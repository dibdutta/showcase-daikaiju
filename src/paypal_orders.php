<?php
ob_start(); // capture any stray output (BOM, whitespace, PHP notices, or die() text)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define("INCLUDE_PATH", "./");
require_once INCLUDE_PATH . "lib/inc.php";

header('Content-Type: application/json');

// ── helpers ───────────────────────────────────────────────────────────────────

function jsonOut(array $payload, int $status = 200): void {
    ob_clean();
    http_response_code($status);
    echo json_encode($payload);
    exit;
}

function paypalAccessToken(): ?string {
    $ch = curl_init(PAYPAL_V2_BASE_URL . '/v1/oauth2/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD        => PAYPAL_CLIENT_ID . ':' . PAYPAL_CLIENT_SECRET,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => 'grant_type=client_credentials',
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    $body = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($body, true);
    return $data['access_token'] ?? null;
}

function paypalRequest(string $method, string $path, ?array $body, string $token): array {
    $ch = curl_init(PAYPAL_V2_BASE_URL . $path);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'PayPal-Request-Id: mpe-' . $method . '-' . uniqid(),
        ],
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    $response = curl_exec($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $httpCode, 'body' => json_decode($response, true)];
}

// ── auth + invoice ownership check ────────────────────────────────────────────

if (!isset($_SESSION['sessUserID'])) {
    jsonOut(['error' => 'Not logged in'], 401);
}

$action     = $_REQUEST['action'] ?? '';
$invoice_id = (int)($_REQUEST['invoice_id'] ?? 0);

if (!$invoice_id) {
    jsonOut(['error' => 'Missing invoice_id'], 400);
}

// Direct query — DBCommon::countData() uses `or die()` which would corrupt the
// JSON response if the query fails, so we bypass it here.
$esc_inv = (int)$invoice_id;
$esc_usr = (int)$_SESSION['sessUserID'];
$rs = mysqli_query(
    $GLOBALS['db_connect'],
    "SELECT COUNT(*) AS cnt FROM " . TBL_INVOICE .
    " WHERE invoice_id = $esc_inv AND fk_user_id = $esc_usr" .
    " AND is_paid = '0' AND is_approved = '1' AND is_cancelled = '0'"
);
if (!$rs || (int)(mysqli_fetch_assoc($rs)['cnt'] ?? 0) === 0) {
    // Diagnostic: fetch actual invoice row to pinpoint failing condition
    $rs_dbg = mysqli_query($GLOBALS['db_connect'],
        "SELECT invoice_id, fk_user_id, is_paid, is_approved, is_cancelled FROM " . TBL_INVOICE .
        " WHERE invoice_id = $esc_inv LIMIT 1"
    );
    $dbg = $rs_dbg ? (mysqli_fetch_assoc($rs_dbg) ?: []) : ['query_failed' => mysqli_error($GLOBALS['db_connect'])];
    jsonOut(['error' => 'Invoice not found or not payable', '_debug' => ['checked_user' => $esc_usr, 'row' => $dbg]], 403);
}

// ── create_order ──────────────────────────────────────────────────────────────

if ($action === 'create_order') {
    $rs2    = mysqli_query($GLOBALS['db_connect'], "SELECT total_amount FROM " . TBL_INVOICE . " WHERE invoice_id = $esc_inv");
    $invRow = $rs2 ? mysqli_fetch_assoc($rs2) : [];
    $base   = (float)($invRow['total_amount'] ?? 0);

    $sessKey  = 'invoice_' . $invoice_id;
    $si       = $_SESSION[$sessKey]['shipping_info'] ?? [];
    $shipping = (float)($si['shipping_charge'] ?? 0);
    $tax      = (float)($si['sale_tax_amount'] ?? 0);
    $total    = number_format($base + $shipping + $tax, 2, '.', '');

    $token = paypalAccessToken();
    if (!$token) {
        jsonOut(['error' => 'PayPal authentication failed — check Client ID and Secret in admin config'], 502);
    }

    $result = paypalRequest('POST', '/v2/checkout/orders', [
        'intent' => 'CAPTURE',
        'purchase_units' => [[
            'reference_id' => 'inv-' . $invoice_id,
            'description'  => 'MyGodzillaShop Invoice #' . $invoice_id,
            'amount'       => ['currency_code' => 'USD', 'value' => $total],
        ]],
        'application_context' => [
            'brand_name'          => 'MyGodzillaShop',
            'landing_page'        => 'NO_PREFERENCE',
            'user_action'         => 'PAY_NOW',
            'return_url'          => SITE_URL . '/my_invoice',
            'cancel_url'          => SITE_URL . '/my_invoice',
        ],
    ], $token);

    if ($result['status'] === 201 && !empty($result['body']['id'])) {
        jsonOut(['id' => $result['body']['id']]);
    }
    jsonOut(['error' => 'Order creation failed', 'details' => $result['body']], 502);
}

// ── capture_order ─────────────────────────────────────────────────────────────

if ($action === 'capture_order') {
    $order_id = trim($_REQUEST['order_id'] ?? '');
    if (!$order_id) {
        jsonOut(['error' => 'Missing order_id'], 400);
    }

    $token = paypalAccessToken();
    if (!$token) {
        jsonOut(['error' => 'PayPal authentication failed'], 502);
    }

    $result = paypalRequest('POST', '/v2/checkout/orders/' . rawurlencode($order_id) . '/capture', null, $token);

    if (!in_array($result['status'], [200, 201]) || ($result['body']['status'] ?? '') !== 'COMPLETED') {
        jsonOut(['error' => 'Capture failed', 'details' => $result['body']], 502);
    }

    // Mirror pay_now() DB updates exactly
    $invoiceObj = new Invoice();
    $row        = $invoiceObj->selectData(TBL_INVOICE, ['*'], ['invoice_id' => $invoice_id]);
    $sessKey    = 'invoice_' . $invoice_id;
    $bi         = $_SESSION[$sessKey]['billing_info'] ?? [];
    $si         = $_SESSION[$sessKey]['shipping_info'] ?? [];

    $billing_address = serialize([
        'billing_firstname'    => $bi['billing_firstname'] ?? '',
        'billing_lastname'     => $bi['billing_lastname'] ?? '',
        'billing_country_id'   => $bi['billing_country_id'] ?? '',
        'billing_country_name' => $bi['billing_country_name'] ?? '',
        'billing_country_code' => $bi['billing_country_code'] ?? '',
        'billing_city'         => $bi['billing_city'] ?? '',
        'billing_state'        => $bi['billing_state'] ?? '',
        'billing_address1'     => $bi['billing_address1'] ?? '',
        'billing_address2'     => $bi['billing_address2'] ?? '',
        'billing_zipcode'      => $bi['billing_zipcode'] ?? '',
    ]);
    $shipping_address = serialize([
        'shipping_firstname'    => $si['shipping_firstname'] ?? '',
        'shipping_lastname'     => $si['shipping_lastname'] ?? '',
        'shipping_country_id'   => $si['shipping_country_id'] ?? '',
        'shipping_country_name' => $si['shipping_country_name'] ?? '',
        'shipping_country_code' => $si['shipping_country_code'] ?? '',
        'shipping_city'         => $si['shipping_city'] ?? '',
        'shipping_state'        => $si['shipping_state'] ?? '',
        'shipping_address1'     => $si['shipping_address1'] ?? '',
        'shipping_address2'     => $si['shipping_address2'] ?? '',
        'shipping_zipcode'      => $si['shipping_zipcode'] ?? '',
    ]);

    $row[0]['additional_charges'] = preg_replace_callback(
        '!s:(\d+):"(.*?)";!s',
        fn($m) => 's:' . strlen($m[2]) . ':"' . $m[2] . '";',
        $row[0]['additional_charges']
    );
    $charges = unserialize($row[0]['additional_charges']) ?: [];

    $ship_label = strtoupper($si['shipping_methods'] ?? '') . ' - ' . ($si['shipping_desc'] ?? '');
    $charges[]  = ['description' => 'Shipping Charge (' . $ship_label . ')', 'amount' => (float)($si['shipping_charge'] ?? 0)];
    if ((float)($si['sale_tax_amount'] ?? 0) > 0) {
        $charges[] = ['description' => 'Sales Tax', 'amount' => (float)$si['sale_tax_amount']];
    }

    $total_amount = (float)($row[0]['total_amount'] ?? 0)
                  + (float)($si['shipping_charge'] ?? 0)
                  + (float)($si['sale_tax_amount'] ?? 0);

    $invoiceObj->updateData(TBL_INVOICE, [
        'billing_address'    => $billing_address,
        'shipping_address'   => $shipping_address,
        'additional_charges' => mysqli_real_escape_string($GLOBALS['db_connect'], serialize($charges)),
        'total_amount'       => $total_amount,
        'is_paid'            => '1',
        'paid_on'            => date('Y-m-d H:i:s'),
    ], ['invoice_id' => $invoice_id], true);

    $linked = $invoiceObj->selectData(TBL_INVOICE_TO_AUCTION, ['fk_auction_id'], ['fk_invoice_id' => $invoice_id]);
    foreach ($linked as $la) {
        $invoiceObj->updateData(TBL_AUCTION, ['auction_payment_is_done' => 1], ['auction_id' => $la['fk_auction_id']], true);
        $aData = $invoiceObj->selectData(TBL_AUCTION, ['auction_is_sold'], ['auction_id' => $la['fk_auction_id']]);
        if (($aData[0]['auction_is_sold'] ?? '') === '3') {
            $invoiceObj->updateData(TBL_AUCTION, ['auction_is_sold' => 2], ['auction_id' => $la['fk_auction_id']], true);
        }
    }

    $invoiceObj->generateSellerInvoice($invoice_id);
    $invoiceObj->mailInvoice($invoice_id, 'invoice');
    unset($_SESSION[$sessKey]);

    jsonOut(['success' => true]);
}

jsonOut(['error' => 'Unknown action'], 400);

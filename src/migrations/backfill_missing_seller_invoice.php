<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

// ── Form ────────────────────────────────────────────────────────────────────
// Fixes the case where an auction was combined (via "combine invoice") into an
// already-paid buyer invoice, then marked paid/shipped through a path that never
// called generateSellerInvoice() — leaving that one auction without a seller invoice.
//
// Approach: call generateSellerInvoice($buyer_invoice_id, $auction_id) — the
// optional second argument scopes the lookup to just this one auction, so other
// auctions already combined into the same buyer invoice are left untouched and
// never get a duplicate seller invoice.
if (!isset($_POST['buyer_invoice_id']) || !isset($_POST['auction_id'])) {
    echo "
    <form method='post' style='font-family:sans-serif;padding:20px;'>
        <h3>Backfill missing seller invoice for one auction on a combined invoice</h3>
        <label>Buyer invoice ID:
            <input type='number' name='buyer_invoice_id' min='1' required style='margin-left:8px;'>
        </label><br><br>
        <label>Auction ID missing its seller invoice:
            <input type='number' name='auction_id' min='1' required style='margin-left:8px;'>
        </label>
        <button type='submit' style='margin-left:12px;'>Run</button>
    </form>";
    exit;
}

$buyer_invoice_id = (int)$_POST['buyer_invoice_id'];
$auction_id       = (int)$_POST['auction_id'];
$results          = [];

// Validate: buyer invoice must exist and be paid
$invoiceRow = mysqli_fetch_assoc(mysqli_query($db,
    "SELECT invoice_id, is_paid, is_buyers_copy FROM tbl_invoice WHERE invoice_id = $buyer_invoice_id"));

if (!$invoiceRow) {
    $results[] = "ERROR: invoice_id=$buyer_invoice_id not found in tbl_invoice.";
} elseif ($invoiceRow['is_buyers_copy'] != '1') {
    $results[] = "ERROR: invoice_id=$buyer_invoice_id is not a buyer copy (is_buyers_copy={$invoiceRow['is_buyers_copy']}).";
} elseif ($invoiceRow['is_paid'] != '1') {
    $results[] = "ERROR: invoice_id=$buyer_invoice_id is not marked paid yet (is_paid={$invoiceRow['is_paid']}). Mark it paid first.";
} else {
    // The target auction must actually be linked to this invoice
    $link = mysqli_fetch_assoc(mysqli_query($db,
        "SELECT fk_auction_id FROM tbl_invoice_to_auction WHERE fk_invoice_id = $buyer_invoice_id AND fk_auction_id = $auction_id"));

    if (!$link) {
        $results[] = "ERROR: auction_id=$auction_id is not linked to invoice_id=$buyer_invoice_id in tbl_invoice_to_auction.";
    } else {
        // Already has a seller invoice?
        $existingSeller = mysqli_fetch_assoc(mysqli_query($db,
            "SELECT i.invoice_id FROM tbl_invoice i
             JOIN tbl_invoice_to_auction ita ON i.invoice_id = ita.fk_invoice_id
             WHERE ita.fk_auction_id = $auction_id AND i.is_buyers_copy = '0'"));

        if ($existingSeller) {
            $results[] = "SKIPPED: auction_id=$auction_id already has seller invoice_id={$existingSeller['invoice_id']}.";
        } else {
            // Scoped to just this auction — other auctions combined into the same
            // buyer invoice (e.g. 198) are untouched and get no duplicate invoice.
            $invoiceObj = new Invoice();
            $invoiceObj->generateSellerInvoice($buyer_invoice_id, $auction_id);

            // Verify the new seller invoice now exists.
            $newSeller = mysqli_fetch_assoc(mysqli_query($db,
                "SELECT i.invoice_id, i.total_amount, i.is_paid FROM tbl_invoice i
                 JOIN tbl_invoice_to_auction ita ON i.invoice_id = ita.fk_invoice_id
                 WHERE ita.fk_auction_id = $auction_id AND i.is_buyers_copy = '0'"));

            if ($newSeller) {
                $results[] = "OK: seller invoice_id={$newSeller['invoice_id']} created for auction_id=$auction_id, net amount \${$newSeller['total_amount']}, is_paid={$newSeller['is_paid']}.";
            } else {
                $results[] = "ERROR: generateSellerInvoice() ran but no seller invoice was found afterward for auction_id=$auction_id. Check tbl_auction/tbl_poster/user_table/country_table joins for this auction.";
            }
        }
    }
}

echo "<pre style='font-family:monospace;padding:20px;'>"
    . implode("\n", $results)
    . "\n\n<a href=''>Run another</a>"
    . "</pre>";

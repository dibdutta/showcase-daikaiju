<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

// ── Form ────────────────────────────────────────────────────────────────────
if (!isset($_POST['auction_id'])) {
    echo "
    <form method='post' style='font-family:sans-serif;padding:20px;'>
        <h3>Create Buyer Invoice for a tbl_auction record</h3>
        <p style='color:#888;font-size:13px;'>
            Looks up the winning bid in tbl_bid_archive for the given auction,
            then generates a buyer invoice (tbl_invoice + tbl_invoice_to_auction + tbl_sold_archive).<br>
            Will refuse to run if an invoice already exists for this auction.
        </p>
        <label>Auction ID (from tbl_auction):
            <input type='number' name='auction_id' min='1' required style='margin-left:8px;width:100px;'>
        </label>
        <button type='submit' style='margin-left:12px;'>Run</button>
    </form>";
    exit;
}

// ── Process ──────────────────────────────────────────────────────────────────
$auction_id = (int)$_POST['auction_id'];
$results    = [];

$results[] = "Auction ID: $auction_id";
$results[] = str_repeat("-", 60);

// 1. Confirm the auction exists and is sold
$rs_auction = mysqli_query($db,
    "SELECT a.auction_id, a.fk_poster_id, a.auction_is_sold, a.max_bid_amount, a.highest_user,
            p.poster_title
     FROM tbl_auction a
     JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
     WHERE a.auction_id = $auction_id
     LIMIT 1");
$auction = $rs_auction ? mysqli_fetch_assoc($rs_auction) : null;

if (!$auction) {
    $results[] = "ERROR: No auction found in tbl_auction for auction_id=$auction_id.";
    output($results); exit;
}
$results[] = "INFO: Auction found — \"{$auction['poster_title']}\" (auction_is_sold={$auction['auction_is_sold']})";

if ($auction['auction_is_sold'] != '1') {
    $results[] = "ERROR: auction_is_sold is not 1. Only process fully-sold auctions.";
    output($results); exit;
}

// 2. Guard: invoice must not already exist
$existing = mysqli_fetch_assoc(mysqli_query($db,
    "SELECT COUNT(*) AS cnt FROM tbl_invoice_to_auction WHERE fk_auction_id = $auction_id"));
if ($existing && $existing['cnt'] > 0) {
    $results[] = "SKIPPED: Invoice already exists for auction_id=$auction_id (tbl_invoice_to_auction has {$existing['cnt']} row(s)). No action taken.";
    output($results); exit;
}

// 3. Find the winning bid in tbl_bid_archive
$rs_bid = mysqli_query($db,
    "SELECT b.bid_id, b.bid_fk_user_id, b.bid_amount, b.bid_is_won
     FROM tbl_bid_archive b
     WHERE b.bid_fk_auction_id = $auction_id
       AND b.bid_is_won = '1'
     ORDER BY b.bid_amount DESC
     LIMIT 1");
$winning_bid = $rs_bid ? mysqli_fetch_assoc($rs_bid) : null;

if (!$winning_bid) {
    // Fallback: find the highest bid for highest_user (proxy-resolved, bid_is_won may be 0)
    $results[] = "WARNING: No bid_is_won=1 row in tbl_bid_archive for auction_id=$auction_id. Trying highest_user + max_bid_amount fallback.";
    if ($auction['highest_user'] && $auction['max_bid_amount']) {
        $rs_bid = mysqli_query($db,
            "SELECT b.bid_id, b.bid_fk_user_id, b.bid_amount, b.bid_is_won
             FROM tbl_bid_archive b
             WHERE b.bid_fk_auction_id = $auction_id
               AND b.bid_fk_user_id = " . (int)$auction['highest_user'] . "
               AND b.bid_amount = " . (float)$auction['max_bid_amount'] . "
             ORDER BY b.bid_id DESC
             LIMIT 1");
        $winning_bid = $rs_bid ? mysqli_fetch_assoc($rs_bid) : null;
    }
    if (!$winning_bid) {
        $results[] = "ERROR: Cannot find a winning bid in tbl_bid_archive for auction_id=$auction_id. Aborting.";
        output($results); exit;
    }
    $results[] = "INFO: Fallback bid found — bid_id={$winning_bid['bid_id']} user_id={$winning_bid['bid_fk_user_id']} amount={$winning_bid['bid_amount']}";
    // Mark it as won so generateInvoice can query it correctly
    mysqli_query($db,
        "UPDATE tbl_bid_archive SET bid_is_won='1' WHERE bid_id=" . (int)$winning_bid['bid_id']);
    $results[] = "INFO: bid_is_won set to 1 on bid_id={$winning_bid['bid_id']} in tbl_bid_archive.";
} else {
    $results[] = "INFO: Winning bid found — bid_id={$winning_bid['bid_id']} user_id={$winning_bid['bid_fk_user_id']} amount={$winning_bid['bid_amount']}";
}

$bid_id     = (int)$winning_bid['bid_id'];
$bid_amount = (float)$winning_bid['bid_amount'];

// 4. Generate invoice — mirrors generateInvoice($bid_id, true, $auction_id) from cron.php
$sql_user = "SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
                    u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
                    u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
                    u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
                    c.country_code AS shipping_country_code,
                    b.bid_fk_auction_id, b.bid_amount AS amount,
                    p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,
                    a.auction_id, a.fk_auction_week_id, pi.poster_thumb
             FROM user_table u
             JOIN tbl_bid_archive b ON b.bid_id = $bid_id AND u.user_id = b.bid_fk_user_id
             JOIN country_table c ON u.country_id = c.country_id
             JOIN tbl_auction a ON a.auction_id = b.bid_fk_auction_id
             JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
             JOIN tbl_poster_images pi ON pi.fk_poster_id = a.fk_poster_id AND pi.is_default = '1'";

$rs_user = mysqli_query($db, $sql_user);
$row     = $rs_user ? mysqli_fetch_assoc($rs_user) : null;

if (!$row) {
    $results[] = "ERROR: Failed to fetch user/poster/auction details for bid_id=$bid_id. MySQL: " . mysqli_error($db);
    output($results); exit;
}

$results[] = "INFO: Buyer — {$row['firstname']} {$row['lastname']} (user_id={$row['user_id']})";
$results[] = "INFO: Amount — \${$row['amount']}";

$winner_name = $row['firstname'] . ' ' . $row['lastname'];

// Serialize billing + shipping addresses
$billing_address = serialize([
    'billing_firstname'    => $row['firstname'],
    'billing_lastname'     => $row['lastname'],
    'billing_country_id'   => $row['country_id'],
    'billing_country_name' => $row['country_name'],
    'billing_country_code' => $row['country_code'],
    'billing_city'         => mysqli_real_escape_string($db, $row['city']),
    'billing_state'        => mysqli_real_escape_string($db, $row['state']),
    'billing_address1'     => mysqli_real_escape_string($db, $row['address1']),
    'billing_address2'     => mysqli_real_escape_string($db, $row['address2']),
    'billing_zipcode'      => $row['zipcode'],
]);
$shipping_address = serialize([
    'shipping_firstname'    => $row['firstname'],
    'shipping_lastname'     => $row['lastname'],
    'shipping_country_id'   => $row['shipping_country_id'],
    'shipping_country_name' => $row['shipping_country_name'],
    'shipping_country_code' => $row['shipping_country_code'],
    'shipping_city'         => mysqli_real_escape_string($db, $row['shipping_city']),
    'shipping_state'        => mysqli_real_escape_string($db, $row['shipping_state']),
    'shipping_address1'     => mysqli_real_escape_string($db, $row['shipping_address1']),
    'shipping_address2'     => mysqli_real_escape_string($db, $row['shipping_address2']),
    'shipping_zipcode'      => $row['shipping_zipcode'],
]);
$auction_details = serialize([
    0 => [
        'auction_id'   => $row['auction_id'],
        'poster_sku'   => $row['poster_sku'],
        'poster_title' => mysqli_real_escape_string($db, $row['poster_title']),
        'amount'       => $row['amount'],
    ],
]);

// Insert tbl_invoice
$sql_invoice = "INSERT INTO tbl_invoice SET
    fk_user_id           = '" . (int)$row['user_id'] . "',
    billing_address      = '" . mysqli_real_escape_string($db, $billing_address) . "',
    shipping_address     = '" . mysqli_real_escape_string($db, $shipping_address) . "',
    total_amount         = '" . (float)$row['amount'] . "',
    auction_details      = '" . mysqli_real_escape_string($db, $auction_details) . "',
    invoice_generated_on = '" . date("Y-m-d H:i:s") . "',
    is_buyers_copy       = '1'";

if (mysqli_query($db, $sql_invoice)) {
    $invoice_id = mysqli_insert_id($db);
    $results[]  = "OK: tbl_invoice inserted — invoice_id=$invoice_id.";

    // Link invoice to auction
    $sql_link = "INSERT INTO tbl_invoice_to_auction SET
        fk_auction_id = '" . (int)$auction_id . "',
        fk_invoice_id = '" . (int)$invoice_id . "',
        amount        = '" . (float)$row['amount'] . "'";
    if (mysqli_query($db, $sql_link)) {
        $results[] = "OK: tbl_invoice_to_auction linked (auction_id=$auction_id → invoice_id=$invoice_id).";
    } else {
        $results[] = "ERROR: tbl_invoice_to_auction insert failed — " . mysqli_error($db);
    }
} else {
    $results[] = "ERROR: tbl_invoice insert failed — " . mysqli_error($db);
}

$results[] = "";
$results[] = "DONE.";

output($results);

function output(array $lines): void {
    echo "<pre style='font-family:monospace;padding:20px;'>"
        . implode("\n", $lines)
        . "\n\n<a href=''>Run another</a>"
        . "</pre>";
}
?>

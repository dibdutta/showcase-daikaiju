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
        <h3>Backfill tbl_bid_archive → tbl_bid for a given auction</h3>
        <p style='color:#888;font-size:13px;'>Copies bids from tbl_bid_archive back into tbl_bid. bid_is_won=1 rows are inserted as bid_is_won=0.</p>
        <label>Auction ID (from tbl_bid_archive):
            <input type='number' name='auction_id' min='1' required style='margin-left:8px;'>
        </label>
        <button type='submit' style='margin-left:12px;'>Run</button>
    </form>";
    exit;
}

// ── Process ──────────────────────────────────────────────────────────────────
$auction_id = (int)$_POST['auction_id'];
$results    = [];

// Validate: bids must exist in tbl_bid_archive for this auction_id
$check = mysqli_query($db,
    "SELECT COUNT(*) AS cnt FROM tbl_bid_archive WHERE bid_fk_auction_id = $auction_id");
$row_check = $check ? mysqli_fetch_assoc($check) : null;

if (!$row_check || $row_check['cnt'] == 0) {
    $results[] = "ERROR: No rows found in tbl_bid_archive for bid_fk_auction_id=$auction_id.";
} else {
    $results[] = "INFO: Found {$row_check['cnt']} bid(s) in tbl_bid_archive for auction_id=$auction_id.";

    // Check if already in tbl_bid
    $exists = mysqli_fetch_assoc(mysqli_query($db,
        "SELECT COUNT(*) AS cnt FROM tbl_bid WHERE bid_fk_auction_id = $auction_id"));
    if ($exists && $exists['cnt'] > 0) {
        $results[] = "SKIPPED: {$exists['cnt']} bid(s) already exist in tbl_bid for auction_id=$auction_id. No action taken.";
    } else {
        // Fetch all bids from archive
        $rs = mysqli_query($db,
            "SELECT bid_fk_user_id, bid_fk_auction_id, bid_amount, is_proxy, bid_is_won,
                    post_date, post_ip, is_snipe
             FROM tbl_bid_archive
             WHERE bid_fk_auction_id = $auction_id
             ORDER BY bid_amount DESC");

        $inserted = 0;
        $errors   = 0;
        while ($row = mysqli_fetch_assoc($rs)) {
            // bid_is_won=1 inserted as 0 — won status belongs in archive only
            $bid_is_won = ($row['bid_is_won'] == '1') ? 0 : (int)$row['bid_is_won'];

            $sql_insert = "INSERT INTO tbl_bid
                (bid_fk_user_id, bid_fk_auction_id, bid_amount, is_proxy, bid_is_won,
                 post_date, post_ip, is_snipe)
                VALUES (
                    " . (int)$row['bid_fk_user_id'] . ",
                    " . (int)$row['bid_fk_auction_id'] . ",
                    " . (float)$row['bid_amount'] . ",
                    '" . mysqli_real_escape_string($db, $row['is_proxy']) . "',
                    $bid_is_won,
                    '" . mysqli_real_escape_string($db, $row['post_date']) . "',
                    '" . mysqli_real_escape_string($db, $row['post_ip']) . "',
                    '" . mysqli_real_escape_string($db, $row['is_snipe']) . "'
                )";

            if (mysqli_query($db, $sql_insert)) {
                $inserted++;
                $results[] = "  OK: user_id={$row['bid_fk_user_id']} amount={$row['bid_amount']}"
                           . ($row['bid_is_won'] == '1' ? " [bid_is_won reset to 0]" : "");
            } else {
                $errors++;
                $results[] = "  ERROR: user_id={$row['bid_fk_user_id']} amount={$row['bid_amount']} — " . mysqli_error($db);
            }
        }

        $results[] = "";
        $results[] = "DONE: $inserted inserted, $errors errors.";
    }
}

echo "<pre style='font-family:monospace;padding:20px;'>"
    . implode("\n", $results)
    . "\n\n<a href=''>Run another</a>"
    . "</pre>";
?>

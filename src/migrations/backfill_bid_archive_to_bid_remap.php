<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

// ── Form ────────────────────────────────────────────────────────────────────
if (!isset($_POST['from_auction_id']) || !isset($_POST['to_auction_id'])) {
    echo "
    <form method='post' style='font-family:sans-serif;padding:20px;'>
        <h3>Backfill tbl_bid_archive → tbl_bid (with auction ID remap)</h3>
        <p style='color:#888;font-size:13px;'>
            Reads bids from tbl_bid_archive for <strong>From Auction ID</strong>,
            inserts them into tbl_bid under <strong>To Auction ID</strong>.<br>
            bid_is_won=1 rows are inserted as bid_is_won=0.<br>
            User IDs 47, 131 and 1706 are always skipped.
        </p>
        <table style='border-spacing:8px 10px;'>
            <tr>
                <td><label>From Auction ID (source in tbl_bid_archive):</label></td>
                <td><input type='number' name='from_auction_id' min='1' required style='width:100px;'></td>
            </tr>
            <tr>
                <td><label>To Auction ID (target inserted into tbl_bid):</label></td>
                <td><input type='number' name='to_auction_id' min='1' required style='width:100px;'></td>
            </tr>
        </table>
        <button type='submit' style='margin-left:8px;'>Run</button>
    </form>";
    exit;
}

// ── Process ──────────────────────────────────────────────────────────────────
$from_auction_id = (int)$_POST['from_auction_id'];
$to_auction_id   = (int)$_POST['to_auction_id'];
$results         = [];

$results[] = "FROM auction_id (archive source) : $from_auction_id";
$results[] = "TO   auction_id (tbl_bid target)  : $to_auction_id";
$results[] = str_repeat("-", 60);

// Validate: source bids must exist in tbl_bid_archive
$check     = mysqli_query($db,
    "SELECT COUNT(*) AS cnt FROM tbl_bid_archive WHERE bid_fk_auction_id = $from_auction_id");
$row_check = $check ? mysqli_fetch_assoc($check) : null;

if (!$row_check || $row_check['cnt'] == 0) {
    $results[] = "ERROR: No rows found in tbl_bid_archive for bid_fk_auction_id=$from_auction_id.";
} else {
    $results[] = "INFO: Found {$row_check['cnt']} bid(s) in tbl_bid_archive for auction_id=$from_auction_id.";

    // Warn if target already has bids in tbl_bid — don't block, just inform
    $exists = mysqli_fetch_assoc(mysqli_query($db,
        "SELECT COUNT(*) AS cnt FROM tbl_bid WHERE bid_fk_auction_id = $to_auction_id"));
    if ($exists && $exists['cnt'] > 0) {
        $results[] = "WARNING: {$exists['cnt']} bid(s) already exist in tbl_bid for auction_id=$to_auction_id. Proceeding anyway — check for duplicates after.";
    }

    // Fetch source bids, excluding internal user IDs
    $rs = mysqli_query($db,
        "SELECT bid_fk_user_id, bid_amount, is_proxy, bid_is_won,
                post_date, post_ip, is_snipe
         FROM tbl_bid_archive
         WHERE bid_fk_auction_id = $from_auction_id
         AND bid_fk_user_id NOT IN (47, 131, 1706)
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
                $to_auction_id,
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
    $results[] = "(Skipped user IDs 47, 131, 1706 from source bids.)";
}

echo "<pre style='font-family:monospace;padding:20px;'>"
    . implode("\n", $results)
    . "\n\n<a href=''>Run another</a>"
    . "</pre>";
?>

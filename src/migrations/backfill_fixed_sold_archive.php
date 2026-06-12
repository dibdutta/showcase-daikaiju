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
        <h3>Backfill fixed-price auction to tbl_sold_archive</h3>
        <label>Auction ID (fixed price):
            <input type='number' name='auction_id' min='1' required style='margin-left:8px;'>
        </label>
        <button type='submit' style='margin-left:12px;'>Run</button>
    </form>";
    exit;
}

// ── Process ──────────────────────────────────────────────────────────────────
$auction_id = (int)$_POST['auction_id'];
$results    = [];

// Validate: must be a sold fixed-price auction
$check = mysqli_query($db,
    "SELECT auction_id, fk_auction_type_id, auction_is_sold
     FROM tbl_auction
     WHERE auction_id = $auction_id");
$row_check = $check ? mysqli_fetch_assoc($check) : null;

if (!$row_check) {
    $results[] = "ERROR: auction_id=$auction_id not found in tbl_auction.";
} elseif ($row_check['fk_auction_type_id'] != 1) {
    $results[] = "ERROR: auction_id=$auction_id is not a fixed-price item (fk_auction_type_id={$row_check['fk_auction_type_id']}).";
} elseif (!in_array($row_check['auction_is_sold'], ['1', '2', '3'])) {
    $results[] = "ERROR: auction_id=$auction_id is not sold (auction_is_sold={$row_check['auction_is_sold']}).";
} else {
    // Check if already archived
    $exists = mysqli_fetch_assoc(mysqli_query($db,
        "SELECT auction_id FROM tbl_sold_archive WHERE auction_id = $auction_id"));
    if ($exists) {
        $results[] = "SKIPPED: auction_id=$auction_id already exists in tbl_sold_archive.";
    } else {
        // Fetch full data for the archive row
        $sql = "
            SELECT
                a.auction_id,
                a.fk_poster_id                                          AS poster_id,
                a.auction_asked_price,
                pi.poster_thumb,
                pi.is_cloud,
                COALESCE(a.auction_asked_price, i.total_amount)         AS soldamnt,
                COALESCE(i.invoice_generated_on, NOW())                 AS invoice_generated_on,
                COALESCE(CONCAT(u.firstname, ' ', u.lastname), '')      AS winnerName
            FROM tbl_auction a
            LEFT JOIN tbl_poster_images pi
                   ON pi.fk_poster_id = a.fk_poster_id AND pi.is_default = '1'
            LEFT JOIN tbl_invoice_to_auction tia ON tia.fk_auction_id = a.auction_id
            LEFT JOIN tbl_invoice i
                   ON i.invoice_id = tia.fk_invoice_id AND i.is_buyers_copy = '1'
            LEFT JOIN user_table u ON u.user_id = i.fk_user_id
            WHERE a.auction_id = $auction_id
            GROUP BY a.auction_id
        ";

        $rs  = mysqli_query($db, $sql);
        $row = $rs ? mysqli_fetch_assoc($rs) : null;

        if (!$row) {
            $results[] = "ERROR: could not fetch details for auction_id=$auction_id — " . mysqli_error($db);
        } else {
            $insert = "INSERT INTO tbl_sold_archive
                           (auction_id, invoice_generated_on, fk_auction_type_id,
                            poster_id, winnerName, soldamnt, is_cloud, auction_week_id, poster_thumb)
                       VALUES (
                           $auction_id,
                           '" . mysqli_real_escape_string($db, $row['invoice_generated_on']) . "',
                           1,
                           " . (int)$row['poster_id'] . ",
                           '" . mysqli_real_escape_string($db, $row['winnerName']) . "',
                           " . (float)$row['soldamnt'] . ",
                           " . (int)($row['is_cloud'] ?? 1) . ",
                           0,
                           '" . mysqli_real_escape_string($db, $row['poster_thumb'] ?? '') . "'
                       )";

            if (mysqli_query($db, $insert)) {
                $results[] = "OK: auction_id=$auction_id inserted into tbl_sold_archive.";
                $results[] = "    winner  : \"{$row['winnerName']}\"";
                $results[] = "    soldamnt: \${$row['soldamnt']}";
                $results[] = "    date    : {$row['invoice_generated_on']}";
            } else {
                $results[] = "ERROR inserting auction_id=$auction_id — " . mysqli_error($db);
            }
        }
    }
}

echo "<pre style='font-family:monospace;padding:20px;'>"
    . implode("\n", $results)
    . "\n\n<a href=''>Run another</a>"
    . "</pre>";
?>

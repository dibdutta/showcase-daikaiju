<?php
// Migration: add lookup indexes to the bid and sold archives.
// tbl_bid_archive had only its primary key, so every "bids for this auction" or "bids by
// this user" lookup (bid history, My Bids, the auction close) scanned the whole table;
// tbl_sold_archive's primary key is (id, auction_id), so lookups by auction_id scanned too.
// Both tables grow every auction. Indexes are built online (no table lock). Safe to re-run.
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

$indexes = [
    ['tbl_bid_archive',  'idx_bid_archive_auction', 'bid_fk_auction_id'],
    ['tbl_bid_archive',  'idx_bid_archive_user',    'bid_fk_user_id'],
    ['tbl_sold_archive', 'idx_sold_archive_auction', 'auction_id'],
];

foreach ($indexes as [$table, $index, $column]) {
    $check = mysqli_query($db,
        "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '$table' AND INDEX_NAME = '$index'"
    );
    $row = mysqli_fetch_assoc($check);
    if ($row['cnt'] == 0) {
        if (mysqli_query($db, "ALTER TABLE `$table` ADD INDEX `$index` (`$column`), ALGORITHM=INPLACE, LOCK=NONE")) {
            echo "Added index: $table.$index ($column)<br>";
        } else {
            echo "Error adding $table.$index: " . mysqli_error($db) . "<br>";
        }
    } else {
        echo "Index already exists: $table.$index<br>";
    }
}

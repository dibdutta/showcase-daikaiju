<?php
// Migration: add config_table.live_auction_highlight — admin on/off switch for the
// homepage live auction hero and the LIVE badge in the header menu (1 = on).
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

$check = mysqli_query($db,
    "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'config_table' AND COLUMN_NAME = 'live_auction_highlight'"
);
$row = mysqli_fetch_assoc($check);
if ($row['cnt'] == 0) {
    if (mysqli_query($db, "ALTER TABLE config_table ADD COLUMN live_auction_highlight ENUM('0','1') NOT NULL DEFAULT '1'")) {
        echo "Added column: live_auction_highlight<br>";
    } else {
        echo "Error adding live_auction_highlight: " . mysqli_error($db) . "<br>";
    }
} else {
    echo "Column already exists: live_auction_highlight<br>";
}

<?php
// Migration: add auction link columns to tbl_auction_calender and ensure seed row exists
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

$db = $GLOBALS['db_connect'];

// Add auction_N_link columns if missing
$link_cols = [
    'auction_1_link' => "ALTER TABLE tbl_auction_calender ADD COLUMN auction_1_link VARCHAR(500) NOT NULL DEFAULT ''",
    'auction_2_link' => "ALTER TABLE tbl_auction_calender ADD COLUMN auction_2_link VARCHAR(500) NOT NULL DEFAULT ''",
    'auction_3_link' => "ALTER TABLE tbl_auction_calender ADD COLUMN auction_3_link VARCHAR(500) NOT NULL DEFAULT ''",
    'auction_4_link' => "ALTER TABLE tbl_auction_calender ADD COLUMN auction_4_link VARCHAR(500) NOT NULL DEFAULT ''",
    'auction_5_link' => "ALTER TABLE tbl_auction_calender ADD COLUMN auction_5_link VARCHAR(500) NOT NULL DEFAULT ''",
];

foreach ($link_cols as $col => $sql) {
    $check = mysqli_query($db,
        "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_auction_calender' AND COLUMN_NAME = '$col'"
    );
    $row = mysqli_fetch_assoc($check);
    if ($row['cnt'] == 0) {
        if (mysqli_query($db, $sql)) {
            echo "Added column: $col<br>";
        } else {
            echo "Error adding $col: " . mysqli_error($db) . "<br>";
        }
    } else {
        echo "Column already exists: $col<br>";
    }
}

// Ensure the seed row id=1 exists (safe to run multiple times)
$exists = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS cnt FROM tbl_auction_calender WHERE id=1"));
if ($exists['cnt'] == 0) {
    if (mysqli_query($db, "INSERT INTO tbl_auction_calender (id) VALUES (1)")) {
        echo "Seed row id=1 inserted.<br>";
    } else {
        echo "Error inserting seed row: " . mysqli_error($db) . "<br>";
    }
} else {
    echo "Seed row id=1 already exists.<br>";
}

echo "Migration complete.";

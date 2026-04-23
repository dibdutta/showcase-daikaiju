<?php
// Migration: add paypal_client_id and paypal_client_secret to tbl_config
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

$cols = [
    "paypal_client_id"     => "ALTER TABLE tbl_config ADD COLUMN paypal_client_id VARCHAR(255) NOT NULL DEFAULT ''",
    "paypal_client_secret" => "ALTER TABLE tbl_config ADD COLUMN paypal_client_secret VARCHAR(255) NOT NULL DEFAULT ''",
];

foreach ($cols as $col => $sql) {
    $check = mysqli_query($GLOBALS['db_connect'],
        "SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_config' AND COLUMN_NAME = '$col'"
    );
    $row = mysqli_fetch_assoc($check);
    if ($row['cnt'] == 0) {
        if (mysqli_query($GLOBALS['db_connect'], $sql)) {
            echo "Added column: $col<br>";
        } else {
            echo "Error adding $col: " . mysqli_error($GLOBALS['db_connect']) . "<br>";
        }
    } else {
        echo "Column already exists: $col<br>";
    }
}
echo "Migration complete.";

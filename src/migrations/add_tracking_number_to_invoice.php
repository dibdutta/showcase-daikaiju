<?php
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

$sql = "ALTER TABLE tbl_invoice ADD COLUMN tracking_number VARCHAR(100) NULL DEFAULT NULL AFTER shipped_date";

if (mysqli_query($GLOBALS['db_connect'], $sql)) {
    echo "Migration successful: tracking_number column added to tbl_invoice.\n";
} else {
    $err = mysqli_error($GLOBALS['db_connect']);
    if (strpos($err, 'Duplicate column') !== false) {
        echo "Column already exists — skipping.\n";
    } else {
        echo "Error: " . $err . "\n";
    }
}

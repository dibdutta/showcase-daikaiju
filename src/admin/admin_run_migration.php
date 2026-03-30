<?php
/**
 * One-time migration: creates subcategory tables.
 * Run once from the browser, then delete or restrict access.
 */
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];

$sqls = [
    "CREATE TABLE IF NOT EXISTS tbl_subcategory (
        subcat_id    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fk_cat_id    INT UNSIGNED NOT NULL,
        subcat_value VARCHAR(255) NOT NULL,
        is_active    TINYINT(1) NOT NULL DEFAULT 1,
        post_date    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        up_date      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_cat_subcat (fk_cat_id, subcat_value)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS tbl_poster_to_subcategory (
        ptsc_id      INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fk_poster_id INT UNSIGNED NOT NULL,
        fk_subcat_id INT UNSIGNED NOT NULL,
        UNIQUE KEY uq_poster_subcat (fk_poster_id, fk_subcat_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS tbl_poster_to_subcategory_live (
        ptscl_id     INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fk_poster_id INT UNSIGNED NOT NULL,
        fk_subcat_id INT UNSIGNED NOT NULL,
        UNIQUE KEY uq_poster_subcat_live (fk_poster_id, fk_subcat_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
];

$results = [];
foreach ($sqls as $sql) {
    if (mysqli_query($db, $sql)) {
        $results[] = "OK: " . substr($sql, 0, 60) . "...";
    } else {
        $results[] = "ERROR: " . mysqli_error($db);
    }
}

echo "<pre>" . implode("\n", $results) . "\n\nMigration complete. Delete this file.</pre>";
?>

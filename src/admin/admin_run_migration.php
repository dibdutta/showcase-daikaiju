<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die("Admin login required.");
}

$db = $GLOBALS['db_connect'];
$results = [];

function runSql($db, $sql, &$results) {
    if (mysqli_query($db, $sql)) {
        $results[] = "OK: " . substr(trim($sql), 0, 80) . "...";
    } else {
        $results[] = "ERROR: " . mysqli_error($db) . " | SQL: " . substr(trim($sql), 0, 80);
    }
}

// 1. Create tbl_shop_category
runSql($db, "CREATE TABLE IF NOT EXISTS tbl_shop_category (
    shop_cat_id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    shop_cat_name VARCHAR(255) NOT NULL,
    sort_order    INT NOT NULL DEFAULT 0,
    is_active     TINYINT(1) NOT NULL DEFAULT 1,
    post_date     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    up_date       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_shop_cat_name (shop_cat_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

// 2. Create tbl_subcategory with fk_shop_cat_id
runSql($db, "CREATE TABLE IF NOT EXISTS tbl_subcategory (
    subcat_id       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_shop_cat_id  INT UNSIGNED NOT NULL,
    subcat_value    VARCHAR(255) NOT NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    post_date       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    up_date         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_shopcat_subcat (fk_shop_cat_id, subcat_value)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

// 3. If tbl_subcategory already existed with fk_cat_id, add fk_shop_cat_id column if missing
$colCheck = mysqli_query($db, "SHOW COLUMNS FROM tbl_subcategory LIKE 'fk_shop_cat_id'");
if (mysqli_num_rows($colCheck) == 0) {
    runSql($db, "ALTER TABLE tbl_subcategory ADD COLUMN fk_shop_cat_id INT UNSIGNED NOT NULL DEFAULT 0 AFTER subcat_id", $results);
}
// Drop old fk_cat_id if it exists
$colCheck2 = mysqli_query($db, "SHOW COLUMNS FROM tbl_subcategory LIKE 'fk_cat_id'");
if (mysqli_num_rows($colCheck2) > 0) {
    runSql($db, "ALTER TABLE tbl_subcategory DROP COLUMN fk_cat_id", $results);
}

// 4. Poster-to-subcategory mapping tables
runSql($db, "CREATE TABLE IF NOT EXISTS tbl_poster_to_subcategory (
    ptsc_id      INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_poster_id INT UNSIGNED NOT NULL,
    fk_subcat_id INT UNSIGNED NOT NULL,
    UNIQUE KEY uq_poster_subcat (fk_poster_id, fk_subcat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

runSql($db, "CREATE TABLE IF NOT EXISTS tbl_poster_to_subcategory_live (
    ptscl_id     INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_poster_id INT UNSIGNED NOT NULL,
    fk_subcat_id INT UNSIGNED NOT NULL,
    UNIQUE KEY uq_poster_subcat_live (fk_poster_id, fk_subcat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

// 5. Poster-to-shop-category mapping tables
runSql($db, "CREATE TABLE IF NOT EXISTS tbl_poster_to_shop_category (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_poster_id  INT UNSIGNED NOT NULL,
    fk_shop_cat_id INT UNSIGNED NOT NULL,
    UNIQUE KEY uq_poster_shopcat (fk_poster_id, fk_shop_cat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

runSql($db, "CREATE TABLE IF NOT EXISTS tbl_poster_to_shop_category_live (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_poster_id  INT UNSIGNED NOT NULL,
    fk_shop_cat_id INT UNSIGNED NOT NULL,
    UNIQUE KEY uq_poster_shopcat_live (fk_poster_id, fk_shop_cat_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $results);

echo "<pre>" . implode("\n", $results) . "\n\nMigration complete. Delete this file.</pre>";
?>

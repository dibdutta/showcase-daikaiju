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

// 6. Add PayPal REST v2 credentials to config_table
$colCheck6a = mysqli_query($db, "SHOW COLUMNS FROM config_table LIKE 'paypal_client_id'");
if (mysqli_num_rows($colCheck6a) == 0) {
    runSql($db, "ALTER TABLE config_table ADD COLUMN paypal_client_id VARCHAR(255) NOT NULL DEFAULT ''", $results);
} else {
    $results[] = "OK: paypal_client_id already exists in config_table — skipping.";
}
$colCheck6b = mysqli_query($db, "SHOW COLUMNS FROM config_table LIKE 'paypal_client_secret'");
if (mysqli_num_rows($colCheck6b) == 0) {
    runSql($db, "ALTER TABLE config_table ADD COLUMN paypal_client_secret VARCHAR(255) NOT NULL DEFAULT ''", $results);
} else {
    $results[] = "OK: paypal_client_secret already exists in config_table — skipping.";
}

// 8. Add tracking_number to tbl_invoice
$colCheck3 = mysqli_query($db, "SHOW COLUMNS FROM tbl_invoice LIKE 'tracking_number'");
if (mysqli_num_rows($colCheck3) == 0) {
    runSql($db, "ALTER TABLE tbl_invoice ADD COLUMN tracking_number VARCHAR(100) NULL DEFAULT NULL AFTER shipped_date", $results);
} else {
    $results[] = "OK: tracking_number column already exists in tbl_invoice — skipping.";
}

// 9. Fix duplicate is_default=1 rows in tbl_poster_images.
// For each poster that has more than one is_default=1 image, keep only the one
// with the highest poster_image_id (most recently added) and set the rest to '0'.
$fixSql = "UPDATE tbl_poster_images pi1
           INNER JOIN (
               SELECT fk_poster_id, MAX(poster_image_id) AS keep_id
               FROM tbl_poster_images
               WHERE is_default = '1'
               GROUP BY fk_poster_id
               HAVING COUNT(*) > 1
           ) AS dupes ON pi1.fk_poster_id = dupes.fk_poster_id
                      AND pi1.poster_image_id <> dupes.keep_id
           SET pi1.is_default = '0'
           WHERE pi1.is_default = '1'";
if (mysqli_query($db, $fixSql)) {
    $affected = mysqli_affected_rows($db);
    $results[] = "OK: fixed duplicate is_default rows — $affected row(s) cleared.";
} else {
    $results[] = "ERROR fixing duplicate is_default: " . mysqli_error($db);
}

// 10. Remove phantom tbl_poster_images rows caused by dynamicPosterUpload('weekly') bug.
// The bug always inserted into tbl_poster_images AND tbl_poster_images_live when
// type='weekly'. For a live-auction poster the correct records are in _live; the
// matching rows in tbl_poster_images are spurious duplicates.
// Safe match key: same fk_poster_id + original_filename in both tables.
// Rows legitimately in tbl_poster_images (fixed-price uploads) will NOT have a
// matching original_filename in tbl_poster_images_live, so they are untouched.

// Dry-run: count affected rows first.
$countRs = mysqli_query($db,
    "SELECT COUNT(*) AS cnt
     FROM tbl_poster_images pi
     INNER JOIN tbl_poster_images_live pil
         ON pi.fk_poster_id = pil.fk_poster_id
        AND pi.original_filename = pil.original_filename");
$countRow = $countRs ? mysqli_fetch_assoc($countRs) : null;
$dupCount = $countRow ? (int)$countRow['cnt'] : 0;

if ($dupCount === 0) {
    $results[] = "OK: no phantom tbl_poster_images rows found — nothing to clean up.";
} else {
    $cleanSql = "DELETE pi FROM tbl_poster_images pi
                 INNER JOIN tbl_poster_images_live pil
                     ON pi.fk_poster_id = pil.fk_poster_id
                    AND pi.original_filename = pil.original_filename";
    if (mysqli_query($db, $cleanSql)) {
        $deleted = mysqli_affected_rows($db);
        $results[] = "OK: removed $deleted phantom row(s) from tbl_poster_images (were duplicated in tbl_poster_images_live).";
    } else {
        $results[] = "ERROR cleaning phantom poster images: " . mysqli_error($db);
    }
}

echo "<pre>" . implode("\n", $results) . "\n\nMigration complete. Delete this file.</pre>";
?>

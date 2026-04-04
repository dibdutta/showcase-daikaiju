<?php
/**
 * Migration: Remove Size (fk_cat_type_id=1) and Genre (fk_cat_type_id=2)
 *
 * Deletes all poster-to-category associations for Size and Genre from both
 * the live and non-live tables, then removes the category rows themselves
 * and their category type entries.
 *
 * Run once from the command line:
 *   php migrations/remove_size_genre.php
 *
 * Or place in the web root temporarily and visit it while logged in as admin.
 */

define('INCLUDE_PATH', __DIR__ . '/../');
require_once INCLUDE_PATH . 'lib/dbconfig.php';

$db = mysqli_connect(
    getenv('DB_SERVER') ?: 'mysql',
    getenv('DB_USER')   ?: 'root',
    getenv('DB_PASSWORD') ?: 'root',
    getenv('DB_NAME')   ?: 'mpe'
);

if (!$db) {
    die('DB connection failed: ' . mysqli_connect_error() . PHP_EOL);
}

$steps = [
    'Delete Size/Genre rows from tbl_poster_to_category' =>
        "DELETE FROM tbl_poster_to_category
         WHERE fk_cat_id IN (
             SELECT cat_id FROM tbl_category WHERE fk_cat_type_id IN (1, 2)
         )",

    'Delete Size/Genre rows from tbl_poster_to_category_live' =>
        "DELETE FROM tbl_poster_to_category_live
         WHERE fk_cat_id IN (
             SELECT cat_id FROM tbl_category WHERE fk_cat_type_id IN (1, 2)
         )",

    'Delete Size and Genre entries from tbl_category' =>
        "DELETE FROM tbl_category WHERE fk_cat_type_id IN (1, 2)",

    'Delete Size and Genre entries from tbl_category_type' =>
        "DELETE FROM tbl_category_type WHERE cat_type_id IN (1, 2)",
];

foreach ($steps as $label => $sql) {
    if (mysqli_query($db, $sql)) {
        $affected = mysqli_affected_rows($db);
        echo "[OK] {$label} — {$affected} row(s) affected" . PHP_EOL;
    } else {
        echo "[ERR] {$label} — " . mysqli_error($db) . PHP_EOL;
    }
}

mysqli_close($db);
echo PHP_EOL . "Migration complete." . PHP_EOL;

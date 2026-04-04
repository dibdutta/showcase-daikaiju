<?php
/**
 * Migration: Create Blog / Articles tables
 *
 * Run once:
 *   php migrations/create_blog_tables.php
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

    'Create tbl_blog' => "
        CREATE TABLE IF NOT EXISTS tbl_blog (
            blog_id       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title         VARCHAR(255) NOT NULL,
            slug          VARCHAR(255) NOT NULL,
            content       MEDIUMTEXT,
            featured_image VARCHAR(255) DEFAULT '',
            status        TINYINT(1) NOT NULL DEFAULT 1,
            post_date     DATETIME,
            update_date   DATETIME,
            post_ip       VARCHAR(45),
            UNIQUE KEY uq_slug (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ",

    'Create tbl_blog_comments' => "
        CREATE TABLE IF NOT EXISTS tbl_blog_comments (
            comment_id      INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            blog_id         INT UNSIGNED NOT NULL,
            commenter_name  VARCHAR(100) NOT NULL,
            commenter_email VARCHAR(150) NOT NULL,
            comment_text    TEXT NOT NULL,
            status          TINYINT(1) NOT NULL DEFAULT 0,
            post_date       DATETIME,
            post_ip         VARCHAR(45),
            KEY idx_blog_id (blog_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ",
];

foreach ($steps as $label => $sql) {
    if (mysqli_query($db, $sql)) {
        echo "[OK] {$label}" . PHP_EOL;
    } else {
        echo "[ERR] {$label} — " . mysqli_error($db) . PHP_EOL;
    }
}

mysqli_close($db);
echo PHP_EOL . "Migration complete." . PHP_EOL;

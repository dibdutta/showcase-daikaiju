<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

$db = $GLOBALS['db_connect'];

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

$results = [];

if (isset($_POST['run'])) {
    foreach ($steps as $label => $sql) {
        if (mysqli_query($db, $sql)) {
            $results[] = ['ok' => true, 'label' => $label];
        } else {
            $results[] = ['ok' => false, 'label' => $label, 'error' => mysqli_error($db)];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Migration: Create Blog Tables</title>
<style>
body { font-family: Arial, sans-serif; padding: 30px; background: #f5f5f5; }
h2 { color: #bd1a21; }
.box { background: #fff; border: 1px solid #ccc; padding: 20px; max-width: 700px; border-radius: 4px; }
.ok  { color: green; margin: 6px 0; }
.err { color: red;   margin: 6px 0; }
.warn { background: #fff3cd; border: 1px solid #ffc107; padding: 12px; margin-bottom: 16px; border-radius: 4px; }
button { background: #bd1a21; color: #fff; border: none; padding: 10px 24px; font-size: 14px; cursor: pointer; border-radius: 4px; }
.done { background: #d4edda; border: 1px solid #28a745; padding: 12px; border-radius: 4px; margin-top: 12px; }
</style>
</head>
<body>
<div class="box">
<h2>Migration: Create Blog Tables</h2>

<?php if (empty($results)): ?>
<div class="warn">This will create <strong>tbl_blog</strong> and <strong>tbl_blog_comments</strong> tables. Safe to run multiple times (uses CREATE TABLE IF NOT EXISTS).</div>
<form method="post">
    <button type="submit" name="run" value="1">Run Migration</button>
</form>
<?php else: ?>
<div class="done"><strong>Migration complete.</strong></div>
<?php foreach ($results as $r): ?>
    <?php if ($r['ok']): ?>
        <p class="ok">&#10003; <?php echo htmlspecialchars($r['label']); ?></p>
    <?php else: ?>
        <p class="err">&#10007; <?php echo htmlspecialchars($r['label']); ?> &mdash; <?php echo htmlspecialchars($r['error']); ?></p>
    <?php endif; ?>
<?php endforeach; ?>
<p><a href="admin_blog_manager.php">&rarr; Go to Blog Manager</a></p>
<?php endif; ?>

<p style="margin-top:20px;"><a href="admin_main.php">&larr; Back to Admin</a></p>
</div>
</body>
</html>

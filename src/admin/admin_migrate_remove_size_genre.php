<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
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

$results = [];

if (isset($_POST['run'])) {
    foreach ($steps as $label => $sql) {
        if (mysqli_query($GLOBALS['db_connect'], $sql)) {
            $affected = mysqli_affected_rows($GLOBALS['db_connect']);
            $results[] = ['ok' => true, 'label' => $label, 'rows' => $affected];
        } else {
            $results[] = ['ok' => false, 'label' => $label, 'error' => mysqli_error($GLOBALS['db_connect'])];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Migration: Remove Size &amp; Genre</title>
<style>
body { font-family: Arial, sans-serif; padding: 30px; background: #f5f5f5; }
h2 { color: #bd1a21; }
.box { background: #fff; border: 1px solid #ccc; padding: 20px; max-width: 700px; border-radius: 4px; }
.ok  { color: green; margin: 6px 0; }
.err { color: red;   margin: 6px 0; }
.warn { background: #fff3cd; border: 1px solid #ffc107; padding: 12px; margin-bottom: 16px; border-radius: 4px; }
button { background: #bd1a21; color: #fff; border: none; padding: 10px 24px; font-size: 14px; cursor: pointer; border-radius: 4px; }
button:hover { background: #9e1519; }
.done { background: #d4edda; border: 1px solid #28a745; padding: 12px; border-radius: 4px; margin-top: 12px; }
</style>
</head>
<body>
<div class="box">
<h2>Migration: Remove Size &amp; Genre</h2>

<?php if (empty($results)): ?>
<div class="warn">
    <strong>Warning:</strong> This will permanently delete all Size and Genre category data from the database. This cannot be undone. Run only once.
</div>
<p>Steps that will be executed:</p>
<ol>
<?php foreach ($steps as $label => $sql): ?>
    <li><?php echo htmlspecialchars($label); ?></li>
<?php endforeach; ?>
</ol>
<form method="post">
    <button type="submit" name="run" value="1">Run Migration</button>
</form>

<?php else: ?>
<div class="done"><strong>Migration complete.</strong></div>
<?php foreach ($results as $r): ?>
    <?php if ($r['ok']): ?>
        <p class="ok">&#10003; <?php echo htmlspecialchars($r['label']); ?> &mdash; <?php echo $r['rows']; ?> row(s) affected</p>
    <?php else: ?>
        <p class="err">&#10007; <?php echo htmlspecialchars($r['label']); ?> &mdash; <?php echo htmlspecialchars($r['error']); ?></p>
    <?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>

<p style="margin-top:20px;"><a href="admin_main.php">&larr; Back to Admin</a></p>
</div>
</body>
</html>

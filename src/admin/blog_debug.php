<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "Step 1: Starting\n";

define('INCLUDE_PATH', '../');
echo "Step 2: INCLUDE_PATH defined\n";

require_once INCLUDE_PATH . 'lib/inc.php';
echo "Step 3: inc.php loaded\n";

ini_set('display_errors', 1); // re-set after configures.php overrides it

session_start();
if (!isset($_SESSION['adminLoginID'])) {
    die("Not logged in as admin.");
}
echo "Step 4: Admin session OK\n";

require_once INCLUDE_PATH . 'classes/Blog.php';
echo "Step 5: Blog.php loaded\n";

$blog = new Blog();
echo "Step 6: Blog object created\n";

$total = $blog->totalBlogs();
echo "Step 7: totalBlogs() = $total\n";

$pending = $blog->totalComments(null, 0);
echo "Step 8: totalComments(pending) = $pending\n";

echo "Step 9: All OK — no fatal errors\n";
echo "</pre>";
?>

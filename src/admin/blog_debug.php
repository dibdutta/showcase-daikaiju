<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "Step 1: Starting\n";

define('INCLUDE_PATH', '../');
echo "Step 2: INCLUDE_PATH defined\n";

require_once INCLUDE_PATH . 'lib/inc.php';
ini_set('display_errors', 1); // re-assert after configures.php overrides it
error_reporting(E_ALL);
echo "Step 3: inc.php loaded\n";

// DO NOT call session_start() again — inc.php already starts it
echo "Step 4: Session check — adminLoginID = " . (isset($_SESSION['adminLoginID']) ? $_SESSION['adminLoginID'] : 'NOT SET') . "\n";

echo "Step 5: Loading FCKeditor\n";
require_once INCLUDE_PATH . 'FCKeditor/fckeditor.php';
echo "Step 6: FCKeditor loaded\n";

echo "Step 7: Loading Blog class\n";
require_once INCLUDE_PATH . 'classes/Blog.php';
echo "Step 8: Blog class loaded\n";

echo "Step 9: Creating Blog object\n";
$blog = new Blog();
echo "Step 10: Blog object created\n";

echo "Step 11: Calling totalBlogs()\n";
$total = $blog->totalBlogs();
echo "Step 12: totalBlogs() = $total\n";

echo "Step 13: Calling totalComments()\n";
$pending = $blog->totalComments(null, 0);
echo "Step 14: totalComments(pending) = $pending\n";

echo "\nAll OK — no fatal errors.\n";
echo "</pre>";
?>

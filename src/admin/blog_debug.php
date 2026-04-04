<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";

define('PAGE_HEADER_TEXT', 'Blog / Articles Manager');
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Simulate being logged in so we can trace the full list_blogs() path
$_SESSION['adminLoginID'] = $_SESSION['adminLoginID'] ?: 1;
echo "Session adminLoginID = " . $_SESSION['adminLoginID'] . "\n";

echo "Step A: Loading adminCommon\n";
require_once INCLUDE_PATH . 'lib/adminCommon.php';
echo "Step B: adminCommon loaded, smarty = " . get_class($smarty) . "\n";

echo "Step C: Loading Blog class\n";
require_once INCLUDE_PATH . 'classes/Blog.php';
echo "Step D: Blog class loaded\n";

echo "Step E: Creating Blog + fetching\n";
$blog  = new Blog();
$total = $blog->totalBlogs();
$rows  = $total > 0 ? $blog->fetchBlogs() : [];
$pendingComments = $blog->totalComments(null, 0);
echo "Step F: total=$total, pendingComments=$pendingComments\n";

echo "Step G: Assigning to Smarty\n";
$smarty->assign('blogs', $rows);
$smarty->assign('total', $total);
$smarty->assign('pendingComments', $pendingComments);
$smarty->assign('encoded_string', easy_crypt($_SERVER['REQUEST_URI']));
echo "Step H: Assignments done\n";

echo "Step I: Displaying template admin_blog_list.tpl\n";
echo "</pre>";
$smarty->display('admin_blog_list.tpl');
echo "<pre>Step J: Template rendered OK\n</pre>";

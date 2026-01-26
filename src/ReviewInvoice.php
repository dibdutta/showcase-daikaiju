<?php 
ob_start(); 
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."lib/common.php";
unset($_SESSION);
session_unset();
session_destroy();
session_start();

var_dump(session_id());exit;
ob_start();

echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	die();


?>
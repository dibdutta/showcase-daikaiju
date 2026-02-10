<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
content();       ////////////   For page content 

dispmiddle();

ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->display("faq.tpl");
}
?>
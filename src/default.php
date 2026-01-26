<?php
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
      ////////////   For page content 

dispmiddle();

ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/common.php";
	//echo date('Y-m-d H:i:s');	
	$smarty->display("default.tpl");
}

?>
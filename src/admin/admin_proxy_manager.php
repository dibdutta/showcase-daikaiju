<?php

/**************************************************/
ob_start();

define ("PAGE_HEADER_TEXT", "Admin Proxy Bid Section");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}


//if($_REQUEST['mode']=="change_password"){
//	change_password();
//}
//elseif($_POST['mode'] == "save_password"){
//	$chk = check_admin_password();
//	if($chk == true){
//		update_password();
//	}
//	else{
//		change_password();
//	}
//}
//
//elseif($_POST['mode'] == "save_change_profile"){
//	$chk = checkProfileValue();
//	if($chk == true){
//		update_profile();
//	}
//	else{
//		dispmiddle();
//	}
//}
//elseif($_REQUEST['mode']=="createUser"){
//	createUser();
//}
//elseif($_REQUEST['mode']=="createNewUser"){
//	$chk=checkUser();
//	if($chk==true){
//		createNewUser();
//	}
//	else{
//		createUser();
//	}
//}
//else{
	dispmiddle();
//}

ob_end_flush();
/*************************************************/



/////      Start of Middle function  //////
function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));
	$bidObj = new Bid();
	$auction_id=$_REQUEST['auction_id'] ?? '';
	$bidData=$bidObj->fetchProxyBidsInAdmin($auction_id);
	//print_r($bidData);
	$total=count($bidData);
	$smarty->assign('total', $total);
	$smarty->assign('bidData', $bidData);
	$smarty->display("admin_proxy_auction_details.tpl");
}

?>
<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
define ("PAGE_HEADER_TEXT", "Admin Login");

if(isset($_SESSION['adminLoginID']) && $_REQUEST['mode']!="adminLogout"){
	redirect_admin("admin_main.php");
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="checkLogin"){
	$chk = checkLogin();
	if($chk == true){
		admin_login();
	}
	else{
		dispmiddle();
	}
}
elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "forgotpassword"){
	forgotpassword();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "retrieve_pass"){
	retrieve_pass();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "reset_password"){
	reset_password();
}
elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="send_password"){
	$chk = checkAdminEmail();
	if($chk == true){
		send_password();
	}
	else{
		forgotpassword();
	}
}
elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="adminLogout"){
	adminLogout();
}
else{
	dispmiddle();
}

ob_end_flush();

/*************************************************/



function dispmiddle(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_login.tpl");
}

/********************* Admin Login Function START *****************************************/


function checkLogin(){
	$errCounter=0;
	
	if(trim($_POST['user_name'])==""){
		$errCounter++;
		$GLOBALS['user_name_err'] = "Please enter your username.";
	}
	if(trim($_POST['password'])==""){
		$errCounter++;
		$GLOBALS['password_err'] = "Please enter your password.";
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}



function admin_login(){
	$obj = new AdminUser;
	$obj->adminLoginName = $_POST['user_name'];
	$obj->adminPassword = $_POST['password'];
	
	$chkUserName = $obj->checkAdminUserName();
	if($chkUserName == true){
		$chkBlock = $obj->checkAdminUserNameBlock();
		if($chkBlock == false){
			$chkLogin = $obj->checkAdminLogin();
			if($chkLogin == true){
				$chk = $obj->adminLogin();
				if($chk == true){
					redirect_admin($_SESSION['redirect_page']);
				}
				else{
					$_SESSION['adminErr'] = "Sorry! There is some problem. Please try again.";
					redirect_admin("admin_login.php");
				}
			}
			else{
				$_SESSION['adminErr'] = "You have entered wrong username or password.";
				redirect_admin("admin_login.php");
			}
		}
		else{
			$_SESSION['adminErr'] = "Sorry! Your login information has been blocked.";
			redirect_admin("admin_login.php");
		}
	}
	else{
		$_SESSION['adminErr'] = "You have entered wrong username or password.";
		redirect_admin("admin_login.php");
	}
}
/****************   Admin Login Function END  ********************************************/



function forgotpassword(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value)); 
	}
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_forgot_password.tpl");
}


function checkAdminEmail(){
	$errCounter=0;
	
	if(trim($_POST['email'])==""){
		$errCounter++;
		$GLOBALS['email_err'] = "Please enter your email address or username.";
	}
	
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}


function send_password(){
	$obj = new AdminUser;
	$obj->adminEmail = $_POST['email'];
	$obj->adminLoginName = $_REQUEST['email'];
	$chkUserEmail = $obj->checkAdminEmail();
	if($chkUserEmail == true){
		$chk = $obj->adminResetPassword();
		if($chk == true){
			$_SESSION['adminErr'] = "Your new password has been sent to your email address.";
			redirect_admin("admin_login.php?mode=forgotpassword");
		}
		else{
			$_SESSION['adminErr'] = "Sorry! There is some problem. Please try again.";
			redirect_admin("admin_login.php?mode=forgotpassword");
		}
	}
	else{
		$_SESSION['adminErr'] = "You have entered wrong email address or username.";
		redirect_admin("admin_login.php?mode=forgotpassword");
	}
}


/********************* Admin Logout Function START *****************************************/

function adminLogout(){
	$obj = new AdminUser;
	$chk = $obj->adminLogout();
	redirect_admin("admin_login.php");
}
/****************   Admin Logout Function END  ********************************************/
function retrieve_pass(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$verify_id=$_REQUEST['verify_id'];
	$smarty->assign('verify_id', $verify_id); 
	$smarty->display("admin_set_pass.tpl");
}
function reset_password(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$objAdmin = new DBCommon();
	$objAdmin->primaryKey="admin_id";
	$verify_code=$_REQUEST['verify_id'];
	$verify_id=md5($_REQUEST['verify_id']);
	
	if($_POST['password']==""){
		
		$_SESSION['adminErr'] = "Please enter your password";
		redirect_admin("admin_login.php?mode=retrieve_pass&verify_id=".$verify_code);
	}elseif($_POST['confirm_password']==""){
		
		$_SESSION['adminErr'] = "Please enter your confirm password";
		redirect_admin("admin_login.php?mode=retrieve_pass&verify_id=".$verify_code);
	}elseif($_POST['password']!=$_POST['confirm_password']){
		
		$_SESSION['adminErr'] = "You password and confirm password is not same.";
		redirect_admin("admin_login.php?mode=retrieve_pass&verify_id=".$verify_code);
	}else{
		$pass=md5($_POST['password']);
		$chk=$objAdmin->updateData(ADMIN_TABLE,array("admin_pwd"=>$pass),array("admin_set_password"=>$verify_id),true);
		$chkAdmin=$objAdmin->updateData(ADMIN_TABLE,array("admin_set_password"=>''),array("admin_set_password"=>$verify_id),true);
		$_SESSION['adminErr'] = "You password is updated successfully.";
		redirect_admin("admin_login.php");
	}
}
?>

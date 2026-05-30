<?php
ob_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(isset($_SESSION['sessUserID']) && $_SESSION['sessUserID']!=''){
	header("Location: myaccount.php");
	exit;
}

//content();       ////////////   For page content 

if($_REQUEST['mode'] == 'send_password'){
	if(validate_forget_password() == true){
		send_password();
	}else{
		dispmiddle();
	}
}elseif($_REQUEST['mode'] == 'retrieve_pass'){
	retrieve_pass();
}elseif($_REQUEST['mode'] == 'reset_password'){
	reset_password();
}else{
	dispmiddle();
}

ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/common.php";

	$smarty->assign('username', $_POST['username']);
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}

	$smarty->display("forget_password.tpl");
}

function validate_forget_password()
{
	$errCounter = 0;
	
	if($_REQUEST['username'] == ""){
		$GLOBALS['username_err'] = "Please enter Username.";
		$errCounter++;	
	}
	else{
		$obj = new User();
		$obj->status = '1';
		$obj->username = $_REQUEST['username'];
		$obj->email = $_REQUEST['username'];
		$row = $obj->fetchUsernameEmail();
		if($row[USER_ID] == ''){
			$errCounter++;
			$GLOBALS['username_err'] = "Invalid Username / Email Id!.";
		}
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function send_password()
{
	$obj = new User();
	$obj->status = '1';
	$obj->username = $_REQUEST['username'];
	$obj->email = $_REQUEST['username'];
	$row = $obj->fetchUserDetails();
	if(!empty($row)){
		$newPassword = generatePassword();
		$obj->password = $newPassword;
		$chk = $obj->forgetPassword();
	}else{
		$newPassword = generatePassword();
		$row = $obj->fetchUsernameEmail();
		$obj->password = $newPassword;
		$chk = $obj->forgetPasswordEmail();
	}
	
	//$countryCode = getCountryCode($row[COUNTRY_ID]);
	
	
	
	
	if($chk == true){
		/******************************** Email Start ******************************/
			
			 $toMail = $row['email'];
			 $toName = $row['firstname']." ".$row['lastname'];
			 $subject = "Forget Password";
			 $fromMail = ADMIN_EMAIL_ADDRESS;
			 $fromName = ADMIN_NAME;
			$resetUrl = 'https://'.HOST_NAME.'/forget_password.php?mode=retrieve_pass&varify_id='.$newPassword;
			$textContent  = "<p style='margin:0 0 16px 0; color:#333333;'>Dear " . htmlspecialchars($row['firstname']) . ",</p>";
			$textContent .= "<p style='margin:0 0 16px 0; color:#333333;'>We received a request to reset your KaijuLink password. Click the button below to set a new password. This link is valid for a limited time.</p>";
			$textContent .= "<p style='margin:0 0 20px 0;'><a href='" . $resetUrl . "' style='display:inline-block; background:#c0392b; color:#ffffff; padding:10px 24px; border-radius:4px; text-decoration:none; font-weight:bold; font-size:14px;'>Reset My Password</a></p>";
			$textContent .= "<p style='margin:0 0 16px 0; color:#999999; font-size:12px;'>If the button doesn't work, copy and paste this link into your browser:<br /><a href='" . $resetUrl . "' style='color:#c0392b;'>" . $resetUrl . "</a></p>";
			$textContent .= "<p style='margin:0 0 16px 0; color:#333333;'>If you did not request a password reset, you can safely ignore this email.</p>";
			$textContent .= "<p style='margin:20px 0 0 0; color:#333333;'>Warm regards,<br /><strong>".ADMIN_NAME."</strong><br /><a href='mailto:".ADMIN_EMAIL_ADDRESS."' style='color:#c0392b;'>".ADMIN_EMAIL_ADDRESS."</a></p>";	
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
			
			/****************************** Email End ********************************/

		if($check == true){
			$_SESSION['Err']="A mail has been sent to your registered mail to set new password.";
			header("location: forget_password.php?key=1");
			exit();
		}else{
			$_SESSION['Err']="Failed to send mail. Please try again.";
			header("location: forget_password.php?key=0");
			exit();
		}
	}
}
function retrieve_pass(){
	require_once INCLUDE_PATH."lib/common.php";
	$objUser = new User();
	$objUser->primaryKey=USER_ID;
	$count=$objUser->countData(USER_TABLE,array("user_setpass_code"=>md5($_REQUEST['varify_id'])));
	if($count > 0){
		$show_ind=1;
	}elseif($count == 0){
		$show_ind=0;
	}
	$smarty->assign('show_ind', $show_ind);
	$smarty->assign('varify_id', $_REQUEST['varify_id']);
	$smarty->display("reset_password.tpl");
}
function reset_password(){
	require_once INCLUDE_PATH."lib/common.php";
	$objUser = new User();
	$objUser->primaryKey=USER_ID;
	$actual_code=$_REQUEST['user_setpass_code'];
	$user_setpass_code=md5($_REQUEST['user_setpass_code']);
	$pass=md5($_REQUEST['password']);
	$confirm_pass=md5($_REQUEST['confirm_password']);
//	echo $user_setpass_code."<br>";
//	echo $pass."<br>";
//	echo $confirm_pass."<br>";
//	exit;
	if($pass==$confirm_pass){
	$count=$objUser->countData(USER_TABLE,array("user_setpass_code"=>$user_setpass_code))	;
	if($count>0){
	$chk=$objUser->updateData(USER_TABLE,array("password"=>$pass),array("user_setpass_code"=>$user_setpass_code),true);
	$chkUser=$objUser->updateData(USER_TABLE,array("user_setpass_code"=>''),array("user_setpass_code"=>$user_setpass_code),true);
	if($chk){
		$_SESSION['Err']="New password has been set";
		header("location: forget_password.php");
		exit;
	 }else{
	 	$_SESSION['Err']="Can not set new password. Please try again.";
	 	header("location: forget_password.php");
	 	exit;	
	 }
	}else{
		$_SESSION['Err']="Can not set new password. Please try again.";
		header("location: forget_password.php?mode=retrieve_pass&varify_id=".$actual_code);	
		exit;
	}
	}else{
		$_SESSION['Err']="New password and confirm password is not same.";
		header("location: forget_password.php?mode=retrieve_pass&varify_id=".$actual_code);
		exit;
	}
	
	//$smarty->display("reset_password.tpl");
}
?>
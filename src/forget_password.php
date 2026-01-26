<?php
ob_start();
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
			$textContent = "Please click in the url to reset your new password <br/>";
			$textContent.= '<a href="http://'.HOST_NAME.'/forget_password.php?mode=retrieve_pass&varify_id='.$newPassword.'" target="_blank">http://'.HOST_NAME.'/forget_password.php?mode=retrieve_pass&varify_id='.$newPassword."</a><br /><br />";
			//$textContent .= "<b>Username : </b>".$_POST['username']."<br />";
			//$textContent .= "<b>Password : </b>".$password."<br /><br />";
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
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
	$objUser->primaryKey=user_id;
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
	$objUser->primaryKey=user_id;
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
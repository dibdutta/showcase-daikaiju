<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED); 
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(isset($_POST['mode']) && $_POST['mode'] == "process_login"){
	process_login();
}elseif(isset($_POST['mode']) && $_POST['mode'] == "logout"){
	logout();
}elseif(isset($_POST['mode']) && $_POST['mode'] == "change_password"){
	forget_password();
}else{
	process_login();
}
ob_end_flush();

function process_login()
{
	$obj = new User();
	$obj->username = $_REQUEST['username'];
	$obj->password = $_REQUEST['password'];
	//$ipCountry=chkIpAddress();
	//if($ipCountry!='GREECE'){
		if($chk = $obj->checkLogin()){
			$auctionWeekObj = new AuctionWeek();
	    	$auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
			if($auctionWeeks >= 1){
				echo '1';
			}else{
				$auctionWeeksUpcoming =$auctionWeekObj->countLiveAuctionWeekUpcoming();
				if($auctionWeeksUpcoming >=1){
					echo '2';
				}else{
					echo '3';
				}
			}
		}else{
			echo 'Invalid Username / Password!';
		}
	//}else{
		//echo 'Invalid Username / Password!';
	//}
	exit;
}

function forgot_password()
{
	require_once INCLUDE_PATH."lib/common.php";

	foreach ($_POST as $key => $value ) {
		//$smarty->assign($key, $value);
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}

	$smarty->display("forgot_password.tpl");
}

function validateForgotPassword()
{
	$errCounter = 0;

	if($_POST['login_type'] == '1'){
		$obj = new Member();
	}else{
		$obj = new Advertiser();
	}
	$obj->username = trim($_REQUEST['username']);
	
	if($_REQUEST['username'] == ""){
		$GLOBALS['username_err'] = "Enter Username.";
		$errCounter++;
	}elseif($obj->checkUsername() == false){
		$GLOBALS['username_err'] = "Invalid Username.";
		$errCounter++;
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}

}

function send_new_password()
{
	if($_POST['login_type'] == '1'){
		$obj = new Member();
		$obj->username = $_REQUEST['username'];
		$row = $obj->fetchMemberDetails();
		$obj->memberID = $row[MEMBER_ID];
	}else{
		$obj = new Advertiser();
		$obj->username = $_REQUEST['username'];
		$row = $obj->fetchAdvertiserDetails();
		$obj->advertiserID = $row[ADVERTISER_ID];
	}

	$newPassword = generatePassword();
	$obj->password = $newPassword;	
	$chk = $obj->updatePassword();

	if($chk == true){
	
		/******************************** Email Start ******************************/
		
		$toMail = $row[EMAIL];
		$toName = $row[FIRSTNAME];
		$subject = "Forgot Password";
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		
		$textContent  = "<p style='margin:0 0 16px 0; color:#333333;'>Dear " . htmlspecialchars($row[FIRSTNAME]) . ",</p>";
		$textContent .= "<p style='margin:0 0 12px 0; color:#333333;'>As requested, here are your login credentials:</p>";
		$textContent .= "<table style='background:#f9f9f9; border:1px solid #e0e0e0; border-radius:4px; margin:0 0 20px 0; border-collapse:collapse;'>";
		$textContent .= "<tr><td style='padding:10px 20px; color:#666666; font-size:13px; border-bottom:1px solid #e0e0e0;'><strong>Username</strong></td><td style='padding:10px 20px; color:#333333; font-size:13px; border-bottom:1px solid #e0e0e0;'>" . htmlspecialchars(trim($_POST['username'])) . "</td></tr>";
		$textContent .= "<tr><td style='padding:10px 20px; color:#666666; font-size:13px;'><strong>Password</strong></td><td style='padding:10px 20px; color:#333333; font-size:13px;'>" . htmlspecialchars($newPassword) . "</td></tr>";
		$textContent .= "</table>";
		$textContent .= "<p style='margin:0 0 16px 0;'><a href='https://www.kaijulink.com' style='display:inline-block; background:#c0392b; color:#ffffff; padding:10px 24px; border-radius:4px; text-decoration:none; font-weight:bold; font-size:14px;'>Log In to Your Account</a></p>";
		$textContent .= "<p style='margin:20px 0 0 0; color:#333333;'>Warm regards,<br /><strong>".ADMIN_NAME."</strong><br /><a href='mailto:".ADMIN_EMAIL_ADDRESS."' style='color:#c0392b;'>".ADMIN_EMAIL_ADDRESS."</a></p>";	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;

		$chk = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

	
		$_SESSION['Err'] = "New Password has been sent to your email-ID.";
		header("Location: index.php");
		exit;
	}else{
		$_SESSION['Err'] = "Forgot Password process has failed. Please Try Again.";
		header("Location: index.php");
		exit;
	}
}

function validateUser($email,$firstname,$lastname){
		$email=preg_replace('/\s+/', '', $email);
		$firstname=preg_replace('/\s+/', '', $firstname);
		$lastname=preg_replace('/\s+/', '', $lastname);
		$sqlTemp = "Select * from  tbl_blacklist WHERE idtbl_blacklist=100 ";
		$ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		$rowtemp= mysqli_fetch_assoc($ressql);
		$domainArr=explode(",",$rowtemp['domain']);
		$key=1;
		foreach($domainArr as $name) {
			list($user, $domain) = explode('@', $email);
			if ($domain == $name) {
				$key=2;
				break;
			}
		}
		
		$firstnameArr=explode(",",$rowtemp['firstname']);
		foreach($firstnameArr as $name) {
			$name=preg_replace('/\s+/', '', $name);
			if (strtoupper($firstname )== strtoupper($name)) {
				$key=2;
				break;
			}
		}
		
		$lastnameArr=explode(",",$rowtemp['lastname']);
		foreach($lastnameArr as $name) {
			$name=preg_replace('/\s+/', '', $name);
			if (strtoupper($lastname) == strtoupper($name)) {
				$key=2;
				break;
			}
		}
		
		$emailArr=explode(",",$rowtemp['email']);
		foreach($emailArr as $name) {
			$name=preg_replace('/\s+/', '', $name);
			if (strtoupper($email) == strtoupper($name)) {
				$key=2;
				break;
			}
		}

		return $key;
		
	}

?>
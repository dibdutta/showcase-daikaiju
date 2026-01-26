<?php
/**
 * 
 * This class handles all the functions that are related to Admin module.
 *
 */
class AdminUser{
	var $ownID;

	var $adminID;
	var $adminLoginName;
	var $adminPassword;
	var $adminSetPassword;
	var $adminEmail;
	var $adminFirstName;
	var $adminMiddleName;
	var $adminLastName;
	var $loginTry;
	var $adminLastLooggedin;
	var $resetPassword;
	var $blockReason;	
	var $superAdmin;
	
	var $adminAccessID;
	var $adminAccessSection;
	
	var $adminSectionID;
	var $adminSectionName;
	
	var $accessSectionList;
	
	
	function __construct(){
		$this->postIP = $_SERVER['REMOTE_ADDR'];
		$this->status = 0;
		
		$this->offset = $GLOBALS['offset'];
		$this->toShow = $GLOBALS['toshow'];
		$this->orderType = $GLOBALS['order_type'];
		$this->orderBy = $GLOBALS['order_by'];
	}
	
	
	function fetchAdminDetails(){
		$sql = "SELECT at.* 
				FROM ".ADMIN_TABLE." AS at 
				WHERE 1 ";
		if($this->adminID!=""){
			$sql .= " AND at.".ADMIN_ID." = '".$this->adminID."'";
		}
		if($this->adminEmail!=""){
			$sql .= " AND at.".ADMIN_EMAIL." = '".$this->adminEmail."'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			return $row;
		}
		else{
			return false;
		}
	}
	function fetchAdminDetailsByUsername(){
		$sql = "SELECT at.* 
				FROM ".ADMIN_TABLE." AS at 
				WHERE 1 ";
		if($this->adminLoginName!=""){
			$sql .= " AND at.".ADMIN_LOGIN_NAME." = '".$this->adminLoginName."'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			return $row;
		}
	}
	function checkAdminEmail(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_EMAIL." = '".$this->adminEmail."' OR 
				".ADMIN_LOGIN_NAME." = '".$this->adminLoginName."'
				";
		if($this->adminID!=""){
			$sql .= " AND ".ADMIN_ID." !='".$this->adminID."' ";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	function updateAdminProfile(){
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_FIRST_NAME." = '".$this->adminFirstName."', 
				".ADMIN_MIDDLE_NAME." = '".$this->adminMiddleName."', 
				".ADMIN_LAST_NAME." = '".$this->adminLastName."', 
				".ADMIN_EMAIL." = '".$this->adminEmail."',
				".UPDATE_DATE." = now(),
				".POST_IP." = '".$this->postIP."' 
				WHERE ".ADMIN_ID." = '".$this->adminID."' ";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			 $userName = $this->adminFirstName." ".$this->adminMiddleName." ".$this->adminLastName;
			 $userEmail = $this->adminEmail;
			$subject = "Your profile has beed updated successfully in ".HOST_NAME."";
			
			 $mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>Your profile has been updated successfully today in <a href="'.DOMAIN_PATH.'/" target="_blank">'.HOST_NAME.'</a>. Here is your updated profile:<br><br> Name : <span style="font-weight: bold; font-color: #0000FF;">'.$userName.'</span><br>Email Address : <span style="font-weight: bold; font-color: #0000FF;">'.$userEmail.'</span><br><br><br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM; 

			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
			
			return true;
		}
		else{
			return false;
		}
	}
	
	function checkAdminPassword(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_PASSWORD." LIKE BINARY MD5('".$this->adminPassword."') 
				AND ".ADMIN_ID."='".$this->adminID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter'] >0) {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function updateAdminPassword(){
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_PASSWORD."=MD5('".$this->adminPassword."'),
				".UPDATE_DATE." = now(),
				".POST_IP." = '".$this->postIP."' 
				WHERE ".ADMIN_ID."='".$this->adminID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = $this->fetchAdminDetails();
			$userName = $row[ADMIN_FIRST_NAME]." ".$row[ADMIN_MIDDLE_NAME]." ".$row[ADMIN_LAST_NAME];
			 $userEmail = $row[ADMIN_EMAIL];
			$subject = "Your password has beed updated successfully in ".HOST_NAME."";
			
		 	$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>Your password has been updated successfully today in <a href="'.DOMAIN_PATH.'/" target="_blank">'.HOST_NAME.'</a>. Here is your current login information:<br><br> Username : <span style="font-weight: bold; font-color: #0000FF;">'.$row[ADMIN_LOGIN_NAME].'</span><br>Password : <span style="font-weight: bold; font-color: #0000FF;">'.$this->adminPassword.'</span><br><br><br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM; 

			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
			return true;
		}
		else {
			return false;
		}
	}
	
	
	function checkAdminUserNameBlock(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' 
				AND ".ADMIN_LOGIN_TRY." < '3' 
				AND ".STATUS." != '0' ";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0) {
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return true;
		}
	}
	
	
	function checkAdminUserName(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."'";
		if($this->adminID!=""){
			$sql .= " AND ".ADMIN_ID."!='".$this->adminID."'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0) {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function checkAdminLogin(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' 
				AND ".ADMIN_PASSWORD." LIKE BINARY MD5('".$this->adminPassword."')";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0) {
				return true;
			}
			else{
				$sqlChk = "SELECT ".ADMIN_LOGIN_TRY." 
							FROM ".ADMIN_TABLE." 
							WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' ";
				$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
				$rowChk = mysqli_fetch_array($resChk);
				
				if(($rowChk[ADMIN_LOGIN_TRY]+1)==3){
					$sql = "UPDATE ".ADMIN_TABLE." SET 
							".ADMIN_LOGIN_TRY." = '".($rowChk[ADMIN_LOGIN_TRY]+1)."', 
							".ADMIN_BLOCK_REASON." = 'Too many try using wrong username and password.', 
							WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' ";
				}
				else{
					$sql = "UPDATE ".ADMIN_TABLE." SET 
							".ADMIN_LOGIN_TRY." = '".($rowChk[ADMIN_LOGIN_TRY]+1)."' 
							WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' ";
				}
				$res = mysqli_query($GLOBALS['db_connect'],$sql);
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function adminLogin(){
		$sql = "SELECT ".ADMIN_ID.", ".ADMIN_LAST_LOGIN.", ".ADMIN_SUPER_ADMIN.", ".ADMIN_RESET_PASSWORD.", 
				CONCAT(".ADMIN_FIRST_NAME.", ' ', ".ADMIN_MIDDLE_NAME.", ' ', ".ADMIN_LAST_NAME.") AS administrator
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_LOGIN_NAME." LIKE BINARY '".$this->adminLoginName."' 
				AND ".ADMIN_PASSWORD." LIKE BINARY MD5('".$this->adminPassword."')";
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			
			//session_register("adminLoginID");
			//session_register("adminLastLoginDate");
			//session_register("administratorName");
			
			$_SESSION['adminLoginID']=$row[ADMIN_ID];
			$_SESSION['adminLastLoginDate']=$row[ADMIN_LAST_LOGIN];
			$_SESSION['administratorNames']=$row['administrator'];
			
			if($row[ADMIN_RESET_PASSWORD] == 1){
				$_SESSION['redirect_page'] = "admin_account_manager.php?mode=change_password&msg=Please change your password.";
			}
			else{
				$_SESSION['redirect_page'] = "admin_main.php";
			}
			
			$_SESSION['accessPages'] = array();
			
			$sql = "UPDATE ".ADMIN_TABLE." SET 
					".ADMIN_LOGIN_TRY." = '0', 
					".ADMIN_RESET_PASSWORD." = '0' 
					WHERE ".ADMIN_ID." = '".$row[ADMIN_ID]."'";
			$res = mysqli_query($GLOBALS['db_connect'],$sql);
			
			if($row[ADMIN_SUPER_ADMIN] == 1 && MULTIUSER_ADMIN == true){
				session_register("superAdmin");
				$_SESSION['superAdmin'] = 1;
				
				$sqlAccess = " SELECT apt.".ADMIN_SECTION_NAME." 
								FROM ".ADMIN_SECTION_TABLE." AS apt 
								WHERE 1 
								AND apt.".STATUS." = '1' ";		
			}
			else{
				$sqlAccess = " SELECT apt.".ADMIN_SECTION_NAME." 
								FROM ".ADMIN_ACCESS_TABLE." AS aat 
								LEFT JOIN ".ADMIN_SECTION_TABLE." AS apt ON apt.".ADMIN_SECTION_ID." = aat.".ADMIN_SECTION_ID." 
								WHERE aat.".ADMIN_ID." = '".$row[ADMIN_ID]."' 
								AND apt.".STATUS." = '1' ";
			}
			$resAccess = mysqli_query($GLOBALS['db_connect'],$sqlAccess);
			while($rowAccess = mysqli_fetch_array($resAccess)){
				if(strstr($rowAccess[ADMIN_SECTION_NAME], ",")){
					$temp = explode(",", $rowAccess[ADMIN_SECTION_NAME]);
					foreach($temp as $val){
						$_SESSION['accessPages'][] = $val;
					}
				}
				else{
					$_SESSION['accessPages'][] = $rowAccess[ADMIN_SECTION_NAME];
				}
			}
			
			return true;
		}
		else{
			return false;
		}
	}
	
	function adminResetPassword(){
		$this->adminPassword = makeRandomWord(8);
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_SET_PASSWORD." = '".md5($this->adminPassword)."', 
				".UPDATE_DATE." = now(), 
				".POST_IP." = '".$this->postIP."'
				WHERE ".ADMIN_EMAIL." = '".$this->adminEmail."'
				OR ".ADMIN_LOGIN_NAME."= '".$this->adminLoginName."'
				";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = $this->fetchAdminDetails();
			if(empty($row)){
				$row = $this->fetchAdminDetailsByUsername();
			}
			$userName = $row[ADMIN_FIRST_NAME]." ".$row[ADMIN_MIDDLE_NAME]." ".$row[ADMIN_LAST_NAME];
			$userEmail = $row[ADMIN_EMAIL];
			$subject = "Forget Password";
			
			$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br /><br />Please click in the url to reset your new password.<br /><br /><a href="http://'.HOST_NAME.'/admin/admin_login.php?mode=retrieve_pass&verify_id='.$this->adminPassword.'" target="_blank">http://'.HOST_NAME.'/admin/admin_login.php?mode=retrieve_pass&verify_id='.$this->adminPassword.'</a><br /><br /><br />Regards,<br>Administrator '.ADMIN_NAME.'<br />'.HOST_NAME.'<br /><br /><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
			
			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
			return true;
		}
		else{
			return false;
		}
	}
	
	function adminLogout(){
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_LAST_LOGIN."=now() 
				WHERE ".ADMIN_ID."='".$_SESSION['adminLoginID']."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		
		unset($_SESSION['adminLoginID']);
		unset($_SESSION['adminLastLoginDate']);
		unset($_SESSION['administratorName']);
		unset($_SESSION['accessPages']);
		unset($_SESSION['superAdmin']);
		
		session_register("accessPages");
		session_register("administratorName");
		session_unregister("adminLoginID");
		session_unregister("adminLastLoginDate");
		session_register("superAdmin");
		
		session_destroy();
	}

	function totalAdminUser(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE 1 ";
		if(SUPER_ADMIN_CREATION == true){
			$sql .= " AND ".ADMIN_ID." != '".$this->ownID."'";
		}
		else{
			$sql .= " AND ".ADMIN_SUPER_ADMIN." != '1'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			return $row['counter'];
		}
		else{
			return false;
		}
	}
	
	
	function fetchAllAdministrator(){
		$sql = "SELECT * 
				FROM ".ADMIN_TABLE." 
				WHERE 1 ";
		if(SUPER_ADMIN_CREATION == true){
			$sql .= " AND ".ADMIN_ID." != '".$this->ownID."'";
		}
		else{
			$sql .= " AND ".ADMIN_SUPER_ADMIN." != '1'";
		}
		$sql .=" ORDER BY ".$this->orderBy." ".$this->orderType." 
				 LIMIT ".$this->offset.", ".$this->toShow."";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	function addAdminProfile(){
		$sql = "INSERT INTO ".ADMIN_TABLE." SET 
				".ADMIN_LOGIN_NAME." = '".$this->adminLoginName."', 
				".ADMIN_PASSWORD." = '".md5($this->adminPassword)."', 
				".ADMIN_FIRST_NAME." = '".$this->adminFirstName."', 
				".ADMIN_MIDDLE_NAME." = '".$this->adminMiddleName."', 
				".ADMIN_LAST_NAME." = '".$this->adminLastName."', 
				".ADMIN_EMAIL." = '".$this->adminEmail."', 
				".POST_DATE." = now(), 
				".UPDATE_DATE." = now(),
				".POST_IP." = '".$this->postIP."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$userName = $this->adminFirstName." ".$this->adminMiddleName." ".$this->adminLastName;
			$userEmail = $this->adminEmail;
			$subject = "Your profile has beed saved successfully in ".HOST_NAME."";
			
			$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>Your profile has been saved successfully today in <a href="'.DOMAIN_PATH.'/" target="_blank">'.HOST_NAME.'</a>. Here is your updated profile and login information:<br><br> Username : <span style="font-weight: bold; font-color: #0000FF;">'.$this->adminLoginName.'</span><br> Password : <span style="font-weight: bold; font-color: #0000FF;">'.$this->adminPassword.'</span><br><br> Name : <span style="font-weight: bold; font-color: #0000FF;">'.$userName.'</span><br>Email Address : <span style="font-weight: bold; font-color: #0000FF;">'.$userEmail.'</span><br><br><br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;

			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
			
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function changeStatus(){
		$sqlChk = " SELECT ".STATUS.", ".ADMIN_LOGIN_TRY." 
					FROM ".ADMIN_TABLE." 
					WHERE ".ADMIN_ID."='".$this->adminID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		
		if($rowChk[STATUS]==1 || $rowChk[ADMIN_LOGIN_TRY]>3){
			$this->status = 0;
			$this->loginTry = $rowChk[ADMIN_LOGIN_TRY];
			$this->blockReason = "Blocked by Administrator.";
			
			$rowUser = $this->fetchAdminDetails();
			$userEmail = $rowUser[ADMIN_EMAIL];
			$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
			
			$subject = "Your account in ".HOST_NAME." is inactived from today";
			
			$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>We are sorry to inform that your account in '.HOST_NAME.' is inactivated from today.<p align="justify">For further information or query, please contact <strong>Administrator</strong>.</a></p>We look forward very much to helping you,<br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
			
			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);

		}
		else{
			$this->status = 1;
			$this->loginTry = 0;
			$this->blockReason = "";
			
			$rowUser = $this->fetchAdminDetails();
			$userEmail = $rowUser[ADMIN_EMAIL];
			$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
			
			$subject = "Your account in ".HOST_NAME." is activated today";
			$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>We are pleased to inform that your account in '.HOST_NAME.' is activated today.<br><p align="justify">For further information please <strong>Administrator</strong></p>We look forward very much to helping you,<br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
			
			sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
			
		}
		
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_LOGIN_TRY."='".$this->loginTry."', 
				".ADMIN_BLOCK_REASON."='".$this->blockReason."', 
				".UPDATE_DATE."=now(), 
				".STATUS."='".$this->status."', 
				".POST_IP."='".$this->postIP."' 
				WHERE ".ADMIN_ID."='".$this->adminID."'";
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	
	
	function setActive(){
		$this->status = 1;
		$this->loginTry = 0;
		$this->blockReason = "";
		
		$rowUser = $this->fetchAdminDetails();
		$userEmail = $rowUser[ADMIN_EMAIL];
		$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
		
		$subject = "Your account in ".HOST_NAME." is activated today";
		$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>We are pleased to inform that your account in '.HOST_NAME.' is activated today.<br><p align="justify">For further information please <strong>Administrator</strong></p>We look forward very much to helping you,<br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
		
		sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
		
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_LOGIN_TRY."='".$this->loginTry."', 
				".ADMIN_BLOCK_REASON."='".$this->blockReason."', 
				".UPDATE_DATE."=now(), 
				".STATUS."='".$this->status."', 
				".POST_IP."='".$this->postIP."' 
				WHERE ".ADMIN_ID."='".$this->adminID."'";
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function setInactive(){
		$sqlChk = " SELECT ".STATUS.", ".ADMIN_LOGIN_TRY." 
					FROM ".ADMIN_TABLE." 
					WHERE ".ADMIN_ID."='".$this->adminID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		
		$this->status = 0;
		$this->loginTry = $rowChk[ADMIN_LOGIN_TRY];
		$this->blockReason = "Blocked by Administrator.";
		
		$rowUser = $this->fetchAdminDetails();
		$userEmail = $rowUser[ADMIN_EMAIL];
		$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
		
		$subject = "Your account in ".HOST_NAME." is inactived from today";
		
		$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>We are sorry to inform that your account in '.HOST_NAME.' is inactivated from today.<p align="justify">For further information or query, please contact <strong>Administrator</strong>.</a></p>We look forward very much to helping you,<br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
		
		sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
		
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_LOGIN_TRY."='".$this->loginTry."', 
				".ADMIN_BLOCK_REASON."='".$this->blockReason."', 
				".UPDATE_DATE."=now(), 
				".STATUS."='".$this->status."', 
				".POST_IP."='".$this->postIP."' 
				WHERE ".ADMIN_ID."='".$this->adminID."'";
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	
	function deleteAdministrator(){
		$rowUser = $this->fetchAdminDetails();
		$userEmail = $rowUser[ADMIN_EMAIL];
		$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
		
		$sendChk = 1;
		$subject = "Your acount in ".HOST_NAME." has been removed.";
		
		$mailBody = MAIL_BODY_TOP.'Dear <b>'.$userName.'</b>,<br><br>We are sorry to inform you that your account has been removed form our wesite.<br><br>Regards,<br>Administrator '.ADMIN_NAME.'<br>'.HOST_NAME.'<br><br><span style="color: #0000FF;"><strong>PLEASE NOTE:</strong> THIS IS AN AUTO GENERATED MAIL. PLEASE DO NOT REPLY TO THIS E-MAIL. </span>'.MAIL_BODY_BOTTOM;
		
		$sendChk = sendMail($userEmail, $userName, $subject, $mailBody, ADMIN_EMAIL_ADDRESS, ADMIN_NAME, $html=1);
		if($sendChk == 1) {
			$sql = "DELETE FROM ".ADMIN_TABLE." WHERE ".ADMIN_ID."='".$this->adminID."'";
			if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
				return true;
			}
			else{
				return false;
			}
		}
		else {
			return false;
		}	
	}
	
	
	function createPageList(){
		$dirPath="../admin/";
		$dirPointer = dir($dirPath);
		$filesDetails = array();
		while($entry = $dirPointer->read()) {
			if ($entry != "." && $entry != "..") {
				if(preg_match("/admin_*\w*_manager.php/i", $entry) && $entry!="admin_super_manager.php") {
					$filesDetails[$entry] = ucwords(str_replace("_", " ", str_replace(".php", "", $entry)));
				}
			}
		}
		$dirPointer->close();
		
		
		foreach($filesDetails as $key=>$val){
			$sqlChk = " SELECT COUNT(".ADMIN_SECTION_ID.") AS counter 
						FROM ".ADMIN_SECTION_TABLE." 
						WHERE ".ADMIN_SECTION_NAME." = '".$key."'";
			$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
			$rowChk = mysqli_fetch_array($resChk);
			if($rowChk['counter']==0){
				$sql = "INSERT INTO ".ADMIN_SECTION_TABLE." SET 
						".ADMIN_SECTION_NAME." = '".$key."', 
						".ADMIN_SECTION_DESCRIPTION." = '".$val."', 
						".POST_DATE." = now(), 
						".UPDATE_DATE." = now(), 
						".STATUS." = '1', 
						".POST_IP." = '".$this->postIP."'
						";
				$res = mysqli_query($GLOBALS['db_connect'],$sql);
			}
		}	
		
		return $filesDetails;
	}
	
	
	function fetchTotalAdminSection(){
		$sql = "SELECT COUNT(".ADMIN_SECTION_ID.") AS counter 
				FROM ".ADMIN_SECTION_TABLE." 
				WHERE 1 ";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter'] > 0){
				return $row['counter'];
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function fetchAdminSection(){
		$sql = "SELECT ".ADMIN_SECTION_ID.", ".ADMIN_SECTION_NAME.", ".ADMIN_SECTION_DESCRIPTION." 
				FROM ".ADMIN_SECTION_TABLE." 
				WHERE 1 
				ORDER BY ".ADMIN_SECTION_DESCRIPTION." ASC";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	
	function fetchAccessedSection(){
		$sql = "SELECT apt.".ADMIN_SECTION_ID.", apt.".ADMIN_SECTION_NAME." 
				FROM ".ADMIN_ACCESS_TABLE." AS aat 
				LEFT JOIN ".ADMIN_SECTION_TABLE." AS apt ON apt.".ADMIN_SECTION_ID." = aat.".ADMIN_SECTION_ID." 
				WHERE aat.".ADMIN_ID." = '".$this->adminID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_array($res)){
				$result[] = $row;
			}
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	function checkSuperAdmin(){
		$sql = "SELECT COUNT(".ADMIN_ID.") AS counter 
				FROM ".ADMIN_TABLE." 
				WHERE ".ADMIN_ID." = '".$this->adminID."' 
				AND ".ADMIN_SUPER_ADMIN." = '".$this->superAdmin."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter'] > 0){
				return $row['counter'];
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	
	function setSuperAdmin(){
		$sql = "UPDATE ".ADMIN_TABLE." SET 
				".ADMIN_SUPER_ADMIN." = '".$this->superAdmin."', 
				".UPDATE_DATE." = now(),
				".POST_IP." = '".$this->postIP."' 
				WHERE ".ADMIN_ID." = '".$this->adminID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	function setAdminAccess(){
		$totalSection = $this->fetchTotalAdminSection();
		
		
		$sqlDelete = "DELETE FROM ".ADMIN_ACCESS_TABLE." 
					 WHERE ".ADMIN_ID." = '".$this->adminID."'";
		$resDelete = mysqli_query($GLOBALS['db_connect'],$sqlDelete);
		$flag = 0;
		
		foreach($this->accessSectionList as $val){
			$sql = "INSERT INTO ".ADMIN_ACCESS_TABLE." SET 
					".ADMIN_ID." = '".$this->adminID."', 
					".ADMIN_SECTION_ID." = '".$val."', 
					".POST_DATE." = now(), 
					".POST_IP." = '".$this->postIP."'";
			if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
				
			}
			else{
				$flag = 1;
			}
		}
		if($flag == 0){
			if(SUPER_ADMIN_CREATION == true){
				if($totalSection == count($this->accessSectionList)){
					$this->superAdmin = 1;
					$this->setSuperAdmin();
				}
				else{
					$this->superAdmin = 0;
					$this->setSuperAdmin();
				}
			}
			return true;
		}
		else{
			return false;
		}
	}
}
?>
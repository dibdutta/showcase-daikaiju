<?php
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(isset($_SESSION['sessUserID']) && $_SESSION['sessUserID']!=''){
    header("Location: myaccount.php");
    exit;
}

//content();       ////////////   For page content 

if($_REQUEST['mode'] == 'register'){
    $chk = validateForm();
    if($chk == true){
        save_user();
    }else{
        dispmiddle();
    }
}elseif($_REQUEST['mode'] == 'verify'){
    verify();
}/*elseif($_REQUEST['mode'] == 'activation_code'){
    activation_code();
}elseif($_REQUEST['mode'] == 'send_activation_code'){
    if(validate_activation_code() == true){
        send_activation_code();
    }else{
        activation_code();
    }
}*/else{
    dispmiddle();
}

ob_end_flush();

function dispmiddle(){
    require_once INCLUDE_PATH."lib/common.php";
    //$rs = getCountryList();
    $rs = getCountryList();
    while($row = mysqli_fetch_array($rs)){
        $countryName[] = $row[COUNTRY_NAME];
        $countryID[] = $row[COUNTRY_ID];        
    }
    $smarty->assign('countryID', $countryID);
    $smarty->assign('countryName', $countryName);
    $smarty->assign('country_id', $_POST['country_id']);
	
	$commonObj = new DBCommon();
	$commonObj->orderBy='name';
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name','abbreviation'),$where = '1',true);

    foreach ($_POST as $key => $value ){
        $smarty->assign($key, $value);
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
    }
    
    $smarty->assign('agree_err', $GLOBALS['agree_err']);
	$smarty->assign('us_states', $us_states);

    $smarty->display("register.tpl");
}

function validateForm()
{
    require_once('securimage/securimage.php');
    $errCounter = 0;

    $obj = new User();

    if($_REQUEST['firstname'] == ""){
        $GLOBALS['firstname_err'] = "Please enter Firstname.";
        $errCounter++;  
    }

    if($_REQUEST['lastname'] == ""){
        $GLOBALS['lastname_err'] = "Please enter Lastname.";
        $errCounter++;  
    }

    if($_REQUEST['email'] == ""){
        $GLOBALS['email_err'] = "Please enter E-mail Address.";
        $errCounter++;  
    }elseif(checkEmail($_REQUEST['email'], '') == 1){
        $GLOBALS['email_err'] = "Invalid E-mail Address.";
        $errCounter++;
    }else{
        if($_REQUEST['mode'] == 'register'){
            if($obj->checkUnique(EMAIL,$_REQUEST['email'])){
                $GLOBALS['email_err'] = "E-mail Address already exists.";
                $errCounter++;
            }
        }
    }

    if($_REQUEST['username'] == ""){
        $GLOBALS['username_err'] = "Please enter Username.";
        $errCounter++;  
    }elseif($obj->checkUnique(USERNAME,$_REQUEST['username'])){
		$GLOBALS['username_err'] = "Username alreay exists.";
		$errCounter++;      
    }

    if($_REQUEST['password'] == ""){
        $GLOBALS['password_err'] = "Please enter Password.";
        $errCounter++;  
    }   
    
    if($_REQUEST['cpassword'] == ""){
        $GLOBALS['cpassword_err'] = "Please enter Confirm Password.";
        $errCounter++;  
    }   
    
    if($_REQUEST['cpassword'] != $_REQUEST['password']){
        $GLOBALS['cpassword_err'] = "Confirm Password does not match to Password.";
        $errCounter++;  
    }
    
    if($_REQUEST['address1'] == ""){
        $GLOBALS['address1_err'] = "Please enter Address1.";
        $errCounter++;  
    }
    
    if($_REQUEST['country_id'] == ""){
        $GLOBALS['country_id_err'] = "Please enter Country.";
        $errCounter++;  
    }
	
    /*if($_REQUEST['country_id'] != 230 && $_REQUEST['state_textbox'] == ""){
        $GLOBALS['state_textbox_err'] = "Please enter a State.";
        $errCounter++;  
    }else*/if($_REQUEST['country_id'] == 230 && $_REQUEST['state_select'] == ""){
        $GLOBALS['state_select_err'] = "Please select a State.";
        $errCounter++;  
	}
		
	if($_REQUEST['city'] == ""){
        $GLOBALS['city_err'] = "Please enter City.";
        $errCounter++;  
    }

    if($_REQUEST['zipcode'] == ""){
        $GLOBALS['zipcode_err'] = "Please enter Zipcode.";
        $errCounter++;  
    }
    
    if($_REQUEST['contact_no'] == ""){
        $GLOBALS['contact_no_err'] = "Please enter Mobile No.";
        $errCounter++;  
    }elseif(check_int($_REQUEST['contact_no'])==0){
    	$GLOBALS['contact_no_err'] = "Please enter valid Mobile No.";
        $errCounter++;
    }/*elseif(strlen(trim($_REQUEST['contact_no'])) != 12){
        $GLOBALS['contact_no_err'] = "Invalid Mobile No. Enter Mobile No. properly.";
        $errCounter++;  
    }*/
    
    if($_REQUEST['shipping_firstname'] == ""){
        $GLOBALS['shipping_firstname_err'] = "Please enter Shipping Firstname.";
        $errCounter++;  
    }

    if($_REQUEST['shipping_lastname'] == ""){
        $GLOBALS['shipping_lastname_err'] = "Please enter Shipping Lastname.";
        $errCounter++;  
    }

    if($_REQUEST['shipping_address1'] == ""){
        $GLOBALS['shipping_address1_err'] = "Please enter Shipping Address1.";
        $errCounter++;  
    }
        
    if($_REQUEST['shipping_country_id'] == ""){
        $GLOBALS['shipping_country_id_err'] = "Please enter Shipping Country.";
        $errCounter++;  
    }

    /*if($_REQUEST['shipping_country_id'] != 230 && $_REQUEST['shipping_state_textbox'] == ""){
        $GLOBALS['shipping_state_textbox_err'] = "Please enter Shipping State.";
        $errCounter++;  
    }else*/if($_REQUEST['shipping_country_id'] == 230 && $_REQUEST['shipping_state_select'] == ""){
        $GLOBALS['shipping_state_select_err'] = "Please select Shipping State.";
        $errCounter++;  
    }

    if($_REQUEST['shipping_city'] == ""){
        $GLOBALS['shipping_city_err'] = "Please enter Shipping City.";
        $errCounter++;  
    }

    if($_REQUEST['shipping_zipcode'] == ""){
        $GLOBALS['shipping_zipcode_err'] = "Please enter Shipping Zipcode.";
        $errCounter++;  
    }
    
    if($_REQUEST['code'] == ""){
        $GLOBALS['code_err'] = "Please enter Code.";
        $errCounter++;  
    }
        
    /*if($_REQUEST['card_type'] == ""){
        $GLOBALS['card_type_err'] = "Please enter Card Type.";
        $errCounter++; 
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
		
	/*if($errCounter == 0){
		$validcard = checkCreditCard($_REQUEST['credit_card_no'], $_REQUEST['card_type'],$ccerror, $ccerrortext);
		if($validcard == false || !paypalCCValidation($_REQUEST)){
			$GLOBALS['credit_card_no_err'] = "Card is not Valid.";
			$errCounter++;
		}
	}*/
	
    $image = new Securimage();
    if (isset($_POST['code']) && !$image->check($_POST['code'])){
        $GLOBALS['code_err'] = "Security Code is invalid.";
        $errCounter++;  
    }

    if(!isset($_POST['agree'])){
        $GLOBALS['agree_err'] = "Please read and agree to the Terms of us.";
        $errCounter++;  
    }
	//$expiry_date = $_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'];
	
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
    $obj->verifyCode = '';//generatePassword(10);
    $obj->firstname = trim($_POST['firstname']);
    $obj->lastname = trim($_POST['lastname']);
    $obj->email = $_POST['email'];
    $obj->username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $obj->password = $password; 
    $obj->address1 = $_POST['address1'];
    $obj->address2 = $_POST['address2'];
    $obj->countryID = $_POST['country_id'];
    $obj->state = ($_POST['country_id'] == '230') ? $_POST['state_select'] : $_POST['state_textbox'];
	$obj->city = $_POST['city'];
    $obj->zipcode = $_POST['zipcode'];
    
    $obj->shipping_firstname = $_POST['shipping_firstname'];
    $obj->shipping_lastname = $_POST['shipping_lastname'];
    $obj->shipping_address1 = $_POST['shipping_address1'];
    $obj->shipping_address2 = $_POST['shipping_address2'];
    $obj->shipping_countryID = $_POST['shipping_country_id'];
    $obj->shipping_state = ($_POST['shipping_country_id'] == '230') ? $_POST['shipping_state_select'] : $_POST['shipping_state_textbox'];
	$obj->shipping_city = $_POST['shipping_city'];
    $obj->shipping_zipcode = $_POST['shipping_zipcode'];
    
    $obj->contactNo = trim($_POST['contact_no']);
    $obj->newsletterSubscription = $_POST['newsletter_subscription'];
	$insert_id = $obj->saveUser();
    if($insert_id > 0){
    		/*$cardname = $_REQUEST['card_type'];
			$cardnumber = trim($_REQUEST['credit_card_no']);
			$security_code = trim($_REQUEST['security_code']);
			$expiry_date = $_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'];
			$last_digit = substr($cardnumber,-4,4);
			$expired_validity = datediff_with_presentdate($expiry_date);
			$validcard = checkCreditCard($cardnumber, $cardname,$ccerror, $ccerrortext);
			$sql="Insert into `card_details` (user_id,card_type,card_number,security_code,expiry_date,last_digit)
				  values ('".$insert_id."','".$cardname."','".md5($cardnumber)."','".md5($security_code)."','".$expiry_date."','".$last_digit."')";
			$sql_card = mysqli_query($GLOBALS['db_connect'],$sql);*/
	
        /******************************** Email Start ******************************/
        
        $toMail = $_POST['email'];
        $toName = $_POST['firstname']." ".$_POST['lastname'];
        $subject = "Email Verification";
        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;
        
        //$textContent = "Thanks for registering with us. Please click on the link below to complete the registration process.<br /><br /><a href='".DOMAIN_PATH."/register.php?mode=verify&username=".$_POST['username']."&vcode=".$obj->verifyCode."'><b>Validate</b></a><br /><br />";
		$textContent = "Thanks for registering with us. Your login credentials are given below.<br /><br />";
        $textContent .= "<b>Username : </b>".$_POST['username']."<br />";
        $textContent .= "<b>Password : </b>".$password."<br /><br />";
        $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
        $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
        $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
        
		$sqlCountry="Select country_name from country_table where country_id=".$_POST['country_id'];
		$resCountry=mysqli_query($GLOBALS['db_connect'],$sqlCountry);
		$fetchCountry=mysqli_fetch_array($resCountry);
		$country_name= $fetchCountry['country_name'];
		
		$subjectAdmin= "New User Registration";
		$textContentAdmin ="The following user has registered with MoviePosterExchange.<br/>";
		$textContentAdmin .="Username: ".$_POST['username'].".<br/>";
		$textContentAdmin .="Name: ".$_POST['firstname']." ".$_POST['lastname'].".<br/>";
		$textContentAdmin .="Address: ".$_POST['address1'].",".$country_name.",".$_POST['city']."-".$_POST['zipcode'].".<br/>";
		$textContentAdmin .="Email: ".$_POST['email'].".<br/><br/>";
        $textContentAdmin .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContentAdmin = MAIL_BODY_TOP.$textContentAdmin.MAIL_BODY_BOTTOM;
		
        $check = sendMail($fromMail, $fromName, $subjectAdmin, $textContentAdmin, $fromMail, $fromName, $html=1);
		
        /****************************** Email End ********************************/
    if(true)  
        //$_SESSION['Err']="An activation mail has sent to your mail-id.";
		$_SESSION['Err']="Registration completed successfully!";
        header("location: register.php?mode=verify&verify_status=success");
        exit();
    }else{
        $_SESSION['Err']="Registration has not been completed successfully. Please try again!";
        header("location: register.php?mode=verify&verify_status=failed");
        exit();         
    }
}

function verify()
{
    require_once INCLUDE_PATH."lib/common.php";
    
    /*$obj = new User();
    $obj->username = $_REQUEST['username'];
    $obj->verifyCode = $_REQUEST['vcode'];
    
    $chk = $obj->validate();
    if($chk == true){
        $smarty->assign("verify_status", "success");
        $smarty->assign("verify_msg", "Registration process is completed successfully.");
        //$_SESSION['Err']="Registration process is completed.";
        //header("location: register.php");
        //exit();
    }else{
        $sql = "SELECT count(user_id) AS counter FROM ".USER_TABLE." WHERE username = '".$_REQUEST['username']."'";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);
        if($row['counter'] > 0){
            $smarty->assign("verify_status", "failed");
            $smarty->assign("verify_msg", "Account is already verified.");
            //$_SESSION['Err']="Account is already verified.";
        }else{
            $smarty->assign("verify_status", "failed");
            $smarty->assign("verify_msg", "Registration process is not completed.");
            //$_SESSION['Err']="Registration process is not completed.";
        }
        //header("location: register.php?mode=verify_status");
        //exit();
    }*/
	$smarty->assign("verify_status", $_REQUEST['verify_status']);
    $smarty->display("verify_status.tpl");
}

/*function validate_activation_code()
{
    $errCounter = 0;
    
    if($_REQUEST['username'] == ""){
        $GLOBALS['username_err'] = "Please enter Username.";
        $errCounter++;  
    }else{
        $obj = new User();
        $obj->status = '0';
        $obj->username = $_REQUEST['username'];
        $row = $obj->fetchUserDetails();

        if($row[USER_ID] == ''){
            $errCounter++;
            $GLOBALS['username_err'] = "Invalid Username!.";
        }
    }
    
    if($errCounter > 0){
        return false;
    }else{
        return true;
    }
}

function activation_code()
{
    require_once INCLUDE_PATH."lib/common.php";

    $smarty->assign('username', $_POST['username']);
    foreach ($_POST as $key => $value ) {
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
    }

    $smarty->display("activation_code.tpl");
}*/

?>
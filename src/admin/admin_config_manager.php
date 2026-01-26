<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Configuration Section");

define ("REQUIRED_PAYMENT_SYSTEM", false);              // For payment settings
define ("REQUIRED_IMAGE_CONFIGURATION", false);			// For thum image settings
define ("REQUIRED_SITE_URL_CONFIGURATION", false);		// For SEO/SSL Url settings

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode']=="save_config"){
	$chk = checkValue();
	if($chk==true){
		save_content();
	}
	else{
		dispmiddle();
	}
}
else{
	dispmiddle();
}

ob_end_flush();


/*********************   START of dispmiddle Function   *********/
function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$sql="SELECT * FROM ".CONFIG_TABLE."";
	$res = mysqli_query($GLOBALS['db_connect'],$sql);
	$row = mysqli_fetch_array($res);
	
	$adminName = $row[CONFIG_ADMIN_NAME];
	$adminEmail = $row[CONFIG_ADMIN_EMAIL];
	$pageTitle = $row[CONFIG_ADMIN_PAGE_TITLE];
	$welcomeText = $row[CONFIG_ADMIN_PAGE_WELCOMETEXT];
	$instruction = $row[CONFIG_ADMIN_INSTRUCTION];
	$copyRight = $row[CONFIG_ADMIN_COPYRIGHT];
	$auction_start_hour = $row[CONFIG_AUCTION_START_HOUR];
	$auction_start_min = $row[CONFIG_AUCTION_START_MIN];
	$auction_start_am_pm = $row[CONFIG_AUCTION_START_AM_PM];
	$auction_end_hour = $row[CONFIG_AUCTION_END_HOUR];
	$auction_end_min = $row[CONFIG_AUCTION_END_MIN];
	$auction_end_am_pm = $row[CONFIG_AUCTION_END_AM_PM];
	$auction_incr_min_span = $row[CONFIG_AUCTION_INCR_MIN_SPAN];
	$auction_incr_sec_span = $row[CONFIG_AUCTION_INCR_SEC_SPAN];
	$auction_incr_by_min = $row[CONFIG_AUCTION_INCR_BY_MIN];
	$auction_incr_by_sec = $row[CONFIG_AUCTION_INCR_BY_SEC];
	
	$paypal_api_username = $row[CONFIG_PAYPAL_API_USERNAME];
	$paypal_api_password = $row[CONFIG_PAYPAL_API_PASSWORD];
	$paypal_api_signature = $row[CONFIG_PAYPAL_API_SIGNATURE];
	$paypal_is_test_mode = $row[CONFIG_PAYPAL_IS_TEST_MODE];
	
	$sale_tax_ga = $row[CONFIG_SALE_TAX_GA];
	$sale_tax_nc = $row[CONFIG_SALE_TAX_NC];
	$marchant_fee = $row[MARCHANT_FEE];
	$mpe_charge = $row[MPE_CHARGE];
	$mpe_charge_weekly = $row[MPE_CHARGE_WEEKLY];
	$metaKeywords = $row[SITE_GLOBAL_DESCRIPTION];
 	$metaDescription = $row[SITE_GLOBAL_KEYWORDS];
 	$metaTags = $row[SITE_GLOBAL_METATAGS];
 	$peterEmail=$row['peter_email_id'];
 	$seanEmail=$row['sean_email_id'];
 	$bannerLink=stripslashes($row['banner_link']);
	$bannerTitle=stripslashes($row['banner_title']);
	$short_type=$row['short_type'];
	
	if($_REQUEST['adminName']!=""){
		$adminName = $_REQUEST['adminName'];
	}
	if($_REQUEST['adminEmail']!=""){
		$adminEmail = $_REQUEST['adminEmail'];
	}
	if($_REQUEST['pageTitle']!=""){
		$pageTitle = $_REQUEST['pageTitle'];
	}
	if($_REQUEST['welcomeText']!=""){
		$welcomeText = $_REQUEST['welcomeText'];
	}
	if($_REQUEST['instruction']!=""){
		$instruction = $_REQUEST['instruction'];
	}
	if($_REQUEST['copyRight']!=""){
		$copyRight = $_REQUEST['copyRight'];
	}
	
	$smarty->assign('adminName', $adminName);
	$smarty->assign('adminEmail', $adminEmail);
	$smarty->assign('pageTitle', $pageTitle);
	$smarty->assign('welcomeText', $welcomeText);
	$smarty->assign('instruction', $instruction);
	$smarty->assign('copyRight', $copyRight);
	$smarty->assign('auction_start_hour', $auction_start_hour);
	$smarty->assign('auction_start_min', $auction_start_min);
	$smarty->assign('auction_start_am_pm', $auction_start_am_pm);
	$smarty->assign('auction_end_hour', $auction_end_hour);
	$smarty->assign('auction_end_min', $auction_end_min);
	$smarty->assign('auction_end_am_pm', $auction_end_am_pm);
	$smarty->assign('auction_incr_min_span', $auction_incr_min_span);
	$smarty->assign('auction_incr_sec_span', $auction_incr_sec_span);
	$smarty->assign('auction_incr_by_min', $auction_incr_by_min);
	$smarty->assign('auction_incr_by_sec', $auction_incr_by_sec);
	
	$smarty->assign('paypal_api_username', $paypal_api_username);
	$smarty->assign('paypal_api_password', $paypal_api_password);
	$smarty->assign('paypal_api_signature', $paypal_api_signature);
	$smarty->assign('paypal_is_test_mode', $paypal_is_test_mode);
	
	$smarty->assign('sale_tax_ga', $sale_tax_ga);
	$smarty->assign('sale_tax_nc', $sale_tax_nc);
	$smarty->assign('marchant_fee', $marchant_fee);
	$smarty->assign('mpe_charge', $mpe_charge);
	$smarty->assign('mpe_charge_weekly', $mpe_charge_weekly);
	$smarty->assign('metaKeywords', $metaKeywords);
 	$smarty->assign('metaDescription', $metaDescription);
 	$smarty->assign('metaTags', $metaTags);
 	$smarty->assign('peterEmail', $peterEmail);
 	$smarty->assign('seanEmail', $seanEmail);
 	$smarty->assign('bannerLink', $bannerLink);
 	$smarty->assign('bannerTitle', $bannerTitle);
 	$smarty->assign('short_type', $short_type);
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display('admin_config_manager.tpl');
}
/**********    END of edit_content Function    *******************/

function checkValue(){
	$errCounter=0;
	if($_POST['adminName']==""){
		$GLOBALS['adminName_err']="Please enter administrator's name.";
		$errCounter++;
	}
	if($_POST['adminEmail']==""){
		$GLOBALS['adminEmail_err']="Please enter administrator's email.";
		$errCounter++;
	}else{
		$chkMail=checkEmail($_POST['adminEmail'], '');
		if($chkMail==true){
			$GLOBALS['adminEmail_err']="Please valid email ID.";
			$errCounter++;
		}
	}
	if($_POST['pageTitle']==""){
		$GLOBALS['pageTitle_err']="Please enter admin page title.";
		$errCounter++;
	}
	if($_POST['welcomeText']==""){
		$GLOBALS['welcomeText_err']="Please enter admin header text.";
		$errCounter++;
	}
	if($_POST['copyRight']==""){
		$GLOBALS['copyRight_err']="Please enter admin copyright text.";
		$errCounter++;
	}
	if($_POST['paypal_api_username']==""){
		$GLOBALS['paypal_api_username_err']="Please enter Paypal API Username.";
		$errCounter++;
	}
	if($_POST['paypal_api_password']==""){
		$GLOBALS['paypal_api_password_err']="Please enter Paypal API Password.";
		$errCounter++;
	}
	if($_POST['paypal_api_signature']==""){
		$GLOBALS['paypal_api_signature_err']="Please enter Paypal API Signature.";
		$errCounter++;
	}
	if($errCounter>0){
		return false;
	}else{
		return true;
	}
}

function save_content() {

	 $sql = "UPDATE ".CONFIG_TABLE." SET 
			".CONFIG_ADMIN_NAME."='".$_REQUEST['adminName']."', 
			".CONFIG_ADMIN_EMAIL."='".$_REQUEST['adminEmail']."', 
			".CONFIG_ADMIN_PAGE_TITLE."='".$_REQUEST['pageTitle']."', 
			".CONFIG_ADMIN_PAGE_WELCOMETEXT."='".$_REQUEST['welcomeText']."', 
			".CONFIG_ADMIN_INSTRUCTION."='".$_REQUEST['instruction']."', 
			".CONFIG_ADMIN_COPYRIGHT."='".$_REQUEST['copyRight']."',
			".CONFIG_AUCTION_START_HOUR."='".$_REQUEST['auction_start_hour']."',
			".CONFIG_AUCTION_START_MIN."='".$_REQUEST['auction_start_min']."',
			".CONFIG_AUCTION_START_AM_PM."='".$_REQUEST['auction_start_am_pm']."',
			".CONFIG_AUCTION_END_HOUR."='".$_REQUEST['auction_end_hour']."',
			".CONFIG_AUCTION_END_MIN."='".$_REQUEST['auction_end_min']."',
			".CONFIG_AUCTION_END_AM_PM."='".$_REQUEST['auction_end_am_pm']."',
			".CONFIG_AUCTION_INCR_MIN_SPAN."='".$_REQUEST['auction_incr_min_span']."',
			".CONFIG_AUCTION_INCR_SEC_SPAN."='".$_REQUEST['auction_incr_sec_span']."',
			".CONFIG_AUCTION_INCR_BY_MIN."='".$_REQUEST['auction_incr_by_min']."',
			".CONFIG_AUCTION_INCR_BY_SEC."='".$_REQUEST['auction_incr_by_sec']."',
			".CONFIG_PAYPAL_API_USERNAME."='".$_REQUEST['paypal_api_username']."',
			".CONFIG_PAYPAL_API_PASSWORD."='".$_REQUEST['paypal_api_password']."',
			".CONFIG_PAYPAL_API_SIGNATURE."='".$_REQUEST['paypal_api_signature']."',
			".CONFIG_PAYPAL_IS_TEST_MODE."='".$_REQUEST['paypal_is_test_mode']."',
			".CONFIG_SALE_TAX_GA."='".$_REQUEST['sale_tax_ga']."',
			".CONFIG_SALE_TAX_NC."='".$_REQUEST['sale_tax_nc']."',
			".MARCHANT_FEE."='".$_REQUEST['marchant_fee']."',
			".MPE_CHARGE."='".$_REQUEST['mpe_charge']."',
			".MPE_CHARGE_WEEKLY."='".$_REQUEST['mpe_charge_weekly']."',
			".SITE_GLOBAL_DESCRIPTION."='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['metaKeywords'])."',
   			".SITE_GLOBAL_KEYWORDS."='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['metaDescription'])."',
   			".SITE_GLOBAL_METATAGS."='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['metaTags'])."',
   			 peter_email_id='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['peterEmail'])."',
   			 sean_email_id='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['seanEmail'])."',
   			 banner_title = '".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['bannerTitle'])."',
			 banner_link = '".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['bannerLink'])."',
			 short_type = '".$_REQUEST['shortType']."',
			".STATUS."='1', 
			".UPDATE_DATE."=now(), 
			".POST_IP."='".$_SERVER['REMOTE_ADDR']."'";
	
	if(mysqli_query($GLOBALS['db_connect'],$sql)){
		//updatePendingAuctionsTime();
		$_SESSION['adminErr']="Configuration changed successfully.";
		redirect_admin("admin_config_manager.php");
	}
	else{
		$_SESSION['adminErr']="Configuration not changed successfully."; 
		redirect_admin("admin_config_manager.php");
	}
}

function updatePendingAuctionsTime()
{
	if($_REQUEST['auction_start_am_pm'] == 'pm'){
		$start_time = ($_REQUEST['auction_start_hour']+12).":".$_REQUEST['auction_start_min'].":00";
	}else{
		$start_time = ($_REQUEST['auction_start_hour']).":".$_REQUEST['auction_start_min'].":00";
	}
	
	if($_REQUEST['auction_end_am_pm'] == 'pm'){
		$end_time = ($_REQUEST['auction_end_hour']+12).":".$_REQUEST['auction_end_min'].":00";
	}else{
		$end_time = ($_REQUEST['auction_end_hour']).":".$_REQUEST['auction_end_min'].":00";
	}	

	$sql = "SELECT auction_id, auction_actual_start_datetime, auction_actual_end_datetime FROM ".TBL_AUCTION."
			WHERE (fk_auction_type_id = '2' AND auction_is_approved = '0')
			OR (fk_auction_type_id = '3' AND ((auction_is_approved = '0')
			OR (auction_is_approved = '1' AND is_approved_for_monthly_auction = '0'))";
	$rs = mysqli_query($GLOBALS['db_connect'],$sql);
	
	while($row = mysqli_fetch_array($rs)){
		list($date, $time) = explode(' ', $row['auction_actual_start_datetime']);
		$start_datetime = $date." ".$start_time;
		
		list($date, $time) = explode(' ', $row['auction_actual_end_datetime']);
		$end_datetime = $date." ".$end_time;
		
		$sql = "UPDATE ".TBL_AUCTION." SET
				auction_actual_start_datetime = '".$start_datetime."', auction_actual_end_datetime = '".$end_datetime."'
				WHERE auction_id = '".$row['auction_id']."'";
		mysqli_query($GLOBALS['db_connect'],$sql);		
	}
}
?>
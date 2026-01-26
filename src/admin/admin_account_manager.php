<?php
/**************************************************/
ob_start();

define ("PAGE_HEADER_TEXT", "Admin Manager Section");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}


if($_REQUEST['mode']=="change_password"){
	change_password();
}
elseif($_POST['mode'] == "save_password"){
	$chk = check_admin_password();
	if($chk == true){
		update_password();
	}
	else{
		change_password();
	}
}

elseif($_POST['mode'] == "save_change_profile"){
	$chk = checkProfileValue();
	if($chk == true){
		update_profile();
	}
	else{
		dispmiddle();
	}
}
elseif($_REQUEST['mode']=="createUser"){
	createUser();
}
elseif($_REQUEST['mode']=="createNewUser"){
	$chk=checkUser();
	if($chk==true){
		createNewUser();
	}
	else{
		createUser();
	}
}elseif($_REQUEST['mode']=="email_template"){
	email_template();
}elseif($_REQUEST['mode']=="email_template_item_specific"){
	email_template_item_specific();
}elseif($_REQUEST['mode']=="save_email_template_item_specific"){
	email_template_item_specific();
}elseif($_REQUEST['mode']=="save_email_template"){
	email_template();
}elseif($_REQUEST['mode']=="view_template_item_specific"){
	view_template_item_specific();
}elseif($_REQUEST['mode']=="view_template"){
	view_template();
}elseif($_REQUEST['mode']=="home_template"){
	home_template();
}elseif($_REQUEST['mode']=="save_home_template"){
	home_template();
}elseif($_REQUEST['mode']=="save_calender_template"){
	save_calender_template();
}elseif($_REQUEST['mode']=="calender_template"){
	calender_template();
}elseif($_REQUEST['mode']=="blacklist"){
	blacklist();
}elseif($_REQUEST['mode']=="save_blacklist"){
	save_blacklist();
}elseif($_REQUEST['mode']=="viewBlacklistHistory"){
	viewBlacklistHistory();
}elseif($_REQUEST['mode']=="shipping"){
	shippingCollection();
}
else{
	dispmiddle();  
}
ob_end_flush();
/*************************************************/



/////      Start of Middle function  //////
function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$obj = new AdminUser;
	$obj->adminID = $_SESSION['adminLoginID'];
	$row = $obj->fetchAdminDetails();

	$smarty->assign('first_name', trim($_POST['first_name'])!=""?escape($_POST['first_name']):$row[ADMIN_FIRST_NAME]);
	$smarty->assign('middle_name', trim($_POST['middle_name'])!=""?escape($_POST['middle_name']):$row[ADMIN_MIDDLE_NAME]);
	$smarty->assign('last_name', trim($_POST['last_name'])!=""?escape($_POST['last_name']):$row[ADMIN_LAST_NAME]);
	$smarty->assign('email', trim($_POST['email'])!=""?escape($_POST['email']):$row[ADMIN_EMAIL]);
	$smarty->assign('cemail', trim($_POST['cemail'])!=""?escape($_POST['cemail']):$row[ADMIN_EMAIL]);
	
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_profile_manager.tpl");
}



function checkProfileValue(){
	$errCounter=0;
	
	if(trim($_POST['first_name'])==""){
		$errCounter++;
		$GLOBALS['first_name_err'] = "Please enter your first name.";
	}
	if(trim($_POST['last_name'])==""){
		$errCounter++;
		$GLOBALS['last_name_err'] = "Please enter your last name.";
	}
	if(trim($_POST['email'])==""){
		$errCounter++;
		$GLOBALS['email_err'] = "Please enter your email.";
	}
	else{
		$chkMail=checkEmail($_POST['email'], '');
		if($chkMail==true){
			$GLOBALS['email_err'] = "Please enter valid email address.";
			$errCounter++;
		}
	}
	if(trim($_POST['cemail'])==""){
		$errCounter++;
		$GLOBALS['cemail_err'] = "Please enter your email address in confirm box.";
	}
	else{
		$chkMail=checkEmail($_POST['cemail'], '');
		if($chkMail==true){
			$GLOBALS['cemail_err'] = "Please enter valid email address in confirm box.";
			$errCounter++;
		}
	}
	if(trim($_POST['cemail'])!=trim($_POST['email'])){
		$errCounter++;
		$GLOBALS['cemail_err'] = "Please enter same email address in confirm box.";
	}
	else{
		$obj = new AdminUser;
		$obj->adminID = $_SESSION['adminLoginID'];
		$obj->adminEmail = $_POST['email'];
		$chk = $obj->checkAdminEmail();
		if($chk == true){
			$errCounter++;
			$GLOBALS['email_err'] = "This email address already exists.";
		}
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}



function update_profile(){
	$obj = new AdminUser;
	$obj->adminID = $_SESSION['adminLoginID'];
	$obj->adminFirstName = trim($_POST['first_name']);
	$obj->adminMiddleName = trim($_POST['middle_name']);
	$obj->adminLastName = trim($_POST['last_name']);
	$obj->adminEmail = trim($_POST['email']);
	$_SESSION['administratorNames']=$_POST['first_name']." ".$_POST['middle_name']." ".$_POST['last_name'];
	$chk = $obj->updateAdminProfile();
	if($chk == true){
		//echo "1";
		$_SESSION['adminErr'] = "Your profile has been updated successfully.";
		redirect_admin("admin_account_manager.php");
	}
	else{
		//echo "2";
		$_SESSION['adminErr'] = "Your profile not updated successfully.";
		redirect_admin("admin_account_manager.php");
	}
}
	
	
function change_password(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
	}
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}
	
	$smarty->display("admin_change_password_manager.tpl");
}


function check_admin_password(){
	$errCounter=0;
	
	if(trim($_POST['oldpassword'])==""){
		$errCounter++;
		$GLOBALS['oldpassword_err'] = "Please enter your old password.";
	}
	else{
		$obj = new AdminUser;
		$obj->adminID = $_SESSION['adminLoginID'];
		$obj->adminPassword = $_POST['oldpassword'];
		$chk = $obj->checkAdminPassword();
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



function update_password(){
	$obj = new AdminUser;
	$obj->adminID = $_SESSION['adminLoginID'];
	$obj->adminPassword = trim($_POST['newpassword']);
	
	$chk = $obj->updateAdminPassword();
	if($chk == true){
		$_SESSION['adminErr'] = "Your password has been updated successfully.";
		redirect_admin("admin_account_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Your password not updated successfully.";
		redirect_admin("admin_account_manager.php");
	}
}
	
	
	
	
function createUser() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign('new_login', htmlentities(trim(stripslashes($_POST['new_login']))));
	
	$smarty->display("admin_create_manager.tpl");
}
	
	


function changePassword(){
	$oldpassword=$_POST['oldpassword'];
	$newpassword=$_POST['newpassword'];
	$cnewpassword=$_POST['cnewpassword'];
	
	if($newpassword!=$cnewpassword){
		$_SESSION['adminErr']="You have to enter same password in confirm password field.";
		redirect_admin("admin_account_manager.php");
	}
	else{
		$passChk=new AdminUser();
		$chkOld=$passChk->checkOldPassword($oldpassword);
		if($chkOld==true){
			$passChk->changePassword($newpassword);
			$_SESSION['adminErr']="The password has been updated successfully.";
			redirect_admin("admin_account_manager.php");
		}
		else{
			$_SESSION['adminErr']="The old password is not correct.";
			redirect_admin("admin_account_manager.php");
		}		
	}
}




function checkUser(){
	$errCounter=0;
	
	if($_POST['new_login']==""){
		$errCounter++;
		$_SESSION['adminErr']="Please enter user ID.";
	}
	if($_POST['new_password']==""){
		$errCounter++;
		$_SESSION['adminErr']="Please enter password.";
	}
	if($_POST['cnew_password']==""){
		$errCounter++;
		$_SESSION['adminErr']="Please enter confirm password.";
	}
	if($_POST['cnew_password']!=$_POST['new_password']){
		$errCounter++;
		$_SESSION['adminErr']="Please enter same password in confirm password.";
	}
	if($_POST['new_login']!=""){
		$checkUser=new AdminUser();
		$chkUser=$checkUser->checkUser($_POST['new_login']);
		if($chkUser==true){
			$_SESSION['adminErr']="Please change the user ID.";
			$errCounter++;
		}
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}


function createNewUser(){
	$new_login=$_POST['new_login'];
	$newpassword=$_POST['new_password'];
	$cnewpassword=$_POST['cnew_password'];
	
	$createUser=new AdminUser();
	$chkUser=$createUser->checkUser($new_login);
	
	$createUser=new AdminUser();
	$chk=$createUser->newUser($new_login, $newpassword);
	if($chk==true){
		$_SESSION['adminErr']="One admin manager has been added successfully.";
		redirect_admin("admin_account_manager.php");
	}
	else{
		$_SESSION['adminErr']="There is some problem. Please try again.";
		redirect_admin("admin_account_manager.php");
	}
}
function email_template(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
		if(isset($_REQUEST['first_name1']) && $_REQUEST['first_name1']!=''){
		    $auction_ids = $_REQUEST['first_name1'].','.$_REQUEST['first_name2'].','.$_REQUEST['first_name3'].','.$_REQUEST['first_name4'];
		 	$sql= "UPDATE tbl_email_temp SET auction_id='".$auction_ids."',banner_text='".$_REQUEST['banner_text']."',fixed_text='".$_REQUEST['fixed_text']."',title= '".$_REQUEST['title']."',is_auction='".$_REQUEST['is_auction']."' WHERE temp_id=1 ";
		 	$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		 }
		 $sqlTemp = "Select * from tbl_email_temp WHERE temp_id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);
		 $rowtempArr = explode(',',$rowtemp['auction_id']);	
		 $auctionIds1 = $rowtempArr[0].",".	$rowtempArr[1].",".$rowtempArr[2].",".$rowtempArr[3];
		 $auctionIds2 = $rowtempArr[4].",".	$rowtempArr[5].",".$rowtempArr[6].",".$rowtempArr[7];
		 $auctionIds3 = $rowtempArr[8].",".	$rowtempArr[9].",".$rowtempArr[10].",".$rowtempArr[11];
		 $auctionIds4 = $rowtempArr[12].",".$rowtempArr[13].",".$rowtempArr[14].",".$rowtempArr[15];
		$smarty->assign('auction_ids1', $auctionIds1);
		$smarty->assign('auction_ids2', $auctionIds2);
		$smarty->assign('auction_ids3', $auctionIds3);
		$smarty->assign('auction_ids4', $auctionIds4);
		$smarty->assign('banner_text', $rowtemp['banner_text']);
		$smarty->assign('fixed_text', $rowtemp['fixed_text']);
		$smarty->assign('title', $rowtemp['title']);
		$smarty->assign('is_auction', $rowtemp['is_auction']);
		$smarty->display("admin_email_template.tpl");
	}
	function home_template(){		
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Home Page Manager");
		if(isset($_REQUEST['first_name']) && $_REQUEST['first_name']!=''){
		 	$sql= "UPDATE admin_home_cms SET home_auction_id='".$_REQUEST['first_name']."',home_text='".trim(addslashes($_REQUEST['banner_text']))."',home_link='".$_REQUEST['fixed_text']."',is_auction= '".$_REQUEST['is_auction']."' WHERE home_temp_id=1 ";
		 	$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		 }
		 $sqlTemp = "Select * from admin_home_cms WHERE home_temp_id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('auction_ids', $rowtemp['home_auction_id']);
		$smarty->assign('banner_text', strip_slashes($rowtemp['home_text']));
		$smarty->assign('fixed_text', $rowtemp['home_link']);
		$smarty->assign('is_auction', $rowtemp['is_auction']);
		$smarty->display("admin_home_template.tpl");	
	}
	function email_template_item_specific(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
		if(isset($_REQUEST['first_name']) && $_REQUEST['first_name']!=''){
		 	$sql= "UPDATE tbl_email_temp_item_specific SET auction_id='".$_REQUEST['first_name']."',text_main='".trim(addslashes($_REQUEST['banner_text']))."',link_main='".$_REQUEST['banner_link']."',text_sub= '".trim(addslashes($_REQUEST['fixed_text']))."',link_sub= '".$_REQUEST['second_banner_link']."',title= '".$_REQUEST['title']."',is_auction= '".$_REQUEST['is_auction']."' WHERE item_specific_temp_id=1 ";
		 	$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		 }
		 $sqlTemp = "Select * from tbl_email_temp_item_specific WHERE item_specific_temp_id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('auction_id', $rowtemp['auction_id']);
		$smarty->assign('banner_text', strip_slashes($rowtemp['text_main']));
		$smarty->assign('fixed_text', strip_slashes($rowtemp['text_sub']));
		$smarty->assign('banner_link', $rowtemp['link_main']);
		$smarty->assign('second_banner_link', $rowtemp['link_sub']);
		$smarty->assign('title', $rowtemp['title']);
		$smarty->assign('is_auction', $rowtemp['is_auction']);
		$smarty->display("admin_email_template_item_specific.tpl");
	}
	function view_template_item_specific(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$sqlTemp = "Select * from tbl_email_temp_item_specific  WHERE item_specific_temp_id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);
		 if($rowtemp['is_auction']==1){
		 	$sql="Select p.poster_title,tpi.poster_thumb , p.poster_desc ,tpi.is_cloud
			  FROM tbl_auction_live a,tbl_poster_live p, tbl_poster_images_live tpi
			   WHERE a.auction_id= '".$rowtemp['auction_id']."'
			   AND a.fk_poster_id=p.poster_id
			   AND tpi.fk_poster_id = a.fk_poster_id
			   AND tpi.is_default='1' ";
		 }else{
		 	$sql="Select p.poster_title,tpi.poster_thumb , p.poster_desc ,tpi.is_cloud
			  FROM tbl_auction a,tbl_poster p, tbl_poster_images tpi
			   WHERE a.auction_id= '".$rowtemp['auction_id']."'
			   AND a.fk_poster_id=p.poster_id
			   AND tpi.fk_poster_id = a.fk_poster_id
			   AND tpi.is_default='1' ";
		 }
		 
			   
		$res_sql =	mysqli_query($GLOBALS['db_connect'],$sql);
		$row=mysqli_fetch_array($res_sql);
		if($row['is_cloud']==1){
			$smarty->assign('image_path', CLOUD_POSTER_THUMB_BIG_GALLERY.$row['poster_thumb']);
		}else{
			$smarty->assign('image_path', "http://".$_SERVER['HTTP_HOST']."/poster_photo/".$row['poster_thumb']);
		}
		$smarty->assign('auction_id', $rowtemp['auction_id']);
		$smarty->assign('poster_title', $row['poster_title']);
		$smarty->assign('poster_thumb', $row['poster_thumb']);
		$smarty->assign('poster_desc', $row['poster_desc']);
		$smarty->assign('banner_text', $rowtemp['text_main']);
		$smarty->assign('sub_banner_text', $rowtemp['text_sub']);
		$smarty->assign('banner_link', $rowtemp['link_main']);
		$smarty->assign('sub_banner_link', $rowtemp['link_sub']);	
		$smarty->assign('title', $rowtemp['title']);
		$smarty->assign('is_auction', $rowtemp['is_auction']);
		
		$smarty->display("admin_email_temp_item_specific.tpl");
		
	}
	function calender_template(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Upcoming Auction Calender");
		
		 $sqlTemp = "Select * from  tbl_auction_calender WHERE id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('upcoming_1', $rowtemp['auction_1']);
		$smarty->assign('upcoming_2', $rowtemp['auction_2']);
		$smarty->assign('upcoming_3', $rowtemp['auction_3']);
		$smarty->assign('upcoming_4', $rowtemp['auction_4']);
		$smarty->assign('upcoming_5', $rowtemp['auction_5']);
		$smarty->assign('upcoming_link_1', $rowtemp['auction_1_link']);
		$smarty->assign('upcoming_link_2', $rowtemp['auction_2_link']);
		$smarty->assign('upcoming_link_3', $rowtemp['auction_3_link']);
		$smarty->assign('upcoming_link_4', $rowtemp['auction_4_link']);
		$smarty->assign('upcoming_link_5', $rowtemp['auction_5_link']);
		$smarty->display("admin_calender_template.tpl");
	}
	function save_calender_template(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		
		 	$sql= "UPDATE  tbl_auction_calender SET auction_1='".$_REQUEST['upcoming_1']."',auction_2='".$_REQUEST['upcoming_2']."',
					auction_3='".$_REQUEST['upcoming_3']."',auction_4= '".$_REQUEST['upcoming_4']."',auction_5= '".$_REQUEST['upcoming_5']."',
					auction_1_link='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['upcoming_link_1'])."',auction_2_link='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['upcoming_link_2'])."',
					auction_3_link='".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['upcoming_link_3'])."',auction_4_link= '".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['upcoming_link_4'])."',auction_4_link= '".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['upcoming_link_5'])."'
					WHERE id=1 ";
			//echo $sql;
			//exit();
		 	$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		 
		 $sqlTemp = "Select * from  tbl_auction_calender WHERE id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('upcoming_1', $rowtemp['auction_1']);
		$smarty->assign('upcoming_2', $rowtemp['auction_2']);
		$smarty->assign('upcoming_3', $rowtemp['auction_3']);
		$smarty->assign('upcoming_4', $rowtemp['auction_4']);
		$smarty->assign('upcoming_5', $rowtemp['auction_5']);
		$smarty->assign('upcoming_link_1', $rowtemp['auction_1_link']);
		$smarty->assign('upcoming_link_2', $rowtemp['auction_2_link']);
		$smarty->assign('upcoming_link_3', $rowtemp['auction_3_link']);
		$smarty->assign('upcoming_link_4', $rowtemp['auction_4_link']);
		$smarty->assign('upcoming_link_5', $rowtemp['auction_5_link']);
		$smarty->display("admin_calender_template.tpl");
	}
	
	function blacklist(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Balcklist Section");
		$sql_max = "Select max(idtbl_blacklist) maxid from tbl_blacklist ";
		$resMaxSql= mysqli_query($GLOBALS['db_connect'],$sql_max);
		$rowMaxtemp= mysqli_fetch_array($resMaxSql);		
		$maxID= $rowMaxtemp['maxid'];
		$sqlTemp = "Select * from  tbl_blacklist WHERE idtbl_blacklist= ".$maxID;
		$ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		$rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('domain', $rowtemp['domain']);
		$smarty->assign('firstname', $rowtemp['firstname']);
		$smarty->assign('lastname', $rowtemp['lastname']);
		$smarty->assign('email', $rowtemp['email']);
		$smarty->display("admin_blacklist_template.tpl");
	}
	
	function save_blacklist(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		
			$sql_max = "Select max(idtbl_blacklist) maxid from tbl_blacklist ";
			$resMaxSql= mysqli_query($GLOBALS['db_connect'],$sql_max);
			$rowMaxtemp= mysqli_fetch_array($resMaxSql);		
			$maxID= $rowMaxtemp['maxid']+1;
		
		 	/*$sql= "UPDATE  tbl_blacklist SET domain='".$_REQUEST['domain']."',firstname='".$_REQUEST['firstname']."',lastname='".$_REQUEST['lastname']."',email= '".$_REQUEST['email']."'  WHERE idtbl_blacklist=1 ";
		 	$resSql= mysqli_query($GLOBALS['db_connect'],$sql);*/
			
			$sql= "Insert into tbl_blacklist (idtbl_blacklist,domain,firstname,lastname,email) values (".$maxID.",'".$_REQUEST['domain']."','".$_REQUEST['firstname']."','".$_REQUEST['lastname']."','".$_REQUEST['email']."')";
			$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		 
		$sqlTemp = "Select * from tbl_blacklist WHERE idtbl_blacklist= ".$maxID;
		$ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		$rowtemp= mysqli_fetch_array($ressql);		
		$smarty->assign('domain', $rowtemp['domain']);
		$smarty->assign('firstname', $rowtemp['firstname']);
		$smarty->assign('lastname', $rowtemp['lastname']);
		$smarty->assign('email', $rowtemp['email']);
		$smarty->display("admin_blacklist_template.tpl");
	}
	
	function viewBlacklistHistory(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$sql_max = "Select max(idtbl_blacklist) maxid from tbl_blacklist ";
		$resMaxSql= mysqli_query($GLOBALS['db_connect'],$sql_max);
		$rowMaxtemp= mysqli_fetch_array($resMaxSql);		
		$maxID= $rowMaxtemp['maxid'];
		$sqlTemp = "Select * from  tbl_blacklist WHERE idtbl_blacklist< ".$maxID;
		$ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		while($row = mysqli_fetch_array($ressql)){
			$dataArr[] = $row;
		}
		$smarty->assign('data', $dataArr);
		$smarty->display("admin_blacklist_template_hist.tpl");
	}
	
	function shippingCollection(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$sqlInv = "SELECT additional_charges,discounts FROM ".TBL_INVOICE." inv WHERE inv.invoice_generated_on > '2018-01-01 00:00:00' and inv.is_paid='1' ";
			$i=0;
			if($rs = mysqli_query($GLOBALS['db_connect'],$sqlInv)){
				while($invoiceData = mysqli_fetch_assoc($rs)){
					
					$charges = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['additional_charges']);
					$charges = unserialize($charges);
					if(!empty($charges)){
						foreach($charges as $key => $value){
							//$newinvoiceCharge[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['additional_charges'][$key]['description']), 'amount' => $invoiceData['additional_charges'][$key]['amount']);
							//$charges[$key]['amount'];							
							$subTotal += $charges[$key]['amount'];
							
						}
					}					
					$i++;
				}
			}
		$smarty->assign('total', $subTotal);
		$smarty->display("admin_shipping_collection.tpl");
	}
?>
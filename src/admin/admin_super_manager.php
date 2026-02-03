<?php

/**************************************************/
ob_start();

define ("PAGE_HEADER_TEXT", "Account Manager Section");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}
redirect_admin("admin_account_manager.php");

if(($_REQUEST["order_by"] ?? '')!="") {
	$GLOBALS["order_by"] = $_REQUEST["order_by"];
}
else {
	$GLOBALS["order_by"] = STATUS;
}

$mode = $_REQUEST['mode'] ?? '';
if($mode=="change_password"){
	change_password();
}
elseif(($_POST['mode'] ?? '') == "save_password"){
	$chk = check_admin_password();
	if($chk == true){
		update_password();
	}
	else{
		change_password();
	}
}elseif($mode == "change_profile"){
	change_profile();
}elseif(($_POST['mode'] ?? '') == "save_change_profile"){
	$chk = checkProfileValue();
	if($chk == true){
		update_profile();
	}else{
		change_profile();
	}
}elseif($mode=="create_user"){
	create_user();
}elseif($mode=="createNewUser"){
	$chk=checkUser();
	if($chk==true){
		createNewUser();
	}else{
		create_user();
	}
}elseif($mode=="edit_user"){
	edit_user();
}elseif($mode=="updateUser"){
	$chk=checkUpdateUser();
	if($chk==true){
		updateUser();
	}else{
		edit_user();
	}
}elseif($mode=="delete_user"){
	delete_user();
}elseif($mode=="change_access"){
	change_access();
}elseif($mode=="saveChangeAccess"){
	saveChangeAccess();
}elseif($mode=="set_active_all"){
	set_active_all();
}elseif($mode=="set_inactive_all"){
	set_inactive_all();
}elseif($mode=="delete_all"){
	delete_all();
}else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/



function dispmiddle(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$obj = new AdminUser;
	$obj->ownID = $_SESSION['adminLoginID'];
	$total = $obj->totalAdminUser();
	
	if($total>0){
		$smarty->assign('userNameTXT', orderBy("Administrator's Name", ADMIN_FIRST_NAME.", ".ADMIN_MIDDLE_NAME.", ".ADMIN_LAST_NAME, 1, "toplink"));
		$smarty->assign('userEmailTXT', orderBy("Administrator's Email", ADMIN_EMAIL, 1, "toplink"));
		$smarty->assign('statusTXT', orderBy("Administrator's Status", STATUS, 1, "toplink"));
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		$row = $obj->fetchAllAdministrator();
		$row = $row ?? [];
		for($n=0; $n<count($row); $n++){
			$userID[] = $row[$n][ADMIN_ID];
			$obj->adminID = $row[$n][ADMIN_ID];
			$obj->superAdmin = 1;
			$superAdminStatus[] = $obj->checkSuperAdmin();
			$userName[] = $row[$n][ADMIN_FIRST_NAME]." ".$row[$n][ADMIN_MIDDLE_NAME]." ".$row[$n][ADMIN_LAST_NAME];
			$userEmail[] = $row[$n][ADMIN_EMAIL];
			$blockReason[] = $row[$n][ADMIN_BLOCK_REASON];
			if($row[$n][ADMIN_LOGIN_TRY]>=3 || $row[$n][STATUS] == 0){
				$adminStatus[] = "Inactive";
			}
			else{
				$adminStatus[] = "Active";
			}
		}
		$smarty->assign('userID', $userID);
		$smarty->assign('superAdminStatus', $superAdminStatus);
		$smarty->assign('userName', $userName);
		$smarty->assign('userEmail', $userEmail);
		$smarty->assign('adminStatus', $adminStatus);
		$smarty->assign('blockReason', $blockReason);
		
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	
	$smarty->display("admin_manager.tpl");
}


function change_access(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$obj = new AdminUser;
	$obj->adminID = $_REQUEST['admin_id'] ?? '';
	//$obj->createPageList();

	$rowUser = $obj->fetchAdminDetails();
	$userEmail = $rowUser[ADMIN_EMAIL];
	$userName = $rowUser[ADMIN_FIRST_NAME].' '.$rowUser[ADMIN_MIDDLE_NAME].' '.$rowUser[ADMIN_LAST_NAME];
	
	$rowSection = $obj->fetchAdminSection();
	$rowSection = $rowSection ?? [];
	for($n=0; $n<count($rowSection); $n++){
		$sectionID[] = $rowSection[$n][ADMIN_SECTION_ID];
		$sectionName[] = $rowSection[$n][ADMIN_SECTION_NAME];
		$sectionDesc[] = $rowSection[$n][ADMIN_SECTION_DESCRIPTION];
	}
	
	$obj->superAdmin = 1;
	$chkSuperAdmin = $obj->checkSuperAdmin();
	$rowAccesss = $obj->fetchAccessedSection();
	$rowAccesss = $rowAccesss ?? [];
	if($chkSuperAdmin == 1 && SUPER_ADMIN_CREATION == true && count($rowAccesss) == 0){
		for($n=0; $n<count($sectionID); $n++){
			$selectedSection[] = $sectionID[$n];
		}
	}
	else{
		$rowAccesss = $obj->fetchAccessedSection();
		for($n=0; $n<count($rowAccesss); $n++){
			$selectedSection[] = $rowAccesss[$n][ADMIN_SECTION_ID];
		}
	}
	
	$smarty->assign('admin_id', $_REQUEST['admin_id'] ?? '');

	$smarty->assign('sectionID', $sectionID);
	$smarty->assign('sectionName', $sectionName);
	$smarty->assign('sectionDesc', $sectionDesc);
	$smarty->assign('selectedSection', $selectedSection);
	
	$smarty->assign('administratorName', $userName);
	$smarty->assign('administratorEmail', $userEmail);
	
	$smarty->display("admin_change_access_manager.tpl");
}



function saveChangeAccess(){
	$obj = new AdminUser;
	$obj->adminID = $_POST['admin_id'];
	$obj->accessSectionList = $_POST['sections'];
	$chk = $obj->setAdminAccess();
	if($chk == true){
		$_SESSION['adminErr'] = "The Administrator's access has been updates successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "The Administrator's access has not been updates successfully.";
		redirect_admin("admin_super_manager.php");
	}
}


function create_user(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, escape($value)); 
	}
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}
	
	$smarty->display("admin_create_user_manager.tpl");
}


function checkUser(){
	$errCounter=0;
	if(trim($_POST['user_name'])==""){
		$errCounter++;
		$GLOBALS['user_name_err'] = "Please enter your username.";
	}
	else{
		$obj = new AdminUser;
		$obj->adminLoginName = $_POST['user_name'];
		if($_POST['admin_id']!=""){
			$obj->adminID = $_POST['admin_id'];
		}
		$chk = $obj->checkAdminUserName();
		if($chk == true){
			$errCounter++;
			$GLOBALS['user_name_err'] = "Sorry! This username already exists.";
		}
	}
	if(trim($_POST['password'])==""){
		$errCounter++;
		$GLOBALS['password_err'] = "Please enter password.";
	}
	if(trim($_POST['cpassword'])==""){
		$errCounter++;
		$GLOBALS['cpassword_err'] = "Please enter password in confirm box.";
	}
	if(trim($_POST['cpassword'])!=trim($_POST['password'])){
		$errCounter++;
		$GLOBALS['cpassword_err'] = "Please enter same password in confirm box.";
	}
	if(trim($_POST['first_name'])==""){
		$errCounter++;
		$GLOBALS['first_name_err'] = "Please enter your first name.";
	}
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
		$obj->adminEmail = $_POST['email'];
		if($_POST['admin_id']!=""){
			$obj->adminID = $_POST['admin_id'];
		}
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



function createNewUser(){
	$obj = new AdminUser;
	$obj->adminLoginName = trim($_POST['user_name']);
	$obj->adminPassword = trim($_POST['password']);
	$obj->adminFirstName = trim($_POST['first_name']);
	$obj->adminMiddleName = trim($_POST['middle_name']);
	$obj->adminLastName = trim($_POST['last_name']);
	$obj->adminEmail = trim($_POST['email']);
	
	$chk = $obj->addAdminProfile();
	if($chk == true){
		$_SESSION['adminErr'] = "An administrator has been added successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "The administrator not added successfully.";
		redirect_admin("admin_super_manager.php");
	}
}


function edit_user(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign('admin_id', $_REQUEST['admin_id'] ?? '');

	$obj = new AdminUser();
	$obj->adminID = $_REQUEST['admin_id'] ?? '';
	$row = $obj->fetchAdminDetails();
	
	$smarty->assign('user_name', trim($_POST['user_name'])!=""?escape($_POST['user_name']):$row[ADMIN_LOGIN_NAME]);
	$smarty->assign('first_name', trim($_POST['first_name'])!=""?escape($_POST['first_name']):$row[ADMIN_FIRST_NAME]);
	$smarty->assign('middle_name', trim($_POST['middle_name'])!=""?escape($_POST['middle_name']):$row[ADMIN_MIDDLE_NAME]);
	$smarty->assign('last_name', trim($_POST['last_name'])!=""?escape($_POST['last_name']):$row[ADMIN_LAST_NAME]);
	$smarty->assign('email', trim($_POST['email'])!=""?escape($_POST['email']):$row[ADMIN_EMAIL]);
	$smarty->assign('cemail', trim($_POST['cemail'])!=""?escape($_POST['cemail']):$row[ADMIN_EMAIL]);
	
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}
	
	$smarty->display("admin_update_user_manager.tpl");
}




function checkUpdateUser(){
	$errCounter=0;
	if(trim($_POST['first_name'])==""){
		$errCounter++;
		$GLOBALS['first_name_err'] = "Please enter your first name.";
	}
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
		$obj->adminEmail = $_POST['email'];
		if($_POST['admin_id']!=""){
			$obj->adminID = $_POST['admin_id'];
		}
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


function updateUser(){
	$obj = new AdminUser;
	$obj->adminID = $_POST['admin_id'];
	$obj->adminFirstName = trim($_POST['first_name']);
	$obj->adminMiddleName = trim($_POST['middle_name']);
	$obj->adminLastName = trim($_POST['last_name']);
	$obj->adminEmail = trim($_POST['email']);
	
	$chk = $obj->updateAdminProfile();
	if($chk == true){
		$_SESSION['adminErr'] = "Administrator's profile has been updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Administrator's profile not updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
}


/////      Start of Middle function  //////
function change_profile() {
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
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
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
	
	$chk = $obj->updateAdminProfile();
	if($chk == true){
		$_SESSION['adminErr'] = "Your profile has been updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Your profile not updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
}
	
	
function change_password(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	if(($_REQUEST['admin_id'] ?? '')!=""){
		$smarty->assign('admin_id', $_REQUEST['admin_id']);
	}
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
	}
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
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
		if($_POST['admin_id']!=""){
			$obj->adminID = $_POST['admin_id'];
		}
		else{
			$obj->adminID = $_SESSION['adminLoginID'];
		}
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
	if($_POST['admin_id']!=""){
		$obj->adminID = $_POST['admin_id'];
	}
	else{
		$obj->adminID = $_SESSION['adminLoginID'];
	}
	$obj->adminPassword = trim($_POST['newpassword']);
	
	$chk = $obj->updateAdminPassword();
	if($chk == true){
		$_SESSION['adminErr'] = "Your password has been updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Your password not updated successfully.";
		redirect_admin("admin_super_manager.php");
	}
}
	


function delete_user(){
	$obj = new AdminUser;
	$obj->adminID = $_REQUEST['admin_id'] ?? '';

	$chk = $obj->deleteAdministrator();
	
	if($chk == true){
		$_SESSION['adminErr'] = "The Administrator has been deleted successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "The Administrator has not been deleted successfully.";
		redirect_admin("admin_super_manager.php");
	}
}	
	

function set_active_all(){
	$flag = 1;
	$obj = new AdminUser;
	foreach($_POST['admin_ids'] as $val){
		$obj->adminID = $val;
		$chk = $obj->setActive();
		if($chk == false){
			$flag = 0;
		}
	}
	
	if($flag == 1){
		$_SESSION['adminErr'] = "Selected Administrator has been activated successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Selected Administrator has not been activated successfully.";
		redirect_admin("admin_super_manager.php");
	}
}



function set_inactive_all(){
	$flag = 1;
	$obj = new AdminUser;
	foreach($_POST['admin_ids'] as $val){
		$obj->adminID = $val;
		$chk = $obj->setInactive();
		if($chk == false){
			$flag = 0;
		}
	}
	
	if($flag == 1){
		$_SESSION['adminErr'] = "Selected Administrator has been inactivated successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Selected Administrator has not been inactivated successfully.";
		redirect_admin("admin_super_manager.php");
	}
}


function delete_all(){
	$flag = 1;
	$obj = new AdminUser;
	foreach($_POST['admin_ids'] as $val){
		$obj->adminID = $val;
		$chk = $obj->deleteAdministrator();
		if($chk == false){
			$flag = 0;
		}
	}
	
	if($flag == 1){
		$_SESSION['adminErr'] = "Selected Administrator has been deleted successfully.";
		redirect_admin("admin_super_manager.php");
	}
	else{
		$_SESSION['adminErr'] = "Selected Administrator has not been deleted successfully.";
		redirect_admin("admin_super_manager.php");
	}
}


?>
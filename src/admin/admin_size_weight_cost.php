<?php

ob_start();
define ("PAGE_HEADER_TEXT", "SIZE WEIGHT COST MASTER");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';
if($mode == "edit_size"){
	edit_size();
}elseif($mode == "add_size"){
	add_size();
}elseif($mode == "save_size"){
	$chk = validateSaveForm();
	if($chk == true){
		save_size();
	}else{
		add_size();
	}
}elseif($mode == "update_size"){
	$chk = validateForm();
	if($chk == true){
		update_size();
	}else{
		edit_size();
	}
}elseif($mode == "delete_size"){
	delete_size();
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
	$categoryObject = new Category();
	$categoryObject->primaryKey='size_weight_cost_id';
	$total = $categoryObject->countData(TBL_SIZE_WEIGHT_COST_MASTER);
	$sizeRow=$categoryObject->selectData(TBL_SIZE_WEIGHT_COST_MASTER);
	$smarty->assign('total', $total);
	$smarty->assign('sizeRow', $sizeRow);
	//print_r($sizeRow);
	$smarty->display("admin_size_weight_cost_listing.tpl");
}

function edit_size() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$objCategory = new Category;
	$where=array('size_weight_cost_id'=>$_REQUEST['size_id'] ?? '');
	$rowSize = $objCategory->selectData(TBL_SIZE_WEIGHT_COST_MASTER,array('*'),$where);
	$smarty->assign ("rowSize", $rowSize);	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}
	$smarty->display('admin_size_weight_cost_edit.tpl');
}

function validateForm()
{
	$errCounter = 0;
	$obj = new User();

	if(($_REQUEST['name'] ?? '') == ""){
		$GLOBALS['name_err'] = "Please enter Name.";
		$errCounter++;
	}
	if(($_REQUEST['length'] ?? '') == ""){
		$GLOBALS['length_err'] = "Please enter Length.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['length'] ?? '')){
		$GLOBALS['length_err'] = "Please enter Numeric Length.";
		$errCounter++;
	}
	if(($_REQUEST['width'] ?? '') == ""){
		$GLOBALS['width_err'] = "Please enter Width.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['width'] ?? '')){
		$GLOBALS['width_err'] = "Please enter Numeric Width.";
		$errCounter++;
	}
	if(($_REQUEST['height'] ?? '') == ""){
		$GLOBALS['height_err'] = "Please enter Height.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['height'] ?? '')){
		$GLOBALS['height_err'] = "Please enter Numeric Height.";
		$errCounter++;
	}
	if(($_REQUEST['weight_lb'] ?? '') == ""){
		$GLOBALS['weight_lb_err'] = "Please enter Weight in LB.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['weight_lb'] ?? '')){
		$GLOBALS['weight_lb_err'] = "Please enter Numeric Weight in LB.";
		$errCounter++;
	}
     if(($_REQUEST['weight_oz'] ?? '') == ""){
		$GLOBALS['weight_oz_err'] = "Please enter Weight in OZ.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['weight_oz'] ?? '')){
		$GLOBALS['weight_oz_err'] = "Please enter Numeric Weight in OZ.";
		$errCounter++;
	}
	 if(($_REQUEST['packaging_cost'] ?? '') == ""){
		$GLOBALS['packaging_cost_err'] = "Please enter Packaging Cost.";
		$errCounter++;
	}elseif(!is_numeric($_REQUEST['packaging_cost'] ?? '')){
		$GLOBALS['packaging_cost_err'] = "Please enter Numeric Packaging Cost.";
		$errCounter++;
	}
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_size()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	extract($_REQUEST);
	$objCategory = new Category();
	$where=array('size_weight_cost_id'=>$_REQUEST['size_id'] ?? '');

	$sizeData=array('name' => addslashes($name), 'length' => $length,'width'=>$width,'height'=>$height,'weight_oz'=>$weight_oz,'weight_lb'=>$weight_lb,'packaging_cost'=>$packaging_cost,'size_type'=>$flat_rolled);
	if($objCategory->updateData(TBL_SIZE_WEIGHT_COST_MASTER, $sizeData,$where,true)){
		$_SESSION['adminErr']="Record has been updated successfully.";
		header("location: admin_size_weight_cost.php");
		exit();
	}else{
		$_SESSION['adminErr']="Record has not been updated successfully.";
		header("location: ".PHP_SELF);
		exit();			
	}
}

function add_size(){
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	foreach ($_REQUEST as $key => $value ) {
		$smarty->assign($key, $_REQUEST[$key] ?? '');
	}
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}

	$smarty->display("admin_size_weight_cost_add.tpl");
}

function validateSaveForm()
{
	$errCounter = 0;

	$obj = new User();

	if(($_REQUEST['name'] ?? '') == ""){
		$GLOBALS['name_err'] = "Please enter Name.";
		$errCounter++;
	}
	if(($_REQUEST['length'] ?? '') == ""){
		$GLOBALS['length_err'] = "Please enter Length.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['length'] ?? '')){
		$GLOBALS['length_err'] = "Please enter Numeric Length.";
		$errCounter++;
	}
	if(($_REQUEST['width'] ?? '') == ""){
		$GLOBALS['width_err'] = "Please enter Width.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['width'] ?? '')){
		$GLOBALS['width_err'] = "Please enter Numeric Width.";
		$errCounter++;
	}
	if(($_REQUEST['height'] ?? '') == ""){
		$GLOBALS['height_err'] = "Please enter Height.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['height'] ?? '')){
		$GLOBALS['height_err'] = "Please enter Numeric Height.";
		$errCounter++;
	}
	if(($_REQUEST['weight_lb'] ?? '') == ""){
		$GLOBALS['weight_lb_err'] = "Please enter Weight in LB.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['weight_lb'] ?? '')){
		$GLOBALS['weight_lb_err'] = "Please enter Numeric Weight in LB.";
		$errCounter++;
	}
     if(($_REQUEST['weight_oz'] ?? '') == ""){
		$GLOBALS['weight_oz_err'] = "Please enter Weight in OZ.";
		$errCounter++;
	}elseif(!check_int($_REQUEST['weight_oz'] ?? '')){
		$GLOBALS['weight_oz_err'] = "Please enter Numeric Weight in OZ.";
		$errCounter++;
	}
	 if(($_REQUEST['packaging_cost'] ?? '') == ""){
		$GLOBALS['packaging_cost_err'] = "Please enter Packaging Cost.";
		$errCounter++;
	}elseif(!is_numeric($_REQUEST['packaging_cost'] ?? '')){
		$GLOBALS['packaging_cost_err'] = "Please enter Numeric Packaging Cost.";
		$errCounter++;
	}
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function save_size()
{
	extract($_REQUEST);
	$objCategory = new Category();
	$sizeData=array('name' => addslashes($name), 'length' => $length,'width'=>$width,'height'=>$height,'weight_oz'=>$weight_oz,'weight_lb'=>$weight_lb,'packaging_cost'=>$packaging_cost,'size_type'=>$flat_rolled);
	if($objCategory->updateData(TBL_SIZE_WEIGHT_COST_MASTER, $sizeData)){
		$_SESSION['adminErr']="New size inserted successfully.";
		header("location: admin_size_weight_cost.php");
		exit();
	}else{
		$_SESSION['adminErr']="New size has not been inserted successfully.";
		header("location: ".PHP_SELF);
		exit();			
	}
}

function delete_size(){
	$objCategory = new Category;
	$where=array('size_weight_cost_id'=>$_REQUEST['size_id'] ?? '');
	$chk = $objCategory->deleteData(TBL_SIZE_WEIGHT_COST_MASTER,$where);

	if($chk == true){
		$_SESSION['adminErr'] = "The record has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete record. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}

}

?>
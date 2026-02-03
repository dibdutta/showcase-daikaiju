<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Category Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';
if($mode == "add_category"){
	add_category();
}elseif($mode == "save_category"){
	$chk = checkCategory();
	if($chk == true){
		save_category();
	}else{
		add_category();
	}
}elseif($mode == "edit_category"){
	edit_category();
}elseif($mode == "delete"){
	del_category();
}elseif($mode == "add_condition"){
	add_condition();
}elseif($mode == "update_category"){
	$chk = checkUpdateCategory();
	if($chk == true){
		update_category();
	}else{
		edit_category();
	}
}else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));
	$smarty->assign(array('cat_type_id' => $cat_type_id ?? ''));
	$obj = new Category();
	$total = $obj->countData(TBL_CATEGORY, array('fk_cat_type_id' => $cat_type_id ?? ''));
	if($total>0){
		if($cat_type_id==1){
			$obj->orderBy="fk_size_weight_cost_id";
			$obj->orderType="ASC";
		}else{
			$obj->orderBy="LOWER(cat_value)";
			//$obj->orderType="DESC";
		}
		if($cat_type_id!=1){
			$catRows = $obj->selectData(TBL_CATEGORY, array('*'), array('fk_cat_type_id' => $cat_type_id), true, true);
		}elseif($cat_type_id==1){
			$catRows = $obj->fetchCategoryDetails($cat_type_id, true, true);
		}
		$smarty->assign('catRows', $catRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	
	$smarty->display('admin_category_manager.tpl');
}

/************************************	 END of Middle	  ********************************/

function add_category() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$obj = new Category;

	$commonSizeTypes = $obj->selectData(TBL_SIZE_WEIGHT_COST_MASTER,array("name,size_weight_cost_id"));
	$smarty->assign('commonSizeTypes', $commonSizeTypes);

	foreach ($_REQUEST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
		$smarty->assign($key,$value);
	}

	$smarty->display('admin_add_category_manager.tpl');
}
function add_condition()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));
	$obj = new Category;

	foreach ($_REQUEST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
		$smarty->assign($key,$value);
	}

	$smarty->display('admin_add_condition_manager.tpl');
}
function del_category()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	extract($_REQUEST);
	$sql = "SELECT count(*) as total FROM ".TBL_POSTER_TO_CATEGORY." tpc,".TBL_AUCTION." a WHERE 
						 tpc.fk_cat_id = '".$cat_id."' AND a.fk_poster_id=tpc.fk_poster_id AND
						a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						";
	$data = mysqli_query($GLOBALS['db_connect'],$sql);
	$total_array = mysqli_fetch_array($data) or die(mysqli_error($GLOBALS['db_connect'])) ;
	$total=$total_array['total'];
	if($total > 0){
		echo $sql_poster = "SELECT p.poster_title  FROM ".TBL_AUCTION." a,".TBL_POSTER." p,".TBL_POSTER_TO_CATEGORY." tpc WHERE 
						 tpc.fk_cat_id = '".$cat_id."' AND a.fk_poster_id=tpc.fk_poster_id AND
						a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND tpc.fk_poster_id=p.poster_id
						"; 
		$data_poster = mysqli_query($GLOBALS['db_connect'],$sql_poster);
	    $_SESSION['adminErr'] = "This record has been used in the following poster(s).You cannot delete.";
	    $i=1;
	    while($total_array = mysqli_fetch_array($data_poster)){
	    	$_SESSION['adminErr'].='<br/>';
	    	$_SESSION['adminErr'].=$i.'.&nbsp;';
	    	$_SESSION['adminErr'].=$total_array['poster_title'] ;	
	    	$i++;
	    }
		header("location: ".PHP_SELF."?cat_type_id=".$cat_type_id);	
	}else{
		$sql = "Delete from ".TBL_CATEGORY." WHERE cat_id = '".$cat_id."' AND fk_cat_type_id = '".$cat_type_id."'";
		$del = mysqli_query($GLOBALS['db_connect'],$sql);
		if($del){
			$_SESSION['adminErr'] = "This Record is Deleted.";
			header("location: ".PHP_SELF."?cat_type_id=".$cat_type_id);	
			exit;
		}else{
			$_SESSION['adminErr'] = "This Record is not Deleted. Please try again";
			header("location: ".PHP_SELF."?cat_type_id=".$cat_type_id);
			exit;
		}
	}
}

function edit_category() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string'] ?? '');
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

	$obj = new Category();
	$commonSizeTypes = $obj->selectData(TBL_SIZE_WEIGHT_COST_MASTER,array("name,size_weight_cost_id"));
	$smarty->assign('commonSizeTypes', $commonSizeTypes);

	extract($_REQUEST);
	$smarty->assign(array('cat_type_id' => $cat_type_id ?? ''));
	$row = $obj->selectData(TBL_CATEGORY, array('cat_value','fk_size_weight_cost_id','is_stills'), array('cat_id' => $cat_id ?? ''));
	$smarty->assign('cat_id', $cat_id ?? '');
	$smarty->assign('category', $row);

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
	}
	
	$smarty->display('admin_edit_category_manager.tpl');
}

function checkCategory(){

	$errCounter=0;
	$obj = new Category;
	extract($_REQUEST);

	if($fk_cat_type_id == ""){
		$GLOBALS['fk_cat_type_id_err'] = "Please select a Category Type.";
		$errCounter++;
	}
	if($cat_value == ""){
		$GLOBALS['cat_value_err'] = "Please select a Category Type.";
		$errCounter++;
	}else{
		$counter = $obj->countData(TBL_CATEGORY, array("cat_value" => $cat_value,'fk_size_weight_cost_id'=>$packaging_type));
		if($counter > 0){
			$GLOBALS['cat_value_err'] = "This category already exists!";
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

function checkUpdateCategory(){

	$errCounter=0;
	$obj = new Category;
	extract($_REQUEST);

	if($cat_value == ""){
		$GLOBALS['cat_value_err'] = "Please select a Category Type.";
		$errCounter++;
	}else{
		$counter = $obj->countData(TBL_CATEGORY, array('cat_value' => $cat_value,'fk_size_weight_cost_id'=>$packaging_type), array('cat_id' => $cat_id));
		if($counter > 0){
			$GLOBALS['cat_value_err'] = "This category already exists!";
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

function save_category(){
	extract($_REQUEST);
	$obj = new Category;
	if($fk_cat_type_id=='1'){
		$data = array('fk_cat_type_id' => $fk_cat_type_id, 'cat_value' => $cat_value,'fk_size_weight_cost_id'=>$packaging_type);
	}elseif($fk_cat_type_id=='2'){
		if(($_REQUEST['is_stills'] ?? '')==''){
			$_REQUEST['is_stills'] = 0;
		}
		$data = array('fk_cat_type_id' => $fk_cat_type_id, 'cat_value' => $cat_value,'is_stills' => $_REQUEST['is_stills']);
	}else{
		$data = array('fk_cat_type_id' => $fk_cat_type_id, 'cat_value' => $cat_value);
		}
	$chk = $obj->updateData(TBL_CATEGORY, $data);
	if($chk){
		$_SESSION['adminErr'] = "One category has been created successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}

function update_category(){
	extract($_REQUEST);
	$obj = new Category;
	if($cat_type_id=='1'){
		$chk = $obj->updateData(TBL_CATEGORY, array('cat_value' => $cat_value,'fk_size_weight_cost_id' => $packaging_type), array('cat_id' => $cat_id), true);
	}elseif($cat_type_id=='2'){
		if(($_REQUEST['is_stills'] ?? '')==''){
			$_REQUEST['is_stills'] = 0;
		}
		$chk = $obj->updateData(TBL_CATEGORY, array('cat_value' => $cat_value,'fk_size_weight_cost_id' => $packaging_type,'is_stills' => $_REQUEST['is_stills']), array('cat_id' => $cat_id), true);
	}else{
		$chk = $obj->updateData(TBL_CATEGORY, array('cat_value' => $cat_value), array('cat_id' => $cat_id), true);
	}
	if($chk == true){
		$_SESSION['adminErr'] = "One category has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}else{
		$_SESSION['adminErr'] = "No category has not been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'] ?? '')."");
		exit;
	}
}

?>
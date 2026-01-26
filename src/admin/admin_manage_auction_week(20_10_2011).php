<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Auction Week Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "add_auction_week"){
	add_auction_week();
}elseif($_REQUEST['mode'] == "save_auction_week"){
	$chk = checkAuctionWeek();
	if($chk == true){
		save_auction_week();
	}else{
		add_auction_week();
	}
}elseif($_REQUEST['mode'] == "update_auction_week"){
	$chk = checkEditEvent();
	if($chk == true){
		update_auction_week();
	}else{
		edit_auction_week();
	}
}elseif($_REQUEST['mode'] == "edit_auction_week"){
	edit_auction_week();
}elseif($_REQUEST['mode'] == "delete_auction_week"){
	delete_auction_week();
}elseif($_REQUEST['mode'] == "show_all_auction_week"){
	show_all_auction_week();
}else{
	show_all_auction_week();
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function show_all_auction_week() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
//	$smarty->assign(array('cat_type_id' => $cat_type_id));
	
	$total_array=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select count(*) total from tbl_auction_week"));
	$total=$total_array['total'];
	$smarty->assign('total', $total);
	if($total > 0){
		$obj = new DBCommon();
		//$event = $obj->selectData(TBL_EVENT, array('*'));
		$auction_week = $obj->selectData(TBL_AUCTION_WEEK, array('*'));
		for($i=0;$i<count($auction_week);$i++)
		{
			$auction_week[$i]['start_date']=date('d-m-Y',strtotime($auction_week[$i]['auction_week_start_date']));
			$auction_week[$i]['end_date']=date('d-m-Y',strtotime($auction_week[$i]['auction_week_end_date']));
		}
		$smarty->assign('auction_week', $auction_week);
		
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->display('admin_auction_week_manager.tpl');
}

/************************************	 END of Middle	  ********************************/

function add_auction_week() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));	
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('admin_add_auction_week.tpl');
}
function delete_auction_week()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	extract($_REQUEST);
	$obj = new DBCommon();
	$obj->primaryKey = 'auction_id';
	$total = $obj->countData(TBL_AUCTION, array('fk_auction_week_id' =>$auction_week_id));
	if($total >0){
		$_SESSION['adminErr'] = "This Auction Week is in Use.You cannot Delete.";
		header("location: ".PHP_SELF."?mode=show_all_auction_week");	
	}else{
		$del=$obj->deleteData(TBL_AUCTION_WEEK,array('auction_week_id' => $auction_week_id));
		if($del){
			$_SESSION['adminErr'] = "This Record is Deleted.";
			header("location: ".PHP_SELF."?mode=show_all_auction_week");	
		}else{
			$_SESSION['adminErr'] = "This Record cannot be Deleted.";
			header("location: ".PHP_SELF."?mode=show_all_auction_week");
		}
	}
}

function edit_auction_week() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$obj=new DBCommon();
	extract($_REQUEST);
	$smarty->assign(array('auction_week_id' => $auction_week_id));
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('*'), array('auction_week_id' => $auction_week_id));
	$row[0]['start_date']=date('m/d/Y',strtotime($row[0]['auction_week_start_date']));
	$row[0]['end_date']=date('m/d/Y',strtotime($row[0]['auction_week_end_date']));
	$smarty->assign('auction_week', $row);
	$smarty->assign('auction_week_id', $auction_week_id);
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('admin_edit_auction_week.tpl');
}

function checkAuctionWeek(){

	$errCounter=0;
	extract($_REQUEST);
	if(is_numeric($start_date)){
		$GLOBALS['start_date_err'] = "Please select a valid Start Date.";
		$errCounter++;
	}
	if(is_numeric($end_date)){
		$GLOBALS['end_date_err'] = "Please select a valid End Date.";
		$errCounter++;
	}
	if($start_date == ""){
		$GLOBALS['start_date_err'] = "Please select a Start Date.";
		$errCounter++;
	}
    if($end_date < date('m/d/Y')){
		$GLOBALS['end_date_err'] = "Please Select a End Date more than Today";
		$errCounter++;	
	}
	
	if($end_date <= $start_date){
		   $GLOBALS['end_date_err'] = "End Date must be greater than Start Date.";
		   $errCounter++;	
	}
	if($end_date == ""){
		$GLOBALS['end_date_err'] = "Please select a End Date.";
		$errCounter++;
	}
	
	if($event_title == ""){
		$GLOBALS['event_title_err'] = "Please select a Auction Week Title.";
		$errCounter++;
	}else{
		$obj = new DBCommon();
		$obj->primaryKey = 'auction_week_id';
	    $total = $obj->countData(TBL_AUCTION_WEEK,array('auction_week_title' => $event_title));
		if($total > 0){
			$GLOBALS['event_title_err'] = "This Title Alreddy Exists.";
			$errCounter++;	
		}
	}

	if($errCounter>0){
		return false;
	}else{
		return true;
	}
}

function save_auction_week(){
	extract($_REQUEST);
	$obj = new Event();
	$data = array('auction_week_title' => $event_title,
				  'auction_week_start_date' => date('Y-m-d',strtotime($start_date)),
				  'auction_week_end_date' => date('Y-m-d',strtotime($end_date)));
	$insert_event = $obj->updateData(TBL_AUCTION_WEEK,$data);
	if($insert_event){
		$_SESSION['adminErr'] = "One auction week has been created successfully.";
		header("location: admin_manage_auction_week.php?mode=show_all_event");
		exit;
	}else{
		$_SESSION['adminErr'] = "No auction week has not been created successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

function checkEditEvent(){

	$errCounter=0;
	
	extract($_REQUEST);
	
	if(is_numeric($start_date)){
		$GLOBALS['start_date_err'] = "Please select a valid Start Date.";
		$errCounter++;
	}
	if(is_numeric($end_date)){
		$GLOBALS['end_date_err'] = "Please select a valid End Date.";
		$errCounter++;
	}
    if($end_date < date('m/d/Y')){
		$GLOBALS['end_date_err'] = "Please Select a End Date more than Today";
		$errCounter++;	
	}
	
	if($start_date == ""){
		$GLOBALS['start_date_err'] = "Please select a Start Date.";
		$errCounter++;
	}
	
	if($end_date == ""){
		$GLOBALS['end_date_err'] = "Please select a End Date.";
		$errCounter++;
	}
	
	if($end_date <= $start_date){
		   $GLOBALS['end_date_err'] = "End Date must be greater than Start Date.";
		   $errCounter++;	
	}
	
	if($event_title == ""){
		$GLOBALS['event_title_err'] = "Please select a Event Title.";
		$errCounter++;
	}else{
		
		$obj = new DBCommon();
		$obj->primaryKey = 'auction_week_id';
	    $total=$obj->countData(TBL_AUCTION_WEEK,array('auction_week_title' => $event_title), array('auction_week_id' => $auction_week_id));
	    //$total = $obj->countData(TBL_AUCTION_WEEK,array('auction_week_title' => $event_title));
	    
	    $objAuction=new Auction();
		$totalEventInAuction = $objAuction->countData(TBL_AUCTION, array('fk_auction_week_id' => $auction_week_id));
		
		if($total > 0){
			$GLOBALS['event_title_err'] = "This Title Alreddy Exists.";
			$errCounter++;	
		}elseif($totalEventInAuction > 0){
			$_SESSION['adminErr'] = "This Record is already in use cannot be edited.";
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

function update_auction_week()
{
	extract($_REQUEST);		
	$obj = new Event();
	$obj->primaryKey = 'fk_event_id';
	$total = $obj->countData(TBL_AUCTION, array('fk_auction_week_id' => $auction_week_id));

	/* For testing purpost $total has been set zero (0) */
	$total = 0;
	/* For testing purpost $total has been set zero (0) */
	if($total >0){
		$_SESSION['adminErr'] = "This Event is in Use.You cannot Delete.";
		header("location: ".PHP_SELF."?mode=show_all_event");	
	}else{
		$data = array('auction_week_title' => $event_title,
					  'auction_week_start_date' => date('Y-m-d',strtotime($start_date)),
					  'auction_week_end_date' => date('Y-m-d',strtotime($end_date)));
		$update_event = $obj->updateData(TBL_AUCTION_WEEK,$data,array('auction_week_id' => $auction_week_id), true);
		
		if($update_event){
			$_SESSION['adminErr'] = "Auction week has been successfully Updated.";
			header("location: admin_manage_auction_week.php?mode=show_all_auction_week");
			exit;
		}else{
			$_SESSION['adminErr'] = "Auction week has not been Updated successfully.";
			header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
			exit;
		}
	}
}


?>
<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Report Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "user_report"){
	user_report_display();
}elseif($_REQUEST['mode'] == "print_user_report"){
	print_user_report();
}elseif($_REQUEST['mode'] == "auction_report"){
	auction_report_display();
}elseif($_REQUEST['mode'] == "print_auction_report"){
	print_auction_report();
}elseif($_REQUEST['mode'] == "pay_now_seller"){
	pay_now_seller();
}elseif($_REQUEST['mode'] == "complete_payment"){
	complete_payment();
}elseif($_REQUEST['mode'] == "admin_auction_seller_detail"){
	admin_auction_seller_detail();
}elseif($_REQUEST['mode'] == "auction_payment_report"){
	auction_payment_report();
}elseif($_REQUEST['mode'] == "print_seller_payment_report"){
	print_seller_payment_report();
}


ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function user_report_display() {
	
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	$obj = new User();
	$objDBCommon = new DBCommon();
	$obj->status = "";
	$total = $obj->totalUsers();
	
	if($total>0){
		$smarty->assign('userNameTXT', "User Name");
		$smarty->assign('emailTXT', "Email Address");
		$smarty->assign('statusTXT', "Status");
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		
		$obj->orderBy = USER_ID;
		$obj->orderType = 'DESC';
		$row = $obj->fetchAllUsers();
		
		for($n=0; $n<count($row); $n++){
			$userFNAME[] = $row[$n][firstname];
			$userLNAME[] = $row[$n][lastname];
			$userCONTACT[] = $row[$n][contact_no];
			$userID[] = $row[$n][USER_ID];
			$country_name=$objDBCommon->selectData(COUNTRY_TABLE,array(country_name),array(country_id=>$row[$n][country_id]));
			//print_r($country_name);
			$country[]=$country_name[0]['country_name'];
			$city[]=$row[$n][CITY];
			$state[]=$row[$n][STATE];
			$address1[]=$row[$n][ADDRESS1];
			$address2[]=$row[$n][ADDRESS2];
			$userName[] = $row[$n][USERNAME];
			$email[] = $row[$n][EMAIL];
			$status[] = $row[$n][STATUS];
		}
		$smarty->assign('userFNAME', $userFNAME);
		$smarty->assign('userLNAME', $userLNAME);
		$smarty->assign('userID', $userID);
		$smarty->assign('country', $country);
		$smarty->assign('city', $city);
		$smarty->assign('address1', $address1);
		$smarty->assign('address2', $address2);
		$smarty->assign('state', $state);
		$smarty->assign('userCONTACT', $userCONTACT);
		$smarty->assign('userName', $userName);
		$smarty->assign('email', $email);
		$smarty->assign('status', $status);
			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
		$smarty->assign('total', $total);
	
}
	$smarty->display('admin_user_report_manager.tpl');
}

/************************************	 END of Middle	  ********************************/
function print_user_report(){
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	$obj = new User();
	$objDBCommon = new DBCommon();
	$obj->status = "";
	$total = $obj->totalUsers();
	
	if($total>0){
		$smarty->assign('userNameTXT', "User Name");
		$smarty->assign('emailTXT', "Email Address");
		$smarty->assign('statusTXT', "Status");
		
		$smarty->assign('startIndex', $GLOBALS['offset']+1);
		
		$obj->orderBy = USER_ID;
		$obj->orderType = 'DESC';
		$row = $obj->fetchAllUsers();
		
		for($n=0; $n<count($row); $n++){
			$userFNAME[] = $row[$n][firstname];
			$userLNAME[] = $row[$n][lastname];
			$userCONTACT[] = $row[$n][contact_no];
			$userID[] = $row[$n][USER_ID];
			$country_name=$objDBCommon->selectData(COUNTRY_TABLE,array(country_name),array(country_id=>$row[$n][country_id]));
			//print_r($country_name);
			$country[]=$country_name[0]['country_name'];
			$city[]=$row[$n][CITY];
			$state[]=$row[$n][STATE];
			$address1[]=$row[$n][ADDRESS1];
			$address2[]=$row[$n][ADDRESS2];
			$userName[] = $row[$n][USERNAME];
			$email[] = $row[$n][EMAIL];
			$status[] = $row[$n][STATUS];
		}
		$smarty->assign('userFNAME', $userFNAME);
		$smarty->assign('userLNAME', $userLNAME);
		$smarty->assign('userID', $userID);
		$smarty->assign('country', $country);
		$smarty->assign('city', $city);
		$smarty->assign('address1', $address1);
		$smarty->assign('address2', $address2);
		$smarty->assign('state', $state);
		$smarty->assign('userCONTACT', $userCONTACT);
		$smarty->assign('userName', $userName);
		$smarty->assign('email', $email);
		$smarty->assign('status', $status);
		
		$smarty->display('admin_user_print_report.tpl');
}
}
function auction_report_display(){
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	//echo $_REQUEST['search'];
	//exit();
	//echo $_REQUEST['start_date'];
	//echo $_REQUEST['end_date'];
	//exit();
	$obj = new Category();
	$obj->orderBy=FIRSTNAME;
	$obj->orderType=ASC;
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	$smarty->assign("userRow", $userRow);
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=auction_report&search=".$_REQUEST['search']);
	}else{
	$objAuction = new Auction();
	if($_REQUEST['start_date']!='')
	{
	$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
	}else{
	$start_date='';	
	}
	if($_REQUEST['end_date']!=''){
	$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
	}else{
	$end_date='';	
	}
	$total = $objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$start_date,$end_date);
	if(!isset($_REQUEST['sort'])){
		$_REQUEST['sort']='poster_title';
	}
	$smarty->assign("sort", $_REQUEST['sort']);
	if($_REQUEST['search']!='reconciliation'){
	$dataAuction=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$start_date,$end_date,$_REQUEST['sort']);
	
	$dataAuction=$objAuction->fetchWinnerAndSoldPrice($dataAuction);
	
//	for($i=0;$i<count($dataAuction);$i++){
//		if($dataAuction[$i]['fk_auction_type_id']=='1' && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->offerWinnerForReport($dataAuction[$i]['auction_id']);		
//		}elseif(($dataAuction[$i]['fk_auction_type_id']=='2' || $dataAuction[$i]['fk_auction_type_id']=='3') && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->bidWinnerForReport($dataAuction[$i]['auction_id']);
//		}elseif($dataAuction[$i]['auction_is_sold']=='2'){
//			$objInvoice= new Invoice();
//			$dataAuction[$i]['winnerName']=$objInvoice->auctionWinnerForReport($dataAuction[$i]['auction_id']);
//		}
//	}
	//echo "<pre>";
	//print_r($dataAuction);
	//echo "</pre>";
	//exit;
	
	$smarty->assign('dataAuction', $dataAuction);
	
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	$smarty->assign('total', $total);
	$smarty->assign('offset', $GLOBALS['offset']);
	$smarty->assign('toshow', $GLOBALS['toshow']);
	//$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('user_id', $_REQUEST['user_id']);
	
	$smarty->assign('start_date', $start_date);
	$smarty->assign('end_date', $end_date);
	}
	if($_REQUEST['search']!='reconciliation'){
	
	$smarty->display('admin_auction_report_manager.tpl');
	}else{

	$total_sold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'sold',$start_date,$end_date);
	$total_pending=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'pending',$start_date,$end_date);
	$total_unsold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unsold',$start_date,$end_date);
	$total_reopen=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'reopen',$start_date,$end_date);
	$total_upcoming=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'upcoming',$start_date,$end_date);
	$total_selling=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'selling',$start_date,$end_date);
	$total_yet_paid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$total_paid_by_admin=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'paid',$start_date,$end_date);
	$total_unpaid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unpaid',$start_date,$end_date);
	$total_unapproved=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unapproved',$start_date,$end_date);
	$total_amount_paid_by_admin=$objAuction->fetchTotalAmountPaidByAdmin($_REQUEST['user_id'],$start_date,$end_date);
	//echo $total_amount_paid_by_admin;
	$objAuction->offset = 0;
	$objAuction->toShow = $total_yet_paid;
	
	$FetchTotalYetpaid=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$FetchTotalYetpaid=$objAuction->fetchSoldPriceForSeller($FetchTotalYetpaid);
	$total_sold_price=0;
	$total_fee=0;
	$total_own=0;
	
	for($i=0;$i<$total_yet_paid;$i++){
		$FetchTotalYetpaid[$i]['mpe_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_CHARGE_TO_SELLER)/100, 2, '.', '');
		$FetchTotalYetpaid[$i]['trans_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_TRANSACTION_CHARGE_TO_SELLER)/100, 2, '.', '') ;
		$FetchTotalYetpaid[$i]['tot_charge']=$FetchTotalYetpaid[$i]['mpe_charge']+$FetchTotalYetpaid[$i]['trans_charge'];
		$FetchTotalYetpaid[$i]['seller_owned']=number_format(($FetchTotalYetpaid[$i]['soldamnt']-($FetchTotalYetpaid[$i]['mpe_charge']+ $FetchTotalYetpaid[$i]['trans_charge'])), 2, '.', '');
		$total_sold_price=$total_sold_price + $FetchTotalYetpaid[$i]['soldamnt'];
		$total_fee=$total_fee + $FetchTotalYetpaid[$i]['tot_charge'];
		$total_own=number_format(($total_own + $FetchTotalYetpaid[$i]['seller_owned']), 2, '.', '');
	}
	
	
	$smarty->assign('total_sold_price', number_format(($total_sold_price), 2, '.', ''));
	$smarty->assign('total_fee', number_format(($total_fee), 2, '.', ''));
	$smarty->assign('total_sold', $total_sold);
	$smarty->assign('total_unapproved', $total_unapproved);
	$smarty->assign('total_own', number_format(($total_own), 2, '.', ''));
	$smarty->assign('total_pending', $total_pending);
	$smarty->assign('total_unsold', $total_unsold);
	$smarty->assign('total_reopen', $total_reopen);	
	$smarty->assign('total_upcoming', $total_upcoming);
	$smarty->assign('total_selling', $total_selling);
	$smarty->assign('total_yet_paid', $total_yet_paid);
	$smarty->assign('total_unpaid', $total_unpaid);
	$smarty->assign('total_paid_by_admin', $total_paid_by_admin);
	$smarty->assign('paidAuctionDetails', $FetchTotalYetpaid);
	$smarty->assign('total_amount_paid_by_admin', $total_amount_paid_by_admin);
	$smarty->display('admin_auction_reconciliation_report_manager.tpl');	
	}
	
}
function print_auction_report()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	//echo $_REQUEST['search'];
	//exit();
	$objAuction = new Auction();
	if($_REQUEST['search']!='reconciliation'){
	$dataAuction=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$_REQUEST['start_date'],$_REQUEST['end_date'],$_REQUEST['sort']);	
	$dataAuction=$objAuction->fetchWinnerAndSoldPrice($dataAuction);
	$smarty->assign('dataAuction', $dataAuction);
	}
	
//	for($i=0;$i<count($dataAuction);$i++){
//	if($dataAuction[$i]['fk_auction_type_id']=='1' && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->offerWinnerForReport($dataAuction[$i]['auction_id']);		
//		}elseif(($dataAuction[$i]['fk_auction_type_id']=='2' || $dataAuction[$i]['fk_auction_type_id']=='3') && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->bidWinnerForReport($dataAuction[$i]['auction_id']);
//		}elseif($dataAuction[$i]['auction_is_sold']=='2'){
//			$objInvoice= new Invoice();
//			$dataAuction[$i]['winnerName']=$objInvoice->auctionWinnerForReport($dataAuction[$i]['auction_id']);
//		}
//	 }
	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	$smarty->assign('search', strtoupper($_REQUEST['search']));	
	$smarty->assign('user_id', $_REQUEST['user_id']);	
	$smarty->assign('start_date', $_REQUEST['start_date']);
	$smarty->assign('end_date', $_REQUEST['end_date']);
	
	
if($_REQUEST['search']!='reconciliation'){
	
	$smarty->display('admin_auction_print_report.tpl');
	}else{
	$total = $objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$start_date,$end_date);	
	$total_sold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'sold',$start_date,$end_date);
	$total_pending=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'pending',$start_date,$end_date);
	$total_unsold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unsold',$start_date,$end_date);
	$total_reopen=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'reopen',$start_date,$end_date);
	$total_upcoming=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'upcoming',$start_date,$end_date);
	$total_selling=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'selling',$start_date,$end_date);
	$total_yet_paid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$total_paid_by_admin=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'paid',$start_date,$end_date);
	$total_unpaid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unpaid',$start_date,$end_date);
	$total_unapproved=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unapproved',$start_date,$end_date);
	$total_amount_paid_by_admin=$objAuction->fetchTotalAmountPaidByAdmin($_REQUEST['user_id'],$start_date,$end_date);
	$objAuction->offset = 0;
	$objAuction->toShow = $total_yet_paid;
	
	$FetchTotalYetpaid=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$FetchTotalYetpaid=$objAuction->fetchSoldPriceForSeller($FetchTotalYetpaid);
	$total_sold_price=0;
	$total_fee=0;
	$total_own=0;
	
	for($i=0;$i<$total_yet_paid;$i++){
		$FetchTotalYetpaid[$i]['mpe_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_CHARGE_TO_SELLER)/100, 2, '.', '');
		$FetchTotalYetpaid[$i]['trans_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_TRANSACTION_CHARGE_TO_SELLER)/100, 2, '.', '') ;
		$FetchTotalYetpaid[$i]['tot_charge']=$FetchTotalYetpaid[$i]['mpe_charge']+$FetchTotalYetpaid[$i]['trans_charge'];
		$FetchTotalYetpaid[$i]['seller_owned']=number_format(($FetchTotalYetpaid[$i]['soldamnt']-($FetchTotalYetpaid[$i]['mpe_charge']+ $FetchTotalYetpaid[$i]['trans_charge'])), 2, '.', '');
		$total_sold_price=$total_sold_price + $FetchTotalYetpaid[$i]['soldamnt'];
		$total_fee=$total_fee + $FetchTotalYetpaid[$i]['tot_charge'];
		$total_own=number_format(($total_own + $FetchTotalYetpaid[$i]['seller_owned']), 2, '.', '');
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('total_sold_price', number_format(($total_sold_price), 2, '.', ''));
	$smarty->assign('total_fee', number_format(($total_fee), 2, '.', ''));
	$smarty->assign('total_sold', $total_sold);
	$smarty->assign('total_unapproved', $total_unapproved);
	$smarty->assign('total_own', number_format(($total_own), 2, '.', ''));
	$smarty->assign('total_pending', $total_pending);
	$smarty->assign('total_unsold', $total_unsold);
	$smarty->assign('total_reopen', $total_reopen);	
	$smarty->assign('total_upcoming', $total_upcoming);
	$smarty->assign('total_selling', $total_selling);
	$smarty->assign('total_yet_paid', $total_yet_paid);
	$smarty->assign('total_unpaid', $total_unpaid);
	$smarty->assign('total_paid_by_admin', $total_paid_by_admin);
	$smarty->assign('paidAuctionDetails', $FetchTotalYetpaid);
	$smarty->assign('total_amount_paid_by_admin', $total_amount_paid_by_admin);
	$smarty->display('admin_print_auction_reconciliation_report_manager.tpl');	
	}
}
	function pay_now_seller(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$objAuction = new Auction();
	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	$smarty->assign('search', strtoupper($_REQUEST['search']));	
	$smarty->assign('user_id', $_REQUEST['user_id']);	
	$smarty->assign('start_date', $_REQUEST['start_date']);
	$smarty->assign('end_date', $_REQUEST['end_date']);
	$total_yet_paid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	
	$FetchTotalYetpaid=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$FetchTotalYetpaid=$objAuction->fetchSoldPriceForSeller($FetchTotalYetpaid);
	$total_sold_price=0;
	$total_fee=0;
	$total_own=0;
	
	for($i=0;$i<$total_yet_paid;$i++){
		$FetchTotalYetpaid[$i]['mpe_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_CHARGE_TO_SELLER)/100, 2, '.', '');
		$FetchTotalYetpaid[$i]['trans_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_TRANSACTION_CHARGE_TO_SELLER)/100, 2, '.', '') ;
		$FetchTotalYetpaid[$i]['tot_charge']=$FetchTotalYetpaid[$i]['mpe_charge']+$FetchTotalYetpaid[$i]['trans_charge'];
		$FetchTotalYetpaid[$i]['seller_owned']=number_format(($FetchTotalYetpaid[$i]['soldamnt']-($FetchTotalYetpaid[$i]['mpe_charge']+ $FetchTotalYetpaid[$i]['trans_charge'])), 2, '.', '');
		$total_sold_price=$total_sold_price + $FetchTotalYetpaid[$i]['soldamnt'];
		$total_fee=$total_fee + $FetchTotalYetpaid[$i]['tot_charge'];
		$total_own=number_format(($total_own + $FetchTotalYetpaid[$i]['seller_owned']), 2, '.', '');
	}
	$smarty->assign('total_sold_price', number_format(($total_sold_price), 2, '.', ''));
	$smarty->assign('total_fee', number_format(($total_fee), 2, '.', ''));
	$smarty->assign('total_own', number_format(($total_own), 2, '.', ''));
	$smarty->assign('total_yet_paid', $total_yet_paid);
	$smarty->assign('paidAuctionDetails', $FetchTotalYetpaid);
	$smarty->display('admin_auction_print_seller.tpl');
	}
 function complete_payment(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
 	if($_REQUEST['user_id']!=''){
 	if(count($_REQUEST['auction_id'])>0){
 		$sql_insert="Insert into `tbl_mpe_admin_payment_to_seller` (user_id,payment_amount,payment_date) values ('".$_REQUEST['user_id']."','".$_REQUEST['pay_amnt']."','".date('Y-m-d H:i:s')."')";
 		if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
 		foreach($_REQUEST['auction_id'] as $key=>$val){
 			$sql_update=mysqli_query($GLOBALS['db_connect'],"Update `tbl_auction`  set auction_payment_is_done_seller='1' where auction_id=$val");	
 		}
 	
 		}
 		$smarty->display('admin_complete_payment.tpl');
 	}
 	}else{
 		
 	}
 		
 }
 function admin_auction_seller_detail(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";	
	//echo $_REQUEST['search'];
	//exit();
	//echo $_REQUEST['start_date'];
	//echo $_REQUEST['end_date'];
	//exit();
	$obj = new Category();
	$obj->orderBy=FIRSTNAME;
	$obj->orderType=ASC;
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	$smarty->assign("userRow", $userRow);
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=auction_report&search=".$_REQUEST['search']);
	}else{
	$objAuction = new Auction();
	if($_REQUEST['start_date']!='')
	{
	$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
	}else{
	$start_date='';	
	}
	if($_REQUEST['end_date']!=''){
	$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
	}else{
	$end_date='';	
	}
	$total = $objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$start_date,$end_date);
	if($_REQUEST['search']!='reconciliation'){
	$objAuction->offset = 0;
	$objAuction->toShow = $total;	
	$dataAuction=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],$_REQUEST['search'],$start_date,$end_date);
	
	$dataAuction=$objAuction->fetchWinnerAndSoldPrice($dataAuction);
	
//	for($i=0;$i<count($dataAuction);$i++){
//		if($dataAuction[$i]['fk_auction_type_id']=='1' && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->offerWinnerForReport($dataAuction[$i]['auction_id']);		
//		}elseif(($dataAuction[$i]['fk_auction_type_id']=='2' || $dataAuction[$i]['fk_auction_type_id']=='3') && $dataAuction[$i]['auction_is_sold']=='1'){
//			$dataAuction[$i]['winnerName']=$objAuction->bidWinnerForReport($dataAuction[$i]['auction_id']);
//		}elseif($dataAuction[$i]['auction_is_sold']=='2'){
//			$objInvoice= new Invoice();
//			$dataAuction[$i]['winnerName']=$objInvoice->auctionWinnerForReport($dataAuction[$i]['auction_id']);
//		}
//	}
	//echo "<pre>";
	//print_r($dataAuction);
	//echo "</pre>";
	//exit;
	
	$smarty->assign('dataAuction', $dataAuction);
	
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	$smarty->assign('total', $total);
	$smarty->assign('offset', $GLOBALS['offset']);
	$smarty->assign('toshow', $GLOBALS['toshow']);
	//$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('user_id', $_REQUEST['user_id']);
	
	$smarty->assign('start_date', $start_date);
	$smarty->assign('end_date', $end_date);
	}
	if($_REQUEST['search']!='reconciliation'){
	
	$smarty->display('admin_auction_seller_detail.tpl');
	}else{

	$total_sold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'sold',$start_date,$end_date);
	$total_pending=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'pending',$start_date,$end_date);
	$total_unsold=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unsold',$start_date,$end_date);
	$total_reopen=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'reopen',$start_date,$end_date);
	$total_upcoming=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'upcoming',$start_date,$end_date);
	$total_selling=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'selling',$start_date,$end_date);
	$total_yet_paid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$total_paid_by_admin=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'paid',$start_date,$end_date);
	$total_unpaid=$objAuction->countTotalAuctionsAdmin($_REQUEST['user_id'],'unpaid',$start_date,$end_date);
	$total_amount_paid_by_admin=$objAuction->fetchTotalAmountPaidByAdmin($_REQUEST['user_id'],$start_date,$end_date);
	//echo $total_amount_paid_by_admin;
	$objAuction->offset = 0;
	$objAuction->toShow = $total_yet_paid;
	
	$FetchTotalYetpaid=$objAuction->fetchTotalAuctionsAdmin($_REQUEST['user_id'],'yet_to_pay',$start_date,$end_date);
	$FetchTotalYetpaid=$objAuction->fetchSoldPriceForSeller($FetchTotalYetpaid);
	$total_sold_price=0;
	$total_fee=0;
	$total_own=0;
	
	for($i=0;$i<$total_yet_paid;$i++){
		$FetchTotalYetpaid[$i]['mpe_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_CHARGE_TO_SELLER)/100, 2, '.', '');
		$FetchTotalYetpaid[$i]['trans_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_TRANSACTION_CHARGE_TO_SELLER)/100, 2, '.', '') ;
		$FetchTotalYetpaid[$i]['tot_charge']=$FetchTotalYetpaid[$i]['mpe_charge']+$FetchTotalYetpaid[$i]['trans_charge'];
		$FetchTotalYetpaid[$i]['seller_owned']=number_format(($FetchTotalYetpaid[$i]['soldamnt']-($FetchTotalYetpaid[$i]['mpe_charge']+ $FetchTotalYetpaid[$i]['trans_charge'])), 2, '.', '');
		$total_sold_price=$total_sold_price + $FetchTotalYetpaid[$i]['soldamnt'];
		$total_fee=$total_fee + $FetchTotalYetpaid[$i]['tot_charge'];
		$total_own=number_format(($total_own + $FetchTotalYetpaid[$i]['seller_owned']), 2, '.', '');
	}
	
	
	$smarty->assign('total_sold_price', number_format(($total_sold_price), 2, '.', ''));
	$smarty->assign('total_fee', number_format(($total_fee), 2, '.', ''));
	$smarty->assign('total_sold', $total_sold);
	$smarty->assign('total_own', number_format(($total_own), 2, '.', ''));
	$smarty->assign('total_pending', $total_pending);
	$smarty->assign('total_unsold', $total_unsold);
	$smarty->assign('total_reopen', $total_reopen);	
	$smarty->assign('total_upcoming', $total_upcoming);
	$smarty->assign('total_selling', $total_selling);
	$smarty->assign('total_yet_paid', $total_yet_paid);
	$smarty->assign('total_unpaid', $total_unpaid);
	$smarty->assign('total_paid_by_admin', $total_paid_by_admin);
	$smarty->assign('paidAuctionDetails', $FetchTotalYetpaid);
	$smarty->assign('total_amount_paid_by_admin', $total_amount_paid_by_admin);
	$smarty->display('admin_auction_seller_detail.tpl');
 }
 }
  function auction_payment_report(){
  	
   	require_once INCLUDE_PATH."lib/adminCommon.php";
   	
   	$obj = new User();
    $obj->orderBy=FIRSTNAME;
    $obj->orderType=ASC;
    $userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);	
    $smarty->assign('userRow', $userRow);
  	if(isset($_REQUEST['search'])){
   		$key=1;
   	}else{
   		$key=0;
   	}
   
	   	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
			$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
			header("location: ".PHP_SELF."?mode=auction_payment_report");
		}else{
	
			if($_REQUEST['start_date']!='')
			  {
			   $start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
			  }else{
			   $start_date='';	
			  }
			if($_REQUEST['end_date']!=''){
			  $end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
	        }else{
	          $end_date='';	
	        }
	       $objAuction= new Auction();
   	       $smarty->assign('user_id', $_REQUEST['user_id']);
		   $dataPayment=$objAuction->paymentDetailsSeller($_REQUEST['user_id'],$start_date,$end_date);
	       //print_r($dataPayment);
		   $total=count($dataPayment);
		   $smarty->assign('dataPayment', $dataPayment);
		   $smarty->assign('start_date', $start_date);
	       $smarty->assign('end_date', $end_date);
	       $smarty->assign('total', $total);
	       $smarty->assign('key', $key);
	       }
   	
	$smarty->display('admin_seller_payment_report.tpl');
   }
   function print_seller_payment_report(){
   	require_once INCLUDE_PATH."lib/adminCommon.php";
   	$obj = new User();
    $userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1,'user_id'=>$_REQUEST['user_id']));	
   	$smarty->assign('userRow', $userRow);
   	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	$smarty->assign('start_date', $_REQUEST['start_date']);
	$smarty->assign('end_date', $_REQUEST['end_date']);
   	$objAuction= new Auction();
	$dataPayment=$objAuction->paymentDetailsSeller($_REQUEST['user_id'],$start_date,$end_date);
	$smarty->assign('dataPayment', $dataPayment);
	//admin_auction_print_report.tpl  
	$smarty->display('admin_print_seller_payment_report.tpl');     
   }
?>
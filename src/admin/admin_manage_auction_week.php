<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Auction Week Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';
if($mode == "add_auction_week"){
	add_auction_week();
}elseif($mode == "save_auction_week"){
	$chk = checkAuctionWeek();
	if($chk == true){
		save_auction_week();
	}else{
		add_auction_week();
	}
}elseif($mode == "update_auction_week"){
	$chk = checkEditEvent();
	if($chk == true){
		update_auction_week();
	}else{
		edit_auction_week();
	}
}elseif($mode == "edit_auction_week"){
	edit_auction_week();
}elseif($mode == "delete_auction_week"){
	delete_auction_week();
}elseif($mode == "show_all_auction_week"){
	show_all_auction_week();
}elseif($mode == "manage_weekly_auction"){
	manage_weekly_auction();
}elseif($mode == "create_new_weekly_auction"){
	create_new_weekly_auction();
}elseif($mode == "manage_weekly_auction_for_seller"){
    manage_weekly_auction_for_seller();
}elseif($mode == "save_weekly_auction"){
	$chk = validateNewWeeklyForm();
	if($chk){
		save_new_weekly_auction();
	}else{
		create_new_weekly_auction();
	}
}elseif($mode == "combine_buyer_invoice"){
    combine_buyer_invoice();
}elseif($mode == "combine_seller_invoice"){
    combine_seller_invoice();
}elseif($mode == "mark_paid_seller_invoice"){
    mark_paid_seller_invoice();
}elseif($mode == "mark_shipped_buyer_invoice"){
    mark_shipped_buyer_invoice();
}elseif($mode == "update_auction_status"){
    update_auction_status();
}elseif($mode == "sync_auction_bid"){
    sync_auctiocn_bid_fun();
}elseif($mode == "view_snipes"){
    view_snipes();
}else{
	show_all_auction_week();
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function show_all_auction_week() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	define ("PAGE_HEADER_TEXT", " Admin Weekly/still photo Auction Manager");
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
//	$smarty->assign(array('cat_type_id' => $cat_type_id));
	
	$total_array=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select count(*) total from tbl_auction_week"));
	$total=$total_array['total'];
	$smarty->assign('total', $total);
	if($total > 0){
		$obj = new DBCommon();
        $obj->orderBy="auction_week_id";
        $obj->orderType="DESC";
        $auction_week = $obj->selectData(TBL_AUCTION_WEEK, array('*'), '1', true, true);
		for($i=0;$i<count($auction_week);$i++)
		{
			$auction_week[$i]['start_date']=date('m/d/Y H:i:s',strtotime($auction_week[$i]['auction_week_start_date']));
			$auction_week[$i]['end_date']=date('m/d/Y H:i:s',strtotime($auction_week[$i]['auction_week_end_date']));
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
	define ("PAGE_HEADER_TEXT", "Admin Add Auction Manager");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));	
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
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
	define ("PAGE_HEADER_TEXT", "Admin Edit Auction Week Manager");
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$obj=new DBCommon();
	extract($_REQUEST);
	$smarty->assign(array('auction_week_id' => $auction_week_id));
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('*'), array('auction_week_id' => $auction_week_id));
	$row[0]['start_date']=date('m/d/Y',strtotime($row[0]['auction_week_start_date']));
	$row[0]['end_date']=date('m/d/Y',strtotime($row[0]['auction_week_end_date']));
	
	
	list($date,$time) = explode(' ', $row[0]['auction_week_start_date']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$row[0]['auction_start_hour'] = $h - 12;
		$row[0]['auction_start_am_pm'] = 'pm';
	}else{
		$row[0]['auction_start_hour'] = $h;
		$row[0]['auction_start_am_pm'] = 'am';
	}
	$row[0]['auction_start_min'] = $m;
	/////////
	
	/////////
	list($date,$time) = explode(' ', $row[0]['auction_week_end_date']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$row[0]['auction_end_hour'] = $h - 12;
		$row[0]['auction_end_am_pm'] = 'pm';
	}else{
		$row[0]['auction_end_hour'] = $h;
		$row[0]['auction_end_am_pm'] = 'am';
	}
	$row[0]['auction_end_min'] = $m;
//	echo "<pre>";
//	print_r($row);
//	echo "</pre>";
	$smarty->assign('auction_week', $row);
	$smarty->assign('auction_week_id', $auction_week_id);
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
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
    if(compareDates($end_date,date('m/d/Y'))){
		$GLOBALS['end_date_err'] = "Please Select an End Date more than Today";
		$errCounter++;	
	}
	
	if(compareDates($end_date,$start_date)){
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
	if($auction_start_am_pm=='am'){
		$start_time=$start_date.' '.$auction_start_hour.':'.$auction_start_min.':'.'00';
	}elseif($auction_start_am_pm=='pm'){
		$auction_start_hour=($auction_start_hour + 12);
		$start_time=$start_date.' '.$auction_start_hour.':'.$auction_start_min.':'.'00';
	}
	if($auction_end_am_pm=='am'){
		$end_time=$end_date.' '.$auction_end_hour.':'.$auction_end_min.':'.'00';
	}elseif($auction_end_am_pm=='pm'){
		$auction_end_hour=	($auction_end_hour + 12);
		$end_time=$end_date.' '.$auction_end_hour.':'.$auction_end_min.':'.'00';	
	}

	$obj = new Event();
	if($is_test==''){
		$is_test=0;
	}
	if($is_still==''){
		$is_still=0;
	}
	$data = array('auction_week_title' => $event_title,
				  'auction_week_start_date' => date('Y-m-d H:i:s',strtotime($start_time)),
				  'auction_week_end_date' => date('Y-m-d H:i:s',strtotime($end_time)),'is_test'=>$is_test,'is_stills'=>$is_still);
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
    if(compareDates($end_date,date('m/d/Y'))){
		$GLOBALS['end_date_err'] = "Please Select an End Date more than Today";
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
	
	if(compareDates($end_date,$start_date)){
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
		$_SESSION['adminErr'] = "This auction week is in use.You cannot Delete.";
		header("location: ".PHP_SELF."?mode=show_all_event");	
	}else{
		if($auction_start_am_pm=='am'){
			$start_time=$start_date.' '.$auction_start_hour.':'.$auction_start_min.':'.'00';
		}elseif($auction_start_am_pm=='pm'){
			$auction_start_hour=($auction_start_hour + 12);
			$start_time=$start_date.' '.$auction_start_hour.':'.$auction_start_min.':'.'00';
		}
		if($auction_end_am_pm=='am'){
			$end_time=$end_date.' '.$auction_end_hour.':'.$auction_end_min.':'.'00';
		}elseif($auction_end_am_pm=='pm'){
			$auction_end_hour=	($auction_end_hour + 12);
			$end_time=$end_date.' '.$auction_end_hour.':'.$auction_end_min.':'.'00';	
		}
		if($is_test==''){
		$is_test=0;
		}
		if($is_still==''){
			$is_still=0;
		}
		$data = array('auction_week_title' => $event_title,
					  'auction_week_start_date' => date('Y-m-d H:i:s',strtotime($start_time)),
					  'auction_week_end_date' => date('Y-m-d H:i:s',strtotime($end_time)),'is_test'=>$is_test,'is_stills'=>$is_still);
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

############################# Added on 21-11-2011 that admin can add weekly auction and assign to users #########################

	function manage_weekly_auction()
{
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $auctionWeekObj = new AuctionWeek();
	$auctionWeekDetails = $auctionWeekObj->fetchAuctionWeekDetails($_REQUEST['week_id']);
	$auctionWeekTitle=$auctionWeekDetails[0]['auction_week_title'];
	$smarty->assign('auctionWeekTitle', $auctionWeekTitle);
	if($auctionWeekDetails[0]['is_stills']==1){
		define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
		$smarty->assign('is_stills', 1);		
	}else{
    	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager (".$auctionWeekTitle.")");
		$smarty->assign('is_stills', 0);
	}

    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $auctionObj = new Auction();
    $auctionObj->orderType = 'DESC';
    if($auctionWeekDetails[0]['is_stills']==0){
    	$total_pending = $auctionObj->countWeeklyAuctionByWeek($_REQUEST['week_id'],'','pending',$auctionWeekDetails[0]['is_stills']);
	}
	if($total_pending==0){
		$total_selling = $auctionObj->countWeeklyAuctionByWeek($_REQUEST['week_id'],'','selling',$auctionWeekDetails[0]['is_stills']);
	}
    if($auctionWeekDetails[0]['is_stills']==1){
		if($total_pending==0 && $total_selling==0){
			$total_sold = $auctionObj->countWeeklyAuctionByWeek($_REQUEST['week_id'],'','sold',$auctionWeekDetails[0]['is_stills']);
		}
	}else{
		if($total_pending==0 && $total_selling==0){
			$auctionRows_sold_total = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','sold','0',$auctionWeekDetails[0]['is_stills']) ?? [];
			$total_sold = count($auctionRows_sold_total);
		}
	}
	if($total_pending==0 && $total_selling==0){
		$total_unsold = $auctionObj->countWeeklyAuctionByWeek($_REQUEST['week_id'],'','unsold',$auctionWeekDetails[0]['is_stills']);
	}
    if($auctionWeekDetails[0]['is_stills']==0){
		if($total_pending > 0){
			$auctionRows_pending = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','pending','',$auctionWeekDetails[0]['is_stills']);
			/*echo "<pre>";
			print_r($auctionRows_pending);
			echo "</pre>";*/
			$smarty->assign('total_pending', $total_pending);
			$smarty->assign('auctionRows_pending', $auctionRows_pending);
		}
	}
    if($total_selling > 0){
        $auctionRows_selling = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','selling','',$auctionWeekDetails[0]['is_stills']);
        /*echo "<pre>";
        print_r($auctionRows_selling);
        echo "</pre>";*/
        $smarty->assign('total_selling', $total_selling);
        $smarty->assign('auctionRows_selling', $auctionRows_selling);
    }
    if($total_sold > 0){
        $auctionRows_sold = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','sold','1',$auctionWeekDetails[0]['is_stills']);
        #$auctionRows_sold_total = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','sold','0',$auctionWeekDetails[0]['is_stills']);
        $user_arr = array();
        $amount_arr = array();
        $auction_arr = array();
        $new_user_arr = array();
        foreach($auctionRows_sold  as $key => $val){

            $user_arr[]=$auctionRows_sold[$key]['user_id'];
            $amount_arr[]=$auctionRows_sold[$key]['amount'];
            //$auction_arr[]=$auctionRows_sold[$key]['auction_id'];
        }
        foreach($auctionRows_sold_total ?? [] as $key => $val){
            $auction_arr[]=$auctionRows_sold_total[$key]['auction_id'];
            $new_user_arr[]=$auctionRows_sold_total[$key]['user_id'];
        }

        $size_user_arr=count($user_arr);
        $new_size_user_arr=count($new_user_arr);

        foreach($auctionRows_sold  as $key => $val){
            $tot=linearSearchCount($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id']);
            $auctionRows_sold[$key]['tot_poster']=$tot;
            $totAmount=linearSearchTotal($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id'],$amount_arr);
            $auctionRows_sold[$key]['tot_amount']=$totAmount;
            /*$totAuction=substr(linearSearchTotalAuction($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr),0,strlen(linearSearchTotalAuction($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr))-1);
               $auctionRows_sold[$key]['tot_auction']=$totAuction;*/
        }
        foreach($auctionRows_sold  as $key => $val){
            $totAuction=substr(linearSearchTotalAuction($new_user_arr,$new_size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr),0,strlen(linearSearchTotalAuction($new_user_arr,$new_size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr))-1);
            $auctionRows_sold[$key]['tot_auction']=$totAuction;
        }
        /*echo "<pre>";
        print_r($auctionRows_sold);
        echo "</pre>";*/
        $smarty->assign('total_sold', $total_sold);
        $smarty->assign('auctionRows_sold', $auctionRows_sold);
        $smarty->assign('auctionRows_sold_total', $auctionRows_sold_total);
        $smarty->assign('displayCounterTXT', displayCounter($total_sold, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total_sold, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    if($total_unsold > 0){
        $auctionRows_unsold = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id'],'','unsold','',$auctionWeekDetails[0]['is_stills']);
        /*echo "<pre>";
        print_r($auctionRows_unsold);
        echo "</pre>";*/
        $smarty->assign('total_unsold', $total_unsold);
        $smarty->assign('auctionRows_unsold', $auctionRows_unsold);
    }

    /*if($total>0){
         $auctionRows = $auctionObj->fetchWeeklyAuctionByWeek($_REQUEST['week_id']);
         $smarty->assign('auctionRows', $auctionRows);
         $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
         $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
     }*/
    $smarty->assign('week_id', $_REQUEST['week_id']);

    $smarty->display('admin_week_wise_weekly_auction_manager.tpl');
}
	function create_new_weekly_auction(){
	if(!$_POST)
    {
		if(isset($_SESSION['img']))
		{
		  unset($_SESSION['img']);
		}
    }
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$auctionWeekObj = new AuctionWeek();
	$auctionWeekDetails = $auctionWeekObj->fetchAuctionWeekDetails($_REQUEST['week_id']);
	$auctionWeekTitle=$auctionWeekDetails[0]['auction_week_title'];
	$smarty->assign('auctionWeekTitle', $auctionWeekTitle);
	define ("PAGE_HEADER_TEXT", "Admin Auction Manager (".$auctionWeekTitle.")");
	
	
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	//$auctionWeekObj = new AuctionWeek();
    //$aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
    //$smarty->assign('aucetionWeeks', $aucetionWeeks);

	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		$smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
		if($key=='poster_desc'){
			$PosterDesc=$value;
		}
		if(($key == 'poster_images') && ($value != "" || isset($_SESSION['img'])) )
		{
		if(isset($_SESSION['img']))
		{
		$imgstr=implode(",",$_SESSION['img']);
		$imgstr=$imgstr.',';
		unset($_SESSION['img']);
		}
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
		
		
		if($value != "")
		{
			$smarty->assign("poster_images", $value); 
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
		}
	}
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = (($_POST['random'] ?? '') == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	if(isset($posterImageRows)){
		for($i=0;$i<count($posterImageRows);$i++){
			$existingImages .= $posterImageRows[$i]['poster_image'].",";
		}
		$existing_images_arr = explode(',',trim($existingImages, ','));
		$smarty->assign("existingImages", $existingImages);
		$smarty->assign("browse_count", (count($poster_images_arr ?? []) + count($posterImageRows)));
	}
	
	
	
	
	$obj->orderBy = 'firstname';
	$obj->orderType = 'ASC';
	
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1), true);
	$smarty->assign("userRow", $userRow);
	
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	/*$oFCKeditor->ToolbarSet = 'Basic';*/
	$oFCKeditor->Value = $PosterDesc;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_create_weekly_auction.tpl');
	
}
function validateNewWeeklyForm()
{
    $errCounter = 0;
	$random = $_REQUEST['random'];
	if($_POST['user_id'] == ""){
		$GLOBALS['user_id_err'] = "Please select an User.";
		$errCounter++;	
	}else{
		$user_name=$_POST['user_id'];
		if($user_name==''){
			$GLOBALS['user_id_err'] = "Please select a valid User.";
			$errCounter++;
		}else{
			$objUser = new User;
			$objUser->primaryKey="user_id";
			$totUser= $objUser->countData(USER_TABLE,array("username"=>$user_name));
			if($totUser!='1'){
				$GLOBALS['user_id_err'] = "This User does not exists";
				$errCounter++;
			}
		}
	}
	
    if($_POST['poster_title'] == ""){
        $GLOBALS['poster_title_err'] = "Please enter Poster Title.";
        $errCounter++;  
    }
    
    if($_POST['poster_size'] == ""){
        $GLOBALS['poster_size_err'] = "Please select a Size.";
        $errCounter++;
    }
    
    if($_POST['genre'] == ""){
        $GLOBALS['genre_err'] = "Please select Genre.";
        $errCounter++;  
    }
    
    if($_POST['dacade'] == ""){
        $GLOBALS['dacade_err'] = "Please select a Decade.";
        $errCounter++;  
    }
    
    if($_POST['country'] == ""){
        $GLOBALS['country_err'] = "Please select Country.";
        $errCounter++;  
    }
    
    if($_POST['condition'] == ""){
        $GLOBALS['condition_err'] = "Please select Condition.";
        $errCounter++; 
    }
    
    if($_POST['poster_desc'] == ""){
        $GLOBALS['poster_desc_err'] = "Please enter Poster Description.";
        $errCounter++; 
    }
	
    if($_POST['asked_price'] == ""){
        $GLOBALS['asked_price_err'] = "Please enter Starting Price.";
        $errCounter++;
        $asked_price_err = 1;
    }elseif(check_int($_POST['asked_price'])==0){
        $GLOBALS['asked_price_err'] = "Please enter integer values only.";
        $errCounter++;
        $asked_price_err = 1;
    }
    
    if($_POST['buynow_price'] != "" && check_int($_POST['buynow_price'])==0){
        $GLOBALS['buynow_price_err'] = "Please enter integer values only.";
        $errCounter++;
    }elseif($_POST['buynow_price'] != "" && $_POST['buynow_price'] != 0 && $asked_price_err == ''){
        if($_POST['buynow_price'] <= $_POST['asked_price']){
            $GLOBALS['buynow_price_err'] = "Buynow price must be greater than starting price.";
            $errCounter++;
        }
    }
    
   if($_POST['poster_images'] == "" && !isset($_SESSION['img'])   && $_POST['existing_images'] == ""){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else{
	$posterimages=$_POST['poster_images'];
	if(isset($_SESSION['img']))
	{
	$imgstr=implode(",",$_SESSION['img']);
	
	
	if($posterimages!='')
	{
	$posterimages=$posterimages.$imgstr;
	}
	else
	{
	$posterimages=$imgstr;
	}
	}
	if($posterimages!='')
	{
		$posterArr = explode(',', trim($posterimages, ','));
		foreach($posterArr as $key => $value){
			$size = getimagesize("../poster_photo/temp/$random/".$value);
			if(!$size){
				$GLOBALS['poster_images_err'] = "Please provide proper images only.";
				$errCounter++;
			}
		}
	 }
	}
    if($errCounter > 0){
        return false;
    }else{
        return true;
    }
}
	function save_new_weekly_auction(){
		
    extract($_REQUEST);
    $obj = new Poster();
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $week_id));	

    $start_date = $row[0]['auction_week_start_date'];
    $end_date = $row[0]['auction_week_end_date'];
	$end_date_arr=explode(" ",$end_date);
	$end_date_arr=explode("-",$end_date_arr[0]);
	
	$user_name=$_POST['user_id'];
	$objUser = new User();
	$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
	$user_new_id=$arrUser[0]['user_id'];
    $data = array('fk_user_id' => $user_new_id,
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => $end_date_arr[1].$end_date_arr[2].$end_date_arr[0].generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => date("Y-m-d H:i:s"),
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);
    
    $poster_id = $obj->updateData("tbl_poster_live", $data);
	
	
    
    
    if($poster_size != ""){
        $obj->updateData("tbl_poster_to_category_live", array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
    }

    if($genre != ""){
        $obj->updateData("tbl_poster_to_category_live", array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
    }

    if($dacade != ""){
        $obj->updateData("tbl_poster_to_category_live", array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
    }

    if($country != ""){
        $obj->updateData("tbl_poster_to_category_live", array("fk_poster_id" => $poster_id, "fk_cat_id" => $country)); 
    }
    
    if($condition != ""){
        $obj->updateData("tbl_poster_to_category_live", array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
    }

	
        
    $data = array("fk_auction_type_id" => 2,
                  "fk_poster_id" => $poster_id,
				  "fk_auction_week_id" => $week_id,
                  "auction_asked_price" => $asked_price,
                  "auction_start_date" => $start_date,
                  "auction_end_date" => $end_date,
                  "auction_actual_start_datetime" => $start_date,
                  "auction_actual_end_datetime" => $end_date,
                  "auction_is_approved" => 1,
                  "auction_is_sold" => 0,
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => "0000-00-00 00:00:00",
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"],
				  "imdb_link"=>$imdb_link);
    //echo "<pre>";print_r($data);exit;
    $auction_id=$obj->updateData("tbl_auction_live", $data);

	$objWantlist = new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
	
	 if(isset($_SESSION['img']))
		{
			$imgstr=implode(",",$_SESSION['img']);
			if(isset($poster_images))
			{
			$poster_images=$poster_images.$imgstr;
			}
			else
			{
			$poster_images=$imgstr;
			}
		}
		if($poster_images!='')
		{
			$posterArr = explode(',', trim($poster_images, ','));
			##### NEW FUNCTION FOR POSTER UPLOAD starts #####
			//$is_default = end($posterArr);
			$is_default = $posterArr[0];
			$base_temp_dir="../poster_photo/temp/$random"; 
			$src_temp="../poster_photo/temp/$random/";
			$dest_poster_photo="../poster_photo/";
			$destThumb = "../poster_photo/thumbnail";
			$destThumb_buy = "../poster_photo/thumb_buy";
			$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
			$destThumb_big_slider = "../poster_photo/thumb_big_slider";
			dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider,'weekly' );
			
			
			if (is_dir($base_temp_dir)) {
				rmdir($base_temp_dir);
				}
			##### NEW FUNCTION FOR POSTER UPLOAD ends #####
    	}
    if($poster_id > 0){     
        $_SESSION['adminErr']="Poster added successfully.";
        header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
        exit();
    }else{
        $_SESSION['adminErr']="Could not add poster.Please try again.";
        header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
        exit();
    }

	}
function combine_buyer_invoice(){
    $newinvoiceAuction = array();
    $newinvoiceCharge = array();
    $newinvoiceDiscount = array();
    $invoiceArr= array();
    $subTotal=0;
    $invoiceObj = new Invoice();
    foreach($_REQUEST['auction_id'] as $key=>$val){
        $invoiceData = $invoiceObj->fetchInvoiceByAuctionId($val);
        $invoiceArr[] = $invoiceData['invoice_id'];
        $user_id= $invoiceData['fk_user_id'];
        $shipping_address=$invoiceData['shipping_address'];
        $billing_address=$invoiceData['billing_address'];
        $invoiceData['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['auction_details']);
        $invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
        if(!empty($invoiceData['auction_details'])){
            foreach($invoiceData['auction_details'] as $key => $value){
                $newinvoiceAuction[] =array('auction_id' => $invoiceData['auction_details'][$key]['auction_id'],'poster_sku' => $invoiceData['auction_details'][$key]['poster_sku'], 'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['auction_details'][$key]['poster_title']), 'amount' => $invoiceData['auction_details'][$key]['amount']);
                $subTotal += $invoiceData['auction_details'][$key]['amount'];
            }
        }
        $invoiceData['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['additional_charges']);
        $invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
        if(!empty($invoiceData['additional_charges'])){
            foreach($invoiceData['additional_charges'] as $key => $value){
                $newinvoiceCharge[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['additional_charges'][$key]['description']), 'amount' => $invoiceData['additional_charges'][$key]['amount']);
                $subTotal += $invoiceData['additional_charges'][$key]['amount'];
            }
        }
        $invoiceData['discounts'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['discounts']);
        $invoiceData['discounts'] = unserialize($invoiceData['discounts']);
        if(!empty($invoiceData['discounts'])){
            foreach($invoiceData['discounts'] as $key => $value){
                $newinvoiceDiscount[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['discounts'][$key]['description']), 'amount' => $invoiceData['discounts'][$key]['amount']);
                $subTotal -= $invoiceData['discounts'][$key]['amount'];
            }
        }
    }

    $auction_details=serialize($newinvoiceAuction);

    $add_charge=serialize($newinvoiceCharge);

    $discount=serialize($newinvoiceDiscount);

    $data = array('fk_user_id' => $user_id, 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
        'auction_details' => $auction_details, 'additional_charges' => $add_charge,'discounts'=>$discount, 'total_amount' => $subTotal,
        'invoice_generated_on' => date("Y-m-d H:i:s"), 'is_buyers_copy' => 1,'is_combined'=>'1');
    $invoice_id = $invoiceObj->updateData(TBL_INVOICE, $data);

    foreach($invoiceArr as $key=>$val){
        mysqli_query($GLOBALS['db_connect'],"Update tbl_invoice_to_auction set fk_invoice_id = $invoice_id where fk_invoice_id=".$val);
        mysqli_query($GLOBALS['db_connect'],"Delete from tbl_invoice where invoice_id=".$val);
    }
    if($invoice_id > 0){
        echo "1";
    }else{
        echo "2";
    }

}function manage_weekly_auction_for_seller(){

    require_once INCLUDE_PATH."lib/adminCommon.php";
    $auctionWeekObj = new AuctionWeek();
	$auctionWeekDetails = $auctionWeekObj->fetchAuctionWeekDetails($_REQUEST['week_id']);
	
	if($auctionWeekDetails[0]['is_stills']==1){
		define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
		$smarty->assign('is_stills', 1);		
	}else{
    	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
		$smarty->assign('is_stills', 0);
	}

    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $auctionObj = new Auction();
    $auctionObj->orderType = 'DESC';
    $total_sold = $auctionObj->countWeeklyAuctionByWeek($_REQUEST['week_id'],'','sold',$auctionWeekDetails[0]['is_stills']);
    if($total_sold > 0){
        $auctionRows_sold = $auctionObj->fetchWeeklyAuctionByWeekSeller($_REQUEST['week_id'],'','sold','1',$auctionWeekDetails[0]['is_stills']);
        $auctionRows_sold_total = $auctionObj->fetchWeeklyAuctionByWeekSeller($_REQUEST['week_id'],'','sold','0',$auctionWeekDetails[0]['is_stills']);
        $user_arr = array();
        $amount_arr = array();
        $auction_arr = array();
        $new_user_arr = array();
        foreach($auctionRows_sold ?? [] as $key => $val){

            $user_arr[]=$auctionRows_sold[$key]['user_id'];
            $amount_arr[]=$auctionRows_sold[$key]['amount'];
        }
        foreach($auctionRows_sold_total ?? [] as $key => $val){
            $auction_arr[]=$auctionRows_sold_total[$key]['auction_id'];
            $new_user_arr[]=$auctionRows_sold_total[$key]['user_id'];
        }
        $size_user_arr=count($user_arr);
        $new_size_user_arr=count($new_user_arr);

        foreach($auctionRows_sold  as $key => $val){
            $tot=linearSearchCount($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id']);
            $auctionRows_sold[$key]['tot_poster']=$tot;
            $totAmount=linearSearchTotal($user_arr,$size_user_arr,$auctionRows_sold[$key]['user_id'],$amount_arr);
            $auctionRows_sold[$key]['tot_amount']=$totAmount;
            $totAuction=substr(linearSearchTotalAuction($new_user_arr,$new_size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr),0,strlen(linearSearchTotalAuction($new_user_arr,$new_size_user_arr,$auctionRows_sold[$key]['user_id'],$auction_arr))-1);
            $auctionRows_sold[$key]['tot_auction']=$totAuction;
        }

        $smarty->assign('total_sold', $total_sold);
        $smarty->assign('auctionRows_sold', $auctionRows_sold);
        $smarty->assign('displayCounterTXT', displayCounter($total_sold, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total_sold, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    $smarty->assign('week_id', $_REQUEST['week_id']);

    $smarty->display('admin_week_wise_weekly_auction_manager_seller.tpl');

}
function combine_seller_invoice(){

    //print_r($_REQUEST['auction_id']);
    $newinvoiceAuction = array();
    $newinvoiceCharge = array();
    $newinvoiceDiscount = array();
    $invoiceArr= array();
    $subTotal=0;
    $invoiceObj = new Invoice();
    $total_till=0;
	$mpe_charge=0;
    foreach($_REQUEST['auction_id'] as $key=>$val){
        $invoiceData = $invoiceObj->fetchInvoiceByAuctionIdSeller($val);
        $invoiceArr[] = $invoiceData['invoice_id'];
        $user_id= $invoiceData['fk_user_id'];
        //$shipping_address=$invoiceData['shipping_address'];
        $billing_address=$invoiceData['billing_address'];
        $invoiceData['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['auction_details']);
        $invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
        if(!empty($invoiceData['auction_details'])){
            foreach($invoiceData['auction_details'] as $key => $value){
                $newinvoiceAuction[] =array('auction_id' => $invoiceData['auction_details'][$key]['auction_id'],'poster_sku' => $invoiceData['auction_details'][$key]['poster_sku'], 'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['auction_details'][$key]['poster_title']), 'amount' => $invoiceData['auction_details'][$key]['amount']);
                $subTotal += $invoiceData['auction_details'][$key]['amount'];
                $total_till += $invoiceData['auction_details'][$key]['amount'];
				$sqlAuction="Select fk_auction_type_id from tbl_auction where auction_id = ".$invoiceData['auction_details'][$key]['auction_id'];
				$resAuction= mysqli_query($GLOBALS['db_connect'],$sqlAuction);
				$fetchSqlAuction= mysqli_fetch_array($resAuction);
				if($fetchSqlAuction['fk_auction_type_id']=='2' || $fetchSqlAuction['fk_auction_type_id']=='5'){
					$mpe_charge += number_format(((($invoiceData['auction_details'][$key]['amount'])*MPE_CHARGE_TO_SELLER_WEEKLY)/100), 2, '.', '');
				}else{
					$mpe_charge += number_format(((($invoiceData['auction_details'][$key]['amount'])*MPE_CHARGE_TO_SELLER)/100), 2, '.', '');
				}
            }
        }
        $invoiceData['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['additional_charges']);
        $invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
        if(!empty($invoiceData['additional_charges'])){
            foreach($invoiceData['additional_charges'] as $key => $value){
                $newinvoiceCharge[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['additional_charges'][$key]['description']), 'amount' => $invoiceData['additional_charges'][$key]['amount']);
                $subTotal += $invoiceData['additional_charges'][$key]['amount'];
            }
        }
        $invoiceData['discounts'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['discounts']);
        $invoiceData['discounts'] = unserialize($invoiceData['discounts']);
        if(!empty($invoiceData['discounts'])){
            foreach($invoiceData['discounts'] as $key => $value){
                $newinvoiceDiscount[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['discounts'][$key]['description']), 'amount' => $invoiceData['discounts'][$key]['amount']);
                $subTotal -= $invoiceData['discounts'][$key]['amount'];
            }
        }
    }

    //$mpe_charge = number_format(((mysqli_real_escape_string($GLOBALS['db_connect'],$total_till)*MPE_CHARGE_TO_SELLER)/100), 2, '.', '');

    $transection_charge = number_format(((mysqli_real_escape_string($GLOBALS['db_connect'],$total_till)*MPE_TRANSACTION_CHARGE_TO_SELLER)/100), 2, '.', '');

    $discount = serialize(array(array('description' => 'MPE Commision', 'amount' => $mpe_charge),
        array('description' => 'Merchant Fee', 'amount' => $transection_charge)));
    $auction_details=serialize($newinvoiceAuction);

    $add_charge=serialize($newinvoiceCharge);

    //$discount=serialize($newinvoiceDiscount);

    $data = array('fk_user_id' => $user_id, 'billing_address' => $billing_address, 'shipping_address' => '',
        'auction_details' => $auction_details, 'additional_charges' => $add_charge,'discounts'=>$discount, 'total_amount' => $subTotal,
        'invoice_generated_on' => date("Y-m-d H:i:s"), 'is_buyers_copy' => 0,'is_combined'=>'1');

    $invoice_id = $invoiceObj->updateData(TBL_INVOICE, $data);

    foreach($invoiceArr as $key=>$val){
        mysqli_query($GLOBALS['db_connect'],"Update tbl_invoice_to_auction set fk_invoice_id = $invoice_id where fk_invoice_id=".$val);
        mysqli_query($GLOBALS['db_connect'],"Delete from tbl_invoice where invoice_id=".$val);
    }
    if($invoice_id > 0){
        echo "1";
    }else{
        echo "2";
    }

}
    function mark_paid_seller_invoice(){
        require_once INCLUDE_PATH."lib/adminCommon.php";
        $dbCommonObj = new Invoice();
        if($update=$dbCommonObj->updateData(TBL_INVOICE,array('paid_on'=>date('Y-m-d :H:i:s'),'is_paid'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true)){
            echo "1";
        }else{
            echo "2";
        }

    }
    function mark_shipped_buyer_invoice(){
        require_once INCLUDE_PATH."lib/adminCommon.php";
        $dbCommonObj = new Invoice();
        if($update=$dbCommonObj->updateData(TBL_INVOICE,array('shipped_date'=>date('Y-m-d :H:i:s'),'is_shipped'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true)){
            echo "1";
        }else{
            echo "2";
        }

    }
	
	function update_auction_status(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$data = array('is_test' => $_REQUEST['val']);
    	$auctionWeekObj = new AuctionWeek();
		$update_event = $auctionWeekObj->updateData(TBL_AUCTION_WEEK,$data,array('auction_week_id' => $_REQUEST['auction_week_id']), true);
		echo "1";
	}
	
	function sync_auctiocn_bid_fun(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$auction_week_id = $_REQUEST['week_id'];
		echo $auction_week_id ;
		$sql = "Select b.* from tbl_bid b,tbl_auction a where b.bid_fk_auction_id = a.auction_id and a.fk_auction_week_id = ".$auction_week_id;
		$rs= mysqli_query($GLOBALS['db_connect'],$sql);
		while($row=mysqli_fetch_array($rs)){
			
			$sql_insert = "Insert into tbl_bid_archive (`bid_fk_user_id`,`bid_fk_auction_id`,`bid_amount`,`is_proxy`,`bid_is_won`,`post_date`,`post_ip`,`is_snipe`) values 
							(".$row['bid_fk_user_id'].",".$row['bid_fk_auction_id'].",".$row['bid_amount'].",".$row['is_proxy'].",'".$row['bid_is_won']."','".$row['post_date']."','".$row['post_ip']."','".$row['is_snipe']."' )" ;
			mysqli_query($GLOBALS['db_connect'],$sql_insert);
			
			$sql_del = "Delete from tbl_bid where bid_id=".$row['bid_id'];
			mysqli_query($GLOBALS['db_connect'],$sql_del);
		
	
		}
		
		echo "1";
	}
	
	function view_snipes(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Auction Snipe Manager");
		$auction_week_id = $_REQUEST['week_id'];
		$dataArr;
		$sql ="Select b.bid_amount,b.bid_is_won,u.firstname,u.lastname,p.poster_title,pi.poster_image,p.poster_sku
				From tbl_bid_archive b,tbl_auction a,tbl_poster p,user_table u,tbl_poster_images pi
				Where a.fk_auction_week_id=".$auction_week_id." and pi.is_default='1' and b.is_snipe='1' and b.bid_fk_auction_id=a.auction_id and a.fk_poster_id=p.poster_id 
                and b.bid_fk_user_id=u.user_id and p.poster_id=pi.fk_poster_id ORDER BY p.poster_title,bid_amount desc ";
				
		$rs=mysqli_query($GLOBALS['db_connect'],$sql);
		while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		$smarty->assign('total', sizeof($dataArr));
		$smarty->assign('snipeArr', $dataArr);
		$smarty->display('admin_weekly_auction_snipe_manager.tpl');
	}
		

?>

<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Event Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "add_event"){
	add_event();
}elseif($_REQUEST['mode'] == "save_event"){
	$chk = checkEvent();
	if($chk == true){
		save_event();
	}else{
		add_event();
	}
}elseif($_REQUEST['mode'] == "update_event"){
	$chk = checkEditEvent();
	if($chk == true){
		update_event();
	}else{
		edit_event();
	}
}elseif($_REQUEST['mode'] == "edit_event"){
	edit_event();
}elseif($_REQUEST['mode'] == "delete_event"){
	del_event();
}elseif($_REQUEST['mode'] == "manage_monthly_auction"){
	manage_monthly_auction();
}elseif($_REQUEST['mode'] == "create_monthly_auction"){
	create_monthly_auction();
}elseif($_REQUEST['mode'] == "save_monthly_auction"){
	$chk = validateMonthlyForm();
	if(!$chk){
		create_monthly_auction();
	}else{
		save_monthly_auction();
	}
}elseif($_REQUEST['mode'] == "show_all_event"){
	show_all_event();
}else{
	show_all_event();
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function show_all_event() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$smarty->assign(array('cat_type_id' => $cat_type_id));
	
	$total_array=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select count(*) total from tbl_event"));
	$total=$total_array['total'];
	$smarty->assign('total', $total);
	if($total>0){
		$obj = new Event();
		//$event = $obj->selectData(TBL_EVENT, array('*'));
		$event = $obj->selectData(TBL_EVENT, array('*'), '1', true, true);
		for($i=0;$i<count($event);$i++)
		{
			$event[$i]['start_date']=date('d-m-Y',strtotime($event[$i]['event_start_date']));
			$event[$i]['end_date']=date('d-m-Y',strtotime($event[$i]['event_end_date']));
		}
		$smarty->assign('event', $event);
		
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->display('admin_event_manager.tpl');
}

/************************************	 END of Middle	  ********************************/

function add_event() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));	
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('admin_add_event.tpl');
}
function del_event()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	extract($_REQUEST);
	$obj = new Event();
	$obj->primaryKey = 'fk_event_id';
	$total = $obj->countData(TBL_AUCTION, array('fk_event_id' => $event_id));
	if($total >0){
		$_SESSION['adminErr'] = "This Event is in Use.You cannot Delete.";
		header("location: ".PHP_SELF."?mode=show_all_event");	
	}else{
		$del=$obj->deleteData(TBL_EVENT,array('event_id' => $event_id));
		if($del){
			$_SESSION['adminErr'] = "This Record is Deleted.";
			header("location: ".PHP_SELF."?mode=show_all_event");	
		}else{
			$_SESSION['adminErr'] = "This Record cannot be Deleted.";
			header("location: ".PHP_SELF."?mode=show_all_event");
		}
	}
}

function edit_event() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	extract($_REQUEST);
	$smarty->assign(array('event_id' => $event_id));
	$row = $obj->selectData(TBL_EVENT, array('*'), array('event_id' => $event_id));
	$row[0]['start_date']=date('m/d/Y',strtotime($row[0]['event_start_date']));
	$row[0]['end_date']=date('m/d/Y',strtotime($row[0]['event_end_date']));
	$smarty->assign('event', $row);
	$smarty->assign('event_id', $event_id);
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('admin_edit_event.tpl');
}

function checkEvent(){

	$errCounter=0;
	$obj = new Category;
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
		$GLOBALS['event_title_err'] = "Please select a Event Title.";
		$errCounter++;
	}else{
		$obj = new Event();
		$obj->primaryKey = 'event_id';
	    $total = $obj->countData(TBL_EVENT,array('event_title' => $event_title));
		if($total > 0){
			$GLOBALS['event_title_err'] = "This Title Alreddy Exists.";
			$errCounter++;	
		}
	}
	
	if($event_desc == ""){
		$GLOBALS['event_desc_err'] = "Please provide Event Description.";
		$errCounter++;
	}
	
	if($errCounter>0){
		return false;
	}else{
		return true;
	}
}

function save_event(){
	extract($_REQUEST);
	$obj = new Event();
	$data = array('event_title' => $event_title,
				  'event_desc' => $event_desc,
				  'event_start_date' => date('Y-m-d',strtotime($start_date)),
				  'event_end_date' => date('Y-m-d',strtotime($end_date)));
	$insert_event = $obj->updateData(TBL_EVENT,$data);
	if($insert_event){
		$_SESSION['adminErr'] = "One event has been created successfully.";
		header("location: admin_event_manager.php?mode=show_all_event");
		exit;
	}else{
		$_SESSION['adminErr'] = "No event has not been created successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

function checkEditEvent(){

	$errCounter=0;
	$obj = new Category;
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
		$obj = new Event();
	    $total=$obj->countData(TBL_EVENT,array('event_title' => $event_title), array('event_id' => $event_id));
		$objAuction=new Auction();
		$totalEventInAuction = $objAuction->countData(TBL_AUCTION, array('fk_event_id' => $event_id));
		if($total > 0){
			$GLOBALS['event_title_err'] = "This Title Alreddy Exists.";
			$errCounter++;	
		}elseif($totalEventInAuction > 0){
			$_SESSION['adminErr'] = "This Record is already in use cannot be edited.";
			$errCounter++;
		}
	}
	
	if($event_desc == ""){
		$GLOBALS['event_desc_err'] = "Please provide Event Description.";
		$errCounter++;
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function update_event()
{
	extract($_REQUEST);		
	$obj = new Event();
	$obj->primaryKey = 'fk_event_id';
	$total = $obj->countData(TBL_AUCTION, array('fk_event_id' => $event_id));

	/* For testing purpost $total has been set zero (0) */
	$total = 0;
	/* For testing purpost $total has been set zero (0) */
	if($total >0){
		$_SESSION['adminErr'] = "This Event is in Use.You cannot Delete.";
		header("location: ".PHP_SELF."?mode=show_all_event");	
	}else{
		$data = array('event_title' => $event_title,
					  'event_desc' => $event_desc,
					  'event_start_date' => date('Y-m-d',strtotime($start_date)),
					  'event_end_date' => date('Y-m-d',strtotime($end_date)));
		$update_event = $obj->updateData(TBL_EVENT,$data,array('event_id' => $event_id), true);
		
		if($update_event){
			$_SESSION['adminErr'] = "Event has been successfully Updated.";
			header("location: admin_event_manager.php?mode=show_all_event");
			exit;
		}else{
			$_SESSION['adminErr'] = "Event has not been Updated successfully.";
			header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
			exit;
		}
	}
}

function manage_monthly_auction()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
	$total = $auctionObj->countMonthlyAuctionByEvent($_REQUEST['event_id']);
	
	if($total>0){
		$auctionRows = $auctionObj->fetchMonthlyAuctionByEvent($_REQUEST['event_id']);
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('event_id', $_REQUEST['event_id']);
	
	$smarty->display('admin_event_wise_monthly_auction_manager.tpl');
}

function create_monthly_auction()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);

	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
		if($key == 'poster_images' && $value != ""){
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
	}
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$obj->orderBy = USERNAME;
	$obj->orderType = ASC;
	//$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'username'), array('status' => 1), true);
	$smarty->assign("userRow", $userRow);
	
	$smarty->assign("event_id", $_REQUEST['event_id']);
	$smarty->display('admin_create_event_wise_monthly_auction_manager.tpl');
}

function validateMonthlyForm(){

	$errCounter = 0;

	if($_POST['user_id'] == ""){
		$GLOBALS['user_id_err'] = "Please select an User.";
		$errCounter++;	
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
		$GLOBALS['genre_err'] = "Please select Grene.";
		$errCounter++;	
	}
	if($_POST['dacade'] == ""){
		$GLOBALS['dacade_err'] = "Please select Dacade.";
		$errCounter++;	
	}
	if($_POST['country'] == ""){
		$GLOBALS['country_err'] = "Please select Country.";
		$errCounter++;	
	}
	if($_POST['condition'] == ""){
		$GLOBALS['condition_err'] = "Please select Description.";
		$errCounter++;	
	}
	if($_POST['poster_desc'] == ""){
		$GLOBALS['poster_desc_err'] = "Please enter Poster Description.";
		$errCounter++;	
	}
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select one image as default.";
		$errCounter++;	
	}

	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
	}elseif(check_int($_POST['asked_price']) == 0){
		$GLOBALS['asked_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['reserve_price'] != "" && check_int($_POST['reserve_price']) == 0){
		$GLOBALS['reserve_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$reserve_price_err = 1;
	}
	
	if($_POST['reserve_price'] != "" && ($asked_price_err != 1 && $reserve_price_err != 1) && ($_POST['reserve_price'] <= $_POST['asked_price'])){
		$GLOBALS['reserve_price_err'] = "Reserved price must be grater than starting price.";
		$errCounter++;
	}
	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}	

	$eventObj = new Event();
	$counter = $eventObj->countData(TBL_EVENT, array("event_id" => $_POST['event_id']));

	if($counter == 0){
		$GLOBALS['event_id_err'] = "Invalid event!";
		$errCounter++;	
	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function save_monthly_auction()
{
	extract($_POST);
	$obj = new Poster();

	$data = array('fk_user_id' => $_REQUEST['user_id'],
				  'poster_title' => add_slashes($poster_title),
				  'poster_desc' => add_slashes($poster_desc),
				  'poster_sku' => generatePassword(6),
				  'flat_rolled' => $flat_rolled,
				  'post_date' => date("Y-m-d H:i:s"),
				  'up_date' => "0000-00-00",
				  'status' => 1,
				  'post_ip' => $_SERVER["REMOTE_ADDR"]);

	$poster_id = $obj->updateData(TBL_POSTER, $data);
	
	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "../poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "../poster_photo/$fileName";
		$destThumb = "../poster_photo/thumbnail";
		if(rename($src, $dest)){
			create_thumbnail($destThumb,$dest,$fileName,100,100);
			//copy($dest, $destThumb."/".$fileName);
		}
		
		$set_default = ($value == $is_default)? 1 : 0;
		$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
												  "poster_image" => $fileName, "is_default" => $set_default));
	}
	
	if($poster_size != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	}

	if($genre != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	}

	if($dacade != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	}

	if($country != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));	
	}
	
	if($condition != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	}
	
	$row = $obj->selectData(TBL_EVENT, array('event_start_date', 'event_end_date'), array("event_id" => $event_id));

	if($_POST['auction_start_am_pm'] == 'am'){
		$start_time = $_POST['auction_start_hour'].":".$_POST['auction_start_min'];
	}else{
		$start_time = ($_POST['auction_start_hour'] + 12).":".$_POST['auction_start_min'];
	}

	if($_POST['auction_end_am_pm'] == 'am'){
		$end_time = $_POST['auction_end_hour'].":".$_POST['auction_end_min'];
	}else{
		$end_time = ($_POST['auction_end_hour'] + 12).":".$_POST['auction_end_min'];
	}
	
	$start_date = $row[0]['event_start_date']." ".$start_time;
	$end_date = $row[0]['event_end_date']." ".$end_time;
	
	$data = array("fk_auction_type_id" => 3,
				  "fk_poster_id" => $poster_id,
				  "fk_event_id" => $event_id,
				  "auction_asked_price" => $asked_price,
				  "auction_reserve_offer_price" => $reserve_price,
				  "auction_actual_start_datetime" => $start_date,
				  "auction_actual_end_datetime" => $end_date,
				  "auction_is_approved" => 1,
				  "is_approved_for_monthly_auction" => 1,
				  "auction_is_sold" => 0,
				  "post_date" => date("Y-m-d H:i:s"),
				  "up_date" => "0000-00-00 00:00:00",
				  "status" => 1,
				  "post_ip" => $_SERVER["REMOTE_ADDR"]);
				  
	$auction_id=$obj->updateData(TBL_AUCTION, $data);		
	$objWantlist=new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
	if($poster_id > 0){		
		$_SESSION['adminErr']="Poster added successfully.";
		header("location: ".PHP_SELF."?mode=show_all_event");
		exit();
	}else{
		$_SESSION['adminErr']="Could not add poster.Please try again.";
		header("location: ".PHP_SELF."?mode=show_all_event");
		exit();
	}
}

?>
<?php
ob_start();
//error_reporting(E_ALL ^ E_NOTICE);

define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}

if($_REQUEST['mode'] == "bulkupload"){
	bulkupload();
}elseif($_REQUEST['mode'] == "save_bulkupload"){
	$chk = validateBulkupload();
	if($chk == true){
		save_bulkupload();
	}else{
		bulkupload();
	}
}elseif($_REQUEST['mode'] == "manualupload"){
	manualupload();
}elseif($_REQUEST['mode'] == "fixed_upload"){
	$chk = validateFixedForm();
	if($chk == true){
		save_fixed_auction();
	}else{
		fixed();
	}	
}elseif($_REQUEST['mode'] == "monthly_upload"){
	$chk = validateMonthlyForm();
	if($chk == true){
		save_monthly_auction();
	}else{
		monthly();
	}	
}elseif($_REQUEST['mode'] == "weekly_upload"){
	$chk = validateWeeklyForm();
	if($chk == true){
		save_weekly_auction();
	}else{
		weekly();
	}	
}elseif($_REQUEST['mode'] == "selling"){
	myAyctions();
}elseif($_REQUEST['mode'] == "pending"){
	myAyctions();
}elseif($_REQUEST['mode'] == "unsold"){
	myAyctions();
}elseif($_REQUEST['mode'] == "sold"){
	myAyctions();
}elseif($_REQUEST['mode'] == "upcoming"){
	myAyctions();
}elseif($_REQUEST['mode'] == "fixed"){
	fixed();
}elseif($_REQUEST['mode'] == "weekly"){
	weekly();
}elseif($_REQUEST['mode'] == "monthly"){
	monthly();
}else{
	dispmiddle();
}

ob_end_flush();

////////////   For page content 

function dispmiddle()
{
	require_once INCLUDE_PATH."lib/common.php";

	$smarty->display("myaccount.tpl");
}

function manualupload()
{
	require_once INCLUDE_PATH."lib/common.php";

	//$smarty->display("manualupload.tpl");
	$smarty->display("choose_options.tpl");
}

function fixed()
{
	require_once INCLUDE_PATH."lib/common.php";

	$obj = new Category();
	$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
		if($key == 'poster_images' && $value != ""){
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
		
	}

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$smarty->display("fixed.tpl");
}

function monthly()
{	
	require_once INCLUDE_PATH."lib/common.php";

	$obj = new Category();
	$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);
    //$where=array("event_start_date" <= date('Y-m-d'),"event_end_date" > date('Y-m-d'));
	$eventSql = "Select * from `tbl_event` where `event_start_date` <= '".date('Y-m-d')."' and event_end_date > '".date('Y-m-d')."'";	
	if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $eventRows[] = $row;
			   }
	 }
	$smarty->assign('eventRows', $eventRows);

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
		if($key == 'poster_images' && $value != ""){
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
	}

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$smarty->display("monthly.tpl");
}

function weekly()
{
	require_once INCLUDE_PATH."lib/common.php";

	$obj = new Category();
	$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
/*if($key == "is_default"){
	echo $value;exit;	
}*/
		if($key == 'poster_images' && $value != ""){
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
	}

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$smarty->display("weekly.tpl");
}

function validateFixedForm()
{
	$errCounter = 0;

	if($_POST['poster_title'] == ""){
		$GLOBALS['poster_title_err'] = "Please enter Poster Title.";
		$errCounter++;	
	}
	if($_POST['genre'] == ""){
		$GLOBALS['genre_err'] = "Please select Grene.";
		$errCounter++;	
	}
	if($_POST['condition'] == ""){
		$GLOBALS['condition_err'] = "Please select Description.";
		$errCounter++;	
	}
	if($_POST['poster_desc'] == ""){
		$GLOBALS['poster_desc_err'] = "Please enter Description.";
		$errCounter++;	
	}
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Asked Price.";
		$errCounter++;
		$asked_price_err = 1;
		
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['offer_price'] == ""){
		$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
		$errCounter++;
		$offer_price_err = 1;
	}elseif(!is_numeric($_POST['offer_price'])){
		$GLOBALS['offer_price_err'] = "Please enter numeric values only.";
		$errCounter++;
		$offer_price_err = 1;	
	}
	
	if($asked_price_err == '' && $offer_price_err == ''){
		if($_POST['is_percentage'] == 1){
			if($_POST['asked_price'] <= ($_POST['asked_price']*$_POST['offer_price']/100)){
				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
				$errCounter++;	
			}
		}else{
			if($_POST['asked_price'] <= $_POST['offer_price']){
				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
				$errCounter++;	
			}
		}
	}
	
	if($_POST['poster_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}else if($_POST['is_default'] == ""){
		$GLOBALS['poster_images_err'] = "Please select one image as default.";
		$errCounter++;	
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function validateMonthlyForm()
{
	$errCounter = 0;
	if($_POST['poster_title'] == ""){
		$GLOBALS['poster_title_err'] = "Please select Poster Title.";
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
	if($_POST['decade'] == ""){
		$GLOBALS['decade_err'] = "Please select a Decade.";
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
		$GLOBALS['poster_desc_err'] = "Please select Grene.";
		$errCounter++;	
	}
	if($_POST['event_month'] == ""){
		$GLOBALS['event_month_err'] = "Please select a Event Month.";
		$errCounter++;	
	}
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['reserve_price'] != '' && !is_numeric($_POST['reserve_price'])){
		$GLOBALS['reserve_price_err'] = "Please enter numeric values only.";
		$errCounter++;
	}elseif($_POST['reserve_price'] != '' && $asked_price_err == ''){
		if($_POST['reserve_price'] <= $_POST['asked_price']){
			$GLOBALS['reserve_price_err'] = "Reserved price must be grater than starting price.";
			$errCounter++;
		}
	}
	
	if($_POST['poster_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}else if($_POST['is_default'] == ""){
		$GLOBALS['poster_images_err'] = "Please select one image as default.";
		$errCounter++;	
	}
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function validateWeeklyForm()
{
	$errCounter = 0;

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
	
	if($_POST['decade'] == ""){
		$GLOBALS['decade_err'] = "Please select a Decade.";
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
	
	if($_POST['start_date'] == ""){
		$GLOBALS['start_date_err'] = "Please enter Start Date.";
		$errCounter++;	
	}
	/* For testing purpost this validation has been set off */
	
	/*elseif($_POST['start_date'] <= date('m/d/Y')){
		$GLOBALS['start_date_err'] = "Start Date must be grater than Today";
		$errCounter++;	
	}*/
	
	/* For testing purpost this validation has been set off */

	if($_POST['end_date'] == ""){
		$GLOBALS['end_date_err'] = "Please enter End Date.";
		$errCounter++;	
	}elseif($_POST['end_date'] <= $_POST['start_date']){
		$GLOBALS['end_date_err'] = "End Date must be greater than Start Date.";
		$errCounter++;	
	}
	
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['buynow_price'] != "" && !is_numeric($_POST['buynow_price'])){
		$GLOBALS['buynow_price_err'] = "Please enter numeric values only.";
		$errCounter++;
	}elseif($_POST['buynow_price'] != "" && $asked_price_err == ''){
		if($_POST['buynow_price'] <= $_POST['asked_price']){
			$GLOBALS['buynow_price_err'] = "Buynow price must be grater than starting price.";
			$errCounter++;
		}
	}
	
	if($_POST['poster_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}else if($_POST['is_default'] == ""){
		$GLOBALS['poster_images_err'] = "Please select one image as default.";
		$errCounter++;	
	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function save_fixed_auction()
{
	extract($_POST);
	$obj = new Poster();

	$data = array('fk_user_id' => $_SESSION['sessUserID'],
				  'poster_title' => $poster_title,
				  'poster_desc' => $poster_desc,
				  'poster_sku' => generatePassword(6),
				  'post_date' => date("Y-m-d H:i:s"),
				  'up_date' => "0000-00-00",
				  'status' => 1,
				  'post_ip' => $_SERVER["REMOTE_ADDR"]);
	$poster_id = $obj->updateData(TBL_POSTER, $data);
	
	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "poster_photo/$fileName";
		//$thumbnail_path="thumbnail/";
		$destThumb = "poster_photo/thumbnail";
		if(rename($src, $dest)){
			//create_thumbnail($destThumb,$dest,$fileName,100,100);
			copy($dest, $destThumb."/".$fileName);
		}
		$set_default = ($value == $is_default)? 1 : 0;
		$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
												  "poster_image" => $fileName, "is_default" => $set_default));
	}

	if($genre != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	}

	if($condition != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	}
	
	$is_percentage = ($is_percentage == '')? '0' : '1';
	
	$data = array("fk_auction_type_id" => 1,
				  "fk_poster_id" => $poster_id,
				  "auction_asked_price" => $asked_price,
				  "auction_reserve_offer_price" => $offer_price,
				  "is_offer_price_percentage" => $is_percentage,
				  "auction_is_approved" => 0,
				  "auction_is_sold" => 0,
				  "auction_note" => $auction_note,
				  "post_date" => date("Y-m-d H:i:s"),
				  "up_date" => "0000-00-00 00:00:00",
				  "status" => 1,
				  "post_ip" => $_SERVER["REMOTE_ADDR"]);
				  
	$obj->updateData(TBL_AUCTION, $data);

	if($poster_id > 0){		
		$_SESSION['Err']="Poster added successfully.";
		header("location: ".PHP_SELF."?mode=pending");
		exit();
	}
	else{
		$_SESSION['Err']="Could not add poster.Please try again.";
		header("location: ".PHP_SELF."?mode=manualupload");
		exit();
	}
}

function save_monthly_auction()
{
	extract($_POST);
	$obj = new Poster();

	$data = array('fk_user_id' => $_SESSION['sessUserID'],
				  'poster_title' => $poster_title,
				  'poster_desc' => $poster_desc,
				  'poster_sku' => generatePassword(6),
				  'post_date' => date("Y-m-d H:i:s"),
				  'up_date' => "0000-00-00",
				  'status' => 1,
				  'post_ip' => $_SERVER["REMOTE_ADDR"]);

	$poster_id = $obj->updateData(TBL_POSTER, $data);
	
	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "poster_photo/$fileName";
		$destThumb = "poster_photo/thumbnail";
		if(rename($src, $dest)){
			//create_thumbnail($destThumb,$dest,$fileName,100,100);
			copy($dest, $destThumb."/".$fileName);
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

	if($decade != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	}

	if($country != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));	
	}
	
	if($condition != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	}
	
	$row = $obj->selectData(TBL_EVENT, array('event_start_date', 'event_end_date'), array("event_id" => $event_month));

	$start_date = $row[0]['event_start_date']." ".AUCTION_START_TIME;
	$end_date = $row[0]['event_end_date']." ".AUCTION_END_TIME;
	
	$data = array("fk_auction_type_id" => 3,
				  "fk_poster_id" => $poster_id,
				  "fk_event_id" => $event_month,
				  "auction_asked_price" => $asked_price,
				  "auction_reserve_offer_price" => $reserve_price,
				  "auction_actual_start_datetime" => $start_date,
				  "auction_actual_end_datetime" => $end_date,
				  "auction_is_approved" => 0,
				  "is_approved_for_monthly_auction" => 0,
				  "auction_is_sold" => 0,
				  "post_date" => date("Y-m-d H:i:s"),
				  "up_date" => "0000-00-00 00:00:00",
				  "status" => 1,
				  "post_ip" => $_SERVER["REMOTE_ADDR"]);
				  
	$obj->updateData(TBL_AUCTION, $data);		

	if($poster_id > 0){		
		$_SESSION['Err']="Poster added successfully.";
		header("location: ".PHP_SELF."?mode=pending");
		exit();
	}
	else{
		$_SESSION['Err']="Could not add poster.Please try again.";
		header("location: ".PHP_SELF."?mode=monthly");
		exit();
	}
}

function save_weekly_auction()
{
	extract($_POST);
	$obj = new Poster();

	$data = array('fk_user_id' => $_SESSION['sessUserID'],
				  'poster_title' => $poster_title,
				  'poster_desc' => $poster_desc,
				  'poster_sku' => generatePassword(6),
				  'post_date' => date("Y-m-d H:i:s"),
				  'up_date' => "0000-00-00",
				  'status' => 1,
				  'post_ip' => $_SERVER["REMOTE_ADDR"]);
	
	$poster_id = $obj->updateData(TBL_POSTER, $data);
	
	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "poster_photo/$fileName";
		$destThumb = "poster_photo/thumbnail";
		if(rename($src, $dest)){
			//create_thumbnail($destThumb,$dest,$fileName,100,100);
			copy($dest, $destThumb."/".$fileName);
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

	if($decade != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	}

	if($country != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));	
	}
	
	if($condition != ""){
		$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	}
	
	list($m,$d,$y) = explode('/', $start_date);
	$start_date = "$y-$m-$d ".AUCTION_START_TIME;
	list($m,$d,$y) = explode('/', $end_date);
	$end_date = "$y-$m-$d ".AUCTION_END_TIME;
	
	$data = array("fk_auction_type_id" => 2,
				  "fk_poster_id" => $poster_id,
				  "auction_asked_price" => $asked_price,
				  "auction_buynow_price" => $buynow_price,
				  "auction_start_date" => $start_date,
				  "auction_end_date" => $end_date,
				  "auction_actual_start_datetime" => $start_date,
				  "auction_actual_end_datetime" => $end_date,
				  "auction_is_approved" => 0,
				  "auction_is_sold" => 0,
				  "post_date" => date("Y-m-d H:i:s"),
				  "up_date" => "0000-00-00 00:00:00",
				  "status" => 1,
				  "post_ip" => $_SERVER["REMOTE_ADDR"]);
	
	$obj->updateData(TBL_AUCTION, $data);

	if($poster_id > 0){		
		$_SESSION['Err']="Poster added successfully.";
		header("location: ".PHP_SELF."?mode=pending");
		exit();
	}else{
		$_SESSION['Err']="Could not add poster.Please try again.";
		header("location: ".PHP_SELF."?mode=weekly");
		exit();
	}
}

function myAyctions()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	$status = $_REQUEST['mode'];
	$objAuction = new Auction();
	$total = $objAuction->countAuctionsByStatus($_SESSION['sessUserID'], $status);
	$auctionRow = $objAuction->fetchAuctionsByStatus($_SESSION['sessUserID'], $status);

	$posterObj = new Poster();
	$posterObj->fetchPosterCategories($auctionRow);
	$posterObj->fetchPosterImages($auctionRow);

	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$smarty->assign('status', $status);
	$smarty->assign('total', $total);
	$smarty->assign('auction', $auctionRow);
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));

	$smarty->display('myauctions.tpl');
}

/*********** Bulkuplod Starts ***********/

function bulkupload()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	foreach ($_FILES as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}

	$smarty->display("bulkupload.tpl");

}

function validateBulkupload()
{
	$errCounter = 0;
	$fileExt = end(explode('.', $_FILES['bulkupload']['name']));
	if(is_uploaded_file($_FILES['bulkupload']['tmp_name']) && $fileExt != 'zip') {
		 $type = $_FILES['bulkupload']['type']; 
		/*if($type!="application/zip" || $type!="application/octet-stream") {
			$GLOBALS["bulkupload_err"] = "Invalid file format.";
			$errCounter++;
		}*/
		$GLOBALS["bulkupload_err"] = "Invalid file format. Please upload zip file only.";
		$errCounter++;
	}elseif(!is_uploaded_file($_FILES['bulkupload']['tmp_name'])){
		$GLOBALS['bulkupload_err']="Please select a zip file.";
		$errCounter++;
	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function save_bulkupload()
{
	// Bulkupload Upload Starts

	if(is_uploaded_file($_FILES['bulkupload']['tmp_name'])){
		$path = "bulkupload/".rand(999, 999999);
		$fieldName = "bulkupload";
		$fileName = rand(999, 999999);
		$uploadedFilename = moveUploadedFile($fieldName, $path, $fileName);
	}
	$zipObj = new ZipArch();
        //if (system("unzip auction.zip -d zipped/")){
        
        $status = $zipObj->unzip($path."/".$uploadedFilename, $dest_dir=false, $create_zip_name_dir=false, $overwrite=false);
        
        //$status = $zipObj->unzip($path."/".$uploadedFilename, $dest_dir=false, $create_zip_name_dir=false, $overwrite=false);

	// Bulkupload Upload Ends
	
	// Read CSV / XLS File Starts
	
	  $row = 1;
          //if(($handle = fopen($path."/".$uploadedFilename, "r")) !== FALSE){
          
          
          if (!is_file($path."/auction/auction.csv")) {
            require_once INCLUDE_PATH . "lib/common.php";
            $genericErrorMessage = "CSV file not found. Check your folder structure.";
            $smarty->assign('genericErrorMessage', $genericErrorMessage);
            $smarty->assign('insertRecordMeg', '');
            $smarty->display("bulkupload.tpl");
            die;
        }
	  if(($handle = fopen($path."/auction/auction.csv", "r")) !== FALSE){
		  $auctionObj = new Auction();
                  parseCSVFile($path."/auction/");
//		  while(($data = fgetcsv($handle, 1024, ",")) !== FALSE){
//			  $num = count($data);
//			  //echo "<p> $num fields in line $row: <br /></p>\n";
//			  $row++;
//			  for($c=0; $c < $num; $c++){
//				   //echo $data[$c] . "<br />\n";
//
//                                   $posterData = array("poster_title" => $data[0], "poster_desc" => $data[1]);
//                                   //print_r($posterData);
//				   /*$poster_id = $auctionObj->updateData(TBL_POSTER, $posterData);
//
//				   $posterImagesArr = explode(',', $posterData[4]);
//				   for($i = 0; $i < count($posterImagesArr); $i++){
//                                        //$posaterImageData = array("poster_id" => $poster_id, "poster_thumb" => , "poster_large" => );
//                                        //$poster_id = $auctionObj->updateData(TBL_POSTER, $posterData);
//				   }
//                                    */
//			  }
//		  }
		  fclose($handle);
	  }

	// Read CSV / XLS File Ends

	return false;
}

function parseCSVFile($pathOfCsvFile) {
    $genericErrorMessage = '';
    $insertRecordMeg ='';
    require_once INCLUDE_PATH."lib/common.php";
    if (!is_file($pathOfCsvFile . 'auction.csv')) {
        $genericErrorMessage = "CSV file not found. Check your folder structure.";
        $smarty->assign('genericErrorMessage', $genericErrorMessage);
        $smarty->assign('insertRecordMeg', '');
        $smarty->display("bulkupload.tpl");
        die;
    }
    if (($handle = fopen($pathOfCsvFile.'auction.csv','r')) !== FALSE) {
            $i = 0;
            $delimiter =',';
            while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== FALSE) {

                for ($j=0; $j<count($lineArray); $j++) {
                    $data2DArray[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
    $newData =array();
    $totalItemInArray = count($data2DArray); //excluding the headers
    $countInnerArray = count($data2DArray[0]);
    //echo '<pre>';print_r($data2DArray[0]);echo '</pre>';

    /*
     * [0] => Array
        (
            [0] => Poster Title
            [1] => Poster SKU
            [2] => Auction Type
            [3] => Poster Description
            [4] => Poster Images (Separated with ",")
            [5] => Condition        !fixed      !month  !weekly
            [6] => Size                         !month  !weekly
            [7] => Genre            !fixed      !month  !weekly
            [8] => Decade                       !month  !weekly
            [9] => Country                      !month  !weekly
            [10] => Asking Price    !fixed
            [11] => Offer Price
            [12] => Starting Price              !month  !weekly
            [13] => Reserve Price
            [14] => Buy Now
            [15] => Month Event                 !month
            [16] => Auction Start Date                  !weekly
            [17] => Auction End Date                    !weekly
            [18] => Auction Note
        )
     */
    
    for($c=0;$c<$totalItemInArray;$c++)
    {
        if($c==0){
            //0 the element contain the headers of the csv files so omit this index.
            continue;
        }
       
        //Images in the image folder validating and renameing
        $posterImage = explode(',',$data2DArray[$c][4]);
        if (!empty($posterImage)) {
            foreach ($posterImage as $imageKey) {
                $imageKey = trim($imageKey);
                
                //var_dump(is_file($pathOfCsvFile . 'poster_photo/' . $imageKey));
                if (!is_file($pathOfCsvFile . 'poster_photo/' . $imageKey)) {
                    continue;   //if img not found check for the next image
                }
            }
            //echo "<br>index $c - ".$renamedImageName = renameImage($pathOfCsvFile,$posterImage);//$path."/auction/"
            //$data2DArray[$c][4] = $renamedImageName;
        }else{
            //echo '<br><br>Unable to add this file. No poster found<br><br> ';
            $genericErrorMessage ="Sorry unable to proceed. Poster not found.";
            break;
        }

        
        for($innerElement = 0; $innerElement < $countInnerArray; $innerElement++)
        {
            $fixedConditionId = '';
            $fixedGenreId = '';
            $sizeCat = '';
            $decadeCat = '';
            $countryCat ='';
            
            $attValueString = $data2DArray[$c][$innerElement];
            $arr_noEmpty = array(0,2,3,4);//These items genral for all auction type

            //Checking for empty for genrela eg: title, sku etc..
            if(in_array($innerElement ,$arr_noEmpty))
            {
                if(isEmpty($attValueString)){
                    //echo '<br><br>Unable to add this file<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. All fields need to be filled up.";
                    break;
                }
            }

            
            //Auction type FIXED
            if($data2DArray[$c][$innerElement]=='fixed')
            {
                //echo '<p>auction type Fixed</br>';
                if(isEmpty($data2DArray[$c][10])){
                    //echo '<br><br>Unable to add this file missing asked price<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. Asked price missing.";
                    break;
                }

                if(isEmpty($data2DArray[$c][5]) && isEmpty($data2DArray[$c][7])){
                    //echo '<br><br>Unable to add this file missing condition value<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. Condition value missing.";
                    break;
                }

                //Getting the category id
                $fixedConditionId = fetchCategoryId($data2DArray[$c][5]);
                $fixedGenreId = fetchCategoryId($data2DArray[$c][7]);
                if($fixedConditionId=='' || $fixedGenreId ==''){
                    //echo '<br><br>Unable to add this file. Category condition and genere not found for fixed<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. Condition and genre are missing.";
                    break;
                }
                $insertRecordMeg = insertRecord($data2DArray[$c], array($fixedConditionId,$fixedGenreId,),$data2DArray[$c][$innerElement] ,$pathOfCsvFile );
            }//end of fixed


            //Auction type WEEKLY
            if($data2DArray[$c][$innerElement]=='weekly')
            {
                if (    isEmpty($data2DArray[$c][5]) || isEmpty($data2DArray[$c][6])  ||
                        isEmpty($data2DArray[$c][7]) || isEmpty($data2DArray[$c][8])  ||
                        isEmpty($data2DArray[$c][9]) || isEmpty($data2DArray[$c][12]) ||
                        isEmpty($data2DArray[$c][16] || isEmpty($data2DArray[$c][17]))
                   ){
                    //echo '<br><br>Unable to add this file. In weekly options this need to be filled up<br><br> ';
                    $genericErrorMessage ="Sorry unable to proceed. Catogories are not properly formatted.";
                    break;
                }

                //Fetching the category id by searching the cat name
                $fixedConditionId = fetchCategoryId($data2DArray[$c][5]);
                $sizeCat = fetchCategoryId($data2DArray[$c][6]);
                $fixedGenreId = fetchCategoryId($data2DArray[$c][7]);
                $decadeCat = fetchCategoryId($data2DArray[$c][8]);
                $countryCat = fetchCategoryId($data2DArray[$c][9]);

                //If any of the category id is blank the error will be thrown and excution stops
                if($fixedConditionId=='' || $sizeCat =='' || $fixedGenreId=='' ||  $decadeCat=='' || $countryCat==''){
                    //echo '<br><br>Unable to add this file. Category condition and genere not found for fixed<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. Category not found for weekly auction.";
                    break;
                }

                $insertRecordMeg = insertRecord($data2DArray[$c], array($fixedConditionId, $sizeCat, $fixedGenreId, $decadeCat, $countryCat), $data2DArray[$c][$innerElement], $pathOfCsvFile);
            }//End of weekly


           
            //Auction type MONTHLY
            if($data2DArray[$c][$innerElement]=='monthly')
            {
                if( isEmpty($data2DArray[$c][5]) || isEmpty($data2DArray[$c][6])  ||
                    isEmpty($data2DArray[$c][7]) || isEmpty($data2DArray[$c][8])  ||
                    isEmpty($data2DArray[$c][9]) || isEmpty($data2DArray[$c][12]) ||
                    isEmpty($data2DArray[$c][15]) )
                {
                    //echo '<br><br>Unable to add this file. In monthly options this need to be filled up<br><br> ';
                    $genericErrorMessage ="Sorry unable to proceed. Monthly auction this fields need to be filled up.";
                    break;
                }

                //Fetching the category id by searching the cat name
                $fixedConditionId = fetchCategoryId($data2DArray[$c][5]);
                $sizeCat = fetchCategoryId($data2DArray[$c][6]);
                $fixedGenreId = fetchCategoryId($data2DArray[$c][7]);
                $decadeCat = fetchCategoryId($data2DArray[$c][8]);
                $countryCat = fetchCategoryId($data2DArray[$c][9]);

                //If any of the category id is blank the error will be thrown and excution stops
                if($fixedConditionId=='' || $sizeCat =='' || $fixedGenreId=='' ||  $decadeCat=='' || $countryCat==''){
                    //echo '<br><br>Unable to add this file. Category condition and genere not found for fixed<br><br>----------------------- ';
                    $genericErrorMessage ="Sorry unable to proceed. Category not found for the monthly auction type.";
                    break;
                }
                $insertRecordMeg = insertRecord($data2DArray[$c], array($fixedConditionId, $sizeCat, $fixedGenreId, $decadeCat, $countryCat), $data2DArray[$c][$innerElement], $pathOfCsvFile);
            }// end of monthly
             
        }//end of first for loop
    }
   
    if($genericErrorMessage==''){
        $genericErrorMessage ='Successfully uploaded.';
    }
    $smarty->assign('genericErrorMessage',$genericErrorMessage);
    $smarty->assign('insertRecordMeg',$insertRecordMeg);
    $smarty->display("bulkupload.tpl");
}//eof function


function isEmpty($string){
    return ($string=='');
}

function fetchCategoryId($catNameValue) {
    require_once INCLUDE_PATH . "lib/common.php";
    $returnCatid = '';
    $sql = "SELECT cat_id FROM tbl_category WHERE cat_value ='" . $catNameValue . "'";
    $result = mysqli_query($GLOBALS['db_connect'],$sql);
    if (mysqli_num_rows($result) > 0) {
        $fixedRow = mysqli_fetch_array($result);
        $returnCatid = $fixedRow['cat_id'];
    }

    return $returnCatid;
}

function insertRecord($csvDataArray, $categoryIdArray, $auctionType, $pathOfCsvFile){
    require_once INCLUDE_PATH . "lib/common.php";
    $erorr ='';
    $debug=false;
    if(isset($_GET) && $_GET['debug'] =='true')
        $debug = true;
   
    //Poster Insertion
    if (!empty($csvDataArray) && $debug==false) {
        $posterArray = array(
            'fk_user_id' => $_SESSION['sessUserID'],
            'poster_title' => trim($csvDataArray[0]),
            'poster_desc' => trim($csvDataArray[3]),
            'poster_sku' => generatePassword(6),
            'post_date' => date("Y-m-d h:i:s"),
            'post_ip' => $_SERVER['REMOTE_ADDR'],
        );

        $sqlPosterInsert = 'INSERT INTO tbl_poster (';
        foreach($posterArray as $key => $values){
            $sqlPosterInsert .= " $key,";
        }
        $sqlPosterInsert = substr($sqlPosterInsert, 0, -1) . ') VALUES(';
        foreach($posterArray as $key => $values){
            $sqlPosterInsert .= " '$values',";
        }
        $sqlPosterInsert = substr($sqlPosterInsert, 0, -1). ')';

        if (mysqli_query($GLOBALS['db_connect'],$sqlPosterInsert)) {
            $insertedPosterId =  mysqli_insert_id($GLOBALS['db_connect']);

            $posterImageFromCSV = array();
            $posterImageArray = array();
            //Adding the poster images
            $posterImageFromCSV = explode(',',$csvDataArray[4]);
            $posterImageArray = renameImage($pathOfCsvFile,$posterImageFromCSV);
            for($i=0;$i<count($posterImageArray);$i++)
            {
                if($i==0)
                    $defaultImg = 1;
                else
                    $defaultImg = 0;
                //Inserting in the poster
                $posterPictureArray = array(
                    'fk_poster_id' => $insertedPosterId,
                    'poster_thumb' => $posterImageArray[$i],
                    'poster_image' => $posterImageArray[$i],
                    'is_default'   => $defaultImg,
                );
                $sqlPosterImageInsert = 'INSERT INTO tbl_poster_images (';
                
                foreach ($posterPictureArray as $key => $values) {
                    $sqlPosterImageInsert .= " $key,";
                }
                $sqlPosterImageInsert = substr($sqlPosterImageInsert, 0, -1) . ') VALUES(';
                foreach ($posterPictureArray as $key => $values) {
                    $sqlPosterImageInsert .= " '$values',";
                }
                $sqlPosterImageInsert = substr($sqlPosterImageInsert, 0, -1) . ')';
                if($posterImageArray[$i]!='' ){
                    mysqli_query($GLOBALS['db_connect'],$sqlPosterImageInsert)or die('<br><br>Error in insertion <br>' . mysqli_error($GLOBALS['db_connect']));
                }
                

            }//Endo of image insert for loop

            //Adding the category to the poster
            for($i=0;$i<count($categoryIdArray);$i++){

                $posterCatAttributes = array(
                    'fk_poster_id'  =>  $insertedPosterId,
                    'fk_cat_id'     =>  $categoryIdArray[$i],
                );
                $sqlPosterCatInsert = 'INSERT INTO tbl_poster_to_category (';
                foreach ($posterCatAttributes as $key => $values) {
                    $sqlPosterCatInsert .= " $key,";
                }
                $sqlPosterCatInsert = substr($sqlPosterCatInsert, 0, -1) . ') VALUES(';
                foreach ($posterCatAttributes as $key => $values) {
                    $sqlPosterCatInsert .= " '$values',";
                }

                $sqlCheckDuplicate = "SELECT COUNT(*) AS is_duplicate FROM tbl_poster_to_category WHERE fk_poster_id ='$insertedPosterId' AND fk_cat_id ='$categoryIdArray[$i]'";
                $resultDuplicate = mysqli_query($GLOBALS['db_connect'],$sqlCheckDuplicate);
                $duplicateRow = mysqli_fetch_array($resultDuplicate);
                
                if($duplicateRow['is_duplicate']==0){
                    $sqlPosterCatInsert = substr($sqlPosterCatInsert, 0, -1) . ')';
                    mysqli_query($GLOBALS['db_connect'],$sqlPosterCatInsert)or die('<br><br>Error in insertion <br>' . mysqli_error($GLOBALS['db_connect']));
                }
                
            }//end of category for loop

            /**********************Adding to the Auction****************************/
            //Insert in the auction table
            //Setting the type id of auction
            $auctionTypeId ='1';
            if ($csvDataArray[2]=='fixed')
                $auctionTypeId ="1";
            else if($csvDataArray[2]=='weekly')
                $auctionTypeId ="2";
            else if($csvDataArray[2]=='monthly')
                $auctionTypeId ="3";

            //Searching the event id of the auction
            $eventId ='';
            if(!empty($csvDataArray[15])){
                $sqlSearchEventId = "SELECT event_id FROM tbl_event WHERE event_title = '".$csvDataArray[15]."'";
                $eventResult = mysqli_query($GLOBALS['db_connect'],$sqlSearchEventId)or die('<br>Error in event title. '.mysqli_error($GLOBALS['db_connect']));
                if(mysqli_num_rows($eventResult)>0){
                    $rowEvent = mysqli_fetch_array($eventResult);
                    $eventId = $rowEvent['event_id'];
                }

            }

            //Determining the offer price is percentage or not
            $isOfferPercentage = 0;
            $offerPrice = $csvDataArray[11];
            $posistion = strpos(trim($csvDataArray[11]), '%');
            $strLength = strlen(trim($csvDataArray[11]));

            if(($strLength-1) == $posistion && $csvDataArray[11]!=''){ //If percentage sign present means Fixed
                $isOfferPercentage = 1;
                $offerPrice = trim($csvDataArray[11]);
                $offerPrice = substr($offerPrice, 0 , -1);
                
            }else{
                if ($csvDataArray[13] != '') {
                    $offerPrice = trim($csvDataArray[13]);
                }
            }
            
            if($offerPrice!=''){
                $offerPrice = number_format($offerPrice, 2, '.', '');
            }

            

            $startDate = ($csvDataArray[16]=='') ? '0000-00-00 00:00:00' : date('Y-m-d H:i:s', strtotime($csvDataArray[16]));
            $endDate =   ($csvDataArray[17]=='') ? '0000-00-00 00:00:00' : date('Y-m-d H:i:s', strtotime($csvDataArray[17]));

            $startingPrice = 0;
            $startingPrice = ($csvDataArray[10]!='') ? number_format($csvDataArray[10], 2, '.', '') : '';
            if($startingPrice=='' && $csvDataArray[2]!='fixed'){
                if($csvDataArray[12]!=''){
                    $startingPrice = trim($csvDataArray[12]);
                    $startingPrice = number_format($startingPrice, 2, '.', '');

                }
            }

            
            $auctionDataArray=array(
             'fk_auction_type_id'                => $auctionTypeId,
             'fk_poster_id'                      => $insertedPosterId,
             'fk_event_id'                       => $eventId,
             'auction_asked_price'               => $startingPrice,
             'auction_reserve_offer_price'       => $offerPrice,
             'is_offer_price_percentage'         => $isOfferPercentage,
             'auction_buynow_price'              => ($csvDataArray[14]!='') ? number_format($csvDataArray[14], 2, '.', '') : '',
             'auction_start_date'                => $startDate,
             'auction_end_date'                  => $endDate,
             'auction_is_approved'               => 0,
             'is_approved_for_monthly_auction'   => 0,
             'auction_is_sold'                   => 0,
             'auction_note'                      => $csvDataArray[1],
             'post_date'                         => date("Y-m-d h:i:s"),
             'status'                            => 1,
             'post_ip'                           => $_SERVER['REMOTE_ADDR'],
            );

            $sqlAuctionInsert = 'INSERT INTO tbl_auction (';
            foreach ($auctionDataArray as $key => $values) {
                $sqlAuctionInsert .= " $key,";
            }
            $sqlAuctionInsert = substr($sqlAuctionInsert, 0, -1) . ') VALUES(';
            foreach ($auctionDataArray as $key => $values) {
                $sqlAuctionInsert .= " '$values',";
            }
            $sqlAuctionInsert = substr($sqlAuctionInsert, 0, -1) . ')';
            mysqli_query($GLOBALS['db_connect'],$sqlAuctionInsert) or die('<br><br>Error in insertion <br>' . mysqli_error($GLOBALS['db_connect']));
            /**********************Adding to the Auction****************************/

        }//end of posterinsert if()
        else {
            $erorr = '<br>There is some error in the operation in - '.$auctionType.'.
                      <br>Unable to add the poster data<br>['.mysqli_error($GLOBALS['db_connect']).']';
            
        }

    }else{
        //echo '<pre>';print_r($csvDataArray);echo '</pre>';
        $erorr = '<br>This is in testing mode. No insertion operation will be performed<br>';
    }

    return $error;
}//end of insertRecord()

function renameImage($pathOfAuctionDir,$imageArray){
        $src = $pathOfAuctionDir.'poster_photo/';
        $posterRenamedArr =array();
        $returnValue='';
        foreach($imageArray as $img){
            $img = trim($img);
            $imgInfo = pathinfo($src.$img);
            $extension = trim($imgInfo['extension']);
            //$fileName = rand(1000, 9999) . '.' . $extension;
            $fileName = rand(1000, 9999) . '__'. $img;
            $dest = "poster_photo/$fileName";
            $destThumb = "poster_photo/thumbnail/$fileName";
            $sourceFile = $src.$img;
            if(is_file($sourceFile)){
//              if (rename($sourceFile, $dest)) {
//                 copy($dest, $destThumb);
//              }
                if (copy($sourceFile, $dest)){
                     copy($dest, $destThumb);
                }
                
                $posterRenamedArr[]= $fileName;
            }
        }
         
        if(!empty($posterRenamedArr)){
            //$returnValue = implode(',',$posterRenamedArr);
            $returnValue = $posterRenamedArr;
        }
        return $returnValue;
    }
?>
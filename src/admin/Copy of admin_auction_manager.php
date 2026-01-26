<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Auction Manager");

ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "edit_fixed"){
	edit_fixed();
}elseif($_REQUEST['mode'] == "update_fixed"){
	$chk = validateFixedForm();
	if($chk == true){
		update_fixed();
	}else{
		edit_fixed();
	}
}elseif($_REQUEST['mode'] == "edit_weekly"){
	edit_weekly();
}elseif($_REQUEST['mode'] == "update_weekly"){
	$chk = validateWeeklyForm();
	if($chk == true){
		update_weekly();
	}else{
		edit_weekly();
	}
}elseif($_REQUEST['mode'] == "edit_monthly"){
	edit_monthly();
}elseif($_REQUEST['mode'] == "update_monthly"){
	$chk = validateMonthlyForm();
	if($chk == true){
		update_monthly();
	}else{
		edit_monthly();
	}
}elseif($_REQUEST['mode'] == "fixed"){
	fixedPriceSale();
}elseif($_REQUEST['mode'] == "weekly"){
	weeklyAuction();
}elseif($_REQUEST['mode'] == "monthly"){
	monthlyAuction();
}else{
	fixedPriceSale();
}

ob_end_flush();
/*************************************************/

/*********************	START of FixedPriceSale Function	**********/

function fixedPriceSale() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Auction();
	
	if($_REQUEST['search'] == 'waiting'){
		$where["auction_is_approved"] = 0;
	}elseif($_REQUEST['search'] == 'approved'){
		$where["auction_is_approved"] = 1;
		$where["auction_is_sold"] = 0;
	}elseif($_REQUEST['search'] == 'disapproved'){
		$where["auction_is_approved"] = 2;
	}elseif($_REQUEST['search'] == 'sold'){
		$where["auction_is_sold"] = 1;
	}else{
		$countWhere['fk_auction_type_id'] = 1;
	}
	$countWhere = $where;
	$countWhere['fk_auction_type_id'] = 1;
	$total = $obj->countData(TBL_AUCTION, $countWhere);
	
	if($total>0){
		$auctionRows = $obj->fetchFixedSale($where);
//echo "<pre>";print_r($auctionRows);
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->display('admin_fixed_auction_manager.tpl');
}

function weeklyAuction() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Auction();

	if($_REQUEST['search'] == 'waiting'){
		$where["auction_is_approved"] = 0;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 2;
	}elseif($_REQUEST['search'] == 'approved'){
		$where = "auction_is_approved = '1' AND auction_is_sold = '0' AND auction_end_date >= now()";
		$countWhere = "fk_auction_type_id = '2' AND ".$where;
	}elseif($_REQUEST['search'] == 'disapproved'){
		$where["auction_is_approved"] = 2;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 2;
	}elseif($_REQUEST['search'] == 'sold'){
		$where["auction_is_sold"] = 1;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 2;
	}elseif($_REQUEST['search'] == 'unsold'){
		$where = "auction_is_approved = '1' AND auction_is_sold = '0' AND auction_end_date <= now()";
		$countWhere = "fk_auction_type_id = '2' AND ".$where;
	}else{
		$countWhere['fk_auction_type_id'] = 2;
	}
	$total = $obj->countData(TBL_AUCTION, $countWhere);
	
	if($total>0){
		$auctionRows = $obj->fetchWeeklyAuctions($where);

		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->display('admin_weekly_auction_manager.tpl');
}

function monthlyAuction() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Auction();
	
	if($_REQUEST['search'] == 'waiting'){
		$where["auction_is_approved"] = 0;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 3;
	}elseif($_REQUEST['search'] == 'waiting_receive'){
		$where["auction_is_approved"] = 1;
		$where["is_approved_for_monthly_auction"] = 0;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 3;
	}elseif($_REQUEST['search'] == 'approved'){
		$where = "auction_is_approved = '1' AND is_approved_for_monthly_auction = '1' AND auction_is_sold = '0' AND event_end_date >= now()";
		$countWhere = "fk_auction_type_id = '3' AND ".$where;
	}elseif($_REQUEST['search'] == 'disapproved'){
		$where["auction_is_approved"] = 2;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 3;
	}elseif($_REQUEST['search'] == 'sold'){
		$where["auction_is_sold"] = 1;
		$countWhere = $where;
		$countWhere['fk_auction_type_id'] = 3;
	}elseif($_REQUEST['search'] == 'unsold'){
		$where = "fk_auction_type_id = '3' AND auction_is_approved = '1' AND auction_is_sold = '0' AND event_end_date <= now()";
		$countWhere = $where;
	}else{
		$countWhere['fk_auction_type_id'] = 3;
	}	
	
	$total = $obj->countMonthlyAuction($countWhere);

	if($total>0){
		$auctionRows = $obj->fetchMonthlyAuctions($where);
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->display('admin_monthly_auction_manager.tpl');
}

/************************************	 END of Middle	  ********************************/


/********************** Edit Fixed price starts *************************/

function edit_fixed() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

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
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	//echo "<pre>";print_r($posterImageRows);
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}

	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$smarty->display('admin_edit_fixed_auction_manager.tpl');
}

function validateFixedForm(){

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
		$GLOBALS['condition_err'] = "Please select a Condition.";
		$errCounter++;	
	}
	if($_POST['poster_desc'] == ""){
		$GLOBALS['poster_desc_err'] = "Please enter Description.";
		$errCounter++;	
	}
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Asked Price.";
		$errCounter++;	
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}
	
	if($_POST['offer_price'] == ""){
		$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
		$errCounter++;	
	}elseif(!is_numeric($_POST['offer_price'])){
		$GLOBALS['offer_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}
	
	/*if($_POST['poster_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}*/

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_fixed(){
	extract($_REQUEST);
	$obj = new Auction();

	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $offer_price,
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => $auction_note);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => $poster_title, 'poster_desc' => $poster_desc);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));

	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "../poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "../poster_photo/$fileName";
		$destThumb = "../poster_photo/thumbnail/$fileName";
		if(rename($src, $dest)){
			copy($dest, $destThumb);
		}
		
		$is_default = ($key == 0)? 1 : 0;
		$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
												  "poster_image" => $fileName, "is_default" => $is_default));
	}

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been created successfully.";
		header("location: ".PHP_SELF."?mode=fixed");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?cat_type_id=".$fk_cat_type_id);
	}*/
}

/******************* Edit Weekly Auction Starts *****************/

function edit_weekly() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

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
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	//echo "<pre>";print_r($posterImageRows);

	list($date,$time) = explode(' ', $auctionRow[0]['auction_start_date']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_start_date'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_end_date']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_end_date'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));

	$smarty->display('admin_edit_weekly_auction_manager.tpl');
}

function validateWeeklyForm(){

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
	if($_POST['start_date'] == ""){
		$GLOBALS['start_date_err'] = "Please enter Start Date.";
		$errCounter++;	
	}
	if($_POST['end_date'] == ""){
		$GLOBALS['end_date_err'] = "Please enter End Date.";
		$errCounter++;	
	}
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;	
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}
	
	if($_POST['buynow_price'] != "" && !is_numeric($_POST['buynow_price'])){
		$GLOBALS['buynow_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_weekly(){
	extract($_REQUEST);
	$obj = new Auction();

	list($m,$d,$y) = explode('/', $start_date);
	$start_date = "$y-$m-$d";
	list($m,$d,$y) = explode('/', $end_date);
	$end_date = "$y-$m-$d";

	$auctionData = array("auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date, "auction_end_date" => $end_date);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => $poster_title, 'poster_desc' => $poster_desc);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "../poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "../poster_photo/$fileName";
		$destThumb = "../poster_photo/thumbnail/$fileName";
		if(rename($src, $dest)){
			copy($dest, $destThumb);
		}
		
		$is_default = ($key == 0)? 1 : 0;
		$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
												  "poster_image" => $fileName, "is_default" => $is_default));
	}

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}

/******************* Edit Monthly Auction Starts *****************/

function edit_monthly() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);

	$eventRows = $obj->selectData(TBL_EVENT, array('*'));
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
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	//echo "<pre>";print_r($posterImageRows);

	list($date,$time) = explode(' ', $auctionRow[0]['auction_start_date']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_start_date'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_end_date']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_end_date'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$smarty->display('admin_edit_monthly_auction_manager.tpl');
}

function validateMonthlyForm(){

	$errCounter = 0;

	if($_POST['poster_title'] == ""){
		$GLOBALS['poster_title_err'] = "Please enter Poster Title.";
		$errCounter++;	
	}
	if($_POST['event_month'] == ""){
		$GLOBALS['event_month_err'] = "Please enter Event Month.";
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

	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;	
	}elseif(!is_numeric($_POST['asked_price'])){
		$GLOBALS['asked_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}
	
	if($_POST['reserve_price'] != "" && !is_numeric($_POST['reserve_price'])){
		$GLOBALS['reserve_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_monthly(){
	extract($_REQUEST);
	$obj = new Auction();

	list($m,$d,$y) = explode('/', $start_date);
	$start_date = "$y-$m-$d";
	list($m,$d,$y) = explode('/', $end_date);
	$end_date = "$y-$m-$d";

	$auctionData = array("auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date, "auction_end_date" => $end_date);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => $poster_title, 'poster_desc' => $poster_desc);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	$posterArr = explode(',', trim($poster_images, ','));
	foreach($posterArr as $key => $value){
		$src = "../poster_photo/temp/$random/$value";
		$fileExt = end(explode('.', $value));
		$fileName = rand(1000, 9999).'.'.$fileExt;
		$dest = "../poster_photo/$fileName";
		$destThumb = "../poster_photo/thumbnail/$fileName";
		if(rename($src, $dest)){
			copy($dest, $destThumb);
		}
		
		$is_default = ($key == 0)? 1 : 0;
		$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
												  "poster_image" => $fileName, "is_default" => $is_default));
	}

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".PHP_SELF."?mode=monthly");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}


?>
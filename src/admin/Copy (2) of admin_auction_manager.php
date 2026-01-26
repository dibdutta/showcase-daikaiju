<?php
/**************************************************/

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
}elseif($_REQUEST['mode'] == "manage_invoice"){
	manage_invoice();
}elseif($_REQUEST['mode'] == "fixed"){
	fixedPriceSale();
}elseif($_REQUEST['mode'] == "weekly"){
	weeklyAuction();
}elseif($_REQUEST['mode'] == "monthly"){
	monthlyAuction();
}elseif($_REQUEST['mode'] == "view_details"){
	view_details();
}elseif($_REQUEST['mode'] == "view_details_offer"){
	view_details_offer();
}elseif($_REQUEST['mode'] == "view_monthly"){
	view_monthly();
}elseif($_REQUEST['mode'] == "view_fixed"){
	view_fixed();
}elseif($_REQUEST['mode'] == "view_weekly"){
	view_weekly();
}elseif($_REQUEST['mode'] == "update_invoice_charge"){
	update_invoice_charge();
}elseif($_REQUEST['mode'] == "update_invoice_discount"){
	update_invoice_discount();
}elseif($_REQUEST['mode'] == "delete_invoice_charge"){
	delete_invoice_charge();
}elseif($_REQUEST['mode'] == "delete_invoice_discount"){
	delete_invoice_discount();
}elseif($_REQUEST['mode'] == "approve_invoice"){
	approve_invoice();
}elseif($_REQUEST['mode'] == "cancel_invoice"){
	cancel_invoice();
}elseif($_REQUEST['mode'] == "reopen_fixed"){
	reopen_fixed();
}elseif($_REQUEST['mode'] == "reopen_fixed_auction"){
	reopen_fixed_auction();
}elseif($_REQUEST['mode'] == "reopen_weekly"){
	reopen_weekly();
}elseif($_REQUEST['mode'] == "reopen_weekly_auction"){
	reopen_weekly_auction();
}elseif($_REQUEST['mode'] == "reopen_monthly"){
	reopen_monthly();
}elseif($_REQUEST['mode'] == "reopen_monthly_auction"){
	reopen_monthly_auction();
}else{
	fixedPriceSale();
}

ob_end_flush();
/*************************************************/

/*********************	START of FixedPriceSale Function	**********/

function fixedPriceSale() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
	$total = $auctionObj->countFixedPriceSaleByStatus($_REQUEST['search']);
	if($total>0){
		$auctionRows = $auctionObj->fetchFixedPriceSaleByStatus($_REQUEST['search']);
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
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
	$total = $auctionObj->countWeeklyAuctionByStatus($_REQUEST['search']);
	
	if($total>0){
		$auctionRows = $auctionObj->fetchWeeklyAuctionByStatus($_REQUEST['search']);
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
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
	$total = $auctionObj->countMonthlyAuctionByStatus($_REQUEST['search']);
	
	if($total>0){
		$auctionRows = $auctionObj->fetchMonthlyAuctionByStatus($_REQUEST['search']);
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
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']); 

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	
	$posterRow[0]['poster_desc'] = strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title'] = strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

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

function view_fixed() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']); 

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

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
	$smarty->display('admin_view_fixed_auction_manager.tpl');
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
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select one image as default.";
		$errCounter++;	
	}
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Asked Price.";
		$errCounter++;
		$asked_price_err = 1;
	}elseif(check_int($_POST['asked_price'])==0){
		$GLOBALS['asked_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['offer_price'] == ""){
		$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
		$errCounter++;
		$offer_price_err = 1;
	}elseif(check_int($_POST['offer_price'])==0){
		$GLOBALS['offer_price_err'] = "Please enter integer values only.";
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
	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}

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
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note));
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), 'flat_rolled' => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));

	if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		foreach($posterArr as $key => $value){
			$src = "../poster_photo/temp/$random/$value";
			$fileExt = end(explode('.', $value));
			$fileName = rand(1000, 9999).'.'.$fileExt;
			if($is_default == $value){
				$is_default = $fileName;
			}
			$dest = "../poster_photo/$fileName";
			$destThumb = "../poster_photo/thumbnail";
			if(rename($src, $dest)){
				create_thumbnail($destThumb,$dest,$fileName,100,100);
				//copy($dest, $destThumb."/".$fileName);
			}
			$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
													  "poster_image" => $fileName));
		}
	}

	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default), true);

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".PHP_SELF."?mode=fixed");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?cat_type_id=".$fk_cat_type_id);
	}*/
}

/******************* Edit Weekly Auction Starts *****************/

function edit_weekly() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_start_date']);
	$auctionRow[0]['auction_start_date'] = "$m/$d/$y";
	
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_end_date']);
	$auctionRow[0]['auction_end_date'] = "$m/$d/$y";

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc'] = strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title'] = strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));

	$smarty->display('admin_edit_weekly_auction_manager.tpl');
}

function view_weekly()
{
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_start_date']);
	$auctionRow[0]['auction_start_date'] = "$m/$d/$y";
	
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_end_date']);
	$auctionRow[0]['auction_end_date'] = "$m/$d/$y";

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));

	$smarty->display('admin_view_weekly_auction_manager.tpl');

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
	
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select one image as default.";
		$errCounter++;	
	}

	if($_POST['start_date'] == ""){
		$GLOBALS['start_date_err'] = "Please enter Start Date.";
		$errCounter++;	
	}/*elseif($_POST['start_date'] <= date('m/d/Y')){
		$GLOBALS['start_date_err'] = "Start Date must be grater than Today";
		$errCounter++;	
	}*/
	
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
	}elseif(check_int($_POST['asked_price']) == 0){
		$GLOBALS['asked_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['buynow_price'] == ""){
		$GLOBALS['buynow_price_err'] = "Please enter Buynow Price.";
		$errCounter++;	
	}elseif(check_int($_POST['buynow_price']) == 0){
		$GLOBALS['buynow_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$buynow_price_err = 1;
	}
	
	if(($asked_price_err != 1 && $buynow_price_err != 1) && ($_POST['buynow_price'] <= $_POST['asked_price'])){
		$GLOBALS['buynow_price_err'] = "Buynow price must be grater than starting price.";
		$errCounter++;
	}
	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
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
	$start_date_picker = "$y-$m-$d ";
	list($m,$d,$y) = explode('/', $end_date);
	$end_date_picker = "$y-$m-$d ";
	
	$auctionWhere = array("auction_id" => $auction_id);
	
	$start_date = $start_date_picker.' '.AUCTION_START_TIME;
	$end_date = $end_date_picker.' '.AUCTION_END_TIME;
	
	$auctionData = array("auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date_picker, "auction_end_date" => $end_date_picker,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
	
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), "flat_rolled" => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		foreach($posterArr as $key => $value){
			$src = "../poster_photo/temp/$random/$value";
			$fileExt = end(explode('.', $value));
			$fileName = rand(1000, 9999).'.'.$fileExt;
			if($is_default == $value){
				$is_default = $fileName;
			}
			$dest = "../poster_photo/$fileName";
			$destThumb = "../poster_photo/thumbnail";
			if(rename($src, $dest)){
				create_thumbnail($destThumb,$dest,$fileName,100,100);
				//copy($dest, $destThumb."/".$fileName);
			}
			$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
													  "poster_image" => $fileName));
		}
	}	
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default), true);

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}

/******************* Edit Monthly Auction Starts *****************/

function edit_monthly() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$smarty->display('admin_edit_monthly_auction_manager.tpl');
}

function view_monthly()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$smarty->display('admin_view_monthly_auction_manager.tpl');
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
	
	if($_POST['reserve_price'] != "" && !is_numeric($_POST['reserve_price'])){
		$GLOBALS['reserve_price_err'] = "Please enter numeric values only.";
		$errCounter++;	
	}elseif(check_int($_POST['reserve_price']) == 0){
		$GLOBALS['reserve_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$reserve_price_err = 1;
	}
	
	if(($asked_price_err == 1 && $reserve_price_err != 1) && ($_POST['reserve_price'] <= $_POST['asked_price'])){
		$GLOBALS['reserve_price_err'] = "Reserved price must be grater than starting price.";
		$errCounter++;
	}
	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
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

	$auctionWhere = array("auction_id" => $auction_id);
	
	$eventRow = $obj->selectData(TBL_EVENT, array('*'), array("event_id" => $event_month));
	$start_date = $eventRow[0]['event_start_date'].' '.AUCTION_START_TIME;
	$end_date = $eventRow[0]['event_end_date'].' '.AUCTION_END_TIME;
	
	$auctionData = array("auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date, "auction_end_date" => $end_date,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date,
						 "fk_event_id" => $event_month);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), 'flat_rolled' => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		foreach($posterArr as $key => $value){
			$src = "../poster_photo/temp/$random/$value";
			$fileExt = end(explode('.', $value));
			$fileName = rand(1000, 9999).'.'.$fileExt;
			if($is_default == $value){
				$is_default = $fileName;
			}
			$dest = "../poster_photo/$fileName";
			$destThumb = "../poster_photo/thumbnail";
			if(rename($src, $dest)){
				create_thumbnail($destThumb,$dest,$fileName,100,100);
				//copy($dest, $destThumb."/".$fileName);
			}
			$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => $fileName,
													  "poster_image" => $fileName));
		}
	}	
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default), true);
	
	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".PHP_SELF."?mode=monthly");
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}

function view_details(){
	extract($_REQUEST);
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Auction Bid Details");
	$obj = new Auction();
	$auctionArr=$obj->select_details_auction($auction_id);
//	print_r($auctionArr);
	$objBid = new Bid();
	$auctionArr=$objBid->fetchBidsById($auctionArr);
	$objBid->fetch_BidCount_MaxBid($auctionArr);
	$countBid=count($auctionArr[0]['bids']);
	$smarty->assign("auctionArr", $auctionArr);
	$smarty->assign("total", $countBid);
	$smarty->display('admin_view_auction_details.tpl');
}

function view_details_offer(){
    extract($_REQUEST);
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Auction Bid Details");
	$obj = new Auction();
	$auctionArr=$obj->select_details_auction($auction_id);
	$objOffer= new Offer();
	$auctionArr=$objOffer->fetchOffersById($auctionArr);
	$objOffer->fetch_OfferCount_MaxOffer($auctionArr);
//	echo "<pre>";
//	print_r($auctionArr);
//	echo "</pre>";
	$countBid=count($auctionArr[0]['offers']);
	$smarty->assign("auctionArr", $auctionArr);
	$smarty->assign("total", $countBid);
	$smarty->display('admin_view_fixed_auction_details.tpl');
}

function manage_invoice()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Invoice Manager");
	
	$invoiceObj = new Invoice();
	$invoiceData = $invoiceObj->fetchInvoiceByAuctionId($_REQUEST['auction_id']);
	if(empty($invoiceData)){
	 $smarty->assign("key", 1);
	}
	$invoiceData['shipping_address'] = unserialize($invoiceData['shipping_address']);
	$invoiceData['billing_address'] = unserialize($invoiceData['billing_address']);
	$invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
	$invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
	$invoiceData['discounts'] = unserialize($invoiceData['discounts']);

	$smarty->assign("invoiceData", $invoiceData);
	
	$smarty->display('admin_manage_invoice.tpl');
}
function update_invoice_charge(){
    $desc=$_REQUEST['charge_desc'];
    $amnt= number_format($_REQUEST['charge_amnt'],2,'.','');
	echo $_REQUEST['invoice_id'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('additional_charges','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$charges=unserialize($auction[0]['additional_charges']);
	$total_amnt=$auction[0]['total_amount'];
	$charges[] = array('description' => $desc, 'amount' => $amnt);
	
	
	
	$total_amnt=$total_amnt + $_REQUEST['charge_amnt'];
	$charges=serialize($charges);
	$update=$dbCommonObj->updateData(TBL_INVOICE,array('additional_charges'=>$charges,'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
	$charges=unserialize($charges);
	$total_no_charges=count($charges);
	$dynamic_id=rand(1000,9999);
	$new_cost.="<tr id='tr_del_amnt_$dynamic_id'>";
	$new_cost.="<td align='right'><img  src='../admin_images/delete_charge.jpg' id='del_amnt_$dynamic_id' onclick='del_charge(this.id)'></td>";	
    $new_cost.="<td align='right' width='100px'><input type='hidden' name='desc_del_amnt_$dynamic_id' id='desc_del_amnt_$dynamic_id' value='$desc' />(+) $desc</td>";
    $new_cost.="<td align='left' width='132px'><input type='hidden' name='input_del_amnt_$dynamic_id' id='input_del_amnt_$dynamic_id' value='$amnt' />$$amnt</td>";
    $new_cost.="</tr>";
	
	echo $new_cost;
}
function delete_invoice_charge(){
	$desc=$_REQUEST['charge_desc'];
    $amnt= $_REQUEST['charge_amnt'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('additional_charges','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$charges=unserialize($auction[0]['additional_charges']);
	print_r($charges);
	$total_amnt=$auction[0]['total_amount'];
	$total_amnt=$total_amnt - $_REQUEST['charge_amnt'];
	$i=0;
	foreach($charges as $key => $value) {
	if($charges[$i]['description']==$desc &&  $charges[$i]['amount']==$amnt) {
	unset($charges[$i]);
   }
   $i++;
  }
 $charges=serialize($charges);
 $update=$dbCommonObj->updateData(TBL_INVOICE,array('additional_charges'=>$charges,'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
}
 function update_invoice_discount(){
 	$desc=$_REQUEST['discount_desc'];
    $amnt= number_format($_REQUEST['discount_amnt'],2,'.','');
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('discounts','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$discounts=unserialize($auction[0]['discounts']);
	$total_amnt=$auction[0]['total_amount'];
	$total_amnt=$total_amnt - $_REQUEST['discount_amnt'];
	$discounts[] = array('description' => $desc, 'amount' => $amnt);
	$discounts=serialize($discounts);
	$update=$dbCommonObj->updateData(TBL_INVOICE,array('discounts'=>$discounts,'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
	$discounts=unserialize($discounts);
	$dynamic_id=rand(1000,9999);
	$new_cost.="<tr id='tr_del_amnt_$dynamic_id'>";
	$new_cost.="<td align='right'><img  src='../admin_images/delete_charge.jpg' id='del_amnt_$dynamic_id' onclick='del_discount(this.id)'></td>";	
    $new_cost.="<td align='right' width='100px'><input type='hidden' name='desc_del_amnt_$dynamic_id' id='desc_del_amnt_$dynamic_id' value='$desc' />(-) $desc</td>";
    $new_cost.="<td align='left' width='132px'><input type='hidden' name='input_del_amnt_$dynamic_id' id='input_del_amnt_$dynamic_id' value='$amnt' />$amnt</td>";
    $new_cost.="</tr>";
	
	echo $new_cost;
 }
 function delete_invoice_discount(){
 	 $desc=$_REQUEST['discount_desc'];
     $amnt= $_REQUEST['discount_amnt'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('discounts','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$discounts=unserialize($auction[0]['discounts']);
	$total_amnt=$auction[0]['total_amount'];
	$total_amnt=$total_amnt + $_REQUEST['discount_amnt'];
	$i=0;
	foreach($discounts as $key => $value) {
	if($discounts[$i]['description']==$desc &&  $discounts[$i]['amount']==$amnt) {
	unset($discounts[$i]);
   }
   $i++;
  }
  $discounts=serialize($discounts);
  $update=$dbCommonObj->updateData(TBL_INVOICE,array('discounts'=>$discounts,'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
 }
 function approve_invoice(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
 	$dbCommonObj = new DBCommon();
 	$update=$dbCommonObj->updateData(TBL_INVOICE,array('approved_on'=>date('Y-m-d :H:i:s'),'is_approved'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true);
 }
 function cancel_invoice(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
 	$dbCommonObj = new DBCommon();
 	$update=$dbCommonObj->updateData(TBL_INVOICE,array('cancelled_on'=>date('Y-m-d :H:i:s'),'is_approved'=>'0','is_cancelled'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true);
 }
 function reopen_fixed(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']); 

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id'],"reopen_auction_id"=>"0"));
	if(empty($auctionRow)){
		$is_empty='1';
		$smarty->assign("is_empty", $is_empty);
	}
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

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
	$smarty->display('admin_reopen_fixed_auction_manager.tpl');
 }
 function reopen_fixed_auction(){
 	extract($_REQUEST);
	$obj = new Auction();
	$new_auctionData = array("auction_asked_price" => $buy_now,"is_reopened"=>'1',
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note),"fk_poster_id"=>$poster_id,"fk_auction_type_id"=>'1',"auction_is_approved"=>'1'
	,"auction_is_sold"=>'0',"post_date"=>date('Y-m-d H:i:s'),'up_date' => "0000-00-00","status"=>'1','post_ip' => $_SERVER["REMOTE_ADDR"]);
	$obj->updateData(TBL_AUCTION, $new_auctionData,false);
	$reopen_auction_id=mysqli_insert_id($GLOBALS['db_connect']);	
	
	$auctionData = array("reopen_auction_id" => $reopen_auction_id);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

		$_SESSION['adminErr'] = "Auction has been re-opened successfully.";
		header("location: ".PHP_SELF."?mode=fixed&search=unpaid");
	
 }
 function reopen_weekly(){
 		
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id'],"reopen_auction_id" =>"0"));
	if(empty($auctionRow)){
		$is_empty='1';
		$smarty->assign("is_empty", $is_empty);
	}
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_start_date']);
	$auctionRow[0]['auction_start_date'] = "$m/$d/$y";
	
	list($y, $m, $d) = explode('-', $auctionRow[0]['auction_end_date']);
	$auctionRow[0]['auction_end_date'] = "$m/$d/$y";

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));

	$smarty->display('admin_reopen_weekly_auction_manager.tpl');
 }
 function reopen_weekly_auction(){
 	extract($_REQUEST);
	$obj = new Auction();
	$new_auctionData = array("auction_asked_price" => $new_buy_now,"is_reopened"=>'1',
						 "fk_poster_id"=>$poster_id,"fk_auction_type_id"=>'1',"auction_is_approved"=>'1'
	,"auction_is_sold"=>'0',"post_date"=>date('Y-m-d H:i:s'),'up_date' => "0000-00-00","status"=>'1','post_ip' => $_SERVER["REMOTE_ADDR"]);
	$obj->updateData(TBL_AUCTION, $new_auctionData,false);
	$reopen_auction_id=mysqli_insert_id($GLOBALS['db_connect']);	
	
	$auctionWhere = array("auction_id" => $auction_id);
	$auctionData = array("reopen_auction_id" => $reopen_auction_id);
	
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

		$_SESSION['adminErr'] = "Auction has been re-opened successfully.";
		header("location: ".PHP_SELF."?mode=weekly&search=unpaid");
 }
 function reopen_monthly(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
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
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']);

	$random = ($_POST['random'] == '')? rand(999, 999999) : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id'],"reopen_aucton_id"=>"0"));
	if(empty($auctionRow)){
		$is_empty='1';
		$smarty->assign("is_empty", $is_empty);
	}
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$smarty->display('admin_reopen_monthly_auction_manager.tpl');
 }
 function reopen_monthly_auction(){
 	extract($_REQUEST);
	$obj = new Auction();
	$new_auctionData = array("auction_asked_price" => $new_buy_now,"is_reopened"=>'1',
						 "fk_poster_id"=>$poster_id,"fk_auction_type_id"=>'1',"auction_is_approved"=>'1'
	,"auction_is_sold"=>'0',"post_date"=>date('Y-m-d H:i:s'),'up_date' => "0000-00-00","status"=>'1','post_ip' => $_SERVER["REMOTE_ADDR"]);
	$obj->updateData(TBL_AUCTION, $new_auctionData,false);
	$reopen_auction_id=mysqli_insert_id($GLOBALS['db_connect']);	
	
	$auctionWhere = array("auction_id" => $auction_id);
	$auctionData = array("reopen_auction_id" => $reopen_auction_id);
	
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

		$_SESSION['adminErr'] = "Auction has been re-opened successfully.";
		header("location: ".PHP_SELF."?mode=monthly&search=unpaid");
 }
?>
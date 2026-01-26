<?php
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}

if($_REQUEST['mode']=='update_fixed'){
	$chk = validateFixedForm();
	if($chk == true){
		update_fixed();
	}else{
		edit_fixed();
	}
}elseif($_REQUEST['mode']=='update_monthly'){
	$chk = validateMonthlyForm();
	if($chk == true){
		update_monthly();
	}else{
		edit_monthly();
	}
}elseif($_REQUEST['mode']=='update_weekly'){
	$chk = validateWeeklyForm();
	if($chk == true){
		update_weekly();
	}else{
		edit_weekly();
	}
}elseif($_REQUEST['mode']=='update_stills'){
	$chk = validateStillsForm();
	if($chk == true){
		update_stills();
	}else{
		edit_stills();
	}
}elseif($_REQUEST['mode']=='delete_auction'){
	delete_auction();
}
else{
	dispmiddle();
}

ob_end_flush();

function dispmiddle(){
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/common.php";
	extract($_REQUEST);
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		/*if($key == 'poster_images' && $value != ""){
			$poster_images_arr = explode(',',trim($value, ','));
			$smarty->assign("poster_images_arr", $poster_images_arr); 
		}*/
		///////////Added By Sourav Banerjee////////
		if(($key =='poster_images') && ($value != "" || isset($_SESSION['img'])))
		{
		if(isset($_SESSION['img']))
		{
		$imgstr=implode(",",$_SESSION['img']);
		unset($_SESSION['img']);
		if($value != "")
		{
		$value=$value.",".$imgstr;
		}
		else
		{
		$value=$imgstr.",";
		}
		}
		$value = str_replace(",,",",",$value);
		$value=trim($value, ',');
		
		if($value != "")
		{
		 $smarty->assign("poster_images", trim($value, ',')); 
		$poster_images_arr = explode(',',trim($value, ','));
		$smarty->assign("poster_images_arr", $poster_images_arr); 
		}
		}
	}	
	$smarty->assign("is_default_err", $GLOBALS['is_default_err']); 

	///////////Added By Sourav Banerjee////////
   
	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	$auctionRow[0]['auction_note']=strip_slashes($auctionRow[0]['auction_note']);
	$auctionRow[0]['auction_asked_price']=intval($auctionRow[0]['auction_asked_price']);
	$auctionRow[0]['auction_reserve_offer_price']=intval($auctionRow[0]['auction_reserve_offer_price']);
	$auctionRow[0]['auction_buynow_price']=intval($auctionRow[0]['auction_buynow_price']);
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id'],"fk_user_id" => $_SESSION['sessUserID']));
//	if($auctionRow[0]['fk_auction_type_id']=='1'){
//		$auctionObj->primaryKey = 'offer_id';
//		$count_offer=$auctionObj->countData(TBL_OFFER,array("offer_fk_auction_id" =>$_REQUEST['auction_id']));
//		$smarty->assign("count_offer", $count_offer);
//	}else{
//		$auctionObj->primaryKey = 'bid_id';
//		$count_bids=$auctionObj->countData(TBL_BID,array("bid_fk_auction_id" =>$_REQUEST['auction_id']));
//		$smarty->assign("count_bids", $count_bids);
//	}
	
	if(empty($posterRow)){
		$view_key=1;
		$smarty->assign("view_key", $view_key);
	}else{
		$view_key=0;
		$smarty->assign("view_key", $view_key);
	}

	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}

	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	if($_REQUEST['type']=='monthly'){
		if($auctionRow[0]['auction_is_approved']=='0'){		
			$eventSql = "SELECT * FROM ".TBL_EVENT." WHERE event_end_date > '".date('Y-m-d')."'";	
			if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
				while($row = mysqli_fetch_assoc($rs)){
				   $eventRows[] = $row;
				}
			}
			}else{
			$eventSql = "SELECT * FROM ".TBL_EVENT." e,".TBL_AUCTION." a
						 WHERE a.auction_id='".$_REQUEST['auction_id']."' AND e.event_id =a.fk_event_id";
			if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
				while($row = mysqli_fetch_assoc($rs)){
				   $eventRows[] = $row;
				}
			}
		}
		$smarty->assign('eventRows', $eventRows);
	}
	if($_REQUEST['type']=='weekly'){
		//list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
		//list($y,$m,$d) = explode('-', $date);
		//$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";
		
		//list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
		//list($y,$m,$d) = explode('-', $date);
		//$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";
		if($auctionRow[0]['auction_is_approved']=='0'){
			$auctionWeekObj = new AuctionWeek();
	    	$aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeks();
	    	$smarty->assign('aucetionWeeks', $aucetionWeeks);
		
		}else{
			$auctionWeekObj = new AuctionWeek();
			$aucetionWeeks = $auctionWeekObj->fetchWeekForAuction($_REQUEST['auction_id']);
			$smarty->assign('aucetionWeeks', $aucetionWeeks);
		}
	}
	
//	/////////
//	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
//	list($h,$m,$s) = explode(':', $time);
//	if($h >= 12){
//		$auctionRow[0]['auction_start_hour'] = $h - 12;
//		$auctionRow[0]['auction_start_am_pm'] = 'pm';
//	}else{
//		$auctionRow[0]['auction_start_hour'] = $h;
//		$auctionRow[0]['auction_start_am_pm'] = 'am';
//	}
//	$auctionRow[0]['auction_start_min'] = $m;
//	/////////
//	
//	/////////
//	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
//	list($h,$m,$s) = explode(':', $time);
//	if($h >= 12){
//		$auctionRow[0]['auction_end_hour'] = $h - 12;
//		$auctionRow[0]['auction_end_am_pm'] = 'pm';
//	}else{
//		$auctionRow[0]['auction_end_hour'] = $h;
//		$auctionRow[0]['auction_end_am_pm'] = 'am';
//	}
//	$auctionRow[0]['auction_end_min'] = $m;
	////////
	
	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	if($_REQUEST['type']=='monthly'){
		$smarty->display("edit_myauction_monthly.tpl");
	}elseif($_REQUEST['type']=='weekly'){
		$smarty->display("edit_myauction_weekly.tpl");
	}elseif($_REQUEST['type']=='fixed'){
    	$smarty->display("edit_myauction_fixed.tpl");
	}elseif($_REQUEST['type']=='stills'){
    	$smarty->display("edit_myauction_stills.tpl");
	}
	}
function validateFixedForm(){

	$errCounter = 0;
	$random = $_REQUEST['random'];
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
		$GLOBALS['condition_err'] = "Please select Condition.";
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
		
	}elseif($_POST['asked_price']!=$_POST['chk_auction_asked_price']){
		$where = array("fk_auction_id" => $_POST['auction_id'],"is_paid" =>"0");
		$objAuctionforCart = new Auction();
		$objAuctionforCart->primaryKey = "cart_id";
		$countAuction= $objAuctionforCart->countData(TBL_CART_HISTORY,$where);
		if($countAuction > 0){
			$GLOBALS['asked_price_err'] = "Ask price can't be edited because this poster have been added to the cart list.";
			$errCounter++;
			$offer_price_err = 1;
		}
	}
	
	if($_POST['is_consider']==1){
		if($_POST['offer_price'] == ""){
			$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif($_POST['offer_price']==0){
			$GLOBALS['offer_price_err'] = "Please enter proper numeric value.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif(check_int($_POST['offer_price'])==0){
			$GLOBALS['offer_price_err'] = "Please enter integer values only.";
			$errCounter++;
			$offer_price_err = 1;
		}
	
		if($_POST['offer_price'] != "" && check_int($_POST['offer_price'])==0){
				$GLOBALS['offer_price_err'] = "Please enter integer values only.";
				$errCounter++;
				$offer_price_err = 1;   
			}
    
		if($_POST['offer_price'] != "" && ($asked_price_err == '' && $offer_price_err == '')){
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
	}
//	if($_POST['offer_price'] != "" && ($asked_price_err == '' && $offer_price_err == '')){
//		if($_POST['is_percentage'] == 1){
//			if($_POST['asked_price'] <= ($_POST['asked_price']*$_POST['offer_price']/100)){
//				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
//				$errCounter++;	
//			}
//		}else{
//			if($_POST['asked_price'] <= $_POST['offer_price']){
//				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
//				$errCounter++;	
//			}
//		}
//	}
//	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""  && !isset($_SESSION['img'])){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}
	elseif(!empty($_POST['poster_images']) || isset($_SESSION['img']))
	{
	$posterimages=$_POST['poster_images'];
	if(isset($_SESSION['img']))
	{
	$imgstr=implode(",",$_SESSION['img']);	
	
	if($posterimages!='')
	{
	$posterimages=$posterimages.",".$imgstr;
	}
	else
	{
	$posterimages=$imgstr.",";
	}
	}
	$posterimages = str_replace(",," , "," ,$posterimages);
	$posterimages =trim($posterimages, ',');
	if($posterimages!="")
	{
	    
		$posterArr = explode(',', $posterimages);
		
		//print_r($posterArr);exit;
		foreach($posterArr as $key => $value){
			$size = getimagesize("poster_photo/temp/$random/".$value);
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
function validateMonthlyForm(){
	$errCounter = 0;
	$random = $_REQUEST['random'];
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
		$GLOBALS['condition_err'] = "Please select Condition.";
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
	}elseif(check_int($_POST['asked_price'])==0){
		$GLOBALS['asked_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['reserve_price'] != '' && check_int($_POST['reserve_price'])==0){
		$GLOBALS['reserve_price_err'] = "Please enter integer values only.";
		$errCounter++;	
	}
	if($_POST['reserve_price'] != '' && $_POST['reserve_price'] != 0 && $_POST['reserve_price']< $_POST['asked_price']){
		$GLOBALS['reserve_price_err'] = "Reserve price must be greater than asked price.";
		$errCounter++;	
	}
	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""  && !isset($_SESSION['img'])){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}
	elseif(!empty($_POST['poster_images']) || isset($_SESSION['img']))
	{
	$posterimages=$_POST['poster_images'];
	if(isset($_SESSION['img']))
	{
	$imgstr=implode(",",$_SESSION['img']);	
	
	if($posterimages!='')
	{
	$posterimages=$posterimages.",".$imgstr;
	}
	else
	{
	$posterimages=$imgstr.",";
	}
	}
	$posterimages = str_replace(",," , "," ,$posterimages);
	$posterimages =trim($posterimages, ',');
	if($posterimages!="")
	{
	    
		$posterArr = explode(',', $posterimages);
		
		//print_r($posterArr);exit;
		foreach($posterArr as $key => $value){
			$size = getimagesize("poster_photo/temp/$random/".$value);
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

function validateWeeklyForm(){
	$errCounter = 0;
	$random = $_REQUEST['random'];
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
		$GLOBALS['condition_err'] = "Please select Condition.";
		$errCounter++;	
	}
	
	if($_POST['poster_desc'] == ""){
		$GLOBALS['poster_desc_err'] = "Please enter Poster Description.";
		$errCounter++;	
	}	
	
	if($_POST['auction_week'] == ""){
        $GLOBALS['auction_week_err'] = "Please select an Auction Week.";
        $errCounter++;  
        
    }
	
	/*if($_POST['start_date'] == ""){
		$GLOBALS['start_date_err'] = "Please enter Start Date.";
		$errCounter++;	
	}elseif($_POST['start_date'] <= date('m/d/Y')){
		$GLOBALS['start_date_err'] = "Start Date must be greater than Today";
		$errCounter++;	
	}
	
	if($_POST['end_date'] == ""){
		$GLOBALS['end_date_err'] = "Please enter End Date.";
		$errCounter++;	
	}elseif($_POST['end_date'] <= $_POST['start_date']){
		$GLOBALS['end_date_err'] = "End Date must be greater than Start Date.";
		$errCounter++;	
	}*/
	
	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
		
	}elseif(check_int($_POST['asked_price'])==0){
		$GLOBALS['asked_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$asked_price_err = 1;
		
	}
	
	if($_POST['buynow_price'] != "" && check_int($_POST['buynow_price'])==false){
		$GLOBALS['buynow_price_err'] = "Please enter integer values only.";
		$errCounter++;	
	}
	if($_POST['buynow_price'] != "" && $_POST['buynow_price']!=0 && $_POST['buynow_price'] < $_POST['asked_price']){
		$GLOBALS['buynow_price_err'] = "Buynow price must be greater than starting price.";
		$errCounter++;
		
	}
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""  && !isset($_SESSION['img'])){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}
	elseif(!empty($_POST['poster_images']) || isset($_SESSION['img']))
	{
	$posterimages=$_POST['poster_images'];
	if(isset($_SESSION['img']))
	{
	$imgstr=implode(",",$_SESSION['img']);	
	
	if($posterimages!='')
	{
	$posterimages=$posterimages.",".$imgstr;
	}
	else
	{
	$posterimages=$imgstr.",";
	}
	}
	$posterimages = str_replace(",," , "," ,$posterimages);
	$posterimages =trim($posterimages, ',');
	if($posterimages!="")
	{
	    
		$posterArr = explode(',', $posterimages);
		
		//print_r($posterArr);exit;
		foreach($posterArr as $key => $value){
			$size = getimagesize("poster_photo/temp/$random/".$value);
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

function edit_fixed(){
	
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		if(($key == 'poster_images') && ($value != "" || isset($_SESSION['img'])))
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
    
	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	$auctionRow[0]['auction_note']=strip_slashes($auctionRow[0]['auction_note']);
	$auctionRow[0]['auction_asked_price']=number_format($auctionRow[0]['auction_asked_price'],'0','.',',');
	$auctionRow[0]['auction_reserve_offer_price']=number_format($auctionRow[0]['auction_reserve_offer_price'],'0','.',',');
	$auctionRow[0]['auction_buynow_price']=number_format($auctionRow[0]['auction_buynow_price'],'0','.',',');
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	//echo "<pre>";print_r($posterImageRows);
	
	for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
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
	$smarty->assign("view_key", 0);
	$smarty->display("edit_myauction_fixed.tpl");
	

	}

function edit_monthly() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);


	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
		if(($key == 'poster_images') && ($value != "" || isset($_SESSION['img'])))
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
    
	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	
	$auctionRow[0]['auction_asked_price']=number_format($auctionRow[0]['auction_asked_price'],'0','.',',');
	$auctionRow[0]['auction_reserve_offer_price']=number_format($auctionRow[0]['auction_reserve_offer_price'],'0','.',',');
	$auctionRow[0]['auction_buynow_price']=number_format($auctionRow[0]['auction_buynow_price'],'0','.',',');
	
	if($auctionRow[0]['auction_is_approved']=='0'){		
		//$eventSql = "Select * from `tbl_event` where `event_start_date` <= '".date('Y-m-d')."' and event_end_date > '".date('Y-m-d')."'";	
		$eventSql = "Select * from `tbl_event` where event_end_date > '".date('Y-m-d')."'";	
		if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
			while($row = mysqli_fetch_assoc($rs)){
			   $eventRows[] = $row;
			}
		}
	}else{
		$eventSql = "Select * from `tbl_event` e,`tbl_auction` a where a.auction_id='".$_REQUEST['auction_id']."' and e.event_id=a.fk_event_id";
		if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
			while($row = mysqli_fetch_assoc($rs)){
			   $eventRows[] = $row;
			}
		}
	}
	  
	$smarty->assign('eventRows', $eventRows);
	
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	//echo "<pre>";print_r($posterImageRows);

	/*list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";*/
	
	/////////
	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$auctionRow[0]['auction_start_hour'] = $h - 12;
		$auctionRow[0]['auction_start_am_pm'] = 'pm';
	}else{
		$auctionRow[0]['auction_start_hour'] = $h;
		$auctionRow[0]['auction_start_am_pm'] = 'am';
	}
	$auctionRow[0]['auction_start_min'] = $m;
	/////////
	
	/////////
	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$auctionRow[0]['auction_end_hour'] = $h - 12;
		$auctionRow[0]['auction_end_am_pm'] = 'pm';
	}else{
		$auctionRow[0]['auction_end_hour'] = $h;
		$auctionRow[0]['auction_end_am_pm'] = 'am';
	}
	$auctionRow[0]['auction_end_min'] = $m;
	////////

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	$smarty->assign("view_key", 0);
	$smarty->display("edit_myauction_monthly.tpl");
}

function edit_weekly() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/common.php";
	define ("PAGE_HEADER_TEXT", "Weekly Auction Upadte");
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	//$auctionWeekObj = new AuctionWeek();
	//$aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
	//$smarty->assign('aucetionWeeks', $aucetionWeeks);

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
		if(($key == 'poster_images') && ($value != "" || isset($_SESSION['img'])))
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
    
	
	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	
	$auctionRow[0]['auction_asked_price']=number_format($auctionRow[0]['auction_asked_price'],'0','.',',');
	$auctionRow[0]['auction_reserve_offer_price']=number_format($auctionRow[0]['auction_reserve_offer_price'],'0','.',',');
	$auctionRow[0]['auction_buynow_price']=number_format($auctionRow[0]['auction_buynow_price'],'0','.',',');
	
	if($auctionRow[0]['auction_is_approved']=='0'){
		$auctionWeekObj = new AuctionWeek();
		$aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
		$smarty->assign('aucetionWeeks', $aucetionWeeks);
	
	}else{
		$auctionWeekObj = new AuctionWeek();
		$aucetionWeeks = $auctionWeekObj->fetchWeekForAuction($_REQUEST['auction_id']);
		$smarty->assign('aucetionWeeks', $aucetionWeeks);
	}
	
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

	/*list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";

	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($y,$m,$d) = explode('-', $date);
	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";*/
	
	/////////
	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$auctionRow[0]['auction_start_hour'] = $h - 12;
		$auctionRow[0]['auction_start_am_pm'] = 'pm';
	}else{
		$auctionRow[0]['auction_start_hour'] = $h;
		$auctionRow[0]['auction_start_am_pm'] = 'am';
	}
	$auctionRow[0]['auction_start_min'] = $m;
	/////////
	
	/////////
	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
	list($h,$m,$s) = explode(':', $time);
	if($h >= 12){
		$auctionRow[0]['auction_end_hour'] = $h - 12;
		$auctionRow[0]['auction_end_am_pm'] = 'pm';
	}else{
		$auctionRow[0]['auction_end_hour'] = $h;
		$auctionRow[0]['auction_end_am_pm'] = 'am';
	}
	$auctionRow[0]['auction_end_min'] = $m;
	////////

	$smarty->assign("auctionRow", $auctionRow);
	$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	$smarty->assign("view_key", 0);
	$smarty->display('edit_myauction_weekly.tpl');
	}

function update_fixed(){
	
	extract($_REQUEST);
	$obj = new Auction();
	$is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered=='0'){
		$offer_price= 0;
	}
	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $offer_price,
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note));
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => mysqli_real_escape_string($GLOBALS['db_connect'],$poster_desc),'flat_rolled'=>$flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	if(isset($poster_images) || isset($_SESSION['img'])){
	
	
	
	    if(isset($_SESSION['img']))
		{
		$imgstr=implode(",",$_SESSION['img']);
		unset($_SESSION['img']);
		if(isset($poster_images))
		{
		$poster_images=$poster_images.",".$imgstr;
		}
		else
		{
		$poster_images=$imgstr.",";
		}
		}
		$poster_images = str_replace(",,",",",$poster_images);
		$poster_images=trim($poster_images, ',');
	if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="poster_photo/temp/$random"; 
		$src_temp="poster_photo/temp/$random/";
		$dest_poster_photo="poster_photo/";
		$destThumb = "poster_photo/thumbnail";
		$destThumb_buy = "poster_photo/thumb_buy";
		$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "poster_photo/thumb_big_slider";
		dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
		if (is_dir($base_temp_dir)) {
			rmdir($base_temp_dir);
			}
		##### NEW FUNCTION FOR POSTER UPLOAD ends #####
	}
	}
    
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("original_filename" => $is_default,"fk_poster_id"=>$poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default,"fk_poster_id"=>$poster_id), true);
	
	$_SESSION['Err'] = "Auction has been modified successfully.";	
	header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string']));
	//header("location: myselling.php?mode=pending");
	exit();
	}
function update_monthly(){
	extract($_REQUEST);
	$obj = new Auction();

	$auctionWhere = array("auction_id" => $auction_id);
	
	$auctionRow = $obj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $auction_id));
	$auction_start_date_arr = explode(' ',$auctionRow[0]['auction_actual_start_datetime']);
	$auction_start_time = $auction_start_date_arr[1];
	$auction_end_date_arr = explode(' ',$auctionRow[0]['auction_actual_end_datetime']);
	$auction_end_time = $auction_end_date_arr[1];
	$eventRow = $obj->selectData(TBL_EVENT, array('*'), array("event_id" => $event_month));
	
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
	
	$start_date = $eventRow[0]['event_start_date'].' '.$start_time;
	$end_date = $eventRow[0]['event_end_date'].' '.$end_time;
	
	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $reserve_price,
						 "fk_event_id" => $event_month, "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => mysqli_real_escape_string($GLOBALS['db_connect'],$poster_desc),'flat_rolled'=>$flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);

	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));
	
	if(isset($poster_images) || isset($_SESSION['img'])){
	
	    if(isset($_SESSION['img']))
		{
		$imgstr=implode(",",$_SESSION['img']);
		unset($_SESSION['img']);
		if(isset($poster_images))
		{
		$poster_images=$poster_images.",".$imgstr;
		}
		else
		{
		$poster_images=$imgstr.",";
		}
		}
		$poster_images = str_replace(",,",",",$poster_images);
		$poster_images=trim($poster_images, ',');
		if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		
		$posterArr = explode(',', trim($poster_images, ','));
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="poster_photo/temp/$random";
		$src_temp="poster_photo/temp/$random/";
		$dest_poster_photo="poster_photo/";
		$destThumb = "poster_photo/thumbnail";
		$destThumb_buy = "poster_photo/thumb_buy";
		$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "poster_photo/thumb_big_slider";
		dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
		
		if (is_dir($base_temp_dir)) {
			rmdir($base_temp_dir);
			}
		##### NEW FUNCTION FOR POSTER UPLOAD ends #####
	}
    }
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("original_filename" => $is_default,"fk_poster_id"=>$poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default,"fk_poster_id"=>$poster_id), true);

	$_SESSION['Err'] = "Auction has been modified successfully.";
	//header("location: myselling.php?mode=pending");
	header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string']));
	exit();
}

function update_weekly()
{
	extract($_REQUEST);
	$obj = new Auction();
	
	/*list($m,$d,$y) = explode('/', $start_date);
	$start_date_picker = "$y-$m-$d ";
	list($m,$d,$y) = explode('/', $end_date);
	$end_date_picker = "$y-$m-$d ";
	
	$auctionRow = $obj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $auction_id));
	$auction_start_date_arr=explode(' ',$auctionRow[0]['auction_actual_start_datetime']);
	$auction_start_time=$auction_start_date_arr[1];
	$auction_end_date_arr=explode(' ',$auctionRow[0]['auction_actual_end_datetime']);
	$auction_end_time=$auction_end_date_arr[1];
	$start_date=$start_date_picker.' '.$auction_start_time;
	$end_date=$end_date_picker.' '.$auction_end_time;*/
	
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
	
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
	
	$start_date = $row[0]['auction_week_start_date']." ".$start_time;
    $end_date = $row[0]['auction_week_end_date']." ".$end_time;
	
	$auctionData = array("fk_auction_week_id" => $auction_week, "auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date, "auction_end_date" => $end_date,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
	
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => mysqli_real_escape_string($GLOBALS['db_connect'],$poster_desc),'flat_rolled'=>$flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	if(isset($poster_images) || isset($_SESSION['img'])){
	
	    if(isset($_SESSION['img']))
		{
		
		$imgstr=implode(",",$_SESSION['img']);
		unset($_SESSION['img']);
		if(isset($poster_images))
		{
		$poster_images=$poster_images.",".$imgstr;
		}
		else
		{
		$poster_images=$imgstr.",";
		}
		}
		$poster_images = str_replace(",,",",",$poster_images);
		$poster_images=trim($poster_images, ',');
		if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="poster_photo/temp/$random";
		$src_temp="poster_photo/temp/$random/";
		$dest_poster_photo="poster_photo/";
		$destThumb = "poster_photo/thumbnail";
		$destThumb_buy = "poster_photo/thumb_buy";
		$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "poster_photo/thumb_big_slider";
		dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
	
		if (is_dir($base_temp_dir)) {
			rmdir($base_temp_dir);
			}
		##### NEW FUNCTION FOR POSTER UPLOAD ends #####
	}
	}
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("original_filename" => $is_default,"fk_poster_id"=>$poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default,"fk_poster_id"=>$poster_id), true);


	
	$_SESSION['Err'] = "Auction has been modified successfully.";
	//header("location: myselling.php?mode=pending");
	header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string']));
	exit();
}
 function delete_auction(){
 	
	require_once INCLUDE_PATH."lib/common.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	extract($_REQUEST);
	
	$auctionObj = new Auction();
	if($status!='sold'){
	$auctionData = $auctionObj->selectData(TBL_AUCTION, array('fk_poster_id', 'auction_is_approved','fk_auction_type_id','auction_is_sold','reopen_auction_id'), array('auction_id' => $auction_id));
	
	
	$auctionObj->deleteData(TBL_OFFER, array('offer_fk_auction_id' => $_REQUEST['auction_id']));	
	
	$auctionObj->deleteData(TBL_BID, array('bid_fk_auction_id' => $_REQUEST['auction_id']));
	
	
	$invoiceTblData = $auctionObj->selectData(TBL_INVOICE_TO_AUCTION, array('fk_invoice_id'), array('fk_auction_id' => $_REQUEST['auction_id']));
	$tot_record=count($invoiceTblData);
	for($i=0;$i<$tot_record;$i++){
		$auctionObj->deleteData(TBL_INVOICE, array('invoice_id' => $invoiceTblData[$i]['fk_invoice_id']));
	}
	$auctionObj->deleteData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => $_REQUEST['auction_id']));
	
	$type=$auctionData[0]['fk_auction_type_id'];
	
	$countPoster=$auctionObj->countData(TBL_AUCTION,array('fk_poster_id' => $auctionData[0]['fk_poster_id']),array('auction_id'=>$_REQUEST['auction_id'])) ;
	if($countPoster == 0){
		$posterImages = $auctionObj->selectData(TBL_POSTER_IMAGES, array('poster_image', 'poster_thumb'), array('fk_poster_id' => $auctionData[0]['fk_poster_id']));
		foreach($posterImages as $key => $value){
			
				$posterLarge = "poster_photo/".$value['poster_image'];
				$posterThumb = "poster_photo/thumbnail/".$value['poster_thumb'];
				$posterThumbBuy = "poster_photo/thumb_buy/".$value['poster_thumb'];
				$posterThumbBuyGallery = "poster_photo/thumb_buy_gallery/".$value['poster_thumb'];
								
				@unlink($posterLarge);
				@unlink($posterThumb);
				@unlink($posterThumbBuy);
				@unlink($posterThumbBuyGallery);
			
		}
	
		$auctionObj->deleteData(TBL_POSTER, array('poster_id' => $auctionData[0]['fk_poster_id']));
		$auctionObj->deleteData(TBL_POSTER_IMAGES, array('fk_poster_id' => $auctionData[0]['fk_poster_id']));
		$auctionObj->deleteData(TBL_POSTER_TO_CATEGORY, array('fk_poster_id' => $auctionData[0]['fk_poster_id']));
	}
	$auctionObj->deleteData(TBL_AUCTION, array('auction_id' => $auction_id));
	$auctionObj->deleteData(TBL_CART_HISTORY, array('fk_auction_id' => $auction_id));
	$auctionObj->deleteData(TBL_WATCHING, array('auction_id' => $auction_id));
	}else{
		$auctionData = array("is_deleted" => '1');
		$auctionWhere = array("auction_id" => $auction_id);
		$auctionObj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	
	}
	if(!isset($_REQUEST['offset'])){
		$offset=0;
	}else{
		$offset=$_REQUEST['offset'];
	}
	if(!isset($_REQUEST['toshow'])){
		$toshow=0;
	}else{
		$toshow=$_REQUEST['toshow'];
	}
	$_SESSION['Err'] = "Auction has been deleted successfully.";
	header("location: myselling.php?mode=".$status."&offset=".$offset."&toshow=".$toshow);		
	exit;
 }
 function validateStillsForm(){

	$errCounter = 0;
	$random = $_REQUEST['random'];
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
		$GLOBALS['condition_err'] = "Please select Condition.";
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
		
	}elseif($_POST['asked_price']!=$_POST['chk_auction_asked_price']){
		$where = array("fk_auction_id" => $_POST['auction_id'],"is_paid" =>"0");
		$objAuctionforCart = new Auction();
		$objAuctionforCart->primaryKey = "cart_id";
		$countAuction= $objAuctionforCart->countData(TBL_CART_HISTORY,$where);
		if($countAuction > 0){
			$GLOBALS['asked_price_err'] = "Ask price can't be edited because this poster have been added to the cart list.";
			$errCounter++;
			$offer_price_err = 1;
		}
	}
	
	if($_POST['is_consider']==1){
		if($_POST['offer_price'] == ""){
			$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif($_POST['offer_price']==0){
			$GLOBALS['offer_price_err'] = "Please enter proper numeric value.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif(check_int($_POST['offer_price'])==0){
			$GLOBALS['offer_price_err'] = "Please enter integer values only.";
			$errCounter++;
			$offer_price_err = 1;
		}
	
		if($_POST['offer_price'] != "" && check_int($_POST['offer_price'])==0){
				$GLOBALS['offer_price_err'] = "Please enter integer values only.";
				$errCounter++;
				$offer_price_err = 1;   
			}
    
		if($_POST['offer_price'] != "" && ($asked_price_err == '' && $offer_price_err == '')){
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
	}
//	if($_POST['offer_price'] != "" && ($asked_price_err == '' && $offer_price_err == '')){
//		if($_POST['is_percentage'] == 1){
//			if($_POST['asked_price'] <= ($_POST['asked_price']*$_POST['offer_price']/100)){
//				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
//				$errCounter++;	
//			}
//		}else{
//			if($_POST['asked_price'] <= $_POST['offer_price']){
//				$GLOBALS['offer_price_err'] = "Offer price must be less than asked price.";
//				$errCounter++;	
//			}
//		}
//	}
//	
	if($_POST['poster_images'] == "" && $_POST['existing_images'] == ""  && !isset($_SESSION['img'])){
		$GLOBALS['poster_images_err'] = "Please select Photos.";
		$errCounter++;	
	}
	elseif(!empty($_POST['poster_images']) || isset($_SESSION['img']))
	{
	$posterimages=$_POST['poster_images'];
	if(isset($_SESSION['img']))
	{
	$imgstr=implode(",",$_SESSION['img']);	
	
	if($posterimages!='')
	{
	$posterimages=$posterimages.",".$imgstr;
	}
	else
	{
	$posterimages=$imgstr.",";
	}
	}
	$posterimages = str_replace(",," , "," ,$posterimages);
	$posterimages =trim($posterimages, ',');
	if($posterimages!="")
	{
	    
		$posterArr = explode(',', $posterimages);
		
		//print_r($posterArr);exit;
		foreach($posterArr as $key => $value){
			$size = getimagesize("poster_photo/temp/$random/".$value);
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
	function update_stills(){
	
	extract($_REQUEST);
	$obj = new Auction();
	$is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered=='0'){
		$offer_price= 0;
	}
	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $offer_price,
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note));
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => mysqli_real_escape_string($GLOBALS['db_connect'],$poster_desc),'flat_rolled'=>$flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $decade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	if(isset($poster_images) || isset($_SESSION['img'])){
	
	
	
	    if(isset($_SESSION['img']))
		{
		$imgstr=implode(",",$_SESSION['img']);
		unset($_SESSION['img']);
		if(isset($poster_images))
		{
		$poster_images=$poster_images.",".$imgstr;
		}
		else
		{
		$poster_images=$imgstr.",";
		}
		}
		$poster_images = str_replace(",,",",",$poster_images);
		$poster_images=trim($poster_images, ',');
	if($poster_images != ""){
		$posterArr = explode(',', trim($poster_images, ','));
		
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="poster_photo/temp/$random"; 
		$src_temp="poster_photo/temp/$random/";
		$dest_poster_photo="poster_photo/";
		$destThumb = "poster_photo/thumbnail";
		$destThumb_buy = "poster_photo/thumb_buy";
		$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "poster_photo/thumb_big_slider";
		dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
		if (is_dir($base_temp_dir)) {
			rmdir($base_temp_dir);
			}
		##### NEW FUNCTION FOR POSTER UPLOAD ends #####
	}
	}
    
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 0), array("fk_poster_id" => $poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("original_filename" => $is_default,"fk_poster_id"=>$poster_id), true);
	$obj->updateData(TBL_POSTER_IMAGES, array("is_default" => 1), array("poster_thumb" => $is_default,"fk_poster_id"=>$poster_id), true);
	
	$_SESSION['Err'] = "Auction has been modified successfully.";	
	header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string']));
	//header("location: myselling.php?mode=pending");
	exit();
	}
function edit_stills(){
	
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		if(($key == 'poster_images') && ($value != "" || isset($_SESSION['img'])))
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
    
	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	$auctionRow[0]['auction_note']=strip_slashes($auctionRow[0]['auction_note']);
	$auctionRow[0]['auction_asked_price']=number_format($auctionRow[0]['auction_asked_price'],'0','.',',');
	$auctionRow[0]['auction_reserve_offer_price']=number_format($auctionRow[0]['auction_reserve_offer_price'],'0','.',',');
	$auctionRow[0]['auction_buynow_price']=number_format($auctionRow[0]['auction_buynow_price'],'0','.',',');
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
	
	for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
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
	$smarty->assign("view_key", 0);
	$smarty->display("edit_myauction_stills.tpl");
	

	}
?>
<?php
/**************************************************/
ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
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
	if($chk){
          
		update_monthly();
	}else{
           
		edit_monthly();
	}
}elseif($_REQUEST['mode'] == "manage_invoice_seller"){
	manage_invoice_seller();
}
elseif($_REQUEST['mode'] == "manage_invoice"){
	manage_invoice();
}elseif($_REQUEST['mode'] == "fixed"){
	fixedPriceSale();
}elseif($_REQUEST['mode'] == "weekly"){
	weeklyAuction();
}elseif($_REQUEST['mode'] == "monthly"){
	monthlyAuction();
}elseif($_REQUEST['mode'] == "phone_order"){
	phone_order();
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
}elseif($_REQUEST['mode'] == "notify_buyer"){
    notify_buyer();
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
}elseif($_REQUEST['mode'] == "manage_invoice_seller_print"){
	manage_invoice_seller_print();
}elseif($_REQUEST['mode'] == "delete_auction"){
	delete_auction();
}elseif($_REQUEST['mode'] == "create_fixed"){
	create_fixed();
}elseif($_REQUEST['mode'] == "save_fixed_auction"){
	$chk = validateNewFixedForm();
	if(!$chk){
		create_fixed();
	}else{
		save_new_fixed_auction();
	}
}elseif($_REQUEST['mode'] == "bulkupload"){
    bulkupload();
}elseif($_REQUEST['mode'] == "save_bulkupload"){
    $chk = validateBulkupload();
    if($chk == true){
        save_bulkupload();
    }else{
        bulkupload();
    }
}elseif($_REQUEST['mode'] == "bulkupload_pending"){
    bulkupload_pending();
}elseif($_REQUEST['mode'] == "download_bulk"){
    download_bulk();
}elseif($_REQUEST['mode'] == "delete_bulk"){
    delete_bulk();
}elseif($_REQUEST['mode'] == "track_first_sold_for_home"){
    track_first_sold_for_home();
}elseif($_REQUEST['mode'] == "update_slider"){
 updateSlider();
}else if($_REQUEST['mode'] == "clearOffer"){
 clearOffer();
}else if($_REQUEST['mode'] == "mark_as_paid_invoice"){
    mark_as_paid_invoice();
}else if($_REQUEST['mode'] == "stills"){
    stills();
}else if($_REQUEST['mode'] == "create_stills"){
    create_stills();
}elseif($_REQUEST['mode'] == "save_stills"){
	$chk = validateNewStillsForm();
	if(!$chk){
		create_stills();
	}else{
		save_new_stills();
	}
}elseif($_REQUEST['mode'] == "edit_stills"){
	edit_stills();
}elseif($_REQUEST['mode'] == "update_stills"){
	$chk = validateFixedForm();
	if($chk == true){
		update_stills();
	}else{
		edit_stills();
	}
}elseif($_REQUEST['mode'] == "weekly_relist"){
    weekly_relist();
}elseif($_REQUEST['mode'] == "relist_weekly_to_weekly"){
    relist_weekly_to_weekly();
}elseif($_REQUEST['mode'] == "shipped_item_list"){
    shipped_item_list();
}else if($_REQUEST['mode'] == "stills_auction"){
    stills_auction();
}else if($_REQUEST['mode'] == "create_stills_auction"){
    create_stills_auction();
}elseif($_REQUEST['mode'] == "save_stills_auction"){
	$chk = validateNewStillsAuctionForm();
	if(!$chk){
		create_stills_auction();
	}else{
		save_new_stills_auction();
	}
}elseif($_REQUEST['mode'] == "edit_stills_auction"){
	edit_stills_auction();
}elseif($_REQUEST['mode'] == "update_stills_auction"){
	$chk = validateEditStillsAuctionForm();
	if($chk == true){
		update_stills_auction();
	}else{
		edit_stills_auction();
	}
}elseif($_REQUEST['mode'] == "view_stills"){
	view_stills();
}elseif($_REQUEST['mode'] == "reopen_stills"){
    reopen_stills();
}elseif($_REQUEST['mode'] == "reopen_stills_auction"){
    reopen_stills_auction();
}elseif($_REQUEST['mode'] == "set_as_big_slider"){
    set_as_big_slider();
}elseif($_REQUEST['mode'] == "remove_as_big_slider"){
    remove_as_big_slider();
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
	if(isset($_REQUEST['search']) && $_REQUEST['search']!=''){
		if($_REQUEST['search']=='all'){
			$_REQUEST['search']='';
		}
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=fixed&search=".$_REQUEST['search']);
	}else{
		$auctionObj = new Auction();
		$auctionObj->orderType = 'DESC';
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
	if($_REQUEST['search']!='sold'){
			$total = $auctionObj->countFixedPriceSaleByStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$total = $auctionObj->soldAuctionCOUNTFIXED($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
	if($total > 0 ){
	if($_REQUEST['search']!='sold'){
			$auctionRows = $auctionObj->fetchFixedPriceSaleByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$auctionObj->orderBy='invoice_generated_on';
			$auctionRows=$auctionObj->soldAuctionFIXED($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
            if ($auctionRows[$i]['is_cloud'] !='1'){
                list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
            }else{
                //list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=800;
                $auctionRows[$i]['img_height']=800;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }


    	}		

    			$smarty->assign('auctionRows', $auctionRows);			
				$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
				$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    	
     }
	if($_REQUEST['search']==''){
			$_REQUEST['search']='all';
		}
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	}else{
		$smarty->assign('total', 0);
		$smarty->assign('search', $_REQUEST['search']);
	}
	$smarty->display('admin_fixed_auction_manager.tpl');
}

function weeklyAuction() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=weekly&search=".$_REQUEST['search']);
	}else{
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
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
	if($_REQUEST['search']!='sold'){
			$total = $auctionObj->countWeeklyAuctionByStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$total = $auctionObj->soldAuctionCOUNTWEEKLY($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
	
	if($total>0){
	if($_REQUEST['search']!='sold'){
		$auctionRows = $auctionObj->fetchWeeklyAuctionByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$auctionObj->orderBy='invoice_generated_on';
			$auctionRows=$auctionObj->soldAuctionWEEKLY($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
            if (file_exists("../poster_photo/" . $auctionRows[$i]['poster_image'])){
                list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
            }else{
                //list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=800;
                $auctionRows[$i]['img_height']=600;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }
    	}	
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
 }
	$smarty->display('admin_weekly_auction_manager.tpl');
}

function monthlyAuction() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=monthly&search=".$_REQUEST['search']);
	}else{
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
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
	if($_REQUEST['search']!='sold'){
			$total = $auctionObj->countMonthlyAuctionByStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$total = $auctionObj->soldAuctionCOUNTMONTHLY($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
	
	if($total>0){
	if($_REQUEST['search']!='sold'){
		$auctionRows = $auctionObj->fetchMonthlyAuctionByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$auctionObj->orderBy='invoice_generated_on';
			$auctionRows=$auctionObj->soldAuctionMONTHLY($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
            if (file_exists("../poster_photo/" . $auctionRows[$i]['poster_image'])){
                list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
            }else{
                list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }
    	}
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	$smarty->display('admin_monthly_auction_manager.tpl');
}

/************************************	 END of Middle	  ********************************/


/********************** Edit Fixed price starts *************************/

function edit_fixed() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");

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
		
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->fetchEditAuctionDetail($_REQUEST['auction_id']);

	//$offerObj = new Offer();
	//$offerCount = $offerObj->countData(TBL_OFFER, array("offer_fk_auction_id" => $_REQUEST['auction_id']));

	//$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	
	$posterRow[0]['poster_desc'] = strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title'] = strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
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
	//$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	//$smarty->assign("offer_count", $offerCount);
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $auctionRow[0]['poster_desc'] ;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_edit_fixed_auction_manager.tpl');
	}

function view_fixed() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
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
	$smarty->display('admin_view_fixed_auction_manager.tpl');
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
		$GLOBALS['genre_err'] = "Please select Genre.";
		$errCounter++;	
	}
	if($_POST['dacade'] == ""){
		$GLOBALS['dacade_err'] = "Please select Decade.";
		$errCounter++;	
	}
	if($_POST['country'] == ""){
		$GLOBALS['country_err'] = "Please select Country.";
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
		$GLOBALS['is_default_err'] = "Please select atleast one image as default.";
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
					$GLOBALS['offer_price_err'] = "Minimum Offer price must be less than asked price.";
					$errCounter++;  
				}
			}
		}
	}
	if($_POST['offer_price']!=$_POST['chk_auction_offer_price']){
		$where = array("fk_auction_id" => $_POST['auction_id'],"is_paid" =>"0");
		$objAuctionforCart = new Auction();
		$objAuctionforCart->primaryKey = "cart_id";
		$countAuction= $objAuctionforCart->countData(TBL_CART_HISTORY,$where);
		if($countAuction > 0){
			$GLOBALS['offer_price_err'] = "Offer price can't be edited because this poster have been added to the cart list.";
			$errCounter++;
			$offer_price_err = 1;
		}
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

function update_fixed()
{
	extract($_REQUEST);
	$obj = new Auction();
	$is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered ==0){
		$offer_price = 0;
	}
	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $offer_price,
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note),"imdb_link"=>$imdb_link);
	$auctionWhere = array("auction_id" => $auction_id);
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

	//////////////Added By Sourav banerjee////////////////////
	
		
	
	if(isset($poster_images) || isset($_SESSION['img'])){
	
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
		if($poster_images!= "")
		{
         $posterArr = explode(',', trim($poster_images, ','));
	
		//////////////Added By Sourav banerjee////////////////////
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="../poster_photo/temp/$random";
		$src_temp="../poster_photo/temp/$random/";
		$dest_poster_photo="../poster_photo/";
		$destThumb = "../poster_photo/thumbnail";
		$destThumb_buy = "../poster_photo/thumb_buy";
		$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "../poster_photo/thumb_big_slider";
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

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?cat_type_id=".$fk_cat_type_id);
		//exit;
	}*/
}

/******************* Edit Weekly Auction Starts *****************/

function edit_weekly() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	$auctionWeekObj = new AuctionWeek();
    $aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
    $smarty->assign('aucetionWeeks', $aucetionWeeks);

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
		
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	 $_SESSION['random']=$random;
	
	///////////added by sourav banerjee//////////
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->fetchEditAuctionDetail($_REQUEST['auction_id']);
	//$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));
	//list($y, $m, $d) = explode('-', $auctionRow[0]['auction_start_date']);
	//$auctionRow[0]['auction_start_date'] = "$m/$d/$y";
	
	//list($y, $m, $d) = explode('-', $auctionRow[0]['auction_end_date']);
	//$auctionRow[0]['auction_end_date'] = "$m/$d/$y";
	
	//$offerObj = new Offer();
	//$bidCount = $offerObj->countData(TBL_BID, array("bid_fk_auction_id" => $_REQUEST['auction_id']));

	//$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	//$posterRow[0]['poster_desc'] = strip_slashes($posterRow[0]['poster_desc']);
	//$posterRow[0]['poster_title'] = strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
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
	//echo "<pre>";print_r($auctionRow);exit;
	$smarty->assign("auctionRow", $auctionRow);
	//$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	//$smarty->assign("bid_count", $bidCount);
ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $auctionRow[0]['poster_desc'] ;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_edit_weekly_auction_manager.tpl');
}

function view_weekly()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Weekly Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
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
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
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
		$GLOBALS['genre_err'] = "Please select Genre.";
		$errCounter++;	
	}
	if($_POST['dacade'] == ""){
		$GLOBALS['dacade_err'] = "Please select Decade.";
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
	
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select atleast one image as default.";
		$errCounter++;	
	}

	/*if($_POST['start_date'] == ""){
		$GLOBALS['start_date_err'] = "Please enter Start Date.";
		$errCounter++;	
	}//elseif($_POST['start_date'] <= date('m/d/Y')){
		//$GLOBALS['start_date_err'] = "Start Date must be grater than Today";
		//$errCounter++;	
	//}
	
	if($_POST['end_date'] == ""){
		$GLOBALS['end_date_err'] = "Please enter End Date.";
		$errCounter++;	
	}elseif($_POST['end_date'] <= $_POST['start_date']){
		$GLOBALS['end_date_err'] = "End Date must be greater than Start Date.";
		$errCounter++;	
	}*/
	
    if($_POST['auction_week'] == ""){
        $GLOBALS['auction_week_err'] = "Please select a Auction Week.";
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
	
	if($_POST['buynow_price'] != "" && check_int($_POST['buynow_price']) == 0){
		$GLOBALS['buynow_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$buynow_price_err = 1;
	}
	
	if($_POST['buynow_price']!=""  && $_POST['buynow_price']!=0 &&  $_POST['buynow_price'] <= $_POST['asked_price']){
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
	$posterimages=$posterimages.$imgstr;
	}
	else
	{
	$posterimages=$imgstr;
	}
	}
	if($posterimages != "")
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

function update_weekly(){
	extract($_REQUEST);
	$obj = new Auction();

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
	
    $start_date = $row[0]['auction_week_start_date']." ".$start_time;
    $end_date = $row[0]['auction_week_end_date']." ".$end_time;
	
	$auctionData = array("fk_auction_week_id" => $auction_week, "auction_asked_price" => $asked_price, "auction_buynow_price" => $buynow_price,
						 "auction_start_date" => $start_date_picker, "auction_end_date" => $end_date_picker,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date,"imdb_link"=>$imdb_link);
	
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), "flat_rolled" => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	//////////////Added By Sourav banerjee////////////////////
	if(isset($poster_images) || isset($_SESSION['img'])){
	
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
		if($poster_images!= "")
		{
    $posterArr = explode(',', trim($poster_images, ','));
	
		//////////////Added By Sourav banerjee////////////////////
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="../poster_photo/temp/$random";
		$src_temp="../poster_photo/temp/$random/";
		$dest_poster_photo="../poster_photo/";
		$destThumb = "../poster_photo/thumbnail";
		$destThumb_buy = "../poster_photo/thumb_buy";
		$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "../poster_photo/thumb_big_slider";
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

	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}

/******************* Edit Monthly Auction Starts *****************/

function edit_monthly() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);

	$eventRows = $obj->selectData(TBL_EVENT, array('*'), "event_end_date > '".date('Y-m-d')."'");
	$smarty->assign('eventRows', $eventRows);

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
		
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->fetchEditAuctionDetail($_REQUEST['auction_id']);
	//$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	/*$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);*/
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));

//	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_start_datetime']);
//	list($y,$m,$d) = explode('-', $date);
//	$auctionRow[0]['auction_actual_start_datetime'] = "$m/$d/$y";
//
//	list($date,$time) = explode(' ', $auctionRow[0]['auction_actual_end_datetime']);
//	list($y,$m,$d) = explode('-', $date);
//	$auctionRow[0]['auction_actual_end_datetime'] = "$m/$d/$y";

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

	$smarty->assign("auctionRow", $auctionRow);
	//$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $auctionRow[0]['poster_desc'] ;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_edit_monthly_auction_manager.tpl');
}

function view_monthly()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Monthly Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
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
	$random = $_REQUEST['random'];
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
		$GLOBALS['genre_err'] = "Please select Genre.";
		$errCounter++;	
	}
	if($_POST['dacade'] == ""){
		$GLOBALS['dacade_err'] = "Please select Decade.";
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
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select atleast one image as default.";
		$errCounter++;	
	}

	if($_POST['asked_price'] == ""){
		$GLOBALS['asked_price_err'] = "Please enter Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
	}elseif(check_int($_POST['asked_price']) == 0){
		$GLOBALS['asked_price_err'] = "Please enter proper Starting Price.";
		$errCounter++;
		$asked_price_err = 1;
	}
	
	if($_POST['reserve_price'] != "" && check_int($_POST['reserve_price']) == 0){
		$GLOBALS['reserve_price_err'] = "Please enter integer values only.";
		$errCounter++;
		$reserve_price_err = 1;
	}
	
	if($_POST['reserve_price'] != "" && $_POST['reserve_price'] != 0 && $_POST['reserve_price'] <= $_POST['asked_price']){
		$GLOBALS['reserve_price_err'] = "Reserved price must be greater than starting price.";
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

function update_monthly(){
	extract($_REQUEST);
	$obj = new Auction();

	$auctionWhere = array("auction_id" => $auction_id);
	
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

	//////////////Added By Sourav banerjee////////////////////
	if(isset($poster_images) || isset($_SESSION['img'])){
	
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
		if($poster_images!= "")
		{
        $posterArr = explode(',', trim($poster_images, ','));
	
		//////////////Added By Sourav banerjee////////////////////
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="../poster_photo/temp/$random";
		$src_temp="../poster_photo/temp/$random/";
		$dest_poster_photo="../poster_photo/";
		$destThumb = "../poster_photo/thumbnail";
		$destThumb_buy = "../poster_photo/thumb_buy";
		$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "../poster_photo/thumb_big_slider";
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
	
	//if($chk){
		$_SESSION['adminErr'] = "Auction has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?mode=weekly");
	}*/
}

function view_details(){
	extract($_REQUEST);
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Auction Bid Details");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$obj = new Auction();
	$auctionArr=$obj->select_details_auction($auction_id);
    if (file_exists("../poster_photo/" . $auctionArr[0]['poster_thumb'])){
        $auctionArr[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionArr[0]['poster_thumb'];
    }else{
        $auctionArr[0]['image_path']=CLOUD_POSTER_THUMB.$auctionArr[0]['poster_thumb'];
    }
//	print_r($auctionArr);
	$objBid = new Bid();
	if($auctionArr[0]['auction_is_sold']=='0'){
		//$objBid = new Bid();
		$auctionArr=$objBid->fetchBidsById($auctionArr);
		$objBid->fetch_BidCount_MaxBid($auctionArr);
		$countBid=count($auctionArr[0]['bids']);
	}
	if($auctionArr[0]['auction_is_sold']=='1'){
		//$objBid = new Bid();
		$auctionArr=$objBid->fetchBidsById($auctionArr);
		$objBid->fetch_BidCount_MaxBid($auctionArr);
		$countBid=count($auctionArr[0]['bids']);
		$objInvoice = new Invoice();
		$invoiceData=$objInvoice->auctionWinnerForDetail($auctionArr[0]['auction_id']);
		$smarty->assign("invoiceData", $invoiceData);
	}
	if($auctionArr[0]['auction_is_sold']=='2'){
		$auctionArr=$objBid->fetchBidsById($auctionArr);
		$objBid->fetch_BidCount_MaxBid($auctionArr);
		$countBid=count($auctionArr[0]['bids']);
		$objInvoice = new Invoice();
		$invoiceData=$objInvoice->auctionWinnerForDetail($auctionArr[0]['auction_id']);
		$smarty->assign("invoiceData", $invoiceData);
		//print_r($invoiceData);
	}
	
	$where_bid_max=array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$auctionArr[0]['highest_bid']);
	$count_bid_max=$objBid->countData(TBL_BID,$where_bid_max);
	if($count_bid_max > 1){
		$smarty->assign("max_amount_no", 1);
	}else{
		$smarty->assign("max_amount_no", 0);
	}
	$smarty->assign("auctionArr", $auctionArr);
	$smarty->assign("total", $countBid);
	$smarty->display('admin_view_auction_details.tpl');
}

function view_details_offer(){
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	extract($_REQUEST);
	define ("PAGE_HEADER_TEXT", "Admin Auction Bid Details");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$obj = new Auction();
	$auctionArr=$obj->select_details_auction($auction_id);
    if (file_exists("../poster_photo/" . $auctionArr[0]['poster_thumb'])){
        $auctionArr[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionArr[0]['poster_thumb'];
    }else{
        $auctionArr[0]['image_path']=CLOUD_POSTER_THUMB.$auctionArr[0]['poster_thumb'];
    }
	if($auctionArr[0]['auction_is_sold']=='0'){
		$objOffer= new Offer();
		$auctionArr=$objOffer->fetchOffersById($auctionArr);
		$objOffer->fetch_OfferCount_MaxOffer($auctionArr);
		$countBid=count($auctionArr[0]['offers']);
	}
	if($auctionArr[0]['auction_is_sold']=='1'){
		$objOffer= new Offer();
		$auctionArr=$objOffer->fetchOffersById($auctionArr);
		$objOffer->fetch_OfferCount_MaxOffer($auctionArr);
		$countBid=count($auctionArr[0]['offers']);
		$objInvoice = new Invoice();
		$invoiceData=$objInvoice->auctionWinnerForDetail($auctionArr[0]['auction_id']);
		$smarty->assign("invoiceData", $invoiceData);
	}
	if($auctionArr[0]['auction_is_sold']=='2'){
		$objOffer= new Offer();
		$auctionArr=$objOffer->fetchOffersById($auctionArr);
		$objOffer->fetch_OfferCount_MaxOffer($auctionArr);
		$countBid=count($auctionArr[0]['offers']);
		$objInvoice = new Invoice();
		$invoiceData=$objInvoice->auctionWinnerForDetail($auctionArr[0]['auction_id']);
		$smarty->assign("invoiceData", $invoiceData);
		//print_r($invoiceData);
	}
	if($auctionArr[0]['auction_is_sold']=='3'){
        $objOffer= new Offer();
        $auctionArr=$objOffer->fetchOffersById($auctionArr);
        $objOffer->fetch_OfferCount_MaxOffer($auctionArr);
        $countBid=count($auctionArr[0]['offers']);
    }
	$smarty->assign("auctionArr", $auctionArr);
	$smarty->assign("total", $countBid);
	$smarty->display('admin_view_fixed_auction_details.tpl');
}

function manage_invoice()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Invoice Manager");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$invoiceObj = new Invoice();
	$invoiceData = $invoiceObj->fetchInvoiceByAuctionId($_REQUEST['auction_id']);
	$chk_item_type=$invoiceObj->chk_item_type($invoiceData['invoice_id']);
	if(empty($invoiceData)){
	 $smarty->assign("key", 1);
	}
	$invoiceData['shipping_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['shipping_address']);
	$invoiceData['shipping_address'] = unserialize($invoiceData['shipping_address']);
	$invoiceData['billing_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['billing_address']);
	$invoiceData['billing_address'] = unserialize($invoiceData['billing_address']);
	$invoiceData['auction_details'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['auction_details']);
	$invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
	$invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
	$invoiceData['discounts'] = unserialize($invoiceData['discounts']);
	if($chk_item_type==1 || $chk_item_type==4){
			for($k=0;$k<count($invoiceData['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$invoiceData['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$invoiceData['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
			}
	  }
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($invoiceData['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}

	$smarty->assign("invoiceData", $invoiceData);
	
	$smarty->display('admin_manage_invoice.tpl');
}

function manage_invoice_seller()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Invoice Manager");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$invoiceObj = new Invoice();
	$invoiceData = $invoiceObj->fetchInvoiceByAuctionIdSeller($_REQUEST['auction_id']);
	if(empty($invoiceData)){
	 $smarty->assign("key", 1);
	}
	$invoiceData['shipping_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['shipping_address']);
	$invoiceData['shipping_address'] = unserialize($invoiceData['shipping_address']);
	$invoiceData['billing_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['billing_address']);
	$invoiceData['billing_address'] = unserialize($invoiceData['billing_address']);
	$invoiceData['auction_details'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData['auction_details']);
	$invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
	$invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
	$invoiceData['discounts'] = unserialize($invoiceData['discounts']);

	$smarty->assign("invoiceData", $invoiceData);
	
	$smarty->display('admin_manage_invoice_seller.tpl');
}
function manage_invoice_seller_print(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$invoiceObj = new Invoice();
	$invoiceData = $invoiceObj->selectData(TBL_INVOICE,array('*'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$invoiceData[0]['shipping_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData[0]['shipping_address']);
	$invoiceData['shipping_address'] = unserialize($invoiceData[0]['shipping_address']);
	$invoiceData[0]['billing_address'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData[0]['billing_address']);
	$invoiceData['billing_address'] = unserialize($invoiceData[0]['billing_address']);
	$invoiceData[0]['auction_details'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData[0]['auction_details']);
	$invoiceData['auction_details'] = unserialize($invoiceData[0]['auction_details']);
	$invoiceData[0]['additional_charges'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData[0]['additional_charges']);
	$invoiceData['additional_charges'] = unserialize($invoiceData[0]['additional_charges']);
	$invoiceData[0]['discounts'] = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $invoiceData[0]['discounts']);
	$invoiceData['discounts'] = unserialize($invoiceData[0]['discounts']); 
	$smarty->assign("invoiceData", $invoiceData);

    $user_email = $invoiceObj->selectData(USER_TABLE,array('email'),array('user_id'=>$invoiceData[0]['fk_user_id']));
    $smarty->assign("user_email", $user_email);
//	echo "<pre>";
//	print_r($invoiceData);
	$smarty->display('admin_manage_invoice_seller_print.tpl');
	}

function update_invoice_charge(){
    $desc=$_REQUEST['charge_desc'];
    $amnt= number_format($_REQUEST['charge_amnt'],2,'.','');
//	echo $_REQUEST['invoice_id'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('additional_charges','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$auction[0]['additional_charges']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $auction[0]['additional_charges']);
	$charges=unserialize($auction[0]['additional_charges']);
	$total_amnt=$auction[0]['total_amount'];
	$charges[] = array('description' => $desc, 'amount' => $amnt);
	
	
	
	$total_amnt=$total_amnt + $_REQUEST['charge_amnt'];
	$charges=serialize($charges);
	$update=$dbCommonObj->updateData(TBL_INVOICE,array('additional_charges'=>mysqli_real_escape_string($GLOBALS['db_connect'],$charges),'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
	$charges=unserialize($charges);
	$total_no_charges=count($charges);
	$dynamic_id=rand(1000,9999);
	$new_cost.='<div id="tr_del_amnt_'.$dynamic_id.'" style="width:100%; float:left;">';
	$new_cost.='<div style="float:left; width:25%; height:18px; ">
	<img src="'.CLOUD_STATIC_ADMIN.'del_ind.jpg" style="display:none;" class="del_img" >
	<img  src="'.CLOUD_STATIC_ADMIN.'delete_charge.jpg" id="del_amnt_'.$dynamic_id.'" class="del_ind" onclick="del_charge(this.id)"></div>';	
    $new_cost.='<div style="float:left; width:50%; border-left:1px solid #cccccc; height:18px; ">
	<input type="hidden" name="desc_del_amnt_'.$dynamic_id.'" id="desc_del_amnt_'.$dynamic_id.'" value="'.$desc.'" />(+) '.$desc.'</div>';
    $new_cost.='<div style="float:left; width:24%; border-left:1px solid #cccccc; text-align:left; height:18px;">
	<input type="hidden" name="input_del_amnt_'.$dynamic_id.'" id="input_del_amnt_'.$dynamic_id.'" value="'.$amnt.'" />$'.$amnt.'</div>';
    $new_cost.="</div>";
	
	echo $new_cost;
}
function delete_invoice_charge(){
	$desc=$_REQUEST['charge_desc'];
    $amnt= $_REQUEST['charge_amnt'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('additional_charges','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$auction[0]['additional_charges']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $auction[0]['additional_charges']);
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
	$arrCrarges = array();
		foreach($charges as $key => $value) {		
			$arrCrarges[] = $value;
		}
 $charges=serialize($arrCrarges);
 $update=$dbCommonObj->updateData(TBL_INVOICE,array('additional_charges'=>mysqli_real_escape_string($GLOBALS['db_connect'],$charges),'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
}
 function update_invoice_discount(){
 	$desc=$_REQUEST['discount_desc'];
    $amnt= number_format($_REQUEST['discount_amnt'],2,'.','');
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('discounts','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$auction[0]['discounts']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $auction[0]['discounts']);
	$discounts=unserialize($auction[0]['discounts']);
	$total_amnt=$auction[0]['total_amount'];
	$total_amnt=$total_amnt - $_REQUEST['discount_amnt'];
	$discounts[] = array('description' => $desc, 'amount' => $amnt); 
	$discounts=serialize($discounts);
	$update=$dbCommonObj->updateData(TBL_INVOICE,array('discounts'=>mysqli_real_escape_string($GLOBALS['db_connect'],$discounts),'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
	$discounts=unserialize($discounts);
	$dynamic_id=rand(1000,9999);
	$new_cost.='<div id="tr_del_amnt_'.$dynamic_id.'" style="width:100%; float:left;">';
	$new_cost.='<div style="float:left; width:25%; height:18px; ">
	<img src="'.CLOUD_STATIC_ADMIN.'del_ind.jpg" style="display:none;" class="del_img" >
	<img  src="'.CLOUD_STATIC_ADMIN.'delete_charge.jpg" id="del_amnt_'.$dynamic_id.'" class="del_ind" onclick="del_discount(this.id)"></div>';	
    $new_cost.='<div style="float:left; width:50%;border-left:1px solid #cccccc; height:18px;">
	<input type="hidden" name="desc_del_amnt_'.$dynamic_id.'" id="desc_del_amnt_'.$dynamic_id.'" value="'.$desc.'" />(-)'. $desc.'</div>';
    $new_cost.='<div style="float:left; width:24%;border-left:1px solid #cccccc; text-align:left; height:18px;">
	<input type="hidden" name="input_del_amnt_'.$dynamic_id.'" id="input_del_amnt_'.$dynamic_id.'" value="'.$amnt.'" />$'.$amnt.'</div>';
    $new_cost.="</div>";
    
//	$new_cost.="<tr id='tr_del_amnt_$dynamic_id'>";
//	$new_cost.="<td align='right'><img  src='../admin_images/delete_charge.jpg' id='del_amnt_$dynamic_id' onclick='del_discount(this.id)'></td>";	
//    $new_cost.="<td align='right' width='100px'><input type='hidden' name='desc_del_amnt_$dynamic_id' id='desc_del_amnt_$dynamic_id' value='$desc' />(-) $desc</td>";
//    $new_cost.="<td align='left' width='132px'><input type='hidden' name='input_del_amnt_$dynamic_id' id='input_del_amnt_$dynamic_id' value='$amnt' />$amnt</td>";
//    $new_cost.="</tr>";
	
	echo $new_cost;
 }
 function delete_invoice_discount(){
 	 $desc=$_REQUEST['discount_desc'];
     $amnt= $_REQUEST['discount_amnt'];
	require_once INCLUDE_PATH."lib/adminCommon.php";
	$dbCommonObj = new DBCommon();
	$auction = $dbCommonObj->selectData(TBL_INVOICE,array('discounts','total_amount'),array('invoice_id'=>$_REQUEST['invoice_id']));
	$auction[0]['discounts']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $auction[0]['discounts']);
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
 	$arrDiscounts = array();
	foreach($discounts as $key => $value) {		
		$arrDiscounts[] = $value;
	}
	
  $discounts=serialize($arrDiscounts);
  $update=$dbCommonObj->updateData(TBL_INVOICE,array('discounts'=>mysqli_real_escape_string($GLOBALS['db_connect'],$discounts),'total_amount'=>$total_amnt),array('invoice_id'=>$_REQUEST['invoice_id']),true);
 
 }
 function approve_invoice(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
 	$dbCommonObj = new DBCommon();
 	$update=$dbCommonObj->updateData(TBL_INVOICE,array('approved_on'=>date('Y-m-d :H:i:s'),'is_approved'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true);
 	if(isset($_REQUEST['sent_mail']) && $_REQUEST['sent_mail']=='1'){
 		$obj=new Invoice();
 		$obj->mailInvoice($_REQUEST['invoice_id'],'Seller'); 
 	}else{
	    $sqlStatus = "Select fk_auction_type_id from tbl_auction where auction_id= '".$_REQUEST['auction_id']."' ";
		$resSqlStatus=mysqli_query($GLOBALS['db_connect'],$sqlStatus);
		$fetchAuction=mysqli_fetch_array($resSqlStatus);
		$auctionStatus=$fetchAuction['fk_auction_type_id'];
		if($auctionStatus=='2'){
         /******************************** Email Start ******************************/
         $sql = "SELECT u.username, u.firstname, u.lastname, u.email,
				tw.auction_week_title
				FROM ".USER_TABLE." u,  ".TBL_AUCTION." a,".TBL_INVOICE_TO_AUCTION." tia,".TBL_INVOICE." i,".TBL_AUCTION_WEEK." tw
				WHERE i.invoice_id = '".$_REQUEST['invoice_id']."'
				AND tia.fk_invoice_id = i.invoice_id
				AND tia.fk_auction_id = a.auction_id
				AND u.user_id = i.fk_user_id
				AND a.fk_auction_week_id= tw.auction_week_id ";
         $rs = mysqli_query($GLOBALS['db_connect'],$sql);
         $row = mysqli_fetch_array($rs);

         $toMail = $row['email'];
         $toName = $row['firstname']." ".$row['lastname'];
         $subject = "Auction Invoice";
         $fromMail = ADMIN_EMAIL_ADDRESS;
         $fromName = ADMIN_NAME;
         $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
         $textContent.= 'Your invoice for the '.$row['auction_week_title'].' is ready. Please login to your account and go to <b>User Section</b>. Under <b>My Account</b>, select <b>Invoices/Reconciliations </b> and follow prompts. Please note that if you have multiple outstanding invoices you can combine by clicking checkbox for each invoice and selecting <b>Combine Invoices</b> button. <br /><br />';
         
         $textContent .= '<a href="http://'.HOST_NAME.'/buy.php">Click Here to log in. </a><br /><br />';
         $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
         $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
         $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		 }else{
			$obj=new Invoice();
 		    $obj->mailInvoice($_REQUEST['invoice_id'],''); 
		 }
     }
 }
 function notify_buyer(){
        require_once INCLUDE_PATH."lib/adminCommon.php";
        $obj=new Invoice();
        if($obj->mailInvoice($_REQUEST['invoice_id'],'buyer_notify')){
            echo '1';
        }
    }
 function cancel_invoice(){
 	require_once INCLUDE_PATH."lib/adminCommon.php";
 	$dbCommonObj = new DBCommon();
 	$update=$dbCommonObj->updateData(TBL_INVOICE,array('cancelled_on'=>date('Y-m-d :H:i:s'),'is_cancelled'=>'1'),array('invoice_id'=>$_REQUEST['invoice_id']),true);
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
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
         if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
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
	$smarty->display('admin_reopen_fixed_auction_manager.tpl');
 }
 function reopen_fixed_auction(){
 	extract($_REQUEST);
 	if(check_int($buy_now)==true){
	$obj = new Auction();
	$new_auctionData = array("auction_asked_price" => $buy_now,"is_reopened"=>'1',
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note),"fk_poster_id"=>$poster_id,"fk_auction_type_id"=>'1',"auction_is_approved"=>'1'
	,"auction_is_sold"=>'0',"post_date"=>date('Y-m-d H:i:s'),'up_date' => "0000-00-00","status"=>'1','post_ip' => $_SERVER["REMOTE_ADDR"]);
	$obj->updateData(TBL_AUCTION, $new_auctionData,false);
	$reopen_auction_id=mysqli_insert_id($GLOBALS['db_connect']);	
	
	$auctionData = array("reopen_auction_id" => $reopen_auction_id);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	
        $sql_update="UPDATE tbl_invoice ti,tbl_invoice_to_auction tia set ti.is_cancelled='1' where ti.invoice_id=tia.fk_invoice_id and tia.fk_auction_id=$auction_id";
        $res_sql_update=mysqli_query($GLOBALS['db_connect'],$sql_update);
        
		$_SESSION['adminErr'] = "Auction has been re-opened successfully.";
		header("location: ".PHP_SELF."?mode=fixed&search=unpaid");
 	}else{
 		$_SESSION['adminErr'] = "Please provide proper numeric value for buy now price";
		header("location: ".PHP_SELF."?mode=reopen_fixed&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
 	}
	
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

     $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
     $smarty->assign("random", $random);

     $auctionObj = new Auction();
     $auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

     if(empty($auctionRow)){
         $is_empty='1';
         $smarty->assign("is_empty", $is_empty);
     }
     //list($y, $m, $d) = explode('-', $auctionRow[0]['auction_actual_start_date']);
	 $auctionRow[0]['auction_start_date'] = date("m/d/Y",strtotime($auctionRow[0]['auction_actual_start_datetime']));
     //$auctionRow[0]['auction_start_date'] = "$m/$d/$y";

     //list($y, $m, $d) = explode('-', $auctionRow[0]['auction_actual_end_date']);
     $auctionRow[0]['auction_end_date'] =date("m/d/Y",strtotime($auctionRow[0]['auction_actual_end_datetime']));

     $posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
     $posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
     $posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
     $posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
     for($i=0;$i<count($posterImageRows);$i++){
         if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
             $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
         }else{
             $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
         }
     }
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

     $auctionWeekObj = new AuctionWeek();
     $aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
     $smarty->assign('aucetionWeeks', $aucetionWeeks);

     ob_start();
     $oFCKeditor = new FCKeditor('poster_desc') ;
     $oFCKeditor->BasePath = '../FCKeditor/';
     /*$oFCKeditor->ToolbarSet = 'Basic';*/
     $oFCKeditor->Value = $posterRow[0]['poster_desc'];
     $oFCKeditor->Width  = '430';
     $oFCKeditor->Height = '300';
     $oFCKeditor->ToolbarSet = 'AdminToolBar';
     $oFCKeditor->Create() ;
     $poster_desc = ob_get_contents();
     ob_end_clean();
     $smarty->assign('poster_desc', $poster_desc);
     $smarty->display('admin_reopen_weekly_auction_manager.tpl');
 }
 function reopen_weekly_auction(){
     extract($_REQUEST);

     if(isset($choose_fixed_weekly) && $choose_fixed_weekly!=''){

         $obj = new Auction();
         if($choose_fixed_weekly=='fixed'){
            if(isset($fixed_asked_price) && $fixed_asked_price!=''){
				if(isset($is_consider) && $is_consider==0){
					$offer_price = 0;
				}else{
					
					if($_POST['offer_price'] == ""){						
						$_SESSION['adminErr'] = "Please enter Offer Price.";
						header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
					}elseif($_POST['offer_price']==0){						
						$_SESSION['adminErr'] = "Please enter proper numeric value for Offer Price.";
						header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
					}elseif(check_int($_POST['offer_price'])==0){						
						$_SESSION['adminErr'] = "Please enter integer values only for Offer Price.";
						header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);   
					}elseif($_POST['offer_price'] != "" && check_int($_POST['offer_price'])==0){
						$_SESSION['adminErr'] = "Please enter integer values only for Offer Price.";
						header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);    
					}elseif($_POST['fixed_asked_price'] <= $_POST['offer_price']){								
						$_SESSION['adminErr'] = "Offer price must be less than asked price.";
						header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']); 
					}else{	
					
						$row = $obj->selectData(TBL_AUCTION, array('fk_poster_id'), array("auction_id" => $auction_id));
						$poster_id = $row[0]['fk_poster_id'];

						
						$auctionData = array("fk_auction_type_id"=>'1',"fk_poster_id"=>$poster_id,"auction_is_approved"=>'1',"is_reopened"=>'0',"auction_is_sold"=>'0',"fk_auction_week_id" => '', "auction_asked_price" => $fixed_asked_price, "auction_buynow_price" => '',"auction_reserve_offer_price"=>$offer_price,"auction_start_date" => '', "auction_end_date" => '',
							"auction_actual_start_datetime" => '', "auction_actual_end_datetime" => '',"post_date"=>date('Y-m-d H:i:s'));

						$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), false);
						$obj->deleteData(TBL_BID, array('bid_fk_auction_id' => $auction_id));
						$obj->deleteData(TBL_AUCTION, array('auction_id' => $auction_id));
						$_SESSION['adminErr'] = "Auction has been re-opened successfully.";
						header("location: ".$decode_string);
					}
				}
            }else{
                $_SESSION['adminErr'] = "Please provide asked price to relist.";
                header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
            }
        }
         elseif($choose_fixed_weekly=='weekly'){
             if(isset($auction_week) && $auction_week!=''){
                 $row = $obj->selectData(TBL_AUCTION, array('fk_poster_id'), array("auction_id" => $auction_id));
                 $poster_id = $row[0]['fk_poster_id'];

                 $row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
                 $start_date = $row[0]['auction_week_start_date'];
                 $end_date = $row[0]['auction_week_end_date'];

                 $auctionData = array("fk_auction_type_id"=>'2',"fk_auction_week_id" => $auction_week,"fk_poster_id"=>$poster_id,"auction_is_approved"=>'1', "auction_asked_price" => $weekly_asked_price, "auction_reserve_offer_price"=>'',
                     "auction_start_date" => $start_date, "auction_end_date" => $end_date,
                     "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
					 
				 $posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), 'flat_rolled' => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
				 $obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
					$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
					$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
					$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
					$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
					$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

                 $obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), false);
                 $obj->deleteData(TBL_BID, array('bid_fk_auction_id' => $auction_id));
                 $obj->deleteData(TBL_AUCTION, array('auction_id' => $auction_id));
                 $_SESSION['adminErr'] = "Auction has been re-opened successfully.";
                 header("location: ".$decode_string);
             }else{
                 $_SESSION['adminErr'] = "Please provide auction week to relist.";
                 header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
             }
         }

     }else{
         $_SESSION['adminErr'] = "Please select a relist type for this poster.";
         header("location: ".PHP_SELF."?mode=reopen_weekly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
     }
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id'],"reopen_auction_id"=>"0"));
	//print_r($auctionRow);
	if(empty($auctionRow)){
		$is_empty='1';
		$smarty->assign("is_empty", $is_empty);
	}
	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
     for($i=0;$i<count($posterImageRows);$i++){
         if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
             $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
         }else{
             $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
         }
     }
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
 	if(check_int($new_buy_now)==true){
	$obj = new Auction();
	$new_auctionData = array("auction_asked_price" => $new_buy_now,"is_reopened"=>'1',
						 "fk_poster_id"=>$poster_id,"fk_auction_type_id"=>'1',"auction_is_approved"=>'1'
	,"auction_is_sold"=>'0',"post_date"=>date('Y-m-d H:i:s'),'up_date' => "0000-00-00","status"=>'1','post_ip' => $_SERVER["REMOTE_ADDR"]);
	$obj->updateData(TBL_AUCTION, $new_auctionData,false);
	$reopen_auction_id=mysqli_insert_id($GLOBALS['db_connect']);	
	
	$auctionWhere = array("auction_id" => $auction_id);
	$auctionData = array("reopen_auction_id" => $reopen_auction_id);
	
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);
       // $sql_invoice_id=mysqli_query($GLOBALS['db_connect'],"Select ")
        $sql_update="UPDATE tbl_invoice ti,tbl_invoice_to_auction tia set ti.is_cancelled='1' where ti.invoice_id=tia.fk_invoice_id and tia.fk_auction_id=$auction_id";
        $res_sql_update=mysqli_query($GLOBALS['db_connect'],$sql_update);
                $_SESSION['adminErr'] = "Auction has been re-opened successfully.";
		header("location: ".$decoded_string);
 	}else{
 		$_SESSION['adminErr'] = "Please provide proper numeric value for buy now price.";
		header("location: ".PHP_SELF."?mode=reopen_monthly&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
 	}
 }
 
function delete_auction()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";

	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	extract($_REQUEST);
	
	$auctionObj = new Auction();
	$auctionData = $auctionObj->selectData(TBL_AUCTION, array('fk_poster_id', 'auction_is_approved','fk_auction_type_id','auction_is_sold','reopen_auction_id'), array('auction_id' => $auction_id));
	
	
	$auctionObj->deleteData(TBL_OFFER, array('offer_fk_auction_id' => $_REQUEST['auction_id']));	
	
	$auctionObj->deleteData(TBL_BID, array('bid_fk_auction_id' => $_REQUEST['auction_id']));
    $auctionObj->deleteData(TBL_PROXY_BID, array('fk_auction_id' => $_REQUEST['auction_id']));
	
	
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
			
				$posterLarge = "../poster_photo/".$value['poster_image'];
				$posterThumb = "../poster_photo/thumbnail/".$value['poster_thumb'];	
				$posterThumbBuy = "../poster_photo/thumb_buy/".$value['poster_thumb'];
				$posterThumbBuyGallery = "../poster_photo/thumb_buy_gallery/".$value['poster_thumb'];
							
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
		
		$_SESSION['adminErr'] = "Auction deleted successfully.";
	
	if($type=='1'){
		header("location: ".PHP_SELF."?mode=fixed");
	}elseif($type=='2'){
		header("location: ".PHP_SELF."?mode=weekly");
	}else{
		header("location: ".PHP_SELF."?mode=monthly");
	}	
	exit;
}
function create_fixed(){

if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Fixed Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);

	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$obj->orderBy = FIRSTNAME;
	$obj->orderType = ASC;
	//$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1), true);
	$smarty->assign("userRow", $userRow);
	
	$smarty->assign("event_id", $_REQUEST['event_id']);
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $PosterDesc;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_create_fixed_auction.tpl');
	
	}
	
	function validateNewFixedForm(){

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
		$GLOBALS['dacade_err'] = "Please select Decade.";
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
	
	if($_POST['is_consider']==1){
		if($_POST['offer_price'] == ""){
			$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif($_POST['offer_price']==0){
			$GLOBALS['offer_price_err'] = "Please enter proper numeric value.";
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
					$GLOBALS['offer_price_err'] = "Minimum Offer price must be less than asked price.";
					$errCounter++;  
				}
			}
		}
	}
	
	if($_POST['poster_images'] == "" && !isset($_SESSION['img']) ){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;  
    }else{
	$posterimages=$_POST['poster_images'];
	$imgstr='';
	if(isset($_SESSION['img']))
	{
	foreach($_SESSION['img'] as $v)
	{
	if($v!="")
	{
	$imgstr.=$v.",";
	}
	}
	//$imgstr=implode(",",$_SESSION['img']);
	
	
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
	function save_new_fixed_auction(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
    extract($_POST);
    $obj = new Poster();
	$user_name=$_POST['user_id'];
	$objUser = new User();
	$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
	$user_new_id=$arrUser[0]['user_id'];
    $data = array('fk_user_id' => $user_new_id,
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => date("Y-m-d H:i:s"),
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]
                  );
    $poster_id = $obj->updateData(TBL_POSTER, $data);
    
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
		if($poster_images!= "")
		{
    $posterArr = explode(',', trim($poster_images, ','));
    ##### NEW FUNCTION FOR POSTER UPLOAD starts #####
	$base_temp_dir="../poster_photo/temp/$random"; 
	$src_temp="../poster_photo/temp/$random/";
	$dest_poster_photo="../poster_photo/";
	$destThumb = "../poster_photo/thumbnail";
	$destThumb_buy = "../poster_photo/thumb_buy";
	$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
	$destThumb_big_slider = "../poster_photo/thumb_big_slider";
	dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
	
	
    if (is_dir($base_temp_dir)) {
    	rmdir($base_temp_dir);
		}
	##### NEW FUNCTION FOR POSTER UPLOAD ends #####
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
    
    $is_percentage = ($is_percentage == '')? '0' : '1';
    $is_considered = ($is_consider == '')? '0' : '1';
    if($is_considered ==0){
		$offer_price = 0;
	}
    $data = array("fk_auction_type_id" => 1,
                  "fk_poster_id" => $poster_id,
                  "auction_asked_price" => $asked_price,
                  "auction_reserve_offer_price" => $offer_price,
                  "is_offer_price_percentage" => $is_percentage,
                  "auction_is_approved" => 1,
                  "auction_is_sold" => 0,
                  "auction_note" => add_slashes($auction_note),
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => date("Y-m-d H:i:s"),
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"],
                  'imdb_link'=>$imdb_link);
                  
    $auction_id=$obj->updateData(TBL_AUCTION, $data);
	$objWantlist=new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
    if($auction_id > 0){     
        $_SESSION['adminErr']="Poster added successfully.";
       //header("location: ".PHP_SELF."?mode=fixed");
		header("location: admin_auction_manager.php?mode=fixed");
        exit();
    }else{
        $_SESSION['adminErr']="Could not add poster.Please try again.";
		header("location: admin_auction_manager.php?mode=fixed");
        //header("location: ".PHP_SELF."?mode=manualupload");
        exit();
    }
}
	/*********** Bulkuplod Starts ***********/

function bulkupload()
{
    require_once INCLUDE_PATH."lib/adminCommon.php";
    define ("PAGE_HEADER_TEXT", "Admin Bulk Upload");
    foreach ($_FILES as $key => $value ) {
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
    }
	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		
	}

    $smarty->display("admin_bulkupload.tpl");

}

function validateBulkupload()
{
    $errCounter = 0;
    $fileExt = end(explode('.', $_FILES['bulkupload']['name']));
	$size = $_FILES['bulkupload']['size']/ 1000000;
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
    }elseif($size > 30){
        $GLOBALS['bulkupload_err']="Please select a zip file less than 30 mb.";
        $errCounter++;
    }
	if($_REQUEST['user_id'] == ""){
		$GLOBALS['user_id_err'] = "Please select an User.";
		$errCounter++;	
	}else{
		$user_name=$_REQUEST['user_id'];
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

    if($errCounter > 0){
        return false;
    }else{
        return true;
    }
}

function save_bulkupload()
{
	// Bulkupload Upload Starts
	$user_name=$_POST['user_id'];
	$objUser = new User();
	$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
	$user_new_id=$arrUser[0]['user_id'];
	if(is_uploaded_file($_FILES['bulkupload']['tmp_name'])){
		$path = "../bulkupload/".session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'];
		$fieldName = "bulkupload";
		$fileName = rand(999, 999999);
		$uploadedFilename = moveUploadedFile($fieldName, $path, $fileName);
		
	}
	$zipObj = new ZipArch();
	$status = $zipObj->unzip($path."/".$uploadedFilename, $dest_dir=false, $create_zip_name_dir=false, $overwrite=false);

	// Bulkupload Upload Ends
	
	// Read CSV / XLS File Starts

	$row = 1;
	if (!is_file($path."/auction/auction.csv")) {
		$_SESSION['adminErr'] = "CSV file not found. Check your folder structure.";
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();
	}else{
		parseCSVFile($path."/auction/",$path,$fileName,$user_new_id);
	}
	
	// Read CSV / XLS File Ends
	
	return false;
}

function parseCSVFile($pathOfCsvFile,$path,$fileName,$user_new_id) {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	$error_ind=0;
    $genericErrorMessage = '';
    $insertRecordMeg ='';
	$successCounter = 0;
    /*if (!is_file($pathOfCsvFile . 'auction.csv')) {
        $genericErrorMessage = "CSV file not found. Check your folder structure.";
        $smarty->assign('genericErrorMessage', $genericErrorMessage);
        $smarty->assign('insertRecordMeg', '');
        $smarty->display("bulkupload.tpl");
        die;
    }*/
    if (($handle = fopen($pathOfCsvFile.'auction.csv','r')) !== FALSE) {
		$i = 0;
		$delimiter =',';
		while (($lineArray = fgetcsv($handle, 1024, $delimiter)) !== FALSE) {		
			for ($j=0; $j<count($lineArray); $j++) {
				$data2DArray[$i][$j] = $lineArray[$j];
			}
			$i++;
		}
		fclose($handle);
	}else{
		$_SESSION['adminErr'] = "Cannot open CSV file. Please try again.";
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();
	}
    $newData = array();
    $totalItemInArray = count($data2DArray); //excluding the headers
    $countInnerArray = count($data2DArray[0]);

	
######  Not required as now bulk upload only for fixed #######	
    for($c=1; $c<$totalItemInArray; $c++)
    {
		$errCounter = 0;
		
		$conditionId = '';
		$sizeId = '';
		$genreId = '';
		$decadeId = '';
		$countryId = '';
		
			
			
			$replaceArr = array("\n", "\r", "\t", " ", "\o", "\xOB");
			$condition = strtolower(str_replace($replaceArr, '', $data2DArray[$c][4]));
			$size = strtolower(str_replace($replaceArr, '', $data2DArray[$c][5]));
			$genre = strtolower(str_replace($replaceArr, '', $data2DArray[$c][6]));
			$decade = strtolower(str_replace($replaceArr, '', decade_calculator($data2DArray[$c][7])));
			$country = strtolower(str_replace($replaceArr, '', $data2DArray[$c][8]));

			
			$conditionId = fetchCategoryId($condition,5);
			$sizeId = fetchCategoryId($size,1);
			$genreId = fetchCategoryId($genre,2);
			$decadeId = fetchCategoryId($decade,3);
			$countryId = fetchCategoryId($country,4);
			$is_consider=strtolower(str_replace($replaceArr, '', $data2DArray[$c][10])); 
			
    	if(!empty($data2DArray[$c][3]))	{
	        $posterImage = explode(',',$data2DArray[$c][3]);
	        //print_r($posterImage);
			$imageFlag = 0;
        if (!empty($posterImage)) {
            foreach ($posterImage as $imageKey) {
                $imageKey = trim($imageKey);
                if (is_file($pathOfCsvFile.'poster_photo/'.$imageKey) && isImage($imageKey)) {
					//if img not found check for the next image
					$imageFlag = 1;
					//
                }elseif(!isImage($imageKey)){
                	$imageFlag = 0;
					break;
				}elseif(!is_file($pathOfCsvFile.'poster_photo/'.$imageKey)){
					$imageFlag = 2;
					break;
				}
            }
        }
		}else{
            $errCounter++;
			$posterLog .= "Poster {$c}: Poster image is empty.<br />";
			$posterImageInd=1;
        }

		$auctionType = strtolower(trim($data2DArray[$c][2]));
		
		if(isEmpty($data2DArray[$c][0])){// Checking for Poster Title
			$errCounter++;
			$posterLog .= "Poster {$c}: Poster title is empty.<br />";
		}
		######  Not required as now bulk upload only for fixed #######
		/*elseif(isEmpty($data2DArray[$c][2]) || ($auctionType != 'fixed' && $auctionType != 'weekly' && $auctionType != 'monthly')){// Checking for Auction Type e.g., monthly, weekly, fixes
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster type.<br />";
		}*/
		######  Not required as now bulk upload only for fixed #######
		elseif(isEmpty($data2DArray[$c][2])){// Checking for Poster Description
			$errCounter++;			
			$posterLog .= "Poster {$c}: Poster description is empty.<br />";
		}elseif($imageFlag == 0){// Checking for Poster Images
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster files. jpg, jpeg, gif and png files are allowed.<br />";	
		}elseif($imageFlag == 2){// Checking for Poster Images
			$errCounter++;
			$posterLog .= "Poster {$c}: Poster Image not found.<br />";	
		}elseif(isEmpty($conditionId)){// Checking for Poster Category Condition
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster condition.<br />";
		}elseif(isEmpty($sizeId)){// Checking for Poster Category Size
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster size.<br />";
		}elseif(isEmpty($genreId)){// Checking for Poster Category Genre
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster genre.<br />";
		}elseif(isEmpty($decadeId)){// Checking for Poster Category Decade
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster decade.<br />";
		}elseif(isEmpty($countryId)){// Checking for Poster Category Country
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid poster country.<br />";	
		}elseif((isEmpty($data2DArray[$c][9]) || check_int($data2DArray[$c][9]) == 0)){// Checking for Ask Price
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid ask price.<br />";
		}elseif(isEmpty($data2DArray[$c][10]) || check_int($data2DArray[$c][10]) == 0){//Checking for Offer Price
			$errCounter++;
			$posterLog .= "Poster {$c}: Invalid Min offer I wiil consider.<br />";
		}elseif($data2DArray[$c][10] > $data2DArray[$c][9]){//Checking for Min offer Price < Asked Price
			$errCounter++;
			$posterLog .= "Poster {$c}: Minimum Offer price must be less than Ask price.<br />";
		}
		

		if($errCounter == 0){ 
        	//for($innerElement = 0; $innerElement < $countInnerArray; $innerElement++){
				$auctionID = insertRecord($data2DArray[$c], array($conditionId, $sizeId, $genreId, $decadeId, $countryId),$data2DArray[$c][$innerElement] ,$pathOfCsvFile, $auctionWeekId, $auctionWeekStartDate, $auctionWeekEndDate, $eventId, $eventStartDate, $eventEndDate,$user_new_id );
				
				if($auctionID > 0){
					$successCounter++;
					$posterLog .= "Poster {$c}: Poster uploaded successfully.<br />";
				}else{
					$posterLog .= "Poster {$c}: Poster uploaded failed.<br />";
				}
			//}
		}
    }
	//delete_directory($path."/");

	//$_SESSION['Err'] = $successCounter." poster has been uploaded.";
	$_SESSION['adminErr'] = $posterLog;
	header("location: ".PHP_SELF."?mode=bulkupload");
	exit();
}//eof function

function isEmpty($string){
    return ($string=='');
}

function fetchCategoryId($catNameValue,$key) {
    require_once INCLUDE_PATH . "lib/common.php";
    $returnCatid = '';
    $sql = "SELECT cat_id FROM ".TBL_CATEGORY." WHERE 
   			( STRCMP( LCASE( replace( cat_value, ' ', '' ) ) , '" . $catNameValue . "' )=0 
				OR
			 LCASE( replace( cat_value, ' ', '' ) ) LIKE '%".$catNameValue."%' ) and fk_cat_type_id=".$key;
			 
    $result = mysqli_query($GLOBALS['db_connect'],$sql);
    if (mysqli_num_rows($result) > 0) {
        $fixedRow = mysqli_fetch_array($result);
        $returnCatid = $fixedRow['cat_id'];
    }

    return $returnCatid;
}

function insertRecord($csvDataArray, $categoryIdArray, $auctionType, $pathOfCsvFile, $auctionWeekId='', $auctionWeekStartDate='', $auctionWeekEndDate='', $eventId='', $eventStartDate='', $eventEndDate='',$user_new_id){

	require_once INCLUDE_PATH . "lib/common.php";
	
	$erorr = '';
	$debug = false;	
	$auctionObj = new Auction();
	
    if(isset($_GET) && $_GET['debug'] == 'true')
        $debug = true;
   
    //Poster Insertion
    if (!empty($csvDataArray) && $debug == false) {
		if(trim($csvDataArray[11]) == 'flat'){
			$flat_rolled = 'flat';
		}else{
			$flat_rolled = 'rolled';
		}
        $posterArray = array(
            'fk_user_id' => $user_new_id,
            'poster_title' => trim(addslashes($csvDataArray[0])),
            'poster_desc' => trim(addslashes($csvDataArray[2])),
            'poster_sku' => generatePassword(6),
			'flat_rolled' => $flat_rolled,
            'post_date' => date("Y-m-d h:i:s"),
        	'up_date' => date("Y-m-d h:i:s"),
            'post_ip' => $_SERVER['REMOTE_ADDR'],
        );

		$insertedPosterId = $auctionObj->updateData(TBL_POSTER, $posterArray);

        if ($insertedPosterId > 0) {
            $posterImageFromCSV = array();
            $posterImageArray = array();
            //Adding the poster images
            $posterImageFromCSV = explode(',',$csvDataArray[3]);
            //$posterImageArray = renameImage($pathOfCsvFile,$posterImageFromCSV);
            for($i = 0; $i < count($posterImageFromCSV); $i++){
                    $defaultImg = $posterImageFromCSV[0];
					
				}//End of image insert for loop
				
                //Inserting in the poster
                ##### NEW FUNCTION FOR POSTER UPLOAD starts #####
				
				$src_temp = $pathOfCsvFile.'poster_photo/';	
				$dest_poster_photo="../poster_photo/";
				$destThumb = "../poster_photo/thumbnail";
				$destThumb_buy = "../poster_photo/thumb_buy";
				$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
				$destThumb_big_slider = "../poster_photo/thumb_big_slider";
				dynamicPosterUpload($posterImageFromCSV,$insertedPosterId,$defaultImg,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
	
				##### NEW FUNCTION FOR POSTER UPLOAD ends #####
				

            //Adding the category to the poster
            for($i = 0; $i<count($categoryIdArray); $i++){
                $posterCatAttributes = array(
                    'fk_poster_id'  =>  $insertedPosterId,
                    'fk_cat_id'     =>  $categoryIdArray[$i],
                );
				$auctionObj->updateData(TBL_POSTER_TO_CATEGORY, $posterCatAttributes);
				
            }//end of category for loop

            /**********************Adding to the Auction****************************/
            //Insert in the auction table
            //Setting the type id of auction
            $auctionTypeId = '1';
            /*if(strtolower(trim($csvDataArray[2])) == 'fixed')
                $auctionTypeId = "1";
            elseif(strtolower(trim($csvDataArray[2])) == 'weekly')
                $auctionTypeId = "2";
            elseif(strtolower(trim($csvDataArray[2])) == 'monthly')
                $auctionTypeId = "3";*/

            //Determining the offer price is percentage or not
            $isOfferPercentage = 0;
        	//$offerPrice = $csvDataArray[10];
            //$replaceArr = array("\n", "\r", "\t", " ", "\o", "\xOB");
			//$offerPrice = strtolower(str_replace($replaceArr, '', $csvDataArray[10]));
			$offerPrice = ($csvDataArray[10]!='') ? number_format($csvDataArray[10], 2, '.', '') : '';
			

            if($offerPrice=='yes'){
            	$offerPrice=1;
            }elseif($offerPrice=='no'){
            	$offerPrice=0;
            }
			
			//////
			/*if(strtolower(trim($csvDataArray[2])) == 'weekly'){				
				$start_date = $auctionWeekStartDate;
				$end_date = $auctionWeekEndDate;				
			}elseif(strtolower(trim($csvDataArray[2])) == 'monthly'){				
				$start_date = $eventStartDate;
				$end_date = $eventEndDate;
			}*/
			
			/*$startTimeArr = extract_time1($csvDataArray[18]);
			if(!empty($startTimeArr)){
			if(strtolower($startTimeArr[4]) == 'am'){
				$start_time = $startTimeArr[1].":".$startTimeArr[2];
			}else{
				$start_time = ($startTimeArr[1] + 12).":".$startTimeArr[2];
			}
			}else{
				$startTimeArr = extract_time2($csvDataArray[18]);
				if(strtolower($startTimeArr[3]) == 'am'){
					$start_time = $startTimeArr[1].":".$startTimeArr[2];
				}else{
					$start_time = ($startTimeArr[1] + 12).":".$startTimeArr[2];
				}
			}
			
			$endTimeArr = extract_time1($csvDataArray[19]);
			if(!empty($endTimeArr)){
			if(strtolower($endTimeArr[4]) == 'am'){
				$end_time = $endTimeArr[1].":".$endTimeArr[2];
			}else{
				$end_time = ($endTimeArr[1] + 12).":".$endTimeArr[2];
			}
			}else{
				$endTimeArr = extract_time2($csvDataArray[19]);
				if(strtolower($endTimeArr[3]) == 'am'){
					$end_time = $endTimeArr[1].":".$endTimeArr[2];
				}else{
					$end_time = ($endTimeArr[1] + 12).":".$endTimeArr[2];
				}
			}
			
			$auctionActualStartTime = $start_date.' '.$start_time;
			$auctionActualEndTime = $end_date.' '.$end_time;*/
			//////

            $startingPrice = 0;
            $startingPrice = ($csvDataArray[9]!='') ? number_format($csvDataArray[9], 2, '.', '') : '';
            /*if($startingPrice=='' && $csvDataArray[2]!='fixed'){
                if($csvDataArray[12]!=''){
                    $startingPrice = trim($csvDataArray[12]);
                    $startingPrice = number_format($startingPrice, 2, '.', '');
				}
            }*/

            $auctionDataArray = array(
								'fk_auction_type_id'                => 1,
								'fk_poster_id'                      => $insertedPosterId,
								'fk_event_id'                       => 0,
								'fk_auction_week_id'                => 0,
								'auction_asked_price'               => $startingPrice,
								'auction_reserve_offer_price'       => $offerPrice,
								'is_offer_price_percentage'         => $isOfferPercentage,
								'auction_buynow_price'              => 0.00,
								'auction_start_date'                => 0000-00-00,
								'auction_end_date'                  => 0000-00-00,
								'auction_actual_start_datetime'     => '0000-00-00 00:00:00',
								'auction_actual_end_datetime'       => '0000-00-00 00:00:00',
								'auction_is_approved'               => 1,
								'is_approved_for_monthly_auction'   => 0,
								'auction_is_sold'                   => 0,
								'auction_note'                      => $csvDataArray[1],
								'post_date'                         => date("Y-m-d h:i:s"),
								'status'                            => 1,
								'post_ip'                           => $_SERVER['REMOTE_ADDR']
            );

			return $auctionId = $auctionObj->updateData(TBL_AUCTION, $auctionDataArray);

            /**********************Adding to the Auction****************************/

        }//end of posterinsert if()
        else {
            $erorr = '<br />There is some error in the operation in - '.$auctionType.'.
                      <br />Unable to add the poster data<br />['.mysqli_error($GLOBALS['db_connect']).']';
        }
    }else{
        $erorr = '<br />This is in testing mode. No insertion operation will be performed<br>';
    }

    //return $error;
	
	return 0;
	
}//end of insertRecord()
function bulkupload_pending(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		define ("PAGE_HEADER_TEXT", "Admin Pending Bulk Uploads");
		$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
		$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
		$sql_bulk="Select b.*,u.firstname,u.lastname,u.username from tbl_pending_bulkuploads b,user_table u 
							where b.status ='0' and u.user_id =b.fk_user_id order by b.upload_date desc";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql_bulk)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		}
//		echo "<pre>";
//		print_r($dataArr);
//		echo "</pre>";
		$countRow = count($dataArr);
		$smarty->assign('total', $countRow);
		$smarty->assign('bulkRows', $dataArr);
		$smarty->display('admin_bulkupload_pending.tpl');
	}
	function download_bulk(){
		
	$filename = $_REQUEST['file'];
	
	// required for IE, otherwise Content-disposition is ignored
	if(ini_get('zlib.output_compression'))
	ini_set('zlib.output_compression', 'Off');
	
	// addition by Jorg Weske
	$file_extension = strtolower(substr(strrchr($filename,"."),1));
	
	if( $filename == "" )
	{
		echo "<html><title>Title Here</title><body>ERROR: download file NOT SPECIFIED. </body></html>";
		exit;
	} elseif (!file_exists("../bulk/".$filename) ){
		echo "<html><title>Title Here</title><body>ERROR: File not found.</body></html>";
		exit;
	};
	switch($file_extension)
	{
		
		case "pdf": $ctype="application/pdf"; break;
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "doc": $ctype="application/msword"; break;
		case "xls": $ctype="application/vnd.ms-excel"; break;
		case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		case "gif": $ctype="image/gif"; break;
		case "png": $ctype="image/png"; break;
		case "jpeg":
		case "jpg": $ctype="image/jpg"; break;
		default: $ctype="application/force-download";
	}
	
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	// change, added quotes to allow spaces in filenames, by Rajkumar Singh
	header("Content-Disposition: attachment; filename=\"".basename("../bulk/".$filename)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize("../bulk/".$filename));
	readfile("../bulk/".$filename);
	exit();
	}
	function delete_bulk(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		//$auctionObj = new Auction();
		//$auctionData = $auctionObj->selectData(TBL_PENDING_BULKUPLOADS, array('file_name'), array('bulkupload_id' => $_REQUEST['bulkupload_id']));
		$bulkupload_id=$_REQUEST['bulkupload_id'];
		$auctionData = mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select file_name from tbl_pending_bulkuploads where bulkupload_id = $bulkupload_id "));
		
		unlink("../bulk/".$auctionData['file_name']);
		//$auctionObj->deleteData(TBL_PENDING_BULKUPLOADS, array('bulkupload_id' => $_REQUEST['bulkupload_id']));
		$deleteData=mysqli_query($GLOBALS['db_connect'],"Delete from tbl_pending_bulkuploads where bulkupload_id = $bulkupload_id ");
		$_SESSION['adminErr'] = "Record deleted successfully.";
		header("location: ".PHP_SELF."?mode=bulkupload_pending");
	}
	 function track_first_sold_for_home(){
	  $actionId = $_REQUEST['actionId'];
	  $deleteExistingSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '0'
	  WHERE
	  auction_is_approved = '1' AND auction_is_sold != '0' AND slider_first_position_status = '1'" ;
	  mysqli_query($GLOBALS['db_connect'],$deleteExistingSliderStatus); 
	  
	  $updateNewSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '1'
	  WHERE
	  auction_is_approved = '1' AND auction_is_sold != '0' AND auction_id ='$actionId' " ;
	  mysqli_query($GLOBALS['db_connect'],$updateNewSliderStatus);
	  
	  echo "The poster has been successfully set as first poster image.";
  
 }
 function updateSlider(){
	  $actionId = $_REQUEST['actionId'];
	  $deleteExistingSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '0'
	  WHERE
	  auction_is_approved = '1' AND auction_is_sold = '0' AND  slider_first_position_status = '1'" ;
	  mysqli_query($GLOBALS['db_connect'],$deleteExistingSliderStatus); 
	  $updateNewSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '1'
	  WHERE
	   auction_is_approved = '1' AND auction_is_sold = '0' AND auction_id ='$actionId' " ;
	  mysqli_query($GLOBALS['db_connect'],$updateNewSliderStatus);
	  
	  echo "The poster has been successfully set as first poster image.";
 }
 function clearOffer(){
	  $actionId = $_REQUEST['auction_id'];
	  $delteOffer = "DELETE FROM tbl_offer WHERE  offer_fk_auction_id = '$actionId' ";
	  mysqli_query($GLOBALS['db_connect'],$delteOffer);
	  echo "1";
    }
    function mark_as_paid_invoice(){
        require_once INCLUDE_PATH."lib/adminCommon.php";
        $dbCommonObj = new Invoice();
        $update=$dbCommonObj->updateData(TBL_INVOICE,array('paid_on'=>date('Y-m-d :H:i:s'),'is_paid'=>'1','is_ordered' =>'0'),array('invoice_id'=>$_REQUEST['invoice_id']),true);
        $sql= "Select distinct(fk_auction_id) from tbl_invoice_to_auction where fk_invoice_id='".$_REQUEST['invoice_id']."' ";
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
			 $sqlauction = "Select auction_is_sold from tbl_auction where auction_id='".$row['fk_auction_id']."' ";
			 $rsAuction=mysqli_query($GLOBALS['db_connect'],$sqlauction);
			 $rowAuction = mysqli_fetch_assoc($rsAuction);
			 if($rowAuction['auction_is_sold']=='3'){
				$update=$dbCommonObj->updateData(TBL_AUCTION,array('auction_payment_is_done'=>'1','auction_is_sold'=>'2'),array('auction_id'=>$row['fk_auction_id']),true);
			 }else{
				$update=$dbCommonObj->updateData(TBL_AUCTION,array('auction_payment_is_done'=>'1'),array('auction_id'=>$row['fk_auction_id']),true);
			 }
                
            }
        }
        $dbCommonObj->generateSellerInvoice($_REQUEST['invoice_id']);
        $dbCommonObj->mailInvoice($_REQUEST['invoice_id'],'phone_order_approve');
    }
	function phone_order() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Phone Order Invoice");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=phone_order&search_fixed_poster=".$_REQUEST['search_fixed_poster']);
	}else{
	$auctionObj = new Auction();
	$auctionObj->orderType = 'DESC';
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
	
	$total = $auctionObj->countPhoneOrderByStatus($_REQUEST['search_fixed_poster'],$start_date,$end_date);
	
	if($total>0){		
		$auctionRows = $auctionObj->fetchPhoneOrderByStatus($_REQUEST['search_fixed_poster'],$start_date,$end_date);
		
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
			if (file_exists("../poster_photo/" . $auctionRows[$i]['poster_image'])){
                list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
            }else{
                list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }
    	}
		$smarty->assign('auctionRows', $auctionRows);			
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search_fixed_poster']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	$smarty->display('admin_phone_order_manager.tpl');
}
function stills() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=fixed&search=".$_REQUEST['search']);
	}else{
		$auctionObj = new Auction();
		$auctionObj->orderType = 'DESC';
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
	if($_REQUEST['search']!='sold'){
			$total = $auctionObj->countStillsByStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$total = $auctionObj->soldAuctionCOUNTSTILLS($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
	if($total > 0 ){
	if($_REQUEST['search']!='sold'){
			$auctionRows = $auctionObj->fetchStillsByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$auctionObj->orderBy='invoice_generated_on';
			$auctionRows=$auctionObj->soldAuctionSTILLS($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
			if ($auctionRows[$i]['is_cloud'] !='1'){
                list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=$width;
                $auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
            }else{
                //list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=800;
                $auctionRows[$i]['img_height']=800;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }
    	}		
		
    			$smarty->assign('auctionRows', $auctionRows);			
				$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
				$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    	
     }
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	$smarty->display('admin_stills_manager.tpl');
}
 function create_stills(){

if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);

	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$obj->orderBy = FIRSTNAME;
	$obj->orderType = ASC;
	//$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1), true);
	$smarty->assign("userRow", $userRow);
	
	$smarty->assign("event_id", $_REQUEST['event_id']);
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $PosterDesc;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_create_stills.tpl');
	
	}
	function validateNewStillsForm(){

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
		$GLOBALS['poster_title_err'] = "Please enter Stills/Photos Title.";
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
		$GLOBALS['dacade_err'] = "Please select Decade.";
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
		$GLOBALS['poster_desc_err'] = "Please enter Stills/Photos Description.";
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
	
	if($_POST['is_consider']==1){
		if($_POST['offer_price'] == ""){
			$GLOBALS['offer_price_err'] = "Please enter Offer Price.";
			$errCounter++;
			$offer_price_err = 1;
		}elseif($_POST['offer_price']==0){
			$GLOBALS['offer_price_err'] = "Please enter proper numeric value.";
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
					$GLOBALS['offer_price_err'] = "Minimum Offer price must be less than asked price.";
					$errCounter++;  
				}
			}
		}
	}
	
	if($_POST['poster_images'] == "" && !isset($_SESSION['img']) ){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;  
    }else{
	$posterimages=$_POST['poster_images'];
	$imgstr='';
	if(isset($_SESSION['img']))
	{
	foreach($_SESSION['img'] as $v)
	{
	if($v!="")
	{
	$imgstr.=$v.",";
	}
	}
	//$imgstr=implode(",",$_SESSION['img']);
	
	
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
function save_new_stills(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
    extract($_POST);
    $obj = new Poster();
	$user_name=$_POST['user_id'];
	$objUser = new User();
	$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
	$user_new_id=$arrUser[0]['user_id'];
    $data = array('fk_user_id' => $user_new_id,
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => date("Y-m-d H:i:s"),
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);
    $poster_id = $obj->updateData(TBL_POSTER, $data);
    
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
		if($poster_images!= "")
		{
    $posterArr = explode(',', trim($poster_images, ','));
    ##### NEW FUNCTION FOR POSTER UPLOAD starts #####
	$base_temp_dir="../poster_photo/temp/$random"; 
	$src_temp="../poster_photo/temp/$random/";
	$dest_poster_photo="../poster_photo/";
	$destThumb = "../poster_photo/thumbnail";
	$destThumb_buy = "../poster_photo/thumb_buy";
	$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
	$destThumb_big_slider = "../poster_photo/thumb_big_slider";
	dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
	
	
    if (is_dir($base_temp_dir)) {
    	rmdir($base_temp_dir);
		}
	##### NEW FUNCTION FOR POSTER UPLOAD ends #####
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
    
    $is_percentage = ($is_percentage == '')? '0' : '1';
    $is_considered = ($is_consider == '')? '0' : '1';
    if($is_considered ==0){
		$offer_price = 0;
	}
    $data = array("fk_auction_type_id" => 4,
                  "fk_poster_id" => $poster_id,
                  "auction_asked_price" => $asked_price,
                  "auction_reserve_offer_price" => $offer_price,
                  "is_offer_price_percentage" => $is_percentage,
                  "auction_is_approved" => 1,
                  "auction_is_sold" => 0,
                  "auction_note" => add_slashes($auction_note),
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => date("Y-m-d H:i:s"),
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"]);
                  
    $auction_id=$obj->updateData(TBL_AUCTION, $data);
	$objWantlist=new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
    if($auction_id > 0){     
        $_SESSION['adminErr']="Stills/Photos added successfully.";
       //header("location: ".PHP_SELF."?mode=stills");
		header("location: admin_auction_manager.php?mode=stills");
        exit();
    }else{
        $_SESSION['adminErr']="Could not add Stills/Photos.Please try again.";
		header("location: admin_auction_manager.php?mode=stills");
        //header("location: ".PHP_SELF."?mode=manualupload");
        exit();
    }
}
function edit_stills() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Manager");

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
		
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->fetchEditAuctionDetail($_REQUEST['auction_id']);

	//$offerObj = new Offer();
	//$offerCount = $offerObj->countData(TBL_OFFER, array("offer_fk_auction_id" => $_REQUEST['auction_id']));

	//$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	
	$posterRow[0]['poster_desc'] = strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title'] = strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
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
	//$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	//$smarty->assign("offer_count", $offerCount);
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $auctionRow[0]['poster_desc'] ;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_edit_stills_manager.tpl');
	}
	function update_stills()
{
	extract($_REQUEST);
	$obj = new Auction();
	$is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered ==0){
		$offer_price = 0;
	}
	$auctionData = array("auction_asked_price" => $asked_price, "auction_reserve_offer_price" => $offer_price,
						 "is_offer_price_percentage" => $is_percentage, "auction_note" => add_slashes($auction_note));
	$auctionWhere = array("auction_id" => $auction_id);
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

	//////////////Added By Sourav banerjee////////////////////
	
		
	
	if(isset($poster_images) || isset($_SESSION['img'])){
	
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
		if($poster_images!= "")
		{
         $posterArr = explode(',', trim($poster_images, ','));
	
		//////////////Added By Sourav banerjee////////////////////
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="../poster_photo/temp/$random";
		$src_temp="../poster_photo/temp/$random/";
		$dest_poster_photo="../poster_photo/";
		$destThumb = "../poster_photo/thumbnail";
		$destThumb_buy = "../poster_photo/thumb_buy";
		$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "../poster_photo/thumb_big_slider";
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

	//if($chk){
		$_SESSION['adminErr'] = "Stills/Photos has been updated successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?cat_type_id=".$fk_cat_type_id);
		//exit;
	}*/
}
 function weekly_relist(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		
		extract($_REQUEST);
		$objAuction = new Auction();
		$auctionDetails=$objAuction->select_details_auction($id);
		$auctionDetails[0]['poster_desc']=strip_slashes($auctionDetails[0]['poster_desc']);
		if (file_exists("poster_photo/" . $auctionDetails[0]['poster_image'])){
			$auctionDetails[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionDetails[0]['poster_image'];
		 }else{
			 $auctionDetails[0]['image_path']=CLOUD_POSTER_THUMB.$auctionDetails[0]['poster_image'];
		 }
		$posterObj = new Poster();
		$posterObj->fetchPosterCategories($auctionDetails);
		$smarty->assign('auctionDetails', $auctionDetails);
		
		$auctionWeekObj = new AuctionWeek();
		$aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
		$smarty->assign('aucetionWeeks', $aucetionWeeks);
		$smarty->assign('auction_id', $id);
		$smarty->display("admin_auction_weekly_relist.tpl"); 
	}
	function relist_weekly_to_weekly(){
	
		extract($_REQUEST);
		$obj = new Auction();
		$row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
		$start_date = $row[0]['auction_week_start_date'];
		$end_date = $row[0]['auction_week_end_date'];
		
		$auctionData = array("fk_auction_type_id"=>'2',"fk_auction_week_id" => $auction_week, "auction_asked_price" => $asked_price,"auction_buynow_price" => '', "auction_start_date" => $start_date, "auction_end_date" => $end_date,
							 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
		$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
		$obj->deleteData(TBL_OFFER, array('offer_fk_auction_id' => $auction_id));				 
 
	}
  function shipped_item_list(){
	   extract($_REQUEST);
	   $dataArr = array();	   
	   $sql = " Select p.poster_title,a.fk_auction_type_id  
	                   from tbl_auction a , 
					   tbl_poster p ,
					   tbl_invoice_to_auction tia 
					       WHERE tia.fk_invoice_id = '".$_REQUEST['invoice_id']."' 
						   AND a.auction_id =  tia.fk_auction_id
						   AND a.fk_poster_id = p.poster_id	
						   " ;
		
       if($resArr=mysqli_query($GLOBALS['db_connect'],$sql)){
	       $i=0;
	       while($row= mysqli_fetch_array($resArr)){
			 $dataArr[$i]['poster_title'] = $row['poster_title'];
			 if($row['fk_auction_type_id']=='1'){
			   $dataArr[$i]['auction_type'] = "Fixed";
			 }elseif($row['fk_auction_type_id']=='2'){
			   $dataArr[$i]['auction_type'] = "Weekly";
			 }elseif($row['fk_auction_type_id']=='3'){
			   $dataArr[$i]['auction_type'] = "Monthly";
			 }
			$i++;			 
		   }
		   
        }
		echo json_encode($dataArr);			   
	}
  function stills_auction() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF."?mode=fixed&search=".$_REQUEST['search']);
	}else{
		$auctionObj = new Auction();
		$auctionObj->orderType = 'DESC';
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
	if($_REQUEST['search']!='sold'){
			$total = $auctionObj->countStillsAuctionByStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$total = $auctionObj->soldAuctionCOUNTSTILLSAuction($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
	if($total > 0 ){
	if($_REQUEST['search']!='sold'){
			$auctionRows = $auctionObj->fetchStillsAuctionByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}else{
			$auctionObj->orderBy='invoice_generated_on';
			$auctionRows=$auctionObj->soldAuctionSTILLSAuction($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		}
		$total_now=count($auctionRows);
    	for($i=0;$i<$total_now;$i++)
    	{
			if ($auctionRows[$i]['is_cloud']!='1'){
				list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
				$auctionRows[$i]['img_width']=$width;
				$auctionRows[$i]['img_height']=$height;
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_image'];
			}else{
                //list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRows[$i]['img_width']=800;
                $auctionRows[$i]['img_height']=600;
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_image'];
            }
    	}		
		
    			$smarty->assign('auctionRows', $auctionRows);			
				$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
				$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    	
     }
	
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	$smarty->display('admin_stills_auction_manager.tpl');
}
	function create_stills_auction(){
	if(!$_POST)
	{
		if(isset($_SESSION['img']))
		{
		  unset($_SESSION['img']);
		}
	}
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategoryStills(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	$auctionWeekObj = new AuctionWeek();
    $aucetionWeeks = $auctionWeekObj->fetchActiveWeeksForStills();
    $smarty->assign('aucetionWeeks', $aucetionWeeks);

	foreach ($_POST as $key => $value) {
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	$_SESSION['random']=$random;
	
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	
	$obj->orderBy = FIRSTNAME;
	$obj->orderType = ASC;
	//$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1),true);
	
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname'), array('status' => 1), true);
	$smarty->assign("userRow", $userRow);
	
	$smarty->assign("event_id", $_REQUEST['event_id']);
	ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $PosterDesc;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_create_stills_auction.tpl');
	
	}
	
	function save_new_stills_auction(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
    extract($_REQUEST);
    $obj = new Poster();
	$user_name=$_POST['user_id'];
	$objUser = new User();
	$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
	$user_new_id=$arrUser[0]['user_id'];
    $data = array('fk_user_id' => $user_new_id,
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => date("Y-m-d H:i:s"),
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);
    $poster_id = $obj->updateData(TBL_POSTER, $data);
    
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
		if($poster_images!= "")
		{
    $posterArr = explode(',', trim($poster_images, ','));
    ##### NEW FUNCTION FOR POSTER UPLOAD starts #####
	$base_temp_dir="../poster_photo/temp/$random"; 
	$src_temp="../poster_photo/temp/$random/";
	$dest_poster_photo="../poster_photo/";
	$destThumb = "../poster_photo/thumbnail";
	$destThumb_buy = "../poster_photo/thumb_buy";
	$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
	$destThumb_big_slider = "../poster_photo/thumb_big_slider";
	dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider);
	
	
    if (is_dir($base_temp_dir)) {
    	rmdir($base_temp_dir);
		}
	##### NEW FUNCTION FOR POSTER UPLOAD ends #####
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
	
    $row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $week_id));
    $start_date = $row[0]['auction_week_start_date'];
    $end_date = $row[0]['auction_week_end_date'];
    
    $data = array("fk_auction_type_id" => 5,
                  "fk_poster_id" => $poster_id,
				  "fk_auction_week_id" => $week_id,
                  "auction_asked_price" => 10,
				  "auction_start_date" => $start_date,
                  "auction_end_date" => $end_date,
                  "auction_actual_start_datetime" => $start_date,
                  "auction_actual_end_datetime" => $end_date,                 
                  "auction_is_approved" => 1,
                  "auction_is_sold" => 0,
                  "auction_note" => add_slashes($auction_note),
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => date("Y-m-d H:i:s"),
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"],
                  "imdb_link"=>$imdb_link);
                  
    $auction_id=$obj->updateData(TBL_AUCTION, $data);
	$objWantlist=new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
    if($auction_id > 0){     
        $_SESSION['adminErr']="Stills/Photos added successfully.";
       //header("location: ".PHP_SELF."?mode=stills");
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
        exit();
    }else{
        $_SESSION['adminErr']="Could not add Stills/Photos.Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
        //header("location: ".PHP_SELF."?mode=manualupload");
        exit();
    }
}
 function validateNewStillsAuctionForm(){

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
		$GLOBALS['poster_title_err'] = "Please enter Stills/Photos Title.";
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
		$GLOBALS['dacade_err'] = "Please select Decade.";
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
		$GLOBALS['poster_desc_err'] = "Please enter Stills/Photos Description.";
		$errCounter++;	
	}
	if($_POST['is_default'] == ""){
		$GLOBALS['is_default_err'] = "Please select one image as default.";
		$errCounter++;	
	}

	
	if($_POST['poster_images'] == "" && !isset($_SESSION['img']) ){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;  
    }else{
	$posterimages=$_POST['poster_images'];
	$imgstr='';
	if(isset($_SESSION['img']))
	{
	foreach($_SESSION['img'] as $v)
	{
	if($v!="")
	{
	$imgstr.=$v.",";
	}
	}
	//$imgstr=implode(",",$_SESSION['img']);
	
	
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
function edit_stills_auction() {
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
	
	$smarty->assign ("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategoryStills(TBL_CATEGORY, array('*'),true,true);
	$smarty->assign('catRows', $catRows);
	
	$auctionWeekObj = new AuctionWeek();
    $aucetionWeeks = $auctionWeekObj->fetchActiveWeeks();
    $smarty->assign('aucetionWeeks', $aucetionWeeks);

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
		
		if($value != "")
		{
		$value=$value.$imgstr;
		}
		else
		{
		$value=$imgstr;
		}
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	 $_SESSION['random']=$random;
	
	///////////added by sourav banerjee//////////
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->fetchEditAuctionDetail($_REQUEST['auction_id']);

	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
            $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
        }else{
            $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
        }
    }
	for($i=0;$i<count($posterImageRows);$i++){
		$existingImages .= $posterImageRows[$i]['poster_image'].",";
	}
	$existing_images_arr = explode(',',trim($existingImages, ','));
	
	$posterCategoryRows =  $auctionObj->selectData(TBL_POSTER_TO_CATEGORY, array('fk_cat_id'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));


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
	//echo "<pre>";print_r($auctionRow);exit;
	$smarty->assign("auctionRow", $auctionRow);
	//$smarty->assign("posterRow", $posterRow);
	$smarty->assign("posterCategoryRows", $posterCategoryRows);
	$smarty->assign("posterImageRows", $posterImageRows);
	$smarty->assign("existingImages", $existingImages);
	$smarty->assign("browse_count", (count($poster_images_arr) + count($posterImageRows)));
	//$smarty->assign("bid_count", $bidCount);
ob_start();
	$oFCKeditor = new FCKeditor('poster_desc') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->Value = $auctionRow[0]['poster_desc'] ;
	$oFCKeditor->Width  = '430';
	$oFCKeditor->Height = '300';
	$oFCKeditor->ToolbarSet = 'AdminToolBar';	
	$oFCKeditor->Create() ;
	$poster_desc = ob_get_contents();
	ob_end_clean();
	$smarty->assign('poster_desc', $poster_desc);
	$smarty->display('admin_edit_stills_auction_manager.tpl');
	}
	function update_stills_auction()
{
	extract($_REQUEST);
	$obj = new Auction();
	$auctionData = array("imdb_link"=>$imdb_link);	
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);	
	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), 'flat_rolled' => $flat_rolled);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $genre));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $dacade));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $country));
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $condition));

	//////////////Added By Sourav banerjee////////////////////
		
	
	if(isset($poster_images) || isset($_SESSION['img'])){
	
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
		if($poster_images!= "")
		{
         $posterArr = explode(',', trim($poster_images, ','));
	
		//////////////Added By Sourav banerjee////////////////////
		##### NEW FUNCTION FOR POSTER UPLOAD starts #####
		$base_temp_dir="../poster_photo/temp/$random";
		$src_temp="../poster_photo/temp/$random/";
		$dest_poster_photo="../poster_photo/";
		$destThumb = "../poster_photo/thumbnail";
		$destThumb_buy = "../poster_photo/thumb_buy";
		$destThumb_buy_gallery = "../poster_photo/thumb_buy_gallery";
		$destThumb_big_slider = "../poster_photo/thumb_big_slider";
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

	
	$_SESSION['adminErr'] = "Stills/Photos has been updated successfully.";
	header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
	exit;
	
}
function validateEditStillsAuctionForm(){

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
		$GLOBALS['genre_err'] = "Please select Genre.";
		$errCounter++;	
	}
	if($_POST['dacade'] == ""){
		$GLOBALS['dacade_err'] = "Please select Decade.";
		$errCounter++;	
	}
	if($_POST['country'] == ""){
		$GLOBALS['country_err'] = "Please select Country.";
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
		$GLOBALS['is_default_err'] = "Please select atleast one image as default.";
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

function view_stills() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Stills/Photos Auction Manager");
	
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
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

	$random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
	$smarty->assign("random", $random);
	
	$auctionObj = new Auction();
	$auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

	$posterRow =  $auctionObj->selectData(TBL_POSTER, array('*'), array("poster_id" => $auctionRow[0]['fk_poster_id']));
	$posterRow[0]['poster_desc']=strip_slashes($posterRow[0]['poster_desc']);
	$posterRow[0]['poster_title']=strip_slashes($posterRow[0]['poster_title']);
	$posterImageRows =  $auctionObj->selectData(TBL_POSTER_IMAGES, array('*'), array("fk_poster_id" => $auctionRow[0]['fk_poster_id']));
    for($i=0;$i<count($posterImageRows);$i++){
        if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
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
	$smarty->display('admin_view_still_auction_manager.tpl');
}
function reopen_stills(){

     require_once INCLUDE_PATH."lib/adminCommon.php";
     define ("PAGE_HEADER_TEXT", "Admin Stills/Photo Auction Manager");

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

     $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['adminLoginID'] : $_POST['random'];
     $smarty->assign("random", $random);

     $auctionObj = new Auction();
     $auctionRow = $auctionObj->selectData(TBL_AUCTION, array('*'), array("auction_id" => $_REQUEST['auction_id']));

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
         if (file_exists("../poster_photo/" . $posterImageRows[$i]['poster_thumb'])){
             $posterImageRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$posterImageRows[$i]['poster_thumb'];
         }else{
             $posterImageRows[$i]['image_path']=CLOUD_POSTER_THUMB.$posterImageRows[$i]['poster_thumb'];
         }
     }
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

     $auctionWeekObj = new AuctionWeek();
     $aucetionWeeks = $auctionWeekObj->fetchActiveWeeksForStills();
     $smarty->assign('aucetionWeeks', $aucetionWeeks);

     ob_start();
     $oFCKeditor = new FCKeditor('poster_desc') ;
     $oFCKeditor->BasePath = '../FCKeditor/';
     /*$oFCKeditor->ToolbarSet = 'Basic';*/
     $oFCKeditor->Value = $posterRow[0]['poster_desc'];
     $oFCKeditor->Width  = '430';
     $oFCKeditor->Height = '300';
     $oFCKeditor->ToolbarSet = 'AdminToolBar';
     $oFCKeditor->Create() ;
     $poster_desc = ob_get_contents();
     ob_end_clean();
     $smarty->assign('poster_desc', $poster_desc);
     $smarty->display('admin_reopen_stills_auction_manager.tpl');
 }
 function reopen_stills_auction(){
     extract($_REQUEST);

     if(isset($choose_fixed_weekly) && $choose_fixed_weekly!=''){

         $obj = new Auction();         
		 if(isset($auction_week) && $auction_week!=''){
			 $row = $obj->selectData(TBL_AUCTION, array('fk_poster_id'), array("auction_id" => $auction_id));
			 $poster_id = $row[0]['fk_poster_id'];

			 $row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
			 $start_date = $row[0]['auction_week_start_date'];
			 $end_date = $row[0]['auction_week_end_date'];

			 $auctionData = array("fk_auction_type_id"=>'5',"fk_auction_week_id" => $auction_week,"fk_poster_id"=>$poster_id,"auction_is_approved"=>'1', "auction_asked_price" => $weekly_asked_price, "auction_reserve_offer_price"=>'',
				 "auction_start_date" => $start_date, "auction_end_date" => $end_date,
				 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
			 $obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), false);
			 $obj->deleteData(TBL_BID, array('bid_fk_auction_id' => $auction_id));
			 $obj->deleteData(TBL_AUCTION, array('auction_id' => $auction_id));
			 $_SESSION['adminErr'] = "Stills/Photo has been re-listed successfully.";
			 header("location: ".$decode_string);
		 }else{
			 $_SESSION['adminErr'] = "Please provide auction week to relist.";
			 header("location: ".PHP_SELF."?mode=reopen_stills&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
		 }
         

     }else{
         $_SESSION['adminErr'] = "Please select a relist type for this poster.";
         header("location: ".PHP_SELF."?mode=reopen_stills&auction_id=".$auction_id."&encoded_string=".$_REQUEST['encoded_string']);
     }
 }
 function set_as_big_slider(){
 	$obj = new Auction();
	$auction_id = $_REQUEST['auction_id'];
	$auctionData = array("is_set_for_home_big_slider"=>'1') ;
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
	echo "1";
 }
 
 function remove_as_big_slider(){
 	$obj = new Auction();
	$auction_id = $_REQUEST['auction_id'];
	$auctionData = array("is_set_for_home_big_slider"=>'0') ;
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
	echo "2";
	 	
 }
 function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
?>
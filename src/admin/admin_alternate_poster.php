<?php

/**************************************************/
ob_start();

define ("PAGE_HEADER_TEXT", "Admin Manager Alternative Poster Section");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}


if($_REQUEST['mode'] == "create_alternate_posters"){
	create_alternate_posters();
}elseif($_REQUEST['mode'] == "save_alternative_poster"){
	$chk = validateNewFixedForm();
	if(!$chk){
		create_fixed();
	}else{
		save_new_fixed_auction();
	}
}elseif($_REQUEST['mode']=="edit_alternative"){
	edit_alternative();
}elseif($_REQUEST['mode']=="view_details_sell_status"){
	view_details_sell_status();
}elseif($_REQUEST['mode']=="update_alternative"){
	$chk = validateFixedForm();
	if($chk == true){
		update_alternative();
	}else{
		edit_alternative();
	}
}elseif($_REQUEST['mode']=="manage_invoice_alternative"){
	manage_invoice_alternative();
}
else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/



/////      Start of Middle function  //////
function dispmiddle() {

	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	/*if(isset($_REQUEST['search']) && $_REQUEST['search']!=''){
		if($_REQUEST['search']=='all'){
			$_REQUEST['search']='';
		}*/
	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
		$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
		header("location: ".PHP_SELF);
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
	
	
	$total = $auctionObj->countAlternativePosterStatus($_REQUEST['search'],'',$_REQUEST['search_fixed_poster'],$start_date,$end_date);
		
	if($total > 0 ){
	if($_REQUEST['search']!='sold'){
			$auctionRows = $auctionObj->fetchAlternativeByStatus($_REQUEST['search'],'',$_REQUEST['sort_type'],$_REQUEST['search_fixed_poster'],$start_date,$end_date);
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
				
				$smarty->assign('total', $total);
    			$smarty->assign('auctionRows', $auctionRows);			
				$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
				$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    	
     }
	/*if($_REQUEST['search']==''){
			$_REQUEST['search']='all';
		}
	$smarty->assign('total', $total);
	$smarty->assign('search', $_REQUEST['search']);
	$smarty->assign('sort_type', $_REQUEST['sort_type']);
	
	*/
	/*}else{
		$smarty->assign('total', 0);
		$smarty->assign('search', $_REQUEST['search']);
	}*/
	if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!='')
	 {
		$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
		$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
	  }
	}
	$smarty->assign('search_fixed_poster', $_REQUEST['search_fixed_poster']);
	$smarty->display('admin_alternative_poster_manager.tpl');
}

function create_alternate_posters(){

if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Alternate Poster Manager");
	
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
	$smarty->display('admin_create_alternate_poster.tpl');
	
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
		$GLOBALS['poster_title_err'] = "Please enter Title.";
		$errCounter++;	
	}

	if($_POST['poster_size'] == ""){
		$GLOBALS['poster_size_err'] = "Please select a Size.";
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
                  'post_ip' => $_SERVER["REMOTE_ADDR"],
				  'artist' => $artist,
				  'quantity' => $quantity,
				  'field_1' => $field_1,
				  'field_2' => $field_2,
				  'field_3' => $field_3
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
	
    
    
    $is_percentage = ($is_percentage == '')? '0' : '1';
    $is_considered = ($is_consider == '')? '0' : '1';
    if($is_considered ==0){
		$offer_price = 0;
	}
    $data = array("fk_auction_type_id" => 6,
                  "fk_poster_id" => $poster_id,
                  "auction_asked_price" => $asked_price,
                  "auction_is_approved" => 1,
                  "auction_is_sold" => 0,
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => date("Y-m-d H:i:s"),
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"]
				  );
                  
    $auction_id=$obj->updateData(TBL_AUCTION, $data);
	$objWantlist=new Wantlist();
	$objWantlist->countNewAuctionWithWantlist($auction_id);	
    if($auction_id > 0){     
        $_SESSION['adminErr']="Poster added successfully.";
       //header("location: ".PHP_SELF."?mode=fixed");
		header("location: admin_alternate_poster.php?mode=alternate_posters");
        exit();
    }else{
        $_SESSION['adminErr']="Could not add poster.Please try again.";
		header("location: admin_alternate_poster.php?mode=alternate_posters");
        //header("location: ".PHP_SELF."?mode=manualupload");
        exit();
    }
}
	function edit_alternative(){
		
		if(!$_POST)
		{
			if(isset($_SESSION['img']))
			{
			  unset($_SESSION['img']);
			}
		}
		require_once INCLUDE_PATH."lib/adminCommon.php";
	
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
		$posterRow[0]['artist'] = strip_slashes($posterRow[0]['artist']);
		$posterRow[0]['quantity'] = strip_slashes($posterRow[0]['quantity']);
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
		$smarty->display('admin_edit_alternative_poster_manager.tpl');
	
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

	function update_alternative()
	{
	extract($_REQUEST);
	$obj = new Auction();
	$is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered ==0){
		$offer_price = 0;
	}
	$auctionData = array("auction_asked_price" => $asked_price);
	$auctionWhere = array("auction_id" => $auction_id);
	$obj->updateData(TBL_AUCTION, $auctionData, $auctionWhere, true);	

	$posterData = array('poster_title' => add_slashes($poster_title), 'poster_desc' => add_slashes($poster_desc), 'flat_rolled' => $flat_rolled,
						'quantity'=>$quantity,'artist'=>$artist,'field_1' => $field_1,'field_2' => $field_2,'field_3' => $field_3);
	$posterWhere = array("poster_id" => $poster_id);
	$obj->updateData(TBL_POSTER, $posterData, $posterWhere, true);
	
	$obj->deleteData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id));	
	$obj->updateData(TBL_POSTER_TO_CATEGORY, array("fk_poster_id" => $poster_id, "fk_cat_id" => $poster_size));
	

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
		$_SESSION['adminErr'] = "Alternative Poster has been updated successfully.";
		header("location: admin_alternate_poster.php?mode=alternate_posters");
		exit;
	/*}else{
		$_SESSION['adminErr'] = "No category has not been created successfully.";
		header("location: ".PHP_SELF."?cat_type_id=".$fk_cat_type_id);
		//exit;
	}*/
}
 function view_details_sell_status(){
	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	extract($_REQUEST);
	define ("PAGE_HEADER_TEXT", "Admin Alternative Item Sold Details");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$obj = new Auction();
	$auctionArr=$obj->select_details_auction($auction_id);
    if (file_exists("../poster_photo/" . $auctionArr[0]['poster_thumb'])){
        $auctionArr[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionArr[0]['poster_thumb'];
    }else{
        $auctionArr[0]['image_path']=CLOUD_POSTER_THUMB.$auctionArr[0]['poster_thumb'];
    }
	
	$sql ="Select i.invoice_id,i.total_amount,u.firstname,u.lastname ,i.invoice_generated_on
				FROM  tbl_invoice i, tbl_invoice_to_auction tia,user_table u
						WHERE tia.fk_auction_id = '".$auction_id."'  
							  AND tia.fk_invoice_id = i.invoice_id 
							  AND u.user_id = i.fk_user_id
							  AND i.is_buyers_copy ='1' ";
							  
	if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
	}
	$smarty->assign("dataArr", $dataArr);
	$smarty->assign("auctionArr", $auctionArr);
	$smarty->assign("total", $countBid);
	$smarty->display('admin_view_alternative_auction_details.tpl');
}
 function manage_invoice_alternative(){
 	
	require_once INCLUDE_PATH."lib/adminCommon.php";
	define ("PAGE_HEADER_TEXT", "Admin Invoice Manager");
	$smarty->assign ("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	$invoiceObj = new Invoice();
	$invoiceData = $invoiceObj->fetchInvoiceAuctionDetailsAlternative($_REQUEST['invoice_id']);
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
	//echo "<pre>".print_r($invoiceData)."</pre>";
	
	$smarty->display('admin_manage_invoice.tpl');

 }
	
?>
<?php
ob_start(); 
//error_reporting(E_ALL ^ E_NOTICE);
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
if(!isset($_SESSION['sessUserID'])){
    header("Location:index.php");
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
}elseif($_REQUEST['mode'] == "fixed_selling"){
    myAyctions();
}elseif($_REQUEST['mode'] == "pending"){
    myAyctions();
}elseif($_REQUEST['mode'] == "unsold"){
    myAyctions();
}elseif($_REQUEST['mode'] == "sold"){
    myAyctions();
}elseif($_REQUEST['mode'] == "upcoming"){
    myAyctions();
}elseif($_REQUEST['mode'] == "unpaid"){
    myAyctions();
}elseif($_REQUEST['mode'] == "fixed"){
    fixed();
}elseif($_REQUEST['mode'] == "weekly"){
    weekly();
}elseif($_REQUEST['mode'] == "monthly"){
    monthly();
}elseif($_REQUEST['mode'] == "download"){
    download();
}elseif($_REQUEST['mode'] == "auction_images_large"){
    auction_images_large();
}elseif($_REQUEST['mode'] == "images_next"){
    images_next();
}elseif($_REQUEST['mode'] == "move_to_weekly"){
    move_to_weekly();
}elseif($_REQUEST['mode'] == "move_fixed"){
    move_fixed();
}elseif($_REQUEST['mode'] == "weekly_relist"){
    weekly_relist();
}elseif($_REQUEST['mode'] == "relist_weekly_to_weekly"){
    relist_weekly_to_weekly();
}elseif($_REQUEST['mode'] == "faq"){
    faq();
}elseif($_REQUEST['mode'] == "relist_weekly_to_fixed"){
    relist_weekly_to_fixed();
}elseif($_REQUEST['mode'] == "save_bulk_to_admin"){
    save_bulk_to_admin();
}elseif($_REQUEST['mode'] == "stills"){
    stills();
}elseif($_REQUEST['mode'] == "stills_upload"){
    $chk = validateStillsForm();
    if($chk == true){
        save_stills_auction();
    }else{
        stills();
    }
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
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
    require_once INCLUDE_PATH."lib/common.php";
    $obj = new Category();
    $catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
    $smarty->assign('catRows', $catRows);
    
        foreach ($_POST as $key => $value ) {
        
        $smarty->assign($key, $value); 
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
        
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

   
    $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
    $smarty->assign("random", $random);
    $_SESSION['random']=$random;
 

    $smarty->display("fixed.tpl");
	}

function monthly()
{ 
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}   
     
    require_once INCLUDE_PATH."lib/common.php";

    $obj = new Category();
    $catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
    $smarty->assign('catRows', $catRows );
    //$where=array("event_start_date" <= date('Y-m-d'),"event_end_date" > date('Y-m-d'));

    $eventSql = "SELECT * FROM ".TBL_EVENT." WHERE event_end_date > now()";   
	if($rs = mysqli_query($GLOBALS['db_connect'],$eventSql)){
		while($row = mysqli_fetch_assoc($rs)){
		   $eventRows[] = $row;
		}
	}

    $smarty->assign('eventRows', $eventRows);

   foreach ($_POST as $key => $value ) {
        $smarty->assign($key, $value); 
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
        
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

   
    $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
    $smarty->assign("random", $random);
    $_SESSION['random']=$random;
    
    $smarty->display("monthly.tpl");
}

function weekly()
{
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
    require_once INCLUDE_PATH."lib/common.php";

    $obj = new Category();
    $catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
    $smarty->assign('catRows', $catRows);

	$auctionWeekObj = new AuctionWeek();
    $aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeks();
    $smarty->assign('aucetionWeeks', $aucetionWeeks);

    foreach ($_POST as $key => $value ) {
    	if($key=='poster_desc')
    	{
    	$value=strip_slashes($value);
    	}
    	
        $smarty->assign($key, $value); 
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');

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

   
    $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
    $smarty->assign("random", $random);
    $_SESSION['random']=$random;
    
    $smarty->display("weekly.tpl");
	}

function validateFixedForm()
{
    $errCounter = 0;
	$random = $_REQUEST['random'];
	
    if($_POST['poster_title'] == ""){
        $GLOBALS['poster_title_err'] = "Please enter Poster Title.";
        $errCounter++;  
    }
    if($_POST['poster_size'] == ""){
        $GLOBALS['poster_size_err'] = "Please select Size.";
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
    if($_POST['asked_price'] == ""){
        $GLOBALS['asked_price_err'] = "Please enter Asked Price.";
        $errCounter++;
        $asked_price_err = 1;
        
    }if($_POST['asked_price'] == '0'){
        $GLOBALS['asked_price_err'] = "Please enter valid Asked Price.";
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
    
    if($_POST['poster_images'] == "" && !isset($_SESSION['img'])){
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
		if($posterimages!="")
	 {
		$posterArr = explode(',', trim($posterimages, ','));
		foreach($posterArr as $key => $value){
			$size = getimagesize("poster_photo/temp/$random/".$value);
			if(!$size){
				$GLOBALS['poster_images_err'] = "Please provide proper images only.";
				$errCounter++;
			}
		}
	 }
	}
	echo $posterimages;
    var_dump($GLOBALS);
    if($errCounter > 0){
        return false;
    }else{
        return true;
    }
	}

function validateMonthlyForm()
{
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
	if($_POST['is_default'] == ""){
        $GLOBALS['is_default_err'] = "Please Select a default Image.";
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
    
    if($_POST['poster_images'] == "" && !isset($_SESSION['img'])){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;  
    }else{
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
		if($posterimages!="")
	 {
	 $posterimages = str_replace(",," , "," ,$posterimages);
		$posterArr = explode(',', trim($posterimages, ','));
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

function validateWeeklyForm()
{
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
	if($_POST['is_default'] == ""){
        $GLOBALS['is_default_err'] = "Please Select a default Image.";
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
    
    if($_POST['buynow_price'] != "" && check_int($_POST['buynow_price'])==0){
        $GLOBALS['buynow_price_err'] = "Please enter integer values only.";
        $errCounter++;
    }elseif($_POST['buynow_price'] != "" && $_POST['buynow_price'] != 0 && $asked_price_err == ''){
        if($_POST['buynow_price'] <= $_POST['asked_price']){
            $GLOBALS['buynow_price_err'] = "Buynow price must be greater than starting price.";
            $errCounter++;
        }
    }
    
    if($_POST['poster_images'] == "" && !isset($_SESSION['img'])){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;  
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;  
    }else{
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
		if($posterimages!="")
	 {
	 $posterimages = str_replace(",," , "," ,$posterimages);
		$posterArr = explode(',', trim($posterimages, ','));
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

function save_fixed_auction()
{
    extract($_POST);
    $obj = new Poster();

    $data = array('fk_user_id' => $_SESSION['sessUserID'],
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
		if($poster_images !="")
		{
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
		}
	##### NEW FUNCTION FOR POSTER UPLOAD ends #####

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
    
    $is_percentage = ($is_percentage == '')? '0' : '1';
    $is_considered = ($is_consider == '')? '0' : '1'; 
    if($is_considered=='0'){
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
                  "up_date" => "0000-00-00 00:00:00",
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"]
    			  );

    $obj->updateData(TBL_AUCTION, $data);
	exit();
	$sqlForEmail = "SELECT u.email,u.firstname,u.lastname FROM ".USER_TABLE." u WHERE u.user_id =" . $_SESSION['sessUserID'];
	$rsForEmail = mysqli_query($GLOBALS['db_connect'],$sqlForEmail);
	$emailArr = mysqli_fetch_array($rsForEmail);
	$email = $emailArr['email'];
	
	############ After Listing Email Alert Seller ############
	
	$toMail = $email;
	$toName = $emailArr['firstname'].' '.$emailArr['lastname'];
	$fromMail = ADMIN_EMAIL_ADDRESS;
	$fromName = ADMIN_NAME;

	$subject = "MPE::Your item has been successfully listed ";

	$textContent = 'Dear '.$emailArr['firstname'].' '.$emailArr['lastname'].',<br /><br />';
				//$textContent .= '<b>Poster Title : </b>'.$invoice['poster_title'].'<br />';
	$textContent .= 'Poster Title :'.$poster_title.'<br />';
	$textContent .= 'Congratulations! Your item has been successfully listed.<br />';
	$textContent .= 'You may view this item and any other items listed by logging in to your account <a href="http://'.HOST_NAME.'/">HERE</a> and placing your mouse over the Welcome, located in top red banner and selecting my selling/selling.<br /><br />';
				
	$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
	$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
	$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

    if($poster_id > 0){     
        $_SESSION['Err']="Poster added successfully.";
        header("location: ".PHP_SELF."?mode=selling");
        exit();
    }else{
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
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => "0000-00-00",
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);

    $poster_id = $obj->updateData(TBL_POSTER, $data);
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
		if($poster_images!="")
		{
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


//	if($_POST['auction_start_am_pm'] == 'am'){
//		$start_time = $_POST['auction_start_hour'].":".$_POST['auction_start_min'];
//	}else{
//		$start_time = ($_POST['auction_start_hour'] + 12).":".$_POST['auction_start_min'];
//	}
//
//	if($_POST['auction_end_am_pm'] == 'am'){
//		$end_time = $_POST['auction_end_hour'].":".$_POST['auction_end_min'];
//	}else{
//		$end_time = ($_POST['auction_end_hour'] + 12).":".$_POST['auction_end_min'];
//	}

    $start_date = $row[0]['event_start_date'];
    $end_date = $row[0]['event_end_date'];
    
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
    }else{
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
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => "0000-00-00",
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);
    
    $poster_id = $obj->updateData(TBL_POSTER, $data);
   /////Added By Sourav//////// 
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
	
	/////Added By Sourav////////
	if($poster_images!='')
	{
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

    $start_date = $row[0]['auction_week_start_date'];
    $end_date = $row[0]['auction_week_end_date'];
        
    $data = array("fk_auction_type_id" => 2,
                  "fk_poster_id" => $poster_id,
				  "fk_auction_week_id" => $auction_week,
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
    //echo "<pre>";print_r($data);exit;
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
	$objAuction->orderType = 'DESC';
	if(isset($_REQUEST['search_sold']) && $_REQUEST['search_sold']!=''){
	  $title= $_REQUEST['search_sold'];	
	}else{
	  $title='';	
	}
	if($status!='sold'){
    	$total = $objAuction->countAuctionsByStatus($_SESSION['sessUserID'], $status,'',$title,1);
    	$auctionRow = $objAuction->fetchAuctionsByStatus($_SESSION['sessUserID'], $status,$_REQUEST['sort_by'],'',$title,1);
	}else{
		################ Closed for loading Issue #################
		/*$objAuction->orderBy='invoice_generated_on';
		$total=$objAuction->countJstFinishedAuction($title,$_SESSION['sessUserID']);
		$auctionRow=$objAuction->soldAuction(true,true,$title,$_SESSION['sessUserID'],'',$status,$_REQUEST['sort_by']);
		$objAuction->fetchWinnerAndSoldPrice($auctionRow);*/
		################ Closed for loading Issue #################
		
		$objAuction->orderBy='invoice_generated_on';
		$total=$objAuction->countSoldItemAuction($title,$_SESSION['sessUserID']);
		$auctionRow=$objAuction->OrderBySoldPriceSeller($_REQUEST['sort_by'],'DESC',$title,'','',$_SESSION['sessUserID']);
		
	}
	
    //$posterObj = new Poster();
    //$posterObj->fetchPosterCategories($auctionRow);
    //$posterObj->fetchPosterImages($auctionRow);

	$total_now=count($auctionRow);
    for($i=0;$i<$total_now;$i++)
    {
      
		
		if ($auctionRow[$i]['is_cloud'] !='1'){
                list($width, $height, $type, $attr) = getimagesize("poster_photo/".$auctionRow[$i]['poster_thumb']);
                $auctionRow[$i]['img_width']=$width;
                $auctionRow[$i]['img_height']=$height;
                $auctionRow[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                //list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$auctionRows[$i]['poster_image']);
                $auctionRow[$i]['img_width']=800;
                $auctionRow[$i]['img_height']=800;
                $auctionRow[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRow[$i]['poster_thumb'];
            }
        if($auctionRow[$i]['fk_auction_type_id']==1){
            $offerObj=new Offer();
            $offerObj->fetch_OfferCount_MaxOffer($auctionRow);
			$offerObj->fetchTotalOffers($auctionRow);
        }elseif($auctionRow[$i]['fk_auction_type_id']==2 || $auctionRow[$i]['fk_auction_type_id']==3){
            $objBid = new Bid();
            $objBid->fetch_BidCount_MaxBid($auctionRow);
			$objBid->fetchBidsByIdNew($auctionRow);
        }
    }
	
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $smarty->assign('status', $status);
	$smarty->assign('sort_by', $_REQUEST['sort_by']);
    $smarty->assign('total', $total);
	
    $smarty->assign('auction', $auctionRow);
    $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=25, $end=100, $step=25, $use=1));
    $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	if(!isset($_REQUEST['offset'])){
		$offset=0;
	}else{
		$offset=$_REQUEST['offset'];
	}
	if(!isset($_REQUEST['toshow'])){
		$toshow=$total;
	}else{
		$toshow=$_REQUEST['toshow'];
	}
	if(isset($_REQUEST['toshow'])){
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
	}
    $smarty->display('myauctions.tpl');
}

/*********** Bulkuplod Starts ***********/

function bulkupload()
{
    require_once INCLUDE_PATH."lib/common.php";
    
    if(isset($_REQUEST['cnt_err']) && $_REQUEST['cnt_err']>0){
    	$err= $_REQUEST['cnt_err'];
    }else{
    	$err=0;
    }
	if(isset($_SESSION['err_cntr']) && $_SESSION['err_cntr']>0 && !isset($_REQUEST['cnt_err'])){
    	$err= $err + $_SESSION['err_cntr'];
    }
    
    foreach ($_FILES as $key => $value ) {
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
    }
    $err =$err + count($_FILES);
    $_SESSION['err_cntr']=$err;
    $smarty->assign('err', $_SESSION['err_cntr']);
    $smarty->display("bulkupload.tpl");

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
        $GLOBALS['bulkupload_err']="Please select a zip file less than 30 MB.";
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
		$path = "bulkupload/".session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'];
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
		$_SESSION['Err'] = "CSV file not found. Check your folder structure.";
		if (isset($_SESSION['err_cntr']) && $_SESSION['err_cntr']!=''){
			$_SESSION['err_cntr']=$_SESSION['err_cntr'] + 1;
		}else{
			$_SESSION['err_cntr']=1;
		}
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();
	}else{
		parseCSVFile($path."/auction/",$path,$fileName);
	}
	
	// Read CSV / XLS File Ends
	
	return false;
}

function parseCSVFile($pathOfCsvFile,$path,$fileName) {
	require_once INCLUDE_PATH."lib/common.php";
	$error_ind=0;
    $genericErrorMessage = '';
    $insertRecordMeg ='';
	$successCounter = 0;
    
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
		$_SESSION['Err'] = "Cannot open CSV file. Please try again.";
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();
	}
    $newData = array();
//    echo "<pre>";
//    print_r($data2DArray);
//    echo "</pre>";
    $totalItemInArray = count($data2DArray); //excluding the headers
    $countInnerArray = count($data2DArray[0]);


	
    for($c=1; $c<$totalItemInArray; $c++)
    {
		$errCounter = 0;
		
		$conditionId = '';
		$sizeId = '';
		$genreId = '';
		$decadeId = '';
		$countryId = '';
		$posistion = strpos(trim($data2DArray[$c][10]), '%');
			
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
		
		elseif(isEmpty($data2DArray[$c][2])){// Checking for Poster Description
			$errCounter++;			
			$posterLog .= "Poster {$c}: Poster description is empty.<br />";
		}
		//elseif(isEmpty($data2DArray[$c][3]) && $posterImageInd!='1'){// Checking for Poster Images
			//$errCounter++;
			//$posterLog .= "Poster {$c}: Poster images not found.<br />";
		//}
    	elseif($imageFlag == 0){// Checking for Poster Images
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
        	
		}
		
		$error_ind=$error_ind + $errCounter;
    }
    
    if($error_ind == 0){
    	for($c=1; $c<$totalItemInArray; $c++)
    	{
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
    	 	$auctionID = insertRecord($data2DArray[$c], array($conditionId, $sizeId, $genreId, $decadeId, $countryId),$data2DArray[$c][$innerElement] ,$pathOfCsvFile);
    	}		
				if($auctionID > 0){
					$successCounter++;
					$posterLog .= "Poster(s) uploaded successfully.<br />";
				}else{
					$posterLog .= "Poster {$c}: Poster uploaded failed.<br />";
				}
				
         
			delete_directory($path."/");
			$_SESSION['Err'] = $posterLog;
			header("location: ".PHP_SELF."?mode=pending");
			exit();
	}else{
		if (isset($_SESSION['err_cntr']) && $_SESSION['err_cntr']!=''){
			$_SESSION['err_cntr']=$_SESSION['err_cntr'] + 1;
		}else{
			$_SESSION['err_cntr']=1;
		}
		
		delete_directory($path."/");
		$_SESSION['Err'] = $posterLog;
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();
	}

	//$_SESSION['Err'] = $successCounter." poster has been uploaded.";
	
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

function insertRecord($csvDataArray, $categoryIdArray, $auctionType, $pathOfCsvFile){

	require_once INCLUDE_PATH . "lib/common.php";
	
	$erorr = '';
	$debug = false;	
	$auctionObj = new Auction();
	
    if(isset($_GET) && $_GET['debug'] == 'true')
        $debug = true;
   
    //Poster Insertion
    if (!empty($csvDataArray) && $debug == false) {
		if(trim($csvDataArray[11]) == 'flat' || trim($csvDataArray[11]) == 'Flat' || trim($csvDataArray[11]) == 'FLAT'){
			$flat_rolled = 'flat';
		}else{
			$flat_rolled = 'rolled';
		}
        $posterArray = array(
            'fk_user_id' => $_SESSION['sessUserID'],
            'poster_title' => trim(addslashes($csvDataArray[0])),
            'poster_desc' => trim(addslashes($csvDataArray[2])),
            'poster_sku' => generatePassword(6),
			'flat_rolled' => $flat_rolled,
            'post_date' => date("Y-m-d h:i:s"),
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
				$dest_poster_photo="poster_photo/";
				$destThumb = "poster_photo/thumbnail";
				$destThumb_buy = "poster_photo/thumb_buy";
				$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
				$destThumb_big_slider = "poster_photo/thumb_big_slider";
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
			
			

            $startingPrice = 0;
            $startingPrice = ($csvDataArray[9]!='') ? number_format($csvDataArray[9], 2, '.', '') : '';
            

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
								'auction_is_approved'               => 0,
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

function renameImage($pathOfAuctionDir,$imageArray){
	$src = $pathOfAuctionDir.'poster_photo/';
	$posterRenamedArr =array();
	$returnValue='';
	foreach($imageArray as $img){
		$img = trim($img);
		$imgInfo = pathinfo($src.$img);
		$extension = trim($imgInfo['extension']);
		//$fileName = rand(1000, 9999) . '.' . $extension;
		$fileName = rand(1000, 9999) . '_'. $img;
		$dest = "poster_photo/$fileName";
		$destThumb = "poster_photo/thumbnail";
		$destThumb_buy = "poster_photo/thumb_buy";
		$destThumb_buy_gallery = "poster_photo/thumb_buy_gallery";
		$sourceFile = $src.$img;
		if(is_file($sourceFile)){
//              if (rename($sourceFile, $dest)) {
//                 copy($dest, $destThumb);
//              }
			if (copy($sourceFile, $dest)){
				//copy($dest, $destThumb);
				create_thumbnail($destThumb,$dest,$fileName,100,100);
				create_thumbnail_for_buy($destThumb_buy,$dest,$fileName,150,150);
				create_thumbnail_for_buy_gallery($destThumb_buy_gallery,$dest,$fileName,200,200);
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

function download(){
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
	} elseif ( ! file_exists( $filename ) ){
		echo "<html><title>Title Here</title><body>ERROR: File not found.</body></html>";
		exit;
	};
	switch( $file_extension )
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
	header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($filename));
	readfile("$filename");
	exit();
} 
function  auction_images_large(){
	 require_once INCLUDE_PATH . "lib/common.php";
	 $poster_id=$_REQUEST['id'];
	 $objposter = new Poster();
	 $poster_arr=$objposter->selectData('TBL_POSTER_IMAGES',array('*'),array("fk_poster_id"=>$poster_id));
	 $total_images=count($poster_arr);
	 $smarty->assign('total_images',$total_images);
	 $smarty->assign('poster_arr',$poster_arr);
	 $smarty->assign('poster_id',$poster_id);
	 $smarty->display("auction_images_large.tpl"); 
}
function images_next(){
	require_once INCLUDE_PATH . "lib/common.php";
	$poster_id=$_REQUEST['poster_id'];
	$page_index=$_REQUEST['page_index'];
	$sql_next="Select poster_image from tbl_poster_images where fk_poster_id='".$poster_id."' limit $page_index,1";
	if($rs = mysqli_query($GLOBALS['db_connect'],$sql_next)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $imgArr[] = $row;
			   }
	$smarty->assign('imgArr',$imgArr);
	$smarty->display("auction_images_next.tpl"); 		   
	}
 }
 function move_to_weekly(){
 	require_once INCLUDE_PATH."lib/common.php";
	
	extract($_REQUEST);
	$objAuction = new Auction();
	$auctionDetails=$objAuction->select_details_auction($id);
     if (file_exists("poster_photo/" . $auctionDetails[0]['poster_image'])){
         $auctionDetails[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionDetails[0]['poster_image'];
     }else{
         $auctionDetails[0]['image_path']=CLOUD_POSTER_THUMB.$auctionDetails[0]['poster_image'];
     }
	$auctionDetails[0]['poster_desc']=strip_slashes($auctionDetails[0]['poster_desc']);
	$posterObj = new Poster();
	$posterObj->fetchPosterCategories($auctionDetails);
	$smarty->assign('auctionDetails', $auctionDetails);
	
	$auctionWeekObj = new AuctionWeek();
    $aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeks();
     if(!empty($aucetionWeeks)){
         $smarty->assign('aucetionWeeks', $aucetionWeeks);
     }else{
         $smarty->assign('aucetionWeeks', '');
     }
	$smarty->assign('auction_id', $id);
	$smarty->display("auction_move_to_weekly.tpl"); 
 }
 function move_fixed(){
 	extract($_REQUEST);
 	$obj = new Auction();
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
	$start_date = $row[0]['auction_week_start_date'];
    $end_date = $row[0]['auction_week_end_date'];
	
	$auctionData = array("fk_auction_type_id"=>'2',"fk_auction_week_id" => $auction_week, "auction_asked_price" => $asked_price, "auction_reserve_offer_price"=>'',
						 "auction_start_date" => $start_date, "auction_end_date" => $end_date,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
	$obj->deleteData(TBL_OFFER, array('offer_fk_auction_id' => $auction_id));				 
 }
 function weekly_relist(){
 	
 	require_once INCLUDE_PATH."lib/common.php";
	
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
    $aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeks();
     if(!empty($aucetionWeeks)){
         $smarty->assign('aucetionWeeks', $aucetionWeeks);
     }else{
         $smarty->assign('aucetionWeeks', '');
     }
	$smarty->assign('auction_id', $id);
	$smarty->display("auction_weekly_relist.tpl"); 
 
 }
 function relist_weekly_to_weekly(){
 	extract($_REQUEST);
 	$obj = new Auction();
	$row = $obj->selectData(TBL_AUCTION_WEEK, array('auction_week_start_date', 'auction_week_end_date'), array("auction_week_id" => $auction_week));
	$start_date = $row[0]['auction_week_start_date'];
    $end_date = $row[0]['auction_week_end_date'];
	
	$auctionData = array("fk_auction_week_id" => $auction_week, "auction_asked_price" => $asked_price,"auction_buynow_price" => '', "auction_start_date" => $start_date, "auction_end_date" => $end_date,
						 "auction_actual_start_datetime" => $start_date, "auction_actual_end_datetime" => $end_date);
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
	$obj->deleteData(TBL_BID, array('bid_fk_auction_id' => $auction_id));				 
 }
 function relist_weekly_to_fixed(){
 	
 	extract($_REQUEST);
 	$obj = new Auction();
	$auctionData = array("fk_auction_type_id"=>'1',"fk_auction_week_id" => '', "auction_asked_price" => $asked_price, "auction_buynow_price" => '',"auction_reserve_offer_price"=>$buynow_price,"auction_start_date" => '', "auction_end_date" => '',
						 "auction_actual_start_datetime" => '', "auction_actual_end_datetime" => '');
	$obj->updateData(TBL_AUCTION, $auctionData, array("auction_id" => $auction_id), true);
	$obj->deleteData(TBL_BID, array('bid_fk_auction_id' => $auction_id));
	$obj->deleteData(TBL_OFFER, array('offer_fk_auction_id' => $auction_id));				 
 }
 function faq(){
 	require_once INCLUDE_PATH."lib/common.php";
 	$page = new PageContent();
    $page->pageName = "faq.php";
    $row = $page->pageContentDetails();
    
    $GLOBALS["sslStatus"] = $row[PAGE_SSL_PERMISSION];
    
    if(SSL_URL ==  true && $GLOBALS["sslStatus"] == 1 && $_SERVER['HTTPS'] !="on"){
        header("location: https://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit();
    }
    elseif((SSL_URL == false or $GLOBALS["sslStatus"] == 0) && $_SERVER['HTTPS'] =="on"){
        header("location: http://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit();
    }

    $GLOBALS["pageTitle"] = $row[PAGE_TITLE];
    $GLOBALS["pageHeaderName"] = $row[PAGE_HEADER_NAME];
    
	$smarty->assign('pageContent', $row[PAGE_CONTENT]);
	$smarty->assign('pageHeaderName', $row[PAGE_HEADER_NAME]);
	
	$smarty->display("user_faq.tpl");
 }
 function save_bulk_to_admin(){
 	require_once INCLUDE_PATH."lib/common.php";
 	$fileExt = end(explode('.', $_FILES['bulkupload_admin']['name']));
    $size = $_FILES['bulkupload_admin']['size']/ 1000000;
 	if($fileExt != 'zip') {
        $_SESSION['Err'] = "Invalid file format. Please upload zip file only.";
        header("location: ".PHP_SELF."?mode=bulkupload");
		exit();	
    }elseif($size > 20){
        $_SESSION['Err'] ="Please select a zip file less than 20 MB.";
        header("location: ".PHP_SELF."?mode=bulkupload");
		exit();	
    }
    
    else{
 	$path = "bulk/";
 	$fieldName = "bulkupload_admin";
	$fileName = "auction_".session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'];
	$fileName_insert=$fileName.'.zip';
	$size = $_FILES['bulkupload_admin']['size']/ 1000000;
	if($uploadedFilename = moveUploadedFile($fieldName, $path, $fileName)){
		$sql=mysqli_query($GLOBALS['db_connect'],"Insert into tbl_pending_bulkuploads 
						  (fk_user_id,file_name,file_size,status,upload_date)
						  values
						  ('".$_SESSION['sessUserID']."','".$fileName_insert."',$size,'0','".date('Y-m-d H:i:s')."')	");
		$sql = "SELECT u.username, u.firstname, u.lastname, u.email
                FROM ".USER_TABLE." u
                WHERE u.user_id =".$_SESSION['sessUserID'];
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);
		
		$toMail =  ADMIN_EMAIL_ADDRESS;
        $toName =  "Dibyendu Dutta";
        $subject = "Bulk Upload Zip";
        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;
        
		$textContent = "New zip file has been uploaded by ".$row['firstname']."  ".$row['lastname']." (".$row['username'].").<br /><br />";
        $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
        $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
        if($check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1)){
		$_SESSION['Err'] = "Uploaded successfully.";
		$_SESSION['err_cntr'] = "0";
		header("location: ".PHP_SELF."?mode=bulkupload");
		exit();	
	}
	}
 }
 }
 function stills()
{
if(!$_POST)
{
    if(isset($_SESSION['img']))
    {
      unset($_SESSION['img']);
    }
}
    require_once INCLUDE_PATH."lib/common.php";
    $obj = new Category();
    $catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'),true,true);
    $smarty->assign('catRows', $catRows);

        foreach ($_POST as $key => $value ) {

        $smarty->assign($key, $value);
        eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');

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


    $random = ($_POST['random'] == '')? session_id().'_'.md5(date('Y-m-d H:i:s')).'_'.$_SESSION['sessUserID'] : $_POST['random'];
    $smarty->assign("random", $random);
    $_SESSION['random']=$random;


    $smarty->display("stills.tpl");
	}
 function validateStillsForm()
{
    $errCounter = 0;
	$random = $_REQUEST['random'];

    if($_POST['poster_title'] == ""){
        $GLOBALS['poster_title_err'] = "Please enter Poster Title.";
        $errCounter++;
    }
    if($_POST['poster_size'] == ""){
        $GLOBALS['poster_size_err'] = "Please select Size.";
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
        $GLOBALS['is_default_err'] = "Please Select a default Image.";
        $errCounter++;
    }
    if($_POST['asked_price'] == ""){
        $GLOBALS['asked_price_err'] = "Please enter Asked Price.";
        $errCounter++;
        $asked_price_err = 1;

    }if($_POST['asked_price'] == '0'){
        $GLOBALS['asked_price_err'] = "Please enter valid Asked Price.";
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

    if($_POST['poster_images'] == "" && !isset($_SESSION['img'])){
        $GLOBALS['poster_images_err'] = "Please select Photos.";
        $errCounter++;
    }else if($_POST['is_default'] == ""){
        $GLOBALS['poster_images_err'] = "Please select one image as default.";
        $errCounter++;
    }else{
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
		if($posterimages!="")
	 {
	 $posterimages = str_replace(",," , "," ,$posterimages);
		$posterArr = explode(',', trim($posterimages, ','));
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
	function save_stills_auction()
{
    extract($_POST);
    $obj = new Poster();

    $data = array('fk_user_id' => $_SESSION['sessUserID'],
                  'poster_title' => add_slashes($poster_title),
                  'poster_desc' => add_slashes($poster_desc),
                  'poster_sku' => generatePassword(6),
                  'flat_rolled' => $flat_rolled,
                  'post_date' => date("Y-m-d H:i:s"),
                  'up_date' => "0000-00-00",
                  'status' => 1,
                  'post_ip' => $_SERVER["REMOTE_ADDR"]);
    $poster_id = $obj->updateData(TBL_POSTER, $data);
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
		if($poster_images !="")
		{
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
		}
	##### NEW FUNCTION FOR POSTER UPLOAD ends #####

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

    $is_percentage = ($is_percentage == '')? '0' : '1';
    $is_considered = ($is_consider == '')? '0' : '1';
	if($is_considered=='0'){
		$offer_price = 0;
	}
    $data = array("fk_auction_type_id" => 4,
                  "fk_poster_id" => $poster_id,
                  "auction_asked_price" => $asked_price,
                  "auction_reserve_offer_price" => $offer_price,
                  "is_offer_price_percentage" => $is_percentage,
                  "auction_is_approved" => 0,
                  "auction_is_sold" => 0,
                  "auction_note" => add_slashes($auction_note),
                  "post_date" => date("Y-m-d H:i:s"),
                  "up_date" => "0000-00-00 00:00:00",
                  "status" => 1,
                  "post_ip" => $_SERVER["REMOTE_ADDR"]
    			  );

    $obj->updateData(TBL_AUCTION, $data);

    if($poster_id > 0){
        $_SESSION['Err']="Poster added successfully.";
        header("location: ".PHP_SELF."?mode=pending");
        exit();
    }else{
        $_SESSION['Err']="Could not add poster.Please try again.";
        header("location: ".PHP_SELF."?mode=manualupload");
        exit();
    }
	}
?>
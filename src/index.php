<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

ob_start();
define ("INCLUDE_PATH", "./");

require_once INCLUDE_PATH."lib/inc.php";
//chkLoginNow();
//content();       ////////////   For page content 

if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "login"){
	$chk = validateLoginForm();
	if($chk == true){
		check_login();
	}else{
		dispmiddle();
	}
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "forgot_password"){
	forgot_password();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "new_password"){
	$chk = validateForgotPassword();
	if($chk == true){
		send_new_password();
	}else{
		forgot_password();
	}
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "select_watchlist"){
	select_watchlist();
}else{
	dispmiddle();
}

ob_end_flush();

function dispmiddle(){

	require_once INCLUDE_PATH."lib/common.php";

	// Assign default values for template variables to avoid null errors in PHP 8
	$smarty->assign("dataArrSlider", array());
	$smarty->assign("dataArrFixed", array());
	$smarty->assign("totFixed", 0);
	$smarty->assign("dataArrWeekly", array());
	$smarty->assign("totWeekly", 0);
	$smarty->assign("dataArrUpcoming", array());
	$smarty->assign("totUpcoming", 0);
	$smarty->assign("dataJstFinishedAuction", array());
	$smarty->assign("totJstFinished", 0);
	$smarty->assign("dataArrSmall", array());

	$objAuction=new Auction();

	##### as per new Big Slider ######
	$dataArrSlider = array();
	$sql="Select p.poster_title,tpi.poster_thumb,a.auction_id ,tpi.is_cloud
				from tbl_auction a,tbl_poster p,tbl_poster_images tpi
				WHERE a.fk_poster_id=p.poster_id
				AND p.poster_id = tpi.fk_poster_id
				AND a.is_set_for_home_big_slider='1'
				AND a.auction_is_sold='0'
				AND tpi.is_default='1'" ;
	$rs = mysqli_query($GLOBALS['db_connect'],$sql);
	$k=0;
	while($rs && $row = mysqli_fetch_assoc($rs)){
			   $dataArrSlider[] = $row;
			   $dataArrSlider[$k]['big_image']=CLOUD_POSTER_THUMB_BIG_GALLERY.$row['poster_thumb'];
			   $dataArrSlider[$k]['poster_url']=posterUrl($row['auction_id'], $row['poster_title']);
			   $k++;
		   }

	$sql="Select p.poster_title,tpi.poster_thumb,a.auction_id ,tpi.is_cloud
				from tbl_auction_live a,tbl_poster_live p,tbl_poster_images_live tpi
				WHERE a.fk_poster_id=p.poster_id
				AND p.poster_id = tpi.fk_poster_id
				AND a.is_set_for_home_big_slider='1'
				AND a.auction_is_sold='0'
				AND tpi.is_default='1'";
	$rs = mysqli_query($GLOBALS['db_connect'],$sql);
	if($rs){
		while($row = mysqli_fetch_assoc($rs)){
				   $dataArrSlider[] = $row;
				   $dataArrSlider[$k]['big_image']=CLOUD_POSTER_THUMB_BIG_GALLERY.$row['poster_thumb'];
				   $dataArrSlider[$k]['poster_url']=posterUrl($row['auction_id'], $row['poster_title']);
				   $k++;
			   }
	}		   			
	$smarty->assign("dataArrSlider", $dataArrSlider);
	
	$dataArrFixed=$objAuction->fetchLiveAuctionsHomePage('fixed');
	//$watchObj = new Watch();
	//$posterObj = new Poster();
	if(!empty($dataArrFixed)){

        $totFixed=count($dataArrFixed);
        for($i=0;$i<$totFixed;$i++){
			$dataArrFixed[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$dataArrFixed[$i]['poster_thumb'];
			$dataArrFixed[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataArrFixed[$i]['poster_thumb'];
			$dataArrFixed[$i]['poster_url']=posterUrl($dataArrFixed[$i]['auction_id'], $dataArrFixed[$i]['poster_title']);
        }
        $smarty->assign("dataArrFixed", $dataArrFixed);
        $smarty->assign("totFixed", $totFixed);
    }
    $dataArrWeekly=$objAuction->fetchLiveAuctionsHomePage('weekly');

	##### Live auction hero — replaces the slider + sidebar while a weekly auction runs #####
	$liveHero = buildLiveAuctionHero($GLOBALS['liveAuctionWeek'] ?? null);
	if($liveHero && $liveHero['featured'] && !empty($dataArrWeekly)){
		// The featured lot is in the hero; don't repeat it in the "More lots" carousel
		$dataArrWeekly = array_values(array_filter($dataArrWeekly, function($r) use ($liveHero){
			return $r['auction_id'] != $liveHero['featured']['auction_id'];
		}));
	}
	$smarty->assign("liveHero", $liveHero);

    if(!empty($dataArrWeekly) && count($dataArrWeekly) > ($liveHero ? 0 : 1) ){

        $totWeekly=count($dataArrWeekly);
        for($i=0;$i<$totWeekly;$i++){
            $dataArrWeekly[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$dataArrWeekly[$i]['poster_thumb'];
            $dataArrWeekly[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataArrWeekly[$i]['poster_thumb'];
            $dataArrWeekly[$i]['poster_url']=posterUrl($dataArrWeekly[$i]['auction_id'], $dataArrWeekly[$i]['poster_title']);
        }
        $smarty->assign("dataArrWeekly", $dataArrWeekly);
        $smarty->assign("totWeekly", $totWeekly);
    }else{
        $dataArrUpcoming=$objAuction->fetchUpcomingAuctionHomePage();
        if(!empty($dataArrUpcoming)){
            $totUpcoming=count($dataArrUpcoming);
            for($i=0;$i<$totUpcoming;$i++){
				$dataArrUpcoming[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$dataArrUpcoming[$i]['poster_thumb'];
                $dataArrUpcoming[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataArrUpcoming[$i]['poster_thumb'];
                $dataArrUpcoming[$i]['poster_url']=posterUrl($dataArrUpcoming[$i]['auction_id'], $dataArrUpcoming[$i]['poster_title']);
			}
            $smarty->assign("dataArrUpcoming", $dataArrUpcoming);
            $smarty->assign("totUpcoming", $totUpcoming);
        }
    }
	//$dataArrMonthly=$objAuction->fetchLiveAuctionsHomePage('monthly');
	//if(!empty($dataArrMonthly)){
	//$watchObj->checkWatchlist($dataArrMonthly);
	//$posterObj->fetchPosterImages($dataArrMonthly);
	//$totMonthly=count($dataArrMonthly);
	//$smarty->assign("dataArrMonthly", $dataArrMonthly);
	//$smarty->assign("totMonthly", $totMonthly);
	//}
	
	################ Closed for loading Issue #################
	$dataJstFinishedAuction=$objAuction->homePageSoldSlider();
	if(!empty($dataJstFinishedAuction)){
        //$posterObj->fetchPosterImages($dataJstFinishedAuction);
        //$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
        $totJstFinished = count($dataJstFinishedAuction);
        for($i = 0; $i < $totJstFinished; $i++){
            $dataJstFinishedAuction[$i]['image_path'] = CLOUD_POSTER_THUMB_BUY . $dataJstFinishedAuction[$i]['poster_thumb'];
            $dataJstFinishedAuction[$i]['large_image'] = CLOUD_POSTER_THUMB_BUY_GALLERY . $dataJstFinishedAuction[$i]['poster_thumb'];
            $dataJstFinishedAuction[$i]['poster_url'] = posterUrl($dataJstFinishedAuction[$i]['auction_id'], $dataJstFinishedAuction[$i]['poster_title']);
        }
        $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
        $smarty->assign("totJstFinished", $totJstFinished);
    }
	
	################ Closed for loading Issue #################
	
	#### For Small poster
	$dataArr = array();
	$sqlTemp = "Select * from admin_home_cms WHERE home_temp_id=1 ";
	$ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
	$rowtemp = $ressql ? mysqli_fetch_assoc($ressql) : null;
	$sql = "";
	if($rowtemp){
		if($rowtemp['is_auction']==1){
			$sql="Select p.poster_title,tpi.poster_thumb ,a.fk_auction_type_id,a.auction_asked_price,a.highest_user,tpi.is_cloud
					      FROM tbl_auction_live a,tbl_poster_live p, tbl_poster_images_live tpi
						   WHERE a.auction_id= '".$rowtemp['home_auction_id']."'
						   AND a.fk_poster_id=p.poster_id
						   AND tpi.fk_poster_id = a.fk_poster_id
						   AND tpi.is_default='1' ";
		}else{
			$sql="Select p.poster_title,tpi.poster_thumb ,a.fk_auction_type_id,a.auction_asked_price,a.highest_user,tpi.is_cloud
					      FROM tbl_auction a,tbl_poster p, tbl_poster_images tpi
						   WHERE a.auction_id= '".$rowtemp['home_auction_id']."'
						   AND a.fk_poster_id=p.poster_id
						   AND tpi.fk_poster_id = a.fk_poster_id
						   AND tpi.is_default='1' ";
		}
	}

	if($sql != ""){
		$res_sql = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = $res_sql ? mysqli_fetch_assoc($res_sql) : null;
		if($row && $rowtemp){
			$dataArr[0]['poster_title']=$row['poster_title'];
			$dataArr[0]['poster_thumb']=$row['poster_thumb'];
			$dataArr[0]['home_text']=$rowtemp['home_text'];
			$dataArr[0]['home_link']=$rowtemp['home_link'];
			$dataArr[0]['fk_auction_type_id']=$row['fk_auction_type_id'];
			$dataArr[0]['auction_asked_price']=$row['auction_asked_price'];
			$dataArr[0]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$row['poster_thumb'];
		}
	}

	$smarty->assign("dataArrSmall", $dataArr);

	$smarty->assign('pageTitle', SITE_TITLE.': The Online Marketplace for Kaiju Collectors');
	$smarty->assign('pageMetaDescription', 'Buy and sell Godzilla memorabilia, and kaiju collectibles. Weekly live auctions and fixed-price shop at Kaijulink.');
	$smarty->assign('canonicalUrl', SITE_URL . '/');

	$smarty->display("index_demo.tpl");
}

/**
 * Data for the homepage live auction hero, or null when there is nothing to show.
 * Featured lot: only a live lot with is_set_for_home_big_slider = '1' (set from admin
 * "Set First Image for Home → Auction"). None flagged → the hero shows without the lot card.
 */
function buildLiveAuctionHero($liveWeek){
	if(!$liveWeek){
		return null;
	}
	$db = $GLOBALS['db_connect'];

	$featSql = "SELECT a.auction_id, a.auction_asked_price, a.max_bid_amount AS last_bid_amount, a.bid_count,
	                   p.poster_title, MAX(pi.poster_thumb) AS poster_thumb
	            FROM tbl_auction_live a
	            INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
	            INNER JOIN tbl_poster_images_live pi ON pi.fk_poster_id = a.fk_poster_id AND pi.is_default = '1'
	            WHERE a.is_set_for_home_big_slider = '1'
	              AND a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
	              AND a.auction_actual_start_datetime <= NOW() AND a.auction_actual_end_datetime >= NOW()
	            GROUP BY a.auction_id
	            ORDER BY a.auction_id ASC
	            LIMIT 1";
	$featRs = mysqli_query($db, $featSql);
	$featured = $featRs ? mysqli_fetch_assoc($featRs) : null;
	if($featured){
		$featured['big_image']  = CLOUD_POSTER_THUMB_BIG_GALLERY.$featured['poster_thumb'];
		$featured['poster_url'] = posterUrl($featured['auction_id'], $featured['poster_title']);
	}

	$weekId = (int)$liveWeek['auction_week_id'];
	$bidders = 0;
	$biddersRs = mysqli_query($db, "SELECT COUNT(DISTINCT b.bid_fk_user_id) AS cnt
	                                FROM tbl_bid b INNER JOIN tbl_auction_live a ON a.auction_id = b.bid_fk_auction_id
	                                WHERE a.fk_auction_week_id = $weekId");
	if($biddersRs && ($r = mysqli_fetch_assoc($biddersRs))){
		$bidders = (int)$r['cnt'];
	}

	$next = null;
	$nextRs = mysqli_query($db, "SELECT auction_week_title, auction_week_start_date FROM tbl_auction_week
	                             WHERE is_stills = '0' AND auction_week_start_date > NOW()
	                             ORDER BY auction_week_start_date ASC LIMIT 1");
	if($nextRs && ($r = mysqli_fetch_assoc($nextRs))){
		$next = array('title' => $r['auction_week_title'],
		              'starts' => date('l, F j', strtotime($r['auction_week_start_date'])));
	}

	// "Halloween Auction" → "Halloween" + accented "Auction"
	$title = trim($liveWeek['auction_week_title']);
	$words = preg_split('/\s+/', $title);
	$accent = count($words) > 1 ? array_pop($words) : '';

	$endTs = strtotime($liveWeek['auction_week_end_date']);
	return array(
		'title'        => $title,
		'title_lead'   => implode(' ', $words),
		'title_accent' => $accent,
		'is_long'      => strlen($title) > 22,
		'end_ms'       => $endTs * 1000,
		'server_ms'    => time() * 1000,
		'end_day'      => date('l, F j', $endTs),
		'end_time'     => date('g:i A T', $endTs),
		'lots'         => (int)$liveWeek['lot_count'],
		'bids'         => (int)$liveWeek['bid_total'],
		'bidders'      => $bidders,
		'featured'     => $featured,
		'next'         => $next,
	);
}
function select_watchlist(){
	
	$flag = 1;
	if($_SESSION['sessUserID']!=''){
		if($_REQUEST['is_track']!=''){
			$obj = new DBCommon();
			$obj->primaryKey = 'watching_id';
			$where = array('user_id' => $_SESSION['sessUserID'], "auction_id" => $_REQUEST['is_track']);
			$count=$obj->countData(TBL_WATCHING,$where);
			if($count < 1){
				$Data = array("auction_id" => $_REQUEST['is_track'], "user_id" => $_SESSION['sessUserID'],"add_date"=>date('Y-m-d'));
				$chk=$obj->updateData(TBL_WATCHING,$Data,false);
				if($chk==true){
					$_SESSION['Err']="Item is added to your watchlist.";
				}else{
					$_SESSION['Err'] .="Item is not added to your watchlist.";
				}
			}else{
				$_SESSION['Err']="Item is already added to your watchlist.";
			}
		}else{
			$_SESSION['Err']="Please select atleast one item to add to your watchlist.";
			header("location: ".PHP_SELF);
			exit;	
		}
	}else{
		$_SESSION['Err']="Please login to add to your watch list";
		header("location: ".PHP_SELF);
	}
	header("location: ".PHP_SELF);
	exit;
}
function validateLoginForm()
{
	$errCounter = 0;
	
	if($_REQUEST['username'] == ""){
		$GLOBALS['username_err'] = "Enter Username.";
		$errCounter++;
	}
	
	if($_REQUEST['password'] == ""){
		$GLOBALS['password_err'] = "Enter Password.";
		$errCounter++;
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}


function check_login()
{
	$obj = new User();

	$obj->username = $_REQUEST['username'];
	$obj->password = $_REQUEST['password'];

	if($chk = $obj->checkLogin()){
		header("location: myaccount.php");
		exit();
	}else{
		$_SESSION['Err']="Invalid Username/Password.";
		header("location: ".PHP_SELF);
		exit();
	}
}

function forgot_password()
{
	require_once INCLUDE_PATH."lib/common.php";

	foreach ($_POST as $key => $value ) {
		//$smarty->assign($key, $value);
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}

	$smarty->display("forgot_password.tpl");
}

function validateForgotPassword()
{
	$errCounter = 0;

	if($_POST['login_type'] == '1'){
		$obj = new Member();
	}else{
		$obj = new Advertiser();
	}
	$obj->username = trim($_REQUEST['username']);
	
	if($_REQUEST['username'] == ""){
		$GLOBALS['username_err'] = "Enter Username.";
		$errCounter++;
	}elseif($obj->checkUsername() == false){
		$GLOBALS['username_err'] = "Invalid Username.";
		$errCounter++;
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}

}

function send_new_password()
{
	if($_POST['login_type'] == '1'){
		$obj = new Member();
		$obj->username = $_REQUEST['username'];
		$row = $obj->fetchMemberDetails();
		$obj->memberID = $row[MEMBER_ID];
	}else{
		$obj = new Advertiser();
		$obj->username = $_REQUEST['username'];
		$row = $obj->fetchAdvertiserDetails();
		$obj->advertiserID = $row[ADVERTISER_ID];
	}

	$newPassword = generatePassword();
	$obj->password = $newPassword;	
	$chk = $obj->updatePassword();

	if($chk == true){
	
		/******************************** Email Start ******************************/
		
		$toMail = $row[EMAIL];
		$toName = $row[FIRSTNAME];
		$subject = "Forgot Password";
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		
		$textContent = "Your login information is :<br /><br />";
		$textContent .= "<b>Username : </b>".trim($_POST['username'])."<br />";
		$textContent .= "<b>Password : </b>".$newPassword."<br /><br />";
		$textContent .= "<p style='margin:20px 0 0 0; color:#333333;'>Warm regards,<br /><strong>".ADMIN_NAME."</strong><br /><a href='mailto:".ADMIN_EMAIL_ADDRESS."' style='color:#c0392b;'>".ADMIN_EMAIL_ADDRESS."</a></p>";	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;

		$chk = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

	
		$_SESSION['Err'] = "New Password has been sent to your email-ID.";
		header("Location: index.php");
		exit;
	}else{
		$_SESSION['Err'] = "Forgot Password process has failed. Please Try Again.";
		header("Location: index.php");
		exit;
	}
}
mysqli_close($GLOBALS['db_connect']);
?>
<?php
    $smarty = new SmartyBC;

	$smarty->setCompileCheck(COMPILE_CHECK);
	$smarty->debugging = DEBUGGING;
	$smarty->setCaching(CACHING ? Smarty::CACHING_LIFETIME_CURRENT : Smarty::CACHING_OFF);

	$smarty->setTemplateDir(INCLUDE_PATH.'templates/');
	$smarty->setCompileDir(INCLUDE_PATH.'templates_c/');
	if(isset($GLOBALS["pageTitle"])){
		$smarty->assign('pageTitle', $GLOBALS["pageTitle"]);
	}else{
		$smarty->assign('pageTitle', '');
	}
	if(isset($GLOBALS["pageContent"])){
		$smarty->assign('pageContent', $GLOBALS["pageContent"]);
	}else{
		$smarty->assign('pageContent', '');
	}
	if(isset($GLOBALS["pageHeaderName"])){
		$smarty->assign('pageHeaderName', $GLOBALS["pageHeaderName"]);
	}else{
		$smarty->assign('pageHeaderName', '');
	}
	if(isset($GLOBALS["metaTags"])){
		$smarty->assign('metaTags', $GLOBALS["metaTags"]);
	}else{
		$smarty->assign('metaTags', '');
	}
	$smarty->assign('metaKeywords', $GLOBALS["metaKeywords"]);
	$smarty->assign('metaDescription', $GLOBALS["metaDescription"]);
	
	$currentPage = basename($_SERVER['PHP_SELF']);	
	if($currentPage == "cart.php" || $currentPage == "my_invoice.php" || $currentPage == "ReviewOrder.php" || $currentPage == "DoExpressCheckoutPayment.php") {
		$smarty->assign('actualPath', PAGE_LINK);
		$smarty->assign('actualPathJSCSS', PAGE_LINK_SSL_CSSJS);
		$smarty->assign('actualImagePath', IMAGE_LINK_SSL);
	}
	else{
		$smarty->assign('actualPath', PAGE_LINK);
		$smarty->assign('actualPathJSCSS', PAGE_LINK_CSSJS);
		$smarty->assign('actualImagePath', IMAGE_LINK);
	}
	
	//$smarty->assign('imageWidth', IMAGE_WIDTH);
	//$smarty->assign('imageHeight', IMAGE_HEIGHT);
	
	
	if(isset($_SESSION['Err']) && $_SESSION['Err']=="" && isset($_REQUEST['msg']) && $_REQUEST['msg']!=""){
		$_SESSION['Err'] = $_REQUEST['msg'];
		$smarty->assign('errorMessage', $_SESSION['Err']);
	}

	
	$_SESSION['Err'] = "";
	$objCommon = new DBCommon();
	if(isset($_SESSION['sessUserID'])){
		
		
		
		/** Message count **/
		
		$objCommon->primaryKey = 'message_id';
		if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'read' && $_REQUEST['from'] != 'sent'){
			$objCommon->updateData(TBL_MESSAGE, array('message_is_new' => 0), array('message_id' => $_REQUEST['message_id']), true);
		}		
		
		$where = array('message_to' => $_SESSION['sessUserID'], 'message_is_new' => '1', "message_is_deleted_to" => '0',"message_is_toadmin" => '0',"message_is_fromadmin" => '1');
		$countMsg = 0;
		$countMsg = $objCommon->countData(TBL_MESSAGE, $where);
		//if($countMsg < 1) $countMsg = 0; else $countMsg = $countMsg;
		$smarty->assign('countMsg', $countMsg);
		$smarty->assign('sessUserID', true);
		
		/**	Wantlist count **/
		
		$objCommon->primaryKey = 'wantlist_id';

		$total_CommonWant = $objCommon->countData(TBL_WANTLIST, array("fk_user_id"=> $_SESSION['sessUserID']));
		if($total_CommonWant > 0){
			$totalCommonWant = 0;	
			$dataCommonWant = $objCommon->selectData(TBL_WANTLIST,array('*'),array("fk_user_id"=>$_SESSION['sessUserID']));
			$objCommonWant = new Wantlist();
			for($i=0;$i<$total_CommonWant;$i++){
				$count_matchCommonWant = array();
				$count_matchCommonWant = array_merge($count_matchCommonWant, $objCommonWant->get_poster_id($dataCommonWant[$i]['wantlist_id']));
				$totalCommonWant += count($count_matchCommonWant);
			}
		}
		else{
		$totalCommonWant=0;
		}		
		$smarty->assign('total_want_count', $totalCommonWant);
		
		/** Wishlist count **/
		
		$objCommon->primaryKey = 'watching_id';
		$where = array('user_id' => $_SESSION['sessUserID']);
		$count_user_watching = $objCommon->countData(TBL_WATCHING, $where);
		$smarty->assign('count_watching', $count_user_watching);
	
		
		
		/** Outgoing Offers Count **/
		
		$offerObj = new Offer();
		
		if($_SERVER['PHP_SELF']=='/offers.php' && $_REQUEST['mode']==''){
			//$sqlUpdateReadOutgoingOffer = mysqli_query($GLOBALS['db_connect']," Update tbl_offer set is_read_buyer = '1' WHERE offer_fk_user_id= '".$_SESSION['sessUserID']."' AND offer_parent_id='0' ");
		}
		
		$totalUnReadOutgoingOffer = $offerObj->countUnread_Offers($_SESSION['sessUserID'], true);
		if(!$totalUnReadOutgoingOffer){
			$totalUnReadOutgoingOffer = 0 ;
		}
		$smarty->assign('totalUnReadOutgoingOffer', $totalUnReadOutgoingOffer);
		
		/** Incoming Counters Count **/
		
		if($_SERVER['PHP_SELF']=='/offers.php' && $_REQUEST['mode']=='incoming_counters'){
					$sql = "SELECT
					cntr_ofr.offer_id  AS cntr_offer_id
					FROM tbl_auction a,tbl_offer ofr
					  LEFT JOIN tbl_offer cntr_ofr
						ON ofr.offer_id = cntr_ofr.offer_parent_id
					WHERE ofr.offer_fk_auction_id = a.auction_id
						AND ofr.offer_parent_id = '0'
						AND ofr.offer_fk_user_id = '".$_SESSION['sessUserID']."'
						AND ofr.is_archived='0' 
						AND cntr_ofr.is_read_buyer='0'
						AND cntr_ofr.offer_amount !='' " ;
			$resSql = mysqli_query($GLOBALS['db_connect'], $sql);
			while($row=mysqli_fetch_array($resSql)){
				$sqlUpdate = mysqli_query($GLOBALS['db_connect']," Update tbl_offer set is_read_buyer = '1' WHERE offer_id= '".$row['cntr_offer_id']."' ");
			}
		}
		
		$totalUnReadIncomingCounters = $offerObj->countUnread_incoming_counters($_SESSION['sessUserID']);
		if(!$totalUnReadIncomingCounters){
			$totalUnReadIncomingCounters = 0 ;
		}
		$smarty->assign('totalUnReadIncomingCounters', $totalUnReadIncomingCounters);
		
		/** Incoming Offers Count **/
		
		if($_SERVER['PHP_SELF']=='/offers.php' && $_REQUEST['mode']=='incoming_offers'){
				$sql = "SELECT ofr.offer_id
							FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
								 WHERE ofr.offer_fk_auction_id = a.auction_id
								 AND a.fk_poster_id = p.poster_id 
								 AND p.fk_user_id = '".$_SESSION['sessUserID']."'
								 AND ofr.is_archived_seller='0'
								 AND ofr.is_read_seller='0'
								 AND ofr.offer_parent_id = '0' " ;
			$resSql = mysqli_query($GLOBALS['db_connect'], $sql);
			while($row=mysqli_fetch_array($resSql)){
				$sqlUpdate = mysqli_query($GLOBALS['db_connect']," Update tbl_offer set is_read_seller = '1' WHERE offer_id= '".$row['offer_id']."' ");
			}
		}
		
		$totalUnReadIncomingOffers = $offerObj->countUnread_incoming_offers($_SESSION['sessUserID']);
		if(!$totalUnReadIncomingOffers){
			$totalUnReadIncomingOffers = 0 ;
		}
		$smarty->assign('totalUnReadIncomingOffers', $totalUnReadIncomingOffers);
		
		/** Outgoing Counters Count **/
		
		if($_SERVER['PHP_SELF']=='/offers.php' && $_REQUEST['mode']=='outgoing_counters'){
				/*$sql = "SELECT
						  cntr_ofr.offer_id offer_id
						FROM tbl_auction a,
						  tbl_poster p,
						  tbl_offer ofr
						  LEFT JOIN tbl_offer cntr_ofr
							ON ofr.offer_id = cntr_ofr.offer_parent_id
						WHERE p.fk_user_id = '".$_SESSION['sessUserID']."'
							AND a.fk_poster_id = p.poster_id
							AND ofr.offer_fk_auction_id = a.auction_id
							AND ofr.offer_parent_id = '0'
							AND ofr.is_archived_seller = '0'
							AND cntr_ofr.is_read_seller = '0'
							AND cntr_ofr.offer_amount != '' " ;
			$resSql = mysqli_query($GLOBALS['db_connect'], $sql);
			while($row=mysqli_fetch_array($resSql)){
				$sqlUpdate = mysqli_query($GLOBALS['db_connect']," Update tbl_offer set is_read_seller = '1' WHERE offer_id= '".$row['offer_id']."' ");
			}*/
		}
		
		$totalUnReadOutgoingCounters = $offerObj->countUnread_outgoing_counters($_SESSION['sessUserID']);
		if(!$totalUnReadOutgoingCounters){
			$totalUnReadOutgoingCounters = 0 ;
		}
		$smarty->assign('totalUnReadOutgoingCounters', $totalUnReadOutgoingCounters);
	
		}
	
	/******************* User Login area end here ****************/
	
	/******************* Code for Right Panel here ****************/
	$rightPanelObj = new Category();
	$where = "fk_cat_type_id <> '5'";
	$rightPanelCatRows = $rightPanelObj->selectDataCategoryStills(TBL_CATEGORY, array('cat_id','cat_value','is_stills'));
	$smarty->assign('rightPanelCatRows', $rightPanelCatRows);
	if($_SERVER['REQUEST_URI']!='/myselling.php?mode=bulkupload'){
		$_SESSION['err_cntr']=0;
	}
	
	$currentPage = basename($_SERVER['PHP_SELF']);	
	if($currentPage == "cart.php" || $currentPage == "my_invoice.php" || $currentPage == "ReviewOrder.php" || $currentPage == "DoExpressCheckoutPayment.php") {
		if($_SERVER['SERVER_PORT'] != '443'){
			//header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
			//exit; 
		}
	}
	if(isset($_SESSION['cart'])){
		$smarty->assign('totalCartCount', count($_SESSION['cart']));
	}else{
		$smarty->assign('totalCartCount', 0);
	}
	
	$sqlTemp = "Select * from  tbl_auction_calender WHERE id=1 ";
	$ressql= mysqli_query($GLOBALS['db_connect'], $sqlTemp); 
	$rowtemp= mysqli_fetch_assoc($ressql);
	//echo "<pre>".print_r($rowtemp)."</pre>";	
	$smarty->assign('calenderArray', $rowtemp);
?>
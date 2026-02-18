<?php
/**************************************************/
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define ("PAGE_HEADER_TEXT", "User Messages");
ob_start();

define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['sessUserID'])){
    header("Location: index.php");
    exit;
}
if($_REQUEST['mode'] == "incoming_counters"){ 
    incoming_counters();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="accept_offer"){
    processOffer();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="reject_offer"){
    processOffer();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="make_counter_offer"){
    processOffer();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="refresh_outgoing_offers_only"){
    refreshOutgoingOffersOnly();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="refresh_outgoing_offers"){
    refreshOutgoingOffers();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="refresh_incoming_counters"){
    refreshIncomingCounters();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="incoming_offers"){
    incoming_offers();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="outgoing_counters"){
    outgoing_counters();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="refresh_incoming_offers_only"){
    refresh_incoming_offers_only();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="trackOfferIfExists"){
    trackOfferIfExists();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="trackArchived"){
    trackArchived();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="archived_outgoing_offers_only"){
    archived_outgoing_offers_only();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="archived_outgoing_offers"){
    archived_outgoing_offers();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="archived_incoming_offers"){
    archived_incoming_offers();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="archived_outgoing_counters"){
    archived_outgoing_counters();
}else{
    dispmiddle();
}

ob_end_flush();
/*************************************************/

/*********************  START of dispmiddle Function    **********/

function dispmiddle()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], true);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID']);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('my_outgoing_offers_only.tpl');
}

/************************************    END of Middle   ********************************/

function incoming_counters()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], true);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID']);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('my_outgoing_offers.tpl');
}

function refreshOutgoingOffersOnly()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], true);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID']);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('refresh_outgoing_offers_only.tpl');
}
function refreshOutgoingOffers()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], true);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID']);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('refresh_outgoing_offers.tpl');
}

function refreshIncomingCounters() {
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], false);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,'',false,1);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);
        
        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('refresh_incoming_counters.tpl');
}

function validateProcessOffer()
{
    extract($_REQUEST);
    $errCounter = 0;
    $offerObj = new Offer();
    if($offerObj->auctionIsSold($offer_id)){
        $errors = "This poster already sold\n";
        $errCounter++;
    }elseif($mode == 'make_counter_offer'){

        if($offer_amount == ''){
            $errors = "Please enter counter offer amount";
            $errCounter++;
        }elseif(!is_numeric($offer_amount)){
            $errors .= "Please enter numeric value for counter offer amount";
            $errCounter++;  
        }elseif($offerObj->countData(TBL_OFFER, array("offer_parent_id" => $offer_id)) > 0){
            $errors .= "Counter offer already exists!";
            $errCounter++;
        }
    }
    
    if($errCounter > 0){
        return $errors;
    }else{
        return '';
    }
}
function incoming_offers()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], false);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,'',false,1);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);

        
        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('my_incoming_offers_only.tpl');
}
function refresh_incoming_offers_only()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], false);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,$user_id = '',$isArchived='',1);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);
        
        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('refresh_incoming_offers_only.tpl');
}
function outgoing_counters()
{
    require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers($_SESSION['sessUserID'], false);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,'',false,1);
        $offerObj->fetchTotalOffers($auctionRows);
		
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);
        
        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }
    
    $smarty->assign('total', $total);
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
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
    $smarty->display('my_incoming_counters.tpl');
}
function processOffer()
{
    extract($_REQUEST);
    $errors = validateProcessOffer();
    if($errors == ''){
        $offerObj = new Offer();
        if($mode == 'accept_offer'){
            $check = $offerObj->acceptOffer($auction_id, $offer_id);
            if($check){                     
                if($type == 'buyer'){
                    sendOfferMail($offer_id, 'accept_counter_offer');
                }else{
                    sendOfferMail($offer_id, 'accept_offer');
                }
                echo "true";
            }else{
                echo "false";
            }
        }elseif($mode == 'reject_offer'){
            $check = $offerObj->rejectOffer($offer_id);
            if($check){
                if($type == 'buyer'){
                    sendOfferMail($offer_id, 'reject_counter_offer');
                }else{
                    sendOfferMail($offer_id, 'reject_offer');
                }
                echo "true";
            }else{
                echo "false";
            }
        }elseif($mode == 'make_counter_offer'){
            $check = $offerObj->makeCounterOffer($auction_id, $offer_id, $offer_amount);        
            if($check){
                //sendOfferMail($offer_id, 'counter_offer_made');
				sendOfferMail($check, 'counter_offer_made');
                echo "true";
            }else{
                echo "false";
            }
        }else{
            echo "false";
        }
    }else{
        echo $errors;
    }
}
function trackOfferIfExists(){
	$offerObj = new Offer();
	$offer_id=$_REQUEST['offer_id'];
	$where=array("offer_id"=>$offer_id);
	$count=$offerObj->countData(TBL_OFFER,$where);
	if($count ==1){
		echo "1";
	}else if($count ==0){
		echo "2";
	}
}
function trackArchived(){
    $offerObj = new Offer();
    $posterTitle = array();
    if(!empty($_REQUEST['auction_id'])){
        foreach($_REQUEST['auction_id'] as $key=>$val)  {

            if(isset($_REQUEST['is_seller']) && $_REQUEST['is_seller']=='1'){
                $countKey=$offerObj->ifArchivedAbleSeller($val);
                $countArr = explode('-',$countKey);
                $count = $countArr['0'];
                $poster_title =  $countArr['1'];
                if($count=='0'){
                    $offerData = array("is_archived_seller" => '1',"archived_date" => date('Y-m-d H:i:s'));
                    $offerWhere = array("offer_fk_auction_id" => $val);
                    $offerObj->updateData(TBL_OFFER, $offerData, $offerWhere, true);
                }else{
                    $key=1;
                    array_push($posterTitle,$poster_title);
                }
            } else{
                $countKey=$offerObj->ifArchivedAble($val,$_SESSION['sessUserID']);
                $countArr = explode('-',$countKey);
                $count = $countArr['0'];
                $poster_title =  $countArr['1'];
                if($count=='0'){
                    $offerData = array("is_archived" => '1',"archived_date" => date('Y-m-d H:i:s'));
                    $offerWhere = array("offer_fk_auction_id" => $val,"offer_fk_user_id" => $_SESSION['sessUserID']);
                    $offerObj->updateData(TBL_OFFER, $offerData, $offerWhere, true);
                }else{
                   $key=1;
                   array_push($posterTitle,$poster_title);
                }
            }

        }
        if($key=='1') {
            foreach($posterTitle as $key=>$val){
              $_SESSION['Err'] .= $key+1 .'.'.$val.'<br/>';
            }
            $_SESSION['Err'] .="These Items are not moved successfully to archive as there are pending offers.";
        }else{
            $_SESSION['Err']="Items are successfully moved to archive.";
        }
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    } else{
        $_SESSION['Err']="Please select atleast one item to move to archive.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
}

function archived_outgoing_offers_only(){

    require_once INCLUDE_PATH."lib/common.php";

    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers_archived($_SESSION['sessUserID'], true);

    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers_archived($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID'],true);
        $offerObj->fetchTotalOffers($auctionRows);

        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));

        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }

    $smarty->assign('total', $total);
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
    $smarty->assign('offset', $offset);
    $smarty->assign('toshow', $toshow);
    $smarty->display('my_archived_offers_only.tpl');

}
function archived_outgoing_offers(){


    require_once INCLUDE_PATH."lib/common.php";

    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Offers_archived($_SESSION['sessUserID'], true);

    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Offers_archived($_SESSION['sessUserID'], true,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID'],true);
        $offerObj->fetchTotalOffers($auctionRows);

        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        //$posterObj->fetchPosterImages($auctionRows);

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));

        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }

    $smarty->assign('total', $total);
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
    $smarty->assign('offset', $offset);
    $smarty->assign('toshow', $toshow);
    $smarty->display('my_archived_offers.tpl');


}

function archived_incoming_offers(){


    require_once INCLUDE_PATH."lib/common.php";

    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Incoming_Offers_archived($_SESSION['sessUserID'], false);

    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Incoming_Offers_archived($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,'',true,1);
        $offerObj->fetchTotalOffers($auctionRows);

        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);


        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));

        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }

    $smarty->assign('total', $total);
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
    $smarty->assign('offset', $offset);
    $smarty->assign('toshow', $toshow);
    $smarty->display('my_archived_incoming_offers.tpl');

}

function  archived_outgoing_counters(){
   require_once INCLUDE_PATH."lib/common.php";

    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_Incoming_Offers_archived($_SESSION['sessUserID'], false);

    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_Incoming_Offers_archived($_SESSION['sessUserID'], false,$_REQUEST['order_by'],$_REQUEST['order_type']);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows,'',true,1);
        $offerObj->fetchTotalOffers($auctionRows);

        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);


        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));

        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }

    $smarty->assign('total', $total);
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
    $smarty->assign('offset', $offset);
    $smarty->assign('toshow', $toshow);
    $smarty->display('my_archived_outgoing_counters.tpl');
}

function sendOfferMail($offer_id, $status)
{
    $sql = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, p.poster_title, p.poster_sku, ofr.offer_amount
            FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
            WHERE ofr.offer_fk_user_id = usr.user_id
            AND ofr.offer_fk_auction_id = a.auction_id
            AND a.fk_poster_id = p.poster_id
            AND ofr.offer_id = '".$offer_id."'";
    $rs = mysqli_query($GLOBALS['db_connect'],$sql);
    $row = mysqli_fetch_array($rs);
	
	
	$sqlForSeller ="SELECT usr.firstname, usr.lastname, usr.email
					FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." AS p
					WHERE ofr.offer_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id
					AND p.fk_user_id = usr.user_id
					AND ofr.offer_id =  '".$offer_id."'";
	$rsSeller = mysqli_query($GLOBALS['db_connect'],$sqlForSeller);
	$rowSeller = mysqli_fetch_array($rsSeller);
	
	if($status == "counter_offer_made" or $status == "reject_counter_offer" or $status == "accept_counter_offer"){
		$sqlCOfferData = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, o.offer_fk_user_id
							FROM tbl_offer AS o, user_table AS usr WHERE usr.user_id = o.offer_fk_user_id
							AND o.offer_id
							IN (
							SELECT offer_parent_id
							FROM tbl_offer
							WHERE offer_id = '".$offer_id."'
							)";
		$rsCOfferData = mysqli_query($GLOBALS['db_connect'],$sqlCOfferData);
		$rowCOfferData = mysqli_fetch_array($rsCOfferData);
	}
    
    if($status == "counter_offer_made" or $status == "reject_counter_offer" or $status == "accept_counter_offer"){
		$toMail = $rowCOfferData['email'];
		$toName = $rowCOfferData['firstname'].' '.$row['lastname'];
	}else{
		$toMail = $row['email'];
		$toName = $row['firstname'].' '.$row['lastname'];
	}
	$toMailSeller = $rowSeller['email'];
    $toNameSeller = $rowSeller['firstname'].' '.$rowSeller['lastname'];
    //$subject = "MPE::Offer Accepted - ".$row['poster_title']." (#".$row['poster_sku'].")";
    $fromMail = ADMIN_EMAIL_ADDRESS;
    $fromName = ADMIN_NAME;
    
    if($status == "counter_offer_made" or $status == "reject_counter_offer" or $status == "accept_counter_offer"){
		$textContent = 'Dear '.$rowCOfferData['firstname'].' '.$rowCOfferData['lastname'].',<br /><br />';
	} else {
    	$textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
	}
    $textContent .= '<b>Item Title : </b>'.$row['poster_title'].'<br />';
    //$textContent .= '<b>Poster SKU : </b>'.$row['poster_sku'].'<br /><br />';
	
	$textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br /><br />';
    $textContentSeller .= '<b>Item Title : </b>'.$row['poster_title'].'<br />';
    //$textContentSeller .= '<b>Poster SKU : </b>'.$row['poster_sku'].'<br /><br />';
	
    if($status == "accept_counter_offer"){
		$subject = "MPE::Counter Offer Accepted - ".$row['poster_title']." ";
		$textContent .= 'Congratulations! You have accepted the counter-offer of $'.$row['offer_amount'].'.<br /><br/>';
		$textContent .= 'You will receive an invoice shortly via email for payment.<br />';
		$textContent .= 'You may also view invoice once generated by logging in and selecting <b>Invoices/Reconciliations</b> located in <b>User Section</b>.<br /><br />';
        $textContentSeller .= 'Congratulations! Your counter-offer of $'.$row['offer_amount'].' has been accepted.<br />';
        $textContentSeller .= 'Buyer will be invoiced and you will be notified via email when we receive payment.<br /><br />';
        $textContentAdmin .= $rowSeller['firstname'].' '.$rowSeller['lastname'].'&#39;s counter-offer of $'.$row['offer_amount'].' has been accepted.<br />';
        $textContentAdmin .= $rowCOfferData['firstname'].' '.$rowCOfferData['lastname'].' has been accepted the counter-offer of '.$row['poster_title'].'.<br /><br />';
        //$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
    }elseif($status == "accept_offer"){
		$subject = "MPE::Offer Accepted - ".$row['poster_title']." ";
        $textContent .= 'Congratulations! Your offer of $'.$row['offer_amount'].' has been accepted.<br /><br />';
        $textContent .= 'You will receive an invoice shortly via email for payment.<br />';
		$textContent .= 'You may also view invoice once generated by logging in and selecting <b>Invoices/Reconciliations</b> located in <b>User Section</b>.<br /><br />';
		$textContentSeller .= 'You have accepted the offer of $'.$row['offer_amount'].'<br />';
		$textContentSeller .= 'Buyer will be invoiced and you will be notified via email when we receive payment.<br /><br />';
        $textContentAdmin .= $row['firstname'].' '.$row['lastname'].'&#39;s offer of $'.$row['offer_amount'].' has been accepted.<br />';
        $textContentAdmin .= $rowSeller['firstname'].' '.$rowSeller['lastname'].' has been accepted the offer of '.$row['poster_title'].'.<br />';
        //$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
    }elseif($status == "reject_counter_offer"){
		$subject = "MPE::Counter Offer Rejected - ".$row['poster_title']." ";
		$textContent .= 'You have rejected the counter offer of $'.$row['offer_amount'].'<br /><br />';
        $textContentSeller .= 'Your counter offer of $'.$row['offer_amount'].' has been rejected.<br /><br />';
        //$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
    }elseif($status == "reject_offer"){
		$subject = "MPE::Offer Rejected - ".$row['poster_title']." ";
        $textContent .= 'Your offer of $'.$row['offer_amount'].' has been rejected.<br /><br />';
		$textContentSeller .= 'You have rejected the offer of $'.$row['offer_amount'].'<br /><br />';
        //$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
    }elseif($status == "counter_offer_made"){
		$subject = "MPE::Counter Offer Made - ".$row['poster_title']." ";
        $textContent .= 'Counter offer of $'.$row['offer_amount'].' has been made against your offer.<br /><br />';
		$textContentSeller .= 'You have made a counter offer of $'.$row['offer_amount'].'<br /><br />';
        //$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
    }
	
	$textContent .= 'Please contact us at <a href="mailto:'.SITE_EMAIL.'">'.SITE_EMAIL.'</a> if you have any questions.<br /><br />';    
    $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
    $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
	
	$textContentSeller .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';    
    $textContentSeller .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
    $textContentSeller = MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM;
	
	//echo $textContent."<br>".$textContentSeller;
	//die;
	$textContentAdmin .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
    $textContentAdmin = MAIL_BODY_TOP.$textContentAdmin.MAIL_BODY_BOTTOM;
    
    
    $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
	$checkSeller = sendMail($toMailSeller, $toNameSeller, $subject, $textContentSeller, $fromMail, $fromName, $html=1);
	if($status == "accept_counter_offer" || $status == "accept_offer"){
		$checkAdmin = sendMail(ADMIN_EMAIL_ADDRESS,ADMIN_NAME, $subject, $textContentAdmin, $fromMail, $fromName, $html=1);
	}
}

?>
<?php
ob_start();
define ("PAGE_HEADER_TEXT", "Control Panel");

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

dispmiddle();

ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/adminCommon.php";
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	/* Dash Board for Sold Items */
	$objAuction = new Auction();
	$totalSoldAuc=$objAuction->countJstFinishedAuction('','',$type='Home');
	$objAuction->orderBy='invoice_generated_on';
	$dataJstFinishedAuction=$objAuction->soldAuction(true,true,'','',$type='Home');
    for($i=0;$i<count($dataJstFinishedAuction);$i++){
        if (file_exists("../poster_photo/" . $dataJstFinishedAuction[$i]['poster_thumb'])){
            $dataJstFinishedAuction[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataJstFinishedAuction[$i]['poster_thumb'];
        }else{
            $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB.$dataJstFinishedAuction[$i]['poster_thumb'];
        }
    }
	$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);

	$smarty->assign('total', $totalSoldAuc);
	$smarty->assign('dataJstFinishedAuction', $dataJstFinishedAuction);
	$objBid = new Bid();
    $objBid->orderType="DESC";
	$dataBid = $objBid->fetchBidDetails('','winning');
    for($i=0;$i<count($dataBid);$i++){
        if (file_exists("../poster_photo/" . $dataBid[$i]['poster_thumb'])){
            $dataBid[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataBid[$i]['poster_thumb'];
        }else{
            $dataBid[$i]['image_path']=CLOUD_POSTER_THUMB.$dataBid[$i]['poster_thumb'];
        }
    }
	$objBid->fetchMyBidByType($dataBid,'','winning');
	$smarty->assign('totalBids', count($dataBid));
	$smarty->assign('bidDetails', $dataBid);
	
	$objOffer = new Offer();
	$dataOfr = $objOffer->fetchMyWinningOffers();
    for($i=0;$i<count($dataOfr);$i++){
        if (file_exists("../poster_photo/" . $dataOfr[$i]['poster_thumb'])){
            $dataOfr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataOfr[$i]['poster_thumb'];
        }else{
            $dataOfr[$i]['image_path']=CLOUD_POSTER_THUMB.$dataOfr[$i]['poster_thumb'];
        }
    }
	$smarty->assign('dataOfr', $dataOfr);
	$smarty->assign('totalOffers', count($dataOfr));
	
 	$smarty->display("admin_main.tpl");
}
?>
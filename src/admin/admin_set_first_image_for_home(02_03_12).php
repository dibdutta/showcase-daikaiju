<?php
/**************************************************/
ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "update_slider"){
 	updateSlider();
}else{
	fixedPriceSale();
}

ob_end_flush();
/*************************************************/

/*********************	START of FixedPriceSale Function	**********/

	function fixedPriceSale() {
		require_once INCLUDE_PATH."lib/adminCommon.php";	
		if($_REQUEST['search'] == 'selling' ){
			define ("PAGE_HEADER_TEXT", "Featured Items for Sale");	
		}else if($_REQUEST['search'] == 'sold'){
			define ("PAGE_HEADER_TEXT", "Recent Sales Results");
		}
				
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
		$total = $auctionObj->countFixedPriceSaleByStatusHome($_REQUEST['search']);
		if($total > 0 ){
			$auctionRows = $auctionObj->fetchFixedPriceSaleByStatusHome($_REQUEST['search']);
			$total_now=count($auctionRows);
	    	for($i=0;$i<$total_now;$i++)
	    	{
				if (file_exists("../poster_photo/" . $auctionRows[$i]['poster_image'])){
					list($width, $height, $type, $attr) = getimagesize("../poster_photo/".$auctionRows[$i]['poster_image']);
					$auctionRows[$i]['img_width']=$width;
					$auctionRows[$i]['img_height']=$height;
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
		$smarty->display('admin_set_first_image_for_home.tpl');
	}
	function updateSlider(){
	 $actionId = $_REQUEST['actionId'];
	 $deleteExistingSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '0'
	 WHERE
	 fk_auction_type_id  = '1' AND auction_is_approved = '1' AND auction_is_sold = '0'" ;
	 mysqli_query($GLOBALS['db_connect'],$deleteExistingSliderStatus); 
	 $updateNewSliderStatus = "UPDATE tbl_auction SET slider_first_position_status = '1'
	 WHERE
	 fk_auction_type_id  = '1' AND auction_is_approved = '1' AND auction_is_sold = '0' AND auction_id ='$actionId' " ;
	 mysqli_query($GLOBALS['db_connect'],$updateNewSliderStatus);
	 
	 echo "Poster is Successfuly set as first poster in Recent Sales Results Slider.";
}  	
?>
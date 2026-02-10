<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="search_sold"){
    search_sold();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="fixed"){
    fixed_result();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="search_sold_fixed"){
    search_sold_fixed();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="weekly"){
    weekly_result();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="search_sold_weekly"){
    search_sold_weekly();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="stills"){
    stills_result();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="search_sold_stills"){
    search_sold_stills();
}else{
    dispmiddle();
}



ob_end_flush();

	function dispmiddle(){
		require_once INCLUDE_PATH."lib/common.php";
		$objAuction = new Auction();
		$posterObj = new Poster();
		if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}		
		$total=$objAuction->countSoldItemAuction();
		//$objAuction->orderBy='soldamnt';
		$dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type']);		
		if(!empty($dataJstFinishedAuction)){
			//$posterObj->fetchPosterImages($dataJstFinishedAuction);
			//$posterObj->fetchPosterCategories($dataJstFinishedAuction);
            for($i=0;$i<count($dataJstFinishedAuction);$i++){
                
                    $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                
            }
			$smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
		}
		$objAuction->orderBy='invoice_generated_on';
		$smarty->assign("total", $total);
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=25, $end=100, $step=25, $use=1));
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
		$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
		if($_SESSION['sessAuctionView'] == 'list'){
				$smarty->display("sold_item.tpl");	
		}else{
				$smarty->display("sold_item_grid.tpl");
		}
	
}
 function search_sold(){
     require_once INCLUDE_PATH."lib/common.php";
     extract($_REQUEST);
	 if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}
     if($search_sold=='' || $search_sold=='Search sold items by their title..'){
         $_SESSION['Err']="Please enter a poster title!";
         header("location: ".PHP_SELF);
         exit;
     }else{
         $objAuction = new Auction();
         $posterObj = new Poster();
         $title=$search_sold;
         $total=$objAuction->countSoldItemAuction(trim($title));
		 if($total>0){			 
			$dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type'],trim($title));
				 //$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
		  }
         
         if(!empty($dataJstFinishedAuction)){
             for($i=0;$i<count($dataJstFinishedAuction);$i++){
                 
                     $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                 
             }
             $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
         }
         $objAuction->orderBy='invoice_generated_on';
         $smarty->assign("total", $total);
         $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
         $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
         $smarty->assign('displaySortByTXT', displaySortBy("headertext"));
         
     }
		if($_SESSION['sessAuctionView'] == 'list'){
				$smarty->display("sold_item.tpl");	
		}else{
				$smarty->display("sold_item_grid.tpl");
		}
 }

function fixed_result(){

    require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}
    $objAuction = new Auction();
    $posterObj = new Poster();
    $total=$objAuction->countSoldItemAuction('','','','fixed');
    $dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type'],'','fixed');
   
    if(!empty($dataJstFinishedAuction)){
        for($i=0;$i<count($dataJstFinishedAuction);$i++){
            
                $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
            
        }
        $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
    }
    $objAuction->orderBy='invoice_generated_on';
    $smarty->assign("total", $total);
    $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=25, $end=100, $step=25, $use=1));
    $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

    if($_SESSION['sessAuctionView'] == 'list'){
			$smarty->display("sold_item_fixed.tpl");	
	}else{
			$smarty->display("sold_item_grid_fixed.tpl");
	}

}
function search_sold_fixed(){
    require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}
    extract($_REQUEST);
    if($search_sold=='' || $search_sold=='Search sold items by their title..'){
        $_SESSION['Err']="Please enter a poster title!";
        header("location: ".PHP_SELF);
        exit;
    }else{
        $objAuction = new Auction();
        $posterObj = new Poster();
        $title=$search_sold;
        $total=$objAuction->countSoldItemAuction(trim($title),'','','fixed');
		if($total>0){			 
			$dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type'],trim($title),'fixed');
				 //$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
		  }
        
        if(!empty($dataJstFinishedAuction)){
            for($i=0;$i<count($dataJstFinishedAuction);$i++){
                
                    $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                
            }
            $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
        }
        $objAuction->orderBy='invoice_generated_on';
        $smarty->assign("total", $total);
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

        if($_SESSION['sessAuctionView'] == 'list'){
					$smarty->display("sold_item_fixed.tpl");	
			}else{
					$smarty->display("sold_item_grid_fixed.tpl");
			}
    }

}
function weekly_result(){


    require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}
    $objAuction = new Auction();
    $auctionWeekObj = new AuctionWeek();
    $total=$objAuction->countSoldItemAuction('','','','weekly');
    $dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type'],'','weekly');
    if(!empty($dataJstFinishedAuction)){
        for($i=0;$i<count($dataJstFinishedAuction);$i++){
            
                $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                $dataJstFinishedAuction[$i]['image_big']=CLOUD_POSTER_THUMB_BIG_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
            
        }
        $auctionWeek= $auctionWeekObj->selectAuctionWeek();
        $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
        $smarty->assign("auctionWeek", $auctionWeek);
    }
    $objAuction->orderBy='invoice_generated_on';
    $smarty->assign("total", $total);
    $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=25, $end=100, $step=25, $use=1));
    $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

    if($_SESSION['sessAuctionView'] == 'list'){
			$smarty->display("sold_item_weekly.tpl");	
	 }else{
			$smarty->display("sold_item_grid_weekly.tpl");
	 }


}
function search_sold_weekly(){

    require_once INCLUDE_PATH."lib/common.php";
    extract($_REQUEST);
	if(isset($_SESSION['sessAuctionView'])){

		}else{
			$_SESSION['sessAuctionView']='';
		}
		if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
			$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
		}
    if(($search_sold =='' || $search_sold =='Search sold items by their title..') && $_REQUEST['auction_week']==''){
        //$_SESSION['Err']="Please enter a poster title!";
        header("location: ".PHP_SELF."?mode=weekly");
        exit;
    }else{
        if($search_sold =='Search sold items by their title..'){
            $search_sold='';
        }
        $objAuction = new Auction();
        $auctionWeekObj = new AuctionWeek();
        $title=$search_sold;
        $total=$objAuction->countSoldItemAuction(trim($title),'','','weekly',$_REQUEST['auction_week']);
		if($total>0){			 
			$dataJstFinishedAuction=$objAuction->OrderBySoldPrice($_REQUEST['order_by'],$_REQUEST['order_type'],trim($title),'weekly',$_REQUEST['auction_week']);
				 //$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
		  }
        
        if(!empty($dataJstFinishedAuction)){
            for($i=0;$i<count($dataJstFinishedAuction);$i++){
                
                    $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                
            }
            $auctionWeek= $auctionWeekObj->selectAuctionWeek();
            $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
            $smarty->assign("auctionWeek", $auctionWeek);
        }
        $objAuction->orderBy='invoice_generated_on';
        $smarty->assign("total", $total);
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

        if($_SESSION['sessAuctionView'] == 'list'){
			$smarty->display("sold_item_weekly.tpl");	
		 }else{
			$smarty->display("sold_item_grid_weekly.tpl");
		 }
    }


}

function stills_result(){

    require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessAuctionView'])){

	}else{
		$_SESSION['sessAuctionView']='';
	}
	if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
		$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
	}
    $objAuction = new Auction();
    $auctionWeekObj = new AuctionWeek();
    $total=$objAuction->countJstFinishedAuction('','','','stills');
    if($_REQUEST['order_by']=='auction_asked_price'){
        $dataJstFinishedAuction=$objAuction->soldAuction('','','','','','','','stills');
        $dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);

        for($i=0;$i<$total;$i++){
                $sql_insert="Insert into `tbl_temp` (`auction_id`,
													 `event_title`,
													 `invoice_generated_on`,
													 `fk_auction_type_id`,
													 `auction_is_sold`,
							 						 `auction_asked_price`,
							 						 `auction_reserve_offer_price`,
							 						 `auction_buynow_price`,
							 						 `poster_id`,
							 						 `poster_title`,
							 						 `poster_sku`,
							 						 `poster_desc`,
							 						 `poster_thumb`,
							 						 `winnerName`,
							 						 `soldamnt`,
							 						 `poster_size`,
							 						 `genre`,
							 						 `decade`,
							 						 `country`,
							 						 `cond`,
													 `is_cloud`) values
							 						 (
													  '".$dataJstFinishedAuction[$i]['auction_id']."',
							 						  '',
							 						  '".$dataJstFinishedAuction[$i]['invoice_generated_on']."',
							 						  '".$dataJstFinishedAuction[$i]['fk_auction_type_id']."',
							 						  '1',
							 						  '".$dataJstFinishedAuction[$i]['auction_asked_price']."',
							 						  '',
							 						  '".$dataJstFinishedAuction[$i]['auction_buynow_price']."',
							 						  '',
							 						  '".addslashes($dataJstFinishedAuction[$i]['poster_title'])."',
							 						  '',
							 						  '',
							 						  '".addslashes($dataJstFinishedAuction[$i]['poster_thumb'])."',
							 						  '".$dataJstFinishedAuction[$i]['winnerName']."',
							 						  '".$dataJstFinishedAuction[$i]['soldamnt']."',
							 						  '',
							 						  '',
							 						  '',
							 						  '',
							 						  '',
													  '".$dataJstFinishedAuction[$i]['is_cloud']."'
							 						 )";
                $res_sql=mysqli_query($GLOBALS['db_connect'],$sql_insert);
            }
        $objAuction->orderBy='soldamnt';
        $dataJstFinishedAuction=$objAuction->OrderBySoldPrice(true,true);

        $truncate=mysqli_query($GLOBALS['db_connect'],"TRUNCATE TABLE `tbl_temp` ");
    }else {
        $dataJstFinishedAuction=$objAuction->soldAuction(true,true,'','','','','','stills');
        $dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
    }
    if(!empty($dataJstFinishedAuction)){
        for($i=0;$i<count($dataJstFinishedAuction);$i++){
            if($dataJstFinishedAuction[$i]['is_cloud']=='0'){
                $dataJstFinishedAuction[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$dataJstFinishedAuction[$i]['poster_thumb'];
            }else{
                $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
            }
        }
        $auctionWeek= $auctionWeekObj->selectAuctionWeekStills();
        $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
        $smarty->assign("auctionWeek", $auctionWeek);
    }
    $objAuction->orderBy='invoice_generated_on';
    $smarty->assign("total", $total);
    $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=25, $end=100, $step=25, $use=1));
    $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

    
	if($_SESSION['sessAuctionView'] == 'list'){
			$smarty->display("sold_item_stills.tpl");	
	 }else{
			$smarty->display("sold_item_grid_stills.tpl");
	 }	
	


}
function search_sold_stills(){

    require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessAuctionView'])){

	}else{
		$_SESSION['sessAuctionView']='';
	}
	if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
		$_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
	}
    extract($_REQUEST);
    if(($search_sold =='' || $search_sold =='Search sold items by their title..') && $_REQUEST['auction_week']==''){
        //$_SESSION['Err']="Please enter a poster title!";
        header("location: ".PHP_SELF."?mode=stills");
        exit;
    }else{
        if($search_sold =='Search sold items by their title..'){
            $search_sold='';
        }
        $objAuction = new Auction();
        $auctionWeekObj = new AuctionWeek();
        $title=$search_sold;
        $total=$objAuction->countJstFinishedAuction(trim($title),'','','stills',$_REQUEST['auction_week']);
        if($_REQUEST['order_by']=='auction_asked_price'){
            $dataJstFinishedAuction=$objAuction->soldAuction('','',trim($title),'','','','','stills',$_REQUEST['auction_week']);
            $dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);

            for($i=0;$i<$total;$i++){
                $sql_insert="Insert into `tbl_temp` (`auction_id`,
													 `event_title`,
													 `invoice_generated_on`,
													 `fk_auction_type_id`,
													 `auction_is_sold`,
							 						 `auction_asked_price`,
							 						 `auction_reserve_offer_price`,
							 						 `auction_buynow_price`,
							 						 `poster_id`,
							 						 `poster_title`,
							 						 `poster_sku`,
							 						 `poster_desc`,
							 						 `poster_thumb`,
							 						 `winnerName`,
							 						 `soldamnt`,
							 						 `poster_size`,
							 						 `genre`,
							 						 `decade`,
							 						 `country`,
							 						 `cond`,
													 `is_cloud`) values
							 						 (
													  '".$dataJstFinishedAuction[$i]['auction_id']."',
							 						  '',
							 						  '".$dataJstFinishedAuction[$i]['invoice_generated_on']."',
							 						  '".$dataJstFinishedAuction[$i]['fk_auction_type_id']."',
							 						  '1',
							 						  '".$dataJstFinishedAuction[$i]['auction_asked_price']."',
							 						  '',
							 						  '".$dataJstFinishedAuction[$i]['auction_buynow_price']."',
							 						  '',
							 						  '".addslashes($dataJstFinishedAuction[$i]['poster_title'])."',
							 						  '',
							 						  '',
							 						  '".addslashes($dataJstFinishedAuction[$i]['poster_thumb'])."',
							 						  '".$dataJstFinishedAuction[$i]['winnerName']."',
							 						  '".$dataJstFinishedAuction[$i]['soldamnt']."',
							 						  '',
							 						  '',
							 						  '',
							 						  '',
							 						  '',
													  '".$dataJstFinishedAuction[$i]['is_cloud']."'
							 						 )";
                $res_sql=mysqli_query($GLOBALS['db_connect'],$sql_insert);
            }
            $objAuction->orderBy='soldamnt';
            $dataJstFinishedAuction=$objAuction->OrderBySoldPrice(true,true);

            $truncate=mysqli_query($GLOBALS['db_connect'],"TRUNCATE TABLE `tbl_temp` ");
        }else {
            $dataJstFinishedAuction=$objAuction->soldAuction(true,true,trim($title),'','','','','stills',$_REQUEST['auction_week']);
            $dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);
        }
        if(!empty($dataJstFinishedAuction)){
            $auctionWeek= $auctionWeekObj->selectAuctionWeekStills();
            for($i=0;$i<count($dataJstFinishedAuction);$i++){
                if($dataJstFinishedAuction[$i]['is_cloud']=='0'){
                    $dataJstFinishedAuction[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$dataJstFinishedAuction[$i]['poster_thumb'];
                }else{
                    $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataJstFinishedAuction[$i]['poster_thumb'];
                }
            }
            $smarty->assign("dataJstFinishedAuction", $dataJstFinishedAuction);
            $smarty->assign("auctionWeek", $auctionWeek);
        }
        $objAuction->orderBy='invoice_generated_on';
        $smarty->assign("total", $total);
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
        $smarty->assign('displaySortByTXT', displaySortBy("headertext"));

        
		if($_SESSION['sessAuctionView'] == 'list'){
			$smarty->display("sold_item_stills.tpl");	
	 }else{
			$smarty->display("sold_item_grid_stills.tpl");
	 }
	 
    }


}
mysqli_close($GLOBALS['db_connect']);
?>
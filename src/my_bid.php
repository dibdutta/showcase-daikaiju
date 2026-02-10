<?php  
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}
chkLoginNow();
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='losing'){
	displayList();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=='winning'){
	displayList();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=='closed'){
	closed();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=='fixed_puchases'){
	fixed_puchases();
}else{
 	displayList();
}
ob_end_flush();
	
function displayList()
{
	$type = '';
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_REQUEST['mode'])){
		$type = $_REQUEST['mode'];
	}
	$objBid = new Bid();
	if($type==''){
		$total = $objBid->countBidsNew($_SESSION['sessUserID'],$type,'active');
		$dataBid = $objBid->fetchBidDetailsNew($_SESSION['sessUserID'],$type,'active');
		$objBid->fetchMyBidByTypeNew($dataBid,$_SESSION['sessUserID'],$type,'active');
	}
	elseif($type=='winning'){
	$sql_highest="SELECT max(tb.bid_amount) as bid_amount,tb.bid_fk_auction_id from ".TBL_BID." tb ,tbl_auction_live a  
							 WHERE a.auction_id=tb.bid_fk_auction_id 
							 AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  		 AND a.auction_actual_end_datetime >= '".date('Y-m-d H:i:s')."'
					  		 AND a.auction_actual_start_datetime <= '".date('Y-m-d H:i:s')."'
					  		 AND tb.bid_is_won = '0'
							 GROUP BY tb.bid_fk_auction_id ";
		
		$sql_highest_res=mysqli_query($GLOBALS['db_connect'],$sql_highest);
		$i=0;
		while($row=mysqli_fetch_array($sql_highest_res)){
			$tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$row['bid_fk_auction_id']."' and bid_amount='".$row['bid_amount']."'";
			$tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));
		
			$counter_tot_high=$tot_counter_row_highest['0'];
			
			$sql_insert=mysqli_query($GLOBALS['db_connect'],"Insert into tbl_lossing_temp_table 
										(fk_user_id,
										 fk_auction_id,
										 total_highest,
										 highest_no) 
										 values
										 ('".$_SESSION['sessUserID']."',
										  '".$row['bid_fk_auction_id']."',
										  '".$row['bid_amount']."',
										  '".$counter_tot_high."'
										 )
										 ");
			$i++;
		}
		$sql_temp_data="Select temp_bid_id,fk_user_id,fk_auction_id from tbl_lossing_temp_table 
							   where fk_user_id='".$_SESSION['sessUserID']."'";
		$sql_temp_data_res=mysqli_query($GLOBALS['db_connect'],$sql_temp_data);
		while($row_temp=mysqli_fetch_array($sql_temp_data_res)){
			$sql_user_highest="Select b.bid_amount as user_highest_amnt ,b.is_proxy  from tbl_bid b where 
									  b.bid_fk_user_id='".$_SESSION['sessUserID']."'
									  AND b.bid_fk_auction_id='".$row_temp['fk_auction_id']."'
									  AND b.bid_amount=(SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_user_id='".$_SESSION['sessUserID']."' AND tb.bid_fk_auction_id=b.bid_fk_auction_id  GROUP BY tb.bid_fk_auction_id)
									  ";
			$sql_user_highest_data=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_user_highest));
			$update_sql=mysqli_query($GLOBALS['db_connect'],"Update tbl_lossing_temp_table 
											set user_highest='".$sql_user_highest_data['user_highest_amnt']."',
											is_proxy='".$sql_user_highest_data['is_proxy']."'
											where temp_bid_id='".$row_temp['temp_bid_id']."'
											");
			 
		}
		$total_sql="SELECT count(fk_auction_id) as counter from tbl_lossing_temp_table 
					where fk_user_id = '".$_SESSION['sessUserID']."' and user_highest > 0 AND ((user_highest > total_highest) OR (user_highest=total_highest AND highest_no >1 AND is_proxy='1') OR (user_highest=total_highest AND highest_no =1))  ";
		$total_sql_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$total_sql));
		$total=$total_sql_res['counter'];
		
		
		$sql = "SELECT tpb.amount proxy_amnt,a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, a.auction_reserve_offer_price, a.is_offer_price_percentage,
				a.auction_buynow_price, p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud
				FROM `tbl_lossing_temp_table` tl,tbl_poster_live p,".TBL_BID." b,tbl_poster_images_live pi,tbl_auction_live a
				LEFT JOIN tbl_proxy_bid_live tpb ON a.auction_id = tpb.fk_auction_id AND tpb.fk_user_id='".$_SESSION['sessUserID']."' AND tpb.is_override != '1'
				WHERE tl.fk_user_id = '".$_SESSION['sessUserID']."' and tl.user_highest > 0 AND ((tl.user_highest > tl.total_highest) OR (tl.user_highest=tl.total_highest AND tl.highest_no >1 AND tl.is_proxy='1')OR (tl.user_highest=tl.total_highest AND tl.highest_no =1))
				AND a.auction_id=tl.fk_auction_id 
				AND b.bid_fk_auction_id = a.auction_id
				AND p.poster_id = a.fk_poster_id
				AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'
				GROUP BY a.auction_id ORDER BY b.post_date desc
				";
		if(isset($_REQUEST['toshow'])){
			if(!isset($_REQUEST['offset'])){
				$offset=0;
			 }else{
				$offset=$_REQUEST['offset'];
			}
			$sql.= " LIMIT ".$offset.", ".$_REQUEST['toshow']."";
		}
		//ORDER BY b.post_date ".$this->orderType."	
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
		$dataBid=$dataArr;
	 }

	}elseif($type=='losing'){
		 $sql_highest="SELECT max(tb.bid_amount) as bid_amount,tb.bid_fk_auction_id from ".TBL_BID." tb ,tbl_auction_live a  
							 WHERE a.auction_id=tb.bid_fk_auction_id 
							 AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  		 AND a.auction_actual_end_datetime >= '".date('Y-m-d H:i:s')."'
					  		 AND a.auction_actual_start_datetime <= '".date('Y-m-d H:i:s')."'
					  		 AND tb.bid_is_won = '0'
							 GROUP BY tb.bid_fk_auction_id ";
		
		$sql_highest_res=mysqli_query($GLOBALS['db_connect'],$sql_highest);
		$i=0;
		while($row=mysqli_fetch_array($sql_highest_res)){
			$tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$row['bid_fk_auction_id']."' and bid_amount='".$row['bid_amount']."'";
			$tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));
		
			$counter_tot_high=$tot_counter_row_highest['0'];
			$sql_insert=mysqli_query($GLOBALS['db_connect'],"Insert into tbl_lossing_temp_table 
										(fk_user_id,
										 fk_auction_id,
										 total_highest,
										 highest_no) 
										 values
										 ('".$_SESSION['sessUserID']."',
										  '".$row['bid_fk_auction_id']."',
										  '".$row['bid_amount']."',
										  '".$counter_tot_high."'
										 )
										 ");
			$i++;
		}
		$sql_temp_data="Select temp_bid_id,fk_user_id,fk_auction_id from tbl_lossing_temp_table 
							   where fk_user_id='".$_SESSION['sessUserID']."'";
		$sql_temp_data_res=mysqli_query($GLOBALS['db_connect'],$sql_temp_data);
		while($row_temp=mysqli_fetch_array($sql_temp_data_res)){
			$sql_user_highest="Select b.bid_amount as user_highest_amnt ,b.is_proxy  from tbl_bid b where 
									  b.bid_fk_user_id='".$_SESSION['sessUserID']."'
									  AND b.bid_fk_auction_id='".$row_temp['fk_auction_id']."'
									  AND b.bid_amount=(SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_user_id='".$_SESSION['sessUserID']."' AND tb.bid_fk_auction_id=b.bid_fk_auction_id  GROUP BY tb.bid_fk_auction_id)
									  ";
			$sql_user_highest_data=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_user_highest));
			$update_sql=mysqli_query($GLOBALS['db_connect'],"Update tbl_lossing_temp_table 
											set user_highest='".$sql_user_highest_data['user_highest_amnt']."',
											is_proxy='".$sql_user_highest_data['is_proxy']."'
											where temp_bid_id='".$row_temp['temp_bid_id']."'
											");
			 
		}
		$total_sql="SELECT count(fk_auction_id) as counter from tbl_lossing_temp_table 
					where fk_user_id = '".$_SESSION['sessUserID']."' and user_highest>0 AND ((user_highest < total_highest) OR (user_highest=total_highest AND highest_no >1 AND is_proxy='0'))  ";
		$total_sql_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$total_sql));
		$total=$total_sql_res['counter'];
		
		
		$sql = "SELECT tpb.amount proxy_amnt,a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, a.auction_reserve_offer_price, a.is_offer_price_percentage,
				a.auction_buynow_price, p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud
				FROM `tbl_lossing_temp_table` tl,tbl_poster_live p,".TBL_BID." b,tbl_poster_images_live pi,tbl_auction_live a
				LEFT JOIN tbl_proxy_bid_live tpb ON a.auction_id = tpb.fk_auction_id AND tpb.fk_user_id='".$_SESSION['sessUserID']."' AND tpb.is_override != '1'
				WHERE tl.fk_user_id = '".$_SESSION['sessUserID']."' and tl.user_highest > 0 AND ((tl.user_highest < tl.total_highest) OR (tl.user_highest=tl.total_highest AND tl.highest_no>1 AND tl.is_proxy='0'))
				AND a.auction_id=tl.fk_auction_id 
				AND b.bid_fk_auction_id = a.auction_id
				AND p.poster_id = a.fk_poster_id
				AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'
				GROUP BY a.auction_id ORDER BY b.post_date desc
				";
		if(isset($_REQUEST['toshow'])){
			if(!isset($_REQUEST['offset'])){
				$offset=0;
			 }else{
				$offset=$_REQUEST['offset'];
			}
			$sql.= " LIMIT ".$offset.", ".$_REQUEST['toshow']."";
		}
		//ORDER BY b.post_date ".$this->orderType."	
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
		$dataBid=$dataArr;
	 }
	}
	$sql_empty_table=mysqli_query($GLOBALS['db_connect'],"TRUNCATE TABLE `tbl_lossing_temp_table`");
	$objBid->fetchMyBidByTypeNew($dataBid,$_SESSION['sessUserID'],$type,'active');	
	$objBid->fetch_BidCount_MaxBid($dataBid);
			$objBid->fetchBidsByIdNew($dataBid);
			for($i=0;$i<count($dataBid);$i++){
                if ($dataBid[$i]['is_cloud']==1){
					$dataBid[$i]['image_path']=CLOUD_POSTER_THUMB.$dataBid[$i]['poster_thumb'];               
                }else{
                    $dataBid[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataBid[$i]['poster_thumb'];
                }
				$where_bid_max=array("bid_fk_auction_id"=>$dataBid[$i]['auction_id'],"bid_amount"=>$dataBid[$i]['highest_bid']);
				$count_bid_max=$objBid->countData(TBL_BID,$where_bid_max);
				if($count_bid_max > 1){
					$dataBid[$i]['max_amount_no']=1;
				}else{
					$dataBid[$i]['max_amount_no']=0;
				}
			}
	$smarty->assign('total', $total);
	//$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($dataBid);
	
	
	$smarty->assign('bidDetails', $dataBid);
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->display('my_bids.tpl');
}
function closed(){
	require_once INCLUDE_PATH."lib/common.php";
	$type = $_REQUEST['type'];
	$objBid = new Bid();
	################ 
	
	if($type=='losing'){

		 $sql_highest="Select b.bid_amount as user_highest_amnt ,b.bid_fk_auction_id,b.is_proxy,a.auction_is_sold  from tbl_bid_archive b,tbl_auction a where 
	 						a.auction_actual_end_datetime < now() AND a.auction_is_approved = '1'
	 						AND b.bid_fk_auction_id=a.auction_id
	 						AND b.bid_fk_user_id='".$_SESSION['sessUserID']."'
	 						AND b.bid_amount=(SELECT max(tb.bid_amount) as bid_amount from tbl_bid_archive tb where tb.bid_fk_user_id='".$_SESSION['sessUserID']."' AND tb.bid_fk_auction_id=b.bid_fk_auction_id  GROUP BY tb.bid_fk_auction_id)";			  
		
		$sql_highest_res=mysqli_query($GLOBALS['db_connect'],$sql_highest);
		$i=0;
		while($row=mysqli_fetch_array($sql_highest_res)){
			
			$sql_insert=mysqli_query($GLOBALS['db_connect'],"Insert into tbl_lossing_temp_table 
										(fk_user_id,
										 fk_auction_id,
										 user_highest,
										 is_proxy,
										 is_sold) 
										 values
										 ('".$_SESSION['sessUserID']."',
										  '".$row['bid_fk_auction_id']."',
										  '".$row['user_highest_amnt']."',
										  '".$row['is_proxy']."',
										  '".$row['auction_is_sold']."'
										 )
										 ");
			$i++;
		}
		
		$sql_temp_data="Select temp_bid_id,fk_user_id,fk_auction_id from tbl_lossing_temp_table 
							   where fk_user_id='".$_SESSION['sessUserID']."'";
		
		$sql_temp_data_res=mysqli_query($GLOBALS['db_connect'],$sql_temp_data);
		while($row_temp=mysqli_fetch_array($sql_temp_data_res)){
			//$tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$row['bid_fk_auction_id']."' and bid_amount='".$row['bid_amount']."'";
			//$tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));
			$sql_user_highest="SELECT tb.bid_amount as highest_bid_amount,count(tb.bid_id) counter  from tbl_bid_archive tb   
							 	WHERE tb.bid_fk_auction_id='".$row_temp['fk_auction_id']."'
							 	AND tb.bid_amount=(SELECT max(b.bid_amount) as bid_amount from tbl_bid_archive b where  b.bid_fk_auction_id=tb.bid_fk_auction_id  GROUP BY b.bid_fk_auction_id) 
							 	";
			$sql_user_highest_data=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_user_highest));
			$update_sql=mysqli_query($GLOBALS['db_connect'],"Update tbl_lossing_temp_table 
											set total_highest='".$sql_user_highest_data['highest_bid_amount']."',
											highest_no='".$sql_user_highest_data['counter']."'
											where temp_bid_id='".$row_temp['temp_bid_id']."'
											");
			 
		}
		$total_sql="SELECT count(fk_auction_id) as counter from tbl_lossing_temp_table 
					where fk_user_id = '".$_SESSION['sessUserID']."' and user_highest > 0 AND ((user_highest < total_highest ) OR (user_highest=total_highest AND is_proxy='0' AND highest_no > 1) OR (user_highest=total_highest AND is_sold='0'))  ";
		$total_sql_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$total_sql));
		$total=$total_sql_res['counter'];
		
		
		 $sql = "SELECT tpb.amount proxy_amnt,a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, a.auction_reserve_offer_price, a.is_offer_price_percentage,
				a.auction_buynow_price, p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image
				FROM `tbl_lossing_temp_table` tl,".TBL_POSTER." p,tbl_bid_archive b,".TBL_POSTER_IMAGES." pi,".TBL_AUCTION." a
				LEFT JOIN tbl_proxy_bid tpb ON a.auction_id = tpb.fk_auction_id AND tpb.fk_user_id='".$_SESSION['sessUserID']."' AND tpb.is_override != '1'
				WHERE tl.fk_user_id = '".$_SESSION['sessUserID']."' and tl.user_highest > 0 AND ((tl.user_highest < tl.total_highest) OR (tl.user_highest=tl.total_highest AND tl.is_proxy='0' AND tl.highest_no > 1 ) OR (tl.user_highest<=tl.total_highest AND tl.is_sold='0'))
				AND a.auction_id=tl.fk_auction_id 
				AND b.bid_fk_auction_id = a.auction_id
				AND p.poster_id = a.fk_poster_id
				AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'
				GROUP BY a.auction_id ORDER BY b.post_date desc
				";
		if(isset($_REQUEST['toshow'])){
			if(!isset($_REQUEST['offset'])){
				$offset=0;
			 }else{
				$offset=$_REQUEST['offset'];
			}
			$sql.= " LIMIT ".$offset.", ".$_REQUEST['toshow']."";
		}
		//ORDER BY b.post_date ".$this->orderType."	
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $i=0;
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
                   if (file_exists("poster_photo/" . $row['poster_thumb'])){
                       $dataArr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$row['poster_thumb'];
                   }else{
                       $dataArr[$i]['image_path']=CLOUD_POSTER_THUMB.$row['poster_thumb'];
                   }
                   $i++;
			   }
            
		$dataBid=$dataArr;
	 }

	 $sql_empty_table=mysqli_query($GLOBALS['db_connect'],"TRUNCATE TABLE `tbl_lossing_temp_table`");
	}
	################
	else{
		$total = $objBid->countBidsArchive($_SESSION['sessUserID'],$type,'closed');
		$dataBid = $objBid->fetchBidDetailsArchive($_SESSION['sessUserID'],$type,'closed');
        for($i=0;$i<count($dataBid);$i++){
            if ($dataBid[$i]['is_cloud']==1){
				$dataBid[$i]['image_path']=CLOUD_POSTER_THUMB.$dataBid[$i]['poster_thumb'];
            }else{
                $dataBid[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataBid[$i]['poster_thumb'];               
            }
        }
	}
	$objBid->fetchMyBidByTypeArchive($dataBid,$_SESSION['sessUserID'],$type,'closed');

	$objBid->fetch_BidCount_MaxBidArchive($dataBid);
	$objBid->fetchBidsByIdArchive($dataBid);
	$smarty->assign('total', $total);
	
	//$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($dataBid);
	
	
	
	
	
	$smarty->assign('bidDetails', $dataBid);
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->display('my_bids_closed.tpl');
}
function fixed_puchases(){
	 require_once INCLUDE_PATH."lib/common.php"; 
    
    extract($_REQUEST);
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
    
    $offerObj = new Offer();
    $total = $offerObj->countMyAuction_OffersNew($_SESSION['sessUserID'], true);
    
    if($total>0){
        $auctionRows = $offerObj->fetchMyAuction_OffersNew($_SESSION['sessUserID'], true);
        for($i=0;$i<count($auctionRows);$i++){
            if (file_exists("poster_photo/" . $auctionRows[$i]['poster_thumb'])){
                $auctionRows[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRows[$i]['poster_thumb'];
            }else{
                $auctionRows[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRows[$i]['poster_thumb'];
            }
        }
        $offerObj->fetch_OfferCount_MaxOffer($auctionRows);
        $offerObj->fetchMyOffers($auctionRows, $_SESSION['sessUserID'],'purchases');
        $offerObj->fetchTotalOffers($auctionRows);
//        echo "<pre>";
//        print_r($auctionRows);
//        echo "</pre>";
        $posterObj = new Poster();
        $posterObj->fetchPosterCategories($auctionRows);
        

        $smarty->assign('auctionRows', $auctionRows);
        $smarty->assign('json_arr', json_encode($auctionRows));
        
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));           
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
    }
    
    $smarty->assign('total', $total);
    
    $smarty->display('my_purchases.tpl');
}
?>
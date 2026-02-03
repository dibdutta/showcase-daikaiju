<?php
/**
 * 
 * This class handles all the functions that are related to Bid module.
 *
 */
class Bid extends DBCommon{
	/**
	 * 
	 * This is a constructer of Bid Class.
	 */
	public function __construct(){		
		$this->primaryKey = 'bid_id';
		$this->orderBy = 'post_date';
		$this->orderType = 'DESC';
		parent::__construct();
	}
	
	
	function countBids($user_id = '', $type = ''){
			$sql = "SELECT COUNT(DISTINCT(a.auction_id)) AS counter
					FROM ".TBL_AUCTION." a,".TBL_BID." b
					WHERE b.bid_fk_auction_id = a.auction_id";
			if($user_id!=''){
				$sql .= " AND b.bid_fk_user_id = '".$user_id."'";
			}
			if($type == 'losing'){
				$sql .= " AND a.auction_is_sold IN ('1','2') AND a.auction_is_approved = '1'
						  AND a.auction_actual_end_datetime < '".date('Y-m-d H:i:s')."' AND b.bid_is_won = '0'";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_is_won = '1'";
			}
			
			if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   $counter = mysqli_fetch_assoc($rs);
			   return $counter['counter'];
			}
			return false;	 
		}
	function fetchBidDetails($user_id = '', $type = ''){
			$sql = "SELECT a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
					a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, a.auction_reserve_offer_price, a.is_offer_price_percentage,
					a.auction_buynow_price, p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image
					FROM ".TBL_POSTER." p,".TBL_AUCTION." a,".TBL_BID." b,".TBL_POSTER_IMAGES." pi
					WHERE b.bid_fk_auction_id = a.auction_id
					AND p.poster_id = a.fk_poster_id
					AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'";
			if($user_id!=''){
				$sql .= " AND b.bid_fk_user_id = '".$user_id."'";
			}
			if($type == 'losing'){
				$sql .= " AND a.auction_is_sold IN ('1','2') AND a.auction_is_approved = '1'
						  AND a.auction_actual_end_datetime < '".date('Y-m-d H:i:s')."' AND b.bid_is_won = '0'";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_is_won = '1'";
			}
			
			$sql .= " GROUP BY a.auction_id
					  ORDER BY b.post_date ".$this->orderType."
					  LIMIT ".$this->offset.", ".$this->toShow."";
		    //echo $sql;
		    //$sql .= " GROUP BY a.auction_id ORDER BY b.post_date desc";
			if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
			   return $dataArr;
		   }
		   return false;	 
		}
		
	function fetchMyBidByType(&$dataArr, $user_id='',$type='')
		{
			if(empty($dataArr)){
				return true;
			}
			$auctions_ids = '';
			for($i=0;$i<count($dataArr);$i++){
				$auctions_ids .= $dataArr[$i]['auction_id'].",";
			}
			$auctions_ids = trim($auctions_ids, ',');
			$sql = "SELECT b.bid_fk_auction_id,b.post_date, b.bid_is_won, b.bid_amount FROM ".TBL_BID." b
					WHERE b.bid_fk_auction_id IN (".$auctions_ids.")";
			if($user_id!=''){
			 $sql.= "and b.bid_fk_user_id=$user_id";
			}
			   if($type=='losing'){
					$sql.=" and b.bid_is_won='0'";
				}elseif($type=='winning'){
					$sql.=" and b.bid_is_won='1'";	
				}
				$sql.=" ORDER BY b.post_date DESC";
		$bidsArr = [];
		    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $bidsArr[] = $row;
			   }
		    }

			for($i=0;$i<count($dataArr);$i++){
				$flag = 0;
				for($j=0;$j<count($bidsArr);$j++){
					if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
						 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
						 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
						 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
						 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
						 $flag++;
					}
				}
				$dataArr[$i]['bids'] = $arr ?? [];

				unset($arr);
			}
		   return true;
		}
	/**
	 * 
	 * This function count no of bids by user id and type(winning or loosing).
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function countBidsNew($user_id = '', $type = '',$status=''){
		$sql = "SELECT COUNT(DISTINCT(a.auction_id)) AS counter,max(b.bid_amount)
				FROM tbl_auction_live a,".TBL_BID." b
				WHERE b.bid_fk_auction_id = a.auction_id ";
		if($status=='active'){
			$sql .= " AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  AND a.auction_actual_end_datetime >= now()
					  AND a.auction_actual_start_datetime <= now()
					  AND b.bid_is_won = '0' ";
		}
		if($status=='closed'){
			$sql .= " AND a.auction_actual_end_datetime < now() AND a.auction_is_approved = '1'
					  ";
		}
	
		if($user_id!=''){
			$sql .= " AND b.bid_fk_user_id = '".$user_id."' ";
		}
		if($status=='active'){
			if($type == 'losing'){
				//$sql .= " AND b.bid_amount < (SELECT max(bid_amount) as bid_amount_max
 											  //from tbl_bid tb where tb.bid_fk_auction_id=b.bid_fk_auction_id)";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type == 'losing'){
				$sql .= "  AND b.bid_is_won = '0' AND ((b.bid_amount < (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id))
						   OR (b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id ) AND b.is_proxy!='1') )";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_is_won = '1' ";
			}
		}
		
		//echo $sql;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;	 
	}
	/**
	 * 
	 * This function count no of bids by user id and type(winning or loosing).
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function countBidsArchive($user_id = '', $type = '',$status=''){
		$sql = "SELECT COUNT(DISTINCT(a.auction_id)) AS counter,max(b.bid_amount)
				FROM ".TBL_AUCTION." a,tbl_bid_archive b
				WHERE b.bid_fk_auction_id = a.auction_id ";
		if($status=='active'){
			$sql .= " AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  AND a.auction_actual_end_datetime >= now()
					  AND a.auction_actual_start_datetime <= now()
					  AND b.bid_is_won = '0' ";
		}
		if($status=='closed'){
			$sql .= " AND a.auction_actual_end_datetime < now() AND a.auction_is_approved = '1'
					  ";
		}
	
		if($user_id!=''){
			$sql .= " AND b.bid_fk_user_id = '".$user_id."' ";
		}
		if($status=='active'){
			if($type == 'losing'){
				//$sql .= " AND b.bid_amount < (SELECT max(bid_amount) as bid_amount_max
 											  //from tbl_bid tb where tb.bid_fk_auction_id=b.bid_fk_auction_id)";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type == 'losing'){
				$sql .= "  AND b.bid_is_won = '0' AND ((b.bid_amount < (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id))
						   OR (b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id ) AND b.is_proxy!='1') )";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_is_won = '1' ";
			}
		}
		
		//echo $sql;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;	 
	}
	
	/**
	 * 
	 * This function fetches bid details by user id and type(winning or loosing).
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function fetchBidDetailsNew($user_id = '', $type = '',$status=''){
		$sql = "SELECT tpb.amount proxy_amnt,a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, 
				a.auction_buynow_price, p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM tbl_poster_live p,".TBL_BID." b,tbl_poster_images_live pi,tbl_auction_live a 
				LEFT JOIN tbl_proxy_bid_live tpb ON a.auction_id = tpb.fk_auction_id AND tpb.fk_user_id=$user_id AND tpb.is_override != '1'
				WHERE b.bid_fk_auction_id = a.auction_id
				AND p.poster_id = a.fk_poster_id
				AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'
				
				";
		if($status=='active'){
			$sql .= " AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  AND a.auction_actual_end_datetime >= now()
					  AND a.auction_actual_start_datetime <= now()
					  AND b.bid_is_won = '0' ";
		}elseif($status=='closed'){
			$sql.=" AND a.auction_actual_end_datetime < now() AND a.auction_is_approved = '1' ";
		}
		
		if($user_id!=''){
			$sql .= " AND b.bid_fk_user_id = '".$user_id."' ";
		}
		if($status=='active'){
			if($type == 'losing'){
				//$sql .= " AND b.bid_amount < (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type == 'losing'){
					$sql .= " AND a.auction_actual_end_datetime < '".date('Y-m-d H:i:s')."' AND b.bid_is_won = '0' ";	
				}elseif($type == 'winning'){
					$sql .= " AND b.bid_is_won = '1' ";
				}
		}
		$sql .= " GROUP BY a.auction_id
				  ORDER BY b.post_date desc
				  LIMIT ".$this->offset.", ".$this->toShow."";
	
	    //echo $sql;
		//$sql .= " GROUP BY a.auction_id ORDER BY b.post_date desc";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;	 
	}
	/**
	 * 
	 * This function fetches bid details by user id and type(winning or loosing).
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function fetchBidDetailsArchive($user_id = '', $type = '',$status=''){
		$sql = "SELECT tpb.amount proxy_amnt,a.auction_id, a.fk_poster_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, a.auction_is_approved, a.auction_is_sold, 
				 p.poster_id,p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM ".TBL_POSTER." p,tbl_bid_archive b,".TBL_POSTER_IMAGES." pi,".TBL_AUCTION." a 
				LEFT JOIN tbl_proxy_bid tpb ON a.auction_id = tpb.fk_auction_id AND tpb.fk_user_id=$user_id AND tpb.is_override != '1'
				WHERE b.bid_fk_auction_id = a.auction_id
				AND p.poster_id = a.fk_poster_id
				AND pi.fk_poster_id = p.poster_id and pi.is_default = '1'
				
				";
		if($status=='active'){
			$sql .= " AND a.auction_is_sold ='0' AND a.auction_is_approved = '1'
					  AND a.auction_actual_end_datetime >= now()
					  AND a.auction_actual_start_datetime <= now()
					  AND b.bid_is_won = '0' ";
		}elseif($status=='closed'){
			$sql.=" AND a.auction_actual_end_datetime < now() AND a.auction_is_approved = '1' ";
		}
		
		if($user_id!=''){
			$sql .= " AND b.bid_fk_user_id = '".$user_id."' ";
		}
		if($status=='active'){
			if($type == 'losing'){
				//$sql .= " AND b.bid_amount < (SELECT max(tb.bid_amount) as bid_amount from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";	
			}elseif($type == 'winning'){
				$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount from tbl_bid_archive tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type == 'losing'){
					$sql .= " AND a.auction_actual_end_datetime < '".date('Y-m-d H:i:s')."' AND b.bid_is_won = '0' ";	
				}elseif($type == 'winning'){
					$sql .= " AND b.bid_is_won = '1' ";
				}
		}
		$sql .= " GROUP BY a.auction_id
				  ORDER BY b.post_date desc
				  LIMIT ".$this->offset.", ".$this->toShow."";
	
	    //echo $sql;
		//$sql .= " GROUP BY a.auction_id ORDER BY b.post_date desc";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;	 
	}
	/**
	 * 
	 * This function fetches bid details by user id and auction id.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 */
	
	function fetchMyBids(&$dataArr, $user_id, $type='')
	{
		if(empty($dataArr)){
			return true;
		}
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		$sql = " SELECT b.bid_fk_auction_id,b.post_date, b.bid_is_won, b.bid_amount FROM ".TBL_BID." b
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") and b.bid_fk_user_id=$user_id ";
			if($type=='losing'){
				$sql.=" and b.bid_is_won='0'";
			}elseif($type=='winning'){
				$sql.=" and b.bid_is_won='1'";	
			}
			$sql.=" ORDER BY b.post_date DESC";
	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $flag++;
				}
			}
			$dataArr[$i]['bids'] = $arr ?? [];

			unset($arr);
		}
	   return true;
	}
	
	/**
	 * 
	 * This function fetches bid details by user id and auction id and type.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched. 
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function fetchMyBidByTypeNew(&$dataArr, $user_id='',$type='',$status='')
	{
		if(empty($dataArr)){
			return true;
		}
		$auctions_ids='';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		$sql = "SELECT b.bid_fk_auction_id,b.bid_id,b.post_date, b.bid_is_won, max(b.bid_amount) as bid_amount,b.is_proxy FROM ".TBL_BID." b 
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") AND b.bid_amount= (select max(bid_amount)
                     from tbl_bid tb
                    where tb.bid_fk_user_id = b.bid_fk_user_id and b.bid_fk_user_id=$user_id and tb.bid_fk_auction_id=b.bid_fk_auction_id
                    )";
		//if($user_id!=''){
		// $sql.= " and b.bid_fk_user_id=$user_id ";
		//}
		if($status=='active'){
		   if($type=='losing'){
				//$sql.=" and b.bid_is_won='0'";
			}elseif($type=='winning'){
				//$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount_high from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type=='losing'){
				$sql.=" and b.bid_is_won='0'";
			}elseif($type=='winning'){
				$sql.=" and b.bid_is_won='1'";	
			}
		}	
			$sql.=" GROUP BY b.bid_fk_auction_id ";
			//echo $sql;
	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $flag++;
				}
			}
			$dataArr[$i]['bids'] = $arr ?? [];

			unset($arr);
		}
	   return true;
	}

	/**
	 *
	 * This function fetches bid details by user id and auction id and type.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 * @param $user_id=>This paramter defines the user id,means whoose bid details to be fetched.
	 * @param $type=>This parameter defines the type of bids(winning or loosing).
	 */
	function fetchMyBidByTypeArchive(&$dataArr, $user_id='',$type='',$status='')
	{
		if(empty($dataArr)){
			return true;
		}
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		$sql = "SELECT b.bid_fk_auction_id,b.bid_id,b.post_date, b.bid_is_won, max(b.bid_amount) as bid_amount,b.is_proxy FROM tbl_bid_archive b 
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") AND b.bid_amount= (select max(bid_amount)
                     from tbl_bid_archive tb
                    where tb.bid_fk_user_id = b.bid_fk_user_id and b.bid_fk_user_id=$user_id and tb.bid_fk_auction_id=b.bid_fk_auction_id
                    )";
		//if($user_id!=''){
		// $sql.= " and b.bid_fk_user_id=$user_id ";
		//}
		if($status=='active'){
		   if($type=='losing'){
				//$sql.=" and b.bid_is_won='0'";
			}elseif($type=='winning'){
				//$sql .= " AND b.bid_amount = (SELECT max(tb.bid_amount) as bid_amount_high from ".TBL_BID." tb where tb.bid_fk_auction_id=a.auction_id  GROUP BY tb.bid_fk_auction_id)";
			}
		}elseif($status=='closed'){
			if($type=='losing'){
				$sql.=" and b.bid_is_won='0'";
			}elseif($type=='winning'){
				$sql.=" and b.bid_is_won='1'";	
			}
		}	
			$sql.=" GROUP BY b.bid_fk_auction_id ";
			//echo $sql;
	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $flag++;
				}
			}
			$dataArr[$i]['bids'] = $arr ?? [];

			unset($arr);
		}
	   return true;
	}
	function fetchBidsByIdNew(&$dataArr)
	{
		if(empty($dataArr)){
			return $dataArr;
		}
		$auctions_ids='';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		 $sql = "SELECT ut.firstname,ut.username,ut.lastname,b.bid_fk_auction_id,b.post_date,b.is_proxy, b.bid_is_won, b.bid_amount FROM ".TBL_BID." b,".USER_TABLE." ut
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") and ut.user_id=b.bid_fk_user_id and b.bid_amount!=0  ORDER BY b.bid_amount  DESC ";

	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['user_name'] = $bidsArr[$j]['username'];
					 $arr[$flag]['username'] = $bidsArr[$j]['firstname'].' '.$bidsArr[$j]['lastname'];
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $flag++;
				}

			}
			$dataArr[$i]['bid_popup'] = $arr ?? [];
			unset($arr);
		}
		return $dataArr;
	   return true;
	}
	function fetchBidsByIdArchive(&$dataArr)
	{
		if(empty($dataArr)){
			return $dataArr;
		}
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		 $sql = "SELECT ut.firstname,ut.username,ut.lastname,b.bid_fk_auction_id,b.post_date,b.is_proxy, b.bid_is_won, b.bid_amount FROM tbl_bid_archive b,".USER_TABLE." ut
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") and ut.user_id=b.bid_fk_user_id and b.bid_amount!=0  ORDER BY b.bid_amount  DESC ";

	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['user_name'] = $bidsArr[$j]['username'];
					 $arr[$flag]['username'] = $bidsArr[$j]['firstname'].' '.$bidsArr[$j]['lastname'];
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $flag++;
				}

			}
			$dataArr[$i]['bid_popup'] = $arr ?? [];
			unset($arr);
		}
		return $dataArr;
	   return true;
	}

	function fetchBidsByIdArchiveS(&$dataArr)
	{
		if(empty($dataArr)){
			return $dataArr;
		}
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		 $sql = "SELECT ut.firstname,ut.username,ut.lastname,b.bid_fk_auction_id,b.post_date,b.is_proxy, b.bid_is_won, b.bid_amount FROM tbl_bid_archive b,".USER_TABLE." ut
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") and ut.user_id=b.bid_fk_user_id and b.bid_amount!=0  ORDER BY b.bid_amount  DESC ";

	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['user_name'] = $bidsArr[$j]['username'];
					 $arr[$flag]['username'] = $bidsArr[$j]['firstname'].' '.$bidsArr[$j]['lastname'];
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $flag++;
				}

			}
			$dataArr[$i]['bids'] = $arr ?? [];
			unset($arr);
		}
		return $dataArr;
	   return true;
	}
	/**
	 *
	 * This function fetches bid details by bid id.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 */
	function fetchBidsById(&$dataArr)
	 {
		if(empty($dataArr)){
			return true;
		}
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		 $sql = "SELECT ut.firstname,ut.lastname,b.bid_fk_auction_id,b.post_date,b.is_proxy, b.bid_is_won, b.bid_amount FROM ".TBL_BID." b,".USER_TABLE." ut
				WHERE b.bid_fk_auction_id IN (".$auctions_ids.") and ut.user_id=b.bid_fk_user_id and b.bid_amount!=0  ORDER BY b.bid_amount DESC";

	    $bidsArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidsArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($bidsArr);$j++){
				if($dataArr[$i]['auction_id'] == $bidsArr[$j]['bid_fk_auction_id']){
					 $arr[$flag]['username'] = $bidsArr[$j]['firstname'].' '.$bidsArr[$j]['lastname'];
					 $arr[$flag]['post_date'] = formatDateTime($bidsArr[$j]['post_date']);
					 $arr[$flag]['bid_is_won'] = $bidsArr[$j]['bid_is_won'];
					 $arr[$flag]['bid_amount'] = $bidsArr[$j]['bid_amount'];
					 $arr[$flag]['bid_time'] = $bidsArr[$j]['post_date'];
					 $arr[$flag]['is_proxy'] = $bidsArr[$j]['is_proxy'];
					 $flag++;
				}
			}
			$dataArr[$i]['bids'] = $arr ?? [];
			return $dataArr;
			unset($arr);
		}
	   return true;
	}
	/**
	 *
	 * This function fetches the no of bids correspondent to an auction and also the highest bid.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 */
	function fetch_BidCount_MaxBid(&$dataArr)
	{
		if(empty($dataArr)){
			return true;
		}
		$auction_ids='';
		for($i=0;$i<count($dataArr);$i++){
			$auction_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auction_ids = trim($auction_ids, ',');

		 $sql = "SELECT bid_fk_auction_id, count(bid_id) AS counter, max(bid_amount) AS highest_bid
				FROM ".TBL_BID." WHERE bid_fk_auction_id IN (".$auction_ids.") GROUP BY bid_fk_auction_id";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   for($i=0;$i<count($dataArr);$i++){
					if($dataArr[$i]['auction_id'] == $row['bid_fk_auction_id']){
						$dataArr[$i]['count_bid'] = $row['counter'];
						$dataArr[$i]['highest_bid'] = $row['highest_bid'];
						break;
					}
			   }
		   }
	    }
		
		/*for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT count(bid_id) AS counter, max(bid_amount) AS highest_bid
					FROM ".TBL_BID." WHERE bid_fk_auction_id = '".$dataArr[$i]['auction_id']."'";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			$row = mysqli_fetch_assoc($rs);
			$dataArr[$i]['count_bid'] = $row['counter'];
			$dataArr[$i]['highest_bid'] = $row['highest_bid'];
		}*/
		return true;
	}
	/**
	 * 
	 * This function fetches the no of bids correspondent to an auction and also the highest bid.
	 * @param $dataArr=>This parameter contains the array of auction details from which we will get the auction id.
	 */
	function fetch_BidCount_MaxBidArchive(&$dataArr)
	{
		if(empty($dataArr)){
			return true;
		}
		$auction_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auction_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auction_ids = trim($auction_ids, ',');

		 $sql = "SELECT bid_fk_auction_id, count(bid_id) AS counter, max(bid_amount) AS highest_bid
				FROM tbl_bid_archive WHERE bid_fk_auction_id IN (".$auction_ids.") GROUP BY bid_fk_auction_id";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   for($i=0;$i<count($dataArr);$i++){
					if($dataArr[$i]['auction_id'] == $row['bid_fk_auction_id']){
						$dataArr[$i]['count_bid'] = $row['counter'];
						$dataArr[$i]['highest_bid'] = $row['highest_bid'];
						break;
					}
			   }
		   }
	    }
		
		/*for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT count(bid_id) AS counter, max(bid_amount) AS highest_bid
					FROM ".TBL_BID." WHERE bid_fk_auction_id = '".$dataArr[$i]['auction_id']."'";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			$row = mysqli_fetch_assoc($rs);
			$dataArr[$i]['count_bid'] = $row['counter'];
			$dataArr[$i]['highest_bid'] = $row['highest_bid'];
		}*/
		return true;
	}
	
	function fetchWinningBidByAuctionID(&$auctionRow)
	{
		$auction_id = $auctionRow['auction_id'] ?? '';
		$sql = "SELECT * FROM ".TBL_BID." WHERE bid_fk_auction_id = '".$auction_id."'";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		$auctionRow['won_bid'] = $row;
	}
function fetchProxyBids(&$dataArr){
		for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT amount
				FROM `tbl_proxy_bid` WHERE fk_auction_id = '".$dataArr[$i]['auction_id']."' and fk_user_id='".($_SESSION['sessUserID'] ?? '')."'";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				$row = mysqli_fetch_assoc($rs);
				$counter=$row['amount'];
				if($counter > 0){
				$dataArr[$i]['proxy_amnt'] = $counter;
				}else{
				$dataArr[$i]['proxy_amnt'] = '0.00';	
				}
		}		
	   return true;
	}
	function fetchProxyBidsInAdmin($auction_id){
	  if(($_REQUEST['type'] ?? '')=='sold'){
	  		$sql = "SELECT
					  u.firstname,
					  u.lastname,
					  tp.amount,
					  tp.proxy_date,
					  MAX(b.bid_amount) AS bid_amount,
					  b.post_date
					FROM user_table u,
					  tbl_bid_archive b  
					  LEFT JOIN tbl_proxy_bid tp
						ON b.bid_fk_auction_id=tp.fk_auction_id   AND b.bid_fk_user_id  = tp.fk_user_id  AND tp.is_override = '0'
					WHERE  
						b.bid_fk_user_id = u.user_id   
						AND b.bid_fk_auction_id = '".$auction_id."'
						AND b.bid_amount = (SELECT
                          MAX(ntb.bid_amount)
                        FROM tbl_bid_archive ntb
                        WHERE ntb.bid_fk_auction_id = '".$auction_id."'
                        AND ntb.bid_fk_user_id = u.user_id
                        GROUP BY ntb.bid_fk_user_id)
						GROUP BY b.bid_fk_user_id";
	  }else{
	  		$sql = "SELECT
					  u.firstname,
					  u.lastname,
					  tp.amount,
					  tp.proxy_date,
					  MAX(b.bid_amount) AS bid_amount,
					  b.post_date
					FROM user_table u,
					  tbl_bid b  
					  LEFT JOIN tbl_proxy_bid tp
						ON b.bid_fk_auction_id=tp.fk_auction_id   AND b.bid_fk_user_id  = tp.fk_user_id  AND tp.is_override = '0'
					WHERE  
						b.bid_fk_user_id = u.user_id   
						AND b.bid_fk_auction_id = '".$auction_id."'
						AND b.bid_amount = (SELECT
                          MAX(ntb.bid_amount)
                        FROM tbl_bid ntb
                        WHERE ntb.bid_fk_auction_id = '".$auction_id."'
                        AND ntb.bid_fk_user_id = u.user_id
                        GROUP BY ntb.bid_fk_user_id)
						GROUP BY b.bid_fk_user_id";
	  }
			 
			if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   		while($row = mysqli_fetch_assoc($rs)){
			   		$bidsArr[] = $row;
		   }
	    }
	    return $bidsArr;
	}
//	function fetchBidsDetailsForTooltip(){

 //}
}

?>
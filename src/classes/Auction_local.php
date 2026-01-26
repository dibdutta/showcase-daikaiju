<?php
/**
 * 
 * This class handles all the functions that are related to auction module.
 *
 */
class Auction extends DBCommon{
	
	/**
	* 
	* This is a constructer of Auction Class.
	*/
	
	public function __construct(){
		parent::__construct();
		
		$this->primaryKey = 'auction_id';
		if($this->orderBy == ''){		
			$this->orderBy = 'auction_id';
		}
		if($this->orderType == ''){
			$this->orderType = 'DESC';
		}
	}
	
	/*********************** All available auctions for front-end ***********************/
	
	/**
		 * 
		 * This function counts the no. of auctions that are in selling state and available for bidding.
		 * @param $fetch=>This paramter defines what type of auctions to be fetched(as fixed,weekly,monthly or all). 
		 */
	function countLiveAuctions($fetch = '',$auction_week_id = '')
	{
		/*$sql = "SELECT count(a.auction_id) AS counter
				FROM ".TBL_AUCTION." a 
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE 1 AND pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart <> '1' ";*/
		if($fetch != ('weekly' || 'extended')){
			$sql = "SELECT count(a.auction_id) AS counter
				FROM tbl_auction a 				
				WHERE a.auction_is_approved = '1'   ";
		}elseif($fetch == 'extended'){
			$sql = "SELECT count(a.auction_id) AS counter
				FROM tbl_auction_live a,tbl_auction_week tw
				WHERE  a.fk_auction_week_id = tw.auction_week_id 
				AND (UNIX_TIMESTAMP(tw.auction_week_end_date) - UNIX_TIMESTAMP()) <= 0 ";
		}else{
			$sql = "SELECT count(a.auction_id) AS counter
				FROM tbl_auction_live a 
				WHERE  1 ";
		}
			
		if($fetch == 'fixed'){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND a.fk_auction_type_id = '1'  ";
		}elseif($fetch == 'weekly'){
			$sql .= " AND a.auction_is_sold ='0' AND ((a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}elseif($fetch == 'extended'){
			$sql .= " AND a.auction_is_sold ='0' AND ((a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}/*elseif($fetch == 'stills'){
			$sql .= " AND (a.fk_auction_type_id = '5' 
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}*/elseif($fetch == 'stills'){
			$sql .= " AND (a.fk_auction_type_id = '4' 
					AND a.auction_is_sold IN ('0','3'))";
		}elseif($fetch == 'monthly'){
			$sql .= " AND a.auction_is_sold ='0' AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1' 
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}elseif($fetch == 'alternative'){
			$sql .= "  AND a.fk_auction_type_id = '6'  ";
		}else{
			$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id IN ('1','6') end AND a.auction_is_sold IN ('0','3')  ";		
		}
		
		if($auction_week_id!='')	{
	   		$sql .= " AND a.fk_auction_week_id = ".$auction_week_id;
	   }
	//$sql .= " GROUP BY a.auction_id ";
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
	   }
	   return false;
	}
	
	function countLiveAuctionsForProxy($fetch = '')
		{
			$sql = "SELECT count(a.auction_id) AS counter
					FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id WHERE  p.fk_user_id <> '".$_SESSION['sessUserID']."' ";
				
			if($fetch == 'fixed'){
				$sql .= " AND (a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
			}elseif($fetch == 'weekly'){
				$sql .= " AND (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
			}elseif($fetch == 'monthly'){
				$sql .= " AND (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
			}else{
				$sql .= " AND (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))
						OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))  ";		
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
	 * This function fetches the auctions that are in selling state and available for bidding.
	 * @param $fetch=>This paramter defines what type of auctions to be fetched(as fixed,weekly,monthly or all). 
	 */
	function fetchLiveAuctions($fetch = '', $poster_ids = '',$view_mode='',$auction_week_id= '')
	{
        if(!isset($_SESSION['sessUserID'])){
            $user_id='';
        }else{
            $user_id=$_SESSION['sessUserID'];
        }
        if($view_mode=='list'){
			if($fetch == 'weekly'){				
				$sql = "SELECT
						   c.cat_value AS poster_size,
						   c1.cat_value AS genre,
						   c2.cat_value AS decade,
						   poster_size_auction(p.poster_id) AS country,
						   cond_auction(p.poster_id) AS cond,
						   tw.watching_id AS watch_indicator,
						   a.auction_id,						   
						   a.fk_auction_type_id,
						   a.auction_asked_price,	 
						   a.fk_auction_week_id ,
						   a.auction_actual_start_datetime,
						   a.imdb_link,
						  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
						  a.auction_actual_end_datetime,
						  a.auction_is_sold,					  
						  aw.auction_week_title,
						  p.poster_id,
						  p.fk_user_id,
						  p.poster_title,
						  u.username,
						  pi.poster_thumb,
						  pi.is_cloud,
						  a.max_bid_amount AS last_bid_amount
						  FROM
								".USER_TABLE." u,tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
												  INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id											  
												  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
												  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
												  INNER JOIN (tbl_poster_to_category_live ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category_live ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category_live ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
	
														  WHERE pi.is_default = '1'
														  AND a.auction_is_approved = '1'
														  AND a.in_cart <> '1' 
														  AND u.user_id = p.fk_user_id
														 ";
				
			}else{
				$sql = "SELECT
						   c.cat_value AS poster_size,
						   c1.cat_value AS genre,
						   c2.cat_value AS decade,
						   poster_size(p.poster_id) AS country,
						   cond(p.poster_id) AS cond,
						   tw.watching_id AS watch_indicator,
						   a.auction_id,
						   a.is_reopened,
						   a.fk_auction_type_id,
						   a.auction_asked_price,
						   a.auction_reserve_offer_price,
						   a.fk_event_id ,
						   a.fk_auction_week_id ,
						   a.is_offer_price_percentage,
						   a.auction_buynow_price,
						   a.auction_actual_start_datetime,
						   a.imdb_link,
						  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
						  a.auction_actual_end_datetime,
						  a.auction_is_sold,					  
						  aw.auction_week_title,
						  p.poster_id,
						  p.fk_user_id,
						  p.poster_title,
						  u.username,
						  pi.poster_thumb,
						  pi.is_cloud,
						  a.max_bid_amount AS last_bid_amount
						  FROM
								".USER_TABLE." u,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
												  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id											  
												  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
												  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
												  INNER JOIN (tbl_poster_to_category ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
	
														  WHERE pi.is_default = '1'
														  AND a.auction_is_approved = '1'
														  AND a.in_cart <> '1' 
														  AND u.user_id = p.fk_user_id
														 ";
				}
        }else{
			if($fetch=='alternative' || $fetch==''){
				

            	$sql = "SELECT
					   c.cat_value AS poster_size,
                       tw.watching_id AS watch_indicator,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.auction_reserve_offer_price,
					   a.fk_event_id ,
					   a.fk_auction_week_id ,
					   a.is_offer_price_percentage,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  e.event_title,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud,
					  p.artist,
					  p.quantity,
					  p.field_1,
					  p.field_2,
					  p.field_3,
					  a.max_bid_amount AS last_bid_amount
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
											  INNER JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.in_cart <> '1'
													  
													 ";

        
		
		}else{
		
			if($fetch == 'weekly'){
				$sql = "SELECT
                       tw.watching_id AS watch_indicator,
					   a.auction_id,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.fk_auction_week_id ,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud,
					  a.max_bid_amount AS last_bid_amount
					  FROM
							tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
											  INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'									  

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.in_cart <> '1'
													 ";
		
		}elseif($fetch == 'extended'){
			$sql = "SELECT
				   tw.watching_id AS watch_indicator,
				   a.auction_id,
				   a.fk_auction_type_id,
				   a.auction_asked_price,
				   a.fk_auction_week_id ,
				   a.auction_actual_start_datetime,
				  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				  a.auction_actual_end_datetime,
				  aw.auction_week_title,
				  p.poster_id,
				  p.fk_user_id,
				  p.poster_title,
				  pi.poster_thumb,
				  pi.is_cloud,
				  a.max_bid_amount AS last_bid_amount
				  FROM
						tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
										  INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
										  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
										  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'									  

												  WHERE pi.is_default = '1'
												  AND (UNIX_TIMESTAMP(aw.auction_week_end_date) - UNIX_TIMESTAMP()) <= 0
												  AND a.auction_is_approved = '1'
												  AND a.in_cart <> '1'
												 ";
	
	}else{
			$sql = "SELECT
                       tw.watching_id AS watch_indicator,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.auction_reserve_offer_price,
					   a.fk_event_id ,
					   a.fk_auction_week_id ,
					   a.is_offer_price_percentage,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  e.event_title,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud,
					  a.max_bid_amount AS last_bid_amount
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
											  

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.in_cart <> '1'
													 ";
		
		    }

            
          }
		}
			
		if($fetch == 'fixed'){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND a.fk_auction_type_id = '1'  ";
		}elseif($fetch == 'weekly'){
			$sql .= "  AND ( a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($fetch == 'extended'){
			$sql .= "  AND ( a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}/*elseif($fetch == 'stills'){
			$sql .= " AND (a.fk_auction_type_id = '5' 
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
					
		}*/elseif($fetch == 'stills'){
			$sql .= " AND (a.fk_auction_type_id = '4' 
					AND a.auction_is_sold IN ('0','3'))";
					
		}elseif($fetch == 'alternative'){
			$sql .= "  AND a.fk_auction_type_id = '6'  ";
		}elseif($fetch == 'monthly'){
		 	$sql .= " AND a.auction_is_sold ='0' AND (a.fk_auction_type_id = '3' 
						   AND a.is_approved_for_monthly_auction = '1' 
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}else{
			if($view_mode=='list'){
				$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end AND a.auction_is_sold IN ('0','3') ";	
			}else{
				$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id IN ('1','6') end AND a.auction_is_sold IN ('0','3') ";	
			}	
		}
		if($fetch == 'monthly'){
			//$this->orderBy=" a.auction_id ";
		}
		if($fetch == 'weekly'){
			//$this->orderBy=" a.auction_id ";
		}
		
		if($auction_week_id!='')	{
	   		$sql .= " AND a.fk_auction_week_id = ".$auction_week_id;
	    }
		
		$orderBy=$this->orderBy;
        if($orderBy=="auction_actual_end_datetime"){
            $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date when a.fk_auction_type_id ='4' then  p.up_date   else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="poster_title"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY p.poster_title ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_bid_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_asked_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY a.auction_asked_price ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="shuffle"){
			$sql .= " GROUP BY a.auction_id
				  ORDER BY rand()
				  LIMIT ".$this->offset.", ".$this->toShow."";
			}
		else{
			if($fetch == 'fixed' ){
				/*$sql .= " GROUP BY a.auction_id
				  ORDER BY rand()
				  LIMIT ".$this->offset.", ".$this->toShow."";*/
				$sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";  
			}elseif($fetch == 'alternative' || $fetch == 'stills'){
				$sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
			}elseif($fetch == ''){
				$sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
			}else{
			   if(SHORT_TYPE=='2'){
					$sql .= " GROUP BY a.auction_id
						  ORDER BY last_bid_amount ".$this->orderType.",a.auction_id ".$this->orderType."
						  LIMIT ".$this->offset.", ".$this->toShow."";
				}elseif(SHORT_TYPE=='1'){	  
					$sql .= " GROUP BY a.auction_id
						  ORDER BY ".$this->orderBy." ".$this->orderType."
						  LIMIT ".$this->offset.", ".$this->toShow."";
				  }
			}
        
           
        }
		//echo 	$sql;	
		//die();
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	}	
	
	
	function fetchLiveAuctionsForProxy($fetch = '', $poster_ids = '')
		{
		/*$sql = "SELECT a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, e.event_title,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,
				COUNT(b.bid_id) AS bid_count, max(b.bid_amount) AS last_bid_amount, max(b.post_date) AS last_bid_post_date,
				COUNT(o.offer_id) AS offer_count, max(o.offer_amount) AS last_offer_amount, max(o.post_date) AS last_offer_post_date
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
				WHERE pi.is_default = '1' ";*/
				
		$sql = "SELECT a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				a.auction_actual_end_datetime, e.event_title, aw.auction_week_title,
				p.poster_id, p.fk_user_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				WHERE pi.is_default = '1' AND p.fk_user_id <> '".$_SESSION['sessUserID']."' ";
			
		if($fetch == 'fixed'){
			$sql .= " AND (a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($fetch == 'weekly'){
			$sql .= " AND (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($fetch == 'monthly'){
		 	$sql .= " AND (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1'
						   AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}else{
			$sql .= " AND (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())
					OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())  ";		
		}
		
		

		 $sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   $this->fetchHighestOfferCountOffer($dataArr);
		   $this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	}
	/* Search starts here */
	
	
	function searchPosterIds($list='',$auction_week_id='')
	{
        if(isset($_REQUEST['keyword'])){
            $keyword=$_REQUEST['keyword'];
        }else{
            $keyword ='';
            $_REQUEST['keyword']='';
        }
        $srcFlag = '';
        if($list==''){
            $qry = "  AND a.auction_is_approved = '1'
                      AND a.auction_is_sold IN ('0','3')
                      AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end ";

        }elseif($list=='fixed'){
            $qry = "  AND a.auction_is_approved = '1'
                      AND a.auction_is_sold IN ('0','3')
                      AND a.fk_auction_type_id ='1'  ";
        }elseif($list=='weekly'){
            $qry = "  AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() ";
        }elseif($list=='monthly'){
            $qry = "  AND a.auction_is_approved = '1'
                      AND a.auction_is_sold = '0'
                      AND a.fk_auction_type_id ='3' AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() AND a.is_approved_for_monthly_auction = '1' ";
        }elseif($list=='upcoming'){
            $qry = "  
                      AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime > now() ) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime > now()  and a.is_approved_for_monthly_auction = '1')   end ";
        }/*elseif($list == 'stills'){			
			$qry .= " AND (a.fk_auction_type_id = '5' 
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))
					  AND a.auction_is_sold = '0'
					  AND a.auction_is_approved = '1' ";
		}*/elseif($list == 'stills'){			
			$qry .= " AND (a.fk_auction_type_id = '4' 
					  AND a.auction_is_sold IN ('0','3')
					  AND a.auction_is_approved = '1' ";
		}
		$qry .= " AND a.in_cart='0' ";
		if($auction_week_id!=''){
				$qry .= " AND a.fk_auction_week_id ='".$auction_week_id."' ";
			}
		if(isset($_REQUEST['poster_size_id']) && $_REQUEST['poster_size_id'] != '' && $_REQUEST['keyword'] == ''){
		    if($list=='weekly'){			
			
					$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_images_live pi, tbl_auction_live a
							WHERE ptc.fk_poster_id = a.fk_poster_id
							AND pi.fk_poster_id = a.fk_poster_id
							AND pi.is_default='1'
							AND ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."'";
					$sql .= $qry;
					$rs = mysqli_query($GLOBALS['db_connect'],$sql);
					while($row = mysqli_fetch_array($rs)){
						$size_poster_ids[] = $row['fk_poster_id'];
					}
		
					if(is_array($size_poster_ids)){
						$poster_ids = implode(',', $size_poster_ids);
						$srcFlag = '1';
					}else{
						return;
					}
				
			}else{
			
					$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
							WHERE ptc.fk_poster_id = a.fk_poster_id
							AND pi.fk_poster_id = a.fk_poster_id
							AND pi.is_default='1'
							AND ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."'";
					$sql .= $qry;
					$rs = mysqli_query($GLOBALS['db_connect'],$sql);
					while($row = mysqli_fetch_array($rs)){
						$size_poster_ids[] = $row['fk_poster_id'];
					}
		
					if(is_array($size_poster_ids)){
						$poster_ids = implode(',', $size_poster_ids);
						$srcFlag = '1';
					}else{
						return;
					}
				}
        }elseif(isset($_REQUEST['poster_size_id']) && $_REQUEST['poster_size_id'] != '' && $_REQUEST['keyword'] != ''){
		 	if($list=='weekly'){
				
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_live p,tbl_poster_images_live pi, tbl_auction_live a
					WHERE ptc.fk_poster_id = a.fk_poster_id
					AND  p.poster_id = a.fk_poster_id
					AND  pi.fk_poster_id = a.fk_poster_id					
					AND pi.is_default='1'  ";
				$sql .= $qry;
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
					
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
					
				
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$size_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($size_poster_ids)){
					$poster_ids = implode(',', $size_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			
			}else{
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
					WHERE ptc.fk_poster_id = a.fk_poster_id
					AND  p.poster_id = a.fk_poster_id
					AND  pi.fk_poster_id = a.fk_poster_id	
					AND pi.is_default='1'  ";
				$sql .= $qry;
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
				
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$size_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($size_poster_ids)){
					$poster_ids = implode(',', $size_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}
        }

        if(isset($_REQUEST['genre_id']) && $_REQUEST['genre_id'] != '' && $_REQUEST['keyword'] == ''){
			if($list=='weekly'){
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_images_live pi, tbl_auction_live a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND pi.fk_poster_id = a.fk_poster_id
						AND pi.is_default='1'
						AND ptc.fk_cat_id = '".$_REQUEST['genre_id']."'";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}else{
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND pi.fk_poster_id = a.fk_poster_id
						AND pi.is_default='1'
						AND ptc.fk_cat_id = '".$_REQUEST['genre_id']."'";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}
        }elseif(isset($_REQUEST['genre_id']) && $_REQUEST['genre_id'] != '' && $_REQUEST['keyword'] != ''){
		  if($list=='weekly'){
		  		$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_live p,tbl_poster_images_live pi, tbl_auction_live a
					WHERE ptc.fk_poster_id = a.fk_poster_id
					AND  p.poster_id = a.fk_poster_id
					AND  pi.fk_poster_id = a.fk_poster_id
					AND pi.is_default='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['genre_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
					
				
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

		  }else{
		  		$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
					WHERE ptc.fk_poster_id = a.fk_poster_id
					AND  p.poster_id = a.fk_poster_id
					AND  pi.fk_poster_id = a.fk_poster_id
					AND pi.is_default='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['genre_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
					
				
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

           }
        }

        if(isset($_REQUEST['decade_id']) && $_REQUEST['decade_id'] != '' &&  $_REQUEST['keyword'] == ''){
			if($list=="weekly"){
				
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc, tbl_auction_live a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['decade_id']."'";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
        
			}else{
		
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_AUCTION." a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['decade_id']."'";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}
        }elseif(isset($_REQUEST['decade_id']) && $_REQUEST['decade_id'] != '' && $_REQUEST['keyword'] != ''){
			if($list=="weekly"){
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_live p,tbl_poster_images_live pi, tbl_auction_live a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id						
						AND pi.is_default ='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['decade_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";

				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}else{
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id						
						AND pi.is_default ='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['decade_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";

				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}
        }

        if(isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != '' && $_REQUEST['keyword'] == ''){
			if($list=="weekly"){
				
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc, tbl_auction_live a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['country_id']."'
						";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$country_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($country_poster_ids)){
					$poster_ids = implode(',', $country_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
        
			}else{
				
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_AUCTION." a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['country_id']."'
						";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$country_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($country_poster_ids)){
					$poster_ids = implode(',', $country_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
        
			}
		
		}elseif(isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != '' && $_REQUEST['keyword'] != ''){
			if($list=="weekly"){

					$sql = "SELECT distinct(ptc.fk_poster_id) FROM tbl_poster_to_category_live ptc,tbl_poster_live p,tbl_poster_images_live pi, tbl_auction_live a
							WHERE ptc.fk_poster_id = a.fk_poster_id
							AND  p.poster_id = a.fk_poster_id
							AND  pi.fk_poster_id = a.fk_poster_id							
							AND pi.is_default ='1' ";
					$sql .= $qry;
					if($poster_ids != ""){
						$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
					}
					$split_stemmed = explode(" ",$keyword);
					$sql .= " AND ( ";
					
					$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['country_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
						
					$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
					$sql.= " ) ";
					$rs = mysqli_query($GLOBALS['db_connect'],$sql);
					while($row = mysqli_fetch_array($rs)){
						$country_poster_ids[] = $row['fk_poster_id'];
					}
		
					if(is_array($country_poster_ids)){
						$poster_ids = implode(',', $country_poster_ids);
						$srcFlag = '1';
					}else{
						return;
					}
        
			}else{
				$sql = "SELECT distinct(ptc.fk_poster_id) FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id						
						AND pi.is_default ='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				
				$sql .= " ( ptc.fk_cat_id = '".$_REQUEST['country_id']."' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
					
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$country_poster_ids[] = $row['fk_poster_id'];
				}
	
				if(is_array($country_poster_ids)){
					$poster_ids = implode(',', $country_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}
		}
		if($_REQUEST['poster_size_id'] == '' && $_REQUEST['genre_id'] == '' && $_REQUEST['decade_id'] == '' && $_REQUEST['country_id'] == '' ){
			$split_stemmed = explode(" ",$keyword);
				$qry .= " AND ( ";
				
				$qry .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ) OR";
					
				
				$qry=substr($qry,0,(strLen($qry)-3));//this will eat the last OR
				$qry.= " ) ";
		}
		if($srcFlag == ''){
			if($list=="weekly"){
				$sql = "SELECT a.fk_poster_id FROM tbl_poster_live p, tbl_auction_live a 
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE 1 AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id ".$qry;
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$ids[] = $row['fk_poster_id'];
				}
			}else{
				$sql = "SELECT a.fk_poster_id FROM ".TBL_POSTER." p, ".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE 1 AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id ".$qry;
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$ids[] = $row['fk_poster_id'];
				}
			}
			
			$poster_ids = implode(',', $ids);
		}

		return $poster_ids;
	}
	
	function countSearchLiveAuctions($poster_ids)
	{
		if($poster_ids!= ''){
			$ids = explode(',', $poster_ids);
			return count($ids);
		}
		
		return 0;
	}
	
	function fetchSearchLiveAuctions($poster_ids,$view_mode='',$list='')
	{
        if(!isset($_SESSION['sessUserID'])){
            $user_id='';
        }else{
            $user_id=$_SESSION['sessUserID'];
        }

        if($view_mode=='list'){
			if($list=='weekly'){				
				
				$sql = "SELECT c.cat_value AS poster_size,
						   c1.cat_value AS genre,
						   c2.cat_value AS decade,
						   poster_size_auction(p.poster_id) AS country,
						   cond_auction(p.poster_id) AS cond,
						   tw.watching_id AS watch_indicator,
					a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,a.imdb_link,
					a.auction_actual_end_datetime, aw.auction_week_title,
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, p.poster_sku,  pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount
					FROM
					tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
					INNER JOIN (tbl_poster_to_category_live ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id


												  INNER JOIN (tbl_poster_to_category_live ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id

												  INNER JOIN (tbl_poster_to_category_live ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1'
					AND a.fk_poster_id IN (".$poster_ids.")
					AND a.auction_is_approved = '1'
					
					  ";
				
			}else{
				$sql = "SELECT c.cat_value AS poster_size,
						   c1.cat_value AS genre,
						   c2.cat_value AS decade,
						   poster_size(p.poster_id) AS country,
						   cond(p.poster_id) AS cond,
						   tw.watching_id AS watch_indicator,
					a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,a.imdb_link,
					a.auction_actual_end_datetime, aw.auction_week_title,
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, p.poster_sku,  pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount
					FROM
					".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
					INNER JOIN (tbl_poster_to_category ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id


												  INNER JOIN (tbl_poster_to_category ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id

												  INNER JOIN (tbl_poster_to_category ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1'
					AND a.fk_poster_id IN (".$poster_ids.")
					AND a.auction_is_approved = '1'
					
					  ";
			} 
        }else{
			if($list=='weekly'){
				$sql = "SELECT
					   tw.watching_id AS watch_indicator,
				a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				p.poster_id, p.poster_title,  pi.poster_thumb,p.fk_user_id,pi.is_cloud,
				a.max_bid_amount AS last_bid_amount
				FROM
				tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'

				WHERE pi.is_default = '1'
				AND a.fk_poster_id IN (".$poster_ids.")
				AND a.auction_is_approved = '1'
				
				  ";
			}else{
				$sql = "SELECT
						   tw.watching_id AS watch_indicator,
					a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
					a.auction_actual_end_datetime,  aw.auction_week_title,
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title,  pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount
					FROM
					".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'

					WHERE pi.is_default = '1'
					AND a.fk_poster_id IN (".$poster_ids.")
					AND a.auction_is_approved = '1'
					
					  ";
			}
        }
		/*$sql .= " AND a.auction_is_sold IN ('0','3') AND case when (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1') when  a.fk_auction_type_id ='4' then a.auction_is_approved='1'  else  a.fk_auction_type_id ='1' end ";*/

		$orderBy=$this->orderBy;
        if($orderBy=="auction_actual_end_datetime"){
            $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_bid_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }else{
			if($list=='weekly'){
				
				$sql .= " 
					  ORDER BY last_bid_amount ".$this->orderType.",a.auction_id ".$this->orderType."
					  LIMIT ".$this->offset.", ".$this->toShow."";
			}else{
				$sql .= " GROUP BY a.auction_id
					  ORDER BY ".$this->orderBy." ".$this->orderType."
					  LIMIT ".$this->offset.", ".$this->toShow."";
			}
        }
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
		}
		return false;
	}
	function fetchSearchLiveAuctions_upcoming($poster_ids)
     {
         if(!isset($_SESSION['sessUserID'])){
             $user_id='';
         }else{
             $user_id=$_SESSION['sessUserID'];
         }

        $sql = "SELECT
	 	        c.cat_value AS poster_size,
                c1.cat_value AS genre,
                c2.cat_value AS decade,
                poster_size(p.poster_id) AS country,
                cond(p.poster_id) AS cond,
                count(tw.watching_id) AS watch_indicator,
	 	        a.auction_id,a.fk_poster_id,a.auction_is_approved, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.imdb_link,
				a.is_offer_price_percentage, a.auction_buynow_price,a.auction_note, a.auction_actual_start_datetime, a.auction_actual_end_datetime, e.event_title,aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				p.poster_id, p.poster_title, p.poster_sku,  pi.poster_thumb,pi.poster_image,pi.is_cloud
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
											  LEFT JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  LEFT JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  LEFT JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id
				WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND
				a.auction_actual_start_datetime > now()
				AND a.fk_poster_id IN (".$poster_ids.")
				AND a.auction_is_approved = '1'
				AND a.auction_is_sold = '0'
				  ";

        $sql .= " AND case when a.fk_auction_type_id ='2' then  ( a.auction_actual_start_datetime > now() ) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime > now()  AND a.is_approved_for_monthly_auction = '1')   end ";

        $sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            //$this->fetchHighestOfferCountOffer($dataArr);
            //$this->fetchHighestBidCountBid($dataArr);
            return $dataArr;
        }
        return false;
    }
	function countKeySearchLiveAuctions($keyword = '',$list='',$search_type='',$auction_week_id='')
	{
		$sqlCat="SELECT cat_id from tbl_category where fk_cat_type_id=2 AND lower(cat_value) LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],strtolower($keyword))."%' ";
		
		$rowCat=mysqli_fetch_assoc(mysqli_query($GLOBALS['db_connect'],$sqlCat));
		$matchCatId=$rowCat['cat_id'];
		
		if($list=='weekly'){
			if($matchCatId>1){
				$sql = "SELECT distinct(a.auction_id)
					FROM tbl_poster_live p,tbl_auction_live a
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					INNER JOIN tbl_poster_to_category_live tpc ON a.fk_poster_id = tpc.fk_poster_id
					WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
					AND a.in_cart = '0' 
					 ";
			}else{
				$sql = "SELECT distinct(a.auction_id)
					FROM tbl_poster_live p,tbl_auction_live a
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
					AND a.in_cart = '0' 
					 ";
			}
			
		}else{
			if($matchCatId>1){
				 $sql = "SELECT distinct(a.auction_id)
					FROM ".TBL_POSTER." p,".TBL_AUCTION." a
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					INNER JOIN tbl_poster_to_category tpc ON a.fk_poster_id = tpc.fk_poster_id
					WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
					 ";			 
			}else{
				$sql = "SELECT distinct(a.auction_id)
					FROM ".TBL_POSTER." p,".TBL_AUCTION." a
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
					AND a.in_cart = '0' 
					 ";
			}
		}
        

        if($list==''){
			if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode']=='list'){
					 $sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end  ";
			}else{
					 $sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id IN ('1','6') end  ";
			}
            
        }elseif($list=='fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' AND a.auction_is_sold IN ('0','3') ";
        }elseif($list=='weekly'){
            $sql .= " AND ( (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
        }elseif($list=='monthly'){
            $sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1'
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
        }/*elseif($list=='stills'){
            $sql .= " AND (a.fk_auction_type_id = '5' 
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())) AND a.auction_is_sold='0' ";
        }*/elseif($list=='stills'){
            $sql .= " AND (a.fk_auction_type_id = '4' 
					  AND a.auction_is_sold IN ('0','3')) ";
        }
		if($auction_week_id!=''){
	   		$sql .= " AND a.fk_auction_week_id = ".$auction_week_id;
	    }
        if($keyword != ''){
            $sql .= " AND (";
            $split_stemmed = explode(" ",$keyword);
            $totKey=count($split_stemmed);
            /*if($totKey>1){
                if(($search_type=='title_desc' || $search_type=='')){
					if($matchCatId>1){
						$newSql = $sql." ( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                    }else{
						$newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					}
				}elseif($search_type=='title'){
                    $newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
                if($rs = mysqli_query($GLOBALS['db_connect'],$newSql)){
                    while($counter = mysqli_fetch_assoc($rs)){
                        $rowNew[]=$counter['auction_id'];
                    }
                }

                $i=1;
                while(list($key,$val)=each($split_stemmed)){

                    if($val<>" " and strlen($val) > 0 and ($search_type=='title_desc' || $search_type=='')){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }elseif($val<>" " and strlen($val) > 0 and $search_type=='title'){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }
                    $i++;
                    if($rs = mysqli_query($GLOBALS['db_connect'],$i)){
                        while($counter = mysqli_fetch_assoc($rs)){
                            $row[]=$counter['auction_id'];
                        }
                    }
                }
                if(!empty($row)){
                foreach(array_count_values($row)as $key=>$val){
                    if($val==$totKey){
                        $rowNew[]=$key;
                    }
                }
               }

            }else{*/
                if(($search_type=='title_desc' || $search_type=='')){
					if($matchCatId>1){
						$sql .= " ( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                    }else{
						$sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					}
					
                }elseif($search_type=='title'){
                    $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
				
                if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                    while($counter = mysqli_fetch_assoc($rs))
                        $rowNew[]=$counter['auction_id'];
                }
            /*}*/
            // $sql.= ")";
        }

        if(!empty($rowNew)){
            return array_unique(($rowNew));
        }else{
            return false;
        }
    }
	
	function fetchKeySearchLiveAuctions($keyword = '',$list='',$search_type='',$arrList='',$view_mode='',$auction_week_id='')
		{
            if(!isset($_SESSION['sessUserID'])){
                $user_id='';
            }else{
                $user_id=$_SESSION['sessUserID'];
            }
            if($view_mode=='list'){
					
				if($list=='weekly'){
						
					$sql = "SELECT
					c.cat_value AS poster_size,
				   c1.cat_value AS genre,
				   c2.cat_value AS decade,
				   poster_size(p.poster_id) AS country,
				   cond(p.poster_id) AS cond,
				   tw.watching_id AS watch_indicator,
					a.auction_id,  a.fk_auction_type_id, a.auction_asked_price, a.imdb_link,
					a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime,  aw.auction_week_title,
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount,u.username
					FROM ".USER_TABLE." u,tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
					INNER JOIN (tbl_poster_to_category_live ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category_live ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category_live ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0' AND u.user_id = p.fk_user_id ";
				
				}else{
					
					$sql = "SELECT
					c.cat_value AS poster_size,
				   c1.cat_value AS genre,
				   c2.cat_value AS decade,
				   poster_size(p.poster_id) AS country,
				   cond(p.poster_id) AS cond,
				   tw.watching_id AS watch_indicator,
					a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.imdb_link,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime,  aw.auction_week_title,
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount,u.username
					FROM ".USER_TABLE." u,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id					
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
					INNER JOIN (tbl_poster_to_category ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0' AND u.user_id = p.fk_user_id ";
            
				}
			}else{
				
				 if($list=='alternative' || $list==''){
				 			 $sql = "SELECT c.cat_value AS poster_size,
									tw.watching_id AS watch_indicator,
									a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
									a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
									a.auction_actual_end_datetime,  aw.auction_week_title,
									(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
									p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
									a.max_bid_amount AS last_bid_amount,p.artist,p.quantity,p.field_1,p.field_2,p.field_3
									FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
									INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id									
									LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
									LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
									INNER JOIN (tbl_poster_to_category ptc
							 			RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
							  				AND c.fk_cat_type_id = 1 )
										ON a.fk_poster_id = ptc.fk_poster_id					
									WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
				 
				 }else{
					 if($list=='weekly' || $list=='extended'){
										    
						 $sql = "SELECT
								tw.watching_id AS watch_indicator,
								a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
								a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
								a.auction_actual_end_datetime, aw.auction_week_title,
								(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
								p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
								a.max_bid_amount AS last_bid_amount
								FROM tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
								INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
								LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
								LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
								WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
				 
					}else{
						 $sql = "SELECT
								tw.watching_id AS watch_indicator,
								a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
								a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
								a.auction_actual_end_datetime,  aw.auction_week_title,
								(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
								p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
								a.max_bid_amount AS last_bid_amount
								FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
								INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id								
								LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
								LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
				
								WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
					}
				 }

               

            }
		if($list==''){
			if($view_mode=='list'){
				$sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end ";
				}else{
				$sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id IN ('1','6') end ";
				}
		}elseif($list=='fixed'){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND (a.fk_auction_type_id = '1') ";
		}elseif($list=='weekly' || $list == 'extended'){
			$sql .= " AND ( (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}elseif($list=='monthly'){
			$sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}/*elseif($list=='stills'){
            $sql .= " AND (a.fk_auction_type_id = '5' 
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())) AND a.auction_is_sold ='0' ";
        }*/elseif($list=='stills'){
            $sql .= " AND (a.fk_auction_type_id = '4' 
					 AND a.auction_is_sold IN ('0','3')) ";
        }
			/*if($keyword != ''){
                $sql .= " AND ( ";
                $split_stemmed = explode(" ",$keyword);
                while(list($key,$val)=each($split_stemmed)){
                    if($val<>" " and strlen($val) > 0 and ($search_type=='title_desc' || $search_type=='')){
                        $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
                    }elseif($val<>" " and strlen($val) > 0 and $search_type=='title' ){
                        $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
                    }
                }
                $sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
                $sql .= " ) ";
               }*/
			if($auction_week_id!=''){
	   			$sql .= " AND a.fk_auction_week_id = ".$auction_week_id;
	   		}    
            $sql .= " AND a.auction_id IN ($arrList) ";
			$orderBy=$this->orderBy;
            if($orderBy=="auction_actual_end_datetime"){
                $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }elseif($orderBy=="auction_bid_price"){
                $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }else{
                if($list=='weekly'){
					$sql .= " GROUP BY a.auction_id
						  ORDER BY last_bid_amount ".$this->orderType.",a.auction_id ".$this->orderType."
						  LIMIT ".$this->offset.", ".$this->toShow."";
				}else{
					$sql .= " GROUP BY a.auction_id
					  ORDER BY ".$this->orderBy." ".$this->orderType."
					  LIMIT ".$this->offset.", ".$this->toShow."";
				}
            }

	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	}
	
	function countRefineLiveAuctions()	
	{
		$srcQry = " 1 ";
		if($_REQUEST['keyword'] != ''){
			$srcQry = " (p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%' OR ( p.poster_id=ptc.fk_poster_id AND ptc.fk_cat_id=c.cat_id AND c.cat_value LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%'))";
		}
		
		if(is_array($_REQUEST['cat']) && count($_REQUEST['cat']) > 0){
			$ids = implode(',', $_REQUEST['cat']);
			if($_REQUEST['keyword'] != ''){
				$srcQry .= " OR (ptc.fk_cat_id IN (".$ids."))";
			}else{
				$srcQry = " (ptc.fk_cat_id IN (".$ids."))";
			}
		}

		$sql = "SELECT COUNT(DISTINCT(a.auction_id)) AS counter
				FROM ".TBL_AUCTION." a,".TBL_CATEGORY." c, ".TBL_POSTER." p, ".TBL_POSTER_TO_CATEGORY." ptc WHERE 1
				AND a.fk_poster_id = p.poster_id
				AND a.fk_poster_id = ptc.fk_poster_id AND a.in_cart = '0' ";

		$sql .= " AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
				  OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
				  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))
				  OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
				  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())))";	

		
		$sql .= " AND (".$srcQry.")";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	
	function fetchRefineLiveAuctions()	
	{
		$srcQry = " 1 ";
		if($_REQUEST['keyword'] != ''){
			$srcQry = " (p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%' OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%' OR ( p.poster_id=ptc.fk_poster_id AND ptc.fk_cat_id=c.cat_id AND c.cat_value LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$_REQUEST['keyword'])."%'))";
		}
		
		if(is_array($_REQUEST['cat']) && count($_REQUEST['cat']) > 0){
			$ids = implode(',', $_REQUEST['cat']);
			if($_REQUEST['keyword'] != ''){
				$srcQry .= " OR (ptc.fk_cat_id IN (".$ids."))";
			}else{
				$srcQry = " (ptc.fk_cat_id IN (".$ids."))";
			}
		}
		
		$sql = "SELECT a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, e.event_title, aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".TBL_CATEGORY." c,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
				LEFT JOIN ".TBL_POSTER_TO_CATEGORY." ptc ON a.fk_poster_id = ptc.fk_poster_id				
				WHERE pi.is_default = '1' AND a.in_cart = '0' ";

		$sql .= " AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
				  OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
				  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))
				  OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
				  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())))";	

		$sql .= " AND (".$srcQry.")";
		
		$sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   $this->fetchHighestOfferCountOffer($dataArr);
		   $this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
		}
		return false;
	}
	
	/* Search ends here */
	
	/*********************** All available auctions for front-end ***********************/

	/*********************** All (Fixed Price, monthly, weekly) auctions by status (selling, pending, sold, unsold) starts ***********************/
	
	##### fetch live auction ids ######
	/**
	 * 
	 * This function fetches the expired auctions .
	 */
	function fetchExpiredAuctions()
	{
		$sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold, a.auction_reserve_offer_price,
				MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count, MAX(b.bid_amount) AS last_bid_amount
				FROM ".TBL_AUCTION." a 
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				WHERE ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
				OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'))
				AND (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) <= 0
				GROUP BY a.auction_id";

	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
	
	function processExpiredAuction($auction_id, $bid_id)
	{
		$sql = "UPDATE ".TBL_AUCTION." a, ".TBL_BID." b SET a.auction_is_sold='1', b.bid_is_won='1'
				WHERE a.auction_id='".$auction_id."'
				AND b.bid_id='".$bid_id."'";
		if(mysqli_query($GLOBALS['db_connect'],$sql)){
			$invoiceObj = new Invoice();
			$invoiceObj->generateInvoice($bid_id, true);
		}
	}
	
	
	/**
	 * 
	 * This function counts the no. of  auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function countAuctionsByStatus($user_id = '', $auctionStatus = '',$auctionWeek = '',$title='',$from_myselling=0)
	{
		if($auctionStatus == 'upcoming' || $auctionStatus == 'selling' ){
		 if($from_myselling==1){
			$sql = "SELECT count(1) AS counter
				FROM tbl_auction_live a , tbl_poster_live p , tbl_poster_images_live pi 
				WHERE  pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.fk_poster_id = pi.fk_poster_id ";
		}else{				
			$sql = "SELECT count(1) AS counter
				FROM tbl_auction_live a , tbl_poster_live p , tbl_poster_images_live pi ,".TBL_AUCTION_WEEK." aw  
				WHERE  pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.fk_poster_id = pi.fk_poster_id  
				AND a.fk_auction_week_id = aw.auction_week_id AND aw.is_test = '0' ";					
			}
		}else{
			$sql = "SELECT count(a.auction_id) AS counter
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id  
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id  
				WHERE  pi.is_default = '1'  ";
				}
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		if($title !='' && $title !='Search by title..'){
            $sql.=" AND	p.poster_title LIKE '%".$title."%'  ";
        }
		if($auctionStatus == 'pending'){
			$sql .= "AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '3' AND (a.auction_is_approved = '0' OR a.is_approved_for_monthly_auction = '0')))";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND a.auction_is_sold IN ('1','2') AND a.is_deleted='0' ";
        }elseif($auctionStatus == 'unpaid'){
            $sql .= "AND a.auction_is_sold = '3' AND a.is_deleted='0' ";
        }elseif($auctionStatus == 'unsold'){
			$sql .= "AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1'
						  AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now())
					OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1'
						AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now())
					OR 	(a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' 
						AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now()) )";
		}elseif($auctionStatus == 'upcoming'){
			if($auctionWeek==''){
				$sql .= "AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
							AND a.auction_actual_start_datetime > now())
						)";
			}else{
				$sql .= " AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
							AND a.auction_actual_start_datetime > now() AND a.fk_auction_week_id='".$auctionWeek."' )
						OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						 AND a.auction_actual_start_datetime > now() AND a.fk_auction_week_id='".$auctionWeek."' ))";
			 }
		}else{
			$sql .= "AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
					OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())
					OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the  auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchAuctionsByStatus($user_id = '', $auctionStatus = '',$sort_by='',$auctionWeek = '',$title='',$from_myselling=0)
	{
		//$this->orderType = 'DESC';
        if(!isset($_SESSION['sessUserID'])){
            $Sessionuser_id='';
        }else{
            $Sessionuser_id=$_SESSION['sessUserID'];
        }
		if($auctionStatus == 'upcoming' || $auctionStatus == 'selling'){
			
			$sql = "SELECT 
				c.cat_value AS poster_size,
  				c1.cat_value AS genre,
  				c2.cat_value AS decade,
  				poster_size_auction(p.poster_id) AS country,
  				cond_auction(p.poster_id) AS cond,
				count(tw.watching_id) AS watch_indicator,a.auction_id,a.fk_poster_id,a.auction_is_approved, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price,a.auction_note, a.auction_actual_start_datetime, a.auction_actual_end_datetime,aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,a.auction_is_sold,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud,p.up_date,p.post_date
				FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$Sessionuser_id."'
				LEFT JOIN (tbl_poster_to_category ptc 
				             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id 
							  AND c.fk_cat_type_id = 1 ) 
				  ON a.fk_poster_id = ptc.fk_poster_id
				  		
							   
				  LEFT JOIN (tbl_poster_to_category ptc1 
				  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id 
							  AND c1.fk_cat_type_id = 2)
				  ON a.fk_poster_id = ptc1.fk_poster_id			  
							  
				  LEFT JOIN (tbl_poster_to_category ptc2 
				  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id 
							  AND c2.fk_cat_type_id = 3)
				  ON a.fk_poster_id = ptc2.fk_poster_id	
				WHERE pi.is_default = '1'";
		
		}else{
			$sql = "SELECT 
				c.cat_value AS poster_size,
  				c1.cat_value AS genre,
  				c2.cat_value AS decade,
  				poster_size(p.poster_id) AS country,
  				cond(p.poster_id) AS cond,
				count(tw.watching_id) AS watch_indicator,a.auction_id,a.fk_poster_id,a.auction_is_approved, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price,a.auction_note, a.auction_actual_start_datetime, a.auction_actual_end_datetime, e.event_title,aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,a.auction_is_sold,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud,p.up_date,p.post_date
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ia ON a.auction_id = ia.fk_auction_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$Sessionuser_id."'
				LEFT JOIN (tbl_poster_to_category ptc 
				             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id 
							  AND c.fk_cat_type_id = 1 ) 
				  ON a.fk_poster_id = ptc.fk_poster_id
				  		
							   
				  LEFT JOIN (tbl_poster_to_category ptc1 
				  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id 
							  AND c1.fk_cat_type_id = 2)
				  ON a.fk_poster_id = ptc1.fk_poster_id			  
							  
				  LEFT JOIN (tbl_poster_to_category ptc2 
				  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id 
							  AND c2.fk_cat_type_id = 3)
				  ON a.fk_poster_id = ptc2.fk_poster_id	
				WHERE pi.is_default = '1'";
		}
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."' ";
		}
		if($title !='' && $title !='Search by title..'){
            $sql.=" AND	p.poster_title LIKE '%".$title."%'  ";
        }
		if($auctionStatus == 'pending'){
			$sql .= "AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '0')
					OR (a.fk_auction_type_id = '3' AND (a.auction_is_approved = '0' OR a.is_approved_for_monthly_auction = '0')))";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND a.auction_is_sold IN ('1','2') AND a.is_deleted='0' ";
        }elseif($auctionStatus == 'unpaid'){
            $sql .= "AND a.auction_is_sold = '3' AND a.is_deleted='0' ";
        }elseif($auctionStatus == 'unsold'){
			$sql .= "AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1'
						  AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now())
					OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1'
						AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now())
					OR 	(a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' 
						AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now()) )";	
		}elseif($auctionStatus == 'upcoming'){
			if($from_myselling!=1){
				$sql .= " AND aw.is_test = '0' " ;
				}
			if($auctionWeek==''){
				$sql .= "  AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
							AND a.auction_actual_start_datetime > now())
						)";
			}else{
				$sql .= " AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
							AND a.auction_actual_start_datetime > now() AND a.fk_auction_week_id='".$auctionWeek."' )
						OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						   AND a.auction_actual_start_datetime > now() AND a.fk_auction_week_id='".$auctionWeek."' ))";
			 }
		}else{
			 $sql .= "AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
					OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())
					OR (a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_by=='price'){
			$sql .= " ORDER BY a.auction_asked_price DESC 
				    LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_by=='title'){
			$sql .= " ORDER BY p.poster_title ASC 
				    LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_by=='listing_date'){
			if($auctionStatus=='upcoming'){
				$this->orderType="ASC";
			}else{
				$this->orderType="DESC";
			}
			$sql .= " ORDER BY   
					case when a.fk_auction_type_id ='2'  then a.auction_actual_start_datetime  when a.fk_auction_type_id ='4'  then p.up_date else p.up_date end 
					".$this->orderType." 
				    LIMIT ".$this->offset.", ".$this->toShow." ";
			/*$sql .= " ORDER BY  
					case when a.fk_auction_type_id !='1'  then a.auction_actual_start_datetime  else p.up_date end,
					a.auction_actual_start_datetime,p.up_date  DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";*/
			/* $sql.=" ORDER BY CASE a.fk_auction_type_id WHEN 1 THEN p.up_date  DESC
			 		ELSE WHEN a.fk_auction_type_id <> 1 THEN a.auction_actual_start_datetime DESC END  
					LIMIT ".$this->offset.", ".$this->toShow." "	;	*/
		}elseif($sort_by=='uploaded_date'){
			$sql .= " ORDER BY p.post_date DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_by=='sold_date'){
			$sql .= " ORDER BY i.invoice_generated_on DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
		}else{
			$sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				    LIMIT ".$this->offset.", ".$this->toShow."";
				}
		//echo $sql;		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** All auctions (Fixed Price, monthly, weekly) by status (selling, pending, sold, unsold) ends ***********************/
	
	/*********************** Fixed Price items by status (selling, pending, sold) starts ***********************/
	
	/**
	 * 
	 * This function counts the no of the fixed price auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	
	function countFixedPriceSaleByStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT count(distinct(a.auction_id)) AS counter,a.auction_id
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE  pi.is_default = '1' AND a.fk_auction_type_id = '1' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		//echo $sql;
		//$sql .= " GROUP BY a.auction_id";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the fixed price auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchFixedPriceSaleByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		//echo $sort_type;
		$sql = "SELECT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.is_set_for_home_big_slider,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname,pi.is_cloud,pi.is_big
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '1' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** Fixed Price items by status ends ***********************/
	
	/*********************** Weekly Auction by status (selling, pending, sold, unsold) starts ***********************/
	/**
	 * 
	 * This function counts the no. of the weekly auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function countWeeklyAuctionByStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		if($auctionStatus=='selling' || $auctionStatus=='upcoming'){
			$sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".USER_TABLE." u ,tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id				
				WHERE pi.is_default = '1'  AND u.user_id=p.fk_user_id ";
		}else{
			$sql = "SELECT count(distinct(a.auction_id)) AS counter
					FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
					LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
					WHERE pi.is_default = '1' AND a.fk_auction_type_id = '2' AND u.user_id=p.fk_user_id ";
		}
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'unsold'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime < now())";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND ( a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() )";
		}elseif($auctionStatus == 'upcoming'){
			$sql .= "AND (a.auction_actual_start_datetime > now())";
		}elseif($auctionStatus == 'unpaid'){
			 $sql .= "AND (a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
			 			   AND i.is_approved = '1' AND a.auction_actual_end_datetime < now() AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  a.auction_actual_start_datetime >='".$start_date."'  AND a.auction_actual_end_datetime <= '".$end_date."' "; 	
		}
		//$sql .= " GROUP BY a.auction_id";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the weekly auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchWeeklyAuctionByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		if($auctionStatus=='selling' || $auctionStatus=='upcoming'){
			$sql = "SELECT a.auction_id,a.reopen_auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_buynow_price,a.is_set_for_home_big_slider,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime, a.auction_is_approved,a.slider_first_position_status,
				p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname,p.poster_id,pi.is_cloud,pi.is_big
				FROM ".USER_TABLE." u ,tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id				
				WHERE pi.is_default = '1'  AND u.user_id=p.fk_user_id ";
		}else{
			$sql = "SELECT a.auction_id,a.reopen_auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_buynow_price,a.is_set_for_home_big_slider,
					a.auction_actual_start_datetime, a.auction_actual_end_datetime, a.auction_is_approved,a.slider_first_position_status,
					p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname,p.poster_id,pi.is_cloud,pi.is_big
					FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
					LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
					WHERE pi.is_default = '1' AND a.fk_auction_type_id = '2' AND u.user_id=p.fk_user_id ";
			}
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'unsold'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime < now())";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($auctionStatus == 'upcoming'){
			$sql .= "AND (a.auction_actual_start_datetime > now())";
		}elseif($auctionStatus == 'unpaid'){
			 $sql .= "AND (a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
			 			   AND i.is_approved = '1' AND a.auction_actual_end_datetime < now() AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  a.auction_actual_start_datetime >='".$start_date."'  AND a.auction_actual_end_datetime <= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
			
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** Weekly Auction by status ends ***********************/
	
	/*********************** Monthly Auction by status (selling, pending, sold, unsold) starts ***********************/
	/**
	 * 
	 * This function counts the no of the monthly auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function countMonthlyAuctionByStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '3' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND (a.auction_is_approved = '0' AND a.is_approved_for_monthly_auction = '0')";
		}elseif($auctionStatus == 'waiting_receive'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '0')";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'unsold'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						  AND a.auction_actual_end_datetime <= now())";
		}elseif($auctionStatus == 'upcoming'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.is_approved_for_monthly_auction = '1' AND a.auction_actual_start_datetime > now())";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						  AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
						  AND i.is_approved = '1' AND a.auction_actual_end_datetime < now() AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  a.auction_actual_start_datetime >= '".$start_date."'  AND a.auction_actual_end_datetime <= '".$end_date."' "; 	
		}
		//$sql .= " GROUP BY a.auction_id";
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the monthly auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchMonthlyAuctionByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT a.auction_id,a.reopen_auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_is_approved,
				a.is_approved_for_monthly_auction, e.event_title,u.firstname,u.lastname,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,
				p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,p.poster_id,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '3' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND (a.auction_is_approved = '0' AND a.is_approved_for_monthly_auction = '0')";
		}elseif($auctionStatus == 'waiting_receive'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '0')";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'unsold'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						  AND a.auction_actual_end_datetime <= now())";
		}elseif($auctionStatus == 'upcoming'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_actual_start_datetime > now())";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1'
						  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						  AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
						  AND i.is_approved = '1' AND a.auction_actual_end_datetime < now() AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  a.auction_actual_start_datetime >= '".$start_date."'  AND a.auction_actual_end_datetime <= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	
	/*********************** Monthly Auction by event ***********************/
	/**
	 * 
	 * This function counts the no of the monthly auctions by event .
	 * @param $event_id=>This paramter defines under which event_id the auctions belong.
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function countMonthlyAuctionByEvent($event_id, $user_id = '')
	{
		$sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE a.fk_auction_type_id = '3' AND a.fk_event_id = '".$event_id."'";

		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/*********************** Monthly Auction by event ***********************/
	
	/**
	 * 
	 * This function fetches the monthly auctions by event .
	 * @param $event_id=>This paramter defines under which event_id the auctions belong.
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchMonthlyAuctionByEvent($event_id, $user_id = '')
	{
		$sql = "SELECT a.auction_id,a.reopen_auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_is_approved,
				a.is_approved_for_monthly_auction, e.event_title,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,
				p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '3' AND a.fk_event_id = '".$event_id."'";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		$sql .= " GROUP BY a.auction_id";
		
		$sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** Weekly Auction by auction week ***********************/
	/**
	 * 
	 * This function counts the no of the weekly auctions by auction weeek .
	 * @param $event_id=>This paramter defines under which event_id the auctions belong.
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function countWeeklyAuctionByWeek($week_id, $user_id = '',$type='',$is_stills='')
	{
        if($type=='selling' || $type=='pending'){
			$sql = "SELECT count(1) AS counter
					FROM tbl_auction_live a
					WHERE  a.fk_auction_week_id = '".$week_id."'  ";
		 }else{
		 	$sql = "SELECT count(distinct(a.auction_id)) AS counter
					FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					WHERE  a.fk_auction_week_id = '".$week_id."'  ";
		 }
				
		if($type=='selling'){
            $sql.="  AND a.auction_actual_end_datetime >= now() AND a.auction_is_approved='1' AND a.auction_actual_start_datetime <= now() ";
        }
        if($type=='pending'){
            $sql.="  AND  a.auction_actual_start_datetime > now()  ";
        }
        if($type=='unsold'){
            $sql.="  AND a.auction_actual_end_datetime < now() AND a.auction_is_approved='1' AND a.auction_is_sold='0' ";
        }
        if($type=='sold'){
            $sql.="  AND a.auction_actual_end_datetime < now() AND a.auction_is_approved='1' AND a.auction_is_sold !='0' ";
        }
		if($is_stills==0){
			$sql.="AND a.fk_auction_type_id = '2' ";
		}else{
			$sql.="AND a.fk_auction_type_id = '5' ";
		}		
        
        if($user_id != ""){
            $sql .= " AND p.fk_user_id = '".$user_id."'";
        }

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $counter = mysqli_fetch_assoc($rs);
            return $counter['counter'];
        }
        return false;
    }
	/**
	 * 
	 * This function fetches the monthly auctions by event .
	 * @param $event_id=>This paramter defines under which event_id the auctions belong.
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchWeeklyAuctionByWeek($week_id, $user_id = '',$type='',$is_limit='',$is_stills='')
	{

        if($type!='sold' && $type!='selling' && $type!='pending'){
            $sql = "SELECT a.auction_id,a.reopen_auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_buynow_price, a.auction_is_approved,a.auction_is_sold,
                     
                    
                    p.poster_title, p.poster_sku, pi.poster_thumb,pi.is_cloud
                    FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
                    INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id                    
                    WHERE pi.is_default = '1'   AND a.fk_auction_week_id = '".$week_id."'";
        }elseif($type=='selling' || $type=='pending'){
			$sql = "SELECT a.auction_id, a.auction_asked_price,
                     a.auction_is_approved,a.auction_is_sold,
                     w.auction_week_title,
                    a.auction_actual_start_datetime, a.auction_actual_end_datetime,
                    p.poster_title,  pi.poster_thumb,pi.is_cloud
                    FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
                    LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
                    LEFT JOIN ".TBL_AUCTION_WEEK." w ON a.fk_auction_week_id = w.auction_week_id
                    WHERE pi.is_default = '1'   AND a.fk_auction_week_id = '".$week_id."'";
		}else{
            $sql = "SELECT a.auction_id,a.reopen_auction_id,ubuyer.username,ubuyer.firstname,ubuyer.lastname,ubuyer.user_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_buynow_price, a.auction_is_approved,a.auction_is_sold,				
				p.poster_title, p.poster_sku, pi.poster_thumb,i_buyer.invoice_generated_on,tia_buyer.amount,i_buyer.is_combined,i_buyer.is_paid,
				i_buyer.is_approved,i_buyer.paid_on,i_buyer.is_combined,i_buyer.is_shipped,i_buyer.shipped_date,i_buyer.invoice_id,pi.is_cloud
				FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id				
				INNER JOIN (".TBL_INVOICE_TO_AUCTION." tia_buyer
							 RIGHT JOIN (".TBL_INVOICE." i_buyer
							 RIGHT JOIN ".USER_TABLE." ubuyer ON i_buyer.fk_user_id = ubuyer.user_id)
							ON tia_buyer.fk_invoice_id = i_buyer.invoice_id AND  i_buyer.is_buyers_copy ='1'
					)
				ON a.auction_id = tia_buyer.fk_auction_id
				WHERE pi.is_default = '1'   AND a.fk_auction_week_id = '".$week_id."'
				AND a.auction_actual_end_datetime < now() AND a.auction_is_approved='1' AND a.auction_is_sold !='0' ";
        }
        
		if($is_stills==0){
			$sql .="  AND a.fk_auction_type_id = '2' ";
		}else{
			$sql .="  AND a.fk_auction_type_id = '5' ";
		}
        if($type=='selling'){
            $sql.=" AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() AND a.auction_is_approved='1' ";
        }
        if($type=='pending'){
            $sql.="  AND a.auction_is_approved='1' ";
        }
        if($type=='unsold'){
            $sql.="  AND a.auction_actual_end_datetime < now() AND a.auction_is_approved='1' AND a.auction_is_sold='0' ";
        }
		if($user_id != ""){
            $sql .= " AND p.fk_user_id = '".$user_id."'";
        }
        $sql .= " GROUP BY a.auction_id";
        if($type!='sold'){
            /*$sql .= " ORDER BY ".$this->orderBy." ".$this->orderType."
                    LIMIT ".$this->offset.", ".$this->toShow."";*/
            $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType."";

        }elseif($type=='sold' && $is_limit=='1'){
            $sql .= " ORDER BY ubuyer.user_id DESC
                    LIMIT ".$this->offset.", ".$this->toShow."";
        }elseif($type=='sold' && $is_limit=='0'){
            $sql .= " ORDER BY ubuyer.user_id DESC ";
        }

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $i=0;
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
				if($is_limit!='0'){
					if ($dataArr[$i]['is_cloud']=='1'){
						$dataArr[$i]['image_path']=CLOUD_POSTER_THUMB.$dataArr[$i]['poster_thumb'];                    
					}else{
						$dataArr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataArr[$i]['poster_thumb'];
					}
				}
                $i++;
            }
            if($type!='sold'){
                return $dataArr;
            }else{
                //$this->getTotalCountPrice($dataArr);
                return $dataArr;
            }
        }
        return false;
    }
    function fetchWeeklyAuctionByWeekSeller($week_id, $user_id = '',$type='',$is_limit='',$is_stills='')
    {


        $sql="SELECT a.auction_id,a.reopen_auction_id,ubuyer.username,ubuyer.firstname,ubuyer.lastname,ubuyer.user_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_is_approved,a.auction_is_sold,
				a.is_approved_for_monthly_auction, w.auction_week_title,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,
				p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,i_buyer.invoice_generated_on,tia_buyer.amount,i_buyer.is_combined,i_buyer.is_paid,
				i_buyer.is_approved,i_buyer.paid_on,i_buyer.is_combined,i_buyer.is_buyers_copy,i_buyer.invoice_id
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." w ON a.fk_auction_week_id = w.auction_week_id
				LEFT JOIN (".TBL_INVOICE_TO_AUCTION." tia_buyer
							 RIGHT JOIN (".TBL_INVOICE." i_buyer
							 RIGHT JOIN ".USER_TABLE." ubuyer ON i_buyer.fk_user_id = ubuyer.user_id )
							ON tia_buyer.fk_invoice_id = i_buyer.invoice_id AND  i_buyer.is_buyers_copy ='0'
					)
				ON a.auction_id = tia_buyer.fk_auction_id
				WHERE pi.is_default = '1'   AND a.fk_auction_week_id = '".$week_id."'
				AND a.auction_actual_end_datetime < now() AND a.auction_is_approved='1' AND a.auction_is_sold !='0'";
        if($user_id != ""){
            $sql .= " AND p.fk_user_id = '".$user_id."'";
        }

		if($is_stills==0){
			$sql .= " AND a.fk_auction_type_id = '2' " ;
		}elseif($is_stills==1){
			$sql .= " AND a.fk_auction_type_id = '5' " ;
		}
        $sql .= " GROUP BY a.auction_id";

        if($type=='sold' && $is_limit=='1'){
            $sql .= " ORDER BY ubuyer.user_id DESC
                        LIMIT ".$this->offset.", ".$this->toShow."";
        }elseif($type=='sold' && $is_limit=='0'){
            $sql .= " ORDER BY ubuyer.user_id DESC ";
        }

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $i=0;
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
                if (file_exists("../poster_photo/" . $dataArr[$i]['poster_thumb'])){
                    $dataArr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataArr[$i]['poster_thumb'];
                }else{
                    $dataArr[$i]['image_path']=CLOUD_POSTER_THUMB.$dataArr[$i]['poster_thumb'];
                }
                $i++;
            }
            if($type!='sold'){
                return $dataArr;
            }else{
                //$this->getTotalCountPrice($dataArr);
                return $dataArr;
            }
        }
        return false;
    }
	
	
	/*********************** All available auctions for front-end ***********************/
	/**
	 * 
	 * This function fetches the last bid details by the auction id .
	 * @param $auction_id=>Provides the auction id.
	 */
	function getLastBid($auction_id)
	{
		/*$sql = "SELECT a.auction_asked_price, a.auction_reserve_offer_price,
				a.auction_buynow_price, a.auction_actual_end_datetime,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				a.auction_is_sold, b.bid_amount, b.bid_is_won, b.post_date
				FROM ".TBL_AUCTION." a
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				WHERE a.auction_id = '".$auction_id."' ORDER BY b.bid_id DESC LIMIT 1";*/
		$sql = "SELECT p.fk_user_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.auction_buynow_price, a.auction_actual_end_datetime,a.bid_count,a.max_bid_amount,a.highest_user,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				a.auction_is_sold, b.bid_amount, b.bid_is_won, b.post_date
				FROM tbl_auction_live a
				INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				WHERE a.auction_id = '".$auction_id."' ORDER BY b.bid_id DESC LIMIT 1";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_assoc($rs);
		return $row;
	}
	/**
	 * 
	 * This function fetches the last offer details by the auction id .
	 * @param $auction_id=>Provides the auction id.
	 */
	function getLastOffer($auction_id)
	{
		$sql = "SELECT p.fk_user_id, a.auction_asked_price, a.auction_reserve_offer_price, a.is_offer_price_percentage,a.in_cart,
				a.auction_is_sold, o.offer_amount, o.offer_is_accepted, o.post_date
				FROM ".TBL_AUCTION." a
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
				WHERE a.auction_id = '".$auction_id."'
				AND (o.offer_parent_id = '0' OR o.offer_parent_id IS NULL)
				ORDER BY o.offer_id DESC LIMIT 1";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_assoc($rs);
		return $row;
	}
	/**
	 * 
	 * This function fetches the highest bid or highest offer details by the auction id .
	 * @param $auction_id=>Provides the auction id.
	 */
	function instantUpdateOfferAuction($auction_ids,$list='')
	{
        /*$sql = "(SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold,	a.auction_actual_end_datetime,
                  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,	a.auction_reserve_offer_price,
                  MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,	MAX(b.bid_amount) AS last_bid_amount
                  FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                  WHERE a.auction_id IN ($auction_ids))
                  UNION
                  (SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,
                  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,	a.auction_reserve_offer_price,
                  MAX(o.offer_id) AS last_offer_id, COUNT(o.offer_id) AS offer_count,	MAX(o.offer_amount) AS last_offer_amount
                  FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
                  WHERE a.auction_id IN ($auction_ids)
                  AND o.offer_parent_id = 0)
                  GROUP BY a.auction_id";*/


        /*$sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold,
                  a.auction_actual_end_datetime, (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
                  a.auction_reserve_offer_price, 	MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,
                  MAX(b.bid_amount) AS last_bid_amount, MAX(po.offer_id) AS last_offer_id, COUNT(po.offer_id) AS offer_count,
                  MAX(po.offer_amount) AS last_offer_amount
                  FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                  LEFT JOIN ".TBL_OFFER." po ON a.auction_id = po.offer_fk_auction_id
                  LEFT JOIN ".TBL_OFFER." o ON po.offer_parent_id = o.offer_id
                  WHERE a.auction_id IN ($auction_ids)
                  GROUP BY a.auction_id";*/

        if($list==''){
            $sql = "SELECT a.auction_id,a.auction_asked_price, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,a.in_cart,a.fk_auction_week_id,
                    (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
                    MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,	MAX(b.bid_amount) AS last_bid_amount,highest_user(a.auction_id) as highest_user
                    FROM tbl_auction_live a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    WHERE a.auction_id IN ($auction_ids)
                    GROUP BY a.auction_id";

            if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                while($row = mysqli_fetch_assoc($rs)){
                    $dataArr[] = $row;
                }
            }

            // Data fetched for Offers
            $sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,a.in_cart,a.fk_auction_week_id,
                    COUNT(o.offer_id) AS offer_count, MAX(o.offer_amount) AS last_offer_amount
                    FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
                    WHERE a.auction_id IN ($auction_ids)
                    AND o.offer_parent_id = 0
                    GROUP BY a.auction_id";

            // All data (Bids & Offers) marged
            if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                while($row = mysqli_fetch_assoc($rs)){
                    $dataArr[] = $row;
                }
            }
        }elseif($list=='fixed' || $list=='stills'){
            $sql = "SELECT a.auction_id,a.auction_asked_price, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,a.in_cart,
                    (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
                    MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,	MAX(b.bid_amount) AS last_bid_amount,highest_user(a.auction_id) as highest_user
                    FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    WHERE a.auction_id IN ($auction_ids)
                    GROUP BY a.auction_id";

            if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                while($row = mysqli_fetch_assoc($rs)){
                    $dataArr[] = $row;
                }
            }

            // Data fetched for Offers
            $sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,a.in_cart,
                    COUNT(o.offer_id) AS offer_count, MAX(o.offer_amount) AS last_offer_amount
                    FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
                    WHERE a.auction_id IN ($auction_ids)
                    AND o.offer_parent_id = 0
                    GROUP BY a.auction_id";

            // All data (Bids & Offers) marged
            if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                while($row = mysqli_fetch_assoc($rs)){
                    $dataArr[] = $row;
                }
            }
        }elseif($list=='weekly'){
            /*$sql = "SELECT a.auction_id,a.auction_asked_price, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,
                    (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
                    MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,	MAX(b.bid_amount) AS last_bid_amount,highest_user(a.auction_id) as highest_user
                    FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    WHERE a.auction_id IN ($auction_ids)
                    GROUP BY a.auction_id";*/
            $rs=mysqli_query($GLOBALS['db_connect'],"CALL myFunction('".$auction_ids."')");


            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }

        }/*elseif($list=='stills'){
			$rs=mysqli_query($GLOBALS['db_connect'],"CALL myFunction('".$auction_ids."')");


            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
		}*/

        if(count($dataArr) > 0)	{
            return $dataArr;
        }else{
            return false;
        }
    }
	
	/*function instantUpdateOfferAuctionCron(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		 $auctions_ids = trim($auctions_ids, ',');
		
		 $sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,
				a.auction_reserve_offer_price, 	MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,
				MAX(b.bid_amount) AS last_bid_amount, MAX(o.offer_id) AS last_offer_id, COUNT(o.offer_id) AS offer_count,
				MAX(o.offer_amount) AS last_offer_amount
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
				WHERE a.auction_id IN ($auctions_ids) GROUP BY a.auction_id";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArrCron[] = $row;
		   }
		   return $dataArrCron;
		}
		return false;
	}*/
	
	/**
	 * 
	 * This function fetches the details related to auction and poster of a wantlist id .
	 * @param $wantlist_ids=>Provides the wantlist id.
	 */
	function select_wantlist_auctions($wantlist_ids)
	{
		$posterArr=explode("-",$wantlist_ids);
		if($posterArr[0]=='fixed'){
			$sql = "SELECT a.auction_id,a.is_reopened,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				a.auction_actual_end_datetime, p.fk_user_id, p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE pi.is_default = '1' and a.fk_poster_id=".$posterArr[1];
		}else{
			$sql = "SELECT a.auction_id,a.is_reopened,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				a.auction_actual_end_datetime, p.fk_user_id, p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE pi.is_default = '1' and a.fk_poster_id=".$posterArr[1];
		}		
		
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
	 * This function fetches the details related to auction and poster of a auction id .
	 * @param $auction_id=>Provides the auction id.
	 */

	function select_details_auction($auction_id,$is_fixed='')
	{
        if(!isset($_SESSION['sessUserID'])){
            $user_id='';
        }else{
            $user_id=$_SESSION['sessUserID'];
        }
		
		if($is_fixed==1){
			$count='';
		}else{
			$count=$this->isLiveAuctionItem($auction_id);
		}
		if($count<1){
			$sql = "SELECT 
				c.cat_value AS poster_size,
  				c1.cat_value AS genre,
  				c2.cat_value AS decade,
  				poster_size(p.poster_id) AS country,
  				cond(p.poster_id) AS cond,
				count(tw.watching_id) AS watch_indicator,
				count(distinct(pim.poster_image_id)) AS total_poster,
				w.auction_week_title,a.auction_id,a.is_reopened,a.fk_auction_type_id, a.auction_asked_price,a.imdb_link, a.auction_reserve_offer_price,a.is_approved_for_monthly_auction, a.auction_note,a.in_cart,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				IF((a.auction_actual_start_datetime <= NOW() AND a.auction_actual_end_datetime >= NOW()), 1, 0) is_selling,
				IF((a.auction_actual_start_datetime >= NOW()), 1, 0) is_upcoming,a.auction_is_approved,
				a.auction_is_sold, a.auction_actual_end_datetime, p.poster_id, p.poster_title, p.poster_sku,
				a.bid_count, a.max_bid_amount,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left_to_start,
				p.fk_user_id, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud,p.artist,p.quantity, p.field_1,p.field_2, p.field_3,u.username
				FROM ".USER_TABLE." u,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pim ON a.fk_poster_id = pim.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." w ON a.fk_auction_week_id = w.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
				LEFT JOIN (tbl_poster_to_category ptc 
		             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id 
					  AND c.fk_cat_type_id = 1 ) 
		  		ON a.fk_poster_id = ptc.fk_poster_id
		  		
					   
				  LEFT JOIN (tbl_poster_to_category ptc1 
				  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id 
							  AND c1.fk_cat_type_id = 2)
				  ON a.fk_poster_id = ptc1.fk_poster_id			  
							  
				  LEFT JOIN (tbl_poster_to_category ptc2 
				  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id 
							  AND c2.fk_cat_type_id = 3)
				  ON a.fk_poster_id = ptc2.fk_poster_id	
				WHERE pi.is_default = '1' and a.auction_id IN (".$auction_id.") and u.user_id=p.fk_user_id ";
		
		}else{
			$sql = "SELECT 
				c.cat_value AS poster_size,
  				c1.cat_value AS genre,
  				c2.cat_value AS decade,
  				poster_size_auction(p.poster_id) AS country,
  				cond_auction(p.poster_id) AS cond,
				count(tw.watching_id) AS watch_indicator,
				count(distinct(pim.poster_image_id)) AS total_poster,
				w.auction_week_title,a.auction_id,a.is_reopened,a.fk_auction_type_id, a.auction_asked_price,a.imdb_link, a.auction_reserve_offer_price,a.is_approved_for_monthly_auction, a.auction_note,a.in_cart,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				IF((a.auction_actual_start_datetime <= NOW() AND a.auction_actual_end_datetime >= NOW()), 1, 0) is_selling,
				IF((a.auction_actual_start_datetime >= NOW()), 1, 0) is_upcoming,a.auction_is_approved,
				a.auction_is_sold, a.auction_actual_end_datetime, p.poster_id, p.poster_title, p.poster_sku,a.max_bid_amount,a.bid_count,
				(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left_to_start,
				p.fk_user_id, p.poster_desc, pi.poster_thumb,pi.poster_image,pi.is_cloud,p.artist,p.quantity, p.field_1,p.field_2, p.field_3,u.username
				FROM ".USER_TABLE." u,tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN tbl_poster_images_live pim ON a.fk_poster_id = pim.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." w ON a.fk_auction_week_id = w.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
				LEFT JOIN (tbl_poster_to_category_live ptc 
		             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id 
					  AND c.fk_cat_type_id = 1 ) 
		  		ON a.fk_poster_id = ptc.fk_poster_id
		  		
					   
				  LEFT JOIN (tbl_poster_to_category_live ptc1 
				  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id 
							  AND c1.fk_cat_type_id = 2)
				  ON a.fk_poster_id = ptc1.fk_poster_id			  
							  
				  LEFT JOIN (tbl_poster_to_category_live ptc2 
				  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id 
							  AND c2.fk_cat_type_id = 3)
				  ON a.fk_poster_id = ptc2.fk_poster_id	
				WHERE pi.is_default = '1' and a.auction_id IN (".$auction_id.") and u.user_id=p.fk_user_id";

			
		}
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}

    function countTotalAuctionsAdmin($user_id = '', $auctionStatus = '',$start_date='',$end_date='',$auction_type='',$auction_week='')
    {
		 $sql = "SELECT
				  count(distinct(a.auction_id))as counter
				FROM user_table u,
				  tbl_poster p,
				  tbl_poster_images pi,
				  tbl_auction a 
				  LEFT JOIN (tbl_invoice_to_auction tia
				  RIGHT JOIN tbl_invoice i
					ON tia.fk_invoice_id = i.invoice_id)
					ON a.auction_id = tia.fk_auction_id
				WHERE pi.is_default = '1'
					AND a.fk_poster_id = p.poster_id
					AND a.fk_poster_id = pi.fk_poster_id
					AND u.user_id = p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0' ";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND a.auction_is_sold != '0' AND a.auction_is_sold != '3' AND a.auction_is_approved = '1' AND i.is_buyers_copy = '1' ";
		}elseif($auctionStatus == 'unsold'){
			$sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";
		}elseif($auctionStatus == 'upcoming'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_start_datetime > now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";

		}elseif($auctionStatus == 'selling'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
			          AND case when (a.fk_auction_type_id ='2' OR a.fk_auction_type_id ='5')  then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end  ";


		}elseif($auctionStatus == 'fixed'){
			$sql .= "AND a.fk_auction_type_id = '1' ";
					   
		}elseif($auctionStatus == 'weekly'){
			$sql .= "AND a.fk_auction_type_id = '2' ";
					   
		}elseif($auctionStatus == 'monthly'){
			$sql .= "AND a.fk_auction_type_id = '3' ";
					   
		}elseif($auctionStatus == 'reopen'){
			$sql .= "AND a.is_reopened = '1' ";
					   
		}elseif($auctionStatus == 'paid'){
			 $sql .= " AND i.is_paid = '1' AND  a.auction_payment_is_done_seller = '1' ";
					   
		}elseif($auctionStatus == 'unpaid'){
			$sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3' AND i.is_paid = '0'  AND i.is_buyers_copy = '1' and i.is_cancelled='0' ";
					   
		}elseif($auctionStatus == 'cancelled'){
			$sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3' AND i.is_buyers_copy = '1' and i.is_cancelled='1' ";
					   
		}elseif($auctionStatus == 'yet_to_pay'){
			$sql .= " AND i.is_paid = '1' AND a.auction_payment_is_done_seller = '0' AND i.is_buyers_copy = '1' ";
					   
		}elseif($auctionStatus == 'unapproved'){
			$sql .= " AND a.auction_is_approved = '2' ";

		}elseif($auctionStatus == 'paid_by_buyer'){
            $sql .= " AND i.is_paid = '1' AND a.auction_is_sold !='0' AND i.is_buyers_copy = '1' ";

        }
        if($auction_type == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auction_type == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auction_type == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }/*elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '5' ";
					   
		}*/elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '4' ";
					   
		}

        if($auction_week!=''){
            $sql .= " AND a.fk_auction_week_id = $auction_week ";
        }
		
		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';
			/*$sql .= " AND (( a.fk_auction_type_id = '1' AND DATE(p.up_date) >='$start_date' AND DATE(p.up_date) <='$end_date' )
			         OR (a.fk_auction_type_id = '2' AND DATE(a.auction_actual_start_datetime) >='$start_date' AND DATE(a.auction_actual_start_datetime) <='$end_date')
					 OR (a.fk_auction_type_id = '3' AND DATE(a.auction_actual_start_datetime) >='$start_date' AND DATE(a.auction_actual_start_datetime) <='$end_date'))
			";*/
			/*if($auctionStatus == ''){
				$sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."' AND i.is_buyers_copy = '1'  ";
			}else{
				$sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."'  ";
			}*/
			$sql .= " AND  DATE(a.auction_actual_start_datetime) >='".$start_date."' AND DATE(a.auction_actual_start_datetime) <='".$end_date."' ";
		}

		//echo $sql;
        //exit;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
    function fetchTotalAuctionsAdmin($user_id = '', $auctionStatus = '',$start_date='',$end_date='',$auction_type='',$auction_week='')
    {
	
		$this->orderType = 'ASC';
		$this->orderBy =$sort;
		
		$sql = "SELECT a.auction_id,
					  a.fk_poster_id,
					  a.fk_auction_type_id,
					  a.auction_asked_price,
					  a.auction_reserve_offer_price,
					  a.is_offer_price_percentage,
					  a.auction_buynow_price,
					  a.auction_actual_start_datetime,
					  a.is_approved_for_monthly_auction,
					  a.auction_actual_end_datetime,
					  a.auction_is_approved,
					  a.auction_is_sold,
					  u.firstname,
					  u.lastname,
					  p.poster_id,
					  p.poster_title,
					  p.poster_sku,
					  p.poster_desc,
					  pi.poster_thumb,
					  pi.poster_image,
					  pi.is_cloud,
					  tia.amount,
					  i.invoice_generated_on,
					  u_invoice.firstname as buyer_firstname,
					  u_invoice.lastname as buyer_lastname
					  
					FROM user_table u,
						 tbl_poster p,
						 tbl_poster_images pi,
						 tbl_auction a
					 
					 
					  LEFT JOIN (tbl_invoice_to_auction tia
					   RIGHT JOIN (tbl_invoice i
								   RIGHT JOIN user_table u_invoice
									 ON i.fk_user_id = u_invoice.user_id)
						 ON tia.fk_invoice_id = i.invoice_id)
						ON a.auction_id = tia.fk_auction_id
					WHERE pi.is_default = '1'
						AND a.fk_poster_id = p.poster_id
						AND a.fk_poster_id = pi.fk_poster_id
						AND u.user_id = p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}

        if($auctionStatus == 'pending'){
            $sql .= " AND a.auction_is_approved = '0' ";
        }elseif($auctionStatus == 'sold'){
            $sql .= "AND a.auction_is_sold != '0' AND a.auction_is_sold != '3' AND a.auction_is_approved = '1' AND i.is_buyers_copy = '1' ";
        }elseif($auctionStatus == 'unsold'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";
        }elseif($auctionStatus == 'upcoming'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_start_datetime > now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";

        }elseif($auctionStatus == 'selling'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
			          AND case when (a.fk_auction_type_id ='2' OR a.fk_auction_type_id ='5')  then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end  ";


		}elseif($auctionStatus == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auctionStatus == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auctionStatus == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }elseif($auctionStatus == 'reopen'){
            $sql .= " AND a.is_reopened = '1' ";
			
        }elseif($auctionStatus == 'paid'){
            $sql .= " AND a.auction_is_sold!='0' AND i.is_paid = '1' AND  a.auction_payment_is_done_seller = '1'   ";

        }elseif($auctionStatus == 'unpaid'){
            $sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3'  AND i.is_paid = '0'  AND i.is_buyers_copy = '1' and i.is_cancelled='0' ";

        }elseif($auctionStatus == 'cancelled'){
            $sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3'  AND i.is_buyers_copy = '1' and i.is_cancelled='1' ";

        }elseif($auctionStatus == 'yet_to_pay'){
            $sql .= " AND i.is_paid = '1' AND a.auction_payment_is_done_seller = '0' AND i.is_buyers_copy = '1' ";

        }elseif($auctionStatus == 'unapproved'){
            $sql .= " AND a.auction_is_approved = '2' ";

        }elseif($auctionStatus == 'paid_by_buyer'){
            $sql .= " AND a.auction_is_sold!='0'  AND i.is_paid = '1' AND i.is_buyers_copy = '1'  ";

        }

        if($auction_type == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auction_type == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auction_type == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }/*elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '5' ";
					   
		}*/elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '4' ";
					   
		}

        if($auction_week!=''){
            $sql .= " AND a.fk_auction_week_id = $auction_week ";
        }

		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';			
		  if($auctionStatus == ''){
				$sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."' AND i.is_buyers_copy = '1'  ";
			}else{
				$sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."'  ";
			}
		}
		
		$sql .= " GROUP BY a.auction_id " ;
		
		
		
        if($auctionStatus == 'unpaid'){
            $sql .= " ORDER BY u_invoice.firstname
				LIMIT ".$this->offset.", ".$this->toShow."";
        }elseif($auctionStatus == 'paid'){
            $sql .= " ORDER BY u.firstname
				LIMIT ".$this->offset.", ".$this->toShow."";
        }elseif($auctionStatus == 'yet_to_pay'){
            $sql .= " ORDER BY i.invoice_id
				LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($auctionStatus == 'paid_by_buyer'){
            $sql .= " ORDER BY u_invoice.firstname
				LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($auctionStatus == 'sold'){
            $sql .= " ORDER BY u.firstname
				LIMIT ".$this->offset.", ".$this->toShow."";

        }else{
            $sql .= " ORDER BY p.poster_title
				LIMIT ".$this->offset.", ".$this->toShow."";

        }

		//echo $sql;
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	function fetchTotalAmountPaidByAdmin($user_id = '', $start_date='',$end_date='',$auction_week_id=''){
		$sql="Select SUM(payment_amount) as payment_amount from tbl_mpe_admin_payment_to_seller ";
		if($user_id!=''){
		$sql.=" where user_id = '".$user_id."' ";
		}
		if($start_date != ""){
			$start_date = $start_date.' 00:00:00';
			$sql .= " AND DATE(payment_date) >='$start_date' ";
		}
		if($end_date != ""){
			$end_date = $end_date.' 24:00:00';
			$sql .= " AND DATE(payment_date) <='$end_date' ";
		}
		if($auction_week_id!=''){
			$sql .= " AND auction_week_id  ='$auction_week_id' ";
		}
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		$row = mysqli_fetch_assoc($rs);
		$amount=$row['payment_amount'];
		}
		//echo $sql;
		return $amount;
	}
	
	function bidWinnerForReport($auction_id){
		$sql="Select u.firstname as winnerFname,u.lastname as winnerLname from user_table u,tbl_bid tb where tb.bid_fk_auction_id=$auction_id and tb.bid_is_won='1' and tb.bid_fk_user_id=u.user_id";
		$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
		$res=mysqli_fetch_array($res_sql);
		$tot_row=mysqli_num_rows($res_sql);
		if($tot_row >0){
			return $winnerName=$res['winnerFname'].' '.$res['winnerLname'];
			
		}else{
			return $winnerName='';
		}
	
	}
	
	function offerWinnerForReport($id){
		$sql ="SELECT u.firstname, u.lastname,
				ofr.offer_id, cntr_ofr.offer_id AS cntr_offer_id, ofr.offer_is_accepted, cntr_ofr.offer_is_accepted cntr_offer_is_accepted, 
				ofr.offer_amount, cntr_ofr.offer_amount AS cntr_offer_amount
				FROM user_table u, tbl_poster p, tbl_auction a ,`tbl_offer` ofr
				LEFT JOIN `tbl_offer` cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id 
				WHERE( ofr.offer_fk_auction_id =$id OR cntr_ofr.offer_fk_auction_id =$id )
				AND (ofr.offer_is_accepted = '1' or cntr_ofr.offer_is_accepted = '1') 
				AND ofr.offer_parent_id=0 AND ofr.offer_fk_user_id=u.user_id 
				AND ofr.offer_fk_auction_id = a.auction_id AND a.fk_poster_id = p.poster_id";		
	//$sql="Select u.firstname as winnerFname,u.lastname as winnerLname from user_table u,tbl_offer tbo where tbo.offer_fk_auction_id=$auction_id and tbo.offer_is_accepted='1' and tbo.offer_fk_user_id=u.user_id";
		$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
		$res=mysqli_fetch_array($res_sql);
		$tot_row=mysqli_num_rows($res_sql);
		if($tot_row >0){
			return $winnerName=$res['winnerFname'].' '.$res['winnerLname'];
		}else{
			return $winnerName='';
		}
	}
	
	function fetchWinnerAndSoldPrice(&$dataAuction){
		for($i=0;$i<count($dataAuction);$i++){
			if($dataAuction[$i]['fk_auction_type_id']=='1' && $dataAuction[$i]['auction_is_sold']=='1'){
				$sql ="SELECT u.firstname winnerFname, u.lastname winnerLname,
					ofr.offer_id, cntr_ofr.offer_id AS cntr_offer_id, ofr.offer_is_accepted, cntr_ofr.offer_is_accepted cntr_offer_is_accepted, 
					ofr.offer_amount, cntr_ofr.offer_amount AS cntr_offer_amount
					FROM user_table u, tbl_poster p, tbl_auction a ,`tbl_offer` ofr
					LEFT JOIN `tbl_offer` cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id 
					WHERE( ofr.offer_fk_auction_id ='".$dataAuction[$i]['auction_id']."' OR cntr_ofr.offer_fk_auction_id ='".$dataAuction[$i]['auction_id']."' )
					AND (ofr.offer_is_accepted = '1' or cntr_ofr.offer_is_accepted = '1') 
					AND ofr.offer_parent_id=0 AND ofr.offer_fk_user_id=u.user_id 
					AND ofr.offer_fk_auction_id = a.auction_id AND a.fk_poster_id = p.poster_id";
	//$sql="Select u.firstname as winnerFname,u.lastname as winnerLname from user_table u,tbl_offer tbo where tbo.offer_fk_auction_id=$auction_id and tbo.offer_is_accepted='1' and tbo.offer_fk_user_id=u.user_id";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$tot_row=mysqli_num_rows($res_sql);
				if($tot_row >0){
					$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
					if($res['offer_is_accepted']=='1'){
						$dataAuction[$i]['soldamnt']=$res['offer_amount'];
					}elseif($res['cntr_offer_is_accepted']=='1'){
						$dataAuction[$i]['soldamnt']=$res['cntr_offer_amount'];
					}else{
						$dataAuction[$i]['soldamnt']='';
					}
				}else{
					$dataAuction[$i]['winnerName']='';
				}	
			}elseif(($dataAuction[$i]['fk_auction_type_id']=='2' || $dataAuction[$i]['fk_auction_type_id']=='3' || $dataAuction[$i]['fk_auction_type_id']=='5') && $dataAuction[$i]['auction_is_sold']=='1'){
					
				$sql="Select u.firstname as winnerFname,u.lastname as winnerLname,tb.bid_amount from user_table u,tbl_bid tb where tb.bid_fk_auction_id='".$dataAuction[$i]['auction_id']."' and tb.bid_is_won='1' and tb.bid_fk_user_id=u.user_id";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$tot_row=mysqli_num_rows($res_sql);
				if($tot_row >0){
					$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
					$dataAuction[$i]['soldamnt']=$res['bid_amount'];
				}else{
					$dataAuction[$i]['winnerName']='';
					$dataAuction[$i]['soldamnt']='';
				}
			}elseif($dataAuction[$i]['auction_is_sold']=='2'){
				$sql="Select u.firstname as winnerFname,u.lastname as winnerLname,tia.amount 
			  		  from user_table u,tbl_invoice ti,tbl_invoice_to_auction tia 
			  		  where tia.fk_auction_id='".$dataAuction[$i]['auction_id']."' and tia.fk_invoice_id=ti.invoice_id and ti.fk_user_id=u.user_id and ti.is_buyers_copy='1'";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$tot_row=mysqli_num_rows($res_sql);
				if($tot_row >0){
					$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
					$dataAuction[$i]['soldamnt']=$res['amount'];
				}else{
					$dataAuction[$i]['winnerName']='';
					$dataAuction[$i]['soldamnt']='';
				}
			}
			
		}
		return $dataAuction;
	}
	
	function fetchSoldPriceForSeller(&$dataAuction){
		for($i=0;$i<count($dataAuction);$i++){
			if(($dataAuction[$i]['fk_auction_type_id']=='1' || $dataAuction[$i]['fk_auction_type_id']=='4') && $dataAuction[$i]['auction_is_sold']=='1'){
				 $sql ="SELECT u.firstname winnerFname, u.lastname winnerLname,
					ofr.offer_id, cntr_ofr.offer_id AS cntr_offer_id, ofr.offer_is_accepted, cntr_ofr.offer_is_accepted cntr_offer_is_accepted, 
					ofr.offer_amount, cntr_ofr.offer_amount AS cntr_offer_amount
					FROM user_table u, tbl_poster p, tbl_auction a ,`tbl_offer` ofr
					LEFT JOIN `tbl_offer` cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id 
					WHERE( ofr.offer_fk_auction_id ='".$dataAuction[$i]['auction_id']."' OR cntr_ofr.offer_fk_auction_id ='".$dataAuction[$i]['auction_id']."' )
					AND (ofr.offer_is_accepted = '1' or cntr_ofr.offer_is_accepted = '1') 
					AND ofr.offer_parent_id=0 AND ofr.offer_fk_user_id=u.user_id 
					AND ofr.offer_fk_auction_id = a.auction_id AND a.fk_poster_id = p.poster_id";
	//$sql="Select u.firstname as winnerFname,u.lastname as winnerLname from user_table u,tbl_offer tbo where tbo.offer_fk_auction_id=$auction_id and tbo.offer_is_accepted='1' and tbo.offer_fk_user_id=u.user_id";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$tot_row=mysqli_num_rows($res_sql);
				if($tot_row >0){
					$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
					if($res['offer_is_accepted']=='1'){
						$dataAuction[$i]['soldamnt']=$res['offer_amount'];
					}elseif($res['cntr_offer_is_accepted']=='1'){
						$dataAuction[$i]['soldamnt']=number_format(($res['cntr_offer_amount']), 2, '.', '');
					}else{
						$dataAuction[$i]['soldamnt']='';
					}
				}else{
					$dataAuction[$i]['winnerName']='';
				}	
			}elseif(($dataAuction[$i]['fk_auction_type_id']=='2' || $dataAuction[$i]['fk_auction_type_id']=='3' || $dataAuction[$i]['fk_auction_type_id']=='5') && $dataAuction[$i]['auction_is_sold']=='1'){
					
				$sql="Select u.firstname as winnerFname,u.lastname as winnerLname,tb.bid_amount from user_table u,tbl_bid_archive tb where tb.bid_fk_auction_id='".$dataAuction[$i]['auction_id']."' and tb.bid_is_won='1' and tb.bid_fk_user_id=u.user_id";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$tot_row=mysqli_num_rows($res_sql);
				if($tot_row >0){
					$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
					$dataAuction[$i]['soldamnt']=number_format(($res['bid_amount']), 2, '.', '');
				}else{
					$dataAuction[$i]['winnerName']='';
					$dataAuction[$i]['soldamnt']='';
				}
			}elseif($dataAuction[$i]['auction_is_sold']=='2'){
				$sql="Select u.firstname as winnerFname,u.lastname as winnerLname,tia.amount 
			  		  from user_table u,tbl_invoice ti,tbl_invoice_to_auction tia 
			  		  where tia.fk_auction_id='".$dataAuction[$i]['auction_id']."' and tia.fk_invoice_id=ti.invoice_id and ti.fk_user_id=u.user_id and ti.is_buyers_copy='1'";
				$res_sql=mysqli_query($GLOBALS['db_connect'],$sql);
				$res=mysqli_fetch_array($res_sql);
				$dataAuction[$i]['winnerName']=$res['winnerFname'].' '.$res['winnerLname'];
				$dataAuction[$i]['soldamnt']=$res['amount'];
			}
			
		}
		return $dataAuction;
	}
	
	/*function get_image_array($poster_id){
		$sql="Select pi.poster_image,a.auction_id,pi.is_default
			  from ".TBL_POSTER_IMAGES." as pi,".TBL_AUCTION." a
			  where pi.fk_poster_id=$poster_id and pi.fk_poster_id=a.fk_poster_id"; 
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $imageArr[] = $row;
		   }
		   return $imageArr;
		}
		return false;
	}*/
	
	function select_details_auction_byId($auction_id)
	{
		$count=$this->isLiveAuctionItem($auction_id);
		if($count<1){
			$sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.is_approved_for_monthly_auction,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime, p.poster_id, p.poster_title, p.poster_sku,
					p.poster_desc, pi.poster_thumb,pi.poster_image
					FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					WHERE pi.is_default = '1' and a.auction_id IN (".$auction_id.")";
		}else{
			$sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.is_approved_for_monthly_auction,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime, p.poster_id, p.poster_title, p.poster_sku,
					p.poster_desc, pi.poster_thumb,pi.poster_image
					FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					WHERE pi.is_default = '1' and a.auction_id IN (".$auction_id.")";
		}
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_assoc($rs)){
				$dataArr[] = $row;
			}
			return $dataArr;
		}
		return false;
	}
	
	function select_details_auction_by_bid($auction_id)
	{
		
			
			$sql = "SELECT a.auction_id, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.is_approved_for_monthly_auction,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime, p.poster_id, p.poster_title, p.poster_sku,
					p.poster_desc, pi.poster_thumb,pi.poster_image
					FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					WHERE pi.is_default = '1' and a.auction_id IN (".$auction_id.")";
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			while($row = mysqli_fetch_assoc($rs)){
				$dataArr[] = $row;
			}
			return $dataArr;
		}
		return false;
	}

	function fetchLiveAuctionsHomePage($fetch = '')
	{
        if(!isset($_SESSION['sessUserID'])){
            $user_id='';
        }else{
            $user_id=$_SESSION['sessUserID'];
        }
		if($fetch == 'weekly'){
			$sql = "SELECT tw.watching_id AS watch_indicator,a.auction_id, a.fk_auction_type_id, a.auction_asked_price,
					a.auction_buynow_price,
					p.poster_id, p.poster_title,pi.poster_thumb,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount
					FROM tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
					WHERE pi.is_default = '1'";
		}else{
			$sql = "SELECT tw.watching_id AS watch_indicator,a.auction_id, a.fk_auction_type_id, a.auction_asked_price,
				a.auction_buynow_price,
				p.poster_id, p.poster_title,pi.poster_thumb,pi.is_cloud,
				a.max_bid_amount AS last_bid_amount
				FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
				WHERE pi.is_default = '1'";
		}	
		if($fetch == 'fixed'){
			$sql .= " AND (a.fk_auction_type_id = '1' AND  a.auction_is_sold = '0' AND a.auction_is_approved = '1' ) AND a.slider_first_position_status = '0'";
			$to=11;
			
			$selectFirstPosterInfo = "SELECT tw.watching_id AS watch_indicator,a.auction_id, a.fk_auction_type_id, a.auction_asked_price,
			a.auction_buynow_price,a.slider_first_position_status,
			p.poster_id, p.poster_title, pi.poster_thumb,pi.is_cloud
			FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
			INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
			LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
			WHERE a.slider_first_position_status = '1' AND pi.is_default = '1' AND (a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0') 
			
			";			
			
		}elseif($fetch == 'weekly'){
            $sql .= " AND (a.fk_auction_type_id = '2' AND a.auction_is_sold = '0' AND a.auction_is_approved = '1' ) AND a.slider_first_position_status = '0' AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() ";
            $to=11;

            $selectFirstPosterInfo = "SELECT tw.watching_id AS watch_indicator,a.auction_id,a.is_reopened, a.fk_auction_type_id, a.auction_asked_price,
			a.auction_buynow_price,
			p.poster_id, p.poster_title, pi.poster_thumb,pi.is_cloud,
			a.max_bid_amount AS last_bid_amount
			FROM tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
			INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
			LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
			WHERE a.slider_first_position_status = '1' AND pi.is_default = '1' AND (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' )
			AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()
			";

        }elseif($fetch == 'monthly'){
			$sql .= " AND (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1'
						   AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
			$to=6;
		}else{
			$sql .= " AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
					OR (a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())
					OR (a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
						AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";		
		}
		
		if($fetch == 'fixed'){
			$rsfirstPosterInfo = mysqli_query($GLOBALS['db_connect'],$selectFirstPosterInfo);
			$firstPosterInfo = mysqli_fetch_assoc($rsfirstPosterInfo);
			if($firstPosterInfo['poster_thumb']!=''){
				$dataArr[] = $firstPosterInfo;
			}else{
				$to=12;
			}
		}
        if($fetch == 'weekly'){
            $rsfirstPosterInfo = mysqli_query($GLOBALS['db_connect'],$selectFirstPosterInfo);
			if($rsfirstPosterInfo){
				$firstPosterInfo = mysqli_fetch_assoc($rsfirstPosterInfo);
				if($firstPosterInfo['poster_thumb']!=''){
					$dataArr[] = $firstPosterInfo;
				}else{
					$to=12;
				}
			}
            
            
        }
		if($fetch != 'weekly'){
		
			 $sql .= " AND a.auction_id >= FLOOR(1 + RAND() * (SELECT
										MAX(auction_id)
									  FROM tbl_auction))
					  GROUP BY a.auction_id				  
					  LIMIT 0, $to";
		}else{
			 $sql .= " ORDER BY RAND() LIMIT 0, $to ";
		}
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}

    function countJstFinishedAuction($title='',$user_id='',$type='',$auction_type='',$auction_week_id='')
    {
        $sql = "SELECT COUNT(distinct(a.auction_id)) AS counter
				FROM ".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE  a.auction_is_approved = '1' AND  a.auction_is_sold IN ('1','2')
				AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
				AND pi.is_default = '1'
				";
        if($title!=''){
			$sql.=" AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' )";
        }
        if($user_id!=''){
            $sql.=" AND	p.fk_user_id = ".$user_id;
        }
        if($type=='Home'){
            $sql.=" AND	a.is_deleted ='0' ";
        }
        if($auction_type=='weekly'){
            $sql.=" AND	a.fk_auction_type_id ='2' ";
        }
        elseif($auction_type=='fixed'){
            $sql.=" AND a.fk_auction_type_id IN ('1','4') ";
        }
		elseif($auction_type=='stills'){
            $sql.=" AND a.fk_auction_type_id ='5' ";
        }
		
        if($auction_week_id!=''){
            $sql.=" AND a.fk_auction_week_id = $auction_week_id ";
        }

        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);
        return $row['counter'];


    }

    function soldAuction($isOrdered = false, $isLimit = false,$title='',$user_id='',$type='',$is_sold='',$sort_by='',$auction_type='',$auction_week_id='')
    {
        $sql = "SELECT
		 		a.auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_buynow_price,
				 pi.poster_image,
		 		p.poster_id, p.poster_title,  pi.poster_thumb,pi.is_cloud,a.fk_auction_week_id
				FROM ".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a,".TBL_POSTER." p , ".TBL_POSTER_IMAGES." pi				
					WHERE a.auction_is_approved = '1' 
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id AND i.is_buyers_copy = '1' 
					AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.fk_poster_id = pi.fk_poster_id
				";
        if($title !=''){
            $sql.=" AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' )";
        }
        if($user_id!=''){
            $sql.=" AND	p.fk_user_id = ".$user_id;
        }
        if($type=='Home'){
            $sql.=" AND	a.is_deleted ='0' ";
        }
        if($auction_type=='weekly'){
            $sql.=" AND	a.fk_auction_type_id ='2' AND  a.auction_is_sold = '1' ";
        }
        elseif($auction_type=='fixed'){
            $sql.=" AND a.fk_auction_type_id IN ('1','4') AND  a.auction_is_sold IN ('1','2') ";
        }
		elseif($auction_type=='stills'){
            $sql.=" AND a.fk_auction_type_id ='5' AND  a.auction_is_sold IN ('1','2') ";
        }else{
			$sql.=" AND  a.auction_is_sold IN ('1','2') ";
		}
        if($auction_week_id!=''){
            $sql.=" AND a.fk_auction_week_id = $auction_week_id ";
        }
        $sql.=" group by a.auction_id ";
        if($is_sold!='sold'){
            if($isOrdered){
			   /*$sql = $sql." ORDER BY ".$this->orderBy." ".$this->orderType;*/
			   if($this->orderBy=='auction_id'){
				$sql .= " ORDER BY tia.amount DESC ";
			   }else{
			    $sql = $sql." ORDER BY ".$this->orderBy." ".$this->orderType;
			   }
		   }
            if($isLimit){
                $sql = $sql." LIMIT ".$this->offset.",".$this->toShow;
            }
        }else{
            if($sort_by=='price'){
                $sql .= " ORDER BY a.auction_asked_price DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='title'){
                $sql .= " ORDER BY p.poster_title ASC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='listing_date'){
                if($auctionStatus=='upcoming'){
                    $this->orderType="ASC";
                }else{
                    $this->orderType="DESC";
                }
                $sql .= " ORDER BY
					case when a.fk_auction_type_id ='2'  then a.auction_actual_start_datetime when a.fk_auction_type_id ='4'  then p.up_date  else p.up_date end
					".$this->orderType."
				    LIMIT ".$this->offset.", ".$this->toShow." ";
                /*$sql .= " ORDER BY
                        case when a.fk_auction_type_id !='1'  then a.auction_actual_start_datetime  else p.up_date end,
                        a.auction_actual_start_datetime,p.up_date  DESC
                        LIMIT ".$this->offset.", ".$this->toShow."";*/
                /* $sql.=" ORDER BY CASE a.fk_auction_type_id WHEN 1 THEN p.up_date  DESC
                         ELSE WHEN a.fk_auction_type_id <> 1 THEN a.auction_actual_start_datetime DESC END
                        LIMIT ".$this->offset.", ".$this->toShow." "	;	*/
            }elseif($sort_by=='uploaded_date'){
                $sql .= " ORDER BY p.post_date DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='sold_date'){
                $sql .= " ORDER BY i.invoice_generated_on DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }else{
                $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType."
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }
        }
        //echo $sql;
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }

function soldAuctionCOUNTFIXED($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,e.event_title,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		  $count = mysqli_num_rows($rs);	
		   
		   return $count;
		}
		return false;
	
		
	}   
   
function soldAuctionFIXED($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,i.is_shipped,i.shipped_date,i.invoice_id,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				
				
					WHERE a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2') ) AND i.is_buyers_copy = '1' ";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	
		
	}
function soldAuctionCOUNTWEEKLY($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,e.event_title,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $total = mysqli_num_rows($rs);
		   return $total;
		}
		return false;
	
		
	}	
	
function soldAuctionWEEKLY($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,e.event_title,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	
		
	}
function soldAuctionCOUNTMONTHLY($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,e.event_title,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $total=mysqli_num_rows($rs);
		   return $total;
		}
		return false;
	
		
	}
function soldAuctionMONTHLY($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,e.event_title,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '3' AND a.auction_is_approved = '1' AND a.is_approved_for_monthly_auction = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0')";
		}elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	
		
	}
    
   
	function fetchJstFinishedAuction() 
	{ 
		
		 $selectFirstPosterInfo = "SELECT distinct(a.auction_id), a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
		    a.slider_first_position_status,p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
		    FROM ".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
		    INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
		    INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
		    WHERE a.slider_first_position_status = '1' AND a.auction_is_approved = '1' AND a.fk_auction_type_id IN( '1','2','3')
		    AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
		    AND pi.is_default = '1' 
		    ";
		   
		  $limit = 12;
		  $rsfirstPosterInfo = mysqli_query($GLOBALS['db_connect'],$selectFirstPosterInfo);
		  if(mysqli_num_rows($rsfirstPosterInfo) > 0){ 
		   $firstPosterInfo = mysqli_fetch_assoc($rsfirstPosterInfo);
		   $dataArr[] = $firstPosterInfo;
		   $limit = 11;
		  }
		  
		  $sql = "SELECT distinct(a.auction_id), a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
		  p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
		  FROM ".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
		  INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
		  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
		  WHERE a.auction_is_approved = '1' AND a.fk_auction_type_id IN( '1','2','3')
		  AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
		  AND pi.is_default = '1'
		  AND a.slider_first_position_status != '1' 
		  AND a.auction_id >= FLOOR(1 + RAND() * (SELECT
                                    MAX(auction_id)
                                  FROM tbl_auction))
				   LIMIT 0,$limit ";
		  
		    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		     while($row = mysqli_fetch_assoc($rs)){
		      $dataArr[] = $row;
		     }
		     return $dataArr;
		    }
		    return false;
		}
   
   function fetchEditAuctionDetail($auction_id,$chkLive='')
   {
		if($chkLive>0){
			
			$sql = "SELECT p.poster_title, p.poster_sku, p.poster_desc, p.flat_rolled, 
				aw.auction_week_title, aw.auction_week_start_date, aw.auction_week_end_date, a.fk_poster_id, a.auction_is_approved, a.fk_auction_type_id,a.auction_is_sold,
				a.fk_event_id, a.fk_auction_week_id, a.auction_asked_price,
				a.auction_note, IF((a.auction_actual_start_datetime <= NOW()), 1, 0) is_selling, a.auction_is_approved,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,p.artist,p.quantity,a.imdb_link		
				FROM tbl_poster_live p, tbl_auction_live a
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id 
				WHERE p.poster_id = a.fk_poster_id
				AND a.auction_id = '".$auction_id."'";
		
		}else{
			$sql = "SELECT p.poster_title, p.poster_sku, p.poster_desc, p.flat_rolled, 
					aw.auction_week_title, aw.auction_week_start_date, aw.auction_week_end_date, a.fk_poster_id, a.auction_is_approved, a.fk_auction_type_id,a.auction_is_sold,
					a.fk_event_id, a.fk_auction_week_id, a.auction_asked_price, a.auction_reserve_offer_price, a.is_offer_price_percentage,
					a.auction_buynow_price,	a.auction_note, IF((a.auction_actual_start_datetime <= NOW()), 1, 0) is_selling, a.auction_is_approved,
					a.auction_actual_start_datetime, a.auction_actual_end_datetime,a.imdb_link,p.artist,p.quantity,p.field_1,p.field_2,p.field_3		
					FROM ".TBL_POSTER." p, ".TBL_AUCTION." a
					LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
					LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id 
					WHERE p.poster_id = a.fk_poster_id
					AND a.auction_id = '".$auction_id."'";
		}		
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
	
	function sellerInvoicePrice($auction_id){
		$sql="Select tia.amount 
			  from tbl_invoice ti,tbl_invoice_to_auction tia 
			  where tia.fk_auction_id=$auction_id and tia.fk_invoice_id=ti.invoice_id and  ti.is_buyers_copy='0'";
		if($rs = mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql))){
			return $rs['amount'];
		}
	}
	
	function fetchHighestOfferCountOffer(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			if($dataArr[$i]['fk_auction_type_id'] == 1){
				$auction_ids .= $dataArr[$i]['auction_id'].",";
			}
		}
		$auction_ids = trim($auction_ids, ',');
		
		$sql = "SELECT offer_fk_auction_id, COUNT(offer_id) AS offer_count,
				MAX(offer_amount) AS last_offer_amount, MAX(post_date) AS last_offer_post_date
				FROM ".TBL_OFFER."
				WHERE offer_fk_auction_id IN ($auction_ids)
				AND offer_parent_id = '0'
				GROUP BY offer_fk_auction_id";
		
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }
			
		for($j=0;$j<count($offerArr);$j++){
			for($i=0;$i<count($dataArr);$i++){
				if($dataArr[$i]['auction_id'] == $offerArr[$j]['offer_fk_auction_id']){					
					$dataArr[$i]['offer_count'] = $offerArr[$j]['offer_count'];
					$dataArr[$i]['last_offer_amount'] = $offerArr[$j]['last_offer_amount'];
					$dataArr[$i]['last_offer_post_date'] = $offerArr[$j]['last_offer_post_date'];
				}				
			}			
		}	
		return;
	}
	
	function fetchHighestBidCountBid(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			if($dataArr[$i]['fk_auction_type_id'] != 1){
				$auction_ids .= $dataArr[$i]['auction_id'].",";
			}
		}
		$auction_ids = trim($auction_ids, ',');
		
		$sql = "SELECT bid_fk_auction_id, COUNT(bid_id) AS bid_count,
				MAX(bid_amount) AS last_bid_amount, MAX(post_date) AS last_bid_post_date
				FROM ".TBL_BID."
				WHERE bid_fk_auction_id IN ($auction_ids)
				GROUP BY bid_fk_auction_id";
		
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidArr[] = $row;
		   }
	    }
			
		for($j=0;$j<count($bidArr);$j++){
			for($i=0;$i<count($dataArr);$i++){
				if($dataArr[$i]['auction_id'] == $bidArr[$j]['bid_fk_auction_id']){					
					$dataArr[$i]['bid_count'] = $bidArr[$j]['bid_count'];
					$dataArr[$i]['last_bid_amount'] = $bidArr[$j]['last_bid_amount'];
					$dataArr[$i]['last_bid_post_date'] = $bidArr[$j]['last_bid_post_date'];
				}				
			}			
		}
		return;
	}
	function paymentDetailsSeller($user_id='',$start_date='',$end_date=''){
		$sql="Select * from ".TBL_MPE_ADMIN_PAYMENT_TO_SELLER." where user_id= $user_id ";
		if($start_date != ""){
			$sql .= " AND DATE(payment_date) >='$start_date' ";
			}
		if($end_date != ""){
		$sql .= " AND DATE(payment_date) <='$end_date' ";
		}
		$sql .="ORDER BY payment_date DESC ";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidArr[] = $row;
		   }
	    }
	    return $bidArr;
	}
 	/*function OrderBySoldPrice($isOrdered = false, $isLimit = false){
     	 $sql=" Select * from `tbl_temp`";
     	 if($isOrdered){
			   $sql = $sql." ORDER BY ".$this->orderBy." ".$this->orderType;
		   }	
     	if($isLimit){
			   $sql = $sql." LIMIT ".$this->offset.",".$this->toShow;
		   }
     	 if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   		while($row = mysqli_fetch_assoc($rs)){
			   	$dataArr[] = $row;
		   		}
			}	
			return $dataArr;
     }*/
	 function countAuctionsByStatus_upcoming($keyword,$search_type='',$auction_week='',$list='')
	 {
         $sql = " SELECT distinct(a.auction_id)
				FROM  ".TBL_AUCTION." a , ".TBL_POSTER." p ,".TBL_AUCTION_WEEK." aw WHERE a.fk_poster_id = p.poster_id
				 AND  a.auction_is_approved = '1' AND a.auction_is_sold = '0' 
				 AND a.auction_actual_start_datetime > now() AND a.fk_auction_week_id = aw.auction_week_id AND aw.is_test='0' ";

		if($list=='stills'){
			 $sql .= " AND a.fk_auction_type_id = '5' " ;
		}else{
			 $sql .= "AND ((a.fk_auction_type_id = '2'
							)
						OR (a.fk_auction_type_id = '5'  
							))";
		}				
		 if($auction_week !=''){
		 	$sql .= " AND a.fk_auction_week_id= '".$auction_week."' " ;
		 }				
         if($keyword != ''){
            $sql .= " AND (";
            $split_stemmed = explode(" ",$keyword);
            $totKey=count($split_stemmed);
            if($totKey>1){
                if(($search_type=='title_desc' || $search_type=='')){
                    $newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }elseif($search_type=='title'){
                    $newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
				
                if($rs = mysqli_query($GLOBALS['db_connect'],$newSql)){
                    while($counter = mysqli_fetch_assoc($rs)){
                        $rowNew[]=$counter['auction_id'];
                    }
                }

                $i=1;
                while(list($key,$val)=each($split_stemmed)){

                    if($val<>" " and strlen($val) > 0 and ($search_type=='title_desc' || $search_type=='')){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }elseif($val<>" " and strlen($val) > 0 and $search_type=='title'){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }
                    $i++;
                    if($rs = mysqli_query($GLOBALS['db_connect'],$i)){
                        while($counter = mysqli_fetch_assoc($rs)){
                            $row[]=$counter['auction_id'];
                        }
                    }
                }
                if(!empty($row)){
                foreach(array_count_values($row)as $key=>$val){
                    if($val==$totKey){
                        $rowNew[]=$key;
                    }
                }
               }

            }else{
                if(($search_type=='title_desc' || $search_type=='')){
                    $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }elseif($search_type=='title'){
                    $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
                if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                    while($counter = mysqli_fetch_assoc($rs))
                        $rowNew[]=$counter['auction_id'];
                }
            }
            // $sql.= ")";
        }

         if(!empty($rowNew)){
            return array_unique(($rowNew));
        }else{
            return false;
        }

     }
	 function fetchAuctionsByStatus_upcoming($keyword,$sort_by='',$arrayList='',$search_type=''){
	 
         $sql = "SELECT
	 	        c.cat_value AS poster_size,
                c1.cat_value AS genre,
                c2.cat_value AS decade,
                poster_size(p.poster_id) AS country,
                cond(p.poster_id) AS cond,
            	a.auction_id,a.fk_poster_id,a.auction_is_approved, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price,a.auction_note, a.auction_actual_start_datetime, a.auction_actual_end_datetime, e.event_title,aw.auction_week_title,
				(UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  LEFT JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  LEFT JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id
				WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND
				a.auction_actual_start_datetime > now() ";
				
		 $sql .= "AND ((a.fk_auction_type_id = '2'
						)
					OR (a.fk_auction_type_id = '5'  
						))";
         $sql .= " AND a.auction_id IN ($arrayList) ";
		 
		 
         if($sort_by=='price'){
             $sql .= " ORDER BY a.auction_asked_price DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
         }elseif($sort_by=='title'){
             $sql .= " ORDER BY p.poster_title ASC
				    LIMIT ".$this->offset.", ".$this->toShow."";
         }elseif($sort_by=='listing_date'){
             if($auctionStatus=='upcoming'){
                 $this->orderType="ASC";
             }else{
                 $this->orderType="DESC";
             }
             $sql .= " ORDER BY
					case when a.fk_auction_type_id !='1'  then a.auction_actual_start_datetime  else p.up_date end 
					".$this->orderType." 
				    LIMIT ".$this->offset.", ".$this->toShow." ";
             /*$sql .= " ORDER BY
                       case when a.fk_auction_type_id !='1'  then a.auction_actual_start_datetime  else p.up_date end,
                       a.auction_actual_start_datetime,p.up_date  DESC
                       LIMIT ".$this->offset.", ".$this->toShow."";*/
             /* $sql.=" ORDER BY CASE a.fk_auction_type_id WHEN 1 THEN p.up_date  DESC
                        ELSE WHEN a.fk_auction_type_id <> 1 THEN a.auction_actual_start_datetime DESC END
                       LIMIT ".$this->offset.", ".$this->toShow." "	;	*/
         }elseif($sort_by=='uploaded_date'){
             $sql .= " ORDER BY p.post_date DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
         }elseif($sort_by=='sold_date'){
             $sql .= " ORDER BY i.invoice_generated_on DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
         }else{
             $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType."
				    LIMIT ".$this->offset.", ".$this->toShow."";
         }
         if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
             while($row = mysqli_fetch_assoc($rs)){
                 $dataArr[] = $row;
             }
             //$this->fetchHighestOfferCountOffer($dataArr);
             //$this->fetchHighestBidCountBid($dataArr);
             return $dataArr;
         }
     }
	 function fetchLiveAuctionsTest($fetch = '', $poster_ids = '')
	{
		/*$sql = "SELECT a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime, e.event_title,
				p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,
				COUNT(b.bid_id) AS bid_count, max(b.bid_amount) AS last_bid_amount, max(b.post_date) AS last_bid_post_date,
				COUNT(o.offer_id) AS offer_count, max(o.offer_amount) AS last_offer_amount, max(o.post_date) AS last_offer_post_date
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
				LEFT JOIN ".TBL_OFFER." o ON a.auction_id = o.offer_fk_auction_id
				WHERE pi.is_default = '1' ";*/
				
		$sql = "SELECT 
					   c.cat_value AS poster_size,
  					   c1.cat_value AS genre,
  					   c2.cat_value AS decade,
  					   poster_size(p.poster_id) AS country,
  					   cond(p.poster_id) AS cond,
					   count(tw.watching_id) AS watch_indicator,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.auction_reserve_offer_price,
					   a.fk_event_id ,
					   a.fk_auction_week_id ,
					   a.is_offer_price_percentage,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  e.event_title,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  p.poster_sku,
					  p.poster_desc,
					  pi.poster_thumb
					  FROM 
							tbl_poster_to_category ptc,
  							tbl_category c,
  							tbl_poster_to_category ptc1,
  							tbl_category c1,
  							tbl_poster_to_category ptc2,
  							tbl_category c2,
							".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$_SESSION['sessUserID']."' 
													  WHERE pi.is_default = '1' 
													  AND a.auction_is_approved = '1'
													  AND a.auction_is_sold = '0'
													  AND ptc.fk_poster_id = p.poster_id 
													  AND ptc.fk_cat_id = c.cat_id 
													  AND c.fk_cat_type_id = 1 
													  AND ptc1.fk_poster_id = p.poster_id 
													  AND ptc1.fk_cat_id = c1.cat_id 
													  AND c1.fk_cat_type_id = 2 
													  AND ptc2.fk_poster_id = p.poster_id 
													  AND ptc2.fk_cat_id = c2.cat_id 
													  AND c2.fk_cat_type_id = 3 
													 ";
			
		if($fetch == 'fixed'){
			$sql .= " AND (a.fk_auction_type_id = '1' )";
		}elseif($fetch == 'weekly'){
			$sql .= " AND (a.fk_auction_type_id = '2' 
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}elseif($fetch == 'monthly'){
		 	$sql .= " AND (a.fk_auction_type_id = '3' 
						   AND a.is_approved_for_monthly_auction = '1' 
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}else{
			$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end ";		
		}
		if($fetch == 'monthly'){
			$this->orderBy=" a.fk_event_id ";
		}
		if($fetch == 'weekly'){
			$this->orderBy=" a.fk_auction_week_id ";
		}
		$sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
		//echo 	$sql;	
		//die();
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	}	
	/**
	 * 
	 * This function counts the no of the fixed price auctions by status for Home Page .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	
	function countFixedPriceSaleByStatusHome($auctionStatus = '', $search_fixed_poster=''){
		if($auctionStatus == 'sold'){
			$sql = "SELECT count(distinct(a.auction_id)) AS counter,a.auction_id
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE  pi.is_default = '1' AND u.user_id=p.fk_user_id AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0' )";
		}elseif($auctionStatus == 'selling'){
			$sql = "SELECT count(distinct(a.auction_id)) AS counter,a.auction_id
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE  pi.is_default = '1' AND a.fk_auction_type_id = '1' AND u.user_id=p.fk_user_id AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0') ";
		}

		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}

	/**
	 * This function fetches Feature item and recent sales auctions by status for Home Page .
	 * @param Integer $auctionStatus
	 * @param String $sort_type
	 * @param String $search_fixed_poster
	 */
	function fetchFixedPriceSaleByStatusHome($auctionStatus = '', $sort_type='',$search_fixed_poster=''){
		if($auctionStatus == 'sold'){
			$sql = "SELECT DISTINCT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.auction_payment_is_done,slider_first_position_status,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1'  AND u.user_id=p.fk_user_id 
				AND (a.auction_is_approved = '1' AND a.auction_is_sold != '0' )";
		}elseif($auctionStatus == 'selling'){
			$sql = "SELECT DISTINCT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.auction_payment_is_done,slider_first_position_status,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '1' AND u.user_id=p.fk_user_id AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}
		
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
	
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title ASC ";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title DESC ";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname DESC ";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname ASC	";
		}else{
			$sql .= " ORDER BY  a.slider_first_position_status DESC	";
		}
		
	    $sql .= " LIMIT ".$this->offset.", ".$this->toShow."";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	
	// Expied Auction started
	### added temporarily to avoid same auction result
	function countExpiredAuctions($fetch='',$auction_week_id=''){
		
		$sql = "SELECT count(a.auction_id) AS counter
				FROM ".TBL_AUCTION." a 				
				LEFT JOIN ".TBL_AUCTION_WEEK." tw ON a.fk_auction_week_id = tw.auction_week_id
				WHERE 1 AND a.auction_is_approved = '1' AND a.auction_is_sold='1'  ";
			
		if($fetch == 'fixed'){
			$sql .= " AND a.fk_auction_type_id = '1' AND a.auction_is_sold IN ('0','3')";
		}elseif($fetch == 'weekly'){
		    if($auction_week_id==''){
				$sql .= " AND (a.fk_auction_type_id = '2' 
					AND tw.is_latest='1' AND tw.is_stills='0')";
				}else{
				$sql .= " AND (a.fk_auction_type_id = '2' 
					AND tw.is_latest='1' AND tw.is_stills='0')";
				}
		}elseif($fetch == 'stills'){
			$sql .= " AND (a.fk_auction_type_id = '5' 
					AND tw.is_latest='1' AND tw.is_stills='1')";
		}elseif($fetch == 'monthly'){
			$sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1' 
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}else{
			$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end AND a.auction_is_sold IN ('0','3') ";		
		}
	//$sql .= " GROUP BY a.auction_id ";
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
	   }
	   return false;
	
	}
	### added temporarily to avoid same auction result
	function fetchExperiedAuctions($fetch = '', $poster_ids = '',$view_mode='',$auction_week_id='')
	{
        
        if($view_mode=='list'){
            $sql = "SELECT
					   c.cat_value AS poster_size,
  					   c1.cat_value AS genre,
  					   c2.cat_value AS decade,
  					   poster_size(p.poster_id) AS country,
  					   cond(p.poster_id) AS cond,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.fk_auction_week_id ,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  a.auction_actual_end_datetime,
					  a.auction_is_sold,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud,
	  				  a.max_bid_amount AS last_bid_amount,
					  a.bid_count
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  INNER JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  INNER JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  INNER JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.auction_is_sold = '1'
													 ";
        }else{
			$sql = "Select a.auction_id,
						   a.fk_auction_type_id,
						   a.auction_week_id,
						   aw.auction_week_title,
						   a.poster_id,
						   p.poster_title,
						   p.fk_user_id,
						   a.poster_thumb,
						   a.is_cloud,
						   a.soldamnt as last_bid_amount,
						   count(b.bid_id) AS bid_count			
					FROM tbl_sold_archive a,".TBL_POSTER." p ,".TBL_AUCTION_WEEK." aw ,tbl_bid_archive b
					WHERE a.poster_id = p.poster_id
					AND a.auction_week_id = aw.auction_week_id
					AND b.bid_fk_auction_id = a.auction_id
				";
            /*$sql = "SELECT
                       a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.fk_auction_week_id ,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  a.auction_actual_end_datetime,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud,
					  a.max_bid_amount AS last_bid_amount,
					  a.bid_count
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  	    WHERE pi.is_default = '1'
													AND a.auction_is_approved = '1'
													AND a.auction_is_sold = '1'
													 "; */

        }
			
		if($fetch == 'fixed'){
			$sql .= " AND a.fk_auction_type_id = '1' AND a.auction_is_sold IN ('0','3') ";
		}elseif($fetch == 'weekly'){
		   if($auction_week_id==''){
				$sql .= " AND aw.is_latest = '1' AND aw.is_stills='0' ";
			}else{
				$sql .= " AND aw.is_latest = '1' AND aw.is_stills='0' ";
			}
		}elseif($fetch == 'stills'){
			$sql .= " AND aw.is_latest='1' AND aw.is_stills='1' ";
		}elseif($fetch == 'monthly'){
		 	$sql .= " AND a.auction_is_sold ='0' AND (a.fk_auction_type_id = '3' 
						   AND a.is_approved_for_monthly_auction = '1' 
						   AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())";
		}else{
			$sql .= " AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end AND a.auction_is_sold IN ('0','3') ";		
		}
		if($fetch == 'monthly'){
			//$this->orderBy=" a.auction_id ";
		}
		if($fetch == 'weekly'){
			//$this->orderBy=" a.auction_id ";
		}
		//$orderBy=$this->orderBy;
        if($orderBy=="auction_actual_end_datetime"){
            $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_bid_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif(isset($_REQUEST['order_by']) and  $_REQUEST['order_by']=="poster_title"){
			$sql .= " GROUP BY a.auction_id 
			     ORDER BY  p.poster_title  ".$_REQUEST['order_type']."  
				LIMIT ".$this->offset.", ".$this->toShow."";

        }else{            
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
	
		   return $dataArr;
	   }
	   return false;
	}
	function countKeySearchExpiredAuctions($keyword = '',$list='',$search_type=''){
        $sql = "SELECT distinct(a.auction_id)
				FROM ".TBL_POSTER." p,".TBL_AUCTION." a
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				INNER JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
				 ";

        if($list==''){
            $sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end  ";
        }elseif($list=='fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' AND a.auction_is_sold IN ('0','3') ";
        }elseif($list=='weekly'){
            $sql .= " AND a.auction_is_sold ='1' AND aw.is_latest='1' AND aw.is_stills='0' ";
        }elseif($list=='stills'){
            $sql .= " AND a.auction_is_sold ='1' AND aw.is_latest='1' AND aw.is_stills='1' ";
        }elseif($list=='monthly'){
            $sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1'
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
        }
        if($keyword != ''){
            $sql .= " AND (";
            $split_stemmed = explode(" ",$keyword);
            $totKey=count($split_stemmed);
            if($totKey>1){
                if(($search_type=='title_desc' || $search_type=='')){
                    $newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }elseif($search_type=='title'){
                    $newSql = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
                if($rs = mysqli_query($GLOBALS['db_connect'],$newSql)){
                    while($counter = mysqli_fetch_assoc($rs)){
                        $rowNew[]=$counter['auction_id'];
                    }
                }

                $i=1;
                while(list($key,$val)=each($split_stemmed)){

                    if($val<>" " and strlen($val) > 0 and ($search_type=='title_desc' || $search_type=='')){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }elseif($val<>" " and strlen($val) > 0 and $search_type=='title'){
                        $i = $sql." ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' )) ";
                    }
                    $i++;
                    if($rs = mysqli_query($GLOBALS['db_connect'],$i)){
                        while($counter = mysqli_fetch_assoc($rs)){
                            $row[]=$counter['auction_id'];
                        }
                    }
                }
                if(!empty($row)){
                foreach(array_count_values($row)as $key=>$val){
                    if($val==$totKey){
                        $rowNew[]=$key;
                    }
                }
               }

            }else{
                if(($search_type=='title_desc' || $search_type=='')){
                    $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }elseif($search_type=='title'){
                    $sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
                }
                if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
                    while($counter = mysqli_fetch_assoc($rs))
                        $rowNew[]=$counter['auction_id'];
                }
            }
            // $sql.= ")";
        }

        if(!empty($rowNew)){
            return array_unique(($rowNew));
        }else{
            return false;
        }
    }
	function fetchKeySearchExpiredAuctions($keyword = '',$list='',$search_type='',$arrList='',$view_mode=''){
            
            if($view_mode=='list'){
                $sql = "SELECT
				c.cat_value AS poster_size,
			    c1.cat_value AS genre,
			    c2.cat_value AS decade,
			    poster_size(p.poster_id) AS country,
			    cond(p.poster_id) AS cond,
			   	a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
				a.auction_actual_end_datetime, aw.auction_week_title,
				p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,
				a.max_bid_amount AS last_bid_amount,
				a.bid_count
				FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				INNER JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  INNER JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  INNER JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id
				WHERE pi.is_default = '1' AND a.auction_is_approved = '1'  ";
            }else{
				
				$sql = "Select a.auction_id,
						   a.fk_auction_type_id,
						   a.auction_week_id,
						   aw.auction_week_title,
						   a.poster_id,
						   p.poster_title,
						   p.fk_user_id,
						   a.poster_thumb,
						   a.is_cloud,
						   a.soldamnt as last_bid_amount,
						   count(b.bid_id) AS bid_count			
					FROM tbl_sold_archive a,".TBL_POSTER." p ,".TBL_AUCTION_WEEK." aw ,tbl_bid_archive b
					WHERE a.poster_id = p.poster_id
					AND a.auction_week_id = aw.auction_week_id
					AND b.bid_fk_auction_id = a.auction_id
				";

                /*$sql = "SELECT
			    a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
				a.auction_actual_end_datetime,aw.auction_week_title,
				
				p.poster_id, p.poster_title, pi.poster_thumb,pi.is_cloud,p.fk_user_id,
				a.max_bid_amount AS last_bid_amount,a.bid_count
				FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				WHERE pi.is_default = '1' AND a.auction_is_approved = '1'  ";*/

            }
		if($list==''){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end ";
		}elseif($list=='fixed'){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND (a.fk_auction_type_id = '1') ";
		}elseif($list=='weekly'){
			//$sql .= " AND (a.auction_is_sold = '1'  AND aw.is_latest = '1' AND aw.is_stills='0')";
			$sql .= " AND aw.is_latest = '1' AND aw.is_stills='0' ";
		}elseif($list=='stills'){
			$sql .= " AND (a.auction_is_sold = '1'  AND aw.is_latest = '1' AND aw.is_stills='1')";
		}elseif($list=='monthly'){
			$sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}
			
            $sql .= " AND a.auction_id IN ($arrList) ";
			$orderBy=$this->orderBy;
            if($orderBy=="auction_actual_end_datetime"){
                $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }elseif($orderBy=="auction_bid_price"){
                $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }else{
                $sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
            }

	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	}
	function searchExpiredPosterIds($list=''){
		
	
        if(isset($_REQUEST['keyword'])){
            $keyword=$_REQUEST['keyword'];
        }else{
            $keyword ='';
            $_REQUEST['keyword']='';
        }
        $srcFlag = '';
        
				$qry = "  AND a.auction_is_approved = '1'
                      AND a.auction_is_sold = '1'
                      AND a.fk_auction_type_id ='2' ";
		
		
		
			if(isset($_REQUEST['poster_size_id']) && $_REQUEST['poster_size_id'] != '' && $_REQUEST['keyword'] == ''){
				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
				        LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND pi.fk_poster_id = a.fk_poster_id
						AND pi.is_default='1'
						AND aw.is_latest='1'
						AND ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."'";
				$sql .= $qry;
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$size_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($size_poster_ids)){
					$poster_ids = implode(',', $size_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}elseif(isset($_REQUEST['poster_size_id']) && $_REQUEST['poster_size_id'] != '' && $_REQUEST['keyword'] != ''){

				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['poster_size_id']."'
						AND pi.is_default='1'  
						AND aw.is_latest='1' ";
				$sql .= $qry;
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				while(list($key,$val)=each($split_stemmed)){
					if($val<>" " and strlen($val) > 0){
						$sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
					}
				}
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$size_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($size_poster_ids)){
					$poster_ids = implode(',', $size_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}

			if(isset($_REQUEST['genre_id']) && $_REQUEST['genre_id'] != '' && $_REQUEST['keyword'] == ''){
				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND pi.fk_poster_id = a.fk_poster_id
						AND pi.is_default='1'
						AND aw.is_latest='1'
						AND ptc.fk_cat_id = '".$_REQUEST['genre_id']."'";
				$sql .= $qry;

				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}elseif(isset($_REQUEST['genre_id']) && $_REQUEST['genre_id'] != '' && $_REQUEST['keyword'] != ''){
				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['genre_id']."'
						AND pi.is_default='1'
						AND aw.is_latest='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				while(list($key,$val)=each($split_stemmed)){
					if($val<>" " and strlen($val) > 0){
						$sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
					}
				}
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$genre_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($genre_poster_ids)){
					$poster_ids = implode(',', $genre_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}

			if(isset($_REQUEST['decade_id']) && $_REQUEST['decade_id'] != '' &&  $_REQUEST['keyword'] == ''){
				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND aw.is_latest = '1'
						AND ptc.fk_cat_id = '".$_REQUEST['decade_id']."'";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}elseif(isset($_REQUEST['decade_id']) && $_REQUEST['decade_id'] != '' && $_REQUEST['keyword'] != ''){

				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['decade_id']."'
						AND pi.is_default ='1' 
						AND aw.is_latest= '1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				while(list($key,$val)=each($split_stemmed)){
					if($val<>" " and strlen($val) > 0){
						$sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
					}
				}
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$decade_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($decade_poster_ids)){
					$poster_ids = implode(',', $decade_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}

			if(isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != '' && $_REQUEST['keyword'] == ''){
				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND aw.is_latest = '1'
						AND ptc.fk_cat_id = '".$_REQUEST['country_id']."'
						";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$country_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($country_poster_ids)){
					$poster_ids = implode(',', $country_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}
			}elseif(isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != '' && $_REQUEST['keyword'] != ''){

				$sql = "SELECT ptc.fk_poster_id FROM ".TBL_POSTER_TO_CATEGORY." ptc,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi, ".TBL_AUCTION." a
						LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
						WHERE ptc.fk_poster_id = a.fk_poster_id
						AND  p.poster_id = a.fk_poster_id
						AND  pi.fk_poster_id = a.fk_poster_id
						AND ptc.fk_cat_id = '".$_REQUEST['country_id']."'
						AND aw.is_latest = '1'
						AND pi.is_default ='1' ";
				$sql .= $qry;
				if($poster_ids != ""){
					$sql .= " AND ptc.fk_poster_id IN (".$poster_ids.")";
				}
				$split_stemmed = explode(" ",$keyword);
				$sql .= " AND ( ";
				while(list($key,$val)=each($split_stemmed)){
					if($val<>" " and strlen($val) > 0){
						$sql .= " ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) OR";
					}
				}
				$sql=substr($sql,0,(strLen($sql)-3));//this will eat the last OR
				$sql.= " ) ";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				while($row = mysqli_fetch_array($rs)){
					$country_poster_ids[] = $row['fk_poster_id'];
				}

				if(is_array($country_poster_ids)){
					$poster_ids = implode(',', $country_poster_ids);
					$srcFlag = '1';
				}else{
					return;
				}

			}
		
		if($srcFlag == ''){
			$sql = "SELECT a.fk_poster_id FROM ".TBL_AUCTION." a 
			LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id 
			LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
			WHERE 1 
			AND aw.is_latest = '1'
			AND pi.is_default = '1' ".$qry;
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			while($row = mysqli_fetch_array($rs)){
				$ids[] = $row['fk_poster_id'];
			}
			$poster_ids = implode(',', $ids);
		}

		return $poster_ids;
	
	}
	function fetchSearchExpiredAuctions($poster_ids,$view_mode=''){
		
        if(!isset($_SESSION['sessUserID'])){
            $user_id='';
        }else{
            $user_id=$_SESSION['sessUserID'];
        }

        if($view_mode=='list'){
            $sql = "SELECT c.cat_value AS poster_size,
  					   c1.cat_value AS genre,
  					   c2.cat_value AS decade,
  					   poster_size(p.poster_id) AS country,
  					   cond(p.poster_id) AS cond,
					   a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				       a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					   a.auction_actual_end_datetime, aw.auction_week_title,
				       p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
				       a.max_bid_amount AS last_bid_amount,a.bid_count
				FROM
				".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				INNER JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  INNER JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  INNER JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id
				WHERE pi.is_default = '1'
				AND a.fk_poster_id IN (".$poster_ids.")
				AND a.auction_is_approved = '1'
				  
				  ";
        }else{

            $sql = "SELECT
					   
				a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
				a.auction_actual_end_datetime,  aw.auction_week_title,
				p.poster_id, p.poster_title,  pi.poster_thumb,p.fk_user_id,
				a.max_bid_amount AS last_bid_amount,a.bid_count
				FROM
				".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				

				WHERE pi.is_default = '1'
				AND a.fk_poster_id IN (".$poster_ids.")
				AND a.auction_is_approved = '1'
				  
				  ";

        }
		$sql .= " AND a.auction_is_sold ='1' AND  a.fk_auction_type_id ='2'  ";
		
		$orderBy=$this->orderBy;
        if($orderBy=="auction_actual_end_datetime"){
            $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_bid_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }else{
            $sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
        }

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
		}
		return false;
	
	}
	function countLiveWeeklyAuctions(){
		$sql=" Select count(1) as total from tbl_auction_live 
					 where auction_actual_start_datetime <= now() 
					 AND auction_actual_end_datetime >= now() LIMIT 0,1 " ;
		
		$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
		if($resSql){
			$fetchSql = mysqli_fetch_array($resSql);
			$total= $fetchSql['total'];
			return $total;
		}
	}
    function fetchUpcomingAuctionHomePage(){
        if(!isset($_SESSION['sessUserID'])){
            $watchUserId= '';
        }else{
            $watchUserId= $_SESSION['sessUserID'];
        }

        $sql = "SELECT tw.watching_id AS watch_indicator,a.auction_id,a.auction_asked_price,
				p.poster_id, p.poster_title,pi.poster_thumb
				FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$watchUserId."'
				WHERE pi.is_default = '1' AND aw.is_test ='0' ";


        $sql .= " AND (a.auction_actual_start_datetime > now() AND a.fk_auction_type_id = '2' AND a.auction_is_sold = '0' AND a.auction_is_approved = '1' ) AND a.slider_first_position_status = '0'  ";
        $to=11;

        $selectFirstPosterInfo = "SELECT tw.watching_id AS watch_indicator,a.auction_id,a.auction_asked_price,
				p.poster_id, p.poster_title,pi.poster_thumb
				FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
				LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$watchUserId."'
				WHERE a.slider_first_position_status = '1' AND a.auction_actual_start_datetime > now() AND pi.is_default = '1' AND a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND aw.is_test ='0' ";




        $rsfirstPosterInfo = mysqli_query($GLOBALS['db_connect'],$selectFirstPosterInfo);
		if($rsfirstPosterInfo){
			$firstPosterInfo = mysqli_fetch_assoc($rsfirstPosterInfo);
			if($firstPosterInfo['poster_thumb']!=''){
					$dataArr[] = $firstPosterInfo;
			}else{
				$to=12;
			}
		}
        


        $sql .= " AND a.auction_id >= FLOOR(1 + RAND() * (SELECT
                                    MAX(auction_id)
                                  FROM tbl_auction))
				  GROUP BY a.auction_id	
				  LIMIT 0, $to ";
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	function countPhoneOrderByStatus($search_fixed_poster='',$start_date='',$end_date='')
	{
		$search_fixed_poster = trim($search_fixed_poster);
		$sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1'  AND u.user_id=p.fk_user_id ";
			
		
		
		$sql .= "AND ( a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
			 			   AND i.is_approved = '1'  AND i.is_buyers_copy = '1' AND i.is_ordered='1' )";
		
		if($search_fixed_poster!=''){		   
		   $sql .= " AND  (p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $start_date = $start_date.' '.'00:00:00';
		   $end_date = $end_date.' '.'24:00:00';
		   $sql .= " AND  i.order_date >='".$start_date."'  AND i.order_date <= '".$end_date."' "; 	
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
	 * This function fetches the weekly auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchPhoneOrderByStatus($search_fixed_poster='',$start_date='',$end_date='')
	{
		$search_fixed_poster = trim($search_fixed_poster);
		$sql = "SELECT
				  a.auction_id,  
				  ita.amount,
				  a.auction_is_approved,
				  p.poster_title,
				  p.poster_sku,
				  pi.poster_thumb,
				  pi.poster_image,
				  u.firstname,
				  u.lastname,
				  p.poster_id,
				  buyer.firstname       AS buyer_firstname,
				  buyer.lastname        AS buyer_lastname,
				  i.order_date
					FROM ".USER_TABLE." u ,".USER_TABLE." buyer,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
					LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
					LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
					WHERE pi.is_default = '1'  AND u.user_id=p.fk_user_id AND buyer.user_id = i.fk_user_id ";
			
		
		
		$sql .= "AND ( a.auction_is_approved = '1' AND a.auction_payment_is_done = '0' AND ita.fk_invoice_id != ''
			 			   AND i.is_approved = '1'  AND i.is_buyers_copy = '1' AND i.is_ordered='1' )";
						   
		if($search_fixed_poster!=''){
		   $sql .= " AND  ( p.poster_title  like '%$search_fixed_poster%' )  "; 
		}
		if($start_date!='' && $end_date!=''){
		   $start_date = $start_date.' '.'00:00:00';
		   $end_date = $end_date.' '.'24:00:00';
		   $sql .= " AND  i.order_date >='".$start_date."'  AND i.order_date <= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		
		
	    $sql .= " ORDER BY i.order_date DESC 
				LIMIT ".$this->offset.", ".$this->toShow."";			
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	function countStillsByStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT count(1) AS counter
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE  pi.is_default = '1' AND a.fk_auction_type_id = '4' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		//echo $sql;
		//$sql .= " GROUP BY a.auction_id";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the fixed price auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchStillsByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		//echo $sort_type;
		$sql = "SELECT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price,a.auction_reserve_offer_price,a.is_set_for_home_big_slider,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname,pi.is_big,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '4' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** Fixed Price items by status ends ***********************/
	function soldAuctionCOUNTSTILLS($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT distinct(a.auction_id)		 		
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				
				
					WHERE a.fk_auction_type_id = '4' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		  $count = mysqli_num_rows($rs);	
		   
		   return $count;
		}
		return false;
	
		
	}   
   
function soldAuctionSTILLS($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb , pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				
					WHERE a.fk_auction_type_id = '4' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2') )";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	
		
	}
	function countTotalSoldAuctionReport($user_id = '', $auctionStatus = '',$start_date='',$end_date='',$auction_type='',$auction_week='')
	{
		 $sql = "SELECT
				  COUNT(DISTINCT(a.auction_id)) AS counter
				FROM user_table u,
				  tbl_poster p,
				  tbl_poster_images pi,
				  tbl_auction a,
				  tbl_invoice_to_auction tia
				  INNER JOIN tbl_invoice i
					ON tia.fk_invoice_id = i.invoice_id
				WHERE pi.is_default = '1'
					AND a.fk_poster_id = p.poster_id
					AND a.fk_poster_id = pi.fk_poster_id
					AND u.user_id = p.fk_user_id
					AND a.auction_id = tia.fk_auction_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'sold'){
			$sql .= "AND a.auction_is_sold != '0' AND a.auction_is_sold != '3'  AND a.auction_is_approved = '1' AND i.is_buyers_copy = '1' ";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3'  AND i.is_paid = '0'  AND i.is_buyers_copy = '1' ";
					   
		}elseif($auctionStatus == 'paid_by_buyer'){
            $sql .= " AND i.is_paid = '1' AND a.auction_is_sold !='0'  AND a.auction_is_sold != '3'  AND i.is_buyers_copy = '1' ";

        }
		
		if($auction_type == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auction_type == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auction_type == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }
		
        if($auction_week!=''){
            $sql .= " AND a.fk_auction_week_id = $auction_week ";
        }
		
		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';
			
		  $sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."'  ";
		}
		//echo $sql;
			
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	
	function fetchTotalSoldAuctionReport($user_id = '', $auctionStatus = '',$start_date='',$end_date='',$sort,$auction_type='',$auction_week='')
	{
		
		$sql = "SELECT a.auction_id,
					  a.fk_poster_id,
					  a.fk_auction_type_id,
					  a.auction_asked_price,
					  a.auction_reserve_offer_price,
					  a.is_offer_price_percentage,
					  a.auction_buynow_price,					 
					  a.auction_is_sold,
					  u.firstname,
					  u.lastname,
					  p.poster_id,
					  p.poster_title,
					  p.poster_sku,
					  p.poster_desc,
					  pi.poster_thumb,
					  pi.poster_image,
					  tia.amount,
					  i.invoice_generated_on
					FROM user_table u,
						 tbl_poster p,
						 tbl_poster_images pi,
						 tbl_auction a
					 
					  LEFT JOIN tbl_event e
						ON a.fk_event_id = e.event_id
					  INNER JOIN (tbl_invoice_to_auction tia
					   RIGHT JOIN (tbl_invoice i
								   RIGHT JOIN user_table u_invoice
									 ON i.fk_user_id = u_invoice.user_id)
						 ON tia.fk_invoice_id = i.invoice_id)
						ON a.auction_id = tia.fk_auction_id
					WHERE pi.is_default = '1'
						AND a.fk_poster_id = p.poster_id
						AND a.fk_poster_id = pi.fk_poster_id
						AND u.user_id = p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}

        if($auctionStatus == 'sold'){
            $sql .= "AND a.auction_is_sold != '0' AND a.auction_is_sold != '3'  AND a.auction_is_approved = '1' AND i.is_buyers_copy = '1' ";
        }elseif($auctionStatus == 'unpaid'){
            $sql .= " AND a.auction_is_sold!='0'  AND a.auction_is_sold != '3'  AND i.is_paid = '0'  AND i.is_buyers_copy = '1' ";
        }elseif($auctionStatus == 'paid_by_buyer'){
            $sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3'  AND i.is_paid = '1' AND i.is_buyers_copy = '1'  ";

        }
		
		if($auction_type == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auction_type == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auction_type == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }
		
		if($auction_week!=''){
            $sql .= " AND a.fk_auction_week_id = $auction_week ";
        }
		
		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';			
		  $sql .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."'  ";
		}
		
		$sql .= " GROUP BY a.auction_id 
		          ORDER BY i.invoice_generated_on DESC
				  " ;
		//echo $sql;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	function checkChargesDiscountSeller(&$dataArr){
	for($i=0;$i<count($dataArr);$i++){
		$sql="Select i.invoice_id,i.additional_charges,i.discounts 
					FROM tbl_invoice i , tbl_invoice_to_auction tia 
					  WHERE  i.is_buyers_copy='0' 
						 AND i.invoice_id=tia.fk_invoice_id
						 AND tia.fk_auction_id='".$dataArr[$i]['auction_id']."'";
		$resSql= mysqli_query($GLOBALS['db_connect'],$sql);
		while($row=mysqli_fetch_array($resSql)){
			$row['additional_charges']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $row['additional_charges'] );
			$dataArr[$i]['additional_charges'] = unserialize($row['additional_charges']);
			
			$row['discounts']=preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $row['discounts'] );
			$dataArr[$i]['discounts'] = unserialize($row['discounts']);
			$dataArr[$i]['invoice_id'] = $row['invoice_id'];
		}
						 
	  }					 
		return $dataArr;
	}
	function countStillsAuctionByStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT COUNT(DISTINCT(a.auction_id)) AS counter
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE  pi.is_default = '1' AND a.fk_auction_type_id = '5' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		//echo $sql;
		//$sql .= " GROUP BY a.auction_id";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the fixed price auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchStillsAuctionByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		//echo $sort_type;
		$sql = "SELECT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price,a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, pi.poster_thumb,pi.poster_image,pi.is_cloud,u.firstname,u.lastname
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '5' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	/*********************** Fixed Price items by status ends ***********************/
	function soldAuctionCOUNTSTILLSAuction($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT distinct(a.auction_id)		 		
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				
				
					WHERE a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		  $count = mysqli_num_rows($rs);	
		   
		   return $count;
		}
		return false;
	
		
	}   
   
function soldAuctionSTILLSAuction($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		
		//echo $sort_type;
		$sql = "SELECT 
		 		a.auction_id,a.reopen_auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_reserve_offer_price,a.auction_buynow_price,
				a.auction_actual_start_datetime, a.auction_actual_end_datetime,pi.poster_image,u.firstname,u.lastname,
		 		p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.is_cloud
				FROM ".USER_TABLE." u ,".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a 
				LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_EVENT." e ON a.fk_event_id = e.event_id
				
					WHERE a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND  a.auction_is_sold != '0'  
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id
					AND pi.is_default = '1' AND u.user_id=p.fk_user_id   
				";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2') )";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	
		
	}
 function countUpcomingStillsAuctionsByStatus()
	{
		$sql = "SELECT count(a.auction_id) AS counter
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id  
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id  
				WHERE  pi.is_default = '1'  ";
			
		
		
        
		$sql .= " AND ((a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
					AND a.auction_actual_start_datetime > now())) ";
				
			
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
function fetchStillsLiveAuctions($view_mode=''){
	
        
        if($view_mode=='list'){
            $sql = "SELECT
					   c.cat_value AS poster_size,
  					   c1.cat_value AS genre,
  					   c2.cat_value AS decade,
  					   poster_size(p.poster_id) AS country,
  					   cond(p.poster_id) AS cond,
					   tw.watching_id AS watch_indicator,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.fk_auction_week_id ,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
											  INNER JOIN (tbl_poster_to_category ptc
											             RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
														  AND c.fk_cat_type_id = 1 )
											  ON a.fk_poster_id = ptc.fk_poster_id


											  INNER JOIN (tbl_poster_to_category ptc1
											  		RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
														  AND c1.fk_cat_type_id = 2)
											  ON a.fk_poster_id = ptc1.fk_poster_id

											  INNER JOIN (tbl_poster_to_category ptc2
											  		RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
														  AND c2.fk_cat_type_id = 3)
											  ON a.fk_poster_id = ptc2.fk_poster_id

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.in_cart <> '1'

													 ";
        }else{

            $sql = "SELECT
                       tw.watching_id AS watch_indicator,
					   a.auction_id,
					   a.is_reopened,
					   a.fk_auction_type_id,
					   a.auction_asked_price,
					   a.fk_auction_week_id ,
					   a.auction_buynow_price,
					   a.auction_actual_start_datetime,
					  (UNIX_TIMESTAMP(a.auction_actual_start_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					  a.auction_actual_end_datetime,
					  aw.auction_week_title,
					  p.poster_id,
					  p.fk_user_id,
					  p.poster_title,
					  pi.poster_thumb,
					  pi.is_cloud
					  FROM
							".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
											  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
											  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
											  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'

													  WHERE pi.is_default = '1'
													  AND a.auction_is_approved = '1'
													  AND a.in_cart <> '1'

													 ";

        }
		
		$sql .= " AND ((a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
					AND a.auction_actual_start_datetime > now())) ";
			
		$orderBy=$this->orderBy;
        if($orderBy=="auction_actual_end_datetime"){
            $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }elseif($orderBy=="auction_bid_price"){
            $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

        }else{
			   if(SHORT_TYPE=='2'){	  
					$sql .= " GROUP BY a.auction_id
						  ORDER BY ".$this->orderBy." ".$this->orderType."
						  LIMIT ".$this->offset.", ".$this->toShow."";
				  }elseif(SHORT_TYPE=='1'){	  
					$sql .= " GROUP BY a.auction_id
						  ORDER BY ".$this->orderBy." ".$this->orderType."
						  LIMIT ".$this->offset.", ".$this->toShow."";
				  }
			}
		//die();
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   //$this->fetchHighestOfferCountOffer($dataArr);
		   //$this->fetchHighestBidCountBid($dataArr);
		   return $dataArr;
	   }
	   return false;
	
	}
	function countLiveStillsAuctionsByStatus(){
		
		$sql = "SELECT count(a.auction_id) AS counter
				FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id  
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id  
				WHERE  pi.is_default = '1'  ";
			
		
		
        
		$sql .= " AND ((a.fk_auction_type_id = '5' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
					AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() )) ";
				
			
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	
	}	
	function countLiveWeeklyAuctionsForStills(){
		$sql=" Select count(1) as total from tbl_auction 
					 where fk_auction_type_id = '5' 
					 AND auction_is_approved = '1' 
					 AND auction_actual_start_datetime <= now() 
					 AND auction_actual_end_datetime >= now() LIMIT 0,1 " ;
		
		$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
		$fetchSql = mysqli_fetch_array($resSql);
		$total= $fetchSql['total'];
		return $total;
	}
	function countUpcomingStillsAuction(){
		$sql=" Select count(1) as total from tbl_auction 
					 where fk_auction_type_id = '5' 
					 AND auction_is_approved = '1' 
					 AND auction_actual_start_datetime > now() 
					 LIMIT 0,1 " ;
		
		$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
		$fetchSql = mysqli_fetch_array($resSql);
		$total= $fetchSql['total'];
		return $total;
	}
	
	function countAuctionsForUpcomingNow()
	{
		$sql = "SELECT a.auction_id AS counter
				FROM tbl_auction_live a ,  
				tbl_poster_images_live pi,
				".TBL_AUCTION_WEEK." aw
				WHERE  pi.is_default = '1' 
				AND a.fk_poster_id = pi.fk_poster_id
				AND a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
							AND a.auction_actual_start_datetime > NOW() AND a.fk_auction_week_id = aw.auction_week_id
							AND aw.is_test = '0'
						LIMIT 0,1 ";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   if($counter !=''){
		   	return $counter['counter'];
		   }else{
		   	return 0;
		   }
		}
		return false;
	}
	function fetchTotalPostersForItem($poster_id,$type=''){
	  if($type=='weekly'){
		$sql = "SELECT poster_image,is_cloud from tbl_poster_images_live where fk_poster_id = ".$poster_id." and is_default='1' " ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		}
	  	$sql = "SELECT poster_image,is_cloud from tbl_poster_images_live where fk_poster_id = ".$poster_id." and is_default<>'1' " ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		}
	  }else{
	  	$sql = "SELECT poster_image,is_cloud from tbl_poster_images where fk_poster_id = ".$poster_id ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		}
	  }
		 
	  return $dataArr;
	   
	}
	function countAlternativePosterStatus($auctionStatus = '', $user_id = '',$search_fixed_poster='',$start_date='',$end_date='')
	{
		$sql = "SELECT count(distinct(a.auction_id)) AS counter,a.auction_id
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE  pi.is_default = '1' AND a.fk_auction_type_id = '6' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR  u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';
		 } 
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		//echo $sql;
		//$sql .= " GROUP BY a.auction_id";

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	/**
	 * 
	 * This function fetches the fixed price auctions by status .
	 * @param $auctionStatus=>This paramter defines what status of auctions to be fetched(as pending,sold,unsold,upcoming or all). 
	 * @param $user_id=>This parameter defines auctions to be fetched of which user.
	 */
	function fetchAlternativeByStatus($auctionStatus = '', $user_id = '',$sort_type='',$search_fixed_poster='',$start_date='',$end_date='')
	{
		//echo $sort_type;
		$sql = "SELECT a.auction_id,a.reopen_auction_id,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.is_set_for_home_big_slider,
				a.is_offer_price_percentage, a.auction_is_approved,p.poster_id, p.poster_title, p.poster_sku, p.poster_desc, pi.poster_thumb,pi.poster_image,u.firstname,u.lastname,pi.is_cloud,pi.is_big,p.artist,p.quantity
				FROM ".USER_TABLE." u ,".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
				LEFT JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				LEFT JOIN ".TBL_INVOICE_TO_AUCTION." ita ON ita.fk_auction_id = a.auction_id
				LEFT JOIN ".TBL_INVOICE." i ON i.invoice_id = ita.fk_invoice_id
				WHERE pi.is_default = '1' AND a.fk_auction_type_id = '6' AND u.user_id=p.fk_user_id ";
			
		if($user_id != ""){
			$sql .= " AND p.fk_user_id = '".$user_id."'";
		}
		
		if($auctionStatus == 'pending'){
			$sql .= "AND a.auction_is_approved = '0'";
		}elseif($auctionStatus == 'sold'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold IN ('1','2'))";
        }elseif($auctionStatus == 'seller_pending'){
            $sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold ='3')";
        }elseif($auctionStatus == 'selling'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '0')";
		}elseif($auctionStatus == 'unpaid'){
			$sql .= "AND (a.auction_is_approved = '1' AND a.auction_is_sold = '1' AND a.auction_payment_is_done = '0'
					 AND ita.fk_invoice_id != '' AND i.is_approved = '1' AND i.is_buyers_copy = '1' AND i.is_paid='0')";
		}
		if($search_fixed_poster!=''){
		   $sql .= " AND  (u.firstname like '%$search_fixed_poster%' OR u.lastname like '%$search_fixed_poster%' OR p.poster_title  like '%$search_fixed_poster%') "; 
		}
		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';
		 } 
		if($start_date!='' && $end_date!=''){
		   $sql .= " AND  p.up_date >='".$start_date."'  AND p.up_date<= '".$end_date."' "; 	
		}
		$sql .= " GROUP BY a.auction_id ";
		if($sort_type=='poster_title'){
			$sql .= " ORDER BY  p.poster_title  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='poster_title_desc'){
			$sql .= " ORDER BY  p.poster_title  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller_desc'){
			$sql .= " ORDER BY  u.firstname  DESC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}elseif($sort_type=='seller'){
			$sql .= " ORDER BY  u.firstname  ASC  
				LIMIT ".$this->offset.", ".$this->toShow."";
		}
		else{
	      $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType." 
				LIMIT ".$this->offset.", ".$this->toShow."";
				}
				
		//echo $sql ;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	
	function soldAuctionBulkInsertInNewTable($isOrdered = false, $isLimit = false,$title='',$user_id='',$type='',$is_sold='',$sort_by='',$auction_type='',$auction_week_id='')
    {
        $sql = "SELECT
		 		a.auction_id,i.invoice_generated_on, a.fk_auction_type_id, a.auction_is_sold,a.auction_asked_price,a.auction_buynow_price,
				 pi.poster_image,
		 		p.poster_id, p.poster_title,  pi.poster_thumb,pi.is_cloud,a.fk_auction_week_id
				FROM ".TBL_INVOICE." i ,".TBL_INVOICE_TO_AUCTION." tia,".TBL_AUCTION." a,".TBL_POSTER." p , ".TBL_POSTER_IMAGES." pi				
					WHERE a.auction_is_approved = '1' 
					AND tia.fk_auction_id = a.auction_id AND i.invoice_id=tia.fk_invoice_id AND i.is_buyers_copy = '1' 
					AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.fk_poster_id = pi.fk_poster_id
				";
        if($title !=''){
            $sql.=" AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' )";
        }
        if($user_id!=''){
            $sql.=" AND	p.fk_user_id = ".$user_id;
        }
        if($type=='Home'){
            $sql.=" AND	a.is_deleted ='0' ";
        }
        if($auction_type=='weekly'){
            $sql.=" AND	a.fk_auction_type_id ='2' AND  a.auction_is_sold = '1' ";
        }
        elseif($auction_type=='fixed'){
            $sql.=" AND a.fk_auction_type_id IN ('1','4') AND  a.auction_is_sold IN ('1','2') ";
        }
		elseif($auction_type=='stills'){
            $sql.=" AND a.fk_auction_type_id ='5' AND  a.auction_is_sold IN ('1','2') ";
        }else{
			$sql.=" AND  a.auction_is_sold IN ('1','2') ";
		}
        if($auction_week_id!=''){
            $sql.=" AND a.fk_auction_week_id = $auction_week_id ";
        }
        $sql.=" group by a.auction_id ";
        if($is_sold!='sold'){
            if($isOrdered){
			   /*$sql = $sql." ORDER BY ".$this->orderBy." ".$this->orderType;*/
			   if($this->orderBy=='auction_id'){
				$sql .= " ORDER BY tia.amount DESC ";
			   }else{
			    $sql = $sql." ORDER BY ".$this->orderBy." ".$this->orderType;
			   }
		   }
            if($isLimit){
                $sql = $sql." LIMIT ".$this->offset.",".$this->toShow;
            }
        }else{
            if($sort_by=='price'){
                $sql .= " ORDER BY a.auction_asked_price DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='title'){
                $sql .= " ORDER BY p.poster_title ASC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='listing_date'){
                if($auctionStatus=='upcoming'){
                    $this->orderType="ASC";
                }else{
                    $this->orderType="DESC";
                }
                $sql .= " ORDER BY
					case when a.fk_auction_type_id ='2'  then a.auction_actual_start_datetime when a.fk_auction_type_id ='4'  then p.up_date  else p.up_date end
					".$this->orderType."
				    LIMIT ".$this->offset.", ".$this->toShow." ";
                /*$sql .= " ORDER BY
                        case when a.fk_auction_type_id !='1'  then a.auction_actual_start_datetime  else p.up_date end,
                        a.auction_actual_start_datetime,p.up_date  DESC
                        LIMIT ".$this->offset.", ".$this->toShow."";*/
                /* $sql.=" ORDER BY CASE a.fk_auction_type_id WHEN 1 THEN p.up_date  DESC
                         ELSE WHEN a.fk_auction_type_id <> 1 THEN a.auction_actual_start_datetime DESC END
                        LIMIT ".$this->offset.", ".$this->toShow." "	;	*/
            }elseif($sort_by=='uploaded_date'){
                $sql .= " ORDER BY p.post_date DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }elseif($sort_by=='sold_date'){
                $sql .= " ORDER BY i.invoice_generated_on DESC
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }else{
                $sql .= " ORDER BY ".$this->orderBy." ".$this->orderType."
				    LIMIT ".$this->offset.", ".$this->toShow."";
            }
        }
        echo $sql;
		//exit();
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	
	function countSoldItemAuction($title='',$user_id='',$type='',$auction_type='',$auction_week_id='')
    {
		if($title!='' && $title !='Search by title..'){
			$sql = "SELECT COUNT(distinct(tsa.auction_id)) AS counter
					FROM tbl_sold_archive tsa, ".TBL_POSTER." p
					WHERE tsa.poster_id = p.poster_id
					AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' )
					";
		 }elseif($user_id!=''){
		 	$sql = "SELECT COUNT(distinct(auction_id)) AS counter
					FROM tbl_sold_archive tsa,".TBL_POSTER." p
					WHERE tsa.poster_id = p.poster_id
					";		 	
		 }else{
		 	$sql = "SELECT COUNT(distinct(auction_id)) AS counter
					FROM tbl_sold_archive
					WHERE 1
					";		 	
		 }
        if($user_id!=''){
            $sql.=" AND	p.fk_user_id = ".$user_id;
        }
        if($type=='Home'){
            $sql.=" AND	a.is_deleted ='0' ";
        }
        if($auction_type=='weekly'){
            $sql.=" AND	fk_auction_type_id ='2' ";
        }
        elseif($auction_type=='fixed'){
            $sql.=" AND fk_auction_type_id ='1' ";
        }
		elseif($auction_type=='stills'){
            $sql.=" AND fk_auction_type_id ='5' ";
        }
        if($auction_week_id!=''){
            $sql.=" AND auction_week_id = $auction_week_id ";
        }
		//echo $sql;
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);
        return $row['counter'];


    }
	
	function OrderBySoldPrice($sort_by = '', $sort_type = '',$title='',$item_type='',$auction_week_id=''){
	
		if($title!=''){
			$sql=" Select tsa.*,p.poster_title from `tbl_sold_archive` tsa ,".TBL_POSTER." p
		 			WHERE tsa.poster_id = p.poster_id
					AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' ) ";
			
		}else{
     	 	$sql=" Select tsa.*,p.poster_title from `tbl_sold_archive` tsa ,".TBL_POSTER." p
		 			WHERE tsa.poster_id = p.poster_id ";
			}
		if($auction_week_id!=''){
            $sql.=" AND tsa.auction_week_id = $auction_week_id ";
        }
		 if($item_type=='fixed'){
		 	$sql .= " AND tsa.fk_auction_type_id = 1 " ;
		 }elseif($item_type=='weekly'){
		 	$sql .= " AND tsa.fk_auction_type_id = 2 " ;
		 }
		 $sql = $sql." GROUP BY tsa.auction_id ";
		 if($sort_by=='poster_title'){
            $sql .= " ORDER BY p.poster_title ".$sort_type;
         }elseif($sort_by=='auction_actual_end_datetime'){
		 	$sql .= " ORDER BY tsa.invoice_generated_on ".$sort_type;
		 }elseif($sort_by=='auction_asked_price'){
		 	$sql .= " ORDER BY tsa.soldamnt ".$sort_type;
		 }else{
		 	$sql .= " ORDER BY tsa.soldamnt DESC" ;
		 }
     	 
			$sql = $sql." LIMIT ".$this->offset.",".$this->toShow;
		 //echo $sql;  
     	 if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   		while($row = mysqli_fetch_assoc($rs)){
			   	$dataArr[] = $row;
		   		}
			}	
			return $dataArr;
     }
	 
	 function homePageSoldSlider (){ 
		
		 $selectFirstPosterInfo = "SELECT p.poster_title,tsa.soldamnt,tsa.poster_thumb,a.auction_id,tsa.is_cloud
		    FROM tbl_sold_archive tsa ,tbl_auction a,tbl_poster p
		    WHERE a.slider_first_position_status = '1' AND a.auction_is_sold IN ('1','2')
		    AND a.auction_id = tsa.auction_id AND a.fk_poster_id=p.poster_id
		    ";
		   
		  $limit = 12;
		  $rsfirstPosterInfo = mysqli_query($GLOBALS['db_connect'],$selectFirstPosterInfo);
		  if(mysqli_num_rows($rsfirstPosterInfo) > 0){ 
		   $firstPosterInfo = mysqli_fetch_assoc($rsfirstPosterInfo);
		   $dataArr[] = $firstPosterInfo;
		   $limit = 11;
		  }
		  
		  $sql = "SELECT p.poster_title,tsa.soldamnt,tsa.poster_thumb,a.auction_id,tsa.is_cloud
		  FROM tbl_sold_archive tsa ,tbl_auction a,tbl_poster p
		  WHERE a.auction_is_sold IN ('1','2') 
		  AND a.auction_id = tsa.auction_id AND a.fk_poster_id=p.poster_id
		  AND a.slider_first_position_status != '1' 
		  AND tsa.auction_id >= FLOOR(1 + RAND() * (SELECT
                                    MAX(auction_id)
                                  FROM tbl_sold_archive))
				   LIMIT 0,$limit ";
		  
		    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		     while($row = mysqli_fetch_assoc($rs)){
		      $dataArr[] = $row;
		     }
		     return $dataArr;
		    }
		    return false;
		}
		
		function OrderBySoldPriceSeller($sort_by = '', $sort_type = '',$title='',$item_type='',$auction_week_id='',$user_id=''){
		if($title!='' && $title !='Search by title..'){
			$sql=" Select tsa.*,p.poster_title from `tbl_sold_archive` tsa ,".TBL_POSTER." p
		 			WHERE tsa.poster_id = p.poster_id
					AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$title)."%' ) ";
			
		}else{
     	 	$sql=" Select tsa.*,p.poster_title,a.auction_asked_price,a.auction_note from `tbl_sold_archive` tsa ,".TBL_POSTER." p,tbl_auction a
		 			WHERE tsa.poster_id = p.poster_id
					AND tsa.auction_id = a.auction_id ";
			}
		if($auction_week_id!=''){
            $sql.=" AND tsa.auction_week_id = $auction_week_id ";
        }
		if($user_id!=''){
             $sql.=" AND p.fk_user_id = ".$user_id;
        }
		 if($item_type=='fixed'){
		 	$sql .= " AND tsa.fk_auction_type_id = 1 " ;
		 }elseif($item_type=='weekly'){
		 	$sql .= " AND tsa.fk_auction_type_id = 2 " ;
		 }
		 if($sort_by=='poster_title' || $sort_by=='title'){
            $sql .= " ORDER BY p.poster_title ".$sort_type;
         }elseif($sort_by=='auction_actual_end_datetime' || $sort_by=='sold_date'){
		 	$sql .= " ORDER BY tsa.invoice_generated_on ".$sort_type;
		 }elseif($sort_by=='auction_asked_price' || $sort_by=='price'){
		 	$sql .= " ORDER BY tsa.soldamnt ".$sort_type;
		 }else{
		 	$sql .= " ORDER BY tsa.soldamnt DESC" ;
		 }
     	 
			$sql = $sql." LIMIT ".$this->offset.",".$this->toShow;
		  //echo $sql;
     	 if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   		while($row = mysqli_fetch_assoc($rs)){
			   	$dataArr[] = $row;
		   		}
			}	
			return $dataArr;
     }
	 
	 function isLiveAuctionItem($auction_id)
    {
		 $sql = "SELECT
				  count(a.auction_id)as counter
				FROM tbl_auction_live a 				  
				WHERE a.auction_id = ".$auction_id." and a.fk_auction_type_id =2					
					 ";
        //exit;
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	
	function reactUpdateJson($from,$to){		
				$sql = "SELECT
						   c.cat_value AS poster_size,
						   c1.cat_value AS genre,
						   c2.cat_value AS decade,
						   poster_size(p.poster_id) AS country,
						   cond(p.poster_id) AS cond,
						   tw.watching_id AS watch_indicator,
						   a.auction_id,
						   a.auction_asked_price,
						   a.auction_reserve_offer_price,
						   a.is_offer_price_percentage,
						   a.auction_buynow_price,
						   p.poster_id,
						   p.fk_user_id,
						   p.poster_title,
						   u.username,
						   pi.poster_thumb,
						   pi.is_cloud
						  FROM
								".USER_TABLE." u,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
												  INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id											  
												  LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
												  LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = 47
												  INNER JOIN (tbl_poster_to_category ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
	
														  WHERE pi.is_default = '1'
														  AND a.auction_is_approved = '1'
														  AND a.in_cart <> '1' 
														  AND u.user_id = p.fk_user_id
														  AND a.auction_is_sold='0'
														  AND a.fk_auction_type_id='1'
														  ORDER BY p.poster_title 
														  LIMIT ".$from."," .$to
														 ;
						
				if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   			while($row = mysqli_fetch_assoc($rs)){
			   			$dataArr[] = $row;
		   			}
		   			return $dataArr;
	   			}
				return false;
	}
	
	function countKeySearchLiveAuctionsGlobal($keyword = '',$list='',$search_type='',$auction_week_id='')
	{
		$rowAuction='';
		$sqlCat="SELECT cat_id from tbl_category where fk_cat_type_id=2 AND lower(cat_value) LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],strtolower($keyword))."%' ";
		
		$rowCat=mysqli_fetch_assoc(mysqli_query($GLOBALS['db_connect'],$sqlCat));
		$matchCatId=$rowCat['cat_id'];
		
		
		if($matchCatId>1){
			$sqlAuction = "SELECT distinct(a.auction_id)
				FROM tbl_poster_live p,tbl_auction_live a
				INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				INNER JOIN tbl_poster_to_category_live tpc ON a.fk_poster_id = tpc.fk_poster_id
				WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
				AND a.in_cart = '0' AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()
				 ";
		}else{
			$sqlAuction = "SELECT distinct(a.auction_id)
				FROM tbl_poster_live p,tbl_auction_live a
				INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
				AND a.in_cart = '0' AND a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()
				 ";
		}
			
		
		if($matchCatId>1){
			 $sqlOthers = "SELECT distinct(a.auction_id)
				FROM ".TBL_POSTER." p,".TBL_AUCTION." a
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				INNER JOIN tbl_poster_to_category tpc ON a.fk_poster_id = tpc.fk_poster_id
				WHERE a.auction_is_sold='0' AND a.fk_auction_type_id=1 AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
				AND a.in_cart = '0' ";			 
		}else{
			$sqlOthers = "SELECT distinct(a.auction_id)
				FROM ".TBL_POSTER." p,".TBL_AUCTION." a
				INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id
				WHERE a.auction_is_sold='0' AND a.fk_auction_type_id=1 AND pi.is_default = '1' AND a.fk_poster_id = p.poster_id AND a.auction_is_approved = '1' 
				AND a.in_cart = '0' ";
		}      
		
		
        if($keyword != ''){
            
            $split_stemmed = explode(" ",$keyword);
            $totKey=count($split_stemmed);
            /*if($totKey>1){
                
				if($matchCatId>1){
					$newSqlAuction = $sqlAuction." AND (( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					$newSqlOthers = $sqlOthers." AND (( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					
				}else{
					$newSqlAuction = $sqlAuction." AND (( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					$newSqlOthers = $sqlOthers." AND (( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
				}
				
                if($rs = mysqli_query($GLOBALS['db_connect'],$newSqlAuction)){
                    while($counter = mysqli_fetch_assoc($rs)){
                        $rowAuction[]=$counter['auction_id'];
                    }
                }
				
				if($rs = mysqli_query($GLOBALS['db_connect'],$newSqlOthers)){
                    while($counter = mysqli_fetch_assoc($rs)){
                        $rowOthers[]=$counter['auction_id'];
                    }
                }

                $i=1;
                while(list($key,$val)=each($split_stemmed)){
                    
                        $iAuction = $sqlAuction." AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) ";
                        $iOthers = $sqlOthers." AND ( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$val)."%' ) ";
                    
                    $i++;
					
                    if($rs = mysqli_query($GLOBALS['db_connect'],$iAuction)){
                        while($counter = mysqli_fetch_assoc($rs)){
                            $rowAuction[]=$counter['auction_id'];
                        }
                    }
					
					if($rs = mysqli_query($GLOBALS['db_connect'],$iOthers)){
                        while($counter = mysqli_fetch_assoc($rs)){
							
                            $rowOthers[]=$counter['auction_id'];
                        }
                    }
                }
				
                
				
            }else{*/
                
				if($matchCatId>1){
					$newSqlAuction = $sqlAuction. " AND  (( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					$newSqlOthers = $sqlOthers. " AND  (( tpc.fk_cat_id= ".$matchCatId." OR p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
				}else{
					$newSqlAuction = $sqlAuction." AND (( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
					$newSqlOthers = $sqlOthers." AND (( p.poster_title LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' OR  p.poster_desc LIKE '%".mysqli_real_escape_string($GLOBALS['db_connect'],$keyword)."%' ))";
				}
					
                
				
                if($rs = mysqli_query($GLOBALS['db_connect'],$newSqlAuction)){
                    while($counter = mysqli_fetch_assoc($rs))
                        $rowAuction[]=$counter['auction_id'];
                }
				
				if($rs = mysqli_query($GLOBALS['db_connect'],$newSqlOthers)){
                    while($counter = mysqli_fetch_assoc($rs))
                        $rowOthers[]=$counter['auction_id'];
                }
           /* }*/
            
        }
		if(!empty($rowAuction)){
			$row['auction']= array_unique(($rowAuction));
		}
		if(!empty($rowOthers)){
			$row['others']= array_unique(($rowOthers));
		}		
		
        if(!empty($row)){
            return ($row);
        }else{
            return false;
        }
    }
	
	function fetchKeySearchLiveAuctionsGlobals($list='',$arrList='',$view_mode='')
		{
            if(!isset($_SESSION['sessUserID'])){
                $user_id='';
            }else{
                $user_id=$_SESSION['sessUserID'];
            }
            if($view_mode=='list'){
					
				if($list=='weekly'){
						
					$sql = "SELECT
					c.cat_value AS poster_size,
				    c1.cat_value AS genre,
				    c2.cat_value AS decade,
				    poster_size(p.poster_id) AS country,
				    cond(p.poster_id) AS cond,
					a.auction_id,  a.fk_auction_type_id, a.auction_asked_price, a.imdb_link,
					a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime,  
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount,u.username
					FROM ".USER_TABLE." u,tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
					INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id				
					INNER JOIN (tbl_poster_to_category_live ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category_live ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category_live ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0' AND u.user_id = p.fk_user_id ";
				
				}else{
					
					$sql = "SELECT
					c.cat_value AS poster_size,
				   c1.cat_value AS genre,
				   c2.cat_value AS decade,
				   poster_size(p.poster_id) AS country,
				   cond(p.poster_id) AS cond,
					a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,a.imdb_link,
					a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,a.auction_is_sold,
					a.auction_actual_end_datetime,  
					(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
					p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
					a.max_bid_amount AS last_bid_amount,u.username
					FROM ".USER_TABLE." u,".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id						
					INNER JOIN (tbl_poster_to_category ptc
															 RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
															  AND c.fk_cat_type_id = 1 )
												  ON a.fk_poster_id = ptc.fk_poster_id
	
	
												  INNER JOIN (tbl_poster_to_category ptc1
														RIGHT JOIN tbl_category c1 ON ptc1.fk_cat_id = c1.cat_id
															  AND c1.fk_cat_type_id = 2)
												  ON a.fk_poster_id = ptc1.fk_poster_id
	
												  INNER JOIN (tbl_poster_to_category ptc2
														RIGHT JOIN tbl_category c2 ON ptc2.fk_cat_id = c2.cat_id
															  AND c2.fk_cat_type_id = 3)
												  ON a.fk_poster_id = ptc2.fk_poster_id
					WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0' AND u.user_id = p.fk_user_id ";
            
				}
			}else{
				
				 if($list=='alternative' || $list==''){
				 			 $sql = "SELECT c.cat_value AS poster_size,
									tw.watching_id AS watch_indicator,
									a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
									a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
									a.auction_actual_end_datetime,  aw.auction_week_title,
									(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
									p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
									a.max_bid_amount AS last_bid_amount,p.artist,p.quantity,p.field_1,p.field_2,p.field_3
									FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
									INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id									
									LEFT JOIN ".TBL_AUCTION_WEEK." aw ON a.fk_auction_week_id = aw.auction_week_id
									LEFT JOIN ".TBL_WATCHING." tw ON a.auction_id = tw.auction_id AND tw.user_id = '".$user_id."'
									INNER JOIN (tbl_poster_to_category ptc
							 			RIGHT JOIN tbl_category c ON ptc.fk_cat_id = c.cat_id
							  				AND c.fk_cat_type_id = 1 )
										ON a.fk_poster_id = ptc.fk_poster_id					
									WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
				 
				 }else{
				 	if($list=='weekly'){
										    
						 $sql = "SELECT								
								a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
								a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
								a.auction_actual_end_datetime, 
								(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
								p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud,
								a.max_bid_amount AS last_bid_amount
								FROM tbl_auction_live a INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
								INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id								
								WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
				 
					}else{
						 $sql = "SELECT								
								a.auction_id, a.is_reopened, a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
								a.is_offer_price_percentage, a.auction_buynow_price, a.auction_actual_start_datetime,
								a.auction_actual_end_datetime,  
								(UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
								p.poster_id, p.poster_title, pi.poster_thumb,p.fk_user_id,pi.is_cloud								
								FROM ".TBL_AUCTION." a INNER JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
								INNER JOIN ".TBL_POSTER_IMAGES." pi ON a.fk_poster_id = pi.fk_poster_id			
								WHERE pi.is_default = '1' AND a.auction_is_approved = '1' AND a.in_cart = '0'  ";
					}
				 }

               

            }
		if($list==''){
			if($view_mode=='list'){
				$sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end ";
				}else{
				$sql .= " AND a.auction_is_sold IN ('0','3') AND case when a.fk_auction_type_id ='2' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id IN ('1','6') end ";
				}
		}elseif($list=='fixed'){
			$sql .= " AND a.auction_is_sold IN ('0','3') AND (a.fk_auction_type_id = '1') ";
		}elseif($list=='weekly'){
			$sql .= " AND ( (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}elseif($list=='monthly'){
			$sql .= " AND (a.fk_auction_type_id = '3'  AND a.is_approved_for_monthly_auction = '1' AND a.auction_is_sold = '0'
					  AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()))";
		}elseif($list=='stills'){
            $sql .= " AND (a.fk_auction_type_id = '4' 
					 AND a.auction_is_sold IN ('0','3')) ";
        }
			
			  
            $sql .= " AND a.auction_id IN ($arrList) ";
			$orderBy=$this->orderBy;
            if($orderBy=="auction_actual_end_datetime"){
                $sql .= " GROUP BY a.auction_id ORDER BY
				  case when a.fk_auction_type_id ='1' then  p.up_date  else ".$this->orderBy." end ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }elseif($orderBy=="auction_bid_price"){
                $sql .= " GROUP BY a.auction_id
				  ORDER BY last_bid_amount ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";

            }else{
                $sql .= " GROUP BY a.auction_id
				  ORDER BY ".$this->orderBy." ".$this->orderType."
				  LIMIT ".$this->offset.", ".$this->toShow."";
            }
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   
		   return $dataArr;
	   }
	   return false;
	}
	
	function fetchTotalAuctionsAdminRecon($user_id = '', $auctionStatus = '',$start_date='',$end_date='',$auction_type='',$auction_week='')
    {
	
		$this->orderType = 'ASC';
		$this->orderBy =$sort;
		
		$sql = "SELECT a.max_bid_amount					  
					FROM tbl_auction a	WHERE				 
					  ";
			
		

        if($auctionStatus == 'pending'){
            $sql .= " AND a.auction_is_approved = '0' ";
        }elseif($auctionStatus == 'sold'){
            $sql .= " a.auction_is_sold != '0' AND a.auction_is_sold != '3' AND a.auction_is_approved = '1'  ";
        }elseif($auctionStatus == 'unsold'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_end_datetime <= now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";
        }elseif($auctionStatus == 'upcoming'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0' AND a.auction_actual_start_datetime > now()
			          AND case when a.fk_auction_type_id ='3' then  (a.is_approved_for_monthly_auction = '1') else  (a.fk_auction_type_id ='2' || a.fk_auction_type_id ='5') end ";

        }elseif($auctionStatus == 'selling'){
            $sql .= " AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
			          AND case when (a.fk_auction_type_id ='2' OR a.fk_auction_type_id ='5')  then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now()) when a.fk_auction_type_id ='3' then  (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now() and a.is_approved_for_monthly_auction = '1')  else  a.fk_auction_type_id ='1' end  ";


		}elseif($auctionStatus == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auctionStatus == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auctionStatus == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }elseif($auctionStatus == 'reopen'){
            $sql .= " AND a.is_reopened = '1' ";
			
        }elseif($auctionStatus == 'unpaid'){
            $sql .= " AND a.auction_is_sold!='0' AND a.auction_is_sold != '3'  AND i.is_paid = '0'  AND i.is_buyers_copy = '1' ";

        }elseif($auctionStatus == 'unapproved'){
            $sql .= " AND a.auction_is_approved = '2' ";

        }

        if($auction_type == 'fixed'){
            $sql .= " AND a.fk_auction_type_id = '1' ";

        }elseif($auction_type == 'weekly'){
            $sql .= " AND a.fk_auction_type_id = '2' ";

        }elseif($auction_type == 'monthly'){
            $sql .= " AND a.fk_auction_type_id = '3' ";

        }/*elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '5' ";
					   
		}*/elseif($auction_type == 'stills'){
			$sql .= " AND a.fk_auction_type_id = '4' ";
					   
		}

        if($auction_week!=''){
            $sql .= " AND a.fk_auction_week_id = $auction_week ";
        }

		if($start_date != ""){
		  $start_date = $start_date.' 00:00:00';
		  $end_date = $end_date.' 24:00:00';			
		  if($auctionStatus == ''){
				$sql .= " AND a.auction_actual_end_datetime >= '".$start_date."' AND a.auction_actual_end_datetime <= '".$end_date."'  ";
			}else{
				$sql .= " AND a.auction_actual_end_datetime >= '".$start_date."' AND a.auction_actual_end_datetime <= '".$end_date."'  ";
			}
		}
		
		$sql .= " GROUP BY a.auction_id " ;
		
		
		
        

		//echo $sql;
		
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $total_amount_sold_by_mpe = number_format(($total_amount_sold_by_mpe + $row['max_bid_amount']), 2, '.', '');
		   }
		   return $total_amount_sold_by_mpe;
		}
		return false;
	}

	function getExtendedAuction(){
		$sql = "SELECT tw.auction_week_end_date
				FROM tbl_auction_live a,tbl_auction_week tw
				WHERE  a.fk_auction_week_id = tw.auction_week_id 
				AND (UNIX_TIMESTAMP(tw.auction_week_end_date) - UNIX_TIMESTAMP()) <= 0 LIMIT 1";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		while($row = mysqli_fetch_array($rs)){
			$extended_week_title =  date("m.d.y", strtotime($row["auction_week_end_date"]));;
		}
		return $extended_week_title;
	}
}

?>

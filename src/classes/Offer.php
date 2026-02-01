<?php

class Offer extends DBCommon{
	
	public function __construct(){		
		$this->primaryKey = 'offer_id';
		$this->orderBy = 'post_date';
		parent::__construct();
	}
	
	function countMyAuction_Offers($user_id = '', $is_outgoing = false)
	{
		$sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id";

		if($user_id != '' && $is_outgoing){
			$sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'
					  AND ofr.is_archived='0' ";
		}elseif($user_id != '' && !$is_outgoing){
			$sql .= " AND p.fk_user_id = '".$user_id."'
			          AND ofr.is_archived_seller='0'";
		}

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	function countMyAuction_OffersNew($user_id = '', $is_outgoing = false)
		{
			$sql = "SELECT count(distinct(a.auction_id)) AS counter
					FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
					WHERE ofr.offer_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id AND a.auction_is_sold IN ('1','2') ";
	
			if($user_id != '' && $is_outgoing){
				$sql .= " AND ofr.offer_parent_id = '0'
						  AND ofr.offer_fk_user_id = '".$user_id."'";
			}elseif($user_id != '' && !$is_outgoing){
				$sql .= " AND p.fk_user_id = '".$user_id."'";
			}
	
			if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
			   $counter = mysqli_fetch_assoc($rs);
			   return $counter['counter'];
			}
			return false;
		}
	
	function fetchMyAuction_OffersNew($user_id = '', $is_outgoing = false)
		{
			$sql = "SELECT p.poster_id, p.poster_title, p.poster_desc, p.poster_sku, pi.poster_thumb,
					a.auction_id, a.auction_asked_price, a.auction_reserve_offer_price,
					a.is_offer_price_percentage, a.auction_is_sold, a.auction_note
					FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p, ".TBL_POSTER_IMAGES." pi
					WHERE ofr.offer_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id AND a.fk_auction_type_id IN ('1','4')
					AND p.poster_id = pi.fk_poster_id AND pi.is_default = '1' AND a.auction_is_sold IN ('1','2') ";
	
			if($is_outgoing){
				$sql .= " AND ofr.offer_parent_id = '0'
						  AND ofr.offer_fk_user_id = '".$user_id."'";
			}elseif($user_id != '' && !$is_outgoing){
				$sql .= " AND p.fk_user_id = '".$user_id."'";
			}
			$sql .= " GROUP BY a.auction_id ORDER BY ofr.offer_id DESC";
	
		   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){   
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }		   
			   return $dataArr;
		   }
		   return false;
		}
	function fetchMyAuction_Offers($user_id = '', $is_outgoing = false,$orderBy='',$orderType='')
	{
		$sql = "SELECT p.poster_id, p.poster_title, p.poster_desc, p.poster_sku, pi.poster_thumb,
				a.auction_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_is_sold, a.auction_note
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p, ".TBL_POSTER_IMAGES." pi
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id AND a.fk_auction_type_id IN ('1','4')
				AND p.poster_id = pi.fk_poster_id AND pi.is_default = '1'";

		if($is_outgoing){
			$sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'
					  AND ofr.is_archived='0' ";
		}elseif($user_id != '' && !$is_outgoing){
			$sql .= " AND p.fk_user_id = '".$user_id."'
			          AND ofr.is_archived_seller='0' ";
		}
		if($orderBy=='') {
		    $sql .= " GROUP BY a.auction_id ORDER BY ofr.offer_id DESC";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='DESC' ) {
            $sql .= " AND ofr.offer_amount = ( SELECT MAX(offer_amount) FROM tbl_offer WHERE  offer_fk_auction_id=a.auction_id AND offer_fk_user_id ='".$user_id."' group by offer_fk_auction_id ) ";
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.post_date DESC ";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='ASC' ) {
            $sql .= " AND ofr.offer_amount = ( SELECT MAX(offer_amount) FROM tbl_offer WHERE  offer_fk_auction_id=a.auction_id AND offer_fk_user_id ='".$user_id."' group by offer_fk_auction_id ) ";
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.post_date ASC";
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
	
	function fetch_OfferCount_MaxOffer(&$dataArr)
	{
		/*for($i=0;$i<count($dataArr);$i++){
			$auction_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auction_ids = trim($auction_ids, ',');

		$sql = "SELECT offer_fk_auction_id, count(offer_id) AS counter, max(offer_amount) AS highest_offer
				FROM ".TBL_OFFER." WHERE offer_fk_auction_id IN (".$auction_ids.")";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }
		
		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($offerArr);$j++){
				if($dataArr[$i]['auction_id'] == $offerArr[$j]['offer_fk_auction_id']){					
					$dataArr[$i]['count_offer'] = $offerArr[$j]['counter'];
					$dataArr[$i]['highest_offer'] = $offerArr[$j]['highest_offer'];
				}				
			}			
		}*/
		
		for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT COUNT(offer_id) AS counter, MAX(offer_amount) AS highest_offer
					FROM ".TBL_OFFER."
					WHERE offer_fk_auction_id = '".$dataArr[$i]['auction_id']."'
					AND offer_parent_id = '0'";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			$row = mysqli_fetch_assoc($rs);
			$dataArr[$i]['count_offer'] = $row['counter'];
			$dataArr[$i]['highest_offer'] = $row['highest_offer'];
		}
		return true;
	}
	
	function fetchMyOffers(&$dataArr, $user_id = '',$isArchived='',$is_seller='')
	{
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		
		$sql = "SELECT ofr.offer_id, ofr.offer_fk_auction_id, ofr.offer_is_accepted, ofr.offer_amount, ofr.post_date,
				cntr_ofr.offer_id AS cntr_offer_id, cntr_ofr.offer_is_accepted AS cntr_ofr_offer_is_accepted,
				cntr_ofr.offer_amount AS cntr_ofr_offer_amount, cntr_ofr.post_date AS cntr_ofr_post_date
				FROM ".TBL_OFFER." ofr LEFT JOIN ".TBL_OFFER." cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
				WHERE ofr.offer_fk_auction_id IN (".$auctions_ids.")
				AND ofr.offer_parent_id = '0'";
				
		if($user_id != ''){
			$sql .= " AND ofr.offer_fk_user_id = '".$user_id."'";
		}
         if($is_seller==''){
             if(!$isArchived){
                 $sql .= " AND ofr.is_archived='0' " ;
             }elseif($isArchived=='purchases'){
				 $sql .= "  " ;
			 }else{
                 $sql .= " AND ofr.is_archived='1' " ;
             }
         }else{
             if(!$isArchived){
                 $sql .= " AND ofr.is_archived_seller='0' " ;
             }else{
                 $sql .= " AND ofr.is_archived_seller='1' " ;
             }
         }


		$sql .= " ORDER BY ofr.post_date DESC";

	    $offerArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($offerArr);$j++){
				if($dataArr[$i]['auction_id'] == $offerArr[$j]['offer_fk_auction_id']){
					 $arr[$flag]['offer_id'] = $offerArr[$j]['offer_id'];
					 $arr[$flag]['offer_is_accepted'] = $offerArr[$j]['offer_is_accepted'];
					 $arr[$flag]['offer_amount'] = $offerArr[$j]['offer_amount'];
					 $arr[$flag]['post_date'] = $offerArr[$j]['post_date'];

					 $arr[$flag]['cntr_offer_id'] = $offerArr[$j]['cntr_offer_id'];
					 $arr[$flag]['cntr_ofr_offer_is_accepted'] = $offerArr[$j]['cntr_ofr_offer_is_accepted'];
					 $arr[$flag]['cntr_ofr_offer_amount'] = $offerArr[$j]['cntr_ofr_offer_amount'];
					 $arr[$flag]['cntr_ofr_post_date'] = $offerArr[$j]['cntr_ofr_post_date'];
					 $flag++;
				}				
			}
			$dataArr[$i]['offers'] = $arr;			
			unset($arr);
		}		
	   return true;
	}
	function fetchTotalOffers(&$dataArr)
	 {
		$auctions_ids = '';
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		
		$sql = "SELECT ut.firstname,ut.username,ut.lastname,ofr.offer_id, ofr.offer_fk_auction_id, ofr.offer_is_accepted, ofr.offer_amount, ofr.post_date,
				cntr_ofr.offer_id AS cntr_offer_id, cntr_ofr.offer_is_accepted AS cntr_ofr_offer_is_accepted,
				cntr_ofr.offer_amount AS cntr_ofr_offer_amount, cntr_ofr.post_date AS cntr_ofr_post_date
				FROM ".USER_TABLE." ut,".TBL_OFFER." ofr LEFT JOIN ".TBL_OFFER." cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
				WHERE ofr.offer_fk_auction_id IN (".$auctions_ids.") AND ut.user_id=ofr.offer_fk_user_id
				AND ofr.offer_parent_id = '0' ";



		$sql .= " ORDER BY ofr.post_date DESC";

	    $offerArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($offerArr);$j++){
				if($dataArr[$i]['auction_id'] == $offerArr[$j]['offer_fk_auction_id']){
					 $arr[$flag]['offer_id'] = $offerArr[$j]['offer_id'];
					 $arr[$flag]['offer_is_accepted'] = $offerArr[$j]['offer_is_accepted'];
					 $arr[$flag]['offer_amount'] = $offerArr[$j]['offer_amount'];
					 $arr[$flag]['post_date'] = $offerArr[$j]['post_date'];
					 $arr[$flag]['username'] = $offerArr[$j]['firstname'].' '.$offerArr[$j]['lastname'];
					 $arr[$flag]['user_name'] = $offerArr[$j]['username'];
					 $arr[$flag]['cntr_offer_id'] = $offerArr[$j]['cntr_offer_id'];
					 $arr[$flag]['cntr_ofr_offer_is_accepted'] = $offerArr[$j]['cntr_ofr_offer_is_accepted'];
					 $arr[$flag]['cntr_ofr_offer_amount'] = $offerArr[$j]['cntr_ofr_offer_amount'];
					 $arr[$flag]['cntr_ofr_post_date'] = $offerArr[$j]['cntr_ofr_post_date'];
					 $flag++;
				}				
			}
			$dataArr[$i]['tot_offers'] = $arr;			
			unset($arr);
		}		
	   return true;
	}
	function fetchMyWinningOffers($user_id = '')
	{
		 $sql = "SELECT a.auction_id,p.poster_title, p.poster_sku, pti.poster_thumb, ofr.post_date,
				IF(ofr.offer_is_accepted = '1', ofr.offer_amount, cntr_ofr.offer_amount) AS offer_amount
				FROM ".TBL_OFFER." ofr LEFT JOIN ".TBL_OFFER." cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id, ".
				TBL_AUCTION." a,".TBL_POSTER." p, ".TBL_POSTER_IMAGES." pti
				WHERE a.auction_id = ofr.offer_fk_auction_id
				AND a.fk_poster_id = p.poster_id
				AND p.poster_id = pti.fk_poster_id
				AND pti.is_default = '1'
				AND (ofr.offer_is_accepted = '1' OR cntr_ofr.offer_is_accepted = '1')
				";
		if($user_id!=''){
			$sql .= " AND ofr.offer_fk_user_id = '".$user_id."' AND p.fk_user_id != '".$user_id."'";
		}
		$sql .= " GROUP BY a.auction_id ORDER BY ofr.post_date DESC  ";
		//echo $sql;
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }
		return $offerArr;
	
	}
	
	function fetchOffersById(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			$auctions_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auctions_ids = trim($auctions_ids, ',');
		
		$sql = "SELECT ut.firstname,ut.lastname,ofr.offer_id, ofr.offer_fk_auction_id, ofr.offer_is_accepted, ofr.offer_amount, ofr.post_date,
				cntr_ofr.offer_id AS cntr_offer_id, cntr_ofr.offer_is_accepted AS cntr_ofr_offer_is_accepted,
				cntr_ofr.offer_amount AS cntr_ofr_offer_amount, cntr_ofr.post_date AS cntr_ofr_post_date
				FROM ".USER_TABLE." ut,".TBL_OFFER." ofr LEFT JOIN ".TBL_OFFER." cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
				WHERE ofr.offer_fk_auction_id IN (".$auctions_ids.")
				AND ofr.offer_parent_id = '0' AND ut.user_id=ofr.offer_fk_user_id";
				
		if($user_id != ''){
			$sql .= " AND ofr.offer_fk_user_id = '".$user_id."'";
		}

		$sql .= " ORDER BY ofr.post_date DESC";

	    $offerArr = [];
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $offerArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($offerArr);$j++){
				if($dataArr[$i]['auction_id'] == $offerArr[$j]['offer_fk_auction_id']){
				 	 $arr[$flag]['username'] = $offerArr[$j]['firstname'].' '.$offerArr[$j]['lastname'];
					 $arr[$flag]['offer_id'] = $offerArr[$j]['offer_id'];
					 $arr[$flag]['offer_is_accepted'] = $offerArr[$j]['offer_is_accepted'];
					 $arr[$flag]['offer_amount'] = $offerArr[$j]['offer_amount'];
					 $arr[$flag]['post_date'] = $offerArr[$j]['post_date'];
					 
					 $arr[$flag]['cntr_offer_id'] = $offerArr[$j]['cntr_offer_id'];
					 $arr[$flag]['cntr_ofr_offer_is_accepted'] = $offerArr[$j]['cntr_ofr_offer_is_accepted'];
					 $arr[$flag]['cntr_ofr_offer_amount'] = $offerArr[$j]['cntr_ofr_offer_amount'];
					 $arr[$flag]['cntr_ofr_post_date'] = $offerArr[$j]['cntr_ofr_post_date'];
					 $flag++;
				}				
			}
			$dataArr[$i]['offers'] = $arr;			
			unset($arr);
			return $dataArr;
		}		
	   return true;
	}
	
	function acceptOffer($auction_id, $offer_id)
	{
		$sql = "UPDATE ".TBL_OFFER." SET offer_is_accepted = '2'
				WHERE offer_fk_auction_id = '".$auction_id."'
				AND offer_id != '".$offer_id."'";
		$check = mysqli_query($GLOBALS['db_connect'],$sql);
		if($check){
			$checkOffer = $this->updateData(TBL_OFFER, array('offer_is_accepted' => 1), array('offer_id' => $offer_id), true);
			if($checkOffer){
				$checkAuction = $this->updateData(TBL_AUCTION, array('auction_is_sold' => 1), array('auction_id' => $auction_id), true);
				if($checkAuction){
					$invoiceObj = new Invoice();
					$invoiceObj->generateInvoice($offer_id, false);
					return true;
				}else{
					return false;
				}
			}
			return false;
		}
		return false;
	}

	function rejectOffer($offer_id)
	{
		$check = $this->updateData(TBL_OFFER, array('offer_is_accepted' => 2), array('offer_id' => $offer_id), true);
		if($check){
			return true;
		}else{
			return false;
		}
	}

	function makeCounterOffer($auction_id, $offer_id, $cntr_offer)
	{
		$data = array("offer_parent_id" => $offer_id, "offer_fk_user_id" => $_SESSION['sessUserID'],
					  "offer_fk_auction_id" => $auction_id, "offer_amount" => $cntr_offer, "offer_is_accepted" => 0,
					  "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
		$check = $this->updateData(TBL_OFFER, $data);
		if($check){
			//return true;
			return $check;
		}else{
			return false;
		}
	}
	
	function auctionIsSold($offer_id)
	{
		$sql = "SELECT auc.auction_is_sold FROM ".TBL_AUCTION." auc, ".TBL_OFFER." ofr
				WHERE auc.auction_id = ofr.offer_fk_auction_id
				AND ofr.offer_id = '".$offer_id."'";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		if($row['auction_is_sold'] > 0){
			return true;
		}else{		
			return false;
		}
	}
	###  New functions for archived ####
    function countMyAuction_Offers_archived($user_id = '', $is_outgoing = false)
    {
        $sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id AND ofr.is_archived='1' ";

        if($user_id != '' && $is_outgoing){
            $sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'";
        }elseif($user_id != '' && !$is_outgoing){
            $sql .= " AND p.fk_user_id = '".$user_id."'";
        }

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $counter = mysqli_fetch_assoc($rs);
            return $counter['counter'];
        }
        return false;
    }

    function fetchMyAuction_Offers_archived($user_id = '', $is_outgoing = false,$orderBy='',$orderType='')
    {
        $sql = "SELECT p.poster_id, p.poster_title, p.poster_desc, p.poster_sku, pi.poster_thumb,
				a.auction_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_is_sold, a.auction_note
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p, ".TBL_POSTER_IMAGES." pi
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id AND a.fk_auction_type_id = '1'
				AND p.poster_id = pi.fk_poster_id AND pi.is_default = '1' AND ofr.is_archived='1' ";

        if($is_outgoing){
            $sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'";
        }elseif($user_id != '' && !$is_outgoing){
            $sql .= " AND p.fk_user_id = '".$user_id."'";
        }
        if($orderBy=='') {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.offer_id DESC";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='DESC' ) {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.archived_date DESC ";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='ASC' ) {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.archived_date ASC";
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

    function countMyAuction_Incoming_Offers_archived($user_id = '', $is_outgoing = false){

        $sql = "SELECT count(distinct(a.auction_id)) AS counter
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id  ";

        if($user_id != '' && $is_outgoing){
            $sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'
					  AND ofr.is_archived='1' ";
        }elseif($user_id != '' && !$is_outgoing){
            $sql .= " AND p.fk_user_id = '".$user_id."'
			          AND ofr.is_archived_seller='1'";
        }

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $counter = mysqli_fetch_assoc($rs);
            return $counter['counter'];
        }
        return false;

    }
    function fetchMyAuction_Incoming_Offers_archived($user_id = '', $is_outgoing = false,$orderBy='',$orderType=''){

        $sql = "SELECT p.poster_id, p.poster_title, p.poster_desc, p.poster_sku, pi.poster_thumb,
				a.auction_id, a.auction_asked_price, a.auction_reserve_offer_price,
				a.is_offer_price_percentage, a.auction_is_sold, a.auction_note
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p, ".TBL_POSTER_IMAGES." pi
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id AND a.fk_auction_type_id = '1'
				AND p.poster_id = pi.fk_poster_id AND pi.is_default = '1' ";

        if($is_outgoing){
            $sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'
					  AND ofr.is_archived='1' ";
        }elseif($user_id != '' && !$is_outgoing){
            $sql .= " AND p.fk_user_id = '".$user_id."'
			          AND ofr.is_archived_seller='1' ";
        }
        if($orderBy=='') {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.offer_id DESC";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='DESC' ) {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.archived_date DESC ";
        }elseif($orderBy=='auction_actual_end_datetime' && $orderType=='ASC' ) {
            $sql .= " GROUP BY a.auction_id ORDER BY ofr.archived_date ASC";
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
	function ifArchivedAble($auction_id,$user_id){
            $sql= "Select count(1) as counter,p.poster_title from ".TBL_POSTER." p,".TBL_AUCTION." a,".TBL_OFFER." ofr
                 LEFT JOIN ".TBL_OFFER." cntr_ofr  ON ofr.offer_id = cntr_ofr.offer_parent_id
                 WHERE ofr.offer_fk_auction_id = '".$auction_id."'
                 AND ofr.offer_fk_user_id ='".$user_id."'
                  AND (ofr.offer_is_accepted = '0' OR cntr_ofr.offer_is_accepted = '0')
                  AND (ofr.is_archived = '0' OR cntr_ofr.is_archived = '0')
                 AND a.auction_id = '".$auction_id."'
                 AND a.fk_poster_id = p.poster_id  ";

          $resSql = mysqli_query($GLOBALS['db_connect'],$sql);
          $rowSql = mysqli_fetch_array($resSql);
          $count =  $rowSql['counter'];

          $poster_title = $rowSql['poster_title'];
          if($count>0){
              return $auction_id.'-'.$poster_title;
          }else{
              return '0-';
          }
    }
    function ifArchivedAbleSeller($auction_id){
        $sql= "Select count(1) as counter,p.poster_title from ".TBL_POSTER." p,".TBL_AUCTION." a,".TBL_OFFER." ofr
                 LEFT JOIN ".TBL_OFFER." cntr_ofr  ON ofr.offer_id = cntr_ofr.offer_parent_id
                 WHERE ofr.offer_fk_auction_id = '".$auction_id."'
                 AND (ofr.offer_is_accepted = '0' OR cntr_ofr.offer_is_accepted = '0')
                 AND (ofr.is_archived_seller = '0' OR cntr_ofr.is_archived_seller = '0')
                 AND a.auction_id = '".$auction_id."'
                 AND a.fk_poster_id = p.poster_id  ";

        $resSql = mysqli_query($GLOBALS['db_connect'],$sql);
        $rowSql = mysqli_fetch_array($resSql);
        $count =  $rowSql['counter'];

        $poster_title = $rowSql['poster_title'];
        if($count>0){
            return $auction_id.'-'.$poster_title;
        }else{
            return '0-';
        }
    }
	function countUnread_Offers($user_id = '', $is_outgoing = false)
	{
		$sql = "SELECT count(1) AS counter
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a
				WHERE ofr.offer_fk_auction_id = a.auction_id
				";

		if($user_id != '' && $is_outgoing){
			$sql .= " AND ofr.offer_parent_id = '0'
					  AND ofr.offer_fk_user_id = '".$user_id."'
					  AND ofr.is_archived='0' 
					  ANd ofr.is_read_buyer='0'";
		}
		//$sql .= "GROUP BY a.auction_id ";
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	function countUnread_incoming_counters($user_id = ''){
		 $sql= "SELECT
				  count(1) as counter 
				FROM tbl_auction a,tbl_offer ofr
				  LEFT JOIN tbl_offer cntr_ofr
					ON ofr.offer_id = cntr_ofr.offer_parent_id
				WHERE ofr.offer_fk_auction_id = a.auction_id
					AND ofr.offer_parent_id = '0'
					AND ofr.offer_fk_user_id = '".$user_id."'
					AND ofr.is_archived='0' 
					AND cntr_ofr.is_read_buyer='0'
					AND cntr_ofr.offer_amount !='' " ;
					
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;			
	}
	function countUnread_incoming_offers($user_id = '')
	{
		$sql = "SELECT count(1) AS counter
				FROM ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
				WHERE ofr.offer_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id  ";

		
		$sql .= " AND p.fk_user_id = '".$user_id."'
			      AND ofr.is_archived_seller='0'
				  AND ofr.is_read_seller='0'
				  AND ofr.offer_parent_id = '0' ";
		

		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;
	}
	function countUnread_outgoing_counters($user_id = ''){
	  $sql =  "SELECT
				COUNT(1) AS counter
				FROM tbl_auction a,
					tbl_poster p,
					tbl_offer ofr
					  LEFT JOIN tbl_offer cntr_ofr
						ON ofr.offer_id = cntr_ofr.offer_parent_id
					WHERE p.fk_user_id = '".$user_id."'
						AND a.fk_poster_id = p.poster_id
						AND ofr.offer_fk_auction_id = a.auction_id
						AND ofr.offer_parent_id = '0'
						AND ofr.is_archived_seller = '0'
						AND cntr_ofr.is_read_seller = '0'
						AND cntr_ofr.offer_amount != '' ";
			
		if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
		}
		return false;	
	}
}
?>
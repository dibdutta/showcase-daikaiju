<?php

class Watch extends DBCommon{
	
	public function __construct(){		
		$this->primaryKey = 'watching_id';
		$this->orderBy = 'add_date';
		parent::__construct();
	}
	
	function checkWatchlist(&$dataArr)
	{/*
		for($i=0;$i<count($dataArr);$i++){
			$auction_ids .= $dataArr[$i]['auction_id'].",";
		}
		$auction_ids = trim($auction_ids, ',');

		 $sql = "SELECT bid_fk_auction_id, count(bid_id) AS counter, max(bid_amount) AS highest_bid
				FROM ".TBL_BID." WHERE bid_fk_auction_id IN (".$auction_ids.")";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $bidArr[] = $row;
		   }
	    }*/
		
		for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT count(watching_id) AS counter
				FROM ".TBL_WATCHING." WHERE auction_id = '".$dataArr[$i]['auction_id']."' and user_id='".$_SESSION['sessUserID']."'";
				$rs = mysqli_query($GLOBALS['db_connect'],$sql);
				$row = mysqli_fetch_assoc($rs);
				$counter=$row['counter'];
				if($counter==0){
				$dataArr[$i]['watch_indicator'] = 0;
				}else{
				$dataArr[$i]['watch_indicator'] = 1;	
				}
		}		
	   return true;
	}
}
?>
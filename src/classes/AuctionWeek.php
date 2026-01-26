<?php
/**
 * 
 * This class handles all the functions that are related to AuctionWeek module.
 *
 */
class AuctionWeek extends DBCommon{
	/**
	* 
	* This is a constructer of AuctionWeek Class.
	*/
	public function __construct(){		
		$this->primaryKey = 'auction_week_id';
		$this->orderBy = 'auction_week_id';
		parent::__construct();
	}
	
	public function fetchWeekForAuction($auction_id)
	{
		$sql = "SELECT * FROM ".TBL_AUCTION_WEEK." taw,".TBL_AUCTION." a
				WHERE a.auction_id=$auction_id and a.fk_auction_week_id= taw.auction_week_id";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
	public function fetchActiveWeeks()
	{
		/*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
				WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
		$sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE auction_week_end_date >= now() AND is_stills='0' ";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
    public function fetchUpcomingWeeks()
    {
        /*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
                  WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE auction_week_start_date >= now() AND is_stills='0' AND is_test <> '1' ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
    public function selectAuctionWeek()
    {
        /*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
                  WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE is_test <> '1' and auction_week_end_date < now() AND is_stills='0'  ORDER BY auction_week_end_date DESC ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	public function fetchUpcomingWeeksWithItem()
    {
        /*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
                  WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
        $sql = "SELECT tw.* FROM tbl_auction_week tw,tbl_auction a  WHERE tw.auction_week_start_date >= NOW() AND a.fk_auction_week_id = tw.auction_week_id AND tw.is_test <> '1' GROUP BY tw.auction_week_id  ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	public function fetchActiveWeeksForStills()
	{
		/*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
				WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
		$sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE auction_week_end_date >= now() AND is_stills='1' ";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
	public function fetchAuctionWeekDetails($id)
	{
		/*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
				WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
		$sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE auction_week_id = '".$id."' ";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		
	   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
	   }
	   return false;
	}
	
	public function selectAuctionWeekStills()
    {
        /*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
                  WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE  auction_week_end_date < now() AND is_stills='1' ORDER BY auction_week_end_date DESC ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	public function countLiveAuctionWeekRunning(){
		$sql = " SELECT count(1) as counter FROM ".TBL_AUCTION_WEEK." WHERE  auction_week_end_date >= now() AND is_stills='0' AND auction_week_start_date < now() ";
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
	   }
	}
	public function countLiveAuctionWeekUpcoming(){
		$sql = " SELECT count(1) as counter FROM ".TBL_AUCTION_WEEK." WHERE  is_stills='0' AND auction_week_start_date > now() ";
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   $counter = mysqli_fetch_assoc($rs);
		   return $counter['counter'];
	   }
	}
	public function fetchLiveAuctionNames(){
		
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE  auction_week_end_date >= now() AND is_stills='0' AND auction_week_start_date < now() ORDER BY auction_week_end_date ";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
	}
	public function fetchLiveStillsNames(){
		
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE  auction_week_end_date >= now() AND is_stills='1' AND auction_week_start_date < now()  ";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
	}
	public function fetchUpcomingWeeksNewForAdmin()
    {
        /*$sql = "SELECT * FROM ".TBL_AUCTION_WEEK."
                  WHERE auction_week_start_date <= now() AND auction_week_end_date >= now()";*/
        $sql = "SELECT * FROM ".TBL_AUCTION_WEEK." WHERE auction_week_start_date >= now() AND is_stills='0'  ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[] = $row;
            }
            return $dataArr;
        }
        return false;
    }
	public function latestEndedAuctions(){
		$sql = "select auction_week_end_date from ".TBL_AUCTION_WEEK." WHERE is_latest='1' AND is_closed='1' ORDER BY auction_week_end_date DESC LIMIT 1 ";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_assoc($rs);
		$i=0;
        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $dataArr[$i]["auction_week_title"] = date("m.d.y", strtotime($row["auction_week_end_date"]));
				$i=$i+1;
            }
            return $dataArr;
        }
        return false;
	}
}
?>
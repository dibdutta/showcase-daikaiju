<?php
class Wantlist extends DBCommon{
	
	public function __construct(){		
		$this->primaryKey = 'wantlist_id';
		$this->orderBy = 'wantlist_id';
		parent::__construct();
	}
	
	function countWantlist($cat_id)
	{
		
		for($i=0;$i<count($cat_id);$i++){
		 $sql=mysqli_query($GLOBALS['db_connect'],"SELECT COUNT('want_id') AS counter FROM `tbl_wantlist` as wt,`tbl_wantlist_category` as w where wt.want_id=w.fk_want_id and wt.user_id = '".$_SESSION['sessUserID']."' and w.fk_cat_id=$cat_id[$i]"); 
		 $row = mysqli_fetch_assoc($sql);
		 $total= $row['counter'];
		 if($total >0){
			 $chk=0;
		 }else{
			 $chk=1;
			 break;
		 }
	}
	/*if(count($cat_id) ==1){
		
	}*/ 
	if($chk==0){
		return false;
	}else{
		return true;
	}
}
function get_poster_id($wantlist_id) {
    //echo "select fk_genre_id, fk_poster_size_id, fk_decade_id, fk_country_id from tbl_wantlist where wantlist_id = $wantlist_id";
	//exit;
	//echo "select fk_genre_id, fk_poster_size_id, fk_decade_id, fk_country_id from tbl_wantlist where wantlist_id = $wantlist_id";
	//echo "select poster_title from tbl_wantlist where wantlist_id = $wantlist_id";
	$result = mysqli_query($GLOBALS['db_connect'],"select poster_title from tbl_wantlist where wantlist_id = $wantlist_id"); 
	$res_row = mysqli_fetch_assoc($result);
	$res_array = mysqli_real_escape_string($GLOBALS['db_connect'], $res_row['poster_title']);
	$res_array = "%" . $res_array . "%" ;

	//echo $sql="select poster_id from `tbl_poster` where poster_title='".$res_array."'";
	
	$result = mysqli_query($GLOBALS['db_connect'],"select p.poster_id from `tbl_poster` p,`tbl_auction` a where poster_title LIKE '".$res_array."' and 
						   a.fk_poster_id=p.poster_id AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
					
					)
						   ");
	$found=array();
	while($row=mysqli_fetch_assoc($result)){
		array_push($found,$row['poster_id']);
	}
	
	$result_auction = mysqli_query($GLOBALS['db_connect'],"select p.poster_id from `tbl_poster_live` p,`tbl_auction_live` a where p.poster_title LIKE '".$res_array."' and 
						   a.fk_poster_id=p.poster_id AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())))
						   ");
	while($row=mysqli_fetch_assoc($result_auction)){
		array_push($found,$row['poster_id']);
	}

	return $found;
	
}

function get_poster_id_details($wantlist_id) {
    //echo "select fk_genre_id, fk_poster_size_id, fk_decade_id, fk_country_id from tbl_wantlist where wantlist_id = $wantlist_id";
	//exit;
	//echo "select fk_genre_id, fk_poster_size_id, fk_decade_id, fk_country_id from tbl_wantlist where wantlist_id = $wantlist_id";
	//echo "select poster_title from tbl_wantlist where wantlist_id = $wantlist_id";
	$result = mysqli_query($GLOBALS['db_connect'],"select poster_title from tbl_wantlist where wantlist_id = $wantlist_id"); 
	$res_row = mysqli_fetch_assoc($result);
	$res_array = mysqli_real_escape_string($GLOBALS['db_connect'], $res_row['poster_title']);
	$res_array = "%" . $res_array . "%" ;
	
	//echo $sql="select poster_id from `tbl_poster` where poster_title='".$res_array."'";
	
	$result = mysqli_query($GLOBALS['db_connect'],"select p.poster_id from `tbl_poster` p,`tbl_auction` a where poster_title LIKE '".$res_array."' and 
						   a.fk_poster_id=p.poster_id AND ((a.fk_auction_type_id = '1' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0')
					
					)
						   ");
	$found=array();
	while($row=mysqli_fetch_assoc($result)){
		array_push($found,'fixed-'.$row['poster_id']);
	}
	
	$result_auction = mysqli_query($GLOBALS['db_connect'],"select p.poster_id from `tbl_poster_live` p,`tbl_auction_live` a where p.poster_title LIKE '".$res_array."' and 
						   a.fk_poster_id=p.poster_id AND ((a.fk_auction_type_id = '2' AND a.auction_is_approved = '1' AND a.auction_is_sold = '0'
					AND (a.auction_actual_start_datetime <= now() AND a.auction_actual_end_datetime >= now())))
						   ");
	while($row=mysqli_fetch_assoc($result_auction)){
		array_push($found,'weekly-'.$row['poster_id']);
	}
	
	return $found;
	
}	

function countNewAuctionWithWantlist($auction_id){
	$auctionCategory=array();
	$wantList=array();
	$sql="Select p.poster_title,a.auction_actual_start_datetime from `tbl_poster_live` p, `tbl_auction_live` a where a.auction_id=$auction_id and p.poster_id=a.fk_poster_id";
	$row_sql=mysqli_query($GLOBALS['db_connect'],$sql);
	$res_sql=mysqli_fetch_assoc($row_sql);
	$mail_poster_title=$res_sql['poster_title'];
	$auctionCategory=strtolower($res_sql['poster_title']);
	$result = mysqli_query($GLOBALS['db_connect'],"select fk_user_id,wantlist_id,poster_title from tbl_wantlist");	
	 while($res_row = mysqli_fetch_assoc($result)){
	 	 $res_array = strtolower($res_row['poster_title']);
		 $wantlist_id=$res_row['fk_user_id'];
		 //$posMatch = stripos($res_array, $auctionCategory);
	 if(preg_match("/".$res_array."/i",$auctionCategory)){
				//array_push($wantList,$wantlist_id);
				sendMailByUserid($mail_poster_title,$wantlist_id,$res_sql['auction_actual_start_datetime']);
			}
		 }
		//return $wantList;
	}
}
?>
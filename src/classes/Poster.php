<?php

class Poster extends DBCommon{
	
	public function __construct(){		
		$this->primaryKey = 'poster_id';
		$this->orderBy = 'poster_id';
		parent::__construct();
	}
	function selectAllPostersById($poster_id){
		$sql = "SELECT *
		 		FROM ".TBL_POSTER_IMAGES." 
				WHERE fk_poster_id = $poster_id
				ORDER BY is_default DESC ";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $catArr[] = $row;
		   }
	    }
		return $catArr;
	}
	
	function selectAllPostersByIdLive($poster_id){
		$sql = "SELECT *
		 		FROM tbl_poster_images_live 
				WHERE fk_poster_id = $poster_id
				ORDER BY is_default DESC ";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $catArr[] = $row;
		   }
	    }
		return $catArr;
	}
	
	function fetchPosterCategories(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			$poster_ids .= $dataArr[$i]['poster_id'].",";
		}
		$poster_ids = trim($poster_ids, ',');
		
		/*$sql = "SELECT ptc.fk_poster_id, c.cat_value FROM ".TBL_POSTER_TO_CATEGORY." ptc
				LEFT JOIN ".TBL_CATEGORY." c ON ptc.fk_cat_id = c.cat_id
				WHERE ptc.fk_poster_id IN (".$poster_ids.")";*/
				
		 $sql = "SELECT ptc.fk_poster_id, c.cat_value, c.fk_cat_type_id
		 		FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_CATEGORY." c
				WHERE ptc.fk_cat_id = c.cat_id AND ptc.fk_poster_id IN (".$poster_ids.")
				ORDER BY c.fk_cat_type_id";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $catArr[] = $row;
		   }
	    }
		
		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($catArr);$j++){
				if($dataArr[$i]['poster_id'] == $catArr[$j]['fk_poster_id']){
					$arr[$flag]['fk_cat_type_id'] = $catArr[$j]['fk_cat_type_id'];
					$arr[$flag]['cat_value'] = $catArr[$j]['cat_value'];
					$flag++;
					//$dataArr[$i]['categories'] .= $catArr[$j]['cat_value'].",";
				}				
			}
			//$dataArr[$i]['categories'] = trim($dataArr[$i]['categories'], ',');
			$dataArr[$i]['categories'] = $arr;
			unset($arr);
		}		
	   return true;
	}
	function countTotalPoster(&$dataArr){
		for($i=0;$i<count($dataArr);$i++){
			$sql = "SELECT count(pi.poster_image_id) AS tot_poster from
							".TBL_AUCTION." a,".TBL_POSTER." p,".TBL_POSTER_IMAGES." pi
							where a.auction_id= '".$dataArr[$i]['auction_id']."'
							and p.poster_id= a.fk_poster_id
							and pi.fk_poster_id = p.poster_id ";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			$row = mysqli_fetch_assoc($rs);		
			$tot_poster=$row['tot_poster'];		
			$dataArr[$i]['total_poster'] = $tot_poster;				
					}
			return $dataArr;		
		}
	function fetchPosterImages(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			$poster_ids .= $dataArr[$i]['poster_id'].",";
		}
		$poster_ids = trim($poster_ids, ',');
		
		$sql = "SELECT pi.fk_poster_id, pi.poster_image, pi.is_default FROM ".TBL_POSTER_IMAGES." pi
				WHERE pi.fk_poster_id IN (".$poster_ids.")";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $imagesArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($imagesArr);$j++){
				if($dataArr[$i]['poster_id'] == $imagesArr[$j]['fk_poster_id']){					
					 $arr[$flag]['poster_image'] = $imagesArr[$j]['poster_image'];
					 if($imagesArr[$j]['is_default'] == 1){
						 $arr[$flag]['is_default'] = 1;
					 }else{
						 $arr[$flag]['is_default'] = 0;
					 }
					 $flag++;
				}				
			}
			$dataArr[$i]['images'] = $arr;			
			unset($arr);
		}
	   return true;
	}
	
	function countNewAuctionWithWantlist($auction_id){
	$auctionCategory=array();
	$wantList=array();
	$sql="Select p.poster_title,a.auction_actual_start_datetime from `tbl_poster_live` p, `tbl_auction_live` a where a.auction_id=$auction_id and p.poster_id=a.fk_poster_id";
	$row_sql=mysqli_query($GLOBALS['db_connect'],$sql);
	$res_sql=mysqli_fetch_array($row_sql);
	$mail_poster_title=$res_sql['poster_title'];
	$auctionCategory=strtolower($res_sql['poster_title']);
	$result = mysqli_query($GLOBALS['db_connect'],"select fk_user_id,wantlist_id,poster_title from tbl_wantlist");	
	 while($res_row = mysqli_fetch_array($result)){
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
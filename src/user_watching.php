<?php  
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}if($_REQUEST['mode']=='delete_all_watching' || $_REQUEST['del_mode']=='delete_all_watching'){
	delete_all_watching();
}elseif($_REQUEST['mode']=='add_note'){
	add_note();
}else{
	displayList();
}
ob_end_flush();
	
function displayList()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuction']){
        $_SESSION['sessAuction'] = $_REQUEST['view_mode'];
    }
	
	if(isset($_REQUEST[type]) && $_REQUEST[type]!=''){
		$type=$_REQUEST[type];
	}else{
		$type='';
	}
	
	if($type==''){
		$sql_count="SELECT COUNT(watching_id) AS counter FROM `tbl_watching` w , tbl_auction_live a WHERE w.user_id='".$_SESSION['sessUserID']."' 
					AND a.auction_id=w.auction_id and w.status='0' ";	
		$rs = mysqli_query($GLOBALS['db_connect'],$sql_count) or die(mysqli_error($GLOBALS['db_connect']));
		$row = mysqli_fetch_array($rs);
		$total= $row['counter'];
		
		if($total>0){
			$sql_watching="SELECT w.watching_id,a.auction_id,a.fk_auction_type_id, a.auction_asked_price,
			a.auction_buynow_price,a.auction_actual_end_datetime,a.auction_is_sold, 				
			a.auction_actual_start_datetime, (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
			p.fk_user_id, p.poster_id, p.poster_title,pi.poster_thumb,w.add_note,pi.is_cloud,a.bid_count
			FROM ".TBL_WATCHING." w,tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
			LEFT JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
			WHERE pi.is_default = '1' and w.status='0' and w.auction_id=a.auction_id and w.user_id='".$_SESSION['sessUserID']."'
			ORDER BY w.add_date DESC " ;
			if($_REQUEST['toshow'] > 0 ){
				if($_REQUEST['offset'] > 0){
					
				}else{
						$_REQUEST['offset'] = 0;
				}
				$sql_watching.=" LIMIT ".$_REQUEST['offset'].", ".$_REQUEST['toshow']." ";
			}	
		}
	
	}elseif($type=='fixed'){
		$sql_count="SELECT COUNT(watching_id) AS counter FROM `tbl_watching` tw,`tbl_auction` a WHERE tw.user_id='".$_SESSION['sessUserID']."' 
	                  AND a.auction_id = tw.auction_id ";
		
		$sql_count .=" AND a.auction_is_sold ='0' AND a.fk_auction_type_id='1' ";
		
		$rs = mysqli_query($GLOBALS['db_connect'],$sql_count) or die(mysqli_error($GLOBALS['db_connect']));
		$row = mysqli_fetch_array($rs);
		$total= $row['counter'];
		
		if($total>0){
			$sql_watching="SELECT w.watching_id,a.auction_id,a.fk_auction_type_id, a.auction_asked_price, a.auction_reserve_offer_price,
			a.is_offer_price_percentage, a.auction_buynow_price,a.auction_is_sold, 				
			p.fk_user_id, p.poster_id, p.poster_title,pi.poster_thumb,pi.is_cloud,w.add_note
			FROM ".TBL_WATCHING." w,tbl_auction a LEFT JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
			LEFT JOIN tbl_poster_images pi ON a.fk_poster_id = pi.fk_poster_id
			WHERE pi.is_default = '1' and w.auction_id=a.auction_id AND w.user_id='".$_SESSION['sessUserID']."' AND a.fk_auction_type_id='1'  AND a.auction_is_sold='0'
			ORDER BY w.add_date DESC " ;
			if($_REQUEST['toshow'] > 0 ){
				if($_REQUEST['offset'] > 0){
				}else{
					$_REQUEST['offset'] = 0;
				}
				$sql_watching.=" LIMIT ".$_REQUEST['offset'].", ".$_REQUEST['toshow']." ";
			}	
		}
		
	}elseif($type=='sold'){
	
		
		 $sql_count = "SELECT COUNT(1) AS counter
					FROM tbl_sold_archive tsa,tbl_watching tw
					WHERE tsa.auction_id = tw.auction_id
					AND tw.user_id='".$_SESSION['sessUserID']."'
					AND tw.status='1' ";			
		 $rs = mysqli_query($GLOBALS['db_connect'],$sql_count) or die(mysqli_error($GLOBALS['db_connect']));
		 $row = mysqli_fetch_array($rs);
		 $total= $row['counter'];		
		
		
		if($total>0){
			$sql_watching="SELECT w.watching_id,p.poster_title,tsa.* FROM ".TBL_WATCHING." w,tbl_sold_archive tsa,tbl_poster p
							   WHERE w.user_id='".$_SESSION['sessUserID']."'
							   AND tsa.auction_id = w.auction_id
							   AND p.poster_id=tsa.poster_id AND w.status='1' order by tsa.invoice_generated_on desc ";
			
			
			if(isset($_REQUEST['toshow']) && $_REQUEST['toshow']> 0 ){
				if($_REQUEST['offset'] > 0){
				}else{
					$_REQUEST['offset'] = 0;
				}
				$sql_watching.=" LIMIT ".$_REQUEST['offset'].", ".$_REQUEST['toshow']." ";
			}else{
				$sql_watching.=" LIMIT 0,33 ";
			}
		}
	}
	

	
	if($total > 0){					
		if($rs_watching = mysqli_query($GLOBALS['db_connect'],$sql_watching)){
			while($row_watching = mysqli_fetch_assoc($rs_watching)){
				$dataArr[] = $row_watching;
			}
		}
		
		if($type=='sold' || $type=='fixed'){
			for($i=0;$i<count($dataArr);$i++){				
									  
																															   
		 
				$dataArr[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$dataArr[$i]['poster_thumb'];			
			}
		}else{
			for($i=0;$i<count($dataArr);$i++){
				if ($dataArr[$i]['is_cloud']=='0'){
					$dataArr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$dataArr[$i]['poster_thumb'];
				}else{
					if($type==''){
						$dataArr[$i]['image_path']=CLOUD_POSTER_THUMB.$dataArr[$i]['poster_thumb'];
					}
				}
		
				if($dataArr[$i]['fk_auction_type_id'] == 2 && $dataArr[$i]['auction_is_sold'] == 0){
												
					$dataArr[$i]['auction_countdown'] = '<span id="cd_'.$dataArr[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$dataArr[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$dataArr[$i]['seconds_left'].', new Date())});</script></span>';
					
				}
			}
		}
  
		$smarty->assign('watchingItems', $dataArr);
		$smarty->assign('json_arr', json_encode($dataArr));
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));
			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
		if(!isset($_REQUEST['offset'])){
			$offset=0;
		}else{
			$offset=$_REQUEST['offset'];
		}
		if(!isset($_REQUEST['toshow'])){
			//$toshow=$total;
		}else{
			$toshow=$_REQUEST['toshow'];
		}
		$smarty->assign('offset', $offset);
		$smarty->assign('toshow', $toshow);
	
	}
	$smarty->assign('total', $total);
	
	if($_SESSION['sessAuction'] == 'list'){
		$smarty->display("user_watching.tpl");
    }else{
		$smarty->display("user_watching_grid.tpl");
	}
	
}
function delete_all_watching()
{		
	$flag = 1;
	if(!isset($_REQUEST['offset'])){
		$offset=0;
	}else{
		$offset=$_REQUEST['offset'];
	}
	if(isset($_REQUEST['toshow']) && $_REQUEST['toshow']< 1){
		//$toshow=$_REQUEST['total'];
	}else{
		$toshow=$_REQUEST['toshow'];
	}
	$obj = new DBCommon();
	if(count($_REQUEST['watching_ids']) > 0){
		foreach($_REQUEST['watching_ids'] as $val){
		$chk = $obj->deleteData(TBL_WATCHING, array("watching_id" => $val));
		if($chk == false){
			$flag = 0;
			}
		}	

		  if($flag == 1){
			$_SESSION['Err']="The selected posters has been removed from the watchlist.";
			header("location: ".PHP_SELF."?offset=".$offset."&toshow=".$toshow);
			exit;
		  }else{
			$_SESSION['Err'] .="All Watching not deleted successfully.";
			header("location: ".PHP_SELF."?offset=".$offset."&toshow=".$toshow);
			exit;
			}
   }else{
		$_SESSION['Err'] .="Please select an watching to delete.";
		header("location:".PHP_SELF."?offset=".$offset."&toshow=".$toshow);
		exit;
   }
}
function add_note(){
 	$watchlist_id = $_REQUEST['id'];
	$add_note_text = $_REQUEST['add_note_text'];
	$sql = "Update tbl_watching set add_note = '".$add_note_text."' WHERE watching_id= ".$watchlist_id;
	if(mysqli_query($GLOBALS['db_connect'],$sql)){
		echo "1" ;
	}
 }
?>
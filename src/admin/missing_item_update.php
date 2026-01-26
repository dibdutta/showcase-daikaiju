<?php


define ("DB_SERVER", "localhost");
define ("DB_NAME", "mpe");
define ("DB_USER", "geotech");
define ("DB_PASSWORD", "Hello@4321");

$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");

$total=0;

$sql = " SELECT auction_id,fk_poster_id FROM tbl_auction WHERE fk_auction_week_id = ".$_REQUEST['week_id']." AND auction_is_sold='1'  ";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
while($row = mysqli_fetch_array($res)){
	$sql_archive_bids = "SELECT bid_id from tbl_bid_archive where bid_is_won='1' AND bid_fk_auction_id=".$row['auction_id'];
	$res_archive_bids = mysqli_query($GLOBALS['db_connect'],$sql_archive_bids);
	$row_archive_bids = mysqli_fetch_array($res_archive_bids);
	$sql_archive = "SELECT COUNT(1) as counter FROM tbl_invoice_to_auction WHERE tbl_invoice_to_auction.fk_auction_id= ".$row['auction_id'];
	//echo $sql_archive;
	$res_archive = mysqli_query($GLOBALS['db_connect'],$sql_archive);
	$row_archive = mysqli_fetch_array($res_archive);
	if($row_archive['counter']==0){
		$sql_update = "SELECT COUNT(1) as count FROM tbl_poster_images WHERE fk_poster_id = ".$row['fk_poster_id'];
		$update_sql = mysqli_query($GLOBALS['db_connect'],$sql_update);
		$row_update = mysqli_fetch_array($update_sql);
		echo $row_update['count'];
		echo "<br/>";
		if($row_update['count']==1){
			$sql_update1 = "SELECT poster_image_id FROM tbl_poster_images WHERE fk_poster_id = ".$row['fk_poster_id'];
			$update_sql1 = mysqli_query($GLOBALS['db_connect'],$sql_update1);
			$row_update1 = mysqli_fetch_array($update_sql1);
			
			$s_update = "UPDATE tbl_poster_images
					SET is_default = '1'
					WHERE poster_image_id=".$row_update1['poster_image_id'];
			mysqli_query($GLOBALS['db_connect'],$s_update);
			echo "Lost-".$row['fk_poster_id'];
			echo "<br/>";
		}else{			
			$sql_update1 = "SELECT poster_image_id FROM tbl_poster_images WHERE fk_poster_id = ".$row['fk_poster_id']." LIMIT 0,1 ";
			$update_sql1 = mysqli_query($GLOBALS['db_connect'],$sql_update1);
			$row_update1 = mysqli_fetch_array($update_sql1);
			
			$s_update = "UPDATE tbl_poster_images
					SET is_default = '1'
					WHERE poster_image_id=".$row_update1['poster_image_id'];
			mysqli_query($GLOBALS['db_connect'],$s_update);
		
			echo "Multiple-".$row['fk_poster_id'];
			echo "<br/>";
		}			
	}
	
}

echo $total;
?>
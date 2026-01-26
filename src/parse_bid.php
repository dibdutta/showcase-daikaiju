<?php


define ("DB_SERVER", "localhost");
define ("DB_NAME", "mpe");
define ("DB_USER", "geotech");
define ("DB_PASSWORD", "Hello@4321");

$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");



$sql = "SELECT * from tbl_bid where post_date <= '2016-04-10 21:00:00' ";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
while($row = mysqli_fetch_array($res)){
	$sql_archive = "SELECT count(1) as counter from tbl_bid_archive where bid_id =".$row['bid_id'];
	$res_archive = mysqli_query($GLOBALS['db_connect'],$sql_archive);
	$row_archive = mysqli_fetch_array($res_archive);
	if($row_archive['counter']==0){
		$sql_insert = "Insert into tbl_bid_archive (`bid_id`,`bid_fk_user_id`,`bid_fk_auction_id`,`bid_amount`,`is_proxy`,`bid_is_won`,`post_date`,`post_ip`) values 
						(".$row['bid_id'].",".$row['bid_fk_user_id'].",".$row['bid_fk_auction_id'].",".$row['bid_amount'].",".$row['is_proxy'].",'".$row['bid_is_won']."','".$row['post_date']."','".$row['post_ip']."' )" ;
		mysqli_query($GLOBALS['db_connect'],$sql_insert);
	}
	$sql_del = "Delete from tbl_bid where bid_id=".$row['bid_id'];
	//mysqli_query($GLOBALS['db_connect'],$sql_del);
}


?>
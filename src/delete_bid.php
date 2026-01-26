<?php


define ("DB_SERVER", "localhost");
define ("DB_NAME", "mpe");
define ("DB_USER", "geotech");
define ("DB_PASSWORD", "Hello@4321");

$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");



$sql = "SELECT b.bid_id FROM tbl_auction a,tbl_bid b WHERE a.fk_auction_week_id =300 AND a.auction_id=b.bid_fk_auction_id";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
while($row = mysqli_fetch_array($res)){
	echo $row['bid_id'];
	$sql_del = "Delete from tbl_bid where bid_id=".$row['bid_id'];
	mysqli_query($GLOBALS['db_connect'],$sql_del);
}


?>
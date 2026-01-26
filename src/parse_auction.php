<?php


define ("DB_SERVER", "localhost");
define ("DB_NAME", "mpe");
define ("DB_USER", "geotech");
define ("DB_PASSWORD", "Hello@4321");

$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");



$sql = "SELECT * FROM tbl_auction WHERE auction_is_sold <> '1' AND auction_actual_end_datetime < '2016-01-17 22:00:00' AND fk_auction_type_id NOT IN (1,6) ";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
while($row = mysqli_fetch_array($res)){
	$sql_archive = "SELECT count(1) as counter from tbl_auction_archive where auction_id =".$row['auction_id'];
	$res_archive = mysqli_query($GLOBALS['db_connect'],$sql_archive);
	$row_archive = mysqli_fetch_array($res_archive);
	if($row_archive['counter']==0){
		$sql_insert = "Insert into tbl_auction_archive (`auction_id`,`fk_auction_type_id`,`fk_poster_id`,`fk_event_id`,`fk_auction_week_id`,`auction_asked_price`,`auction_reserve_offer_price`,`is_offer_price_percentage`,`auction_buynow_price`,`auction_start_date`,`auction_end_date`,`auction_actual_start_datetime`,`auction_actual_end_datetime`,`auction_is_approved`,`reopen_auction_id`,`is_reopened`,`is_paying`,`is_approved_for_monthly_auction`,`auction_is_sold`,`auction_payment_is_done`,`auction_payment_is_done_seller`,`auction_note`,`post_date`,`up_date`,`status`,`post_ip`,`slider_first_position_status`,`is_deleted`,`is_considered`,`bid_count`,`max_bid_amount`,`highest_user`,`in_cart`,`is_set_for_home_big_slider`,`imdb_link`) values 
						(".$row['auction_id'].",".$row['fk_auction_type_id'].",".$row['fk_poster_id'].",".$row['fk_event_id'].",".$row['fk_auction_week_id'].",".$row['auction_asked_price'].",".$row['auction_reserve_offer_price'].",".$row['is_offer_price_percentage'].",".$row['auction_buynow_price'].",'".$row['auction_start_date']."','".$row['auction_end_date']."' ,'".$row['auction_actual_start_datetime']."','".$row['auction_actual_end_datetime']."','".$row['auction_is_approved']."',".$row['reopen_auction_id'].", '".$row['is_reopened']."','".$row['is_paying']."','".$row['is_approved_for_monthly_auction']."','".$row['auction_is_sold']."','".$row['auction_payment_is_done']."','".$row['auction_payment_is_done_seller']."','".$row['auction_note']."','".$row['post_date']."','".$row['up_date']."','".$row['status']."','".$row['post_ip']."',".$row['slider_first_position_status'].",'".$row['is_deleted']."','".$row['is_considered']."',".$row['bid_count'].",".$row['max_bid_amount'].",".$row['highest_user'].",'".$row['in_cart']."','".$row['is_set_for_home_big_slider']."','".$row['imdb_link']."')" ;
		
		mysqli_query($GLOBALS['db_connect'],$sql_insert);
	}
	$sql_del = "Delete from tbl_auction where auction_id=".$row['auction_id'];
	mysqli_query($GLOBALS['db_connect'],$sql_del);
}


?>
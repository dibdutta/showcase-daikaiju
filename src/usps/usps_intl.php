<?php
include("usps_calculator_intl.php");
define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
$totalPoster=$_REQUEST['totalPoster'];
/*if($_REQUEST['country_id']!='38'){
$sql=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select country_name from country_table where country_id=".$_REQUEST['country_id']));
$dest=$sql['country_name']; 
$weight_arr=explode(',', $_REQUEST['weights']);
$i=0;
$Price=0.00;
$err_ind=false;
foreach($weight_arr as $key =>$val){
	$sql_fetch_shipping_details=" Select * from tbl_size_weight_cost_master
									 where size_weight_cost_id = ".$weight_arr[$i];
	
	$sql_fetch_shipping_details_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_fetch_shipping_details));
	$length =$sql_fetch_shipping_details_res['length'];
	$width = $sql_fetch_shipping_details_res['width'];
	$height = $sql_fetch_shipping_details_res['height'];
	$weight_lb=$sql_fetch_shipping_details_res['weight_lb'];
	$weight_oz=$sql_fetch_shipping_details_res['weight_oz'];
	$packaging_cost=$sql_fetch_shipping_details_res['packaging_cost'];
	$arrFromUsps=explode('/',USPSParcelRate($dest,$width, $height, $length, $weight_lb,$weight_oz));
	if($arrFromUsps[0]==''){
	 $err_ind=true;
	}else{
	$Price =$Price + $arrFromUsps[0] + $packaging_cost;
	}
	$DeleveryTime=$arrFromUsps[1]; 
	$i++;
}
if($err_ind){
	echo $err="Y";
}else{
	echo $Price."/".$DeleveryTime;
}
}else*/if($_REQUEST['country_id']=='38'){
	$Price=$totalPoster * 15;
	echo $Price."/".$DeleveryTime;
}else{
	$Price=$totalPoster * 21;
	echo $Price."/".$DeleveryTime;
}
?>
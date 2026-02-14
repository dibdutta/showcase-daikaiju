<?php

/*define ("INCLUDE_PATH", $_SERVER['DOCUMENT_ROOT']."/");
require_once INCLUDE_PATH."lib/inc.php";

if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "process_offers"){
    process_offers();
}if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "update_bid"){
    updateBidCronJob();
}

ob_end_flush();*/
/*************************************************/
define ("FULL_PATH", "http://www.movieposterexchange.com");
define ("CLOUD_STATIC","https://d2m46dmzqzklm5.cloudfront.net/images/");
define ("HOST_NAME", "www.movieposterexchange.com");
define ('MAIL_BODY_TOP', '<html><head></head><body style="  padding:0px; margin:0px;">
<table align="center" bgcolor="#FFFFFF" width="600px" border="0" cellspacing="0" cellpadding="0">

	<tr>
		<td background="'.CLOUD_STATIC.'emailer-bg.png" width="100%" height="10">
		</td>
	</tr>
	<tr>
		<td valign="middle" width="100%" style=" padding:10px;border-left:1px solid #dbd9da; border-right:1px solid #dbd9da; background-color:#f5f5f5; border-bottom:1px solid #dbd9da;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
			<tr>
			<td width="260" valign="top">
			<a href="'.FULL_PATH.'/index.php" target="_blank"><img src="'.CLOUD_STATIC.'logo.png" alt="logo" width="142" height="189" border="0"></a>
			</td>
			<td valign="middle" align="right">&nbsp;</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr><td width="100%" valign="top" style="border-left:1px solid #dbd9da; border-right:1px solid #dbd9da; padding: 5px; font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size:14px;"><br />');

define ('MAIL_BODY_BOTTOM', '</td></tr>
<tr>
<td background="'.CLOUD_STATIC.'footer-bg.png"  width="100%" height="75">
	<table align="center" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td align="right"><p style="padding: 5px; font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size:12px; color: #a2a8ab;" ><span>&copy; 2010 - 2011.Movie Poster exchange .</span>
			</td>
		</tr>
	</table>
</td>
</tr></table>

</body></html>');

/*if(HOST_NAME=="192.168.100.140:8082"){
	define ("DB_NAME", "mpe_test");
	define ("DB_SERVER", "localhost");
	define ("DB_USER", "root");
	define ("DB_PASSWORD", "");
}elseif(HOST_NAME=="localhost:8081"){
	define ("DB_NAME", "mpe");
	define ("DB_SERVER", "localhost");
	define ("DB_USER", "root");
	define ("DB_PASSWORD", "");
}elseif(HOST_NAME=="192.168.100.82:301"){
	define ("DB_NAME", "mpe");
	define ("DB_SERVER", "localhost");
	define ("DB_USER", "root");
	define ("DB_PASSWORD", "");
}elseif(HOST_NAME=="movieposterexchange.com" ||  HOST_NAME=="www.movieposterexchange.com"){*/
	define ("DB_SERVER", getenv('DB_SERVER') ?: "mysql");
	define ("DB_NAME", getenv('DB_NAME') ?: "mpe");
	define ("DB_USER", getenv('DB_USER') ?: "root");
	define ("DB_PASSWORD", getenv('DB_PASSWORD') ?: "root");
	
/*}elseif(HOST_NAME=="mpe.geotechinfo.co.uk"){
	define ("DB_SERVER", "localhost");
	define ("DB_NAME", "geotech_mpe");
	define ("DB_USER", "ranjan");
	define ("DB_PASSWORD", "geotech@1234");
}else{
	define ("DB_SERVER", "localhost");
	define ("DB_NAME", "mpe");
	define ("DB_USER", "mpegeotech");
	define ("DB_PASSWORD", "gipl@321890");
}*/

$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");
date_default_timezone_set('America/New_York');


//////////////    administration  information   //////////

define ("CONFIG_TABLE", "config_table");
define ("CONFIG_ADMIN_NAME", "admin_name");
define ("CONFIG_ADMIN_EMAIL", "admin_email");

define ("USER_TABLE", "user_table");
define ("TBL_POSTER", "tbl_poster");
define ("TBL_AUCTION", "tbl_auction");
define ("TBL_OFFER", "tbl_offer");
define ("TBL_BID", "tbl_bid_archive");
define ("COUNTRY_TABLE", "country_table");
define ("TBL_INVOICE", "tbl_invoice");
define ("TBL_INVOICE_TO_AUCTION", "tbl_invoice_to_auction");


function generateInvoice($id, $is_bid,$auction_id='')
{
	if($is_bid){
		$sql = "SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
				u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
				u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
				u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
				c.country_code AS shipping_country_code,b.bid_fk_auction_id, b.bid_amount AS amount,
				p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,a.auction_id,a.fk_auction_week_id,pi.poster_thumb
				FROM ".USER_TABLE." u, ".TBL_BID." b, ".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a,tbl_poster_images pi
				WHERE b.bid_id = '".$id."'
				AND u.country_id = c.country_id
				AND b.bid_fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id
				AND pi.fk_poster_id = a.fk_poster_id
				AND pi.is_default = '1'
				AND u.user_id = b.bid_fk_user_id";
	}else{		 
		$sql ="SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
			   u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
			   u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
			   u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
			   c.country_code AS shipping_country_code, p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,
			   ofr.offer_id, cntr_ofr.offer_id AS cntr_offer_id, ofr.offer_is_accepted, cntr_ofr.offer_is_accepted cntr_offer_is_accepted, 
			   ofr.offer_amount, cntr_ofr.offer_amount AS cntr_offer_amount,ofr.offer_fk_auction_id , a.auction_id,a.fk_auction_week_id,pi.poster_thumb
			   FROM tbl_poster_images pi,".USER_TABLE." u,".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a ,`tbl_offer` ofr
			   LEFT JOIN `tbl_offer` cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
			   WHERE( ofr.offer_id ='".$id."' OR cntr_ofr.offer_id ='".$id."' )
			   AND(ofr.offer_is_accepted = '1' or cntr_ofr.offer_is_accepted = '1')
			   AND ofr.offer_parent_id=0 AND ofr.offer_fk_user_id=u.user_id
			   AND u.country_id = c.country_id AND ofr.offer_fk_auction_id = a.auction_id
			   AND a.fk_poster_id = p.poster_id
			   AND pi.fk_poster_id = a.fk_poster_id
			   AND pi.is_default = '1' ";	
	}
	$rs = mysqli_query($GLOBALS['db_connect'],$sql);
	$row = mysqli_fetch_array($rs);
	$winnerName = $row['firstname'].' '.$row['lastname'];
	
	$sql_insert_sold="Insert into `tbl_sold_archive` (`auction_id`,
													 `invoice_generated_on`,
													 `fk_auction_type_id`,
							 						 `poster_id`,
							 						 `winnerName`,
							 						 `soldamnt`,
													 `is_cloud`,
													 `auction_week_id`,
													 `poster_thumb`) values
							 						 (
													  '".$row['auction_id']."',							 						  
							 						  '".date("Y-m-d H:i:s")."',
							 						  '2',							 						  
							 						  '".$row['poster_id']."',
							 						  '".$winnerName."',
							 						  '".$row['amount']."',
													  '1',
													  '".$row['fk_auction_week_id']."',
													  '".$row['poster_thumb']."'
							 						 )";
	mysqli_query($GLOBALS['db_connect'],$sql_insert_sold);	
	if($is_bid){
		$amount = $row['amount'];
		$auction_id = $row['bid_fk_auction_id'];	
	}else{
		 $auction_id = $row['offer_fk_auction_id'];	
		 if($row['offer_is_accepted'] == '1'){
			$amount = $row['offer_amount'];
		 }elseif($row['cntr_offer_is_accepted'] == '1'){
			$amount = $row['cntr_offer_amount'];
		 }
	}
	$billing_address = serialize(array('billing_firstname' => $row['firstname'],
									   'billing_lastname' => $row['lastname'],
									   'billing_country_id' => $row['country_id'],
									   'billing_country_name' => $row['country_name'],
									   'billing_country_code' => $row['country_code'],
									   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['city']),
									   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['state']),
									   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address1']),
									   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address2']),
									   'billing_zipcode' => $row['zipcode']));
	$shipping_address = serialize(array('shipping_firstname' => $row['firstname'],
										'shipping_lastname' => $row['lastname'],
										'shipping_country_id' => $row['shipping_country_id'],
										'shipping_country_name' => $row['shipping_country_name'],
										'shipping_country_code' => $row['shipping_country_code'],
										'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_city']),
										'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_state']),
										'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address1']),
										'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address2']),
										'shipping_zipcode' => $row['shipping_zipcode']));
	$auction_details = serialize(array(0 => array('auction_id' => $row['auction_id'],
												  'poster_sku' => $row['poster_sku'],
												  'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['poster_title']),
												  'amount' => $amount)));
    $select_is_sold="SELECT fk_invoice_id from tbl_invoice_to_auction where fk_auction_id ='".$auction_id."' ";
    $res_select_is_sold=mysqli_fetch_row(mysqli_query($GLOBALS['db_connect'],$select_is_sold));

    if($res_select_is_sold==0){

        $data = array('fk_user_id' => $row['user_id'], 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
				  'total_amount' => $amount, 'auction_details' => $auction_details, 'invoice_generated_on' => date("Y-m-d H:i:s"), 'is_buyers_copy' => 1);
	
	/*if($row['shipping_state'] == 'Georgia'){
		$sale_tax =  array('description' => 'Sale Tax', 'amount' => SALE_TAX_GA);
	}elseif($row['shipping_state'] == 'North Carolina'){
		$sale_tax =  array('description' => 'Sale Tax', 'amount' => SALE_TAX_NC);
	}
	
	$additional_charges = serialize(array(0 => $sale_tax));*/
	 
	/* Invoice for Buyer */
	//$invoice_id = $this->updateData(TBL_INVOICE, $data);
	//$this->updateData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => $auction_id, 'fk_invoice_id' => $invoice_id, 'amount' => $amount));
	
	
	$sql = "INSERT INTO ".TBL_INVOICE." SET
			fk_user_id = '".$row['user_id']."',
			billing_address = '".$billing_address."',
			shipping_address = '".$shipping_address."',
			total_amount = '".$amount."',
			auction_details = '".$auction_details."',
			invoice_generated_on = '".date("Y-m-d H:i:s")."',
			is_buyers_copy = '1'";
	
	if(mysqli_query($GLOBALS['db_connect'],$sql)){
		$invoice_id = mysqli_insert_id($GLOBALS['db_connect']);	
		$sql = "INSERT INTO ".TBL_INVOICE_TO_AUCTION." SET
				fk_auction_id = '".$auction_id."',
				fk_invoice_id = '".$invoice_id."',
				amount = '".$amount."'";
		mysqli_query($GLOBALS['db_connect'],$sql);
	}
        return "true";
    }else{
        return "false";
    }
}

generateInvoice(1111370,TRUE);


?>

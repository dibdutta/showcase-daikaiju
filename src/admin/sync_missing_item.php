<?php
define ("FULL_PATH", "http://www.movieposterexchange.com");
define ("CLOUD_STATIC","http://c4808190.r90.cf2.rackcdn.com/");
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

define ("DB_SERVER", "localhost");
define ("DB_NAME", "mpe");
define ("DB_USER", "geotech");
define ("DB_PASSWORD", "Hello@4321");

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
define ("TBL_BID", "tbl_bid");
define ("COUNTRY_TABLE", "country_table");
define ("TBL_INVOICE", "tbl_invoice");
define ("TBL_INVOICE_TO_AUCTION", "tbl_invoice_to_auction");

$sqlAdmin = "SELECT ".CONFIG_ADMIN_NAME.", ".CONFIG_ADMIN_EMAIL." FROM ".CONFIG_TABLE."";
$resAdmin = mysqli_query($GLOBALS['db_connect'],$sqlAdmin);
$rowAdmin = mysqli_fetch_array($resAdmin);

define ("ADMIN_NAME", $rowAdmin[CONFIG_ADMIN_NAME]);
define ("ADMIN_EMAIL_ADDRESS", $rowAdmin[CONFIG_ADMIN_EMAIL]);




$sql = " SELECT auction_id FROM tbl_auction WHERE fk_auction_week_id = ".($_REQUEST['week_id'] ?? '')." AND auction_is_sold='1'  ";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
while($row = mysqli_fetch_array($res)){
	//$sql_archive = "SELECT count(1) as counter from tbl_bid_archive where bid_is_won='1' AND bid_fk_auction_id=".$row['auction_id'];
	$sql_archive = "SELECT COUNT(1) as counter FROM tbl_invoice_to_auction WHERE tbl_invoice_to_auction.fk_auction_id= ".$row['auction_id'];
	//echo $sql_archive;
	$res_archive = mysqli_query($GLOBALS['db_connect'],$sql_archive);
	$row_archive = mysqli_fetch_array($res_archive);
	if($row_archive['counter']==0){
		$sql_archive_bids = "SELECT bid_id from tbl_bid_archive where bid_is_won='1' AND bid_fk_auction_id=".$row['auction_id'];
		$res_archive_bids = mysqli_query($GLOBALS['db_connect'],$sql_archive_bids);
		$row_archive_bids = mysqli_fetch_array($res_archive_bids);
	
		$status=generateInvoice($row_archive_bids['bid_id'], true,$row['auction_id']);
		if($status=='true'){
        $sql_winnerMail="Select u.email,u.firstname,u.lastname,p.poster_title from tbl_poster p,user_table u ,tbl_bid_archive b,tbl_auction a
                        where b.bid_id='".$row_archive_bids['bid_id']."' and b.bid_fk_user_id = u.user_id and a.auction_id=b.bid_fk_auction_id and a.fk_poster_id=p.poster_id";
		
        $res_sql_winnerMail=mysqli_query($GLOBALS['db_connect'],$sql_winnerMail);
        $row=mysqli_fetch_array($res_sql_winnerMail);
        $toMail = $row['email'];
        $toName = $row['firstname'].' '.$row['lastname'];
		$poster_title_sold=$row['poster_title'];
		echo 'Poster-Title-'.$poster_title_sold;
		echo "<br/>";
        $subject = "MPE::Bid won - ".$row['poster_title']." ";
        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;

        $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
        $textContent .= 'Congratulations! You have won the following item:<b> '.$poster_title_sold.'</b><br /><br />';
        $textContent .= 'To view this and all other items that you placed bids on, please login to your account and in <b>User Section</b> select <b>My Closed Items</b>,  located under the <b>My Buying</b> section.<br /><br />';
        $textContent .= '<a href="http://'.HOST_NAME.'/buy.php">Click Here to log in. </a><br /><br />';
        $textContent .= 'You will receive an email when your invoice is ready with payment instructions. Once generated, invoices are also viewable in <b>User Section</b> under <b>My Account/Invoices</b>.<br /><br />';
        $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
        //$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$toName.' <'.$toMail.'>' . "\r\n";
        $headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

        mail('"'.$toName.'" <'.$toMail.'>', $subject, $textContent, $headers);


        $sql_SellerMail="Select u.email,u.firstname,u.lastname,p.poster_title from tbl_poster p,user_table u ,tbl_auction a
                         where a.auction_id= '".$auction_id."'  and a.fk_poster_id=p.poster_id and p.fk_user_id=u.user_id ";
        $res_sql_SellerMail=mysqli_query($GLOBALS['db_connect'],$sql_SellerMail);
        $rowSeller=mysqli_fetch_array($res_sql_SellerMail);
        $toMailSeller = $rowSeller['email'];
        $toNameSeller = $rowSeller['firstname'].' '.$rowSeller['lastname'];
        $subject = "MPE::Poster Sold - ".$rowSeller['poster_title']." ";
        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;

        $textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br /><br />';
        $textContentSeller.= 'Congratulations! Your Poster <b>(Poster Title : '.$poster_title_sold.'</b>) has been sold.To view this as well as any other items you have sold please login to your account and select <b>Sold</b>, located in <b>User Panel</b>, under <b>My Selling</b>.  <br /><br/>';
        //$textContentSeller.= 'Please Ship item promptly so that we may expedite shipment to buyer and payment to you. Ship to:<br /><br/>';
		//$textContentSeller.= 'Movie Poster Exchange<br />';
		//$textContentSeller.= 'POB 123<br />';
		//$textContentSeller.= 'Gibsonville, NC 27249<br /><br/>';
		//$textContentSeller.= 'If MPE is currently holding item then please disregard.<br /><br/>';
		$textContentSeller.= 'Click <a href="http://'.HOST_NAME.'/buy.php"> Here </a> to go to site.<br /><br />';
        $textContentSeller.= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContentSeller= MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM;
        //$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$toNameSeller.' <'.$toMailSeller.'>' . "\r\n";
        $headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

        mail('"'.$toNameSeller.'" <'.$toMailSeller.'>', $subject, $textContentSeller, $headers);

        ########  Admin mail for sold poster #####



        $textContentAdmin.= 'This Poster <b>(Poster Title : '.$poster_title_sold.'</b>) has been sold.<br />';
        $textContentAdmin.= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContentAdmin= MAIL_BODY_TOP.$textContentAdmin.MAIL_BODY_BOTTOM;
        //$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$toNameSeller.' <'.$toMailSeller.'>' . "\r\n";
        $headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

        mail('"'.ADMIN_NAME.'" <'.ADMIN_EMAIL_ADDRESS.'>', $subject, $textContentAdmin, $headers);
     }
	}
	
}


function generateInvoice($id, $is_bid,$auction_id='')
{
	if($is_bid){
		$sql = "SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
				u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
				u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
				u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
				c.country_code AS shipping_country_code,b.bid_fk_auction_id, b.bid_amount AS amount,
				p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,a.auction_id,a.fk_auction_week_id,pi.poster_thumb
				FROM ".USER_TABLE." u, tbl_bid_archive b, ".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a,tbl_poster_images pi
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
?>
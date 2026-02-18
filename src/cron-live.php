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
require_once __DIR__ . "/lib/site_constants.php";
define ("FULL_PATH", SITE_URL);
define ("CLOUD_STATIC","https://d2m46dmzqzklm5.cloudfront.net/images/");
define ("HOST_NAME", SITE_HOST);
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
define ("TBL_BID", "tbl_bid");
define ("COUNTRY_TABLE", "country_table");
define ("TBL_INVOICE", "tbl_invoice");
define ("TBL_INVOICE_TO_AUCTION", "tbl_invoice_to_auction");

$sql = "SELECT ".CONFIG_ADMIN_NAME.", ".CONFIG_ADMIN_EMAIL." FROM ".CONFIG_TABLE."";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
$row = mysqli_fetch_array($res);

define ("ADMIN_NAME", $row[CONFIG_ADMIN_NAME]);
define ("ADMIN_EMAIL_ADDRESS", $row[CONFIG_ADMIN_EMAIL]);

process_offers();
updateBidCronJob();

function process_offers()
{
    $sql = "SELECT * FROM ".TBL_OFFER." ofr WHERE ofr.offer_is_accepted = '0' AND ADDDATE(ofr.post_date, INTERVAL 3 DAY) < now()";
    $rs = mysqli_query($GLOBALS['db_connect'],$sql);
    while($row = mysqli_fetch_array($rs)){
        $sql_update = "UPDATE ".TBL_OFFER." SET offer_is_accepted = '2' WHERE offer_id = '".$row['offer_id']."'";
        if(mysqli_query($GLOBALS['db_connect'],$sql_update)){       
            $sql = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, pos.poster_title, pos.poster_sku
                    FROM ".USER_TABLE." usr, ".TBL_AUCTION." auc, ".TBL_POSTER." pos
                    WHERE usr.user_id = pos.fk_user_id AND pos.poster_id = auc.fk_poster_id
                    AND auc.auction_id = '".$row['offer_fk_auction_id']."'";
            $rs = mysqli_query($GLOBALS['db_connect'],$sql);
            $rowSeller=mysqli_fetch_array($rs);
            if($row['offer_parent_id'] == 0){
                $status = "no_respose_from_seller";
            }else{
                $status = "no_respose_from_buyer";
            }
            sendOfferMailCron($rowSeller,$status);
            if($row['offer_parent_id'] == 0){
                 $sql = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, pos.poster_title, pos.poster_sku
				 		 FROM ".USER_TABLE." usr,".TBL_OFFER." ofr, ".TBL_AUCTION." auc, ".TBL_POSTER." pos
						 WHERE ofr.offer_fk_user_id=usr.user_id
						 AND ofr.offer_fk_auction_id=auc.auction_id
						 AND auc.fk_poster_id=pos.poster_id
						 AND ofr.offer_id=".$row['offer_id'];
				$status = "reject_offer_seller";
            }else{
                 /*$sql="SELECT usr.username, usr.firstname, usr.lastname, usr.email
                        FROM ".USER_TABLE." usr,".TBL_OFFER." ofr where ofr.offer_fk_user_id=usr.user_id and ofr.offer_id=".$row['offer_parent_id'];*/
				$sql = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, pos.poster_title, pos.poster_sku
                        FROM ".USER_TABLE." usr,".TBL_OFFER." ofr, ".TBL_AUCTION." auc, ".TBL_POSTER." pos
						WHERE ofr.offer_fk_user_id=usr.user_id
						AND ofr.offer_fk_auction_id=auc.auction_id
						AND auc.fk_poster_id=pos.poster_id
						AND ofr.offer_id=".$row['offer_parent_id'];
				$status = "reject_offer_buyer";
            }       
            $rs = mysqli_query($GLOBALS['db_connect'],$sql);
            $rowBuyer = mysqli_fetch_array($rs);
            sendOfferMailCron($rowBuyer,$status);
        }
    }
}


function sendOfferMailCron($row, $status)
{
    $toMail = $row['email'];
    $toName = $row['firstname'].' '.$row['lastname'];
    //$subject = "MPE::Offer Accepted - ".$row['poster_title']." (#".$row['poster_sku'].")";
    $fromMail = ADMIN_EMAIL_ADDRESS;
    $fromName = ADMIN_NAME;
    
    $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
    $textContent .= '<b>Poster Title : </b>'.$row['poster_title'].'<br />';
    $textContent .= '<b>Poster Sku : </b>'.$row['poster_sku'].'<br /><br />';
    if($status == "no_respose_from_seller"){ // Mail goes to seller for no response from seller's end
    	$subject = "MPE::Buyer Offer Rejected - ".$row['poster_title']." (#".$row['poster_sku'].")";
        $textContent .= 'Buyer offer is rejected as there is no response from your end in the allotted 72 hrs.<br /><br />';
        $textContent .= 'For more details, please <a href="'.SITE_URL.'">login</a> and go to your User Panel(place mouse over Welcome for dropdown panel) and view under My Selling/My Incoming Offers.<br /><br />';
    }elseif($status == "no_respose_from_buyer"){ // Mail goes to seller for no response from buyer's end
    	$subject = "MPE::Your Offer Rejected - ".$row['poster_title']." (#".$row['poster_sku'].")";
        $textContent .= 'Buyer has not responded to your counter offer within the allotted 72 hours. Counter offer has expired.<br /><br />';
        $textContent .= 'For more details, please <a href="'.SITE_URL.'">login</a> and go to your User Panel(place mouse over Welcome for dropdown panel) and view under My Selling/My Outgoing Counters. <br /><br />';
    }elseif($status == "reject_offer_seller"){ // Mail goes to buyer for no response from seller's end
    	$subject = "MPE::Your Offer Rejected - ".$row['poster_title']." (#".$row['poster_sku'].")";
        //$textContent .= 'Your offer has expired with no response, but we encourage you to submit another offer.<br /><br />';
        $textContent .= 'Seller has not responded to your offer in the allotted 72 hours. Offer has expired.<br /><br />';
        $textContent .= 'For more details, please <a href="'.SITE_URL.'">login</a> and go to your User Panel(place mouse over Welcome for dropdown panel) and view under My Buying/My Outgoing Offers.<br /><br />';
    }elseif($status == "reject_offer_buyer"){ // Mail goes to buyer for no response from buyer's end
    	$subject = "MPE::Seller Offer Rejected - ".$row['poster_title']." (#".$row['poster_sku'].")";
        $textContent .= 'Seller offer is rejected as there is no response from your end in the allotted 72 hrs.<br /><br />';
        $textContent .= 'For more details, please <a href="'.SITE_URL.'">login</a> and go to your User Panel(place mouse over Welcome for dropdown panel) and view under My Buying/My Incoming Counters.<br /><br />';
    }
    
	$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
	$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM; 
	//$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	//$headers .= 'To: '.$toName. "\r\n";
	$headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	
	mail('"'.$toName.'" <'.$toMail.'>', $subject, $textContent, $headers);
}


/**
 * 
 */
function updateBidCronJob(){
	
	$auction_week_id= fetchExpiredAuctions();
	if($auction_week_id>1){
			
			$sql_update_week = "UPDATE tbl_auction_week  SET is_latest= '0' where is_latest= '1' AND is_stills= '0' ";
			$sql_update_res_week=mysqli_query($GLOBALS['db_connect'],$sql_update_week);
	   
			$sql_update_auction_week = "UPDATE tbl_auction_week  SET is_latest= '1',is_closed= '1' WHERE auction_week_id=".$auction_week_id;
	   
			$sql_update_res_auction=mysqli_query($GLOBALS['db_connect'],$sql_update_auction_week);
	  
			mail('dibyendu.dutta.mail@gmail.com', 'My Subject', 'dibyendu'.$auction_week_id);
			$auction_ids=fetchExpiredAuctionDetails($auction_week_id);
			$auctionItems=fetchExpiredAuctionDetailsList($auction_ids);
			for($i=0;$i<count($auctionItems);$i++){
				if($auctionItems[$i]['bid_count'] > 0){
				
					if($auctionItems[$i]['fk_auction_type_id'] == '2' || $auctionItems[$i]['fk_auction_type_id'] == '5'){
					  
					   if( ($auctionItems[$i]['proxy_amount'] > $auctionItems[$i]['max_bid_amount']) &&  ($auctionItems[$i]['highest_user'] != $auctionItems[$i]['fk_user_id']) ){
							$auction_id = $auctionItems[$i]['auction_id'];
							$sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid
											 WHERE is_override = '0' AND fk_auction_id='".$auction_id."' and amount =
											( SELECT MAX(amount) FROM tbl_proxy_bid WHERE  is_override = '0' AND fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid WHERE is_override ='0' AND fk_auction_id='".$auction_id."'))";
							
							$sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
							$second_highest_val=$sql_second_highest_res['amount'];
							$second_highest_user=$sql_second_highest_res['fk_user_id'];
							
							if($second_highest_val > $auctionItems[$i]['max_bid_amount']){
									$next_bid = $second_highest_val + increment_amount($second_highest_val);
									if($next_bid > $auctionItems[$i]['proxy_amount']){
										$next_bid = $auctionItems[$i]['proxy_amount']; 
									}
									if($next_bid > 0){
										$sql_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,bid_is_won,post_date,post_ip) values ('".$auctionItems[$i]['highest_user']."','".$auction_id."','".$second_highest_val."','0','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
										$sql_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_insert);
								
										$sql_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,bid_is_won,post_date,post_ip) values ('".$auctionItems[$i]['fk_user_id']."','".$auction_id."','".$next_bid."','1','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
										$sql_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_insert);
									
										$last_bid_id = mysqli_insert_id($GLOBALS['db_connect']);
									
										$update_sql_latest="Update tbl_auction set highest_user ='".$auctionItems[$i]['fk_user_id']."',max_bid_amount='".$next_bid."',bid_count=bid_count + 2 where auction_id='".$auction_id."'";
										mysqli_query($GLOBALS['db_connect'],$update_sql_latest);
										}
							}else{
									$next_bid = $auctionItems[$i]['max_bid_amount'] + increment_amount($auctionItems[$i]['max_bid_amount']);
									if($next_bid > $auctionItems[$i]['proxy_amount']){
										$next_bid = $auctionItems[$i]['proxy_amount']; 
									}
									if($next_bid > 0){
										$sql_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,bid_is_won,post_date,post_ip) values ('".$auctionItems[$i]['fk_user_id']."','".$auction_id."','".$next_bid."','1','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
										$sql_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_insert);
									
										$last_bid_id = mysqli_insert_id($GLOBALS['db_connect']);
									
										$update_sql_latest="Update tbl_auction set highest_user ='".$auctionItems[$i]['fk_user_id']."',max_bid_amount='".$next_bid."',bid_count=bid_count + 1 where auction_id='".$auction_id."'";
										mysqli_query($GLOBALS['db_connect'],$update_sql_latest);
									}	
								}
							$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
											FROM ".USER_TABLE." usr,".TBL_AUCTION." a,".TBL_POSTER." p
											WHERE usr.user_id='".$auctionItems[$i]['highest_user']."'
											and a.auction_id='".$auction_id."'
											and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);
		
							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;
		
							$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
		
							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;		
		
							// To send HTML mail, the Content-type header must be set
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
							// Additional headers
							//$headers .= 'To: '.$toName.' <'.$toMail.'>' . "\r\n";
							$headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
							//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
							//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		
							mail('"'.$toName.'" <'.$toMail.'>', $subject, $textContent, $headers);	
							processExpiredAuction($auctionItems[$i]['auction_id'], $last_bid_id);	
							
					   }elseif($auctionItems[$i]['max_bid_amount'] > $auctionItems[$i]['bid_amount_from_bid']){
							$sql_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$auctionItems[$i]['fk_user_id']."','".$auctionItems[$i]['auction_id']."','".$auctionItems[$i]['max_bid_amount']."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
							$sql_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_insert);
							$last_bid_id = mysqli_insert_id($GLOBALS['db_connect']);
							
							processExpiredAuction($auctionItems[$i]['auction_id'], $last_bid_id);
					   }			   
					   else{
							processExpiredAuction($auctionItems[$i]['auction_id'], $auctionItems[$i]['last_bid_id']);
						}
							
					}elseif($auctionItems[$i]['fk_auction_type_id'] == '3' && $auctionItems[$i]['auction_reserve_offer_price'] <= $auctionItems[$i]['last_bid_amount']){
						processExpiredAuction($auctionItems[$i]['auction_id'], $auctionItems[$i]['last_bid_id']);
					}           
				}
			}
			sync_auctioc_bid_fun($auction_ids);
	}
}

function fetchExpiredAuctions()
{
	$sql = "SELECT
            tw.fk_auction_week_id
			from tbl_auction_live tw
WHERE (UNIX_TIMESTAMP(tw.auction_actual_end_datetime) - UNIX_TIMESTAMP()) <= 0 LIMIT 1
";
   $auction_week_id = '';
   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
	   while($row = mysqli_fetch_assoc($rs)){
		$auction_week_id=$row['fk_auction_week_id'];
	   }
	  }
	 return $auction_week_id;
}

function fetchExpiredAuctionDetails($auction_week_id){
	$sql= "Select p.*,a.auction_id from tbl_auction_live a , tbl_poster_live p where a.fk_poster_id = p.poster_id AND (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) <= 0 AND a.fk_auction_week_id = " .$auction_week_id;
	$processed_items=array();
	 if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		while($row = mysqli_fetch_assoc($rs)){
			$insert_poster = "Insert into tbl_poster (`fk_user_id`,`poster_title`,`poster_desc`,`poster_sku`,`flat_rolled`,`post_date`,`up_date`,`status`,`post_ip`) values 
			(".$row['fk_user_id'].",'".addslashes($row['poster_title'])."','".addslashes($row['poster_desc'])."','".$row['poster_sku']."','".$row['flat_rolled']."','".$row['post_date']."','".$row['up_date']."','".$row['status']."','".$row['post_ip']."')" ;
			$poster_id_insert = mysqli_query($GLOBALS['db_connect'],$insert_poster);
			$poster_id_new =mysqli_insert_id($GLOBALS['db_connect']);
			if($poster_id_new>1){
				$select_auction = "Select * from tbl_auction_live where fk_poster_id=".$row['poster_id'];
				$rs_auction=mysqli_query($GLOBALS['db_connect'],$select_auction);
				$row_auction=mysqli_fetch_array($rs_auction);
				$insert_auction = "Insert into tbl_auction (`fk_auction_type_id`,`fk_poster_id`,`fk_auction_week_id`,`auction_asked_price`,`auction_actual_start_datetime`,`auction_actual_end_datetime`,`auction_is_approved`,`auction_is_sold`,`post_date`,`up_date`,`post_ip`,`slider_first_position_status`,`is_considered`,`bid_count`,`max_bid_amount`,`highest_user`,`is_set_for_home_big_slider`)
				values( 
				".$row_auction['fk_auction_type_id']." , ".$poster_id_new.",".$row_auction['fk_auction_week_id'].", ".$row_auction['auction_asked_price'].", '".$row_auction['auction_actual_start_datetime']."','".$row_auction['auction_actual_end_datetime']."','".$row_auction['auction_is_approved']."','".$row_auction['auction_is_sold']."', '".$row_auction['post_date']."','".$row_auction['up_date']."','".$row_auction['post_ip']."', ".$row_auction['slider_first_position_status'].",".$row_auction['is_considered'].",".$row_auction['bid_count'].",".$row_auction['max_bid_amount'].",".$row_auction['highest_user'].",".$row_auction['is_set_for_home_big_slider']." ) "   ;
				$auction_id_new_res=mysqli_query($GLOBALS['db_connect'],$insert_auction);
				$auction_id_new= mysqli_insert_id($GLOBALS['db_connect']);
				array_push($processed_items,$auction_id_new);
				if($auction_id_new>1){
				    ###################  tbl_proxy_bid_live to tbl_proxy_bid  ##########################################
					$select_proxy ="Select * from tbl_proxy_bid_live where fk_auction_id=".$row['auction_id'];
					if($rs_proxy = mysqli_query($GLOBALS['db_connect'],$select_proxy)){
						while($row_proxy = mysqli_fetch_array($rs_proxy)){
							$sql_proxy = " Insert into tbl_proxy_bid (`fk_user_id`,`fk_auction_id`,`amount`,`proxy_date`,`is_override`) value (".$row_proxy['fk_user_id'].",".$auction_id_new.",".$row_proxy['amount'].",'".$row_proxy['proxy_date']."','".$row_proxy['is_override']."') ";				 
							if(mysqli_query($GLOBALS['db_connect'],$sql_proxy)){
								$del_proxy="Delete from tbl_proxy_bid_live where proxy_id=".$row_proxy['proxy_id'];
								mysqli_query($GLOBALS['db_connect'],$del_proxy);
							 }
						}
					}
					###################  tbl_bid to tbl_bid  ##########################################
					$update_bid = " Update tbl_bid set bid_fk_auction_id=".$auction_id_new." WHERE bid_fk_auction_id = ".$row['auction_id'];
					mysqli_query($GLOBALS['db_connect'],$update_bid);	
					
					
					################# tbl_poster_images_live to tbl_poster_images ######################################
					$select_images ="Select poster_image,poster_image_id from tbl_poster_images_live where fk_poster_id=".$row['poster_id'];
					if($rs_images = mysqli_query($GLOBALS['db_connect'],$select_images)){
						while($row_images = mysqli_fetch_assoc($rs_images)){
							$sql_update = " UPDATE tbl_poster_images set fk_poster_id= ".$poster_id_new." WHERE poster_image='".$row_images['poster_image']."' ";
							if(mysqli_query($GLOBALS['db_connect'],$sql_update)){
								$del_images="Delete from tbl_poster_images_live where poster_image_id=".$row_images['poster_image_id'];
								mysqli_query($GLOBALS['db_connect'],$del_images);
							}
						}
					}
					################ tbl_poster_to_category_live to tbl_poster_to_category ############################
					$select_cat ="Select * from tbl_poster_to_category_live where fk_poster_id=".$row['poster_id'];
					if($rs_cat = mysqli_query($GLOBALS['db_connect'],$select_cat)){
						while($row_cat = mysqli_fetch_assoc($rs_cat)){
							$sql_cat_images = " Insert into tbl_poster_to_category (`fk_poster_id`,`fk_cat_id`) value (".$poster_id_new.",".$row_cat['fk_cat_id'].") ";
							if(mysqli_query($GLOBALS['db_connect'],$sql_cat_images)){
								$del_cat="Delete from tbl_poster_to_category_live where fk_poster_id=".$row['poster_id']." AND fk_cat_id=".$row_cat['fk_cat_id'];
								mysqli_query($GLOBALS['db_connect'],$del_cat);
							}
						}
					}
									
					$sql_auction_mapping = " Insert into tbl_auction_mapping (`auction_id_old`,`auction_id_new`) value (".$row_auction['auction_id'].",".$auction_id_new.") ";
					mysqli_query($GLOBALS['db_connect'],$sql_auction_mapping);
					
					$del_auction="Delete from tbl_auction_live where auction_id=".$row_auction['auction_id'];
					mysqli_query($GLOBALS['db_connect'],$del_auction);
				}
				$del_poster="Delete from tbl_poster_live where poster_id=".$row['poster_id'];
				mysqli_query($GLOBALS['db_connect'],$del_poster);			
				
			}
			
		}
	 }
	 return $processed_items;
}

function fetchExpiredAuctionDetailsList($auction_ids)
{
	$ids = join(",",$auction_ids);
	$sql = "SELECT
            a.auction_id,
            a.fk_auction_type_id,
			a.fk_auction_week_id,
            tb.bid_id  AS last_bid_id,
			MAX(tb.bid_amount) AS bid_amount_from_bid,
            a.bid_count,
			a.highest_user,
			a.max_bid_amount,
			p.fk_user_id,
			a.fk_poster_id,
			max(p.amount) as proxy_amount
			FROM tbl_auction a
			LEFT JOIN tbl_proxy_bid p
                  ON a.auction_id = p.fk_auction_id	
			and p.is_override ='0'	  
			and p.amount =
							( SELECT MAX(amount) FROM tbl_proxy_bid WHERE is_override ='0' AND  fk_auction_id=a.auction_id group by fk_auction_id )
            LEFT JOIN tbl_bid tb
                  ON a.auction_id = tb.bid_fk_auction_id				
                AND CASE WHEN countMax(a.auction_id) = 1 THEN tb.bid_amount = (SELECT
                                                                       MAX(ntb.bid_amount)
                                                                     FROM tbl_bid ntb
                                                                     WHERE ntb.bid_fk_auction_id = a.auction_id
                                                                     GROUP BY ntb.bid_fk_auction_id)WHEN countMax(a.auction_id) > 1 THEN tb.bid_amount = (SELECT
                                                                                                                                                            MAX(ntb.bid_amount)
                                                                                                                                                          FROM tbl_bid ntb
                                                                                                                                                          WHERE ntb.bid_fk_auction_id = a.auction_id
                                                                                                                                                          GROUP BY ntb.bid_fk_auction_id)
      AND tb.is_proxy = '1' END
	  WHERE a.auction_id IN (".$ids.")
	  GROUP BY a.auction_id ";
   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
   	$auction_stills_id = '';
   	$auction_week_id = '';
	   while($row = mysqli_fetch_assoc($rs)){
		//   if($row['is_stills']=='1'){
		//   	$is_stills = $row['is_stills'];
		// 	$auction_stills_id=$row['fk_auction_week_id'];
		//   }elseif($row['is_stills']=='0'){
		//   	$is_weekly = $row['is_stills'];
		// 	$auction_week_id=$row['fk_auction_week_id'];
		//   }
		   $dataArr[] = $row;
           if($row['bid_count'] > 0){
               $sql_update = "UPDATE ".TBL_AUCTION." a SET a.auction_is_sold='1'
                        WHERE a.auction_id='".$row['auction_id']."'
                        ";
               $sql_update_res=mysqli_query($GLOBALS['db_connect'],$sql_update);
           }
		   // Logic  to move unsold to Fixed
		   else{
			      
                //"auction_reserve_offer_price" => $offer_price,
                //"is_offer_price_percentage" => $is_percentage,
                  
			    $sql_insert_unsold_fixed="Insert into `tbl_auction` (`fk_poster_id`,
													 `auction_asked_price`,
													 `fk_auction_type_id`,
							 						 `auction_is_approved`,
							 						 `auction_is_sold`,
							 						 `post_date`,
													 `up_date`,
													 `status`,
													 `post_ip`,
													 `reopen_auction_id`,
													 `is_reopened`) values
							 						 (
													  '".$row['fk_poster_id']."',							 						  
							 						  '10',
							 						  '1',
													  '0',
													  '0',
							 						  '".date("Y-m-d H:i:s")."',
							 						  '".date("Y-m-d H:i:s")."',
													  '1',
													  '".$_SERVER["REMOTE_ADDR"]."',
													  '".$row['auction_id']."',
													  '1'													  
							 						 )";
				//echo($sql_insert_unsold_fixed);
			    mysqli_query($GLOBALS['db_connect'],$sql_insert_unsold_fixed);
		   }
	   }
	 
	  if($is_stills==1 && $auction_stills_id!=''){
			$sql_update_week = "UPDATE tbl_auction_week  SET is_latest= '0' where is_latest= '1' AND is_stills= '1' ";
			$sql_update_res_week=mysqli_query($GLOBALS['db_connect'],$sql_update_week);
	   
			$sql_update_auction_week = "UPDATE tbl_auction_week  SET is_latest= '1',is_closed= '1' WHERE auction_week_id=".$auction_stills_id;		   
			$sql_update_res_auction=mysqli_query($GLOBALS['db_connect'],$sql_update_auction_week);
	  } 
	   return $dataArr;
   }
   return false;
}


function processExpiredAuction($auction_id, $bid_id)
{
    $sql = "UPDATE ".TBL_BID." b SET  b.bid_is_won='1'
                    WHERE b.bid_id='".$bid_id."'";
	if(mysqli_query($GLOBALS['db_connect'],$sql)){
        $status=generateInvoice($bid_id, true,$auction_id);
	}
     if($status=='true'){
        $sql_winnerMail="Select u.email,u.firstname,u.lastname,p.poster_title from tbl_poster p,user_table u ,tbl_bid b,tbl_auction a
                        where b.bid_id='".$bid_id."' and b.bid_fk_user_id = u.user_id and a.auction_id=b.bid_fk_auction_id and a.fk_poster_id=p.poster_id";
        $res_sql_winnerMail=mysqli_query($GLOBALS['db_connect'],$sql_winnerMail);
        $row=mysqli_fetch_array($res_sql_winnerMail);
        $toMail = $row['email'];
        $toName = $row['firstname'].' '.$row['lastname'];
        $subject = "MPE::Bid won - ".$row['poster_title']." ";
        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;

        $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
        $textContent .= 'Congratulations! You have won the following item:<b> '.$row['poster_title'].'</b><br /><br />';
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
        $textContentSeller.= 'Congratulations! Your Poster <b>(Poster Title : '.$row['poster_title'].'</b>) has been sold.To view this as well as any other items you have sold please login to your account and select <b>Sold</b>, located in <b>User Panel</b>, under <b>My Selling</b>.  <br /><br/>';
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



        $textContentAdmin.= 'This Poster <b>(Poster Title : '.$row['poster_title'].'</b>) has been sold.<br />';
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
function increment_amount($buy_now){
 	if($buy_now < 10){
 		return 1;
 	}elseif(10 <= $buy_now && $buy_now <= 29){
 		return 2;
 	}elseif(30 <= $buy_now && $buy_now <= 49){
 		return 3;
 	}elseif(50 <= $buy_now && $buy_now <= 99){
 		return 5;
 	}elseif(100 <= $buy_now && $buy_now <= 199){
 		return 10;
 	}elseif(200 <= $buy_now && $buy_now <= 299){
 		return 20;
 	}elseif(300 <= $buy_now && $buy_now <= 499){
 		return 25;
 	}elseif(500 <= $buy_now && $buy_now <= 999){
 		return 50;
 	}elseif(1000 <= $buy_now && $buy_now <= 1999){
 		return 100;
 	}elseif(2000 <= $buy_now && $buy_now <= 2999){
 		return 200;
 	}elseif(3000 <= $buy_now && $buy_now <= 4999){
 		return 250;
 	}elseif(5000 <= $buy_now && $buy_now <= 9999){
 		return 500;
 	}elseif(10000 <= $buy_now && $buy_now <= 19999){
 		return 1000;
 	}elseif(20000 <= $buy_now && $buy_now <= 29999){
 		return 2000;
 	}elseif(30000 <= $buy_now && $buy_now <= 49999){
 		return 2500;
 	}elseif(50000 <= $buy_now && $buy_now <= 99999){
 		return 5000;
 	}elseif(100000 <= $buy_now && $buy_now <= 199999){
 		return 10000;
 	}elseif(200000 <= $buy_now && $buy_now <= 299999){
 		return 20000;
 	}elseif(300000 <= $buy_now && $buy_now <= 499999){
 		return 25000;
 	}elseif(500000 <= $buy_now && $buy_now <= 999999){
 		return 50000;
 	}elseif(1000000 <= $buy_now && $buy_now <= 1999999){
 		return 100000;
 	}elseif(2000000 <= $buy_now && $buy_now <= 2999999){
 		return 200000;
 	}elseif(3000000 <= $buy_now && $buy_now <= 4999999){
 		return 250000;
 	}elseif(5000000 <= $buy_now && $buy_now <= 9999999){
 		return 500000;
 	}elseif($buy_now >= 10000000){
 		return 1000000;
 	}
 }
//processExpiredAuction('2','2')
function sync_auctioc_bid_fun($auction_ids){
	$ids = join(",",$auction_ids);
	$sql = "Select * from tbl_bid b where b.bid_fk_auction_id  IN (".$ids.")";
	echo $sql;
	$rs= mysqli_query($GLOBALS['db_connect'],$sql);
	while($row=mysqli_fetch_array($rs)){
		
		$sql_insert = "Insert into tbl_bid_archive (`bid_fk_user_id`,`bid_fk_auction_id`,`bid_amount`,`is_proxy`,`bid_is_won`,`post_date`,`post_ip`,`is_snipe`) values 
						(".$row['bid_fk_user_id'].",".$row['bid_fk_auction_id'].",".$row['bid_amount'].",'".$row['is_proxy']."','".$row['bid_is_won']."','".$row['post_date']."','".$row['post_ip']."','".$row['is_snipe']."' )" ;
		
		echo $sql_insert;
		mysqli_query($GLOBALS['db_connect'],$sql_insert);
		
		$sql_del = "Delete from tbl_bid where bid_id=".$row['bid_id'];
		mysqli_query($GLOBALS['db_connect'],$sql_del);
	

	}
	sync_auction_bids($auction_ids);
}
function sync_auction_bids($auction_ids){
	$ids = join(",",$auction_ids);
	$sql = " SELECT a.auction_id,a.fk_poster_id,a.max_bid_amount,p.poster_title,a.highest_user FROM tbl_auction a,tbl_poster p WHERE a.auction_id IN (".$ids.") AND a.auction_is_sold='1' AND 
a.fk_poster_id=p.poster_id ";
	echo $sql;
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
			$sql_archive_bids = "SELECT u.firstname,u.lastname,b.bid_id from tbl_bid_archive b,user_table u where b.bid_is_won='1' AND b.bid_fk_user_id=u.user_id AND b.bid_fk_auction_id=".$row['auction_id'];
			$res_archive_bids = mysqli_query($GLOBALS['db_connect'],$sql_archive_bids);
			$row_archive_bids = mysqli_fetch_array($res_archive_bids);
			
			$sql_archive_bid_id = "SELECT b.bid_id from tbl_bid_archive b where b.bid_fk_auction_id=".$row['auction_id']." and bid_fk_user_id =".$row['highest_user']." and bid_amount=".$row['max_bid_amount'];
			$res_archive_bid_id = mysqli_query($GLOBALS['db_connect'],$sql_archive_bid_id);
			$row_archive_bid_id = mysqli_fetch_array($res_archive_bid_id);
			
			if($row_archive_bids['firstname']=='' and $row_archive_bids['lastname']==''){
				mysqli_query($GLOBALS['db_connect'],"update tbl_bid_archive set bid_is_won='1' where bid_id = ".$row_archive_bid_id['bid_id']);
			}else{
				// mysqli_query($GLOBALS['db_connect'],"update tbl_bid_archive set bid_is_won='1' where bid_id = ".$row_archive_bid_id['bid_id']);
			}
		}

	}
	set_default_images($res,$auction_ids);
 }
 
 function set_default_images($res,$auction_ids){
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
				echo "Multiple-".$row['fk_poster_id'];
				echo "<br/>";

			}	
			
		}
		
	}
 }

?>

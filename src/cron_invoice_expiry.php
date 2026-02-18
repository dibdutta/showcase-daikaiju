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

ini_set("display_errors","on");
require_once __DIR__ . "/lib/site_constants.php";
define ("FULL_PATH", SITE_URL);
define ("CLOUD_STATIC","http://c4808190.r90.cf2.rackcdn.com/");
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
			<a href="'.FULL_PATH.'/index.php" target="_blank"><img src="'.CLOUD_STATIC.'logo.png" alt="logo" width="278" height="84" border="0"></a>
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


	define ("DB_SERVER", getenv('DB_SERVER') ?: "mysql");
	define ("DB_NAME", getenv('DB_NAME') ?: "mpe");
	define ("DB_USER", getenv('DB_USER') ?: "root");
	define ("DB_PASSWORD", getenv('DB_PASSWORD') ?: "root");


$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");
date_default_timezone_set('America/Los_Angeles');


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

checkExpiredInvoice();

function checkExpiredInvoice(){
    $UserArr= array();
    $posterArr = array();
    $sql=" SELECT i.invoice_id,p.poster_title,i.fk_user_id,tia.fk_auction_id,a.fk_auction_type_id,a.auction_is_sold
                 FROM tbl_invoice AS i,tbl_invoice_to_auction AS tia,tbl_auction AS a , tbl_poster AS p
                      WHERE i.is_paid='0'
                            AND (UNIX_TIMESTAMP(tia.expiry_date) - UNIX_TIMESTAMP()) <= 0
                            AND tia.fk_invoice_id = i.invoice_id
                            AND a.auction_id=tia.fk_auction_id
                            AND p.poster_id = a.fk_poster_id ";

    $executeSql=mysqli_query($GLOBALS['db_connect'],$sql);
    while($row=mysqli_fetch_array($executeSql)){
        if($row['fk_auction_type_id']=='1' && $row['auction_is_sold']=='3'){
            removeExpiredPosters($row['invoice_id'],$row['fk_auction_id']);
            array_push($UserArr,$row['fk_user_id']);
            array_push($posterArr,$row['poster_title']);
        }
    }

    //$result=array_unique($UserArr);
    $i=0;
    foreach($UserArr as $key=>$val){
        /******************************** Email Start ******************************/
        $sql = "SELECT u.username, u.firstname, u.lastname, u.email
				FROM ".USER_TABLE." u
				WHERE u.user_id = '".$val."'";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);


        $toMail = $row['email'];
        $toName = $row['firstname']." ".$row['lastname'];

        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;

        $subject = "Poster Title: ".$posterArr[$i]." has been removed from your invoice.";
        $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
        $textContent .= "Item: <b>".$posterArr[$i]."</b> has been removed from your invoice section,as payment has not occurred in the allotted 72 hours. Item has returned to selling state.<br /><br/>";
        
        $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$toNameSeller.' <'.$toMailSeller.'>' . "\r\n";
        $headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
        //$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

        mail('"'.$toName.'" <'.$toMail.'>', $subject, $textContent, $headers);
        $i++;
    }
}
 function removeExpiredPosters($invoice_id,$auction_id){
		// To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        //$headers .= 'To: '.$toNameSeller.' <'.$toMailSeller.'>' . "\r\n";
        $headers .= 'From: '.ADMIN_NAME.' <'.ADMIN_EMAIL_ADDRESS.'>' . "\r\n";
  
		$sqlForBuyer ="SELECT usr.firstname, usr.lastname, usr.email , p.poster_title
					FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." AS p
					WHERE ofr.offer_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id
					AND ofr.offer_fk_user_id = usr.user_id
					AND ofr.offer_is_accepted = '2'
					AND ofr.offer_fk_auction_id =  '".$auction_id."' GROUP BY usr.user_id ";

            $rsBuyer = mysqli_query($GLOBALS['db_connect'],$sqlForBuyer);
            while($rowBuyer = mysqli_fetch_array($rsBuyer)){
                $toMailBuyer=$rowBuyer['email'];
                $toNameBuyer=$rowBuyer['firstname']." ".$rowBuyer['lastname'];
                $textContentBuyer='';
                $subjectBuyer = "MPE::Poster Relisted - ".$rowBuyer['poster_title']." ";
				$textContentBuyer = 'Dear '.$rowBuyer['firstname'].' '.$rowBuyer['lastname'].',<br><br>';
                $textContentBuyer .= $rowBuyer['poster_title'].' has been relisted again.<br /><br />';
                $textContentBuyer .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
                $textContentBuyer .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
                $textContentBuyer = MAIL_BODY_TOP.$textContentBuyer.MAIL_BODY_BOTTOM;
                
				mail('"'.$toNameBuyer.'" <'.$toMailBuyer.'>', $subjectBuyer, $textContentBuyer, $headers);
            }
			$sqlDeleteOffer="Delete from tbl_offer where offer_fk_auction_id = '".$auction_id."' ";
            mysqli_query($GLOBALS['db_connect'],$sqlDeleteOffer);
       $del=0;
       $sql="select i.auction_details,i.total_amount,tia.amount from tbl_invoice i,tbl_invoice_to_auction tia
                        where i.invoice_id = '".$invoice_id."' AND
                              tia.fk_invoice_id = i.invoice_id AND
                              tia.fk_auction_id= '".$auction_id."' ";
        $auction=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql));

         $auction['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $auction['auction_details']);
         $auction_details=unserialize($auction['auction_details']);

         $total_amnt=$auction['total_amount'];
         $newTotalAmount = $auction['total_amount']- $auction['amount'];
         if($newTotalAmount==0){
             $del=1;
         }
         $i=0;
         foreach($auction_details as $key => $value) {
             if($auction_details[$i]['auction_id']==$auction_id) {
                 unset($auction_details[$i]);
             }
             $i++;
         }

         $arrAuctionDetails = array();
         foreach($auction_details as $key => $value) {
             $arrAuctionDetails[] = $value;
         }

        $auctionDetailsNew=serialize($arrAuctionDetails);
        if($del=='1'){
            $deleteInvoice= "Delete from tbl_invoice where invoice_id='".$invoice_id."'  ";
            mysqli_query($GLOBALS['db_connect'],$deleteInvoice);
        }else{
            $update="Update tbl_invoice set auction_details='".$auctionDetailsNew."',total_amount='".$newTotalAmount."' where invoice_id= '".$invoice_id."' ";
            mysqli_query($GLOBALS['db_connect'],$update);
        }

         $delete= "Delete from tbl_invoice_to_auction where fk_invoice_id='".$invoice_id."' AND fk_auction_id = '".$auction_id."' ";
         mysqli_query($GLOBALS['db_connect'],$delete);

         $updateAuction= "Update tbl_auction set auction_is_sold= '0' where auction_id = '".$auction_id."' ";
         mysqli_query($GLOBALS['db_connect'],$updateAuction);
 }
 //mail('dibyendu.dutta.mail@gmail.com', 'My Subject', 'hello');
?>

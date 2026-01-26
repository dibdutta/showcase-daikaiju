<?php

/**********************************************************
DoExpressCheckoutPayment.php

This functionality is called to complete the payment with
PayPal and display the result to the buyer.

The code constructs and sends the DoExpressCheckoutPayment
request string to the PayPal server.

Called by GetExpressCheckoutDetails.php.

Calls CallerService.php and APIError.php.

**********************************************************/

require_once 'CallerService.php';

session_start();
	define ("INCLUDE_PATH", "../../");
   	require_once INCLUDE_PATH."lib/inc.php";
   	require_once INCLUDE_PATH."lib/common.php";
   	$invoiceObj = new Invoice();
   	$errCounter = 0;
 	$auctionObj = new Auction();
	 foreach($_SESSION['cart'] as $key => $value){
	  $counter = $auctionObj->countData(TBL_AUCTION, array('auction_id' => $value['auction_id'], 'is_paying' => 1));
	  if($counter > 0){
	   $errCounter++;
	   
	   break;
	  }
	 }
	 if($errCounter > 0){
	  $_SESSION['Err'] = "Please try after sometime.";	
	  header("location:".SITE_URL."cart.php?mode=do_express_checkout");
	  exit;
	 }
   	foreach($_SESSION['cart'] as $key => $value){
		$invoiceObj->updateData(TBL_AUCTION, array('is_paying' => 1), array('auction_id' => $value['auction_id']), true);
	} 

ini_set('session.bug_compat_42',0);
ini_set('session.bug_compat_warn',0);

/* Gather the information to make the final call to
   finalize the PayPal payment.  The variable nvpstr
   holds the name value pairs
   */


$token =urlencode( $_SESSION['token']);
$paymentAmount =urlencode ($_SESSION['TotalAmount']);
$paymentType = urlencode($_SESSION['paymentType']);
$currCodeType = urlencode($_SESSION['currCodeType']);
$payerID = urlencode($_SESSION['payer_id']);
$serverName = urlencode($_SERVER['SERVER_NAME']);


 $nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;



 /* Make the call to PayPal to finalize payment
    If an error occured, show the resulting errors
    */
 
$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
 $ack = strtoupper($resArray["ACK"]);


if($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'){
	$_SESSION['reshash']=$resArray;
	//$location = "APIError.php";
	//header("Location: $location");
	$_SESSION['Err'] = "Payment failed. Please try again!"."<br/>"." Paypal Error Code:". $resArray['L_ERRORCODE0']."&nbsp;".$resArray['L_LONGMESSAGE0'];
	foreach($_SESSION['cart'] as $key => $value){
		$invoiceObj->updateData(TBL_AUCTION, array('is_paying' => 0), array('auction_id' => $value['auction_id']), true);
	} 
	header("location:".SITE_URL."cart.php?mode=do_express_checkout");
	exit;
}else{
	$invoice_id = $invoiceObj->processInstantPaymentInvoice($_SESSION['sessUserID'], $_SESSION['cart'], $_SESSION['billing_info'], $_SESSION['shipping_info']);
	//$invoice_id = 123;
	
	foreach($_SESSION['cart'] as $key => $value){
		    $sql_SellerMail="Select u.email,u.firstname,u.lastname,p.poster_title from tbl_poster p,user_table u ,tbl_auction a
		       where a.auction_id= '".$value['auction_id']."'  and a.fk_poster_id=p.poster_id and p.fk_user_id=u.user_id ";
		    $res_sql_SellerMail=mysqli_query($GLOBALS['db_connect'],$sql_SellerMail);
		    $rowSeller=mysqli_fetch_array($res_sql_SellerMail);
		    $toMailSeller = $rowSeller['email'];
		       $toNameSeller = $rowSeller['firstname'].' '.$row['lastname'];
		       $subject = "MPE::Poster Sold - ".$rowSeller['poster_title']." ";
		       $fromMail = ADMIN_EMAIL_ADDRESS;
		       $fromName = ADMIN_NAME;
		       
		       $textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br /><br />';
		       $textContentSeller.= 'Congratulations!Your Poster <b>(Poster Title : '.$rowSeller['poster_title'].'</b>) has been sold.<br />';
		       $textContentSeller .= 'For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />';
		       $textContentSeller.= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
		    $textContentSeller= MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM; 
		    $check = sendMail($toMailSeller, $toNameSeller, $subject, $textContentSeller, $fromMail, $fromName, $html=1);
		   $invoiceObj->updateData(TBL_CART_HISTORY, array('is_paid' => '1'), array('fk_auction_id' => $value['auction_id']), true);
		   $invoiceObj->updateData(TBL_OFFER, array('offer_is_accepted' => '2'), array('offer_fk_auction_id' => $value['auction_id']), true);
		  }
	foreach($_SESSION['cart'] as $key => $value){
		$invoiceObj->updateData(TBL_AUCTION, array('is_paying' => 0), array('auction_id' => $value['auction_id']), true);
	}  
	unset($_SESSION['cart']);
	unset($_SESSION['billing_info']);
	unset($_SESSION['shipping_info']);
	$_SESSION['Err'] = "Payment is done successfully!";
	header("location:".SITE_URL."my_invoice.php?invoice_id=".$invoice_id);
	exit;
}

?>


<html>
<head>
    <title>PayPal PHP SDK - DoExpressCheckoutPayment API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
		<br>
		<center>
		<font size=2 color=black face=Verdana><b>DoExpressCheckoutPage</b></font>
		<br><br>

		<b>Order Processed! Thank you for your payment!</b><br><br>


    <table width =400>
                                        
         <?php 
   		 	require_once 'ShowAllResponse.php';
    	 ?>
    </table>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>
</html>
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
	 
	 
   	
ini_set('session.bug_compat_42',0); 
ini_set('session.bug_compat_warn',0);

/* Gather the information to make the final call to
   finalize the PayPal payment.  The variable nvpstr
   holds the name value pairs
   */


$token =urlencode( $_SESSION['invoice_'.$_SESSION['invoice_id']]['token']);
$paymentAmount =urlencode ($_SESSION['invoice_'.$_SESSION['invoice_id']]['TotalAmount']);
$paymentType = urlencode($_SESSION['invoice_'.$_SESSION['invoice_id']]['paymentType']);
$currCodeType = urlencode($_SESSION['invoice_'.$_SESSION['invoice_id']]['currCodeType']);
$payerID = urlencode($_SESSION['invoice_'.$_SESSION['invoice_id']]['payer_id']);
$serverName = urlencode($_SERVER['SERVER_NAME']);


 $nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE=USD&IPADDRESS='.$serverName ;



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
	
	header("location:".SITE_URL."my_invoice?mode=do_express_checkout&invoice_id=".$_SESSION['invoice_id']);
	exit;
}else{
		$invoiceObj = new Invoice();
		
		$row = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_SESSION['invoice_id']));
		
		$billing_address = serialize(array('billing_firstname' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_firstname'],
										   'billing_lastname' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_lastname'],
										   'billing_country_id' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_country_id'],
										   'billing_country_name' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_country_name'],
										   'billing_country_code' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_country_code'],
										   'billing_city' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_city'],
										   'billing_state' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_state'],
										   'billing_address1' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_address1'],
										   'billing_address2' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_address2'],
										   'billing_zipcode' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['billing_info']['billing_zipcode']));
		
		$shipping_address = serialize(array('shipping_firstname' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_firstname'],
											'shipping_lastname' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_lastname'],
											'shipping_country_id' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_country_id'],
											'shipping_country_name' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_country_name'],
											'shipping_country_code' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_country_code'],
											'shipping_city' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_city'],
											'shipping_state' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_state'],
											'shipping_address1' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_address1'],
											'shipping_address2' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_address2'],
											'shipping_zipcode' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_zipcode']));
		
		$row[0]['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row[0]['additional_charges'] );
		$additional_charges_arr = unserialize($row[0]['additional_charges']);
		
		$shipping_desc = strtoupper($_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_methods'])." - ".
						 $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_desc'];
		
		$additional_charges_arr[] = array('description' => 'Shipping Charge ('.$shipping_desc.')',
										  'amount' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_charge']);
										  
		if($_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['sale_tax_amount'] > 0){
			$additional_charges_arr[] = array('description' => 'Sales Tax', 'amount' => $_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['sale_tax_amount']);						
		}
		
		$additional_charges = serialize($additional_charges_arr);
		
		$total_amount = $row[0]['total_amount'] + 
						$_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['shipping_charge'] + 
						$_SESSION['invoice_'.$_SESSION['invoice_id']]['shipping_info']['sale_tax_amount']; 
		
		$data = array('billing_address' => $billing_address, 'shipping_address' => $shipping_address, 'additional_charges' => mysqli_real_escape_string($GLOBALS['db_connect'],$additional_charges),
					  'total_amount' => $total_amount, 'is_paid' => 1, 'paid_on' => date("Y-m-d H:i:s"));

		$invoiceObj->updateData(TBL_INVOICE, $data, array('invoice_id' => $_SESSION['invoice_id']), true);
		
		$data = $invoiceObj->selectData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id'), array('fk_invoice_id' => $_SESSION['invoice_id']));
		for($i=0;$i<count($data);$i++){
			$invoiceObj->updateData(TBL_AUCTION, array('auction_payment_is_done' => 1), array('auction_id' => $data[$i]['fk_auction_id']), true);

			$auctionData = $invoiceObj->selectData(TBL_AUCTION, array('auction_is_sold'), array('auction_id' => $data[$i]['fk_auction_id']));
			if($auctionData[0]['auction_is_sold']=='3'){
				$invoiceObj->updateData(TBL_AUCTION, array('auction_is_sold' => 2), array('auction_id' => $data[$i]['fk_auction_id']), true);
			}
		}
		
		$invoiceObj->generateSellerInvoice($_SESSION['invoice_id']);
		$invoiceObj->mailInvoice($_SESSION['invoice_id'],'invoice');

		unset($_SESSION['invoice_'.$_SESSION['invoice_id']]);
		unset($_SESSION['invoice_id']);
		$_SESSION['Err']="Payment is done successfully.";
		header("location: ".SITE_URL."my_invoice");
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
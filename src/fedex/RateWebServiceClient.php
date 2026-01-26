<?php
define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 9.0.0

$totalPoster=$_REQUEST['totalPoster'];
$zip_code=$_REQUEST['zip_code'];
$city=$_REQUEST['city'];
$address1=$_REQUEST['address1'];
$sql=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select country_code from country_table where country_id=".$_REQUEST['country_id']));
$res=$sql['country_code'];
require_once('fedex-common.php');
//print_r($_SERVER);
$newline = "<br />";
//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "RateService_v9.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");
 
$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array('UserCredential' =>
                                      array('Key' => 'moB7y4CgOwnaVI2O', 'Password' => 'MOxKdYAv7arPd1K6aJXlrXUf9')); 
$request['ClientDetail'] = array('AccountNumber' => '510087321', 'MeterNumber' => '100062376');
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***');
$request['Version'] = array('ServiceId' => 'crs', 'Major' => '9', 'Intermediate' => '0', 'Minor' => '0');
$request['ReturnTransitAndCommit'] = true;
$request['RequestedShipment']['DropoffType'] = 'BUSINESS_SERVICE_CENTER'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
$request['RequestedShipment']['ShipTimestamp'] = date('c');
$request['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_ECONOMY'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
$request['RequestedShipment']['TotalInsuredValue']=array('Ammount'=>100,'Currency'=>'USD');
$request['RequestedShipment']['Shipper'] = array(
		'Address' => array(
			'StreetLines' => '221 E MAIN ST',
            'City' => 'GIBSONVILLE',
            'StateOrProvinceCode' => 'NC',
            'PostalCode' => '27249',
            'CountryCode' => 'US',
            'Residential' => false)
		);
$request['RequestedShipment']['Recipient'] = array(
		'Address' => array(
			'StreetLines' => $address1,
            'City' => $city,
            'PostalCode' => $zip_code,
            'CountryCode' => $res,
            'Residential' => false)
		);
		//print_r($request['RequestedShipment']['Recipient']);
$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER');
//$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER',
//                                                        'Payor' => array('AccountNumber' => '510087321',
//                                                                     'CountryCode' => 'US'));
$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
$request['RequestedShipment']['RateRequestTypes'] = 'LIST';
$request['RequestedShipment']['PackageCount'] = $totalPoster;
$request['RequestedShipment']['PackageDetail'] = 'INDIVIDUAL_PACKAGES';  //  Or PACKAGE_SUMMARY
/*$request['RequestedShipment']['RequestedPackageLineItems'] = array('0' => array('Weight' => array('Value' => 2, 'Units' => 'LB'),
                                                                                'Dimensions' => array('Length' => 24, 'Width' => 16, 'Height' => 1, 'Units' => 'IN'
																			)
																		)	
                                                                   );*/                                                                  
//echo "<pre>";print_r($request['RequestedShipment']['RequestedPackageLineItems']);

$weights = explode(',',$_REQUEST['weights']);
$i=0;                                                             
foreach($weights as $key => $value){
	$sql_fetch_shipping_details=" Select * from tbl_size_weight_cost_master
									 where size_weight_cost_id = ".$weights[$i];
	$sql_fetch_shipping_details_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_fetch_shipping_details));
	$length =$sql_fetch_shipping_details_res['length'];
	$width = $sql_fetch_shipping_details_res['width'];
	$height = $sql_fetch_shipping_details_res['height'];
	$weight_lb=$sql_fetch_shipping_details_res['weight_lb'];
	$weight_oz=$sql_fetch_shipping_details_res['weight_oz'];
	$weight_oz_in_lb=($weight_oz * 0.0625);
	$weight_lb_total= ($weight_lb + $weight_oz_in_lb);						 
	$packageItems[] = array('Weight' => array('Value' => $weight_lb_total, 'Units' => 'LB' ),
							'Dimensions' => array('Length' => $length, 'Width' => $width, 'Height' => $height, 'Units' => 'IN'));

$i++;
}
$request['RequestedShipment']['RequestedPackageLineItems']=$packageItems;

try 
{
	if(setEndpoint('changeEndpoint'))
	{
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	$response = $client ->getRates($request);
        
    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
    {  	
    	$rateReply = $response -> RateReplyDetails;
    	$charge=$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
    	$amnt = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
    	//echo $amount = '$'."<input type='text' name='ship_amnt' value='$amnt' readonly='readonly' class='input_textbox'/>";
    	 if(array_key_exists('DeliveryTimestamp',$rateReply)){
        	$deliveryDate = $rateReply->DeliveryTimestamp ;
        }else if(array_key_exists('TransitTime',$rateReply)){
        	$deliveryDate = $rateReply->TransitTime ;
        }
        //echo ' '.'Delivery Date'.$deliveryDate;
		$uspsOptions[0]['option'] = '&nbsp;Delivery Date'.$deliveryDate;
		$k=0;
		$weights = explode(',',$_REQUEST['weights']);
		foreach($weights as $key => $value){
			 $sql_fetch_shipping_details=" Select * from tbl_size_weight_cost_master
									 where size_weight_cost_id = ".$weights[$k];
			$sql_fetch_shipping_details_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_fetch_shipping_details));
			
			$charge = $charge + $sql_fetch_shipping_details_res['packaging_cost'];
			 $k++;
		  }
		 
		$uspsOptions[0]['charge'] = $charge;
		echo json_encode($uspsOptions);
    }
    else
    { 
        $error= "<div style='color:#FF0000;'>";
        $error.= $response->Notifications->Message;
        $error.= "</div>";
        //echo $error;
		
		$uspsOptions[0]['option'] = 'error';
		if($response->Notifications->Message == NULL){
			$uspsOptions[0]['charge'] = "Shipping is not available here";
		}else{
			$uspsOptions[0]['charge'] = $response->Notifications->Message;
		}
		echo json_encode($uspsOptions);
    } 
    
    //writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
   printFault($exception, $client);        
}

?>
<?php

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 9.0.0
//$totalPoster=$_REQUEST['totalPoster'];
//$property= array('Weight' => array('Value' => 1,
//                                'Units' => 'LB'),
//                                'Dimensions' => array('Length' => 36,
//                                					  'Width' => 24,
//                                                      'Height' => 3,
//                                                      'Units' => 'IN')
//                                                  ); 
//   for($tp=1;$tp<=$totalPoster;$tp++){
//	$PosterAttr()=$property;
//	}                                                  
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
$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
$request['RequestedShipment']['ShipTimestamp'] = date('c');
$request['RequestedShipment']['ServiceType'] = 'PRIORITY_OVERNIGHT'; // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_GROUND, ...
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
			'StreetLines' => '1166 HOLIDAY DRIVE',
            'City' => 'WASILLA',
            'StateOrProvinceCode' => 'AK',
            'PostalCode' => '99812',
            'CountryCode' => 'US',
            'Residential' => false)
		);
$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER');
//$request['RequestedShipment']['ShippingChargesPayment'] = array('PaymentType' => 'SENDER',
//                                                        'Payor' => array('AccountNumber' => '510087321',
//                                                                     'CountryCode' => 'US'));
$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
$request['RequestedShipment']['PackageCount'] = '1';
$request['RequestedShipment']['PackageDetail'] = 'INDIVIDUAL_PACKAGES';  //  Or PACKAGE_SUMMARY
$request['RequestedShipment']['RequestedPackageLineItems'] = array('0' => array('Weight' => array('Value' => 1,
                                                                                    'Units' => 'LB'),
                                                                                    'Dimensions' => array('Length' => 36,
                                                                                        'Width' => 24,
                                                                                        'Height' => 3,
           1                                                                             'Units' => 'IN'))
																	
                                                                   );                                                                   
 //print_r($request);
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
    	echo $amount = '$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
    	 if(array_key_exists('DeliveryTimestamp',$rateReply)){
        	$deliveryDate=  $rateReply->DeliveryTimestamp ;
        }else if(array_key_exists('TransitTime',$rateReply)){
        	$deliveryDate= $rateReply->TransitTime ;
        }
        echo ' '.'Delivery Date'.$deliveryDate;
    }
    else
    {
        printError($client, $response);
    } 
    
    //writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
   printFault($exception, $client);        
}

?>
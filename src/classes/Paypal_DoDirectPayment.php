<?php
class Paypal_DoDirectPayment
{
	public $amount;
	public $ccType;
	public $ccNumber;
	public $expdate;
	public $cvv2;
	public $firstName;
	public $lastName;
	public $address;
	public $city;
	public $stateCode;
	public $zip;
	public $countryCode;
	public $currencyCode;
	
	public $API_Endpoint;
	public $version;
	public $API_UserName;
	public $API_Password;
	public $API_Signature;
	public $nvp_Header;
	public $subject;
	public $AUTH_token;
	public $AUTH_signature;
	public $AUTH_timestamp;
	public $methodName = "doDirectPayment";
	
	public function __construct()
	{

	}
	
	public function hash_call()
	{ 
		$nvpStr = "METHOD=".urlencode($this->methodName)."&VERSION=".urlencode($this->version).
				  "&PWD=".urlencode($this->API_Password)."&USER=".urlencode($this->API_UserName)."&SIGNATURE=".urlencode($this->API_Signature).
				  "&PAYMENTACTION=Sale&AMT=".urlencode(trim($this->amount))."&CREDITCARDTYPE=".urlencode(trim($this->ccType))."&ACCT=".urlencode(trim($this->ccNumber)).
				  "&EXPDATE=".urlencode(trim($this->expdate))."&CVV2=".urlencode(trim($this->cvv2))."&FIRSTNAME=".urlencode(trim($this->firstName)).
				  "&LASTNAME=".urlencode(trim($this->lastName))."&STREET=".urlencode(trim($this->address))."&CITY=".urlencode(trim($this->city)).
				  "&STATE=".urlencode(trim($this->stateCode))."&ZIP=".urlencode(trim($this->zip))."&COUNTRYCODE=".urlencode(trim($this->countryCode)).
				  "&CURRENCYCODE=".urlencode(trim($this->currencyCode));
    
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		//$resArray = $this->hash_call($this->methodName, $nvpstr);
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		 */

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpStr);
		
		//getting response from server
		$response = curl_exec($ch);
		
		//convrting NVPResponse to an Associative Array
		$nvpResArray = $this->deformatNVP($response);
		$nvpReqArray = $this->deformatNVP($nvpreq);
		//$_SESSION['nvpReqArray'] = $nvpReqArray;
		
		if(curl_errno($ch)){
			// moving to display page to display curl errors
			/*$_SESSION['curl_error_no'] = curl_errno($ch) ;
			$_SESSION['curl_error_msg'] = curl_error($ch);
			$location = "APIError.php";
			header("Location: $location");*/
			
		}else{
			//closing the curl
			curl_close($ch);
		}

		return $nvpResArray;
	}
	
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	  */
	
	function deformatNVP($nvpstr)
	{
		$intial=0;
		$nvpArray = array();	
	
		while(strlen($nvpstr)){
			//postion of Key
			$keypos = strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval = substr($nvpstr, $intial, $keypos);
			$valval = substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] = urldecode( $valval);
			$nvpstr = substr($nvpstr,$valuepos + 1, strlen($nvpstr));
		 }
		return $nvpArray;
	}
	
	function formAutorization($auth_token, $auth_signature, $auth_timestamp)
	{
		$authString = "token=".$auth_token.",signature=".$auth_signature.",timestamp=".$auth_timestamp;
		return $authString;
	}
}
?>
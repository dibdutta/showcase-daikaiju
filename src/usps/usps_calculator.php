<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
function USPSParcelRate($dest_zip,$width, $height, $length, $weight_lb,$weight_oz)
{

	// This script was written by Mark Sanborn at http://www.marksanborn.net
	// If this script benefits you are your business please consider a donation
	// You can donate at http://www.marksanborn.net/donate.  
	
	// ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========
	
	$userName = '530DUTTA1484'; // Your USPS Username
	$orig_zip = '27249'; // Zipcode you are shipping FROM
	
	// =============== DON'T CHANGE BELOW THIS LINE ===============
	
	$url = "http://production.shippingapis.com/ShippingAPI.dll";
	$ch = curl_init();
	
	// set the target url
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	
	// parameters to post
	curl_setopt($ch, CURLOPT_POST, 1);
	
	$data = "API=RateV4&XML=<RateV4Request USERID=\"$userName\">
	<Package ID=\"1ST\">
	<Service>PRIORITY</Service>
	<ZipOrigination>$orig_zip</ZipOrigination>
	<ZipDestination>$dest_zip</ZipDestination>
	<Pounds>$weight_lb</Pounds>
	<Ounces>$weight_oz</Ounces>
	<Container>NONRECTANGULAR</Container>
	<Size>LARGE</Size>
	<Width>$width</Width>
    <Length>$length</Length>
    <Height>$height</Height>
    <Girth>$height</Girth>
	<Machinable>TRUE</Machinable>
	</Package>
	</RateV4Request>";
	
	
	// send the POST values to USPS
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	
	$result=curl_exec ($ch);
//if (!$result=curl_exec ($ch)) 
//{
//print "cURL Failed to connect!";
//} 
//else {print "$result";}
	$data = strstr($result, '<?');
	// echo '<!-- '. $data. ' -->'; // Uncomment to show XML in comments
	$xml_parser = xml_parser_create();
	xml_parse_into_struct($xml_parser, $data, $vals, $index);
	xml_parser_free($xml_parser);
	$params = array();
	$level = array();
	foreach ($vals as $xml_elem){
		if ($xml_elem['type'] == 'open') {
			if (array_key_exists('attributes',$xml_elem)){
				list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
			}else{
				$level[$xml_elem['level']] = $xml_elem['tag'];
			}
		}
		if ($xml_elem['type'] == 'complete'){
			$start_level = 1;
			$php_stmt = '$params';
			while($start_level < $xml_elem['level']){
				$php_stmt .= '[$level['.$start_level.']]';
				$start_level++;
			}
			$php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
			eval($php_stmt);
		}
	}
	curl_close($ch);
	//echo '<pre>'; print_r($params); echo'</pre>'; // Uncomment to see xml tags

	/*$uspsOptions[0]['option'] = '';//($totalPoster *$params['RATEV3RESPONSE']['1ST'][$level['3']]['RATE']);
	$uspsOptions[0]['charge'] = number_format(($totalPoster * $params['RATEV3RESPONSE']['1ST'][$level['3']]['RATE']), 2);
	if($uspsOptions[0]['charge']>0){
	return $uspsOptions;
	}else{
	$uspsOptions[0]['error']=$params['RATEV3RESPONSE']['1ST']['ERROR']['DESCRIPTION'];
	return $uspsOptions;
	}*/

	// Get rate
	$rate = $params['RATEV4RESPONSE']['1ST']['1']['RATE'] ?? '';

	// Get delivery time - try different possible keys from USPS response
	// USPS Priority Mail typically returns commitment info in various locations
	$deliveryTime = '';
	if (isset($params['RATEV4RESPONSE']['1ST']['1']['COMMITMENTNAME'])) {
		$deliveryTime = $params['RATEV4RESPONSE']['1ST']['1']['COMMITMENTNAME'];
	} elseif (isset($params['RATEV4RESPONSE']['1ST']['1']['COMMITMENTDATE'])) {
		$deliveryTime = $params['RATEV4RESPONSE']['1ST']['1']['COMMITMENTDATE'];
	} elseif (isset($params['RATEV4RESPONSE']['1ST']['COMMITMENTNAME'])) {
		$deliveryTime = $params['RATEV4RESPONSE']['1ST']['COMMITMENTNAME'];
	} elseif (isset($params['RATEV4RESPONSE']['1ST']['COMMITMENTDATE'])) {
		$deliveryTime = $params['RATEV4RESPONSE']['1ST']['COMMITMENTDATE'];
	} elseif (isset($params['RATEV4RESPONSE']['1ST']['1']['MAILSERVICE'])) {
		// Fallback to mail service description which may include timing
		$deliveryTime = $params['RATEV4RESPONSE']['1ST']['1']['MAILSERVICE'];
	}

	// Strip HTML tags and decode entities (e.g., <sup>®</sup> becomes ®)
	// First decode HTML entities, then strip tags, then clean up any remaining HTML fragments
	$deliveryTime = html_entity_decode($deliveryTime, ENT_QUOTES, 'UTF-8');
	$deliveryTime = strip_tags($deliveryTime);
	// Remove any remaining < or > characters that might be left over from malformed HTML
	$deliveryTime = str_replace(array('<', '>'), '', $deliveryTime);
	$deliveryTime = trim($deliveryTime);

	// Default delivery time for Priority Mail if not found in response
	if (empty($deliveryTime)) {
		$deliveryTime = '1-3 Business Days';
	}

	// Return rate/deliveryTime format expected by usps.php
	return $rate . '/' . $deliveryTime;
}
?>
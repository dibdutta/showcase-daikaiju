<?php
define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
function USPSParcelRate($dest,$width, $height, $length, $weight_lb,$weight_oz)
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
	
//	 $data = "API=IntlRateV2&XML=<IntlRateV2Request USERID=\"$userName\">
//	<Revision>2</Revision>
//	<Package ID=\"1ST\">
//	<Pounds>$weight</Pounds>
//	<Ounces>0</Ounces>
//	<Machinable>True</Machinable>
//	<MailType>Package</MailType>
//	<GXG>
//	<POBoxFlag>Y</POBoxFlag>
//	<GiftFlag>N</GiftFlag>
//	</GXG>
//	<ValueOfContents>0</ValueOfContents>
//	<Country>$dest</Country>
//	<Container>NONRECTANGULAR</Container>
//	<Size>LARGE</Size>
//	<Width>$width</Width>
//	<Length>$length</Length>
//	<Height>$height</Height>
//	<Girth>$girth</Girth>
//	<OriginZip>$orig_zip</OriginZip>
//	<CommercialFlag>N</CommercialFlag>
//	</Package>
//	</IntlRateV2Request>";

	$data = "API=IntlRateV2&XML=<IntlRateV2Request USERID=\"$userName\">
  	<Package ID=\"1ST\">
    <Pounds>$weight_lb</Pounds>
    <Ounces>$weight_oz</Ounces>
    <Machinable>True</Machinable>
    <MailType>Package</MailType>
    <GXG>
          <POBoxFlag>Y</POBoxFlag>
          <GiftFlag>N</GiftFlag>
    </GXG>
    <ValueOfContents>0</ValueOfContents>
    <Country>$dest</Country>
    <Container>NONRECTANGULAR</Container>
    <Size>LARGE</Size>
    <Width>$width</Width>
    <Length>$length</Length>
    <Height>$height</Height>
    <Girth>$height</Girth>
    <CommercialFlag>N</CommercialFlag>
    </Package>
 	</IntlRateV2Request>";

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
	foreach ($vals as $xml_elem) {
		if ($xml_elem['type'] == 'open') {
			if (array_key_exists('attributes',$xml_elem)) {
				list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
			} else {
			$level[$xml_elem['level']] = $xml_elem['tag'];
			}
		}
		if ($xml_elem['type'] == 'complete') {
			$start_level = 1;
			$php_stmt = '$params';
			while($start_level < $xml_elem['level']) {
				$php_stmt .= '[$level['.$start_level.']]';
				$start_level++;
			}
			$php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
			eval($php_stmt);
		}
	}
	curl_close($ch);
	//echo '<pre>'; print_r($params); echo'</pre>'; // Uncomment to see xml tags
	return $params['INTLRATEV2RESPONSE']['1ST']['2']['POSTAGE'].'/'.$params['INTLRATEV2RESPONSE']['1ST']['2']['SVCCOMMITMENTS'];
	

}
?>
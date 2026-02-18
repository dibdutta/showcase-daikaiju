<?php
// load SOAP library
require_once("libs/nusoap.php");
require_once("libs/functions.php");
// load library that holds implementations of functions we're making available to the web service
// set namespace
require_once(__DIR__ . "/lib/site_constants.php");
$ns="http://" . SITE_DOMAIN . "/";
// create SOAP server object
$server = new soap_server();
// setup WSDL file, a WSDL file can contain multiple services
$server->configureWSDL('Calculator',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
// register a web service method
$server->register('ws_add',
	array('int1' => 'xsd:integer','int2' => 'xsd:integer'), 	// input parameters
	array('total' => 'xsd:integer'), 							// output parameter
	$ns, 														// namespace
    "$ns#ws_add",		                						// soapaction
    'rpc',                              						// style
    'encoded',                          						// use
    'adds two integer values and returns the result'           	// documentation
	);

function ws_add($int1, $int2){
return new soapval('return','xsd:integer',add($int1, $int2));
}
// service the methods 
$server->service($HTTP_RAW_POST_DATA);
?>
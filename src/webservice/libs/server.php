<?php
// Pull in the NuSOAP code
//require_once('libs/nusoap.php');
// Create the server instance
//$server = new soap_server();
// Initialize WSDL support
//$server->configureWSDL('hellowsdl', 'urn:hellowsdl');
// Register the method to expose
//$server->register('hello',                // method name
   // array('name' => 'xsd:string'),        // input parameters
    //array('return' => 'xsd:string'),      // output parameters
  //  'urn:hellowsdl',                      // namespace
   // 'urn:hellowsdl#hello',                // soapaction
   // 'rpc',                                // style
   // 'encoded',                            // use
  // 'Says hello to the caller'            // documentation
//);
// Define the method as a PHP function
//function hello($name) {
        //return 'Hello, ' . $name;
//}
// Use the request to (try to) invoke the service
//$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);


// load SOAP library
require_once("libs/nusoap.php");
require_once("libs/functions.php");
// load library that holds implementations of functions we're making available to the web service
// set namespace
$ns="http://localhost/";
// create SOAP server object
$server = new soap_server();
// setup WSDL file, a WSDL file can contain multiple services
$server->configureWSDL('Calculator',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
// register a web service method
$server->register('ws_add',
	array('str1' => 'xsd:string','str2' => 'xsd:string'), 	// input parameters
	array('user_status' => 'xsd:string'), 							// output parameter
	$ns, 														// namespace
    "$ns#ws_add",		                						// soapaction
    'rpc',                              						// style
    'encoded',                          						// use
    'adds two integer values and returns the result'           	// documentation
	);

function ws_add($str1, $str1){
return new soapval('return','xsd:string',add($str1, $str2));
}
// service the methods 
$server->service($HTTP_RAW_POST_DATA);
?>
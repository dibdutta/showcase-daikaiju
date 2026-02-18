<?php
if(isset($_REQUEST['SUBMIT']) && $_REQUEST['SUBMIT']=='submit'){
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

// Pull in the NuSOAP code
require_once('nusoap.php');
// Create the client instance
$client = new nusoap_client('http://www.mygodzillashop.com/webservice/server.php?wsdl', true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
$result = $client->call('user_validation', array('str1'=>$username, 'str2'=>$password)); 
// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($result);
    echo '</pre>';
    }
}
}
// Display the request and response
/*echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';*/
// Display the debug messages
/*echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';*/
?>
<form method="post">
<table>
<tr><td>Username</td><td><input type="text" name="username"  /></td></tr>
<tr><td>Password</td><td><input type="password" name="password"  /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="SUBMIT" value="submit" /></td></tr>
</table>
</form>
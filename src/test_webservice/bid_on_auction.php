<?php
if(isset($_REQUEST['SUBMIT']) && $_REQUEST['SUBMIT']=='submit'){
$username=$_REQUEST['user_name'];
$password=$_REQUEST['password'];
$auction_id=$_REQUEST['auction_id'];
$bid_amnt=$_REQUEST['bid_amnt'];

if($auction_id >0){
// Pull in the NuSOAP code
require('nusoap.php');
// Create the client instance
$client = new nusoap_client('http://www.movieposterexchange.com/webservice/server.php?wsdl', true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
$result=$client->call('postBid',array('username'=>$username,'password'=>$password,'auction_id'=>$auction_id,'bid_amount'=>$bid_amnt));

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
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
}
 //Display the debug messages
//echo '<h2>Debug</h2>';
//echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
<form method="post">
<table>
<tr><td>Username:</td><td><input type="text" name="user_name"  /></td></tr>
<tr><td>Password:</td><td><input type="password" name="password"  /></td></tr>
<tr><td>Auction Id:</td><td><input type="text" name="auction_id"  /></td></tr>
<tr><td>Max Bid:</td><td><input type="text" name="bid_amnt"  /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="SUBMIT" value="submit" /></td></tr>
</table>
</form>
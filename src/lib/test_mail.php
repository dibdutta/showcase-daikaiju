<?php

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

require 'AWS/aws-autoloader.php';

$client = new Aws\Ses\SesClient([
    		'version' => 'latest',
    		'region'  => 'us-west-2'//,
    		//'debug'   => true
		 ]);


define('SENDER', 'Movie Poster Exchange <info@movieposterexchange.com>');

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
define('RECIPIENT', 'dibyendu.dutta.mail@gmail.com');

// Replace us-west-2 with the AWS region you're using for Amazon SES.
define('REGION','us-west-2');

define('SUBJECT','MPE::New poster matching your want list');
define('BODY','This email was sent with Amazon SES using the AWS SDK for PHP.');


//use Guzzle\Plugin\Log\LogPlugin;
//$client->addSubscriber(LogPlugin::getDebugPlugin());

$request = array();
$request['Source'] = SENDER;
$request['Destination']['ToAddresses'] = array(RECIPIENT);
$request['Message']['Subject']['Data'] = SUBJECT;
$request['Message']['Body']['Text']['Data'] = BODY;

try {
     $result = $client->sendEmail($request);
     $messageId = $result->get('MessageId');
     echo("Email sent! Message ID: $messageId"."\n");

} catch (Exception $e) {
     echo("The email was not sent. Error message: ");
     echo($e->getMessage()."\n");
}


?>

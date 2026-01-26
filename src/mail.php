<?php
$to = "sriparna.dutta@geotechinfo.net";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "madhurraj2003@gmail.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?> 
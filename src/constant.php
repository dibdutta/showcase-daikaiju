<?php
$url = 'https://api.constantcontact.com/v2/contacts?action_by=ACTION_BY_OWNER&api_key=8gzakbpndhw46cmsbwdqpq4k';
$data = array({"lists"=> [{"id"=> "1"}],"email_addresses": [{"email_address": "dutta.dibyendu2010@gmail.com"}],"first_name": "Dibyendu","last_name": "Dutta"});

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Authorization:e3524e1e-4573-4df9-840e-88d3de3101fb;Content-type: application/json;charset=UTF-8",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);
?>
<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

// Show config being used
echo "<pre>";
echo "ZEPTOMAIL_API_URL:   " . ZEPTOMAIL_API_URL . "\n";
echo "ZEPTOMAIL_SMTP_TOKEN set: " . (ZEPTOMAIL_SMTP_TOKEN ? 'YES (' . strlen(ZEPTOMAIL_SMTP_TOKEN) . ' chars)' : 'NO — MISSING') . "\n";
echo "SITE_EMAIL:          " . SITE_EMAIL . "\n";
echo "Sending to:          " . ADMIN_EMAIL_ADDRESS . "\n\n";

// Send with verbose cURL error capture
$payload = json_encode([
    'from'     => ['address' => SITE_EMAIL, 'name' => 'Kaijulink'],
    'to'       => [['email_address' => ['address' => ADMIN_EMAIL_ADDRESS, 'name' => ADMIN_NAME]]],
    'subject'  => 'Zeptomail Production Test',
    'htmlbody' => '<p>Zeptomail working in production.</p>',
]);

$ch = curl_init(ZEPTOMAIL_API_URL);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Zoho-enczapikey ' . ZEPTOMAIL_SMTP_TOKEN,
        'Content-Type: application/json',
        'Accept: application/json',
    ],
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "cURL Error: " . ($curlErr ?: 'none') . "\n";
echo "Response: $response\n";
echo "</pre>";

<?php
// Temporary debug script - DELETE after troubleshooting
header('Content-Type: text/plain');

$clientId     = getenv('USPS_CONSUMER_KEY');
$clientSecret = getenv('USPS_CONSUMER_SECRET');

echo "=== ENV VARS ===\n";
echo "USPS_CONSUMER_KEY set: " . (!empty($clientId) ? 'YES (' . substr($clientId, 0, 8) . '...)' : 'NO') . "\n";
echo "USPS_CONSUMER_SECRET set: " . (!empty($clientSecret) ? 'YES' : 'NO') . "\n\n";

echo "=== STEP 1: OAuth Token ===\n";
$ch = curl_init('https://apis.usps.com/oauth2/v3/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type'    => 'client_credentials',
    'client_id'     => $clientId,
    'client_secret' => $clientSecret,
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

$tokenResponse = curl_exec($ch);
$tokenHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$tokenError    = curl_error($ch);
curl_close($ch);

echo "HTTP Status: $tokenHttpCode\n";
if ($tokenError) echo "cURL Error: $tokenError\n";
echo "Response: $tokenResponse\n\n";

$tokenData = json_decode($tokenResponse, true);
$token = $tokenData['access_token'] ?? '';

if (empty($token)) {
    echo "TOKEN FAILED - stopping here\n";
    exit;
}
echo "Token obtained: " . substr($token, 0, 20) . "...\n\n";

echo "=== STEP 2: Prices API ===\n";
$payload = [
    'originZIPCode'                => '27249',
    'destinationZIPCode'           => '90001',
    'weight'                       => 2.0,
    'length'                       => 24.0,
    'width'                        => 6.0,
    'height'                       => 6.0,
    'mailClass'                    => 'PRIORITY_MAIL',
    'processingCategory'           => 'NON_MACHINABLE',
    'destinationEntryFacilityType' => 'NONE',
    'rateIndicator'                => 'SP',
    'priceType'                    => 'RETAIL',
];
echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . "\n\n";

$ch = curl_init('https://apis.usps.com/prices/v3/base-rates/search');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
]);

$priceResponse = curl_exec($ch);
$priceHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$priceError    = curl_error($ch);
curl_close($ch);

echo "HTTP Status: $priceHttpCode\n";
if ($priceError) echo "cURL Error: $priceError\n";
echo "Response: " . json_encode(json_decode($priceResponse), JSON_PRETTY_PRINT) . "\n\n";

echo "=== STEP 3: DB Weight Record ===\n";
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

$sql = "SELECT * FROM tbl_size_weight_cost_master WHERE size_weight_cost_id = 10";
$res = mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'], $sql));
echo "size_weight_cost_id=10 row: ";
echo $res ? json_encode($res) : "NOT FOUND";
echo "\n\n";

$sql2 = "SELECT * FROM tbl_size_weight_cost_master LIMIT 5";
$res2 = mysqli_query($GLOBALS['db_connect'], $sql2);
echo "First 5 rows in tbl_size_weight_cost_master:\n";
while ($row = mysqli_fetch_assoc($res2)) {
    echo json_encode($row) . "\n";
}
?>

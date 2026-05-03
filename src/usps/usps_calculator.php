<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

function USPSGetToken() {
    static $cached_token = null;
    if ($cached_token !== null) {
        return $cached_token;
    }

    $clientId     = "7qILcfTnmqqNGPsauLPZUG86Y04EZPjSk7UaZuLAD1X5zz6W";
    $clientSecret = "liwUXyKGX0XzG9hPaVWSwG8uSqE2cKouRJXw8Ahwq9z6uIYzGSjv3cgmc9Aowyn8";

    $ch = curl_init('https://apis.usps.com/oauth2/v3/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type'    => 'client_credentials',
        'client_id'     => $clientId,
        'client_secret' => $clientSecret,
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $cached_token = $data['access_token'] ?? '';
    return $cached_token;
}

function USPSParcelRate($dest_zip, $width, $height, $length, $weight_lb, $weight_oz) {
    $orig_zip   = '30188';
    $weightLbs  = 1;//(float)$weight_lb + ((float)$weight_oz / 16);

    $token = USPSGetToken();
    if (empty($token)) {
        return '/';
    }

    $payload = [
        'originZIPCode'                => $orig_zip,
        'destinationZIPCode'           => (string)$dest_zip,
        'weight'                       => round($weightLbs, 4),
        'length'                       => (float)$length,
        'width'                        => (float)$width,
        'height'                       => (float)$height,
        'mailClass'                    => 'PRIORITY_MAIL',
        'processingCategory'           => 'NON_MACHINABLE',
        'destinationEntryFacilityType' => 'NONE',
        'rateIndicator'                => 'SP',
        'priceType'                    => 'RETAIL',
    ];

    $ch = curl_init('https://apis.usps.com/prices/v3/base-rates/search');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (empty($data['rates']) || !is_array($data['rates'])) {
        return '/';
    }

    $rate = $data['rates'][0]['price'] ?? '';
    if ($rate === '' || $rate === null) {
        return '/';
    }

    $deliveryTime = 'Priority Mail (1-3 Business Days)';

    return $rate . '/' . $deliveryTime;
}
?>

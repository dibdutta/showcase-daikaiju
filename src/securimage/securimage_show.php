<?php
// PHP 8 compatible CAPTCHA image generator
// Stores code in $_SESSION['securimage_code_value'] — same key used by Securimage::check()

error_reporting(0);

if (session_id() == '') {
    session_start();
}

$width  = 155;
$height = 45;
$length = 5;
$chars  = 'ABCDEFGHJKMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789';

// Generate random code
$code = '';
for ($i = 0; $i < $length; $i++) {
    $code .= $chars[random_int(0, strlen($chars) - 1)];
}
$_SESSION['securimage_code_value'] = strtolower($code);

// Create image
$im = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle($im, 0, 0, $width, $height, $bg);

// Background noise dots
for ($i = 0; $i < 80; $i++) {
    $dc = imagecolorallocate($im, rand(180, 230), rand(180, 230), rand(180, 230));
    imagesetpixel($im, rand(0, $width), rand(0, $height), $dc);
}

// Noise lines
for ($i = 0; $i < 4; $i++) {
    $lc = imagecolorallocate($im, rand(180, 220), rand(180, 220), rand(180, 220));
    imageline($im, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lc);
}

// Draw each character
$fontFile = __DIR__ . '/elephant.ttf';
$useTtf   = function_exists('imagettftext') && file_exists($fontFile);
$x = 10;
for ($i = 0; $i < strlen($code); $i++) {
    $tc    = imagecolorallocate($im, rand(0, 80), rand(0, 80), rand(30, 130));
    $angle = rand(-18, 18);
    $size  = rand(20, 26);
    $y     = rand(32, 40);
    if ($useTtf) {
        imagettftext($im, $size, $angle, $x, $y, $tc, $fontFile, $code[$i]);
        $x += rand(25, 32);
    } else {
        imagestring($im, 5, $x, rand(10, 22), $code[$i], $tc);
        $x += 26;
    }
}

header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
imagepng($im);
imagedestroy($im);

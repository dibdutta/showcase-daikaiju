<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

$to     = ADMIN_EMAIL_ADDRESS;
$result = sendMail($to, ADMIN_NAME, 'Zeptomail Production Test - Kaijulink', '<p>Zeptomail is working correctly in <b>production</b>.</p><p>API URL: ' . ZEPTOMAIL_API_URL . '</p>');

echo $result
    ? "<p style='color:green;font-size:18px;'>SUCCESS — test email sent to <b>$to</b>. Check your inbox.</p>"
    : "<p style='color:red;font-size:18px;'>FAILED — check server error_log.</p>";

<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

$result = sendMail(ADMIN_EMAIL_ADDRESS, ADMIN_NAME, 'Zeptomail Production Test - Kaijulink', '<p>Zeptomail is working correctly in <b>production</b>.</p>');

echo $result
    ? "<p style='color:green;font-size:18px;'>SUCCESS — test email sent to <b>" . ADMIN_EMAIL_ADDRESS . "</b>. Check your inbox.</p>"
    : "<p style='color:red;font-size:18px;'>FAILED — check server error_log.</p>";

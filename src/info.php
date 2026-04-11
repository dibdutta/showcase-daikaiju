<?php
date_default_timezone_set('America/New_York');
echo $_SERVER['HTTP_X_FORWARDED_PORT'];

echo "****";
echo ini_get('upload_max_filesize')."<br />";
echo ini_get('post_max_size')."<br />";
echo ini_get('max_execution_time')."<br />";
echo date('Y-m-d H:i:s');

// SES test email
if (isset($_GET['sendmail'])) {
    require_once __DIR__ . '/lib/site_constants.php';
    require_once __DIR__ . '/lib/function.php';

    $to   = $_GET['to'] ?? 'dibyendu.dutta.mail@gmail.com';
    $name = 'Test Recipient';
    $subject = 'SES Test Email - MyGodzillaShop';
    $body = '<h2>SES Test</h2><p>This is a test email sent via AWS SES from MyGodzillaShop at ' . date('Y-m-d H:i:s') . '</p>';

    try {
        sendMail($to, $name, $subject, $body);
        echo "<br /><strong style='color:green'>Email sent to {$to}</strong>";
    } catch (Exception $e) {
        echo "<br /><strong style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</strong>";
    }
} else {
    echo "<br /><a href='?sendmail=1'>Click here to send test email to dibyendu.dutta.mail@gmail.com</a>";
    echo "<br /><small>Or: ?sendmail=1&to=other@email.com</small>";
}

phpinfo();

?>
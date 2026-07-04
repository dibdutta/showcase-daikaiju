<?php
/**
 * Zeptomail diagnostic page.
 * Sends a test email and shows the raw API response so you can diagnose
 * token / sender-verification / DNS issues without needing CloudWatch.
 *
 * Access: /admin/admin_test_mail.php  (requires admin session)
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('PAGE_HEADER_TEXT', 'Mail Diagnostics');
ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['test_to'])) {
    $result = run_test(
        trim($_POST['test_to']),
        trim($_POST['test_subject'] ?? 'Kaijulink – Mail Diagnostic Test'),
        trim($_POST['test_body']   ?? 'This is a diagnostic test email sent from the Kaijulink admin panel.')
    );
}

function run_test($toMail, $subject, $bodyText) {
    $out = [];

    // ── Config snapshot ──────────────────────────────────────────────
    $token    = defined('ZEPTOMAIL_SMTP_TOKEN') ? ZEPTOMAIL_SMTP_TOKEN : '(undefined)';
    $apiUrl   = defined('ZEPTOMAIL_API_URL')    ? ZEPTOMAIL_API_URL    : '(undefined)';
    $fromAddr = defined('SITE_EMAIL')           ? SITE_EMAIL           : '(undefined)';

    $out['token_set']   = !empty($token) && $token !== '(undefined)';
    $out['token_hint']  = $out['token_set'] ? substr($token, 0, 8) . '…' . substr($token, -4) : '(empty — check SSM parameter)';
    $out['api_url']     = $apiUrl;
    $out['from_addr']   = $fromAddr;
    $out['to_addr']     = $toMail;

    if (!$out['token_set']) {
        $out['status']  = 'error';
        $out['message'] = 'ZEPTOMAIL_SMTP_TOKEN is empty. Set it in AWS SSM at /showcase/prod/ZEPTOMAIL_SMTP_TOKEN and redeploy.';
        return $out;
    }

    if (strpos($toMail, '@') === false) {
        $out['status']  = 'error';
        $out['message'] = 'Invalid recipient email address.';
        return $out;
    }

    // ── Build minimal payload ─────────────────────────────────────────
    $htmlBody = '<p style="font-family:Arial,sans-serif;font-size:14px;">' . htmlspecialchars($bodyText) . '</p>'
              . '<p style="font-family:Arial,sans-serif;font-size:11px;color:#999;">Sent from Kaijulink admin diagnostic tool — ' . date('Y-m-d H:i:s T') . '</p>';

    $payload = json_encode([
        'from'     => ['address' => $fromAddr, 'name' => 'Kaijulink'],
        'to'       => [['email_address' => ['address' => $toMail, 'name' => 'Test Recipient']]],
        'subject'  => $subject,
        'htmlbody' => $htmlBody,
    ]);

    $out['payload_ok'] = ($payload !== false);
    if (!$out['payload_ok']) {
        $out['status']  = 'error';
        $out['message'] = 'json_encode failed: ' . json_last_error_msg();
        return $out;
    }

    // ── cURL call ─────────────────────────────────────────────────────
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Zoho-enczapikey ' . $token,
            'Content-Type: application/json',
            'Accept: application/json',
        ],
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);

    $response    = curl_exec($ch);
    $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr     = curl_error($ch);
    $curlErrNo   = curl_errno($ch);
    curl_close($ch);

    $out['http_code']   = $httpCode;
    $out['curl_err']    = $curlErr;
    $out['curl_errno']  = $curlErrNo;
    $out['raw_response']= $response;

    // Try to pretty-print JSON response
    $decoded = json_decode($response, true);
    $out['response_decoded'] = $decoded;

    if ($curlErr) {
        $out['status']  = 'error';
        $out['message'] = 'cURL error #' . $curlErrNo . ': ' . $curlErr;
    } elseif ($httpCode >= 200 && $httpCode < 300) {
        $out['status']  = 'success';
        $out['message'] = 'Email sent successfully (HTTP ' . $httpCode . ').';
    } else {
        $out['status']  = 'error';
        $apiMsg = $decoded['message'] ?? ($decoded['error']['message'] ?? ($decoded['error'] ?? ''));
        $out['message'] = 'Zeptomail returned HTTP ' . $httpCode . ($apiMsg ? ': ' . $apiMsg : '.');

        // Common diagnosis hints
        if ($httpCode === 401) {
            $out['hint'] = 'Token is invalid or expired. Update /showcase/prod/ZEPTOMAIL_SMTP_TOKEN in AWS SSM Parameter Store and redeploy ECS.';
        } elseif ($httpCode === 422) {
            $out['hint'] = 'Sender address "' . $fromAddr . '" is not verified in Zeptomail. Go to Zeptomail → Mail Agents → Sender Addresses and verify it.';
        } elseif ($httpCode === 429) {
            $creditExhausted = isset($decoded['error']['details'][0]['code']) && $decoded['error']['details'][0]['code'] === 'LE_102';
            $out['hint'] = $creditExhausted
                ? 'Email credits are exhausted. Log in to Zeptomail → Mail Agents → Credits / Billing and purchase more credits or upgrade your plan.'
                : 'Rate limit hit. Wait a moment and try again, or check your Zeptomail plan quota.';
        } elseif ($httpCode === 0) {
            $out['hint'] = 'No response received — check outbound internet access from ECS or whether ' . $apiUrl . ' is reachable.';
        }
    }

    return $out;
}

require_once INCLUDE_PATH . 'lib/adminCommon.php';
ob_end_clean();
ob_start();
$smarty->display('admin_header.tpl');
echo ob_get_clean();
?>
<style>
.diag-section { background:#fff; border:1px solid #ddd; border-radius:5px; padding:18px 20px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.diag-section h3 { font-size:13px; font-weight:700; color:#0f3460; margin:0 0 12px; border-bottom:1px solid #eee; padding-bottom:8px; text-transform:uppercase; letter-spacing:.5px; }
.diag-kv { display:flex; gap:8px; font-size:12px; margin-bottom:6px; align-items:flex-start; }
.diag-kv dt { color:#777; width:160px; flex-shrink:0; }
.diag-kv dd { color:#222; font-family:monospace; margin:0; word-break:break-all; }
.diag-ok   { color:#28a745; font-weight:700; }
.diag-fail { color:#dc3545; font-weight:700; }
.diag-warn { color:#856404; font-weight:700; }
.diag-box-ok   { background:#d4edda; border:1px solid #28a745; color:#155724; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-box-err  { background:#f8d7da; border:1px solid #dc3545; color:#721c24; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-hint { background:#fff3cd; border:1px solid #ffc107; color:#664d03; border-radius:4px; padding:8px 12px; font-size:12px; margin-top:8px; }
.diag-raw { background:#1a1a2e; color:#a8dadc; font-family:monospace; font-size:11px; padding:12px; border-radius:4px; overflow-x:auto; white-space:pre-wrap; margin-top:8px; max-height:220px; overflow-y:auto; }
.diag-form label { font-size:12px; font-weight:600; color:#444; display:block; margin-bottom:4px; }
.diag-form input[type=text], .diag-form input[type=email], .diag-form textarea {
    width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:3px; font-size:13px; font-family:inherit; box-sizing:border-box; margin-bottom:10px;
}
.diag-form input:focus, .diag-form textarea:focus { outline:none; border-color:#0f3460; }
.diag-btn { background:#0f3460; color:#fff; border:none; padding:9px 22px; font-size:12px; font-weight:700; border-radius:3px; cursor:pointer; text-transform:uppercase; letter-spacing:.5px; }
.diag-btn:hover { background:#1a3a6e; }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td align="center" class="bold_text" style="padding:10px 0 6px;">Mail Diagnostics — Zeptomail</td></tr>
<tr><td align="center"><a href="#" onclick="history.back();return false;" class="action_link">&lt;&lt; Back</a></td></tr>
</table>

<div style="max-width:700px;margin:16px auto;">

<?php if ($result): ?>

    <?php if ($result['status'] === 'success'): ?>
        <div class="diag-box-ok">&#10003; <?= htmlspecialchars($result['message']) ?></div>
    <?php else: ?>
        <div class="diag-box-err">&#10007; <?= htmlspecialchars($result['message']) ?></div>
        <?php if (!empty($result['hint'])): ?>
            <div class="diag-hint"><strong>How to fix:</strong> <?= htmlspecialchars($result['hint']) ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="diag-section">
        <h3>Configuration</h3>
        <dl>
            <div class="diag-kv"><dt>API URL</dt><dd><?= htmlspecialchars($result['api_url']) ?></dd></div>
            <div class="diag-kv"><dt>From address</dt><dd><?= htmlspecialchars($result['from_addr']) ?></dd></div>
            <div class="diag-kv"><dt>To address</dt><dd><?= htmlspecialchars($result['to_addr']) ?></dd></div>
            <div class="diag-kv"><dt>Token</dt>
                <dd class="<?= $result['token_set'] ? 'diag-ok' : 'diag-fail' ?>">
                    <?= htmlspecialchars($result['token_hint']) ?>
                </dd>
            </div>
        </dl>
    </div>

    <?php if (isset($result['http_code'])): ?>
    <div class="diag-section">
        <h3>API Response</h3>
        <dl>
            <div class="diag-kv"><dt>HTTP status</dt>
                <dd class="<?= ($result['http_code'] >= 200 && $result['http_code'] < 300) ? 'diag-ok' : 'diag-fail' ?>">
                    <?= (int)$result['http_code'] ?>
                </dd>
            </div>
            <?php if ($result['curl_err']): ?>
            <div class="diag-kv"><dt>cURL error</dt><dd class="diag-fail"><?= htmlspecialchars($result['curl_err']) ?></dd></div>
            <?php endif; ?>
        </dl>
        <div class="diag-raw"><?= htmlspecialchars($result['raw_response'] ?: '(empty)') ?></div>
    </div>
    <?php endif; ?>

<?php endif; ?>

    <div class="diag-section">
        <h3>Send Test Email</h3>
        <form method="post" class="diag-form">
            <label>Recipient email <span style="color:#dc3545;">*</span></label>
            <input type="email" name="test_to" value="<?= htmlspecialchars($_POST['test_to'] ?? '') ?>" placeholder="you@example.com" required>

            <label>Subject</label>
            <input type="text" name="test_subject" value="<?= htmlspecialchars($_POST['test_subject'] ?? 'Kaijulink – Mail Diagnostic Test') ?>">

            <label>Body text</label>
            <textarea name="test_body" rows="3"><?= htmlspecialchars($_POST['test_body'] ?? 'This is a diagnostic test email sent from the Kaijulink admin panel.') ?></textarea>

            <button type="submit" class="diag-btn">Send Test Email</button>
        </form>
    </div>

    <div class="diag-section">
        <h3>Quick Fix Guide</h3>
        <table border="0" cellpadding="5" cellspacing="1" width="100%" style="font-size:12px;">
            <tr style="background:#f5f5f5;">
                <th align="left" style="padding:6px 8px;">HTTP code</th>
                <th align="left" style="padding:6px 8px;">Meaning</th>
                <th align="left" style="padding:6px 8px;">Action</th>
            </tr>
            <tr><td style="padding:5px 8px;"><span class="diag-ok">2xx</span></td><td>Success</td><td>Email sent ✓</td></tr>
            <tr style="background:#fafafa;"><td style="padding:5px 8px;"><span class="diag-fail">401</span></td><td>Unauthorised</td><td>Update <code>ZEPTOMAIL_SMTP_TOKEN</code> in AWS SSM → redeploy ECS</td></tr>
            <tr><td style="padding:5px 8px;"><span class="diag-fail">422</span></td><td>Sender unverified</td><td>Verify <code>info@kaijulink.com</code> in Zeptomail → Mail Agents → Sender Addresses</td></tr>
            <tr style="background:#fafafa;"><td style="padding:5px 8px;"><span class="diag-warn">429 LE_102</span></td><td>Credits exhausted</td><td>Log in to Zeptomail → Mail Agents → Credits/Billing and top up</td></tr>
            <tr><td style="padding:5px 8px;"><span class="diag-warn">429</span></td><td>Rate limited</td><td>Wait and retry; check Zeptomail plan quota</td></tr>
            <tr><td style="padding:5px 8px;"><span class="diag-fail">0</span></td><td>No connection</td><td>ECS task can't reach Zeptomail — check security group outbound rules</td></tr>
        </table>
    </div>

</div>
</td></tr>
</table>
<?php $smarty->display('admin_footer.tpl'); ?>

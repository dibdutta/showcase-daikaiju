<?php
/**
 * Click-tracking redirect for manually-sent newsletter campaigns
 * (see admin/admin_auction_newsletter.php). Every "Bid Now" / CTA link in
 * those emails routes through here so clicks can be logged before bouncing
 * the visitor on to the real destination.
 *
 * GET params:
 *   campaign — free-text label identifying the send (e.g. "2026-08-16-ending-soon")
 *   item     — what was clicked: an auction_id, or "cta" for the main button
 *   url      — the real destination
 *
 * user_id/email are only recorded when the visitor happens to already be
 * logged in at click time — the newsletter is one identical email BCC'd to
 * everyone, so there is no per-recipient link to attribute anonymous clicks to.
 *
 * `url` is restricted to this site's own host so this endpoint can never be
 * used as an open redirector.
 */
ob_start();
define('INCLUDE_PATH', './');
require_once INCLUDE_PATH . 'lib/inc.php';

$db = $GLOBALS['db_connect'];

$campaign = substr(trim($_GET['campaign'] ?? ''), 0, 100);
$item     = substr(trim($_GET['item'] ?? ''), 0, 50);
$rawUrl   = trim($_GET['url'] ?? '');

$target = 'https://' . HOST_NAME . '/buy?list=weekly';
if ($rawUrl !== '') {
    $parsed = parse_url($rawUrl);
    $scheme = strtolower($parsed['scheme'] ?? '');
    $host   = $parsed['host'] ?? '';
    // parse_url()'s host never includes the port, but HOST_NAME (HTTP_HOST) does
    // on non-standard-port deployments — strip it from both sides before comparing.
    $stripPort = function ($h) { return strtolower(preg_replace('/:\d+$/', '', $h)); };
    if (in_array($scheme, ['http', 'https'], true) && $stripPort($host) === $stripPort(HOST_NAME)) {
        $target = $rawUrl;
    }
}

$userId = $_SESSION['sessUserID'] ?? null;
$email  = null;
if ($userId) {
    $rs = mysqli_query($db, "SELECT email FROM " . USER_TABLE . " WHERE user_id = " . (int)$userId);
    if ($rs && ($row = mysqli_fetch_assoc($rs))) {
        $email = $row['email'];
    }
}

$campaignSafe = mysqli_real_escape_string($db, $campaign);
$itemSafe     = mysqli_real_escape_string($db, $item);
$targetSafe   = mysqli_real_escape_string($db, substr($target, 0, 500));
$ip           = mysqli_real_escape_string($db, $_SERVER['REMOTE_ADDR'] ?? '');
$ua           = mysqli_real_escape_string($db, substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255));
$userIdSql    = $userId ? (int)$userId : 'NULL';
$emailSql     = $email ? "'" . mysqli_real_escape_string($db, $email) . "'" : 'NULL';

mysqli_query($db, "INSERT INTO tbl_newsletter_click_log
    (campaign, item_ref, target_url, user_id, email, ip_address, user_agent)
    VALUES ('$campaignSafe', '$itemSafe', '$targetSafe', $userIdSql, $emailSql, '$ip', '$ua')");

header('Location: ' . $target);
exit;

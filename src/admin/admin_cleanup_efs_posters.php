<?php
/**
 * One-time cleanup: delete all poster images from EFS now that they live in S3.
 * Run once, then this file will be removed along with the EFS mount point.
 *
 * Usage: https://www.mygodzillashop.com/admin/admin_cleanup_efs_posters.php
 */
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

header('Content-Type: text/plain');

if (!isset($_SESSION['adminLoginID'])) {
    die('Admin login required.');
}

$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

$dirs = [
    'poster_photo/thumb_big_slider/',
    'poster_photo/thumb_buy_gallery/',
    'poster_photo/thumb_buy/',
    'poster_photo/thumbnail/',
    'poster_photo/',
];

$deleted = 0;
$skipped = 0;
$log     = [];

foreach ($dirs as $dir) {
    $localDir = $docRoot . '/' . $dir;
    if (!is_dir($localDir)) {
        $log[] = "SKIP (no dir): $localDir";
        continue;
    }

    foreach (glob($localDir . '*') as $localPath) {
        if (!is_file($localPath)) {
            continue;
        }
        if (unlink($localPath)) {
            $deleted++;
        } else {
            $log[] = "FAIL: could not delete $localPath";
            $skipped++;
        }
    }
}

echo "EFS poster cleanup complete.\n";
echo "Deleted : $deleted files\n";
echo "Failed  : $skipped\n\n";
if ($log) {
    echo implode("\n", $log) . "\n\n";
}
echo "Safe to proceed: remove the EFS poster-photo mount and access point.\n";

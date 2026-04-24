<?php
/**
 * One-time migration: copy all poster images from EFS to S3.
 * Uses S3_STATIC_BUCKET env var (set via ECS task definition).
 * Run once via browser after deploying the S3 upload code, then DELETE this file.
 *
 * Usage: https://www.mygodzillashop.com/admin/admin_migrate_images_to_s3.php
 */
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    die('Admin login required.');
}

$s3Bucket = getenv('S3_STATIC_BUCKET');
$cdnBase  = getenv('CDN_STATIC_URL') ?: 'https://d294w6g1afjpvs.cloudfront.net';

if (!$s3Bucket) {
    die('S3_STATIC_BUCKET environment variable not set.');
}

$s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => 'us-east-1']);

$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

$dirs = [
    'poster_photo/',
    'poster_photo/thumbnail/',
    'poster_photo/thumb_buy/',
    'poster_photo/thumb_buy_gallery/',
    'poster_photo/thumb_big_slider/',
];

$ok   = 0;
$skip = 0;
$fail = 0;
$log  = [];

foreach ($dirs as $dir) {
    $localDir = $docRoot . '/' . $dir;
    if (!is_dir($localDir)) {
        $log[] = "SKIP (no dir): $localDir";
        continue;
    }

    foreach (glob($localDir . '*') as $localPath) {
        if (!is_file($localPath)) { continue; }

        $s3Key = $dir . basename($localPath);

        // Skip if already in S3
        try {
            $s3->headObject(['Bucket' => $s3Bucket, 'Key' => $s3Key]);
            $skip++;
            continue;
        } catch (Aws\S3\Exception\S3Exception $e) {
            // 404 = not yet uploaded, proceed
        }

        try {
            $s3->putObject([
                'Bucket'       => $s3Bucket,
                'Key'          => $s3Key,
                'SourceFile'   => $localPath,
                'ContentType'  => mime_content_type($localPath) ?: 'image/jpeg',
                'CacheControl' => 'max-age=31536000',
            ]);
            $ok++;
        } catch (Exception $e) {
            $log[] = "FAIL: $s3Key — " . $e->getMessage();
            $fail++;
        }
    }
}

header('Content-Type: text/plain');
echo "Migration complete.\n";
echo "Uploaded : $ok\n";
echo "Skipped  : $skip (already in S3)\n";
echo "Failed   : $fail\n\n";
if ($log) {
    echo implode("\n", $log) . "\n\n";
}
echo "Sample CDN URL: " . $cdnBase . "/poster_photo/thumbnail/<filename>\n";
echo "\nDELETE THIS FILE after confirming images load from CloudFront.\n";

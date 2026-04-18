<?php
/**
 * Cleanup orphaned blog images from S3.
 *
 * Compares every object under blog-images/ in S3 against filenames
 * referenced in tbl_blog (content HTML + featured_image column).
 * Unreferenced objects are deleted.
 *
 * By default runs as a DRY RUN — no deletes happen.
 * Pass ?confirm=1 (web) or --delete (CLI) to actually delete.
 *
 * Run via admin panel: /admin/admin_run_migration.php
 * Or directly:         php migrations/cleanup_orphaned_blog_images.php [--delete]
 */

define('INCLUDE_PATH', __DIR__ . '/../');
require_once INCLUDE_PATH . 'lib/dbconfig.php';
require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';

$dryRun = true;
if (php_sapi_name() === 'cli') {
    $dryRun = !in_array('--delete', $argv ?? []);
} else {
    $dryRun = !(($_GET['confirm'] ?? '') === '1');
}

// ── DB connection ─────────────────────────────────────────────────────────────

$db = mysqli_connect(
    getenv('DB_SERVER')   ?: 'mysql',
    getenv('DB_USER')     ?: 'root',
    getenv('DB_PASSWORD') ?: 'root',
    getenv('DB_NAME')     ?: 'mpe'
);
if (!$db) {
    die('DB connection failed: ' . mysqli_connect_error() . PHP_EOL);
}

// ── S3 client (uses ECS task role credentials automatically) ──────────────────

$s3Bucket = getenv('S3_STATIC_BUCKET') ?: 'showcase-prod-static-assets-263180773284';
$s3Prefix = 'blog-images/';
$cdnBase  = rtrim(getenv('CDN_STATIC_URL') ?: 'https://d294w6g1afjpvs.cloudfront.net', '/');

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
]);

// ── Step 1: collect all filenames referenced in the database ──────────────────

$referenced = [];

$res = mysqli_query($db, "SELECT content, featured_image FROM tbl_blog");
while ($row = mysqli_fetch_assoc($res)) {

    // featured_image stores just the filename
    if (!empty($row['featured_image'])) {
        $referenced[$row['featured_image']] = true;
    }

    // content stores HTML with full CloudFront URLs, e.g.:
    // https://d294w6g1afjpvs.cloudfront.net/blog-images/blog_1234_5678.jpg
    if (!empty($row['content'])) {
        preg_match_all('#blog-images/([^\s"\'<>]+)#', $row['content'], $matches);
        foreach ($matches[1] as $filename) {
            $referenced[$filename] = true;
        }
    }
}

// ── Step 2: list all objects in S3 blog-images/ ───────────────────────────────

$s3Objects = [];
$paginator = $s3->getPaginator('ListObjectsV2', [
    'Bucket' => $s3Bucket,
    'Prefix' => $s3Prefix,
]);

foreach ($paginator as $page) {
    foreach ($page['Contents'] ?? [] as $obj) {
        $key      = $obj['Key'];           // e.g. blog-images/blog_xxx.jpg
        $filename = basename($key);
        $s3Objects[$filename] = [
            'key'          => $key,
            'size'         => $obj['Size'],
            'last_modified'=> $obj['LastModified'],
        ];
    }
}

// ── Step 3: find orphans ──────────────────────────────────────────────────────

$orphans = array_diff_key($s3Objects, $referenced);

// ── Output ────────────────────────────────────────────────────────────────────

$nl = php_sapi_name() === 'cli' ? PHP_EOL : '<br>';

echo "S3 bucket:          {$s3Bucket}{$nl}";
echo "Prefix:             {$s3Prefix}{$nl}";
echo "Total S3 objects:   " . count($s3Objects) . "{$nl}";
echo "Referenced in DB:   " . count($referenced) . "{$nl}";
echo "Orphaned (to delete): " . count($orphans) . "{$nl}";
echo str_repeat('-', 60) . $nl;

if (empty($orphans)) {
    echo "Nothing to delete — S3 is clean." . $nl;
    exit(0);
}

$totalBytes = 0;
foreach ($orphans as $filename => $info) {
    $kb          = round($info['size'] / 1024, 1);
    $totalBytes += $info['size'];
    $modified    = $info['last_modified']->format('Y-m-d H:i');
    echo "  {$filename}  ({$kb} KB, uploaded {$modified}){$nl}";
}

$totalKb = round($totalBytes / 1024, 1);
echo str_repeat('-', 60) . $nl;
echo "Total reclaimable: {$totalKb} KB{$nl}";

if ($dryRun) {
    echo $nl;
    echo "DRY RUN — nothing deleted.{$nl}";
    if (php_sapi_name() === 'cli') {
        echo "Run with --delete to remove these files.{$nl}";
    } else {
        echo "Add ?confirm=1 to the URL to actually delete.{$nl}";
    }
    exit(0);
}

// ── Step 4: delete orphans ────────────────────────────────────────────────────

echo $nl . "Deleting..." . $nl;

$keys = array_map(fn($info) => ['Key' => $info['key']], array_values($orphans));

// S3 deleteObjects supports up to 1000 keys per call
foreach (array_chunk($keys, 1000) as $batch) {
    $result = $s3->deleteObjects([
        'Bucket' => $s3Bucket,
        'Delete' => ['Objects' => $batch],
    ]);
    foreach ($result['Deleted'] ?? [] as $deleted) {
        echo "  Deleted: " . basename($deleted['Key']) . $nl;
    }
    foreach ($result['Errors'] ?? [] as $err) {
        echo "  ERROR deleting " . $err['Key'] . ": " . $err['Message'] . $nl;
    }
}

echo $nl . "Done." . $nl;

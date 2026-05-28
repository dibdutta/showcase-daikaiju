<?php
/**
 * admin_reset_delete_s3_images.php
 *
 * Step 2 of 2 — deletes all poster images from S3 (production only).
 * Streams progress to the browser in real time, so CloudFront's 60s
 * origin_read_timeout is never hit — output flushes after each S3 batch.
 *
 * Run Step 1 (DB truncation) first via:
 *   admin_reset_truncate_tables.php
 *
 * S3 keys deleted (5 variants per image):
 *   poster_photo/<filename>
 *   poster_photo/thumbnail/<filename>
 *   poster_photo/thumb_buy/<filename>
 *   poster_photo/thumb_buy_gallery/<filename>
 *   poster_photo/thumb_big_slider/<filename>
 */

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

$db        = $GLOBALS['db_connect'];
$is_prod   = (APP_ENV === 'production');
$s3_bucket = getenv('S3_STATIC_BUCKET') ?: '';
$confirmed = isset($_POST['confirm']) && $_POST['confirm'] === 'YES_DELETE_S3';

$s3_prefixes = [
    'poster_photo/',
    'poster_photo/thumbnail/',
    'poster_photo/thumb_buy/',
    'poster_photo/thumb_buy_gallery/',
    'poster_photo/thumb_big_slider/',
];

function collect_image_filenames_s3($db) {
    $filenames = [];
    foreach (['tbl_poster_images', 'tbl_poster_images_live'] as $tbl) {
        $chk = mysqli_query($db, "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '$tbl'");
        if ($chk && mysqli_fetch_assoc($chk)['cnt'] > 0) {
            $res = mysqli_query($db, "SELECT DISTINCT poster_image FROM `$tbl` WHERE poster_image != ''");
            while ($row = mysqli_fetch_assoc($res)) {
                $filenames[$row['poster_image']] = true;
            }
        }
    }
    return array_keys($filenames);
}

if (!$confirmed):
    $filenames        = collect_image_filenames_s3($db);
    $image_count      = count($filenames);
    $s3_object_count  = $image_count * count($s3_prefixes);
?>
<!DOCTYPE html>
<html>
<head>
<title>Step 2 — Delete S3 Images</title>
<style>
  body  { font-family: Arial, sans-serif; padding: 30px; max-width: 900px; margin: 0 auto; }
  h2   { color: #c0392b; }
  .warn  { background:#fff3cd; border:1px solid #ffc107; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  .info  { background:#d1ecf1; border:1px solid #17a2b8; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  .skip  { background:#f8f9fa; border:1px solid #dee2e6; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  .btn-danger  { background:#c0392b; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; }
  .btn-cancel  { background:#6c757d; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; margin-left:12px; }
</style>
</head>
<body>

<h2>Step 2 of 2 — Delete S3 Poster Images</h2>
<p style="color:#555;">Make sure you have already run <a href="admin_reset_truncate_tables.php">Step 1 (truncate tables)</a> first.</p>

<?php if (!$is_prod): ?>
<div class="skip">
  <strong>⊘ Skipped — APP_ENV is not production.</strong><br>
  S3 deletion only runs in production. No action will be taken.
</div>
<?php else: ?>

<div class="warn">
  <strong>WARNING — This action is irreversible.</strong><br>
  <?= number_format($s3_object_count) ?> S3 objects will be permanently deleted
  (<?= number_format($image_count) ?> images × 5 variants)
  from bucket <code><?= htmlspecialchars($s3_bucket ?: 'S3_STATIC_BUCKET not set') ?></code>.
</div>

<div class="info">
  Deletion streams progress in real time — do not close this tab until it says complete.
  Each batch of 1,000 keys is deleted in one S3 API call.
</div>

<form method="post" onsubmit="return confirm('Delete <?= number_format($s3_object_count) ?> S3 objects? This CANNOT be undone.');">
  <input type="hidden" name="confirm" value="YES_DELETE_S3">
  <button type="submit" class="btn-danger">DELETE <?= number_format($s3_object_count) ?> S3 OBJECTS</button>
  <button type="button" class="btn-cancel" onclick="location.href='<?= ADMIN_PAGE_LINK ?>'">Cancel</button>
</form>

<?php endif; ?>

</body>
</html>
<?php
else:
    // ── Confirmed — stream deletion progress ───────────────────────────────
    // Disable output buffering so chunks reach the browser immediately.
    while (ob_get_level()) {
        ob_end_flush();
    }
    set_time_limit(0);
    ignore_user_abort(true);
?>
<!DOCTYPE html>
<html>
<head>
<title>Deleting S3 Images…</title>
<style>
  body  { font-family: Arial, sans-serif; padding: 30px; max-width: 900px; margin: 0 auto; }
  h2   { color: #c0392b; }
  pre  { background:#f8f9fa; border:1px solid #dee2e6; padding:14px; border-radius:4px; font-size:13px; line-height:1.6; white-space:pre-wrap; }
  .ok    { color:#155724; font-weight:bold; }
  .err   { color:#721c24; font-weight:bold; }
  .done  { background:#d4edda; border:1px solid #28a745; padding:14px 18px; border-radius:4px; margin-top:16px; }
</style>
</head>
<body>
<h2>Deleting S3 Images…</h2>
<p>Do not close this tab.</p>
<pre id="log">
<?php
    flush();

    if (!$is_prod) {
        echo "⊘ APP_ENV is not production — skipping S3 deletion.\n";
        flush();
    } elseif (empty($s3_bucket)) {
        echo "✖ S3_STATIC_BUCKET is not set — cannot delete.\n";
        flush();
    } else {
        $filenames = collect_image_filenames_s3($db);
        $image_count = count($filenames);

        if ($image_count === 0) {
            echo "⊘ No images found in tbl_poster_images / tbl_poster_images_live — nothing to delete.\n";
            flush();
        } else {
            echo "Found {$image_count} unique image files × 5 variants = " . ($image_count * 5) . " S3 objects.\n";
            echo "Bucket: {$s3_bucket}\n\n";
            flush();

            require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';
            $s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => 'us-east-1']);

            // Build full key list
            $keys = [];
            foreach ($filenames as $filename) {
                foreach ($s3_prefixes as $prefix) {
                    $keys[] = ['Key' => $prefix . $filename];
                }
            }

            $total_deleted = 0;
            $total_errors  = 0;
            $batch_num     = 0;
            $chunks        = array_chunk($keys, 1000);

            foreach ($chunks as $chunk) {
                $batch_num++;
                $batch_size = count($chunk);
                echo "Batch {$batch_num}/" . count($chunks) . " — sending {$batch_size} keys… ";
                flush();

                try {
                    $result         = $s3->deleteObjects(['Bucket' => $s3_bucket, 'Delete' => ['Objects' => $chunk]]);
                    $deleted        = count($result['Deleted'] ?? []);
                    $batch_errors   = $result['Errors'] ?? [];
                    $total_deleted += $deleted;
                    $total_errors  += count($batch_errors);

                    echo "✔ {$deleted} deleted";
                    if (!empty($batch_errors)) {
                        echo ", ✖ " . count($batch_errors) . " errors:\n";
                        foreach ($batch_errors as $err) {
                            echo "    " . $err['Key'] . ': ' . $err['Message'] . "\n";
                        }
                    } else {
                        echo "\n";
                    }
                } catch (Exception $e) {
                    $total_errors++;
                    echo "✖ Batch failed: " . $e->getMessage() . "\n";
                }

                flush();
            }

            echo "\n--- Done ---\n";
            echo "Total deleted : {$total_deleted}\n";
            echo "Total errors  : {$total_errors}\n";
            flush();
        }
    }
?>
</pre>

<div class="done">
  <strong>✔ S3 deletion complete.</strong>
  <a href="<?= ADMIN_PAGE_LINK ?>" style="margin-left:20px; color:#007bff;">← Back to Admin Panel</a>
</div>

</body>
</html>
<?php
endif;
?>

<?php
/**
 * admin_reset_auction_data.php
 *
 * Truncates all poster/auction transactional tables AND deletes S3 images.
 * Master data tables (users, categories, config, reference) are untouched.
 *
 * TABLES TRUNCATED (34):
 *   tbl_poster, tbl_poster_live
 *   tbl_poster_images, tbl_poster_images_live
 *   tbl_auction, tbl_auction_live, tbl_auction_archive, tbl_auction_mapping
 *   tbl_auction_week, tbl_auction_calender, tbl_event
 *   tbl_poster_to_category, tbl_poster_to_category_live
 *   tbl_poster_to_subcategory, tbl_poster_to_subcategory_live
 *   tbl_poster_to_shop_category, tbl_poster_to_shop_category_live
 *   tbl_bid, tbl_bid_archive
 *   tbl_proxy_bid, tbl_proxy_bid_live
 *   tbl_offer
 *   tbl_watching
 *   tbl_wantlist, tbl_wantlist_category
 *   tbl_messages
 *   tbl_cart_history
 *   tbl_invoice, tbl_invoice_to_auction
 *   tbl_sold_archive
 *   tbl_mpe_admin_payment_to_seller
 *   tbl_temp, tbl_lossing_temp_table
 *   tbl_pending_bulkuploads
 *
 * S3 CLEANUP (production only):
 *   Deletes all 5 variants per image (original, thumbnail, thumb_buy,
 *   thumb_buy_gallery, thumb_big_slider) from S3_STATIC_BUCKET.
 *
 * TABLES PRESERVED:
 *   config_table, admin_table, admin_access_table, admin_section_table
 *   user_table, country_table, card_details
 *   page_table, page_content_table
 *   tbl_category, tbl_category_type, tbl_subcategory, tbl_shop_category
 *   tbl_auction_type
 *   tbl_us_state, tbl_package_dimention, tbl_size_weight_cost_master, tbl_cond_desc
 *   tbl_blog, tbl_blog_comments
 *   tbl_email_temp, tbl_email_temp_item_specific
 *   tbl_blacklist
 */

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

$tables_to_truncate = [
    // Poster data
    'tbl_poster',
    'tbl_poster_live',
    'tbl_poster_images',
    'tbl_poster_images_live',
    // Auction data
    'tbl_auction',
    'tbl_auction_live',
    'tbl_auction_archive',
    'tbl_auction_mapping',
    'tbl_auction_week',
    'tbl_auction_calender',
    'tbl_event',
    // Category junction tables
    'tbl_poster_to_category',
    'tbl_poster_to_category_live',
    'tbl_poster_to_subcategory',
    'tbl_poster_to_subcategory_live',
    'tbl_poster_to_shop_category',
    'tbl_poster_to_shop_category_live',
    // Bidding
    'tbl_bid',
    'tbl_bid_archive',
    'tbl_proxy_bid',
    'tbl_proxy_bid_live',
    // Offers
    'tbl_offer',
    // User activity
    'tbl_watching',
    'tbl_wantlist',
    'tbl_wantlist_category',
    'tbl_messages',
    'tbl_cart_history',
    // Invoices & payments
    'tbl_invoice',
    'tbl_invoice_to_auction',
    'tbl_sold_archive',
    'tbl_mpe_admin_payment_to_seller',
    // Temp / working tables
    'tbl_temp',
    'tbl_lossing_temp_table',
    'tbl_pending_bulkuploads',
];

// S3 key prefixes — 5 variants generated per image on upload
$s3_prefixes = [
    'poster_photo/',
    'poster_photo/thumbnail/',
    'poster_photo/thumb_buy/',
    'poster_photo/thumb_buy_gallery/',
    'poster_photo/thumb_big_slider/',
];

$db        = $GLOBALS['db_connect'];
$is_prod   = (APP_ENV === 'production');
$s3_bucket = getenv('S3_STATIC_BUCKET') ?: '';
$confirmed = isset($_POST['confirm']) && $_POST['confirm'] === 'YES_TRUNCATE';

// Collect unique image filenames from both image tables
function collect_image_filenames($db) {
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

// Batch-delete S3 objects, returns ['deleted' => n, 'errors' => [...]]
function delete_s3_images($filenames, $prefixes, $bucket) {
    if (empty($filenames) || empty($bucket)) {
        return ['deleted' => 0, 'errors' => ['S3_STATIC_BUCKET not set or no images found']];
    }

    require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';
    $s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => 'us-east-1']);

    // Build full key list: 5 variants × n images
    $keys = [];
    foreach ($filenames as $filename) {
        foreach ($prefixes as $prefix) {
            $keys[] = ['Key' => $prefix . $filename];
        }
    }

    $deleted  = 0;
    $errors   = [];
    $chunks   = array_chunk($keys, 1000); // S3 deleteObjects max 1000 per call

    foreach ($chunks as $chunk) {
        try {
            $result   = $s3->deleteObjects(['Bucket' => $bucket, 'Delete' => ['Objects' => $chunk]]);
            $deleted += count($result['Deleted'] ?? []);
            foreach ($result['Errors'] ?? [] as $err) {
                $errors[] = $err['Key'] . ': ' . $err['Message'];
            }
        } catch (Exception $e) {
            $errors[] = 'Batch delete failed: ' . $e->getMessage();
        }
    }

    return ['deleted' => $deleted, 'errors' => $errors];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Reset Auction Data</title>
<style>
  body  { font-family: Arial, sans-serif; padding: 30px; max-width: 900px; margin: 0 auto; }
  h2   { color: #c0392b; }
  h3   { margin-top: 28px; color: #343a40; }
  .warn  { background:#fff3cd; border:1px solid #ffc107; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  .keep  { background:#d4edda; border:1px solid #28a745; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  .info  { background:#d1ecf1; border:1px solid #17a2b8; padding:14px 18px; border-radius:4px; margin-bottom:16px; }
  table  { width:100%; border-collapse:collapse; margin-top:10px; }
  th     { background:#343a40; color:#fff; padding:8px 12px; text-align:left; }
  td     { padding:7px 12px; border-bottom:1px solid #dee2e6; }
  .ok    { color:#155724; font-weight:bold; }
  .skip  { color:#856404; }
  .err   { color:#721c24; font-weight:bold; }
  .btn-danger { background:#c0392b; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; }
  .btn-cancel { background:#6c757d; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; margin-left:12px; }
</style>
</head>
<body>

<h2>⚠ Reset Auction &amp; Poster Data</h2>

<?php if (!$confirmed): ?>

<div class="warn">
  <strong>WARNING — This action is irreversible.</strong><br>
  <?= count($tables_to_truncate) ?> database tables will be permanently emptied <strong>and all poster images will be deleted from S3</strong>.
</div>

<div class="keep">
  <strong>PRESERVED (not touched):</strong> config_table, admin_table, user_table,
  country_table, page_table, page_content_table, card_details,
  tbl_category, tbl_category_type, tbl_subcategory, tbl_shop_category,
  tbl_auction_type, tbl_us_state, tbl_package_dimention,
  tbl_size_weight_cost_master, tbl_cond_desc,
  tbl_blog, tbl_blog_comments, tbl_email_temp, tbl_email_temp_item_specific,
  tbl_blacklist
</div>

<?php
  // Show S3 image count
  $image_filenames = collect_image_filenames($db);
  $image_count     = count($image_filenames);
  $s3_object_count = $image_count * count($s3_prefixes);
?>

<div class="info">
  <strong>S3 cleanup <?= $is_prod ? '(PRODUCTION — will run)' : '(LOCAL — will be skipped)' ?>:</strong><br>
  <?= number_format($image_count) ?> unique image files found &times; 5 variants
  = <strong><?= number_format($s3_object_count) ?> S3 objects</strong> to delete
  from bucket <code><?= htmlspecialchars($s3_bucket ?: 'S3_STATIC_BUCKET not set') ?></code>
</div>

<h3>Tables that will be truncated:</h3>
<table>
  <tr><th>#</th><th>Table</th><th>Current Row Count</th></tr>
  <?php
  $total_rows = 0;
  foreach ($tables_to_truncate as $i => $tbl) {
      $count  = '<span style="color:#999">N/A — table does not exist</span>';
      $exists = false;
      $chk = mysqli_query($db, "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '" . mysqli_real_escape_string($db, $tbl) . "'");
      if ($chk && mysqli_fetch_assoc($chk)['cnt'] > 0) {
          $exists = true;
          $res = mysqli_query($db, "SELECT COUNT(*) as cnt FROM `$tbl`");
          if ($res) {
              $n = (int) mysqli_fetch_assoc($res)['cnt'];
              $count = number_format($n) . ' rows';
              $total_rows += $n;
          }
      }
      echo "<tr><td>" . ($i + 1) . "</td><td><code>$tbl</code></td><td>$count</td></tr>";
  }
  ?>
  <tr style="background:#f8f9fa;font-weight:bold">
    <td colspan="2">TOTAL</td>
    <td><?= number_format($total_rows) ?> rows</td>
  </tr>
</table>

<form method="post" onsubmit="return confirm('Delete <?= number_format($s3_object_count) ?> S3 objects and truncate <?= count($tables_to_truncate) ?> tables? This CANNOT be undone.');">
  <input type="hidden" name="confirm" value="YES_TRUNCATE">
  <button type="submit" class="btn-danger">DELETE S3 IMAGES + TRUNCATE ALL TABLES</button>
  <button type="button" class="btn-cancel" onclick="location.href='<?= ADMIN_PAGE_LINK ?>'">Cancel</button>
</form>

<?php else: ?>

<?php
  // ── Step 1: S3 cleanup (production only) ──────────────────────────────
  $s3_result = ['deleted' => 0, 'errors' => []];
  $image_filenames = collect_image_filenames($db);

  if ($is_prod) {
      $s3_result = delete_s3_images($image_filenames, $s3_prefixes, $s3_bucket);
  }

  // ── Step 2: Truncate tables ────────────────────────────────────────────
  $tbl_results = [];
  $success = $skipped = $errors = 0;

  mysqli_query($db, "SET FOREIGN_KEY_CHECKS=0");
  foreach ($tables_to_truncate as $tbl) {
      $chk = mysqli_query($db, "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '" . mysqli_real_escape_string($db, $tbl) . "'");
      if (!$chk || mysqli_fetch_assoc($chk)['cnt'] == 0) {
          $tbl_results[] = ['table' => $tbl, 'status' => 'skip', 'note' => 'Table does not exist — skipped'];
          $skipped++;
          continue;
      }
      if (mysqli_query($db, "TRUNCATE TABLE `$tbl`")) {
          $tbl_results[] = ['table' => $tbl, 'status' => 'ok', 'note' => 'Truncated successfully'];
          $success++;
      } else {
          $tbl_results[] = ['table' => $tbl, 'status' => 'err', 'note' => mysqli_error($db)];
          $errors++;
      }
  }
  mysqli_query($db, "SET FOREIGN_KEY_CHECKS=1");
?>

<h3>S3 Image Cleanup</h3>
<?php if (!$is_prod): ?>
  <p class="skip">⊘ Skipped — APP_ENV is not production. Images were not deleted from S3.</p>
<?php else: ?>
  <p>
    <strong class="ok">✔ <?= number_format($s3_result['deleted']) ?> S3 objects deleted</strong>
    (<?= number_format(count($image_filenames)) ?> images × 5 variants)
  </p>
  <?php if (!empty($s3_result['errors'])): ?>
    <p class="err">⚠ <?= count($s3_result['errors']) ?> S3 error(s):</p>
    <ul>
      <?php foreach (array_slice($s3_result['errors'], 0, 20) as $e): ?>
        <li class="err"><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
      <?php if (count($s3_result['errors']) > 20): ?>
        <li class="err">... and <?= count($s3_result['errors']) - 20 ?> more (check error_log)</li>
      <?php endif; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>

<h3>Table Truncation</h3>
<p>
  <strong class="ok">✔ <?= $success ?> truncated</strong> &nbsp;|&nbsp;
  <strong class="skip">⊘ <?= $skipped ?> skipped</strong> &nbsp;|&nbsp;
  <strong class="err">✖ <?= $errors ?> errors</strong>
</p>
<table>
  <tr><th>Table</th><th>Result</th></tr>
  <?php foreach ($tbl_results as $r): ?>
  <tr>
    <td><code><?= htmlspecialchars($r['table']) ?></code></td>
    <td class="<?= $r['status'] ?>"><?= htmlspecialchars($r['note']) ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<p style="margin-top:24px">
  <a href="<?= ADMIN_PAGE_LINK ?>" style="color:#007bff">← Back to Admin Panel</a>
</p>

<?php endif; ?>

</body>
</html>

<?php
/**
 * admin_reset_truncate_tables.php
 *
 * Step 1 of 2 — truncates all transactional tables only.
 * Fast (< 5s), safe to run through CloudFront.
 *
 * Run Step 2 (S3 image deletion) separately via:
 *   admin_reset_delete_s3_images.php
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
 */

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Access denied.');
}

$tables_to_truncate = [
    'tbl_poster',
    'tbl_poster_live',
    'tbl_poster_images',
    'tbl_poster_images_live',
    'tbl_auction',
    'tbl_auction_live',
    'tbl_auction_archive',
    'tbl_auction_mapping',
    'tbl_auction_week',
    'tbl_auction_calender',
    'tbl_event',
    'tbl_poster_to_category',
    'tbl_poster_to_category_live',
    'tbl_poster_to_subcategory',
    'tbl_poster_to_subcategory_live',
    'tbl_poster_to_shop_category',
    'tbl_poster_to_shop_category_live',
    'tbl_bid',
    'tbl_bid_archive',
    'tbl_proxy_bid',
    'tbl_proxy_bid_live',
    'tbl_offer',
    'tbl_watching',
    'tbl_wantlist',
    'tbl_wantlist_category',
    'tbl_messages',
    'tbl_cart_history',
    'tbl_invoice',
    'tbl_invoice_to_auction',
    'tbl_sold_archive',
    'tbl_mpe_admin_payment_to_seller',
    'tbl_temp',
    'tbl_lossing_temp_table',
    'tbl_pending_bulkuploads',
];

$db        = $GLOBALS['db_connect'];
$confirmed = isset($_POST['confirm']) && $_POST['confirm'] === 'YES_TRUNCATE';

?>
<!DOCTYPE html>
<html>
<head>
<title>Step 1 — Truncate Tables</title>
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
  .btn-danger  { background:#c0392b; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; }
  .btn-next    { background:#007bff; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; margin-left:12px; text-decoration:none; display:inline-block; }
  .btn-cancel  { background:#6c757d; color:#fff; border:none; padding:12px 28px; font-size:15px; border-radius:4px; cursor:pointer; margin-top:14px; margin-left:12px; }
</style>
</head>
<body>

<h2>Step 1 of 2 — Truncate Database Tables</h2>
<p style="color:#555;">Step 2 (S3 image deletion) is on a separate page: <a href="admin_reset_delete_s3_images.php">admin_reset_delete_s3_images.php</a></p>

<?php if (!$confirmed): ?>

<div class="warn">
  <strong>WARNING — This action is irreversible.</strong><br>
  <?= count($tables_to_truncate) ?> database tables will be permanently emptied.
  This does <strong>not</strong> delete S3 images — run Step 2 for that.
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

<h3>Tables that will be truncated:</h3>
<table>
  <tr><th>#</th><th>Table</th><th>Current Row Count</th></tr>
  <?php
  $total_rows = 0;
  foreach ($tables_to_truncate as $i => $tbl) {
      $count  = '<span style="color:#999">N/A — table does not exist</span>';
      $chk = mysqli_query($db, "SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '" . mysqli_real_escape_string($db, $tbl) . "'");
      if ($chk && mysqli_fetch_assoc($chk)['cnt'] > 0) {
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

<form method="post" onsubmit="return confirm('Truncate <?= count($tables_to_truncate) ?> tables? This CANNOT be undone.');">
  <input type="hidden" name="confirm" value="YES_TRUNCATE">
  <button type="submit" class="btn-danger">TRUNCATE ALL TABLES</button>
  <button type="button" class="btn-cancel" onclick="location.href='<?= ADMIN_PAGE_LINK ?>'">Cancel</button>
</form>

<?php else: ?>

<?php
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

<h3>Results</h3>
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

<div class="info" style="margin-top:24px;">
  <strong>Next:</strong> Delete S3 poster images in Step 2.
</div>

<p style="margin-top:16px;">
  <a href="admin_reset_delete_s3_images.php" class="btn-next">Go to Step 2 — Delete S3 Images →</a>
  <a href="<?= ADMIN_PAGE_LINK ?>" style="color:#007bff; margin-left:20px;">← Back to Admin Panel</a>
</p>

<?php endif; ?>

</body>
</html>

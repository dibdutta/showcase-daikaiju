<?php
/**
 * admin_fix_image_orientation.php
 *
 * One-off repair for poster images whose thumbnails came out sideways.
 * Phone photos store pixels unrotated plus an EXIF Orientation flag; browsers
 * honour the flag on the original, but GD ignored it when building thumbnails.
 *
 * Look up an item by auction ID, poster ID or image ID, then for each image:
 *   1. download the original (S3 in production, poster_photo/ locally)
 *   2. bake the EXIF rotation into the pixels (optionally rotate further by hand)
 *   3. regenerate thumbnail, thumb_buy, thumb_buy_gallery, thumb_big_slider
 *   4. upload all five back to the same keys and invalidate CloudFront
 */

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    die('Admin login required.');
}

@ini_set('memory_limit', '512M');
set_time_limit(300);

$db        = $GLOBALS['db_connect'];
$is_prod   = (APP_ENV === 'production');
$s3_bucket = getenv('S3_STATIC_BUCKET') ?: '';
$cf_dist   = getenv('CLOUDFRONT_DIST_ID') ?: '';
$doc_root  = (!empty($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') : '/var/www/html') . '/';

$variants = [
    'original'          => ['prefix' => 'poster_photo/',                   'fn' => null],
    'thumbnail'         => ['prefix' => 'poster_photo/thumbnail/',         'fn' => 'create_thumbnail',                 'w' => 100, 'h' => 100],
    'thumb_buy'         => ['prefix' => 'poster_photo/thumb_buy/',         'fn' => 'create_thumbnail_for_buy',         'w' => 150, 'h' => 150],
    'thumb_buy_gallery' => ['prefix' => 'poster_photo/thumb_buy_gallery/', 'fn' => 'create_thumbnail_for_buy_gallery', 'w' => 200, 'h' => 200],
    'thumb_big_slider'  => ['prefix' => 'poster_photo/thumb_big_slider/',  'fn' => 'create_thumbnail_for_big_slider',  'w' => 570, 'h' => 430],
];

$orientation_labels = [
    1 => 'Normal', 2 => 'Mirrored', 3 => 'Upside down', 4 => 'Mirrored + upside down',
    5 => 'Mirrored + 90° CCW', 6 => 'Sideways (needs 90° CW)', 7 => 'Mirrored + 90° CW', 8 => 'Sideways (needs 90° CCW)',
];

$rotation_choices = [
    'skip' => 'Skip',
    'auto' => 'Auto (use EXIF)',
    '6'    => 'Auto + rotate 90° clockwise',
    '3'    => 'Auto + rotate 180°',
    '8'    => 'Auto + rotate 90° counter-clockwise',
];

$lookup_type = $_REQUEST['lookup_type'] ?? 'auction';
if (!in_array($lookup_type, ['auction', 'poster', 'image'], true)) $lookup_type = 'auction';
$lookup_id   = (int)($_REQUEST['lookup_id'] ?? 0);
$action      = $_POST['action'] ?? '';

/** Find image rows for the lookup, keyed by filename (the S3 key suffix). */
function find_images($db, $type, $id) {
    if ($id <= 0) return [];
    $queries = [];
    if ($type === 'auction') {
        $queries['Fixed price'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_auction a JOIN tbl_poster_images pi ON pi.fk_poster_id = a.fk_poster_id
            LEFT JOIN tbl_poster p ON p.poster_id = a.fk_poster_id WHERE a.auction_id = $id";
        $queries['Live'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_auction_live a JOIN tbl_poster_images_live pi ON pi.fk_poster_id = a.fk_poster_id
            LEFT JOIN tbl_poster_live p ON p.poster_id = a.fk_poster_id WHERE a.auction_id = $id";
    } elseif ($type === 'poster') {
        $queries['Fixed price'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_poster_images pi LEFT JOIN tbl_poster p ON p.poster_id = pi.fk_poster_id WHERE pi.fk_poster_id = $id";
        $queries['Live'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_poster_images_live pi LEFT JOIN tbl_poster_live p ON p.poster_id = pi.fk_poster_id WHERE pi.fk_poster_id = $id";
    } else {
        $queries['Fixed price'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_poster_images pi LEFT JOIN tbl_poster p ON p.poster_id = pi.fk_poster_id
            WHERE pi.poster_image_id = $id OR pi.poster_image LIKE '$id.%'";
        $queries['Live'] = "SELECT pi.poster_image_id, pi.fk_poster_id, pi.poster_image, p.poster_title
            FROM tbl_poster_images_live pi LEFT JOIN tbl_poster_live p ON p.poster_id = pi.fk_poster_id
            WHERE pi.poster_image_id = $id OR pi.poster_image LIKE '$id.%'";
    }

    $images = [];
    foreach ($queries as $source => $sql) {
        $rs = mysqli_query($db, $sql);
        if (!$rs) continue; // e.g. _live tables missing locally
        while ($row = mysqli_fetch_assoc($rs)) {
            $fn = trim($row['poster_image']);
            if (!preg_match('/^[A-Za-z0-9_-]+\.[A-Za-z0-9]+$/', $fn)) continue;
            if (!isset($images[$fn])) {
                $images[$fn] = $row + ['sources' => []];
            }
            $images[$fn]['sources'][] = $source . ' (poster #' . (int)$row['fk_poster_id'] . ')';
        }
    }
    return $images;
}

function get_s3_client() {
    static $s3 = null;
    if ($s3 === null) {
        require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';
        $s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => 'us-east-1']);
    }
    return $s3;
}

/** Copy the stored original to $dest. Returns an error string, or '' on success. */
function fetch_original($fn, $dest) {
    global $is_prod, $s3_bucket, $doc_root;
    if ($is_prod) {
        if (!$s3_bucket) return 'S3_STATIC_BUCKET is not set';
        try {
            get_s3_client()->getObject(['Bucket' => $s3_bucket, 'Key' => 'poster_photo/' . $fn, 'SaveAs' => $dest]);
        } catch (Exception $e) {
            return 'S3 download failed: ' . $e->getMessage();
        }
        return '';
    }
    $src = $doc_root . 'poster_photo/' . $fn;
    if (!is_file($src)) return 'Original not found at ' . $src;
    return copy($src, $dest) ? '' : 'Could not copy ' . $src;
}

function make_work_dir() {
    global $variants;
    $dir = sys_get_temp_dir() . '/orient_fix_' . bin2hex(random_bytes(6));
    foreach ($variants as $name => $v) {
        mkdir($dir . '/' . $name, 0777, true);
    }
    return $dir;
}

function remove_work_dir($dir) {
    if (is_dir($dir)) delete_directory($dir);
}

/** Rotate one image and republish all five variants. Returns [ok, message]. */
function fix_image($fn, $choice) {
    global $variants, $is_prod, $s3_bucket, $doc_root;

    $work = make_work_dir();
    $orig = $work . '/original/' . $fn;
    try {
        $err = fetch_original($fn, $orig);
        if ($err) return [false, $err];

        $exif = getJpegExifOrientation($orig);
        if ($choice === 'auto' && $exif <= 1) {
            return [false, 'No EXIF rotation on this image — nothing to do. Pick a manual rotation if it is still sideways.'];
        }
        $steps = [];
        if ($exif > 1) {
            if (!applyImageOrientation($orig, $exif)) return [false, 'GD could not apply EXIF orientation ' . $exif];
            $steps[] = 'applied EXIF orientation ' . $exif;
        }
        if ($choice !== 'auto') {
            if (!applyImageOrientation($orig, (int)$choice)) return [false, 'GD could not rotate the image'];
            $steps[] = 'rotated ' . ['6' => '90° CW', '3' => '180°', '8' => '90° CCW'][$choice];
        }

        foreach ($variants as $name => $v) {
            if ($v['fn']) call_user_func($v['fn'], $work . '/' . $name, $orig, $fn, $v['w'], $v['h']);
            if (!is_file($work . '/' . $name . '/' . $fn)) return [false, 'Failed to generate ' . $name];
        }

        if ($is_prod) {
            $s3   = get_s3_client();
            $mime = mime_content_type($orig) ?: 'image/jpeg';
            foreach ($variants as $name => $v) {
                $s3->putObject([
                    'Bucket'       => $s3_bucket,
                    'Key'          => $v['prefix'] . $fn,
                    'SourceFile'   => $work . '/' . $name . '/' . $fn,
                    'ContentType'  => $mime,
                    'CacheControl' => 'max-age=31536000',
                ]);
            }
        } else {
            foreach ($variants as $name => $v) {
                $destDir = $doc_root . $v['prefix'];
                if (!is_dir($destDir)) mkdir($destDir, 0777, true);
                if (!copy($work . '/' . $name . '/' . $fn, $destDir . $fn)) return [false, 'Could not write ' . $destDir . $fn];
            }
        }
        return [true, ucfirst(implode(', ', $steps)) . '; regenerated 4 thumbnails and ' . ($is_prod ? 'uploaded 5 files to S3' : 'wrote 5 files locally') . '.'];
    } catch (Exception $e) {
        return [false, 'Error: ' . $e->getMessage()];
    } finally {
        remove_work_dir($work);
    }
}

/** Returns [ok, message]. */
function invalidate_cloudfront($paths) {
    global $cf_dist;
    if (!$cf_dist) return [false, 'CLOUDFRONT_DIST_ID is not set on this container'];
    try {
        require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';
        $cf  = new Aws\CloudFront\CloudFrontClient(['version' => 'latest', 'region' => 'us-east-1']);
        $res = $cf->createInvalidation([
            'DistributionId'    => $cf_dist,
            'InvalidationBatch' => [
                'CallerReference' => 'orient-fix-' . time() . '-' . bin2hex(random_bytes(3)),
                'Paths'           => ['Quantity' => count($paths), 'Items' => $paths],
            ],
        ]);
        return [true, 'Invalidation ' . $res['Invalidation']['Id'] . ' created — CloudFront usually clears within a few minutes.'];
    } catch (Exception $e) {
        return [false, $e->getMessage()];
    }
}

$images  = find_images($db, $lookup_type, $lookup_id);
$results = [];
$cf_result = null;
$cf_paths  = [];

if ($action === 'fix' && $images) {
    foreach ((array)($_POST['rotation'] ?? []) as $fn => $choice) {
        if (!isset($images[$fn]) || $choice === 'skip' || !isset($rotation_choices[$choice])) continue;
        $results[$fn] = fix_image($fn, $choice);
        if ($results[$fn][0]) {
            foreach ($variants as $v) $cf_paths[] = '/' . $v['prefix'] . $fn;
        }
    }
    if ($is_prod && $cf_paths) {
        $cf_result = invalidate_cloudfront($cf_paths);
    }
}

// Read current orientation of each original for the preview table
$preview = [];
if ($images) {
    foreach ($images as $fn => $row) {
        $work = make_work_dir();
        $tmp  = $work . '/original/' . $fn;
        $err  = fetch_original($fn, $tmp);
        $preview[$fn] = $err
            ? ['error' => $err]
            : ['orientation' => getJpegExifOrientation($tmp), 'size' => @getimagesize($tmp)];
        remove_work_dir($work);
    }
}

$h = function ($s) { return htmlspecialchars((string)$s, ENT_QUOTES); };
$cache_bust = '?v=' . time();
?>
<!DOCTYPE html>
<html>
<head>
<title>Fix Poster Image Orientation</title>
<style>
  body   { font-family: Arial, sans-serif; padding: 30px; max-width: 1100px; margin: 0 auto; }
  h2     { margin-bottom: 4px; }
  .muted { color: #666; }
  .info  { background:#d1ecf1; border:1px solid #17a2b8; padding:12px 16px; border-radius:4px; margin:14px 0; }
  .warn  { background:#fff3cd; border:1px solid #ffc107; padding:12px 16px; border-radius:4px; margin:14px 0; }
  .ok    { background:#d4edda; border:1px solid #28a745; padding:12px 16px; border-radius:4px; margin:14px 0; }
  .err   { background:#f8d7da; border:1px solid #dc3545; padding:12px 16px; border-radius:4px; margin:14px 0; }
  table  { border-collapse: collapse; width: 100%; margin-top: 14px; }
  th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: middle; font-size: 13px; }
  th     { background: #f4f4f4; }
  td img { max-width: 200px; max-height: 200px; display: block; }
  .bad   { color: #c0392b; font-weight: bold; }
  .btn   { background:#2c7be5; color:#fff; border:none; padding:10px 22px; font-size:14px; border-radius:4px; cursor:pointer; }
  pre    { white-space: pre-wrap; word-break: break-all; background:#f8f9fa; padding:10px; border:1px solid #ddd; }
  input[type=number] { width: 120px; padding: 6px; }
  select { padding: 6px; }
</style>
</head>
<body>

<h2>Fix Poster Image Orientation</h2>
<p class="muted">Repairs sideways thumbnails: rotates the original to match its EXIF orientation and regenerates all four thumbnails.
  Environment: <strong><?= $h(APP_ENV) ?></strong><?= $is_prod ? ' — files go to S3 bucket <code>' . $h($s3_bucket) . '</code>' : ' — files are written to poster_photo/ on disk' ?>.</p>

<form method="get">
  <select name="lookup_type">
    <option value="auction" <?= $lookup_type === 'auction' ? 'selected' : '' ?>>Item / Auction ID</option>
    <option value="poster"  <?= $lookup_type === 'poster'  ? 'selected' : '' ?>>Poster ID</option>
    <option value="image"   <?= $lookup_type === 'image'   ? 'selected' : '' ?>>Image ID (e.g. 1023 from …/poster_photo/1023.jpg)</option>
  </select>
  <input type="number" name="lookup_id" min="1" value="<?= $lookup_id ?: '' ?>" required>
  <button type="submit" class="btn">Look up</button>
</form>

<?php foreach ($results as $fn => [$ok, $msg]): ?>
  <div class="<?= $ok ? 'ok' : 'err' ?>"><strong><?= $h($fn) ?>:</strong> <?= $h($msg) ?></div>
<?php endforeach; ?>

<?php if ($cf_paths && $is_prod): ?>
  <?php if ($cf_result && $cf_result[0]): ?>
    <div class="ok"><?= $h($cf_result[1]) ?></div>
  <?php else: ?>
    <div class="warn">
      <strong>CloudFront was not invalidated</strong> (<?= $h($cf_result[1] ?? '') ?>). The CDN keeps serving the old sideways files
      for up to 30 days until you clear them. Run this from a machine with AWS access:
      <pre>aws cloudfront create-invalidation --distribution-id &lt;CLOUDFRONT_DIST_ID&gt; --paths <?= $h(implode(' ', $cf_paths)) ?></pre>
    </div>
  <?php endif; ?>
  <div class="info">Browsers that already loaded these images may keep a cached copy; a hard refresh (Ctrl/Cmd+Shift+R) shows the new version.</div>
<?php endif; ?>

<?php if ($lookup_id && !$images): ?>
  <div class="warn">No images found for <?= $h($lookup_type) ?> ID <?= $lookup_id ?>.</div>
<?php elseif ($images): ?>
  <form method="post" onsubmit="return confirm('Overwrite the selected images and all their thumbnails?');">
    <input type="hidden" name="action" value="fix">
    <input type="hidden" name="lookup_type" value="<?= $h($lookup_type) ?>">
    <input type="hidden" name="lookup_id" value="<?= $lookup_id ?>">
    <table>
      <tr>
        <th>Image</th><th>Original</th><th>Gallery thumbnail (current)</th><th>EXIF orientation</th><th>Action</th>
      </tr>
      <?php foreach ($images as $fn => $row): $p = $preview[$fn]; ?>
      <tr>
        <td>
          <strong><?= $h($fn) ?></strong><br>
          <?= $h($row['poster_title'] ?? '') ?><br>
          <span class="muted"><?= $h(implode(', ', $row['sources'])) ?></span>
        </td>
        <td><a href="<?= $h(CLOUD_POSTER . $fn . $cache_bust) ?>" target="_blank"><img src="<?= $h(CLOUD_POSTER . $fn . $cache_bust) ?>" alt=""></a></td>
        <td><img src="<?= $h(CLOUD_POSTER_THUMB_BUY_GALLERY . $fn . $cache_bust) ?>" alt=""></td>
        <td>
          <?php if (isset($p['error'])): ?>
            <span class="bad"><?= $h($p['error']) ?></span>
          <?php else: ?>
            <span class="<?= $p['orientation'] > 1 ? 'bad' : '' ?>"><?= $p['orientation'] ?> — <?= $h($orientation_labels[$p['orientation']]) ?></span><br>
            <span class="muted">Stored pixels: <?= (int)$p['size'][0] ?>×<?= (int)$p['size'][1] ?></span>
          <?php endif; ?>
        </td>
        <td>
          <?php if (!isset($p['error'])): ?>
          <select name="rotation[<?= $h($fn) ?>]">
            <?php $default = $p['orientation'] > 1 ? 'auto' : 'skip'; ?>
            <?php foreach ($rotation_choices as $val => $label): ?>
              <option value="<?= $h($val) ?>" <?= $val === $default ? 'selected' : '' ?>><?= $h($label) ?></option>
            <?php endforeach; ?>
          </select>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <p class="muted">"Auto" bakes in the EXIF rotation so the image looks the way the original does in your browser.
      The manual options rotate further from that view; use them only if the original itself looks wrong.</p>
    <button type="submit" class="btn">Fix selected images</button>
  </form>
<?php endif; ?>

</body>
</html>

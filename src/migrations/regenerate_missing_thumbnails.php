<?php
/**
 * Regenerates missing S3 thumbnail variants for poster images.
 *
 * For each original at poster_photo/<filename>, checks whether the four
 * thumbnail variants exist in S3. Any that are missing are generated from
 * the original using GD and uploaded to S3.
 *
 * Run via: /admin/admin_run_migration.php (requires admin login)
 * Or directly inside the ECS container: php migrations/regenerate_missing_thumbnails.php
 */

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';
require_once 'AWS/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$s3Bucket = getenv('S3_STATIC_BUCKET');
if (!$s3Bucket) {
    die("S3_STATIC_BUCKET env var not set — run this in the ECS container.\n");
}

$s3 = new S3Client(['version' => 'latest', 'region' => 'us-east-1']);

$variants = [
    'poster_photo/thumbnail/'         => [100, 100],
    'poster_photo/thumb_buy/'         => [150, 150],
    'poster_photo/thumb_buy_gallery/' => [200, 200],
    'poster_photo/thumb_big_slider/'  => [570, 430],
];

$tmpDir = sys_get_temp_dir() . '/thumb_regen_' . getmypid() . '/';
mkdir($tmpDir, 0777, true);

$processed = 0;
$skipped   = 0;
$errors    = 0;

// List all originals under poster_photo/ (not in sub-prefixes)
$paginator = $s3->getPaginator('ListObjectsV2', [
    'Bucket'    => $s3Bucket,
    'Prefix'    => 'poster_photo/',
    'Delimiter' => '/',   // only top-level objects, no sub-prefixes
]);

$originals = [];
foreach ($paginator as $page) {
    foreach ($page['Contents'] ?? [] as $obj) {
        $key = $obj['Key'];
        // Skip the folder placeholder itself
        if ($key === 'poster_photo/') continue;
        $originals[] = basename($key);
    }
}

echo "Found " . count($originals) . " originals to check.\n";

foreach ($originals as $fileName) {
    $originalKey = 'poster_photo/' . $fileName;
    $missing = [];
    foreach ($variants as $prefix => $_) {
        $variantKey = $prefix . $fileName;
        try {
            $s3->headObject(['Bucket' => $s3Bucket, 'Key' => $variantKey]);
        } catch (S3Exception $e) {
            if ($e->getStatusCode() === 404 || $e->getStatusCode() === 403) {
                $missing[] = $prefix;
            } else {
                throw $e;
            }
        }
    }

    if (empty($missing)) {
        $skipped++;
        continue;
    }

    echo "Regenerating " . count($missing) . " variant(s) for $fileName … ";

    // Download original from S3
    $localOriginal = $tmpDir . $fileName;
    try {
        $s3->getObject([
            'Bucket' => $s3Bucket,
            'Key'    => $originalKey,
            'SaveAs' => $localOriginal,
        ]);
    } catch (S3Exception $e) {
        echo "SKIP (download failed: " . $e->getMessage() . ")\n";
        $errors++;
        continue;
    }

    $mime = mime_content_type($localOriginal) ?: 'image/jpeg';
    $size = @getimagesize($localOriginal);
    if (!$size) {
        echo "SKIP (not a valid image)\n";
        unlink($localOriginal);
        $errors++;
        continue;
    }

    foreach ($missing as $prefix) {
        [$targetW, $targetH] = $variants[$prefix];
        $localVariant = $tmpDir . $prefix . $fileName;
        @mkdir(dirname($localVariant), 0777, true);

        if (_resizeImage($localOriginal, $localVariant, $targetW, $targetH, $size)) {
            try {
                $s3->putObject([
                    'Bucket'       => $s3Bucket,
                    'Key'          => $prefix . $fileName,
                    'SourceFile'   => $localVariant,
                    'ContentType'  => $mime,
                    'CacheControl' => 'max-age=31536000',
                ]);
                echo "uploaded $prefix … ";
            } catch (S3Exception $e) {
                echo "UPLOAD_FAILED($prefix: " . $e->getMessage() . ") … ";
                $errors++;
            }
            unlink($localVariant);
        } else {
            echo "RESIZE_FAILED($prefix) … ";
            $errors++;
        }
    }

    unlink($localOriginal);
    $processed++;
    echo "done\n";
}

// Clean up tmp dir
@rmdir($tmpDir . 'poster_photo/thumbnail/');
@rmdir($tmpDir . 'poster_photo/thumb_buy/');
@rmdir($tmpDir . 'poster_photo/thumb_buy_gallery/');
@rmdir($tmpDir . 'poster_photo/thumb_big_slider/');
@rmdir($tmpDir . 'poster_photo/');
@rmdir($tmpDir);

echo "\nDone. Processed: $processed, Already complete: $skipped, Errors: $errors\n";


function _resizeImage(string $src, string $dest, int $targetW, int $targetH, array $size): bool
{
    [$origW, $origH, $type] = $size;

    $srcImg = match ($type) {
        IMAGETYPE_JPEG => imagecreatefromjpeg($src),
        IMAGETYPE_PNG  => imagecreatefrompng($src),
        IMAGETYPE_GIF  => imagecreatefromgif($src),
        IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($src) : false,
        default        => false,
    };
    if (!$srcImg) return false;

    // Maintain aspect ratio, fit within targetW × targetH
    $ratio = min($targetW / $origW, $targetH / $origH);
    $newW  = (int) round($origW * $ratio);
    $newH  = (int) round($origH * $ratio);

    $dstImg = imagecreatetruecolor($newW, $newH);

    // Preserve transparency for PNG/GIF
    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
        $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
        imagefilledrectangle($dstImg, 0, 0, $newW, $newH, $transparent);
    }

    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

    $ok = match ($type) {
        IMAGETYPE_JPEG => imagejpeg($dstImg, $dest, 90),
        IMAGETYPE_PNG  => imagepng($dstImg, $dest),
        IMAGETYPE_GIF  => imagegif($dstImg, $dest),
        IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($dstImg, $dest) : false,
        default        => false,
    };

    imagedestroy($srcImg);
    imagedestroy($dstImg);
    return (bool) $ok;
}

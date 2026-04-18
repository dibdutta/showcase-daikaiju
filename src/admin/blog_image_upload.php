<?php
/**
 * FCKeditor/CKEditor image upload endpoint.
 * In production: streams the file to S3, returns a CloudFront URL.
 * Locally: saves to userfiles/image/ on the local filesystem.
 * Returns JSON: { uploaded, fileName, url } or { uploaded:0, error:{ message } }
 */
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

header('Content-Type: application/json');

if (!isset($_SESSION['adminLoginID'])) {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Unauthorised']]);
    exit;
}

if (empty($_FILES['upload']['tmp_name'])) {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'No file received']]);
    exit;
}

$ext     = strtolower(pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
if (!in_array($ext, $allowed)) {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'File type not allowed. Use JPG, PNG, GIF or WebP.']]);
    exit;
}

$filename = 'blog_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
$mimeMap  = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp'];
$mimeType = $mimeMap[$ext] ?? 'image/jpeg';

if (APP_ENV === 'production') {
    require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';

    $s3Bucket = getenv('S3_STATIC_BUCKET');
    $cdnBase  = getenv('CDN_STATIC_URL') ?: 'https://d294w6g1afjpvs.cloudfront.net';

    if (!$s3Bucket) {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'S3_STATIC_BUCKET not configured']]);
        exit;
    }

    try {
        $s3 = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
        ]);

        $s3->putObject([
            'Bucket'       => $s3Bucket,
            'Key'          => 'blog-images/' . $filename,
            'SourceFile'   => $_FILES['upload']['tmp_name'],
            'ContentType'  => $mimeType,
            'CacheControl' => 'max-age=31536000',
        ]);

        $url = rtrim($cdnBase, '/') . '/blog-images/' . $filename;
        echo json_encode(['uploaded' => 1, 'fileName' => $filename, 'url' => $url]);
    } catch (Exception $e) {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'S3 upload failed: ' . $e->getMessage()]]);
    }
} else {
    $uploadDir = dirname(__FILE__) . '/../userfiles/image/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['upload']['tmp_name'], $uploadDir . $filename)) {
        $err = error_get_last();
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Failed to save file: ' . ($err['message'] ?? 'unknown')]]);
        exit;
    }

    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/userfiles/image/' . $filename;
    echo json_encode(['uploaded' => 1, 'fileName' => $filename, 'url' => $url]);
}

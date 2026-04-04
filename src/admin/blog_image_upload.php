<?php
/**
 * CKEditor image upload endpoint.
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

// Use dirname(__FILE__) — always resolves correctly regardless of DOCUMENT_ROOT config
$uploadDir = dirname(__FILE__) . '/../userfiles/image/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filename = 'blog_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
$destPath = $uploadDir . $filename;

if (!move_uploaded_file($_FILES['upload']['tmp_name'], $destPath)) {
    $err = error_get_last();
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Failed to save file: ' . ($err['message'] ?? 'unknown')]]);
    exit;
}

$url = 'https://' . $_SERVER['HTTP_HOST'] . '/userfiles/image/' . $filename;
echo json_encode([
    'uploaded' => 1,
    'fileName' => $filename,
    'url'      => $url,
]);

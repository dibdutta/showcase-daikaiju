<?php
/**
 * CKEditor Simple Upload Adapter endpoint for blog images.
 * Called via XHR — returns JSON { uploaded, fileName, url, error { message } }
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
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'File type not allowed']]);
    exit;
}

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/userfiles/image/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filename = 'blog_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
if (!move_uploaded_file($_FILES['upload']['tmp_name'], $uploadDir . $filename)) {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Failed to save file']]);
    exit;
}

$url = 'http://' . $_SERVER['HTTP_HOST'] . '/userfiles/image/' . $filename;
echo json_encode([
    'uploaded'  => 1,
    'fileName'  => $filename,
    'url'       => $url,
]);

<?php
//ini_set('display_errors','on');
//error_reporting(E_ALL);
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
require(INCLUDE_PATH."lib/configures.php");
require(INCLUDE_PATH."lib/cloudfiles/cloudfiles.php");
$sql="SELECT
  tpi.poster_thumb,
  tpi.fk_poster_id
FROM tbl_poster p,
  tbl_poster_images tpi,
  tbl_auction a
WHERE a.fk_auction_type_id = 1
    AND a.auction_is_approved = '1'
    AND a.auction_is_sold = '0'
    AND a.fk_poster_id = p.poster_id
    AND p.poster_id = tpi.fk_poster_id
    LIMIT 1388,500";
$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
try{
while($row = mysqli_fetch_array($resSql)){
    $originalImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/".$row['poster_thumb'];
    $thumbImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumbnail/".$row['poster_thumb'];
    $thumbBuyImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumb_buy/".$row['poster_thumb'];
    $thumbBuyGalleryImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumb_buy_gallery/".$row['poster_thumb'];
    // Connect to Rackspace
    $auth = new CF_Authentication(CLOUD_API_USERNAME, CLOUD_API_PASSWORD);
    $auth->authenticate();
    $conn = new CF_Connection($auth);

    //Upload original image
    $container = $conn->get_container("cloud_test_original");
    $object = $container->create_object($row['poster_thumb']);
    $object->load_from_filename($originalImage);
    echo $object->public_uri();

    //Upload thumb image
    $container = $conn->get_container("cloud_test_thumbnail");
    $object = $container->create_object($row['poster_thumb']);
    $object->load_from_filename($thumbImage);
    echo $object->public_uri();

    //Upload thumbbuy image
    $container = $conn->get_container("cloud_test_thumb_buy_list");
    $object = $container->create_object($row['poster_thumb']);
    $object->load_from_filename($thumbBuyImage);
    echo $object->public_uri();

    //Upload thumbbuy gallery image
    $container = $conn->get_container("cloud_test_thumb_buy_gallery");
    $object = $container->create_object($row['poster_thumb']);
    $object->load_from_filename($thumbBuyGalleryImage);
}
}catch(Exception $e){
   print_r($e->getTrace());
}
?>
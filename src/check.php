<?php
	define ("DB_SERVER", "50.57.132.111");
	define ("DB_NAME", "mpe");
	define ("DB_USER", "geotech");
	define ("DB_PASSWORD", "Hello@4321");
	$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("Cannot connect DB Server!");
	$link=mysqli_select_db($connect, DB_NAME) or die("Cannot find database!");
$sql=mysqli_query($GLOBALS['db_connect'],"select * from tbl_poster_images order by poster_image_id asc");
$string='<table width="100%" border="2">';
$string.='<tr><td>Image Id</td><td>Auction Id</td><td>Image Name</td><td>Poster Id</td></tr>';
while($arr=mysqli_fetch_array($sql))
{
$extarr=explode(".",$arr['poster_image']);
 $fname=$extarr['0'];
 $ext=$extarr['1'];
//echo $filename=$arr['poster_image_id'].'.'.$arr['FileExtention'];
if($arr['poster_image_id']!=$fname)
{
$aqry=mysqli_query($GLOBALS['db_connect'],"select auction_id from tbl_auction where fk_poster_id='".$arr['fk_poster_id']."'");
$auction=mysqli_fetch_array($aqry);
 $string.='<tr><td>'.$arr['poster_image_id'].'</td><td>'.$auction['auction_id'].'</td><td>'.$arr['poster_image'].'</td><td>'.$arr['fk_poster_id'].'</td></tr>';


 $orgname=$arr['poster_image'];

$filename=$arr['poster_image_id'].".".$ext;
 $filepath = "./poster_photo/".$arr['poster_image'];

/*if (file_exists($filepath)) {
$st=rename("./poster_photo/".$arr['poster_image'],"./poster_photo/".$filename);

}
$filepath1="./poster_photo/thumb_buy_gallery/".$arr['poster_image'];
if (file_exists($filepath1)) {
rename("./poster_photo/thumb_buy_gallery/".$arr['poster_image'],"./poster_photo/thumb_buy_gallery/".$filename);
}
$filepath2="./poster_photo/thumbnail/".$arr['poster_image'];
if (file_exists($filepath2)) {
rename("./poster_photo/thumbnail/".$arr['poster_image'], "./poster_photo/thumbnail/".$filename) ;
}
$filepath3="./poster_photo/thumb_buy/".$arr['poster_image'];
if (file_exists($filepath3)) {
rename("./poster_photo/thumb_buy/".$arr['poster_image'], "./poster_photo/thumb_buy/".$filename);
}
$updateqry=mysqli_query($GLOBALS['db_connect'],"update tbl_poster_images set  poster_image='".$filename."',poster_thumb='".$filename."',original_filename='".$orgname."',FileExtention='".$ext."' where  poster_image_id='".$arr['poster_image_id']."'");*/

}
}
  $string.='</table>';
  echo $string;
  die();
  $fp = fopen("nonmatching_images.doc", 'w+');
 
 
 
   fwrite($fp, $string);
   fclose($fp);
   //header('location:nonmatching_images.doc');
?>
<script type="text/javascript">
window.location='nonmatching_images.doc';
</script>


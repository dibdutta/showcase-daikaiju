<?php
include_once("../lib/configures.php");
error_reporting(E_ALL ^ E_NOTICE);
$Uniquekey=md5(date('Y-m-d H:i:s'));
    function formatbytes($file, $type)  
    {  
        switch($type){  
            case "KB":  
                $filesize = filesize($file) * .0009765625; // bytes to KB  
            break;  
            case "MB":  
                $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB  
            break;  
            case "GB":  
                $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB  
            break;  
        }  
        if($filesize <= 0){  
            return $filesize = 'unknown file size';}  
        else{return round($filesize, 2);}  
    }  
if(isset($_REQUEST['imgurl']))
{
ob_start();
session_start();
ob_end_clean();
//$url = 'http://www.movieposterexchange.com/poster_photo/thumb_buy/1074.jpg';
$url=$_REQUEST['imgurl'];
$urlarr=explode(".",$_REQUEST['imgurl']);
$urlarr=array_reverse($urlarr);
$ext=$urlarr[0];
$ext=strtolower($ext);
if($ext=='jpg' || $ext=='gif' || $ext=='png')
{
$path=$_SERVER['DOCUMENT_ROOT'].'/poster_photo/temp/'.$_SESSION['random'].'/';
if(!is_dir($path))
{
mkdir(str_replace('//','/',$path), 0755, true);
}

$nm=mt_rand();
$img = '../poster_photo/temp/'.$_SESSION['random'].'/'.$nm.'.'.$ext;
@$data=file_get_contents($url);
if($data)
{
file_put_contents($img, $data);
$imgname=$nm.'.'.$ext;
$size= formatbytes($img, "MB"); 
if($size < 2)
{
$_SESSION['img'][]=$imgname;
//print_r($_SESSION['img']);
$i=1;
foreach($_SESSION['img'] as $k => $imgnm)
{
if($imgnm==$imgname)
{
if($i<13)
{
?>

<div style="float:left; width: 110px; padding: 0px 2px 0pt 1px; margin: 0px;" id="photou_<?php echo $Uniquekey;?>"><img height="78" width="100" src="../poster_photo/temp/<?php echo $_SESSION['random'];?>/<?php echo $imgnm;?>" style="border: 3px solid rgb(71, 70, 68);"><input type="radio" <?php if($_REQUEST['mode']!='edit'){?> checked="checked" <?php } ?> value="<?php echo $imgnm;?>" name="is_default"><br><img onClick="deletePhoto('photou_<?php echo $Uniquekey;?>', '<?php echo $imgnm;?>', 'new','<?php echo $k;?>')" src="<?php echo CLOUD_STATIC; ?>delete-icon.png"></div>

<?php
}
else{
?>
<script type="text/javascript">
alert("Maximum fileupload limit exceeds.");
document.getElementByID("path").style.display="none";
</script>

<?php
}

}
$i++;
}
}
else{
?>
<script type="text/javascript">
alert("Please provide image below 2 MB.");</script>
<?php
}
}
else
{
?>
<script type="text/javascript">
alert("Please provide a proper image path.");</script>
<?php
}
}
else{
?>
<script type="text/javascript">
alert("Please provide a proper image path.");</script>
<?php
//$_SESSION['error'][]='<span style="color:#FF0000; font-size:9px;" id="alrt">Please provide a proper image path.</span>';
/*if(count($_SESSION['error']) < 2)
{
echo $_SESSION['error'][0];
}*/
}
}?>
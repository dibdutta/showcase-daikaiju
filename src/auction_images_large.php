<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();

define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
chkLoginNow();
if($_REQUEST['mode'] == "auction_images_large"){
    auction_images_large();
}else{
    images_next();
}

ob_end_flush();

////////////   For page content 
function auction_images_large(){
	 require_once INCLUDE_PATH . "lib/common.php";
	 $poster_id = $_REQUEST['id'] ?? null;
	 $auction_id = $_REQUEST['auction_id'] ?? null;
	 $objauction= new Auction();
	 $count = $auction_id ? $objauction->isLiveAuctionItem($auction_id) : 0;
	 
	 if($count<1){
	 	 $objposter = new Poster();
		 $poster_arr = $objposter->selectAllPostersById($poster_id);
		 
		 $total_images=count($poster_arr);
		 
		 $smarty->assign('total_images',$total_images);
		 
		 $smarty->assign('poster_id',$poster_id);
		 //print_r($poster_arr);
		
		if(isset($_REQUEST['page_index'])) {
			$page_index = $_REQUEST['page_index'];
		}else{
			$page_index = 0;
		}
		
		if($page_index == 0){
			$sql_next = "Select poster_image,is_cloud from tbl_poster_images where fk_poster_id='".$poster_id."' and is_default='1' limit $page_index,1";
		}else{
			$page_index = $page_index-1;	
			$sql_next = "Select poster_image,is_cloud from tbl_poster_images where fk_poster_id='".$poster_id."' and is_default<>'1' limit $page_index,1";	
		}
	
		$rs = mysqli_query($GLOBALS['db_connect'],$sql_next);
		while($row = mysqli_fetch_assoc($rs)){
			$imgArr[] = $row;
		}
	 }else{
	 	 $objposter = new Poster();
	 	 $poster_arr = $objposter->selectAllPostersByIdLive($poster_id);
		 
		  $total_images=count($poster_arr);
		
		  $smarty->assign('total_images',$total_images);
		 
		  $smarty->assign('poster_id',$poster_id);
		 //print_r($poster_arr);
		
			if(isset($_REQUEST['page_index'])) {
				$page_index = $_REQUEST['page_index'];
			}else{
				$page_index = 0;
			}
		  	if($page_index == 0){
				$sql_next = "Select poster_image,is_cloud from tbl_poster_images_live where fk_poster_id='".$poster_id."' and is_default='1' limit $page_index,1";
			}else{
				$page_index = $page_index-1;	
				$sql_next = "Select poster_image,is_cloud from tbl_poster_images_live where fk_poster_id='".$poster_id."' and is_default<>'1' limit $page_index,1";	
			}	
			
			$rs = mysqli_query($GLOBALS['db_connect'],$sql_next);
			while($row = mysqli_fetch_assoc($rs)){
				$imgArr[] = $row;
			}
	 }
	 
    if ($imgArr[0]['is_cloud'] !='1'){
        list($width, $height, $type, $attr) = getimagesize("poster_photo/".$imgArr[0]['poster_image']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $imgArr[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/".$imgArr[0]['poster_image'];
    }else{
        list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$imgArr[0]['poster_image']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $imgArr[0]['image_path']=CLOUD_POSTER.$imgArr[0]['poster_image'];
    }
	if($width>1300){
		$widthNew= 1300;
	}elseif($width>1100){
		$widthNew= 1100;
	}elseif($width>1000){
		$widthNew= 1000;
	}
	else{
		###3 Earlier set at 800 , after Peter's mail moved to 900
		//$widthNew=800;
		$widthNew=800;
	}
	$smarty->assign('imgArr',$imgArr);
	$smarty->assign('widthNew',$widthNew);
	
	 $smarty->display("auction_images_large.tpl"); 
}
function images_next(){
	require_once INCLUDE_PATH . "lib/common.php";
	$poster_id = $_REQUEST['poster_id'];
	$page_index = $_REQUEST['page_index'];
	if($page_index == 0){
		$sql_next = "Select poster_image from tbl_poster_images where fk_poster_id='".$poster_id."' and is_default='1' limit $page_index,1";
	}else{
		$page_index = $page_index-1;	
		$sql_next = "Select poster_image from tbl_poster_images where fk_poster_id='".$poster_id."' and is_default<>'1' limit $page_index,1";	
	}

	$rs = mysqli_query($GLOBALS['db_connect'],$sql_next);
	while($row = mysqli_fetch_assoc($rs)){
		$imgArr[] = $row;
	}
    if (file_exists("poster_photo/" . $imgArr[0]['poster_image'])){
        list($width, $height, $type, $attr) = getimagesize("poster_photo/".$imgArr[0]['poster_image']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $imgArr[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/".$imgArr[0]['poster_image'];
    }else{
        list($width, $height, $type, $attr) = getimagesize(CLOUD_POSTER.$imgArr[0]['poster_image']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $imgArr[0]['image_path']=CLOUD_POSTER.$imgArr[0]['poster_image'];
    }
	
	$smarty->assign('imgArr',$imgArr);
	$smarty->display("auction_images_next.tpl"); 		   

 }
?>
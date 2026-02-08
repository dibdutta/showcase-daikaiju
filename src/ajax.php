<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
define ("INCLUDE_PATH", "");
require_once INCLUDE_PATH."lib/inc.php";

if($_REQUEST['mode'] == "delete_poster"){
	delete_poster();
}elseif($_REQUEST['mode']=="autocomplete"){
	autocomplete();
}elseif($_REQUEST['mode']=="autocomplete_admin"){
	autocomplete_admin();
}elseif($_REQUEST['mode']=="time_left"){
	time_left();
}elseif($_REQUEST['mode']=="server_time"){
	server_time();
}elseif($_REQUEST['mode']=="autocomplete_want"){
	autocomplete_want();
}elseif($_REQUEST['mode']=="delete_session"){
    delete_session();
}elseif($_REQUEST['mode']=="chkcart"){
    chkcart();
}elseif($_REQUEST['mode']=="clearSession"){
    clearSession();
}elseif($_REQUEST['mode']=="chk_auction_week"){
    chk_auction_week();
}elseif($_REQUEST['mode']=="chkQuantity"){
    chkQuantity();
}elseif($_REQUEST['mode']=='updateSession'){
	updateSession();
}elseif($_REQUEST['mode']=='get_cond_desc'){
	get_cond_desc();
}elseif($_REQUEST['mode']=='chk_item_type'){
	chk_item_type();
}elseif($_REQUEST['mode']=='logoutInactiveUser'){
	logoutInactiveUser();
}elseif($_REQUEST["mode"]=='update_exetended_items_endtime' ){
	update_exetended_items_endtime();
}

function delete_poster(){
	extract($_REQUEST);
	$posterObj = new Poster();
	if($type == "existing"){
		$posterObj->primaryKey = 'fk_poster_id';
		if($key=='weekly'){
			$count = $posterObj->countData('tbl_poster_images_live', array("fk_poster_id" => $poster_id));
		}else{
			$count = $posterObj->countData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id));
			}
		if($count > 1){
			if($key=='weekly'){
				if($posterObj->deleteData('tbl_poster_images_live', array("poster_thumb" => $poster_image))){
					$resDataposter = $posterObj->selectData('tbl_poster_images_live',array('poster_image_id'), array("fk_poster_id" => $poster_id,"is_default" => 1));
					if(!empty($resDataposter)){
						$posterObj->updateData('tbl_poster_images_live',array("is_default" => 0), array("fk_poster_id" => $poster_id ,"poster_image_id"=>$resDataposter[0]['poster_image_id']),true);	
					}
					$resData = $posterObj->selectData('tbl_poster_images_live',array('*'), array("fk_poster_id" => $poster_id));
					$posterObj->updateData('tbl_poster_images_live',array("is_default" => 1),array("fk_poster_id" => $poster_id ,"poster_thumb"=>$resData[0]['poster_thumb']),true);
					$posterThumb = "poster_photo/".$poster_image;
					$posterLarge = "poster_photo/thumbnail/".$poster_image;
					@unlink($posterThumb);
					@unlink($posterLarge);
					echo "done";
				}else{
					echo "none";
				}
			}else{				
				if($posterObj->deleteData(TBL_POSTER_IMAGES, array("poster_thumb" => $poster_image))){
					$resDataposter = $posterObj->selectData(TBL_POSTER_IMAGES,array('poster_image_id'), array("fk_poster_id" => $poster_id,"is_default" => 1));
					if(!empty($resDataposter)){
						$posterObj->updateData(TBL_POSTER_IMAGES,array("is_default" => 0), array("fk_poster_id" => $poster_id ,"poster_image_id"=>$resDataposter[0]['poster_image_id']),true);	
					}
					$resData = $posterObj->selectData(TBL_POSTER_IMAGES,array('*'), array("fk_poster_id" => $poster_id));
					$posterObj->updateData(TBL_POSTER_IMAGES,array("is_default" => 1),array("fk_poster_id" => $poster_id ,"poster_thumb"=>$resData[0]['poster_thumb']),true);
					$posterThumb = "poster_photo/".$poster_image;
					$posterLarge = "poster_photo/thumbnail/".$poster_image;
					@unlink($posterThumb);
					@unlink($posterLarge);
					echo "done";
				}else{
					echo "none";
				}
			
			}
		}else{
			echo "invalid_request";
		}
	}else{
		$posterTemp = "poster_photo/temp/".$_SESSION['random']."/".$poster_image;
		if(isset($_SESSION['img']))
		{
		if($key!='')
		{
		unset($_SESSION['img'][$key]);
		array_filter($_SESSION['img']);
		}
		}
		if(@unlink($posterTemp)){
			echo "done";
		}else{
			echo "none";
		}
	}
}

function autocomplete(){
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	$sql = mysqli_query($GLOBALS['db_connect'],"Select p.poster_title from ".TBL_POSTER." as p,".TBL_AUCTION." as a where (p.poster_title like '%".mysqli_real_escape_string($GLOBALS['db_connect'],$q)."%' OR p.poster_desc like '%".mysqli_real_escape_string($GLOBALS['db_connect'],$q)."%')  and a.fk_poster_id=p.poster_id and a.auction_is_approved='1' group by p.poster_title");
	$items=array();
	$i=0;
	if($sql){
		while($res=mysqli_fetch_array($sql)){
			array_push($items,$res['poster_title']);
			echo $items[$i]."\n";
			$i++;
		}
	}
}

function time_left()
{
    extract($_REQUEST);
    if(isset($list) && $list!=''){
       $list=  $_REQUEST['list'];
    }else{
       $list='' ;
    }
    if($list!='weekly' && $list!='fixed' && $list!='stills' && $list!='details' ){
        $auctionObj = new Auction();
        $data = $auctionObj->instantUpdateOfferAuction($ids,'');
    }elseif($list=='fixed'){
        //$rs=mysqli_query($GLOBALS['db_connect'],"CALL myOfferSP('".$ids."',',')");
        //while($row = mysqli_fetch_array($rs)){
           // $data[] = $row;
        //}
		$auctionObj = new Auction();
	    $data = $auctionObj->instantUpdateOfferAuction($ids,$list);
    }elseif($list=='weekly'){
        $rs=mysqli_query($GLOBALS['db_connect'],"CALL spGetAuction('".$ids."',',')");
		if($rs){
			while($row = mysqli_fetch_assoc($rs)){
				$row["current_time"] = date("Y-m-d H:i:s");
				$data[] = $row;
				
			}
		}
		
        /*$sql = "SELECT a.auction_id,a.auction_asked_price, a.fk_auction_type_id, a.auction_is_sold, a.auction_actual_end_datetime,
                    (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
                    MAX(b.bid_id) AS last_bid_id, COUNT(b.bid_id) AS bid_count,	MAX(b.bid_amount) AS last_bid_amount,highest_user(a.auction_id) as highest_user
                    FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_BID." b ON a.auction_id = b.bid_fk_auction_id
                    WHERE a.auction_id IN ($ids)
                    GROUP BY a.auction_id";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            while($row = mysqli_fetch_assoc($rs)){
                $data[] = $row;
            }
        }*/
    }elseif($list=='details'){
			$rs=mysqli_query($GLOBALS['db_connect'],"CALL spGetAuction('".$ids."',',')");
			if($rs){
				while($row = mysqli_fetch_array($rs)){
					$data[] = $row;
				}
			}
		}elseif($list=='stills'){
        $auctionObj = new Auction();
	    $data = $auctionObj->instantUpdateOfferAuction($ids,$list);
        
    }
	if(isset($data) && count($data)>0){
		for($i=0;$i<count($data);$i++){
			
	
			if($data[$i]['fk_auction_type_id'] != 1 && $data[$i]['auction_is_sold'] == '0' && $data[$i]['bid_count'] > 0 && $data[$i]['seconds_left'] <= 0){
				$data[$i]['auction_is_sold'] = 1;
				$data[$i]['bid_is_won'] = 1;
				$data[$i]['auction_is_closed']= 1;
			}
			$data[$i]['actual_end_time'] = date('h:i:s A', strtotime($data[$i]['auction_actual_end_datetime']));
			$data[$i]['actual_end_day'] = date('l', strtotime($data[$i]['auction_actual_end_datetime']));
			$data[$i]['actual_end_date'] = date('m/d/Y', strtotime($data[$i]['auction_actual_end_datetime']));
			if(isset($data[$i]['bid_count']) && $data[$i]['bid_count']==0){
				$data[$i]['next_increment']=increment_amount($data[$i]['auction_asked_price']);
			}else{
				if(isset($data[$i]['last_bid_amount'])){
					$data[$i]['next_increment']=increment_amount($data[$i]['last_bid_amount']);
					}
			}
		}
		$json_arr = json_encode($data);
		echo $json_arr;
	}
		
}
function autocomplete_want(){
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	$sql = mysqli_query($GLOBALS['db_connect'],"Select p.poster_title from ".TBL_POSTER." as p,".TBL_AUCTION." as a where (p.poster_title like '%".mysqli_real_escape_string($GLOBALS['db_connect'],$q)."%' OR p.poster_desc like '%".mysqli_real_escape_string($GLOBALS['db_connect'],$q)."%')  and a.fk_poster_id=p.poster_id and a.auction_is_approved='1' group by p.poster_title");
	$items=array();
	$i=0;
	if($sql){
		$html='<ul style="list-style-type:none;">';
	while($res=mysqli_fetch_array($sql)){
		$val_title=htmlspecialchars($res['poster_title']);
		$html.='<li  style="cursor:pointer;" onclick="set_result(\''.$val_title.'\')">'.$res['poster_title'].'</li>';
		$i++;
	 }
	 $html.='</ul>';
	 
	}
	echo $html;
	//print_r($items);
}
function autocomplete_admin(){
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	$sql = mysqli_query($GLOBALS['db_connect'],"Select u.user_id,u.firstname,u.lastname,u.username from user_table as u where
								(u.firstname like '".$q."%' 
								 OR u.lastname like '".$q."%' 
								 OR CONCAT(u.firstname, '', u.lastname) like '".$q."%'
								 OR CONCAT(u.firstname, ' ', u.lastname) like '".$q."%' )");
	$items=array();
	$i=0;
	if($sql){
	while($res=mysqli_fetch_array($sql)){
		//array_push($items,$res['firstname'].' '.$res['lastname'].'('.$res['username'].')');
		//echo $items[$i]."\n";
		//$items[] = array($res['firstname'].' '.$res['lastname']=>$res['username']);
		$items[$res['username']] = $res['firstname'].' '.$res['lastname'];
		$i++;
	 }
	 if(count($items)>0){
	 	$html='<ul style="list-style-type:none;">';
	 	foreach ($items as $key=>$value) {
			$html.='<li  style="cursor:pointer;" onclick="set_result(\''.$value.'\',\''.$key.'\')">'.$value.' ('.$key.')</li>';
			}
		$html.='</ul>';
		}
	}
	echo $html;
	//print_r($items);
}
function delete_session(){
    if(isset($_SESSION['sessUserID'])){
        unset($_SESSION['sessUserID']);
    }
}
function chkcart(){
	$auction_id = $_REQUEST['auction_id'];
	$sql= "Select in_cart from tbl_auction where auction_id = ".$auction_id;
	$resSql=mysqli_query($GLOBALS['db_connect'],$sql);
  	$fetchSql= mysqli_fetch_array($resSql);
	echo $in_track =$fetchSql['in_cart']; 
}
function clearSession(){
	foreach($_SESSION['cart'] as $key => $value){								
                    $sql_delete=mysqli_query($GLOBALS['db_connect'],"Delete from ".TBL_CART_HISTORY." where `fk_auction_id`='".$value['auction_id']."' and fk_user_id='".$_SESSION['sessUserID']."'");
					$sql_update=mysqli_query($GLOBALS['db_connect'],"Update ".TBL_AUCTION." SET `in_cart`='0' WHERE `auction_id`='".$value['auction_id']."' ");
					unset($_SESSION['cart'][$key]);
					break;
				
			}
}
// Extended Bidding Change
function chk_auction_week(){
	$auction_week_id = $_REQUEST['week_id'];
	$sql= " Select count(1) as is_closed from tbl_auction_week where auction_week_id = ".$auction_week_id." 
				   AND ( UNIX_TIMESTAMP() - UNIX_TIMESTAMP(auction_week_end_date))  >= 10";
	$resSql=mysqli_query($GLOBALS['db_connect'],$sql);
	$fetchSql= mysqli_fetch_array($resSql);
	echo $fetchSql['is_closed'];
}
function chkQuantity(){
	$auction_id = $_REQUEST['id'];
	$quantity = $_REQUEST['quantity'];
	$sql= " Select p.quantity from tbl_poster p,tbl_auction a where a.auction_id = ".$auction_id." 
				   AND a.fk_poster_id = p.poster_id ";
				   
	$resSql=mysqli_query($GLOBALS['db_connect'],$sql);
  	$fetchSql= mysqli_fetch_array($resSql);
	if($fetchSql['quantity'] >=$quantity){
		echo "1";
	}else{
		echo "0";
	}
}
function updateSession(){
	$auction_id = explode(',',$_REQUEST['auctionArr']);
	$amountArr = explode(',',$_REQUEST['amountArr']);
	$quantityArr = explode(',',$_REQUEST['quantityArr']);
	for($k=0;$k<count($auction_id);$k++){
		
		$i=0;
		foreach($_SESSION['cart'] as $key=>$val){
			//echo $_SESSION['cart'][$i]['auction_id'];
			//echo $auction_id[$k];
			if($auction_id[$k] == $_SESSION['cart'][$i]['auction_id']){
				$a= (($amountArr[$k]) * ($quantityArr[$k])); 
			    $_SESSION['cart'][$i]['amount'] = $a;
				$_SESSION['cart'][$i]['quantity']= $quantityArr[$k];
			}
			
			$i++;
		}
	}
	
}
function get_cond_desc(){
	$id = $_REQUEST['id'] ?? '';
	$sql= " Select desc_condition from tbl_cond_desc where fk_condition_id = ".$id." 
				   ";
	$resSql=mysqli_query($GLOBALS['db_connect'],$sql);
	$fetchSql= mysqli_fetch_array($resSql);
	echo $fetchSql['desc_condition'] ?? '';
}
function chk_item_type(){
	//$auction_id = explode(',',$_REQUEST['allVals']);
	//echo count($_REQUEST['allVals']);
	//echo "<br>";
	$key=0;
	$auction_type = array();
	for($k=0;$k<count($_REQUEST['allVals']);$k++){
		$sql ="Select a.fk_auction_type_id from tbl_auction a , tbl_invoice_to_auction tia
					Where tia.fk_invoice_id=".$_REQUEST['allVals'][$k]." 
					and tia.fk_auction_id = a.auction_id";
		$resSql=mysqli_query($GLOBALS['db_connect'],$sql);
  		$fetchSql= mysqli_fetch_array($resSql);
		if(empty($auction_type)){
			array_push($auction_type,$fetchSql['fk_auction_type_id']);
		}
		if (in_array($fetchSql['fk_auction_type_id'], $auction_type)) {
    		
		}else{
			$key =1;
			break;
		}
		
	}
	echo $key;
}

function logoutInactiveUser(){
	
	require_once INCLUDE_PATH."lib/common.php";
	$session_id = base64_encode($_SESSION['sessUserID']).session_id();
	
    $UserArr= array();
    $posterArr = array();
    $sql=" SELECT i.invoice_id,p.poster_title,i.fk_user_id,tia.fk_auction_id,a.fk_auction_type_id,a.auction_is_sold
                 FROM tbl_invoice AS i,tbl_invoice_to_auction AS tia,tbl_auction AS a , tbl_poster AS p
                      WHERE i.is_paid='0'
                            AND tia.session = '".$session_id."'
                            AND tia.fk_invoice_id = i.invoice_id
                            AND a.auction_id=tia.fk_auction_id
                            AND p.poster_id = a.fk_poster_id ";
	
    $executeSql=mysqli_query($GLOBALS['db_connect'],$sql);
    while($row=mysqli_fetch_array($executeSql)){
        if(($row['fk_auction_type_id']=='1' || $row['fk_auction_type_id']=='4') && $row['auction_is_sold']=='3'){
            removeExpiredPosters($row['invoice_id'],$row['fk_auction_id']);
        }
    }

	$obj = new User;
	$chk = $obj->logout();

}

function update_exetended_items_endtime(){
	$id = $_REQUEST['id'];
	$auction_incr_time_span = '00'.':'.AUCTION_INCR_BY_MIN.':'.AUCTION_INCR_BY_SEC;
	$chk_if_closed = "select is_closed from tbl_auction_week where auction_week_id=".$id ;
	$rs_if_closed = mysqli_query($GLOBALS['db_connect'],$chk_if_closed);
	$is_closed_data = mysqli_fetch_assoc($rs_if_closed);
	echo $is_closed_data;
	if($is_closed_data["is_closed"]== '0'){
		$sql_update_week = "UPDATE tbl_auction_week  SET is_latest= '0' where is_latest= '1' AND is_stills= '0' ";
		$sql_update_res_week=mysqli_query($GLOBALS['db_connect'],$sql_update_week);
   
		$sql_update_auction_week = "UPDATE tbl_auction_week  SET is_latest= '1',is_closed= '1' WHERE auction_week_id=".$id;
   
		$sql_update_res_auction=mysqli_query($GLOBALS['db_connect'],$sql_update_auction_week);

		$sql = "UPDATE tbl_auction_live SET
						auction_actual_end_datetime = ADDTIME(now(),'".$auction_incr_time_span."')
						WHERE auction_is_sold ='0' AND ((auction_actual_start_datetime <= now() 
						AND auction_actual_end_datetime >= now())) AND fk_auction_week_id=".$id;
						
		if(mysqli_query($GLOBALS['db_connect'],$sql)){
			return header('X-PHP-Response-Code: 200', true, 200);
		}else{
			return header('X-PHP-Response-Code: 500', true, 500);
		}
	}else{
		return header('X-PHP-Response-Code: 200', true, 200);
	}	
}

?>
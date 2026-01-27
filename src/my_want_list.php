<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);  
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}
chkLoginNow();
if($_REQUEST['mode']=='save_mywant_list'){
    save_mywant_list();
}if($_REQUEST['mode']=='add'){
    display_add();
}if($_REQUEST['mode']=='edit_wantlist'){
    edit_wantlist();
}if($_REQUEST['mode']=='edit_mywant_list'){
    edit_mywant_list();
}if($_REQUEST['mode']=='edit_want'){
    edit_want();
}if($_REQUEST['mode']=='delete_wantlist'){
    delete_wantlist();
}if($_REQUEST['mode']=='delete_want'){
    delete_want();
}if($_REQUEST['mode']=='details'){
    wantlist_details();
}else{
	displayList();
}
ob_end_flush();
	
function displayList()
{
	require_once INCLUDE_PATH."lib/common.php";
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	//$obj = new Category();
	//$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	//$smarty->assign('catRows', $catRows);
	//$smarty->assign('commonCatTypes', $commonCatTypes);
	//$count_match=array();
	$obj_want = new Wantlist();

	$obj_want->primaryKey = 'wantlist_id';
	$total=$obj_want->countData(TBL_WANTLIST,array("fk_user_id"=>$_SESSION['sessUserID']));
	if($total > 0){
	$data=$obj_want->selectData(TBL_WANTLIST,array('*'),array("fk_user_id"=>$_SESSION['sessUserID']),'',true);
	if(!empty($data)){
		$total_count=count($data);
	}

	for($i=0;$i<$total_count;$i++){
	$count_match=array();
	$count_match=array_merge($count_match,$obj_want->get_poster_id($data[$i]['wantlist_id']));
	//$smarty->assign('poster_id_list_'.$i,$count_match);
	$data[$i]['total_poster']=count($count_match);
	}
	$smarty->assign('wantlist',$data);
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	$smarty->assign('total', $total);
	$smarty->display("my_want_list.tpl");
}
function display_add()
{   
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->assign("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	//$obj = new Category();
	//$catRows = $obj->selectData(TBL_CATEGORY, array('*'));
	
	//$smarty->assign('catRows', $catRows);
	$smarty->display("my_want_list_add.tpl");
}
function save_mywant_list()
{
  	require_once INCLUDE_PATH."lib/common.php";
	extract($_REQUEST);
	$obj = new Wantlist();
	$obj->primaryKey = 'wantlist_id';
//	$flag=0;
	$Data = array("fk_user_id" => $_SESSION['sessUserID'],"poster_title" =>addslashes($title));
	$Data2 = array("fk_user_id" => $_SESSION['sessUserID'],"poster_title" =>addslashes($title));
	if($poster_size!=''){
		$Data1=array("fk_poster_size_id"=>$poster_size);
		$Data=array_merge($Data2,$Data1);
		$flag=1;
	}if($genre!=''){
		$Data1=array("fk_genre_id"=>$genre);
		$Data=array_merge($Data2,$Data1);
		$flag=1;
	}if($decade!=''){
		$Data1=array("fk_decade_id"=>$decade);
		$Data=array_merge($Data2,$Data1);
		$flag=1;
	}
	if($country!=''){
		$Data1=array("fk_country_id"=>$country);
		$Data=array_merge($Data2,$Data1);
		$flag=1;
	}
	$count=$obj->countData(TBL_WANTLIST,$Data);
	if($count < 1){
		//$Data1=array("poster_title"=>$title);
		//$Data=array_merge($Data,$Data1);
		$insert_id=$obj->updateData(TBL_WANTLIST,$Data2,false);
		if($insert_id >0){
				$_SESSION['Err']="Poster Title has been added to your want list.";
				//header("Location:".PHP_SELF);
				header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
				exit;
			}
		}else{
			$_SESSION['Err']="Poster Title already added to your want list.";
			//header("Location:".PHP_SELF);
			header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
			exit;
		}
}
function edit_wantlist(){
	require_once INCLUDE_PATH."lib/common.php";
	$obj = new Wantlist();
	$obj->primaryKey = 'wantlist_id';
	$total= count($_REQUEST['wantlist_id']);
	if($total >0){
		 $Data=array();
		 for($i=0;$i<$total;$i++){
		  	$Data_poster=array("fk_poster_size_id"=>$_REQUEST['poster_size'][$i]);
		  	$Data=array_merge($Data,$Data_poster);
			$Data_genre=array("fk_genre_id"=>$_REQUEST['genre'][$i]);
			$Data=array_merge($Data,$Data_genre);
			$Data_decade=array("fk_decade_id"=>$_REQUEST['decade'][$i]);
			$Data=array_merge($Data,$Data_decade);
			$Data_country=array("fk_country_id"=>$_REQUEST['country'][$i]);
			$Data=array_merge($Data,$Data_country);
			$countData=$obj->countData(TBL_WANTLIST,$Data,array("wantlist_id"=>$_REQUEST['wantlist_id'][$i]));
			if($countData > 0){
				$row=$obj->selectData(TBL_WANTLIST,array('*'),$Data);
				for($k=0;$k<$countData;$k++){
					$obj->deleteData(TBL_WANTLIST,array("wantlist_id"=>$row[$k]['wantlist_id']));
				}
			}
			//$Data_notify=array("notify"=>$_REQUEST['notify_id'][$i]);
			//$Data=array_merge($Data,$Data_notify);
		    $update_wantlist=$obj->updateData(TBL_WANTLIST,$Data,array("wantlist_id"=>$_REQUEST['wantlist_id'][$i]),true); 
		}
		if($update_wantlist){
				$_SESSION['Err']="Your want list is successfully modified.";
				header("Location:".PHP_SELF);
				exit; 
		 }
	 }
}
function edit_mywant_list(){
	require_once INCLUDE_PATH."lib/common.php";
	$obj = new Wantlist();
	$obj->primaryKey = 'wantlist_id';
	$poster_title=$_REQUEST['title'];
	$countData=$obj->countData(TBL_WANTLIST,array("poster_title"=>addslashes($poster_title),"fk_user_id"=>$_SESSION['sessUserID']),array("wantlist_id"=>$_REQUEST['wantlist_id']));
	
	if($countData < 1){
		$update_wantlist=$obj->updateData(TBL_WANTLIST,array("poster_title"=>addslashes($poster_title)),array("wantlist_id"=>$_REQUEST['wantlist_id']),true); 
		$_SESSION['Err']="Your want list is successfully modified.";
		//header("Location:".PHP_SELF);
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
		$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
		$_SESSION['Err']="This poster title is already added to your want list.";
		//header("Location:my_want_list.php?mode=edit_want&wantlist_id=".$_REQUEST['wantlist_id']."&encoded_string=".easy_crypt($_SERVER['REQUEST_URI']));
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	
}
function edit_want(){
	require_once INCLUDE_PATH."lib/common.php";
	$smarty->assign("encoded_string", $_REQUEST['encoded_string']);
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj_want = new Wantlist();

	//$obj_want->primaryKey = 'wantlist_id';
	$total=$obj_want->countData(TBL_WANTLIST,array("wantlist_id"=>$_REQUEST['wantlist_id']));
	if($total > 0){
	$data=$obj_want->selectData(TBL_WANTLIST,array('poster_title'),array("wantlist_id"=>$_REQUEST['wantlist_id']));
	}
	$smarty->assign('total', $total);
	$smarty->assign('want_data', $data);
	$smarty->display("my_wantlist_edit.tpl");
}	
function delete_wantlist(){
	require_once INCLUDE_PATH."lib/common.php";
	$obj = new Wantlist();
	$obj->primaryKey = 'wantlist_id';
	$i=count($_REQUEST['auction_ids']);
	if($i >0){
		for($j=0;$j<$i;$j++){
			$chk=$obj->deleteData(TBL_WANTLIST,array("wantlist_id"=>$_REQUEST['auction_ids'][$j]));
			}
		if($chk){
				$_SESSION['Err']="Poster Title(s) have been successfully deleted.";
				header("Location:my_want_list.php");
				exit;
				}
		}else{
			$_SESSION['Err']="Please select a poster title to delete.";
			header("Location:my_want_list.php");
			exit;
	}
	}
function delete_want(){
	require_once INCLUDE_PATH."lib/common.php";
	$obj = new Wantlist();
	$obj->primaryKey = 'wantlist_id';
	$wantlist_id=$_REQUEST['wantlist_id'];
	$chk=$obj->deleteData(TBL_WANTLIST,array("wantlist_id"=>$wantlist_id));
	if($chk){
		$_SESSION['Err']="Poster Title have been successfully deleted.";
		header("Location:my_want_list.php");
		exit;
			}
	else{
		$_SESSION['Err']="Poster Title is not deleted";
		header("Location:my_want_list.php");
		exit;
	}
}	
function wantlist_details()
	{
	require_once INCLUDE_PATH."lib/common.php";
	$wantlist_id=$_REQUEST['wantlist_id'];
	$obj_want = new Wantlist();
	$count_match=array();
	$count_match=array_merge($count_match,$obj_want->get_poster_id_details($wantlist_id));
	$mywantlist_array=array();
	for($i=0;$i<count($count_match);$i++){
		$obj_auction = new Auction();
		$poster_id=array();
		$poster_id=$obj_auction->select_wantlist_auctions($count_match[$i]);
		if(count($poster_id)>0){
			$mywantlist_array=array_merge($mywantlist_array,$poster_id);
		}
	}
	$total=count($mywantlist_array);
	$smarty->assign('total', $total);
	$posterObj = new Poster();
	$posterObj->fetchPosterCategories($mywantlist_array);
	$posterObj->fetchPosterImages($mywantlist_array);
	$offerObj = new Offer();
	$bidObj = new Bid();
	for($i=0;$i<$total;$i++)
	{
		if($mywantlist_array[$i]['fk_auction_type_id']==1){
			
			$offerObj->fetch_OfferCount_MaxOffer($mywantlist_array);
		}else{
			
			$bidObj->fetch_BidCount_MaxBid($mywantlist_array);
		}
	}
	
	for($i=0;$i<count($mywantlist_array);$i++){
        if (file_exists("poster_photo/" . $mywantlist_array[$i]['poster_thumb'])){
            $mywantlist_array[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$mywantlist_array[$i]['poster_thumb'];
        }else{
            $mywantlist_array[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$mywantlist_array[$i]['poster_thumb'];
        }
			if($mywantlist_array[$i]['fk_auction_type_id'] != 1){	
				/*$endDateTime = splitDateTime($mywantlist_array[$i]['auction_actual_end_datetime']);
				$mywantlist_array[$i]['auction_countdown'] = '<span id="cd_'.$mywantlist_array[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$mywantlist_array[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month']-1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
				
				$mywantlist_array[$i]['auction_countdown'] = '<span id="cd_'.$mywantlist_array[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$mywantlist_array[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$mywantlist_array[$i]['seconds_left'].', new Date())});</script></span>';
			}
	  }	
	/* echo "<pre>"; 
	 print_r($mywantlist_array);
	 echo "</pre>"; */
	$smarty->assign('mywantlist_array', $mywantlist_array);
	$smarty->assign('json_arr', json_encode($mywantlist_array));
	$smarty->display("latest_wantlist.tpl");
	}	
?>
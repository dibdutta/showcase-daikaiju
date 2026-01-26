<?php
define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";

if($_REQUEST['mode'] == "admin_user"){
	change_admin_user_status();
}elseif($_REQUEST['mode'] == "page_fixed"){
	change_page_fixed_status();
}elseif($_REQUEST['mode'] == "page_custom"){
	change_page_custom_status();
}elseif($_REQUEST['mode'] == "user"){
	change_user_status();
}/*elseif($_REQUEST['mode'] == "poster"){
	change_poster_status();
}*/elseif($_REQUEST['mode'] == "auction"){
	change_auction_status();
}elseif($_REQUEST['mode'] == "poster_received"){
	change_poster_received_status();
}

function change_admin_user_status(){
	$obj = new AdminUser;
	$obj->adminID = $_REQUEST['id'];
	$chk = $obj->changeStatus();
	if($chk == 0){
		echo "none";
	}
	else{
		echo "done";
	}
}

function change_page_fixed_status(){
	$obj = new PageContent;
	$obj->pageID = $_REQUEST['id'];
	$chk = $obj->changeFixedPageStatus();
	if($chk == 0){
		echo "none";
	}
	else{
		echo "done";
	}
}

function change_page_custom_status(){
	$obj = new PageContent;
	$obj->pageContentID = $_REQUEST['id'];
	$chk = $obj->changeCustomPageStatus();
	if($chk == 0){
		echo "none";
	}
	else{
		echo "done";
	}
}

function change_user_status(){
	$obj = new User;
	$obj->userID = $_REQUEST['id'];
	$chk = $obj->changeStatus();
	if($chk == 0){
		echo "none";
	}
	else{
		echo "done";
	}
}

/*function change_poster_status(){
	$obj = new Poster;
	$data = array('fk_auction_type_id', 'poster_price', 'start_price', 'buynow_price', 'poster_admin_approve');
	$poster = $obj->selectData(TBL_POSTER, $data, array('poster_id' => $_REQUEST['id']));

	$errCounter = 0;
	if($poster[0]['fk_auction_type_id'] != 1){
		if($poster[0]['poster_price'] == '0.00'){
			$errCounter++;
		}elseif($poster[0]['start_price'] == '0.00'){
			$errCounter++;
		}elseif($poster[0]['buynow_price'] == '0.00'){
			$errCounter++;
		}
	}

	if($errCounter == 0){
		$status = ($poster[0]['poster_admin_approve'] == '1') ? '0' : '1';		
		$chk = $obj->updateData(TBL_POSTER, array('poster_admin_approve' => $status), array('poster_id' => $_REQUEST['id']), true);
		if($status == 0){
			echo "none";
		}elseif($status == 1){
			echo "done";
		}
	}else{
		echo "ERROR: Please set Start Price, Buy Now Price and Reserve Price before approve!";
	}
}*/

function change_auction_status(){
	
	$obj = new Auction;
	
	$chk = $obj->updateData(TBL_AUCTION, array('auction_is_approved' => $_REQUEST['is_approved']), array('auction_id' => $_REQUEST['id']), true);
	if($chk){
			
	
		/******************************** Email Start ******************************/
		$sql = "SELECT u.username, u.firstname, u.lastname, u.email,p.poster_id,
				p.poster_title, p.poster_sku, a.fk_auction_type_id 
				FROM ".USER_TABLE." u, ".TBL_POSTER." p, ".TBL_AUCTION." a
				WHERE a.fk_poster_id = p.poster_id
				AND p.fk_user_id = u.user_id
				AND a.auction_id = '".$_REQUEST['id']."'";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		if($row['fk_auction_type_id'] != 3 && $_REQUEST['is_approved']==1){
			$objWantlist=new Wantlist();
			$objWantlist->countNewAuctionWithWantlist($_REQUEST['id']);	
		}
		if($row['fk_auction_type_id'] == '1'){
			$sql_update = "Update tbl_poster set up_date='".date('Y-m-d H:i:s')."' where poster_id='".$row['poster_id']."'";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql_update);
		}	
		$toMail = $row['email'];
		$toName = $row['firstname']." ".$row['lastname'];
		
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		if($_REQUEST['is_approved']==1){
			$subject = "Item approved";
			$textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
			$textContent .= 'Your poster (<strong>Poster Title:</strong> '.$row['poster_title'].', <strong>Poster SKU:</strong> '.$row['poster_sku'].') has been Approved. For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />';
			//$textContent = 'Your poster has been Approved. For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />Poster Title: '.$row['poster_title'].'<br />Poster SKU: '.$row['poster_sku'].'<br /><br />';
			if($row['fk_auction_type_id'] == 3){
			$subject = "Poster / Auction Approved";	
			$textContent .= 'Please ship your posters to MPE for monthly auction .<br /><br />';
			}
		}elseif($_REQUEST['is_approved']==2){
			$subject = "Item not approved";
			$textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
			$textContent .= 'Your item (<strong>Title:</strong> '.$row['poster_title'].', <strong>Poster SKU:</strong> '.$row['poster_sku'].') has not been approved for one or more of the following reasons:<br/> 1. Photo lacks appropriate clarity/definition.<br/> 2. Description is inaccurate or vague.<br/> 3. Item authenticity is indeterminate. <br/> 4. Inappropriate type of item(props, other non-paper related movie material). <br/>Please contact us for further information.<br /><br />';
			//$textContent = 'Your poster has been disapproved. For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />Poster Title: '.$row['poster_title'].'<br />Poster SKU: '.$row['poster_sku'].'<br /><br />';
		}
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		
		/****************************** Email End ********************************/
		echo "done";
	}else{
		echo "none";
	}
}

function change_poster_received_status(){
	$obj = new Auction;
	
	$chk = $obj->updateData(TBL_AUCTION, array('is_approved_for_monthly_auction' => 1), array('auction_id' => $_REQUEST['id']), true);
	if($chk){		
		$objWantlist=new Wantlist();
		$objWantlist->countNewAuctionWithWantlist($_REQUEST['id']);		
		/******************************** Email Start ******************************/
		$sql = "SELECT u.username, u.firstname, u.lastname, u.email,
				p.poster_title, p.poster_sku, a.fk_auction_type_id 
				FROM ".USER_TABLE." u, ".TBL_POSTER." p, ".TBL_AUCTION." a
				WHERE a.fk_poster_id = p.poster_id
				AND p.fk_user_id = u.user_id
				AND a.auction_id = '".$_REQUEST['id']."'";
		$rs = mysqli_query($GLOBALS['db_connect'],$sql);
		$row = mysqli_fetch_array($rs);
		
		$toMail = $row['email'];
		$toName = $row['firstname']." ".$row['lastname'];
		$subject = "Item Received and Approved for Monthly Auction";
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		$textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
		$textContent.= 'Your poster (<strong>Poster Title:</strong> '.$row['poster_title'].', <strong>Poster SKU:</strong> '.$row['poster_sku'].') has been received and approved for monthly auction.For more details, please <a href="http://'.HOST_NAME.'">login </a> <br /><br />';
		//$textContent = 'Your poster has been received and approved for monthly auction.For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />Poster Title: '.$row['poster_title'].'<br />Poster SKU: '.$row['poster_sku'].'<br /><br />';
		
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		
		/****************************** Email End ********************************/
		
		echo "done";
	}else{
		echo "none";
		}
}

?>
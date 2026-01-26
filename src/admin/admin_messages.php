<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "Admin Messages");
ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";

if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

if($_REQUEST['mode'] == "compose"){
	compose();
}elseif($_REQUEST['mode'] == "read"){
	read();
}elseif($_REQUEST['mode'] == "send_message"){
	$chk = validateMessage();
	if($chk == true){
		send_message();
	}else{
		compose();
	}
}elseif($_REQUEST['mode'] == "inbox"){
	dispmiddle();
}elseif($_REQUEST['mode'] == "reply"){
	reply();
}elseif($_REQUEST['mode'] == "send_reply"){
	$chk = validateReply();
	if($chk == true){
		send_reply();
	}else{
		reply();
	}
}elseif($_REQUEST['mode'] == "delete_message"){
	delete_message();
}elseif($_REQUEST['mode'] == "delete_message_sent"){
	delete_message_sent();
}elseif($_REQUEST['mode'] == "delete_all_messages"){
	delete_all_messages();
}elseif($_REQUEST['mode'] == "delete_sent_message"){
	delete_sent_message();
}elseif($_REQUEST['mode'] == "delete_all_sent_messages"){
	delete_all_sent_messages();
}elseif($_REQUEST['mode'] == "sent_messages"){
	sent_messages();
}elseif($_REQUEST['sent_msg'] == "sent_messages"){
	sent_messages();
}elseif($_REQUEST['inbox_msg'] == "inbox_msg"){
	dispmiddle();
}else{
	dispmiddle();
	
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function dispmiddle() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_to' => $_SESSION['adminLoginID'], "message_is_toadmin" => 1, "message_is_fromadmin" => 0, "message_is_deleted_to" => 0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	if(!isset($_REQUEST['search'])){
		$_REQUEST['search']='message_sent_dt';
	}
	if($total>0){
		$messageRows = $obj->listInbox($where, array('*'),$_REQUEST['search']);
		$total_msgs_now=count($messageRows);
		for($i=0;$i<$total_msgs_now;$i++){
			$messageRows[$i]['send_date']=formatDateTime($messageRows[$i]['message_sent_dt'],true); 
		 }
		$smarty->assign('search', $_REQUEST['search']);
		$smarty->assign('messageRows', $messageRows);
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	
	$smarty->display('admin_message_inbox.tpl');
}

/************************************	 END of Middle	  ********************************/

function compose() {
	require_once INCLUDE_PATH."lib/adminCommon.php";

	extract($_REQUEST);
	$smarty->assign ("encoded_string", $encoded_string);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new User();
	$obj->orderBy = "LOWER(firstname)";
	$obj->orderType = 'ASC';
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'username', 'firstname', 'lastname'),1,true);
	$smarty->assign('userRow',$userRow);

	foreach ($_REQUEST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		$smarty->assign($key,$value);
	}
	
	if(!is_array($_REQUEST['user_ids'])){
		eval('$smarty->assign("user_ids_err", $GLOBALS["user_ids_err"]);');
		$smarty->assign($user_ids,$_REQUEST['user_ids']);
	}
	
	ob_start();
	$oFCKeditor = new FCKeditor('message_body') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->ToolbarSet = 'Basic';
	$oFCKeditor->Width  = '600';
	$oFCKeditor->Height = '400';
	$oFCKeditor->Create() ;
	$message_body = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('message_body', $message_body);

	$smarty->display('admin_message_compose.tpl');
}

function validateMessage(){

	$errCounter=0;
	extract($_REQUEST);

	if(!isset($user_ids)){
		$GLOBALS['user_ids_err'] = "Please select User(s).";
		$errCounter++;
	}
	
	if($message_subject == ""){
		$GLOBALS['message_subject_err'] = "Please enter Subject.";
		$errCounter++;
	}
	if($message_body == ""){
		$GLOBALS['message_body_err'] = "Please enter Message Content.";
		$errCounter++;
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function send_message(){
	extract($_REQUEST);
	$obj = new Message();
	
	foreach($_REQUEST[user_ids] as $key => $value ) {
		$data = array('message_subject' => $message_subject,
					  'message_body' => $message_body,
					  'message_sent_dt' => date("Y-m-d H:i:s"),
					  'message_to' => $value,
					  'message_from' => $_SESSION['adminLoginID'],
					  'message_is_new' => '1',
					  'message_is_toadmin' => '0',
					  'message_is_fromadmin' => '1');
		
		$ids[] = $obj->updateData(TBL_MESSAGE, $data);	
	}
	
	if(count($ids) > 0){
		$_SESSION['adminErr'] = "Message sent successfully.";
		header("location: ".PHP_SELF);
	}else{
		$_SESSION['adminErr'] = "Can not send message. Please try again.";
		header("location: ".PHP_SELF);
	}
}

function read()
{
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", $encoded_string);
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_id' => $message_id);
	$message = $obj->readMessage($where, array('*'));
	//print_r($message);
	$smarty->assign('message', $message);
	
	ob_start();
	$oFCKeditor = new FCKeditor('message_body') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->ToolbarSet = 'Basic';
	$oFCKeditor->Width  = '600';
	$oFCKeditor->Height = '400';
	$oFCKeditor->Create() ;
	$message_body = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('message_body', $message_body);
	
	$smarty->display('admin_message_read.tpl');	
}

function reply() {
	require_once INCLUDE_PATH."lib/adminCommon.php";
	
	extract($_REQUEST);
	$smarty->assign ("encoded_string", $encoded_string);
	$smarty->assign ("message_id", $message_id);
	
	$obj = new Message();
	$where = array('message_id' => $message_id, 'message_is_toadmin' => '1');
	$message = $obj->readMessage($where, array('message_subject', 'message_to','message_from'));
	$smarty->assign('message', $message);

	foreach ($_REQUEST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
		$smarty->assign($key,$value);
	}
	
	ob_start();
	$oFCKeditor = new FCKeditor('message_body') ;
	$oFCKeditor->BasePath = '../FCKeditor/';
	$oFCKeditor->ToolbarSet = 'Basic';
	$oFCKeditor->Width  = '600';
	$oFCKeditor->Height = '400';
	$oFCKeditor->Create() ;
	$message_body = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('message_body', $message_body);

	$smarty->display('admin_message_reply.tpl');
}

function validateReply(){

	$errCounter=0;
	extract($_REQUEST);

	if($message_subject == ""){
		$GLOBALS['message_subject_err'] = "Please enter Subject.";
		$errCounter++;
	}
	if($message_body == ""){
		$GLOBALS['message_body_err'] = "Please enter Message Content.";
		$errCounter++;
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function send_reply(){
	extract($_REQUEST);
	$obj = new Message();

	$data = array('message_subject' => $message_subject,
				  'message_body' => $message_body,
				  'message_sent_dt' => date("Y-m-d H:i:s"),
				  'message_to' => $message_to,
				  'message_from' => $_SESSION['adminLoginID'],
				  'message_is_new' => '1',
				  'message_is_toadmin' => '0',
				  'message_is_fromadmin' => '1');
	$ids = $obj->updateData(TBL_MESSAGE, $data);
	
	if($ids > 0){
		$_SESSION['adminErr'] = "Message sent successfully.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}else{
		$_SESSION['adminErr'] = "Can not send message. Please try again.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}
}

function sent_messages() {
	require_once INCLUDE_PATH."lib/adminCommon.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_from' => $_SESSION['adminLoginID'], "message_is_fromadmin" => 1, "message_is_toadmin" => 0, "message_is_deleted_from" => 0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	if(!isset($_REQUEST['search'])){
		$_REQUEST['search']='message_sent_dt';
	}
	if($total>0){
		$messageRows = $obj->listSentMessages($where, array('*'),$_REQUEST['search']);
		$total_msgs_now=count($messageRows);
		for($i=0;$i<$total_msgs_now;$i++){
			$messageRows[$i]['send_date']=formatDateTime($messageRows[$i]['message_sent_dt'],true); 
		 }
		$smarty->assign('search', $_REQUEST['search']);
		$smarty->assign('messageRows', $messageRows);
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	
	$smarty->display('admin_message_sent.tpl');
}

function delete_message(){
	extract($_REQUEST);
	$obj = new Message();
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $message_id, "message_to" => $_SESSION['adminLoginID']), true);

	if($chk == true){
		$_SESSION['adminErr'] = "The Message has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete the Message. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}

function delete_all_messages(){

	$flag = 1;
	$obj = new Message();
	if(count($_REQUEST['message_ids']) >0){
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $val, "message_to" => $_SESSION['adminLoginID']), true);
		if($chk == false){
			$flag = 0;
		}
	}
	}else{
		$_SESSION['adminErr']="Please Select Atleast One Message to Delete.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;	
	}

	if($flag == 1){
		$_SESSION['adminErr']="All Messages deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$_SESSION['adminErr'] .="All Messages not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

function delete_sent_message(){
	extract($_REQUEST);
	$obj = new Message();
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $message_id, "message_from" => $_SESSION['adminLoginID']), true);

	if($chk == true){
		$_SESSION['adminErr'] = "The Message has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete the Message. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}
function delete_message_sent(){
	extract($_REQUEST);
	$obj = new Message();
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $message_id, "message_from" => $_SESSION['adminLoginID']), true);

	if($chk == true){
		$_SESSION['adminErr'] = "The Message has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['adminErr'] = "Can not delete the Message. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}

function delete_all_sent_messages(){

	$flag = 1;
	$obj = new Message();
	if(count($_REQUEST['message_ids'])>0){
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $val, "message_from" => $_SESSION['adminLoginID']), true);
		if($chk == false){
			$flag = 0;
		}
	}	
	}else{
	$_SESSION['adminErr'] = "Please Select Atleast One Message to Delete.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;	
	}

	if($flag == 1){
		$_SESSION['adminErr']="All Messages deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$_SESSION['adminErr'] .="All Messages not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

?>
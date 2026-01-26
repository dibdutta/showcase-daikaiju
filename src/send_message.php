<?php
/**************************************************/
define ("PAGE_HEADER_TEXT", "User Messages");
ob_start();

define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
chkLoginNow();
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
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
}elseif($_REQUEST['mode'] == "delete_all_messages"){
	delete_all_messages();
}elseif($_REQUEST['mode'] == "delete_sent_message"){
	delete_sent_message();
}elseif($_REQUEST['mode'] == "delete_all_sent_messages"){
	delete_all_sent_messages();
}elseif($_REQUEST['mode'] == "sent_messages"){
	sent_messages();
}else{
	dispmiddle();
}

ob_end_flush();
/*************************************************/

/*********************	START of dispmiddle Function	**********/

function dispmiddle() {
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array("message_to" => $_SESSION['sessUserID'], "message_is_toadmin" =>'0',"message_is_fromadmin" =>'1', "message_is_deleted_to" =>0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	
	if($total>0){
		$messageRows = $obj->listInbox($where, array('*'));
		 for($i=0;$i<$total;$i++){
			$messageRows[$i]['send_date']=formatDateTime($messageRows[$i]['message_sent_dt'],true); 
		 }
		$smarty->assign('messageRows', $messageRows);
		
		//$send_date=formatDate();
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	
	$smarty->display('inbox.tpl');
}

/************************************	 END of Middle	  ********************************/

function compose() {
	require_once INCLUDE_PATH."lib/common.php";

	extract($_REQUEST);
	$smarty->assign ("encoded_string", $encoded_string);
	$smarty->assign ("decoded_string", easy_decrypt($_REQUEST['encoded_string']));

	$obj = new User();
	$userRow = $obj->selectData(USER_TABLE, array('user_id', 'username', 'firstname', 'lastname'));
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
	$oFCKeditor->Width  = '450';
	$oFCKeditor->Height = '300';
	$oFCKeditor->Create() ;
	$message_body = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('message_body', $message_body);

	$smarty->display('user_message_compose.tpl');
}

function validateMessage(){

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

function send_message(){
	extract($_REQUEST);
	$obj = new Message();
	
		$data = array('message_subject' => $message_subject,
					  'message_body' => $message_body,
					  'message_sent_dt' => date("Y-m-d H:i:s"),
					  'message_to' => '1',
					  'message_from' => $_SESSION['sessUserID'],
					  'message_is_new' => '1',
					  'message_is_toadmin' => '1',
					  'message_is_fromadmin' => '0');
		
		$ids = $obj->updateData(TBL_MESSAGE, $data);	
	
	if($ids > 0){
		$_SESSION['Err'] = "Message sent successfully.";
		header("location: ".PHP_SELF);
	}else{
		$_SESSION['Err'] = "Can not send message. Please try again.";
		header("location: ".PHP_SELF);
	}
}

function read()
{
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", $encoded_string);
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_id' => $message_id);
	$message = $obj->readMessage($where, array('*'));
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
	$smarty->assign('user_id', $_SESSION['sessUserID']);
	$smarty->display('user_message_read.tpl');	
}

function reply() {
	require_once INCLUDE_PATH."lib/common.php";
	
	extract($_REQUEST);
	$smarty->assign ("encoded_string", $encoded_string);
	$smarty->assign ("message_id", $message_id);
	
	$obj = new Message();
	$where = array('message_id' => $message_id, 'message_is_toadmin' => '0','message_to' => $_SESSION['sessUserID']);
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
	$oFCKeditor->Width  = '450';
	$oFCKeditor->Height = '300';
	$oFCKeditor->Create() ;
	$message_body = ob_get_contents();
	ob_end_clean();	
	$smarty->assign('message_body', $message_body);

	$smarty->display('user_message_reply.tpl');
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
				  'message_from' => $_SESSION['sessUserID'],
				  'message_is_new' => '1',
				  'message_is_toadmin' => '1',
				  'message_is_fromadmin' => '0');

	$ids = $obj->updateData(TBL_MESSAGE, $data);
	
	if($ids > 0){
		$_SESSION['Err'] = "Message sent successfully.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}else{
		$_SESSION['Err'] = "Can not send message. Please try again.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}
}

function sent_messages() {
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_from' => $_SESSION['sessUserID'], "message_is_fromadmin" => 0, "message_is_toadmin" => 1, "message_is_deleted_from" => 0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	
	if($total>0){
		$messageRows = $obj->listSentMessages($where, array('*'));
		for($i=0;$i<$total;$i++){
			$messageRows[$i]['send_date']=formatDateTime($messageRows[$i]['message_sent_dt'],true); 
		 }
		$smarty->assign('messageRows', $messageRows);
		$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=5, $end=100, $step=5, $use=1));			
		$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('is_sent', 1);
	
	$smarty->display('user_message_sent.tpl');
}

function delete_message(){
	extract($_REQUEST);
	$obj = new Message();
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $message_id, "message_to" => $_SESSION['sessUserID']), true);

	if($chk == true){
		$_SESSION['Err'] = "The Message has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['Err'] = "Can not delete the Message. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}

function delete_all_messages(){

	$flag = 1;
	$obj = new Message();
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $val, "message_to" => $_SESSION['sessUserID']), true);
		if($chk == false){
			$flag = 0;
		}
	}	

	if($flag == 1){
		$_SESSION['Err']="All Messages deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$_SESSION['Err'] .="All Messages not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

function delete_sent_message(){
	extract($_REQUEST);
	$obj = new Message();
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $message_id, "message_from" => $_SESSION['sessUserID']), true);
	if($chk == true){
		$_SESSION['Err'] = "The Message has been deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
	else{
		$_SESSION['Err'] = "Can not delete the Message. Please try again.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}

}

function delete_all_sent_messages(){

	$flag = 1;
	$obj = new Message();
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $val, "message_from" => $_SESSION['sessUserID']), true);
		if($chk == false){
			$flag = 0;
		}
	}	

	if($flag == 1){
		$_SESSION['Err']="All Messages deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}else{
		$_SESSION['Err'] .="All Messages not deleted successfully.";
		header("location: ".DOMAIN_PATH."".easy_decrypt($_REQUEST['encoded_string'])."");
		exit;
	}
}

?>
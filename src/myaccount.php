<?php  
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}
//chkLoginNow();
if($_REQUEST['mode'] == "profile"){
	profile();
}elseif($_REQUEST['mode'] == "update_profile"){
	$chk = validateForm();
	if($chk == true){
		update_profile();
	}else{
		profile();
	}	
}elseif($_REQUEST['mode'] == "logout"){
	logout();
}elseif($_REQUEST['mode'] == "change_password"){
	change_password();
}elseif($_REQUEST['mode'] == "save_password"){
	$chk = validateChangePassword();
	if($chk == true){
		update_password();
	}else{
		change_password();
	}
}elseif($_REQUEST['mode'] == "compose"){
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
	inbox();
}elseif($_REQUEST['mode'] == "reply"){
	reply();
}elseif($_REQUEST['mode'] == "send_reply"){
	$chk = validateReply();
	if($chk == true){
		send_reply();
	}else{
		reply();
	}
}elseif($_REQUEST['mode'] == "inbox"){
	inbox();
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

////////////   For page content 

function dispmiddle()
{
	require_once INCLUDE_PATH."lib/common.php";
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	/* Dash Board for Sold Items */
	################ Closed for loading Issue #################
	/*$objAuction = new Auction();
	$posterObj = new Poster();
	$totalSoldAuc=$objAuction->countJstFinishedAuction('',$_SESSION['sessUserID'],$type='Home');
	$dataJstFinishedAuction=$objAuction->soldAuction(true,true,'',$_SESSION['sessUserID'],$type='Home');
    for($i=0;$i<count($dataJstFinishedAuction);$i++){
        if (file_exists("poster_photo/" . $dataJstFinishedAuction[$i]['poster_thumb'])){
            $dataJstFinishedAuction[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataJstFinishedAuction[$i]['poster_thumb'];
        }else{
            $dataJstFinishedAuction[$i]['image_path']=CLOUD_POSTER_THUMB.$dataJstFinishedAuction[$i]['poster_thumb'];
        }
    }
	$dataJstFinishedAuction=$objAuction->fetchWinnerAndSoldPrice($dataJstFinishedAuction);	
	$smarty->assign('total', $totalSoldAuc);
	$smarty->assign('dataJstFinishedAuction', $dataJstFinishedAuction);
	*/
	################ Closed for loading Issue #################
	
	/* Dash Board for Winning Bids */
	$objBid = new Bid();
	$objBid->orderType= "DESC";
	$dataBid = $objBid->fetchBidDetails($_SESSION['sessUserID'],'winning');
    for($i=0;$i<count($dataBid);$i++){
        if (file_exists("poster_photo/" . $dataBid[$i]['poster_thumb'])){
            $dataBid[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataBid[$i]['poster_thumb'];
        }else{
            $dataBid[$i]['image_path']=CLOUD_POSTER_THUMB.$dataBid[$i]['poster_thumb'];
        }
    }
	$objBid->fetchMyBidByType($dataBid,$_SESSION['sessUserID'],'winning');
	$smarty->assign('totalBids', count($dataBid));
	$smarty->assign('bidDetails', $dataBid);
	
	/* Dash Board for Winning Offers */
	$objOffer = new Offer();
	$dataOfr = $objOffer->fetchMyWinningOffers($_SESSION['sessUserID']);
    for($i=0;$i<count($dataOfr);$i++){
        if (file_exists("poster_photo/" . $dataOfr[$i]['poster_thumb'])){
            $dataOfr[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$dataOfr[$i]['poster_thumb'];
        }else{
            $dataOfr[$i]['image_path']=CLOUD_POSTER_THUMB.$dataOfr[$i]['poster_thumb'];
        }
    }
	$smarty->assign('dataOfr', $dataOfr);
	$smarty->assign('totalOffers', count($dataOfr));
	
	
	$objAuction = new Auction();
	$objAuction->orderType = 'DESC';
	$totalSelling = $objAuction->countAuctionsByStatus($_SESSION['sessUserID'], $status);
	$auctionRow = $objAuction->fetchAuctionsByStatus($_SESSION['sessUserID'], $status);
    for($i=0;$i<count($auctionRow);$i++)
    {
        if (file_exists("poster_photo/" . $auctionRow[$i]['poster_thumb'])){
            $auctionRow[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$auctionRow[$i]['poster_thumb'];
        }else{
            $auctionRow[$i]['image_path']=CLOUD_POSTER_THUMB.$auctionRow[$i]['poster_thumb'];
        }
        if($auctionRow[$i]['fk_auction_type_id']==1){
            $offerObj=new Offer();
            $offerObj->fetch_OfferCount_MaxOffer($auctionRow);
        }elseif($auctionRow[$i]['fk_auction_type_id']==2){
            $objBid = new Bid();
            $objBid->fetch_BidCount_MaxBid($auctionRow);
        }
    }
   $smarty->assign('totalSelling', $totalSelling);
   $smarty->assign('sellingItem', $auctionRow); 
   $smarty->display("myaccount.tpl"); 
}

function profile()
{
	require_once INCLUDE_PATH."lib/common.php";

	$obj = new User();
	$row = $obj->selectData(USER_TABLE, array('*'), array('user_id' => $_SESSION['sessUserID']));
	$smarty->assign('profile', $row);
	
	$rs = getCountryList();
	while($row = mysqli_fetch_array($rs)){
		$countryName[] = $row[COUNTRY_NAME];
		$countryID[] = $row[COUNTRY_ID];		
	}
	$smarty->assign('countryID', $countryID);
	$smarty->assign('countryName', $countryName);

	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	$smarty->assign('update_cc', $_REQUEST['update_cc']);
	//$smarty->assign('credit_card_no', $_REQUEST['credit_card_no']);
	
    $user_id=$_SESSION['sessUserID'];
	//$total_array=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select count(*) total from card_details where user_id=$user_id"));
	//$total=$total_array['total'];
	//if($total > 0){
		//$obj = new User();
		//$card = $obj->selectData(CARD_DETAIL, array('*'), array('user_id' => $_SESSION['sessUserID']));
		//$smarty->assign('card', $card);
		//$expiry_date_array=explode('-',$card[0]['expiry_date']);
		//$expiry_month=$expiry_date_array[0];
		//$smarty->assign('expiry_month', $expiry_month);
		//$expiry_year=$expiry_date_array[1];
		//$smarty->assign('expiry_year', $expiry_year);
	//}
	
	$commonObj = new DBCommon();
	$commonObj->orderBy='name';
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name','abbreviation'),$where = '1',true);
	$smarty->assign('us_states', $us_states);
	
	$smarty->display("profile.tpl");
}

function validateForm()
{
	$errCounter = 0;

	$obj = new User();

	if($_REQUEST['firstname'] == ""){
		$GLOBALS['firstname_err'] = "Please enter Firstname.";
		$errCounter++;	
	}

	if($_REQUEST['lastname'] == ""){
		$GLOBALS['lastname_err'] = "Please enter Lastname.";
		$errCounter++;	
	}

	if($_REQUEST['email'] == ""){
		$GLOBALS['email_err'] = "Please enter E-mail Address.";
		$errCounter++;
	}elseif(checkEmail($_REQUEST['email'], '') == 1){
		$GLOBALS['email_err'] = "Invalid E-mail Address.";
		$errCounter++;
	}else{
		if($obj->checkUnique(EMAIL,$_REQUEST['email'], $_SESSION['sessUserID'])){
				$GLOBALS['email_err'] = "E-mail Address already exists.";
				$errCounter++;
		}
	}
	
	if($_REQUEST['address1'] == ""){
		$GLOBALS['address1_err'] = "Please enter Address1.";
		$errCounter++;	
	}
	
	if($_REQUEST['country_id'] == ""){
		$GLOBALS['country_id_err'] = "Please enter Country.";
		$errCounter++;	
	}
	
    /*if($_REQUEST['country_id'] != 230 && $_REQUEST['state_textbox'] == ""){
        $GLOBALS['state_textbox_err'] = "Please enter a State.";
        $errCounter++;  
    }else*/if($_REQUEST['country_id'] == 230 && $_REQUEST['state_select'] == ""){
        $GLOBALS['state_select_err'] = "Please select a State.";
        $errCounter++;  
	}
	
	if($_REQUEST['city'] == ""){
		$GLOBALS['city_err'] = "Please enter City.";
		$errCounter++;	
	}

	if($_REQUEST['zipcode'] == ""){
		$GLOBALS['zipcode_err'] = "Please enter zipcode.";
		$errCounter++;	
	}

	if($_REQUEST['shipping_lastname'] == ""){
		$GLOBALS['shipping_lastname_err'] = "Please enter Shipping Country.";
		$errCounter++;	
	}
	if($_REQUEST['shipping_firstname'] == ""){
		$GLOBALS['shipping_firstname_err'] = "Please enter Shipping First Name.";
		$errCounter++;	
	}

	if($_REQUEST['shipping_address1'] == ""){
		$GLOBALS['shipping_address1_err'] = "Please enter Shipping Address1.";
		$errCounter++;	
	}
	
	if($_REQUEST['shipping_country_id'] == ""){
		$GLOBALS['shipping_country_id_err'] = "Please enter Shipping Country.";
		$errCounter++;	
	}

    /*if($_REQUEST['shipping_country_id'] != 230 && $_REQUEST['shipping_state_textbox'] == ""){
        $GLOBALS['shipping_state_textbox_err'] = "Please enter Shipping State.";
        $errCounter++;  
    }else*/if($_REQUEST['shipping_country_id'] == 230 && $_REQUEST['shipping_state_select'] == ""){
        $GLOBALS['shipping_state_select_err'] = "Please select Shipping State.";
        $errCounter++;  
    }
	
	if($_REQUEST['shipping_city'] == ""){
		$GLOBALS['shipping_city_err'] = "Please enter Shipping City.";
		$errCounter++;	
	}
		
	if($_REQUEST['shipping_zipcode'] == ""){
		$GLOBALS['shipping_zipcode_err'] = "Please enter Shipping Zipcode.";
		$errCounter++;	
	}
	
	if($_REQUEST['contact_no'] == ""){
		$GLOBALS['contact_no_err'] = "Please enter Day Phone.";
		$errCounter++;	
	}
//	if($_REQUEST['card_type'] == ""){
//			$GLOBALS['card_type_err'] = "Please Select Card Type.";
//			 $errCounter++;
//		}
//	if($_REQUEST['update_cc'] == '1'){
//		if($_REQUEST['card_type'] == ""){
//			$GLOBALS['card_type_err'] = "Please Select Card Type.";
//			 $errCounter++;
//		}
//		
//		if($_REQUEST['credit_card_no'] == ""){
//			$GLOBALS['credit_card_no_err'] = "Please Select Credit Card Number.";
//			 $errCounter++;
//		}
//		
//		if($_REQUEST['security_code'] == ""){
//			$GLOBALS['security_code_err'] = "Please enter security code";
//			 $errCounter++;
//		}
//		
//		if($_REQUEST['expired_mnth'] == ""){
//			$GLOBALS['expired_mnth_err'] = "Please select Expiry Month.";
//			$errCounter++;
//		}
//		
//		if($_REQUEST['expired_yr'] == ""){
//			$GLOBALS['expired_yr_err'] = "Please select Expiry Year.";
//			$errCounter++;
//		}
//		
//		$expired_validity = datediff_with_presentdate($_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr']);
//		if($_REQUEST['expired_mnth'] != "" && $_REQUEST['expired_yr'] != "" && $expired_validity == false){
//			$GLOBALS['expired_yr_err'] = "Your Card is Expired.";
//			$errCounter++;
//		}		
//			
//		if($errCounter == 0){
//			$validcard = checkCreditCard($_REQUEST['credit_card_no'], $_REQUEST['card_type'],$ccerror, $ccerrortext);
//			if($validcard == false || !paypalCCValidation($_REQUEST)){
//				$GLOBALS['credit_card_no_err'] = "Card is not Valid.";
//				$errCounter++;
//			}
//		}
//	}

	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function update_profile()
{
	extract($_REQUEST);
	$obj = new User();
	$data = array('firstname' => $firstname,
				  'lastname' => $lastname,
				  'email' => $email,
				  'address1' => $address1,
				  'address2' => $address2,
				  'country_id' => $country_id,
				  'state' => ($country_id == '230') ? $state_select : $state_textbox,
				  'city' => $city,
				  'zipcode' => $zipcode,
				  'shipping_firstname' => $shipping_firstname,
				  'shipping_lastname' => $shipping_lastname,
				  'shipping_address1' => $shipping_address1,
				  'shipping_address2' => $shipping_address2,
				  'shipping_country_id' => $shipping_country_id,
				  'shipping_state' => ($shipping_country_id == '230') ? $shipping_state_select : $shipping_state_textbox,
				  'shipping_city' => $shipping_city,
				  'shipping_zipcode' => $shipping_zipcode,
				  'contact_no' => $contact_no,
				  'newsletter_subscription' => $nl_subscr);
		$chk = $obj->updateData(USER_TABLE, $data, array('user_id' => $_SESSION['sessUserID']), true);
		$user_id = $_SESSION['sessUserID'];
		/*$total_array=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],"Select count(*) total from card_details where user_id=$user_id"));
		$total=$total_array['total'];
		if($total < 1){
			$cardname = $_REQUEST['card_type'];
			$cardnumber = $_REQUEST['credit_card_no'];
			$security_code = $_REQUEST['security_code'];
			$expiry_date = $_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'];
			$last_digit = substr($cardnumber,-4);
			$expired_validity = datediff_with_presentdate($expiry_date);
			if($expired_validity == true){
				$validcard = checkCreditCard($cardnumber, $cardname,$ccerror, $ccerrortext);
				if($validcard==true){
					$sql="Insert into `card_details` (user_id,card_type,card_number,security_code,expiry_date,last_digit) values ('".$_SESSION['sessUserID']."','".$cardname."','".md5($cardnumber)."','".md5($security_code)."','".$expiry_date."','".$last_digit."')";
				if(mysqli_query($GLOBALS['db_connect'],$sql)){
					$_SESSION['Err']="You card is Valid.Your account has been updated successfully.";
					header("Location: myaccount.php?mode=profile");
					exit;
				}else{
					$_SESSION['Err']="Card is not Valid.";
					header("Location: myaccount.php?mode=profile");
					exit;	
				}
			}else{
				$_SESSION['Err']="Card is not Valid.";
				header("Location: myaccount.php?mode=profile");
				exit;
			}
		 }else{
			 $_SESSION['Err']="Your Card is Expired.";
			 header("Location: myaccount.php?mode=profile");
			 exit;
		 }
	}elseif($total > 0){
		 if(isset($_REQUEST['security_code']) && $_REQUEST['security_code']!='XXX'){
			 $security_code=md5($_REQUEST['security_code']);
			 $data = array('security_code' => $security_code);	 
			 $update_card = $obj->updateData(CARD_DETAIL, $data, array('user_id' => $_SESSION['sessUserID']), true);
		 }
		if(isset($_REQUEST['expired_mnth']) && $_REQUEST['expired_mnth']!='' && isset($_REQUEST['expired_yr']) && $_REQUEST['expired_yr']!=''){
			$expiry_date=$_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'];
			$expired_validity=datediff_with_presentdate($expiry_date);
			if($expired_validity==true){ 
			$data = array('expiry_date' => $expiry_date);	 
			$update_card = $obj->updateData(CARD_DETAIL, $data, array('user_id' => $_SESSION['sessUserID']), true);
			}else{
			$_SESSION['Err']="Your Card is Expired.";
			header("location: myaccount.php?mode=profile");
			exit(); 
			}
		}
		if($chk == true){		
			$_SESSION['Err']="Your account has been updated successfully.";
			header("location: myaccount.php?mode=profile");
			exit();
		}else{
			$_SESSION['Err']="Your account has not been updated successfully.";
			header("location: myaccount.php?mode=profile");
			exit();
		}
	}*/

	//$cardData = array('card_type' => $_POST['card_type'], 'card_number' => md5(trim($_POST['credit_card_no'])), 'security_code' => md5(trim($_POST['security_code'])),
					 // 'expiry_date' => $_REQUEST['expired_mnth'].'-'.$_REQUEST['expired_yr'], 'last_digit' => substr(trim($_POST['credit_card_no']),-4,4));
	//$obj->updateData(CARD_DETAIL, $cardData, array('user_id' => $_SESSION['sessUserID']), true);
	
	if($chk == true){		
		$_SESSION['Err']="Your account has been updated successfully.";
		header("location: myaccount.php?mode=profile");
		exit();
	}else{
		$_SESSION['Err']="Your account has not been updated successfully.";
		header("location: myaccount.php?mode=profile");
		exit();
	}
}

function inbox() {
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_to' => $_SESSION['sessUserID'], "message_is_toadmin" => 0, "message_is_deleted_to" => 0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	
	if($total>0){
		$messageRows = $obj->listInbox($where, array('*'));
		$smarty->assign('messageRows', $messageRows);
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
					  'message_from' => $_SESSION['sessUserID'],
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
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", $encoded_string);
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_id' => $message_id, 'message_is_toadmin' => '1', "message_is_deleted_to" => 0);
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
	
	$smarty->display('admin_message_read.tpl');	
}

function reply() {
	require_once INCLUDE_PATH."lib/common.php";
	
	extract($_REQUEST);
	$smarty->assign ("encoded_string", $encoded_string);
	$smarty->assign ("message_id", $message_id);
	
	$obj = new Message();
	$where = array('message_id' => $message_id, 'message_is_toadmin' => '1');
	$message = $obj->readMessage($where, array('message_subject', 'message_to'));
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
				  'message_from' => $_SESSION['sessUserID'],
				  'message_is_new' => '1',
				  'message_is_toadmin' => '0',
				  'message_is_fromadmin' => '1');

	$id = $obj->updateData(TBL_MESSAGE, $data);
	
	if(count($ids) > 0){
		$_SESSION['adminErr'] = "Message sent successfully.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}else{
		$_SESSION['adminErr'] = "Can not send message. Please try again.";
		header("location: ".PHP_SELF."?mode=read&message_id=$message_id&encoded_string=".$encoded_string);
	}
}

function sent_messages() {
	require_once INCLUDE_PATH."lib/common.php";	
	
	extract($_REQUEST);
	$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
	$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string']));
	
	$obj = new Message();
	$where = array('message_from' => $_SESSION['sessUserID'], "message_is_fromadmin" => 1, "message_is_toadmin" => 0, "message_is_deleted_from" => 0);
	$total = $obj->countData(TBL_MESSAGE, $where);
	
	if($total>0){
		$messageRows = $obj->listSentMessages($where, array('*'));
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
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $message_id, "message_to" => $_SESSION['sessUserID']), true);

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
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_to" => 1), array("message_id" => $val, "message_to" => $_SESSION['sessUserID']), true);
		if($chk == false){
			$flag = 0;
		}
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
	$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $message_id, "message_to" => $_SESSION['sessUserID']), true);

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
	foreach($_REQUEST['message_ids'] as $val){
		$chk = $obj->updateData(TBL_MESSAGE, array("message_is_deleted_from" => 1), array("message_id" => $val, "message_to" => $_SESSION['sessUserID']), true);
		if($chk == false){
			$flag = 0;
		}
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

function change_password()
{
	require_once INCLUDE_PATH."lib/common.php";

	foreach ($_POST as $key => $value ) {
		$smarty->assign($key, $value);
	}
	
	foreach ($_POST as $key => $value ) {
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);'); 
	}

	$smarty->display("change_password.tpl");
}

function validateChangePassword(){
	$errCounter=0;
	
	if(trim($_POST['oldpassword'])==""){
		$errCounter++;
		$GLOBALS['oldpassword_err'] = "Please enter your old password.";
	}else{
		$obj = new User;
		$obj->userID = $_SESSION['sessUserID'];
		$obj->password = $_POST['oldpassword'];
		$chk = $obj->checkPassword();
		if($chk == false){
			$errCounter++;
			$GLOBALS['oldpassword_err'] = "Sorry! You have entered wrong password.";
		}
	}
	if(trim($_POST['newpassword'])==""){
		$errCounter++;
		$GLOBALS['newpassword_err'] = "Please enter your new password.";
	}
	if(trim($_POST['cnewpassword'])==""){
		$errCounter++;
		$GLOBALS['cnewpassword_err'] = "Please enter your new password in confirm box.";
	}
	if(trim($_POST['cnewpassword'])!=trim($_POST['newpassword'])){
		$errCounter++;
		$GLOBALS['cnewpassword_err'] = "Please enter same password in confirm box.";
	}
	
	if($errCounter>0){
		return false;
	}
	else{
		return true;
	}
}

function update_password(){
	
	$obj = new User;
	$obj->userID = $_SESSION['sessUserID'];
	$obj->username = $_SESSION['sessUsername'];
	$obj->password = trim($_POST['newpassword']);
	
	$chk = $obj->updatePassword();
	if($chk == true){
		$_SESSION['Err'] = "Your password has been updated successfully.";
		header("Location: myaccount.php?mode=change_password");
		exit;
	}else{
		$_SESSION['Err'] = "Your password not updated successfully.";
		header("Location: myaccount.php?mode=change_password");
		exit;
	}
}

function logout()
{
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
	header("Location: index.php");
	exit;
}

function removeExpiredPosters($invoice_id,$auction_id){
		 require_once INCLUDE_PATH."lib/common.php";
		 $deleteInvoice= "Delete from tbl_invoice where invoice_id='".$invoice_id."'  ";
         mysqli_query($GLOBALS['db_connect'],$deleteInvoice);
			
         $delete= "Delete from tbl_invoice_to_auction where fk_invoice_id='".$invoice_id."' AND fk_auction_id = '".$auction_id."' ";
         mysqli_query($GLOBALS['db_connect'],$delete);

         $updateAuction= "Update tbl_auction set auction_is_sold= '0' where auction_id = '".$auction_id."' ";
         mysqli_query($GLOBALS['db_connect'],$updateAuction);
 }
####################  Checking card details is valid or not #############################


####################  Checking card is expired or not #############################



?>
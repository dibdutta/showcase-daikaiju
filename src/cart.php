<?php
ob_start();
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}

chkLoginNow();
if(isset($_SESSION['cart'])){
	$cartObj = new Cart();
	$chk = $cartObj->chkAuctionStatus($_SESSION['cart']);
	if($chk == false){
		dispmiddle();
		exit;
	}
}

if($_REQUEST['mode']=='shippinginfo'){
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0){
		header("Location: cart.php");
		exit;
	}else{
		shippingInfo();
	}
}elseif($_POST['mode']=='paymentoption'){
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0){
		header("Location: cart.php");
		exit;
	}else{
		$check = validateShippingInfo();
		if($check){
			chooseOptionForPayment();
		}else{
			shippingInfo();
		}
	}
}elseif($_POST['mode']=='finalorder'){
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0){
		header("Location: cart.php");
		exit;
	}else{	
		$check = validatePaymentOption();
		if($check){
			order_details();
		}else{
			paymentOption();
			//header("location: cart.php?mode=paymentoption");
			//exit;
		}
	}
}elseif($_POST['mode']=='pay_now'){
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0){
		header("Location: cart.php");
		exit;
	}else{
		$check = validatePaymentNow();
		if($check){
			pay_now();
		}else{
			order_details();
			exit;
			//header("location: cart.php?mode=paymentoption");
			//exit;
		}
	}
}elseif($_POST['mode']=='update_cart'){
	if(!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0){
		header("Location: cart.php");
		exit;
	}else{
		update_cart();
	}
}elseif($_REQUEST['mode']=='cancel_payment'){
	cancel_payment();
}elseif($_REQUEST['mode']=='do_direct_payment'){
 paymentOption();
}elseif($_REQUEST['mode']=='do_express_checkout'){
 setExpressCheckout();
}elseif($_REQUEST['mode']=='do_express_reviewoder'){
 expressReviewOrder();
}elseif($_REQUEST['mode']=='do_express_checkout_details'){
 getExpressCheckoutDetails();
}else{
 	dispmiddle();
}
ob_end_flush();
	
function dispmiddle()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_REQUEST['id'])){
		$cartObj = new Cart();
		$cartObj->addToCart($_REQUEST['id'], $_SESSION['sessUserID']);
	}
	if(!empty($_SESSION['sold_item'])){
		$count_sold_item=count($_SESSION['sold_item']);	
		$smarty->assign('sold_item', $_SESSION['sold_item']);
		$smarty->assign('count_sold_item', $count_sold_item);
	}
	if($GLOBALS['errorMessage'] != ""){
		$smarty->assign('errorMessage', $GLOBALS['errorMessage']);
	}
	$smarty->assign('total', count($_SESSION['cart']));
	$smarty->assign('cart', $_SESSION['cart']);
	$smarty->display('cart.tpl');
}

function update_cart()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	if(is_array($_REQUEST['auction_ids'])){
		foreach($_REQUEST['auction_ids'] as $reqKey => $reqValue){
			foreach($_SESSION['cart'] as $key => $value){
				if($reqValue == $value['auction_id']){
					unset($_SESSION['cart'][$key]);
                    $sql_delete=mysqli_query($GLOBALS['db_connect'],"Delete from ".TBL_CART_HISTORY." where `fk_auction_id`='".$value['auction_id']."' and fk_user_id='".$_SESSION['sessUserID']."'");
					$sql_update=mysqli_query($GLOBALS['db_connect'],"Update ".TBL_AUCTION." SET `in_cart`='0' WHERE `auction_id`='".$value['auction_id']."' ");
					break;
				}
			}
		}
		
		$cart = array();
		foreach($_SESSION['cart'] as $key => $value){
			$cart[] = $value;
		}
		$_SESSION['cart'] = $cart;
	}else{
		$_SESSION['Err']="Please select a poster to remove.";
	}
	
	$smarty->assign('total', count($_SESSION['cart']));
	$smarty->assign('cart', $_SESSION['cart']);
	header("location: cart.php");
	exit;
}

function shippingInfo()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	if(!empty($_SESSION['cart'])){
		$invoiceObj = New Invoice();
		$weight_array = $invoiceObj->findWeightArrayForCart($_SESSION['cart']);	
	}

	$rs = getCountryList();
	while($row = mysqli_fetch_array($rs)){
		$countryName[] = $row[COUNTRY_NAME];
		$countryID[] = $row[COUNTRY_ID];		
	}
	$smarty->assign('countryID', $countryID);
	$smarty->assign('countryName', $countryName);
	$smarty->assign('country_id', $_POST['country_id']);
	
	$userObj = new User();
	$dataArr = array("firstname", "lastname", "country_id", "city",
					 "state", "address1", "address2", "zipcode",
					 "shipping_firstname", "shipping_lastname", "shipping_country_id", "shipping_city",
					 "shipping_state", "shipping_address1", "shipping_address2", "shipping_zipcode");
	$userData = $userObj->selectData(USER_TABLE, $dataArr, array("user_id" => $_SESSION['sessUserID']));
	$smarty->assign('userData', $userData);
	$smarty->assign('weight_array', implode(',', $weight_array));
	
	foreach ($_POST as $key => $value){
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$commonObj = new DBCommon();
	$commonObj->orderBy='name';
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name'),$where = '1',true);
	$smarty->assign('us_states', $us_states);
	
	$smarty->assign('shipping_methods_err', $GLOBALS['shipping_methods_err']);
	$smarty->assign('shipping_charge_err', $GLOBALS['shipping_charge_err']);

	$smarty->assign('total_item', count($weight_array));
	$smarty->display('shippinginfo.tpl');
}

function validateShippingInfo()
{
	extract($_POST);
	$errCounter = 0;
	
	if($billing_firstname == ""){
		$GLOBALS['billing_firstname_err'] = "Please enter Billing Firstname.";
		$errCounter++;	
	}
	
	if($billing_lastname == ""){
		$GLOBALS['billing_lastname_err'] = "Please enter Billing Lastname.";
		$errCounter++;	
	}
	
	if($billing_address1 == ""){
		$GLOBALS['billing_address1_err'] = "Please enter Billing Address.";
		$errCounter++;	
	}
	
	if($billing_country_id == ""){
		$GLOBALS['billing_country_id_err'] = "Please enter Billing Country.";
		$errCounter++;	
	}
	
    /*if($billing_country_id != 230 && $billing_state_textbox == ""){
        $GLOBALS['billing_state_textbox_err'] = "Please enter a Billing State.";
        $errCounter++;  
    }else*/if($billing_country_id == 230 && $billing_state_select == ""){
        $GLOBALS['billing_state_select_err'] = "Please select a Billing State.";
        $errCounter++;  
	}
	
	if($billing_city == ""){
		$GLOBALS['billing_city_err'] = "Please enter Billing City.";
		$errCounter++;	
	}
	
	if($billing_zipcode == ""){
		$GLOBALS['billing_zipcode_err'] = "Please enter Billing Zipcode.";
		$errCounter++;	
	}
	
	if($shipping_firstname == ""){
		$GLOBALS['shipping_firstname_err'] = "Please enter Shipping Firstname.";
		$errCounter++;	
	}
	
	if($shipping_lastname == ""){
		$GLOBALS['shipping_lastname_err'] = "Please enter Shipping Lastname.";
		$errCounter++;	
	}
	
	if($shipping_address1 == ""){
		$GLOBALS['shipping_address1_err'] = "Please enter Shipping Address.";
		$errCounter++;	
	}
	
	if($shipping_country_id == ""){
		$GLOBALS['shipping_country_id_err'] = "Please enter Shipping Country.";
		$errCounter++;	
	}
	
    /*if($shipping_country_id != 230 && $shipping_state_textbox == ""){
        $GLOBALS['shipping_state_textbox_err'] = "Please enter a Shipping State.";
        $errCounter++;  
    }else*/if($shipping_country_id == 230 && $shipping_state_select == ""){
        $GLOBALS['shipping_state_select_err'] = "Please select a Shipping State.";
        $errCounter++;  
	}
	
	if($shipping_city == ""){
		$GLOBALS['shipping_city_err'] = "Please enter Shipping City.";
		$errCounter++;	
	}
	
	if($shipping_zipcode == ""){
		$GLOBALS['shipping_zipcode_err'] = "Please enter Shipping Zipcode.";
		$errCounter++;	
	}
	
	//if(!isset($shipping_methods) || !isset($shipping_charge)){
	if(!isset($shipping_methods)){
		$GLOBALS['shipping_methods_err'] = "Please select a Shipping Method.";
		$errCounter++;	
	}
	
	if(!isset($shipping_charge)){
		$GLOBALS['shipping_charge_err'] = "Please select a Shipping Option.";
		$errCounter++;	
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function paymentOption()
{
	require_once INCLUDE_PATH."lib/common.php";
	$dbCommonObj = new DBCommon();
	
	foreach ($_POST as $key => $value){
		if(substr($key, 0, 7) == 'billing'){

			if($key == 'billing_country_id'){
				$row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['billing_info']['billing_country_name'] = $row[0]['country_name'];
				$_SESSION['billing_info']['billing_country_code'] = $row[0]['country_code'];
			}elseif($key == 'billing_state_textbox' && $_POST['billing_country_id'] != '230'){
				$_SESSION['billing_info']['billing_state'] = $_POST['billing_state_textbox'];
			}elseif($key == 'billing_state_select' && $_POST['billing_country_id'] == '230'){
				$_SESSION['billing_info']['billing_state'] = $_POST['billing_state_select'];
			}else{
				$_SESSION['billing_info'][$key] = $value;
			}

		}elseif(substr($key, 0, 8) == 'shipping'){

			if($key == 'shipping_country_id'){
				$row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['shipping_info']['shipping_country_name'] = $row[0]['country_name'];
				$_SESSION['shipping_info']['shipping_country_code'] = $row[0]['country_code'];
			}elseif($key == 'shipping_state_textbox' && $_POST['shipping_country_id'] != '230'){
				$_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_textbox'];
			}elseif($key == 'shipping_state_select' && $_POST['shipping_country_id'] == '230'){
				$_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_select'];
				
				if($_POST['shipping_state_select'] == 'Georgia'){
					$_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_GA;
					
					foreach($_SESSION['cart'] as $key => $value){
						$total_price += $value['amount'];
					}
					$_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_GA/100);
					
				}elseif($_POST['shipping_state_select'] == 'North Carolina'){
					$_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_NC;

					foreach($_SESSION['cart'] as $key => $value){
						$total_price += $value['amount'];
					}
					$_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_NC/100);
						
				}else{
					unset($_SESSION['shipping_info']['sale_tax_percentage']);
					unset($_SESSION['shipping_info']['sale_tax_amount']);
				}
				
			}else{
				$_SESSION['shipping_info'][$key] = $value;
			}
		}
	}
	
	foreach ($_POST as $key => $value){
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('paymentoption.tpl');
}

function validatePaymentOption()
{
	extract($_POST);
	$errCounter = 0;
	
	if($firstname == ""){
		$GLOBALS['firstname_err'] = "Please enter Firstname.";
		$errCounter++;	
	}
	
	if($lastname == ""){
		$GLOBALS['lastname_err'] = "Please enter Lastname.";
		$errCounter++;	
	}
	
	if($cc_type == ""){
		$GLOBALS['cc_type_err'] = "Please enter Card Type.";
		$errCounter++;	
	}
	
	if($cc_number == ""){
		$GLOBALS['cc_number_err'] = "Please enter Card Number.";
		$errCounter++;	
	}
	
	if($cvv2Number == ""){
		$GLOBALS['cvv2Number_err'] = "Please enter Card Verification Number.";
		$errCounter++;	
	}
	$expiry_date = $_REQUEST['exp_Month'].'-'.$_REQUEST['exp_Year'];
	$expired_validity = datediff_with_presentdate($expiry_date);
	if($expired_validity == false){
		$_SESSION['Err']="Your Card has been Expired.";
		$errCounter++;
	}else{
	$validcard = checkCreditCard($_REQUEST['cc_number'], $_REQUEST['cc_type'],$ccerror, $ccerrortext);
	if($validcard==false){
		$_SESSION['Err']="Card is not Valid.";
		$errCounter++;
	 }
	}
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function order_details()
{
	require_once INCLUDE_PATH."lib/common.php";

	foreach ($_POST as $key => $value){
		if($key != 'mode')
			$_SESSION['cc_info'][$key] = $value;
	}
	
	$smarty->assign("err_msg", $GLOBALS["err_msg"]);
	
	$obj = new DBCommon();
	
	$shippingCountry = $obj->selectData(COUNTRY_TABLE, array('country_name'), array('country_id' => $_POST['country_id']));
	$smarty->assign('shipping_country_name', $shippingCountry[0]['country_name']); 
	
	$userData = $obj->selectData(USER_TABLE, array('*'), array('user_id' => $_SESSION['sessUserID']));
	$smarty->assign('userData', $userData);
	$billingCountry = $obj->selectData(COUNTRY_TABLE, array('country_name'), array('country_id' => $userData[0]['country_id']));
	$smarty->assign('country_name', $billingCountry[0]['country_name']); 
	
	$smarty->assign('cart', $_SESSION['cart']);
	$smarty->assign('billing_info', $_SESSION['billing_info']);
	$smarty->assign('shipping_info', $_SESSION['shipping_info']);
	
	$smarty->display('order_details.tpl');
}

/*function validatePayNow()
{
	$errCounter = 0;
	
	if($_SESSION['billing_firstname'] == ""){
		$err['billing_firstname_err'] = "Please enter Billing Firstname.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_lastname'] == ""){
		$err['billing_lastname_err'] = "Please enter Billing Lastname.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_address1'] == ""){
		$err['billing_address1_err'] = "Please enter Billing Address.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_city'] == ""){
		$err['billing_city_err'] = "Please enter Billing City.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_state'] == ""){
		$err['billing_state_err'] = "Please enter Billing State.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_zipcode'] == ""){
		$err['billing_zipcode_err'] = "Please enter Billing Zipcode.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_country_id'] == ""){
		$err['billing_country_id_err'] = "Please enter Billing Country.";
		$errCounter++;	
	}
	
	if($_SESSION['billing_country_code'] == ""){
		$err['billing_country_code_err'] = "Billing Country is missing.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_firstname'] == ""){
		$err['shipping_firstname_err'] = "Please enter Shipping Firstname.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_lastname'] == ""){
		$err['shipping_lastname_err'] = "Please enter Shipping Lastname.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_address1'] == ""){
		$err['shipping_address1_err'] = "Please enter Shipping Address.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_city'] == ""){
		$err['shipping_city_err'] = "Please enter Shipping City.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_state'] == ""){
		$err['shipping_state_err'] = "Please enter Shipping State.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_zipcode'] == ""){
		$err['shipping_zipcode_err'] = "Please enter Shipping Zipcode.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_country_id'] == ""){
		$err['shipping_country_id_err'] = "Please enter Shipping Country.";
		$errCounter++;	
	}
	
	if($_SESSION['shipping_country_code'] == ""){
		$err['shipping_country_code_err'] = "Shipping Country is missing.";
		$errCounter++;	
	}
	
	if(!isset($shipping_methods)){
		$GLOBALS['shipping_methods_err'] = "Please select a Shipping Method.";
		$errCounter++;	
	}
	
	if(!isset($shipping_charge)){
		$GLOBALS['shipping_charge_err'] = "Please select a Shipping Option.";
		$errCounter++;	
	}
	
	if($firstname == ""){
		$GLOBALS['firstname_err'] = "Please enter Firstname.";
		$errCounter++;	
	}
	
	if($lastname == ""){
		$GLOBALS['lastname_err'] = "Please enter Lastname.";
		$errCounter++;	
	}
	
	if($cc_type == ""){
		$GLOBALS['cc_type_err'] = "Please enter Card Type.";
		$errCounter++;	
	}
	
	if($cc_number == ""){
		$GLOBALS['cc_number_err'] = "Please enter Card Number.";
		$errCounter++;	
	}
	
	if($cvv2Number == ""){
		$GLOBALS['cvv2Number_err'] = "Please enter Card Verification Number.";
		$errCounter++;	
	}
	
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}*/

function validatePaymentNow()
{
	$errCounter = 0;
	$auctionObj = new Auction();
	foreach($_SESSION['cart'] as $key => $value){
		$counter = $auctionObj->countData(TBL_AUCTION, array('auction_id' => $value['auction_id'], 'is_paying' => 1));
		if($counter > 0){
			$errCounter++;
			$GLOBALS['err_msg'] = "Please try after sometime.";
			break;
		}
	}
	if($errCounter > 0){
		return false;
	}else{
		return true;
	}
}

function pay_now()
{
 	require_once INCLUDE_PATH."lib/common.php";
	
 	extract($_POST);
 	$objPaypal = new Paypal_DoDirectPayment();
	$objCommon = new DBCommon();
	
	foreach($_SESSION['cart'] as $key => $value){
		$cartSubTotal += $value['amount'];
		$objCommon->updateData(TBL_AUCTION, array('is_paying' => 1), array('auction_id' => $value['auction_id']), true);
	}
	$cartTotal = $cartSubTotal + $_SESSION['shipping_info']['shipping_charge'] + $_SESSION['shipping_info']['sale_tax_amount'];

	$objPaypal->amount = number_format($cartTotal, 2, ".", "");
 	$objPaypal->firstName = $_SESSION['cc_info']['firstname'];
 	$objPaypal->lastName = $_SESSION['cc_info']['lastname'];
 	$objPaypal->ccType = $_SESSION['cc_info']['cc_type'];
 	$objPaypal->ccNumber = $_SESSION['cc_info']['cc_number'];
 	$objPaypal->cvv2 = $_SESSION['cc_info']['cvv2Number'];
	$objPaypal->expdate = $_SESSION['cc_info']['exp_Month'].$_SESSION['cc_info']['exp_Year'];

 	$objPaypal->address = $_SESSION['billing_info']['billing_address1'].",".$_SESSION['billing_info']['billing_address2'];
 	$objPaypal->city = $_SESSION['billing_info']['billing_city'];
 	$objPaypal->stateCode = $_SESSION['billing_info']['billing_state'];
 	$objPaypal->zip = $_SESSION['billing_info']['billing_zipcode'];
	
	$row = $objCommon->selectData(COUNTRY_TABLE, array('country_code', 'currency'), array('country_id' => $_SESSION['billing_info']['billing_country_id']));
	
 	$objPaypal->countryCode = $_SESSION['billing_info']['billing_country_code'];
 	//$objPaypal->currencyCode = ($row[0]['currency'] == '') ? 'USD' : $row[0]['currency'];
	$objPaypal->currencyCode = CURRENCY_CODE;
	
	$objPaypal->API_Endpoint = API_ENDPOINT;
	$objPaypal->version = VERSION;
	$objPaypal->API_UserName = API_USERNAME;
	$objPaypal->API_Password = API_PASSWORD;
	$objPaypal->API_Signature = API_SIGNATURE;
	$objPaypal->subject = SUBJECT;
 	$resArray = $objPaypal->hash_call();
 	
	if(preg_match("/success/i",$resArray['ACK'])){ 
		$invoiceObj = new Invoice();
		$invoice_id = $invoiceObj->processInstantPaymentInvoice($_SESSION['sessUserID'], $_SESSION['cart'], $_SESSION['billing_info'], $_SESSION['shipping_info']);
		
		foreach($_SESSION['cart'] as $key => $value){
				$sql_SellerMail="Select u.email,u.firstname,u.lastname,p.poster_title from tbl_poster p,user_table u ,tbl_auction a
						 where a.auction_id= '".$value['auction_id']."'  and a.fk_poster_id=p.poster_id and p.fk_user_id=u.user_id ";
				$res_sql_SellerMail=mysqli_query($GLOBALS['db_connect'],$sql_SellerMail);
				$rowSeller=mysqli_fetch_array($res_sql_SellerMail);
				$toMailSeller = $rowSeller['email'];
			    $toNameSeller = $rowSeller['firstname'].' '.$row['lastname'];
			    $subject = "MPE::Poster Sold - ".$rowSeller['poster_title']." ";
			    $fromMail = ADMIN_EMAIL_ADDRESS;
			    $fromName = ADMIN_NAME;
			    
			    $textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br /><br />';
			    $textContentSeller.= 'Congratulations!Your Poster <b>(Poster Title : '.$rowSeller['poster_title'].'</b>) has been sold.<br />';
			    $textContentSeller .= 'For more details, please <a href="http://'.HOST_NAME.'">login </a><br /><br />';
			    $textContentSeller.= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
				$textContentSeller= MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM; 
				$check = sendMail($toMailSeller, $toNameSeller, $subject, $textContentSeller, $fromMail, $fromName, $html=1);
			$invoiceObj->updateData(TBL_CART_HISTORY, array('is_paid' => '1'), array('fk_auction_id' => $value['auction_id']), true);
			$invoiceObj->updateData(TBL_OFFER, array('offer_is_accepted' => '2'), array('offer_fk_auction_id' => $value['auction_id']), true);
		}
	
		unset($_SESSION['cart']);
		unset($_SESSION['billing_info']);
		unset($_SESSION['shipping_info']);
		unset($_SESSION['cc_info']);
		
		$_SESSION['Err'] = "Payment is done successfully!";
	}else{
		$invoiceObj = new Invoice();
		foreach($_SESSION['cart'] as $key => $value){
			$invoiceObj->updateData(TBL_AUCTION, array('is_paying' => '0'), array('auction_id' => $value['auction_id']), true);
			
		}
		$_SESSION['Err'] = "Payment failed. Please try again!"."<br/>"." Paypal Error Code:". $resArray['L_ERRORCODE0']."&nbsp;".$resArray['L_LONGMESSAGE0'];
		//$smarty->assign('errorMessage', $_SESSION['Err']);
	}
	header("location: my_invoice?invoice_id=".$invoice_id);
	exit;
}

function cancel_payment()
{
	unset($_SESSION['billing_info']);
	unset($_SESSION['shipping_info']);
	unset($_SESSION['cc_info']);
	
	$_SESSION['Err'] = "Payment process is cancelled.";
	header("location: cart.php");
	exit;
}

function chooseOptionForPayment(){
 require_once INCLUDE_PATH."lib/common.php";
 
 $dbCommonObj = new DBCommon();
 
 foreach ($_POST as $key => $value){
  if(substr($key, 0, 7) == 'billing'){

   if($key == 'billing_country_id'){
    $row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
    $_SESSION['billing_info']['billing_country_name'] = $row[0]['country_name'];
    $_SESSION['billing_info']['billing_country_code'] = $row[0]['country_code'];
   }elseif($key == 'billing_state_textbox' && $_POST['billing_country_id'] != '230'){
    $_SESSION['billing_info']['billing_state'] = $_POST['billing_state_textbox'];
   }elseif($key == 'billing_state_select' && $_POST['billing_country_id'] == '230'){
    $_SESSION['billing_info']['billing_state'] = $_POST['billing_state_select'];
   }else{
    $_SESSION['billing_info'][$key] = $value;
   }

  }elseif(substr($key, 0, 8) == 'shipping'){

   if($key == 'shipping_country_id'){
    $row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
    $_SESSION['shipping_info']['shipping_country_name'] = $row[0]['country_name'];
    $_SESSION['shipping_info']['shipping_country_code'] = $row[0]['country_code'];
   }elseif($key == 'shipping_state_textbox' && $_POST['shipping_country_id'] != '230'){
    $_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_textbox'];
   }elseif($key == 'shipping_state_select' && $_POST['shipping_country_id'] == '230'){
    $_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_select']; 
    
    if($_POST['shipping_state_select'] == 'Georgia'){
     $_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_GA;
     
     foreach($_SESSION['cart'] as $key => $value){
      $total_price += $value['amount'];
     }
     $_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_GA/100);
     
    }elseif($_POST['shipping_state_select'] == 'North Carolina'){
     $_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_NC;

     foreach($_SESSION['cart'] as $key => $value){
      $total_price += $value['amount'];
     }
     $_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_NC/100);
      
    }else{
     unset($_SESSION['shipping_info']['sale_tax_percentage']);
     unset($_SESSION['shipping_info']['sale_tax_amount']);
    }
    
   }else{
    $_SESSION['shipping_info'][$key] = $value;
   }
  }
 }
 
 foreach ($_POST as $key => $value){
  $smarty->assign($key, $value); 
  eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
 }
 $smarty->display('choose_option_for_payment.tpl');
} 

function setExpressCheckout(){
	require_once INCLUDE_PATH."lib/common.php";
	$dbCommonObj = new DBCommon();
	
	foreach ($_POST as $key => $value){
		if(substr($key, 0, 7) == 'billing'){

			if($key == 'billing_country_id'){
				$row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['billing_info']['billing_country_name'] = $row[0]['country_name'];
				$_SESSION['billing_info']['billing_country_code'] = $row[0]['country_code'];
			}elseif($key == 'billing_state_textbox' && $_POST['billing_country_id'] != '230'){
				$_SESSION['billing_info']['billing_state'] = $_POST['billing_state_textbox'];
			}elseif($key == 'billing_state_select' && $_POST['billing_country_id'] == '230'){
				$_SESSION['billing_info']['billing_state'] = $_POST['billing_state_select'];
			}else{
				$_SESSION['billing_info'][$key] = $value;
			}

		}elseif(substr($key, 0, 8) == 'shipping'){

			if($key == 'shipping_country_id'){
				$row = $dbCommonObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['shipping_info']['shipping_country_name'] = $row[0]['country_name'];
				$_SESSION['shipping_info']['shipping_country_code'] = $row[0]['country_code'];
			}elseif($key == 'shipping_state_textbox' && $_POST['shipping_country_id'] != '230'){
				$_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_textbox'];
			}elseif($key == 'shipping_state_select' && $_POST['shipping_country_id'] == '230'){
				$_SESSION['shipping_info']['shipping_state'] = $_POST['shipping_state_select'];
				
				if($_POST['shipping_state_select'] == 'Georgia'){
					$_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_GA;
					
					foreach($_SESSION['cart'] as $key => $value){
						$total_price += $value['amount'];
					}
					$_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_GA/100);
					
				}elseif($_POST['shipping_state_select'] == 'North Carolina'){
					$_SESSION['shipping_info']['sale_tax_percentage'] = SALE_TAX_NC;

					foreach($_SESSION['cart'] as $key => $value){
						$total_price += $value['amount'];
					}
					$_SESSION['shipping_info']['sale_tax_amount'] = ($total_price*SALE_TAX_NC/100);
						
				}else{
					unset($_SESSION['shipping_info']['sale_tax_percentage']);
					unset($_SESSION['shipping_info']['sale_tax_amount']);
				}
				
			}else{
				$_SESSION['shipping_info'][$key] = $value;
			}
		}
	}
	
	foreach ($_POST as $key => $value){
		$smarty->assign($key, $value); 
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	
	$smarty->display('setexpresscheckout.tpl');
}

function getExpressCheckoutDetails(){
	require_once INCLUDE_PATH."lib/common.php";
	
	$smarty->assign('cart', $_SESSION['cart']);
	$smarty->assign('billing_info', $_SESSION['billing_info']);
	$smarty->assign('shipping_info', $_SESSION['shipping_info']);
	
	
	//$_SESSION['token'] = $_REQUEST['token'];
	//$_SESSION['payer_id'] = $_REQUEST['PayerID'];
	
	//$_SESSION['paymentAmount'] = $_REQUEST['paymentAmount'];
	//$_SESSION['currCodeType'] = $_REQUEST['currencyCodeType'];
	//$_SESSION['paymentType'] = $_REQUEST['paymentType'];
	
	//$resArray = $_SESSION['reshash'];
	//$_SESSION['TotalAmount'] = $resArray['AMT'] + $resArray['SHIPDISCAMT'];
	
	$resArray = $_SESSION['reshash'];
	$smarty->assign('resArray', $resArray);
 	$smarty->display('getExpressCheckoutdetails.tpl');
}
?>
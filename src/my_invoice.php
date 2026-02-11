<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start(); 
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
if(!isset($_SESSION['sessUserID'])){
	header("Location: index.php");
	exit;
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='print'){
	print_invoice();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=='buyer'){
	buyer_invoice();
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=='buyer_print'){
	buyer_print_invoice();
}elseif($_REQUEST['mode']=='order'){
	order();
}elseif($_REQUEST['mode']=='shippinginfo'){
	if(isset($_REQUEST['invoice_id']) && $_REQUEST['invoice_id'] != ''){
		$invoiceObj = new Invoice();
		$where = array('invoice_id' => $_REQUEST['invoice_id'], 'fk_user_id' => $_SESSION['sessUserID'], 'is_paid' => 0, 'is_approved' => 1, 'is_cancelled' => 0);
		$counter = $invoiceObj->countData(TBL_INVOICE, $where);

		if($counter == 0){
			dispmiddle();
		}else{
			shippingInfo();
		}
	}else{
		dispmiddle();
	}
}/*elseif($_POST['mode']=='update_shipping'){
	$check = validateShippingInfo();
	if($check){
		updateShippingInfo();
	}else{
		shippingInfo();
	}
}*/elseif($_POST['mode'] == 'paymentoption'){
	if(isset($_POST['invoice_id']) && $_POST['invoice_id'] != ''){
		$invoiceObj = new Invoice();
		$where = array('invoice_id' => $_POST['invoice_id'], 'fk_user_id' => $_SESSION['sessUserID'], 'is_paid' => 0, 'is_approved' => 1, 'is_cancelled' => 0);
		$counter = $invoiceObj->countData(TBL_INVOICE, $where);

		if($counter == 0){
			dispmiddle();
		}else{
			$check = validateShippingInfo();
			if($check){
				//paymentOption();
				chooseOptionForPayment();
			}else{
				shippingInfo();
			}
		}
	}else{
		dispmiddle();
	}
}elseif($_POST['mode']=='finalorder'){
	if(isset($_POST['invoice_id']) && $_POST['invoice_id'] != ''){
		$invoiceObj = new Invoice();
		$where = array('invoice_id' => $_POST['invoice_id'], 'fk_user_id' => $_SESSION['sessUserID'], 'is_paid' => 0, 'is_approved' => 1, 'is_cancelled' => 0);
		$counter = $invoiceObj->countData(TBL_INVOICE, $where);

		if($counter == 0){
			dispmiddle();
		}else{
			$check = validatePaymentOption();
			if($check){
				finalorder();
			}else{
				paymentOption();
			}
		}
	}else{
		dispmiddle();
	}	
}elseif($_POST['mode']=='pay_now'){
	if(isset($_POST['invoice_id']) && $_POST['invoice_id'] != ''){
		$invoiceObj = new Invoice();
		$where = array('invoice_id' => $_POST['invoice_id'], 'fk_user_id' => $_SESSION['sessUserID'], 'is_paid' => 0, 'is_approved' => 1, 'is_cancelled' => 0);
		$counter = $invoiceObj->countData(TBL_INVOICE, $where);

		if($counter == 0){
			dispmiddle();
		}else{
			pay_now();
		}
	}else{
		dispmiddle();
	}
}elseif($_REQUEST['mode']=='cancel_payment'){
	cancel_payment();
}elseif($_REQUEST['mode']=='do_direct_payment'){
//var_dump(session_id());
	paymentOption();
}elseif($_REQUEST['mode']=='do_express_checkout'){
 setExpressCheckout();
}elseif($_REQUEST['mode']=='do_express_reviewoder'){
 expressReviewOrder();
}elseif($_REQUEST['mode']=='do_express_checkout_details'){
 getExpressCheckoutDetails();
}elseif($_REQUEST['mode']=='combine_buyer_invoice'){
    combine_buyer_invoice();
}elseif($_REQUEST['mode']=='archive_buyer_invoice'){
    archive_buyer_invoice();
}elseif($_REQUEST['mode']=='generate_buy_now_invoice'){
    generate_buy_now_invoice();
}elseif($_REQUEST['mode']=='phone_order'){
    phone_order();
}elseif($_REQUEST['mode']=='order_now'){
    order_now();
}elseif($_REQUEST['mode']=='archive_invoice'){
    archive_invoice();
}else{
	dispmiddle();	
}
ob_end_flush();

function dispmiddle(){
	require_once INCLUDE_PATH."lib/common.php";
	$objInvoice = new Invoice();
	//$dataArr = $objInvoice->AuctionIdByUserId($_SESSION['sessUserID']);
	$data = array('invoice_id','auction_details','total_amount','invoice_generated_on','is_paid','is_approved','is_cancelled');
	$dataArr = $objInvoice->auctionIdByUserId($_SESSION['sessUserID'],'1',true);

	if(empty($dataArr)){
		$total = 0;
	}else{
		$total=count($dataArr);
	}

	for($i=0;$i<$total;$i++){
		$auctionDetails = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($matches) {
			return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
		}, $dataArr[$i]['auction_details']);
  		$auctionDetails = unserialize($auctionDetails);
  		$dataArr[$i]['auction_details'] = $auctionDetails ;
		if($dataArr[$i]['is_paid']=='1'){
			if($key!=2){
				$key=1;
			}
		}else{
			$key=2;
		}
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('key', $key);
	$smarty->assign('invoiceData', $dataArr);
	$smarty->display("my_invoice_display.tpl");
}

function print_invoice(){
	require_once INCLUDE_PATH."lib/common.php";
	$invoiceObj = new Invoice();
	$chk_item_type=$invoiceObj->chk_item_type($_REQUEST['invoice_id']);
	$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_REQUEST['invoice_id']));
	for($i=0;$i<count($dataArr);$i++){
		$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
		$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
		$dataArr[$i]['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] );
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
		$dataArr[$i]['additional_charges']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['additional_charges'] );
		$dataArr[$i]['additional_charges'] = unserialize($dataArr[$i]['additional_charges']);
		$dataArr[$i]['discounts']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['discounts'] );
		$dataArr[$i]['discounts'] = unserialize($dataArr[$i]['discounts']);
		if($chk_item_type==1 || $chk_item_type==4){
			for($k=0;$k<count($dataArr[$i]['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
				$UserArr.=$fetchSellerSql['user_id'].',';
			}
	  }
	}
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($dataArr[0]['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}
	$smarty->assign("invoiceData", $dataArr);
	$smarty->display("my_invoice_print.tpl");
	exit;
}

function buyer_invoice(){
	require_once INCLUDE_PATH."lib/common.php";
	$objInvoice = new Invoice();
    $data = array('invoice_id', 'auction_details', 'total_amount','approved_on', 'paid_on','is_paid','is_approved');
    $where = array('fk_user_id' => $_SESSION['sessUserID'], 'is_approved' =>'1', 'is_buyers_copy' => 0);
	$objInvoice->orderBy='invoice_generated_on';
	$objInvoice->orderType='DESC';
	$dataArr = $objInvoice->selectData(TBL_INVOICE, $data, $where,true);
	$total = !empty($dataArr) ? count($dataArr) : 0;
	for($i=0; $i<$total; $i++){
		$dataArr[$i]['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] );
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
	}
	
	/*$dataArr = $objInvoice->buyerInvoice($_SESSION['sessUserID']);

	$total = count($dataArr);
	$k = 0;
	for($i=0;$i<$total;$i++)
	{
		if($dataArr[$i]['invoice_id']==$dataArr[$i+1]['invoice_id']){
			$invoice_array[$k]['poster_details'].=$dataArr[$i]['poster_title'].'('.$dataArr[$i]['poster_sku'].')'."<br/>";
			$invoice_array[$k]['invoice_id']=$dataArr[$i]['invoice_id'];
			$invoice_array[$k]['total_amount']=$dataArr[$i]['total_amount'];
			$invoice_array[$k]['post_date']=$dataArr[$i]['post_date'];
		}else{
			$invoice_array[$k]['poster_details'].=$dataArr[$i]['poster_title'].'('.$dataArr[$i]['poster_sku'].')'."<br/>";
			$invoice_array[$k]['invoice_id']=$dataArr[$i]['invoice_id'];
			$invoice_array[$k]['total_amount']=$dataArr[$i]['total_amount'];
			$invoice_array[$k]['post_date']=$dataArr[$i]['post_date'];
			$k++;
		}
	}

	$smarty->assign('total', $total);
	$smarty->assign('invoiceData', $invoice_array);
	$smarty->display("buyer_invoice_display.tpl");*/
	
	$smarty->assign('total', $total);
	$smarty->assign('invoiceData', $dataArr);
	$smarty->display("invoice_listing.tpl");
}

function buyer_print_invoice(){
	require_once INCLUDE_PATH."lib/common.php";
	$objInvoice= new Invoice();	
	$buyerDataArr=$objInvoice->buyerPrintInvoice($_REQUEST['invoice_id']);

	$buyerDataArr[0]['mpe_charge']=number_format(($buyerDataArr[0]['total_amount']* MPE_CHARGE), 2, '.', '');
	$buyerDataArr[0]['transaction_charge']=number_format(($buyerDataArr[0]['total_amount']* TRANSACTION_CHARGE), 2, '.', '') ;
	$buyerDataArr[0]['pay_amount']=number_format(($buyerDataArr[0]['total_amount']-($buyerDataArr[0]['transaction_charge'] + $buyerDataArr[0]['mpe_charge'])), 2, '.', '');
	$buyerDataArr[0]['post_date']=date('m/d/Y',strtotime($buyerDataArr[0]['post_date']));
	$total = count($buyerDataArr);
	for($i=0;$i<$total;$i++){
		if(strlen($buyerDataArr[$i]['poster_desc'])> 50){
		$buyerDataArr[$i]['poster_desc']=str_pad(substr($buyerDataArr[$i]['poster_desc'],0,50),54,".");	
		}else{
			$buyerDataArr[$i]['poster_desc']=$buyerDataArr[$i]['poster_desc'];
		}
	}
	$smarty->assign('invoiceData', $buyerDataArr);
	$smarty->display("buyer_invoice_print.tpl");
}

function shippingInfo()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	$rs = getCountryList();
	while($row = mysqli_fetch_array($rs)){
		$countryName[] = $row[COUNTRY_NAME];
		$countryID[] = $row[COUNTRY_ID];		
	}
	$smarty->assign('countryID', $countryID);
	$smarty->assign('countryName', $countryName);
	$smarty->assign('country_id', $_POST['country_id']);
	
	$invoiceObj = new Invoice();
	if(isset($_REQUEST['invoice_id'])){
		$weight_array=$invoiceObj->findWeightArrayForInvoice($_REQUEST['invoice_id']);	
		$total_item=count($weight_array);
	}
	
	/*$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('billing_address', 'shipping_address'), array('invoice_id' => $_REQUEST['invoice_id']));
	$dataArr[0]['billing_address'] = unserialize($dataArr[0]['billing_address']);
	$dataArr[0]['shipping_address'] = unserialize($dataArr[0]['shipping_address']);*/
	
	$row = $invoiceObj->selectData(USER_TABLE, array('*'), array('user_id' => $_SESSION['sessUserID']));
	
		//$dataArr[$i]['billing_address']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['billing_address'] );
		//$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
	$dataArr[0]['billing_address'] = array('billing_firstname' => $row[0]['firstname'],
									   'billing_lastname' => $row[0]['lastname'],
									   'billing_country_id' => $row[0]['country_id'],
									   'billing_country_name' => $row[0]['country_name'],
									   'billing_country_code' => $row[0]['country_code'],
									   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['city']),
									   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['state']),
									   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['address1']),
									   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['address2']),
									   'billing_zipcode' => $row[0]['zipcode']);
		//$dataArr[$i]['shipping_address']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['shipping_address'] );
		//$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
	$dataArr[0]['shipping_address'] = array('shipping_firstname' => $row[0]['firstname'],
										'shipping_lastname' => $row[0]['lastname'],
										'shipping_country_id' => $row[0]['shipping_country_id'],
										'shipping_country_name' => $row[0]['shipping_country_name'],
										'shipping_country_code' => $row[0]['shipping_country_code'],
										'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_city']),
										'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_state']),
										'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_address1']),
										'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_address2']),
										'shipping_zipcode' => $row[0]['shipping_zipcode']);
	
	$commonObj = new DBCommon();
	$commonObj->orderBy='name';
	$us_states = $commonObj->selectData(TBL_US_STATES, array('name','abbreviation'),$where = '1',true);
	$smarty->assign('us_states', $us_states);

	$smarty->assign('invoice_id', $_REQUEST['invoice_id']);
	$smarty->assign('invoiceData', $dataArr);

	$smarty->assign('weight_array', implode(',', $weight_array));
	$smarty->assign('total_item', $total_item);
	
	foreach ($_POST as $key => $value){
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	if(isset($_REQUEST['invoice_key']) && $_REQUEST['invoice_key']!=''){
		$seller_array=explode(',', base64_decode($_REQUEST['invoice_key']));
		$seller_arr=array();
		for($k=0;$k<count($seller_array);$k++){
			if (in_array($seller_array[$k], $seller_arr)) {
			  
			} else {
				if(is_numeric($seller_array[$k])){
				array_push($seller_arr,$seller_array[$k]);
				}
			}
		}
		if($dataArr[0]['shipping_address']['shipping_country_name']!='Canada' || $dataArr[0]['shipping_address']['shipping_country_name']!='United States'){
			$charge = count($seller_arr)*21;
		}else{
			$charge = count($seller_arr)*15;
		}
		$smarty->assign('count',$charge);
		$smarty->assign('countTotal',count($seller_arr));
	}
	$smarty->assign('shipping_methods_err', $GLOBALS['shipping_methods_err']);
	$smarty->assign('shipping_charge_err', $GLOBALS['shipping_charge_err']);
	
	$smarty->display('invoice_shippinginfo.tpl');
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

function updateShippingInfo()
{
	require_once INCLUDE_PATH."lib/common.php";
	
	$objInvoice = new Invoice();
	
	$billing_address = serialize(array('billing_firstname' => $_POST['billing_firstname'],
									   'billing_lastname' => $_POST['billing_lastname'],
									   'billing_country_id' => $_POST['billing_country_id'],
									   'billing_country_name' => $_POST['billing_country_name'],
									   'billing_country_code' => $_POST['billing_country_code'],
									   'billing_city' => $_POST['billing_city'],
									   'billing_state' => $_POST['billing_state'],
									   'billing_address1' => $_POST['billing_address1'],
									   'billing_address2' => $_POST['billing_address2'],
									   'billing_zipcode' => $_POST['billing_zipcode']));
	$shipping_address = serialize(array('shipping_firstname' => $_POST['shipping_firstname'],
										'shipping_lastname' => $_POST['shipping_lastname'],
										'shipping_country_id' => $_POST['shipping_country_id'],
										'shipping_country_name' => $_POST['shipping_country_name'],
										'shipping_country_code' => $_POST['shipping_country_code'],
										'shipping_city' => $_POST['shipping_city'],
										'shipping_state' => $_POST['shipping_state'],
										'shipping_address1' => $_POST['shipping_address1'],
										'shipping_address2' => $_POST['shipping_address2'],
										'shipping_zipcode' => $_POST['shipping_zipcode'],
										'shipping_option' => 'Shipping Charges ('.strtoupper($_POST['shipping_methods']).')',
										'shipping_charge' => $_POST['shipping_charge']));
	//$additional_charges = serialize(array(0 => array('description' => 'Shipping Charges ('.strtoupper($_POST['shipping_methods']).')', 'amount' => $_POST['shipping_charge'])));
	
	//$invoiceData = $objInvoice->selectData(TBL_INVOICE, array('total_amount'), array('invoice_id' => $_POST['invoice_id']));
	//$data = array('billing_address' => $billing_address, 'shipping_address' => $shipping_address,
				  //'total_amount' => ($invoiceData[0]['total_amount'] + $_POST['shipping_charge']));
				  
	$data = array('billing_address' => $billing_address, 'shipping_address' => $shipping_address);
	$objInvoice->updateData(TBL_INVOICE, $data, array('invoice_id' => $_REQUEST['invoice_id']), true);
	
	//$_SESSION['shipping_info']['shipping_methods'] = 'Shipping Charges ('.strtoupper($_POST['shipping_methods']).')';
	//$_SESSION['shipping_info']['shipping_charge'] = $_POST['shipping_charge'];
	
	header("location: my_invoice?mode=paymentoption&invoice_id=".$_REQUEST['invoice_id']);
	exit;
}

function paymentOption()
{
	require_once INCLUDE_PATH."lib/common.php";
	foreach ($_REQUEST as $key => $value){
		$smarty->assign($key, $value);
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}
	$smarty->display('paymentoption.tpl');
}
function chooseOptionForPayment()
{
	require_once INCLUDE_PATH."lib/common.php";

	$invoiceObj = new Invoice();

	foreach ($_POST as $key => $value){
		if(substr($key, 0, 7) == 'billing'){
			$_SESSION['invoice_'.$_POST['invoice_id']]['billing_info'][$key] = $value;			
			if($key == 'billing_country_id'){
				$row = $invoiceObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_name'] = $row[0]['country_name'];
				$_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_code'] = $row[0]['country_code'];
			}elseif($key == 'billing_state_textbox' && $_POST['billing_country_id'] != '230'){
				$_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_state'] = $_POST['billing_state_textbox'];
			}elseif($key == 'billing_state_select' && $_POST['billing_country_id'] == '230'){
				$_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_state'] = $_POST['billing_state_select'];
			}
		}elseif(substr($key, 0, 8) == 'shipping'){
			if($key == 'shipping_charge'){
			  if(isset($_POST['invoice_key']) && $_POST['invoice_key']!=''){
				if($_POST['shipping_country_id'] == '230' || $_POST['shipping_country_id'] == '38'){
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'][$key] = 15*$_POST['seller_count'];
				}else{
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'][$key] =	21*$_POST['seller_count'];
				}
			  }else{
			  	$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'][$key] = $value;
			  }
			}else{
				$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'][$key] = $value;
			}
			if($key == 'shipping_country_id'){
				$row = $invoiceObj->selectData(COUNTRY_TABLE, array('country_name', 'country_code'), array('country_id' => $value));
				$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_name'] = $row[0]['country_name'];
				$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_code'] = $row[0]['country_code'];
			}elseif($key == 'shipping_state_textbox' && $_POST['shipping_country_id'] != '230'){
				$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_state'] = $_POST['shipping_state_textbox'];
			}elseif($key == 'shipping_state_select' && $_POST['shipping_country_id'] == '230'){
				$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_state'] = $_POST['shipping_state_select'];

				if($_POST['shipping_state_select'] == 'Georgia' || $_POST['shipping_state_select'] == 'GA'){
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_percentage'] = SALE_TAX_GA;
					
					$invoiceRows = $invoiceObj->selectData(TBL_INVOICE, array('total_amount'), array('invoice_id' => $_REQUEST['invoice_id']));
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'] = ($invoiceRows[0]['total_amount']*SALE_TAX_GA/100);
					
				}elseif($_POST['shipping_state_select'] == 'North Carolina' || $_POST['shipping_state_select'] == 'NC'){
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_percentage'] = SALE_TAX_NC;

					$invoiceRows = $invoiceObj->selectData(TBL_INVOICE, array('total_amount'), array('invoice_id' => $_REQUEST['invoice_id']));
					$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'] = ($invoiceRows[0]['total_amount']*SALE_TAX_NC/100);
						
				}else{
					unset($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_percentage']);
					unset($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount']);
				}
			}
		}
	}
	
	//echo "<pre>";print_r($_SESSION['invoice_'.$_POST['invoice_id']]);echo "**".$_POST['invoice_id'];exit;

	foreach ($_POST as $key => $value){
		$smarty->assign($key, $value);
		eval('$smarty->assign("'.$key.'_err", $GLOBALS["'.$key.'_err"]);');
	}

	$smarty->display('choose_option_for_payment_invoice.tpl');
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

function order()
{
	require_once INCLUDE_PATH."lib/common.php";

	$invoiceObj = new Invoice();
	$chk_item_type=$invoiceObj->chk_item_type($_REQUEST['invoice_id']);
	$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('fk_user_id,auction_details,additional_charges,discounts'), array('invoice_id' => $_REQUEST['invoice_id']));
	
	$row = $invoiceObj->selectData(USER_TABLE, array('*'), array('user_id' => $dataArr[0]['fk_user_id']));
	for($i=0;$i<count($dataArr);$i++){
		//$dataArr[$i]['billing_address']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['billing_address'] );
		//$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
		$dataArr[$i]['billing_address'] = array('billing_firstname' => $row[0]['firstname'],
									   'billing_lastname' => $row[0]['lastname'],
									   'billing_country_id' => $row[0]['country_id'],
									   'billing_country_name' => $row[0]['country_name'],
									   'billing_country_code' => $row[0]['country_code'],
									   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['city']),
									   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['state']),
									   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['address1']),
									   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['address2']),
									   'billing_zipcode' => $row[0]['zipcode']);
		//$dataArr[$i]['shipping_address']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['shipping_address'] );
		//$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
		$dataArr[$i]['shipping_address'] = array('shipping_firstname' => $row[0]['firstname'],
										'shipping_lastname' => $row[0]['lastname'],
										'shipping_country_id' => $row[0]['shipping_country_id'],
										'shipping_country_name' => $row[0]['shipping_country_name'],
										'shipping_country_code' => $row[0]['shipping_country_code'],
										'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_city']),
										'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_state']),
										'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_address1']),
										'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row[0]['shipping_address2']),
										'shipping_zipcode' => $row[0]['shipping_zipcode']);
		$dataArr[$i]['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] );
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
		$dataArr[$i]['additional_charges']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['additional_charges'] );
		$dataArr[$i]['additional_charges'] = unserialize($dataArr[$i]['additional_charges']);
		$dataArr[$i]['discounts']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['discounts'] );
		$dataArr[$i]['discounts'] = unserialize($dataArr[$i]['discounts']);
		if($chk_item_type==1 ){
			for($k=0;$k<count($dataArr[$i]['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
				$UserArr.=$fetchSellerSql['user_id'].',';
			}
	  }elseif($chk_item_type==4){
	  			$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][0]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][0]['seller_username']= $fetchSellerSql['username'];
				$UserArr.=$fetchSellerSql['user_id'].',';
	  }
	}
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($dataArr[0]['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}

	$smarty->assign('invoice_id', $_REQUEST['invoice_id']);
	$smarty->assign('invoiceData', $dataArr);
	
	foreach($_POST as $key => $value){
		$smarty->assign($key, $value);
	}

	$smarty->display('order.tpl');
}

function finalorder()
{
	require_once INCLUDE_PATH."lib/common.php";

	$invoiceObj = new Invoice();
	$chk_item_type=$invoiceObj->chk_item_type($_REQUEST['invoice_id']);
	
	$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_POST['invoice_id']));

	for($i=0;$i<count($dataArr);$i++){
		//$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
		//$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
		//$dataArr[$i]['shipping_address'] = $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'];
		$dataArr[$i]['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] );
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
		$dataArr[$i]['additional_charges']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['additional_charges'] );
		$dataArr[$i]['additional_charges'] = unserialize($dataArr[$i]['additional_charges']);
		$dataArr[$i]['discounts']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['discounts'] );
		$dataArr[$i]['discounts'] = unserialize($dataArr[$i]['discounts']);
		if($chk_item_type==1 || $chk_item_type==4){
			for($k=0;$k<count($dataArr[$i]['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
			}
	  }
	}
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($dataArr[0]['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}

	//echo "<pre>";print_r($_SESSION['invoice_'.$_POST['invoice_id']]);
	
	$smarty->assign('invoiceData', $_SESSION['invoice_'.$_POST['invoice_id']]);
	$smarty->assign('invoice_id', $_POST['invoice_id']);
	$smarty->assign('dataArr', $dataArr);
	
	foreach($_POST as $key => $value){
		$smarty->assign($key, $value);
	}

	$smarty->display('finalorder.tpl');
}

function pay_now()
{
 	require_once INCLUDE_PATH."lib/common.php";

 	extract($_REQUEST);
 	$objPaypal = new Paypal_DoDirectPayment();
	$objCommon = new DBCommon();

	$invoiceData = $objCommon->selectData(TBL_INVOICE, array('total_amount'), array('invoice_id' => $invoice_id));
	$invoiceData[0]['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData[0]['auction_details'] );
	$invoiceData[0]['auction_details'] = unserialize($invoiceData[0]['auction_details']);
	 
	$objPaypal->amount = number_format(($invoiceData[0]['total_amount'] + $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_charge']), 2, ".", "");
 	$objPaypal->firstName = $_POST['firstname'];
 	$objPaypal->lastName = $_POST['lastname'];
 	$objPaypal->ccType = $_POST['cc_type'];
 	$objPaypal->ccNumber = $_POST['cc_number'];
 	$objPaypal->cvv2 = $_POST['cvv2Number'];
	$objPaypal->expdate = $_POST['exp_Month'].$_POST['exp_Year'];
	
	$objPaypal->address = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_address1'].",".$_SESSION['invoice_'.$invoice_id]['billing_info']['billing_address2'];
 	$objPaypal->city = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_city'];
	if($_SESSION['invoice_'.$invoice_id]['billing_info']['billing_country_code']=='US'){
 		$objPaypal->stateCode = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_state_select'];
 	}else{
 		$objPaypal->stateCode = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_state_textbox'];
 	}
 	$objPaypal->zip = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_zipcode'];
 	$objPaypal->countryCode = $_SESSION['invoice_'.$invoice_id]['billing_info']['billing_country_code'];
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
		
		$row = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_POST['invoice_id']));
		
		$billing_address = serialize(array('billing_firstname' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_firstname'],
										   'billing_lastname' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_lastname'],
										   'billing_country_id' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_id'],
										   'billing_country_name' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_name'],
										   'billing_country_code' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_code'],
										   'billing_city' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_city'],
										   'billing_state' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_state'],
										   'billing_address1' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_address1'],
										   'billing_address2' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_address2'],
										   'billing_zipcode' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_zipcode']));
		$shipping_address = serialize(array('shipping_firstname' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_firstname'],
											'shipping_lastname' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_lastname'],
											'shipping_country_id' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_id'],
											'shipping_country_name' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_name'],
											'shipping_country_code' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_code'],
											'shipping_city' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_city'],
											'shipping_state' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_state'],
											'shipping_address1' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_address1'],
											'shipping_address2' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_address2'],
											'shipping_zipcode' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_zipcode']));
		
		$row[0]['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row[0]['additional_charges'] );
		$additional_charges_arr = unserialize($row[0]['additional_charges']);
		
		$shipping_desc = strtoupper($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_methods'])." - ".
						 $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_desc'];
		
		$additional_charges_arr[] = array('description' => 'Shipping Charge ('.$shipping_desc.')',
										  'amount' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_charge']);
										  
		if($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'] > 0){
			$additional_charges_arr[] = array('description' => 'Sales Tax', 'amount' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount']);						
		}
		
		$additional_charges = serialize($additional_charges_arr);
		
		$total_amount = $row[0]['total_amount'] + 
						$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_charge'] + 
						$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'];
		
		$data = array('billing_address' => $billing_address, 'shipping_address' => $shipping_address, 'additional_charges' => mysqli_real_escape_string($GLOBALS['db_connect'],$additional_charges),
					  'total_amount' => $total_amount, 'is_paid' => 1, 'paid_on' => date("Y-m-d H:i:s"));

		$invoiceObj->updateData(TBL_INVOICE, $data, array('invoice_id' => $_POST['invoice_id']), true);
		
		$data = $invoiceObj->selectData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id'), array('fk_invoice_id' => $invoice_id));
        for($i=0;$i<count($data);$i++){
            $invoiceObj->updateData(TBL_AUCTION, array('auction_payment_is_done' => 1), array('auction_id' => $data[$i]['fk_auction_id']), true);

            $auctionData = $invoiceObj->selectData(TBL_AUCTION, array('auction_is_sold'), array('auction_id' => $data[$i]['fk_auction_id']));
            if($auctionData[0]['auction_is_sold']=='3'){
                $invoiceObj->updateData(TBL_AUCTION, array('auction_is_sold' => 2), array('auction_id' => $data[$i]['fk_auction_id']), true);
            }
        }
		
		$invoiceObj->generateSellerInvoice($_POST['invoice_id']);
		$invoiceObj->mailInvoice($_POST['invoice_id'],'invoice');

		unset($_SESSION['invoice_'.$_POST['invoice_id']]);
		
		$_SESSION['Err']="Payment is done successfully.";
	}else{
		$_SESSION['Err'] = "Payment failed. Please try again!"."<br/>"." Paypal Error Code:". $resArray['L_ERRORCODE0']."&nbsp;".$resArray['L_LONGMESSAGE0'];
	}

	header("location: my_invoice");
	exit;
}


function cancel_payment()
{
	unset($_SESSION['billing_info']);
	unset($_SESSION['shipping_info']);
	unset($_SESSION['cc_info']);
	
	$_SESSION['Err'] = "Payment process is cancelled.";
	header("location: my_invoice?mode=order&invoice_id=".$_REQUEST['invoice_id']);
	exit;
}
function setExpressCheckout(){
	
	require_once INCLUDE_PATH."lib/common.php";
	$dbCommonObj = new DBCommon();
	$smarty->assign('paypal_url',$_SERVER['HTTP_HOST']);
	$smarty->display('setexpresscheckout.tpl');
}

function getExpressCheckoutDetails(){
	require_once INCLUDE_PATH."lib/common.php";
	$invoiceObj = new Invoice();
	$chk_item_type=$invoiceObj->chk_item_type($_REQUEST['invoice_id']);
	$smarty->assign('billing_info', $_SESSION['invoice_'.$_REQUEST['invoice_id']]['billing_info']);
	$smarty->assign('shipping_info', $_SESSION['invoice_'.$_REQUEST['invoice_id']]['shipping_info']);
	$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_REQUEST['invoice_id']));

	for($i=0;$i<count($dataArr);$i++){
		//$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
		//$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
		//$dataArr[$i]['shipping_address'] = $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'];
		$dataArr[$i]['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details']);
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
		$dataArr[$i]['additional_charges'] = unserialize($dataArr[$i]['additional_charges']);
		$dataArr[$i]['discounts'] = unserialize($dataArr[$i]['discounts']);
		if($chk_item_type==1 || $chk_item_type==4){
			for($k=0;$k<count($dataArr[$i]['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
			}
	  }
	}
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($dataArr[0]['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}

	$smarty->assign('invoiceData', $_SESSION['invoice_'.$_REQUEST['invoice_id']]);
	$smarty->assign('invoice_id', $_REQUEST['invoice_id']);
	$smarty->assign('dataArr', $dataArr);
	
	
	$resArray = $_SESSION['invoice_'.$_REQUEST['invoice_id']]['reshash'];
	$smarty->assign('resArray', $resArray);
 	$smarty->display('getExpressCheckoutdetailsInvoice.tpl');
}
function combine_buyer_invoice(){

    //print_r($_REQUEST['auction_id']);
    $newinvoiceAuction = array();
    $newinvoiceCharge = array();
    $newinvoiceDiscount = array();
    $invoiceArr= array();
    $subTotal=0;
    $invoiceObj = new Invoice();
    foreach($_REQUEST['invoice_id'] as $key=>$val){
        $invoiceData = '';
        $sql = "SELECT inv.* FROM ".TBL_INVOICE." inv
				WHERE inv.invoice_id = '".$val."'
				";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $invoiceData= mysqli_fetch_assoc($rs);
        }
        $invoiceArr[] = $invoiceData['invoice_id'];
        $user_id= $invoiceData['fk_user_id'];
        $shipping_address=$invoiceData['shipping_address'];
        $billing_address=$invoiceData['billing_address'];
        $invoiceData['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['auction_details']);
        $invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
        if(!empty($invoiceData['auction_details'])){
            foreach($invoiceData['auction_details'] as $key => $value){
                $newinvoiceAuction[] =array('auction_id' => $invoiceData['auction_details'][$key]['auction_id'],'poster_sku' => $invoiceData['auction_details'][$key]['poster_sku'], 'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['auction_details'][$key]['poster_title']), 'amount' => $invoiceData['auction_details'][$key]['amount']);
                $subTotal += $invoiceData['auction_details'][$key]['amount'];
            }
        }

        $invoiceData['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['additional_charges']);
        $invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
        if(!empty($invoiceData['additional_charges'])){
            foreach($invoiceData['additional_charges'] as $key => $value){
                $newinvoiceCharge[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['additional_charges'][$key]['description']), 'amount' => $invoiceData['additional_charges'][$key]['amount']);
                $subTotal += $invoiceData['additional_charges'][$key]['amount'];
            }
        }
        $invoiceData['discounts'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['discounts']);
        $invoiceData['discounts'] = unserialize($invoiceData['discounts']);
        if(!empty($invoiceData['discounts'])){
            foreach($invoiceData['discounts'] as $key => $value){
                $newinvoiceDiscount[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['discounts'][$key]['description']), 'amount' => $invoiceData['discounts'][$key]['amount']);
                $subTotal -= $invoiceData['discounts'][$key]['amount'];
            }
        }
    }
    /*echo "<pre>";
    print_r($newinvoiceAuction);
    print_r($newinvoiceCharge);
    print_r($newinvoiceDiscount);
    echo "</pre>";
    die();*/
    $auction_details=serialize($newinvoiceAuction);

    $add_charge=serialize($newinvoiceCharge);

    $discount=serialize($newinvoiceDiscount);

    $data = array('fk_user_id' => $user_id, 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
        'auction_details' => $auction_details, 'additional_charges' => $add_charge,'discounts'=>$discount, 'total_amount' => $subTotal,
        'invoice_generated_on' => date("Y-m-d H:i:s"),'is_approved'=>'1','approved_on'=>date("Y-m-d H:i:s"), 'is_buyers_copy' => 1,'is_combined'=>'1','is_new'=>1);

    $invoice_id = $invoiceObj->updateData(TBL_INVOICE, $data);

    foreach($invoiceArr as $key=>$val){
        mysqli_query($GLOBALS['db_connect'],"Update tbl_invoice_to_auction set fk_invoice_id = $invoice_id where fk_invoice_id=".$val);
        mysqli_query($GLOBALS['db_connect'],"Delete from tbl_invoice where invoice_id=".$val);
    }
    if($invoice_id > 0){
        echo "1";
    }else{
        echo "2";
    }


}
function archive_buyer_invoice(){

    foreach($_REQUEST['invoice_id'] as $key=>$val){
	    $succesKey = '';
        $invoiceData = '';
        $sql = "UPDATE  ".TBL_INVOICE." inv SET is_archived='1' , archived_date= '".date('Y-m-d H:i:s')."'
				WHERE inv.invoice_id = '".$val."'
				";

        if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
            $succesKey = 1;
        }else{
			$succesKey = 2;
			break;
		}
             
    }   
	echo $succesKey;
}
function generate_buy_now_invoice(){
    require_once INCLUDE_PATH."lib/common.php";
    //$expiredate = date('Y-m-d', time()+3600*72);
    //$expiredate= $expiredate ."24:00:00";
    if(!empty($_SESSION['cart'])){
        $i=0;
        $auction_ids='';
        $last_auction_id='';
        $posters='';
        $keyInd=0;
        $auctionInvoicedArr= array();
        foreach($_SESSION['cart'] as $key=>$val){
            $auction_ids.=$_SESSION['cart'][$i]['auction_id'].',';
            $last_auction_id=$_SESSION['cart'][$i]['auction_id'];
			$auction_type_id =$_SESSION['cart'][$i]['fk_auction_type_id'];
			if($auction_type_id==6){
				$sql_update_alternative=mysqli_query($GLOBALS['db_connect'],"Update tbl_poster p, tbl_auction a SET p.`quantity`=quantity-'".$_SESSION['cart'][$i]['quantity']."' WHERE a.`auction_id`='".$last_auction_id."' and a.fk_poster_id = p.poster_id ");
			}
			##### Update Cart Status as this item is no more in cart ###############
			$sql_update=mysqli_query($GLOBALS['db_connect'],"Update tbl_auction SET `in_cart`='0' WHERE `auction_id`='".$last_auction_id."' ");
            $sqlIsInvoiced="Select auction_is_sold from tbl_auction where auction_id='".$last_auction_id."'";
            $resIsInvoiced=mysqli_query($GLOBALS['db_connect'],$sqlIsInvoiced);
            $fetchIsInvoiced = mysqli_fetch_array($resIsInvoiced);
            $isInvoiced=$fetchIsInvoiced['auction_is_sold'];
            if($isInvoiced=='3'){
                $keyInd=1;
                array_push($auctionInvoicedArr,$last_auction_id);
            }
            $i++;
        }
        $auction_ids=substr($auction_ids,0,(strLen($auction_ids)-1));
    }
    if($keyInd!=1){
        $invoiceObj = new Invoice();
        $invoiceObj->generate_buy_now_invoice($last_auction_id,$_SESSION['cart']);

        /******************************** Email Start ******************************/
        $sql = "SELECT u.username, u.firstname, u.lastname, u.email
                    FROM ".USER_TABLE." u
                    WHERE u.user_id = '".$_SESSION['sessUserID']."'";
        $rs = mysqli_query($GLOBALS['db_connect'],$sql);
        $row = mysqli_fetch_array($rs);


        $toMail = $row['email'];
        $toName = $row['firstname']." ".$row['lastname'];

        $fromMail = ADMIN_EMAIL_ADDRESS;
        $fromName = ADMIN_NAME;
        foreach($_SESSION['cart'] as $key => $value){
            $posters=$value['poster_title'].',';
            $sqlForBuyer ="SELECT usr.firstname, usr.lastname, usr.email , p.poster_title,ofr.offer_amount
					FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." AS p
					WHERE ofr.offer_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id
					AND ofr.offer_fk_user_id = usr.user_id
					AND ofr.offer_is_accepted = '0'
					AND ofr.offer_fk_auction_id =  '".$value['auction_id']."' ";

            $rsBuyer = mysqli_query($GLOBALS['db_connect'],$sqlForBuyer);
            while($rowBuyer = mysqli_fetch_array($rsBuyer)){
                $toMailBuyer=$rowBuyer['email'];
                $toNameBuyer=$rowBuyer['firstname']." ".$rowBuyer['lastname'];
                $textContentBuyer='';
                $subjectBuyer = "MPE::Offer Rejected - ".$rowBuyer['poster_title']." ";
				$textContentBuyer = 'Dear '.$rowBuyer['firstname'].' '.$rowBuyer['lastname'].',<br><br>';
                $textContentBuyer .= 'Your offer of $'.$rowBuyer['offer_amount'].' has been rejected.<br /><br />As '.$rowBuyer['poster_title'].' has been sold.<br/><br/>';
                $textContentBuyer .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a><br /><br />';
                $textContentBuyer .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
                $textContentBuyer = MAIL_BODY_TOP.$textContentBuyer.MAIL_BODY_BOTTOM;
                //$check = sendMail($toMailBuyer, $toNameBuyer, $subjectBuyer, $textContentBuyer, $fromMail, $fromName, $html=1);
            }
            //$sqlUpdateOffer="Update tbl_offer set offer_is_accepted='2' where offer_fk_auction_id='".$value['auction_id']."' and offer_is_accepted='0' ";
            //mysqli_query($GLOBALS['db_connect'],$sqlUpdateOffer);
			
			$sqlForSeller ="SELECT  u.firstname,u.lastname,u.email,p.poster_title FROM ".USER_TABLE." u , ".TBL_AUCTION." a, ".TBL_POSTER." AS p
							WHERE u.user_id = p.fk_user_id
							AND p.poster_id = a.fk_poster_id
							AND a.auction_id = '".$value['auction_id']."' ";							
			$rsSeller = mysqli_query($GLOBALS['db_connect'],$sqlForSeller);
			$rowSeller = mysqli_fetch_array($rsSeller);
			$toMailSeller=$rowSeller['email'];
            $toNameSeller=$rowSeller['firstname']." ".$rowSeller['lastname'];
			$subjectSeller = "MPE::Opted For Buy Now - ".$rowSeller['poster_title']." ";
			$textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br><br>';
			$textContentSeller .= 'Poster Title :'.$rowSeller['poster_title'].'<br />';
			$textContentSeller .= 'Congratulations! Your item has been opted for Buy Now. You will receive an email confirmation when payment is received.<br />';
			$textContentSeller .= 'You may view this item and any other items listed by logging in to your account <a href="http://'.HOST_NAME.'/">HERE</a> and placing your mouse over the User Panel, located in top red banner and selecting MY SELLING/Sale Pending.<br /><br />';
			$textContentSeller .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
            $textContentSeller = MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM;
            //$checkSeller = sendMail($toMailSeller, $toNameSeller, $subjectSeller, $textContentSeller, $fromMail, $fromName, $html=1);
        }
        $posters=substr($posters,0,(strLen($posters)-1));
        //$subject = "Invoice created for items(s) will expires on ".date('m-d-Y H:i:s',strtotime($expiredate));
		$subject = "Invoice Generated";
        $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br><br>';
        $textContent .= 'You have generated an invoice for the following item(s):<br />';
        $count=1;
        foreach($_SESSION['cart'] as $key => $value){
            $textContent.=$count.'. '.$value['poster_title'].'&nbsp;&nbsp;Price:$'.$value['amount'].'<br/>';
            $count++;
        }
        $textContent .= 'To give you the ability to combine with other purchases/wins, you may wait up to 72 hours to make payment. Your invoice expires on '.date('m-d-Y H:i:s',strtotime($expiredate)).'<br/>';
		$textContent .= 'You will receive this invoice via email. You can also view it by logging into your account and selecting <b>Invoices/Reconciliations</b> located in <b>User Section</b> under <b>My Account</b>.<br/>';
		$textContent .= 'If you have made payment, please disregard this email.<br /><br />';
        $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
        $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
        //$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
        unset($_SESSION['cart']);
        //$_SESSION['Err']="NOTE: Once an invoice is generated, you may wait up to 72 hours to pay. This is to give you the ability to receive counter offers/offer acceptances and/or combine with other purchases within that time period.";
        header("location: my_invoice");
        exit;

    }else{
        $i=0;
        $posterArr = array();
        foreach($_SESSION['cart'] as $key=>$val){
            $last_auction_id=$_SESSION['cart'][$i]['auction_id'];
            if (in_array($last_auction_id, $auctionInvoicedArr)) {
                array_push($posterArr,$_SESSION['cart'][$i]['poster_title']);
                unset($_SESSION['cart'][$i]);
            }
            $i++;
        }
        $cart = array();
        foreach($_SESSION['cart'] as $key => $value){
            $cart[] = $value;
        }
        $_SESSION['cart'] = $cart;

        $_SESSION['Err']="The following poster(s) have been removed from your invoice, as the posters have been opted for buy now.<br/>";
        $k=0;
        foreach($posterArr as $key=>$val){
            $j=$k+1;
            $_SESSION['Err'].=$j.".".$val."<br/>";
            $k++;
        }
        header("location: cart.php");
        exit;
    }
}
function phone_order(){
	require_once INCLUDE_PATH."lib/common.php";

	$invoiceObj = new Invoice();
	$chk_item_type=$invoiceObj->chk_item_type($_REQUEST['invoice_id']);
	$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_REQUEST['invoice_id']));

	for($i=0;$i<count($dataArr);$i++){
		//$dataArr[$i]['billing_address'] = unserialize($dataArr[$i]['billing_address']);
		//$dataArr[$i]['shipping_address'] = unserialize($dataArr[$i]['shipping_address']);
		//$dataArr[$i]['shipping_address'] = $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info'];
		$dataArr[$i]['auction_details']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] );
		$dataArr[$i]['auction_details'] = unserialize($dataArr[$i]['auction_details']);
		$dataArr[$i]['additional_charges']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['additional_charges'] );
		$dataArr[$i]['additional_charges'] = unserialize($dataArr[$i]['additional_charges']);
		$dataArr[$i]['discounts']=preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['discounts'] );
		$dataArr[$i]['discounts'] = unserialize($dataArr[$i]['discounts']);
		if($chk_item_type==1 || $chk_item_type==4){
		for($k=0;$k<count($dataArr[$i]['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$dataArr[$i]['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$dataArr[$i]['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
			}
	  }
	}
	if($chk_item_type==1 || $chk_item_type==4){
		array_sort_by_column($dataArr[0]['auction_details'],"seller_username");
		$smarty->assign('chk_item_type', $chk_item_type);
		$smarty->assign('userArr', base64_encode($UserArr));
	}
	//echo "<pre>";print_r($_SESSION['invoice_'.$_POST['invoice_id']]);
	
	$smarty->assign('invoiceData', $_SESSION['invoice_'.$_REQUEST['invoice_id']]);
	$smarty->assign('invoice_id', $_REQUEST['invoice_id']);
	$smarty->assign('dataArr', $dataArr);
	
	foreach($_POST as $key => $value){
		$smarty->assign($key, $value);
	}

	$smarty->display('finalorder.tpl');
}
function order_now(){
	
 	require_once INCLUDE_PATH."lib/common.php";

 	extract($_REQUEST);
	$objCommon = new DBCommon();

	$invoiceData = $objCommon->selectData(TBL_INVOICE, array('total_amount'), array('invoice_id' => $invoice_id));

	$invoiceData[0]['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData[0]['auction_details'] );
	$invoiceData[0]['auction_details'] = unserialize($invoiceData[0]['auction_details']);	 
	

	
		$invoiceObj = new Invoice();
		
		$row = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $_POST['invoice_id']));
		
		$billing_address = serialize(array('billing_firstname' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_firstname'],
										   'billing_lastname' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_lastname'],
										   'billing_country_id' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_id'],
										   'billing_country_name' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_name'],
										   'billing_country_code' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_country_code'],
										   'billing_city' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_city'],
										   'billing_state' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_state'],
										   'billing_address1' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_address1'],
										   'billing_address2' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_address2'],
										   'billing_zipcode' => $_SESSION['invoice_'.$_POST['invoice_id']]['billing_info']['billing_zipcode']));
		$shipping_address = serialize(array('shipping_firstname' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_firstname'],
											'shipping_lastname' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_lastname'],
											'shipping_country_id' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_id'],
											'shipping_country_name' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_name'],
											'shipping_country_code' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_country_code'],
											'shipping_city' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_city'],
											'shipping_state' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_state'],
											'shipping_address1' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_address1'],
											'shipping_address2' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_address2'],
											'shipping_zipcode' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_zipcode']));
		
		$row[0]['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row[0]['additional_charges'] );
		$additional_charges_arr = unserialize($row[0]['additional_charges']);
		
		$shipping_desc = strtoupper($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_methods'])." - ".
						 $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_desc'];
		
		$additional_charges_arr[] = array('description' => 'Shipping Charge ('.$shipping_desc.')',
										  'amount' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_charge']);
										  
		if($_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'] > 0){
			$additional_charges_arr[] = array('description' => 'Sales Tax', 'amount' => $_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount']);						
		}
		
		$additional_charges = serialize($additional_charges_arr);
		
		$total_amount = $row[0]['total_amount'] + 
						$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['shipping_charge'] + 
						$_SESSION['invoice_'.$_POST['invoice_id']]['shipping_info']['sale_tax_amount'];
		
		$data = array('billing_address' => $billing_address, 'shipping_address' => $shipping_address, 'additional_charges' => mysqli_real_escape_string($GLOBALS['db_connect'],$additional_charges),
					  'total_amount' => $total_amount, 'is_ordered' => 1, 'order_date' => date("Y-m-d H:i:s"));
		
		$invoiceObj->updateData(TBL_INVOICE, $data, array('invoice_id' => $_POST['invoice_id']), true);
		
		$data = $invoiceObj->selectData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id'), array('fk_invoice_id' => $invoice_id));

        for($i=0;$i<count($data);$i++){
            $invoiceObj->updateData(TBL_AUCTION, array('auction_payment_is_done' => 0), array('auction_id' => $data[$i]['fk_auction_id']), true);

            $auctionData = $invoiceObj->selectData(TBL_AUCTION, array('auction_is_sold'), array('auction_id' => $data[$i]['fk_auction_id']));
            if($auctionData[0]['auction_is_sold']=='3'){
                $invoiceObj->updateData(TBL_AUCTION, array('auction_is_sold' => 2), array('auction_id' => $data[$i]['fk_auction_id']), true);
            }
        }
		//$invoiceObj->generateSellerInvoice($_POST['invoice_id']);
		$invoiceObj->mailInvoice($_POST['invoice_id'],'phone_order');

		unset($_SESSION['invoice_'.$_POST['invoice_id']]);
		
		$_SESSION['Err']="Order is done successfully.";
	

	header("location: my_invoice");
	exit;

}
function archive_invoice(){
	require_once INCLUDE_PATH."lib/common.php";
	$objInvoice = new Invoice();
	//$dataArr = $objInvoice->AuctionIdByUserId($_SESSION['sessUserID']);
	$data = array('invoice_id','auction_details','total_amount','invoice_generated_on','is_paid','is_approved','is_cancelled','is_ordered');
	$dataArr = $objInvoice->auctionIdByUserId($_SESSION['sessUserID'],'1',false);
	
	if(empty($dataArr)){
		$total = 0;
	}else{
		$total=count($dataArr);
	}
	
	for($i=0;$i<$total;$i++){
		$auctionDetails = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $dataArr[$i]['auction_details'] ); 
  		$auctionDetails = unserialize($auctionDetails);  
  		$dataArr[$i]['auction_details'] = $auctionDetails ;
		if($dataArr[$i]['is_paid']=='1'){
			if($key!=2){
				$key=1;
			}
		}else{
			$key=2;
		}
	}
	
	$smarty->assign('total', $total);
	$smarty->assign('key', $key);
	$smarty->assign('invoiceData', $dataArr);
	$smarty->display("my_invoice_display_archive.tpl");
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
?>
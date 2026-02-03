<?php
/**************************************************/
ob_start();

define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
require_once INCLUDE_PATH."FCKeditor/fckeditor.php";
if(!isset($_SESSION['adminLoginID'])){
	redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';

if($mode == "buyer"){
	access_buyer_info();
}elseif($mode == "seller"){
	access_seller_info();
}elseif($mode == "fetch_invoice"){
	fetch_invoice();
}elseif($mode == "mark_shipping_claimed"){
	mark_shipping_claimed();
}
    function access_buyer_info(){

        require_once INCLUDE_PATH."lib/adminCommon.php";
        define ("PAGE_HEADER_TEXT", "Admin Fixed Price Sale Manager");

        $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
        $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));
        $obj = new User();
        $obj->orderBy=FIRSTNAME;
        $obj->orderType=ASC;
        $userRow = $obj->selectData(USER_TABLE, array('user_id', 'firstname','lastname','username'), array('status' => 1),true);

		$auctionWeekObj = new AuctionWeek();
		$auctionWeek= $auctionWeekObj->selectAuctionWeek();
		$smarty->assign("auctionWeek", $auctionWeek);

        $smarty->assign("userRow", $userRow);
        if(($_REQUEST['start_date'] ?? '') > ($_REQUEST['end_date'] ?? '')){
            $_SESSION['adminErr'] = "End Date must be greater than Start Date.";
            header("location: ".PHP_SELF."?mode=fixed&search=".($_REQUEST['search'] ?? ''));
        }else{
            $auctionObj = new Auction();
            $auctionObj->orderType = 'DESC';
            if(($_REQUEST['start_date'] ?? '')!='')
            {
                $start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
            }else{
                $start_date='';
            }
            if(($_REQUEST['end_date'] ?? '')!=''){
                $end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));
            }else{
                $end_date='';
            }
            if(isset($_REQUEST['seller_user_id']) && $_REQUEST['seller_user_id']!=''){
                $seller_user_id=$_REQUEST['seller_user_id'];
            }else{
                $seller_user_id='';
            }
            if(isset($_REQUEST['buyer_user_id']) && $_REQUEST['buyer_user_id']!=''){
                $buyer_user_id=$_REQUEST['buyer_user_id'];
            }else{
                $buyer_user_id='';
            }
            $search_fixed_poster = $_REQUEST['search_fixed_poster'] ?? '';
            $total = $auctionObj->countFixedPriceSaleByStatus('',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
            if($total>0){

                if(isset($_REQUEST['buyer_user_id']) && $_REQUEST['buyer_user_id']!=''){
                    $objOffer = new Offer();
                    $dataOfr = $objOffer->fetchMyWinningOffers($_REQUEST['buyer_user_id']);
                    //$smarty->assign('dataOfr', $dataOfr);
                    $smarty->assign('total_selling', count($dataOfr ?? []));
                }else{
                    $total_selling = $auctionObj->countFixedPriceSaleByStatus('selling',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
                    $smarty->assign('total_selling', $total_selling);
                }
                $total_pending = $auctionObj->countFixedPriceSaleByStatus('pending',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
                $total_sold = $auctionObj->soldAuctionCOUNTFIXED('sold',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
                $total_unpaid = $auctionObj->countFixedPriceSaleByStatus('unpaid',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
                $total_paid = $auctionObj->countFixedPriceSaleByStatus('paid',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
                $total_pending_invoiced = $auctionObj->countFixedPriceSaleByStatus('pending_invoice',$seller_user_id,$search_fixed_poster,$start_date,$end_date,$buyer_user_id);
            }
            $smarty->assign('total', $total);
            if($total>0){
                if(isset($_REQUEST['buyer_user_id']) && $_REQUEST['buyer_user_id']==''){

                }
                $smarty->assign('total_pending', $total_pending);
                $smarty->assign('total_sold', $total_sold);
                $smarty->assign('total_unpaid', $total_unpaid);
                $smarty->assign('total_paid', $total_paid);
                $smarty->assign('total_pending_invoiced', $total_pending_invoiced);
            }
            $smarty->assign('seller_user_id', $_REQUEST['seller_user_id'] ?? '');
            $smarty->assign('buyer_user_id', $_REQUEST['buyer_user_id'] ?? '');
            $smarty->assign('sort_type', $_REQUEST['sort_type'] ?? '');
            $smarty->assign('search_fixed_poster', $search_fixed_poster);
            if(($_REQUEST['start_date'] ?? '')!='' && ($_REQUEST['end_date'] ?? '')!='')
            {
                $smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
                $smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
            }
        }


        $smarty->display('admin_access_cust_info.tpl');

    }

	function access_seller_info(){

        require_once INCLUDE_PATH."lib/adminCommon.php";
        define ("PAGE_HEADER_TEXT", "Admin Access Customer Information");

		if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date']) && compareDates($_REQUEST['end_date'],$_REQUEST['start_date']) ){
			$_SESSION['adminErr'] = "End Date must be greater than Start Date.";
			header("location: ".PHP_SELF."?mode=seller");
			exit;
		}else{
		    $user_name=$_REQUEST['user_id'] ?? '';
			$objUser = new User();
			$arrUser= $objUser->selectData(USER_TABLE,array("user_id"),array("username"=>$user_name));
			$user_new_id=$arrUser[0]['user_id'] ?? '';
			$smarty->assign("user_new_id", $user_new_id);
			if(($_REQUEST['start_date'] ?? '')!='')
			{
				$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
			}else{
				$start_date='';
			}
			if(($_REQUEST['end_date'] ?? '')!=''){
				$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));
			}else{
				$end_date='';
			}
			$invoiceObj = new Invoice() ;
			$invoiceData = array();
			$invoiceData = $invoiceObj->access_customer_information_master($user_new_id,$start_date,$end_date,$_REQUEST['invoice_type'] ?? '');

			$smarty->assign('invoiceData', $invoiceData);
			if(($_REQUEST['start_date'] ?? '')!='' && ($_REQUEST['end_date'] ?? '')!='')
			 {
				$smarty->assign('start_date_show', date('m/d/Y',strtotime($start_date)));
				$smarty->assign('end_date_show', date('m/d/Y',strtotime($end_date)));
			  }
			$smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
			$smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

		}
			$sqlInv = "SELECT additional_charges FROM ".TBL_INVOICE." inv WHERE inv.is_claimed = 0	";
			$i=0;
			$subTotal = 0;
			if($rs = mysqli_query($GLOBALS['db_connect'],$sqlInv)){
				while($invoiceData = mysqli_fetch_assoc($rs)){

					$charges = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['additional_charges']);
					$charges = unserialize($charges);
					if(!empty($charges)){
						foreach($charges as $key => $value){
							//$newinvoiceCharge[] =array('description' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoiceData['additional_charges'][$key]['description']), 'amount' => $invoiceData['additional_charges'][$key]['amount']);
							$subTotal += $charges[$key]['amount'];

						}
					}

					$i++;
				}
			}

			if($subTotal>0){
				$smarty->assign('shipping', $subTotal);
			}else{
				$smarty->assign('shipping', 0);
			}
			$smarty->display('admin_access_cust_info_seller.tpl');

    }

	function fetch_invoice(){
	    require_once INCLUDE_PATH."lib/adminCommon.php";
        define ("PAGE_HEADER_TEXT", "Admin Access Customer Information");


		$invoiceObj = new Invoice();
		$invoiceData = $invoiceObj->fetchInvoiceAuctionDetails($_REQUEST['invoice_id'] ?? 0);


		if(empty($invoiceData)){
		 $smarty->assign("key", 1);
		}
		$invoiceData['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['auction_details']);
		$invoiceData['auction_details'] = unserialize($invoiceData['auction_details']);
		if(($invoiceData['auction_details'][0]['auction_id'] ?? '')!=''){

		foreach($invoiceData['auction_details'] as $key=>$val){
			 $sql="Select u.firstname,u.lastname,a.fk_auction_type_id,pi.poster_thumb,pi.is_cloud
						 from tbl_auction a , tbl_poster p , user_table u ,tbl_poster_images pi
						    WHERE a.auction_id = '".$invoiceData['auction_details'][$key]['auction_id']."'
  							      AND a.fk_poster_id = p.poster_id
								  AND p.fk_user_id = u.user_id
								  AND pi.fk_poster_id = p.poster_id
								  AND pi.is_default = '1' ";
			$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
			$row= mysqli_fetch_array($resSql);
			$invoiceData['auction_details'][$key]['name'] = $row['firstname'].' '.$row['lastname'];
			$invoiceData['auction_details'][$key]['fk_auction_type_id'] = $row['fk_auction_type_id'];
			//$invoiceData['auction_details'][$key]['image'] = $row['poster_thumb'];
			if ($row['is_cloud'] !='1'){
                $invoiceData['auction_details'][$key]['image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$row['poster_thumb'];
            }else{
                $invoiceData['auction_details'][$key]['image']=CLOUD_POSTER_THUMB.$row['poster_thumb'];
            }
		 }
		}else{

			foreach($invoiceData['auction_details'] as $key=>$val){
				 $sql="Select u.firstname,u.lastname,a.fk_auction_type_id,pi.poster_thumb,pi.is_cloud
							 from tbl_auction a , tbl_poster p , user_table u ,tbl_poster_images pi
								WHERE p.poster_sku = '".$invoiceData['auction_details'][$key]['poster_sku']."'
									  AND a.fk_poster_id = p.poster_id
									  AND p.fk_user_id = u.user_id
									  AND pi.fk_poster_id = p.poster_id
									  AND pi.is_default = '1' ";
				$resSql = mysqli_query($GLOBALS['db_connect'],$sql);
				$row= mysqli_fetch_array($resSql);
				$invoiceData['auction_details'][$key]['name'] = $row['firstname'].' '.$row['lastname'];
				$invoiceData['auction_details'][$key]['fk_auction_type_id'] = $row['fk_auction_type_id'];
				//$invoiceData['auction_details'][$key]['image'] = $row['poster_thumb'];
				if ($row['is_cloud'] !='1'){
					$invoiceData['auction_details'][$key]['image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$row['poster_thumb'];
				}else{
					$invoiceData['auction_details'][$key]['image']=CLOUD_POSTER_THUMB.$row['poster_thumb'];
				}
			 }

		}
		$invoiceData['additional_charges'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['additional_charges']);
		$invoiceData['additional_charges'] = unserialize($invoiceData['additional_charges']);
		$invoiceData['discounts'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoiceData['discounts']);
		$invoiceData['discounts'] = unserialize($invoiceData['discounts']);


		/*echo "<pre>";
		print_r($invoiceData);
		echo "</pre>";*/

		$smarty->assign("invoiceData", $invoiceData);


        $smarty->display('admin_access_cust_info_popup.tpl');
	}

	function mark_shipping_claimed(){
		require_once INCLUDE_PATH."lib/adminCommon.php";

		$sqlInv = "UPDATE ".TBL_INVOICE." inv  set inv.is_claimed=1 WHERE inv.is_claimed = 0 ";
		if(mysqli_query($GLOBALS['db_connect'],$sqlInv)){
			return 1;
		}else{
			return  2;
		}

	}


?>

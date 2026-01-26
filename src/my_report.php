<?php
	ob_start();
	define ("INCLUDE_PATH", "./");
	require_once INCLUDE_PATH."lib/inc.php";
	chkLoginNow();
	if(!isset($_SESSION['sessUserID'])){
		header("Location: index.php");
		exit;
	}
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='print'){
		print_report();
	}if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='view_report'){
		dispmiddle();
	}if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='payment_from_mpe'){
		payment_from_mpe();
	}if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='print_payment_details'){
		print_payment_details();
	}else{
		dispmiddle();	
	}
	ob_end_flush();

	function dispmiddle(){
		require_once INCLUDE_PATH."lib/common.php";
		
		$auctionWeekObj = new AuctionWeek();
        $auctionWeek= $auctionWeekObj->selectAuctionWeek();
        $smarty->assign("auctionWeek", $auctionWeek);
		$auctionWeekStills= $auctionWeekObj->selectAuctionWeekStills();
        $smarty->assign("auctionWeekStills", $auctionWeekStills);
		if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date']) && $_REQUEST['start_date']!='' && $_REQUEST['end_date']!=''){
				if(!compareDates($_REQUEST['start_date'], $_REQUEST['end_date'])){
				$_SESSION['Err'] = "End Date must be greater than Start Date.";
				header("location: ".PHP_SELF."?mode=auction_report&search=".$_REQUEST['search']);
			}else{			    
				if($_REQUEST['start_date']!='')
				{
					$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
				}else{
					$start_date='';	
				}
				if($_REQUEST['end_date']!=''){
					$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
				}else{
					$end_date='';	
				}
				if($_REQUEST['auction_type']=='stills'){
					$_REQUEST['auction_week']=$_REQUEST['auction_stills'];
				}
				########################### Removed as per latest requirement ###############################
				//$dataArr = $objInvoice->reportByUserIdWithDate($_SESSION['sessUserID'],$start_date,$end_date);
				
				$smarty->assign('start_date', $_REQUEST['start_date']);
				$smarty->assign('end_date', $_REQUEST['end_date']);
			    
				$objAuction = new Auction();
				$total_sold=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'sold',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				$total_paid_by_buyer=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'paid_by_buyer',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				$total_unpaid=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'unpaid',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				
				########### total amount  paid by buyer  calculation starts #########
				$objAuction->offset = 0;
				$objAuction->toShow = $total_paid_by_buyer;

				$FetchTotalPaidByBuyer=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'paid_by_buyer',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				$FetchTotalPaidByBuyer=$objAuction->fetchSoldPriceForSeller($FetchTotalPaidByBuyer);

				for($i=0;$i<$total_paid_by_buyer;$i++){
					$total_amount_paid_by_buyer=number_format(($total_amount_paid_by_buyer + $FetchTotalPaidByBuyer[$i]['soldamnt']), 2, '.', '');
				}
				$smarty->assign('total_amount_paid_by_buyer', number_format(($total_amount_paid_by_buyer), 2, '.', ''));

				########### total amount  paid by buyer  calculation ENDS #########

				########### total amount  sold by MPE   calculation starts #########
				$objAuction->offset = 0;
				$objAuction->toShow = $total_sold;
				$FetchTotalSoldByMPE=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'sold',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				$FetchTotalSoldByMPE=$objAuction->fetchSoldPriceForSeller($FetchTotalSoldByMPE);

				for($i=0;$i<$total_sold;$i++){
					$total_amount_sold_by_mpe=number_format(($total_amount_sold_by_mpe + $FetchTotalSoldByMPE[$i]['soldamnt']), 2, '.', '');
				}
				$smarty->assign('total_amount_sold_by_mpe', number_format(($total_amount_sold_by_mpe), 2, '.', ''));

				########### total amount  Sold by MPE  calculation ENDS #########

				########### total amount  Unpaid by buyer calculation starts #########
				$objAuction->offset = 0;
				$objAuction->toShow = $total_unpaid;
				$FetchTotalUnpaidByBuyer=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'unpaid',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				$FetchTotalUnpaidByBuyer=$objAuction->fetchSoldPriceForSeller($FetchTotalUnpaidByBuyer);

				for($i=0;$i<$total_sold;$i++){
					$total_amount_unpaid_by_buyer=number_format(($total_amount_unpaid_by_buyer + $FetchTotalUnpaidByBuyer[$i]['soldamnt']), 2, '.', '');
				}
				$smarty->assign('total_amount_unpaid_by_buyer', number_format(($total_amount_unpaid_by_buyer), 2, '.', ''));

				########### total amount  Unpaid by buyer calculation ends #########
				$smarty->assign('userName', $FetchTotalUnpaidByBuyer[0]['firstname'].' '.$FetchTotalUnpaidByBuyer[0]['lastname']);
				$smarty->assign('total_sold', $total_sold);
				$smarty->assign('total_paid_by_buyer', $total_paid_by_buyer);
				$smarty->assign('total_unpaid', $total_unpaid);
			}
		}else{
			$end_date='';
			$start_date='';
			if($_REQUEST['auction_type']=='stills'){
					$_REQUEST['auction_week']=$_REQUEST['auction_stills'];
				}
			
			$objAuction = new Auction();
			$total_sold=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'sold',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
			$total_paid_by_buyer=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'paid_by_buyer',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
			$total_unpaid=$objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],'unpaid',$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
				
			########### total amount  paid by buyer  calculation starts #########
			$objAuction->offset = 0;
			$objAuction->toShow = $total_paid_by_buyer;

			$FetchTotalPaidByBuyer=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'paid_by_buyer',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
			$FetchTotalPaidByBuyer=$objAuction->fetchSoldPriceForSeller($FetchTotalPaidByBuyer);

			for($i=0;$i<$total_paid_by_buyer;$i++){
				$total_amount_paid_by_buyer=number_format(($total_amount_paid_by_buyer + $FetchTotalPaidByBuyer[$i]['soldamnt']), 2, '.', '');
			}
			$smarty->assign('total_amount_paid_by_buyer', number_format(($total_amount_paid_by_buyer), 2, '.', ''));

			########### total amount  paid by buyer  calculation ENDS #########

			########### total amount  sold by MPE   calculation starts #########
			$objAuction->offset = 0;
			$objAuction->toShow = $total_sold;
			$FetchTotalSoldByMPE=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'sold',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
			$FetchTotalSoldByMPE=$objAuction->fetchSoldPriceForSeller($FetchTotalSoldByMPE);

			for($i=0;$i<$total_sold;$i++){
				$total_amount_sold_by_mpe=number_format(($total_amount_sold_by_mpe + $FetchTotalSoldByMPE[$i]['soldamnt']), 2, '.', '');
			}
			$smarty->assign('total_amount_sold_by_mpe', number_format(($total_amount_sold_by_mpe), 2, '.', ''));

			########### total amount  Sold by MPE  calculation ENDS #########

			########### total amount  Unpaid by buyer calculation starts #########
			$objAuction->offset = 0;
			$objAuction->toShow = $total_unpaid;
			$FetchTotalUnpaidByBuyer=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],'unpaid',$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
			$FetchTotalUnpaidByBuyer=$objAuction->fetchSoldPriceForSeller($FetchTotalUnpaidByBuyer);

			for($i=0;$i<$total_sold;$i++){
				$total_amount_unpaid_by_buyer=number_format(($total_amount_unpaid_by_buyer + $FetchTotalUnpaidByBuyer[$i]['soldamnt']), 2, '.', '');
			}
			$smarty->assign('total_amount_unpaid_by_buyer', number_format(($total_amount_unpaid_by_buyer), 2, '.', ''));

			########### total amount  Unpaid by buyer calculation ends #########
			$smarty->assign('userName', $FetchTotalUnpaidByBuyer[0]['firstname'].' '.$FetchTotalUnpaidByBuyer[0]['lastname']);
			$smarty->assign('total_sold', $total_sold);
			$smarty->assign('total_paid_by_buyer', $total_paid_by_buyer);
			$smarty->assign('total_unpaid', $total_unpaid);
		}		     
			$smarty->assign('auction_type', $_REQUEST['auction_type']);
			$smarty->display("my_selling_report.tpl");
		
	}

	function print_report(){
		require_once INCLUDE_PATH."lib/common.php";
		
		
		$objAuction = new Auction();
         if($_REQUEST['start_date']!='')
         {
             $start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
         }else{
             $start_date='';
         }
         if($_REQUEST['end_date']!=''){
             $end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));
         }else{
             $end_date='';
         }
         $total = $objAuction->countTotalSoldAuctionReport($_SESSION['sessUserID'],$_REQUEST['search'],$start_date,$end_date,$_REQUEST['auction_type'],$_REQUEST['auction_week']);
         
         $smarty->assign('total', $total);              
         $smarty->assign('search', $_REQUEST['search']);
         $smarty->assign('start_date', $start_date);
         $smarty->assign('end_date', $end_date);
         
         $objAuction->offset = 0;
         $objAuction->toShow = $total;

         $FetchTotalYetpaid=$objAuction->fetchTotalSoldAuctionReport($_SESSION['sessUserID'],$_REQUEST['search'],$start_date,$end_date,$_REQUEST['sort'],$_REQUEST['auction_type'],$_REQUEST['auction_week']);
         $FetchTotalYetpaid=$objAuction->fetchSoldPriceForSeller($FetchTotalYetpaid);
         $total_sold_price=0;
         $total_fee=0;
         $total_own=0;

         for($i=0;$i<$total;$i++){
             $FetchTotalYetpaid[$i]['mpe_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_CHARGE_TO_SELLER)/100, 2, '.', '');
             $FetchTotalYetpaid[$i]['trans_charge']=number_format(($FetchTotalYetpaid[$i]['soldamnt']* MPE_TRANSACTION_CHARGE_TO_SELLER)/100, 2, '.', '') ;
             $FetchTotalYetpaid[$i]['tot_charge']=$FetchTotalYetpaid[$i]['mpe_charge']+$FetchTotalYetpaid[$i]['trans_charge'];
             $FetchTotalYetpaid[$i]['seller_owned']=number_format(($FetchTotalYetpaid[$i]['soldamnt']-($FetchTotalYetpaid[$i]['mpe_charge']+ $FetchTotalYetpaid[$i]['trans_charge'])), 2, '.', '');
             $total_sold_price=$total_sold_price + $FetchTotalYetpaid[$i]['soldamnt'];
             $total_fee=$total_fee + $FetchTotalYetpaid[$i]['tot_charge'];
             $total_own=number_format(($total_own + $FetchTotalYetpaid[$i]['seller_owned']), 2, '.', '');
         }


         $smarty->assign('total_sold_price', number_format(($total_sold_price), 2, '.', ''));
         $smarty->assign('total_fee', number_format(($total_fee), 2, '.', ''));         
         $smarty->assign('total_own', number_format(($total_own), 2, '.', ''));        
         $smarty->assign('total', $total);
         $smarty->assign('reportData', $FetchTotalYetpaid);
		 $smarty->assign('userName', $FetchTotalYetpaid[0]['firstname'].' '.$FetchTotalYetpaid[0]['lastname']);
		 $smarty->display("my_report_print.tpl");
		 exit;
	}
	function payment_from_mpe(){
	  	require_once INCLUDE_PATH."lib/common.php";
	  	
	  	if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
		  	if(!compareDates($_REQUEST['start_date'], $_REQUEST['end_date'])){
				$_SESSION['Err'] = "End Date must be greater than Start Date.";
				header("location: ".PHP_SELF."?mode=payment_from_mpe");
				exit;
			}
	  	}
	
		if($_REQUEST['start_date']!=''){
			$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
		}else{
			$start_date='';	
		}
		if($_REQUEST['end_date']!=''){
			$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
	    }else{
	        $end_date='';	
	    }
		$objAuction= new Auction();
	   	$smarty->assign('user_id', $_SESSION['sessUserID']);
		$dataPayment=$objAuction->paymentDetailsSeller($_SESSION['sessUserID'],$start_date,$end_date);
		$total=count($dataPayment);
		$smarty->assign('dataPayment', $dataPayment);
		$smarty->assign('start_date', $_REQUEST['start_date']);
		$smarty->assign('end_date', $_REQUEST['end_date']);
		$smarty->assign('total', $total);		     
		$smarty->display("my_payment_report.tpl");  
	}
	function print_payment_details(){
  	require_once INCLUDE_PATH."lib/common.php";
 
  	if($_REQUEST['start_date'] > $_REQUEST['end_date']){
			$_SESSION['Err'] = "End Date must be greater than Start Date.";
			header("location: ".PHP_SELF."?mode=payment_from_mpe");
		}else{
	
			if($_REQUEST['start_date']!='')
			  {
			   $start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));
			  }else{
			   $start_date='';	
			  }
			if($_REQUEST['end_date']!=''){
			  $end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));	
	        }else{
	          $end_date='';	
	        }
	       $objAuction= new Auction();
   	       $smarty->assign('user_id', $_SESSION['sessUserID']);
		   $dataPayment=$objAuction->paymentDetailsSeller($_SESSION['sessUserID'],$start_date,$end_date);
	       //print_r($dataPayment);
		   $total=count($dataPayment);
		   $smarty->assign('dataPayment', $dataPayment);
		   $smarty->assign('start_date', $start_date);
	       $smarty->assign('end_date', $end_date);
	       $smarty->assign('total', $total);
  	}
  	$smarty->display("print_payment_details.tpl");
  
  }
?>
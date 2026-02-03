<?php
class Invoice extends DBCommon{
	
	public function __construct()
	{		
		parent::__construct();
		$this->primaryKey = 'invoice_id';
		//$this->orderBy = 'approved_on';
		//$this->orderType = 'DESC';
	}
	
	public function generateInvoice($id, $is_bid)
	{
		if($is_bid){
			$sql = "SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
					u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
					u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
					u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
					c.country_code AS shipping_country_code,b.bid_fk_auction_id, b.bid_amount AS amount,
					p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,a.auction_id,a.fk_poster_id,pi.poster_thumb
					FROM ".USER_TABLE." u, ".TBL_BID." b, ".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a,tbl_poster_images pi
					WHERE b.bid_id = '".$id."'
					AND	u.user_id = b.bid_fk_user_id
					AND u.country_id = c.country_id
					AND b.bid_fk_auction_id = a.auction_id
					AND a.fk_poster_id = p.poster_id
					AND pi.fk_poster_id = a.fk_poster_id
					AND pi.is_default = '1'	 ";
		}else{		 
			$sql ="SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
				   u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
				   u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
				   u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
				   c.country_code AS shipping_country_code, p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,
				   ofr.offer_id, cntr_ofr.offer_id AS cntr_offer_id, ofr.offer_is_accepted, cntr_ofr.offer_is_accepted cntr_offer_is_accepted, 
				   ofr.offer_amount, cntr_ofr.offer_amount AS cntr_offer_amount,ofr.offer_fk_auction_id,a.auction_id,a.fk_poster_id,pi.poster_thumb
				   FROM ".USER_TABLE." u,".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a ,tbl_poster_images pi,`tbl_offer` ofr
				   LEFT JOIN `tbl_offer` cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
				   WHERE( ofr.offer_id ='".$id."' OR cntr_ofr.offer_id ='".$id."' )
				   AND(ofr.offer_is_accepted = '1' or cntr_ofr.offer_is_accepted = '1')
				   AND ofr.offer_parent_id=0 AND ofr.offer_fk_user_id=u.user_id
				   AND u.country_id = c.country_id AND ofr.offer_fk_auction_id = a.auction_id
				   AND a.fk_poster_id = p.poster_id
				   AND pi.fk_poster_id = a.fk_poster_id
				   AND pi.is_default = '1' ";	
		}
		$rs = mysqli_query($GLOBALS['db_connect'], $sql);
		$row = mysqli_fetch_array($rs);
		$winnerName = $row['firstname'].' '.$row['lastname']; 
		if($is_bid){
			$amount = $row['amount'];
			$auction_id = $row['bid_fk_auction_id'];	
		}else{
			 $auction_id = $row['offer_fk_auction_id'];	
			 if($row['offer_is_accepted'] == '1'){
			  	$amount = $row['offer_amount'];
			 }elseif($row['cntr_offer_is_accepted'] == '1'){
			  	$amount = $row['cntr_offer_amount'];
			 }
		}
		$billing_address = serialize(array('billing_firstname' => $row['firstname'],
										   'billing_lastname' => $row['lastname'],
										   'billing_country_id' => $row['country_id'],
										   'billing_country_name' => $row['country_name'],
										   'billing_country_code' => $row['country_code'],
										   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['city']),
										   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['state']),
										   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address1']),
										   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address2']),
										   'billing_zipcode' => $row['zipcode']));
		$shipping_address = serialize(array('shipping_firstname' => $row['firstname'],
										    'shipping_lastname' => $row['lastname'],
										    'shipping_country_id' => $row['shipping_country_id'],
											'shipping_country_name' => $row['shipping_country_name'],
											'shipping_country_code' => $row['shipping_country_code'],
											'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_city']),
											'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_state']),
											'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address1']),
											'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address2']),
											'shipping_zipcode' => $row['shipping_zipcode']));
		$auction_details = serialize(array(0 => array('auction_id' => $row['auction_id'],
													  'poster_sku' => $row['poster_sku'],
													  'poster_title' =>  mysqli_real_escape_string($GLOBALS['db_connect'],$row['poster_title']),
													  'amount' => $amount)));

		/*if($row['shipping_state'] == 'Georgia'){
			$sale_tax =  array('description' => 'Sale Tax', 'amount' => ($amount*SALE_TAX_GA/100));
		}elseif($row['shipping_state'] == 'North Carolina'){
			$sale_tax =  array('description' => 'Sale Tax', 'amount' => ($amount*SALE_TAX_NC/100));
		}
		
		$additional_charges = serialize(array(0 => $sale_tax));*/
		
		$data = array('fk_user_id' => $row['user_id'], 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
					  'total_amount' => $amount, 'auction_details' => $auction_details,
					  'invoice_generated_on' => date("Y-m-d H:i:s"), 'is_buyers_copy' => 1,'is_approved'=>1,'is_new'=>1);
					  
		/* Invoice for Buyer */
		$invoice_id = $this->updateData(TBL_INVOICE, $data);
		$this->updateData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => $auction_id, 'fk_invoice_id' => $invoice_id, 'amount' => $amount));
		//$this->mailInvoice($invoice_id);
		$sql_insert_sold="Insert into `tbl_sold_archive` (`auction_id`,
													 `invoice_generated_on`,
													 `fk_auction_type_id`,												
							 						 `poster_id`,
							 						 `winnerName`,
							 						 `soldamnt`,
													 `is_cloud`,
													 `auction_week_id`,
													 `poster_thumb`) values
							 						 (
													  '".$row['auction_id']."',							 						  
							 						  '".date("Y-m-d H:i:s")."',							 						  
							 						  '1',
							 						  '".$row['fk_poster_id']."',
							 						  '".$winnerName."',
							 						  '".$amount."',
													  '1',
													  '0',
													  '".$row['poster_thumb']."'
							 						 )";
	 
	 	mysqli_query($GLOBALS['db_connect'], $sql_insert_sold);	
		return;
	}
	
	function processInstantPaymentInvoice($user_id, $cart, $billing_info, $shipping_info)
	{
		$billing_address = serialize(array('billing_firstname' => $billing_info['billing_firstname'],
										   'billing_lastname' => $billing_info['billing_lastname'],
										   'billing_country_id' => $billing_info['billing_country_id'],
										   'billing_country_name' => $billing_info['billing_country_name'],
										   'billing_country_code' => $billing_info['billing_country_code'],
										   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$billing_info['billing_city']),
										   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$billing_info['billing_state']),
										   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$billing_info['billing_address1']),
										   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$billing_info['billing_address2']),
										   'billing_zipcode' => $billing_info['billing_zipcode']));							   
		$shipping_address = serialize(array('shipping_firstname' => $shipping_info['shipping_firstname'],
										    'shipping_lastname' => $shipping_info['shipping_lastname'],
										    'shipping_country_id' => $shipping_info['shipping_country_id'],
											'shipping_country_name' => $shipping_info['shipping_country_name'],
											'shipping_country_code' => $shipping_info['shipping_country_code'],
											'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$shipping_info['shipping_city']),
											'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$shipping_info['shipping_state']),
											'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$shipping_info['shipping_address1']),
											'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$shipping_info['shipping_address2']),
											'shipping_zipcode' => $shipping_info['shipping_zipcode']));
		foreach($cart as $key => $value){
			$auctionsArr[] = array('auction_id' => $value['auction_id'],'poster_sku' => $value['poster_sku'], 'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$value['poster_title']), 'amount' => $value['amount']);
			$subTotal += $value['amount'];
		}
		$auction_details = serialize($auctionsArr);

		$shipping_charge = array('description' => 'Shipping Charge ('.strtoupper($shipping_info['shipping_methods'])." - ".$shipping_info['shipping_desc'].')',
								 'amount' => $shipping_info['shipping_charge']);
		
		if($shipping_info['shipping_state'] == 'Georgia'){
			$sale_tax =  array('description' => 'Sales Tax', 'amount' => ($subTotal*SALE_TAX_GA/100));
			$additional_charges = serialize(array(0 => $shipping_charge, 1 => $sale_tax));
		}elseif($shipping_info['shipping_state'] == 'North Carolina'){
			$sale_tax =  array('description' => 'Sales Tax', 'amount' => ($subTotal*SALE_TAX_NC/100));
			$additional_charges = serialize(array(0 => $shipping_charge, 1 => $sale_tax));
		}else{
			$additional_charges = serialize(array(0 => $shipping_charge));
		}
		
		$total_amount = $subTotal + $shipping_info['shipping_charge'] + $sale_tax['amount'];
		
		$data = array('fk_user_id' => $user_id, 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
					  'auction_details' => $auction_details, 'additional_charges' => $additional_charges, 'total_amount' => $total_amount,
					  'invoice_generated_on' => date("Y-m-d H:i:s"), 'paid_on' => date("Y-m-d H:i:s"), 'is_paid' => '1', 'is_buyers_copy' => 1,'is_new'=>1);

		/* Invoice for Buyer */
		$invoice_id = $this->updateData(TBL_INVOICE, $data);
		$this->mailInvoice($invoice_id);
		
		foreach($cart as $key => $value){
			$sql_for_sold_item_auction = "SELECT
											  a.fk_auction_type_id,
											  a.fk_poster_id,
											  pia.poster_thumb
											FROM tbl_auction a,tbl_poster_images pia
											WHERE a.auction_id = ".$value['auction_id']."
												AND a.fk_poster_id = pia.fk_poster_id
												AND pia.is_default = '1' ";
			$sql_for_sold_item_auction_res = mysqli_query($GLOBALS['db_connect'],$sql_for_sold_item_auction);
			$sql_for_sold_item_auction_row = mysqli_fetch_array($sql_for_sold_item_auction_res);
			
			$sql_for_sold_item_user = "SELECT firstname,lastname from user_table where user_id=".$user_id;
			$sql_for_sold_item_user_res = mysqli_query($GLOBALS['db_connect'],$sql_for_sold_item_auction);
			$sql_for_sold_item_user_row = mysqli_fetch_array($sql_for_sold_item_auction_res);
			
			$winnerName = $sql_for_sold_item_user_row["firstname"]." ".$sql_for_sold_item_user_row["lastname"];
			
			$this->updateData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => $value['auction_id'], 'fk_invoice_id' => $invoice_id, 'amount' => $value['amount']));
			$this->updateData(TBL_AUCTION, array('auction_is_sold' => '2', 'auction_payment_is_done' => '1'), array('auction_id' => $value['auction_id']), true);
			
			$sql_insert_sold="Insert into `tbl_sold_archive` (`auction_id`,
													 `invoice_generated_on`,
													 `fk_auction_type_id`,
							 						 `poster_id`,
							 						 `winnerName`,
							 						 `soldamnt`,
													 `is_cloud`,
													 `auction_week_id`,
													 `poster_thumb`) values
							 						 (
													  '".$value['auction_id']."',							 						  
							 						  '".date("Y-m-d H:i:s")."',
							 						  '".$sql_for_sold_item_auction_row['fk_auction_type_id']."',							 						  
							 						  '".$sql_for_sold_item_auction_row['fk_poster_id']."',
							 						  '".$winnerName."',
							 						  '".$value['amount']."',
													  '1',
													  '0',
													  '".$sql_for_sold_item_auction_row['poster_thumb']."'
							 						 )";
			mysqli_query($GLOBALS['db_connect'], $sql_insert_sold);
		}
		
		$this->generateSellerInvoice($invoice_id);
		
		return $invoice_id;
	}
	
	function auctionIdByUserId($user_id, $is_buyers_copy = 1,$is_archived=''){
		 $sqlAuction="Select invoice_id,auction_details,total_amount,invoice_generated_on,is_approved,is_cancelled,is_paid,is_ordered from `tbl_invoice` where (is_approved='1' or is_paid='1') and is_cancelled <> '1' and is_buyers_copy='".$is_buyers_copy."' and fk_user_id=".$user_id ." ";
		 if($is_archived){
			$sqlAuction.= " and is_archived <> '1' " ;
		 }else{
			$sqlAuction.= " and is_archived <> '0' " ;
		 }
		 if($is_archived){
		    $sqlAuction.= " order by invoice_generated_on desc" ;			
		 }else{
			$sqlAuction.= " order by archived_date desc " ;
		 }
		if($res_sqlAuction=mysqli_query($GLOBALS['db_connect'], $sqlAuction)){
		   while($row = mysqli_fetch_assoc($res_sqlAuction)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	function reportByUserId($user_id, $is_buyers_copy = 0){
		 $sqlAuction="Select invoice_id,auction_details,total_amount,invoice_generated_on,paid_on,is_approved,is_cancelled,is_paid from `tbl_invoice` where is_paid='1' and is_approved='1' and is_buyers_copy='".$is_buyers_copy."' and fk_user_id=".$user_id;
		
		if($res_sqlAuction=mysqli_query($GLOBALS['db_connect'], $sqlAuction)){
		   while($row = mysqli_fetch_assoc($res_sqlAuction)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}
	function reportByUserIdWithDate($user_id,$start_date='',$end_date=''){
		 $sqlAuction="Select * from `tbl_invoice` where is_paid='1' and is_approved='1' and is_buyers_copy='0'  and fk_user_id=".$user_id;
		 if($start_date!='' && $end_date!=''){
			$sqlAuction.=" and DATE_FORMAT(paid_on,'%Y-%m-%d') >='".$start_date."' and DATE_FORMAT(paid_on,'%Y-%m-%d') <='".$end_date."'";
		 }
	//		 echo $sqlAuction;
		if($res_sqlAuction=mysqli_query($GLOBALS['db_connect'], $sqlAuction)){
		   while($row = mysqli_fetch_assoc($res_sqlAuction)){
			   $dataArr[] = $row;
		   }
		   return $dataArr;
		}
		return false;
	}	
	function fetchInvoiceByAuctionId($auction_id, $user_id = '')
	{
		$sql = "SELECT a.auction_actual_end_datetime,inv.* FROM ".TBL_INVOICE." inv, ".TBL_INVOICE_TO_AUCTION." ita,tbl_auction a
				WHERE inv.invoice_id = ita.fk_invoice_id
				AND ita.fk_auction_id = '".$auction_id."' AND inv.is_buyers_copy='1' and a.auction_id=ita.fk_auction_id ";
		if($user_id != ''){
			$sql .= " AND inv.fk_user_id = '".$user_id."'";
		}
		if($rs = mysqli_query($GLOBALS['db_connect'], $sql)){
		   return mysqli_fetch_assoc($rs);
		}
		return false;
	}
	
	function fetchInvoiceByAuctionIdSeller($auction_id, $user_id = '')
	{
		$sql = "SELECT inv.* FROM ".TBL_INVOICE." inv, ".TBL_INVOICE_TO_AUCTION." ita
				WHERE inv.invoice_id = ita.fk_invoice_id
				AND ita.fk_auction_id = '".$auction_id."' AND inv.is_buyers_copy='0'";
		if($user_id != ''){
			$sql .= " AND inv.fk_user_id = '".$user_id."'";
		}
		if($rs = mysqli_query($GLOBALS['db_connect'], $sql)){
		   return mysqli_fetch_assoc($rs);
		}
		return false;
	}
	
	function findWeightArrayForInvoice($invoice_id)
	{
		 
		$i=0;
		$flat_rolled=array();
		$poster_size_id=array();
		$size_weight_cost=array();
		$insert_key=true;
		$insert_key_for_size=true;
		$new_key=true;
		$sql="SELECT p.flat_rolled,tpc.fk_cat_id 
					 FROM ".TBL_AUCTION." a , ".TBL_POSTER." p ,".TBL_INVOICE_TO_AUCTION." tia,tbl_poster_to_category tpc ,tbl_category tc
		     			where tia.fk_invoice_id=$invoice_id
		     			and tia.fk_auction_id=a.auction_id 
		     			and a.fk_poster_id = p.poster_id
		     			and tpc.fk_poster_id =  p.poster_id
		     			and tc.cat_id = tpc.fk_cat_id
		     			and tc.fk_cat_type_id = 1
		     			";
		$res_sql=mysqli_query($GLOBALS['db_connect'], $sql);
		
        while($row=mysqli_fetch_array($res_sql)){
            array_push($flat_rolled, substr($row['flat_rolled'],0,1));
            array_push($poster_size_id, $row['fk_cat_id']);
            $i++;
        }
		//print_r($poster_size_id);
		//print_r($flat_rolled);
		//die();
		$j=0;
		foreach($poster_size_id as $key=>$val){
			$insert_key=true;
			$sql_cat_val="Select cat_value
								 from tbl_category 
								 	where cat_id=".$poster_size_id[$j];
			$sql_cat_val_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_cat_val));
			$name=$sql_cat_val_res['cat_value'];
			
			$sql_count="SELECT COUNT(c.cat_id) AS counter,cw.size_weight_cost_id,cw.size_type,cw.length
							   FROM tbl_category c,tbl_size_weight_cost_master cw 
							   		WHERE c.cat_value='".$name."' 
							   		and cw.size_weight_cost_id = c.fk_size_weight_cost_id 
							   		";
			$sql_count_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_count));
			$count=$sql_count_res['counter'];
			
			$size_weight_cost_id=$sql_count_res['size_weight_cost_id']; 
			$length_main_id=$sql_count_res['length'];  
			$size_type_main_id=$flat_rolled[$j];
			if($count=='1'){
				//$insert_key=true;
				if(!empty($size_weight_cost)){
				#### checking if the $size_weight_cost_id exists in the array already
					foreach ($size_weight_cost as $key=>$val){
						if($size_weight_cost[$key]!=$size_weight_cost_id){
						}else{
							$insert_key=false;
							$insert_key_for_size=false;
						}
						
					}
				##### checking completes here with the result depending on the values $insert_key,$insert_key ######	
					if($insert_key){
						$k=0;
						foreach($size_weight_cost as $key=>$val){
							$sql_final_chk="SELECT length,size_type 
													   from tbl_size_weight_cost_master 
													   		where size_weight_cost_id=".$size_weight_cost[$k];
							
								$sql_final_chk_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_final_chk));
								$size_type_array=$sql_final_chk_res['size_type'];
								$length_array=$sql_final_chk_res['length'];
								$insert_key_for_size=true;
								
								if($size_type_array==$size_type_main_id){
								
									if($length_array > $length_main_id){
										$insert_key_for_size=false;
										$new_key=false;
									}elseif($length_array < $length_main_id){
										unset($size_weight_cost[$k]);
										$arrSizes= array();
										foreach($size_weight_cost as $key => $value) {		
										$arrSizes[] = $value;
										}
										$size_weight_cost=$arrSizes;
										array_push($size_weight_cost, $size_weight_cost_id);
										$insert_key_for_size=false;
										$new_key=false;
									}
								}
								
							$k++;
						}
					}
					if($insert_key_for_size){
						foreach ($size_weight_cost as $key=>$val){
							if($size_weight_cost[$key]!=$size_weight_cost_id){
								$new_key=true;
							}else{
								$new_key=false;
							}
						}
						if($new_key){
							array_push($size_weight_cost, $size_weight_cost_id);
						}
						$insert_key_for_size=false;
					}
				}else{
					array_push($size_weight_cost, $size_weight_cost_id);
				}
			}elseif($count=='2'){
				//$insert_key=true;
				$sql_size_weight=" SELECT cw.size_weight_cost_id,cw.length
										 FROM tbl_category c,tbl_size_weight_cost_master cw 
										 	WHERE c.cat_value='".$name."' 
										 	AND c.fk_size_weight_cost_id = cw.size_weight_cost_id
										 	ANd cw.size_type='".$flat_rolled[$j]."'";

				$sql_size_weight_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_size_weight));	
				$size_weight_cost_id=$sql_size_weight_res['size_weight_cost_id'];
				$length_main_id=$sql_size_weight_res['length'];
				if(!empty($size_weight_cost)){
					
				#### checking if the $size_weight_cost_id exists in the array already
					foreach ($size_weight_cost as $key=>$val){
						if($size_weight_cost[$key]!=$size_weight_cost_id){
						
						}else{
							$insert_key=false;
							$insert_key_for_size=false;
						}
						
					}
				##### checking completes here with the result depending on the values $insert_key,$insert_key ######	
					if($insert_key){
						$k=0;
						foreach($size_weight_cost as $key=>$val){
							$sql_final_chk="SELECT length,size_type 
													   from tbl_size_weight_cost_master 
													   		where size_weight_cost_id=".$size_weight_cost[$k];
							
								$sql_final_chk_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_final_chk));
								$size_type_array=$sql_final_chk_res['size_type'];
								$length_array=$sql_final_chk_res['length'];
								$insert_key_for_size=true;
								if($size_type_array==$size_type_main_id){
								
									if($length_array > $length_main_id){
										$insert_key_for_size=false;
										$new_key=false;
									}elseif($length_array < $length_main_id){
										unset($size_weight_cost[$k]);
										$arrSizes= array();
										foreach($size_weight_cost as $key => $value) {		
										$arrSizes[] = $value;
										}
										$size_weight_cost=$arrSizes;
										array_push($size_weight_cost, $size_weight_cost_id);
										$insert_key_for_size=false;
										$new_key=false;
									}
								}
							$k++;
						}
					}
					if($insert_key_for_size){
						foreach ($size_weight_cost as $key=>$val){
							if($size_weight_cost[$key]!=$size_weight_cost_id){
								$new_key=true;
							}else{
								$new_key=false;
							}
						}
						if($new_key){
							array_push($size_weight_cost, $size_weight_cost_id);
						}
						$insert_key_for_size=false;
					}
				
					
					
				}else{
					array_push($size_weight_cost, $size_weight_cost_id);
				}
			}
			$j++;
			}
        $final = array();
        if(count($size_weight_cost)>1){
            $final[0]=$size_weight_cost[0];
            $final[1]=$size_weight_cost[1];
            return $final;
        }else{
            return $size_weight_cost;
        }
	
	}
	
	function findWeightArrayForCart(&$dataArr)
	{
		$i=0;
		$flat_rolled=array();
		$poster_size_id=array();
		$size_weight_cost=array();
		$insert_key=true;
		$insert_key_for_size=true;
		$new_key=true;
		foreach($dataArr as $key=>$val){
		$sql="SELECT p.flat_rolled,tpc.fk_cat_id 
					 FROM ".TBL_AUCTION." a , ".TBL_POSTER." p ,tbl_poster_to_category tpc ,tbl_category tc
		     			where a.fk_poster_id = p.poster_id
		     			and tpc.fk_poster_id =  p.poster_id
		     			and tc.cat_id = tpc.fk_cat_id
		     			and tc.fk_cat_type_id = 1
		     			and a.auction_id = ".$dataArr[$i]['auction_id'];
		$res_sql=mysqli_query($GLOBALS['db_connect'], $sql);
		$row=mysqli_fetch_array($res_sql);
		array_push($flat_rolled, substr($row['flat_rolled'],0,1));
		array_push($poster_size_id, $row['fk_cat_id']);
		$i++;
		}
		/*echo"<pre>";
		print_r($poster_size_id);
		print_r($flat_rolled);
		echo "</pre>";*/
		$j=0;
		foreach($poster_size_id as $key=>$val){
			$insert_key=true;
			$sql_cat_val="Select cat_value
								 from tbl_category 
								 	where cat_id=".$poster_size_id[$j];
			$sql_cat_val_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_cat_val));
			$name=$sql_cat_val_res['cat_value'];
			
			$sql_count="SELECT COUNT(c.cat_id) AS counter,cw.size_weight_cost_id,cw.size_type,cw.length
							   FROM tbl_category c,tbl_size_weight_cost_master cw 
							   		WHERE c.cat_value='".$name."' 
							   		and cw.size_weight_cost_id = c.fk_size_weight_cost_id 
							   		";
			$sql_count_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_count));
			$count=$sql_count_res['counter'];
			
			$size_weight_cost_id=$sql_count_res['size_weight_cost_id']; 
			$length_main_id=$sql_count_res['length'];  
			$size_type_main_id=$flat_rolled[$j];
			if($count=='1'){
				//$insert_key=true;
				if(!empty($size_weight_cost)){
				#### checking if the $size_weight_cost_id exists in the array already
					foreach ($size_weight_cost as $key=>$val){
						if($size_weight_cost[$key]!=$size_weight_cost_id){
						}else{
							$insert_key=false;
							$insert_key_for_size=false;
						}
						
					}
				##### checking completes here with the result depending on the values $insert_key,$insert_key ######	
					if($insert_key){
						$k=0;
						foreach($size_weight_cost as $key=>$val){
							$sql_final_chk="SELECT length,size_type 
													   from tbl_size_weight_cost_master 
													   		where size_weight_cost_id=".$size_weight_cost[$k];
							
								$sql_final_chk_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_final_chk));
								$size_type_array=$sql_final_chk_res['size_type'];
								$length_array=$sql_final_chk_res['length'];
								$insert_key_for_size=true;
								
								if($size_type_array==$size_type_main_id){
								
									if($length_array > $length_main_id){
										$insert_key_for_size=false;
										$new_key=false;
									}elseif($length_array < $length_main_id){
										unset($size_weight_cost[$k]);
										$arrSizes= array();
										foreach($size_weight_cost as $key => $value) {		
										$arrSizes[] = $value;
										}
										$size_weight_cost=$arrSizes;
										array_push($size_weight_cost, $size_weight_cost_id);
										$insert_key_for_size=false;
										$new_key=false;
									}
								}
								
							$k++;
						}
					}
					if($insert_key_for_size){
						foreach ($size_weight_cost as $key=>$val){
							if($size_weight_cost[$key]!=$size_weight_cost_id){
								$new_key=true;
							}else{
								$new_key=false;
							}
						}
						if($new_key){
							array_push($size_weight_cost, $size_weight_cost_id);
						}
						$insert_key_for_size=false;
					}
				}else{
					array_push($size_weight_cost, $size_weight_cost_id);
				}
			}elseif($count=='2'){
				//$insert_key=true;
				$sql_size_weight=" SELECT cw.size_weight_cost_id,cw.length
										 FROM tbl_category c,tbl_size_weight_cost_master cw 
										 	WHERE c.cat_value='".$name."' 
										 	AND c.fk_size_weight_cost_id = cw.size_weight_cost_id
										 	ANd cw.size_type='".$flat_rolled[$j]."'";
				$sql_size_weight_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_size_weight));	
				$size_weight_cost_id=$sql_size_weight_res['size_weight_cost_id'];
				$length_main_id=$sql_size_weight_res['length'];
				if(!empty($size_weight_cost)){
					
				#### checking if the $size_weight_cost_id exists in the array already
					foreach ($size_weight_cost as $key=>$val){
						if($size_weight_cost[$key]!=$size_weight_cost_id){
						
						}else{
							$insert_key=false;
							$insert_key_for_size=false;
						}
						
					}
				##### checking completes here with the result depending on the values $insert_key,$insert_key ######	
					if($insert_key){
						$k=0;
						foreach($size_weight_cost as $key=>$val){
							$sql_final_chk="SELECT length,size_type 
													   from tbl_size_weight_cost_master 
													   		where size_weight_cost_id=".$size_weight_cost[$k];
							
								$sql_final_chk_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_final_chk));
								$size_type_array=$sql_final_chk_res['size_type'];
								$length_array=$sql_final_chk_res['length'];
								$insert_key_for_size=true;
								if($size_type_array==$size_type_main_id){
								
									if($length_array > $length_main_id){
										$insert_key_for_size=false;
										$new_key=false;
									}elseif($length_array < $length_main_id){
										unset($size_weight_cost[$k]);
										$arrSizes= array();
										foreach($size_weight_cost as $key => $value) {		
										$arrSizes[] = $value;
										}
										$size_weight_cost=$arrSizes;
										array_push($size_weight_cost, $size_weight_cost_id);
										$insert_key_for_size=false;
										$new_key=false;
									}
								}
							$k++;
						}
					}
					if($insert_key_for_size){
						foreach ($size_weight_cost as $key=>$val){
							if($size_weight_cost[$key]!=$size_weight_cost_id){
								$new_key=true;
							}else{
								$new_key=false;
							}
						}
						if($new_key){
							array_push($size_weight_cost, $size_weight_cost_id);
						}
						$insert_key_for_size=false;
					}
				
					
					
				}else{
					array_push($size_weight_cost, $size_weight_cost_id);
				}
			}
			$j++;
			}
		
		return $size_weight_cost;
		/*echo"<pre>";
		print_r($size_weight_cost);
		echo "</pre>";
		die();*/
		

	
   }
   
   function generateSellerInvoice($buyer_invoice_id)
   {
		$sql = "SELECT a.auction_id,a.fk_auction_type_id, p.poster_sku, p.poster_title, ita.amount, u.user_id, u.firstname, u.lastname,u.email,
				u.country_id, u.city, u.state, u.address1, u.address2, u.zipcode, c.country_name, c.country_code,i.shipping_address,i.billing_address,i.invoice_generated_on
				FROM ".TBL_INVOICE." i, ".TBL_INVOICE_TO_AUCTION." ita,".TBL_AUCTION." a, ".TBL_POSTER." p, ".USER_TABLE." u, ".COUNTRY_TABLE." c
				WHERE i.invoice_id = ita.fk_invoice_id
				AND ita.fk_auction_id = a.auction_id
				AND a.fk_poster_id = p.poster_id
				AND p.fk_user_id = u.user_id
				AND u.country_id = c.country_id
				AND i.invoice_id = '".$buyer_invoice_id."'";
		$rs = mysqli_query($GLOBALS['db_connect'], $sql);
		while($invoice = mysqli_fetch_array($rs)){
			$billing_address = serialize(array('billing_firstname' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['firstname']),
											   'billing_lastname' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['lastname']),
											   'billing_country_id' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['country_id']),
											   'billing_country_name' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['country_name']),
											   'billing_country_code' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['country_code']),
											   'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['city']),
											   'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['state']),
											   'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['address1']),
											   'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['address2']),
											   'billing_zipcode' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['zipcode'])));
			
			$auction_details = serialize(array(0 => array('auction_id' => $invoice['auction_id'],
														  'poster_sku' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['poster_sku']),
														  'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['poster_title']),
														  'amount' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['amount']))));
			if($invoice['fk_auction_type_id']=='1' || $invoice['fk_auction_type_id']=='4'){
				$mpe_charge = number_format(((mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['amount'])*MPE_CHARGE_TO_SELLER)/100), 2, '.', '');
			}else{
				$mpe_charge = number_format(((mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['amount'])*MPE_CHARGE_TO_SELLER_WEEKLY)/100), 2, '.', '');
			}
			$transection_charge = number_format(((mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['amount'])*MPE_TRANSACTION_CHARGE_TO_SELLER)/100), 2, '.', '');
			
			$mpe_charges = serialize(array(array('description' => 'MPE Commission', 'amount' => $mpe_charge),
									 array('description' => 'Merchant Fee', 'amount' => $transection_charge)));
			
			$amount = mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['amount']) - ($mpe_charge + $transection_charge);						 
			$sellers_data = array('fk_user_id' => $invoice['user_id'], 'billing_address' => $billing_address, 'auction_details' => $auction_details,
								  'discounts' => $mpe_charges, 'total_amount' => $amount, 'invoice_generated_on' => date("Y-m-d H:i:s"),'paid_on' => date("Y-m-d H:i:s"),
								  'is_paid' => '1', 'is_buyers_copy' => 0);
			
			
			
			$seller_invoice_id = $this->updateData(TBL_INVOICE,$sellers_data);
			$check = $this->updateData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => mysqli_real_escape_string($GLOBALS['db_connect'],$invoice['auction_id']), 'fk_invoice_id' => $seller_invoice_id, 'amount' => $amount));
			if($seller_invoice_id && ($invoice['fk_auction_type_id']=='1' || $invoice['fk_auction_type_id']=='4')){
			
				
			
		
		//$sqlSeller = "SELECT usr.email, usr.firstname, usr.lastname"
		
		
				$row['billing_address'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoice['billing_address']);
				$row['billing_address'] = unserialize($invoice['billing_address']);
				$row['shipping_address'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $invoice['shipping_address']);
				$row['shipping_address'] = unserialize($invoice['shipping_address']);
				$row['invoice_generated_on'] = formatDateTime($invoice['invoice_generated_on']);
				
				$email_template .=  '<table align="center" width="60%" border="0" style="border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer"  bgcolor="Silver"><b>&nbsp;';
		
		
            	$type="Invoice Details";
            	$dateOfInvoice="Date of Invoice:";
        
				$email_template .= $type;
				$email_template .= '</b></td>
								</tr>';
		
				$email_template .=	'<tr height="26">
									<td align="left" colspan="2" class="printer" style="border-bottom:1px solid #cccccc;"><b>Date of Buyer Invoice:</b>'.$row['invoice_generated_on'].'</td>
								</tr>' ;  
		                            
				$email_template .=			'<tr height="26">
									<td align="left">';
				$email_template .= '</td>
									<td align="left">';
									if(is_array($row['shipping_address'])){
										$email_template .= '<b>Shipping Address</b><br />'.
															$row['shipping_address']['shipping_firstname'].'&nbsp;'.$row['shipping_address']['shipping_lastname'].'<br/>'.
															$row['shipping_address']['shipping_address1'];
															if($row['shipping_address']['shipping_address2'] != ''){
																$email_template .= '&nbsp;'.$row['shipping_address']['shipping_address2'];
															}
															$email_template .= '<br />'.$row['shipping_address']['shipping_city'].'&nbsp;'.																				
																				$row['shipping_address']['shipping_state'].'&nbsp;'.
																				$row['shipping_address']['shipping_zipcode'].'<br />';
									}else{
										$email_template .= '&nbsp;';
									}
				$email_template .= '</td>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
								<tr>
									<td align="left" colspan="2">
										<table border="0" width="100%" align="left" cellpadding="2" cellspacing="0" style="border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
											<tr bgcolor="#c4c4c4" class="printer">
												<td align="left" width="25%" style="border:1px solid #CCCCCC;"><b>Sl No</b></td>
												<td align="left" width="50$" style="border:1px solid #CCCCCC;"><b>Title</b></td>
												<td align="left" width="25%" style="border:1px solid #CCCCCC;"><b>Price</b></td>
											</tr>
											<tr><td colspan="3">&nbsp;</td></tr>';
											
											$email_template .= '<tr>
																			<td align="left" style="border-top:1px solid #CCCCCC;">1</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">'.$invoice['poster_title'].'</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">$'.number_format($invoice['amount'], 2).'</td>
																		</tr>';
											
											

						$email_template .= '</table>
									</td>
								</tr>    
							</table>';
				
				$toMail = $invoice['email'];
				$toName = $invoice['firstname'].' '.$invoice['lastname'];
				$fromMail = ADMIN_EMAIL_ADDRESS;
				$fromName = ADMIN_NAME;

				$subject = "MPE::Buyer has paid for - ".$invoice['poster_title']." ";

				$textContent = 'Dear '.$invoice['firstname'].' '.$invoice['lastname'].',<br /><br />';
				//$textContent .= '<b>Poster Title : </b>'.$invoice['poster_title'].'<br />';
				$textContent .= 'Congratulations! Your Item has Sold and Buyer has paid for:<br />';
				$textContent .= "<b>".$invoice['poster_title']."</b><br />";
				$textContent .= "Please ship to Buyer promptly so that we may expedite payment to you. Please email MPE at info@movieposterexchange.com and confirm item has shipped(You can simply reply to this email with info). <br /><br />";
				$textContent .= "Please provide method of shipping and tracking information.<br /><br />";
				$textContent .= $email_template;
				
				$textContent .= '<br /><br />For more details, please <a href="http://'.HOST_NAME.'/">login </a> and go to <b> My Selling/Sold </b> <br /><br />';
				$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
				$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
				$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
			
			}else{		
				
				$toMail = $invoice['email'];
				$toName = $invoice['firstname'].' '.$invoice['lastname'];
				$fromMail = ADMIN_EMAIL_ADDRESS;
				$fromName = ADMIN_NAME;

				$subject = "MPE::Buyer has paid for - ".$invoice['poster_title']." ";

				$textContent = 'Dear '.$invoice['firstname'].' '.$invoice['lastname'].',<br /><br />';
				$textContent .= 'Congratulations! <b>Poster Title : </b>'.$invoice['poster_title'].' has been sold. <br />';
				$textContent .= 'Buyer has paid! Please ship item to:<br /><br />';
				$textContent .= 'Movie Poster Exchange <br /><br />';
				$textContent .= 'POB 123<br /><br />';
				$textContent .= 'Gibsonville, NC 27249 <br /><br />';
				$textContent .= 'Please ship promptly so that we may expedite transaction and issue payment to you! If MPE is currently holding item then please disregard. <br /><br />';
				$textContent .= 'For more details, please <a href="http://'.HOST_NAME.'/">login </a> and go to <b> My Selling/Sold </b> <br /><br />';
				$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
				$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
				//$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);		
			
			}
		}	
   }
   
   function mailInvoice($invloce_id,$EmailType='')
	{
		//$invoiceObj = new Invoice();
		//$dataArr = $invoiceObj->selectData(TBL_INVOICE, array('*'), array('invoice_id' => $invloce_id));
		
		$sql = "SELECT usr.email, usr.firstname, usr.lastname, inv.* FROM ".TBL_INVOICE." inv, ".USER_TABLE." usr
				WHERE usr.user_id = inv.fk_user_id AND inv.invoice_id = '".$invloce_id."'";
		$rs = mysqli_query($GLOBALS['db_connect'], $sql);
		$row = mysqli_fetch_array($rs);
		$chk_item_type=$this->chk_item_type($invloce_id);
		
		//$sqlSeller = "SELECT usr.email, usr.firstname, usr.lastname"
		
		
		$row['billing_address'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row['billing_address']);
		$row['billing_address'] = unserialize($row['billing_address']);
		$row['shipping_address'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row['shipping_address']);
		$row['shipping_address'] = unserialize($row['shipping_address']);
		$row['auction_details'] = preg_replace_callback('!s:(\d+):"(.*?)";!s', function($m) { return 's:'.strlen($m[2]).':"'.$m[2].'";'; }, $row['auction_details']);
		$row['auction_details'] = unserialize($row['auction_details']);
		$row['additional_charges'] = unserialize($row['additional_charges']);
		$row['discounts'] = unserialize($row['discounts']);		
		$row['invoice_generated_on'] = formatDateTime($row['invoice_generated_on']);
		if($chk_item_type==1 || $chk_item_type==4){
			for($k=0;$k<count($row['auction_details']);$k++){
				$seller_sql = "Select u.username,u.user_id from user_table u , tbl_auction a , tbl_poster p
								WHERE a.auction_id= ".$row['auction_details'][$k]['auction_id'].
								" AND a.fk_poster_id = p.poster_id 
								  AND p.fk_user_id = u.user_id ";
				$resSellerSql=mysqli_query($GLOBALS['db_connect'],$seller_sql);
				$fetchSellerSql= mysqli_fetch_array($resSellerSql);
				$row['auction_details'][$k]['seller_username']= $fetchSellerSql['username'];
			}
	  }
	  if($chk_item_type==1 || $chk_item_type==4){
		$this->array_sort_by_column($row['auction_details'],"seller_username");
	  }	
		$invoice = $row;
        if($EmailType=='Seller'){
            $email_template = 'Your Seller Reconciliation has been generated. To view this please login to your account and select <b>Invoices/Reconciliation</b>, located in <b>User Section</b>, under <b>My Account</b>.<br/>';
        }elseif($EmailType=='buyer_notify'){
            $email_template = 'Your invoice has been updated. To view this please login to your account and select <b>Invoices/Reconciliation</b>, located in <b>User Section</b>, under <b>My Account</b>.<br/>';
        }elseif($EmailType=='invoice'){
            $email_template = 'Your paid invoice is below. To view this please login to your account and select <b>Invoices/Reconciliation</b>, located in <b>User Section</b>, under <b>My Account</b>.<br/>';
        }elseif($EmailType=='phone_order'){
			$email_template = 'Thank you for your order. Please contact MPE at 336.402.4123 to make payment arrangements.  You may view status of invoice by logging into your account and selecting <b>Invoices/Reconciliations</b> located in <b>User Section</b> under <b>My Account</b>.<br/><br/>';
        }elseif($EmailType=='phone_order_approve'){
			$email_template = 'We have received your payment. Thanks again for your order and we will send a tracking number as soon as your purchase is shipped.';
        }else{
			$email_template = 'Your Invoice is ready. Please login to your account and go to <b>User Section</b>. Under <b>My Account</b>, select <b>Invoices/Reconciliation </b> and follow prompts. Please note that if you have multiple outstanding invoices you can combine by clicking checkbox for each invoice and selecting <b>Combine Invoices</b> button. <br /><br />';
		}
		//echo "<pre>";print_r($row['email']);
		
		$email_template .=  '<table align="center" width="60%" border="0" style="border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer"  bgcolor="Silver"><b>&nbsp;';
		
		if($EmailType=='buyer_notify'){
            $type="Reissue Invoice Details";
            $dateOfInvoice="Date of Invoice:";
        }elseif($EmailType!='Seller'){
            $type="Invoice Details";
            $dateOfInvoice="Date of Invoice:";
        }else{
            $type="Seller Reconciliation";
            $dateOfInvoice="Date of Buyer Invoice:";
        }
		$email_template .= $type;
		$email_template .= '</b></td>
								</tr>';
		if($EmailType!='Seller'){
			$email_template .=			'<tr height="26">
									<td align="left" colspan="2" class="printer" style="border-bottom:1px solid #cccccc;"><b>Date of Invoice:</b>'.$invoice['invoice_generated_on'].'</td>
								</tr>' ;  
			if($invoice['is_paid']=='1'){
				$email_template .=			'<tr height="26">
									<td align="left" colspan="2" class="printer" style="border-bottom:1px solid #cccccc;"><b>Date Paid: </b>'.date('m/d/Y',strtotime($invoice['paid_on'])).'</td>
								</tr>' ;  
			}
		}else{
			$email_template .=			'<tr height="26">
									<td align="left" colspan="2" class="printer" style="border-bottom:1px solid #cccccc;"><b>Date of Buyer Invoice:</b>'.$invoice['invoice_generated_on'].'</td>
								</tr>' ;  
		} 
		                            
		$email_template .=			'<tr height="26">
									<td align="left">';
									if($EmailType!='Seller'){
									if(is_array($invoice['billing_address'])){
										$email_template .= '<b>Billing Address</b><br />'.
															$invoice['billing_address']['billing_firstname'].'&nbsp;'.$invoice['billing_address']['billing_lastname'].'<br/>'.
															$invoice['billing_address']['billing_address1'];
															if($invoice['billing_address']['billing_address2'] != ''){
																$email_template .= '&nbsp;'.$invoice['billing_address']['billing_address2'];
															}
															$email_template .= '<br />'.$invoice['billing_address']['billing_city'].'&nbsp;'.
																				$invoice['billing_address']['billing_state'].'&nbsp;'.
																				$invoice['billing_address']['billing_zipcode'].'<br />';
									}else{
										$email_template .= '&nbsp;';
									}
									}else{
										
										if(is_array($invoice['billing_address'])){
											$email_template .= '<b>Seller Address</b><br />'.
																$invoice['billing_address']['billing_firstname'].'&nbsp;'.$invoice['billing_address']['billing_lastname'].'<br/>'.
																$invoice['billing_address']['billing_address1'];
																if($invoice['billing_address']['billing_address2'] != ''){
																	$email_template .= '&nbsp;'.$invoice['billing_address']['billing_address2'];
																}
																$email_template .= '<br />'.$invoice['billing_address']['billing_city'].'&nbsp;'.
																					$invoice['billing_address']['billing_state'].'&nbsp;'.
																					$invoice['billing_address']['billing_zipcode'].'<br />';
										}else{
											$email_template .= '&nbsp;';
										}
									
									}
				$email_template .= '</td>
									<td align="left">';
									if(is_array($invoice['shipping_address'])){
										$email_template .= '<b>Shipping Address</b><br />'.
															$invoice['shipping_address']['shipping_firstname'].'&nbsp;'.$invoice['shipping_address']['shipping_lastname'].'<br/>'.
															$invoice['shipping_address']['shipping_address1'];
															if($invoice['shipping_address']['shipping_address2'] != ''){
																$email_template .= '&nbsp;'.$invoice['shipping_address']['shipping_address2'];
															}
															$email_template .= '<br />'.$invoice['shipping_address']['shipping_city'].'&nbsp;'.																				
																				$invoice['shipping_address']['shipping_state'].'&nbsp;'.
																				$invoice['shipping_address']['shipping_zipcode'].'<br />';
									}else{
										$email_template .= '&nbsp;';
									}
				$email_template .= '</td>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
								<tr>
									<td align="left" colspan="2">
										<table border="0" width="100%" align="left" cellpadding="2" cellspacing="0" style="border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
											<tr bgcolor="#c4c4c4" class="printer">
												<td align="left" width="25%" style="border:1px solid #CCCCCC;"><b>Sl No</b></td>
												<td align="left" width="50$" style="border:1px solid #CCCCCC;"><b>Title</b></td>
												<td align="left" width="25%" style="border:1px solid #CCCCCC;"><b>Price</b></td>
											</tr>
											<tr><td colspan="3">&nbsp;</td></tr>';
											$seller_username='';
											if(is_array($invoice['auction_details'])){
												foreach($invoice['auction_details'] as $key => $value){
												if($chk_item_type=='1'){
													if ($seller_username !=$value['seller_username']){
														if ($seller_username!=''){
															$email_template .='<tr>
                                                								<td align="right" colspan="2" style="border-top:1px solid #CCCCCC;">Shiiping Charge:</td>';
															if($invoice['shipping_address']['shipping_country_name']=='Canada' || $invoice['shipping_address']['shipping_country_name']=='United States'){
																				
                                                			$email_template .='<td align="left" style="border-top:1px solid #CCCCCC;">$15</td>
																				
                                            	</tr>';
												  }else{
												  			$email_template .='<td align="left" style="border-top:1px solid #CCCCCC;">$21</td>
																				
                                            	</tr>';
												  }
														}
														$email_template .='<tr>
																		   <td colspan="3" style="border-top:1px solid #CCCCCC;">Seller : '.$value['seller_username'].'</td>
																		   </tr>';
													}
												}
													$k=1;
													$email_template .= '<tr>
																			<td align="left" style="border-top:1px solid #CCCCCC;">'.$k.'</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">'.$value['poster_title'].'</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">$'.number_format($value['amount'], 2).'</td>
																		</tr>';
													$subTotal += $value['amount'];
													$k++;
													if($chk_item_type=='1' || $chk_item_type=='4'){
														$seller_username=$value['seller_username'];
													}
												}
												if($chk_item_type=='1' || $chk_item_type=='4'){
													$email_template .='<tr>
                                                					   <td align="right" colspan="2" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">Shiiping Charge:</td>';
                                                					   
													if($invoice['shipping_address']['shipping_country_name']=='Canada' || $invoice['shipping_address']['shipping_country_name']=='United States'){
																				
                                                			$email_template .='<td align="left" style="border-top:1px solid #CCCCCC;">$15</td>
																				
                                            	</tr>';
												  }else{
												  			$email_template .='<td align="left" style="border-top:1px solid #CCCCCC;">$21</td>
																				
                                            	</tr>';
												  }
												}
											}
											$email_template .= '<tr>
																	<td align="right" colspan="2" style="border-top:1px solid #CCCCCC;">Subtotal</td>
																	<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;" >$'.number_format($subTotal, 2).'.</td>
																</tr>';
											if(is_array($invoice['additional_charges'])){
												
												foreach($invoice['additional_charges'] as $key => $value){
													$email_template .= '<tr>
																			<td align="right" colspan="2" style="border-top:1px solid #CCCCCC;">(+)&nbsp;'.$value['description'].'</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">$'.number_format($value['amount'], 2).'</td>
																		</tr>';
													//$subTotal += $value['amount'];
													
												}
											}

											if(is_array($invoice['discounts'])){
												foreach($invoice['discounts'] as $key => $value){
													$email_template .= '<tr>
																			<td align="right" colspan="2" style="border-top:1px solid #CCCCCC;">(-)&nbsp;'.$value['description'].'</td>
																			<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;">$'.number_format($value['amount'], 2).'</td>
																		</tr>';
													//$subTotal -= $value['amount'];
												}
											}
						$email_template .= '<tr>
												<td align="right" colspan="2" style="border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;">Total</td>
												<td align="left" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;">$'.number_format($invoice['total_amount'], 2).'</td>
											</tr>
										</table>
									</td>
								</tr>    
							</table>';
		
		/* Invoice to the user */
		$toMail = $invoice['email'];
		$toName = $invoice['firstname']." ".$invoice['lastname'];
        if($EmailType!='Seller'){
            $subject = "Movie Poster Invoice";
        }else{
            $subject = "Movie Poster Seller Reconciliation";
        }
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		
		$textContent = $email_template;
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
		
		/* Invoice to the MPE Admin */
		$toMail = ADMIN_EMAIL_ADDRESS;
		$toNameAdmin = ADMIN_NAME;
		
		if($EmailType=='phone_order' ){
			$subject = "Movie Poster Exchange: Phone Order Invoice from ".$toName;
		}elseif($EmailType=='phone_order_approve'){
			$subject = "Movie Poster Exchange: You have marked as Paid invoice of ".$toName;
		}else{
			$subject = "Movie Poster Invoice";
		}
		$fromMail = ADMIN_EMAIL_ADDRESS;
		$fromName = ADMIN_NAME;
		
		$textContent = $email_template;
		$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
		$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
		$check = sendMail($toMail, $toNameAdmin, $subject, $textContent, $fromMail, $fromName, $html=1);
		
		  
		
			/* Invoice to the Sean */
			$toMailSean = SEAN_EMAIL;
			$toNameSean = "Sean Linkenback";
			$subject = "Movie Poster Invoice";
			$fromMail = ADMIN_EMAIL_ADDRESS;
			$fromName = ADMIN_NAME;
			
			$textContent = $email_template;
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			if(isset($toMailSean) && $toMailSean!=''){
				$check = sendMail($toMailSean, $toNameSean, $subject, $textContent, $fromMail, $fromName, $html=1);
			}
			
			/* Invoice to the Peter */
			$toMailPeter = PETER_EMAIL;  
			$toNamePeter = "Peter Contarino";
			$subject = "Movie Poster Invoice";
			$fromMail = ADMIN_EMAIL_ADDRESS;
			$fromName = ADMIN_NAME;
			
			$textContent = $email_template;
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			if(isset($toMailPeter) && $toMailPeter!=''){
				$check = sendMail($toMailPeter, $toNamePeter, $subject, $textContent, $fromMail, $fromName, $html=1);
			}
			
			
		
		
		if($EmailType!='Seller'){  
		
			/* Invoice to the Sean */
			$toMailSean = SEAN_EMAIL;
			$toNameSean = "Sean Linkenback";
			$subject = "Movie Poster Invoice";
			$fromMail = ADMIN_EMAIL_ADDRESS;
			$fromName = ADMIN_NAME;
			
			$textContent = $email_template;
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			if(isset($toMailSean) && $toMailSean!=''){
				$check = sendMail($toMailSean, $toNameSean, $subject, $textContent, $fromMail, $fromName, $html=1);
			}
			
			/* Invoice to the Peter */
			$toMailPeter = PETER_EMAIL;  
			$toNamePeter = "Peter Contarino";
			$subject = "Movie Poster Invoice";
			$fromMail = ADMIN_EMAIL_ADDRESS;
			$fromName = ADMIN_NAME;
			
			$textContent = $email_template;
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;	
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			if(isset($toMailPeter) && $toMailPeter!=''){
				$check = sendMail($toMailPeter, $toNamePeter, $subject, $textContent, $fromMail, $fromName, $html=1);
			}
			
			
		}
	}
	
	function auctionWinnerForReport($auction_id){
		$sql="Select u.firstname as winnerFname,u.lastname as winnerLname 
			  from user_table u,tbl_invoice ti,tbl_invoice_to_auction tia 
			  where tia.fk_auction_id=$auction_id and tia.fk_invoice_id=ti.invoice_id and ti.fk_user_id=u.user_id and ti.is_buyers_copy='1'";
		$res_sql=mysqli_query($GLOBALS['db_connect'], $sql);
		$res=mysqli_fetch_array($res_sql);
		$tot_row=mysqli_num_rows($res_sql);
		if($tot_row >0){
			return $winnerName=$res['winnerFname'].' '.$res['winnerLname'];
		}else{
			return $winnerName='';
		}
	}
	function auctionWinnerForDetail($auction_id){
		$sql="Select u.firstname as winnerFname,u.lastname as winnerLname,ti.total_amount
			  from user_table u,tbl_invoice ti,tbl_invoice_to_auction tia 
			  where tia.fk_auction_id=$auction_id and tia.fk_invoice_id=ti.invoice_id and ti.fk_user_id=u.user_id and ti.is_buyers_copy='1'";
		$res_sql=mysqli_query($GLOBALS['db_connect'], $sql);
		$res=mysqli_fetch_array($res_sql);
		$tot_row=mysqli_num_rows($res_sql);
		if($tot_row >0){
			return $res;
		}
	}
	function generate_buy_now_invoice($auction_ids,$cart){
        $amount='';
        $expiredate = date('Y-m-d');
		$session_id = base64_encode($_SESSION['sessUserID']).session_id();
        $expiredate= $expiredate." 24:00:00";
        $sql ="SELECT u.user_id, u.firstname, u.lastname, u.country_id, u.city, u.state,
				   u.address1, u.address2, u.zipcode, c.country_name, c.country_code,
				   u.shipping_country_id, u.shipping_city, u.shipping_state, u.shipping_address1,
				   u.shipping_address2, u.shipping_zipcode, c.country_name AS shipping_country_name,
				   c.country_code AS shipping_country_code, p.poster_id, p.poster_sku, p.poster_title, p.fk_user_id,
				   a.auction_asked_price,a.auction_id
				   FROM ".USER_TABLE." u,".COUNTRY_TABLE." c, ".TBL_POSTER." p, ".TBL_AUCTION." a
				   WHERE a.auction_id = $auction_ids and u.user_id='".$_SESSION['sessUserID']."'
				   AND u.country_id = c.country_id AND a.fk_poster_id = p.poster_id";


        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_array($rs);


        $billing_address = serialize(array('billing_firstname' => $row['firstname'],
            'billing_lastname' => $row['lastname'],
            'billing_country_id' => $row['country_id'],
            'billing_country_name' => $row['country_name'],
            'billing_country_code' => $row['country_code'],
            'billing_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['city']),
            'billing_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['state']),
            'billing_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address1']),
            'billing_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['address2']),
            'billing_zipcode' => $row['zipcode']));
        $shipping_address = serialize(array('shipping_firstname' => $row['firstname'],
            'shipping_lastname' => $row['lastname'],
            'shipping_country_id' => $row['shipping_country_id'],
            'shipping_country_name' => $row['shipping_country_name'],
            'shipping_country_code' => $row['shipping_country_code'],
            'shipping_city' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_city']),
            'shipping_state' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_state']),
            'shipping_address1' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address1']),
            'shipping_address2' => mysqli_real_escape_string($GLOBALS['db_connect'],$row['shipping_address2']),
            'shipping_zipcode' => $row['shipping_zipcode']));


        foreach($cart as $key => $value){
		 if($value['fk_auction_type_id']==6){
            $auctionsArr[] = array('auction_id'=>$value['auction_id'], 'poster_sku' => $value['poster_sku'], 
			'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$value['poster_title']).' ( $'.$value['auction_asked_price'].' * '.$value['quantity'].')', 'amount' => $value['amount']);
            $amount += $value['amount'];
			}else{
			$auctionsArr[] = array('auction_id'=>$value['auction_id'], 'poster_sku' => $value['poster_sku'], 
			'poster_title' => mysqli_real_escape_string($GLOBALS['db_connect'],$value['poster_title']), 'amount' => $value['amount']);
            $amount += $value['amount'];
			}
        }
        $auction_details = serialize($auctionsArr);
        $data = array('fk_user_id' => $row['user_id'], 'billing_address' => $billing_address, 'shipping_address' => $shipping_address,
            'total_amount' => $amount, 'auction_details' => $auction_details,
            'invoice_generated_on' => date("Y-m-d H:i:s"), 'is_buyers_copy' => 1,'is_approved'=>1,'is_new'=>1);

        /* Invoice for Buyer */
        $invoice_id = $this->updateData(TBL_INVOICE, $data);
        foreach($cart as $key => $value){
            $this->updateData(TBL_INVOICE_TO_AUCTION, array('fk_auction_id' => $value['auction_id'], 'fk_invoice_id' => $invoice_id, 'amount' => $value['amount'],'expiry_date' =>date('Y-m-d H:i:s',strtotime($expiredate)),'session'=>$session_id));
			if($value['fk_auction_type_id']!=6){
            	$this->updateData(TBL_AUCTION, array('auction_is_sold' => 3),array('auction_id'=>$value['auction_id']),true);
			}
           // $this->updateData(TBL_AUCTION, array('auction_is_sold' => 3),array('auction_id'=>$value['auction_id']),true);
        }

    }
	function access_customer_information_master($user_new_id='',$start_date='',$end_date='',$invoice_type=''){
		$sqlInvoice = " Select i.invoice_id,
							   i.invoice_generated_on,
							   i.total_amount,
							   u.firstname,
							   u.lastname,
							   i.is_combined ,
							   i.is_approved,
							   i.is_paid,
							   i.paid_on,
							   i.is_shipped,
							   i.shipped_date,
							   a.auction_actual_end_datetime
                       FROM tbl_invoice i, user_table u ,tbl_invoice_to_auction tia,tbl_auction a 
					      WHERE i.fk_user_id = u.user_id						    
							AND i.is_buyers_copy = '1'
							AND tia.fk_invoice_id = i.invoice_id
							AND tia.fk_auction_id = a.auction_id
							AND a.fk_auction_week_id <> 43
							AND is_cancelled <> '1'
							 ";
		
		if($user_new_id!=''){
			$sqlInvoice .= " AND i.fk_user_id = '".$user_new_id."'";
		}
		if($start_date!='' && $end_date!=''){
			$start_date = $start_date.' 00:00:00';
			$end_date = $end_date.' 24:00:00';
			$sqlInvoice .= " AND i.invoice_generated_on >= '".$start_date."' AND i.invoice_generated_on <= '".$end_date."'";
		}
		if($invoice_type!=''){
		  if($invoice_type=='paid'){
		     $sqlInvoice .= " AND i.is_paid = '1' ";
		  }elseif($invoice_type=='unpaid'){
		     $sqlInvoice .= " AND i.is_paid = '0' ";
		  }elseif($invoice_type=='shipped'){
		     $sqlInvoice .= " AND i.is_paid = '1'  AND i.is_shipped='1' ";
		  }elseif($invoice_type=='notshipped'){
		     $sqlInvoice .= " AND i.is_paid = '1'  AND i.is_shipped='0' ";
		  }
		}
		if($invoice_type=='paid'){
			$sqlInvoice .= "	GROUP BY i.invoice_id
							ORDER BY i.paid_on DESC ";
		}else{
			$sqlInvoice .= "	GROUP BY i.invoice_id
							ORDER BY i.invoice_generated_on DESC ";
		}
		//echo $sqlInvoice;
		if($res_sqlInvoice=mysqli_query($GLOBALS['db_connect'],$sqlInvoice)){
		//$count = mysqli_num_rows($res_sqlInvoice);
		$i=0;
		   while($row = mysqli_fetch_assoc($res_sqlInvoice)){		       
			   $dataArr[] = $row;
			   $dataArr[$i]['inv_no']= str_pad($row['invoice_id'], 4, "0", STR_PAD_LEFT);  
			   //$count--;
			   $i++;
		   }
		   /*echo "<pre>";
		   print_r($dataArr);
		   echo "</pre>";*/
		   return $dataArr;
		
		}
		return false;
	}
	function fetchInvoiceAuctionDetails($invoice_id, $user_id = '')
	{
		 $sql = "SELECT inv.invoice_id,inv.auction_details,inv.additional_charges,inv.discounts,inv.total_amount,inv.is_paid,inv.is_shipped,inv.note  FROM ".TBL_INVOICE." inv
				WHERE inv.invoice_id = '".$invoice_id."'
				AND inv.is_buyers_copy='1'";
		if($user_id != ''){
			$sql .= " AND inv.fk_user_id = '".$user_id."'";
		}

		if($rs = mysqli_query($GLOBALS['db_connect'], $sql)){
		   return mysqli_fetch_assoc($rs);
		}
		return false;
	}
	function fetchInvoiceAuctionDetailsAlternative($invoice_id, $user_id = '')
	{
		 $sql = "SELECT inv.*  FROM ".TBL_INVOICE." inv
				WHERE inv.invoice_id = '".$invoice_id."'
				AND inv.is_buyers_copy='1'";
		if($user_id != ''){
			$sql .= " AND inv.fk_user_id = '".$user_id."'";
		}

		if($rs = mysqli_query($GLOBALS['db_connect'], $sql)){
		   return mysqli_fetch_assoc($rs);
		}
		return false;
	}
	function chk_item_type($invoice_id){
	$sql ="Select a.fk_auction_type_id from tbl_auction a , tbl_invoice_to_auction tia,tbl_invoice i
				Where tia.fk_invoice_id=".$invoice_id." 
				and tia.fk_auction_id = a.auction_id
				and i.invoice_id = tia.fk_invoice_id
				and i.is_new='1' ";
	$resSql=mysqli_query($GLOBALS['db_connect'], $sql);
	$fetchSql= mysqli_fetch_array($resSql);
	return $fetchSql['fk_auction_type_id'];
}
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
}
?>

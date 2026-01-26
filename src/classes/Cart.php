<?php

class Cart extends DBCommon{
	
	public function __construct(){		
		parent::__construct();
	}
	
	function addToCart($id, $user_id)
	{
		$addToCart = false;
		if(count($_SESSION['cart']) == 0 && $id != ''){
			$addToCart = true;
		}elseif(count($_SESSION['cart']) > 0 && $id != ''){
			$counter = 0;		
			foreach($_SESSION['cart'] as $key => $value){
				if($value['auction_id'] == $id){
					$counter = 1;
					break;
				}
			}
			
			if($counter == 0){
				$addToCart = true;
			}
		}
		
		if($addToCart){

            $sql_insert = "Insert into ".TBL_CART_HISTORY." (fk_user_id,fk_auction_id,is_paid) values ($user_id,$id,'0')";
			$res_sql_insert=mysqli_query($GLOBALS['db_connect'],$sql_insert);
			
			
                        
            $sql = "SELECT a.fk_auction_type_id, a.auction_asked_price,a.auction_buynow_price, a.auction_is_sold,
			a.auction_actual_end_datetime, a.auction_actual_start_datetime,	p.poster_title, p.poster_sku, p.flat_rolled,p.quantity
			FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
			WHERE a.auction_id = '".$id."'";
			$auctionRs = mysqli_query($GLOBALS['db_connect'],$sql);
			$auctionRow = mysqli_fetch_assoc($auctionRs);
			
			if($auctionRow['quantity']<=1 && $auctionRow['fk_auction_type_id']=='6'){
				$sql_update = "Update ".TBL_AUCTION." SET in_cart = '1' WHERE auction_id = '".$id."' ";
				$res_sql_insert=mysqli_query($GLOBALS['db_connect'],$sql_update);
			}
			
			if($auctionRow['fk_auction_type_id']=='1' || $auctionRow['fk_auction_type_id']=='4'){
				$sql_update = "Update ".TBL_AUCTION." SET in_cart = '1' WHERE auction_id = '".$id."' ";
				$res_sql_insert=mysqli_query($GLOBALS['db_connect'],$sql_update);
			}

//			if($auctionRow['flat_rolled']=='flat'){
//				$weight=PRODUCT_WEIGHT_FLAT;
//			}elseif($auctionRow['flat_rolled']=='rolled'){
//				$weight=PRODUCT_WEIGHT_ROLL;
//			}
			
			if(($auctionRow['fk_auction_type_id'] == 1 || $auctionRow['fk_auction_type_id']=='4' || $auctionRow['fk_auction_type_id'] == 6) && $auctionRow['auction_is_sold'] == 0){
			  if($auctionRow['fk_auction_type_id'] ==6 && $auctionRow['quantity'] >0){
				$_SESSION['cart'][] = array("auction_id" => $id, "poster_title" => $auctionRow['poster_title'],"fk_auction_type_id"=>$auctionRow['fk_auction_type_id'],
											"poster_sku" => $auctionRow['poster_sku'], "amount" => $auctionRow['auction_asked_price'],"quantity" =>"1","auction_asked_price"=>$auctionRow['auction_asked_price']
											);
						}elseif($auctionRow['fk_auction_type_id']==1 || $auctionRow['fk_auction_type_id']=='4'){
						$_SESSION['cart'][] = array("auction_id" => $id, "poster_title" => $auctionRow['poster_title'],"fk_auction_type_id"=>$auctionRow['fk_auction_type_id'],
											"poster_sku" => $auctionRow['poster_sku'], "amount" => $auctionRow['auction_asked_price'],"quantity" =>"1","auction_asked_price"=>$auctionRow['auction_asked_price']
											);
						} 					
			}elseif($auctionRow['fk_auction_type_id'] == 2 && $auctionRow['auction_is_sold'] == 0 &&
						($auctionRow['auction_actual_start_datetime'] <= date("Y-m-d H:i:s") && $auctionRow['auction_actual_end_datetime'] >= date("Y-m-d H:i:s"))){
				$_SESSION['cart'][] = array("auction_id" => $id, "poster_title" => $auctionRow['poster_title'],
											"poster_sku" => $auctionRow['poster_sku'], "amount" => $auctionRow['auction_buynow_price']
											);
			}
		}else{
			$GLOBALS['errorMessage'] = "This item is already added to your cart";
		}
	
		
	}
	function chkAuctionStatus(&$dataArr){
		if(!empty($dataArr)){
			$i=0;
			$ind=0;
			foreach($dataArr as $key=>$val){
				$sql="SELECT a.auction_payment_is_done, a.fk_auction_type_id, a.auction_asked_price, a.auction_buynow_price,
					  p.poster_title, p.poster_sku,a.auction_is_sold
					  FROM ".TBL_AUCTION." a LEFT JOIN ".TBL_POSTER." p ON a.fk_poster_id = p.poster_id
					  WHERE a.auction_id =".$dataArr[$i]['auction_id'];
				$resSql=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql));
				if($resSql['auction_is_sold'] != '0'){
					if($resSql['fk_auction_type_id'] == 1){
						$_SESSION['sold_item'][] = array("auction_id" => $dataArr[$i]['auction_id'], "poster_title" => $resSql['poster_title'],
													"poster_sku" => $resSql['poster_sku'], "amount" => $resSql['auction_asked_price']);
					}elseif($resSql['fk_auction_type_id'] == 2){
						$_SESSION['sold_item'][] = array("auction_id" => $dataArr[$i]['auction_id'], "poster_title" => $resSql['poster_title'],
													"poster_sku" => $resSql['poster_sku'], "amount" => $resSql['auction_buynow_price']);
					}
					
					unset($_SESSION['cart'][$i]);
					$ind=1;
					
					$cart = array();
					foreach($_SESSION['cart'] as $key => $value){
						$cart[] = $value;
					}
					$_SESSION['cart'] = $cart;
				}
				$i++;
			}
			if($ind==0){
				return true;
			}elseif($ind==1){
				return false;
			}
		}else{
			return false;
		}
	}
}
?>
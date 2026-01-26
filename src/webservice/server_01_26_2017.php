<?php
require_once("libs/nusoap.php");
require_once("libs/connect.php");
require_once("libs/functions.php");

$server = new soap_server;

$server->configureWSDL('server', $ns);

// register a web service method
								###############  Verifying Username and Password Starts ################

$server->register('user_validation',
	array('str1' => 'xsd:string','str2' => 'xsd:string'), 	// input parameters
	array('user_status' => 'xsd:string'), 							// output parameter
	$ns, 														// namespace
    "$ns#user_validation",		                						// soapaction
    'rpc',                              						// style
    'encoded',                          						// use
    'It takes the Username and Password as a input and reurns whether user is valid or not.'           	// documentation
	);

function user_validation($str1, $str2){
return new soapval('return','xsd:string',add($str1, $str2));
}
function add($str1, $str2) {
	$sql="Select count(user_id) as counter from user_table where username='".$str1."' and password = '".md5($str2)."'";
		$row=mysqli_query($GLOBALS['db_connect'],$sql);
		$count_res=mysqli_fetch_array($row);
		$count=$count_res['counter'];
	if($count > 0){
		return "success";
	}else{
		return "failed";
	}
}
									###############  Verifying Username and Password Ends  ################
									
									###############  Auction Details Function Starts ################
$server->wsdl->addComplexType(
    'details',
    'complexType',
    'struct',
    'all',
    '',
    array(
     'auction_id'=>array('name'=>'auction_id','type'=>'xsd:int'),
	 'auction_type'=>array('name'=>'auction_type','type'=>'xsd:string'),
	 'poster_title'=>array('name'=>'poster_title','type'=>'xsd:string'),
     'event_title'=>array('name'=>'event_title','type'=>'xsd:string'),
	 'highest_amnt'=>array('name'=>'highest_amnt','type'=>'xsd:string'),
	 'total_bid_offer'=>array('name'=>'total_bid_offer','type'=>'xsd:int'),
	 'highest_user'=>array('name'=>'highest_user','type'=>'xsd:string'),
     'next_bid'=>array('name'=>'next_bid','type'=>'xsd:string'),
	 'buy_now_price'=>array('name'=>'buy_now_price','type'=>'xsd:string'),
	 'auction_reserve_offer_price'=>array('name'=>'auction_reserve_offer_price','type'=>'xsd:string'),
	 'auction_start_price'=>array('name'=>'auction_start_price','type'=>'xsd:string'),
	 'auction_start_time'=>array('name'=>'auction_start_time','type'=>'xsd:string'),
	 'auction_end_time'=>array('name'=>'auction_end_time','type'=>'xsd:string'),
	 'poster_size'=>array('name'=>'poster_size','type'=>'xsd:string'),
	 'genre'=>array('name'=>'genre','type'=>'xsd:string'),
	 'decade'=>array('name'=>'decade','type'=>'xsd:string'),
	 'country'=>array('name'=>'country','type'=>'xsd:string'),
	 'condition'=>array('name'=>'condition','type'=>'xsd:string'))
    );

$server->register('get_auction_details',
    array('id'=>'xsd:int'),
    array('return'=>'tns:details'),
    'urn:RM',
    'urn:RM#get_auction_details',
    'rpc',
    'encoded',
    'It takes the Auction Id as a input and returns the Auction data.');

function get_auction_details($id){
 	$query="SELECT a.fk_auction_type_id,
				   a.auction_asked_price, 
				   a.auction_reserve_offer_price,
				   a.fk_event_id ,a.fk_auction_week_id ,
				   a.is_offer_price_percentage, 
				   a.auction_buynow_price,
				   a.auction_actual_start_datetime,
				   a.auction_is_sold,
				   a.auction_is_approved,
				   a.auction_actual_end_datetime,
				   e.event_title,
				   aw.auction_week_title,
				   a.is_approved_for_monthly_auction,
				   p.poster_id,
				   p.poster_title, 
				   p.poster_desc
				   FROM tbl_auction_live a LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
				   LEFT JOIN tbl_event e ON a.fk_event_id = e.event_id
				   LEFT JOIN tbl_auction_week aw ON a.fk_auction_week_id = aw.auction_week_id
				   WHERE a.auction_id= ".$id ;
 $rs=mysqli_query($GLOBALS['db_connect'],$query);

 $game=array();
 while($row=mysqli_fetch_assoc($rs)){
  $game[]= $row;
 }
  if($game[0]['fk_auction_type_id']=='1'){
  		if($game[0]['auction_reserve_offer_price'] > 0 && $game[0]['is_offer_price_percentage'] == 1)
		   $game[0]['auction_reserve_offer_price']=($game[0]['auction_asked_price'] * $game[0]['auction_reserve_offer_price'])/100;
		else
		   $game[0]['auction_reserve_offer_price']=$game[0]['auction_reserve_offer_price'];
  		$total_offer=" SELECT COUNT(o.offer_id) AS no_of_offer 
							  from tbl_auction a LEFT JOIN tbl_offer o ON a.auction_id = o.offer_fk_auction_id
							  WHERE a.auction_id= '".$id."' and  o.offer_parent_id = '0'";
		$rs_total_offer=mysqli_query($GLOBALS['db_connect'],$total_offer);
		while($row_tot_offer=mysqli_fetch_assoc($rs_total_offer)){
			$game[0]['no_of_bid']= $row_tot_offer['no_of_offer'];
		}					  
  	  	$select="SELECT u.firstname,
						u.lastname,
						u.username,
						MAX(offer_amount) AS highest_offer 
						from user_table u,tbl_auction a LEFT JOIN tbl_offer o ON a.auction_id = o.offer_fk_auction_id 
						WHERE a.auction_id= '".$id."' 
							  and o.offer_fk_user_id=u.user_id 
							  and o.offer_amount =
								( SELECT MAX(offer.offer_amount) FROM tbl_offer offer WHERE  offer.offer_fk_auction_id='".$id."' group by offer.offer_fk_auction_id) " ;
		$rs=mysqli_query($GLOBALS['db_connect'],$select);
		while($row=mysqli_fetch_assoc($rs)){
		$game[0]['highest_bid']= $row['highest_offer'];
		$game[0]['username']= $row['username'];
		$game[0]['buy_now_price']=$game[0]['auction_asked_price'];
		$game[0]['auction_type']= "Fixed Auction";
		$game[0]['auction_start_price']= 0.00;
		$game[0]['next_bid']= "Not Applicable";
 		}			
  	$array = array("highest_offer"=>$row['highest_offer'], "username"=>$row['firstname'].''.$row['lastname'],"auction_type"=>'Fixed Auction');
  }else{
  		if($game[0]['fk_auction_type_id']=='2'){
			$game[0]['auction_type']= "Weekly";
			$game[0]['event_title']=$game[0]['auction_week_title'];
			$game[0]['buy_now_price']=$game[0]['auction_buynow_price'];
		}elseif($game[0]['fk_auction_type_id']=='3'){
			$game[0]['auction_type']= "Monthly";
		}else{
			$game[0]['auction_type']= "Auction does not exists.";
		}
			$game[0]['auction_start_price']=$game[0]['auction_asked_price'];
  		$total_bid=" SELECT COUNT(b.bid_id) AS no_of_bid
							  from tbl_auction_live a LEFT JOIN tbl_bid b ON a.auction_id = b.bid_fk_auction_id
							  WHERE a.auction_id= '".$id."'";
		$rs_total_bid=mysqli_query($GLOBALS['db_connect'],$total_bid);
		while($row_tot_bid=mysqli_fetch_assoc($rs_total_bid)){
			$game[0]['no_of_bid']= $row_tot_bid['no_of_bid'];
		}
		
  	  	$select="SELECT u.firstname,
						u.lastname,
						u.username,
						max(b.bid_amount) AS highest_bid 
						from user_table u,tbl_auction_live a LEFT JOIN tbl_bid b ON a.auction_id = b.bid_fk_auction_id 
						WHERE a.auction_id= '".$id."'
							  and b.bid_fk_user_id=u.user_id 
							  and b.bid_amount =
								( SELECT MAX(bid.bid_amount) FROM tbl_bid bid WHERE  bid.bid_fk_auction_id='".$id."' group by bid.bid_fk_auction_id) " ;
		$rs=mysqli_query($GLOBALS['db_connect'],$select);
		while($row=mysqli_fetch_assoc($rs)){
		$game[0]['highest_bid']= $row['highest_bid'];
		$game[0]['username']= $row['username'];
		
 		}			
  }
  ###############  Select  categories ################
  
  $selectCatVal=" SELECT c.cat_value, 
						 c.fk_cat_type_id
		 					FROM tbl_poster_to_category_live ptc, tbl_category c
							WHERE ptc.fk_cat_id = c.cat_id
								  AND ptc.fk_poster_id = '".$game[0]['poster_id']."'
								  ORDER BY c.fk_cat_type_id ";
  
  $res_selectCatVal=mysqli_query($GLOBALS['db_connect'],$selectCatVal);
  while($row=mysqli_fetch_assoc($res_selectCatVal)){
        if($row['fk_cat_type_id']=='1'){
			$game[0]['poster_size']= $row['cat_value'];
		}elseif($row['fk_cat_type_id']=='2'){
			$game[0]['genre']= $row['cat_value'];
		}elseif($row['fk_cat_type_id']=='3'){
			$game[0]['decade']= $row['cat_value'];
		}elseif($row['fk_cat_type_id']=='4'){
			$game[0]['country']= $row['cat_value'];
		}elseif($row['fk_cat_type_id']=='5'){
			$game[0]['condition']= $row['cat_value'];
		}
 		}								  
  
  
  if($game[0]['fk_auction_type_id']!='1')
  {
  	if($game[0]['highest_bid']>0){
  	$game[0]['next_bid']=$game[0]['highest_bid'] + increment_amount($game[0]['highest_bid']);
  	}else{
  	$game[0]['next_bid']=$game[0]['auction_asked_price'];	
  	}
	if($game[0]['auction_is_approved']=='0' || ($game[0]['fk_auction_type_id']==3 && $game[0]['is_approved_for_monthly_auction']=='0')){ 
		$game[0]['auction_status']="Pending";
	 }
	elseif($game[0]['auction_is_approved']=='2')
	{
		$game[0]['auction_status']="Disapproved";
		}
	elseif($game[0]['auction_is_approved']=='1' && $game[0]['auction_is_sold']=='0' && $game[0]['auction_actual_start_datetime'] > date("Y-m-d H:i:s"))
	{
		$game[0]['auction_status']="Upcoming";
	}
	elseif($game[0]['auction_is_approved']=='1' && $game[0]['auction_is_sold']=='0' && $game[0]['auction_actual_start_datetime'] < date("Y-m-d H:i:s") &&  $game[0]['auction_actual_end_datetime'] > date("Y-m-d H:i:s"))
	{
		$game[0]['auction_status']="Selling";
	}
	elseif($game[0]['auction_is_approved']=='1' && $game[0]['auction_is_sold']=='0' && $game[0]['auction_actual_start_datetime'] < date("Y-m-d H:i:s") &&  $game[0]['auction_actual_end_datetime'] < date("Y-m-d H:i:s"))
	{
		$game[0]['auction_status']="Expired & Unsold";
	}
	elseif($game[0]['auction_is_sold']=='1')
	{
		$game[0]['auction_status']="Sold";
	}
	elseif($game[0]['auction_is_sold']=='2')
	{
		$game[0]['auction_status']="Sold by Buy Now";
	 }
	}
 if($game[0]['fk_auction_type_id']=='1')
	{
	 if($game[0]['auction_is_sold']=='1')
	 {
		$game[0]['auction_status']="Sold";
		}
	 elseif($game[0]['auction_is_sold']=='2')
	 {
		$game[0]['auction_status']="Sold by Buy Now";
		}
	 elseif($game[0]['auction_is_approved']=='0')
	 {
		$game[0]['auction_status']="Pending";
	  }
	 elseif($game[0]['auction_is_approved']=='2')
	 {
		$game[0]['auction_status']="Disapproved";
		}
	 elseif($game[0]['auction_is_approved']=='1' && $game[0]['auction_is_sold']=='0')
	 {
		$game[0]['auction_status']="Selling";
		}
																					 
	}
 if($game[0]['fk_auction_type_id']==1 || $game[0]['fk_auction_type_id']==2 || $game[0]['fk_auction_type_id']==3)
 { 
	 $userArr = array("auction_id"=>$id,
					  "auction_type"=>$game[0]['auction_type'],
					  "poster_title"=>$game[0]['poster_title'],
					  "event_title"=>$game[0]['event_title'],
					  "highest_amnt"=>$game[0]['highest_bid'],
					  "total_bid_offer"=>$game[0]['no_of_bid'],
					  "highest_user"=>$game[0]['username'],
	 				  "next_bid"=>number_format($game[0]['next_bid'],2,'.',''),
					  "buy_now_price"=>number_format($game[0]['buy_now_price'],2,'.',''),
					  "auction_reserve_offer_price"=>number_format($game[0]['auction_reserve_offer_price'],2,'.',''),
					  "auction_start_price"=>number_format($game[0]['auction_start_price'],2,'.',''),
					  "auction_start_time"=>$game[0]['auction_actual_start_datetime'],
					  "auction_end_time"=>$game[0]['auction_actual_end_datetime'],
					  "poster_size"=>$game[0]['poster_size'],
					  "genre"=>$game[0]['genre'],
					  "decade"=>$game[0]['decade'],
					  "country"=>$game[0]['country'],
					  "condition"=>$game[0]['condition']);
	}else{
		$userArr = array("auction_id"=>$id,
					  "auction_type"=>$game[0]['auction_type']);
	}			  
 return $userArr;
}
										###############  Auction Details Function Ends ################
										
										###############  Closed Auction Details Function Starts ################
$server->wsdl->addComplexType(
    'closed',
    'complexType',
    'struct',
    'all',
    '',
    array(
     'auction_id'=>array('name'=>'auction_id','type'=>'xsd:int'),
	 'auction_type'=>array('name'=>'auction_type','type'=>'xsd:string'),
	 'poster_title'=>array('name'=>'poster_title','type'=>'xsd:string'),
	 'highest_amnt'=>array('name'=>'highest_amnt','type'=>'xsd:string'),
	 'highest_user'=>array('name'=>'highest_user','type'=>'xsd:string'),
	 'auction_start_price'=>array('name'=>'auction_start_price','type'=>'xsd:string'),
	 'auction_start_time'=>array('name'=>'auction_start_time','type'=>'xsd:string'),
	 'auction_end_time'=>array('name'=>'auction_end_time','type'=>'xsd:string'),
	 'total_bid_offer'=>array('name'=>'total_bid_offer','type'=>'xsd:int'))
    );

$server->register('sold_auction_details',
    array('id'=>'xsd:int'),
    array('return'=>'tns:closed'),
    'urn:RM',
    'urn:RM#sold_auction_details',
    'rpc',
    'encoded',
    'It takes the Auction Id as a input and returns the Sold Auction data.');

function sold_auction_details($id){
 	$query="SELECT a.fk_auction_type_id,
				   a.auction_asked_price,
				   a.auction_actual_start_datetime,
				   a.auction_actual_end_datetime,
				   p.poster_title,
				   a.highest_user,
				   a.max_bid_amount,
				   a.bid_count
				   FROM tbl_auction_mapping tam,tbl_auction a LEFT JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
				   WHERE tam.auction_id_old= ".$id." AND a.auction_id = tam.auction_id_new " ;
 $rs=mysqli_query($GLOBALS['db_connect'],$query);

 $game=array();
 while($row=mysqli_fetch_assoc($rs)){
  $game[]= $row;
 }
  
	if($game[0]['fk_auction_type_id']=='2'){
		$game[0]['auction_type']= "Weekly";
		$game[0]['auction_start_price']=$game[0]['auction_asked_price'];
		/*$game[0]['poster_title']=$game[0]['poster_title'];
		$game[0]['highest_amnt']=$game[0]['max_bid_amount'];
		$game[0]['highest_user']=$game[0]['highest_user'];
		$game[0]['auction_start_time']=$game[0]['auction_actual_start_datetime'];
		$game[0]['auction_end_time']=$game[0]['auction_actual_end_datetime'];
		$game[0]['total_bid_offer']=$game[0]['bid_count'];*/
	}else{
		$game[0]['auction_type']= "Auction does not exists.";
	}
		

  
	 $userArr = array("auction_id"=>$id,
					  "auction_type"=>$game[0]['auction_type'],
					  "poster_title"=>$game[0]['poster_title'],
					  "highest_amnt"=>$game[0]['max_bid_amount'],
					  "total_bid_offer"=>$game[0]['bid_count'],
					  "highest_user"=>$game[0]['highest_user'],
					  "auction_start_price"=>number_format($game[0]['auction_start_price'],2,'.',''),
					  "auction_start_time"=>$game[0]['auction_actual_start_datetime'],
					  "auction_end_time"=>$game[0]['auction_actual_end_datetime']
					  );
				  
	return $userArr;
}
										###############  Closed Auction Details Function Ends ################
										
										###############  Bid Posting Process Starts  ################
										
$server->wsdl->addComplexType(
    'postBidStatus',
    'complexType',
    'struct',
    'all',
    '',
    array('post_bid_status'=>array('name'=>'post_bid_status','type'=>'xsd:string'))
    );
$server->register('postBid',
	array('username' => 'xsd:string','password' => 'xsd:string','auction_id'=>'xsd:integer','bid_amount'=>'xsd:integer'),							                                                                // input parameters
	array('return'=>'tns:postBidStatus'), 						// output parameter
	$ns, 														// namespace
    "$ns#postBid",		                						// soapaction
    'rpc',                              						// style
    'encoded',                          						// use
    'It takes the Username,Password,Auction Id(on which user want to bid) and maximum bid amount. And it  returns the status of the bid.'           							// documentation
	);

function postBid($username, $password,$auction_id,$bid_amount) {
    $latest_higest_user='';
    $latest_max_bid='';
    $latest_bid_count=0;
    $instantUpdate=true;
	$sql="Select count(user_id) as counter,user_id from user_table where username='".$username."' and password = '".md5($password)."'";
		$row=mysqli_query($GLOBALS['db_connect'],$sql);
		$count_res=mysqli_fetch_array($row);
		$count=$count_res['counter'];
		$user_id=$count_res['user_id'];
	if($count > 0){
		 $query="SELECT a.fk_auction_type_id,
				   a.auction_asked_price, 
				   a.auction_is_sold,
				   a.auction_is_approved,
				   a.auction_actual_end_datetime,
				   a.bid_count,
				   a.max_bid_amount,
				   a.highest_user,
				   (UNIX_TIMESTAMP(a.auction_actual_end_datetime) - UNIX_TIMESTAMP()) AS seconds_left,
				   p.fk_user_id
				   FROM tbl_auction_live a , tbl_poster_live p 				   
				   WHERE  a.fk_poster_id = p.poster_id
				   AND a.auction_id= ".$auction_id ;
 		$rs=mysqli_query($GLOBALS['db_connect'],$query);
		$row=mysqli_fetch_assoc($rs);
		if(empty($row)){
			return $userArr = array("post_bid_status"=>"Auction does not exists.");
		}
		elseif($row['fk_user_id']!=$user_id){
			
			if($row['auction_is_approved']=='1'){
				if($row['fk_auction_type_id']!='1'){
					
					########  post bid starts #######
						//$next_increment=increment_amount($row['auction_asked_price']);
						/*$select=" SELECT b.bid_fk_user_id,
										max(b.bid_amount) AS highest_bid  
										from tbl_auction a LEFT JOIN tbl_bid b ON a.auction_id = b.bid_fk_auction_id 
										WHERE a.auction_id= '".$auction_id."'
							  				  and b.bid_amount =
											  (SELECT MAX(bid.bid_amount) FROM tbl_bid bid WHERE  bid.bid_fk_auction_id='".$auction_id."' group by bid.bid_fk_auction_id) " ;
						$rs_bid=mysqli_query($GLOBALS['db_connect'],$select);
						$row_highest_bid=mysqli_fetch_assoc($rs_bid);*/
						$highest_bid_amnt=$row['max_bid_amount'];
						$highest_bid_user=$row['highest_user'];
						
						if($highest_bid_amnt > 0){
							$next_increment=increment_amount($highest_bid_amnt);
							$next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
							$curr_bid= ($highest_bid_amnt + $next_increment);
						}else{
							$next_increment=increment_amount($row['auction_asked_price']);
							$curr_bid=0;
						}
						if($curr_bid < $row['auction_asked_price']){
							$curr_bid=0;
						}
						if($curr_bid <= 0 && $bid_amount < $row['auction_asked_price']){
							return $userArr = array("post_bid_status"=>"Bid must be greater or equal to the start amount.");
						}elseif($row['auction_is_sold'] != '0'){
							return $userArr = array("post_bid_status"=>"Bid is closed.");
						}elseif($row['seconds_left'] <= 0){
							return $userArr = array("post_bid_status"=>"Auction is expired.");
						}elseif($curr_bid > 0 && $bid_amount < $curr_bid){
							return $userArr = array("post_bid_status"=>"Bid must be greater than or equal to $".number_format(($curr_bid),2));
						}else{
							
					$proxy_bid_sql="Select count(proxy_id) as conter from tbl_proxy_bid_live where fk_auction_id ='".$auction_id."'";
					$counter_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$proxy_bid_sql));
	
					$counter=$counter_row['0'];	
					########   Bidding Process Starts  ####### 	
					########### added for new proxy bid requirement ########
					#############  Highest  bidder id ##############
					if($bid_amount > $curr_bid && $curr_bid!='0'){
		
		#############  Highest Bid amount from TBL_BID ##############
		if($bid_amount >= $next_highest_bid_amnt){
			if($counter > 0){
				$del_proxy=mysqli_query($GLOBALS['db_connect'],"Update tbl_proxy_bid_live SET is_override='1' where fk_auction_id='".$auction_id."' and fk_user_id='".$user_id."' and is_override='0' ");
				$sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$user_id."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
		 		if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
		 			//echo $_REQUEST['proxy_bid'];
		 		}else{
		 			echo false;
		 		}
			 	#############  Second highest proxy bid amount ##############
				$sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
									 WHERE fk_auction_id='".$auction_id."' AND is_override !='1' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND fk_auction_id='".$auction_id."'))";
				
			 	$sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
			 	$second_highest_val=$sql_second_highest_res['amount'];
			 	$second_highest_user=$sql_second_highest_res['fk_user_id'];
			 	
			 	$new_bid_amount_proxy=($second_highest_val + increment_amount($second_highest_val));
			 	
			 	#############  Highest proxy bidder id ##############
		 	
				$sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE is_override !='1' AND fk_auction_id='".$auction_id."'  and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' group by '".$auction_id."')";
			
				$highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
			 	$highest_user=$highest_user_res['fk_user_id'];
			
				
		
			 	#############  Highest Proxy amount  ##############
		 	
				$sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override !='1' AND fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";		
				 
				$highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
			 	$highest_proxy_amnt=$highest_proxy['proxy_amount'];
			 	
				$tot_high_proxy_bid_sql="Select count(proxy_id) as conter from tbl_proxy_bid_live where is_override !='1' AND fk_auction_id ='".$auction_id."' and amount='".$highest_proxy_amnt."'";
				$tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_proxy_bid_sql));
			
				$counter_tot_high=$tot_counter_row_highest['0'];
		 	
				if($highest_proxy_amnt == $bid_amount && $counter_tot_high > 1){
				
				#### new added if two highest proxy bid  is of same value ######
					
						$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$user_id."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
						$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                        $latest_bid_count= $latest_bid_count+1;
					$bid=1;
					$out_bid_key='outbid';
			 	}
				else{
				
				 	if($highest_bid_amnt <= $second_highest_val)
				 	{
					
					 	
					 	$totBid= countData(tbl_bid,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
					 	if($totBid < 1){
					 		if($highest_proxy_amnt != $bid_amount){
					 			$data = array("bid_fk_user_id" => $user_id, "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount,
								"bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
								$bid = updateData(tbl_bid, $data);
                                 $latest_bid_count= $latest_bid_count+1;
								//$out_bid_key='outbid';
							}else{
					 			$bid_amount_for_new_proxy=($second_highest_val + increment_amount($second_highest_val));
					 			if($bid_amount_for_new_proxy > $highest_proxy_amnt){
					 				$bid_amount_for_new_proxy=$bid_amount;
					 			}
					 			$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
								$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
								$bid=1;
                                $latest_bid_count= $latest_bid_count+1;
                                $latest_higest_user=$highest_user;
                                $latest_max_bid=$bid_amount_for_new_proxy;
								//$out_bid_key='outbid';
							}
					 	}
						
					 	
				 	}elseif($highest_bid_amnt > $second_highest_val){
					
				 		$tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_bid_amnt."'";
						$tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));
			
						$counter_tot_high=$tot_counter_row_highest['0'];
						
						if($counter_tot_high > 1){
				 		$bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
				 		$totBid= countData(tbl_bid,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
				 		if($totBid<1){
			 				$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$user_id."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
							$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                             $latest_bid_count= $latest_bid_count+1;
                             $latest_higest_user=$user_id;
                             $latest_max_bid=$bid_amount_for_winner;
				 		 }
						}elseif($highest_bid_user!=$user_id){
				 		$bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
				 		$totBid=countData(tbl_bid,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
				 		if($totBid<1){
			 				$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$user_id."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
							$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                            $latest_bid_count= $latest_bid_count+1;
				 		 }
							
						}
						$bid=1;
                         $latest_higest_user=$user_id;
                         $latest_max_bid=$bid_amount_for_winner;
				 	}
		 	
			 	 elseif($highest_proxy_amnt==$bid_amount){
			 	 	
			 	 #### new added if  highest proxy bid  is same value  that jst bidded and already few less proxy bid set ######	
			 	 		$bid_amount_for_new_proxy= $curr_bid; 
			 	 		$tot_high_bid_sql_for_proxy="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$bid_amount_for_new_proxy."'";
						$tot_counter_row_highest_for_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_for_proxy));
			
						$counter_tot_high_for_proxy=$tot_counter_row_highest_for_proxy['0'];
						if($counter_tot_high_for_proxy < 1){
							$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
							$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                            $latest_bid_count= $latest_bid_count+1;
						}
			 	 		$bid=1;
                        $latest_higest_user=$highest_user;
                        $latest_max_bid=$bid_amount_for_new_proxy;
			 	}
			 }
		 		
			}else{
				
				if($highest_bid_user!=$user_id){
					$totBid=countData(tbl_bid,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$curr_bid));
					if($totBid<1){
						$data = array("bid_fk_user_id" => $user_id, "bid_fk_auction_id" => $auction_id, "bid_amount" => $curr_bid,
						  "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
						$bid = updateData(tbl_bid, $data);
                        $latest_higest_user=$user_id;
                        $latest_max_bid=$curr_bid;
                        $latest_bid_count= $latest_bid_count+1;
						
						
					}
				}	
				$sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$user_id."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
			 	if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
			 		//echo $_REQUEST['proxy_bid'];
			 		$bid=1;
			 	}else{
			 		echo false;
			 	}
			}
						#### New Add on 26th march 2012 #####
						//$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$_REQUEST['auction_id']."' GROUP BY '".$_REQUEST['auction_id']."'";		
				 
						//$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
			 			//$current_last_bid=$highest_bid['bid_amount'];
				 		if($second_highest_val >= $highest_bid_amnt){
			 	 			$tot_high_bid_sql_new="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$second_highest_val."' and bid_fk_user_id='".$second_highest_user."'";
							$tot_counter_row_highest_new=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_new));
							$tot_counter_row_highest_new_counter=$tot_counter_row_highest_new['0'];
			 	 			if($tot_counter_row_highest_new_counter==0){
								$sql_bid_insert_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$second_highest_user."','".$auction_id."','".$second_highest_val."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
								$sql_bid_insert_res_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new);
                                $latest_bid_count= $latest_bid_count+1;
			 	 			}
							
			 	 		}
		}else{
			$bid='error_for_same_time';
		}		
  }else{
  	
			if($curr_bid==0){
				if($bid_amount > $row['auction_asked_price']){	
		  			$sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".
		$user_id."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
				 		if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
				 			//echo $_REQUEST['proxy_bid'];
				 			$bid=1;
				 		}else{
				 			echo false;
				 		}
				}	
			}	
			if($curr_bid==0){
  			$tot_bid_init_sql="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."'";
			$tot_bid_init_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_init_sql));
			$counter_init_tot=$tot_bid_init_row['0'];
			if($counter_init_tot==0){
		  		$bid_amount_first=$bid_amount;
				if($bid_amount_first > $row['auction_asked_price']){
			  		$bid_amount_first= $row['auction_asked_price'];
			  	}
			  	
			}else{
				if($bid_amount==$row['auction_asked_price']){
				$bid_amount_first=($row['auction_asked_price']);
			}else{
				$sql_second_highest="SELECT amount FROM tbl_proxy_bid_live
								 WHERE is_override !='1' AND fk_auction_id='".$auction_id."' and amount =
								( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."'))";
			
		 		$sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
		 		$second_highest_val=$sql_second_highest_res['amount'];
		 		if($second_highest_val!=''){
		 		if($bid_amount <= $second_highest_val){
		 			$bid_amount_first=$bid_amount;
		 		}elseif($bid_amount > $second_highest_val){
		 			$bid_amount_first=$second_highest_val + increment_amount($second_highest_val);
		 			if($bid_amount_first > $bid_amount){
		 				$bid_amount_first=$bid_amount;
		 			}
		 		}
		 		}else{
		 			$bid='try_later';
		 		}
			}
		}
  	}
    else{
  		$bid_amount_first=$bid_amount;
  		
  				#############  Highest proxy bidder id ##############
		 	
				$sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE is_override !='1' AND fk_auction_id='".$auction_id."' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' group by '".$auction_id."')";
			
				$highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
			 	$highest_user=$highest_user_res['fk_user_id'];
			
				
		
			 	#############  Highest Proxy amount  ##############
		 	
				$sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override !='1' AND fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";		
				 
				$highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
			 	$highest_proxy_amnt=$highest_proxy['proxy_amount'];
			 	
			 	#############  Highest Bid amount from TBL_BID ##############
		 	
				$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";		
		 
				$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
	 			$highest_bid_amnt=$highest_bid['bid_amount'];
  	}
  	if($bid!='try_later'){
  			
  			if(($user_id == $highest_user) && ($curr_bid==intval($highest_proxy_amnt))){
  				$bid=1;
  			}
  			$tot_bid_sql_second="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$second_highest_val."'";
			$tot_counter_row_second=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_sql_second));
				
			$counter_tot_second=$tot_counter_row_second['0'];
			if($counter_tot_second==0 && $second_highest_user!=0){
				$data = array("bid_fk_user_id" => $second_highest_user, "bid_fk_auction_id" => $auction_id, "bid_amount" => $second_highest_val,
						  "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
				$bid =  updateData(tbl_bid, $data);
                $latest_bid_count= $latest_bid_count+1;
			}elseif($highest_proxy_amnt > $highest_bid_amnt && $highest_proxy_amnt <= $curr_bid && $highest_user!=$user_id){
			 	 			
 	 			$tot_high_bid_sql_new="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_proxy_amnt."' and bid_fk_user_id='".$highest_user."'";
 	 			$tot_counter_row_highest_new=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_new));
				$tot_counter_row_highest_new_counter=$tot_counter_row_highest_new['0'];
				
 	 			if($tot_counter_row_highest_new_counter==0){
					$sql_bid_insert_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$highest_proxy_amnt."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
					$sql_bid_insert_res_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new);
                    $latest_bid_count= $latest_bid_count+1;

                    $sql_bid_insert_new_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$user_id."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                    $sql_bid_insert_res_new_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new_new);
                    $latest_bid_count= $latest_bid_count+1;

                      if($bid_amount>$highest_proxy_amnt){
                          $bid=1;
                          $latest_max_bid=$bid_amount;
                          $latest_higest_user=$user_id;
                      }
 	 			}
							
			 	 		
			}
	  			$totBidCount= countData(tbl_bid,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
	  			if($totBidCount==0){
	  				
					
					
			  		$data = array("bid_fk_user_id" => $user_id, "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount_first,
							  "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
					$bid = updateData(tbl_bid, $data);
                      $latest_max_bid=$bid_amount_first;
                      $latest_higest_user=$user_id;
                      $latest_bid_count= $latest_bid_count+1;
	  			}
			
			
			/*elseif($counter_tot_high > 1){
				$sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$_REQUEST['auction_id']."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
				$sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
			}*/
		
  		}
	
  }
  
	
	#######    New proxy bid requirement ends #######
	
	############## added for proxy bid ##############
  	if($bid!='error_for_same_time'){
	$sql_highest_user="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
							 WHERE is_override !='1' AND fk_auction_id='".$auction_id."' and amount =
							( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' group by '".$auction_id."')";
	$highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
	$highest_user=$highest_user_res['fk_user_id'];
	$highest_amnt=$highest_user_res['amount'];
	
	
	if($highest_user!=$user_id){
		if($highest_amnt > $bid_amount){
			$new_bid_amount= $bid_amount + increment_amount($bid_amount);
			if($new_bid_amount >= $highest_amnt){
				$new_bid_amount = $highest_amnt;
			}
			$tot_high_sql="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$new_bid_amount."' and bid_fk_user_id= '".$highest_user."'";
			$tot_counter_high_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_sql));
		
			$counter_tot_highest=$tot_counter_high_row['0'];
			if($counter_tot_highest < 1){
			$data = array("bid_fk_user_id" => $highest_user, "bid_fk_auction_id" => $auction_id, "bid_amount" => $new_bid_amount,"is_proxy"=>1,
				  "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
			$bid = updateData(tbl_bid, $data);
                $latest_bid_count= $latest_bid_count+1;
			}
			$out_bid_key='outbid';
            $latest_higest_user=$highest_user;
            $latest_max_bid=$new_bid_amount;
		}elseif($highest_amnt == $bid_amount){
			$new_bid_amount= $bid_amount;
			$tot_bid_high_sql="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$new_bid_amount."' and bid_fk_user_id= '".$highest_user."'";
			$tot_bid_high_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_high_sql));
		
			$counter_tot_bid_high_row=$tot_bid_high_row['0'];
			if($counter_tot_bid_high_row < 1){
			$data = array("bid_fk_user_id" => $highest_user, "bid_fk_auction_id" => $auction_id, "bid_amount" => $new_bid_amount,"is_proxy"=>1,
				  "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
			$bid = updateData(tbl_bid, $data);
                $latest_bid_count= $latest_bid_count+1;
			}
			$out_bid_key='outbid';
            $latest_higest_user=$highest_user;
            $latest_max_bid=$new_bid_amount;
		}
	  }		
  	}
    if($latest_bid_count > 0 && $latest_max_bid > $highest_bid_amnt){
        $update_sql_latest="Update tbl_auction_live set highest_user ='".$latest_higest_user."',max_bid_amount='".$latest_max_bid."',bid_count=bid_count + '".$latest_bid_count."' where auction_id='".$auction_id."'";
        mysqli_query($GLOBALS['db_connect'],$update_sql_latest);
    }
					############### ends here ############################
					if($out_bid_key=='outbid'){
							$bid='outbid';
						}
					if($bid > 0 && $bid!='outbid'){
						return $userArr = array("post_bid_status"=>"You have successfully bid on this poster.");
					}elseif($bid=='outbid'){
						return $userArr = array("post_bid_status"=>"Your bid is outbid.Please bid again");
					}elseif($bid=='error_for_same_time'){
						$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";		
					 
						$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
				 		$highest_bid_amnt=$highest_bid['bid_amount'];
						$next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
						return $userArr = array("post_bid_status"=>"Please enter bid amount more than next bid amount ".$next_highest_bid_amnt);
					}
							
						}
						
					########  post bid ends #######
				}else{
					
					return $userArr = array("post_bid_status"=>"This fixed poster you cannot bid.");
				}	
				
			}else{
				return $userArr = array("post_bid_status"=>"This is not a approved poster.");
			}
		}else{
			return $userArr = array("post_bid_status"=>"Seller cannot bid on his own poster.");
		}
		//return $userArr = array("post_bid_status"=>$count_res['user_id']);
		
	}else{
		return $userArr = array("post_bid_status"=>"User is  not valid!");
	}
}										
									###############  Bid Posting Process Ends  ################
									
$HTTPRAW_POST_DATA = isset($HTTP_RAW_POST_DATA)? $HTTP_RAW_POST_DATA:"";  
$server->service($HTTP_RAW_POST_DATA);
?>
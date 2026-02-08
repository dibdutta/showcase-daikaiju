<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";

if(!isset($_SESSION['sessUserID'])){
	echo "Please Login!";
	exit;
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="post_bid"){
	$auctionObj= new Auction();
	$lastBid = $auctionObj->getLastBid($_REQUEST['auction_id']);
	$checkError = validatePostBid($lastBid);
	if(!is_array($checkError)){
		$bid_id = postBid($lastBid);
		if($bid_id > 0 && $bid_id!='outbid' && $bid_id!='error_for_same_time'){
			echo "You have successfully bid on this item.";
		}elseif($bid_id=='outbid'){
			echo "You have been outbid. Please bid again.";
		}elseif($bid_id=='error_for_same_time'){
			$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$_REQUEST['auction_id']."' GROUP BY '".$_REQUEST['auction_id']."'";		
		 
			$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
	 		$highest_bid_amnt=$highest_bid['bid_amount'];
			$next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
			echo "Please enter bid amount more than next bid amount $".$next_highest_bid_amnt;
		}elseif($bid_id=='proxy'){
            echo "You are already the highest bidder.This bid is stored as proxy bid.";
        }else{
			echo "Please try again.";
		}
	}else{
		foreach($checkError as $value){
			$errors .= "$value\n";
		}
		echo $errors;
		//unset($_SESSION['Err']);
	}
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="post_offer"){
$auctionObj= new Auction();
	$lastOffer = $auctionObj->getLastOffer($_REQUEST['auction_id']);
	
	$checkError = validatePostOffer($lastOffer);
	if(!is_array($checkError)){
		if($offer_id = postOffer($lastOffer)){
			/***************  send email section for both end seller and buyer  ************************/
			$sql = "SELECT usr.username, usr.firstname, usr.lastname, usr.email, p.poster_title, p.poster_sku, ofr.offer_amount
            FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." p
            WHERE ofr.offer_fk_user_id = usr.user_id
            AND ofr.offer_fk_auction_id = a.auction_id
            AND a.fk_poster_id = p.poster_id
            AND ofr.offer_id = '".$offer_id."'";
			$rs = mysqli_query($GLOBALS['db_connect'],$sql);
			$row = mysqli_fetch_array($rs);
	
	
			$sqlForSeller ="SELECT usr.firstname, usr.lastname, usr.email
							FROM ".USER_TABLE." usr, ".TBL_OFFER." ofr, ".TBL_AUCTION." a, ".TBL_POSTER." AS p
							WHERE ofr.offer_fk_auction_id = a.auction_id
							AND a.fk_poster_id = p.poster_id
							AND p.fk_user_id = usr.user_id
							AND ofr.offer_id =  '".$offer_id."'";
			$rsSeller = mysqli_query($GLOBALS['db_connect'],$sqlForSeller);
			$rowSeller = mysqli_fetch_array($rsSeller);
			
			$toMail = $row['email'];
			$toName = $row['firstname'].' '.$row['lastname'];
			$toMailSeller = $rowSeller['email'];
			$toNameSeller = $rowSeller['firstname'].' '.$rowSeller['lastname'];
			$fromMail = ADMIN_EMAIL_ADDRESS;
			$fromName = ADMIN_NAME;
			
			$subject = "MPE::Offer Made - ".$row['poster_title']." ";
			
			$textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
			$textContent .= '<b>Item Title : </b>'.$row['poster_title'].'<br /><br />';
			$textContent .= 'Your offer of $'.$row['offer_amount'].' has been submitted. The seller has 72 hours to respond.<br />';
			$textContent .= 'You may view this and any other submitted offers by logging in and choosing <b>Outgoing Offers</b> located in <b>User Section</b> under <b>My Buying/My Outgoing Offers</b>.<br /><br />';
			$textContent .= 'Please contact us at <a href="mailto:info@movieposterexchange.com">info@movieposterexchange.com</a> if you have any questions.<br /><br />';    
			$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
			$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
			//echo $textContent;
			//die;
			$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
						
			$textContentSeller = 'Dear '.$rowSeller['firstname'].' '.$rowSeller['lastname'].',<br /><br />';
			$textContentSeller .= '<b>Item Title : </b>'.$row['poster_title'].'<br />';     	 	
			//$textContentSeller .= $row['firstname'].' has been made an offer of $'.$row['offer_amount'].'<br /><br />';
			$textContentSeller .= 'An offer of $'.$row['offer_amount'].' has been made on your item.You have 72 hours to respond. <br /><br />';
			$textContentSeller .= 'For more details, please <a href="http://'.HOST_NAME.'">login</a> and go to your User Panel(place mouse over Welcome for dropdown panel) and view under My Selling/My incoming offers.<br /><br />';    
    		$textContentSeller .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
    		$textContentSeller = MAIL_BODY_TOP.$textContentSeller.MAIL_BODY_BOTTOM;
			
			$checkSeller = sendMail($toMailSeller, $toNameSeller, $subject, $textContentSeller, $fromMail, $fromName, $html=1);
			
			/***************  End email section ************************/
			echo "Thank you for submitting your offer. Offer is valid for 72 hours.\nYou will receive a response within that time period.";
		}else{
			echo "Server error. Please try again.";
		}
	}else{
		foreach($checkError as $value){
			$errors .= "$value\n";
		}
		echo $errors;
		//unset($_SESSION['Err']);
	}
}elseif(isset($_REQUEST['mode']) && $_REQUEST['mode']=="post_buynow"){
	postBuynow();
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=="place_all_bids"){
	processAllBids();
}

/* Validate Bid starts here */

function validatePostBid($lastBid)
{
	extract($_REQUEST);
	$errCounter = 0;
	if($bid_amount == ""){
		$errCounter++;
		$errorArr['bid_amount'] = "Please enter bid amount.";
	}elseif(check_int($bid_amount)==0){
		$errCounter++;
		$errorArr['bid_amount'] = "Please enter integer value.";
	}elseif($lastBid['fk_user_id'] == $_SESSION['sessUserID']){
		$errCounter++;
		$errorArr['own_poster'] = "Seller cannot bid on his own item.";
	}elseif($bid_amount < $lastBid['auction_asked_price']){
		$errCounter++;
		$errorArr['bid_amount'] = "Bid must be greater or equal to the start amount.";
	}
	//elseif($lastBid['bid_amount'] != "" && $bid_amount < ($lastBid['bid_amount'])){
//		$errCounter++;
//		//$errorArr['bid_amount'] = "Bid must be greater than current and highest bid.";
//		$errorArr['bid_amount'] = "Bid must be greater than or equal to $".number_format(($lastBid['bid_amount']+10), 2);
//	}
	elseif($lastBid['seconds_left'] <= 0){
		$errCounter++;
		$errorArr['auction_actual_end_datetime'] = "Auction is expired.";
	}elseif($lastBid['auction_is_sold'] != '0'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Bid is closed.";
	}elseif(is_numeric($_REQUEST['curr_bid'] ?? '') && $_REQUEST['curr_bid'] > 0 && $bid_amount < $_REQUEST['curr_bid']){
		$errCounter++;
		$errorArr['bid_amount'] = "Bidd must be greater than or equal to $".number_format((float)$_REQUEST['curr_bid'], 2);
	}

	if($errCounter > 0){
		return $errorArr;
	}else{
		return true;
	}
}

/* Post Bid starts here 
 $lastbid is the array of particular auction details for which user is bidding.
*/

function postBid($lastBid)
{

    $latest_higest_user='';
    $latest_max_bid='';
    $latest_bid_count=0;
    $instantUpdate=true;
	$second_highest_val='';
	$second_highest_user='';
	$highest_proxy_amnt='';
	$highest_bid_amnt='';
	$highest_user='';
	$out_bid_key='';
    extract($_REQUEST);
    $bid=false;
    $auctionObj= new Auction();
    mysqli_query($GLOBALS['db_connect'],"SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['db_connect'],'START TRANSACTION');

    $highest_bid_user= $lastBid['highest_user'];

    $proxy_bid_sql="Select count(1) as conter from tbl_proxy_bid_live where fk_auction_id ='".$auction_id."'";
    $counter_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$proxy_bid_sql));

    $counter=$counter_row['0'];
    /* $bid_amount is the bid amount provided by the buyer
       $curr_bid is the next minimum bid	
	*/
    if($bid_amount > $curr_bid){
        #############  Highest Bid amount from TBL_BID ##############

        //$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$_REQUEST['auction_id']."' GROUP BY '".$_REQUEST['auction_id']."'";

        //$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
        $highest_bid_amnt=$lastBid['max_bid_amount'];
        $next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
        if($bid_amount >= $next_highest_bid_amnt){
            $bidObj=new Bid();
            if($counter > 0){
                $del_proxy=mysqli_query($GLOBALS['db_connect'],"Update tbl_proxy_bid_live SET is_override='1' where fk_auction_id='".$auction_id."' and fk_user_id='".$_SESSION['sessUserID']."' and is_override='0' ");
                $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
                if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
                    //echo $_REQUEST['proxy_bid'];
                }else{
                    echo false;
                }
                #############  Second highest proxy bid amount ##############
                $sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
									 WHERE fk_auction_id='".$auction_id."' AND is_override !='1' AND amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND fk_auction_id='".$auction_id."'))";

                $sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
                $second_highest_val=$sql_second_highest_res['amount'];
                $second_highest_user=$sql_second_highest_res['fk_user_id'];
                //$next_increment=$_REQUEST['next_increment'];

                $new_bid_amount_proxy=($second_highest_val + increment_amount($second_highest_val));

                #############  Highest proxy bidder id ##############

                $sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE is_override!='1' AND fk_auction_id='".$auction_id."'  and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE  is_override !='1' AND fk_auction_id='".$auction_id."' group by '".$auction_id."')";

                $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
                $highest_user=$highest_user_res['fk_user_id'];



                #############  Highest Proxy amount  ##############

                $sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override!='1' AND fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

                $highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
                $highest_proxy_amnt=$highest_proxy['proxy_amount'];

                $tot_high_proxy_bid_sql="Select count(proxy_id) as conter from tbl_proxy_bid_live where is_override!='1' AND fk_auction_id ='".$auction_id."' and amount='".$highest_proxy_amnt."'";
                $tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_proxy_bid_sql));

                $counter_tot_high=$tot_counter_row_highest['0'];

                if($highest_proxy_amnt == $bid_amount && $counter_tot_high > 1){

                    #### new added if two highest proxy bid  is of same value ######

                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);

                    $bid=1;
                    $out_bid_key='outbid';
                    $latest_bid_count= $latest_bid_count+1;
                }
                else{

                    if($highest_bid_amnt <= $second_highest_val)
                    {


                        $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
                        if($totBid < 1){
                            if($highest_proxy_amnt != $bid_amount){
                                $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount,
                                    "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                                $bid = $auctionObj->updateData(TBL_BID, $data);
                                $latest_bid_count= $latest_bid_count+1;
                                //$out_bid_key='outbid';
                            }else{
                                $bid_amount_for_new_proxy=($second_highest_val + increment_amount($second_highest_val));
                                if($bid_amount_for_new_proxy > $highest_proxy_amnt){
                                    $bid_amount_for_new_proxy=$bid_amount;
                                }
                                if($highest_bid_user!=$_SESSION['sessUserID']){
                                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                    $latest_bid_count= $latest_bid_count+1;
                                }
                                $bid=1;
                                $latest_higest_user=$highest_user;
                                $latest_max_bid=$bid_amount_for_new_proxy;

                            }
                        }
						if($lastBid['highest_user'] != $highest_user){
							$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$lastBid['highest_user']."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction items, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
						}
                    }elseif($highest_bid_amnt > $second_highest_val){

                        $tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_bid_amnt."'";
                        $tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));

                        $counter_tot_high=$tot_counter_row_highest['0'];

                        if($counter_tot_high > 1){
                            $bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
                            $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
                            if($totBid<1){
                                if($highest_bid_user!=$_SESSION['sessUserID']){
                                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                    $latest_bid_count= $latest_bid_count+1;
                                }
                                $latest_higest_user=$_SESSION['sessUserID'];
                                $latest_max_bid=$bid_amount_for_winner;

                            }
                        }elseif($highest_bid_user!=$_SESSION['sessUserID']){
                            $bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
                            $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
                            if($totBid<1){
                                $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                $latest_bid_count= $latest_bid_count+1;
                            }
							
							$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$lastBid['highest_user']."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction items, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

                        }
                        $bid=1;
                        $latest_higest_user=$_SESSION['sessUserID'];
                        $latest_max_bid=$bid_amount_for_winner;
                    }

                    elseif($highest_proxy_amnt==$bid_amount){
                        #### new added if  highest proxy bid  is same value  that jst bidded and already few less proxy bid set ######
                        $bid_amount_for_new_proxy= $curr_bid;
                        $tot_high_bid_sql_for_proxy="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$bid_amount_for_new_proxy."'";
                        $tot_counter_row_highest_for_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_for_proxy));

                        $counter_tot_high_for_proxy=$tot_counter_row_highest_for_proxy['0'];
                        if($counter_tot_high_for_proxy < 1){
                            if($highest_bid_user!=$_SESSION['sessUserID']){
                                $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                $latest_bid_count= $latest_bid_count+1;
                            }
                        }
                        $bid=1;
                        $latest_higest_user=$highest_user;
                    }
                }

            }else{

                if($highest_bid_user!=$_SESSION['sessUserID']){
                    $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$curr_bid));
                    if($totBid<1){
                        $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $curr_bid,
                            "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                        $bid = $auctionObj->updateData(TBL_BID, $data);
                        $latest_higest_user=$_SESSION['sessUserID'];
                        $latest_max_bid=$curr_bid;
                        $latest_bid_count= $latest_bid_count+1;
						
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_bid_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);

                    }

                }
                $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
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
            if($second_highest_val > $highest_bid_amnt){
                $tot_high_bid_sql_new="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$second_highest_val."' and bid_fk_user_id='".$second_highest_user."'";
                $tot_counter_row_highest_new=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_new));
                $tot_counter_row_highest_new_counter=$tot_counter_row_highest_new['0'];
                if($tot_counter_row_highest_new_counter==0){
                    $sql_bid_insert_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$second_highest_user."','".$auction_id."','".$second_highest_val."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                    $sql_bid_insert_res_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new);
                    $latest_bid_count= $latest_bid_count+1;

                    /*$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,".TBL_AUCTION." a,".TBL_POSTER." p
							        WHERE usr.user_id='".$second_highest_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
                    $rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
                    $rowOutbid = mysqli_fetch_array($rsOutbid);

                    $toMail = $rowOutbid['email'];
                    $toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
                    $fromMail = ADMIN_EMAIL_ADDRESS;
                    $fromName = ADMIN_NAME;

                    $subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";

                    $textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
                    $textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
                    $textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
                    $textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
                    $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
                    $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
                    //echo $textContent;
                    //die;
                    $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);*/
                }

            }
        }else{
            $bid='error_for_same_time';
        }
    }
    /* Starting of the else section
	*/
    else{
        if($highest_bid_user!=$_SESSION['sessUserID']){
            if($curr_bid=='NaN'){
                if($bid_amount > $lastBid['auction_asked_price']){
                    $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
                    if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
                        //echo $_REQUEST['proxy_bid'];
                        $bid=1;
                    }else{
                        echo false;
                    }
                }
            }
            if($curr_bid=='NaN'){

                $tot_bid_init_sql="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."'";
                $tot_bid_init_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_init_sql));
                $counter_init_tot=$tot_bid_init_row['0'];
                if($counter_init_tot==0){
                    $bid_amount_first=$bid_amount;
                    if($bid_amount_first > $lastBid['auction_asked_price']){
                        $bid_amount_first= $lastBid['auction_asked_price'];
                    }
                }else{
                    if($bid_amount==$lastBid['auction_asked_price']){
                        $bid_amount_first=($lastBid['auction_asked_price']);
                    }else{
                        $sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
								 WHERE is_override!='1' AND fk_auction_id='".$auction_id."' and amount =
								( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE  is_override !='1' AND fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override !='1' AND  fk_auction_id='".$auction_id."'))";

                        $sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
                        $second_highest_val=$sql_second_highest_res['amount'];
                        $second_highest_user=$sql_second_highest_res['fk_user_id'];



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
                            $bid_amount_first=$bid_amount;
                        }
                    }
                }
            }else{
                $bid_amount_first=$bid_amount;

                #############  Highest proxy bidder id ##############

                $sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE is_override!='1' AND fk_auction_id='".$auction_id."' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE  is_override !='1' AND fk_auction_id='".$auction_id."' group by '".$auction_id."')";

                $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
                $highest_user=$highest_user_res['fk_user_id'];



                #############  Highest Proxy amount  ##############

                $sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override!='1' AND fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

                $highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
                $highest_proxy_amnt=$highest_proxy['proxy_amount'];

                #############  Highest Bid amount from TBL_BID ##############

                $sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

                $highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
                $highest_bid_amnt=$highest_bid['bid_amount'];
				

            }

            if($bid!='try_later'){

                if(($_SESSION['sessUserID'] == $highest_user) && ($curr_bid==intval($highest_proxy_amnt))){
                    $bid=1;
                }
                $tot_bid_sql_second="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$second_highest_val."'";
                $tot_counter_row_second=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_sql_second));

                $counter_tot_second=$tot_counter_row_second['0'];
                if($counter_tot_second==0 && !empty($second_highest_user) && $second_highest_user > 0 && !empty($second_highest_val) && $second_highest_val > 0){
                    $data = array("bid_fk_user_id" => $second_highest_user, "bid_fk_auction_id" => $auction_id, "bid_amount" => $second_highest_val,
                        "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_bid_count= $latest_bid_count+1;

                }elseif($highest_proxy_amnt > $highest_bid_amnt && $highest_proxy_amnt <= $curr_bid && $highest_user!=$_SESSION['sessUserID']){

                    $tot_high_bid_sql_new="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_proxy_amnt."' and bid_fk_user_id='".$highest_user."'";
                    $tot_counter_row_highest_new=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_new));
                    $tot_counter_row_highest_new_counter=$tot_counter_row_highest_new['0'];

                    if($tot_counter_row_highest_new_counter==0){
                        $sql_bid_insert_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$highest_proxy_amnt."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                        $sql_bid_insert_res_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new);
                        $latest_bid_count= $latest_bid_count+1;

                        $sql_bid_insert_new_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                        $sql_bid_insert_res_new_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new_new);
                        $latest_bid_count= $latest_bid_count+1;

                        if($bid_amount>$highest_proxy_amnt){
                            $bid=1;
                            $latest_max_bid=$bid_amount;
                            $latest_higest_user=$_SESSION['sessUserID'];
                        }

                    }


                }
                $bidObj= new Bid();
                $totBidCount=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
                if($totBidCount==0){
				
					if(isset($highest_proxy_amnt) && $highest_proxy_amnt!='' && $highest_proxy_amnt < $bid_amount_first && $highest_proxy_amnt>=$highest_bid_amnt){
					
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
						$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
						$rowOutbid = mysqli_fetch_array($rsOutbid);

						$toMail = $rowOutbid['email'];
						$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
						
						$fromMail = ADMIN_EMAIL_ADDRESS;
						$fromName = ADMIN_NAME;

						//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
						$subject = "Auction outbid notice:You have been outbid";

						$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
						$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
						$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
						$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
						$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
						$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
						$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
					}elseif($highest_bid_amnt > $highest_proxy_amnt){
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_bid_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
						$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
						$rowOutbid = mysqli_fetch_array($rsOutbid);

						$toMail = $rowOutbid['email'];
						$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
						$fromMail = ADMIN_EMAIL_ADDRESS;
						$fromName = ADMIN_NAME;

						//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
						$subject = "Auction outbid notice:You have been outbid";

						$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
						$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
						$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
						$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
						$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
						$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
						$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
					}
                    $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount_first,
                        "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_max_bid=$bid_amount_first;
                    $latest_higest_user=$_SESSION['sessUserID'];
                    $latest_bid_count= $latest_bid_count+1;
                }


            }

        }else{
            $del_proxy=mysqli_query($GLOBALS['db_connect'],"UPDATE tbl_proxy_bid_live SET is_override='1' where fk_auction_id='".$auction_id."' and fk_user_id='".$_SESSION['sessUserID']."' and is_override='0' ");
            $sql_insert_new_proxy="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
            $res_sql_insert_new_proxy= mysqli_query($GLOBALS['db_connect'],$sql_insert_new_proxy);
            $bid='proxy';
        }
    }

    #######    New proxy bid requirement ends #######
    ############## added for proxy bid ##############
    if($bid!='error_for_same_time'){
        $sql_highest_user="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
							 WHERE is_override!='1' AND fk_auction_id='".$auction_id."' and amount =
							( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override!='1' AND  fk_auction_id='".$auction_id."' group by '".$auction_id."')";
        $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
        $highest_user=$highest_user_res['fk_user_id'];
        $highest_amnt=$highest_user_res['amount'];
        if($highest_user!=$_SESSION['sessUserID']){
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
                    $bid = $auctionObj->updateData(TBL_BID, $data);
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
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_bid_count= $latest_bid_count+1;
                }
                $out_bid_key='outbid';
                $latest_higest_user=$highest_user;
                $latest_max_bid=$new_bid_amount;
            }
        }
    }
    if($latest_bid_count > 0 && $latest_max_bid > $lastBid['max_bid_amount']){
        $update_sql_latest="Update tbl_auction_live set highest_user ='".$latest_higest_user."',max_bid_amount='".$latest_max_bid."',bid_count=bid_count + '".$latest_bid_count."' where auction_id='".$auction_id."'";
        mysqli_query($GLOBALS['db_connect'],$update_sql_latest);
    }
    ############### ends here ############################
    if($bid != false){
        $auction_incr_time_span = '00'.':'.AUCTION_INCR_BY_MIN.':'.AUCTION_INCR_BY_SEC;

        if($lastBid['seconds_left'] <= AUCTION_INCR_TIME_SPAN){
            $sql = "UPDATE tbl_auction_live SET
						auction_actual_end_datetime = ADDTIME(now(),'".$auction_incr_time_span."')
						WHERE auction_id = '".$auction_id."'";
            $check = mysqli_query($GLOBALS['db_connect'],$sql);
        }
    }
    if($out_bid_key=='outbid'){
        $bid='outbid';
    }
    if ($bid) {
        mysqli_query($GLOBALS['db_connect'],"COMMIT");
    } else {
        mysqli_query($GLOBALS['db_connect'],"ROLLBACK");
    }
    return $bid;

}

/* Post Bid ends here */

/* Post Offer starts here */

function validatePostOffer($lastOffer)
{
	extract($_REQUEST);
	$errCounter = 0;

	if($offer_amount == ""){
		$errCounter++;
		$errorArr['offer_amount'] = "Please enter amount.";
	}elseif(check_int($offer_amount)==0){
		$errCounter++;
		$errorArr['offer_amount'] = "Please enter integer value.";
	}elseif($lastOffer['in_cart'] == '1'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Item is alreday added in Cart.";
	}elseif($lastOffer['fk_user_id'] == $_SESSION['sessUserID']){
		$errCounter++;
		$errorArr['own_poster'] = "Seller cannot offer on his own item.";
	}elseif($lastOffer['auction_reserve_offer_price'] > 0 && $lastOffer['offer_amount'] == ''){
		/*if($lastOffer['is_offer_price_percentage'] == '1'){
			if($offer_amount < round(($lastOffer['auction_asked_price'] * $lastOffer['auction_reserve_offer_price']) / 100)){
				$errCounter++;
				$errorArr['offer_amount'] = "Offer must be greater or equal to the minimum.";
			}
		}else{*/
			if($offer_amount < $lastOffer['auction_reserve_offer_price']){
				$errCounter++;
				$errorArr['offer_amount'] = "Thank you for submitting your offer."."\n"."The amount you submitted is less than the minimum consideration set by seller"."\n"."Please reconsider your best offer and resubmit.";
			}
		//}
	}elseif($offer_amount <= $lastOffer['offer_amount']){
		$errCounter++;
		$errorArr['offer_amount'] = "Offer must be greater than current high offer.";
	}

	if($lastOffer['auction_is_sold'] != '0'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Offer is closed.";
	}	
	
	if($errCounter > 0){
		return $errorArr;
	}else{
		return true;
	}
}

function postOffer($lastOffer)
{
	extract($_REQUEST);
	$auctionObj= new Auction();
	
	if($lastOffer['is_offer_price_percentage'] == '1'){
		if($offer_amount < round(($lastOffer['auction_asked_price'] * $lastOffer['auction_reserve_offer_price']) / 100)){
			$offer_is_accepted = 2;
		}else{
			$offer_is_accepted = 0;
		}
	}else{
		if($offer_amount < $lastOffer['auction_reserve_offer_price']){
			$offer_is_accepted = 2;
		}else{
			$offer_is_accepted = 0;
		}
	}

	$data = array("offer_parent_id" => 0, "offer_fk_user_id" => $_SESSION['sessUserID'], "offer_fk_auction_id" => $auction_id,
				  "offer_amount" => $offer_amount, "offer_is_accepted" => $offer_is_accepted,
				  "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
	$offer = $auctionObj->updateData(TBL_OFFER, $data);
	return $offer;
}

/* Post Offer ends here */

function postBuynow()
{
	echo "Inside postBuynow!";
}

/* Post all bids starts */

function placeAllBids($lastBid, $auction_id, $bid_amount)
{
    $bid_amount=$bid_amount;
	$latest_higest_user='';
    $latest_max_bid='';
    $latest_bid_count=0;
    $instantUpdate=true;
    $bid=false;
    $auctionObj= new Auction();
    mysqli_query($GLOBALS['db_connect'],"SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['db_connect'],'START TRANSACTION');

    ########### added for new proxy bid requirement ########
    #############  Highest  bidder id ##############
    $highest_bid_user= $lastBid['highest_user'];

    $proxy_bid_sql="Select count(1) as conter from tbl_proxy_bid_live where fk_auction_id ='".$auction_id."'";
    $counter_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$proxy_bid_sql));

    $counter=$counter_row['0'];

    //$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

    //$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
    //$highest_bid_amnt=$highest_bid['bid_amount'];
    $highest_bid_amnt=$lastBid['max_bid_amount'];
    if($highest_bid_amnt > 0){
        $next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
        $curr_bid = $next_highest_bid_amnt;
    }else{
        $curr_bid='NaN';
    }

    if($bid_amount > $curr_bid){

        #############  Highest Bid amount from TBL_BID ##############
        if($bid_amount >= $next_highest_bid_amnt){
            $bidObj=new Bid();
            if($counter > 0){
                $del_proxy=mysqli_query($GLOBALS['db_connect'],"Update tbl_proxy_bid_live SET is_override = '1' where fk_auction_id='".$auction_id."' and fk_user_id='".$_SESSION['sessUserID']."' and is_override='0' ");
                $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
                if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
                    //echo $_REQUEST['proxy_bid'];
                }else{
                    echo false;
                }
                #############  Second highest proxy bid amount ##############
                $sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
									 WHERE fk_auction_id='".$auction_id."' AND is_override != '1' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND  fk_auction_id='".$auction_id."'))";

                $sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
                $second_highest_val=$sql_second_highest_res['amount'];
                $second_highest_user=$sql_second_highest_res['fk_user_id'];

                $new_bid_amount_proxy=($second_highest_val + increment_amount($second_highest_val));

                #############  Highest proxy bidder id ##############

                $sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE fk_auction_id='".$auction_id."' AND is_override != '1' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND  fk_auction_id='".$auction_id."' group by '".$auction_id."')";

                $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
                $highest_user=$highest_user_res['fk_user_id'];



                #############  Highest Proxy amount  ##############

                $sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override != '1' AND fk_auction_id= '".$auction_id."'  GROUP BY '".$auction_id."'";

                $highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
                $highest_proxy_amnt=$highest_proxy['proxy_amount'];

                $tot_high_proxy_bid_sql="Select count(proxy_id) as conter from tbl_proxy_bid_live where is_override != '1' AND fk_auction_id ='".$auction_id."' and amount='".$highest_proxy_amnt."'";
                $tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_proxy_bid_sql));

                $counter_tot_high=$tot_counter_row_highest['0'];

                if($highest_proxy_amnt == $bid_amount && $counter_tot_high > 1){

                    #### new added if two highest proxy bid  is of same value ######

                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);

                    $bid=1;
                    $out_bid_key='outbid';
                    $latest_bid_count= $latest_bid_count+1;
                }
                else{

                    if($highest_bid_amnt <= $second_highest_val)
                    {


                        $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
                        if($totBid < 1){
                            if($highest_proxy_amnt != $bid_amount){
                                $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount,
                                    "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                                $bid = $auctionObj->updateData(TBL_BID, $data);
                                $latest_bid_count= $latest_bid_count+1;
                                //$out_bid_key='outbid';
                            }else{
                                $bid_amount_for_new_proxy=($second_highest_val + increment_amount($second_highest_val));
                                if($bid_amount_for_new_proxy > $highest_proxy_amnt){
                                    $bid_amount_for_new_proxy=$bid_amount;
                                }
                                if($highest_bid_user!=$_SESSION['sessUserID']){
                                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                    $latest_bid_count= $latest_bid_count+1;
                                }
                                $bid=1;
                                $latest_higest_user=$highest_user;
                                $latest_max_bid=$bid_amount_for_new_proxy;
                                //$out_bid_key='outbid';
                            }
                        }
						if($lastBid['highest_user'] != $highest_user){
							$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$lastBid['highest_user']."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
						}

                    }elseif($highest_bid_amnt > $second_highest_val){

                        $tot_high_bid_sql="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_bid_amnt."'";
                        $tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql));

                        $counter_tot_high=$tot_counter_row_highest['0'];

                        if($counter_tot_high > 1){
                            $bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
                            $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
                            if($totBid<1){
                                if($highest_bid_user!=$_SESSION['sessUserID']){
                                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                    $latest_bid_count= $latest_bid_count+1;
                                }
                                $latest_higest_user=$_SESSION['sessUserID'];
                                $latest_max_bid=$bid_amount_for_winner;
                            }
                        }elseif($highest_bid_user!=$_SESSION['sessUserID']){
                            $bid_amount_for_winner=$highest_bid_amnt + increment_amount($highest_bid_amnt);
                            $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount_for_winner));
                            if($totBid<1){
                                $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount_for_winner."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                $latest_bid_count= $latest_bid_count+1;
                            }
							$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$lastBid['highest_user']."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
                        }
                        $bid=1;
                        $latest_higest_user=$_SESSION['sessUserID'];
                        $latest_max_bid=$bid_amount_for_winner;
                    }

                    elseif($highest_proxy_amnt==$bid_amount){

                        #### new added if  highest proxy bid  is same value  that jst bidded and already few less proxy bid set ######
                        $bid_amount_for_new_proxy= $curr_bid;
                        $tot_high_bid_sql_for_proxy="Select count(bid_id) as conter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$bid_amount_for_new_proxy."'";
                        $tot_counter_row_highest_for_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_for_proxy));

                        $counter_tot_high_for_proxy=$tot_counter_row_highest_for_proxy['0'];
                        if($counter_tot_high_for_proxy < 1){
                            if($highest_bid_user!=$_SESSION['sessUserID']){
                                $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$bid_amount_for_new_proxy."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                                $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                                $latest_bid_count= $latest_bid_count+1;
                            }
                        }
                        $bid=1;
                        $latest_higest_user=$highest_user;
                        $latest_max_bid=$bid_amount_for_new_proxy;
                    }
                }

            }else{

                if($highest_bid_user!=$_SESSION['sessUserID']){
                    $totBid=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$curr_bid));
                    if($totBid<1){
                        $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $curr_bid,
                            "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                        $bid = $auctionObj->updateData(TBL_BID, $data);
                        $latest_higest_user=$_SESSION['sessUserID'];
                        $latest_max_bid=$curr_bid;
                        $latest_bid_count= $latest_bid_count+1;
						
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_bid_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
							$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
							$rowOutbid = mysqli_fetch_array($rsOutbid);

							$toMail = $rowOutbid['email'];
							$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
							$fromMail = ADMIN_EMAIL_ADDRESS;
							$fromName = ADMIN_NAME;

							//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
							$subject = "Auction outbid notice:You have been outbid";

							$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
							$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
							$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
							$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction posters, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
							$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
							$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;							
							$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
                    }
					
                }
                $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
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
                    /* Added on 29th may to send mail to outbid user */

                    /*$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,".TBL_AUCTION." a,".TBL_POSTER." p
							        WHERE usr.user_id='".$second_highest_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
                    $rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
                    $rowOutbid = mysqli_fetch_array($rsOutbid);

                    $toMail = $rowOutbid['email'];
                    $toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
                    $fromMail = ADMIN_EMAIL_ADDRESS;
                    $fromName = ADMIN_NAME;

                    $subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";

                    $textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
                    $textContent .= '<b>Poster Title : </b>'.$rowOutbid['poster_title'].'<br />';
                    $textContent .= 'Your bid of $'.$second_highest_val.' have been outbid.<br /><br />';
                    $textContent .= 'For more details, please <a href="http://'.HOST_NAME.'/">login</a><br /><br />';
                    $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
                    $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
                    //echo $textContent;
                    //die;
                    $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);*/
                }

            }
        }else{
            $bid='error_for_same_time';
        }
    }
    else{
        if($highest_bid_user!=$_SESSION['sessUserID']){
            if($curr_bid=='NaN'){
                if($bid_amount > $lastBid['auction_asked_price']){
                    $sql_insert="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
                    if(mysqli_query($GLOBALS['db_connect'],$sql_insert)){
                        //echo $_REQUEST['proxy_bid'];
                        $bid=1;
                    }else{
                        echo false;
                    }
                }
            }
            if($curr_bid=='NaN'){

                $tot_bid_init_sql="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."'";
                $tot_bid_init_row=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_init_sql));
                $counter_init_tot=$tot_bid_init_row['0'];
                if($counter_init_tot==0){
                    $bid_amount_first=$bid_amount;
                    if($bid_amount_first > $lastBid['auction_asked_price']){
                        $bid_amount_first= $lastBid['auction_asked_price'];
                    }
                }else{
                    if($bid_amount==$lastBid['auction_asked_price']){
                        $bid_amount_first=($lastBid['auction_asked_price']);
                    }else{
                        $sql_second_highest="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
								 WHERE is_override != '1' AND fk_auction_id='".$auction_id."' and amount =
								( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE  is_override != '1' AND  fk_auction_id='".$auction_id."' and amount<(SELECT max(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND  fk_auction_id='".$auction_id."'))";

                        $sql_second_highest_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_second_highest));
                        $second_highest_val=$sql_second_highest_res['amount'];
                        $second_highest_user=$sql_second_highest_res['fk_user_id'];

                        /*$sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where fk_auction_id= '".$_REQUEST['auction_id']."' GROUP BY '".$_REQUEST['auction_id']."'";

                      $highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
                       $highest_proxy_amnt=$highest_proxy['proxy_amount'];

                      $tot_high_proxy_bid_sql="Select count(proxy_id) as conter from tbl_proxy_bid_live where fk_auction_id ='".$_REQUEST['auction_id']."' and amount='".$highest_proxy_amnt."'";
                      $tot_counter_row_highest=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_proxy_bid_sql));

                      $counter_tot_high=$tot_counter_row_highest['0'];*/

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
                            $bid_amount_first=$bid_amount;
                        }
                    }
                }
            }else{
                $bid_amount_first=$bid_amount;

                #############  Highest proxy bidder id ##############

                $sql_highest_user="SELECT fk_user_id FROM tbl_proxy_bid_live
									 WHERE is_override != '1' AND fk_auction_id='".$auction_id."' and amount =
									( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND   fk_auction_id='".$auction_id."' group by '".$auction_id."')";

                $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
                $highest_user=$highest_user_res['fk_user_id'];



                #############  Highest Proxy amount  ##############

                $sql_highest_proxy="SELECT max(amount) as proxy_amount from `tbl_proxy_bid_live` where is_override != '1' AND fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

                $highest_proxy=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_proxy));
                $highest_proxy_amnt=$highest_proxy['proxy_amount'];

                #############  Highest Bid amount from TBL_BID ##############

                $sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";

                $highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
                $highest_bid_amnt=$highest_bid['bid_amount'];
            }


            if($bid!='try_later'){

                if(($_SESSION['sessUserID'] == $highest_user) && ($curr_bid==intval($highest_proxy_amnt))){
                    $bid=1;
                }
                $tot_bid_sql_second="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$second_highest_val."'";
                $tot_counter_row_second=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_bid_sql_second));

                $counter_tot_second=$tot_counter_row_second['0'];
                if($counter_tot_second==0 && $second_highest_user!=0){
                    $data = array("bid_fk_user_id" => $second_highest_user, "bid_fk_auction_id" => $auction_id, "bid_amount" => $second_highest_val,
                        "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_bid_count= $latest_bid_count+1;
                }elseif($highest_proxy_amnt > $highest_bid_amnt && $highest_proxy_amnt <= $curr_bid && $highest_user!=$_SESSION['sessUserID']){

                    $tot_high_bid_sql_new="Select count(bid_id) as counter from tbl_bid where bid_fk_auction_id ='".$auction_id."' and bid_amount='".$highest_proxy_amnt."' and bid_fk_user_id='".$highest_user."'";
                    $tot_counter_row_highest_new=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$tot_high_bid_sql_new));
                    $tot_counter_row_highest_new_counter=$tot_counter_row_highest_new['0'];

                    if($tot_counter_row_highest_new_counter==0){
                        $sql_bid_insert_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$highest_user."','".$auction_id."','".$highest_proxy_amnt."','1','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                        $sql_bid_insert_res_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new);
                        $latest_bid_count= $latest_bid_count+1;

                        $sql_bid_insert_new_new="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                        $sql_bid_insert_res_new_new=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert_new_new);
                        $latest_bid_count= $latest_bid_count+1;

                        if($bid_amount>$highest_proxy_amnt){
                            $bid=1;
                            $latest_max_bid=$bid_amount;
                            $latest_higest_user=$_SESSION['sessUserID'];
                        }
                    }


                }
                $bidObj= new Bid();
                $totBidCount=$bidObj->countData(TBL_BID,array("bid_fk_auction_id"=>$auction_id,"bid_amount"=>$bid_amount));
                if($totBidCount==0){
					if($highest_proxy_amnt!='' && $highest_proxy_amnt < $bid_amount_first && $highest_proxy_amnt>=$highest_bid_amnt){
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
						$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
						$rowOutbid = mysqli_fetch_array($rsOutbid);

						$toMail = $rowOutbid['email'];
						$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
						
						$fromMail = ADMIN_EMAIL_ADDRESS;
						$fromName = ADMIN_NAME;

						//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
						$subject = "Auction outbid notice:You have been outbid";

						$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
						$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
						$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
						$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction items, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
						$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
						$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
						$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
					}elseif($highest_proxy_amnt!='' && $highest_bid_amnt > $highest_proxy_amnt){
						$sqlForOutbid ="SELECT usr.firstname, usr.lastname, usr.email,p.poster_title
							        FROM ".USER_TABLE." usr,tbl_auction_live a,tbl_poster_live p
							        WHERE usr.user_id='".$highest_bid_user."'
							        and a.auction_id='".$auction_id."'
							        and a.fk_poster_id=p.poster_id ";
						$rsOutbid = mysqli_query($GLOBALS['db_connect'],$sqlForOutbid);
						$rowOutbid = mysqli_fetch_array($rsOutbid);

						$toMail = $rowOutbid['email'];
						$toName = $rowOutbid['firstname'].' '.$rowOutbid['lastname'];
						$fromMail = ADMIN_EMAIL_ADDRESS;
						$fromName = ADMIN_NAME;

						//$subject = "MPE::You have been outbid - ".$rowOutbid['poster_title']." ";
						$subject = "Auction outbid notice:You have been outbid";

						$textContent = 'Dear '.$rowOutbid['firstname'].' '.$rowOutbid['lastname'].',<br /><br />';
						$textContent .= '<b>You have been outbid on the following item : </b>'.$rowOutbid['poster_title'].'<br /><br />';
						$textContent .= 'To view the item or increase your bid, please click the following link:<br /> <a href="http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'">http://'.HOST_NAME.'/buy.php?mode=poster_details&auction_id='.$auction_id.'</a><br /><br />';
						$textContent .= 'Do not let other items you are interested in get away!<br />To view all Auction items, please click the following link:<br/> <a href="http://'.HOST_NAME.'/buy.php?list=weekly">http://'.HOST_NAME.'/buy.php?list=weekly</a><br /><br />';
						$textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;
						$textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM;
						$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
					}
					
                    $data = array("bid_fk_user_id" => $_SESSION['sessUserID'], "bid_fk_auction_id" => $auction_id, "bid_amount" => $bid_amount_first,
                        "bid_is_won" => 0, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_max_bid=$bid_amount_first;
                    $latest_higest_user=$_SESSION['sessUserID'];
                    $latest_bid_count= $latest_bid_count+1;
                }


                /*elseif($counter_tot_high > 1){
                    $sql_bid_insert="Insert into tbl_bid (bid_fk_user_id,bid_fk_auction_id,bid_amount,is_proxy,post_date,post_ip) values ('".$_SESSION['sessUserID']."','".$_REQUEST['auction_id']."','".$bid_amount."','0','".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')";
                    $sql_bid_insert_res=mysqli_query($GLOBALS['db_connect'],$sql_bid_insert);
                }*/
            }
        }else{
            $del_proxy=mysqli_query($GLOBALS['db_connect'],"UPDATE tbl_proxy_bid_live SET is_override = '1'  where fk_auction_id='".$auction_id."' and fk_user_id='".$_SESSION['sessUserID']."' and is_override='0' ");
            $sql_insert_new_proxy="Insert into tbl_proxy_bid_live (fk_user_id,fk_auction_id,amount,proxy_date) values ('".$_SESSION['sessUserID']."','".$auction_id."','".$bid_amount."','".date('Y-m-d H:i:s')."')";
            $res_sql_insert_new_proxy= mysqli_query($GLOBALS['db_connect'],$sql_insert_new_proxy);
            $bid='proxy';
        }


    }

    #######    New proxy bid requirement ends #######
    ############## added for proxy bid ##############
    if($bid!='error_for_same_time'){
        $sql_highest_user="SELECT amount,fk_user_id FROM tbl_proxy_bid_live
							 WHERE  is_override != '1' AND fk_auction_id='".$auction_id."' and amount =
							( SELECT MAX(amount) FROM tbl_proxy_bid_live WHERE is_override != '1' AND   fk_auction_id='".$auction_id."' group by '".$auction_id."')";
        $highest_user_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_user));
        $highest_user=$highest_user_res['fk_user_id'];
        $highest_amnt=$highest_user_res['amount'];
        if($highest_user!=$_SESSION['sessUserID']){
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
                    $bid = $auctionObj->updateData(TBL_BID, $data);
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
                    $bid = $auctionObj->updateData(TBL_BID, $data);
                    $latest_bid_count= $latest_bid_count+1;
                }
                $out_bid_key='outbid';
                $latest_higest_user=$highest_user;
                $latest_max_bid=$new_bid_amount;
            }
        }
    }
    if($latest_bid_count > 0 && $latest_max_bid > $lastBid['max_bid_amount']){
        $update_sql_latest="Update tbl_auction_live set highest_user ='".$latest_higest_user."',max_bid_amount='".$latest_max_bid."',bid_count=bid_count + '".$latest_bid_count."' where auction_id='".$auction_id."'";
        mysqli_query($GLOBALS['db_connect'],$update_sql_latest);
    }
    ############### ends here ############################
    if($bid != false){
        $auction_incr_time_span = '00'.':'.AUCTION_INCR_BY_MIN.':'.AUCTION_INCR_BY_SEC;

        if($lastBid['seconds_left'] <= AUCTION_INCR_TIME_SPAN){
            $sql = "UPDATE tbl_auction_live SET
						auction_actual_end_datetime = ADDTIME(now(),'".$auction_incr_time_span."')
						WHERE auction_id = '".$auction_id."'";
            $check = mysqli_query($GLOBALS['db_connect'],$sql);
        }
    }
    if($out_bid_key=='outbid'){
        $bid='outbid';
    }
    if ($bid) {
        mysqli_query($GLOBALS['db_connect'],"COMMIT");
    } else {
        mysqli_query($GLOBALS['db_connect'],"ROLLBACK");
    }
    return $bid;

}

function validateAllBids($lastBid, $bid_amount)
{
	//print_r($lastBid);
	//die();
    $currbid = $lastBid['max_bid_amount']+ increment_amount($lastBid['max_bid_amount']);
	$errCounter = 0;
	$bid_amount = intval($bid_amount);
	if($bid_amount == ""){
		$errCounter++;
		$errorArr['bid_amount'] = "Please enter bid amount.";
	}elseif(check_int($bid_amount)==0){
		$errCounter++;
		$errorArr['bid_amount'] = "Please enter integer value.";
	}elseif($lastBid['fk_user_id'] == $_SESSION['sessUserID']){
		$errCounter++;
		$errorArr['own_poster'] = "Seller cannot bid on his own item.";
	}elseif($bid_amount < $lastBid['auction_asked_price']){
		$errCounter++;
		$errorArr['bid_amount'] = "Bid must be greater or equal to the minimum amount of $10.";
	}elseif($bid_amount < $currbid){
		$errCounter++;
		$errorArr['bid_amount'] = "Please enter bid amount more than next bid amount $".$currbid." .";
	}

	if($lastBid['auction_actual_end_datetime'] < date("Y-m-d H:i:s")){
		$errCounter++;
		$errorArr['auction_actual_end_datetime'] = "Auction is expired.";
	}

	if($lastBid['auction_is_sold'] != '0'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Bid is closed.";
	}

	if($errCounter > 0){
		return $errorArr;
	}else{
		return true;
	}
}

function placeAllOffers($auction_id, $offer_amount,$lastOffer)
{
	extract($_REQUEST);
	$offer_amount = intval($offer_amount);
	if($offer_amount < $lastOffer['auction_asked_price']){
	$auctionObj= new Auction();
	
	if($lastOffer['is_offer_price_percentage'] == '1'){
		if($offer_amount < round(($lastOffer['auction_asked_price'] * $lastOffer['auction_reserve_offer_price']) / 100)){
			$offer_is_accepted = 2;
		}else{
			$offer_is_accepted = 0;
		}
	}else{
		if($offer_amount < $lastOffer['auction_reserve_offer_price']){
			$offer_is_accepted = 2;
		}else{
			$offer_is_accepted = 0;
		}
	}
	
	$data = array("offer_parent_id" => 0, "offer_fk_user_id" => $_SESSION['sessUserID'], "offer_fk_auction_id" => $auction_id,
				  "offer_amount" => $offer_amount, "offer_is_accepted" => $offer_is_accepted, "post_date" => date("Y-m-d H:i:s"), "post_ip" => $_SERVER['HTTP_HOST']);
	$offer = $auctionObj->updateData(TBL_OFFER, $data);
	return $offer;
	}else{
	 $cartObj = new Cart();
	 $cartObj->addToCart($auction_id, $_SESSION['sessUserID']);	
	 return $offer="cart";
	}
}

function validateAllOffers($lastOffer, $offer_amount)
{
	$errCounter = 0;
	$offer_amount = intval($offer_amount);
	if($offer_amount == ""){
		$errCounter++;
		$errorArr['offer_amount'] = "Please enter Offer amount.";
	}elseif(check_int($offer_amount)==0){
		$errCounter++;
		$errorArr['offer_amount'] = "Please enter integer value.";
	}elseif($lastOffer['in_cart'] == '1'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Item is alreday added in Cart.";
	}elseif($lastOffer['fk_user_id'] == $_SESSION['sessUserID']){
		$errCounter++;
		$errorArr['own_poster'] = "Seller cannot bid on his own item.";
	}elseif($lastOffer['auction_reserve_offer_price'] > 0 && $lastOffer['offer_amount'] == ''){
		/*if($lastOffer['is_offer_price_percentage'] == '1'){
			if($offer_amount < round(($lastOffer['auction_asked_price'] * $lastOffer['auction_reserve_offer_price']) / 100)){
				$errCounter++;
				$errorArr['offer_amount'] = "Offer must be greater or equal to the minimum.";
			}
		}else{*/
			if($offer_amount < $lastOffer['auction_reserve_offer_price']){
				$errCounter++;
				$errorArr['offer_amount'] = "Thank you for submitting your offer."."\n"."The amount you submitted is less than the minimum consideration set by seller"."\n"."Please reconsider your best offer and resubmit.";
			}
		//}
	}elseif($offer_amount <= $lastOffer['offer_amount']){
		$errCounter++;
		$errorArr['offer_amount'] = "Offer must be greater than current high offer.";
	}

	if($lastOffer['auction_is_sold'] != '0'){
		$errCounter++;
		$errorArr['auction_is_sold'] = "Offer is closed.";
	}

	if($errCounter > 0){
		return $errorArr;
	}else{
		return true;
	}
}

function processAllBids()
{
	extract($_REQUEST);
	$auctionObj = new Auction();
	$msg;
	
	$auctionArr = $auctionObj->select_details_auction_by_bid($ids);
	for($i=0;$i<count($auctionArr);$i++){
		$itemArr[$auctionArr[$i]['auction_id']]['poster'] = $auctionArr[$i]['poster_title']." ";
	}

	foreach($_REQUEST as $key => $value){
		list($type, $postfix, $auction_id) = explode('_', $key);

		if($type == 'bid' && $postfix == 'price'){
			$lastBid = $auctionObj->getLastBid($auction_id);
			
			$checkError = validateAllBids($lastBid, $value);
			if(!is_array($checkError)){
				$bid_id = placeAllBids($lastBid, $auction_id, $value);
				if($bid_id > 0 && $bid_id!='cart' ){
					$itemArr[$auction_id]['message'] .= "You have successfully bid on this item.<br>";
				}elseif($bid_id=='cart'){
					$itemArr[$auction_id]['message'] .= "This item is added to your cart.<br>";
				}elseif($bid_id=='outbid'){
					$itemArr[$auction_id]['message'] .= "You have been outbid. Please bid again.<br>";
				}elseif($bid_id=='error_for_same_time'){
					$sql_highest_bid="SELECT max(bid_amount) as bid_amount from `tbl_bid` where bid_fk_auction_id= '".$auction_id."' GROUP BY '".$auction_id."'";		
		 
					$highest_bid=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_highest_bid));
	 				$highest_bid_amnt=$highest_bid['bid_amount'];
					$next_highest_bid_amnt=$highest_bid_amnt + increment_amount($highest_bid_amnt);
					$itemArr[$auction_id]['message'] .= "Please enter bid amount more than next bid amount $".$next_highest_bid_amnt;
				}elseif($bid_id=='proxy'){
            		$itemArr[$auction_id]['message'] .="You are already the highest bidder.This bid is stored as proxy bid.<br>";
        		}else{
					$itemArr[$auction_id]['message'] .= "Please try again.<br>";
				}
			}else{
				foreach($checkError as $errValue){
					$itemArr[$auction_id]['message'] .= "$errValue\n";
				}
			}
			if (!strpos($itemArr[$auction_id]['message'] ,'enter')) {
				echo $itemArr[$auction_id]['poster']." : ".$itemArr[$auction_id]['message'];
			}
			//echo $itemArr[$auction_id]['poster']." : ".$itemArr[$auction_id]['message'];
		}elseif($type == 'offer' && $postfix == 'price'){
			$lastOffer = $auctionObj->getLastOffer($auction_id);
			$checkError = validateAllOffers($lastOffer, $value);
			if(!is_array($checkError)){
				$offer_id = placeAllOffers($auction_id, $value,$lastOffer);
			if($offer_id > 0 && $offer_id!='cart'){
					$itemArr[$auction_id]['message'] .= "Your offer has been submitted.\n";
				}elseif($offer_id=='cart'){
					$itemArr[$auction_id]['message'] .= "This item is added to your cart.\n";
				}else{
				
					$itemArr[$auction_id]['message'] .= "Server error. Please try again.\n";
				}
			}else{
				foreach($checkError as $errValue){
					$itemArr[$auction_id]['message'] .= "$errValue\n";
				}
			}
			echo $itemArr[$auction_id]['poster']." : ".$itemArr[$auction_id]['message'];
		}
	}
}
?>

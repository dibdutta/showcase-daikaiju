<?php
define ("INCLUDE_PATH", "");
require_once INCLUDE_PATH."lib/inc.php";
if($_REQUEST['mode'] == "bid_popup"){
	bid_popup();
}elseif($_REQUEST['mode'] == "offer_popup"){
	offer_popup();
}elseif($_REQUEST['mode'] == "chkPosterSizeCount"){
	chkPosterSizeCount();
}

function bid_popup(){
  $dataArr = array()	;
  $id=$_REQUEST['id'];
   $html='<div id="'.$id.'" >';
  $html.='<ul>' ;
  $sql = "SELECT ut.username, b.bid_amount FROM ".TBL_BID." b,".USER_TABLE." ut
				WHERE b.bid_fk_auction_id ='".$id."' and ut.user_id=b.bid_fk_user_id and b.bid_amount!=0  ORDER BY b.bid_amount,b.is_proxy ASC ";
   if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
            //$html.='<li>&nbsp;<b>User:</b>&nbsp;'.$row['username'].'<b>&nbsp;&nbsp;Amount:</b>&nbsp;$'.$row['bid_amount'].'&nbsp;</li>';
            $dataArr[]=$row;
		   }
	    }
	//print_r(array_reverse($dataArr)); 
	$dataArr = array_reverse($dataArr);  
	foreach($dataArr as $key=>$val){
		$html.='<li>&nbsp;<b>'.$dataArr[$key]['username'].':</b>&nbsp;$'.$dataArr[$key]['bid_amount'].'&nbsp;</li>';
	} 	
	$html.='</ul>' ;
	$html.='</div>' ;	
	echo $html;			
	}
	function offer_popup(){
	$id=$_REQUEST['id'];
    $html='<div id="'.$id.'">';
    $html.='<ul>' ;
	$sql = "SELECT ut.username, ofr.offer_amount,
				cntr_ofr.offer_amount AS cntr_ofr_offer_amount
				FROM ".USER_TABLE." ut,".TBL_OFFER." ofr LEFT JOIN ".TBL_OFFER." cntr_ofr ON ofr.offer_id = cntr_ofr.offer_parent_id
				WHERE ofr.offer_fk_auction_id ='".$id."' AND ut.user_id=ofr.offer_fk_user_id
				AND ofr.offer_parent_id = '0' ORDER BY ofr.post_date DESC ";
	if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
             //$html.='<li>&nbsp;<b>User:</b>&nbsp;'.$row['username'].'<b>&nbsp;&nbsp;Amount:</b>&nbsp;$'.$row['offer_amount'].'&nbsp;</li>';
             $html.='<li>&nbsp;&nbsp;<b>Amount:</b>&nbsp;$'.$row['offer_amount'].'&nbsp;</li>';
		   }
	    }	
	$html.='</ul>' ;
	$html.='</div>' ;	
	echo $html;				
	}
	function chkPosterSizeCount(){
			$id=$_REQUEST['id'];
			$sql="Select cat_value from tbl_category where cat_id='".$id."'";
			$sql_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql));
			$name=$sql_res['cat_value'];
			
			$sql_count="SELECT COUNT(c.cat_id) AS counter,cw.size_type  FROM tbl_category c,tbl_size_weight_cost_master cw WHERE c.cat_value='".$name."' and cw.size_weight_cost_id = c.fk_size_weight_cost_id ";
			$sql_count_res=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'],$sql_count));
			$count=$sql_count_res['counter'];
			$size_type=$sql_count_res['size_type'];
			if($count==1){
				echo $count.'-'.$size_type;
			}else{
				echo $count;
			}
			
		}
	
?>
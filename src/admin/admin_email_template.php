<?php
define ("INCLUDE_PATH", "../");
require_once INCLUDE_PATH."lib/inc.php";
/**************************************************/
if($_REQUEST['mode']=="view_template"){
	view_template();
}
	function curl_get($url){
		$useragent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch,CURLOPT_COOKIE,"language=nl_NL; c[50.57.132.96:8081/admin/admin_email_template.php?mode=view_template][/][language]=nl_NL");
		$data=curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function get_pb_stats(){
		$html = curl_get("50.57.132.96:8081/admin/admin_email_template.php?mode=view_template");
		// Create a new DOM Document
		$xml = new DOMDocument();
	
		// Load the html contents into the DOM
		return @$xml->loadHTML($html);
	
		
		//return $return;
	}
	function view_template(){
		require_once INCLUDE_PATH."lib/adminCommon.php";
		$sqlTemp = "Select * from tbl_email_temp WHERE temp_id=1 ";
		 $ressql= mysqli_query($GLOBALS['db_connect'],$sqlTemp);
		 $rowtemp= mysqli_fetch_array($ressql);
		 
		 $newArr= explode(',',$rowtemp['auction_id']);			
		 $dataArr= array();
			
			foreach($newArr as $key=>$val){
			  if($val!=''){
			  	if($rowtemp['is_auction']==1){
					$sql="Select p.poster_title,tpi.poster_thumb,tpi.is_cloud,c.cat_value
				      FROM tbl_auction_live a,tbl_poster_live p, tbl_poster_images_live tpi,tbl_category c,tbl_poster_to_category_live tpc
					   WHERE a.auction_id= '".$val."'
					   AND a.fk_poster_id=p.poster_id
					   AND tpi.fk_poster_id = a.fk_poster_id
					   AND tpi.is_default='1'
					   AND tpc.fk_poster_id = a.fk_poster_id
					   AND tpc.fk_cat_id = c.cat_id
					   AND c.fk_cat_type_id = 1 ";
				}else{
					$sql="Select p.poster_title,tpi.poster_thumb,tpi.is_cloud,c.cat_value
				      FROM tbl_auction a,tbl_poster p, tbl_poster_images tpi,tbl_category c,tbl_poster_to_category tpc
					   WHERE a.auction_id= '".$val."'
					   AND a.fk_poster_id=p.poster_id
					   AND tpi.fk_poster_id = a.fk_poster_id
					   AND tpi.is_default='1'
					   AND tpc.fk_poster_id = a.fk_poster_id
					   AND tpc.fk_cat_id = c.cat_id
					   AND c.fk_cat_type_id = 1 ";
				}
				 
					   
				$res_sql =	mysqli_query($GLOBALS['db_connect'],$sql);
				$row=mysqli_fetch_array($res_sql);
				$dataArr[$key]['poster_title']=$row['poster_title'];
				$dataArr[$key]['poster_size']=$row['cat_value'];
				if ($row['is_cloud'] !='1'){                
                	$dataArr[$key]['image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$row['poster_thumb'];
            	}else{                
                	$dataArr[$key]['image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$row['poster_thumb'];
            	}
				$dataArr[$key]['poster_thumb']=$row['poster_thumb'];
				$dataArr[$key]['auction_id']=$val;
				
				}
			}
		$smarty->assign('dataArr', $dataArr);
		$smarty->assign('banner_text', $rowtemp['banner_text']);
		$smarty->assign('fixed_text', $rowtemp['fixed_text']);
		$smarty->assign('title', $rowtemp['title']);	
		$smarty->display("admin_email_temp.tpl");		
		
		//$file = file_get_contents('http://www.example.com/', false, $context);
		//$file = file_get_contents('http://50.57.132.96:8081/admin/admin_email_template.php?mode=view_template', false, $context);	
		//echo get_pb_stats();			
		
	}
	
?>
<?php
// implementation of add function
require_once("connect.php");

$sql = "SELECT * FROM config_table ";
$res = mysqli_query($GLOBALS['db_connect'],$sql);
$row = mysqli_fetch_array($res);

define ("ADMIN_NAME", $row['admin_name']);
define ("ADMIN_EMAIL_ADDRESS", $row['admin_email']);
define("CLOUD_STATIC","https://c4808190.ssl.cf2.rackcdn.com/");
require_once __DIR__ . "/../../lib/site_constants.php";
define ("FULL_PATH", SITE_URL);
define ("HOST_NAME", SITE_HOST);
//////////////    administration  information   //////////

//////////////   Mail Body variables   ///////////////////////////////
	
define ('MAIL_BODY_TOP', '<html><head></head><body style="  padding:0px; margin:0px;">
<table align="center" bgcolor="#FFFFFF" width="600px" border="0" cellspacing="0" cellpadding="0"> 

	<tr>
		<td background="'.CLOUD_STATIC.'emailer-bg.png" width="100%" height="10"> 
		</td>
	</tr>
	<tr>
		<td valign="middle" width="100%" style=" padding:10px;border-left:1px solid #dbd9da; border-right:1px solid #dbd9da; background-color:#f5f5f5; border-bottom:1px solid #dbd9da;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">
			<tr>
			<td width="260" valign="top">
			<a href="'.FULL_PATH.'" target="_blank"><img src="'.CLOUD_STATIC.'logo.png" alt="logo" width="142" height="189" border="0"></a>
			</td>
			<td valign="middle" align="right">&nbsp;</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr><td width="100%" valign="top" style="border-left:1px solid #dbd9da; border-right:1px solid #dbd9da; padding: 5px; font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size:14px;"><br />');

define ('MAIL_BODY_BOTTOM', '</td></tr>
<tr>
<td  background="'.CLOUD_STATIC.'footer-bg.png"  width="100%" height="75">
	<table align="center" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td align="right"><p style="padding: 5px; font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size:12px; color: #a2a8ab;" ><span>&copy; 2011 - 2012. Movie Poster Exchange.</span>
			</td>
		</tr>
	</table>
</td>
</tr></table>

</body></html>');




function increment_amount($buy_now){ 
 	if($buy_now < 10){
 		return 1;
 	}elseif(10 <= $buy_now && $buy_now <= 29){
 		return 2;
 	}elseif(30 <= $buy_now && $buy_now <= 49){
 		return 3;
 	}elseif(50 <= $buy_now && $buy_now <= 99){
 		return 5;
 	}elseif(100 <= $buy_now && $buy_now <= 199){
 		return 10;
 	}elseif(200 <= $buy_now && $buy_now <= 299){
 		return 20;
 	}elseif(300 <= $buy_now && $buy_now <= 499){
 		return 25;
 	}elseif(500 <= $buy_now && $buy_now <= 999){
 		return 50;
 	}elseif(1000 <= $buy_now && $buy_now <= 1999){
 		return 100;
 	}elseif(2000 <= $buy_now && $buy_now <= 2999){
 		return 200;
 	}elseif(3000 <= $buy_now && $buy_now <= 4999){
 		return 250;
 	}elseif(5000 <= $buy_now && $buy_now <= 9999){
 		return 500;
 	}elseif(10000 <= $buy_now && $buy_now <= 19999){
 		return 1000;
 	}elseif(20000 <= $buy_now && $buy_now <= 29999){
 		return 2000;
 	}elseif(30000 <= $buy_now && $buy_now <= 49999){
 		return 2500;
 	}elseif(50000 <= $buy_now && $buy_now <= 99999){
 		return 5000;
 	}elseif(100000 <= $buy_now && $buy_now <= 199999){
 		return 10000;
 	}elseif(200000 <= $buy_now && $buy_now <= 299999){
 		return 20000;
 	}elseif(300000 <= $buy_now && $buy_now <= 499999){
 		return 25000;
 	}elseif(500000 <= $buy_now && $buy_now <= 999999){
 		return 50000;
 	}elseif(1000000 <= $buy_now && $buy_now <= 1999999){
 		return 100000;
 	}elseif(2000000 <= $buy_now && $buy_now <= 2999999){
 		return 200000;
 	}elseif(3000000 <= $buy_now && $buy_now <= 4999999){
 		return 250000;
 	}elseif(5000000 <= $buy_now && $buy_now <= 9999999){
 		return 500000;
 	}elseif($buy_now >= 10000000){
 		return 1000000;
 	}
 }
 function countData($table, $where = '1', $exception = '')
	{
		
		   $counter = 0;
		   if(is_array($where)){
				   $counter = 1;
				   foreach($where as $key => $value){                        
						   $whereClause .= "$key = '".$value."'";
						   $counter++;
						   if(count($where) >= $counter){
								   $whereClause .= ' AND ';
						   }
				   }
				   $whereClause = '('.$whereClause.')';
		   }elseif($where != ''){
				   $whereClause = $where;
		   }
		   
		   
		   
		   $select = "SELECT COUNT(1) AS counter FROM $table WHERE $whereClause $exceptionClause";
		 
		   $rs = mysqli_query($GLOBALS['db_connect'],$select) or die(mysqli_error($GLOBALS['db_connect']));
		   $row = mysqli_fetch_array($rs);
		   return $row['counter'];
		 
   }
   function updateData($table, $data, $where = '1', $isUpdate = false)
   {
		   $counter = 1;
		   foreach($data as $key => $value){                        
				   $tableData .= "$key = '$value'";
				   $counter++;
				   if(count($data) >= $counter){
						   $tableData .= ',';
				   }
		   }
		   
		   if(!$isUpdate){
				$sql = "INSERT INTO $table SET $tableData";
				if(mysqli_query($GLOBALS['db_connect'],$sql)){
					return mysqli_insert_id($GLOBALS['db_connect']);
				}else{
					return false;   
				}
		   }else{   
				if(is_array($where)){
					$counter = 1;
					foreach($where as $key => $value){                        
						$whereClause .= "$key = '".$value."'";
						$counter++;
						if(count($where) >= $counter){
							$whereClause .= ' AND ';
						}
					}
				}else{
					$whereClause = $where;
				}
				
				$sql = "UPDATE $table SET $tableData WHERE $whereClause";
				return mysqli_query($GLOBALS['db_connect'],$sql);
		   }
   }
 
?>
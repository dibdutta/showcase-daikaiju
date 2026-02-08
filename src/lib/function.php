<?php
//ini_set("display_errors","on");
///////////////   Paging Variables  START here  ///////////

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


$arr=explode('/',$_SERVER['PHP_SELF']);
$is_admin=$arr[1];
if (isset($_REQUEST['toshow']) && $_REQUEST['toshow']!=""){
    $GLOBALS["toshow"] = $_REQUEST['toshow'];
}elseif(isset($_SESSION['adminLoginID']) && $_SESSION['adminLoginID']!="" && $is_admin=='admin'){
    $GLOBALS["toshow"] = 100;
}else{
	if($_SERVER["PHP_SELF"]=='/buy.php'){
    	$GLOBALS["toshow"] = 99;
	}else{
		$GLOBALS["toshow"] = 33;
	}
}

if(isset($_REQUEST["offset"]) && $_REQUEST["offset"]!="") {
    $GLOBALS["offset"] = $_REQUEST["offset"];
    $offset=$_REQUEST["offset"];
}else {
    $GLOBALS["offset"] = 0;
    $offset=0;
}

if(isset($_REQUEST["order_by"])) {
    $GLOBALS["order_by"] = $_REQUEST["order_by"];
}else{
    $GLOBALS["order_by"]='';
}

if(isset($_REQUEST['order_type'])) {
    $GLOBALS['order_type'] = $_REQUEST['order_type'];
}else{
    $GLOBALS['order_type']='';
}

/*if($_REQUEST["order_by"]!="") {
    $GLOBALS["order_by"] = $_REQUEST["order_by"];
}
else {
    $GLOBALS["order_by"] = '';
}*/
///////////////   Paging Variables  END here  ///////////




////////////   Redirect Function START here //////////////
function redirect_admin($url) {
    header("Location: ".ADMIN_PAGE_LINK."/".$url."");
    exit();
}
//////////// Redirect Function END here ///////////////


////////////   Redirect Function START here //////////////
function redirect($url) {
    header("Location: ".PAGE_LINK."/".$url."");
    exit();
}
//////////// Redirect Function END here ///////////////

//////////////  escape function START  /////////////////////////

function escape($text){
    return htmlentities(trim(stripslashes($text)));
}

//////////////  escape function START  /////////////////////////


//////////////  ccheckMail  Function START here //////////////
function checkEmail($emailString,$labelEmail){
    $emailstr=strstr($emailString,",");
    $labelemail=strstr($labelEmail,",");
    if($emailstr!="" && $labelemail!="")  //For Multiple Integer Values
    {
          $emailStringArray=explode(",",$emailString);
          $labelEmailArray=explode(",",$labelEmail);
          for($i=0;$i<count($emailStringArray);$i++)
          {
              if(!preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is",$emailString))
              {
                  $GLOBALS["message"]=$GLOBALS["message"].(ucwords($labelEmailArray[$i]))." Not a valid Email Address"."<br>";
                  $emailStringArray[$i]="";
                  $ret=1;
              }else{$ret=0;}
          }
          return $ret;
    }
    else  //For Single Integer Values
    {
          if(!preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is",$emailString))
          {
              $GLOBALS["message"]=$GLOBALS["message"].(ucwords($labelEmail))." Not a valid Email Address."."<br>";
              $emailString="";
              $ret=1;
          }else{$ret=0;}
          return $ret;
    } 
}
//////////////   checkMail Function End here //////////////



/////////////////   ddpagecounter Function START //////////////////

function ddpageCounter($total, $offset, $toshow, $class) {
    $returnTXT = "";
    
    if($total > $toshow) {
        $no_of_pages=ceil($total/$toshow);
        $returnTXT .= "<b><font class=\"".$class."\">Go to page :&nbsp;</font>";
                
        $returnTXT .= "<select name=\"\" onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\" size=1 class=\"look\">";

        for($ii=0; $ii<ceil($total/$toshow); $ii++) {
            if(($ii+1) <= 0 ) {
                
            }
            else{
                $link = DOMAIN_PATH_NEW.$_SERVER["PHP_SELF"].generateLink(($ii*$toshow), $toshow, $GLOBALS['order_by'], $GLOBALS['order_type'])."";
                if($offset == ($ii*$toshow) ) {
                    $returnTXT .= "<option value=\"$link\" selected>".($ii+1)."</option>";      
                }else {
                    $returnTXT .= "<option value=\"$link\">".($ii+1)."</option>";           
                }
            }
        }
        $returnTXT .= "</select><font class=\"".$class."\"> of ".$no_of_pages." Pages.</b>&nbsp;&nbsp;</font>";
    }
    
    return $returnTXT; 
}
/////////////////   ddpagecounter Function END //////////////////



/////////////////   displaycounter Function START //////////////////

function displayCounter($total,$offset,$toshow,$class, $message="Reports Per Page.", $start=5, $end=100, $step=5, $use=1) {
    $returnTXT = "";
        
    $returnTXT .= "<span class=\"".$class."\">Result per page:&nbsp;</span><select name=\"\" onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\" class=\"look\">";
    for ($i=$start; $i <=$end; $i=$i+$step){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink(0, $i, $GLOBALS['order_by'], $GLOBALS['order_type'])."";
        if ($toshow == $i){
            $returnTXT .= "<option value=\"$link\" selected>$i</option>";
        }else{
            $returnTXT .= "<option value=\"$link\">$i</option>";
        }
    }
    $returnTXT .= "</select>&nbsp;<font class=\"".$class."\">".$message."</font>";
    
    return $returnTXT;
}

/////////////////  displaycounter Function END //////////////////


/////////////////   displaySortBy Function START //////////////////

function displaySortBy($class) {
    if(isset($_REQUEST['mode'])){

    }else{
        $_REQUEST['mode']='';
    }
    if(isset($_REQUEST['list'])){

    }else{
        $_REQUEST['list']='';
    }
    $returnTXT = "";
	if($_REQUEST['list']!="upcoming"){
		$returnTXT .= "<span class=\"".$class."\">Sort By:&nbsp;</span><select name=\"\" onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\" class=\"look\">";
	}else{
		$returnTXT .= "<select name=\"\" onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\" class=\"look\">";
	}
	if ($_REQUEST['list']=="fixed" && $_SERVER['PHP_SELF']=="/buy.php"){
		//$returnTXT .= "<option value=\"\">Shuffle</option>";
		$returnTXT .= "<option value=\"\">Select</option>";
	}else{
		$returnTXT .= "<option value=\"\">Select</option>";
	}
	
	if ($_REQUEST['list']=="weekly" && $_SERVER['PHP_SELF']=="/buy.php" && $_SERVER['PHP_SELF']!="/offers.php"){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_bid_price', 'ASC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_bid_price' && $_REQUEST['order_type'] == 'ASC'){
            $returnTXT .= "<option value=\"$link\" selected>Price: Lowest to Highest</option>";
        }else{
            $returnTXT .= "<option value=\"$link\">Price: Lowest to Highest</option>";
        }
    }elseif($_SERVER['PHP_SELF']!="/offers.php"){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_asked_price', 'ASC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_asked_price' && $_REQUEST['order_type'] == 'ASC'){
            $returnTXT .= "<option value=\"$link\" selected>Price: Lowest to Highest</option>";
        }else{
            $returnTXT .= "<option value=\"$link\">Price: Lowest to Highest</option>";
        }
    }
    if ($_REQUEST['list']=="weekly" && $_SERVER['PHP_SELF']=="/buy.php" && $_SERVER['PHP_SELF']!="/offers.php"){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_bid_price', 'DESC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_bid_price' && $_REQUEST['order_type'] == 'DESC'){
            $returnTXT .= "<option value=\"$link\" selected>Price: Highest to Lowest</option>";
        }else{
            $returnTXT .= "<option value=\"$link\">Price: Highest to Lowest</option>";
        }
    }elseif($_SERVER['PHP_SELF']!="/offers.php"){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_asked_price', 'DESC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_asked_price' && $_REQUEST['order_type'] == 'DESC'){
            $returnTXT .= "<option value=\"$link\" selected>Price: Highest to Lowest</option>";
        }else{
            $returnTXT .= "<option value=\"$link\">Price: Highest to Lowest</option>";
        }
    }	
	if ($_SERVER['PHP_SELF']=="/sold_item.php" && $_REQUEST['mode']!='premier' && $_REQUEST['mode']!='search_sold_premier'){
	$link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'invoice_generated_on', 'ASC');
		if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'invoice_generated_on' && $_REQUEST['order_type'] == 'ASC'){
			$returnTXT .= "<option value=\"$link\" selected>Sold Time: Earliest</option>";
		}else{
			$returnTXT .= "<option value=\"$link\">Sold Time: Earliest </option>";
		}
	
		$link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'invoice_generated_on', 'DESC');
		if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'invoice_generated_on' && $_REQUEST['order_type'] == 'DESC'){
			$returnTXT .= "<option value=\"$link\" selected>Sold Time: Latest</option>";
		}else{
			$returnTXT .= "<option value=\"$link\">Sold Time: Latest</option>";
		}
	}elseif($_REQUEST['mode']!='premier' && $_REQUEST['mode']!='search_sold_premier')
	{
		$link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_actual_end_datetime', 'ASC');
		if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_actual_end_datetime' && $_REQUEST['order_type'] == 'ASC'){
			$returnTXT .= "<option value=\"$link\" selected>Time: Earliest</option>";
		}else{
			$returnTXT .= "<option value=\"$link\">Time: Earliest </option>";
		}
	
		$link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'auction_actual_end_datetime', 'DESC');
		if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'auction_actual_end_datetime' && $_REQUEST['order_type'] == 'DESC'){
			$returnTXT .= "<option value=\"$link\" selected>Time: Latest</option>";
		}else{
			$returnTXT .= "<option value=\"$link\">Time: Latest</option>";
		}
	}
    if($_REQUEST['mode']!='premier' && $_REQUEST['mode']!='search_sold_premier'){
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'poster_title', 'ASC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'poster_title' && $_REQUEST['order_type'] == 'ASC' &&  $_SERVER['PHP_SELF']!="/offers.php" ){
            $returnTXT .= "<option value=\"$link\" selected>Title: A-Z</option>";
        }elseif($_SERVER['PHP_SELF']!="/offers.php"){
            $returnTXT .= "<option value=\"$link\">Title: A-Z</option>";
        }
	
        $link = DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'poster_title', 'DESC');
        if(isset($_REQUEST['order_by']) && $_REQUEST['order_by'] == 'poster_title' && $_REQUEST['order_type'] == 'DESC' &&  $_SERVER['PHP_SELF']!="/offers.php" ){
            $returnTXT .= "<option value=\"$link\" selected>Title: Z-A</option>";
        }elseif($_SERVER['PHP_SELF']!="/offers.php"){
            $returnTXT .= "<option value=\"$link\">Title: Z-A</option>";
        }
    }
    $returnTXT .= "</select>";
    
    return $returnTXT;
}

/////////////////  displaySortBy Function END //////////////////



/////////////////   pagecounter Function END //////////////////
function pageCounter($total, $offset, $toshow, $class, $groupby=10, $showcounter=1, $linkStyle='', $redText='red_text') {
    // $showcounter==0   for Display( 1 of 3) style
    // $showcounter==1   for Display( 1 of 3) << Previous 1 2 3 Next >> style
    // $showcounter==2   for Display( 1 of 3) << Previous Next >> style
    // $showcounter==3   for << Previous 1 2 3 Next >> style
    // $showcounter==4   for << Previous Next >> style
    $groupby=5;
    $returnTXT = "";
    $request = false;
	
    if($_SERVER["PHP_SELF"] =='/buy.php'){
		if(isset($_REQUEST['list']) && $_REQUEST['list']=='fixed' ){
			$request =true;
		}elseif(!isset($_REQUEST['list'])){
			$request =true;
		}else{
			if(isset($_REQUEST['track_is_expired']) && $_REQUEST['track_is_expired']=='1'){
				$request =true;
		  }
		}
	}
    if($showcounter>4){
        $showcounter=1;
    }
    
    if($toshow=="" || $toshow==0) {
        $toshow = 20;
    }
        
    if($total<($offset+$toshow)){
        $dispto=$total;
    }
    else{
        $dispto=$offset+$toshow;
    }
    if($total>0){
        if($showcounter<=2 && !$request){
            $returnTXT .= "<span class=\"".$class."\"> (".($offset+1)." - ".($dispto).") of ".$total."</span>&nbsp;&nbsp;";
        }
        if($total > $toshow && ($showcounter==1 || $showcounter==2 || $showcounter==3 || $showcounter==4)) {
            $no_of_pages=ceil($total/$toshow);
            if($offset != 0) {
                $returnTXT .= "<a href='".DOMAIN_PATH_NEW.$_SERVER["PHP_SELF"].generateLink(($offset - $toshow), $toshow, $GLOBALS['order_by'], $GLOBALS['order_type'])."' class='".$linkStyle."'>&laquo; Prev</a>&nbsp;";
            }
            for($ii=0; $ii<ceil($total/$toshow); $ii++) {
                if(($ii+1) <= 0 ) {
                
                }
                else{
                    if($offset<(($groupby-(floor($groupby/2)))*$toshow-1)){
                        $startindex=0;
                        $endindex=$groupby;
                    }
                    elseif(($total-$offset)<(($groupby-(floor($groupby/2)))*$toshow)){
                        $totalpage=ceil($total/$toshow);
                        $startindex=$totalpage-$groupby+1;
                        $endindex=$totalpage;
                    }
                    else{
                        $currentpage=ceil($offset/$toshow);
                        $startindex=$currentpage-(floor($groupby/2))+2;
                        $endindex=$currentpage+(floor($groupby/2))+1;
                    }
                    if(($ii+1)>=$startindex && ($ii+1)<=$endindex && ($showcounter==1 || $showcounter==3)){
                        $link = DOMAIN_PATH_NEW.$_SERVER["PHP_SELF"].generateLink(($ii*$toshow), $toshow, $GLOBALS['order_by'], $GLOBALS['order_type'])."";
                        if($offset != ($ii*$toshow) ) {
                            $returnTXT .= "<a href=\"".$link."\" class=\"".$linkStyle."\">".($ii+1)."</a>&nbsp;";       
                        }else {
                            $returnTXT .= "<b><span class='".$redText."'>".($ii+1)."</span></b>&nbsp;";         
                        }
                    }
                }
            }
            if(($offset + $toshow)<$total) {
                $returnTXT .= " <a href='".DOMAIN_PATH_NEW.$_SERVER["PHP_SELF"].generateLink(($offset + $toshow), $toshow, $GLOBALS['order_by'], $GLOBALS['order_type'])."' class='".$linkStyle."'>Next &raquo;</a>&nbsp;";
            }
        }
    }
    
    return $returnTXT;
}
/////////////////   pagecounter Function END //////////////////



function generateLink($offset, $toShow, $orderBy, $orderType){
    $linkText='';
    foreach($_GET as $key=>$val){
        if(!($key != "offset" xor $key !="toshow" xor $key != "order_by" xor $key != "order_type")){
            if(is_array($val)){
                foreach($val as $item){
                    $linkText .= $key.urlencode("[]")."=".($item)."&amp;";
                }
            }
            else{
                $linkText .= $key."=".urlencode($val)."&amp;";
            }
        }
    }
    if(isset($offset) && $offset != ""){
        $linkText .= "offset=".$offset."&amp;";
    }
    if(isset($toShow) && $toShow != ""){
        $linkText .= "toshow=".$toShow."&amp;";
    }
    if(isset($orderBy) && $orderBy != ""){
        $linkText .= "order_by=".$orderBy."&amp;";
    }
    if(isset($orderType) && $orderType != ""){
        $linkText .= "order_type=".$orderType."&amp;";
    }
    if(isset($linkText) && substr($linkText, -5) == "&amp;"){
        $linkText = substr($linkText, 0, -5);
    }
    if(isset($linkText) && $linkText != ""){
        $linkText = "?".$linkText;
    }
    return $linkText;
}

////////////////   order_by function start here ///////////////
function orderBy($linkname, $orderby, $imageshow=1, $class){
    $returnTXT = "";
        
    $returnTXT .= "<a href=\"".DOMAIN_PATH_NEW.$_SERVER['PHP_SELF'].generateLink($_REQUEST['offset'], $_REQUEST['toshow'], $orderby, $GLOBALS['order_type_s'])."\" class=\"".$class."\" >".$linkname."";
    if($imageshow==1){
        if($GLOBALS['order_by']==$orderby){
            if($GLOBALS['order_type']=="ASC") {
                $returnTXT .= "&nbsp;<img src=\"".ADMIN_IMAGE_LINK."/down_button.gif\" border=\"0\" alt=\"Descending\" />";     
            }
            elseif($GLOBALS['order_type']=="DESC") {
                $returnTXT .= "&nbsp;<img src=\"".ADMIN_IMAGE_LINK."/up_button.gif\" border=\"0\" alt=\"Ascending\" />";
            }
        }
    }
    $returnTXT .= "</a>";
    
    return $returnTXT;
}
////////////////   order_by function END here ///////////////




//////////////  sendMail function START  /////////////////////////

function sendMail($toMail, $toName, $subject, $textContent) {
    require_once 'AWS/aws-autoloader.php';

	$client = new Aws\Ses\SesClient([
				'version' => 'latest',
				'region'  => 'us-west-2'//,
				//'debug'   => true
	]);
	
	define('SENDER', 'Movie Poster Exchange <info@movieposterexchange.com>');

	// Replace recipient@example.com with a "To" address. If your account
	// is still in the sandbox, this address must be verified.
	define('RECIPIENT', $toName.'<'.$toMail.'>');
	
	// Replace us-west-2 with the AWS region you're using for Amazon SES.
	define('REGION','us-west-2');
	
	define('SUBJECT',$subject);
	define('BODY',$textContent);
	
	$request = array();
	$request['Source'] = SENDER;
	$request['Destination']['ToAddresses'] = array(RECIPIENT);
	$request['Message']['Subject']['Data'] = $subject;
	$request['Message']['Subject']['Charset'] = 'utf-8';
	$request['Message']['Body']['Html']['Data'] = BODY;
	$request['Message']['Body']['Html']['Charset'] = 'utf-8';
	//echo "<pre>".print_r($request)."</pre>";
	try{
		$result = $client->sendEmail($request);
	}catch (Exception $e) {
	
	}
	
}

////////////// sendMail function END    ///////////////////////////////



///////////////    upload function start here  /////////////
function moveUploadedFile($fieldName, $path, $fileName = '')
{
    if(is_uploaded_file($_FILES[$fieldName]['tmp_name'])){
        if($fileName == ''){
            $fileName = $_FILES[$fieldName]['name'];
        }
        $extParts = explode('.', $_FILES[$fieldName]['name']);
        $ext = strtolower(end($extParts));
        $fileName = $fileName.'.'.$ext;
        @chmod($path, 0777);
        $newpath = $path."/".$fileName;
        if(!file_exists($path)){
            mkdir(str_replace('//','/',$path), 0755, true);
        }
        if(!file_exists($path)){
            mkdir(str_replace('//','/',$path), 0755, true);
        }
        $status = move_uploaded_file($_FILES[$fieldName]['tmp_name'], $newpath);
        @chmod($newpath , 0777);
        //return str_replace('./', '', str_replace('../', '', $newpath));
        return $fileName;
    }else{
        return false;
    }
}

function moveUploadedFile1($fieldName, $path, $fileName = '', $is_array = false, $array_index = 0)
{
    if($is_array){
        $name = $_FILES[$fieldName]['name'][$array_index];
        $tmp_name = $_FILES[$fieldName]['tmp_name'][$array_index];
    }else{
        $name = $_FILES[$fieldName]['name'];
        $tmp_name = $_FILES[$fieldName]['tmp_name'];
    }
    if(is_uploaded_file($tmp_name)){
        if($fileName == ''){
            $fileName = $name;
        }
        $extParts = explode('.', $name);
        $ext = strtolower(end($extParts));

        $fileName = $fileName.'.'.$ext;
        @chmod($path, 0777);
        $newpath = $path."/".$fileName;
        $status = move_uploaded_file($tmp_name, $newpath);

        @chmod($newpath , 0777);
        //return str_replace('./', '', str_replace('../', '', $newpath));
        return $fileName;
    }else{
        return false;
    }
}

///////////////    upload function start here  /////////////


///////////////    makeRandomWord function start here  /////////////
function makeRandomWord($size) {
    $salt = "ABCHEFGHJKMNPQRSTUVWXYZ0123456789abchefghjkmnpqrstuvwxyz";
    srand((double)microtime()*1000000);
    $word = '';
    $i = 0;
    while (strlen($word)<$size) {
        $num = rand() % 59;
        $tmp = substr($salt, $num, 1);
        $word = $word . $tmp;
        $i++;
    }
    return $word;
}
///////////////    makeRandomWord function end here  /////////////


//Encryption function
function easy_crypt($string){
    return base64_encode($string."_@#&!@_");
}

//Decodes encryption
function easy_decrypt($str){
    $str=base64_decode($str);
    return str_replace("_@#&!@_", "", $str);
}



function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
  /*
    echo datediff('w', '9 July 2003', '4 March 2004', false);
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
  */
  
  if (!$using_timestamps) {
    $datefrom = strtotime($datefrom, 0);
    $dateto = strtotime($dateto, 0);
  }
  $difference = $dateto - $datefrom; // Difference in seconds
   
  switch($interval) {
   
    case 'yyyy': // Number of full years

      $years_difference = floor($difference / 31536000);
      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
        $years_difference--;
      }
      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
        $years_difference++;
      }
      $datediff = $years_difference;
      break;

    case "q": // Number of full quarters

      $quarters_difference = floor($difference / 8035200);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $quarters_difference--;
      $datediff = $quarters_difference;
      break;

    case "m": // Number of full months

      $months_difference = floor($difference / 2678400);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $months_difference--;
      $datediff = $months_difference;
      break;

    case 'y': // Difference between day numbers

      $datediff = date("z", $dateto) - date("z", $datefrom);
      break;

    case "d": // Number of full days

      $datediff = floor($difference / 86400);
      break;

    case "w": // Number of full weekdays

      $days_difference = floor($difference / 86400);
      $weeks_difference = floor($days_difference / 7); // Complete weeks
      $first_day = date("w", $datefrom);
      $days_remainder = floor($days_difference % 7);
      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
      if ($odd_days > 7) { // Sunday
        $days_remainder--;
      }
      if ($odd_days > 6) { // Saturday
        $days_remainder--;
      }
      $datediff = ($weeks_difference * 5) + $days_remainder;
      break;

    case "ww": // Number of full weeks

      $datediff = floor($difference / 604800);
      break;

    case "h": // Number of full hours

      $datediff = floor($difference / 3600);
      break;

    case "n": // Number of full minutes

      $datediff = floor($difference / 60);
      break;

    default: // Number of full seconds (default)

      $datediff = $difference;
      break;
  }    

  return $datediff;

}


////////////   content Function START ///////////////////////
function content() {

    $page = new PageContent();
    if(basename($_SERVER['PHP_SELF'])!='index.php' && basename($_SERVER['PHP_SELF'])!=''){		
    	$page->pageName = basename($_SERVER['PHP_SELF']);
	}else{
		$page->pageName = 'mpe_home_page_cms.php';
	}
    $row = $page->pageContentDetails();
    
    $GLOBALS["sslStatus"] = $row[PAGE_SSL_PERMISSION];
/*    
    if(SSL_URL ==  true && $GLOBALS["sslStatus"] == 1 && $_SERVER['HTTPS'] !="on"){
        header("location: https://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit();
    }
    elseif((SSL_URL == false or $GLOBALS["sslStatus"] == 0) && $_SERVER['HTTPS'] =="on"){
        header("location: http://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit();
    }*/

    $GLOBALS["pageContent"] = $row[PAGE_CONTENT];
    $GLOBALS["pageTitle"] = $row[PAGE_TITLE];
    $GLOBALS["pageHeaderName"] = $row[PAGE_HEADER_NAME];
    $GLOBALS["metaKeywords"] = $row[META_KEYWORDS];
    $GLOBALS["metaDescription"] = $row[META_DESCRIPTION];
    $GLOBALS["metaTags"] = $row[META_TAGS];
    
	$selectGlobalConfig = "SELECT * FROM config_table WHERE config_id = '1'";
    $globalConfigResultSet = mysqli_query($GLOBALS['db_connect'], $selectGlobalConfig);
    $globalConfigInfo = mysqli_fetch_object($globalConfigResultSet);
    
    if($row[META_KEYWORDS] == ""){
      $GLOBALS["metaKeywords"] = $globalConfigInfo->site_global_keywords;
    }    
    if($row[META_DESCRIPTION] == ""){
     $GLOBALS["metaDescription"] = $globalConfigInfo->site_global_description;
    }
    if($row[META_TAGS] == ""){
     $GLOBALS["metaTags"] = $globalConfigInfo->site_global_metatags;
    }
}
//content();
/////////////////   content Function END ////////////////////



////////////  custom content Function START ///////////////////////
function customContent() {
    $page = new pageContent();
    $page->pageContentID = $_REQUEST['pID'];
    $row = $page->pageCustomContentDetails();
    $GLOBALS["sslStatus"] = $row[PAGE_SSL_PERMISSION];
    
    if(SSL_URL ==  true && $GLOBALS["sslStatus"] == 1 && $_SERVER['HTTPS'] !="on"){
        header("location: https://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit(); 
    }
    elseif((SSL_URL ==  false or $GLOBALS["sslStatus"] == 0) && $_SERVER['HTTPS'] =="on"){
        header("location: http://".HOST_NAME."/".basename($_SERVER['REQUEST_URI'])."");
        exit();
    }

    $GLOBALS["pageContent"] = $row[PAGE_CONTENT];
    $GLOBALS["pageTitle"] = $row[PAGE_TITLE];
    $GLOBALS["pageHeaderName"] = $row[PAGE_HEADER_NAME];
    $GLOBALS["metaKeywords"] = $row[META_KEYWORDS];
    $GLOBALS["metaDescription"] = $row[META_DESCRIPTION];
    $GLOBALS["metaTags"] = $row[META_TAGS];
}

function generatePassword ($length = 8)
{

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  // done!
  return $password;

}

function getCountryList()
{
     $sql = "SELECT * FROM ".COUNTRY_TABLE." ORDER BY country_name";
    $rs = mysqli_query($GLOBALS['db_connect'], $sql);
    return $rs;
}

function getCountryByCountryID($country_id)
{
     $sql = "SELECT * FROM ".COUNTRY_TABLE."
            WHERE ".COUNTRY_ID." = '".mysqli_real_escape_string($GLOBALS['db_connect'], $country_id)."'";
    $rs = mysqli_query($GLOBALS['db_connect'], $sql);
    $row = mysqli_fetch_array($rs);
    return $row['country_name'];
}

/////////////////  custom content Function END ////////////////////

function formatDateTime($date,$time=false){
    $database_date=$date;
    if($time){
        return date('m/d/Y H:i:s',strtotime($database_date));
    }else{
        return date('m/d/Y',strtotime($database_date));
    }
}
function formatOnlyTime($date){
    $database_date=$date;
        return date('H:i:s',strtotime($database_date));
}

function formatDbDateTime($date,$time=false){
    $user_date = $date;
    if($time){
        return date('Y-m-d H:i:s',strtotime($user_date));
    }else{
        return date('Y-m-d',strtotime($user_date));
    }
}

function splitDateTime($datetime)
{
    list($date, $time) = explode(' ', $datetime);
    list($year, $month, $date) = explode('-', $date);
    list($hour, $minute, $second) = explode(':', $time);
    $dateTimeArr = array("year" => $year, "month" => $month, "date" => $date,
                         "hour" => $hour, "minute" => $minute, "second" => $second);

    return $dateTimeArr;
}

function create_thumbnail($newpath,$imgpath,$fileName,$resize_width=100,$resize_height){
    $new_up_path=$newpath."/".$fileName;
    require_once("thumbnail_class.php");
    $thumb=new thumbnail($imgpath);
    $size = getimagesize($imgpath);
    $resize_width=100;
    //$resize_height=78;    
    if ($size[0] >= $size[1]) {
        $img_type = 'landscape';
        if ($size[0] > $resize_width) {
            $thumb->size_width($resize_width);         // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_width(83);          // set width for thumbnail with 100 pixels
        }
    }
    else {
        $img_type = 'portrait';
        if ($size[1] > $resize_height) {
            $thumb->size_height($resize_height);           // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_height(78);         // set width for thumbnail with 100 pixels
        }
    }
    $thumb->save($new_up_path);
}

function create_thumbnail_for_buy($newpath,$imgpath,$fileName,$resize_width,$resize_height){
    $new_up_path=$newpath."/".$fileName;
    require_once("thumbnail_class.php");
    $thumb=new thumbnail($imgpath);
    $size = getimagesize($imgpath);
    //$resize_width='200';
    //$resize_height=78;    
    if ($size[0] >= $size[1]) {
        $img_type = 'landscape';
        if ($size[0] > $resize_width) {
            $thumb->size_width($resize_width);         // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_width(150);          // set width for thumbnail with 100 pixels
        }
    }
    else {
        $img_type = 'portrait';
        if ($size[1] > $resize_height) {
            $thumb->size_height($resize_height);           // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_height(150);         // set width for thumbnail with 100 pixels
        }
    }
    
    $thumb->save($new_up_path);    // save my  thumbnail to file "huhu.jpg" in directory "/www/thumb
}

function create_thumbnail_for_buy_gallery($newpath,$imgpath,$fileName,$resize_width,$resize_height){
    $new_up_path=$newpath."/".$fileName;
    require_once("thumbnail_class.php");
    $thumb=new thumbnail($imgpath);
    $size = getimagesize($imgpath);
    //$resize_width='200';
    //$resize_height=78;    
    if ($size[0] >= $size[1]) {
        $img_type = 'landscape';
        if ($size[0] > $resize_width) {
            $thumb->size_width($resize_width);         // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_width(200);          // set width for thumbnail with 100 pixels
        }
    }
    else {
        $img_type = 'portrait';
        if ($size[1] > $resize_height) {
            $thumb->size_height($resize_height);           // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_height(200);         // set width for thumbnail with 100 pixels
        }
    }
    
    $thumb->save($new_up_path);    // save my  thumbnail to file "huhu.jpg" in directory "/www/thumb
}

function create_thumbnail_for_big_slider($newpath,$imgpath,$fileName,$resize_width,$resize_height){
    $new_up_path=$newpath."/".$fileName;
    require_once("thumbnail_class.php");
    $thumb=new thumbnail($imgpath);
    $size = getimagesize($imgpath);
    //$resize_width='200';
    //$resize_height=78;    
    if ($size[0] >= $size[1]) {
        $img_type = 'landscape';
        if ($size[0] > $resize_width) {
            $thumb->size_width($resize_width);         // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_width(570);          // set width for thumbnail with 100 pixels
        }
    }
    else {
        $img_type = 'portrait';
        if ($size[1] > $resize_height) {
            $thumb->size_height($resize_height);           // set width for thumbnail with 100 pixels
        }
        else {
            $thumb->size_height(430);         // set width for thumbnail with 100 pixels
        }
    }
    
    $thumb->save($new_up_path);    // save my  thumbnail to file "huhu.jpg" in directory "/www/thumb
}

function sendOfferMailCron($row, $status)
{
    $toMail = $row['email'];
    $toName = $row['firstname'].' '.$row['lastname'];
    $subject = "MPE::Offer Accepted - ".$row['poster_title']." (#".$row['poster_sku'].")";
    $fromMail = ADMIN_EMAIL_ADDRESS;
    $fromName = ADMIN_NAME;
    
    $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
    $textContent .= '<b>Poster Title : </b>'.$row['poster_title'].'<br />';
    $textContent .= '<b>Poster Title : </b>'.$row['poster_sku'].'<br /><br />';
    if($status == "accept_counter_offer"){
        $textContent .= 'Your counter offer has been accepted.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "accept_offer"){
        $textContent .= 'Your offer has been accepted.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "reject_counter_offer"){
        $textContent .= 'Your counter offer has been rejected.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "reject_offer"){
        $textContent .= 'Your offer has been rejected.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "counter_offer_made"){
        $textContent .= 'Counter offer has been made against your offer.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "no_respose_from_seller"){
        $textContent .= 'Your offer is rejected as there is no respose from your end for last 48 hrs.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "no_respose_from_buyer"){
        $textContent .= 'Your offer is rejected as there is no respose from the buyer for last 48 hrs.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "reject_offer_seller"){
        $textContent .= 'Your offer is rejected as there is no respone from the seller for last 48 hrs.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }elseif($status == "reject_offer_buyer"){
        $textContent .= 'Your offer is rejected as there is no respone from your end for last 48 hrs.<br /><br />';
        $textContent .= 'For more details, please login <a href="http://'.HOST_NAME.'">';
    }
    
    $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
     $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM; 
    $check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
}
function sendMailByUserid($mail_poster_title,$id,$date)
{
    $sql = "SELECT u.username, u.firstname, u.lastname, u.email
                FROM ".USER_TABLE." u
                WHERE u.user_id =".mysqli_real_escape_string($GLOBALS['db_connect'], $id);
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_array($rs);
    $toMail = $row['email'];
    $toName = $row['firstname'].' '.$row['lastname'];
    $subject = "MPE::New poster matching your want list";
    $fromMail = ADMIN_EMAIL_ADDRESS;
    $fromName = ADMIN_NAME;
    
    $textContent = 'Dear '.$row['firstname'].' '.$row['lastname'].',<br /><br />';
    if($date!='0000-00-00 00:00:00' && $date > date('Y-m-d H:i:s')){
    $textContent .= 'New poster(Poster Title:<b>'.$mail_poster_title.'</b>) has matched with your want list. Auction starts on '.date('m/d/Y', strtotime($date)).'.<br /><br />';
    }else{
    $textContent .= 'New poster(Poster Title:<b>'.$mail_poster_title.'</b>) has matched with your want list.<br /><br />';	
    }
    $textContent .= 'For more details, please  <a href="http://'.HOST_NAME.'"> login </a><br /><br />';
    
    $textContent .= "Thanks & Regards,<br /><br />".ADMIN_NAME."<br />".ADMIN_EMAIL_ADDRESS;    
    $textContent = MAIL_BODY_TOP.$textContent.MAIL_BODY_BOTTOM; 

    //$check = sendMail($toMail, $toName, $subject, $textContent, $fromMail, $fromName, $html=1);
	$check = sendMailAWS($toMail, $toName, $subject, $textContent);
	
}


function add_slashes($content){
        return(addslashes($content));
    }
function strip_slashes($content){
        return(stripslashes($content));
    }
function check_int($str){
    //return preg_match("/^[0-9]+$/", $str);
    return is_numeric($str);
}
     function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'ST';
        case 2:  return $num.'ND';
        case 3:  return $num.'RD';
      }
    }
    return $num.'TH';
  }

function datediff_with_presentdate($date)
{
	$curr_month = date('m');
	$curr_year = date('Y');
	$date1 = explode('-',$date);
	$expired_mnth = $date1[0];
	$expired_year = $date1[1];
	if($expired_year > $curr_year){
		return true;
	}elseif($expired_year == $curr_year && $expired_mnth >= $curr_month){
		return true;
	}else{
		return false;
	}
}

function checkCreditCard ($cardnumber, $cardname, &$errornumber, &$errortext) {

  // Define the cards we support. You may add additional card types.
  
  //  Name:      As in the selection box of the form - must be same as user's
  //  Length:    List of possible valid lengths of the card number for the card
  //  prefixes:  List of possible prefixes for the card
  //  checkdigit Boolean to say whether there is a check digit
  
  // Don't forget - all but the last array definition needs a comma separator!
  
  $cards = array (  array ('name' => 'Amex', 
                          'length' => '15', 
                          'prefixes' => '34,37',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Diners Club Carte Blanche', 
                          'length' => '14', 
                          'prefixes' => '300,301,302,303,304,305',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Diners Club', 
                          'length' => '14,16',
                          'prefixes' => '305,36,38,54,55',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Discover', 
                          'length' => '16', 
                          'prefixes' => '6011,622,64,65',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Diners Club Enroute', 
                          'length' => '15', 
                          'prefixes' => '2014,2149',
                          'checkdigit' => true
                         ),
                   array ('name' => 'JCB', 
                          'length' => '16', 
                          'prefixes' => '35',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Maestro', 
                          'length' => '12,13,14,15,16,18,19', 
                          'prefixes' => '5018,5020,5038,6304,6759,6761',
                          'checkdigit' => true
                         ),
                   array ('name' => 'MasterCard', 
                          'length' => '16', 
                          'prefixes' => '51,52,53,54,55',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Solo', 
                          'length' => '16,18,19', 
                          'prefixes' => '6334,6767',
                          'checkdigit' => true
                         ),
                   array ('name' => 'Switch', 
                          'length' => '16,18,19', 
                          'prefixes' => '4903,4905,4911,4936,564182,633110,6333,6759',
                          'checkdigit' => true
                         ),
                   array ('name' => 'VISA', 
                          'length' => '16', 
                          'prefixes' => '4',
                          'checkdigit' => true
                         ),
                   array ('name' => 'VISA Electron', 
                          'length' => '16', 
                          'prefixes' => '417500,4917,4913,4508,4844',
                          'checkdigit' => true
                         ),
                   array ('name' => 'LaserCard', 
                          'length' => '16,17,18,19', 
                          'prefixes' => '6304,6706,6771,6709',
                          'checkdigit' => true
                         )
                );

  $ccErrorNo = 0;

  $ccErrors [0] = "Unknown card type";
  $ccErrors [1] = "No card number provided";
  $ccErrors [2] = "Credit card number has invalid format";
  $ccErrors [3] = "Credit card number is invalid";
  $ccErrors [4] = "Credit card number is wrong length";
               
  // Establish card type
  $cardType = -1;
  for ($i=0; $i<sizeof($cards); $i++) {

    // See if it is this card (ignoring the case of the string)
    if (strtolower($cardname) == strtolower($cards[$i]['name'])) {
      $cardType = $i;
      break;
    }
  }
  
  // If card type not found, report an error
  if ($cardType == -1) {
     $errornumber = 0;     
     $errortext = $ccErrors [$errornumber];
     return false; 
  }
   
  // Ensure that the user has provided a credit card number
  if (strlen($cardnumber) == 0)  {
     $errornumber = 1;     
     $errortext = $ccErrors [$errornumber];
     return false; 
  }
  
  // Remove any spaces from the credit card number
  $cardNo = str_replace (' ', '', $cardnumber);  
   
  // Check that the number is numeric and of the right sort of length.
  if (!preg_match("/^[0-9]{13,19}$/",$cardNo))  {
     $errornumber = 2;     
     $errortext = $ccErrors [$errornumber];
     return false; 
  }
       
  // Now check the modulus 10 check digit - if required
  if ($cards[$cardType]['checkdigit']) {
    $checksum = 0;                                  // running checksum total
    $mychar = "";                                   // next char to process
    $j = 1;                                         // takes value of 1 or 2
  
    // Process each digit one by one starting at the right
    for ($i = strlen($cardNo) - 1; $i >= 0; $i--) {
    
      // Extract the next digit and multiply by 1 or 2 on alternative digits.      
      $calc = $cardNo[$i] * $j;
    
      // If the result is in two digits add 1 to the checksum total
      if ($calc > 9) {
        $checksum = $checksum + 1;
        $calc = $calc - 10;
      }
    
      // Add the units element to the checksum total
      $checksum = $checksum + $calc;
    
      // Switch the value of j
      if ($j ==1) {$j = 2;} else {$j = 1;};
    } 
  
    // All done - if checksum is divisible by 10, it is a valid modulus 10.
    // If not, report an error.
    if ($checksum % 10 != 0) {
     $errornumber = 3;     
     $errortext = $ccErrors [$errornumber];
     return false; 
    }
  }  

  // The following are the card-specific checks we undertake.

  // Load an array with the valid prefixes for this card
  $prefix = explode(',',$cards[$cardType]['prefixes']);
      
  // Now see if any of them match what we have in the card number  
  $PrefixValid = false; 
  for ($i=0; $i<sizeof($prefix); $i++) {
    $exp = '/^' . $prefix[$i] . '/';
    if (preg_match($exp,$cardNo)) {
      $PrefixValid = true;
      break;
    }
  }
      
  // If it isn't a valid prefix there's no point at looking at the length
  if (!$PrefixValid) {
     $errornumber = 3;     
     $errortext = $ccErrors [$errornumber];
     return false; 
  }
    
  // See if the length is valid for this card
  $LengthValid = false;
  $lengths = explode(',',$cards[$cardType]['length']);
  for ($j=0; $j<sizeof($lengths); $j++) {
    if (strlen($cardNo) == $lengths[$j]) {
      $LengthValid = true;
      break;
    }
  }
  
  // See if all is OK by seeing if the length was valid. 
  if (!$LengthValid) {
     $errornumber = 4;     
     $errortext = $ccErrors [$errornumber];
     return false; 
  };   
  
  // The credit card is in the required format.
  return true;
}

function paypalCCValidation($data)
{
	$objPaypal = new Paypal_DoDirectPayment();
	
	$objPaypal->firstName = $data['firstname'];
	$objPaypal->lastName = $data['lastname'];
	$objPaypal->ccType = $data['card_type'];
	$objPaypal->ccNumber = $data['credit_card_no'];
	$objPaypal->cvv2 = $data['security_code'];
	$objPaypal->expdate = $data['expired_mnth'].$data['expired_yr'];
	$objPaypal->amount = "0.01";
	$objPaypal->currencyCode = CURRENCY_CODE;

	$objPaypal->API_Endpoint = API_ENDPOINT;
	$objPaypal->version = VERSION;
	$objPaypal->API_UserName = API_USERNAME;
	$objPaypal->API_Password = API_PASSWORD;
	$objPaypal->API_Signature = API_SIGNATURE;

	$resArray = $objPaypal->hash_call();
	if(preg_match("/success/i",$resArray['ACK']) == 0){
		return false;
	}else{
		return true;
	}
}

function isImage($filename) 
{
	$extArr = array('jpg','jpeg','gif','png');
	$filename = strtolower($filename) ; 
	$exts = preg_split("/[\/\\.]/", $filename) ; 
	$n = count($exts)-1; 
	$exts = $exts[$n];
	$flag = 0;
	foreach($extArr as $key => $value){
		if($value == $exts){
			$flag = 1;
			break;
		}
	}
	if($flag == 1){
		return true;
	}else{
		return false;
	}
} 
function canonicalize_time($time)
{
	return (preg_match('/^((([0]?[1-9]|1[0-2])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?( )?(AM|am|aM|Am|PM|pm|pM|Pm))|(([0]?[0-9]|1[0-9]|2[0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$/', $time, $match)) ? $match : false;
	//return (preg_match('/[\s0]*(\d|1[0-2]):(\d{2})\s*([AaPp][Mm])/xms', $time, $match)) ? $match : false;
}
function extract_time1($time)
{
	//return (preg_match('/^((([0]?[1-9]|1[0-2])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?( )?(AM|am|aM|Am|PM|pm|pM|Pm))|(([0]?[0-9]|1[0-9]|2[0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$/', $time, $match)) ? $match : false;
	return (preg_match('/([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}) ([a-zA-Z]+)/', $time, $match))? $match : false;
	//return !$match ? false:array('hours' => $match[1], 'minutes' => $match[2], 'tod' => $match[4]);
}
function extract_time2($time)
{
	//return (preg_match('/^((([0]?[1-9]|1[0-2])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?( )?(AM|am|aM|Am|PM|pm|pM|Pm))|(([0]?[0-9]|1[0-9]|2[0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$/', $time, $match)) ? $match : false;
//	preg_match('/([0-9]{1,2}):([0-9]{1,2}) ([a-zA-Z]+)/', $time, $match);
//	return !$match ? false:array('hours' => $match[1], 'minutes' => $match[2], 'tod' => $match[4]);
return (preg_match('/([0-9]{1,2}):([0-9]{1,2}) ([a-zA-Z]+)/', $time, $match))? $match : false;
}
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
 function dynamicPosterUpload($posterArr,$poster_id,$is_default,$src_temp,$dest_poster_photo,$destThumb,$destThumb_buy,$destThumb_buy_gallery,$destThumb_big_slider,$type=''){
	//require('configures.php');
 	//require('cloudfiles/cloudfiles.php');
	//require 'AWS/aws-autoloader.php';

	require_once 'AWS/aws-autoloader.php';

	// Make paths absolute so thumbnail functions can find files
	// Get document root, with fallback for cases where it's empty
	$docRoot = !empty($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') : '/var/www/html';
	$docRoot = $docRoot . '/';

	// Helper function to convert relative path to absolute
	$makeAbsolute = function($path) use ($docRoot) {
		// If path starts with ../ it's relative, convert to absolute
		if (strpos($path, '../') === 0) {
			// Remove ../ and prepend document root
			return $docRoot . ltrim(preg_replace('#^\.\./#', '', $path), '/');
		} elseif (strpos($path, '/') === 0) {
			// Already absolute path starting with /
			return $path;
		} else {
			// Relative path without ../, prepend document root
			return $docRoot . ltrim($path, '/');
		}
	};

	$src_temp = $makeAbsolute($src_temp);
	$dest_poster_photo = $makeAbsolute($dest_poster_photo);
	$destThumb = $makeAbsolute($destThumb);
	$destThumb_buy = $makeAbsolute($destThumb_buy);
	$destThumb_buy_gallery = $makeAbsolute($destThumb_buy_gallery);
	if(!empty($destThumb_big_slider)) $destThumb_big_slider = $makeAbsolute($destThumb_big_slider);

 	//$obj = new Poster();

	$has_default = false;
	if (!empty($is_default)) {
		foreach ($posterArr as $v) {
			if ($v == $is_default) { $has_default = true; break; }
		}
	}

	foreach($posterArr as $key => $value){

		$extParts = explode('.', $value);
		$imageExt = $fileExt = end($extParts);
		if ($has_default) {
			$set_default = ($value == $is_default) ? 1 : 0;
		} else {
			// No valid default selected — set first image as default
			$set_default = ($key === array_key_first($posterArr)) ? 1 : 0;
		}
		mysqli_query($GLOBALS['db_connect'], 'START TRANSACTION');
        //$poster_image_id=$obj->updateData(TBL_POSTER_IMAGES, array("fk_poster_id" => $poster_id, "poster_thumb" => addslashes($value),
                                                  //"poster_image" => addslashes($value), "is_default" => $set_default,"FileExtention"=>$imageExt,"original_filename"=>addslashes($value),"is_cloud"=>'1',"is_big"=>'1'));
		mysqli_query($GLOBALS['db_connect'], "Insert into tbl_poster_images (fk_poster_id,poster_thumb,poster_image,is_default,FileExtention,original_filename,is_cloud,is_big)  Values ($poster_id,'".addslashes($value)."','".addslashes($value)."','".$set_default."','".$imageExt."','".addslashes($value)."','1','1') ");

		$poster_image_id=mysqli_insert_id($GLOBALS['db_connect']);
		if($type=='weekly'){
		//$rowPosterImages = $obj->selectData(TBL_POSTER_IMAGES, array('*'), array("poster_image_id" => $poster_image_id));
		$sql="select * from tbl_poster_images where poster_image_id=".$poster_image_id;
		$rowPosterImages=mysqli_fetch_array(mysqli_query($GLOBALS['db_connect'], $sql));
		
		
		mysqli_query($GLOBALS['db_connect'], "Insert into tbl_poster_images_live (fk_poster_id,poster_thumb,poster_image,is_default,FileExtention,original_filename,is_cloud,is_big)  Values ($poster_id,'".addslashes($rowPosterImages['poster_thumb'])."','".addslashes($rowPosterImages['poster_thumb'])."','".$set_default."','".$imageExt."','".addslashes($value)."','1','1') ");
		}

		mysqli_query($GLOBALS['db_connect'], 'COMMIT');										  
			$imgNewName=$poster_image_id.'.'.$imageExt;
			$src = $src_temp.trim($value);
			$fileName = $imgNewName;
			$dest = $dest_poster_photo.$fileName;
			if(rename($src, $dest)){
				create_thumbnail($destThumb,$dest,$fileName,100,100);
				create_thumbnail_for_buy($destThumb_buy,$dest,$fileName,150,150);
				create_thumbnail_for_buy_gallery($destThumb_buy_gallery,$dest,$fileName,200,200);
				create_thumbnail_for_big_slider($destThumb_big_slider,$dest,$fileName,570,430);
			}
			/*
		 * Upload Files to the colud--Start
		 */
		 $originalImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/".$fileName;
		 $thumbImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumbnail/".$fileName;
		 $thumbBuyImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumb_buy/".$fileName;
		 $thumbBuyGalleryImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumb_buy_gallery/".$fileName;
		 $thumbBuyBigImage = $_SERVER['DOCUMENT_ROOT']."/poster_photo/thumb_big_slider/".$fileName;		
		 
		 // Buckets into upload AWS 
		 /*$bucketoriginalImage="cloudposter";
		 $bucketthumbImage="cloudposterthumb";
		 $bucketthumbBuyImage="cloudposterthumbbuy";
		 $bucketthumbBuyGalleryImage="cloudposterthumbbuygallery";
		 $bucketthumbBuyBigImage="cloudposterthumbbiggallery";*/
		 
		 // Connect to AWS 
		 /*$client = new Aws\S3\S3Client([
    		'version' => 'latest',
    		'region'  => 'us-west-2'//,
    		//'debug'   => true
		 ]);
		 */
		
		
 		//Upload original image	
		 /*try {
			$client->putObject(array(
				 'Bucket'=>$bucketoriginalImage,
				 'Key' =>  $fileName,
				 'SourceFile' => $originalImage,
				 'StorageClass' => 'STANDARD'
        	));
		 }catch (S3Exception $e) {
         // Catch an S3 specific exception.
        	echo $e->getMessage();
    	 }*/
		
		//Upload thumb image	
		 /*try {
			$client->putObject(array(
				 'Bucket'=>$bucketthumbImage,
				 'Key' =>  $fileName,
				 'SourceFile' => $thumbImage,
				 'StorageClass' => 'STANDARD'
        	));
		 }catch (S3Exception $e) {
         // Catch an S3 specific exception.
        	echo $e->getMessage();
    	 }*/
				
		//Upload thumbbuy image	
		 /*try {
			$client->putObject(array(
				 'Bucket'=>$bucketthumbBuyImage,
				 'Key' =>  $fileName,
				 'SourceFile' => $thumbBuyImage,
				 'StorageClass' => 'STANDARD'
        	));
		 }catch (S3Exception $e) {
         // Catch an S3 specific exception.
        	echo $e->getMessage();
    	 }*/
				
		//Upload thumbbuy gallery image	
		 /*try {
			$client->putObject(array(
				 'Bucket'=>$bucketthumbBuyGalleryImage,
				 'Key' =>  $fileName,
				 'SourceFile' => $thumbBuyGalleryImage,
				 'StorageClass' => 'STANDARD'
        	));
		 }catch (S3Exception $e) {
         // Catch an S3 specific exception.
        	echo $e->getMessage();
    	 }*/
		 
		 //Upload slider container image	
		 /*try {
			$client->putObject(array(
				 'Bucket'=>$bucketthumbBuyBigImage,
				 'Key' =>  $fileName,
				 'SourceFile' => $thumbBuyBigImage,
				 'StorageClass' => 'STANDARD'
        	));
		 }catch (S3Exception $e) {
         // Catch an S3 specific exception.
        	echo $e->getMessage();
    	 }*/

        //unlink($originalImage);
        //unlink($thumbImage);
        //unlink($thumbBuyImage);
        //unlink($thumbBuyGalleryImage);
		//unlink($thumbBuyBigImage);

		 //echo $object->public_uri();					
		/*
		 * Upload Files to the colud--End
		 */	
  }
 }
 function decade_calculator($year)
	{
	$yr3=substr($year,0,3);
	$min=$yr3.'0';
	$max=$yr3.'9';
	return $min.'-'.$max;
	}  
function delete_directory($dirname) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            delete_directory($dirname.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
   return true;
}	
 function compareDates($date1,$date2) {
$date1_array = explode("/",$date1);
$date2_array = explode("/",$date2);
$timestamp1 =
mktime(0,0,0,$date1_array[0],$date1_array[1],$date1_array[2]);
$timestamp2 =
mktime(0,0,0,$date2_array[0],$date2_array[1],$date2_array[2]);
if ($timestamp1>=$timestamp2) {
return false;
} else if ($timestamp1<$timestamp2) {
return true;
} else {
return "equal";
}
}
function  linearSearchCount(&$a, $n, $k)
{
    $count = 0;
    for ($i = 0; $i < $n; $i++)
    {
        if ($a[$i] == $k)
        {
            $count++;
        }
    }
    return $count;
}
function  linearSearchTotal(&$a, $n, $k,&$b)
{
    $total = 0;
    for ($i = 0; $i < $n; $i++)
    {
        if ($a[$i] == $k)
        {
            $total=$total+$b[$i];
        }
    }
    return $total;
}
function  linearSearchTotalAuction(&$a, $n, $k,&$b)
{
    //$auction = 0;
    for ($i = 0; $i < $n; $i++)
    {
        if ($a[$i] == $k)
        {

            $auction=$auction.$b[$i].',';

        }
    }
    return $auction;
}
function chkTimeOut(){}
 function clrCartAfterLogout(){
 	$sql_delete = " Delete from ".TBL_CART_HISTORY."  where fk_user_id= '".mysqli_real_escape_string($GLOBALS['db_connect'], $_SESSION['sessUserID'])."' ";
	$res_sql_delete=mysqli_query($GLOBALS['db_connect'], $sql_delete);
 }
 function chkLoginNow(){}
 
 function sendMailAWS($toMail, $toName, $subject, $textContent){
 	require_once 'AWS/aws-autoloader.php';

	$client = new Aws\Ses\SesClient([
				'version' => 'latest',
				'region'  => 'us-west-2'//,
				//'debug'   => true
	]);
	
	define('SENDER', 'Movie Poster Exchange <info@movieposterexchange.com>');

	// Replace recipient@example.com with a "To" address. If your account
	// is still in the sandbox, this address must be verified.
	define('RECIPIENT', $toName.'<'.$toMail.'>');
	
	// Replace us-west-2 with the AWS region you're using for Amazon SES.
	define('REGION','us-west-2');
	
	define('SUBJECT',$subject);
	define('BODY',$textContent);
	
	$request = array();
	$request['Source'] = SENDER;
	$request['Destination']['ToAddresses'] = array(RECIPIENT);
	$request['Message']['Subject']['Data'] = $subject;
	$request['Message']['Subject']['Charset'] = 'utf-8';
	$request['Message']['Body']['Html']['Data'] = BODY;
	$request['Message']['Body']['Html']['Charset'] = 'utf-8';
	//echo "<pre>".print_r($request)."</pre>";
	try{
		$result = $client->sendEmail($request);
	}catch (Exception $e) {
	
	}
 
 }
?>
<?php
require_once "dbconfig.php"; 
require_once "var.inc.php"; 
$connect=mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Cannot connect DB Server: " . mysqli_connect_error());
$GLOBALS['db_connect'] = $connect;

// Disable strict SQL modes for MySQL 8 compatibility with legacy queries
// ONLY_FULL_GROUP_BY - allows GROUP BY without all selected columns
// STRICT_TRANS_TABLES - allows INSERT without all required fields (uses defaults/empty)
// NO_ZERO_DATE - allows '0000-00-00' dates
mysqli_query($connect, "SET SESSION sql_mode='NO_ENGINE_SUBSTITUTION'");
//date_default_timezone_set('America/Los_Angeles');
date_default_timezone_set('America/New_York');

if(isset($_COOKIE['UserCookieName']) && $_COOKIE['UserCookieName']!='' ){	
	$userSql="Select username from user_table where user_id = ".mysqli_real_escape_string($connect, $_COOKIE['UserCookieName']);
	$userSqlRes = mysqli_query($connect, $userSql);
	$userSqlFetch = mysqli_fetch_array($userSqlRes);
	define("NewUserName",$userSqlFetch['username']);
	define("NewPassWord",$_COOKIE['UserCookiePass']);
	define("isFromCookie",1);
}else{
	define("NewUserName",'');
	define("NewPassWord",'');
	define("isFromCookie",'');
}

$sql = "SELECT * FROM ".CONFIG_TABLE."";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

//////////////    administration  information   //////////
$GLOBALS["metaKeywords"] = $row[SITE_GLOBAL_KEYWORDS];
$GLOBALS["metaDescription"] = $row[SITE_GLOBAL_DESCRIPTION];
define ("ADMIN_NAME", $row[CONFIG_ADMIN_NAME]);
define ("ADMIN_EMAIL_ADDRESS", $row[CONFIG_ADMIN_EMAIL]);

//////////////    Auction Settings   //////////

//define ("AUCTION_START_HOUR", $row[CONFIG_START_HOUR]);
//define ("AUCTION_START_MIN", $row[CONFIG_START_MIN]);
//define ("AUCTION_START_AM_PM", $row[CONFIG_START_AM_PM]);
if($row[CONFIG_START_AM_PM] == 'pm'){
	$start_time = ($row[CONFIG_START_HOUR]+12).":".$row[CONFIG_START_MIN].":00";
}else{
	$start_time = $row[CONFIG_START_HOUR].":".$row[CONFIG_START_MIN].":00";
}
define ("AUCTION_START_TIME", $start_time);

//define ("AUCTION_END_HOUR", $row[CONFIG_END_HOUR]);
//define ("AUCTION_END_MIN", $row[CONFIG_END_MIN]);
//define ("AUCTION_END_AM_PM", $row[CONFIG_END_AM_PM]);
if($row[CONFIG_END_AM_PM] == 'pm'){
	$end_time = ($row[CONFIG_END_HOUR]+12).":".$row[CONFIG_END_MIN].":00";
}else{
	$end_time = $row[CONFIG_END_HOUR].":".$row[CONFIG_END_MIN].":00";
}
define ("AUCTION_END_TIME", $end_time);

//define ("AUCTION_INCR_MIN_SPAN", $row[CONFIG_INCR_MIN_SPAN]);
//define ("AUCTION_INCR_SEC_SPAN", $row[CONFIG_INCR_SEC_SPAN]);
define ("AUCTION_INCR_TIME_SPAN", (($row[CONFIG_INCR_MIN_SPAN] * 60) + $row[CONFIG_INCR_SEC_SPAN]));

define ("AUCTION_INCR_BY_MIN", $row[CONFIG_INCR_BY_MIN]);
define ("AUCTION_INCR_BY_SEC", $row[CONFIG_INCR_BY_SEC]);
define ("AUCTION_INCR_ENDTIME_IN_SEC", (($row[CONFIG_INCR_BY_MIN] * 60) + $row[CONFIG_INCR_BY_SEC]));


/* Shipping Default Parameters Starts */

define ("PRODUCT_LENGTH", 36);
define ("PRODUCT_WIDTH", 24);
define ("PRODUCT_WEIGHT_ROLL", 2);
define ("PRODUCT_WEIGHT_FLAT", 1);
define ("PRODUCT_HEIGHT", 10);
define ("PRODUCT_GIRTH", 10);

define ("MPE_CHARGE_TO_SELLER", $row[MPE_CHARGE]);
define ("MPE_CHARGE_TO_SELLER_WEEKLY", $row[MPE_CHARGE_WEEKLY]);
define ("MPE_TRANSACTION_CHARGE_TO_SELLER", $row[MARCHANT_FEE]);

define ("SALE_TAX_GA", $row[CONFIG_SALE_TAX_GA]);
define ("SALE_TAX_NC", $row[CONFIG_SALE_TAX_NC]);

define ("PETER_EMAIL_ID", $row[PETER_EMAIL]);
define ("SEAN_EMAIL_ID", $row[SEAN_EMAIL]);

define ("BANNER_TITLE", $row['banner_title']);
define ("BANNER_LINK", $row['banner_link']);

define ("SHORT_TYPE", $row['short_type']);

/* Shipping Default Parameters Ends */

/* Admin Details Starts */
define ("ADMIN_BUY_NAME", 'Movie Poster Exchange');
define ("ADMIN_ADDRESS1", '221 E MAIN ST');
define ("ADMIN_CITY", 'GIBSONVILLE');
define ("ADMIN_STATE", 'NC');
define ("ADMIN_ZIP", '27249');
define ("ADMIN_COUNTRY", 'US');
/* Admin Details  End */

/* Paypal Details Starts */

define ("PAYPAL_ACCOUNT_ID", $row[CONFIG_ADMIN_EMAIL]);

define ("API_USERNAME", $row[CONFIG_PAYPAL_API_USERNAME]);
define ("API_PASSWORD", $row[CONFIG_PAYPAL_API_PASSWORD]);
define ("API_SIGNATURE", $row[CONFIG_PAYPAL_API_SIGNATURE]);
if($row[CONFIG_PAYPAL_IS_TEST_MODE] == '1'){
	define ("API_ENDPOINT", "https://api-3t.sandbox.paypal.com/nvp");
	define ("PAYPAL_URL", "https://www.sandbox.paypal.com/cgi-bin/webscr");
}else{
	define ("API_ENDPOINT", "https://api-3t.paypal.com/nvp");
	define ("PAYPAL_URL", "https://www.paypal.com/cgi-bin/webscr");
}
define ("SUBJECT","");
define ("VERSION", "65.1");
define ("CURRENCY_CODE", "USD");

define('USE_PROXY', FALSE);
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');

/* Paypal Detail Ends */




//////////////////////////////////////////////////////////


/////////    Different Variables   //////////////////////

define ("ADMIN_PAGE_TITLE", $row[CONFIG_ADMIN_PAGE_TITLE]);
define ("ADMIN_COPYRIGHT", $row[CONFIG_ADMIN_COPYRIGHT]); 
define ("ADMIN_WELCOMETEXT", $row[CONFIG_ADMIN_PAGE_WELCOMETEXT]);
define ("ADMIN_INSTRUCTION", nl2br($row[CONFIG_ADMIN_INSTRUCTION]));

////////////////////////////////////////////////////

//////////////////    Link Variables   //////////////////////

if (APP_ENV === 'production') {
	$cdnBase = getenv('CDN_STATIC_URL') ?: "https://d2m46dmzqzklm5.cloudfront.net";
	define ("IMAGE_LINK", $cdnBase."/images");
	define ("PAGE_LINK", "https://".$_SERVER['HTTP_HOST']);
	define ("PAGE_LINK_CSSJS", $cdnBase."/");
	define ("IMAGE_LINK_SSL", $cdnBase."/images");
	define ("PAGE_LINK_SSL", "https://".$_SERVER['HTTP_HOST']."");
	define ("PAGE_LINK_SSL_CSSJS", $cdnBase."/");
} else {
	define ("IMAGE_LINK", "http://".$_SERVER['HTTP_HOST']."/images");
	define ("PAGE_LINK", "http://".$_SERVER['HTTP_HOST']);
	define ("PAGE_LINK_CSSJS", "http://".$_SERVER['HTTP_HOST']."/");
	define ("IMAGE_LINK_SSL", "http://".$_SERVER['HTTP_HOST']."/images");
	define ("PAGE_LINK_SSL", "http://".$_SERVER['HTTP_HOST']."");
	define ("PAGE_LINK_SSL_CSSJS", "http://".$_SERVER['HTTP_HOST']."/");
}

define ("DOMAIN_PATH", "http://".$_SERVER['HTTP_HOST']."");
if(isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT']=='443'){
	define ("DOMAIN_PATH_NEW", "http://".$_SERVER['HTTP_HOST']."");
}else{
	define ("DOMAIN_PATH_NEW", "http://".$_SERVER['HTTP_HOST']."");
}
if (APP_ENV === 'production') {
	define ("ADMIN_IMAGE_LINK", "http://".$_SERVER['HTTP_HOST']."/mpe/admin_images");
	define ("ADMIN_PAGE_LINK", "http://".$_SERVER['HTTP_HOST']."/mpe/admin");
} else {
	define ("ADMIN_IMAGE_LINK", "http://".$_SERVER['HTTP_HOST']."/admin_images");
	define ("ADMIN_PAGE_LINK", "http://".$_SERVER['HTTP_HOST']."/admin");
}

define ("FULL_PATH", "http://www.movieposterexchange.com");


/*
 * CLOUD configuration
 */
define("CLOUD_API_USERNAME", getenv('CLOUD_API_USERNAME') ?: "mpexchange");
define("CLOUD_API_PASSWORD", getenv('CLOUD_API_PASSWORD') ?: "064276f5fdc0df2bb74addd027c71655"); 
define("CLOUD_STATIC_IMAGE_CONTAINER","cloud_mpe_static");

$currentPage = basename($_SERVER['PHP_SELF']);	
if($currentPage == "cart.php" || $currentPage == "my_invoice.php") {
	//header("Location: default.php");
	//exit;
	define("CLOUD_STATIC","https://d2m46dmzqzklm5.cloudfront.net/images/");
	define("CLOUD_STATIC_ADMIN","https://d2m46dmzqzklm5.cloudfront.net/images/");
}else{
	define("CLOUD_STATIC","https://d2m46dmzqzklm5.cloudfront.net/images/");
	define("CLOUD_STATIC_ADMIN","https://d2m46dmzqzklm5.cloudfront.net/images/");
}

define("CLOUD_POSTER_CONTAINER","cloud_mpe_poster_original");
define("CLOUD_POSTER_THUMB_CONTAINER","cloud_mpe_poster_thumbnail");
define("CLOUD_POSTER_THUMB_BUY_CONTAINER","cloud_mpe_poster_thumb_buy");
define("CLOUD_POSTER_THUMB_BUY_GALLERY_CONTAINER","cloud_mpe_poster_thumb_buy_gallery");
define("CLOUD_POSTER_THUMB_BIG_GALLERY_CONTAINER","cloud_mpe_big_slider");

if (APP_ENV === 'production') {
	define("CLOUD_POSTER","https://d2bqhgoagefnx4.cloudfront.net/");
	define("CLOUD_POSTER_THUMB","https://d2uggmgf6ym3vq.cloudfront.net/");
	define("CLOUD_POSTER_THUMB_BUY","https://d2k61xg10jbore.cloudfront.net/");
	define("CLOUD_POSTER_THUMB_BUY_GALLERY","https://d3bzuoa6jwdlat.cloudfront.net/");
	define("CLOUD_POSTER_THUMB_BIG_GALLERY","https://d1o27s03otm3kw.cloudfront.net/");
} else {
	$localBase = "http://" . $_SERVER['HTTP_HOST'] . "/";
	define("CLOUD_POSTER", $localBase . "poster_photo/");
	define("CLOUD_POSTER_THUMB", $localBase . "poster_photo/thumbnail/");
	define("CLOUD_POSTER_THUMB_BUY", $localBase . "poster_photo/thumb_buy/");
	define("CLOUD_POSTER_THUMB_BUY_GALLERY", $localBase . "poster_photo/thumb_buy_gallery/");
	define("CLOUD_POSTER_THUMB_BIG_GALLERY", $localBase . "poster_photo/thumb_big_slider/");
}

define("CLOUD_TEST_ORIGINAL","http://c15168198.r98.cf2.rackcdn.com/");
define("CLOUD_TEST_THUMBNAIL","http://c15168201.r1.cf2.rackcdn.com/");
define("CLOUD_TEST_THUMB_BUY_LIST","http://c15168207.r7.cf2.rackcdn.com/");
define("CLOUD_TEST_THUMB_BUY_GALLERY","http://c15168210.r10.cf2.rackcdn.com/");

/*
 * CLOUD configuration
 */

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
	
////////////////////////////////////////////////////////////////

define ("MAILCHIMP_API", getenv('MAILCHIMP_API') ?: "5bc53167c17cc6e93a5f6aac6912c50e-us2");



?>
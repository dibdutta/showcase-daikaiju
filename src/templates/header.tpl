
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>::Movie Poster Exchange::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  >
<meta name="description" content="{$metaDescription}" >
<meta name="keywords" content="{$metaKeywords}" >


<!-- round corner start here  -->
<!--<link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen" />-->

<!-- round corner ends here  -->


<link rel="shortcut icon" href="{$smarty.const.CLOUD_STATIC}favicon.ico" >

<!--<link href="https://c15123524.ssl.cf2.rackcdn.com/template_test.css" rel="stylesheet" type="text/css"/>-->


<link href="https://d2m46dmzqzklm5.cloudfront.net/css/style.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" type="text/css" href="{$smarty.const.DOMAIN_PATH}/javascript/slider/skins/tango/skin.css" />
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/tooltip/css/temp.css" media="screen" />-->
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/fonts.css" rel="stylesheet" type="text/css" />
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/template.css" rel="stylesheet" type="text/css" />

{if $smarty.const.PHP_SELF != '/myselling.php' && $smarty.const.PHP_SELF != '/edit_myauction.php'}
	<script src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery-1.10.2.js"></script>
	<script src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery-ui.js"></script>
{else}
	<script src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.min.js"></script>
{/if}
{* <script type="text/javascript" src="{$smarty.const.PAGE_LINK_SSL_CSSJS}/javascript/common.js.php"></script> *}
<script type="text/javascript" src="{$actualPath}/javascript/common.js.php"></script>
<link rel="stylesheet" href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery-ui.css">



{literal}
<script type="text/javascript">

function submitDetailsForm(){
    console.log("Inside submitDetailsForm123")
		$.ajax({
			url: 'auth.php',
			type: 'get',
			data: { username: $('#username').val(),password:$('#password').val(),mode:'process_login' },
			success: function(data) {
					   if(data=='2'){
					   	  window.location.href  = "buy.php?list=upcoming";
					   }else if (data=='1'){
					   	  window.location.href  = "buy.php?list=weekly";
					   }else if (data=='3'){
					   	  window.location.href  = "buy.php?list=weekly";
					   }else{
					   	 $("#error").text(data);
					   }
					 }
		});
	 }


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28956865-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = 'https://d2m46dmzqzklm5.cloudfront.net/js/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  function change_text(){
	  $('#login-panel').show();
	  //$('.signin-main-btn').css("color", "white");
	  
	}
  function return_text(){
	  //$('.signin-main-btn').css("color", "black");
	  hideLogIn();
	  }
function clear_text_for_poster(){
    if($("#search_for_poster").val()=='Search For Items by Title,Descriptions,Genre..'){
        $("#search_for_poster").val('');
    }
}
function check_session(){
    $.post('ajax.php', {mode : 'delete_session'}, function(){

    })
	var actualPath=' {/literal}{$actualPath}{literal}';
		$(location).attr('href',actualPath+'/register.php');
}
function refine_search(type,id){
    if(type=='decade'){
        $('#decade_id').val(id);
        $('#poster_size_id').val('');
        $('#genre_id').val('');
        $('#country_id').val('');
    }
    if(type=='poster_size'){
        $('#poster_size_id').val(id);
        $('#decade_id').val('');
        $('#genre_id').val('');
        $('#country_id').val('');
    }
    if(type=='country'){
        $('#poster_size_id').val('');
        $('#decade_id').val('');
        $('#genre_id').val('');
        $('#country_id').val(id);
    }
    if(type=='genre'){
        $('#poster_size_id').val('');
        $('#decade_id').val('');
        $('#genre_id').val(id);
        $('#country_id').val('');
    }
    $('#frm_refine').submit();
}
function hidelogin(){
		$('#login-modal-box').hide();
		$('#login-modal-overlay').hide();
	}
	function showLogIn(){
		$('#login-modal-overlay').show();
		$('#login-modal-box').show();
		$('#username').focus();
	}
	
</script>
<script type="text/javascript">
var idleTime = 0;
var idleInterval;
$(document).ready(function() { 
var checkcart = {/literal}{$totalCartCount};{literal}
//if(checkcart >0){
	//Increment the idle time counter every minute.
	idleInterval = setInterval("timerIncrement()", 240000); // 1 minute
	
	//Zero the idle timer on mouse movement.
	$(this).mousemove(function (e) {
		//resetTimer(); 
	});
	$(this).click(function (e) {
		//resetTimer();
	});
	$(this).keypress(function (e) {
		//resetTimer();
	});
//}
//else if(document.getElementById('landing_page') && $('#landing_page').val() == 'overview'){
	//window.clearInterval(idleInterval);
//}
});
function cancelWarning(){
	window.clearInterval(countdown_inactivity);
	counter = 30;
	resetTimer();
	$("#reset_warning").hide();
	$('#site_bg').hide();
	$("#timer").html(30);
	location.reload();
}
function acceptWarning(){
	var url='{/literal}/ajax.php{literal}';
	$.post(url, {mode:"logoutInactiveUser" }, function(data){
		$("#reset_warning").hide();	
		window.location.href = "index.php";	
	})
	
}
function timerIncrement() {
	var userId = '{/literal}{$smarty.session.sessUserID}{literal}'; 
    idleTime = idleTime + 1;
	
    if (idleTime >= 5) { // 2 minutes
        idleTime = 0;
		$('#site_bg').height($(document).height());
		$('#site_bg').width($(document).width());
		if(userId!=''){
			$('#site_bg').show();
			$("#reset_warning").show();
		}
		showTimer();
    }
}
var countdown_inactivity;
var counter_inactivity = 30;
function showTimer(){
  if(document.getElementById('timer')){
	  
	  countdown_inactivity = setInterval(function(){
		if(counter_inactivity>=0) $("#timer").html(counter_inactivity);
		if (counter_inactivity == 0) {
			$("#reset_warning").hide();
			//reset first
			$("#timer").remove();
			clearInterval(countdown_inactivity); //clear the count down
			idleTime = 0; //user is movie to overview page, reset the idle time
			$("#reset_warning").hide();// hide pop up
			$('#site_bg').hide();//hide site bg
			//redirect to over view page
			acceptWarning();
		}
		counter_inactivity--;
	  }, 1000);
  }
}
function resetTimer(){
	window.clearInterval(idleInterval); // stop 
	idleTime = 0;//reset the idle time
	idleInterval = setInterval("timerIncrement()", 6000); // 1 minute, start from now
}
</script>

<script type="text/javascript">
var idleTime1 = 0;
var idleInterval1;
function  go_to_sold(list,id){
	//Increment the idle time counter every minute.
	timerIncrement1(list,id);
	//idleInterval1 = setInterval("timerIncrement1("+list+","+id+")", 60000); // 1 minute
}
function acceptWarning1(list,id){

  var type ;
  if(list==2){
  	type='weekly';
  }else if(list==5){
  	type='stills';
  }
		//window.location.href = "sold_item.php?mode=search_sold_"+type+"&auction_week="+id;

        $.ajax({
            url: 'http://localhost/mpe/ajax.php?mode=update_exetended_items_endtime&id='+id,
            type: 'GET',
            //data: "mode=update_exetended_items_endtime&id="+id,
            success: function(response) {
                window.location.href = "buy.php?list=extended";
            }
        });
}
function timerIncrement1(list,id) {
    idleTime1 = idleTime1 + 1;
    var type= {/literal}'{$smarty.request.list}'{literal}
    if (idleTime1 >= 1 && type!="extended") { // 2 minutes
        idleTime1 = 0;
		$('#site_bg1').height($(document).height());
		$('#site_bg1').width($(document).width());
		$('#site_bg1').show();
		$("#reset_warning1").show();
		showTimer1(list,id);
    }
}
var countdown;
var counter = 1500;
function showTimer1(list,id){
  if(document.getElementById('timer1')){
	  
	  countdown = setInterval(function(){
	  $.get('http://localhost/mpe/ajax.php?mode=chk_auction_week&week_id='+id, function(data) {
	   if(data=='1'){
		 acceptWarning1(list,id);
		}
	  });
	  }, 1500);
  }
}
</script>
{/literal}
 <!-- sign in popup  -->
    <link rel="stylesheet" type="text/css" href="https://d2m46dmzqzklm5.cloudfront.net/css/dddropdownpanel.css" />

</head>
<body>
<div id="main-wrapper">
<!--Page Starts-->
<div id="page">
 	<div id="header-wrapper">
    <!--Header Starts-->
     <div id="header">
	  <form name="frm_refine" id="frm_refine" method="get" action="{$actualPath}/buy.php">
                <input type="hidden" name="mode" value="search" />
                <input type="hidden" name="poster_size_id" id="poster_size_id" value="{$smarty.request.poster_size_id}" />
                <input type="hidden" name="genre_id" id="genre_id" value="{$smarty.request.genre_id}" />
                <input type="hidden" name="decade_id" id="decade_id" value="{$smarty.request.decade_id}" />
                <input type="hidden" name="country_id" id="country_id" value="{$smarty.request.country_id}" />
                {if $smarty.request.mode!='refinesrcStills'}
                  <input type="hidden" name="list" id="list" value="{$smarty.request.list}" />
				{else} 
				  <input type="hidden" name="list" id="list" value="stills" />
				{/if}
				<input type="hidden" name="is_expired" value="{$is_expired}" />
				<input type="hidden" name="is_expired_stills" id="is_expired_stills" value="{$is_expired_stills}" />
				<input type="hidden" name="auction_week_id" value="{$smarty.request.auction_week_id}" />
         </form>
         <!--<div class="banner">
             <a href="{$smarty.const.BANNER_LINK}" class="bannertxt" style="float:left;" title="Movie Poster Exchange" id="banner">{$smarty.const.BANNER_TITLE}</a>
             <a href="http://www.gavelsnipe.com" target="_blank" style=""><img src="{$smarty.const.CLOUD_STATIC}banner2.png" alt="Gavelsnipe" title="Gavelsnipe"/></a>
         </div>-->
         {*<div style="position:absolute; left:167px; top:90px; background:#fff; height:15px;color:red;">
		 <label>The site will be under maintainance for three(3) Hrs.sorry for the inconvenience caused</label>
		 </div>*}
        <div id="logopanel" style="width:165px; min-height:93px; display:flex; align-items:center; justify-content:center;"><a href="{$actualPath}/index.php" title="Movie Poster Exchange"><img src="https://img1.wsimg.com/isteam/ip/92d26c02-334b-45d8-a4c8-8d3a1ef3f97b/logo/3bb4d422-bdd7-43a5-8462-a3f81cde183b.png/:/rs=w:98,h:80,cg:true,m/cr=w:98,h:80/qt=q:95" alt="Movie Poster Exchange" title="Movie Poster Exchange" width="98" height="80"/></a></div>
        <!--Header Top navigation Starts-->
        <div id="mainnavigation" class="innerbg">
          <ul class="menu">
                <li {if $smarty.const.PHP_SELF == '' || $smarty.const.PHP_SELF == '/index.php'}class="active homeover"{/if}><a href="{$actualPath}/index.php" title="HOME"><span>HOME</span></a></li>
                <li {if $smarty.request.list == 'weekly' || $smarty.request.list == 'extended'}class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly" title="BUY"><span>AUCTIONS</span></a></li>
                <li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy.php?list=fixed" title="POSTER SHOP"><span>POSTER SHOP</span></a></li>
                <li {if $smarty.const.PHP_SELF == '/sell.php'}class="active"{/if}><a href="{$actualPath}/sell.php" title="SELL"><span>SELL</span></a></li>
                <li {if $smarty.const.PHP_SELF == '/faq.php'}class="active"{/if}><a href="{$actualPath}/faq.php" title="FAQ"><span>FAQ</a></span></li>
                <li {if $smarty.const.PHP_SELF == '/contactus.php'}class="active"{/if}><a href="{$actualPath}/contactus.php" title="CONTACT"><span>CONTACT</span></a></li>
                <li  ><a href="{$actualPath}/sold_item.php" title="SOLD ITEMS ARCHIVE"><span style="color:#CC0000;">SOLD ITEMS ARCHIVE</span></a></li></li>
              </ul>
              
         
           </div>    
          <!-- ADD THIS ICON -->   
          
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <!-- FACEBOOK  -->
         <!-- <a class="facebooklike" title="Like MoviePosterExchange on Facebook" href="https://www.facebook.com/pages/MoviePosterExchangecom/105014962910848" target="_blank">
          <img src="{$smarty.const.CLOUD_STATIC}icon_facebook.jpg" alt="" /></a>-->
          <!-- FACEBOOK -->
          
          <!-- TWITTER -->
         <!-- <a class="btn" target="_blank" id="follow-button" title="Follow @MoviePosterExch on Twitter" href="https://twitter.com/intent/follow?original_referer=http%3A%2F%2Fwww.movieposterexchange.com%2Findex.php&amp;region=follow_link&amp;screen_name=MoviePosterExch&amp;source=followbutton&amp;variant=2.0">
          <img src="{$smarty.const.CLOUD_STATIC}icon_twitter.jpg" alt="" /></a>-->
          <!-- TWITTER -->
          
          
          
        </div>
        <!--Search Panel Starts-->
        
        <div id="searchbar">
        <!--<div class="search-left-bg"></div>-->
            <div class="search-midrept-bg ">
                <label><img src="https://d2m46dmzqzklm5.cloudfront.net/images/search-img.png" width="20" height="37" /></label>
                <form name="frm_keysearch" method="get" action="{$actualPath}/buy.php">
                    <!--<input type="hidden" name="list" value="{$smarty.request.list}" class="srchbox-txt" />-->
                     <input type="hidden" name="mode" {if $smarty.request.list!='upcoming'} value="key_search_global"{else} value="key_search_upcoming"{/if} class="srchbox-txt" />
					<input type="hidden" name="is_expired" value="{$is_expired}"  />
					<input type="hidden" name="is_expired_stills" id="is_expired_stills" value="{$is_expired_stills}" />
					<input type="hidden" name="auction_week_id" value="{$smarty.request.auction_week_id}" />
                    <input type="text" name="keyword"  id="search_for_poster" class="srchbox-txt"  {if $smarty.request.mode == 'key_search_global' || $smarty.request.mode == 'key_search_upcoming' || $smarty.request.mode == 'key_search_stills'} value="{$smarty.request.keyword}"{else} value="Search For Items by Title,Descriptions,Genre.."  {/if} onclick="clear_text_for_poster();" />
                    <!--<div style="float:left;"><img src="{$smarty.const.CLOUD_STATIC}search_right_crn.png" width="11" height="35" /></div>-->
                    <!--<div class="styled-select">
                        <select name="search_type" >
                            <option value="title" {if $smarty.request.search_type=='title'}selected="selected" {/if}>Poster Titles</option>
                            <option value="title_desc" {if $smarty.request.search_type=='title_desc'}selected="selected" {/if}>Poster Descriptions</option>
							<option value="stills" {if $smarty.request.search_type=='stills'}selected="selected" {/if}>Photo Titles</option>
                            <option value="stills_desc" {if $smarty.request.search_type=='stills_desc'}selected="selected" {/if}>Photo Descriptions</option>
                        </select>
                    </div>-->
                    <input type="submit" value="" class="srchbtn-main" />
                </form>
                
				{if $smarty.request.list != 'stills' && $smarty.request.mode != 'refinesrcStills'}
					<input type="button" value="" class="refine-srchbtn-main" onclick="$(location).attr('href', '{$actualPath}/buy.php?mode=refinesrc&list={$smarty.request.list}&auction_week_id={$smarty.request.auction_week_id}');" />
				{else}
				    <input type="button" value="" class="refine-srchbtn-main" onclick="$(location).attr('href', '{$actualPath}/buy.php?mode=refinesrcStills');" />
				{/if}
            </div>
       
        <!--<div class="search-right-bg"></div>-->
        <!-- Mailchimp Stars -->
       {if $smarty.session.sessUserID == ''}
    	<div class="fll pl122">
        
         <ul>
        <li>
		<div id="mypanel" class="ddpanel" style="margin-top:16px;">
<div id="mypaneltab" class="ddpaneltab">
<a href="javascript:void(0);" onclick="showLogIn();"><span>Sign In</span></a>
</div>
</div>
         
        <div class="dropdown_2columns"><!-- Begin 2 columns container -->
    
            <div class="col_2">
                <h2>Members Login</h2>
            </div>
    
            <div class="col_2">
			   <form name="frmlogin" id="frmlogin" method="post" action="auth.php">
            	<input type="hidden" name="mode" value="process_login" />
                <table width="120" border="0" cellspacing="2" cellpadding="0">
				 <tr>
				 <td><div id="loginmsg" class="login-err" style="display:none;"></div></td>
				 </tr>
				  <tr>
					<td>
					<input type="text" id="username" name="username" {if $smarty.const.NewUserName!=''} value="{$smarty.const.NewUserName}" {/if} class="w170 required" />
					</td>
				  </tr>
				  <tr>
					<td>					
					<input type="password" id="password" name="password" {if $smarty.const.NewPassWord!=''} value="{$smarty.const.NewPassWord}" {/if} class="w170 required"  style="font-size:10px;" />
					</td>
				  </tr>
				  <tr>
					<td><input type="submit" class="login-blue-btn" value="Login" id="submit" name="submit">
									   </td>
				  </tr>
				  <tr>
					<td> <a href="{$actualPath}/forget_password.php">Forgot password</a></td>
				  </tr>
				</table>
              </form>
            </div>
    
            
          
        </div><!-- End 2 columns container -->
    
    </li>
    </ul>  
    	 </div>
        
        <div class="w02 fll pt14"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w60 fll pt18 pl14 scart"><a href="javascript:void(0)" onclick="check_session()">Join Us</a></div>
		{elseif $smarty.session.sessUserID != ''}
        <div class="w60 fll pt07 pl122">
		<ul id="menu"> 
     <li class="menu_right"><a href="#" class="drop"> User Panel<!--Welcome {$smarty.session.sessUsername}!--></a>
         <div class="dropdown_4columns align_right"><!-- Begin 2 columns container -->
    
            <div class="col_1">
            
                <h3>MY BUYING</h3>
                <ul>
                   <li><a href="{$actualPath}/my_bid.php" >My Active Bids</a></li>
                    <li><a  href="{$actualPath}/offers.php">My Outgoing Offers&nbsp;&nbsp;({$totalUnReadOutgoingOffer})</a></li>
                    <li><a  href="{$actualPath}/offers.php?mode=incoming_counters" {if $totalUnReadIncomingCounters > 0} style="color:#FF4E09;" {/if}>My Incoming Counters&nbsp;&nbsp;({$totalUnReadIncomingCounters})</a></li>
                    <li><a  href="{$actualPath}/my_bid.php?mode=closed">My Closed Items</a></li>
                    <li><a  href="{$actualPath}/user_watching.php">Watch List&nbsp;&nbsp;({$count_watching})</a></li>
                </ul>   
                 
            </div>
    
            <div class="col_1">
            
                <h3>MY SELLING</h3>
                <ul>
                    <li><a  href="{$actualPath}/myselling.php?mode=fixed">Manual Upload</a></li>
                    <!--<li><a  href="{$actualPath}/myselling.php?mode=bulkupload">Bulk Upload</a></li>-->
                    <li><a  href="{$actualPath}/myselling.php?mode=selling">Selling (Auction Items)</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=fixed_selling">Selling (Fixed Items)</a></li>
                    <li><a  href="{$actualPath}/offers.php?mode=incoming_offers" {if $totalUnReadIncomingOffers > 0} style="color:#FF4E09;" {/if} >My Incoming Offers&nbsp;&nbsp;({$totalUnReadIncomingOffers})</a></li>
                    <li><a  href="{$actualPath}/offers.php?mode=outgoing_counters">My Outgoing&nbsp;&nbsp; Counters({$totalUnReadOutgoingCounters})</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=pending">Pending</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=sold">Sold</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=upcoming">Upcoming</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=unsold">Unsold/Closed</a></li>
					<li><a  href="{$actualPath}/myselling.php?mode=unpaid">Sale Pending</a></li>
                </ul>   
                 
            </div>
    
            <div class="col_1">
            
                <h3>MY ACCOUNT</h3>
                <ul>
                    <li><a  href="{$actualPath}/myaccount.php">My Account / Dashboard</a></li>
                    <li><a  href="{$actualPath}/myaccount.php?mode=profile">Profile</a></li>
                    {*<li><a  href="{$actualPath}/send_message.php">Messages&nbsp;&nbsp;({$countMsg}) </a></li>*}
                    <li><a  href="{$actualPath}/my_want_list.php">My Want List&nbsp;&nbsp;({$total_want_count})</a></li>
                    <li><a  href="{$actualPath}/my_invoice.php">Invoices/Reconciliation</a></li>
					<li><a  href="{$actualPath}/my_report.php">Reports</a></li>
					<li><a  href="{$actualPath}/myaccount.php?mode=change_password">Change Password</a></li>
                </ul>   
                 
            </div>
    
            
        </div><!-- End 4 columns container -->
</li> 
      </ul>  
    	 </div>
         <div class="w02 fll pt14"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w60 fll pt18 pl14 scart"><a href="javascript:void(0)" onclick="$(location).attr('href','{$actualPath}/myaccount.php?mode=logout');">Sign Out</a></div>
		{/if}
        <div class="w02 fll pt14"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w24 fll pt18 pl14"><a href="{$actualPath}/cart.php"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/cart1-icon.png" width="24" height="15" /></a></div>
    	<div class="w24 fll pt18 pl14 scart">({if $smarty.session.cart}{$smarty.session.cart|@count}{else}0{/if})</div>
       
    	  
	</div> 
    
        	<div class="clb fll">
            <div id="mainnav" style="z-index:100000; width:995px;" >
        <ul style="margin-left:8px; width:972px;">
		{if $smarty.request.list!='stills' && $smarty.request.mode!='refinesrcStills'}
        	<li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left;" >CATEGORY / GENRE</a>
                    <div>
                    
                        <ul style="z-index:100000;" id="selector_box">
						{section name=counter loop=$rightPanelCatRows}
						{if $rightPanelCatRows[counter].fk_cat_type_id==2 && $rightPanelCatRows[counter].is_stills==0}
						<li ><a href="javascript:void(0);" onclick="refine_search('genre',{$rightPanelCatRows[counter].cat_id})">{$rightPanelCatRows[counter].cat_value}</a>
						</li>
						{/if}
            			{/section} 
                        
                       
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        	<li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Search All Sizes</a>
                    <div>
                        <ul style="z-index:100000;" id="selector_box">
                       {section name=counter loop=$rightPanelCatRows}
						{if $rightPanelCatRows[counter].fk_cat_type_id==1 && $rightPanelCatRows[counter].cat_id !='34'}
						<li ><a href="javascript:void(0);" onclick="refine_search('poster_size',{$rightPanelCatRows[counter].cat_id})">{$rightPanelCatRows[counter].cat_value|escape:'html'}</a>
						
						</li>
						{/if} 
						{/section} 
                        </ul>
                     </div>
                    </div>
                </div>
            </div>
        </li>
        	<li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Search all Decades</a>
                    <div>
                        <ul style="z-index:100000;" id="selector_box">
                        {section name=counter loop=$rightPanelCatRows}
							{if $rightPanelCatRows[counter].fk_cat_type_id==3}
							<li ><a href="javascript:void(0);" onclick="refine_search('decade',{$rightPanelCatRows[counter].cat_id})">{$rightPanelCatRows[counter].cat_value|escape:'html'}</a>
							</li>
							{/if} 
						{/section} 
                        </ul>
                    </div>    
                    </div>
                </div>
            </div>
        </li>
		
        	<li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Search Countries</a>
                    <div>
                        <ul style="z-index:100000;" id="selector_box">
                        {section name=counter loop=$rightPanelCatRows}
						{if $rightPanelCatRows[counter].fk_cat_type_id==4}
						<li ><a href="javascript:void(0);" onclick="refine_search('country',{$rightPanelCatRows[counter].cat_id})">{$rightPanelCatRows[counter].cat_value}</a>					
						</li>
						{/if}
					{/section} 
                        </ul>
                    </div>    
                    </div>
                </div>
            </div>
        </li>
		{else}
			<li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Search Genre/Category</a>
                    <div>
                        <ul style="z-index:100000;" id="selector_box">
						{section name=counter loop=$rightPanelCatRows}
						{if $rightPanelCatRows[counter].fk_cat_type_id==2}
						<li ><a href="javascript:void(0);" onclick="refine_search('genre',{$rightPanelCatRows[counter].cat_id})">{$rightPanelCatRows[counter].cat_value}</a>
						</li>
						{/if}
            			{/section} 
                        </ul>
                        </div>    
                    </div>
                </div>
            </div>
          </li>
		{/if}
        <li class="pr10 mr10 flr">
            <div class="features_menu_column2">
                <div class="features_selector2">
                    <div class="trigger" id="trg">
                    
                    <div>
						<!-- GOOGLE TRANSLATOR --> 
          <div id="google_translate_element" style="border:0;"></div>
          {literal}
          <script>
			function googleTranslateElementInit() {
			  new google.translate.TranslateElement({
			    pageLanguage: 'en',
			    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			  }, 'google_translate_element');
			}
		 </script>
		<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		{/literal}
          <!-- GOOGLE TRANSLATOR -->

                    </div>    
                    </div>
                </div>
            </div>
        </li>



        </ul>
        
        </div>
        
          </div>
    
    
    
    	<!-- Mailchimp Ends -->
    	</div>
    	<!--Search Panel Starts-->
    	
        <!--Header Top navigation Ends-->
          
       
        
        
     <!-- </div>
	Header Ends
	</div>-->
  </div>
  <div style="background-color:#484747; position:absolute; z-index:1000001; width:1600px; height:800px;top:0%; left:0; opacity:.5; filter:alpha(opacity=50); display:none" id="site_bg"></div>
<div style="z-index:1000001; border:4px solid #D9D8D6; position:absolute; top:10%; left:32%; background-color:#FFF; width:400px; padding:5px; display:none" id="reset_warning">
   	<div style="font-size:20px; border-bottom:1px solid #9DA09F">Reset Warning</div>
	<div style="height:20px; text-align:center; padding:10px 0px; font-size:14px;">Due to Inactivity the system will reset in <span id="timer">30</span> seconds</div>
    <div align="right">	
   	 <input type="button" value="OK" class="button" onclick="acceptWarning();" />&nbsp; <input type="button" value="Cancel" class="button" onclick="cancelWarning();" />
    </div>
</div>

<div style="background-color:#484747; position:absolute; z-index:1000002; width:1600px; height:800px;top:0%; left:0; opacity:.5; filter:alpha(opacity=50); display:none" id="site_bg1"></div>
<div style="z-index:1000021; border:4px solid #881319; position:fixed;background-color:#FFFFFF; color:#OOO; width:700px; height:80px; padding:10px 20px; display:none;top: 50%; left: 50%; margin-top: -100px; margin-left: -250px;" id="reset_warning1">
   	
	<div style="height:20px; text-align:center; padding:10px 0px; font-size:14px;">EXTENDED BIDDING SESSION STARTING NOW.<br/>
                                                                                  In this session a new bid placed will restart the countdown timer to 5 minutes. Thank you for bidding and good luck!<br/>
    <img  src="https://d2m46dmzqzklm5.cloudfront.net/images/auctionendshow.gif"/><span id="timer1" style="display:none;">30</span>
    </div>
    <div align="right">
    </div>
</div>
<!--Page Ends-->
{if $smarty.const.PHP_SELF != '/buy.php' && $smarty.const.PHP_SELF != '/user_watching.php'}
    <script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery-validate.js"></script>
{/if}
<div id="dialog-confirm" >
</div>

<!-- Login Modal Overlay -->
<div id="login-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:200000;" onclick="hidelogin();"></div>
<!-- Login Modal -->
<div id="login-modal-box" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:200001; background:#fff; border-radius:8px; box-shadow:0 4px 24px rgba(0,0,0,0.3); padding:32px 36px 24px; width:380px; max-width:90vw; height:auto; overflow:visible;">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="margin:0; font-size:22px; color:#333; font-weight:600;">Member's Login</h2>
    <span onclick="hidelogin();" style="cursor:pointer; font-size:28px; color:#999; line-height:1; padding:0 4px;">&times;</span>
  </div>
  <form name="frmlogin" id="frmlogin" method="post" action="auth.php">
    <input type="hidden" name="mode" value="process_login" />
    <div id="error" style="color:red; margin-bottom:8px;"></div>
    <div id="log-in-popup-text" style="color:#555; margin-bottom:12px; font-size:14px;"></div>
    <div style="margin-bottom:16px;">
      <label for="username" style="display:block; margin-bottom:6px; font-size:14px; font-weight:600; color:#555;">Username</label>
      <input type="text" id="username" name="username" {if $smarty.const.NewUserName!=''} value="{$smarty.const.NewUserName}" {/if} class="required" placeholder="Enter your username" style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:4px; font-size:14px; box-sizing:border-box;" />
    </div>
    <div style="margin-bottom:20px;">
      <label for="password" style="display:block; margin-bottom:6px; font-size:14px; font-weight:600; color:#555;">Password</label>
      <input type="password" id="password" name="password" {if $smarty.const.NewPassWord!=''} value="{$smarty.const.NewPassWord}" {/if} class="required" placeholder="Enter your password" style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:4px; font-size:14px; box-sizing:border-box;" onfocus="{literal}$(this).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){ submitDetailsForm(); }
      }); {/literal}" />
    </div>
    <div style="margin-bottom:16px;">
      <input type="button" value="LOGIN" id="submitButton" name="submit" onclick="submitDetailsForm()" style="width:100%; padding:10px; background:#cc0000; color:#fff; border:none; border-radius:4px; font-size:15px; font-weight:600; cursor:pointer; letter-spacing:1px;" />
    </div>
    <div style="text-align:center; padding-bottom:8px;">
      <a href="{$actualPath}/forget_password.php" style="color:#cc0000; font-size:13px; text-decoration:none;">Forgot password?</a>
    </div>
  </form>
</div>

</body>
</html>
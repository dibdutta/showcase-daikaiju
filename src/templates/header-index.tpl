
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>::{$smarty.const.SITE_TITLE}::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  >
<meta name="description" content="{$metaDescription}" >
<meta name="keywords" content="{$metaKeywords}" >


<!-- round corner start here  -->
<!--<link rel="stylesheet" href="{$actualPath}/css/menu.css" type="text/css" media="screen" />
-->
<!-- round corner ends here  -->
<link rel="shortcut icon" href="https://img1.wsimg.com/isteam/ip/92d26c02-334b-45d8-a4c8-8d3a1ef3f97b/favicon/111624e5-c88b-4ca0-8e89-53a48821379c.jpg/:/rs=w:24,h:24,m" >

<!-- Merged CSS: style.css + fonts.css + jquery-ui.css + template.css + glob.css + dddropdownpanel.css -->
<link href="{$actualPath}/css/site.css" rel="stylesheet" type="text/css" />




{* <script type="text/javascript" src="{$smarty.const.PAGE_LINK_SSL_CSSJS}/javascript/common.js.php"></script> *}
<script type="text/javascript" src="{$actualPath}/javascript/common.js.php"></script>


 <!-- Photogallery script  -->

	<script src="https://d294w6g1afjpvs.cloudfront.net/js/jquery.min.js"></script>
	<script src="https://d294w6g1afjpvs.cloudfront.net/js/slides.jquery.js"></script>
    
    {literal}
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: '{/literal}{$actualPath}{literal}/javascript/Slides-SlidesJS-1/examples/images-with-captions/img/loading.gif',
				play: 1800,
				pause: 1500,
				hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
		
	function submitDetailsForm(){
        console.log("Inside submitDetailsForm");
        console.log("Username:", $('#username').val());
        console.log("Password:", $('#password').val() ? '***' : 'empty');
		$.ajax({
			url: 'auth',
			type: 'get',
			data: { username: $('#username').val(),password:$('#password').val(),mode:'process_login' },
			success: function(data) {
					   console.log("AJAX success, data:", data);
					   if(data=='2'){
					   	  window.location.href  = "buy?list=upcoming";
					   }else if (data=='1'){
					   	  window.location.href  = "buy?list=weekly";
					   }else if (data=='3'){
					   	  window.location.href  = "buy?list=weekly";
					   }else{
					   	 $("#error").text(data);
					   }
					 },
			error: function(xhr, status, error) {
					   console.log("AJAX error:", status, error);
					   console.log("Response:", xhr.responseText);
					 }
		});
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
	var subcatData = {/literal}{$subcatJson|default:'{}'}{literal};
	function populateSubcatNav(shopCatId) {
		var list = document.getElementById('subcat-nav-list');
		if (!list) return;
		var subcats = subcatData[shopCatId] || [];
		list.innerHTML = '<li><a href="javascript:void(0);" onclick="$(\"#subcategory_id\").val(\"\");$(\"#frm_refine\").submit();">All Subcategories</a></li>';
		subcats.forEach(function(sc) {
			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = 'javascript:void(0);';
			a.textContent = sc.subcat_value;
			a.onclick = (function(sid) { return function() { $('#subcategory_id').val(sid); $('#frm_refine').submit(); }; })(sc.subcat_id);
			li.appendChild(a); list.appendChild(li);
		});
	}
	function refine_search(type,id){
		if(type=='decade'){
			$('#decade_id').val(id);
			$('#country_id').val('');
			$('#shop_cat_id').val('');
			$('#subcategory_id').val('');
		}
		if(type=='country'){
			$('#decade_id').val('');
			$('#country_id').val(id);
			$('#shop_cat_id').val('');
			$('#subcategory_id').val('');
		}
		if(type=='shop_cat'){
			$('#shop_cat_id').val(id);
			$('#subcategory_id').val('');
			$('#decade_id').val('');
			$('#country_id').val('');
		}
		$('#frm_refine').submit();
	}
	$(document).ready(function() {
		var currentShopCat = $('#shop_cat_id').val();
		if (currentShopCat) { populateSubcatNav(currentShopCat); }
	});
 	function check_session(){
    $.post('ajax', {mode : 'delete_session'}, function(){

    })
	var actualPath=' {/literal}{$actualPath}{literal}';
		$(location).attr('href',actualPath+'/register');
}
  function clear_text_for_poster(){
    if($("#search_for_poster").val()=='Search For Items by Title,Descriptions,Genre..'){
        $("#search_for_poster").val('');
    }
}
	</script>
    {/literal}


    <!-- Featured Item slider script  -->
    
    
    <!-- sign in popup  -->
	
    
    
    

</head>
<body >

<!--Page Starts-->
<div id="page">
 	<div id="header-wrapper">
    <!--Header Starts-->
     <div id="header">
	  <form name="frm_refine" id="frm_refine" method="get" action="{$actualPath}/buy">
                <input type="hidden" name="mode" value="search" />
                <input type="hidden" name="decade_id" id="decade_id" value="{$smarty.request.decade_id}" />
                <input type="hidden" name="country_id" id="country_id" value="{$smarty.request.country_id}" />
                <input type="hidden" name="shop_cat_id" id="shop_cat_id" value="{$smarty.request.shop_cat_id}" />
                <input type="hidden" name="subcategory_id" id="subcategory_id" value="{$smarty.request.subcategory_id}" />
                {if $smarty.request.mode!='refinesrcStills'}
                  <input type="hidden" name="list" id="list" value="{$smarty.request.list}" />
				{else} 
				  <input type="hidden" name="list" id="list" value="stills" />
				{/if}
				<input type="hidden" name="is_expired" value="{$is_expired}" />
         </form>
         {*<div style="position:absolute; left:167px; top:90px; background:#fff; height:15px;color:red;">
		 <label>The site will be under maintainance for three(3) Hrs.sorry for the inconvenience caused</label>
		 </div>*}
        <div id="logopanel" style="width:165px; min-height:93px; display:flex; align-items:center; justify-content:center;"><a href="{$actualPath}/index" title="Home"><picture><source srcset="https://d294w6g1afjpvs.cloudfront.net/images/kaiju_link_1x.webp 1x, https://d294w6g1afjpvs.cloudfront.net/images/kaiju_link_2x.webp 2x" type="image/webp" /><img src="https://img1.wsimg.com/isteam/ip/92d26c02-334b-45d8-a4c8-8d3a1ef3f97b/logo/3bb4d422-bdd7-43a5-8462-a3f81cde183b.png/:/rs=w:98,h:80,cg:true,m/cr=w:98,h:80/qt=q:95" alt="Logo" title="Home" width="98" height="80" /></picture></a></div>
        <!--Header Top navigation Starts-->
        <div id="mainnavigation" class="innerbg">
          <ul class="menu">
                <li {if $smarty.const.PHP_SELF == '' || $smarty.const.PHP_SELF == '/index.php'}class="active homeover"{/if}><a href="{$actualPath}/index" title="HOME"><span>HOME</span></a></li>
                <li {if $smarty.request.list == 'weekly' || $smarty.request.list == 'extended'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly" title="BUY"><span>AUCTIONS</span></a></li>
                <li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy?list=fixed" title="SHOP NOW"><span>SHOP NOW</span></a></li>
                <li {if $smarty.const.PHP_SELF == '/sell.php'}class="active"{/if}><a href="{$actualPath}/sell" title="SELL"><span>SELL</span></a></li>
                <li {if $smarty.const.PHP_SELF == '/faq.php'}class="active"{/if}><a href="{$actualPath}/faq" title="FAQ"><span>FAQ</span></a></li>
                <li {if $smarty.const.PHP_SELF == '/contactus.php'}class="active"{/if}><a href="{$actualPath}/contactus" title="CONTACT"><span>CONTACT</span></a></li>
                <li  ><a href="{$actualPath}/sold_item" title="SOLD ITEMS ARCHIVE"><span style="color:#CC0000;">SOLD ITEMS ARCHIVE</span></a></li>
              </ul>
              
         
           </div>    
          <!-- ADD THIS ICON -->   
          
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          
          
          
        </div>
        <!--Search Panel Starts-->
        
        <div id="searchbar" style="background:#003878; width:100%; box-sizing:border-box;">
            <div class="search-midrept-bg ">
                <label><img src="https://d294w6g1afjpvs.cloudfront.net/images/search-img.png" width="20" height="37" /></label>
                <form name="frm_keysearch" method="get" action="{$actualPath}/buy">
                    <input type="hidden" name="list" value="{$smarty.request.list}" class="srchbox-txt" />
                    <input type="hidden" name="mode" value="key_search_global" class="srchbox-txt" />
					<input type="hidden" name="is_expired" value="{$is_expired}"  />
                    <input type="text" name="keyword"  id="search_for_poster" class="srchbox-txt"  {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}"{else} value="Search For Items by Title,Descriptions,Genre.." {/if} onclick="clear_text_for_poster();" />
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
                <input type="button" value="" class="refine-srchbtn-main" onclick="$(location).attr('href', '{$actualPath}/buy?mode=refinesrc');" />
            </div>
       
        <!--<div class="search-right-bg"></div>-->
        <!-- Mailchimp Stars -->
       {if $smarty.session.sessUserID == ''}
    	<div class="fll pl122">
        
         <ul>
        <li><!--<a href="javascript:void(0);" class="drop" onclick="showlogin();" ><img src="{$actualPath}/images/signin.png" width="60" height="37" />-->
        <div id="mypanel" class="ddpanel" style="margin-top:16px;">
<div id="mypaneltab" class="ddpaneltab">
<div class="pcontent"></div>
<a href="javascript:void(0);" onclick="showLogIn();"><span>Sign In</span></a>
</div>
</div><!-- Begin Home Item -->
         
        <div ><!-- Begin 2 columns container -->
    
    
            &nbsp;
    
            
          
        </div><!-- End 2 columns container -->
    
    </li>
    </ul>  
    	 </div>
        
        <div class="w02 fll pt14"><img src="https://d294w6g1afjpvs.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w60 fll pt18 pl14 scart"><a href="javascript:void(0)" onclick="check_session()">Join Us</a></div>
		{elseif $smarty.session.sessUserID != ''}
        <div class="w60 fll pt07 pl122">
		<ul id="menu"> 
            <li class="menu_right"><a href="#" class="drop"> Hi, {$smarty.session.sessUsername}</a>
     <div class="pcontent"></div>
         <div class="dropdown_4columns align_right"><!-- Begin 2 columns container -->
    
            <div class="col_1">
            
                <h3>MY BUYING</h3>
                <ul>
                   <li><a href="{$actualPath}/my_bid" >My Active Bids</a></li>
                    <li><a  href="{$actualPath}/offers">My Outgoing Offers&nbsp;&nbsp;({$totalUnReadOutgoingOffer})</a></li>
                    <li><a  href="{$actualPath}/offers?mode=incoming_counters" {if $totalUnReadIncomingCounters > 0} style="color:#FF4E09;" {/if}>My Incoming Counters&nbsp;&nbsp;({$totalUnReadIncomingCounters})</a></li>
                    <li><a  href="{$actualPath}/my_bid?mode=closed">My Closed Items</a></li>
                    <li><a  href="{$actualPath}/user_watching">Watch List&nbsp;&nbsp;({$count_watching})</a></li>
                </ul>   
                 
            </div>
    
            <div class="col_1">
            
                <h3>MY SELLING</h3>
                <ul>
                    <li><a  href="{$actualPath}/myselling?mode=fixed">Manual Upload</a></li>
                    <!--<li><a  href="{$actualPath}/myselling?mode=bulkupload">Bulk Upload</a></li>-->
                    <li><a  href="{$actualPath}/myselling?mode=selling">Selling (Auction Items)</a></li>
					<li><a  href="{$actualPath}/myselling?mode=fixed_selling">Selling (Fixed Items)</a></li>	
                    <li><a  href="{$actualPath}/offers?mode=incoming_offers" {if $totalUnReadIncomingOffers > 0} style="color:#FF4E09;" {/if}>My Incoming Offers&nbsp;&nbsp;({$totalUnReadIncomingOffers})</a></li>
                    <li><a  href="{$actualPath}/offers?mode=outgoing_counters">My Outgoing Counters&nbsp;&nbsp;({$totalUnReadOutgoingCounters})</a></li>
					<li><a  href="{$actualPath}/myselling?mode=pending">Pending</a></li>
					<li><a  href="{$actualPath}/myselling?mode=sold">Sold</a></li>
					<li><a  href="{$actualPath}/myselling?mode=upcoming">Upcoming</a></li>
					<li><a  href="{$actualPath}/myselling?mode=unsold">Unsold/Closed</a></li>
					<li><a  href="{$actualPath}/myselling?mode=unpaid">Sale Pending</a></li>
                </ul>   
                 
            </div>
    
            <div class="col_1">
            
                <h3>MY ACCOUNT</h3>
                <ul>
                    <li><a  href="{$actualPath}/myaccount">My Account / Dashboard</a></li>
                    <li><a  href="{$actualPath}/myaccount?mode=profile">Profile</a></li>
                    <li><a  href="{$actualPath}/send_message">Messages&nbsp;&nbsp;({$countMsg}) </a></li>
                    <li><a  href="{$actualPath}/my_want_list">My Want List ({$total_want_count})</a></li>
                    <li><a  href="{$actualPath}/my_invoice">Invoices/Reconciliation</a></li>
					<li><a  href="{$actualPath}/my_report">Reports</a></li>
					<li><a  href="{$actualPath}/myaccount?mode=change_password">Change Password</a></li>
                </ul>   
                 
            </div>
    
            
        </div><!-- End 4 columns container -->
</li> 
      </ul>  
    	 </div>
         <div class="w02 fll pt14"><img src="https://d294w6g1afjpvs.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w60 fll pt18 pl14 scart"><a href="javascript:void(0)" onclick="$(location).attr('href','{$actualPath}/myaccount?mode=logout');">Sign Out</a></div>
		{/if}
        <div class="w02 fll pt14"><img src="https://d294w6g1afjpvs.cloudfront.net/images/divider.png" width="2" height="20" /></div>
        <div class="w24 fll pt18 pl14"><a href="{$actualPath}/cart"><img src="https://d294w6g1afjpvs.cloudfront.net/images/cart1-icon.png" width="24" height="15" /></a></div>
    	<div class="w24 fll pt18 pl14 scart">({$totalCartCount})</div>
       
    	  
	</div> 
    
        	<div class="clb fll">
            <div id="mainnav" style="z-index:100000; width:995px;" >
        <ul style="margin-left:8px; width:972px;">
        <li class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Category</a>
                    <div>
                        <ul style="z-index:100000;" id="selector_box">
                        <li><a href="javascript:void(0);" onclick="$('#shop_cat_id').val('');$('#subcategory_id').val('');$('#frm_refine').submit();">All Categories</a></li>
                        {section name=sc loop=$shopCatRows}
                        <li><a href="javascript:void(0);" onclick="refine_search('shop_cat',{$shopCatRows[sc].shop_cat_id})">{$shopCatRows[sc].shop_cat_name}</a>
                        {if $smarty.request.shop_cat_id == $shopCatRows[sc].shop_cat_id}
                        <span style="color:#cc0000;font-weight:bold;margin-left:4px;">&#10003;</span>
                        {/if}
                        </li>
                        {/section}
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </li>
        <li id="subcat-nav-item" class="pr10 mr10 fll">
            <div class="features_menu_column mr10">
                <div class="features_selector">
                    <div class="trigger" id="trg">
                    <a href="#" style="float: left; ">Subcategory</a>
                    <div>
                        <ul style="z-index:100000;" id="subcat-nav-list">
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </li>
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
  </div>
<!--Page Ends-->

<!-- Login Modal Overlay -->
<div id="login-modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:200000;" onclick="hidelogin();"></div>
<!-- Login Modal -->
<div id="login-modal-box" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:200001; background:#fff; border-radius:8px; box-shadow:0 4px 24px rgba(0,0,0,0.3); padding:32px 36px 24px; width:380px; max-width:90vw; height:auto; overflow:visible;">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="margin:0; font-size:22px; color:#333; font-weight:600;">Member's Login</h2>
    <span onclick="hidelogin();" style="cursor:pointer; font-size:28px; color:#999; line-height:1; padding:0 4px;">&times;</span>
  </div>
  <form name="frmlogin" id="frmlogin" method="post" action="auth">
    <input type="hidden" name="mode" value="process_login" />
    <div id="error" style="color:red; margin-bottom:8px;"></div>
    <div id="log-in-popup-text" style="color:#555; margin-bottom:12px; font-size:14px;"></div>
    <div style="margin-bottom:16px;">
      <label for="username" style="display:block; margin-bottom:6px; font-size:14px; font-weight:600; color:#555;">Username</label>
      <input type="text" id="username" name="username" {if $smarty.const.NewUserName!=''} value="{$smarty.const.NewUserName}" {/if} class="required" placeholder="Enter your username" style="width:100%; padding:10px 12px; border:1px solid #ccc; border-radius:4px; font-size:14px; box-sizing:border-box;" />
    </div>
    <div style="margin-bottom:20px;">
      <label for="password" style="display:block; margin-bottom:6px; font-size:14px; font-weight:600; color:#555;">Password</label>
      <div style="position:relative;">
        <input type="password" id="password" name="password" {if $smarty.const.NewPassWord!=''} value="{$smarty.const.NewPassWord}" {/if} class="required" placeholder="Enter your password" style="width:100%; padding:10px 36px 10px 12px; border:1px solid #ccc; border-radius:4px; font-size:14px; box-sizing:border-box;" onfocus="{literal}$(this).keypress(function(event){
          var keycode = (event.keyCode ? event.keyCode : event.which);
          if(keycode == '13'){ submitDetailsForm(); }
        }); {/literal}" />
        <span onclick="{literal}var p=document.getElementById('password');if(p.type==='password'){p.type='text';this.textContent='HIDE';}else{p.type='password';this.textContent='SHOW';}{/literal}" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; font-size:11px; font-weight:600; color:#cc0000; user-select:none; letter-spacing:0.5px;">SHOW</span>
      </div>
    </div>
    <div style="margin-bottom:16px;">
      <input type="button" value="LOGIN" id="submitButton" name="submit" onclick="submitDetailsForm()" style="width:100%; padding:10px; background:#cc0000; color:#fff; border:none; border-radius:4px; font-size:15px; font-weight:600; cursor:pointer; letter-spacing:1px;" />
    </div>
    <div style="text-align:center; padding-bottom:8px;">
      <a href="{$actualPath}/forget_password" style="color:#cc0000; font-size:13px; text-decoration:none;">Forgot password?</a>
    </div>
  </form>
</div>
 {include file="header.tpl"}
<link href="https://c15123524.ssl.cf2.rackcdn.com/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/jquery-countdown-1.5.9/jquery.countdown.js"></script>

	{literal}	
<script type="text/javascript">
function toggleDiv(id,flagit,type,track) {
 	 var url = "bid_popup.php";
	 if(type==1 && track==1){
	 	$.get(url, {mode : 'offer_popup', id : id}, function(data){
			$('#'+id).html(data);
	 	});
	 }else if(type==0 && track==1){
	 	$.get(url, {mode : 'bid_popup', id : id}, function(data, textStatus){
	 		$('#'+id).html(data);
	 	});
	 }
	if (flagit=="1"){
	document.getElementById(''+id+'').style.visibility = "visible";
	}
	else
	if (flagit=="0"){
	$('#'+id).html("");
	document.getElementById(''+id+'').style.visibility = "hidden"
	}
}

		function test_enter(auction_id){
		//alert("hello");
			var newData = auction_id.split("_");
			$('#'+newData[2]).html("");
			$("#offer_bttn_"+newData[2]).click();
			return false;			 
		}
		function test_enter_for_bid(auction_id){
			var newData = auction_id.split("_");
			$('#'+newData[2]).html("");
			$("#bid_bttn_"+newData[2]).click();
		}	
		function test_blur(auction_id){
			var newData = auction_id.split("_");
			$('#'+auction_id).unbind('keypress');
			$('#offer_bttn_'+newData[2]).unbind('click');

		}
		function test_blur_for_bid(auction_id){
			var newData = auction_id.split("_");
			$('#'+auction_id).unbind('keypress');
			$('#bid_bttn_'+newData[2]).unbind('click');
		}
        function clear_text(){
            if($("#search_buy_items").val()=='Search Auctions..'){
                document.getElementById('search_buy_items').value='';
            }
        }
	
		function search_buy_items_func(list){
			var search_text= $('#search_buy_items').val();
			window.location.href="buy.php?list="+list+"&mode=key_search&keyword="+encodeURIComponent(search_text);
		}
		function key_search_buy(list){
		
			var search_text= $('#search_buy_items').val();
			window.location.href="buy.php?list="+list+"&mode=key_search&keyword="+encodeURIComponent(search_text);
		}
		function key_search_buy_clear(){
			$('#search_buy_items').unbind('keypress');
			//$('#search_buy_items_func').unbind('click');
		}
</script>
<style type="text/css">
.popDiv { position:absolute; min-width:120px; list-style-type:none; background-color:#006691 ;color:white; z-index:1000;font-size:12px;margin-left:80px;}
.popDiv_Auction { position:absolute; min-width:120px; list-style-type:none; background-color:#006691 ;color:white; z-index:1000;font-size:12px; margin-left:80px;}
</style>
{/literal}
<div id="forinnerpage-container">
  <div id="wrapper">
    <!--Header themepanel Starts-->
    <div id="headerthemepanel">
      <!--Header Theme Starts-->
      {include file="search-login.tpl"}
      <!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->
    <!-- page listing starts -->
    <div id="inner-container"> {include file="right-panel.tpl"}
      <div id="center">
        <div id="squeeze">
          <div class="right-corner">
            <div id="inner-left-container">
              <div id="tabbed-inner-nav">
                <div class="tabbed-inner-nav-left">
                  <ul class="menu">
                    <li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/buy.php"><span>See all Items</span></a></li>
                    <li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy.php?list=fixed"><span>Fixed Price Items</span></a></li>
                    <li {if $smarty.request.list == 'weekly'}class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly"><span>Weekly Auctions</span></a></li>
                    {*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy.php?list=monthly"><span>Event Auctions</span></a></li>*}
                    <li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy.php?list=upcoming"><span>Upcoming</span></a></li>
                  </ul>
                  <div class="tabbed-inner-nav-right"></div>
                </div>
              </div>
              <form name="listFrom" id="listForm" action="" method="post" onsubmit="return false;">
                <input type="hidden" name="mode" value="select_watchlist" />
                <input type="hidden" name="is_track" id="is_track" value="" />
                <input type="hidden" name="offset" value="{$offset}" />
                <input type="hidden" name="toshow" value="{$toshow}" />
                <input type="hidden" name="list" value="{$smarty.request.list}" />
                <div class="innerpage-container-main">
                 <div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>
                  <div class="left-midbg">
                    <div class="right-midbg">
                      <div class="mid-rept-bg"> {if $errorMessage<>""}
                        <div class="messageBox">{$errorMessage}</div>
                        {/if}
                        {if $total > 0}
                        <div class="top-display-panel">
                          <div class="left-area" >
                            <div class="dis">Display as</div>
                            <ul class="menu">
                              <li class="active">List</li>
                              |
                              {if $smarty.request.keyword!=''}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}">Gallery</a></li>
                              {elseif $smarty.request.mode=='search'}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}&mode=search&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}">Gallery</a></li>
                              {else}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}">Gallery</a></li>
                              {/if}
                            </ul>
                          </div>
                          <div class="sortblock">{$displaySortByTXT}</div>
                          <div class="left-area">
                            <div class="results-area">{$displayCounterTXT}</div>
                            <div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
                          </div>
                          <div class="soldSearchblock">
                            <div class="leftSearchbg"></div>
                              <input type="text" class="midSearchbg" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}" {else} value="Search Auctions.."{/if} onclick="clear_text();" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
			key_search_buy(list);
			}	
		}); {/literal}" onblur="key_search_buy_clear()"  />
                            <input type="button" class="rightSearchbg" value="" onclick="search_buy_items_func('{$smarty.request.list}')" />
                          </div>
                        </div>
                        {/if}
                        {if $smarty.session.sessUserID <> ""}
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey">
                           
                          </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        {if $total > 0}                    
                        {if $smarty.session.sessUserID <> ""}
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey SelectionBtnPanel">
                            <div style="float:left; padding:0px; margin:0px;">
                              <input type="button" class="select-all-btn" onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;" value="Select All"/>
                              <input type="button" class="deselect-all-btn"  onclick="javascript: unMarkSelectedRows('listForm'); return false;" style=" cursor:pointer;" value="Deselect All"/>
                            </div>
                            <input type="button" class="watch-slctd-btn" onclick="this.form.submit();" value="Watch Selected"/>
                            <!--<a href="#"><strong>How to Order?</strong></a>-->
                            {if $smarty.request.list == 'fixed'}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="Place All Offers"/>
                            {else}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="Place All Bids" />
                            {/if} </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        <!-- start of movie posters --->
						<div id="container">
                        {section name=counter loop=$auctionItems}
                        <div class="display-listing-main">
                          <div>
                            <table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
                              {if $smarty.request.list=='monthly'}
                              <tr>
                                <td  class="list-poster-box"><div class="" style="color:#000000;padding:5px 0 4px 10px;font-size:15px;font-family:Arial,Helvetica,sans-serif;height:5px;"><b class="EventType">Event :&nbsp;{$auctionItems[counter].event_title}</b></div></td>
                                <td>&nbsp;</td>
                              </tr>
                              {/if}
                              {if $smarty.request.list=='weekly'}
                              <tr>
                                <td  class="list-poster-box"><div  class="" style="color:#000000;padding:5px 0 4px 10px;font-size:15px;font-family:Arial,Helvetica,sans-serif;height:5px;"><b class="weeklyevent">Week :&nbsp;{$auctionItems[counter].auction_week_title}</b></div></td>
                                <td>&nbsp;</td>
                              </tr>
                              {/if}
                              {if $smarty.request.list==''}
                              {if $auctionItems[counter].fk_auction_type_id=='2'}
                              <tr>
                                <td  class="list-poster-box"><div  class="" style="color:#000000;padding:5px 0 4px 10px;font-size:15px;font-family:Arial,Helvetica,sans-serif;height:5px;"><b class="weeklyevent">Week :&nbsp;{$auctionItems[counter].auction_week_title}</b></div></td>
                                <td>&nbsp;</td>
                              </tr>
                              {/if}
                              {if $auctionItems[counter].fk_auction_type_id=='3'}
                              <tr>
                                <td  class="list-poster-box"><div class="" style="color:#000000;padding:5px 0 4px 10px;font-size:15px;font-family:Arial,Helvetica,sans-serif;height:5px;"><b class="EventType">Event :&nbsp;{$auctionItems[counter].event_title}</b></div></td>
                                <td>&nbsp;</td>
                              </tr>
                              {/if}
                              {/if}
                              <tr><td colspan="2" class="list-poster-box" ><div class="poster-area-list"> {if $smarty.session.sessUserID <> ""}
                                    <input type="checkbox" name="auction_ids[]" value="{$auctionItems[counter].auction_id}"/>
                                    {/if} <a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" ><strong>{$auctionItems[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$auctionItems[counter].poster_sku}){/if*}</strong></a> </div></td></tr>
                              <tr>
                                <td class="list-poster-box" valign="top">
                                  <div class="poster-area-list">
                                 	<div class="left">
                                    <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                    <table align="center"><tbody><tr><td align="left" valign="top" style="border:none;position:relative; vertical-align:top; height:160px; width:150px">
                                     <div class="shadowbottom" style="border:none;position:absolute;">
                                       <div class="shadow-bringer shadow"><div class="img"><a href="#"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"  onclick="redirect_poster_details({$auctionItems[counter].auction_id});" style="cursor:pointer;" id="img_enlarge_{$auctionItems[counter].auction_id}" /></a>
                                           <input type="hidden" value="{$auctionItems[counter].large_image}" id="large_image_id_{$auctionItems[counter].auction_id}">
                                           <input type="hidden" value="{$auctionItems[counter].image_path}" id="small_image_id_{$auctionItems[counter].auction_id}"></div> </div></div>
                                       </td>
                                       </tr>
                                       </tbody>
                                       </table>
                                       </div>
                                       <div class="poster-area-list listwatchlist">
                                    <!--<input type="button" class="bidnow-btn" value="Details" onclick="redirect_poster_details({$auctionItems[counter].auction_id});"/>-->
                                    {if $auctionItems[counter].watch_indicator ==0}
                                    <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist({$auctionItems[counter].auction_id});" />
                                    {else}
                                        <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$auctionItems[counter].auction_id});" class="track-btn"  />
                                    {/if}
                                  </div>
                                    </div>
									{*if $smarty.request.mode!='dorefinesrc'*}
                                    <div class="descrp-area">
											<div class="desp-txt"><b>Size : </b> {$auctionItems[counter].poster_size}</div>
										
											<div class="desp-txt"><b>Genre : </b> {$auctionItems[counter].genre}</div>
										
											<div class="desp-txt"><b>Decade : </b> {$auctionItems[counter].decade}</div>
										
											<div class="desp-txt"><b>Country : </b> {$auctionItems[counter].country}</div>
										
											<div class="desp-txt"><b>Condition : </b> {$auctionItems[counter].cond}</div>
                                                </div>
									{*else}	
									<div class="descrp-area">
                                                {section name=catCounter loop=$auctionItems[counter].categories}
                                                    {if $auctionItems[counter].categories[catCounter].fk_cat_type_id == 1}
                                                    <div class="desp-txt"><b>Size : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 2}
                                                    <div class="desp-txt"><b>Genre : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 3}
                                                    <div class="desp-txt"><b>Decade : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 4}
                                                    <div class="desp-txt"><b>Country : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 5}
                                                    <div class="desp-txt"><b>Condition : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                                                    {/if}
                                                {/section} 
                                                </div>		
									{/if*}			
                                      
                                  </div>
                                   </td>
                                <td class="list-auction-det" valign="top"> {if $auctionItems[counter].fk_auction_type_id == 1}
                                  <div class="auction-row">
                                    <div id="auction_data_{$auctionItems[counter].auction_id}" >
                                      
                                    </div>
                                  </div>
                                  <!--   popup starts -->
                                  <div id="{$auctionItems[counter].auction_id}" class="popDiv_Auction"> </div>
                                  <!--   popup ends -->
                                  <!-- middle of fixed starts -->
                                  <!-- Buy Now section for fixed price sell items -->
                                  <div style=" width:100%; padding:10px 0 0 0px; margin:0px; display:block; float:left;">
								  {if $auctionItems[counter].auction_is_sold != '3'}
                                    <div class="text bold left txtHt">&nbsp;&nbsp;Buy Now <span class="buynowprice"> ${$auctionItems[counter].auction_asked_price|number_format:2}</span></div>
                                    <div class="right">
                                      <input type="button" id="buynow_bttn_{$auctionItems[counter].auction_id}" value="Buy Now!!" onclick="redirect_to_cart({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}')" class="bidnow-btn BuyNow" />
                                    </div>
                                  </div>
                                  <!-- Make Offer section for fixed price sell items -->
                                  <div style=" width:100%; padding:0px; margin:0px; display:block; float:left;"> {if $auctionItems[counter].auction_reserve_offer_price > 0}
                                    
                                    {*if $auctionItems[counter].is_reopened == '0'}
                                    <div class="text-price bold left"> $&nbsp;
                                      <input type="text" name="offer_price_{$auctionItems[counter].auction_id}" id="offer_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" />
                                      <span class="CurrencyDecimal bold">.00</span> </div>
                                    {/if*}                                               
                                    {*if $auctionItems[counter].auction_reserve_offer_price > 0 && $auctionItems[counter].is_offer_price_percentage == 1}
                                    <div class="text-price bold left">&nbsp;&nbsp;Minimum ${math|round|number_format:2 equation="(( x *  y) / 100)" x=$auctionItems[counter].auction_asked_price y=$auctionItems[counter].auction_reserve_offer_price}</div>
                                    {elseif $auctionItems[counter].auction_reserve_offer_price > 0 && $auctionItems[counter].is_offer_price_percentage != 1}
                                    <div class="text-price bold left">&nbsp;&nbsp;Minimum ${$auctionItems[counter].auction_reserve_offer_price|round|number_format:2}</div>
                                    {/if*}
                                    {if $auctionItems[counter].is_reopened == '0'}
                                    
                                    <div class="text-price bold left"> $&nbsp;
                                      <input type="text" name="offer_price_{$auctionItems[counter].auction_id}" id="offer_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var auc_id=this.id;
			test_enter(auc_id);
			}	
		}); {/literal}" onblur="test_blur(this.id)" />
                                      <span class="CurrencyDecimal bold">.00</span> </div>
                                    <div class="right" style="padding:2px 0 0 0;">
                                      <input type="button" id="offer_bttn_{$auctionItems[counter].auction_id}" value="Make Offer" onclick="postOffer({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}','{$auctionItems[counter].auction_asked_price}');" class="bidnow-btn makeoffer" />
                                    </div>
									{/if}
                                    {/if}
                                    {/if} </div>
                                  <!-- Middle of fixed ends -->
                                  {elseif $auctionItems[counter].fk_auction_type_id == 2}
                                  <div id="auction_data_{$auctionItems[counter].auction_id}"> {if $auctionItems[counter].last_bid_amount > 0}
                                    <div class="auction-row">
                                      
                                    </div>
                                    {/if} </div>
                                  <!--   popup starts -->
                                  <div id="{$auctionItems[counter].auction_id}" class="popDiv"> </div>
                                  <!--   popup ends -->
                                  <!-- middle of weekly starts -->
                                  <!-- Bid Now section for weekly auction items -->
                                  <div style=" width:100%; padding:0px; margin:0px; display:block; float:left;">
                                    <!--<div class="text-price txtHt bold left">Start Price ${$auctionItems[counter].auction_asked_price|number_format:2}</div>-->
                                    <div class="text-price bold left"> $&nbsp;
                                      <input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="bid_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)"  />
                                      <span class="CurrencyDecimal bold">.00</span> </div>
                                    <div class=" right">
                                      <input type="button" id="bid_bttn_{$auctionItems[counter].auction_id}" value="Bid Now!!" onclick="postBid({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}',{$auctionItems[counter].auction_buynow_price});" class="bidnow-hammer-btn" />
                                    </div>
                                  </div>
                                  <!-- Buy Now section for weekly auction items -->
                                  {if $auctionItems[counter].auction_buynow_price > 0}
                                  <div style=" width:100%; padding:10px 0 0 0px; margin:0px; display:block; float:left;">
                                    <div class="text-price bold left">Buy Now <span class="buynowprice">${$auctionItems[counter].auction_buynow_price|number_format:2}</span></div>
                                    <div class="right">
                                      <input type="button" id="buynow_bttn_{$auctionItems[counter].auction_id}" value="Buy Now!!" onclick="redirect_to_cart('{$auctionItems[counter].auction_id}', '{$auctionItems[counter].fk_user_id}')" class="bidnow-btn BuyNow" />
                                    </div>
                                  </div>
                                  {/if}
                                  <!-- Middle of weekly ends -->
                                  <div id="auction_{$auctionItems[counter].auction_id}">
                                    <div class="auction-row">
                                      <div class="boldItalics time-left">Time Left</div>
                                      <div class="timerwrapper" style="float:right">
                                      <div class="timer-left"></div>
                                      <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                                      <div class="timer-right"></div>
                                      </div>
                                    </div>
                                    <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                                      <div class="buy-text boldItalics" style="margin-right:5px">End Time: </div>
                                      <div class="buy-text" style="float:none;">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                      <div class="buy-text bold" style="margin-right:5px">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                      <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                    </div>
                                  </div>
                                  {elseif $auctionItems[counter].fk_auction_type_id == 3}
                                  <div id="auction_data_{$auctionItems[counter].auction_id}"> {if $auctionItems[counter].last_bid_amount > 0}
                                    <div class="auction-row">
                                    
                                    </div>
                                    {/if} </div>
                                  <!--   popup starts -->
                                  <div id="{$auctionItems[counter].auction_id}" class="popDiv"> </div>
                                  <!--   popup ends -->
                                  <!-- Middle of monthly starts -->
                                  <!-- Bid Now section for monthly auction items -->
                                  <div style=" width:100%; padding:0px; margin:0px; float:right;">
                                    <div class="Minimum">
                                      <!--<div class="text bold ">Start Price ${$auctionItems[counter].auction_asked_price|number_format:2}</div>-->
                                      {if $auctionItems[counter].auction_reserve_offer_price > 0}
                                      <div  id="rp_{$auctionItems[counter].auction_id}"> {if $auctionItems[counter].last_bid_amount >= $auctionItems[counter].auction_reserve_offer_price}
                                        <div class="text NoPrice" style="font-size:11px; float:right;">(Reserve Met)</div>
                                        {else}
                                        <div class="text PriceIncluded" style="font-size:11px;  float:right;">(Reserve Not Met)</div>
                                        {/if} </div>
                                      {else}
                                      <div class="text NoPrice " style="font-size:11px; float:right;">(No Reserve)</div>
                                      {/if} </div>
                                    <div class="Minimum">
                                      <div class="text bold"> $&nbsp;
                                        <input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="bid_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)"  />
                                        <span class="CurrencyDecimal bold">.00</span>&nbsp;
                                        <div class=" right">
                                        <input type="button" id="bid_bttn_{$auctionItems[counter].auction_id}" value="Bid Now!!" onclick="postBid({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}',{$auctionItems[counter].auction_buynow_price});" class="bidnow-hammer-btn"  style="margin-top:0px;"/>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Middle of monthle ends -->
                                  <div id="auction_{$auctionItems[counter].auction_id}">
                                    <div class="auction-row">
                                      <div class="boldItalics time-left">Time Left</div>
                                      <div class="timerwrapper" style="float:right">
                                      <div class="timer-left"></div>
                                      <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                                      <div class="timer-right"></div>
                                      </div>
                                    </div>
                                    <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                                      <div class="buy-text boldItalics" style="margin-right:5px;">End Time: </div>
                                      <div class="buy-text" style="float:none;">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                      <div class="buy-text bold" style="margin-right:5px;">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                      <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                    </div>
                                  </div>
                                  {/if} </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        {/section}</div>
                        <div class="btomgrey-bg"></div>
                        <div class="top-display-panel">
                          <div class="left-area">
                            <div class="results-area">{$displayCounterTXT}</div>
                            <div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
                          </div>
                        </div>
                        <!-- end of movie posters --->
                        {else}
                        <div class="top-display-panel" >
						<div class="top-display-panel">
                          <div class="left-area" >
                            <div class="dis">Display as</div>
                            <ul class="menu">
                              <li class="active">List</li>
                              |
                              {if $smarty.request.keyword!=''}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}">Gallery</a></li>
                              {elseif $smarty.request.mode=='search'}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}&mode=search&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}">Gallery</a></li>
                              {else}
                              <li><a href="buy.php?view_mode=grid&list={$smarty.request.list}">Gallery</a></li>
                              {/if}
                            </ul>
                          </div>
                          <div class="sortblock">
						  <div class="soldSearchblock">
                            <div class="leftSearchbg"></div>
                            <input type="text" class="midSearchbg" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}" {else} value=""{/if} onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
			key_search_buy(list);
			}	
		}); {/literal}" onblur="key_search_buy_clear()"  />
                            <input type="button" class="rightSearchbg" value="" onclick="search_buy_items_func('{$smarty.request.list}')" />
                          </div>
						  
						  </div>
                          
                          
                        </div>
                       {if $smarty.request.list=='weekly'} 
							<div class="msgsearchnorecords"> Auction has ended. Please go to Sold Archive to view results. Upcoming Auction will start shortly.</div>
						{elseif $smarty.request.list=='monthly'}
							<div class="msgsearchnorecords"> There are currently no Event auctions scheduled at this time.</div>
						{else}
							<div class="msgsearchnorecords"> There are no auctions currently running.</div>	
						{/if}	
						</div>
                        {/if}
                        {if $smarty.session.sessUserID <> ""}
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey">
                            <!--							<div class="left-submenu">-->
                            <!--							<span class="goto-span"><strong>GO TO: <u>FOR SALE</u></strong></span>-->
                            <!--							<ul class="menu">-->
                            <!--								<li>[<a href="{$actualPath}/offers.php">My Outgoing Offers</a>]</li>-->
                            <!--                                <li>[<a href="{$actualPath}/offers.php?mode=incoming_counters">My Incoming Offers</a>]</li>-->
                            <!--							</ul>-->
                            <!--							</div>-->
                            <!--							<div class="right-submenu">-->
                            <!--								<span class="goto-span"><strong>AUCTIONS</strong></span>-->
                            <!--                                <ul class="menu">-->
                            <!--                                    <li>[<a href="{$actualPath}/my_bid.php">My Bids</a></li>-->
                            <!--                                    <li><img class="imgprpty" src="{$actualPath}/images/losing-bid-img.png" width="13" height="14" border="0"  /><a class="red" href="{$actualPath}/my_bid.php?mode=losing">Losing Bids</a>|</li>-->
                            <!--                                    <li><img class="imgprpty" src="{$actualPath}/images/winning-bid-img.png" width="13" height="14" border="0" /><a class="green" href="{$actualPath}/my_bid.php?mode=winning">Winning Bids</a>]</li>-->
                            <!--                                    <li>[<a href="{$actualPath}/user_watching.php">Watch List</a>]</li>                                -->
                            <!--                                </ul>	-->
                            <!--							</div>-->
                          </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        {if $total > 0} 
                        {if $smarty.session.sessUserID <> ""}
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey SelectionBtnPanel">
                            <div style="float:left; padding:0px; margin:0px;">
                              <input type="button" class="select-all-btn" onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;" value="Select All"/>
                              <input type="button" class="deselect-all-btn"  onclick="javascript: unMarkSelectedRows('listForm'); return false;" style=" cursor:pointer;" value="Deselect All"/>
                            </div>
                            <input type="button" class="watch-slctd-btn" onclick="this.form.submit();" value="Watch Selected" />
                            {*<a href="#"><strong>How to Order?</strong></a>*}
                            {if $smarty.request.list == 'fixed'}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="Place All Offers"/>
                            {else}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="Place All Bids"/>
                            {/if} </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        {/if}
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                  <div class="btm-mid">
                    <div class="btom-left"></div>
                  </div>
                  <div class="btom-right"></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      {include file="user-panel.tpl"} </div>
    <!-- page listing ends -->
  </div>
  <div class="clear"></div>
</div>
{include file="foot.tpl"}
 {literal}
 <script type="text/javascript">

         $(document).ready(function(){
 dataArr = {/literal}{$json_arr}{literal};
     //setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);
 var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
     setInterval(function() { timeLeft(dataArr,list); }, 1000);
 })


 </script>
 {/literal}
 {if $total > 0}
     {literal}
     <script type="text/javascript">
         $(document).ready(function() {
             var cont_left = $("#container").position().left;
             $("a img").hover(function() {
                 var img_id= this.id;
                 var newSrc = img_id.split("_");
                 var src = $("#large_image_id_"+newSrc[2]).val();
                 // hover in
                 $(this).parent().parent().css("z-index", 5);
                 //alert(newSrc[5]);
                 $("#"+img_id).attr("src", src);
                 $(this).animate({
                     position: "absolute",
                 }, "fast");
             }, function() {
                 var img_id= this.id;
                 var newSrc = img_id.split("_");
                 var src = $("#small_image_id_"+newSrc[2]).val();
                 // hover out
                 $(this).parent().parent().css("z-index", 0);
                 $("#"+img_id).attr("src", src);
                 $(this).animate({
                     position: "absolute",
                 }, "fast");
             });

             $(".img").each(function(index) {
                 var left = (index * 160) + cont_left;
                 $(this).css("left", left + "px");
             });
         });
     </script>
     {/literal}
 {/if}
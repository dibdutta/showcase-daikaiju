 {include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>
<script src="https://unpkg.com/react@15/dist/react.min.js"></script>
<script src="https://unpkg.com/react-dom@15/dist/react-dom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.19.0/babel.min.js"></script>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/axios.min.js"></script>

	{literal}	
<script type="text/javascript">
var fk=0;
function toggleDiv(id,flagit,type,track) {
 	 var url = "bid_popup.php";
	 if(type==1 && track==1){
	 	$.post(url, {mode : 'offer_popup', id : id}, function(data){
			$('#'+id).html(data);
	 	});
	 }else if(type==0 && track==1){
	 	$.post(url, {mode : 'bid_popup', id : id}, function(data, textStatus){
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
            }if($("#search_buy_items").val()=='Search Stills..'){
            document.getElementById('search_buy_items').value='';
			}
        }
	
		function search_buy_items_func(list){
			var search_text= $('#search_buy_items').val();
			var is_expired = $('#is_expired').val();
			var is_expired_stills = $('#is_expired_stills').val();
			var auction_week_id = $('#auction_week_id').val();
			window.location.href="buy?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
		}
		function key_search_buy(list){
		
			var search_text= $('#search_buy_items').val();
			var is_expired = $('#is_expired').val();
			var is_expired_stills = $('#is_expired_stills').val();
			var auction_week_id = $('#auction_week_id').val();
			window.location.href="buy?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
		}
		function key_search_buy_clear(){
			$('#search_buy_items').unbind('keypress');
			//$('#search_buy_items_func').unbind('click');
		}
		function shufflePage(){
			var newUrl =  {/literal}'{$Newlink}'{literal}.replace(/\&amp;/g,'&')
			window.location.href=newUrl;
		}
</script>
<style type="text/css">
.popDiv { position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ; z-index:1000 ;color:#fff; z-index:50; font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:220px; margin-top:230px;visibility:hidden;}
.popDiv_Auction { position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ; z-index:1000; color:#fff; font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:250px; margin-top:150px;visibility:hidden;}

#track-btn-id:hover {
	background-image: url(https://c4808190.ssl.cf2.rackcdn.com/watchthisitem_btn.png);
}

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
                    {*<li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/buy"><span>See all Items</span></a></li>*}
                    <li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy?list=fixed"><span>Fixed Price</span></a></li>
					
					{if $live_count<=1}
                    	<li {if $smarty.request.list == 'weekly' && $smarty.request.track_is_expired != '1'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly"><span>{if $totalLiveWeekly > 0}{$auctionWeeksData[0].auction_week_title}{else}{$latestEndedAuction} Results{/if}</span></a></li>
                    	{*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy?list=monthly"><span>Event Auctions</span></a></li>*}
                    	{if $upcomingTotal >0}
                    		<li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						{else}
							<li {if $smarty.request.track_is_expired == '1'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly&track_is_expired=1"><span> {$latestEndedAuction} Results</span></a></li>
						{/if}
					{elseif $live_count>1}
						<li {if $smarty.request.auction_week_id ==$auctionWeeksData[0].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[0].auction_week_id}"><span>{$auctionWeeksData[0].auction_week_title}</span></a></li>
						<li {if $smarty.request.auction_week_id ==$auctionWeeksData[1].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[1].auction_week_id}"><span>{$auctionWeeksData[1].auction_week_title}</span></a></li>	
					{/if}
					{if $extendedAuction != ""}					    
						<li {if $smarty.request.list == 'extended'} class="active" {/if}><a href="{$actualPath}/buy?list=extended&view_mode=grid"><span>Extended Auction {$extendedAuction}</span></a></li>
					{/if}
                    <li {if $smarty.request.list == 'alternative'} class="active" {/if}><a href="{$actualPath}/buy?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
					{*<li {if $smarty.request.list == 'stills'} class="active" {/if}><a href="{$actualPath}/buy?list=stills"><span>Fixed Stills</span></a></li>*}
				  </ul>
                  
                </div>
              </div>
              <form name="listFrom" id="listForm" action="" method="post" onsubmit="return false;">
                <input type="hidden" name="mode" value="select_watchlist" />
                <input type="hidden" name="is_track" id="is_track" value="" />
                <input type="hidden" name="offset" value="{$offset}" />
                <input type="hidden" name="toshow" value="{$toshow}" />
                <input type="hidden" name="list" value="{$smarty.request.list}" />
				<input type="hidden" name="is_expired" id="is_expired" value="{$is_expired}" />
				<input type="hidden" name="is_expired_stills" id="is_expired_stills" value="{$is_expired_stills}" />
				<input type="hidden" name="auction_week_id" id="auction_week_id" value="{$smarty.request.auction_week_id}" />
                <div class="innerpage-container-main">
                 <div class="top-mid"><div class="top-left"></div></div>
                
                  <div class="left-midbg">
                    <div class="right-midbg">
                      <div class="mid-rept-bg">
					  {if $smarty.request.mode=='search'}
					  	<div class="messageBox"> You have searched for {$cat_value}</div>
					  {/if}
					   {if $errorMessage<>""}
                        <div class="messageBox">{$errorMessage}</div>
                        {/if}
                        {if $total > 0}
                        <div class="top-display-panel">
                          <div class="left-area" >
                            <div class="dis">View as :</div>
                            <ul class="menu">
                              <li class="lista"><span class="active"></span></li>
                              |
                              {if $smarty.request.keyword!='' && $smarty.request.mode=='key_search'}
									<li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}&search_type={$smarty.request.search_type}&is_expired={$is_expired}&is_expired_stills={$is_expired_stills}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {elseif $smarty.request.mode=='search' || $smarty.request.mode=='dorefinesrc'}
									<li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&mode={$smarty.request.mode}&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {elseif $smarty.request.mode=='key_search_global'}
									<li class="list"><a href="buy?view_mode=grid&list={$smarty.request.list}&mode={$smarty.request.mode}&is_expired=0&auction_week_id=&is_expired_stills=&keyword={$smarty.request.keyword|urlencode}"></a></li>	
							  {else}
                              <li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {/if}
                            </ul>
                          </div>
						  <div class="soldSearchblock">
                            	
							<div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;">
                                    <input style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;" type="text" class="midSearchbg_edit fll" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}" {elseif $smarty.request.list == 'stills'} value="Search Stills.." {else} value="Search Auctions.."{/if} onclick="clear_text();" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
			key_search_buy(list);
			}	
		}); {/literal}" onblur="key_search_buy_clear()"   />
                                <input type="button" class="rightSearchbg" value=""  onclick="search_buy_items_func('{$smarty.request.list}')" />
                            </div>    
                            </div>
                          <div class="sortblock">{$displaySortByTXT}</div>
                          
                          
                        </div>
                        <div class="top-display-panel2"> 
							<div class="left-area">
								<div class="results-area" style="width:200px;">{$displayCounterTXT}</div>
								{if ($smarty.request.list == "fixed")}
								<div  style="width:500px;"><input type="button" value="Press to Shuffle Inventory" class="track-btn" id="track-btn-id" onclick="shufflePage()" style="width:200px;background-repeat:repeat" /></div>
								{/if}
								<div class="pagination" {if ($smarty.request.list == "fixed")}style="margin-top:-20px;" {/if}>{$pageCounterTXT}</div>
							  </div>
						  </div>
                        {/if}
                        {if $smarty.session.sessUserID <> ""}
                        <!--<div class="light-grey-bg-inner">
                          <div class="inner-grey">
                           
                          </div>
                          <div class="clear"></div>
                        </div>-->
                        {/if}
                        {if $total > 0}                    
                        {if $smarty.session.sessUserID <> "" && ($is_expired=='0' && $is_expired_stills !='1') }
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey SelectionBtnPanel">
                            <div style="float:left; padding:0px; margin:0px;">
                              <input type="button" class="select-all-btn" onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                              <input type="button" class="deselect-all-btn"  onclick="javascript: unMarkSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                            <input type="button" class="watch-slctd-btn" onclick="this.form.submit();" value=""/>
                            </div>
                            <!--<a href="#"><strong>How to Order?</strong></a>-->
							
                            {if $smarty.request.list == 'fixed'}
                            <input type="button" class="place-all-offers-btn" onclick="placeAllBids(dataArr);" value=""/>
                            {else}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="" />
                            {/if} </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        <!-- start of movie posters --->
						<div id="container">
                        {section name=counter loop=$auctionItems}
                        <div class="display-listing-main mb02">

                          <div class="buylist pt20 pb20">
                          {if $smarty.request.list=='weekly'}
                          <div  class="" style="color:#000000;padding:8px 0;font-size:15px; clear:both;"><b class="weeklyevent">Week :&nbsp;{$auctionItems[counter].auction_week_title}</b></div>
                          {/if}
                          <table width="711" border="0" cellspacing="0" cellpadding="0">
                              <tr>
							     <td width="25" valign="top" class="pt10 tac">
								  {if $smarty.session.sessUserID <> "" && ($is_expired=='0' && $is_expired_stills !='1' )}
                                   	<input type="checkbox" name="auction_ids[]" value="{$auctionItems[counter].auction_id}"/>
                                   {/if} 
								 </td>
                                 <td width="200" class="buylisttb">
<div>
{if $auctionItems[counter].fk_auction_type_id==1}
	<a href="{$actualPath}/buy?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&fixed=1"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
{else}
	<a href="{$actualPath}/buy?mode=poster_details&auction_id={$auctionItems[counter].auction_id}"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
{/if}
                                           
										   </div>
								 {if ($is_expired=='0' && $is_expired_stills !='1' )}			   								
									 {if $auctionItems[counter].watch_indicator ==0}
										<input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist({$auctionItems[counter].auction_id});" id="watch_{$auctionItems[counter].auction_id}" />
									 {else}
										<input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$auctionItems[counter].auction_id});" class="track-btn"  />
									 {/if}
								  {/if}
								  </td>
                                 <td valign="top" class="pr10">
                  <!--3rd td-->  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								    <tr>
									{if $smarty.request.list=='fixed'}
										<td class="pb20"><h1><a href="{$actualPath}/buy?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&fixed=1" style="cursor:pointer;" ><strong>{$auctionItems[counter].poster_title}&nbsp;</strong></a> </h1></td>
									{else}
										<td class="pb20"><h1><a href="{$actualPath}/buy?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" ><strong>{$auctionItems[counter].poster_title}&nbsp;</strong></a> </h1></td>
									{/if}	
      							  </tr>
								    <tr>
									<td class="buylisttbtopbg"></td>
								  </tr>
								    <tr>
								 	<td class="pb10">
									<div class="descrp-area">
										<div class="desp-txt"><b>Size : </b> {$auctionItems[counter].poster_size}</div>
										<div class="desp-txt"><b>Genre : </b> {$auctionItems[counter].genre}</div>
										<div class="desp-txt"><b>Decade : </b> {$auctionItems[counter].decade}</div>
										<div class="desp-txt"><b>Country : </b> {$auctionItems[counter].country}</div>
										<div class="desp-txt"><b>Condition : </b> {$auctionItems[counter].cond}</div>
										{*if $auctionItems[counter].imdb_link!=''}
										<div class="desp-txt" style="border: 2px solid red;color:red;"><a href="{$auctionItems[counter].imdb_link}" target="_blank" style="text-decoration:none;"  >&nbsp;&nbsp;&nbsp;View Item in IMDB</a></div>							{/if*}
									</div>
        							</td>
								</tr>
								    <tr>
        						 <td class="buylisttbtopbg"></td>
      							</tr>
								<!-- Auction Items for Weekly And Stills Starts Here -->
								{if $auctionItems[counter].fk_auction_type_id == 2 || $auctionItems[counter].fk_auction_type_id=='5'}
								{if ($is_expired=='0' && $is_expired_stills !='1') }
									<tr>
									<td class="buylisttbcenter">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
									  
										<td width="65"><div class="boldItalics time-left">Time Left</div></td>
										<td width="146"><div class="timerwrapper" style="float:right">
																 <!-- <div class="timer-left"></div>-->
																  <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
																  <!--<div class="timer-right"></div>-->
																  </div></td>
										<td class="pl20"><div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
																  <div class="buy-text boldItalics" style="margin-right:5px">End Time: </div>
																  <div class="buy-text" style="float:none;">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
																  <div class="buy-text bold" style="margin-right:5px">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
																  <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
																</div></td>
															
									  </tr>
									</table>
                                    </td>
								  </tr>
								     <tr>
        							<td class="buylisttbbottombg"></td>
      							  </tr>
								 	<div id="{$auctionItems[counter].auction_id}" class="popDiv"> </div>								  
								{/if}
								    <tr><td>
								<div id="auction_data_{$auctionItems[counter].auction_id}">
								{if $auctionItems[counter].last_bid_amount > 0}								   
                                    <div class="auction-row">
                                      
                                    </div>								   	
                                 {/if}
								 </div> 
								 </td></tr>
                              		 <tr><td>
                                 {if ($is_expired=='0' && $is_expired_stills !='1' )}
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="bid_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="bid_bttn_{$auctionItems[counter].auction_id}" value="" onclick="postBid({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}');" class="bidnow-hammer-btn" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
                                    
                                    
								</table>
                                  </td></tr>
                                  	{else}
									<tr>
									<td class="pb10">
							<div class="auction-row" style="padding:0px;">
									 <div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:12px; color:#000;">Sold For:</span> </div>
									 <div class="buy-text offer_buyprice">${$auctionItems[counter].last_bid_amount}</div><div  class="buy-text-detpstr"  >&nbsp;<b class="OfferBidNumber">{$auctionItems[counter].bid_count} Bid(s)&nbsp;&nbsp;</b> </div>
									 </div>
							</td>
							  
							</tr>	
                              {/if}    
                              <!-- Auction Items for Weekly And Stills Ends Here -->
							<!-- Fixed Items  Starts Here -->    
                              {elseif  $auctionItems[counter].fk_auction_type_id == 1}
									<tr><td>
							<div class="auction-row">
                                    <div id="auction_data_{$auctionItems[counter].auction_id}" >
                                      
                                    </div>
                            </div>
							</td></tr>
									<div id="{$auctionItems[counter].auction_id}" class="popDiv_Auction"> </div>
							{if $auctionItems[counter].auction_is_sold != '3'}
                            		
							 <tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal">${$auctionItems[counter].auction_asked_price|number_format:2}</div>
											
											 </div></td>
										  <td><div>
											<input type="button" id="buynow_bttn_{$auctionItems[counter].auction_id}" value="" onclick="redirect_to_cart({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" />
											</div></td>
										  	
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
									 
                             <tr><td> 
							{if $auctionItems[counter].auction_reserve_offer_price > 0 }
							{if $auctionItems[counter].is_reopened == '0'}
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								
								<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="offer_price_{$auctionItems[counter].auction_id}" id="offer_price_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var auc_id=this.id;
			test_enter(auc_id);
			}	
		}); {/literal}" onblur="test_blur(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="offer_bttn_{$auctionItems[counter].auction_id}" value="" onclick="postOffer({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}','{$auctionItems[counter].auction_asked_price}');" class="bidnow-btn makeoffer" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
							</table>
                             
							  {/if}
							  {/if}
							   </td></tr>
							   {if  $auctionItems[counter].fk_auction_type_id != 4}
									<tr>
									<td><div ><div class="CurrencyDecimal">Seller : {$auctionItems[counter].username}</div>
											
									</div></td>
									</tr>
								{/if}
                              </table>
                              	</td>
                              </tr>
							  
                                {/if}
                             {/if} 
                             <!-- Fixed Items  Ends Here -->       
                      		 <!--- Code should come here--->          
                           </table></td></tr></table></div>
                         
                        </div><!--containerdiv ends-->
                        {/section}
                        <div  id="root0" class="display-listing-main mb02">

                          
						</div>
						</div>
                        
                        <div class="btomgrey-bg"></div>
                        <div class="top-display-panel2">
                          <div class="left-area">
                            <div class="results-area">{$displayCounterTXT}</div>
                            <div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
                          </div>
                        </div>
                        <!-- end of movie posters --->
                        {else}
						<div class="top-display-panel">
                          <div class="left-area" >
                            <div class="dis">View as :</div>
                            <ul class="menu">
                              <li class="lista"><span class="active"></span></li>
                              |
                              {if $smarty.request.keyword!=''}
                              <li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}&search_type={$smarty.request.search_type}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {elseif $smarty.request.mode=='search' || $smarty.request.mode=='dorefinesrc'}
                              <li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&mode={$smarty.request.mode}&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {else}
                              <li class="grid"><a href="buy?view_mode=grid&list={$smarty.request.list}&auction_week_id={$smarty.request.auction_week_id}"></a></li>
                              {/if}
                            </ul>
                          </div>
						  <div class="soldSearchblock">
                            	
							<div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;">
                                    <input type="text" style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;" class="midSearchbg_edit fll" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}" {elseif $smarty.request.list == 'stills'} value="Search Stills.." {else} value="Search Auctions.."{/if} onclick="clear_text();" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
			key_search_buy(list);
			}	
		}); {/literal}" onblur="key_search_buy_clear()"   />
                                <input type="button" class="rightSearchbg" value=""  onclick="search_buy_items_func('{$smarty.request.list}')" />
                                </div>
                            </div>
                          <div class="sortblock">{$displaySortByTXT}</div>
                          {if $smarty.request.list=='stills'}
							<div class="msgsearchnorecords"> Sorry no records found.</div>
					    {else}		
							<div class="msgsearchnorecords"> Sorry no records found.</div>
						{/if}
                          
                        </div>
                        {/if}
                        {if $total > 0} 
                        {if $smarty.session.sessUserID <> "" && ($is_expired=='0' && $is_expired_stills !='1') }
                        <div class="light-grey-bg-inner">
                          <div class="inner-grey SelectionBtnPanel">
                            <div style="float:left; padding:0px; margin:0px;">
                              <input type="button" class="select-all-btn" onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                              <input type="button" class="deselect-all-btn"  onclick="javascript: unMarkSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                           
                            <input type="button" class="watch-slctd-btn" onclick="this.form.submit();" value="" />
                             </div>
                            {*<a href="#"><strong>How to Order?</strong></a>*}
                            {if $smarty.request.list == 'fixed' }
                            <input type="button" class="place-all-offers-btn" onclick="placeAllBids(dataArr);" value=""/>
                            {else}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value=""/>
                            {/if} </div>
                          <div class="clear"></div>
                        </div>
                        {/if}
                        {/if}
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                  <!--<div class="btm-mid">
                    <div class="btom-left"></div>
                  </div>
                  <div class="btom-right"></div>-->
                </div>
              </form>
            </div>
            
            
            
          </div>
        </div>
      </div>
      
       </div>
         <!--- Rightside Panel --->     
        
{include file="gavelsnipe.tpl"}        
        
        

    <!-- page listing ends -->
  </div>
  <div class="clear"></div>
</div>
{include file="foot.tpl"}
 {literal}
 <script type="text/javascript">
 {/literal}
	    {if $smarty.request.list=='stills'}
		 
	{literal}
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeft(dataArr,list); }, 2500);
			setTimeout(function() { timeLeft(dataArr,list); }, 3000);
	{/literal}
	    {elseif $smarty.request.list=='fixed'}
		 
	{literal}
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeft(dataArr,list); }, 2000);
			setTimeout(function() { timeLeft(dataArr,list); }, 3000);
	{/literal}
		 
		{else}
	{literal}	
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeft(dataArr,list); }, 1500);
			setTimeout(function() { timeLeft(dataArr,list); }, 3000);
	{/literal}		
		{/if}
	{literal}
		if(list=='fixed'){
			$(window).scroll(function() {   
			if($(window).scrollTop() + $(window).height() == $(document).height()) {
			   //renderHtml()
			   }
			});
	    }

		
 </script>
 
 <script type="text/babel">
 

var Dropdown = React.createClass({
		getInitialState () {
			return { value: '',job:'' };
		},
		updateValue (value) {                
			this.setState({ value: value });
			if(value){segmentID=value.value;segmentName=value.label}                        
			else{segmentID=0;segmentName=''}
				
		},
		componentDidMount: function() {
			var _this = this;
			this.serverRequest = 
			  axios
				.get("/buy?mode=react&offset=99&toshow=20")
				.then(function(result) { 
					var seglistA=result.data;
				  _this.setState({
					job: seglistA
				  });
				  
				})
				
		},
		render () { 
			var items = [];                   
			console.log(this.state.job.length)
			for (var i = 0; i < this.state.job.length; i++) {
            var item = this.state.job[i];
			console.log(item)
            items.push(<div className="buylist pt20 pb20" >
						 <table width="711" cellspacing="0" cellpadding="0" border="0">
							 <tbody><tr>
								<td width="25" valign="top" className="pt10 tac">	</td>
								<td width="200" className="buylisttb">
									<div>
										<a href="http://54.213.214.96/buy?mode=poster_details&amp;auction_id=16232&amp;fixed=1"><img src="http://c4941379.r79.cf2.rackcdn.com/23546.jpg" className="image-brdr" /></a>
									</div>
									<input type="button" id="watch_16232" onclick="add_watchlist(16232);" className="track-btn" value="Watch this item" />
								</td>
								 <td valign="top" className="pr10">
									<div className="popDiv_Auction" id="16232"> </div>
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
										<tr>
											<td className="pb20"><h1><a style={{cursor:'pointer'}} href="http://54.213.214.96/buy?mode=poster_details&amp;auction_id=16232"><strong>Beautiful Creaures&nbsp;</strong></a> </h1></td>
										</tr>
										<tr>
											<td className="buylisttbtopbg"></td>
										</tr>
										<tr>
											<td className="pb10">
												<div className="descrp-area">
													<div className="desp-txt"><b>Size : </b> Other</div>
													<div className="desp-txt"><b>Genre : </b> Other</div>
													<div className="desp-txt"><b>Decade : </b> 2010 - To Date </div>
													<div className="desp-txt"><b>Country : </b> United States</div>
													<div className="desp-txt"><b>Condition : </b> 8.0 Very Fine</div>
												</div>
											</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr></tbody>
						</table>
					</div>);
        	}
			
			return (
				<div>
					{items}		
				</div>
				
			);
		}
	});


 
 function renderHtml(){
 	var fkh= fk+1;
	ReactDOM.render(
			  <Dropdown />,
			  document.getElementById('root'+fk)
			  )
	$('#root'+fk).after('<div id="root'+fkh+'" class="display-listing-main mb02"></div>');
	fk++;
 }
 </script>
 {/literal}
 
{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>

{literal}
<style type="text/css">.popDiv { position:absolute; min-width:120px; list-style-type:none; background-color:#881318; color:#fff; z-index:1000;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:150px; margin-top:45px;visibility:hidden;}
.popDiv_Auction { position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ;color:white; z-index:1000;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:150px; margin-top:45px;visibility:hidden;}

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

		<div id="inner-container">
        	{include file="right-panel.tpl"}
            <div id="center"><div id="squeeze"><div class="right-corner">
            
			<div id="inner-left-container">
            
            <div id="tabbed-inner-nav">
				<div class="tabbed-inner-nav-left">
					<ul class="menu">
						{*<li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/buy.php"><span>See all Items</span></a></li>*}
						<li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy.php?list=fixed"><span>Poster Shop</span></a></li>
						{if $live_count<=1}
                    	<li {if $smarty.request.list == 'weekly' && $smarty.request.track_is_expired != '1'}class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly"><span>{if $totalLiveWeekly > 0}{$auctionWeeksData[0].auction_week_title}{else}{$latestEndedAuction} Results{/if}</span></a></li>
                    	{*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy.php?list=monthly"><span>Event Auctions</span></a></li>*}
                    	{if $upcomingTotal >0}
                    		<li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy.php?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						{else}
							<li {if $smarty.request.track_is_expired == '1'}class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly&track_is_expired=1"><span> {$latestEndedAuction} Results</span></a></li>
						{/if}
						{elseif $live_count>1}
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[0].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly&auction_week_id={$auctionWeeksData[0].auction_week_id}"><span>{$auctionWeeksData[0].auction_week_title}</span></a></li>
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[1].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly&auction_week_id={$auctionWeeksData[1].auction_week_id}"><span>{$auctionWeeksData[1].auction_week_title}</span></a></li>	
						{/if}
						{if $extendedAuction != ""}					    
							<li {if $smarty.request.list == 'extended'} class="active" {/if}><a href="{$actualPath}/buy.php?list=extended&view_mode=grid"><span>Extended Auction {$extendedAuction}</span></a></li>
						{/if}
					    <li {if $smarty.request.list == 'alternative'} class="active" {/if}><a href="{$actualPath}/buy.php?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
					</ul>
                     
				</div>	
            </div>
                
                  <form name="listFrom" id="listForm" action="" method="post" onsubmit="return false;">
                 <input type="hidden" id="mode" name="mode" value="select_watchlist" />
                 <input type="hidden" name="is_track" id="is_track" value="" />
				 <input type="hidden" name="offset" value="{$offset}" />
				 <input type="hidden" name="toshow" value="{$toshow}" />
				 <input type="hidden" name="is_expired" id="is_expired" value="{$is_expired}" />
				 <input type="hidden" name="is_expired_stills" id="is_expired_stills" value="{$is_expired_stills}" />
				 <input type="hidden" name="auction_week_id" id="auction_week_id" value="{$smarty.request.auction_week_id}" />
				 <input type="hidden" id="auction_week_end_time" name="auction_week_end_time" value='{$auction_week_end_time}' />
				
				<div class="innerpage-container-main">
                
					<div class="top-mid"><div class="top-left"></div></div>
               
                    
                    
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg">   
					<div class="mid-rept-bg">
					 {if $smarty.request.mode=='search'}
					  	<div class="messageBox"> You have searched for {$cat_value}</div>
					  {/if}
					{if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    	{if $total > 0}
                            <div class="top-display-panel">
							{if $smarty.request.list!=('alternative'|| 'extended')}
                                <div class="left-area">
                                    <div class="dis">View as {$total} :</div>
                                    <ul class="menu">
									{if $smarty.request.keyword!='' && $smarty.request.mode=='key_search'}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}&search_type={$smarty.request.search_type}&is_expired={$is_expired}&is_expired_stills={$is_expired_stills}&auction_week_id={$smarty.request.auction_week_id}"></a> </li>
									{elseif $smarty.request.mode=='search' || $smarty.request.mode=='dorefinesrc'}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode={$smarty.request.mode}&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a></li>	
									{elseif $smarty.request.mode=='key_search_global'}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode={$smarty.request.mode}&is_expired=0&auction_week_id=&is_expired_stills=&keyword={$smarty.request.keyword|urlencode}"></a></li>	
									{else}
                                        <li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&auction_week_id={$smarty.request.auction_week_id}"></a> </li>
									{/if}	
                                        |
                                        <li class="grida"><span class="active"></span></li>
                                    </ul>
                                </div>
								{/if}
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
								<div class="results-area" style="width:200px;;">{$displayCounterTXT}</div>
								{if ($smarty.request.list == "fixed")}
								<div  style="width:500px;"><input type="button" value="Press to Shuffle Inventory" class="track-btn" id="track-btn-id" onclick="shufflePage()" style="width:200px;background-repeat:repeat" /></div>
								{/if}
								<div class="pagination" {if ($smarty.request.list == "fixed")}style="margin-top:-20px;" {/if} >{$pageCounterTXT}</div>
							  </div>
						  </div>
                        {/if}
                        {if $smarty.session.sessUserID <> ""}					
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        {/if}
                        <div class="clear"></div>
                        {if $total > 0}
                        				
                            <div class="light-grey-bg-inner">
                               {if ($smarty.request.list == ("weekly" || "extended") ) && ($is_expired=='0' && $is_expired_stills!='1') }
                                    <div class="inner-grey SelectionBtnPanel" >
										
                                        <div style="float:left; padding:0px; margin:0px;">
										{if $smarty.session.sessUserID <> ""}
                                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="" />
										{else}	
										  &nbsp;
										{/if}	
                                        </div>
									

                                        <div class="time_auction" id="auction_{$auctionItems[0].auction_id}">
                                            {* <div class="bid-time">
                                                <div class="time-left boldItalics">Time Left</div>
                                            </div> *}
                                            
                                            <!--<div class="text-timer" id="timer_{$auctionItems[0].auction_id}">{$auctionItems[0].auction_countdown}</div>-->
                                            
                                        </div>

                                    </div>
                                {/if}
                            </div>
                            
                            				
                            <div class="display-listing-main buygrid"> 
 

                            <div>  
                            <div class="btomgrey-bg"></div>                 
                                {section name=counter loop=$auctionItems}	
                               
                                    <div>							
                                    <div {if $smarty.session.sessUserID == ""} class="grid-view-main gridMrgn" {else} class="grid-view-main " {/if} style="padding:4px 0;">

                                        <div class="poster-area">
                                             <div class="inner-cntnt-each-poster">
                                                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                     <div class="buygridtb" style="padding:2px; text-align:center; height:170px;">
                                       					<div style="padding:2px; margin-bottom:2px;">
														{if $auctionItems[counter].fk_auction_type_id=='1'}
															<a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&fixed=1"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
														{elseif $smarty.request.list=='extended'}
															<a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&extended=true"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
														{else}
															<a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
														{/if}
                                                        
                                                        </div>
                                                      </div>
                                                        {if ($smarty.request.list=='alternative' || $smarty.request.list=='') && $auctionItems[counter].fk_auction_type_id == 6}
                                                        <div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].poster_title}</a></h3></div>
														 <div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].artist}</a></h3></div>	
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].poster_size}</a></h3></div>
														{if $auctionItems[counter].field_1 <> ''}
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].field_1}</a></h3></div>
														{/if}
														{if $auctionItems[counter].field_2 <> ''}
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].field_2}</a></h3></div>
														{/if}
														{if $auctionItems[counter].field_3 <> ''}
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].field_3}</a></h3></div>
														{/if}
														{elseif $smarty.request.list=='fixed'}
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&fixed=1" style="cursor:pointer;" >{$auctionItems[counter].poster_title}</a></h3></div>
														{elseif $smarty.request.list=='extended'}
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}&extended=true" style="cursor:pointer;" >{$auctionItems[counter].poster_title}</a></h3></div>
														{else}
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].poster_title}</a></h3></div>
														{/if}	
                                                         {if $is_expired=='0' && $is_expired_stills !='1' && $smarty.request.list!='alternative' &&  $smarty.request.list!=''}
														   {if $auctionItems[counter].fk_auction_type_id <> '1'}
                                            				<div class="inner-cntnt-each-poster pt10  pb05 pl10 pr10">                                        
                                                			  <div class="tac">
																{if $auctionItems[counter].watch_indicator ==0}	
																  {if $smarty.request.list!='extendded'}
																	<div class="timerwrapper" style="float:right">
																 	<!-- <div class="timer-left"></div>-->
																  	<div class="text-timer" id="timer_{$auctionItems[counter].auction_id}" style="background:#003878; background-image:none; color:#fff; border-radius:3px;">{$auctionItems[counter].auction_countdown}</div>
																  	<!--<div class="timer-right"></div>-->
																  	</div>
																	<input type="button" value="Watch" class="track-btn" style="width:60px;" onclick="add_watchlist_for_details({$auctionItems[counter].auction_id});" id="watch_{$auctionItems[counter].auction_id}" />
																  {/if}
																{else}
																	<div class="timerwrapper" style="float:right">
																 	<!-- <div class="timer-left"></div>-->
																  		<div class="text-timer" id="timer_{$auctionItems[counter].auction_id}" style="background:#003878; background-image:none; color:#fff; border-radius:3px;">{$auctionItems[counter].auction_countdown}</div>
																  		<!--<div class="timer-right"></div>-->
																  	</div>
																	<input type="button" value="Watching" style="width:60px;" onclick="redirect_watchlist({$auctionItems[counter].auction_id});" class="track-btn"  />
													
																{/if}
                                                               </div>
                                                            </div>
															{else}
															<div class="pb05 pl10 pr10 tac" ><h3>Buy Now Price:&nbsp;${$auctionItems[counter].auction_asked_price}</h3></div>
															{/if}
														{/if}
                                            
                                            	<div class="inner-cntnt-each-poster pb05 pl10 pr10">
                                            {if $auctionItems[counter].fk_auction_type_id == 1 }	
                                                <div id="auction_data_{$auctionItems[counter].auction_id}">
                                                    {if $auctionItems[counter].offer_count > 0}
                                                        <div class="auction-row">
                                                            
                                                        </div>
                                                    {/if}
                                                </div>
												<!--   popup starts -->
												<div id="{$auctionItems[counter].auction_id}" class="popDiv_Auction">
												
                                    			</div>
												<!--   popup ends -->
                                            {elseif $auctionItems[counter].fk_auction_type_id == 2 || $auctionItems[counter].fk_auction_type_id == 5}
                                                
													
												
                                                {if ($smarty.request.list == "weekly" || $smarty.request.list == "extended") && ($is_expired == '0' && $is_expired_stills!='1') }
												<div class="bid-time" >
                                                        <div class="left-side1"  style="margin-right: 12px;">
                                                            <div class="text-grid CurrencyDecimal fll"  style="font-size:15px;">&#36;</div>
                                                            <div class="txtdivd fll"><input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="bid_price_{$auctionItems[counter].auction_id}" maxlength="8"  onfocus="{literal}$(this).keypress(function(event){
                                                                    var keycode = (event.keyCode ? event.keyCode : event.which);
                                                                    if(keycode == '13'){
                                                                    var auc_id=this.id;
                                                                    test_enter_for_bid(auc_id);
                                                                    }
                                                                    }); {/literal}" onblur="test_blur_for_bid(this.id)" style="width:40px;" /></div>
                                                            <div class="CurrencyDecimal" style="font-size:15px;">.00</div>
                                                        </div>
                                                        <div class="left-side fll">
														<input type="button" id="bid_bttn_{$auctionItems[counter].auction_id}" value="" onclick="postBid({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}');" class="bidnow-hammer-btn2" /></div>
                                                    </div>
												<div id="auction_data_{$auctionItems[counter].auction_id}" >
                                                    {if $auctionItems[counter].bid_count > 0}
                                                        
                                                    {/if}
                                                </div>
												
												{if ($is_expired == '0' && $is_expired_stills!='1')}
												<!--   popup starts -->
												<div id="{$auctionItems[counter].auction_id}" class="popDiv">
												
                                    			</div>
												
												{/if}	
                                                    
                                                {elseif ($smarty.request.list == "weekly" || $smarty.request.list == "stills") && ($is_expired == '1' ||  $is_expired_stills =='1') }
													<div class="auction-row" style="padding:0px;">
													
													 <div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:13px; color:#000;">Sold Price:</span> </div>
													 <div class="buy-text offer_buyprice" style="font-size:13px;">${$auctionItems[counter].last_bid_amount}</div><div  class="buy-text-detpstr" >&nbsp;<b class="OfferBidNumber" style="font-size:13px;">{$auctionItems[counter].bid_count} Bid(s)&nbsp;&nbsp;</b> </div>
													 
													</div>
                                                {/if}
                                                {elseif $auctionItems[counter].fk_auction_type_id == 3}
                                                <div id="auction_data_{$auctionItems[counter].auction_id}">
                                                    {if $auctionItems[counter].last_bid_amount > 0}
                                                        <div class="auction-row">
                                                            
                                                        </div>
                                                    {/if}
                                                </div>
												<!--   popup starts -->
												<div id="{$auctionItems[counter].auction_id}" class="popDiv">
												
                                    			</div>
												
                                            {/if}
											{if ($smarty.request.list=='alternative' || $smarty.request.list=='') && $auctionItems[counter].fk_auction_type_id == 6 && $auctionItems[counter].quantity > 0}
													<div class="bid-time" >
                                                        <div class="left-side1"  style="margin-right: 12px;">
                                                            <div class="text-grid CurrencyDecimal fll"  style="font-size:15px;">&#36;{$auctionItems[counter].auction_asked_price}</div>
                                                            
                                                        </div>
                                                        <div class="left-side fll">
														<input type="button" id="buynow_bttn_{$auctionItems[counter].auction_id}" value="" onclick="redirect_to_cart({$auctionItems[counter].auction_id}, '{$auctionItems[counter].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" /></div>
                                                    </div>
												{elseif ($smarty.request.list=='alternative' || $smarty.request.list=='') && $auctionItems[counter].fk_auction_type_id == 6 && $auctionItems[counter].quantity == 0}
													<div class="auction-row" style="padding:0px;">
													
													 <div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:13px; color:#000;">
													 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													 <input type="button" value="Sold" class="track-btn" onclick="javascript:void(0);"></span> </div>
													 {*<div class="buy-text offer_buyprice" style="font-size:13px;">${$auctionItems[counter].auction_asked_price}</div>*}
													 
													</div>	
												{/if}
                                            </div>
                                            
                                            
                                            
                                                        
                                              </div>                                            
                                           </div>
                                        </div>
                                       
                                    </div>
                                    </div>
                                    {if ($smarty.section.counter.index) != 0}
                                        {if (($smarty.section.counter.index +1) % 4) == 0} 
                                         <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
                                         <div class="btomgrey-bg"></div> {/if}
                                    {/if} 
                                {/section} 
                                  <div class="btomgrey-bg"></div>  
                                </div>
                            </div>
                            
                            <div class="top-display-panel2">
                              <div class="left-area">
                                <div class="results-area">{$displayCounterTXT}</div>
                                <div class="pagination" style="width:270px;">{$pageCounterTXT}</div>
                              </div>
							</div>
						{else}
						    <div class="top-display-panel">
								{if $smarty.request.list!='extended'}
                                <div class="left-area">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
									{if $smarty.request.keyword!=''}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode=key_search&keyword={$smarty.request.keyword|urlencode}&search_type={$smarty.request.search_type}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a> </li>
									{elseif $smarty.request.mode=='search' || $smarty.request.mode=='dorefinesrc'}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode={$smarty.request.mode}&poster_size_id={$smarty.request.poster_size_id}&genre_id={$smarty.request.genre_id}&decade_id={$smarty.request.decade_id}&country_id={$smarty.request.country_id}&is_expired={$is_expired}&auction_week_id={$smarty.request.auction_week_id}"></a></li>	
									{else}
                                        <li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&auction_week_id={$smarty.request.auction_week_id}"></a> </li>
									{/if}	
                                        |
                                        <li class="grida"><span class="active"></span></li>
                                    </ul>
                                </div>
								{/if}
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
                                
								{if $smarty.request.list=='weekly'} 
									<div class="msgsearchnorecords"> Sorry no records found. </div>
								{elseif $smarty.request.list=='monthly'}
									<div class="msgsearchnorecords"> There are currently no Event auctions scheduled at this time.</div>
								{elseif $smarty.request.list=='stills'}
									<div class="msgsearchnorecords"> Sorry no records found.</div>	
								{else}
									<div class="msgsearchnorecords"> Sorry no records found.</div>	
								{/if}
                            </div>
						
							
                        <div class="top-display-panel2">&nbsp;</div>
						{/if}
                        {if $smarty.session.sessUserID <> ""}
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        {/if}
						{if $total > 1}
                            {if $smarty.session.sessUserID <> ""}
                            <div class="light-grey-bg-inner">
                               {if ($smarty.request.list == "weekly" || $smarty.request.list == "extended") && ($is_expired=='0' && $is_expired_stills!='1')}
                                    <div class="inner-grey SelectionBtnPanel">
                                        <div style="float:left; padding:0px; margin:0px;">
                                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);"  />
                                        </div>

                                        <div class="time_auction" id="auction_{$auctionItems[1].auction_id}">
										{* <div class="bid-time">
                                                <div class="time-left boldItalics">Time Left</div>
                                            </div> *}
                                            
                                            <!--<div class="text-timer" id="timer_{$auctionItems[0].auction_id}">{$auctionItems[0].auction_countdown}</div>-->
                                            
                                        </div>

                                    </div>
                                {/if}
                            </div>
                            
                            {/if}
						{/if}	
                        <div class="clear"></div>			
					</div>
                    </div>
                    </div>
                    
                    
					<!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
				</div>
				</form>	
			</div>	
			
             </div></div></div>	
			
		</div>
         
	<!-- page listing ends -->
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}


{literal}
<script type="text/javascript">

$(document).ready(function(){
    {/literal}
	    {if $smarty.request.list=='alternative'}
		 {if $liveStilltrack ==1}
	{literal}
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 1500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);

	{/literal}
		 {/if}
		 {elseif $smarty.request.list=='stills'}
		 
	{literal}
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 2500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);
	{/literal}
		{else}
			{if $is_expired !='1'}	
	{literal}	
			dataArr = {/literal}{if $json_arr!=''}{$json_arr}{else} ''{/if}{literal};
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 1500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);
	{/literal}	
	       {/if}	
		{/if}
	{literal}
})


</script>
<script type="text/javascript">
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
	/*if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"*/
	}
	else
	if (flagit=="0"){
	document.getElementById(''+id+'').style.visibility = "hidden";
	/*if (document.layers) document.layers[''+id+''].visibility = "hide"
	else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"*/
	}
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
		window.location.href="buy.php?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
	}
	function key_search_buy(list){
		var search_text= $('#search_buy_items').val();
		var is_expired = $('#is_expired').val();
		var is_expired_stills = $('#is_expired_stills').val();
		var auction_week_id = $('#auction_week_id').val();
		window.location.href="buy.php?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
		return false;
	}
	function key_search_buy_clear(){
		$('#search_buy_items').unbind('keypress');
		//$('#search_buy_items_func').unbind('click');
	}
    function test_enter_for_bid(auction_id){
        var newData = auction_id.split("_");
        $('#'+newData[2]).html("");
        $("#bid_bttn_"+newData[2]).click();
    }
    function test_blur_for_bid(auction_id){
        var newData = auction_id.split("_");
        $('#'+auction_id).unbind('keypress');
        $('#bid_bttn_'+newData[2]).unbind('click');
    }
	function shufflePage(){
			var newUrl =  {/literal}'{$Newlink}'{literal}.replace(/\&amp;/g,'&')
			window.location.href=newUrl;
		}
</script>
{/literal}
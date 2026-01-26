{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>
{literal}
<script type="text/javascript">
        function clear_text(){
            if($("#search_buy_items").val()=='Search item in Upcoming Auctions..'){
                document.getElementById('search_buy_items').value='';
            }
        }
	
		
		function search_buy_items_func(list){
			var search_text= $('#search_buy_items').val();
			var auction_week= $('#auction_week').val();
			var list= $('#list').val();
			window.location.href="buy.php?list="+list+"&mode=key_search_upcoming&keyword="+search_text+"&auction_week="+auction_week+"&list="+list;
		}
		function key_search_buy(list){
			var search_text= $('#search_buy_items').val();
			var auction_week= $('#auction_week').val();
			var list= $('#list').val();
			window.location.href="buy.php?list="+list+"&mode=key_search_upcoming&keyword="+search_text+"&auction_week="+auction_week+"&list="+list;
		}
		function key_search_buy_clear(){
			$('#search_buy_items').unbind('keypress');
			//$('#search_buy_items_func').unbind('click');
		}
		function sort_upcoming_auction(auction_week){
			//$('#mode').val("");
			//document.forms["listFrom"].submit();
			window.location.href="buy.php?list=upcoming&auction_week="+auction_week;
		}
</script>
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
					<ul class="menu" >
						{*<li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/buy.php"><span>See all Items</span></a></li>*}
						<li {if $smarty.request.list == 'fixed'}class="active"{/if}><a href="{$actualPath}/buy.php?list=fixed"><span>Fixed Price</span></a></li>
						{if $live_count<=1}
                    		<li {if $smarty.request.list == 'weekly'}class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly"><span>{if $totalLiveWeekly > 0}{$auctionWeeksData[0].auction_week_title}{else}{$latestEndedAuction} Results{/if}</span></a></li>
                    		{*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy.php?list=monthly"><span>Event Auctions</span></a></li>*}
                    		<li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy.php?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						{elseif $live_count>1}
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[0].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly&auction_week_id={$auctionWeeksData[0].auction_week_id}"><span>{$auctionWeeksData[0].auction_week_title}</span></a></li>
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[1].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy.php?list=weekly&auction_week_id={$auctionWeeksData[1].auction_week_id}"><span>{$auctionWeeksData[1].auction_week_title}</span></a></li>	
						{/if}
                        {if $extendedAuction != ""}					    
						    <li {if $smarty.request.list == 'extended'} class="active" {/if}><a href="{$actualPath}/buy.php?list=extended&view_mode=grid"><span>Extended Auction {$extendedAuction}</span></a></li>
						{/if}
						<li {if $smarty.request.list == 'alternative'} class="active" {/if}><a href="{$actualPath}/buy.php?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
						{*<li {if $smarty.request.list == 'stills'} class="active" {/if}><a href="{$actualPath}/buy.php?list=stills"><span>Fixed Price Stills</span></a></li>*}
					</ul>
				
                	</div>
				</div>		
                 <form name="listFrom" id="listForm" action="" method="post" onsubmit="return false;">
                 <input type="hidden" name="mode" value="select_watchlist" />
                 <input type="hidden" name="is_track" id="is_track" value="" />	
				 <input type="hidden" name="auction_week" id="auction_week" value="{$smarty.request.auction_week}" />	
				 <input type="hidden" name="list" id="list" value="{$smarty.request.list}" />	 
				<div class="innerpage-container-main">
					<div class="top-mid"><div class="top-left"></div></div>
                
                    
                     <div class="left-midbg"> 
                    <div class="right-midbg"> 
					<div class="mid-rept-bg">
					{if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    	{if $total > 0}
						<div class="top-display-panel">
                                <div class="left-area_auction" style="width:150px;">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
									{if $smarty.request.keyword!=''}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode=key_search_upcoming&keyword={$smarty.request.keyword}">&nbsp;</a> </li>
									{else}
                                        <li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}">&nbsp;</a> </li>
									{/if}
                                        |
                                        <li class="grida"><span class="active">&nbsp;</span></li>
                                    </ul>
                                </div>
								<div class="soldSearchblock" style="clear:right;">
                            	
								<div style="width:500px; height:26px; border:1px solid #cecfd0; float:left;">
                                    <input style="width:450px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 5px;" type="text" class="midSearchbg_auction fll" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search_upcoming'} value="{$smarty.request.keyword}" {else} value="Search item in Upcoming Auctions.."{/if} onclick="clear_text()" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= {/literal}{if $smarty.request.list==''}''{else}'{$smarty.request.list}'{/if}{literal};
			key_search_buy(list);
			}	
		}); {/literal}" onblur="key_search_buy_clear()"  />
                                <input type="button" class="rightSearchbg" value="" onclick="search_buy_items_func('{$smarty.request.list}')" />
                            </div>
                            </div>
                            {if $smarty.request.list != 'stills'}
							<div class="sortblock_auction2" style="clear: both; width: 280px; margin-top:8px; margin-left:0; text-align:left;" ><span class="headertext">Sort By Auction:&nbsp;</span>
						  <select name="auction_week"  class="look" onchange="sort_upcoming_auction(this.value);">
                                 <option value="" selected="selected">All Auction</option>
                                 {section name=counter loop=$UpcomingAuctionWeeks}
                                     <option value="{$UpcomingAuctionWeeks[counter].auction_week_id}" {if $smarty.request.auction_week == $UpcomingAuctionWeeks[counter].auction_week_id} selected {/if} >{$UpcomingAuctionWeeks[counter].auction_week_title}</option>
                                 {/section}
                             </select></div>
							{/if} 
                                <div class="sortblock_auction" {if $smarty.request.list != 'stills'} style="margin-top: 8px;" {else} style="clear: both; width: 280px; margin-top:8px; margin-left:0; text-align:left;" {/if}>{$displaySortByTXT}</div>
                                
								
                            </div>
							<div class="top-display-panel2"> 
							<div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
							  </div>
						   </div>
						   
						   
                            
                        {/if}
                        {if $smarty.session.sessUserID <> ""}					
						<div class="light-grey-bg-inner">
                        <div class="inner-grey">
							<!--  <div class="left-submenu">
							<span class="goto-span"><strong>GO TO: <u>FIXED PRICE</u></strong></span>
							<ul class="menu">
								<li>[<a href="{$actualPath}/offers.php">My Outgoing Counters</a>]</li>
                                <li>[<a href="{$actualPath}/offers.php?mode=incoming_counters">My Incoming Counters</a>]</li>
							</ul>
							</div>-->
							
                            </div>
						</div>
                        
                        {/if}
                        <div class="clear"></div>
                        {if $total > 0}
                        				
                            <div class="light-grey-bg-inner">                                
                                    <div class="inner-grey SelectionBtnPanel" > 
                                    
                                    <div style="float:left; padding:0px; margin:7px 0px;">
                                            &nbsp;
                                        </div>                                

                                        <div class="time_auction" id="auction_{$auctionItems[0].auction_id}">
                                            <div class="bid-time">
                                                <div class="time-left boldItalics">To Start</div>
                                            </div>
                                            
                                            <div class="text-timer" id="timer_{$auctionItems[0].auction_id}">{$auctionItems[0].auction_countdown}</div>
                                            
                                        </div>

                                    </div>                               
                            </div>
                            
                            				
                            <div class="display-listing-main buygrid">    
                            <div>   
							<div class="btomgrey-bg"></div>                    
                                {section name=counter loop=$auctionItems}	
                                    <div>							
                                    <div {if $smarty.session.sessUserID == ""} class="grid-view-main gridMrgn" {else} class="grid-view-main " {/if}>
                                    {if $smarty.session.sessUserID <> ""}
                                  
                                     {/if}
                                        <div class="poster-area">
                                        <div style=" margin:0px; padding:0px; float:left; ">

                                        </div>
                                          
                                           
                                            
<!--                                            {if $auctionItems[counter].fk_auction_type_id == 3}-->
<!--                                                <div class="desp-txt" style="padding-left:0; margin-left:0;">&nbsp;&nbsp;<b class="EventType" style="border:none; padding-right:0; padding-top:0; padding-bottom:0;">Event :{$auctionItems[counter].event_title}</b></div>-->
<!--                                            {/if}-->
                                             <div class="inner-cntnt-each-poster">
                                                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                     <div class="buygridtb">
                                      					<div>
                                       						<a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}"><img  class="image-brdr"  src="{$auctionItems[counter].image_path}"   /></a>
                                                         </div>
                                                     </div>
                                                     
                                                     <div class="pb05 pl10 pr10"><h3> <a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$auctionItems[counter].auction_id}" style="cursor:pointer;" >{$auctionItems[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$auctionItems[counter].poster_sku}){/if*}</a></h3></div>	
                                                </div>   
                                                
                                                <div class="inner-cntnt-each-poster pt10  pb05 pl10 pr10">                                        
                                                <div class="tal">
                                                    {if $auctionItems[counter].watch_indicator ==0}	
														<input type="button" value="Watch this item" class="track-btn"  onclick="javascript: add_watchlist({$auctionItems[counter].auction_id});" />
                                                    {else}
                                                        <input type="button" value="You are watching&nbsp;&nbsp;" class="track-btn" onclick="redirect_watchlist({$auctionItems[counter].auction_id});" />

                                                    {/if}
                                                    <!--<input type="button" class="bidnow-btn" value="Details" onclick="redirect_poster_details({$auctionItems[counter].auction_id});" />-->
                                                 </div>
                                            </div>                                         
                                               
                                             </div>										
                                            
                                            <!--<div class="inner-cntnt-each-poster">
                                            {if $auctionItems[counter].fk_auction_type_id == 2}
                                                <div id="auction_{$auctionItems[counter].auction_id}">
                                                    <div class="bid-time">
                                                        <div class="buy-text boldItalics">Time To Start</div>
                                                    </div>
                                                    <div class="timer-left"></div>
                                                    <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                                                    <div class="timer-right"></div>                                                   
                                                    <div class="auction-row">
                                                        <div class="text-grid boldItalics">Start Time:</div>
                                                        <div class="text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                        <div class="bold text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%A"}</div>
                                                        <div class="text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                                    </div>
                                                    <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                                                        <div class="text-grid boldItalics">End Time:</div>
                                                        <div class="text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                        <div class="bold text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                                        <div class="text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                                    </div>
                                                </div> 
                                                {elseif $auctionItems[counter].fk_auction_type_id == 3}
                                                <div id="auction_{$auctionItems[counter].auction_id}">
                                                <div class="bid-time">
                                                    <div class="time-left boldItalics">Time To Start</div>
                                                </div>
                                                <div class="timer-left"></div>
                                                <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                                                <div class="timer-right"></div>
                                                <div class="auction-row">
                                                    <div class="text-grid boldItalics">Start Time:</div>
                                                    <div class="text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    <div class="bold text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%A"}</div>
                                                    <div class="text-grid">{$auctionItems[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                                </div>
                                                <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                                                    <div class="text-grid boldItalics">End Time:</div>
                                                    <div class="text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    <div class="bold text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                                    <div class="text-grid">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                                </div>
                                                </div>
                                            {/if}
                                            </div>-->
                                           
                                        </div>
                                        </tr>
                                    </div>
                                    </div>
                                    {if ($smarty.section.counter.index) != 0}
                                        {if (($smarty.section.counter.index +1) % 3) == 0} 
                                        <!-- <img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->                                    <div class="btomgrey-bg"></div>{/if}
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
							<div class="top-display-panel" >
						<div>
                          <div class="left-area">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
									{if $smarty.request.keyword!=''}
										<li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}&mode=key_search_upcoming&keyword={$smarty.request.keyword}"></a> </li>
									{else}
                                        <li class="list"><a href="buy.php?view_mode=list&list={$smarty.request.list}"></a> </li>
									{/if}
                                        |
                                        <li class="grida"><span class="active"></span></li>
                                    </ul>
                                </div>
                          <div class="sortblock">
						  <div class="soldSearchblock">
                            <!--<div class="leftSearchbg"></div>-->
                            <div style="width:285px; height:26px;border:1px solid #cecfd0; float:left;">
                            <input type="text" style="width:240px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;"  class="midSearchbg_auction fll" id="search_buy_items" name="search_sold" {if $smarty.request.mode == 'key_search'} value="{$smarty.request.keyword}" {else} value=""{/if} onfocus="{literal}$(this).keypress(function(event){
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
                          
                          
                        </div>
						{if $smarty.request.mode=='search' || $smarty.request.mode=='key_search_upcoming'}
							<div class="msgsearchnorecords">No items currently match your Query. Please check back.</div>
						{else}
							<div class="msgsearchnorecords">There are no scheduled auctions at this time. Please check back soon.</div>
						{/if}
						
						</div>
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
                                <div class="inner-grey SelectionBtnPanel">
                                     <div style="float:left; padding:0px; margin:7px 0px;">
                                            &nbsp;
                                        </div>   
                                    <div class="time_auction" id="auction_{$auctionItems[1].auction_id}">
                                        <div class="bid-time">
                                            <div class="time-left boldItalics">To Start:</div>
                                        </div>
                                        
                                        <div class="text-timer" id="timer_{$auctionItems[1].auction_id}">{$auctionItems[1].auction_countdown}</div>
                                       
                                    </div>

                                </div>
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
           {include file="gavelsnipe.tpl"} 
	<!-- page listing ends -->
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
{include file="header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/lightbox/lightbox-0.5.css" media="screen" />

{literal}
<script type="text/javascript">

function toggleDiv(id,flagit) {
	if (flagit=="1"){
	if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
	}
	else
	if (flagit=="0"){
	if (document.layers) document.layers[''+id+''].visibility = "hide"
	else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"
	}
}
</script>
<style type="text/css">.div {position:absolute;  left: 475px; min-width:100px; list-style-type:none; visibility:hidden;background-color:#006691;color:white; z-index:50;}</style>
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
        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
        
            <div id="inner-left-container">
                <!--Page body Starts-->
                <div class="innerpage-container-main">
                
                  
                  	 <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    
                    <div class="dashboard-main" style="margin-left:0;">
                                <h1>My Closed Items</h1>
                                <!--<p>(*Note:This is an "at a glance view".For complete details please refer to User Section located at right). </p>-->
                                </div>
                    
                    
					<div class="top-display-panel2">
								<div class="sortblock">{$displaySortByTXT}</div>
								<div class="left-area">
									<div class="results-area">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>                        
							</div>


                    
                    <div class="light-grey-bg-inner">
                    	<div class="inner-grey">
                       <!--   <div class="left-submenu">
                        <span class="goto-span"><strong>GO TO: <u>FIXED PRICE</u></strong></span>
                        <ul class="menu">
                            <li>[<a href="{$actualPath}/offers.php">My Outgoing Counters</a>]</li>
                            <li>[<a href="{$actualPath}/offers.php?mode=incoming_counters">My Incoming Counters</a>]</li>
                        </ul>
                        </div>-->
                        <div class="right-submenu">
                            <span class="goto-span"><strong>MY CLOSED ITEMS:</strong></span>
                            <ul class="menu">
                                    <li>[<!--  <a href="{$actualPath}/my_bid.php">My Bids</a>--></li>
                                    <li><img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}losing-bid-img.png" width="13" height="14" border="0"  /><a class="red" href="{$actualPath}/my_bid.php?mode=closed&type=losing">My Losing</a>|</li>
                                    <li><img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" width="13" height="14" border="0" /><a class="green" href="{$actualPath}/my_bid.php?mode=closed&type=winning">My Winning</a>]</li>
                                    <li>[<a href="{$actualPath}/my_bid.php?mode=fixed_puchases">Purchases</a>]</li>
                                </ul>	
                        </div>
                        
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <!--<div class="light-grey-bg-inner">
                    <input type="button" class="select-all-btn" />
                    <input type="button" class="watch-slctd-btn" />
                    <a href="#"><strong>How to Order?</strong></a>
                    <input type="button" class="place-all-bids-btn" />
                    </div>-->
                    <!-- Poster details start-->
                    
                    <div class="display-listing-main buylist pt20 pb20" id="offers">
                        	<div>
                    {if $total > 0}
                        <table class="list-bid-det-main" cellpadding="0" cellspacing="0" border="0">
                        {section name=counter loop=$auctionRows}
                            <tr>
                                <td width="18%" valign="top">
									<div id="gallery_{$smarty.section.counter.index}" class="posterdetails">
                                    <table align="center"><tbody><tr><td align="left" valign="middle" style="border:none;">
									<div class="buylisttb">
                                       <div>
									<img  class="image-brdr" src="{$auctionRows[counter].image_path}" border="0"  border="0" onclick="redirect_poster_details({$auctionRows[counter].auction_id});" style="cursor:pointer;" />
                                    </div>
                                    </div>
                                    </td></tr></tbody></table>
									</div>
                                </td>
                                <td width="15%" valign="top">
                                	<p class="poster-txt" style="cursor:pointer;" onclick="redirect_poster_details({$auctionRows[counter].auction_id});"><b>{$auctionRows[counter].poster_title}</b>&nbsp;{*$auctionRows[counter].poster_sku*}</p>
									<p class="poster-txt">
									{section name=catCounter loop=$auctionRows[counter].categories}
										{if $auctionRows[counter].categories[catCounter].fk_cat_type_id == 1}
										<b>Size : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
										{elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 2}
										<b>Genre : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
										{elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 3}
										<b>Decade : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
										{elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 4}
										<b>Country : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
										{elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 5}
										<b>Condition : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
										{/if}
									{/section}
									</p>
                                </td>
                                <td width="30%" valign="top" style="width:348px; padding:0 15px;"><p class="poster-txt">{$auctionRows[counter].poster_desc}</p></td>
                                <td width="25%" valign="top" class="poster-txt">
                                	{if $auctionRows[counter].count_offer > 0}
                                        <p class="poster-txt" >Total Offers: {$auctionRows[counter].count_offer}</p>
                                        <!-- Tooltip starts Here -->
                                   
                                    	<div id="div_{$auctionRows[counter].auction_id}" class="div">
                                    		<ui>
                                    		{section name=pop_counter loop=$auctionRows[counter].tot_offers}
                                    			<li><b>&nbsp;Amount:</b>&nbsp; ${$auctionRows[counter].tot_offers[pop_counter].offer_amount}&nbsp;</li>
                                    		{/section}
                                    		</ui>
                                    	</div>
                                    
                                    	<!-- Tooltip ends Here -->
                                        <p class="poster-txt">Highest Offer: <b>${$auctionRows[counter].highest_offer}</b></p>
                                    {/if}
                                </td>
                            </tr>
                            {assign var='offers' value=$auctionRows[counter].offers}                            
                            <tr>
                                <td colspan="4">
                                    <div class="gnrl-listing">
                                    	<div style="margin:12px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-bottom:1px solid #DFDFDF;">
                                        <tr>
                                            {*<th width="10%"class="text bold">Offer Accepted/Rejected</th>*}
                                    		<th width="13%" class="text bold">Offer</th>
                                            <th width="27%" class="text bold">Offer's Status</th>
											<th width="13%" class="text bold">Counter Offer</th>
											<th width="27%" class="text bold">Counter Offer's Status</th>
                                    	</tr>
                                        {section name=offerCounter loop=$offers}                                   
                                        <tr>
                                            {*<td align="left">                                            
                                            {if $offers[offerCounter].offer_is_accepted == '1'}
                                            	<img src="images/winning-bid-img.png" border="0" />
                                            {elseif $offers[offerCounter].offer_is_accepted == '2'}
                                            	<img src="images/losing-bid-img.png" border="0" />
                                            {/if}
                                            </td>*}
                                            <td style="border-left:1px solid #DFDFDF;" align="left" class="text">${$offers[offerCounter].offer_amount}</td>
                                            <td id="ofr_status_{$offers[offerCounter].offer_id}" align="left" class="text">
                                            {if $offers[offerCounter].offer_is_accepted == 0}
                                            	Pending
                                            {elseif $offers[offerCounter].offer_is_accepted == 1}
                                            	Accepted
                                            {elseif $offers[offerCounter].offer_is_accepted == 2}
                                            	Rejected
                                            {/if}
                                            </td>
											<td align="left" class="text">
											{if $offers[offerCounter].cntr_offer_id > 0}
												${$offers[offerCounter].cntr_ofr_offer_amount}
											{else}
												--
											{/if}
											</td>
											<td id="cntr_ofr_status_{$offers[offerCounter].offer_id}" align="left" class="text">
											{if $offers[offerCounter].cntr_offer_id > 0}
												{if $offers[offerCounter].cntr_ofr_offer_is_accepted == 0}
													<div style="float:left; padding-right:10px"><input type="button" value="Accept" class="track-btn-small" onclick="acceptOffer({$auctionRows[counter].auction_id}, {$offers[offerCounter].offer_id}, {$offers[offerCounter].cntr_offer_id}, 'buyer');" /></div>
													<div><input type="button" value="Reject" class="track-btn-small" onclick="rejectOffer({$offers[offerCounter].offer_id}, {$offers[offerCounter].cntr_offer_id}, 'buyer');" /></div>
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 1}
                                                	Accepted
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 2}
                                                	Rejected
                                                {/if}
											{else}
												--
											{/if}
											</td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </div>
                                   </div> 
                                </td>                                
                            </tr>
                        {/section}
                        </table>
                    {else}
                    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">No records found!</td>
                                </tr></table>
                    	
                    {/if}
                    	</div>
                    </div>
					{if $total > 0}
                    <div class="top-display-panel2">
								<div class="sortblock">{$displaySortByTXT}</div>
								<div class="left-area">
									<div class="results-area">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>                        
							</div>
					{/if}		
                    <!-- poster details end-->
                    
                    <!--<div class="light-grey-bg-inner">
                    <input type="button" class="select-all-btn" />
                    <input type="button" class="watch-slctd-btn" />
                    <a href="#"><strong>How to Order?</strong></a>
                    <input type="button" class="place-all-bids-btn" />
                    </div>-->
                      
                      <div class="clear"></div>  
                    </div>
                    </div>
                    </div>
                    
                    
                    
                
            </div>
                <!--Page body Ends-->
            </div>  
            
            </div></div></div>      
            
        </div>  
		{include file="gavelsnipe.tpl"}   
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
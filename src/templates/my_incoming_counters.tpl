{include file="header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/lightbox/lightbox-0.5.css" media="screen" />

{literal}
<script type="text/javascript">
$(document).ready(function(){
	var offset= {/literal}{if $smarty.request.offset==''}{0}{else}{ $smarty.request.offset}{/if}{literal};
	var toshow= {/literal}{if $smarty.request.toshow==''}{20}{else}{ $smarty.request.toshow}{/if}{literal};
    var orderBy= {/literal}{if $smarty.request.order_by==''}''{else}'{$smarty.request.order_by}'{/if}{literal};
    var orderType= {/literal}{if $smarty.request.order_type==''}''{else}'{ $smarty.request.order_type}'{/if}{literal};
	setInterval(function() { refreshIncomingCounters(offset,toshow,orderBy,orderType); }, 50000);
})
</script>
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
<style type="text/css">.div { position:absolute; min-width:120px; list-style-type:none; background-color:#006691 ;color:white; z-index:1000;font-size:12px; margin-left:80px;visibility:hidden;}</style>
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
				<form name="listFrom" id="listForm" action="" method="post">
                <input type="hidden" name="mode" value="trackArchived"  >
				<input type="hidden" name="is_seller" value="1"  >
				<div id="tabbed-inner-nav">
                    <div class="tabbed-inner-nav-left">
                        <ul class="menu">
                            <li {if $smarty.request.mode == 'outgoing_counters'}class="active"{/if}><a href="{$actualPath}/offers.php?mode=outgoing_counters"><span>Recent Outgoing Counters</span></a></li>
                            <li {if $smarty.request.mode == 'archived_outgoing_counters'} class="active"{/if}><a href="{$actualPath}/offers.php?mode=archived_outgoing_counters"><span>Archived Outgoing Counters</span></a></li>

                        </ul>
                       
                    </div>
                </div>
                <div class="innerpage-container-main">
                <div class="top-mid"><div class="top-left"></div></div>
                 
                   
                   <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
						{if $errorMessage<>""}
							<div class="messageBox">{$errorMessage}</div>
						{/if}
					<div class="top-display-panel">
						<div class="sortblock" style="width: 160px; margin-left: 0px;">{$displaySortByTXT}</div>
					</div>
                                
					<div class="top-display-panel2">
						<div class="left-area">
							<div class="results-area">{$displayCounterTXT}</div>
							<div class="pagination">{$pageCounterTXT}</div>
						</div>                        
					</div>
                    {if $total > 0}
                        <div class="light-grey-bg-inner">
                            <div class="inner-grey SelectionBtnPanel">
                                <div style="float:left; padding:0px; margin:0px;">
                                    <input type="button" class="select-all-btn" value=""  onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;"/>
                                    <input type="button" class="deselect-all-btn" value="" onclick="javascript: unMarkSelectedRows('listForm'); return false;" style="cursor:pointer;" />
                                </div>
                                <input type="button" class="archive-slctd-btn" onclick="this.form.submit();" value="" style="padding-left:3px;"/>
                            </div>
                            <div class="clear"></div>
                        </div>
                    {/if}
                    
                    <div class="light-grey-bg-inner">
                    	
                        <div class="clear"></div>
                    </div>
                    
                   
                    <!-- Poster details start-->
                    
                    <div id="offers" class="display-listing-main buylist pt20 pb20">
                    <div>
                    {if $total > 0}
                        <table class="list-bid-det-main" cellpadding="0" cellspacing="0" border="0">
                        {section name=counter loop=$auctionRows}
                            <tr>
								<td width="1%" valign="top"><p class="poster-txt"><input type="checkbox" name="auction_id[]" value="{$auctionRows[counter].auction_id}"> </p></td>
                                <td width="18%" valign="top">
									<div id="gallery_{$smarty.section.counter.index}" class="posterdetails">
                                     <table align="center"><tbody><tr><td align="left" valign="top" style="border:none; vertical-align:top;">
											<div class="buylisttb">
                                       <div><img  class="image-brdr" src="{$auctionRows[counter].image_path}" border="0"  border="0" onclick="redirect_poster_details({$auctionRows[counter].auction_id});" style="cursor:pointer;" /></div></div>
                                        </td></tr></tbody></table>
									</div>
                                </td>
                                <td width="21%" valign="top">
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
                                <td width="25%" valign="top"><p class="poster-txt">{$auctionRows[counter].poster_desc}</p></td>
                                <td width="25%" valign="top" class="poster-txt">
                                	{if $auctionRows[counter].count_offer > 0}
                                         <p class="poster-txt" onMouseOver="toggleDiv('div_{$auctionRows[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auctionRows[counter].auction_id}',0)" style="cursor:pointer;">Total Offers: {$auctionRows[counter].count_offer}</p>
										
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
                                    {if $auctionRows[counter].auction_is_sold=='1' || $auctionRows[counter].auction_is_sold=='2'}<p class="poster-txt">Item Status: <b>Sold{elseif $auctionRows[counter].auction_is_sold=='3'}<p >Item Status: <b>Sale Pending{elseif $auctionRows[counter].auction_is_sold=='0'}<p class="poster-txt">Item Status: <b>Selling{/if}</b></p>
                                </td>
                            </tr>
                            {assign var='offers' value=$auctionRows[counter].offers}                            
                            <tr>
                                <td colspan="5">
                                    <div class="gnrl-listing">
                                    <div style="margin:0; border-bottom:1px solid #DFDFDF;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                    		<th width="13%" class="text bold">Offer</td>
                                            <th width="13%" class="text bold">Offer Date</td>
                                            <th width="30%" class="text bold">Counter Offer</td>
                                            <th width="13%" class="text bold">Counter Offer's Status</td>
                                            <th width="13%" class="text bold">Counter Offer Date</td>
                                    	</tr>
                                        {section name=offerCounter loop=$offers}                                   
                                        <tr>
                                            <td style="text-align:center;" class="text">${$offers[offerCounter].offer_amount}</td>
                                            <td style="text-align:center;" class="text">{$offers[offerCounter].post_date|date_format:"%m/%d/%Y"}</td>
											<td id="cntr_ofr_{$offers[offerCounter].offer_id}"   style="text-align:center;" class="text">
                                            {if $offers[offerCounter].cntr_offer_id > 0}
												${$offers[offerCounter].cntr_ofr_offer_amount}
											{elseif $offers[offerCounter].offer_is_accepted != 2}
												{if $auctionRows[counter].auction_is_sold == 0}
												<div style="width:135px; margin:0 auto;"><div class="fll" style="width:10px;">$</div><input type="text" id="cntr_amt_{$offers[offerCounter].offer_id}" class="inner-txtfld" style="width:107px; height:15px; margin-left:5px;" maxlength="7"  /><!-- .00--></div>
                                                <div><input type="button" value="Counter Offer" class="track-btn-small" style="margin: 5px 2px 5px 16px" onclick="makeCounterOffer({$auctionRows[counter].auction_id}, {$offers[offerCounter].offer_id}, $('#cntr_amt_'+{$offers[offerCounter].offer_id}).val(),{$offset},{$toshow});" /></div>
												{else}
													--
												{/if}
											{/if}
											</td>
											<td id="cntr_ofr_status_{$offers[offerCounter].offer_id}" style="text-align:center;" class="text">
											{if $offers[offerCounter].cntr_offer_id > 0}
                                               {if $offers[offerCounter].cntr_ofr_offer_is_accepted == 0}
                                                	Pending
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 1}
                                                	Accepted
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 2}
                                                	Rejected
												{/if}
											{else}
												--
                                            {/if}
                                            </td>
                                            <td class="text" style="text-align:center;">{if $offers[offerCounter].cntr_offer_id > 0} {$offers[offerCounter].cntr_ofr_post_date|date_format:"%m/%d/%Y"}{else} --{/if}</td>
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
						<div class="top-display-panel">
						<div class="sortblock" style="width: 160px; margin-left: 0px;">{$displaySortByTXT}</div>
						</div>
                        
                        <div class="top-display-panel2">
						<div class="left-area">
                            <div class="results-area">{$displayCounterTXT}</div>
                            <div class="pagination">{$pageCounterTXT}</div>
						</div>
                        </div>  
					{/if}
					{if $total > 0}
                        <div class="light-grey-bg-inner">
                            <div class="inner-grey SelectionBtnPanel">
                                <div style="float:left; padding:0px; margin:0px;">
                                    <input type="button" class="select-all-btn" value=""  onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;"/>
                                    <input type="button" class="deselect-all-btn" value="" onclick="javascript: unMarkSelectedRows('listForm'); return false;" style="cursor:pointer;" />
                                </div>
                                <input type="button" class="archive-slctd-btn" onclick="this.form.submit();" value="" style="padding-left:3px;"/>
                            </div>
                            <div class="clear"></div>
                        </div>
                    {/if}
                    <!-- poster details end-->
                    
                    
                       <div class="clear"></div> 
                    </div>
                    </div>
                    </div>
              
            </div>
			</form>
                <!--Page body Ends-->
            </div> 
            
             </div></div></div>       
            
        </div>  
		{include file="gavelsnipe.tpl"}  
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
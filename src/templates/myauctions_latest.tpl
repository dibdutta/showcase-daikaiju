{include file="header.tpl"}
	<script type="text/javascript" src="{$actualPath}/javascript/fancy/jquery-min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="{$actualPath}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
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
function fancy_images(i){
			$("#various_"+i).fancybox({
				'width'				: '60%',
				'min-height'		: '90%',
				'autoScale'			:  false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		}
</script>
<style type="text/css">.div {position:absolute; top:40px; width:250px; list-style-type:none; visibility:hidden;background-color:#006691;color:white; z-index:40;font-size:12px;}</style>
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
                <div id="tabbed-inner-nav">
                <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li {if $smarty.request.mode == 'selling'}class="active"{/if}><a href="{$actualPath}/myselling?mode=selling"><span>Selling</span></a></li>
                        <li {if $smarty.request.mode == 'pending'}class="active"{/if}><a href="{$actualPath}/myselling?mode=pending"><span>Pending</span></a></li>
                        <li {if $smarty.request.mode == 'sold'}class="active"{/if}><a href="{$actualPath}/myselling?mode=sold"><span>Sold</span></a></li>
                        <li {if $smarty.request.mode == 'unsold'}class="active"{/if}><a href="{$actualPath}/myselling?mode=unsold"><span>Unsold/Closed</span></a></li>
                        <li {if $smarty.request.mode == 'upcoming'}class="active"{/if}><a href="{$actualPath}/myselling?mode=upcoming"><span>Up Coming</span></a></li>
                    </ul>
                    <div class="tabbed-inner-nav-right"></div>
				</div>
                </div>           
                <div class="innerpage-container-main">
                   <div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>
                   
                   <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    {if $total > 0}
					<form action="" method="get" onsubmit="return test();">
					 <input type="hidden" name="mode" value="{$smarty.request.mode}" />
					  <input type="hidden" name="offset" value="{$offset}" />
					 <input type="hidden" name="toshow" value="{$toshow}" />
                        <div class="top-display-panel">
                            <div class="left-area">
                                <div class="results-area" style="width:150px;"><span>{$displayCounterTXT}</span></div>
                                <div class="pagination" style="padding:0px 5px;">{$pageCounterTXT}</div> 
								                           
                            </div>
							
							<div class="sortblock" ><span>Sort By:</span>
								<select name="sort_by" onChange="this.form.submit();">
								<option value="" selected="selected">Select</option>
								<option value="price" {if $sort_by=='price'} selected="selected"{/if}>Price</option>
								<option value="title" {if $sort_by=='title'} selected="selected"{/if}>Title</option>
								{if $smarty.request.mode!='pending'}
									<option value="listing_date" {if $sort_by=='listing_date'} selected="selected"{/if}>Listing Date</option>
								{else}	
									<option value="uploaded_date" {if $sort_by=='uploaded_date'} selected="selected"{/if}>Uploaded Date</option>
								{/if}
								{if $smarty.request.mode=='sold'}
									<option value="sold_date" {if $sort_by=='sold_date'} selected="selected"{/if}>Sold Date</option>
								{/if}
								</select>
								</div> 
							
                        </div> 
						</form>                   
                        <div class="display-listing-main">
                         <div>
                          <!--<div class="borderline"></div>-->
                            {section name=counter loop=$auction}                            
                            <table class="list-view-main" align="center" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td class="list-poster-box" valign="top">
                                        <div class="poster-area-list">
                                            {if $auction[counter].fk_auction_type_id == 1}
                                                <div class="left"><a href="{$actualPath}/edit_myauction?auction_id={$auction[counter].auction_id}&type=fixed&encoded_string={$encoded_string}"><img src="images/edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {elseif $auction[counter].fk_auction_type_id == 2 && $auction[counter].auction_is_approved==0}
                                                <div class="left"><a href="{$actualPath}/edit_myauction?auction_id={$auction[counter].auction_id}&type=weekly&encoded_string={$encoded_string}"><img src="images/edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {elseif $auction[counter].fk_auction_type_id == 3 && $auction[counter].auction_is_approved==0}
                                                <div class="left"><a href="{$actualPath}/edit_myauction?auction_id={$auction[counter].auction_id}&type=monthly&encoded_string={$encoded_string}"><img src="images/edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {/if}
                                            &nbsp;
											{if ($auction[counter].fk_auction_type_id != 3 || $auction[counter].auction_is_approved==0)}
                                              <img src="images/delete_image.png" alt="Delete" title="Delete" height="16px" width="16px" border="0" onclick="javascript: deleteConfirmRecord('{$actualPath}/edit_myauction?mode=delete_auction&auction_id={$auction[counter].auction_id}&status={$smarty.request.mode}&encoded_string={$encoded_string}&toshow={$toshow}&offset={$offset}', 'auction');" style="cursor: pointer;" />
											 {/if} 
                                            &nbsp;
                                          
                                            <span style="cursor:pointer;" onclick="redirect_poster_details({$auction[counter].auction_id});"><strong>{$auction[counter].poster_title}&nbsp;(#{$auction[counter].poster_sku})</strong></span>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="poster-area-list">
                                        <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                        <div class="shadowbottom">
                                       <div class="shadow-bringer shadow">
                                            <img  class="image-brdr" src="{$actualPath}/poster_photo/thumbnail/{$auction[counter].poster_thumb}"  border="0" style="cursor:pointer;"   onclick="javascript:window.open('{$actualPath}/auction_images_large?mode=auction_images_large&id={$auction[counter].poster_id}','mywindow','menubar=1,resizable=1,width={$auction[counter].img_width+100},height={$auction[counter].img_height+100},scrollbars=yes')" />
                                           </div></div>
                                            <!---Move To Weekly Button---->
                                            <div class="Buttondesign MoveToWeekly">
        		            				<div class="ButtondesignLeft"></div>
               								 <div class="ButtondesignMiddle">
												 <a id="various_{$smarty.section.counter.index}" href="{$actualPath}/myselling?mode=move_to_weekly&id={$auction[counter].auction_id}"><input type="button" id="{$smarty.section.counter.index}" onclick="fancy_images(this.id)" class="bidnow-btn" value="Move to weekly" /></a>
                							</div>
               							 	<div class="ButtondesignRight movetoweekly"></div>
           								  </div>
                                            
											 
											</div>
											
                                             <div class="descrp-area-two">
                                            {section name=catCounter loop=$auction[counter].categories}
                                                {if $auction[counter].categories[catCounter].fk_cat_type_id == 1}
                                                <div class="desp-txt"><b>Size : </b> {$auction[counter].categories[catCounter].cat_value}</div>
                                                {elseif $auction[counter].categories[catCounter].fk_cat_type_id == 2}
                                                <div class="desp-txt"><b>Genre : </b> {$auction[counter].categories[catCounter].cat_value}</div>
                                                {elseif $auction[counter].categories[catCounter].fk_cat_type_id == 3}
                                                <div class="desp-txt"><b>Decade : </b> {$auction[counter].categories[catCounter].cat_value}</div>
                                                {elseif $auction[counter].categories[catCounter].fk_cat_type_id == 4}
                                                <div class="desp-txt"><b>Country : </b> {$auction[counter].categories[catCounter].cat_value}</div>
                                                {elseif $auction[counter].categories[catCounter].fk_cat_type_id == 5}
                                                <div class="desp-txt"><b>Condition : </b> {$auction[counter].categories[catCounter].cat_value}</div>
                                                {/if}
                                            {/section}
                                            </div>   
                                            <div class="clear"></div>   
                                        </div>                                      
                                    </td>
                                    {if $auction[counter].fk_auction_type_id==1}
                                    <td class="list-auction-fixed-ask" valign="top">
                                        <div class="auction-row">

                                            <div class="buy-text bold">Ask Price</div>

                                            <div class="buy-text">${$auction[counter].auction_asked_price|number_format:2}</div>
                                        </div>
                                        {if $auction[counter].auction_reserve_offer_price > 0 && $auction[counter].is_offer_price_percentage == 1}
                                        <div class="auction-row">
                                             <div class="buy-text bold">Minimum offer you will consider</div><div class="buy-text">${math|round|number_format:2 equation="(( x *  y) / 100 )" x=$auction[counter].auction_asked_price y=$auction[counter].auction_reserve_offer_price}</div>
                                        </div>
                                        {elseif $auction[counter].auction_reserve_offer_price > 0 && $auction[counter].is_offer_price_percentage != 1}
                                        <div class="auction-row">
                                             <div class="buy-text bold">Minimum offer you will consider</div><div class="buy-text">${$auction[counter].auction_reserve_offer_price|round|number_format:2}</div>
                                        </div>
                                        {/if}
                                        {if $auction[counter].count_offer > 0}
                                        <div class="auction-row" style=" position:relative;">
                                                <div class="buy-text bold" style=" position:relative; cursor:pointer;" onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" >{$auction[counter].count_offer}</div><div class="buy-text" style=" position:relative; cursor:pointer;" onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" >Offer(s)</div>
												
												<!-- Tooltip starts Here -->
                                   
												<div id="div_{$auction[counter].auction_id}" class="div">
												<ul>
												{section name=pop_counter loop=$auction[counter].tot_offers}
												<li>&nbsp;<b>User:</b>&nbsp;{$auction[counter].tot_offers[pop_counter].user_name}<b>&nbsp;Amount:</b>&nbsp; ${$auction[counter].tot_offers[pop_counter].offer_amount}&nbsp;</li>
												{/section}
												</ul>
												</div>
                                    
                                    			<!-- Tooltip ends Here -->
                                                <div class="buy-text bold">Highest Offer</div><div class="buy-text">${$auction[counter].highest_offer|number_format:2}</div>
                                            </div>
                                        {/if}
                                        <div style="float:left; width:305px; padding:0px; margin:0px;">
                                        <div class="note-txt-heading bold">
                                        Note:&nbsp;&nbsp;</div><div class="note-txt">{$auction[counter].auction_note}</div>
                                        </div>
                                    </td>
                                    {elseif $auction[counter].fk_auction_type_id==2}
                                    <td class="list-auction-det" style=" width:55%;" valign="top">
                                        <div class="auction-row">
                                            <div class="buy-text bold">Start Bid</div>
                                            <div class="buy-text"><span class="offer_buyprice">${$auction[counter].auction_asked_price|number_format:2}</span></div>
                                        </div>
                                        <div class="auction-row">
                                            {if $auction[counter].auction_buynow_price > 0}
                                            <div class="buy-text bold">Buy Now</div>
                                            <div class="buy-text"><span class="buynowprice">${$auction[counter].auction_buynow_price|number_format:2}</span></div>
                                            {/if}
                                        </div>
                                        <div class="auction-row">
                                            <div class="buy-text bold" style="margin-right:5px;">End Time</div>
                                            <div class="buy-text" style="float:none;">{$auction[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                            <div class="buy-text" style="margin-right:5px;">{$auction[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                            <div class="buy-text">{$auction[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                        </div>                                        
                                        {if $auction[counter].count_bid > 0}
                                            <div class="auction-row" style=" position:relative;">
                                                <div class="buy-text bold"  onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" style="cursor:pointer;">{$auction[counter].count_bid}</div><div class="buy-text" onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" style="cursor:pointer;">Bid(s)</div>									
												<!-- Tooltip starts Here -->
                                   
												<div id="div_{$auction[counter].auction_id}" class="div">
												<ul>
												{section name=pop_counter loop=$auction[counter].bid_popup}
												<li>&nbsp;<b>User:</b>&nbsp;{$auction[counter].bid_popup[pop_counter].user_name}<b>&nbsp;Amount:</b>&nbsp; ${$auction[counter].bid_popup[pop_counter].bid_amount}&nbsp;</li>
												{/section}
												</ul>
												</div>
                                    
                                    			<!-- Tooltip ends Here -->
                                                <div class="buy-text bold">Highest Bid</div><div class="buy-text">${$auction[counter].highest_bid|number_format:2}</div>
                                            </div>
                                        {/if}
                                    </td>
                                    {elseif $auction[counter].fk_auction_type_id==3}
                                    <td class="list-auction-det" style=" width: 55%;" valign="top">
                                        <div class="auction-row">
                                            <div class="buy-text bold">Start Bid</strong></div>
                                            <div class="buy-text"><span class="offer_buyprice">${$auction[counter].auction_asked_price|number_format:2}</span></div> 
                                            {if $auction[counter].auction_reserve_offer_price > 0}
                                             <div class="auction-row">
                                                <div class="buy-text bold">Reserve Price:</div>
                                                <div class="buy-text"><b class="BigFont">${$auction[counter].auction_reserve_offer_price|number_format:2}</b></div>
                                            </div>
                                             {else}
                                             <div class="auction-row">
                                              <div class="buy-text bold">(No Reserve)</div>
                                              </div>
                                              {/if}
                                              <div class="auction-row">
                                            <div class="buy-text bold" style="margin-right:5px;">End Time</div>
                                            <div class="buy-text" style="float:none;">{$auction[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                            <div class="buy-text" style="margin-right:5px;">{$auction[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                            <div class="buy-text">{$auction[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                            </div>
                                        </div>
                                        {if $auction[counter].count_bid > 0}
                                            <div class="auction-row" style=" position:relative; cursor:pointer;">
                                                <div class="buy-text bold"  onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" >{$auction[counter].count_bid}</div><div class="buy-text" style=" position:relative; cursor:pointer;" onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" >Bid(s)</div>		
												<!-- Tooltip starts Here -->
                                   
												<div id="div_{$auction[counter].auction_id}" class="div">
												<ul>
												{section name=pop_counter loop=$auction[counter].bid_popup}
												<li>&nbsp;<b>User:</b>&nbsp;{$auction[counter].bid_popup[pop_counter].user_name}<b>&nbsp;Amount:</b>&nbsp; ${$auction[counter].bid_popup[pop_counter].bid_amount}&nbsp;</li>
												{/section}
												</ul>
												</div>
                                    
                                    			<!-- Tooltip ends Here -->
                                                <div class="buy-text bold">Highest Bid</div><div class="buy-text">${$auction[counter].highest_bid|number_format:2}</div>
                                            </div>
                                        {/if}
                                    </td>
                                    {/if} 
                                    
                                </tr>
                            </table>
                            {/section}
                            </div>
                        </div>
                        
                    {else}
                        <div class="top-display-panel">No records found!</div>
                    {/if}
                    <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                    
                </div>
            </div>
            
            </div></div></div>
           {include file="user-panel.tpl"}
        </div>
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}
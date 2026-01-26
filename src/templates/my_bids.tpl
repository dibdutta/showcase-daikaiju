{include file="header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/lightbox/jquery.lightbox-0.5.css" media="screen" />

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
<style type="text/css">.div {position:absolute; left:590px;  min-width:120px; list-style-type:none; visibility:hidden;background-color:#881318;color:white; z-index:50;margin-left:80px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c;}</style>

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
                <!--<div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div> -->
                
                  
                    <div class="left-midbg"> 
                    <div class="right-midbg">  
                    <div class="mid-rept-bg">
                     <div class="dashboard-main" style="margin-left:0;">
                                <h1>My Active Bids</h1>
                                <!--<p>(*Note:This is an "at a glance view".For complete details please refer to User Section located at right). </p>-->
                                </div>
                        <div class="light-grey-bg-inner">
                        	<div class="inner-grey">
                            <!--<div class="left-submenu">
                                <span class="goto-span"><strong>GO TO: <u>FIXED PRICE</u></strong></span>
                                <ul class="menu">
                                    <li>[<a href="{$actualPath}/offers.php">My Outgoing Counters</a>]</li>
                                    <li>[<a href="{$actualPath}/offers.php?mode=incoming_counters">My Incoming Counters</a>]</li>
                                </ul>
                            </div>-->
                           
                            
                            
                            <div class="right-submenu">
                                <span class="goto-span"><strong>ITEMS I AM CURRENTLY:</strong></span>
                                <ul class="menu">
                                    <li>[<!--  <a href="{$actualPath}/my_bid.php">My Bids</a>--></li>
									<li><img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" width="13" height="14" border="0" /><a class="green" href="{$actualPath}/my_bid.php?mode=winning">Winning</a>]</li>
                                    <li>&nbsp;[</li>
									<li><img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}losing-bid-img.png" width="13" height="14" border="0"  /><a class="red" href="{$actualPath}/my_bid.php?mode=losing">Losing</a>]</li>
                                    <li>&nbsp;[<a href="{$actualPath}/my_bid.php">All</a>]</li>
                                </ul>	
                            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="display-listing-main">
                        	<div>
                            
                             <div class="top-display-panel2">
                                <div class="left-area">
                                    <div class="results-area" style="width:200px;"><span>{$displayCounterTXT}</span></div>
                                    <div class="pagination" style="width:200px;">{$pageCounterTXT}</div>                            
                            </div>                      
                            </div>
                            <div class="display-listing-main buylist pt20 pb20" id="offers">
                        	<div>
                            <table class="list-bid-det-main" cellpadding="0" cellspacing="0" border="0">
                             {if $total > 0}
                             {section name=counter loop=$bidDetails}
							 	<tr>
                                    <td colspan="4">
                                        <div class="gnrl-listing">
                                        <div>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <th width="10%" class="text bold">Bid Won/Lost</th>
                                                <th width="20%" class="text bold">Bid Time</th>
                                                <th width="20%" class="text bold">Bid Date</th>
                                                <th width="20%" class="text bold">My Proxy Bid</th>
                                            </tr>
                                       {section name=bid_count loop=$bidDetails[counter].bids}
                                       {if $bidDetails[counter].max_amount_no!='1'} 
                                            {if ($bidDetails[counter].bids[bid_count].bid_is_won=='1' || $bidDetails[counter].highest_bid <= $bidDetails[counter].bids[bid_count].bid_amount) && $bidDetails[counter].auction_is_sold <>'2'}
                                                  <tr class="green">
                                                   <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" border="0" title="winning" />
                                                   </td>
                                                   <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                   <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                   <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                   </tr>
                                                {/if}
                                                {if ($bidDetails[counter].bids[bid_count].bid_is_won=='1' || $bidDetails[counter].highest_bid <= $bidDetails[counter].bids[bid_count].bid_amount) && $bidDetails[counter].auction_is_sold =='2'}
                                                   <tr class="green">
                                                    <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" border="0" title="winning" />
                                                   </td>
                                                   <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                   <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                   <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                   </tr>
                                                {/if}
                                         {else}
                                         		{if ($bidDetails[counter].highest_bid <= $bidDetails[counter].bids[bid_count].bid_amount)  && $bidDetails[counter].bids[bid_count].is_proxy==1}
                                                  <tr class="green">
                                                   <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" border="0" title="winning" />
                                                   </td>
                                                   <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                   <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                   <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                   </tr>
                                                {/if}
                                                {if ($bidDetails[counter].highest_bid <= $bidDetails[counter].bids[bid_count].bid_amount) && $bidDetails[counter].auction_is_sold =='2' && $bidDetails[counter].bids[bid_count].is_proxy=='1'}
                                                   <tr class="green">
                                                    <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}winning-bid-img.png" border="0" title="winning" />
                                                   </td>
                                                   <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                   <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                   <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                   </tr>
                                                {/if}
                                                {if ($bidDetails[counter].bids[bid_count].bid_is_won=='1' || $bidDetails[counter].highest_bid <= $bidDetails[counter].bids[bid_count].bid_amount) && $bidDetails[counter].auction_is_sold <>'2' && $bidDetails[counter].bids[bid_count].is_proxy=='0'}
                                                
                                                   <tr class="red">
                                                    <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}losing-bid-img.png" border="0" title="losing" />
                                                   </td>
                                                   <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                   <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                   <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                   </tr>
                                                {/if}
                                                      
                                         {/if}       
                                                {if $bidDetails[counter].highest_bid > $bidDetails[counter].bids[bid_count].bid_amount}
                                                   <tr class="red">
                                                    <td style="border-left:1px solid #DFDFDF;">
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC}losing-bid-img.png" border="0" title="losing" />
                                                    </td>
                                                    <td class="text">{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                                    <td class="text">{*{$bidDetails[counter].bids[bid_count].bid_time|date_format:"%A"} &nbsp;&nbsp;*}{$bidDetails[counter].bids[bid_count].post_date}</td>
                                                    <td class="text">{if $bidDetails[counter].proxy_amnt > $bidDetails[counter].bids[bid_count].bid_amount}${$bidDetails[counter].proxy_amnt|number_format:2}{else}${$bidDetails[counter].bids[bid_count].bid_amount|number_format:2}{/if}</td>
                                                    </tr>
                                                {/if} 
                                         {/section}
                                          
                                        </table>
                                        </div>
                                       </div> 
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td style="width:130px;" valign="top">
                                        <div class="posterdetails">
                                        <div id="gallery_{$smarty.section.counter.index}" style="margin:12px;">
                                        <table align="center"><tbody><tr><td align="left" valign="middle" style="border:none;">
                                                <div class="buylisttb">
                                       <div><img  class="image-brdr" src="{$bidDetails[counter].image_path}" border="0"  border="0" onclick="redirect_poster_details({$bidDetails[counter].auction_id});" style="cursor:pointer;" /></div></div>
                                       </td></tr></tbody></table>
                                         </div>
                                       </div>
                                    </td>
                                    <td style="width:129px;" valign="top" class="text">
                                    <span style="cursor:pointer;" onclick="redirect_poster_details({$bidDetails[counter].auction_id});"> &nbsp;&nbsp;{$bidDetails[counter].poster_title}{*$bidDetails[counter].poster_sku*}</span><br/><br/>
                                     {if $bidDetails[counter].fk_auction_type_id==3}
                                        <strong>&nbsp;&nbsp;Start Bid</strong><br />
                                        <span><em>&nbsp;&nbsp;${$bidDetails[counter].auction_asked_price|number_format:2}</em></span><br />
                                     {/if} 
                                     {if $bidDetails[counter].fk_auction_type_id==2}
                                        <strong>&nbsp;&nbsp;Start Bid</strong><br />
                                        <span><em>&nbsp;&nbsp;${$bidDetails[counter].auction_asked_price|number_format:2}</em></span><br />
                                       {* <strong>&nbsp;&nbsp;Buy Now</strong><br />
                                        <span><em>&nbsp;&nbsp;${$bidDetails[counter].auction_buynow_price|number_format:2}</em></span><br />*}
                                     {/if}  
                                     {if $bidDetails[counter].fk_auction_type_id==1}
                                        <strong>Asking Price</strong><br />
                                        <span><em>${$bidDetails[counter].auction_asked_price|number_format:2}</em></span><br />
                                     {/if}
                                    </td>
                                    <td style="width:348px; padding:0 15px;" valign="top" >
                                         <p class="poster-txt">{$bidDetails[counter].poster_desc}</p>
                                    </td>
                                    <td style="width:173px;" valign="top" class="poster-txt">
                                    <p onMouseOver="toggleDiv('div_{$bidDetails[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$bidDetails[counter].auction_id}',0)" style="cursor:pointer;">Number of Bids: {$bidDetails[counter].count_bid}</p>
                                    <!-- Tooltip starts Here -->
                                   
                                    <div id="div_{$bidDetails[counter].auction_id}" class="div">
                                    <ul>
                                    {section name=pop_counter loop=$bidDetails[counter].bid_popup}
                                    <li>&nbsp;<b>{$bidDetails[counter].bid_popup[pop_counter].user_name}:</b>&nbsp;${$bidDetails[counter].bid_popup[pop_counter].bid_amount}&nbsp;</li>
                                    {/section}
                                    </ul>
                                    </div>
                                    
                                    <!-- Tooltip ends Here -->
                                    <p>Highest Bid: ${$bidDetails[counter].highest_bid|number_format:2}</p>
                                    </td>
                                </tr>
                                
                                {/section}
								<tr>
								<td colspan="4">&nbsp;
								
								</td>
								</tr>
                                {else}
                                 <tr><td colspan="3" align="center" class="text bold">No records found!</td></tr>
                                {/if} 
                            </table>
                            </div>
                            </div>
                            <div class="top-display-panel2">
                                <div class="left-area">
                                    <div class="results-area" style="width:200px;"><span>{$displayCounterTXT}</span></div>
                                    <div class="pagination" style="width:200px;">{$pageCounterTXT}</div>                            
                            	</div>                      
                            	</div>
                            </div>
                        </div>  
                        <div class="clear"></div>                      
                    </div>
                    </div>
                    </div>
                    
                	<!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
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
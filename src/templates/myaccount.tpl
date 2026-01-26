{include file="header.tpl"}
<div id="forinnerpage-container">
    <div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
        <!--Header Theme Starts-->
        {include file="search-login.tpl"} 
        <!--Header Theme Ends-->
        </div>
        <!--Header themepanel Ends-->    
        <div id="inner-container2">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
        
            <div id="inner-left-container">
                <!--<div id="tabbed-inner-nav">-->
                    <!--<ul class="menu">-->
                        <!--<li><a class="active" href="#"><span>See all Items</span></a></li>-->
                        <!-- <li><a href="#"><span>See Items for Sale</span></a></li>-->
                        <!--<li><a href="#"><span>See Monthly Auctions</span></a></li>-->
                        <!--<li><a href="#"><span>See Weekly Auctions</span></a></li>-->
                        <!--<li><a href="#">Event Auctions</a></li>-->
                    <!--</ul>-->
                <!--</div>-->             
                <div class="innerpage-container-main">
                    <!--<div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>-->
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                        <!--inner listing starts-->
                        <div class="display-listing-main">
                            <!--poster details begins here-->
                            <!-- dashboard begins here-->
                            <div class="dashboard-main">
                                <h1>Dashboard</h1>
                                <p>(*Note:This is an "at a glance view".For complete details please refer to "Welcome User" tab section located beside "Sign Out" link at top). </p>
                                <div>
                                	<div class="dashblock mr24">
                                      <h3>Winning Bids</h3>
                  						<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
                                        	<tr>
                                                <th width="55%" align="left" valign="top" class="tal">Poster Title</th>                                            
                                                <th width="18%" align="left" valign="top" class="tal">Bid Date</th>
                                                <th width="19%" align="left" valign="top" class="tal">Amount</th>
                                            </tr>
                                        </table>
                                        <div class="scrollable">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:30px;">                                            
                                            {if $totalBids > 0}
                                            {section name=counter loop=$bidDetails}
                                            <tr>
                                                <td  width="55%"><span style="cursor:pointer;" onclick="redirect_poster_details({$bidDetails[counter].auction_id});"><!--<img src="{$bidDetails[counter].image_path}" width="20px" height="20px" border="0" />-->{$bidDetails[counter].poster_title}</span></td>
                                                <td width="18%" class="tal">{$bidDetails[counter].bids[0].post_date}</td>
                                                <td width="19%" class="tal">${$bidDetails[counter].bids[0].bid_amount}</td>
                                            </tr>                                        
                                            {/section}
                                            <!--<tr>
                                                <td colspan="3" align="right"><a href="{$actualPath}/my_bid.php?mode=closed&type=winning"><img src="{$smarty.const.CLOUD_STATIC}more.jpg" border="0" /></a></td>
                                            </tr>-->
                                            {else}
                                            <tr>
                                                <td align="left" valign="top">No winning bids.</td>
                                            </tr>
                                            {/if}
                                        </table>
                                        
                                      </div>
                                        <div class="tar morediv"><a href="{$actualPath}/my_bid.php?mode=winning"><img src="../images/more.jpg" border="0" /></a></div>
                                        <div class="dashboard-main_shadow"></div>
                                    </div>
                                    <div class="dashblock">
                                        <h3>Winning Offers</h3>
                                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" >
                                            <tr>
                                                <th width="55%" align="left" valign="top" class="tal">Poster Title</th>                                    
                                                <th width="18%" align="left" valign="top" class="tal">Offer Date</th>
                                                <th width="19%" align="left" valign="top" class="tal">Amount</th>
                                            </tr>
                                          </table>
                                        <div class="scrollable">
                                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" >
                                            
                                            {if $totalOffers > 0}
                                            {section name=counter loop=$dataOfr}
                                            <tr>
                                                <td  width="55%" class="tal"><span style="cursor:pointer;" onclick="redirect_poster_details({$dataOfr[counter].auction_id});"><!--<img src="{$dataOfr[counter].image_path}" width="20px" height="20px" border="0" />-->{$dataOfr[counter].poster_title}</span></td>
                                                <td width="18%"  class="tal">{$dataOfr[counter].post_date|date_format:"%m/%d/%Y"}</td>
                                                <td width="19%"  class="tal">${$dataOfr[counter].offer_amount}</td>
                                            </tr>
                                            {/section}
                                            <!--<tr>
                                                <td colspan="3" align="right"><a href="{$actualPath}/offers.php"><img src="{$smarty.const.CLOUD_STATIC}more.jpg" border="0" /></a></td>
                                            </tr>-->
                                            {else}
                                            <tr>
                                                <td align="left" valign="top">No new offer to display.</td>
                                            </tr>
                                            {/if}
                                        </table>
                                        </div>
                                         <div class="tar morediv"><a href="{$actualPath}/offers.php"><img src="../images/more.jpg" border="0" /></a></div>
                                        <div class="dashboard-main_shadow"></div>
                                    </div>
                                    <div class="dashblock mr24">
                                        <h3>Selling</h3>
                                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" >
                                            <tr>
                                                <th width="75%" align="left" valign="top" class="tal">Poster Title</th>                                    
                                                <th width="25%" align="right" valign="top" class="tal">Highest Bid/Offer</th>
                                            </tr>
                                         </table>
                                        <div class="scrollable">
                                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" >
                                           
                                            {if $totalSelling > 0}
                                            {section name=counter loop=$sellingItem}
                                            <tr>
                                                <td  width="75%" class="tal"><span style="cursor:pointer;" onclick="redirect_poster_details({$sellingItem[counter].auction_id});"><!--<img src="{$sellingItem[counter].image_path}" width="20px" height="20px" border="0" />-->{$sellingItem[counter].poster_title}</span></td>
                                                <td width="25%"  class="tal">&nbsp;{if $sellingItem[counter].fk_auction_type_id=='1' }{if $sellingItem[counter].highest_offer > 0}${$sellingItem[counter].highest_offer}{else}--{/if}{else}{if $sellingItem[counter].highest_bid >0}${$sellingItem[counter].highest_bid}{else}--{/if}{/if}</td>
                                                
                                            </tr>
                                            {/section}
                                            <!--<tr>
                                                <td colspan="3" align="right"><a href="{$actualPath}/myselling.php?mode=selling" ><img src="{$smarty.const.CLOUD_STATIC}more.jpg" border="0" /></a></td>
                                            </tr>-->
                                            {else}
                                            <tr>
                                                <td align="left" valign="top">No selling items to display.</td>
                                            </tr>
                                            {/if}
                                        </table>
                                        </div>
                                         <div class="tar morediv"><a href="{$actualPath}/myselling.php?mode=selling"><img src="../images/more.jpg" border="0" /></a></div>
                                        <div class="dashboard-main_shadow"></div>
                                    </div>
									{*
                                    <div class="dashblock">
                                        <h3>My Sold Items</h3>
                                        <table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" >
                                            <tr>
                                                <th width="75%" align="left" valign="top" class="tal">Poster Title</th>
                                                <th width="25%" align="left" valign="top" class="tal">Sold Price</th>
                                            </tr>
                                         </table>
                                        <div class="scrollable">
                                        <table width="100%" align="center" cellpadding="2" cellspacing="0" border="0" >
                                           
                                            {if $total > 0}
                                             {section name=counter loop=$dataJstFinishedAuction}
                                            <tr>
                                                <td  width="75%" class="tal"><span style="cursor:pointer;" onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});"><!--<img src="{$dataJstFinishedAuction[counter].image_path}" width="20px" height="20px" border="0" />-->{$dataJstFinishedAuction[counter].poster_title}</span></td>
                                                <td width="25%"  class="tal">${$dataJstFinishedAuction[counter].soldamnt}</td>
                                            </tr>
                                            {/section}
                                            <!--<tr>
                                                <td colspan="3" align="right"><a href="{$actualPath}/myselling.php?mode=sold" ><img src="{$smarty.const.CLOUD_STATIC}more.jpg" border="0" /></a></td>
                                            </tr>-->
                                            {else}
                                            <tr>
                                                <td align="left" valign="top">No sold item to display.</td>
                                            </tr>
                                            {/if}
                                        </table>
                                        </div>
                                         <div class="tar morediv"><a href="{$actualPath}/myselling.php?mode=sold"><img src="../images/more.jpg" border="0" /></a></div>
                                        <div class="dashboard-main_shadow"></div>
                                    </div>
                                    *}
                                    
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!-- end of dashboarddiv-->
                            <!-- poster details ends here-->
                        </div>
                        <!--inner listing ends-->
                        <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                    <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                    
                </div>
            </div>
            
            </div></div></div>
          {include file="user-panel.tpl"}
        </div>
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
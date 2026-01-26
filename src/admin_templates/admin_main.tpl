{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	{if $errorMessage<>""}
		<tr>
			<td width="100%" align="center" colspan="2"><div class="messageBox">{$errorMessage}</div></td>
		</tr>
	{/if}			
	<tr>
		<td valign="top" align="left" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div class="dashboard-main">
							<div>
								<div class="dashblock"  >
									<span>Recent Sold Items</span>
									<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>
                                            <th align="left" valign="top">Sold Date</th>
                                            <th align="left" valign="top">Amount</th>
                                            <th align="left" valign="top">Type</th>
                                        </tr>
                                       {if $total > 0}
                                             {section name=counter loop=$dataJstFinishedAuction}
                                        <tr>
                                                <td  width="60%"><span style="cursor:pointer;" ><img src="{$dataJstFinishedAuction[counter].image_path}" width="20px" height="20px" border="0" />&nbsp;&nbsp;{$dataJstFinishedAuction[counter].poster_title}&nbsp;</span></td>
                                                 <td width="38%" >&nbsp;{$dataJstFinishedAuction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                                                <td width="38%" align="center">${$dataJstFinishedAuction[counter].soldamnt}</td>
                                                <td width="38%" align="center">{if $dataJstFinishedAuction[counter].fk_auction_type_id=='1'}Fixed
                                                {elseif $dataJstFinishedAuction[counter].fk_auction_type_id=='2'}Weekly
                                                {elseif $dataJstFinishedAuction[counter].fk_auction_type_id=='3'}Monthly
                                                {/if}</td>
                                            </tr>
                                        {/section}
                                        {else}
                                        <tr>
                                            <td align="left" valign="top">No sold item to display.</td>
                                        </tr>
                                        {/if}
                                    </table>
								</div>
								
								<div class="dashblock">
                                    <span>Winning Bids</span>
                                    <table width="90%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>                                            
                                            <th align="left" valign="top">Bid Date</th>
                                            <th align="left" valign="top">Amount</th>
                                        </tr>
                                        {if $totalBids > 0}
                                        {section name=counter loop=$bidDetails}
                                        <tr>
                                            <td  width="55%"><img src="{$bidDetails[counter].image_path}" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="{$actualPath}/admin/admin_auction_manager.php?mode=view_details&auction_id={$bidDetails[counter].auction_id}&encoded_string={$encoded_string}">{$bidDetails[counter].poster_title}(#{$bidDetails[counter].poster_sku})</a></td>
                                            <td width="18%">{$bidDetails[counter].bids[0].post_date}</td>
                                            <td width="15%">${$bidDetails[counter].bids[0].bid_amount}</td>
                                        </tr>                                        
                                        {/section}
                                        
                                        {else}
                                        <tr>
                                            <td align="left" valign="top">No winning bids.</td>
                                        </tr>
                                        {/if}
                                    </table>
                                </div>
                                
                                <div class="dashblock">
                                    <span>Winning Offers</span>
                                    <table width="90%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>                                    
                                            <th align="left" valign="top">Offer Date</th>
                                            <th align="left" valign="top">Amount</th>
                                        </tr>
                                        {if $totalOffers > 0}
                                        {section name=counter loop=$dataOfr}
                                        <tr>
                                            <td  width="55%"><img src="{$dataOfr[counter].image_path}" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="{$actualPath}/admin/admin_auction_manager.php?mode=view_details_offer&auction_id={$dataOfr[counter].auction_id}&encoded_string={$encoded_string}">{$dataOfr[counter].poster_title}(#{$dataOfr[counter].poster_sku})</a></td>
                                            <td width="18%">{$dataOfr[counter].post_date|date_format:"%m/%d/%Y"}</td>
                                            <td width="15%">${$dataOfr[counter].offer_amount}</td>
                                        </tr>
                                        {/section}
                                        
                                        {else}
                                        <tr>
                                            <td align="left" valign="top">No new offer to display.</td>
                                        </tr>
                                        {/if}
                                    </table>
                                </div>
							</div>
							<div class="clear"></div>
						</div>
					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>
{include file="admin_footer.tpl"}
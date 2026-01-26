{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	{if $errorMessage<>""}
		<tr>
			<td width="100%" align="center" colspan="2"><div class="messageBox">{$errorMessage}</div></td>
		</tr>
	{/if}			
	<tr>
		<td valign="top" align="left" width="100%">
			<table width="100%" border="0" cellspacing="15" cellpadding="0">
				<tr>
					<td valign="top" align="center" class="admin_box"  width="28%">
					<b>Latest Messages</b><br/>
					<span style="width: 150px;float:left; text-align:left;"><b>New Message </b></span> <span style="width: 100px;"><b>Date</b></span><br/>
					{if $total>0}
					{section name=counter loop=$messageRows}
                        <span style="width: 150px;float:left; text-align:left;" ><a {if $messageRows[counter].message_is_new == '1'}style="font-weight:bold;"{/if} href="{$actualPath}/send_message.php?mode=read&message_id={$messageRows[counter].message_id}&encoded_string={$encoded_string}">{$messageRows[counter].message_subject}</a> </span>
                        <span style="width: 200px;">{$messageRows[counter].send_date|date_format:"%m/%d/%Y"}</span><br/>
					{/section}
					
					{else}
					 	<span style="width: 150px;float:left; text-align:left;">Sorry no unread message to display.</span>
					{/if}
					
					</td>
					
					<td valign="top" align="center" class="icon_box"  width="38%">
					<b>Winning Bids</b><br/>
					<span style="width: 200px;float:left;text-align:left; "><b>Poster Title</b></span> <span style="width: 120px;"><b>Bid Day</b></span><span style="width: 120px;">&nbsp;<b>Amount</b></span><br/>
					{if $totalBids > 0}
                    {section name=counter loop=$bidDetails}
                     <span style="width: 200px;float:left;text-align:left;"><img src="{$actualPath}/poster_photo/thumbnail/{$bidDetails[counter].poster_thumb}" width="20px" height="20px" border="0" />&nbsp;&nbsp;{$bidDetails[counter].poster_title}(#{$bidDetails[counter].poster_sku})</span>
                     <span style="width: 120px;">{$bidDetails[counter].bids[0].post_date}</span>
                     <span style="width: 120px;">&nbsp;${$bidDetails[counter].bids[0].bid_amount}</span><br/>                                        
                     {/section}
<!--                                        <tr>-->
<!--                                            <td colspan="3" align="right"><a href="{$actualPath}/my_bid.php?mode=winning"><img src="{$actualPath}/images/more.jpg" border="0" /></a></td>-->
<!--                                        </tr>-->
                      {else}
                      <span style="width: 150px;float:left;"><b>No winning bids.</b></span>
                      {/if}
					</td>
					
					<td valign="top" align="center" class="icon_box"  id="logout" width="38%">
					<b>Winning Offers</b><br/>
					<span style="width: 150px;float:left;"><b>Poster Title</b></span> <span style="width: 120px;"><b>Offer Day</b></span><span style="width: 120px;">&nbsp;<b>Amount</b></span><br/>
					{if $totalOffers > 0}
                     {section name=counter loop=$dataOfr}
                      <span style="width: 250px;float:left;"><img src="{$actualPath}/poster_photo/thumbnail/{$bidDetails[counter].poster_thumb}" width="20px" height="20px" border="0" />&nbsp;&nbsp;{$dataOfr[counter].poster_title}(#{$dataOfr[counter].poster_sku})</span>
                     <span style="width: 120px;">{$dataOfr[counter].post_date|date_format:"%m/%d/%Y"}</span>
                     <span style="width: 120px;">&nbsp;${$dataOfr[counter].offer_amount}</span><br/> 
                     {/section}
<!--                                        <tr>-->
<!--                                            <td colspan="3" align="right"><a href="{$actualPath}/offers.php"><img src="{$actualPath}/images/more.jpg" border="0" /></a></td>-->
<!--                                        </tr>-->
                     {else}
                       <span style="width: 250px;float:left;">&nbsp;&nbsp;No new offer to display.</span>
                      {/if}
					</td>
				</tr>
			</table>
		</td>
		
	</tr>
</table>
{include file="admin_footer.tpl"}
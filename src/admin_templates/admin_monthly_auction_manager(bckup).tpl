{include file="admin_header.tpl"}
{literal}
<script language="javascript">
function approveAuction(id, is_approved, searchDisp)
{
	var url = "admin_change_status.php";
	var request = "mode=auction&id="+id+"&is_approved="+is_approved;

	$.post(url, {mode: 'auction', id: id, is_approved: is_approved}, function(retunedData, textStatus){
		if(retunedData == "done"){
			if(searchDisp != '' && searchDisp != 'pending'){
				$("#tr_"+id).hide();
			}else{
				if(is_approved == 1){
					$("#td_"+id).html('<img src="{/literal}{$adminImagePath}{literal}/icon_active.gif" align="absmiddle" alt="Mark as Received" border="0" onclick="javascript: approveReceived('+id+', \''+searchDisp+'\');" title="Mark as Received" class="changeStatus" />');
				}else{
					$("#td_"+id).html("Disapproved");
				}
			}
		}
	});
}

function approveReceived(id, searchDisp)
{
	var url = "admin_change_status.php";
	$.post(url, {mode: 'poster_received', id: id}, function(retunedData, textStatus){
		if(retunedData == "done"){
			if(searchDisp != '' && searchDisp != 'pending'){
				$("#tr_"+id).hide();
			}else{
				$("#td_"+id).html("Approved & Received");
			}
		}
		//javascript:window.location.reload(true);
	});
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                {if $errorMessage<>""}
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                <tr>
					<td width="100%">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									<form action="" method="get">
                                    	<input type="hidden" name="mode" value="monthly" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
                                        	<option value="" selected="selected">All</option>
                                            <option value="selling" {if $search == "selling"}selected="selected"{/if}>Selling</option>
                                            <option value="pending" {if $search == "pending"}selected="selected"{/if}>Pending</option>
                                            <option value="waiting_receive" {if $search == "waiting_receive"}selected="selected"{/if}>Waiting to receive</option>
                                            <option value="sold" {if $search == "sold"}selected="selected"{/if}>Sold</option>
                                            <option value="unsold" {if $search == "unsold"}selected="selected"{/if}>Unsold</option>
											<option value="upcoming" {if $search == "upcoming"}selected="selected"{/if}>Up Coming</option>
											<option value="unpaid" {if $search == "unpaid"}selected="selected"{/if}>Unpaid</option>
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>		
				{if $total>0}
					<tr>
						<td align="center">
                        	<div id="messageBox" class="messageBox" style="display:none;"></div>
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="15%">Poster</td>
                                            <td align="center" class="headertext" width="15%">Starting Price</td>
                                            <td align="center" class="headertext" width="14%">Reserve Price</td>
                                            <td align="center" class="headertext" width="14%">Event Month</td>
                                            {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}<td align="center" class="headertext" width="8%">Status</td>{/if}
											<td align="center" class="headertext" width="10%">Action</td>
										</tr>
										{section name=counter loop=$auctionRows}
											<tr id="tr_{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="{$actualPath}/poster_photo/thumbnail/{$auctionRows[counter].poster_thumb}" height="78" width="100" /><br />{$auctionRows[counter].poster_title}<br /><b>SKU: </b>{$auctionRows[counter].poster_sku}</td>
												<td align="center" class="smalltext">${$auctionRows[counter].auction_asked_price|number_format:2}</td>
                                                <td align="center" class="smalltext">${$auctionRows[counter].auction_reserve_offer_price|number_format:2}</td>
                                                <td align="center" class="smalltext">{$auctionRows[counter].event_title}</td>
                                                {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}
                                                <td id="td_{$auctionRows[counter].auction_id}" align="center" class="smalltext">
                                                	{if $auctionRows[counter].auction_is_approved == 0 && $auctionRows[counter].is_approved_for_monthly_auction == 0}
														<img src="{$adminImagePath}/icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 1, '{$smarty.request.search}');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="{$adminImagePath}/icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 2, '{$smarty.request.search}');" title="Disapprove" class="changeStatus" />
                                                    {elseif $auctionRows[counter].auction_is_approved == 1 && $auctionRows[counter].is_approved_for_monthly_auction == 0}
                                                        <img src="{$adminImagePath}/icon_active.gif" align="absmiddle" alt="Mark as Received" border="0" onclick="javascript: approveReceived({$auctionRows[counter].auction_id}, '{$smarty.request.search}');" title="Mark as Received" class="changeStatus" />
                                                    {elseif $auctionRows[counter].auction_is_approved == 1 && $auctionRows[counter].is_approved_for_monthly_auction == 1}
                                                     	Approved and Received
                                                    {elseif $auctionRows[counter].auction_is_approved == 2}
                                                      	Disapproved
                                                    {/if}
												</td>
                                                {/if}
												<td align="center" class="bold_text">
                                                {if $auctionRows[counter].auction_is_approved == '0'}
                                                	<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_monthly&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a> 
                                                {/if}   
                                                 <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_monthly&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$adminImagePath}/delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->
                                           		{if $search == 'selling' || $search == 'sold' || $auctionRows[counter].is_approved_for_monthly_auction == '1' }        
                                                    &nbsp;&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_details&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>		{/if}
												{if $search == 'sold'}
													<a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$adminImagePath}/invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice_seller&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$adminImagePath}/invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
												{/if}
												{if $search == 'unpaid' && $auctionRows[counter].reopen_auction_id=='0'}
												 <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}">Reopen Auction</a>
												{elseif $search == 'unpaid' && $auctionRows[counter].reopen_auction_id!='0'}
												<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												{/if}
												{if $search == 'unsold' && $auctionRows[counter].reopen_auction_id=='0'}
													 <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$adminImagePath}/reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
												{elseif $search == 'unsold' && $auctionRows[counter].reopen_auction_id!='0'}
													<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												{/if}	
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
											<td align="right" {if $smarty.request.mode == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$adminImagePath}/arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all">Delete</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no auctions in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
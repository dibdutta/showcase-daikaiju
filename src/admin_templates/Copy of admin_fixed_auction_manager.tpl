{include file="admin_header.tpl"}
{literal}
<script language="javascript">
function approveAuction(id, is_approved, searchDisp)
{
	var url = "admin_change_status.php";
	var request = "mode=auction&id="+id+"&is_approved="+status;

	$.post(url, {mode: 'auction', id: id, is_approved: is_approved}, function(retunedData, textStatus){
		if(searchDisp == '' || searchDisp == 'waiting'){
			$("#tr_"+id).hide();
		}else{
			if(status == 1){
				$("#td_"+id).html("Approved");
			}else{
				$("#td_"+id).html("Disapproved");
			}
		}
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
                                    	<input type="hidden" name="mode" value="fixed" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
                                        	<option value="" selected="selected">All</option>
											<option value="waiting" {if $search == "waiting"}selected="selected"{/if}>Waiting for approval</option>
                                            <option value="approved" {if $search == "approved"}selected="selected"{/if}>Approved</option>
											<option value="disapproved" {if $search == "disapproved"}selected="selected"{/if}>Disapproved</option>
                                            <option value="sold" {if $search == "sold"}selected="selected"{/if}>Sold</option>
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
                                            <td align="center" class="headertext" width="15%">Asked Price</td>
                                            <td align="center" class="headertext" width="14%">Offer Price</td>
                                            {if $smarty.request.search == '' || $smarty.request.search == 'waiting'}<td align="center" class="headertext" width="8%">Status</td>{/if}
											<td align="center" class="headertext" width="10%">Action</td>
										</tr>
										{section name=counter loop=$auctionRows}
											<tr id="tr_{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="{$actualPath}/poster_photo/thumbnail/{$auctionRows[counter].poster_thumb}" height="100" width="78"><br />{$auctionRows[counter].poster_title}<br />{$auctionRows[counter].poster_sku}</td>
												<td align="center" class="smalltext">${$auctionRows[counter].auction_asked_price}</td>
                                                <td align="center" class="smalltext">{if $auctionRows[counter].is_offer_price_percentage == 1}{$auctionRows[counter].auction_reserve_offer_price}%{else}${$auctionRows[counter].auction_reserve_offer_price}{/if}</td>
                                                {if $smarty.request.search == '' || $smarty.request.search == 'waiting'}
                                                <td id="td_{$auctionRows[counter].auction_id}" align="center" class="smalltext">
													{if $auctionRows[counter].auction_is_approved == 0}
														<img src="{$adminImagePath}/icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 1, '{$smarty.request.search}');" title="Change Status" class="changeStatus" />&nbsp;|&nbsp;<img src="{$adminImagePath}/icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 2, '{$smarty.request.search}');" title="Change Status" class="changeStatus" />
													{elseif $auctionRows[counter].auction_is_approved == 1}
														Approved
                                                    {else}
                                                    	Disapproved
													{/if}
												</td>
                                                {/if}
												<td align="center" class="bold_text">
                                                    <a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_fixed&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a> &nbsp;|&nbsp<a href="#" class="view_link"><img src="{$adminImagePath}/delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>
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
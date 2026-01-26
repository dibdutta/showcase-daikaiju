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
                                            <td align="center" class="headertext" width="15%">Bid Amount</td>
                                            <td align="center" class="headertext" width="14%">Bidder Name</td>
                                            <td align="center" class="headertext" width="8%">Snipe Status</td>
							
										</tr>
										{section name=counter loop=$snipeArr}
											<tr id="{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="{$smarty.const.CLOUD_POSTER_THUMB}{$snipeArr[counter].poster_image}" height="100" width="78" /><br />{$snipeArr[counter].poster_title}<br />{$snipeArr[counter].poster_sku}</td>
												<td align="center" class="smalltext">${$snipeArr[counter].bid_amount}</td>
                                                <td align="center" class="smalltext">{$snipeArr[counter].firstname} &nbsp;{$snipeArr[counter].lastname}</td>
                                                
                                                <td id="td_{$snipeArr[counter].auction_id}" align="center" class="smalltext">
													{if $snipeArr[counter].bid_is_won == '1'}
														Winning Snipe
                                                    {else}
                                                    	Losing Snipe
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
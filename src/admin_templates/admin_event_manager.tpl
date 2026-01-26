{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"> <a href="{$adminActualPath}/admin_event_manager.php?mode=add_event&encoded_string={$encoded_string}" class="action_link"><strong>Create New Event</strong></a></td>
							</tr>
						</table>
					</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="25%">Event Title </td>
                                            <td align="center" class="headertext" width="25%">Start Time</td>
                                            <td align="center" class="headertext" width="25%">End Time </td>
											<td align="center" class="headertext" width="20%">Action</td>
										</tr>
										{section name=counter loop=$event}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="{$catRows[counter].cat_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext">{$event[counter].event_title}</td>
                                                <td align="center" class="smalltext">{$event[counter].start_date}</td>
                                                <td align="center" class="smalltext">{$event[counter].end_date}</td>
                                                
												<td align="center" class="bold_text">
                                                
													<a href="{$adminActualPath}/admin_event_manager.php?mode=edit_event&event_id={$event[counter].event_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_event_manager.php?mode=delete_event&event_id={$event[counter].event_id}&encoded_string={$encoded_string}', 'Record'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="{$adminActualPath}/admin_event_manager.php?mode=manage_monthly_auction&event_id={$event[counter].event_id}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_open.gif" align="absmiddle" alt="Manage Monthly Auction" title="Manage Monthly Auction" border="0" class="changeStatus" /></a>
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
											<td align="right" colspan="2" class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_category">Delete Category</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no event in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
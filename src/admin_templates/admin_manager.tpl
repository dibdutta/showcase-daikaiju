{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="{$adminActualPath}/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_super_manager.php?mode=change_profile" class="action_link"><strong>Update Profile</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_super_manager.php?mode=change_password" class="action_link"><strong>Change Password</strong></a></td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td width="100%" align="center">
							<form name="listFrom" id="listForm" action="" method="post" >
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
									<tr class="header_bgcolor" height="26">
										<td align="center" class="headertext" width="6%"></td >
										<td align="center" class="headertext" width="22%">{$userNameTXT}</td>
										<td align="center" class="headertext" width="22%">{$userEmailTXT}</td>
										<td align="center" class="headertext" width="20%">{$statusTXT}</td>
										<td align="center" class="headertext" width="30%">Action</td>
									</tr>
									{section name=counter loop=$userID}
										<tr class="{cycle values="odd_tr,even_tr"}">
											<td align="center" class="bold_text"><input type="checkbox" name="admin_ids[]" value="{$userID[counter]}" class="checkBox" /></td >
											<td align="center" class="smalltext">{$userName[counter]}</td >
											<td align="center" class="smalltext">{$userEmail[counter]}</td >
											<td align="center" class="smalltext" id="changeStatusPortion_{$userID[counter]}">
												{if $adminStatus[counter] == "Active"}
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('admin_user', {$userID[counter]}, 'changeStatusPortion_{$userID[counter]}');" title="Change Status" class="changeStatus" />
												{else}
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('admin_user', {$userID[counter]}, 'changeStatusPortion_{$userID[counter]}');" title="Change Status" class="changeStatus" />
												{/if}
											</td>
											<td align="center" class="bold_text"><a href="{$adminActualPath}/admin_super_manager.php?mode=edit_user&admin_id={$userID[counter]}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="{$adminActualPath}/admin_super_manager.php?mode=change_access&admin_id={$userID[counter]}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_changeaccess.gif" align="absmiddle" alt="Change Access" title="Change Access" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="{$adminActualPath}/admin_super_manager.php?mode=change_password&admin_id={$userID[counter]}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_password.gif" align="absmiddle" alt="Change Password" title="Change Password" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_super_manager.php?mode=delete_user&admin_id={$userID[counter]}', 'administrator'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" class="changeStatus" /></a></td>
										</tr>
									{/section}
									<tr class="header_bgcolor" height="26">
										<td align="left" class="smalltext">&nbsp;</td>
										<td align="left" class="headertext" colspan="3">{$pageCounterTXT}</td>
										<td align="right" class="headertext">{$displayCounterTXT}</td>
									</tr>
								</table>
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
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
								</table>
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no administrator.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
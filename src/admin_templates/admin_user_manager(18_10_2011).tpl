{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="{$adminActualPath}/admin_user_manager.php?mode=add_user&encoded_string={$encoded_string}" class="action_link"><strong>Add User</strong></a></td>
                </tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%"></td >
											<td align="center" class="headertext" width="17%">{$userNameTXT}</td>
											<td align="center" class="headertext" width="17%">{$emailTXT}</td>
											<td align="center" class="headertext" width="12%">{$statusTXT}</td >
											<td align="center" class="headertext" width="12%">Action</td>
										</tr>
										{section name=counter loop=$userID}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="smalltext"><input type="checkbox" name="user_ids[]" value="{$userID[counter]}" class="checkBox" /></td>
												<td align="center" class="smalltext">{$userName[counter]}</td>
												<td align="center" class="smalltext">{$email[counter]}</td>
												<td align="center" class="smalltext" id="changeStatusPortion_{$userID[counter]}">
													{if $status[counter] == 1}
														<img src="{$adminImagePath}/icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', {$userID[counter]}, 'changeStatusPortion_{$userID[counter]}');" title="Change Status" class="changeStatus" />
													{else}
														<img src="{$adminImagePath}/icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', {$userID[counter]}, 'changeStatusPortion_{$userID[counter]}');" title="Change Status" class="changeStatus" />
													{/if}
												</td>
												<td align="center" class="bold_text">
													<a href="{$adminActualPath}/admin_user_manager.php?mode=edit_user&user_id={$userID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_edit.gif" align="absmiddle" alt="Update User" title="Update User" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_user_manager.php?mode=delete_user&user_id={$userID[counter]}&encoded_string={$encoded_string}', 'user'); return false;"><img src="{$adminImagePath}/delete_image.png" align="absmiddle" alt="Delete Category" title="Delete User" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="{$adminActualPath}/admin_user_manager.php?mode=change_password&user_id={$userID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$adminImagePath}/icon_small_login.gif" align="absmiddle" alt="Change Password" title="Change Password" border="0" class="changeStatus" /></a>
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>
											<td align="right" class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$adminImagePath}/arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_user">Delete User</option>
											</select>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no user in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
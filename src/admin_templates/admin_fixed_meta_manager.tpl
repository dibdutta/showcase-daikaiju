{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{*<tr>
					<td align="center">{if $smarty.const.FIXED_PAGE_CREATION == 1}<a href="{$adminActualPath}/admin_meta_manager.php?mode=create_page" class="action_link"><strong>Create New Fixed Page</strong></a>{/if}{if $smarty.const.CUSTOM_PAGE_CREATION == 1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_meta_manager.php?mode=create_custom_page" class="action_link"><strong>Add New Custom Page</strong></a>{/if}</td>
				</tr>*}
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									<form action="" method="get">
										Select Page Type : 
										<select name="type" class="look" onchange="javascript: this.form.submit();">
											<option value="custom" {if $type == "custom"}selected="selected"{/if}>Custom Pages</option>
											<option value="fixed" {if $type == "fixed"}selected="selected"{/if}>Fixed Pages</option>
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
							<div style="width: 95%; text-align: right;"><a href="{$smarty.const.PHP_SELF}?type={$type}" class="new_link">&laquo; Back</a>{if $add_content_display == 1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_meta_manager.php?mode=add_content&type={$type}&page_id={$page_id}&encoded_string={$encoded_string}" class="new_link">Add New Content &raquo;</a>{/if}</div>
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="type" value="custom" />
								<input type="hidden" name="from" value="fixed" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tr class="header_bgcolor" height="26">
										{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $statusPermission == 1 or $smarty.const.MULTIUSER_ADMIN == 0}
											<td align="center" class="headertext" width="6%"></td >
										{else}
											<td align="center" class="headertext" width="10%">Index</td >
										{/if}
										<td align="center" class="headertext">{$pageNameTXT}</td>
										{if $smarty.const.MULTIUSER_ADMIN == 1}
											<td align="center" class="headertext">{$permissionTXT}</td>
										{/if}
										<td align="center" class="headertext" width="10%">{$statusTXT}</td >
										<td align="center" class="headertext" width="30%">Action</td>
									</tr>
									{section name=counter loop=$pageID}
										<tr class="{cycle values="odd_tr,even_tr"}">
											{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
												<td align="center" class="smalltext"><input type="checkbox" name="page_ids[]" value="{$pageID[counter]}" class="checkBox" /></td >
											{else}
												<td align="center" class="bold_text">{$smarty.section.counter.index+$startIndex}</td >
											{/if}											
											<td align="center" class="smalltext">{$pageName[counter]}</td>
											{if $smarty.const.MULTIUSER_ADMIN == 1}
												<td align="center" class="smalltext">{$permission[counter]}</td>
											{/if}
											<td align="center" class="smalltext" id="changeStatusPortion_{$pageID[counter]}">
												{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
													{if $pageStatus[counter] == "Active"}
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_custom', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" />
													{else}
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_custom', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" />
													{/if}												
												{else}
													{if $pageStatus[counter] == "Active"}
														{if $smarty.const.MULTIUSER_ADMIN == 1 and  ($permission[counter] == "Edit" or $permission[counter] == "Full")}
															<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_custom', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" />
														{else}
															<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Active" border="0" title="Don't have the permission" class="changeStatus" />
														{/if}													
													{else}
														{if $smarty.const.MULTIUSER_ADMIN == 1 and  ($permission[counter] == "Edit" or $permission[counter] == "Full")}
															<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_custom', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" />
														{else}
															<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Active" border="0" title="Don't have the permission" class="changeStatus" />
														{/if}			
													{/if}
												{/if}
											</td>
											<td align="center" class="bold_text">
												{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
													<a href="{$adminActualPath}/admin_meta_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Meta Content" title="Update Meta Content" border="0" class="changeStatus" /></a>
													{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
														&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_meta_manager.php?mode=delete_content&page_content_id={$pageID[counter]}&type=custom&encoded_string={$encoded_string}', 'meta content'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_delete.gif" align="absmiddle" alt="Delete Meta Content" title="Delete Meta Content" border="0" class="changeStatus" /></a>{*&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_meta_manager.php?mode=delete_page&page_content_id={$pageID[counter]}&type=custom', 'page'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Page" title="Delete Page" border="0" class="changeStatus" /></a>*}
													{/if}
												{else}
													{if ($smarty.const.MULTIUSER_ADMIN == 1 and  ($permission[counter] == "Edit" or $permission[counter] == "Full"))}
														<a href="{$adminActualPath}/admin_meta_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Meta Content" title="Update Meta Content" border="0" class="changeStatus" /></a>
													{else}
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Meta Content" title="Don't have the permission" border="0" class="changeStatus" />
													{/if}
													{if ($smarty.const.MULTIUSER_ADMIN == 1 and ($permission[counter] == "Delete" or $permission[counter] == "Full"))}	
														&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_meta_manager.php?mode=delete_content&page_content_id={$pageID[counter]}&type=custom&encoded_string={$encoded_string}', 'meta content'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_delete.gif" align="absmiddle" alt="Delete Meta Content" title="Delete Meta Content" border="0" class="changeStatus" /></a>{*&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_meta_manager.php?mode=delete_page&page_content_id={$pageID[counter]}&type=custom', 'page'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Page" title="Delete Page" border="0" class="changeStatus" /></a>*}
													{else}
														&nbsp;|&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_delete.gif" align="absmiddle" alt="Delete Meta Content" title="Don't have the permission" border="0" class="changeStatus" />{*&nbsp;|&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Page" title="Don't have the permission" border="0" class="changeStatus" />*}
													{/if}	
												{/if}
											</td>
										</tr>
									{/section}
									<tr class="header_bgcolor" height="26">
										<td align="left" class="smalltext">&nbsp;</td>
										<td align="left" class="headertext" {if ($smarty.const.MULTILINGUAL == 1 and $type == "custom") or ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1)} colspan="2"{else} colspan="2"{/if}>{$pageCounterTXT}</td>
										<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>
									</tr>
								</table>
								{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="hidden" name="encoded_string" value="{$encoded_string}" />
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
												{if ($smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1) or $smarty.const.MULTIUSER_ADMIN == 0}
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_content">Delete Meta Content</option>
													{*<option value="delete_all_page">Remove Page</option>*}
												{else}
													{if $smarty.const.MULTIUSER_ADMIN == 1 and  ($permission[counter] == "Edit" or $permission[counter] == "Full")}
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													{/if}
													{if ($smarty.const.MULTIUSER_ADMIN == 1 and ($permission[counter] == "Delete" or $permission[counter] == "Full"))}	
													<option value="delete_all_content">Delete Meta Content</option>
													{*<option value="delete_all_page">Remove Page</option>*}
													{/if}
												{/if}
												{if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1}
												<option value="edit_permission">Set Edit Permission for Others</option>
												<option value="delete_permission">Set Delete Permission for Others</option>
												<option value="full_permission">Set Full Permission for Others</option>
												<option value="remove_permission">Remove All Permission for Others</option>
												{/if}
											</select>
										</td>
									</tr>
								</table>
							</form>
							{/if}					
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no {$type} page(s) in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
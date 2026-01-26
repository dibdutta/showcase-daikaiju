{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{*<tr>
					<td align="center">{if $smarty.const.FIXED_PAGE_CREATION == 1}<a href="{$adminActualPath}/admin_content_manager.php?mode=create_page&type={$type}" class="action_link"><strong>Create New Fixed Page</strong></a>{/if}{if $smarty.const.CUSTOM_PAGE_CREATION == 1}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_content_manager.php?mode=create_custom_page&type={$type}" class="action_link"><strong>Add New Custom Page</strong></a>{/if}</td>
				</tr>*}
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
                {if $smarty.const.FIXED_PAGE_CREATION == 1 && $smarty.const.CUSTOM_PAGE_CREATION == 1}
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
                {/if}
				{if $total>0}
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="type" value="{$type}" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext">{*$pageNameTXT*}Page Name</td>
											{if $type == 'custom'}
											<td align="center" class="headertext">Status</td>
											{/if}
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										{section name=counter loop=$pageID}
											<tr class="{cycle values="odd_tr,even_tr"}">											
												<td align="center" class="smalltext">{$pageName[counter]}</td>
												{if $type == 'custom'}
													{if $pageStatus[counter] == "Active"}
													<td align="center" class="smalltext" id="changeStatusPortion_{$pageID[counter]}">
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_{$type}', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" /></td>
													{else}
													<td align="center" class="smalltext" id="changeStatusPortion_{$pageID[counter]}">
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_{$type}', {$pageID[counter]}, 'changeStatusPortion_{$pageID[counter]}');" title="Change Status" class="changeStatus" /></td>
													{/if}
												{/if}
												<td align="center" class="bold_text">
													{if $type=="fixed"}
														{if $totalContent[counter]>0}
															<a href="{$adminActualPath}/admin_content_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Content" title="Update Content" border="0" class="changeStatus" /></a>	
														{else}
															<a href="{$adminActualPath}/admin_content_manager.php?mode=add_content&type={$type}&page_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_add.gif" align="absmiddle" alt="Add Content" title="Add Content" border="0" class="changeStatus" /></a>
														{/if}
													{else}
														<a href="{$adminActualPath}/admin_content_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Content" title="Update Content" border="0" class="changeStatus" /></a>
													{/if}														
													{if $type == 'custom'}
														|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_content_manager.php?mode=delete_page&page_content_id={$pageID[counter]}&type={$type}', 'page'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Page" title="Delete Page" border="0" class="changeStatus" /></a>
													{/if}
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<td align="left" class="headertext" {if $type == 'custom'} colspan="2" {/if}>{$pageCounterTXT}</td>
											<td align="right" class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
							</form>				
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
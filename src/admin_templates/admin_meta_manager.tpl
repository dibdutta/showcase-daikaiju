{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
									<tr class="header_bgcolor" height="26">
										<td align="center" class="headertext">{$pageNameTXT}</td>
										<td align="center" class="headertext" width="30%">Action</td>
									</tr>
									{section name=counter loop=$pageID}
										<tr class="{cycle values="odd_tr,even_tr"}">										
											<td align="center" class="smalltext">{$pageName[counter]}</td>
											<td align="center" class="bold_text">
												{if $type=="fixed"}
													{if $totalContent[counter]>0}
														<a href="{$adminActualPath}/admin_meta_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Meta Content" title="Update Meta Content" border="0" class="changeStatus" /></a>	
													{else}
														<a href="{$adminActualPath}/admin_meta_manager.php?mode=add_content&type={$type}&page_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_add.gif" align="absmiddle" alt="Add Content" title="Add Content" border="0" class="changeStatus" /></a>
													{/if}
												{else}
													<a href="{$adminActualPath}/admin_meta_manager.php?mode=edit_content&type={$type}&page_content_id={$pageID[counter]}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Meta Content" title="Update Meta Content" border="0" class="changeStatus" /></a>
												{/if}
												{if $type == "custom"}
													&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_meta_manager.php?mode=delete_content&page_content_id={$pageID[counter]}&type={$type}&encoded_string={$encoded_string}', 'meta content'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_delete.gif" align="absmiddle" alt="Delete Meta Content" title="Delete Meta Content" border="0" class="changeStatus" /></a>
												{/if}
											</td>
										</tr>
									{/section}
									<tr class="header_bgcolor" height="26">
										<td align="left" class="headertext">{$pageCounterTXT}</td>
										<td align="right" class="headertext">{$displayCounterTXT}</td>
									</tr>
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
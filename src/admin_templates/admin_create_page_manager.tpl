{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">{if $smarty.const.CUSTOM_PAGE_CREATION == 1}<a href="{$adminActualPath}/admin_content_manager.php?mode=create_custom_page" class="action_link"><strong>Add New Custom Page</strong></a>{/if}</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%">
						<form action="" method="post" name="createPage" id="createPage" onSubmit="return CreatePageValidation();">
							<input type="hidden" name="mode" value="saveNewPage">
							<input type="hidden" name="type" value="{$type}">
							<table border="0" cellpadding="2" align="center" cellspacing="1" class="header_bordercolor" width="50%">
								<tr class="header_bgcolor" height="24">
									<td align="left" class="headertext" colspan="2">Create New Fixed Page</td>
								</tr>
								<tr class="tr_bgcolor">
									<td align="left" class="bold_text" width="38%" valign="top"><span class="err">*</span> File Name :
									</td>
									<td align="left" valign="top">&nbsp;<input type="text" name="page_name" value="{$page_name}" class="look" size="30" maxlength="40" /><br><span class="err">{$page_name_err}</span>
									</td>
								</tr>
								<tr class="tr_bgcolor">
									<td align="center" class="bold_text" colspan="2"><input type="submit" name="" value="Create Page" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="" class="button" value="Cancel" onclick="javascript: location.href='{$smarty.const.PHP_SELF}?type={$type}';">
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
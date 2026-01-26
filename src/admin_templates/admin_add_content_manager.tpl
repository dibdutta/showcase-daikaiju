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
				<tr>
					<td width="100%" align="center">
						<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr height="22">
								<td align="center" class="bold_text">Edit Page Content</td>
							</tr>
							{if $type!="custom"}
							<tr height="22">
								<td align="center" class="err"><b>Page Name:&nbsp;&nbsp;{$page_name}</b>
								</td>
							</tr>
							{/if}
							<form method="post" action="">
							<input type="hidden" name="mode" value="save_add_content">
							<input type="hidden" name="page_id" value="{$page_id}">
							<input type="hidden" name="type" value="{$type}">
							<input type="hidden" name="encoded_string" value="{$encoded_string}">
							<tr height="22">
								<td align="center" class="bold_text"><BR><BR>Page Header Name :&nbsp;&nbsp;<input type="text" name="page_header_name" value="{$page_header_name}" class="look" size="30"><BR><BR></td>
							</tr>
							<tr>
								<td align="center">
									<table align="center" width="99%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="2" class="bold_text" height="10">Page Content :<br /></td>
										</tr>
										<tr>
											<td width="100%" colspan="2">{$page_content}</td>
										</tr>
										<tr height="28">
											<td align="center"><input type="submit" name="" value="Save Content" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; "></td>
										</tr>
									</table>
								</td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
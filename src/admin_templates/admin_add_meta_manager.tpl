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
						<form method="post" action="">
							<input type="hidden" name="mode" value="save_add_content">
							<input type="hidden" name="page_id" value="{$page_id}">
							<input type="hidden" name="type" value="{$type}">
							<input type="hidden" name="encoded_string" value="{$encoded_string}">
							<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr height="22">
									<td align="center" class="bold_text">Edit Meta Content</td>
								</tr>
								{if $type!="custom"}
								<tr height="22">
									<td align="center" class="err"><b>Page Name:&nbsp;&nbsp;{$page_name}</b>
									</td>
								</tr>
								{/if}
								<tr>
									<td width="100%">
										<table border="0" align="center" cellpadding="2" cellspacing="1" width="80%" class="header_bordercolor">
											<tr class="header_bgcolor">
												<td class="headertext" height="26" colspan="2">Edit Meta Content</td>
											</tr>
											<tr class="tr_bgcolor">
												<td width="30%" class="bold_text" valign="top">Page Title : </td>
												<td class="smalltext" valign="top"><input type="text" name="page_title" value="{$page_title}" class="look" size="63" maxlength="255" /><br /><span class="err">{$page_title_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Page Header Name : </td>
												<td class="smalltext" valign="top"><input type="text" name="page_header_name" value="{$page_header_name}" class="look" size="63" maxlength="100" /><br /><span class="err">{$page_header_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Meta Keywords : </td>
												<td class="smalltext" valign="top"><textarea name="keywords" cols="60" rows="4" class="look" >{$keywords}</textarea><br /><span class="err">{$keywords_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Meta Description : </td>
												<td class="smalltext" valign="top"><textarea name="description" cols="60" rows="4" class="look" >{$description}</textarea><br /><span class="err">{$description_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Other Meta Tags : </td>
												<td class="smalltext" valign="top"><textarea name="other_meta" cols="60" rows="4" class="look" >{$other_meta}</textarea><br /><span class="small-text">**Please enter with meta tags and attributes.</span><br /><span class="err">{$other_meta_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td colspan="2" align="center" class="smalltext" valign="top"><input type="submit" name="" value="Save Content" class="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; "></td>
											</tr>
										</table>
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
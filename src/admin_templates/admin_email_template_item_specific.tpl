{include file="admin_header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/ZeroClipboard.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function() {
	ZeroClipboard.setMoviePath('http://davidwalsh.name/demo/ZeroClipboard.swf');
	var clip = new ZeroClipboard.Client();
	$("#copy").click(function() {
		$.ajax({
			url: 'admin_account_manager.php?mode=view_template_item_specific', success: function(data) { 
				//alert(data); 
				//clip.addEventListener('mousedown',function() {
				clip.setText(data);
				//});
				clip.addEventListener('complete',function(client,text) {
					alert('Html Successfully Copied!');
				});
				//glue it to the button
				clip.glue('copy');
			} 	 
		});
	});
});

</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>Set Email Template</strong></a></td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_email_template_item_specific">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Email Template</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Auction Id :</td>
												<td valign="top"><input type="text"  name="first_name" value="{$auction_id}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Banner Text :</td>
												<td valign="top"><input type="text"  name="banner_text" value="{$banner_text}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Banner Link :</td>
												<td valign="top"><input type="text"  name="banner_link" value="{$banner_link}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Second Banner Text :</td>
												<td valign="top"><input type="text"  name="fixed_text" value="{$fixed_text}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Second Banner Link :</td>
												<td valign="top"><input type="text"  name="second_banner_link" value="{$second_banner_link}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Title of the Template :</td>
												<td valign="top"><input type="text"  name="title" value="{$title}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Is Auction Item :</td>
												<td valign="top"><input type="checkbox" name="is_auction" value="1" {if $is_auction==1}checked {/if}/><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="View Template" class="button" onclick="javascript:window.open('admin_account_manager.php?mode=view_template_item_specific','_blank');"/>&nbsp;&nbsp;
												<input type="button" name="copy" id="copy" value="Copy Html" class="button" onclick="emailtemplate();"/></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
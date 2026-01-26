{include file="admin_header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/ZeroClipboard.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function() {
	ZeroClipboard.setMoviePath('http://davidwalsh.name/demo/ZeroClipboard.swf');
	var clip = new ZeroClipboard.Client();
	$("#copy").click(function() {
		$.ajax({
			url: 'admin_email_template.php?mode=view_template', success: function(data) { 
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
										<input type="hidden" name="mode" value="save_email_template">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Email Template</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Auction Id(s) :</td>
												<td valign="top" ><input type="text"  name="first_name1" value="{$auction_ids1}" maxlength="400" size="32" /><br>
												<input type="text"  name="first_name2" value="{$auction_ids2}" maxlength="400" size="32"  /><br />
												<input type="text"  name="first_name3" value="{$auction_ids3}" maxlength="400" size="32"  /><br />
												<input type="text"  name="first_name4" value="{$auction_ids4}" maxlength="400" size="32"  /><br />
												<span class="err">{$first_name_err}</span></td>
											</tr>
											<tr>
											 <td colspan="2">
											  <b>Format should be like: 5255,6040,6037,6082,6083 .</b> Not like: 5255, 6040, 6037, 6082 (A space between the Ids)<br />
											  <b>Try to copy the HTML in Crome </b> not in Firefox .
											 </td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Banner Text :</td>
												<td valign="top"><input type="text"  name="banner_text" value="{$banner_text}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Fixed Item Text :</td>
												<td valign="top"><input type="text"  name="fixed_text" value="{$fixed_text}" maxlength="400" size="32" /><br><span class="err">{$first_name_err}</span></td>
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
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="View Template" class="button" onclick="javascript:window.open('admin_email_template.php?mode=view_template','_blank');"/>&nbsp;&nbsp;
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
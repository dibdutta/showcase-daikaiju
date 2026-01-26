{include file="header.tpl"}
<table width="552" border="0" cellspacing="0" cellpadding="0">
	{if $errorMessage<>""}
		<tr>
			<td width="100%" align="center"><div class="messageBox" style="width:365px;">{$errorMessage}</div></td>
		</tr>
	{/if}				
	<tr>
		<td><img src="images/top.jpg" width="552" height="4" /></td>
	</tr>					
	<tr>
		<td class="middle_panel">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="header_bordercolor">													
				<tr>
					<td align="center" valign="top">
						<form name="frmacc" action="" method="post">
						<input type="hidden" name="mode" value="send_activation_code">
						<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" >
							<tr class="header_bgcolor">
								<td colspan="2" align="left" valign="top" class="caption"><b>Activation Code Resend :</b></td>
							</tr>
							<tr>
								<td align="right" class="" width="40%" valign="top"><span class="err">*</span> Username :</td>
								<td valign="top"><input type="text" name="username" value="{$username}" size="32" class="input_textbox" /><br /><span id="username_err" class="err">{$username_err}</span></td>
							</tr>
							<tr>
								<td align="left">&nbsp;</td>
								<td align="left" class=""><input type="submit" name="submit" class="butn_11feb" value="Submit" ></td>
							</tr>
						</table>
					</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>							
	<tr>
		<td><img src="images/dwn.jpg" width="552" height="4" /></td>
	</tr>
</table>
{include file="foot.tpl"}
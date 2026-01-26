{include file="admin_header_login.tpl"}
<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">	
	{if $errorMessage<>""}
		<tr>
			<td width="100%" align="center"><div class="messageBox" style="width: 300px;">{$errorMessage}</div></td>
		</tr>
	{/if}
	<tr>
		<td valign="top" align="left" class="box">
			<table width="100%" border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td valign="top" align="left" width="35%">
						<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_login.gif" alt="" border="0"><br><strong>Welcome to</strong><br>{$smarty.const.ADMIN_WELCOMETEXT}<br><br>Enter your username or email address to reset your password.
					</td>
					<td valign="top" align="left" width="65%">
						<form action="{$smarty.const.PHP_SELF}" method="post" name="form" autocomplete="off" >
							<input type="hidden" name="mode" value="send_password">
							<table width="95%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top" align="left" class="page_heading">Forgot Password</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="dark_box">
										<table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">
											<tr>
												<td valign="top" align="left" class="login_text"><strong>Username&nbsp;/&nbsp;<u>E</u>mail Address</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input class="look" name="email" size="36" value="{$email}" maxlength="150" accesskey="e" /><br /><span class="err">{$email_err}</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="10"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="submit" name="submit" class="button" value="Reset Password" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="Cancel" class="button" value="Cancel" onclick="javascript: location.href='{$smarty.const.PHP_SELF}';" /></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="26"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" alt="" border="0"></td>
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
{include file="admin_footer_login.tpl"}





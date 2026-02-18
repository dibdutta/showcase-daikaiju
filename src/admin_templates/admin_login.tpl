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
						<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_login.gif" alt="" border="0"><br><strong>Welcome to</strong><br>{$smarty.const.ADMIN_WELCOMETEXT}<br><br>Use a valid username and password to gain access to the administration console.
					</td>
					<td valign="top" align="left" width="65%">
						<form action="{$smarty.const.PHP_SELF}" method="post" name="form" autocomplete="off" >
							<input type="hidden" name="mode" value="checkLogin">
							<table width="95%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top" align="left" class="page_heading">Login</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="dark_box">
										<table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">
											<tr>
												<td valign="top" align="left" class="login_text"><strong><u>U</u>sername</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input class="look" name="user_name" size="30" value="" maxlength="16" accesskey="u" tabindex="1" /><br /><span class="err">{$user_name_err}</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><strong><u>P</u>assword</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="password"  name="password" class="look" size="30" maxlength="16" accesskey="p" tabindex="2"/><br /><span class="err">{$password_err}</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="image" src="{$smarty.const.CLOUD_STATIC_ADMIN}btn_login.gif" alt="Login" border="0" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_login.php?mode=forgotpassword" class="action_link"><b>Forgot Password?</b></a></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" alt="" border="0"></td>
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
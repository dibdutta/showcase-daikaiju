{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="{$adminActualPath}/admin_super_manager.php?mode=change_profile" class="action_link"><strong>Update Profile</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$adminActualPath}/admin_account_manager.php?mode=change_password" class="action_link"><strong>Change Password</strong></a></td>
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
									<div class="err">* Marked fields are mandatory.</div>
									<form action="" method="post" name="createUser" id="createUser">
										<input type="hidden" name="mode" value="createNewUser">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Change Profile</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Username :</td>
												<td valign="top"><input type="text" class="look" name="user_name" value="{$user_name}" maxlength="16" size="32" autocomplete="off" /><br><span class="err">{$user_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Password :</td>
												<td valign="top"><input type="text" class="look" name="password" value="{$password}" maxlength="16" size="32" autocomplete="off" /><br><span class="err">{$password_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Confirm Password :</td>
												<td valign="top"><input type="text" class="look" name="cpassword" value="{$cpassword}" maxlength="16" size="32" autocomplete="off" /><br><span class="err">{$cpassword_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> First Name :</td>
												<td valign="top"><input type="text" class="look" name="first_name" value="{$first_name}" maxlength="80" size="32" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">&nbsp;</span> Middle Name :</td>
												<td valign="top"><input type="text" class="look" name="middle_name" value="{$middle_name}" maxlength="80" size="32" /><br><span class="err">{$middle_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Last Name :</td>
												<td valign="top"><input type="text" class="look" name="last_name" value="{$last_name}" maxlength="80" size="32" /><br><span class="err">{$last_name_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Email Address :</td>
												<td valign="top"><input type="text" class="look" name="email" value="{$email}" maxlength="150" size="32" /><br><span class="err">{$email_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Retype Email Address :</td>
												<td valign="top"><input type="text" class="look" name="cemail" value="{$cemail}" maxlength="150" size="32" /><br><span class="err">{$cemail_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;
                        <input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$decoded_string}'; " /></td>
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
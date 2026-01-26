{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err">{if $smarty.session.superAdmin == 1 && $smarty.const.SUPER_ADMIN_CREATION == 1}<a href="{$adminActualPath}/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/if}<a href="{$adminActualPath}/admin_account_manager.php" class="action_link"><strong>Update Profile</strong></a></td>
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
									<form action="" method="post" name="changePassword" id="changePassword">
										<input type="hidden" name="mode" value="save_password" />
										{if $admin_id!=""}
											<input type="hidden" name="admin_id" value="{$admin_id}" />
										{/if}
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Change Password</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Old Password :</td>
												<td valign="top"><input type="password" class="look" name="oldpassword" value="{$oldpassword}" maxlength="16" /><br><span class="err">{$oldpassword_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top">New Password :</td>
												<td valign="top"><input type="password"  name="newpassword" value="{$newpassword}" class="look" maxlength="16" /><br><span class="err">{$newpassword_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top">Retype New Password :</td>
												<td valign="top"><input type="password"  name="cnewpassword" value="{$cnewpassword}" class="look" maxlength="16" /><br><span class="err">{$cnewpassword_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Change Password">&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$smarty.const.PHP_SELF}'; " /></td>
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
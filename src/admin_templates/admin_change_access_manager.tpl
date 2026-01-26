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
						<table width="80%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									<div class="err">* Marked fields are mandatory.</div>
									<form action="" method="post" name="changeAccess" id="changeAccess">
										<input type="hidden" name="mode" value="saveChangeAccess" />
										<input type="hidden" name="admin_id" value="{$admin_id}" />
										<table border="0" cellpadding="5" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Change Access</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">&nbsp;</span> Administrator's Name :</td>
												<td valign="top" class="smalltext">{$administratorName}</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">&nbsp;</span> Administrator's Email :</td>
												<td valign="top" class="smalltext">{$administratorEmail}</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">&nbsp;</span> Select section(s) to give access :</td>
												<td valign="top" class="smalltext">
													{html_checkboxes name='sections' values=$sectionID output=$sectionDesc selected=$selectedSection labels=false divStyle='float: left; width:185px; padding: 2px 0 2px 0;' class="checkBox" separator='<br />'}											
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Change Access" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$smarty.const.PHP_SELF}'; " /></td>
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
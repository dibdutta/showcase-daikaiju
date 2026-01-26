{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{*<tr>
					<td width="100%" align="center" class="err">{if $smarty.session.superAdmin == 1}<a href="{$adminActualPath}/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/if}<a href="{$adminActualPath}/admin_account_manager.php?mode=change_password" class="action_link"><strong>Change Password</strong></a></td>
				</tr>*}
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
									{*<div class="err">* Marked fields are mandatory.</div>*}
									<form action="" method="post" name="addCategory" id="addCategory">
										<input type="hidden" name="mode" value="save_category">
										<input type="hidden" name="encoded_string" value="{$encoded_string}">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Add Condition</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span>&nbsp;Select Type :</td>
												<td valign="top">
                                                <select name="fk_cat_type_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$commonCatTypes}
                                                    	<option value="{$commonCatTypes[counter].cat_type_id}" {if $fk_cat_type_id eq $commonCatTypes[counter].cat_type_id}selected{/if}>{$commonCatTypes[counter].cat_type}</option>
                                                    {/section}
                                                </select>
                                                <br /><span class="err">{$fk_cat_type_id_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Condition Title :</td>
												<td valign="top"><input type="text" class="look" name="cat_value" value="{$cat_value}" size="45" /><br /><span class="err">{$cat_value_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save Condition" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$decoded_string}'; " /></td>
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
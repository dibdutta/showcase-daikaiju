{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>Upcoming Auction Calender</strong></a></td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table width="70%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_calender_template">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="3" class="headertext"><b>Upcoming Auction Calender</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 1 :</td>
												<td valign="top"><input type="text"  name="upcoming_1" value="{$upcoming_1}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_1" value="{$upcoming_link_1}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 2 :</td>
												<td valign="top"><input type="text"  name="upcoming_2" value="{$upcoming_2}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_2" value="{$upcoming_link_2}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 3 :</td>
												<td valign="top"><input type="text"  name="upcoming_3" value="{$upcoming_3}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_3" value="{$upcoming_link_3}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Upcoming Auction 4 :</td>
												<td valign="top"><input type="text"  name="upcoming_4" value="{$upcoming_4}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_4" value="{$upcoming_link_4}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 5 :</td>
												<td valign="top"><input type="text"  name="upcoming_5" value="{$upcoming_5}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_5" value="{$upcoming_link_5}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=3><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;&nbsp;
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
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
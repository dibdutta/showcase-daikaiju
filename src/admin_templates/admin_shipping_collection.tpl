{include file="admin_header.tpl"}


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>MPE Year wise Shipping Collection</strong></a></td>
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
										<input type="hidden" name="mode" value="shipping">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Select Year :</td>
												<td valign="top">
													<select name="year">
														<option value="2018">2018</option>
														<option value="2017">2017</option>
														<option value="2016">2016</option>
														
													</select>
												</td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Total Shipping :</td>
												<td valign="top">${$totalShipping} Against Total Invoice: {$totalInvoice}</td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> </td>
												<td valign="top"></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Total Discounts :</td>
												<td valign="top">{$totalDiscounts}</td>
											</tr>
																				
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Get Shipping" >&nbsp;&nbsp;&nbsp;&nbsp;												
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
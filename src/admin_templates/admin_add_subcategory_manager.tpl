{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{if $errorMessage != ""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									<form action="" method="post" name="addSubcategory" id="addSubcategory">
										<input type="hidden" name="mode" value="save_subcategory" />
										<input type="hidden" name="encoded_string" value="{$encoded_string}" />
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Add Subcategory</b></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Parent Category :</td>
												<td valign="top">
													<select name="fk_shop_cat_id" id="fk_shop_cat_id" class="look">
														<option value="">Select Category</option>
														{section name=sc loop=$shopCategories}
															<option value="{$shopCategories[sc].shop_cat_id}" {if $fk_shop_cat_id == $shopCategories[sc].shop_cat_id}selected="selected"{/if}>{$shopCategories[sc].shop_cat_name}</option>
														{/section}
													</select>
													<br /><span class="err">{$fk_shop_cat_id_err}</span>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Subcategory Name :</td>
												<td valign="top">
													<input type="text" class="look" name="subcat_value" id="subcat_value" value="{$subcat_value|default:''}" size="45" />
													<br /><span class="err">{$subcat_value_err}</span>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan="2">
													<input type="submit" name="submit" class="button" value="Save Subcategory" />&nbsp;&nbsp;&nbsp;
													<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$adminActualPath}/admin_subcategory_manager.php';" />
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

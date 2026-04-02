{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{if $errorMessage != ""}
					<tr><td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td></tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table width="50%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									<form action="" method="post" name="editShopCategory" id="editShopCategory">
										<input type="hidden" name="mode" value="update_shop_category" />
										<input type="hidden" name="shop_cat_id" value="{$shop_cat_id}" />
										<input type="hidden" name="encoded_string" value="{$encoded_string}" />
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Edit Category</b></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Category Name :</td>
												<td valign="top">
													<input type="text" class="look" name="shop_cat_name" id="shop_cat_name" value="{$shopCat.shop_cat_name|escape}" size="45" />
													<br /><span class="err">{$shop_cat_name_err}</span>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Sort Order :</td>
												<td valign="top">
													<input type="text" class="look" name="sort_order" id="sort_order" value="{$shopCat.sort_order}" size="10" />
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Active :</td>
												<td valign="top">
													<select name="is_active" class="look">
														<option value="1" {if $shopCat.is_active == 1}selected{/if}>Yes</option>
														<option value="0" {if $shopCat.is_active == 0}selected{/if}>No</option>
													</select>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan="2">
													<input type="submit" name="submit" class="button" value="Update Category" />&nbsp;&nbsp;&nbsp;
													<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$adminActualPath}/admin_shop_category_manager.php';" />
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

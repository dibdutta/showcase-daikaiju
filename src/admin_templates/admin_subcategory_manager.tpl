{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center">
									<a href="{$adminActualPath}/admin_subcategory_manager.php?mode=add_subcategory&encoded_string={$encoded_string}" class="action_link"><strong>Create New Subcategory</strong></a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				{if $smarty.session.adminErr != ""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$smarty.session.adminErr}</div></td>
					</tr>
					{php}unset($_SESSION['adminErr']);{/php}
				{/if}
				<tr>
					<td align="center">
						<form method="get" action="">
							<input type="hidden" name="encoded_string" value="{$encoded_string}" />
							Filter by Category:&nbsp;
							<select name="filter_shop_cat_id" class="look" onchange="this.form.submit()">
								<option value="">All Categories</option>
								{section name=sc loop=$shopCategories}
									<option value="{$shopCategories[sc].shop_cat_id}" {if $filter_shop_cat_id == $shopCategories[sc].shop_cat_id}selected="selected"{/if}>{$shopCategories[sc].shop_cat_name}</option>
								{/section}
							</select>
						</form>
					</td>
				</tr>
				{if $total > 0}
					<tr>
						<td align="center">
							<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
								<tbody>
									<tr class="header_bgcolor" height="26">
										<td align="center" class="headertext" width="35%">Parent Category</td>
										<td align="center" class="headertext" width="45%">Subcategory</td>
										<td align="center" class="headertext" width="20%">Action</td>
									</tr>
									{section name=counter loop=$subcatRows}
										<tr class="{cycle values='odd_tr,even_tr'}">
											<td align="center" class="smalltext">{$subcatRows[counter].cat_name}</td>
											<td align="center" class="smalltext">{$subcatRows[counter].subcat_value}</td>
											<td align="center" class="bold_text">
												<a href="{$adminActualPath}/admin_subcategory_manager.php?mode=edit_subcategory&subcat_id={$subcatRows[counter].subcat_id}&encoded_string={$encoded_string}" class="view_link">
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Edit" title="Edit" border="0" />
												</a>&nbsp;&nbsp;
												<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_subcategory_manager.php?mode=delete&subcat_id={$subcatRows[counter].subcat_id}&encoded_string={$encoded_string}', 'Record'); return false;">
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" />
												</a>
											</td>
										</tr>
									{/section}
									<tr class="header_bgcolor" height="26">
										<td align="left" class="headertext" colspan="2">{$pageCounterTXT}</td>
										<td align="right" class="headertext">{$displayCounterTXT}</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">No subcategories found.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>
</table>
{include file="admin_footer.tpl"}

{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<a href="{$adminActualPath}/admin_shop_category_manager.php?mode=add_shop_category&encoded_string={$encoded_string}" class="action_link"><strong>Add New Category</strong></a>
					</td>
				</tr>
				{if $smarty.session.adminErr != ""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$smarty.session.adminErr}</div></td>
					</tr>
					{php}unset($_SESSION['adminErr']);{/php}
				{/if}
				{if $total > 0}
					<tr>
						<td align="center">
							<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
								<tbody>
									<tr class="header_bgcolor" height="26">
										<td align="center" class="headertext" width="10%">Order</td>
										<td align="center" class="headertext" width="60%">Category Name</td>
										<td align="center" class="headertext" width="30%">Action</td>
									</tr>
									{section name=counter loop=$shopCatRows}
										<tr class="{cycle values='odd_tr,even_tr'}">
											<td align="center" class="smalltext">{$shopCatRows[counter].sort_order}</td>
											<td align="center" class="smalltext">{$shopCatRows[counter].shop_cat_name}</td>
											<td align="center" class="bold_text">
												<a href="{$adminActualPath}/admin_shop_category_manager.php?mode=edit_shop_category&shop_cat_id={$shopCatRows[counter].shop_cat_id}&encoded_string={$encoded_string}" class="view_link">
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Edit" border="0" />
												</a>&nbsp;&nbsp;
												<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_shop_category_manager.php?mode=delete&shop_cat_id={$shopCatRows[counter].shop_cat_id}&encoded_string={$encoded_string}', 'Record'); return false;">
													<img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" border="0" />
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
					<tr><td align="center" class="err">No categories found. Add one above.</td></tr>
				{/if}
			</table>
		</td>
	</tr>
</table>
{include file="admin_footer.tpl"}

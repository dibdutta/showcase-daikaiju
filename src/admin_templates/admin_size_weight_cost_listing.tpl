{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="{$adminActualPath}/admin_size_weight_cost.php?mode=add_size&encoded_string={$encoded_string}" class="action_link"><strong>Add New Size</strong></a></td>
                </tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%">Sl No</td >
											<td align="center" class="headertext" width="12%">Name</td>
											<td align="center" class="headertext" width="12%">Length</td>
											<td align="center" class="headertext" width="12%">Width</td >
											<td align="center" class="headertext" width="12%">Height</td>
											<td align="center" class="headertext" width="12%">Weight</td>
											<td align="center" class="headertext" width="12%">Packaging Cost</td>
											<td align="center" class="headertext" width="12%">Packaging Type</td>
											<td align="center" class="headertext" width="12%">Action</td>
										</tr>
										{section name=counter loop=$sizeRow}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="smalltext">{$smarty.section.counter.index+1}</td>
												<td align="center" class="smalltext">{$sizeRow[counter].name}</td>
												<td align="center" class="smalltext">{$sizeRow[counter].length}"</td>
												<td align="center" class="smalltext" >{$sizeRow[counter].width}"</td>
												<td align="center" class="smalltext">{$sizeRow[counter].height}"</td>
												<td align="center" class="smalltext">{if $sizeRow[counter].weight_lb >0}{$sizeRow[counter].weight_lb}lb{/if}&nbsp;{if $sizeRow[counter].weight_oz >0}{$sizeRow[counter].weight_oz}oz{/if}</td>
												<td align="center" class="smalltext">${$sizeRow[counter].packaging_cost}</td>
												<td align="center" class="smalltext">{if $sizeRow[counter].size_type=='f'}Folded{else}Rolled{/if}</td>
												<td align="center"><a href="{$adminActualPath}/admin_size_weight_cost.php?mode=edit_size&size_id={$sizeRow[counter].size_weight_cost_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Record" title="Update Record" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_size_weight_cost.php?mode=delete_size&size_id={$sizeRow[counter].size_weight_cost_id}&encoded_string={$encoded_string}', 'record'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Record" title="Delete Record" border="0" class="changeStatus" /></a></td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>
											<td align="right" class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_user">Delete User</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no size in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
{include file="admin_header.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center">{*if $cat_type_id!=5*}<a href="{$adminActualPath}/admin_category_manager.php?mode=add_category&encoded_string={$encoded_string}" class="action_link"><strong>Create New Category</strong></a>{*else} <a href="{$adminActualPath}/admin_category_manager.php?mode=add_condition&encoded_string={$encoded_string}" class="action_link"><strong>Create New Condition</strong></a>{/if*}</td>
							</tr>
						</table>
					</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
									<!--  <tr>
									<td colspan="2">Sort By:&nbsp;
									<select name="search" class="look" id='search_id' onChange="this.form.submit();">
                                        	<option value="cat_id" selected="selected" >Category Id</option>
                                        	<option value="cat_value" {if $search == "cat_value"} selected="selected"{/if} >Category Name</option>
<!--                                        	<option value="weekly" {if $search == "weekly"} selected="selected"{/if} >Weekly</option>-->
<!--                                        	<option value="monthly" {if $search == "monthly"} selected="selected"{/if} >Monthly</option>-->
									<!--	</select>
									</td>
									</tr>-->
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="64%">
											{if $cat_type_id==1}Poster Size
											{elseif $cat_type_id==2}Genre
											{elseif $cat_type_id==3}Decade
											{elseif $cat_type_id==4}Country
											{else} Condition
											{/if}</td>
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										{assign var='name' value=''}
										{section name=counter loop=$catRows}
										{if $catRows[counter].name!=''}
										  {if $name!=$catRows[counter].name}
											 <tr class="header_bgcolor">
												<td align="center" class="headertext"  colspan="2">
													{$catRows[counter].name} ({if $catRows[counter].size_type=='f' } Folded {else} Rolled {/if})
												</td>
											 </tr>
										   {/if}
										 {/if}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="{$catRows[counter].cat_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext">{$catRows[counter].cat_value}</td>
												<td align="center" class="bold_text">
                                                	{*if $catRows[counter].cat_value!='Default'*}
													<a href="{$adminActualPath}/admin_category_manager.php?mode=edit_category&cat_type_id={$cat_type_id}&cat_id={$catRows[counter].cat_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_category_manager.php?mode=delete&cat_type_id={$cat_type_id}&cat_id={$catRows[counter].cat_id}&encoded_string={$encoded_string}', 'Record'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>
                                                    {*/if*}
												</td>
											</tr>
											{assign var='name' value=$catRows[counter].name}
										{/section}
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" class="headertext">{$pageCounterTXT}</td>
											<td align="right" class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_category">Delete Category</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no category in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
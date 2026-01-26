{include file="admin_header.tpl"}
{literal}
<script type="text/javascript">
function chksubmit(){
	var cat_value=$("#cat_value").val();
	if(cat_value!=''){
	 var size_id=$("#size_type_id").val();
	 if(size_id==''){
	 	$("#fk_cat_type_id").focus();
	 	alert("Please select a packaging type");
		return false;
	 }
  }	else{
  	$("#cat_value").focus();
  	alert("Please provide a Category name");
    return false;
  }
}
</script>
{/literal}
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
									<form action="" method="post" name="editCategory" id="editCategory" onsubmit="return chksubmit()">
										<input type="hidden" name="mode" value="update_category">
										<input type="hidden" name="cat_id" value="{$cat_id}">
										<input type="hidden" name="encoded_string" value="{$encoded_string}">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
                                            {*if $cat_type_id!=5*}
												<td colspan="2" class="headertext"><b>Edit Category</b>
                                                {*else}
                                                <td colspan="2" class="headertext"><b>Edit Condition</b>
                                                {/if*}
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> {if $cat_type_id!=5}Category :{else}Condition :{/if}</td>
												<td valign="top"><input type="text" class="look" name="cat_value" value="{$category[0].cat_value|escape}" id="cat_value" /><br /><span class="err">{$cat_value_err}</span></td>
											</tr>
											{if $cat_type_id==1}
											<tr class="tr_bgcolor" id="packaging_type" >
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Packaging Type :</td>
												<td valign="top" ><select name="packaging_type" class="look" id="size_type_id">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$commonSizeTypes}
                                                    	<option {if $category[0].fk_size_weight_cost_id==$commonSizeTypes[counter].size_weight_cost_id} selected="selected"{/if}value="{$commonSizeTypes[counter].size_weight_cost_id}" >{$commonSizeTypes[counter].name}</option>
                                                    {/section}
                                                </select>
                                                <br /><span class="err">{$fk_cat_type_id_err}</span></td>
											</tr>
											{/if}
											{if $cat_type_id==2}
												<tr class="tr_bgcolor" id="is_stills_id">
													<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> For Stills :</td>
													<td valign="top"><input type="checkbox" class="look" name="is_stills" value="1" size="45" id="is_stills" {if $category[0].is_stills=='1'} checked="checked" {/if} /><br /><span class="err">{$is_stills_err}</span></td>
												</tr>
											{/if}
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2>{if $cat_type_id!=5}<input type="submit" name="submit" class="button" value="Save Category" >{else}<input type="submit" name="submit" class="button" value="Save Condition" >{/if}&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
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
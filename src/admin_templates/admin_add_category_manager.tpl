{include file="admin_header.tpl"}

{literal}
<script type="text/javascript">
function chkPack(id){
	if(id==1){
		document.getElementById('packaging_type').style.display="block";
	 }else{
	 	document.getElementById('packaging_type').style.display="none";
	 }
	if(id==2){
		document.getElementById('is_stills_id').style.display="block";
	 }else{
	 	document.getElementById('is_stills_id').style.display="none";
	 }
}
function chksubmit(){
	var fk_cat_type_id=$("#fk_cat_type_id").val();
	if(fk_cat_type_id!=''){
	var cat_value=$("#cat_value").val();
	if(cat_value!=''){
	if(fk_cat_type_id=='1'){
	 var size_id=$("#size_type_id").val();
	 if(size_id==''){
	 	$("#fk_cat_type_id").focus();
	 	alert("Please select a packaging type");
		return false;
	 }
	}
  }	else{
  	$("#cat_value").focus();
  	alert("Please provide a Category name");
    return false;
  }
 }else{
 	$("#size_type_id").focus();
 	alert("Please select a category type");
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
									{*<div class="err">* Marked fields are mandatory.</div>*}
									<form action="" method="post" name="addCategory" id="addCategory" onsubmit="return chksubmit()">
										<input type="hidden" name="mode" value="save_category">
										<input type="hidden" name="encoded_string" value="{$encoded_string}">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Add Category</b></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Category Type :</td>
												<td valign="top">
                                                <select name="fk_cat_type_id" id="fk_cat_type_id" class="look" onchange="chkPack(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$commonCatTypes}
                                                    	<option value="{$commonCatTypes[counter].cat_type_id}" {if $fk_cat_type_id eq $commonCatTypes[counter].cat_type_id}selected{/if}>{$commonCatTypes[counter].cat_type}</option>
                                                    {/section}
                                                </select>
                                                <br /><span class="err">{$fk_cat_type_id_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Category :</td>
												<td valign="top"><input type="text" class="look" name="cat_value" value="{$cat_value}" size="45" id="cat_value" /><br /><span class="err">{$cat_value_err}</span></td>
											</tr>
											<tr class="tr_bgcolor"  >
												<td colspan="2" >
												<div id="packaging_type" {if $fk_cat_type_id!='1'}style="display:none;"{/if}>
													<table width="100%" cellpadding="0" cellspacing="0" border="0">
														<tr>
														<td align="left" width="36%" class="bold_text" valign="top"><span class="err">*</span> Packaging Type :</td>
												<td valign="top" ><select name="packaging_type" class="look" id="size_type_id">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$commonSizeTypes}
                                                    	<option value="{$commonSizeTypes[counter].size_weight_cost_id}" {if $packaging_type eq $commonSizeTypes[counter].size_weight_cost_id}selected{/if} >{$commonSizeTypes[counter].name}</option>
                                                    {/section}
                                                </select>
                                                <br /><span class="err">{$fk_cat_type_id_err}</span></td>
														</tr>
													</table>
												</div>
												</td>
											</tr>
											<tr class="tr_bgcolor" {if $smarty.request.cat_type_id!="2"} style="display:none;" {/if} id="is_stills_id">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> For Stills :</td>
												<td valign="top"><input type="checkbox" class="look" name="is_stills" value="1" size="45" id="is_stills" /><br /><span class="err">{$is_stills_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save Category" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$decoded_string}'; " /></td>
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
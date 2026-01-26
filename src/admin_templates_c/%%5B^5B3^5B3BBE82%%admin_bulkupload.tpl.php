<?php /* Smarty version 2.6.14, created on 2018-07-22 11:14:28
         compiled from admin_bulkupload.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/formvalidation.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/jquery.validate.js"></script>
<?php echo '
<script type="text/javascript">
function autocom(q){
	var url = "../ajax.php?mode=autocomplete_admin&q=" + q;
	jQuery.ajax({
  	type : \'GET\',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	  if(data!=\'\'){
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else{
		$("#auto_load").hide();
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	}
	
	function set_result(name,id){
		document.getElementById(\'user\').value=name;
		document.getElementById(\'user_id\').value=id;
		$("#auto_load").hide();
	}
	</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
	<tr>
		<td width="100%" align="center">
			<form name="frm_bulkupload"  action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="save_bulkupload">
				<table width="50%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Bulk Upload</b></td>
					</tr>
					<!--<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>User :</td>
												<td class="smalltext">
                                                <div class="UserNameSearch" style="position:relative;">
												<div><input type="text" name="user" id="user"  class="look" value="<?php echo $this->_tpl_vars['user']; ?>
"  onkeyup="autocom(this.value);"/></div>						
                       						    <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->_tpl_vars['user_id']; ?>
"  class="look"/>
												<br /><span class="err"><?php echo $this->_tpl_vars['user_id_err']; ?>
</span>
                                                </div>
                                                </td>
                                                
											</tr>-->
					<tr class="tr_bgcolor">
						<td valign="top" width="40%"><span class="err">*</span> Browse File (max 20 mb): </td>
						<td><input type="file" name="bulkupload"  class="look" />
                         <br /><span class="err"><?php echo $this->_tpl_vars['bulkupload_err']; ?>
</span>
                         </td>
					</tr>
					<tr class="tr_bgcolor">
						<td align="center" colspan="2" class="bold_text" valign="top">
						<input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;
                        <input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $this->_tpl_vars['decoded_string']; ?>
'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:44:17
  from '/var/www/html/admin_templates/admin_profile_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981eda1132a28_15099193',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '45a1699cdd90a41deef44373e78d9fb602c7eed1' => 
    array (
      0 => '/var/www/html/admin_templates/admin_profile_manager.tpl',
      1 => 1487960190,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981eda1132a28_15099193 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><?php if ($_SESSION['superAdmin'] == 1 && (defined('SUPER_ADMIN_CREATION') ? constant('SUPER_ADMIN_CREATION') : null) == 1) {?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php }?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_account_manager.php?mode=change_password" class="action_link"><strong>Change Password</strong></a></td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									<div class="err">* Marked fields are mandatory.</div>
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_change_profile">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Change Profile</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> First Name :</td>
												<td valign="top"><input type="text" class="look" name="first_name" value="<?php echo $_smarty_tpl->tpl_vars['first_name']->value;?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">&nbsp;</span> Middle Name :</td>
												<td valign="top"><input type="text" class="look" name="middle_name" value="<?php echo $_smarty_tpl->tpl_vars['middle_name']->value;?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['middle_name_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Last Name :</td>
												<td valign="top"><input type="text" class="look" name="last_name" value="<?php echo $_smarty_tpl->tpl_vars['last_name']->value;?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['last_name_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Email Address :</td>
												<td valign="top"><input type="text" class="look" name="email" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" maxlength="150" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['email_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Retype Email Address :</td>
												<td valign="top"><input type="text" class="look" name="cemail" value="<?php echo $_smarty_tpl->tpl_vars['cemail']->value;?>
" maxlength="150" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['cemail_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Change Profile" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='admin_main.php'; " /></td>
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
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

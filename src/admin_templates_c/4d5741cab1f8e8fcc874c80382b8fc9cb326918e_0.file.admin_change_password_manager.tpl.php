<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:44:31
  from '/var/www/html/admin_templates/admin_change_password_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981edaf82f084_49997773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d5741cab1f8e8fcc874c80382b8fc9cb326918e' => 
    array (
      0 => '/var/www/html/admin_templates/admin_change_password_manager.tpl',
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
function content_6981edaf82f084_49997773 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><?php if ($_SESSION['superAdmin'] == 1 && (defined('SUPER_ADMIN_CREATION') ? constant('SUPER_ADMIN_CREATION') : null) == 1) {?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php }?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_account_manager.php" class="action_link"><strong>Update Profile</strong></a></td>
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
									<form action="" method="post" name="changePassword" id="changePassword">
										<input type="hidden" name="mode" value="save_password" />
										<?php if ($_smarty_tpl->tpl_vars['admin_id']->value != '') {?>
											<input type="hidden" name="admin_id" value="<?php echo $_smarty_tpl->tpl_vars['admin_id']->value;?>
" />
										<?php }?>
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Change Password</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Old Password :</td>
												<td valign="top"><input type="password" class="look" name="oldpassword" value="<?php echo $_smarty_tpl->tpl_vars['oldpassword']->value;?>
" maxlength="16" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['oldpassword_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top">New Password :</td>
												<td valign="top"><input type="password"  name="newpassword" value="<?php echo $_smarty_tpl->tpl_vars['newpassword']->value;?>
" class="look" maxlength="16" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['newpassword_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top">Retype New Password :</td>
												<td valign="top"><input type="password"  name="cnewpassword" value="<?php echo $_smarty_tpl->tpl_vars['cnewpassword']->value;?>
" class="look" maxlength="16" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['cnewpassword_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Change Password">&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo (defined('PHP_SELF') ? constant('PHP_SELF') : null);?>
'; " /></td>
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

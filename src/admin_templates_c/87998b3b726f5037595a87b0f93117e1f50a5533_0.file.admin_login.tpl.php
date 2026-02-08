<?php
/* Smarty version 3.1.47, created on 2026-02-01 12:36:34
  from '/var/www/html/admin_templates/admin_login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_697f8f2292b5a5_10372636',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87998b3b726f5037595a87b0f93117e1f50a5533' => 
    array (
      0 => '/var/www/html/admin_templates/admin_login.tpl',
      1 => 1487960220,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header_login.tpl' => 1,
    'file:admin_footer_login.tpl' => 1,
  ),
),false)) {
function content_697f8f2292b5a5_10372636 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header_login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">	
	<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
		<tr>
			<td width="100%" align="center"><div class="messageBox" style="width: 300px;"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
		</tr>
	<?php }?>
	<tr>
		<td valign="top" align="left" class="box">
			<table width="100%" border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td valign="top" align="left" width="35%">
						<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_login.gif" alt="" border="0"><br><strong>Welcome to</strong><br><?php echo (defined('ADMIN_WELCOMETEXT') ? constant('ADMIN_WELCOMETEXT') : null);?>
<br><br>Use a valid username and password to gain access to the administration console.
					</td>
					<td valign="top" align="left" width="65%">
						<form action="<?php echo $_smarty_tpl->tpl_vars['smalrty']->value['const']['PHP_SELF'];?>
" method="post" name="form" autocomplete="off" >
							<input type="hidden" name="mode" value="checkLogin">
							<table width="95%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top" align="left" class="page_heading">Login</td>
								</tr>
								<tr>
									<td valign="top" align="left" class="dark_box">
										<table width="98%" border="0" cellspacing="0" cellpadding="3" align="center">
											<tr>
												<td valign="top" align="left" class="login_text"><strong><u>U</u>sername</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input class="look" name="user_name" size="30" value="" maxlength="16" accesskey="u" tabindex="1" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['user_name_err']->value;?>
</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><strong><u>P</u>assword</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="password"  name="password" class="look" size="30" maxlength="16" accesskey="p" tabindex="2"/><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['password_err']->value;?>
</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="image" src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
btn_login.gif" alt="Login" border="0" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_login.php?mode=forgotpassword" class="action_link"><b>Forgot Password?</b></a></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
blank.gif" alt="" border="0"></td>
											</tr>
										</table>
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
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer_login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

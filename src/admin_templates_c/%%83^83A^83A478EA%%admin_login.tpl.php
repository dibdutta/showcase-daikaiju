<?php /* Smarty version 2.6.14, created on 2017-02-25 12:46:25
         compiled from admin_login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header_login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">	
	<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
		<tr>
			<td width="100%" align="center"><div class="messageBox" style="width: 300px;"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td valign="top" align="left" class="box">
			<table width="100%" border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td valign="top" align="left" width="35%">
						<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_login.gif" alt="" border="0"><br><strong>Welcome to</strong><br><?php echo @ADMIN_WELCOMETEXT; ?>
<br><br>Use a valid username and password to gain access to the administration console.
					</td>
					<td valign="top" align="left" width="65%">
						<form action="<?php echo $this->_tpl_vars['smalrty']['const']['PHP_SELF']; ?>
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
												<td valign="top" align="left" class="login_text"><input class="look" name="user_name" size="30" value="" maxlength="16" accesskey="u" tabindex="1" /><br /><span class="err"><?php echo $this->_tpl_vars['user_name_err']; ?>
</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><strong><u>P</u>assword</strong></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="password"  name="password" class="look" size="30" maxlength="16" accesskey="p" tabindex="2"/><br /><span class="err"><?php echo $this->_tpl_vars['password_err']; ?>
</span></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
blank.gif" alt="" border="0"></td>
											</tr>
											<tr>
												<td valign="top" align="left" class="login_text"><input type="image" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
btn_login.gif" alt="Login" border="0" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_login.php?mode=forgotpassword" class="action_link"><b>Forgot Password?</b></a></td>
											</tr>
											<tr>
												<td valign="top" align="left" height="2"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer_login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php /* Smarty version 2.6.14, created on 2017-10-21 13:28:48
         compiled from admin_profile_manager.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><?php if ($_SESSION['superAdmin'] == 1 && @SUPER_ADMIN_CREATION == 1): ?><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_super_manager.php?mode=create_user" class="action_link"><strong>Add New Administrator</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; ?><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_account_manager.php?mode=change_password" class="action_link"><strong>Change Password</strong></a></td>
				</tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
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
												<td valign="top"><input type="text" class="look" name="first_name" value="<?php echo $this->_tpl_vars['first_name']; ?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">&nbsp;</span> Middle Name :</td>
												<td valign="top"><input type="text" class="look" name="middle_name" value="<?php echo $this->_tpl_vars['middle_name']; ?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $this->_tpl_vars['middle_name_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Last Name :</td>
												<td valign="top"><input type="text" class="look" name="last_name" value="<?php echo $this->_tpl_vars['last_name']; ?>
" maxlength="80" size="32" /><br><span class="err"><?php echo $this->_tpl_vars['last_name_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Email Address :</td>
												<td valign="top"><input type="text" class="look" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" maxlength="150" size="32" /><br><span class="err"><?php echo $this->_tpl_vars['email_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" valign="top"><span class="err">*</span> Retype Email Address :</td>
												<td valign="top"><input type="text" class="look" name="cemail" value="<?php echo $this->_tpl_vars['cemail']; ?>
" maxlength="150" size="32" /><br><span class="err"><?php echo $this->_tpl_vars['cemail_err']; ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
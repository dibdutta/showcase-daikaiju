<?php /* Smarty version 2.6.14, created on 2017-12-16 10:49:13
         compiled from admin_calender_template.tpl */ ?>
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
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>Upcoming Auction Calender</strong></a></td>
				</tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td width="100%" align="center">
						<table width="70%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_calender_template">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="3" class="headertext"><b>Upcoming Auction Calender</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 1 :</td>
												<td valign="top"><input type="text"  name="upcoming_1" value="<?php echo $this->_tpl_vars['upcoming_1']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_1" value="<?php echo $this->_tpl_vars['upcoming_link_1']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 2 :</td>
												<td valign="top"><input type="text"  name="upcoming_2" value="<?php echo $this->_tpl_vars['upcoming_2']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_2" value="<?php echo $this->_tpl_vars['upcoming_link_2']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 3 :</td>
												<td valign="top"><input type="text"  name="upcoming_3" value="<?php echo $this->_tpl_vars['upcoming_3']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_3" value="<?php echo $this->_tpl_vars['upcoming_link_3']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Upcoming Auction 4 :</td>
												<td valign="top"><input type="text"  name="upcoming_4" value="<?php echo $this->_tpl_vars['upcoming_4']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_4" value="<?php echo $this->_tpl_vars['upcoming_link_4']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 5 :</td>
												<td valign="top"><input type="text"  name="upcoming_5" value="<?php echo $this->_tpl_vars['upcoming_5']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_5" value="<?php echo $this->_tpl_vars['upcoming_link_5']; ?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $this->_tpl_vars['first_name_err']; ?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=3><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;&nbsp;
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
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
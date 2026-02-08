<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:45:16
  from '/var/www/html/admin_templates/admin_calender_template.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981eddc20e271_77626601',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4d9c517a3a1aacc687b5093b4f604e64d067968' => 
    array (
      0 => '/var/www/html/admin_templates/admin_calender_template.tpl',
      1 => 1513439296,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981eddc20e271_77626601 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>Upcoming Auction Calender</strong></a></td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
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
												<td valign="top"><input type="text"  name="upcoming_1" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_1']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_1" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_link_1']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 2 :</td>
												<td valign="top"><input type="text"  name="upcoming_2" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_2']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_2" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_link_2']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 3 :</td>
												<td valign="top"><input type="text"  name="upcoming_3" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_3']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_3" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_link_3']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Upcoming Auction 4 :</td>
												<td valign="top"><input type="text"  name="upcoming_4" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_4']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_4" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_link_4']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top">Upcoming Auction 5 :</td>
												<td valign="top"><input type="text"  name="upcoming_5" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_5']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
												<td valign="top"><input type="text"  name="upcoming_link_5" value="<?php echo $_smarty_tpl->tpl_vars['upcoming_link_5']->value;?>
" maxlength="400" size="45" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
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
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

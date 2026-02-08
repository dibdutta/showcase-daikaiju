<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:28:23
  from '/var/www/html/admin_templates/admin_user_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698776370f4089_27402344',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '833818830a5b902841381e0f6ae65f4ece1f085a' => 
    array (
      0 => '/var/www/html/admin_templates/admin_user_manager.tpl',
      1 => 1532880078,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698776370f4089_27402344 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 type="text/javascript">
function view_all(){
	window.location.href="admin_user_manager.php";
}
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_user_manager.php?mode=add_user&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link"><strong>Add User</strong></a></td>
                </tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				
					<tr>
						<td align="center">
							<?php if ($_smarty_tpl->tpl_vars['nextParent']->value <> '') {?><div style="width: 96%; text-align: right;"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['nextParent']->value;?>
&language_id=<?php echo $_smarty_tpl->tpl_vars['language_id']->value;?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php }?>
							<form name="listFrom" id="listForm" action="" method="get" >
								<input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
									<tr>
									<td colspan="2">Sort By:&nbsp;
									<select name="search" class="look" id='search_id' onChange="this.form.submit();">
                                        	<option value="FIRSTNAME" selected="selected" ><?php echo $_smarty_tpl->tpl_vars['userNameTXT']->value;?>
</option>
											<option value="USERNAME" <?php if ($_smarty_tpl->tpl_vars['search']->value == "USERNAME") {?> selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['userIdTXT']->value;?>
</option>
                                        	<option value="EMAIL" <?php if ($_smarty_tpl->tpl_vars['search']->value == "EMAIL") {?> selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['emailTXT']->value;?>
</option>
<!--                                        	<option value="weekly" <?php if ($_smarty_tpl->tpl_vars['search']->value == "weekly") {?> selected="selected"<?php }?> >Weekly</option>-->
<!--                                        	<option value="monthly" <?php if ($_smarty_tpl->tpl_vars['search']->value == "monthly") {?> selected="selected"<?php }?> >Monthly</option>-->
										</select>
									</td>
									<td colspan="3">Search:&nbsp;<input type="text" name="search_user" value="<?php echo $_smarty_tpl->tpl_vars['search_user_by']->value;?>
" class="look">&nbsp;<input type="submit"  value="Search" class="button">
									&nbsp;<input type="button"  value="View All" class="button" onclick="view_all()"></td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%"></td >
											<td align="center" class="headertext" width="15%"><?php echo $_smarty_tpl->tpl_vars['userNameTXT']->value;?>
</td>
											<td align="center" class="headertext" width="15%"><?php echo $_smarty_tpl->tpl_vars['userIdTXT']->value;?>
</td>
											<td align="center" class="headertext" width="15%"><?php echo $_smarty_tpl->tpl_vars['emailTXT']->value;?>
</td>
											<td align="center" class="headertext" width="15%">Date of Creation</td>
											<td align="center" class="headertext" width="15%"><?php echo $_smarty_tpl->tpl_vars['statusTXT']->value;?>
</td >
											<td align="center" class="headertext" width="15%">Action</td>
										</tr>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['userID']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<td align="center" class="smalltext"><input type="checkbox" name="user_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
" class="checkBox" /></td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['userName']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['user']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['email']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
</td>
												<td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['creation_date']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)],"%m/%d/%Y %H:%I:%S");?>
</td>
												<td align="center" class="smalltext" id="changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
">
													<?php if ($_smarty_tpl->tpl_vars['status']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)] == 1) {?>
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
active.png" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', <?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
, 'changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
');" title="Change Status" class="changeStatus" />
													<?php } else { ?>
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.png" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', <?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
, 'changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
');" title="Change Status" class="changeStatus" />
													<?php }?>
												</td>
                                                <td align="center" class="bold_text">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_user_manager.php?mode=edit_user&user_id=<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update User" title="Update User" border="0" class="changeStatus" /></a>&nbsp;|
                                                    &nbsp;
                                                                                                    &nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_user_manager.php?mode=change_password&user_id=<?php echo $_smarty_tpl->tpl_vars['userID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.png" align="absmiddle" alt="Change Password" title="Change Password" border="0" class="changeStatus" /></a>
                                                </td>
											</tr>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext" >&nbsp;</td>
											<td align="left" class="headertext" <?php if ((defined('MULTIUSER_ADMIN') ? constant('MULTIUSER_ADMIN') : null) == 1 && $_SESSION['superAdmin'] == 1) {?> colspan="3" <?php } else { ?> colspan="3"<?php }?>><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" class="headertext" colspan="2"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_user">Delete User</option>
											</select>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				<?php } else { ?>
					
					<tr>
					
						<td align="center" class="err" colspan='5'>There is no user in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

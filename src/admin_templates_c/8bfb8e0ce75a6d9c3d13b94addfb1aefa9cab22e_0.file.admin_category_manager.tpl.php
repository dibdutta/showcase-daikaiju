<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:45:59
  from '/var/www/html/admin_templates/admin_category_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981ee0769ba80_60500769',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8bfb8e0ce75a6d9c3d13b94addfb1aefa9cab22e' => 
    array (
      0 => '/var/www/html/admin_templates/admin_category_manager.tpl',
      1 => 1487960168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981ee0769ba80_60500769 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?mode=add_category&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link"><strong>Create New Category</strong></a></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
									<!--  <tr>
									<td colspan="2">Sort By:&nbsp;
									<select name="search" class="look" id='search_id' onChange="this.form.submit();">
                                        	<option value="cat_id" selected="selected" >Category Id</option>
                                        	<option value="cat_value" <?php if ($_smarty_tpl->tpl_vars['search']->value == "cat_value") {?> selected="selected"<?php }?> >Category Name</option>
<!--                                        	<option value="weekly" <?php if ($_smarty_tpl->tpl_vars['search']->value == "weekly") {?> selected="selected"<?php }?> >Weekly</option>-->
<!--                                        	<option value="monthly" <?php if ($_smarty_tpl->tpl_vars['search']->value == "monthly") {?> selected="selected"<?php }?> >Monthly</option>-->
									<!--	</select>
									</td>
									</tr>-->
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="64%">
											<?php if ($_smarty_tpl->tpl_vars['cat_type_id']->value == 1) {?>Poster Size
											<?php } elseif ($_smarty_tpl->tpl_vars['cat_type_id']->value == 2) {?>Genre
											<?php } elseif ($_smarty_tpl->tpl_vars['cat_type_id']->value == 3) {?>Decade
											<?php } elseif ($_smarty_tpl->tpl_vars['cat_type_id']->value == 4) {?>Country
											<?php } else { ?> Condition
											<?php }?></td>
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										<?php $_smarty_tpl->_assignInScope('name', '');?>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
										<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'] != '') {?>
										  <?php if ($_smarty_tpl->tpl_vars['name']->value != $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name']) {?>
											 <tr class="header_bgcolor">
												<td align="center" class="headertext"  colspan="2">
													<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
 (<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['size_type'] == 'f') {?> Folded <?php } else { ?> Rolled <?php }?>)
												</td>
											 </tr>
										   <?php }?>
										 <?php }?>
											<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</td>
												<td align="center" class="bold_text">
                                                														<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?mode=edit_category&cat_type_id=<?php echo $_smarty_tpl->tpl_vars['cat_type_id']->value;?>
&cat_id=<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?mode=delete&cat_type_id=<?php echo $_smarty_tpl->tpl_vars['cat_type_id']->value;?>
&cat_id=<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
', 'Record'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>
                                                    												</td>
											</tr>
											<?php $_smarty_tpl->_assignInScope('name', $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name']);?>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" class="headertext"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_category">Delete Category</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no category in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

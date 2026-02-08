<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:45:51
  from '/var/www/html/admin_templates/admin_size_weight_cost_listing.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981edff640ae6_92059951',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c41842d33cf616abb2da7df5d97fc59dd4da544' => 
    array (
      0 => '/var/www/html/admin_templates/admin_size_weight_cost_listing.tpl',
      1 => 1487960240,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981edff640ae6_92059951 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_size_weight_cost.php?mode=add_size&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link"><strong>Add New Size</strong></a></td>
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
							<?php if ($_smarty_tpl->tpl_vars['nextParent']->value <> '') {?><div style="width: 96%; text-align: right;"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['nextParent']->value;?>
&language_id=<?php echo $_smarty_tpl->tpl_vars['language_id']->value;?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php }?>
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%">Sl No</td >
											<td align="center" class="headertext" width="12%">Name</td>
											<td align="center" class="headertext" width="12%">Length</td>
											<td align="center" class="headertext" width="12%">Width</td >
											<td align="center" class="headertext" width="12%">Height</td>
											<td align="center" class="headertext" width="12%">Weight</td>
											<td align="center" class="headertext" width="12%">Packaging Cost</td>
											<td align="center" class="headertext" width="12%">Packaging Type</td>
											<td align="center" class="headertext" width="12%">Action</td>
										</tr>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['sizeRow']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<td align="center" class="smalltext"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)+1;?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['length'];?>
"</td>
												<td align="center" class="smalltext" ><?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['width'];?>
"</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['height'];?>
"</td>
												<td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['weight_lb'] > 0) {
echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['weight_lb'];?>
lb<?php }?>&nbsp;<?php if ($_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['weight_oz'] > 0) {
echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['weight_oz'];?>
oz<?php }?></td>
												<td align="center" class="smalltext">$<?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['packaging_cost'];?>
</td>
												<td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['size_type'] == 'f') {?>Folded<?php } else { ?>Rolled<?php }?></td>
												<td align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_size_weight_cost.php?mode=edit_size&size_id=<?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['size_weight_cost_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Record" title="Update Record" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_size_weight_cost.php?mode=delete_size&size_id=<?php echo $_smarty_tpl->tpl_vars['sizeRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['size_weight_cost_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
', 'record'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Record" title="Delete Record" border="0" class="changeStatus" /></a></td>
											</tr>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="headertext" <?php if ((defined('MULTIUSER_ADMIN') ? constant('MULTIUSER_ADMIN') : null) == 1 && $_SESSION['superAdmin'] == 1) {?> colspan="3" <?php } else { ?> colspan="3"<?php }?>><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
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
								</table>-->
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no size in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

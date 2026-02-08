<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:45:41
  from '/var/www/html/admin_templates/admin_content_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981edf574e2a6_21670729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a95b6fa4ee3b6dc592843a38321794d55d895df' => 
    array (
      0 => '/var/www/html/admin_templates/admin_content_manager.tpl',
      1 => 1487960212,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981edf574e2a6_21670729 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
                <?php if ((defined('FIXED_PAGE_CREATION') ? constant('FIXED_PAGE_CREATION') : null) == 1 && (defined('CUSTOM_PAGE_CREATION') ? constant('CUSTOM_PAGE_CREATION') : null) == 1) {?>
				<tr>
					<td width="100%">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									<form action="" method="get">
										Select Page Type : 
										<select name="type" class="look" onchange="javascript: this.form.submit();">
											<option value="custom" <?php if ($_smarty_tpl->tpl_vars['type']->value == "custom") {?>selected="selected"<?php }?>>Custom Pages</option>
											<option value="fixed" <?php if ($_smarty_tpl->tpl_vars['type']->value == "fixed") {?>selected="selected"<?php }?>>Fixed Pages</option>
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
                <?php }?>
				<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext">Page Name</td>
											<?php if ($_smarty_tpl->tpl_vars['type']->value == 'custom') {?>
											<td align="center" class="headertext">Status</td>
											<?php }?>
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['pageID']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">											
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['pageName']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
</td>
												<?php if ($_smarty_tpl->tpl_vars['type']->value == 'custom') {?>
													<?php if ($_smarty_tpl->tpl_vars['pageStatus']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)] == "Active") {?>
													<td align="center" class="smalltext" id="changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
">
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_active.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
', <?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
, 'changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
');" title="Change Status" class="changeStatus" /></td>
													<?php } else { ?>
													<td align="center" class="smalltext" id="changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
">
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('page_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
', <?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
, 'changeStatusPortion_<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
');" title="Change Status" class="changeStatus" /></td>
													<?php }?>
												<?php }?>
												<td align="center" class="bold_text">
													<?php if ($_smarty_tpl->tpl_vars['type']->value == "fixed") {?>
														<?php if ($_smarty_tpl->tpl_vars['totalContent']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)] > 0) {?>
															<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_content_manager.php?mode=edit_content&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&page_content_id=<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Content" title="Update Content" border="0" class="changeStatus" /></a>	
														<?php } else { ?>
															<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_content_manager.php?mode=add_content&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&page_id=<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_add.gif" align="absmiddle" alt="Add Content" title="Add Content" border="0" class="changeStatus" /></a>
														<?php }?>
													<?php } else { ?>
														<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_content_manager.php?mode=edit_content&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
&page_content_id=<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Content" title="Update Content" border="0" class="changeStatus" /></a>
													<?php }?>														
													<?php if ($_smarty_tpl->tpl_vars['type']->value == 'custom') {?>
														|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_content_manager.php?mode=delete_page&page_content_id=<?php echo $_smarty_tpl->tpl_vars['pageID']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
&type=<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
', 'page'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Page" title="Delete Page" border="0" class="changeStatus" /></a>
													<?php }?>
												</td>
											</tr>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<td align="left" class="headertext" <?php if ($_smarty_tpl->tpl_vars['type']->value == 'custom') {?> colspan="2" <?php }?>><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>
							</form>				
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
 page(s) in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

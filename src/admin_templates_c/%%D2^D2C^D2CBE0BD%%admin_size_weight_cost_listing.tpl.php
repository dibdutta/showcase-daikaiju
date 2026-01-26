<?php /* Smarty version 2.6.14, created on 2017-03-12 07:58:22
         compiled from admin_size_weight_cost_listing.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_size_weight_cost_listing.tpl', 37, false),)), $this); ?>
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
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_size_weight_cost.php?mode=add_size&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link"><strong>Add New Size</strong></a></td>
                </tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['total'] > 0): ?>
					<tr>
						<td align="center">
							<?php if ($this->_tpl_vars['nextParent'] <> ""): ?><div style="width: 96%; text-align: right;"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?parent_id=<?php echo $this->_tpl_vars['nextParent']; ?>
&language_id=<?php echo $this->_tpl_vars['language_id']; ?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php endif; ?>
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
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
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['sizeRow']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
											<tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<td align="center" class="smalltext"><?php echo $this->_sections['counter']['index']+1; ?>
</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['name']; ?>
</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['length']; ?>
"</td>
												<td align="center" class="smalltext" ><?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['width']; ?>
"</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['height']; ?>
"</td>
												<td align="center" class="smalltext"><?php if ($this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['weight_lb'] > 0):  echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['weight_lb']; ?>
lb<?php endif; ?>&nbsp;<?php if ($this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['weight_oz'] > 0):  echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['weight_oz']; ?>
oz<?php endif; ?></td>
												<td align="center" class="smalltext">$<?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['packaging_cost']; ?>
</td>
												<td align="center" class="smalltext"><?php if ($this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['size_type'] == 'f'): ?>Folded<?php else: ?>Rolled<?php endif; ?></td>
												<td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_size_weight_cost.php?mode=edit_size&size_id=<?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['size_weight_cost_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Record" title="Update Record" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_size_weight_cost.php?mode=delete_size&size_id=<?php echo $this->_tpl_vars['sizeRow'][$this->_sections['counter']['index']]['size_weight_cost_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'record'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Record" title="Delete Record" border="0" class="changeStatus" /></a></td>
											</tr>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="headertext" <?php if (@MULTIUSER_ADMIN == 1 && $_SESSION['superAdmin'] == 1): ?> colspan="3" <?php else: ?> colspan="3"<?php endif; ?>><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
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
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no size in database.</td>
					</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
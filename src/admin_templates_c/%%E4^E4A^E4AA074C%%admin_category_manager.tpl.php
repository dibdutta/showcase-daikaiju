<?php /* Smarty version 2.6.14, created on 2018-06-17 08:08:05
         compiled from admin_category_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_category_manager.tpl', 59, false),)), $this); ?>
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
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?mode=add_category&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link"><strong>Create New Category</strong></a></td>
							</tr>
						</table>
					</td>
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
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
									<!--  <tr>
									<td colspan="2">Sort By:&nbsp;
									<select name="search" class="look" id='search_id' onChange="this.form.submit();">
                                        	<option value="cat_id" selected="selected" >Category Id</option>
                                        	<option value="cat_value" <?php if ($this->_tpl_vars['search'] == 'cat_value'): ?> selected="selected"<?php endif; ?> >Category Name</option>
<!--                                        	<option value="weekly" <?php if ($this->_tpl_vars['search'] == 'weekly'): ?> selected="selected"<?php endif; ?> >Weekly</option>-->
<!--                                        	<option value="monthly" <?php if ($this->_tpl_vars['search'] == 'monthly'): ?> selected="selected"<?php endif; ?> >Monthly</option>-->
									<!--	</select>
									</td>
									</tr>-->
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="64%">
											<?php if ($this->_tpl_vars['cat_type_id'] == 1): ?>Poster Size
											<?php elseif ($this->_tpl_vars['cat_type_id'] == 2): ?>Genre
											<?php elseif ($this->_tpl_vars['cat_type_id'] == 3): ?>Decade
											<?php elseif ($this->_tpl_vars['cat_type_id'] == 4): ?>Country
											<?php else: ?> Condition
											<?php endif; ?></td>
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										<?php $this->assign('name', ''); ?>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
										<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['name'] != ''): ?>
										  <?php if ($this->_tpl_vars['name'] != $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['name']): ?>
											 <tr class="header_bgcolor">
												<td align="center" class="headertext"  colspan="2">
													<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['name']; ?>
 (<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['size_type'] == 'f'): ?> Folded <?php else: ?> Rolled <?php endif; ?>)
												</td>
											 </tr>
										   <?php endif; ?>
										 <?php endif; ?>
											<tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</td>
												<td align="center" class="bold_text">
                                                														<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?mode=edit_category&cat_type_id=<?php echo $this->_tpl_vars['cat_type_id']; ?>
&cat_id=<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?mode=delete&cat_type_id=<?php echo $this->_tpl_vars['cat_type_id']; ?>
&cat_id=<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'Record'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>
                                                    												</td>
											</tr>
											<?php $this->assign('name', $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['name']); ?>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" class="headertext"><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
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
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no category in database.</td>
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
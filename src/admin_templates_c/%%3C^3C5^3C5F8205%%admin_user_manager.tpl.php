<?php /* Smarty version 2.6.14, created on 2018-07-29 12:01:34
         compiled from admin_user_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_user_manager.tpl', 56, false),array('modifier', 'date_format', 'admin_user_manager.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
function view_all(){
	window.location.href="admin_user_manager.php";
}
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                <tr>
                    <td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_user_manager.php?mode=add_user&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link"><strong>Add User</strong></a></td>
                </tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				
					<tr>
						<td align="center">
							<?php if ($this->_tpl_vars['nextParent'] <> ""): ?><div style="width: 96%; text-align: right;"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?parent_id=<?php echo $this->_tpl_vars['nextParent']; ?>
&language_id=<?php echo $this->_tpl_vars['language_id']; ?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php endif; ?>
							<form name="listFrom" id="listForm" action="" method="get" >
								<input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
									<tr>
									<td colspan="2">Sort By:&nbsp;
									<select name="search" class="look" id='search_id' onChange="this.form.submit();">
                                        	<option value="FIRSTNAME" selected="selected" ><?php echo $this->_tpl_vars['userNameTXT']; ?>
</option>
											<option value="USERNAME" <?php if ($this->_tpl_vars['search'] == 'USERNAME'): ?> selected="selected"<?php endif; ?> ><?php echo $this->_tpl_vars['userIdTXT']; ?>
</option>
                                        	<option value="EMAIL" <?php if ($this->_tpl_vars['search'] == 'EMAIL'): ?> selected="selected"<?php endif; ?> ><?php echo $this->_tpl_vars['emailTXT']; ?>
</option>
<!--                                        	<option value="weekly" <?php if ($this->_tpl_vars['search'] == 'weekly'): ?> selected="selected"<?php endif; ?> >Weekly</option>-->
<!--                                        	<option value="monthly" <?php if ($this->_tpl_vars['search'] == 'monthly'): ?> selected="selected"<?php endif; ?> >Monthly</option>-->
										</select>
									</td>
									<td colspan="3">Search:&nbsp;<input type="text" name="search_user" value="<?php echo $this->_tpl_vars['search_user_by']; ?>
" class="look">&nbsp;<input type="submit"  value="Search" class="button">
									&nbsp;<input type="button"  value="View All" class="button" onclick="view_all()"></td>
									</tr>
									<?php if ($this->_tpl_vars['total'] > 0): ?>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%"></td >
											<td align="center" class="headertext" width="15%"><?php echo $this->_tpl_vars['userNameTXT']; ?>
</td>
											<td align="center" class="headertext" width="15%"><?php echo $this->_tpl_vars['userIdTXT']; ?>
</td>
											<td align="center" class="headertext" width="15%"><?php echo $this->_tpl_vars['emailTXT']; ?>
</td>
											<td align="center" class="headertext" width="15%">Date of Creation</td>
											<td align="center" class="headertext" width="15%"><?php echo $this->_tpl_vars['statusTXT']; ?>
</td >
											<td align="center" class="headertext" width="15%">Action</td>
										</tr>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['userID']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
												<td align="center" class="smalltext"><input type="checkbox" name="user_ids[]" value="<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
" class="checkBox" /></td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['userName'][$this->_sections['counter']['index']]; ?>
</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['user'][$this->_sections['counter']['index']]; ?>
</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['email'][$this->_sections['counter']['index']]; ?>
</td>
												<td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['creation_date'][$this->_sections['counter']['index']])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y %H:%I:%S") : smarty_modifier_date_format($_tmp, "%m/%d/%Y %H:%I:%S")); ?>
</td>
												<td align="center" class="smalltext" id="changeStatusPortion_<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
">
													<?php if ($this->_tpl_vars['status'][$this->_sections['counter']['index']] == 1): ?>
														<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
active.png" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', <?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
, 'changeStatusPortion_<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
');" title="Change Status" class="changeStatus" />
													<?php else: ?>
														<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.png" align="absmiddle" alt="Active" border="0" onclick="javascript: changeStatus('user', <?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
, 'changeStatusPortion_<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
');" title="Change Status" class="changeStatus" />
													<?php endif; ?>
												</td>
                                                <td align="center" class="bold_text">
                                                    <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_user_manager.php?mode=edit_user&user_id=<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update User" title="Update User" border="0" class="changeStatus" /></a>&nbsp;|
                                                    &nbsp;
                                                                                                    &nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_user_manager.php?mode=change_password&user_id=<?php echo $this->_tpl_vars['userID'][$this->_sections['counter']['index']]; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.png" align="absmiddle" alt="Change Password" title="Change Password" border="0" class="changeStatus" /></a>
                                                </td>
											</tr>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext" >&nbsp;</td>
											<td align="left" class="headertext" <?php if (@MULTIUSER_ADMIN == 1 && $_SESSION['superAdmin'] == 1): ?> colspan="3" <?php else: ?> colspan="3"<?php endif; ?>><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" class="headertext" colspan="2"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
										</tr>
									</tbody>
								</table>
								<table width="96%" border="0" cellspacing="1" cellpadding="2" class="">
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
								</table>
							</form>
						</td>
					</tr>
				<?php else: ?>
					
					<tr>
					
						<td align="center" class="err" colspan='5'>There is no user in database.</td>
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
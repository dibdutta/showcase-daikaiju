<?php /* Smarty version 2.6.14, created on 2017-03-12 07:47:41
         compiled from admin_bulkupload_pending.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_bulkupload_pending.tpl', 30, false),array('modifier', 'date_format', 'admin_bulkupload_pending.tpl', 33, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
<!--                <tr>-->
<!--                	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='<?php echo $this->_tpl_vars['actualPath'];  echo $this->_tpl_vars['decoded_string']; ?>
';" class="action_link"><strong>&lt;&lt; Back</strong></a></td>-->
<!--                </tr>-->
                <?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td align="center">
                        <div id="messageBox" class="messageBox" style="display:none;"></div>
                        <form name="listFrom" id="listForm" action="" method="post">
                            <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                    <tr class="header_bgcolor" height="26">
                                        <!--<td align="center" class="headertext" width="6%"></td>-->
                                        <td align="center" class="headertext" width="15%">Uploader Name</td>
                                        <td align="center" class="headertext" width="12%">Uploaded Date</td>
                                        <td align="center" class="headertext" width="13%">File Size</td>
                                        <td align="center" class="headertext" width="12%">Action</td>
                                        
                                    </tr>
                                    <?php if ($this->_tpl_vars['total'] > 0): ?>
                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['bulkRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
									<tr id="tr_<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['bulkupload_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['lastname']; ?>
&nbsp;(<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['username']; ?>
)</td>
                                        <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['upload_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
</td>
                                         <td align="center" class="smalltext">
                                         	<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['file_size']; ?>
 MB
                                        </td>
                                        <td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=download_bulk&file=<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['file_name']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
uplink.png" align="absmiddle" alt="Download Zip" title="Download Zip" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=delete_bulk&bulkupload_id=<?php echo $this->_tpl_vars['bulkRows'][$this->_sections['counter']['index']]['bulkupload_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'record'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Record" title="Delete Record" border="0" class="changeStatus" /></a></td>
									</tr>
									<?php endfor; endif; ?>
									<?php else: ?>	
									<tr>
									<td colspan='4' align='center' style="color: red;">No record found</td>
									</tr>
									<?php endif; ?>									
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
                
				
				<tr>
					<td>&nbsp;</td>
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
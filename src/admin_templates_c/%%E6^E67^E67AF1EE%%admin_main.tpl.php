<?php /* Smarty version 2.6.14, created on 2017-02-25 12:51:29
         compiled from admin_main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_main.tpl', 28, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
		<tr>
			<td width="100%" align="center" colspan="2"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
		</tr>
	<?php endif; ?>			
	<tr>
		<td valign="top" align="left" width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div class="dashboard-main">
							<div>
								<div class="dashblock"  >
									<span>Recent Sold Items</span>
									<table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>
                                            <th align="left" valign="top">Sold Date</th>
                                            <th align="left" valign="top">Amount</th>
                                            <th align="left" valign="top">Type</th>
                                        </tr>
                                       <?php if ($this->_tpl_vars['total'] > 0): ?>
                                             <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['dataJstFinishedAuction']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                        <tr>
                                                <td  width="60%"><span style="cursor:pointer;" ><img src="<?php echo $this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['image_path']; ?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<?php echo $this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['poster_title']; ?>
&nbsp;</span></td>
                                                 <td width="38%" >&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['invoice_generated_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
</td>
                                                <td width="38%" align="center">$<?php echo $this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['soldamnt']; ?>
</td>
                                                <td width="38%" align="center"><?php if ($this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1'): ?>Fixed
                                                <?php elseif ($this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2'): ?>Weekly
                                                <?php elseif ($this->_tpl_vars['dataJstFinishedAuction'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '3'): ?>Monthly
                                                <?php endif; ?></td>
                                            </tr>
                                        <?php endfor; endif; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td align="left" valign="top">No sold item to display.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
								</div>
								
								<div class="dashblock">
                                    <span>Winning Bids</span>
                                    <table width="90%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>                                            
                                            <th align="left" valign="top">Bid Date</th>
                                            <th align="left" valign="top">Amount</th>
                                        </tr>
                                        <?php if ($this->_tpl_vars['totalBids'] > 0): ?>
                                        <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['bidDetails']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                        <tr>
                                            <td  width="55%"><img src="<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['image_path']; ?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['actualPath']; ?>
/admin/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['poster_title']; ?>
(#<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['poster_sku']; ?>
)</a></td>
                                            <td width="18%"><?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['bids'][0]['post_date']; ?>
</td>
                                            <td width="15%">$<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['bids'][0]['bid_amount']; ?>
</td>
                                        </tr>                                        
                                        <?php endfor; endif; ?>
                                        
                                        <?php else: ?>
                                        <tr>
                                            <td align="left" valign="top">No winning bids.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                                
                                <div class="dashblock">
                                    <span>Winning Offers</span>
                                    <table width="90%" align="center" cellpadding="2" cellspacing="0" border="0">
                                        <tr>
                                            <th align="left" valign="top">Poster Title</th>                                    
                                            <th align="left" valign="top">Offer Date</th>
                                            <th align="left" valign="top">Amount</th>
                                        </tr>
                                        <?php if ($this->_tpl_vars['totalOffers'] > 0): ?>
                                        <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['dataOfr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                        <tr>
                                            <td  width="55%"><img src="<?php echo $this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['image_path']; ?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['actualPath']; ?>
/admin/admin_auction_manager.php?mode=view_details_offer&auction_id=<?php echo $this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><?php echo $this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['poster_title']; ?>
(#<?php echo $this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['poster_sku']; ?>
)</a></td>
                                            <td width="18%"><?php echo ((is_array($_tmp=$this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['post_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
</td>
                                            <td width="15%">$<?php echo $this->_tpl_vars['dataOfr'][$this->_sections['counter']['index']]['offer_amount']; ?>
</td>
                                        </tr>
                                        <?php endfor; endif; ?>
                                        
                                        <?php else: ?>
                                        <tr>
                                            <td align="left" valign="top">No new offer to display.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
							</div>
							<div class="clear"></div>
						</div>
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
<?php /* Smarty version 2.6.14, created on 2017-04-01 07:50:34
         compiled from admin_access_cust_info_popup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'admin_access_cust_info_popup.tpl', 18, false),)), $this); ?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="smallTable" id="righttable">
	<tr>
	  <th style="width:25%;">Item</th>
	  <th>Title</th>
	  <th>Seller</th>
	  <th>Type</th>
	  <th>Price</th>
	  
	</tr>
	<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $_REQUEST['invoice_id']; ?>
" />
	<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['auction_details']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr class="altbg">
			<td><img src="<?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['image']; ?>
" alt="" width="36px" height="30px"/><br/>#<?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
			<td><?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_title']; ?>
</td>
			<td><?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['name']; ?>
</td>
			<td><?php if ($this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1'): ?> Fixed <?php elseif ($this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2'): ?> Weekly <?php elseif ($this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2'): ?> Stills/Photos <?php endif; ?></td>
			<td>$<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
			
		</tr>
		<?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount']); ?>
	<?php endfor; endif; ?>
		<tr> 
		    <td colspan="2" align="left">
			<a id="various" href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_auction_manager.php?mode=manage_invoice_seller_print&invoice_id=<?php echo $this->_tpl_vars['invoiceData']['invoice_id']; ?>
">
			<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
view_print.png" onclick="fancy_images()" alt=""/></a>
			&nbsp;<input type="button" name="mark_as_paid" value="Notify Buyer" id="notify_buyer" class="button" onclick="notify_buyer()" >&nbsp;
			&nbsp;<?php if ($this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?><span id="paid"><a href="javascript:void(0)" onclick="markPaid()">Mark Paid</a></span><?php endif; ?>
			&nbsp;<?php if ($this->_tpl_vars['invoiceData']['is_shipped'] == '0'): ?><span id="shipped"><a href="javascript:void(0)" onclick="markShipped()">Mark Shipped</a></span><?php endif; ?>
			&nbsp;<span id="shipped"><a href="javascript:void(0)" onclick="updateNote()">Save Note</a></span>
			</td>
			<td align="right" colspan="2"><b>Subtotal</b></td>
			<td align="left">$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
		</tr>
	<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['additional_charges']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr id='tr_del_charge_<?php echo $this->_sections['counter']['index']; ?>
'>			
			<td align="right" colspan="4">
			 <?php echo $this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['description']; ?>
</td>
			<td align="left">			
			$<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
		</tr>
		<?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['amount']); ?>
		<?php endfor; endif; ?>
		<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['discounts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr id='tr_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
'>	
            			
			<td align="right" colspan="4">
			<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['description']; ?>
</td>
			<td align="left">			
			$<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
		</tr>
		<?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount']); ?>
		<?php endfor; endif; ?>
		
		<tr>
			<td align="left" colspan="3" width="50%"><b style="font-size:17px;color:#CC0000;">Note:</b>&nbsp;<b style="font-size:13px;" id="note"><?php echo $this->_tpl_vars['invoiceData']['note']; ?>
</b></td>
			<td align="right" width="20%"><img src="http://c4922595.r95.cf2.rackcdn.com/icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" onclick="editNote()">&nbsp;&nbsp;<b>Total</b></td>
			<td align="left" id="new_total_amnt">$<?php echo $this->_tpl_vars['invoiceData']['total_amount']; ?>
</td>
			<input type="hidden" id="total_cost_amnt" value="<?php echo $this->_tpl_vars['invoiceData']['total_amount']; ?>
"/>
		</tr>	
   </table>
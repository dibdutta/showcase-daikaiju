<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:40:52
  from '/var/www/html/admin_templates/admin_access_cust_info_popup.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698779244f38c0_26991911',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b69b3162d0acee20130514529ef66a57c85f2b5' => 
    array (
      0 => '/var/www/html/admin_templates/admin_access_cust_info_popup.tpl',
      1 => 1488648502,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_698779244f38c0_26991911 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="smallTable" id="righttable">
	<tr>
	  <th style="width:25%;">Item</th>
	  <th>Title</th>
	  <th>Seller</th>
	  <th>Type</th>
	  <th>Price</th>
	  
	</tr>
	<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $_REQUEST['invoice_id'];?>
" />
	<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['invoiceData']->value['auction_details']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
		<tr class="altbg">
			<td><img src="<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image'];?>
" alt="" width="36px" height="30px"/><br/>#<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '1') {?> Fixed <?php } elseif ($_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '2') {?> Weekly <?php } elseif ($_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '2') {?> Stills/Photos <?php }?></td>
			<td>$<?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
			
		</tr>
		<?php $_smarty_tpl->_assignInScope('subTotal', $_smarty_tpl->tpl_vars['subTotal']->value+$_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
	<?php
}
}
?>
		<tr> 
		    <td colspan="2" align="left">
			<a id="various" href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_auction_manager.php?mode=manage_invoice_seller_print&invoice_id=<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['invoice_id'];?>
">
			<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
view_print.png" onclick="fancy_images()" alt=""/></a>
			&nbsp;<input type="button" name="mark_as_paid" value="Notify Buyer" id="notify_buyer" class="button" onclick="notify_buyer()" >&nbsp;
			&nbsp;<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['is_paid'] == '0') {?><span id="paid"><a href="javascript:void(0)" onclick="markPaid()">Mark Paid</a></span><?php }?>
			&nbsp;<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['is_shipped'] == '0') {?><span id="shipped"><a href="javascript:void(0)" onclick="markShipped()">Mark Shipped</a></span><?php }?>
			&nbsp;<span id="shipped"><a href="javascript:void(0)" onclick="updateNote()">Save Note</a></span>
			</td>
			<td align="right" colspan="2"><b>Subtotal</b></td>
			<td align="left">$<?php echo number_format($_smarty_tpl->tpl_vars['subTotal']->value,2);?>
</td>
		</tr>
	<?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['invoiceData']->value['additional_charges']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
		<tr id='tr_del_charge_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
'>			
			<td align="right" colspan="4">
			 <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['description'];?>
</td>
			<td align="left">			
			$<?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
		</tr>
		<?php $_smarty_tpl->_assignInScope('subTotal', $_smarty_tpl->tpl_vars['subTotal']->value+$_smarty_tpl->tpl_vars['invoiceData']->value['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
		<?php
}
}
?>
		<?php
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['invoiceData']->value['discounts']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?> 
		<tr id='tr_del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
'>	
            			
			<td align="right" colspan="4">
			<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['description'];?>
</td>
			<td align="left">			
			$<?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
		</tr>
		<?php $_smarty_tpl->_assignInScope('subTotal', $_smarty_tpl->tpl_vars['subTotal']->value+$_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
		<?php
}
}
?>
		
		<tr>
			<td align="left" colspan="3" width="50%"><b style="font-size:17px;color:#CC0000;">Note:</b>&nbsp;<b style="font-size:13px;" id="note"><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['note'];?>
</b></td>
			<td align="right" width="20%"><img src="http://c4922595.r95.cf2.rackcdn.com/icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" onclick="editNote()">&nbsp;&nbsp;<b>Total</b></td>
			<td align="left" id="new_total_amnt">$<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['total_amount'];?>
</td>
			<input type="hidden" id="total_cost_amnt" value="<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['total_amount'];?>
"/>
		</tr>	
   </table>
<?php }
}

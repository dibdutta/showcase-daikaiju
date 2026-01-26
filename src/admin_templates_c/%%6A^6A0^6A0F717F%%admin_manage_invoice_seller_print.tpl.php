<?php /* Smarty version 2.6.14, created on 2018-06-09 16:04:24
         compiled from admin_manage_invoice_seller_print.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_manage_invoice_seller_print.tpl', 26, false),array('modifier', 'number_format', 'admin_manage_invoice_seller_print.tpl', 92, false),)), $this); ?>
<?php echo '
<style>
.printer{
font-family:Calibri;	
}

.forPrint-mainBorder{
border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;
padding:5px;
margin:0px;
} 

</style>
'; ?>

<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;<?php if ($this->_tpl_vars['invoiceData'][0]['is_paid'] == '1'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
paid-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '1'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
cancelled-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_approved'] == '1' && $this->_tpl_vars['invoiceData'][0]['is_ordered'] == '0'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
approved-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_paid'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_ordered'] == '1'): ?> background:url(<?php echo @CLOUD_STATIC; ?>
payment-pending-img.png)<?php endif; ?> no-repeat center 75%; ">
                            	<tr>
    								<td style="padding:10px;"><img src="<?php echo @CLOUD_STATIC; ?>
logo.png" width="158" height="158" border="0" />
        							</td>
    							</tr>
                            	
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer" bgcolor="silver"><b>&nbsp;<?php if ($this->_tpl_vars['invoiceData'][0]['is_buyers_copy'] == '1'): ?>Invoice Details<?php else: ?>Seller Reconcilation<?php endif; ?></b></td>
								</tr>
                            	<tr height="26" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF">
                                                                        <td align="left" colspan="1">&nbsp;Date of Order: <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData'][0]['invoice_generated_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
                                	<?php if ($this->_tpl_vars['invoiceData'][0]['is_approved'] == '1' && $this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '0'): ?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:black;">Approved</font></td>
                                	<?php endif; ?>
                                	<?php if ($this->_tpl_vars['invoiceData'][0]['is_approved'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '0'): ?>
                                	<td align="left"  id="invoice_not_approved_on"><strong>Invoice Status: </strong><font style="color:red;"> Not Approved</font></td>
                                	<?php endif; ?>
                                	<?php if ($this->_tpl_vars['invoiceData'][0]['is_approved'] == '1' && $this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '1'): ?>
                                	<td align="left"   id="invoice_cancelled"><strong>Invoice Status: </strong> <font style="color:red;">Cancelled</font></td>
                               		<?php endif; ?>
                               		<?php if ($this->_tpl_vars['invoiceData'][0]['is_approved'] == '1' && $this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '1'): ?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;"> Paid</font></td>
                                	<?php endif; ?>
                                	<?php if ($this->_tpl_vars['invoiceData'][0]['is_approved'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '1'): ?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;">Paid</font> </td>
                                	<?php endif; ?>
                                </tr> 
								<?php if ($this->_tpl_vars['invoiceData'][0]['is_paid'] == '1'): ?> 
									<tr height="26">                                
										<td align="left" colspan="2">&nbsp;Date paid: <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData'][0]['paid_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td> 
									</tr> 
								<?php endif; ?>                               
                                <tr height="26">
                                 <?php if ($this->_tpl_vars['invoiceData'][0]['is_buyers_copy'] == '1'): ?>
                                    <td align="left">
                                        <b>&nbsp;Shipping Address</b><br />
                                        &nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_lastname']; ?>
<br/>
                                        &nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_address1'];  if ($this->_tpl_vars['invoiceData']['shipping_address']['shipping_address2'] != ''): ?>, <?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_address2'];  endif; ?>
                                        <br />&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_city']; ?>
&nbsp;
                                        <?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_state']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_zipcode']; ?>
<br />
                                    </td>
                                    <?php endif; ?>
                                    <td align="left">
                                        <b>&nbsp;Billing Address</b><br />
                                        &nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_lastname']; ?>
<br/>
                                        &nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_address1'];  if ($this->_tpl_vars['invoiceData']['billing_address']['billing_address2'] != ''): ?>, <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_address2'];  endif; ?>
                                        <br />&nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_city']; ?>
&nbsp;
                                       <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_state']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_zipcode']; ?>
<br />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr height="26">
                                    <td colspan="2" align="left" bgcolor="silver"><b>&nbsp;Email</b></td>
                                    <td colspan="2" align="left" bgcolor="silver">&nbsp;</td>

                                </tr>
                                <tr>
                                    <td><?php echo $this->_tpl_vars['user_email'][0]['email']; ?>
</td>
									<td>&nbsp;INV-<?php echo $this->_tpl_vars['invoiceData'][0]['invoice_id']; ?>
</td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr >
                                	<td align="left" colspan="2" >
                                    	<table border="1" width="100%" align="left" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" cellpadding="2" style="border-collapse:collapse;" cellspacing="0" class="invoice-main">
                                        	<tr class="printer" bgcolor="silver">
                                            	<th align="left" width="25%" >Item</th>
                                                <th align="left" width="50$" >Title</th>
                                                <th align="left" width="25%" >Price</th>
                                            </tr>
                                            <tr><td colspan="3">&nbsp;</td></tr>
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
                                        	<tr class="printer" >
                                                <td align="left" >#<?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                                                <td align="left"><?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_title']; ?>
</td>
                                                <td align="left" >$<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            </tr>
                                            <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount']); ?>
                                            <?php endfor; endif; ?>
                                            <tr class="printer"  bgcolor="silver">
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
                                            <tr class="printer">
                                             	<td align="right" ><?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                             	<img src='.<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_charge.jpg' id='del_charge_<?php echo $this->_sections['counter']['index']; ?>
' title='Delete' style="border:1px solid #cccccc;"><?php else: ?>&nbsp;<?php endif; ?></td>
                                                <td align="right" >
                                                (+)&nbsp;<?php echo $this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['description']; ?>
</td>
                                                <td align="left" >
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
                                            <tr class="printer" >
                                            <td align="right"><?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                            <img  src='<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_charge.jpg' id='del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' title='Delete' onclick='del_discount(this.id)'><?php else: ?>&nbsp;<?php endif; ?></td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' id='desc_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' value='<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['description']; ?>
' />
                                                (-)&nbsp;<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['description']; ?>
</td>
                                                <td align="left" >
                                                <input type='hidden' name='input_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' id='input_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' value='<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount']; ?>
' />
                                                $<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            </tr>
                                            <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']-$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount']); ?>
                                            <?php endfor; endif; ?>
                                            
                                            <tr>
                                            	<td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr class="printer" >
                                            	<td align="right" colspan="2" ><b>Total</b></td>
                                                <td align="left" id="new_total_amnt" >$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                                <input type="hidden" id="total_cost_amnt" value="<?php echo $this->_tpl_vars['invoiceData']['total_amount']; ?>
"/>
                                            </tr>
                                            <tr>
                                            <td colspan="3" align="center"><input type="button" value="Print" onclick="window.print();" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                        </form>
                    </td>
                </tr>
               
			</table>
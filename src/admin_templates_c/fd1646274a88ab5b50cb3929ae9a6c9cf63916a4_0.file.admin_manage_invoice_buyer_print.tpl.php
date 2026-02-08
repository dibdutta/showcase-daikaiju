<?php
/* Smarty version 3.1.47, created on 2026-02-08 00:16:17
  from '/var/www/html/admin_templates/admin_manage_invoice_buyer_print.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69881c21b64ae3_40500897',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fd1646274a88ab5b50cb3929ae9a6c9cf63916a4' => 
    array (
      0 => '/var/www/html/admin_templates/admin_manage_invoice_buyer_print.tpl',
      1 => 1770527729,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69881c21b64ae3_40500897 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>

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

<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '1') {?>background:url(<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
paid-img.png)<?php } elseif ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '1') {?>background:url(<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
cancelled-img.png)<?php } elseif ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '1' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_ordered'] == '0') {?>background:url(<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
approved-img.png)<?php } elseif ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_ordered'] == '1') {?> background:url(<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
payment-pending-img.png)<?php }?> no-repeat center 75%; ">
                            	<tr>
    								<td style="padding:10px;"><img src="<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
logo.png" width="158" height="158" border="0" />
        							</td>
    							</tr>
                            	
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer" bgcolor="silver"><b>&nbsp;<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_buyers_copy'] == '1') {?>Invoice Details<?php } else { ?>Seller Reconcilation<?php }?></b></td>
								</tr>
                            	<tr height="26" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF">
                                                                        <td align="left" colspan="1">&nbsp;Date of Order: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[0]['invoice_generated_on']);?>
</td>
                                	<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '1' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0') {?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:black;">Approved</font></td>
                                	<?php }?>
                                	<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0') {?>
                                	<td align="left"  id="invoice_not_approved_on"><strong>Invoice Status: </strong><font style="color:red;"> Not Approved</font></td>
                                	<?php }?>
                                	<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '1' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '1') {?>
                                	<td align="left"   id="invoice_cancelled"><strong>Invoice Status: </strong> <font style="color:red;">Cancelled</font></td>
                               		<?php }?>
                               		<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '1' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '1') {?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;"> Paid</font></td>
                                	<?php }?>
                                	<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '1') {?>
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;">Paid</font> </td>
                                	<?php }?>
                                </tr> 
								<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '1') {?> 
									<tr height="26">                                
										<td align="left" colspan="2">&nbsp;Date paid: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[0]['paid_on']);?>
</td> 
									</tr> 
								<?php }?>                               
                                <tr height="26">
                                 <?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_buyers_copy'] == '1') {?>
                                    <td align="left">
                                        <b>&nbsp;Shipping Address</b><br />
                                        &nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_lastname'];?>
<br/>
                                        &nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_address1'];
if ($_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_address2'] != '') {?>, <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_address2'];
}?>
                                        <br />&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_city'];?>
&nbsp;
                                        <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_state'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_zipcode'];?>
<br />
                                    </td>
                                    <?php }?>
                                    <td align="left">
                                        <b>&nbsp;Billing Address</b><br />
                                        &nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_lastname'];?>
<br/>
                                        &nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_address1'];
if ($_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_address2'] != '') {?>, <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_address2'];
}?>
                                        <br />&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_city'];?>
&nbsp;
                                       <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_state'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['billing_address']['billing_zipcode'];?>
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
                                    <td><?php echo $_smarty_tpl->tpl_vars['user_email']->value[0]['email'];?>
</td>
									<td>&nbsp;INV-<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[0]['invoice_id'];?>
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
											<?php $_smarty_tpl->_assignInScope('seller_username', '');?>
											<?php $_smarty_tpl->_assignInScope('subTotal', 0);?>
											<?php $_smarty_tpl->_assignInScope('ship_new_chrg', 0);?>
											<?php $_smarty_tpl->_assignInScope('auction_wise_total', 0);?>
                                            <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['invoiceData']->value['auction_details']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<?php if ($_smarty_tpl->tpl_vars['chk_item_type']->value == '1') {?>									
												<?php if ($_smarty_tpl->tpl_vars['seller_username']->value != $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username']) {?>
													<?php if ($_smarty_tpl->tpl_vars['seller_username']->value != '') {?>	
										
														<tr class="printer">
															<td align="right" colspan="2" >Shiiping Charge:</td>
														<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'Canada' || $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'United States') {?>
															<td align="left" >$15</td>
															<?php $_smarty_tpl->_assignInScope('ship_new_chrg', $_smarty_tpl->tpl_vars['ship_new_chrg']->value+15);?>
														<?php } else { ?>
															<td align="left" >$21</td>
															<?php $_smarty_tpl->_assignInScope('ship_new_chrg', $_smarty_tpl->tpl_vars['ship_new_chrg']->value+21);?>
														<?php }?>										
														</tr>
													<?php }?>
													<tr><td colspan="3" >Seller : <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username'];?>
</td></tr>									  
												<?php }?>
											<?php } elseif ($_smarty_tpl->tpl_vars['chk_item_type']->value == '2') {?>
												<?php if ($_smarty_tpl->tpl_vars['seller_username']->value != $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username']) {?>
													<?php if ($_smarty_tpl->tpl_vars['seller_username']->value != '') {?>	
														<tr class="printer">
															<td align="right" colspan="2"><b>Auction wise Total:</b></td>
															<td align="left">$<?php echo number_format($_smarty_tpl->tpl_vars['auction_wise_total']->value,2);?>
</td>
														</tr>
													<?php }?>
													<tr><td colspan="3" ><b>Auction :</b> <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username'];?>
</td></tr>
													<?php $_smarty_tpl->_assignInScope('auction_wise_total', 0);?>
												<?php }?>
											<?php }?>
                                        	<tr class="printer" >
                                                <td align="left" >#<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
                                                <td align="left"><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</td>
                                                <td align="left" >$<?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
                                            </tr>
											<?php $_smarty_tpl->_assignInScope('subTotal', $_smarty_tpl->tpl_vars['subTotal']->value+$_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
											<?php if ($_smarty_tpl->tpl_vars['chk_item_type']->value == '1' || $_smarty_tpl->tpl_vars['chk_item_type']->value == '4') {?>
												<?php $_smarty_tpl->_assignInScope('seller_username', $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username']);?>
											<?php } elseif ($_smarty_tpl->tpl_vars['chk_item_type']->value == '2') {?>
												<?php $_smarty_tpl->_assignInScope('seller_username', $_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['seller_username']);?>
												<?php $_smarty_tpl->_assignInScope('auction_wise_total', $_smarty_tpl->tpl_vars['auction_wise_total']->value+$_smarty_tpl->tpl_vars['invoiceData']->value['auction_details'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
											<?php }?>
                                            
                                            <?php
}
}
?>
											<?php if ($_smarty_tpl->tpl_vars['chk_item_type']->value == '1' || $_smarty_tpl->tpl_vars['chk_item_type']->value == '4') {?>
												<tr>
													<td align="right" colspan="2" class="printer">Shiiping Charge:</td>
													<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'Canada' || $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'United States') {?>
														<td align="left" >$15.00</td>
													<?php } else { ?>
														<td align="left" >$21.00</td>
													<?php }?>
												</tr>
												<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'Canada' || $_smarty_tpl->tpl_vars['invoiceData']->value['shipping_address']['shipping_country_name'] == 'United States') {?>
													<?php $_smarty_tpl->_assignInScope('ship_new_chrg', $_smarty_tpl->tpl_vars['ship_new_chrg']->value+15);?>
												<?php } else { ?>
													<?php $_smarty_tpl->_assignInScope('ship_new_chrg', $_smarty_tpl->tpl_vars['ship_new_chrg']->value+21);?>
												<?php }?>
											<?php } else { ?>	
												<tr class="printer">
													<td align="right" colspan="2"><b>Auction wise Total:</b></td>
													<td align="left">$<?php echo number_format($_smarty_tpl->tpl_vars['auction_wise_total']->value,2);?>
</td>
												</tr>
											<?php }?>
                                            <tr class="printer"  bgcolor="silver">
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
                                            <tr class="printer">
                                             	<td align="right" ><?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0') {?>
                                             	<img src='.<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_charge.jpg' id='del_charge_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' title='Delete' style="border:1px solid #cccccc;"><?php } else { ?>&nbsp;<?php }?></td>
                                                <td align="right" >
                                                (+)&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['description'];?>
</td>
                                                <td align="left" >
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
                                            <tr class="printer" >
                                            <td align="right"><?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_approved'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_cancelled'] == '0' && $_smarty_tpl->tpl_vars['invoiceData']->value[0]['is_paid'] == '0') {?>
                                            <img  src='<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_charge.jpg' id='del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' title='Delete' onclick='del_discount(this.id)'><?php } else { ?>&nbsp;<?php }?></td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' id='desc_del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' value='<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['description'];?>
' />
                                                (-)&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['description'];?>
</td>
                                                <td align="left" >
                                                <input type='hidden' name='input_del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' id='input_del_amnt_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
' value='<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'];?>
' />
                                                $<?php echo number_format($_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
                                            </tr>
                                            <?php $_smarty_tpl->_assignInScope('subTotal', $_smarty_tpl->tpl_vars['subTotal']->value-$_smarty_tpl->tpl_vars['invoiceData']->value['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount']);?>
                                            <?php
}
}
?>
                                            
                                            <tr>
                                            	<td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr class="printer" >
                                            	<td align="right" colspan="2" ><b>Total</b></td>
                                                <td align="left" id="new_total_amnt" >$<?php echo number_format($_smarty_tpl->tpl_vars['subTotal']->value,2);?>
</td>
                                                <input type="hidden" id="total_cost_amnt" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['invoiceData']->value[0]['total_amount'])===null||$tmp==='' ? '' : $tmp);?>
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
               
			</table><?php }
}

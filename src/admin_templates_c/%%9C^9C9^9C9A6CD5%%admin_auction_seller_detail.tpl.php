<?php /* Smarty version 2.6.14, created on 2017-11-01 03:43:59
         compiled from admin_auction_seller_detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'admin_auction_seller_detail.tpl', 52, false),array('modifier', 'capitalize', 'admin_auction_seller_detail.tpl', 52, false),array('modifier', 'date_format', 'admin_auction_seller_detail.tpl', 52, false),array('modifier', 'number_format', 'admin_auction_seller_detail.tpl', 87, false),)), $this); ?>
<?php echo '
<script type="text/javascript" src="/javascript/jquery-1.4.2.js"></script>
<script type="text/javascript">
 function check_user(){
	if(document.getElementById(\'user_id\').value==\'\'){
		alert(\'Please select an seller to pay\');
		return false;
	} 
	else{
		document.forms["listFrom"].submit();
	}
 }
 function printPage(){    
	$(".buyerCloumn").hide();
	javascript:window.print();
 }
</script>
<style type="text/css">
.printer{
font-family:Calibri;	
}
.print_data{
	font-size:12px; font-family:Arial;
}

</style>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
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
								<input type="hidden" name="mode" value="complete_payment" />
								<input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
" />
								<table align="center" width="96%" border="1" cellspacing="1" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000"  >
									<tbody>
										<tr>
											<td <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>colspan="8"<?php else: ?>colspan="7"<?php endif; ?> align="center" class="printer"><b>MPE Report:<?php if ($this->_tpl_vars['search'] == '' && $this->_tpl_vars['auction_type'] == ''): ?> All Posters <?php elseif ($this->_tpl_vars['search'] == '' && $this->_tpl_vars['auction_type'] != ''): ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$_REQUEST['auction_type'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 <?php endif;  if ($this->_tpl_vars['search'] != ''):  if ($this->_tpl_vars['search'] == 'yet_to_pay'): ?> Total(s) to be Paid by MPE <?php elseif ($this->_tpl_vars['search'] == 'unpaid'): ?>Total Unpaid by Buyer<?php elseif ($this->_tpl_vars['search'] == 'paid'): ?> Total Payments to Seller(s)<?php elseif ($this->_tpl_vars['search'] == 'paid_by_buyer'): ?> Total Paid by Buyer(s) <?php else: ?> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['search'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 Items<?php endif; ?>  <?php endif;  if ($this->_tpl_vars['start_date'] != ''): ?>From <?php echo ((is_array($_tmp=$this->_tpl_vars['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m-%d-%Y") : smarty_modifier_date_format($_tmp, "%m-%d-%Y")); ?>
 To <?php echo ((is_array($_tmp=$this->_tpl_vars['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m-%d-%Y") : smarty_modifier_date_format($_tmp, "%m-%d-%Y"));  endif; ?></b></td>
										</tr>
										
										
										<tr height="26" class="header_bgcolor">
											<th align="center" width="16%">Poster</td>
											<th align="center" width="12%">Seller</td>
											<th align="center" width="12%" class="buyerCloumn">Buyer</td>

											<th align="center" width="14%">Auction Type</td>
                                            <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>
											<th align="center" width="15%">Auction Pricing</td>
                                            <?php endif; ?>
											<th align="center" width="15%">Auction Timings</td>
											<th align="center" width="8%">Sold Price</td>
											<?php if ($_REQUEST['search'] == 'yet_to_pay' || $_REQUEST['search'] == 'paid'): ?>
												<th align="center"  width="15%">Charges</th>
												<th align="center"  width="15%">Discounts</th>
												<th align="center"  width="15%">Seller Owed</th>
											<?php endif; ?>
											<th align="center" width="12%">Status</td>
											
										</tr>
										<?php $this->assign('oldInvoice', 0); ?>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
											<tr >
												<td align="left"  width="20%" class="print_data">&nbsp;&nbsp;<img src="<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['image']; ?>
" ><br/>
                                                   <?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['poster_title']; ?>
(#<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['poster_sku']; ?>
)
												</td >
												
												<td align="center"  ><?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
												
												<td align="center"  class="buyerCloumn"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['winnerName'] <> ''):  echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['winnerName'];  else: ?>NA<?php endif; ?></td>
												<td align="center"  class="print_data"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1'): ?>Fixed Price Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2'): ?>Weekly Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '3'): ?>Monthly Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '4'): ?>Stills/Photos<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '5'): ?>Stills/Photos Auction<?php endif; ?></td>
                                                <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>
                                                <td align="center" class="print_data"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1' || $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '4'): ?>Asking Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br>Offer Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_reserve_offer_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif; ?>
																					 <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2' || $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '5'): ?>Starting Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br>Buynow Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_buynow_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif; ?>
																					 <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '3'): ?>Starting Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_reserve_offer_price'] > 0): ?>Reserve Price:&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_reserve_offer_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  else: ?>Reserve Not Meet<?php endif;  endif; ?>
												</td>
                                                <?php endif; ?>
												<td align="center" class="print_data"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] != '1' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] != '4'): ?>Start Time&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_start_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%m/%d/%Y %H:%M:%S")); ?>
<br>End Time&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_end_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%m/%d/%Y %H:%M:%S"));  else: ?>----<?php endif; ?></td>
												<td align="center" class="print_data"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt'] != ''): ?>$<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt'];  else: ?>----<?php endif; ?></td>
												<?php if ($_REQUEST['search'] == 'yet_to_pay' || $_REQUEST['search'] == 'paid'): ?>
												<?php if ($this->_tpl_vars['oldInvoice'] != $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['invoice_id']): ?>
													<td align="center" class="smalltext">
													<?php $this->assign('subTotalDis', 0); ?>
													<?php unset($this->_sections['counterdiscount']);
$this->_sections['counterdiscount']['name'] = 'counterdiscount';
$this->_sections['counterdiscount']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counterdiscount']['show'] = true;
$this->_sections['counterdiscount']['max'] = $this->_sections['counterdiscount']['loop'];
$this->_sections['counterdiscount']['step'] = 1;
$this->_sections['counterdiscount']['start'] = $this->_sections['counterdiscount']['step'] > 0 ? 0 : $this->_sections['counterdiscount']['loop']-1;
if ($this->_sections['counterdiscount']['show']) {
    $this->_sections['counterdiscount']['total'] = $this->_sections['counterdiscount']['loop'];
    if ($this->_sections['counterdiscount']['total'] == 0)
        $this->_sections['counterdiscount']['show'] = false;
} else
    $this->_sections['counterdiscount']['total'] = 0;
if ($this->_sections['counterdiscount']['show']):

            for ($this->_sections['counterdiscount']['index'] = $this->_sections['counterdiscount']['start'], $this->_sections['counterdiscount']['iteration'] = 1;
                 $this->_sections['counterdiscount']['iteration'] <= $this->_sections['counterdiscount']['total'];
                 $this->_sections['counterdiscount']['index'] += $this->_sections['counterdiscount']['step'], $this->_sections['counterdiscount']['iteration']++):
$this->_sections['counterdiscount']['rownum'] = $this->_sections['counterdiscount']['iteration'];
$this->_sections['counterdiscount']['index_prev'] = $this->_sections['counterdiscount']['index'] - $this->_sections['counterdiscount']['step'];
$this->_sections['counterdiscount']['index_next'] = $this->_sections['counterdiscount']['index'] + $this->_sections['counterdiscount']['step'];
$this->_sections['counterdiscount']['first']      = ($this->_sections['counterdiscount']['iteration'] == 1);
$this->_sections['counterdiscount']['last']       = ($this->_sections['counterdiscount']['iteration'] == $this->_sections['counterdiscount']['total']);
?>
													<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['description']; ?>
:$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <br/>
													<?php $this->assign('subTotalDis', $this->_tpl_vars['subTotalDis']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount']); ?>
													<?php $this->assign('TotalDis', $this->_tpl_vars['TotalDis']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount']); ?>
													
													<?php endfor; endif; ?>
													
													</td>
													<td align="center" class="smalltext">
													<?php $this->assign('subTotalCharge', 0); ?>
													<?php unset($this->_sections['countercharge']);
$this->_sections['countercharge']['name'] = 'countercharge';
$this->_sections['countercharge']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['countercharge']['show'] = true;
$this->_sections['countercharge']['max'] = $this->_sections['countercharge']['loop'];
$this->_sections['countercharge']['step'] = 1;
$this->_sections['countercharge']['start'] = $this->_sections['countercharge']['step'] > 0 ? 0 : $this->_sections['countercharge']['loop']-1;
if ($this->_sections['countercharge']['show']) {
    $this->_sections['countercharge']['total'] = $this->_sections['countercharge']['loop'];
    if ($this->_sections['countercharge']['total'] == 0)
        $this->_sections['countercharge']['show'] = false;
} else
    $this->_sections['countercharge']['total'] = 0;
if ($this->_sections['countercharge']['show']):

            for ($this->_sections['countercharge']['index'] = $this->_sections['countercharge']['start'], $this->_sections['countercharge']['iteration'] = 1;
                 $this->_sections['countercharge']['iteration'] <= $this->_sections['countercharge']['total'];
                 $this->_sections['countercharge']['index'] += $this->_sections['countercharge']['step'], $this->_sections['countercharge']['iteration']++):
$this->_sections['countercharge']['rownum'] = $this->_sections['countercharge']['iteration'];
$this->_sections['countercharge']['index_prev'] = $this->_sections['countercharge']['index'] - $this->_sections['countercharge']['step'];
$this->_sections['countercharge']['index_next'] = $this->_sections['countercharge']['index'] + $this->_sections['countercharge']['step'];
$this->_sections['countercharge']['first']      = ($this->_sections['countercharge']['iteration'] == 1);
$this->_sections['countercharge']['last']       = ($this->_sections['countercharge']['iteration'] == $this->_sections['countercharge']['total']);
?>
													<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['description']; ?>
:$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <br/>
													<?php $this->assign('subTotalCharge', $this->_tpl_vars['subTotalCharge']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount']); ?>
													<?php $this->assign('TotalCharge', $this->_tpl_vars['TotalCharge']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount']); ?>
													<?php endfor; endif; ?>
													
													</td>
												  <?php else: ?>
												    <?php $this->assign('subTotalCharge', 0); ?>	
													<?php $this->assign('subTotalDis', 0); ?>
												     <td align="center" > -- </td>
													 <td align="center" > -- </td>
												  <?php endif; ?>	
													<td align="center" class="smalltext">
													<?php $this->assign('soldamnt', $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt']); ?>
													<?php $this->assign('totalOwn', $this->_tpl_vars['subTotalCharge']+$this->_tpl_vars['soldamnt']); ?>
													<?php $this->assign('sellerOwn', $this->_tpl_vars['totalOwn']-$this->_tpl_vars['subTotalDis']); ?>
													$<?php echo ((is_array($_tmp=$this->_tpl_vars['sellerOwn'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>

																										
													</td>
												 <?php endif; ?>	
												<td align="center" class="print_data"> <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] != '1'): ?>
																					 <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '0' || ( $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == 3 && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['is_approved_for_monthly_auction'] == '0' )): ?>
																					 Pending
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '2'): ?>
																					 Disapproved
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '1' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '0' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_start_datetime'] > ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S"))): ?>
																					 Upcoming
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '1' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '0' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_start_datetime'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")) && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_end_datetime'] > ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S"))): ?>
																					 Selling
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '1' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '0' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_start_datetime'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")) && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_actual_end_datetime'] < ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S"))): ?>
																					 Expired & Unsold
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '1'): ?>
																					 Sold
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '2'): ?>
																					 Sold by Buy Now
																					 <?php endif; ?>
																					 <?php endif; ?>
																					 <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1'): ?>
																					 <?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '1'): ?>
																					 Sold
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '2'): ?>
																					 Sold by Buy Now
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '0'): ?>
																					 Pending
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '2'): ?>
																					 Disapproved
																					 <?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_approved'] == '1' && $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['auction_is_sold'] == '0'): ?>
																					 Selling
																					 <?php endif; ?>
																					 <?php endif; ?></td>
												
											<?php $this->assign('oldInvoice', $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['invoice_id']); ?>	
											
											</tr>
                                            <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt']); ?>
										<?php endfor; endif; ?>
                                        <?php if ($_REQUEST['search'] == 'sold'): ?>
                                            <tr>
                                                <td colspan="7" align="right" class="print_data">Total Amount:</td>
                                                <td class="print_data">&nbsp;<?php if ($this->_tpl_vars['subTotal'] > 0): ?>&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif; ?></td>
                                            </tr>
                                        <?php endif; ?>
										<?php if ($_REQUEST['search'] == 'yet_to_pay'): ?>
										<tr>
										<td colspan="9" align="right" class="print_data">Total Payable From MPE to seller:</td>
										<td class="print_data" colspan="2" align="left">&nbsp;&nbsp;$<?php $this->assign('totsoldamnt', $this->_tpl_vars['total_sold_price']); ?>
												<?php $this->assign('tottotalOwn', $this->_tpl_vars['TotalCharge']+$this->_tpl_vars['totsoldamnt']); ?>
												<?php $this->assign('totsellerOwn', $this->_tpl_vars['tottotalOwn']-$this->_tpl_vars['TotalDis']); ?>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['totsellerOwn'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
										</tr>
										<?php endif; ?>
                                        <?php if ($_REQUEST['search'] == 'paid_by_buyer'): ?>
                                        <tr>
                                            <td colspan="7" align="right" class="print_data">Total Paid by Buyer:</td>
                                            <td class="print_data">&nbsp;<?php if ($this->_tpl_vars['subTotal'] > 0):  if ($this->_tpl_vars['subTotal'] > 0): ?>&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif;  endif; ?></td>
                                        </tr>
                                        <?php endif; ?>
										<?php if ($_REQUEST['search'] == 'paid'): ?>
										<tr>
										<td <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>colspan="9"<?php else: ?>colspan="8"<?php endif; ?> align="right" class="print_data">Total amount paid by MPE to seller:</td>
										<td colspan="2"  class="print_data">&nbsp;&nbsp;$<?php $this->assign('totsoldamnt', $this->_tpl_vars['total_sold_price']); ?>
												<?php $this->assign('tottotalOwn', $this->_tpl_vars['TotalCharge']+$this->_tpl_vars['totsoldamnt']); ?>
												<?php $this->assign('totsellerOwn', $this->_tpl_vars['tottotalOwn']-$this->_tpl_vars['TotalDis']); ?>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['totsellerOwn'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
										</tr>
										<?php endif; ?>
                                        <?php if ($_REQUEST['search'] == 'unpaid'): ?>
                                        <tr>
                                            <td <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>colspan="7"<?php else: ?>colspan="6"<?php endif; ?> align="right" class="print_data">Total amount Unpaid by Buyer:</td>
                                            <td class="print_data">&nbsp;<?php if ($this->_tpl_vars['subTotal'] > 0): ?>&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif; ?></td>
                                        </tr>
                                        <?php endif; ?>
										<tr class="header_bgcolor" height="26">
										<td <?php if ($_REQUEST['auction_type'] != 'weekly'): ?>colspan="8"<?php else: ?>colspan="7"<?php endif; ?> align='center'><input type="button" value="print" onclick="printPage()"></td>
										</tr>
											
										
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no auction in database.</td>
					</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>		
</table>
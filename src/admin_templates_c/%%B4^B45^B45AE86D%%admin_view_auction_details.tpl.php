<?php /* Smarty version 2.6.14, created on 2017-03-04 11:53:37
         compiled from admin_view_auction_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_view_auction_details.tpl', 27, false),array('modifier', 'number_format', 'admin_view_auction_details.tpl', 32, false),array('modifier', 'date_format', 'admin_view_auction_details.tpl', 90, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
                    </tr>
                <?php endif; ?> 
                    <tr>
                    	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='<?php echo $this->_tpl_vars['actualPath'];  echo $this->_tpl_vars['decoded_string']; ?>
'; " class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                    </tr>              		
					<tr>
						<td align="center">
                        	<div id="messageBox" class="messageBox" style="display:none;"></div>
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="15%">Poster</td>
                                            <td align="center" class="headertext" width="12%">Pricing</td>
                                            <td align="center" class="headertext" width="13%">Brief Auction</td>
                                            <td align="center" class="headertext" width="12%">Status</td>
										</tr>
											<tr id="tr_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionArr'][0]['image_path']; ?>
"  /><br /><?php echo $this->_tpl_vars['auctionArr'][0]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionArr'][0]['poster_sku']; ?>
</td>
												<td align="center" class="smalltext">
												<?php if ($this->_tpl_vars['auctionArr'][0]['fk_auction_type_id'] == '2' || $this->_tpl_vars['auctionArr'][0]['fk_auction_type_id'] == '5'): ?>
												Start Price :&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br/>Buynow Price :&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['auction_buynow_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>

                                                <?php elseif ($this->_tpl_vars['auctionArr'][0]['fk_auction_type_id'] == '3'): ?>
                                                Start Price :&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br/>Reserve Price :&nbsp;$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['auction_reserve_offer_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>

                                                <?php endif; ?>
                                                </td>
                                                <td align="center" class="smalltext">
                                                <?php if ($this->_tpl_vars['auctionArr'][0]['auction_is_sold'] != '2'): ?>
                                                Number of Bid: <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['count_bid'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
<br/>
                                                <?php if ($this->_tpl_vars['auctionArr'][0]['highest_bid'] != ''): ?>Highest Bid: $<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['highest_bid'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  endif; ?>
	                                             <?php if ($this->_tpl_vars['invoiceData'][2] > 0): ?>
	                                             	<br/>  	
	                                               	Sold Price: $<?php echo $this->_tpl_vars['invoiceData'][2]; ?>
<br/>
	                                                (Including all the charges)
	                                             <?php endif; ?>   
                                               	<?php else: ?>
                                               	Buyer Name: <?php echo $this->_tpl_vars['invoiceData'][0]; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData'][1]; ?>
<br/>
                                                Sold Price: $<?php echo $this->_tpl_vars['invoiceData'][2]; ?>
<br/>
                                                (Including all the charges)
                                               	<?php endif; ?>
                                                </td>                                                
												<td align="center" class="bold_text">
                                                <?php if ($this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '0'): ?>
                                                Item is not Sold
                                                <?php elseif ($this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '1'): ?>
                                                Item is Sold by Bidding &nbsp;View buyer invoice:<br/><br/><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionArr'][0]['auction_id']; ?>
"><img alt="" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoiceButton.PNG" width="20" title="View Invoice Buyer" border='0'></a>
                                                <?php elseif ($this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '2'): ?>
                                                Item is Sold by Direct Buy Now. &nbsp;View buyer invoice:<br/><br/><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionArr'][0]['auction_id']; ?>
"><img alt="" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
                                                <?php endif; ?>
												</td>
											</tr>
									</tbody>
								</table>
							</form>
						</td>
					</tr>
					
             	<?php if ($this->_tpl_vars['total'] > 0): ?>
                    <tr>
                    	<td align="left">
                    	 <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_border-noBtom" >
                                <tbody>
                                	<tr class="header_bgcolor" height="26">
                                        <td align="left" class="headertext" width="25%">Bid Person</td>
                                        <td align="center" class="headertext" width="20%">Bid Time</td>
                                                                                <td align="center" class="headertext" width="12%">Bid Date</td >
                                        <td align="center" class="headertext" width="12%">Amount</td>
                                        <td width="8%">&nbsp;</td>
                                    </tr>
                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionArr'][0]['bids']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    	
                                    	<?php if ($this->_tpl_vars['max_amount_no'] > 0): ?>
                                    	<?php if (( ( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '0' ) || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '1'): ?>
                                    	
                                    	<tr>
                                    		
                                    		
                                    		<td align="left" class="smalltext">&nbsp;<?php echo $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['username']; ?>
</td>
                                            <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M:00 %p") : smarty_modifier_date_format($_tmp, "%I:%M:00 %p")); ?>
 EDT</td>
                                                                                        <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
 &nbsp;&nbsp;<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['bids'][$this->_sections['bid_count']['index']]['post_date']; ?>
</td>
                                            <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            <td align="center" class="bold_text">
	                                            <?php if ($this->_tpl_vars['max_amount_no'] == 0): ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php else: ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '1'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '0'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if ($this->_tpl_vars['auctionArr'][0]['highest_bid'] > $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount']): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php endif; ?>
                                            </td>
                                           
                                            
                                             
                                           
                                    	</tr>
                                    	<?php endif; ?>
                                    	<?php endif; ?>
                                    	
                                    	
                                    
                                       
                                       
                                    <?php endfor; endif; ?>
                                   
                                </tbody>
                            </table>
                    	
                    	
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_border-notop" >
                                <tbody>
                                	
                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionArr'][0]['bids']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    	<?php if ($this->_tpl_vars['max_amount_no'] > 0): ?>
                                    	
                                    	<?php if (( ( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '0' ) || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '1'): ?>
                                    	
                                    	
                                    		
                                    		
                                            
                                            
                                           
                                    	
                                    	<?php else: ?>
                                    	
                                    	<tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                                            <td align="left" class="smalltext" width="25%">&nbsp;<?php echo $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['username']; ?>
</td>
                                            <td align="center" class="smalltext" width="20%"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M:00 %p") : smarty_modifier_date_format($_tmp, "%I:%M:00 %p")); ?>
 EDT</td>
                                                                                        <td align="center" class="smalltext" width="12%"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
 &nbsp;&nbsp;<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['bids'][$this->_sections['bid_count']['index']]['post_date']; ?>
</td>
                                            <td align="center" class="smalltext" width="12%">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            <td align="center" class="bold_text" width="8%">
	                                            <?php if ($this->_tpl_vars['max_amount_no'] == 0): ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php else: ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '1'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '0'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if ($this->_tpl_vars['auctionArr'][0]['highest_bid'] > $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount']): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                    	<?php endif; ?>
                                    	<?php else: ?>
                                        <tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                                            <td align="left" class="smalltext">&nbsp;<?php echo $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['username']; ?>
</td>
                                            <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M:00 %p") : smarty_modifier_date_format($_tmp, "%I:%M:00 %p")); ?>
 EDT</td>
                                                                                        <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
 &nbsp;&nbsp;<?php echo $this->_tpl_vars['bidDetails'][$this->_sections['counter']['index']]['bids'][$this->_sections['bid_count']['index']]['post_date']; ?>
</td>
                                            <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            <td align="center" class="bold_text">
	                                            <?php if ($this->_tpl_vars['max_amount_no'] == 0): ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php else: ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '1'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] <> '2' && $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['is_proxy'] == '0'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php endif; ?>
	                                            <?php if (( $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_is_won'] == '1' || $this->_tpl_vars['auctionArr'][0]['highest_bid'] <= $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount'] ) && $this->_tpl_vars['auctionArr'][0]['auction_is_sold'] == '2'): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php endif; ?>
	                                            <?php if ($this->_tpl_vars['auctionArr'][0]['highest_bid'] > $this->_tpl_vars['auctionArr'][0]['bids'][$this->_sections['counter']['index']]['bid_amount']): ?>
	                                            &nbsp;&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endfor; endif; ?>
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="headertext" colspan="3"></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
						</td>
                    </tr>
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no Bid in database.</td>
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
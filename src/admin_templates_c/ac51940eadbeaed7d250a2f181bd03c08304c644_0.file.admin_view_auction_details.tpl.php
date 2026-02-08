<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:24:01
  from '/var/www/html/admin_templates/admin_view_auction_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69877531183492_62412340',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac51940eadbeaed7d250a2f181bd03c08304c644' => 
    array (
      0 => '/var/www/html/admin_templates/admin_view_auction_details.tpl',
      1 => 1487960142,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_69877531183492_62412340 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
                    </tr>
                <?php }?> 
                    <tr>
                    	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;
echo $_smarty_tpl->tpl_vars['decoded_string']->value;?>
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
											<tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['image_path'];?>
"  /><br /><?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['poster_sku'];?>
</td>
												<td align="center" class="smalltext">
												<?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['fk_auction_type_id'] == '2' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['fk_auction_type_id'] == '5') {?>
												Start Price :&nbsp;$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_asked_price'],2);?>
<br/>Buynow Price :&nbsp;$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_buynow_price'],2);?>

                                                <?php } elseif ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['fk_auction_type_id'] == '3') {?>
                                                Start Price :&nbsp;$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_asked_price'],2);?>
<br/>Reserve Price :&nbsp;$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_reserve_offer_price'],2);?>

                                                <?php }?>
                                                </td>
                                                <td align="center" class="smalltext">
                                                <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] != '2') {?>
                                                Number of Bid: <?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['count_bid']);?>
<br/>
                                                <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] != '') {?>Highest Bid: $<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'],2);
}?>
	                                             <?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[2] > 0) {?>
	                                             	<br/>  	
	                                               	Sold Price: $<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[2];?>
<br/>
	                                                (Including all the charges)
	                                             <?php }?>   
                                               	<?php } else { ?>
                                               	Buyer Name: <?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[0];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[1];?>
<br/>
                                                Sold Price: $<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[2];?>
<br/>
                                                (Including all the charges)
                                               	<?php }?>
                                                </td>                                                
												<td align="center" class="bold_text">
                                                <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '0') {?>
                                                Item is not Sold
                                                <?php } elseif ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '1') {?>
                                                Item is Sold by Bidding &nbsp;View buyer invoice:<br/><br/><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_id'];?>
"><img alt="" src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoiceButton.PNG" width="20" title="View Invoice Buyer" border='0'></a>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '2') {?>
                                                Item is Sold by Direct Buy Now. &nbsp;View buyer invoice:<br/><br/><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_id'];?>
"><img alt="" src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
                                                <?php }?>
												</td>
											</tr>
									</tbody>
								</table>
							</form>
						</td>
					</tr>
					
             	<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
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
                                    <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                    	
                                    	<?php if ($_smarty_tpl->tpl_vars['max_amount_no']->value > 0) {?>
                                    	<?php if ((($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '0') || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '1') {?>
                                    	
                                    	<tr>
                                    		
                                    		
                                    		<td align="left" class="smalltext">&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['username'];?>
</td>
                                            <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%I:%M:00 %p");?>
 EDT</td>
                                                                                        <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%m/%d/%Y");?>
 &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index'] : null)]['post_date'];?>
</td>
                                            <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount'],2);?>
</td>
                                            <td align="center" class="bold_text">
	                                            <?php if ($_smarty_tpl->tpl_vars['max_amount_no']->value == 0) {?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php } else { ?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '1') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '0') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] > $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php }?>
                                            </td>
                                           
                                            
                                             
                                           
                                    	</tr>
                                    	<?php }?>
                                    	<?php }?>
                                    	
                                    	
                                    
                                       
                                       
                                    <?php
}
}
?>
                                   
                                </tbody>
                            </table>
                    	
                    	
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_border-notop" >
                                <tbody>
                                	
                                    <?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids']) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                    	<?php if ($_smarty_tpl->tpl_vars['max_amount_no']->value > 0) {?>
                                    	
                                    	<?php if ((($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '0') || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '1') {?>
                                    	
                                    	
                                    		
                                    		
                                            
                                            
                                           
                                    	
                                    	<?php } else { ?>
                                    	
                                    	<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                                            <td align="left" class="smalltext" width="25%">&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['username'];?>
</td>
                                            <td align="center" class="smalltext" width="20%"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%I:%M:00 %p");?>
 EDT</td>
                                                                                        <td align="center" class="smalltext" width="12%"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%m/%d/%Y");?>
 &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index'] : null)]['post_date'];?>
</td>
                                            <td align="center" class="smalltext" width="12%">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount'],2);?>
</td>
                                            <td align="center" class="bold_text" width="8%">
	                                            <?php if ($_smarty_tpl->tpl_vars['max_amount_no']->value == 0) {?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php } else { ?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '1') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '0') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] > $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php }?>
                                            </td>
                                        </tr>
                                    	<?php }?>
                                    	<?php } else { ?>
                                        <tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                                            <td align="left" class="smalltext">&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['username'];?>
</td>
                                            <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%I:%M:00 %p");?>
 EDT</td>
                                                                                        <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_time'],"%m/%d/%Y");?>
 &nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_bid_count']->value['index'] : null)]['post_date'];?>
</td>
                                            <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount'],2);?>
</td>
                                            <td align="center" class="bold_text">
	                                            <?php if ($_smarty_tpl->tpl_vars['max_amount_no']->value == 0) {?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php } else { ?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '1') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
winning-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] <> '2' && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_proxy'] == '0') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php }?>
	                                            <?php if (($_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_is_won'] == '1' || $_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] <= $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) && $_smarty_tpl->tpl_vars['auctionArr']->value[0]['auction_is_sold'] == '2') {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="winning" />
	                                            <?php }?>
	                                            <?php if ($_smarty_tpl->tpl_vars['auctionArr']->value[0]['highest_bid'] > $_smarty_tpl->tpl_vars['auctionArr']->value[0]['bids'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) {?>
	                                            &nbsp;&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
losing-bid-img.png" border="0" title="losing" />
	                                            <?php }?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    <?php
}
}
?>
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="headertext" colspan="3"></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
						</td>
                    </tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no Bid in database.</td>
					</tr>
				<?php }?>
				
							</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

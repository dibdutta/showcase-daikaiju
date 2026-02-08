<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:36:27
  from '/var/www/html/admin_templates/admin_main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981ebcbee7668_05671140',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f63701096c17594b6e9db13921f3f1df1083f57f' => 
    array (
      0 => '/var/www/html/admin_templates/admin_main.tpl',
      1 => 1487960182,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981ebcbee7668_05671140 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
		<tr>
			<td width="100%" align="center" colspan="2"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
		</tr>
	<?php }?>			
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
                                       <?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
                                             <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                        <tr>
                                                <td  width="60%"><span style="cursor:pointer;" ><img src="<?php echo $_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
&nbsp;</span></td>
                                                 <td width="38%" >&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_generated_on'],"%m/%d/%Y");?>
</td>
                                                <td width="38%" align="center">$<?php echo $_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['soldamnt'];?>
</td>
                                                <td width="38%" align="center"><?php if ($_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '1') {?>Fixed
                                                <?php } elseif ($_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '2') {?>Weekly
                                                <?php } elseif ($_smarty_tpl->tpl_vars['dataJstFinishedAuction']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '3') {?>Monthly
                                                <?php }?></td>
                                            </tr>
                                        <?php
}
}
?>
                                        <?php } else { ?>
                                        <tr>
                                            <td align="left" valign="top">No sold item to display.</td>
                                        </tr>
                                        <?php }?>
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
                                        <?php if ($_smarty_tpl->tpl_vars['totalBids']->value > 0) {?>
                                        <?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['bidDetails']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                        <tr>
                                            <td  width="55%"><img src="<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/admin/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
(#<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
)</a></td>
                                            <td width="18%"><?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bids'][0]['post_date'];?>
</td>
                                            <td width="15%">$<?php echo $_smarty_tpl->tpl_vars['bidDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bids'][0]['bid_amount'];?>
</td>
                                        </tr>                                        
                                        <?php
}
}
?>
                                        
                                        <?php } else { ?>
                                        <tr>
                                            <td align="left" valign="top">No winning bids.</td>
                                        </tr>
                                        <?php }?>
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
                                        <?php if ($_smarty_tpl->tpl_vars['totalOffers']->value > 0) {?>
                                        <?php
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['dataOfr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                        <tr>
                                            <td  width="55%"><img src="<?php echo $_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" width="20px" height="20px" border="0" />&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/admin/admin_auction_manager.php?mode=view_details_offer&auction_id=<?php echo $_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
(#<?php echo $_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
)</a></td>
                                            <td width="18%"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['post_date'],"%m/%d/%Y");?>
</td>
                                            <td width="15%">$<?php echo $_smarty_tpl->tpl_vars['dataOfr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['offer_amount'];?>
</td>
                                        </tr>
                                        <?php
}
}
?>
                                        
                                        <?php } else { ?>
                                        <tr>
                                            <td align="left" valign="top">No new offer to display.</td>
                                        </tr>
                                        <?php }?>
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
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:57:25
  from '/var/www/html/admin_templates/admin_auction_week_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981f0b55d56a5_42087325',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5eb142fd336f9c25eb1e7d2b347d5c68e6eab4f2' => 
    array (
      0 => '/var/www/html/admin_templates/admin_auction_week_manager.tpl',
      1 => 1488119106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981f0b55d56a5_42087325 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>

function sync_bids(id){
	$.get("admin_manage_auction_week.php", { mode:"sync_auction_bid","week_id": id},
		function(data) {
			alert("Successfully Synced");
	});	
}

function sync_missing(id){
	$.get("sync_missing_item.php", { "week_id": id},
		function(data) {
			alert("Successfully Synced");
	});	
}
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"> <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=add_auction_week&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link"><strong>Create New Auction Week</strong></a></td>
							</tr>
						</table>
					</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="70%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="20%">Auction Week Title </td>
                                            <td align="center" class="headertext" width="25%">Start Time</td>
                                            <td align="center" class="headertext" width="25%">End Time </td>
											<td align="center" class="headertext" width="30%">Action</td>
										</tr>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auction_week']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                            <tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                                                <!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_title'];?>
</td>
                                                <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['start_date'];?>
</td>
                                                <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['end_date'];?>
</td>
                                                <td align="center" class="bold_text">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=edit_auction_week&auction_week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=delete_auction_week&auction_week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
', 'Record'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=manage_weekly_auction&week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Manage Weekly Auction" title="Manage Weekly Auction" border="0" class="changeStatus" /></a>
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=manage_weekly_auction_for_seller&week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
													&nbsp;&nbsp;
													<a href="javascript:void(0);" ><img src="http://3c514cb7d2d88d109eb9-1000d3d367b7fad333f1e36c27dd4ec3.r35.cf2.rackcdn.com/sync.png" align="absmiddle" alt="Sync Auction Bids" title="Sync Auction Bids" border="0" class="changeStatus" width="20px" onclick="sync_bids(<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
)" /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/missing_item.php?week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/admin-list.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="List of Missing Items" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/missing_item_update.php?week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/set-default.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="Set Default Images" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/sync_missing_item.php?week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/sync-missing.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="Sync Missing Sold Items" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=view_snipes&week_id=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/snipes.png" align="absmiddle" target="_blank" alt="View All Snipes" title="View All Snipes" border="0" class="changeStatus" width="20px"  /> </a>
													
													
                                                </td>
                                            </tr>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" colspan="2" class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all_category">Delete Category</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no auction week  in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

<?php /* Smarty version 2.6.14, created on 2017-02-26 09:27:28
         compiled from admin_auction_week_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_auction_week_manager.tpl', 52, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script>

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
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"> <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=add_auction_week&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link"><strong>Create New Auction Week</strong></a></td>
							</tr>
						</table>
					</td>
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
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auction_week']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                            <tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                                                <!--<td align="center" class="smalltext"><input type="checkbox" name="cat_ids[]" value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_title']; ?>
</td>
                                                <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['start_date']; ?>
</td>
                                                <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['end_date']; ?>
</td>
                                                <td align="center" class="bold_text">
                                                    <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=edit_auction_week&auction_week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Category" title="Update Category" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=delete_auction_week&auction_week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'Record'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>&nbsp;&nbsp;
                                                    <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=manage_weekly_auction&week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Manage Weekly Auction" title="Manage Weekly Auction" border="0" class="changeStatus" /></a>
                                                    <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=manage_weekly_auction_for_seller&week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
													&nbsp;&nbsp;
													<a href="javascript:void(0);" ><img src="http://3c514cb7d2d88d109eb9-1000d3d367b7fad333f1e36c27dd4ec3.r35.cf2.rackcdn.com/sync.png" align="absmiddle" alt="Sync Auction Bids" title="Sync Auction Bids" border="0" class="changeStatus" width="20px" onclick="sync_bids(<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
)" /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/missing_item.php?week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/admin-list.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="List of Missing Items" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/missing_item_update.php?week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/set-default.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="Set Default Images" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="http://www.movieposterexchange.com/admin/sync_missing_item.php?week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/sync-missing.png" align="absmiddle" target="_blank" alt="Sync Auction Bids" title="Sync Missing Sold Items" border="0" class="changeStatus" width="20px"  /> </a>
													&nbsp;&nbsp;
													<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=view_snipes&week_id=<?php echo $this->_tpl_vars['auction_week'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" target="_blank" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/snipes.png" align="absmiddle" target="_blank" alt="View All Snipes" title="View All Snipes" border="0" class="changeStatus" width="20px"  /> </a>
													
													
                                                </td>
                                            </tr>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext"><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" colspan="2" class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
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
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no auction week  in database.</td>
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
<?php /* Smarty version 2.6.14, created on 2017-02-26 13:43:44
         compiled from admin_weekly_auction_snipe_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_weekly_auction_snipe_manager.tpl', 59, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script language="javascript">
function approveAuction(id, is_approved, searchDisp)
{
	var url = "admin_change_status.php";
	var request = "mode=auction&id="+id+"&is_approved="+status;

	$.post(url, {mode: \'auction\', id: id, is_approved: is_approved}, function(retunedData, textStatus){
		if(searchDisp == \'\' || searchDisp == \'waiting\'){
			$("#tr_"+id).hide();
		}else{
			if(status == 1){
				$("#td_"+id).html("Approved");
			}else{
				$("#td_"+id).html("Disapproved");
			}
		}
	});
}
</script>
'; ?>

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
					<td width="100%">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									
								</td>
							</tr>
						</table>
					</td>
				</tr>		
				<?php if ($this->_tpl_vars['total'] > 0): ?>
					<tr>
						<td align="center">
                        	<div id="messageBox" class="messageBox" style="display:none;"></div>
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="15%">Poster</td>
                                            <td align="center" class="headertext" width="15%">Bid Amount</td>
                                            <td align="center" class="headertext" width="14%">Bidder Name</td>
                                            <td align="center" class="headertext" width="8%">Snipe Status</td>
							
										</tr>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['snipeArr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
											<tr id="<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="<?php echo @CLOUD_POSTER_THUMB;  echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['poster_image']; ?>
" height="100" width="78" /><br /><?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
												<td align="center" class="smalltext">$<?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['bid_amount']; ?>
</td>
                                                <td align="center" class="smalltext"><?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['firstname']; ?>
 &nbsp;<?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
                                                
                                                <td id="td_<?php echo $this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['auction_id']; ?>
" align="center" class="smalltext">
													<?php if ($this->_tpl_vars['snipeArr'][$this->_sections['counter']['index']]['bid_is_won'] == '1'): ?>
														Winning Snipe
                                                    <?php else: ?>
                                                    	Losing Snipe
													<?php endif; ?>
												</td>
                                                
												
											</tr>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext"><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" <?php if ($_REQUEST['mode'] == 'fixed_price'): ?>colspan="2"<?php else: ?>colspan="5"<?php endif; ?> class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="<?php echo $this->_tpl_vars['adminImagePath']; ?>
/arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all">Delete</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no auctions in database.</td>
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
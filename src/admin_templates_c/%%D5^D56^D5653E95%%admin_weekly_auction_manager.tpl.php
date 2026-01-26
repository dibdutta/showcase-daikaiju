<?php /* Smarty version 2.6.14, created on 2017-03-04 13:53:24
         compiled from admin_weekly_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_weekly_auction_manager.tpl', 143, false),array('modifier', 'number_format', 'admin_weekly_auction_manager.tpl', 147, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>
<?php echo '
<script type="text/javascript">
	

$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

function reset_date(ele) {
		    $(ele).find(\':input\').each(function() {
		        switch(this.type) {
	            	case \'text\':
	            	case \'select-one\':	
		                $(this).val(\'\');
		                break;    
		            
		        }
		    });
		    
		}
	function test(){
		if(document.getElementById(\'start_date\').value!=\'\'){
			if(document.getElementById(\'end_date\').value!=\'\'){
				return true;
			}else{
				alert("Please select a end date");
				document.getElementById(\'end_date\').focus();
				return false;
		}
	}	
 }	
 function view_all(){
  	window.location.href="admin_auction_manager.php?mode=weekly";
  }
  function set_for_homepage(id){
		if ($(\'#home_slider_\'+id).is(\':checked\')) {
    		$.get("admin_auction_manager.php", { mode:"set_as_big_slider","auction_id": id},
				function(data) {
					
				
			});	
		} else {
    		$.get("admin_auction_manager.php", { mode:"remove_as_big_slider","auction_id": id},
				function(data) {
					
				
			});
		} 
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
					<form action="" method="get" onsubmit="return test();">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									
                                    	<input type="hidden" name="mode" value="weekly" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
                                        	<option value="" selected="selected">All</option>
                                            <option value="selling" <?php if ($this->_tpl_vars['search'] == 'selling'): ?>selected="selected"<?php endif; ?>>Selling</option>
                                            <option value="pending" <?php if ($this->_tpl_vars['search'] == 'pending'): ?>selected="selected"<?php endif; ?>>Pending</option>
                                            <option value="sold" <?php if ($this->_tpl_vars['search'] == 'sold'): ?>selected="selected"<?php endif; ?>>Sold</option>
                                            <option value="unsold" <?php if ($this->_tpl_vars['search'] == 'unsold'): ?>selected="selected"<?php endif; ?>>Unsold</option>
											<option value="upcoming" <?php if ($this->_tpl_vars['search'] == 'upcoming'): ?>selected="selected"<?php endif; ?>>Up Coming</option>
											<option value="unpaid" <?php if ($this->_tpl_vars['search'] == 'unpaid'): ?>selected="selected"<?php endif; ?>>Unpaid</option>
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									
								</td>
							</tr>
						</table>
						<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
							<tr>
							       <td  align="right">Sort By:&nbsp;</td>
								   <td>
										<select name="sort_type" class="look" id='search_id' onChange="this.form.submit();">
											<option value="" selected="selected" >Select</option>
											<option value="poster_title" <?php if ($this->_tpl_vars['sort_type'] == 'poster_title'): ?> selected="selected"<?php endif; ?>>Poster Title(A-Z)</option>						
											<option value="poster_title_desc" <?php if ($this->_tpl_vars['sort_type'] == 'poster_title_desc'): ?> selected="selected"<?php endif; ?>>Poster Title(Z-A)</option>
											<option value="seller" <?php if ($this->_tpl_vars['sort_type'] == 'seller'): ?> selected="selected"<?php endif; ?> >Seller(A-Z)</option>										
											<option value="seller_desc" <?php if ($this->_tpl_vars['sort_type'] == 'seller_desc'): ?> selected="selected"<?php endif; ?>>Seller(Z-A)</option>
										</select>
								    </td>
									<td align="right">Search:&nbsp;</td>
									<td>
										<input type="text" name="search_fixed_poster" value="<?php echo $this->_tpl_vars['search_fixed_poster']; ?>
" class="look" />&nbsp;
									</td>
							</tr>
							<tr>
									<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date:&nbsp;
									</td>
									<td>
										<input type="text" name="start_date" id="start_date" value="<?php echo $this->_tpl_vars['start_date_show']; ?>
"  class="look required" /></td>
									<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date:&nbsp;
									</td>
									<td>
										<input type="text" name="end_date" id="end_date" value="<?php echo $this->_tpl_vars['end_date_show']; ?>
"  class="look required" />                        </td>
									<td>
										<input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" >
									&nbsp;<input type="button"  value="View All" class="button" onclick="view_all()">
									</td>
							</tr>
						</table>
						</form>
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
											<td align="center" class="headertext" width="13%">Seller</td>
                                            <td align="center" class="headertext" width="15%">Start Price</td>
                                            <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending'): ?>
                                            <td align="center" class="headertext" width="8%">Status</td>
                                            <?php endif; ?>
											<td align="center" class="headertext" width="14%">Action</td>
										</tr>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
											<tr id="tr_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['image_path']; ?>
" style="cursor:pointer;" onclick="javascript:window.open('<?php echo $this->_tpl_vars['actualPath']; ?>
/auction_images_large.php?mode=auction_images_large&id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_id']; ?>
&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
','mywindow','menubar=1,resizable=1,width=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['img_width']+100; ?>
,height=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['img_height']+100; ?>
,scrollbars=yes')"  /><br /><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
												<td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                                <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending'): ?>
                                                <td id="td_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" align="center" class="smalltext">
													<?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == 0): ?>
														<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
, 1, '<?php echo $_REQUEST['search']; ?>
', 'weekly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
, 2, '<?php echo $_REQUEST['search']; ?>
', 'weekly');" title="Disapprove" class="changeStatus" />
													<?php elseif ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == 1): ?>
														Approved
                                                    <?php else: ?>
                                                    	Disapproved
													<?php endif; ?>
												</td>
                                                <?php endif; ?>
												<td align="center" class="bold_text">
                                                                                                	<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=delete_auction&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'auction','<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Auction" title="Delete Auction" border="0" class="changeStatus" /></a>
                                                                                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>&nbsp;&nbsp;-->
                                                <?php if ($this->_tpl_vars['search'] == 'selling' || $this->_tpl_vars['search'] == 'sold' || $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == '1'): ?>
                                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a><?php endif; ?>
												<?php if ($this->_tpl_vars['search'] == 'sold'): ?>
												<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Manage Invoice Buyer" title="Manage Invoice Buyer" border="0" class="changeStatus" width="20px" /></a>
												&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice_seller&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
												<?php endif; ?>
												<?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
													 <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
												<?php elseif ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
													<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												<?php endif; ?>
												<?php if ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
													 <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
												<?php elseif ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
													<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												<?php endif; ?>
												<?php if ($this->_tpl_vars['search'] == 'selling' || $this->_tpl_vars['search'] == 'sold'): ?>
                                                 <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_proxy_manager.php?auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&type=<?php echo $this->_tpl_vars['search']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
proxy-bid-icon.png" align="absmiddle" title="Proxy Bids" width="20" height="16" border="0" /></a>
												
												<?php endif; ?>
												<?php if (( $this->_tpl_vars['search'] == 'selling' || $this->_tpl_vars['search'] == 'upcoming' ) && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['is_big'] == '1'): ?>
													<input type="checkbox" name="home_slider" id="home_slider_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" value="<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" onclick="set_for_homepage(this.value)" <?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['is_set_for_home_big_slider'] == '1'): ?> checked="checked" <?php endif; ?> />
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
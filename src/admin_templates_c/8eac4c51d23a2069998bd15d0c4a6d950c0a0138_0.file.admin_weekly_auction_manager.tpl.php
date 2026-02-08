<?php
/* Smarty version 3.1.47, created on 2026-02-07 05:54:26
  from '/var/www/html/admin_templates/admin_weekly_auction_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698719e27e2993_23844806',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8eac4c51d23a2069998bd15d0c4a6d950c0a0138' => 
    array (
      0 => '/var/www/html/admin_templates/admin_weekly_auction_manager.tpl',
      1 => 1487960134,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698719e27e2993_23844806 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
	

$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':
	            	case 'select-one':	
		                $(this).val('');
		                break;    
		            
		        }
		    });
		    
		}
	function test(){
		if(document.getElementById('start_date').value!=''){
			if(document.getElementById('end_date').value!=''){
				return true;
			}else{
				alert("Please select a end date");
				document.getElementById('end_date').focus();
				return false;
		}
	}	
 }	
 function view_all(){
  	window.location.href="admin_auction_manager.php?mode=weekly";
  }
  function set_for_homepage(id){
		if ($('#home_slider_'+id).is(':checked')) {
    		$.get("admin_auction_manager.php", { mode:"set_as_big_slider","auction_id": id},
				function(data) {
					
				
			});	
		} else {
    		$.get("admin_auction_manager.php", { mode:"remove_as_big_slider","auction_id": id},
				function(data) {
					
				
			});
		} 
	}
<?php echo '</script'; ?>
>

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
					<td width="100%">
					<form action="" method="get" onsubmit="return test();">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" >
							<tr>
								<td class="bold_text" align="center">
									
                                    	<input type="hidden" name="mode" value="weekly" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
                                        	<option value="" selected="selected">All</option>
                                            <option value="selling" <?php if ($_smarty_tpl->tpl_vars['search']->value == "selling") {?>selected="selected"<?php }?>>Selling</option>
                                            <option value="pending" <?php if ($_smarty_tpl->tpl_vars['search']->value == "pending") {?>selected="selected"<?php }?>>Pending</option>
                                            <option value="sold" <?php if ($_smarty_tpl->tpl_vars['search']->value == "sold") {?>selected="selected"<?php }?>>Sold</option>
                                            <option value="unsold" <?php if ($_smarty_tpl->tpl_vars['search']->value == "unsold") {?>selected="selected"<?php }?>>Unsold</option>
											<option value="upcoming" <?php if ($_smarty_tpl->tpl_vars['search']->value == "upcoming") {?>selected="selected"<?php }?>>Up Coming</option>
											<option value="unpaid" <?php if ($_smarty_tpl->tpl_vars['search']->value == "unpaid") {?>selected="selected"<?php }?>>Unpaid</option>
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
											<option value="poster_title" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "poster_title") {?> selected="selected"<?php }?>>Poster Title(A-Z)</option>						
											<option value="poster_title_desc" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "poster_title_desc") {?> selected="selected"<?php }?>>Poster Title(Z-A)</option>
											<option value="seller" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "seller") {?> selected="selected"<?php }?> >Seller(A-Z)</option>										
											<option value="seller_desc" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "seller_desc") {?> selected="selected"<?php }?>>Seller(Z-A)</option>
										</select>
								    </td>
									<td align="right">Search:&nbsp;</td>
									<td>
										<input type="text" name="search_fixed_poster" value="<?php echo $_smarty_tpl->tpl_vars['search_fixed_poster']->value;?>
" class="look" />&nbsp;
									</td>
							</tr>
							<tr>
									<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date:&nbsp;
									</td>
									<td>
										<input type="text" name="start_date" id="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date_show']->value;?>
"  class="look required" /></td>
									<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date:&nbsp;
									</td>
									<td>
										<input type="text" name="end_date" id="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date_show']->value;?>
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
				<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
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
                                            <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending') {?>
                                            <td align="center" class="headertext" width="8%">Status</td>
                                            <?php }?>
											<td align="center" class="headertext" width="14%">Action</td>
										</tr>
										<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" style="cursor:pointer;" onclick="javascript:window.open('<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/auction_images_large.php?mode=auction_images_large&id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
','mywindow','menubar=1,resizable=1,width=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['img_width']+100;?>
,height=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['img_height']+100;?>
,scrollbars=yes')"  /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</td>
												<td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'],2);?>
</td>
                                                <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending') {?>
                                                <td id="td_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" align="center" class="smalltext">
													<?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 0) {?>
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 1, '<?php echo $_REQUEST['search'];?>
', 'weekly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 2, '<?php echo $_REQUEST['search'];?>
', 'weekly');" title="Disapprove" class="changeStatus" />
													<?php } elseif ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 1) {?>
														Approved
                                                    <?php } else { ?>
                                                    	Disapproved
													<?php }?>
												</td>
                                                <?php }?>
												<td align="center" class="bold_text">
                                                                                                	<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=delete_auction&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
', 'auction','<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Auction" title="Delete Auction" border="0" class="changeStatus" /></a>
                                                                                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>&nbsp;&nbsp;-->
                                                <?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling' || $_smarty_tpl->tpl_vars['search']->value == 'sold' || $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == '1') {?>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a><?php }?>
												<?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
												<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Manage Invoice Buyer" title="Manage Invoice Buyer" border="0" class="changeStatus" width="20px" /></a>
												&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice_seller&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
												<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
													 <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
												<?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
													<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
													 <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
												<?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
													<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
												<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling' || $_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
                                                 <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_proxy_manager.php?auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&type=<?php echo $_smarty_tpl->tpl_vars['search']->value;?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
proxy-bid-icon.png" align="absmiddle" title="Proxy Bids" width="20" height="16" border="0" /></a>
												
												<?php }?>
												<?php if (($_smarty_tpl->tpl_vars['search']->value == 'selling' || $_smarty_tpl->tpl_vars['search']->value == 'upcoming') && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_big'] == '1') {?>
													<input type="checkbox" name="home_slider" id="home_slider_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" onclick="set_for_homepage(this.value)" <?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_set_for_home_big_slider'] == '1') {?> checked="checked" <?php }?> />
													<?php }?>
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
											<td align="right" <?php if ($_REQUEST['mode'] == 'fixed_price') {?>colspan="2"<?php } else { ?>colspan="5"<?php }?> class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
										</tr>
									</tbody>
								</table>								
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no auctions in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

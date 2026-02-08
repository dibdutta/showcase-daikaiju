<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:32:45
  from '/var/www/html/admin_templates/admin_set_first_image_for_home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6987773d1658f8_56341192',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b50592ffa0a90a38217ec337a81cdd78eae1b090' => 
    array (
      0 => '/var/www/html/admin_templates/admin_set_first_image_for_home.tpl',
      1 => 1487960124,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6987773d1658f8_56341192 (Smarty_Internal_Template $_smarty_tpl) {
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
	function redirect_to_consignment(){
		window.location.href="admin_auction_manager.php?mode=create_fixed&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
";
	}
 	function track_item_for_home(id){
		$.post("admin_auction_manager.php", { mode: "track_first_sold_for_home", auction_id: id },
	 	function(data) {
	   		alert(data);
		});
 	}
 	function changeSeliderPositionStatus(actionId,type){  
	  if(type == 1){
	   $.post("admin_auction_manager.php", { mode: "track_first_sold_for_home", actionId: actionId },
	   function(data) {
	   alert(data);
	  });
	  }else if(type == 2){
	   $.post("admin_auction_manager.php", { mode: "update_slider", actionId: actionId },
	   function(data) {
	   alert(data);
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
					<input type="hidden" name="mode" value="fixed" />
					<input type="hidden" name="search" value="<?php echo $_REQUEST['search'];?>
" />
						<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
							<tr>
						       <td  align="right">Sort By:&nbsp;</td>
							   <td>
									<select name="sort_type" class="look" id='search_id' onChange="javascript: this.form.submit();">
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
								<td>
									<input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" >
								&nbsp;<input type="button"  value="View All" class="button" onclick="window.location.href='admin_set_first_image_for_home.php?mode=fixed&search=<?php echo $_REQUEST['search'];?>
'">
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
											<td align="center" class="headertext" width="14%">Seller</td>
                                            <td align="center" class="headertext" width="12%">Ask Price</td>
                                            <td align="center" class="headertext" width="14%">Offer Price</td>
                                            <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending') {?><td align="center" class="headertext" width="8%">Status</td><?php }?>
											<td align="center" class="headertext" width="13%">Set as First poster in Home Page</td>
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
','mywindow','menubar=1,resizable=1,width=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['img_width']+100;?>
,height=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['img_height']+100;?>
,scrollbars=yes')" /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
												<td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</td>
												<td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'],2);?>
</td>
                                                <td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_reserve_offer_price'] > 0) {?>Will consider Offers<?php } else { ?>--<?php }?></td> 
                                                <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'pending') {?>
                                                <td id="td_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" align="center" class="smalltext">
													<?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 0) {?>
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 1, '<?php echo $_REQUEST['search'];?>
', 'fixed');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 2, '<?php echo $_REQUEST['search'];?>
', 'fixed');" title="Disapprove" class="changeStatus" />
													<?php } elseif ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 1) {?>
														Approved
                                                    <?php } else { ?>
                                                    	Disapproved
													<?php }?>
												</td>
                                                <?php }?>
												<td align="center" class="bold_text">
                                               
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling') {?>
                       									<input type="radio" name="admin_track_slider" value="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" title="Select First Item for Home Page" <?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['slider_first_position_status'] == 1) {?> checked="checked";<?php }?> onclick="changeSeliderPositionStatus(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
,'2');" >
                      								<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
													<input type="radio" name="admin_track_slider" value="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" title="Select First Item for Home Page" <?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['slider_first_position_status'] == 1) {?> checked="checked";<?php }?> onclick="changeSeliderPositionStatus(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
,'1');" >
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
											<td align="right" <?php if ($_REQUEST['search'] == 'fixed_price') {?>colspan="2"<?php } else { ?>colspan="5"<?php }?> class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
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

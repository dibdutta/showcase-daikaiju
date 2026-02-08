<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:57:09
  from '/var/www/html/admin_templates/admin_fixed_auction_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981f0a59e81e7_02347577',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc300926af49533ff0f441e2f982b24cbecd9e6d' => 
    array (
      0 => '/var/www/html/admin_templates/admin_fixed_auction_manager.tpl',
      1 => 1487960248,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981f0a59e81e7_02347577 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
>
<link href="https://c15123524.ssl.cf2.rackcdn.com/font_style.css" rel="stylesheet" type="text/css" />
<link href="https://83dbb0412ecaf8e2c92c-41ffd15ff927f6ace8687112504b6f43.ssl.cf2.rackcdn.com/template_test.css" rel="stylesheet" type="text/css" />

<?php echo '<script'; ?>
>
	!window.jQuery && document.write('<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


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
 function redirect_to_consignment(){
 	window.location.href="admin_auction_manager.php?mode=create_fixed&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
";
 }
 function view_all(){
 	window.location.href="admin_auction_manager.php?mode=fixed";
 }	
 function combine_buyer_invoice(){
	 //var checkBoxs = $(":checkbox").filter(":checked").size();

		 
     var allVals = [];
     $(":checkbox").filter(":checked").each(function() {
       allVals.push($(this).val());
     });
     //$('#t').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for buyer!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_buyer_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data=='1'){
		    			    alert("Successfully invoices are combined"); 
	    			     }else{
	    			    	 alert("invoices are not combined"); 
	    			     }
	    			   }); 
	    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
	     }else{
	    	 $(":checkbox").filter(":checked").each(function() {
		     		$(this).removeAttr("checked");
		          });
	     }
     }else{
    	 alert("Please select atleast two invoices to combine.");
    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
     }
     
 }
 function combine_seller_invoice(){
	 //var checkBoxs = $(":checkbox").filter(":checked").size();

		 
     var allVals = [];
     $(":checkbox").filter(":checked").each(function() {
       allVals.push($(this).val());
     });
     //$('#t').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for seller!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_seller_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data=='1'){
		    			    alert("Successfully invoices are combined"); 
	    			     }else{
	    			    	 alert("invoices are not combined"); 
	    			     }
	    			   }); 
	    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
	     }else{
	    	 $(":checkbox").filter(":checked").each(function() {
		     		$(this).removeAttr("checked");
		          });
	     }
     }else{
    	 alert("Please select atleast two invoices to combine.");
    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
     }
     
 }
 function mark_shipped_buyer_invoice(id)
    {
	  $.get("admin_auction_manager.php", { mode:"shipped_item_list","invoice_id": id},
                    function(data) {
					    var itemList='You are about to mark following items as shipped \n';
                        var obj = JSON.parse(data);
						var count = obj.length;
						for(var i=0;i<count;i++){
						  itemList += 'Poster Title: '+obj[i].poster_title +' (' + obj[i].auction_type + ')' + '\n';
						}
						if(confirm(itemList)){
						   $.get("admin_manage_auction_week.php", { mode:"mark_shipped_buyer_invoice","invoice_id": id},
							function(data) {
							if(data=='1'){
								alert("Successfully invoice(s) are marked as shipped.");
								$(".changeStatus_"+id).attr('src',"<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
shipped.png");
							}else{
								alert("Invoices are not marked as shipped.");
							}
						  });
						}
                    });
     	
        

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
		function fancy_images(i){
			$("#various_"+i).fancybox({
    		'width': 390,
    		'height': 400,
			'onClosed': function() {
    		parent.location.reload(true);
  				}
  			});
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
					<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" >
							
							<tr>
								<td class="bold_text" align="center" colspan="2" >
									
                                    	<input type="hidden" name="mode" value="fixed" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
										    <option value="" selected="selected">Select Status</option>
                                        	<option value="all" <?php if ($_smarty_tpl->tpl_vars['search']->value == "all") {?>selected="selected"<?php }?> >All</option>
											<option value="selling" <?php if ($_smarty_tpl->tpl_vars['search']->value == "selling") {?>selected="selected"<?php }?>>Selling</option>
                                            <option value="pending" <?php if ($_smarty_tpl->tpl_vars['search']->value == "pending") {?>selected="selected"<?php }?>>Pending</option>
                                            <option value="sold" <?php if ($_smarty_tpl->tpl_vars['search']->value == "sold") {?>selected="selected"<?php }?>>Sold</option>
                                            <option value="unpaid" <?php if ($_smarty_tpl->tpl_vars['search']->value == "unpaid") {?>selected="selected"<?php }?>>Unpaid</option>
											<option value="seller_pending" <?php if ($_smarty_tpl->tpl_vars['search']->value == "seller_pending") {?> selected="selected"<?php }?>>Sale Pending</option>
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									
								</td>
								<td>&nbsp; &nbsp;<input type="button"  value="Add Consignment Item" class="button" onclick="redirect_to_consignment()"></td>
							</tr>
						</table>
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
											<option value="buyer" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "buyer") {?> selected="selected"<?php }?> >Buyer(A-Z)</option>										
											<option value="buyer_desc" <?php if ($_smarty_tpl->tpl_vars['sort_type']->value == "buyer_desc") {?> selected="selected"<?php }?>>Buyer(Z-A)</option>
											
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
											<td align="center" class="headertext" width="8%">Poster</td>

											<td align="center" class="headertext" width="12%">Seller</td>
                                            <td align="center" class="headertext" width="6%">Ask Price</td>
                                            <td align="center" class="headertext" width="10%">Offer Price</td>
                                            <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'selling' || $_REQUEST['search'] == 'pending') {?><td align="center" class="headertext" width="8%">Status</td><?php }?>
											<td align="center" class="headertext" width="15%">Action</td>
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
												
                                                <td align="center" class="smalltext" >

                                                <img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
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
                                                <td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_reserve_offer_price'] > 0) {?>Will consider offers<?php } else { ?>--<?php }?></td>
                                                <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'selling' || $_REQUEST['search'] == 'pending') {?>
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
														Approved &nbsp;&nbsp;
														<?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_sold'] == 0) {?>
														<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 2, '<?php echo $_REQUEST['search'];?>
', 'fixed');" title="Disapprove" class="changeStatus" />
														<?php }?>
                                                    <?php } else { ?>
                                                    	Disapproved
													<?php }?>
												</td>
                                                <?php }?>
												<td align="center" class="bold_text">
                                                                                                	<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" /></a>
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=delete_auction&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
', 'auction','<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
'); return false;"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Auction" title="Delete Auction" border="0" class="changeStatus" /></a> 
                                                                                                 <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                    <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" class="changeStatus" /></a>&nbsp;&nbsp;-->
                                             		<?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling' || $_smarty_tpl->tpl_vars['search']->value == 'sold' || $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == '1') {?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_details_offer&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a><?php }?>
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
													<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Manage Invoice" title="Manage Invoice Buyer" border="0" class="changeStatus" width="20px" /></a>
													&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice_seller&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
													<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
													 <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
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
													&nbsp;&nbsp;
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
													<?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_shipped'] == '1') {?>
														<a href="javascript:void(0)"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
shipped.png" alt="Combined" title="Shipped on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['shipped_date'],"%m/%d/%Y");?>
" class="changeStatus" > </a>
													<?php } else { ?>
														<a href="javascript:void(0)"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_shipped.png" alt="Combined" title="Not Shipped" class="changeStatus_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id'];?>
" onclick="mark_shipped_buyer_invoice('<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id'];?>
')"></a>
													<?php }?>
													<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling' && $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_big'] == '1') {?>
													<input type="checkbox" name="home_slider" id="home_slider_<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" onclick="set_for_homepage(this.value)" <?php if ($_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_set_for_home_big_slider'] == '1') {?> checked="checked" <?php }?> />
													<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['search']->value == 'selling') {?>
													<a id="various_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/admin_myselling.php?mode=move_to_weekly&id=<?php echo $_smarty_tpl->tpl_vars['auctionRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><input type="button" id="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
" onclick="fancy_images(this.id)" class="track-btn" value="Move to weekly" /></a>
													<?php }?>
												</td>
											</tr>
										<?php
}
}
?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="4" class="headertext"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
											<td align="right" <?php if ($_REQUEST['search'] == 'fixed_price') {?>colspan="2"<?php } else { ?>colspan="5"<?php }?> class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
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
													<option value="delete_all">Delete</option>
											</select>
										</td>
									</tr>
								</table>-->
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
					<?php if ($_smarty_tpl->tpl_vars['search']->value != '') {?>
						<td align="center" class="err">There is no auctions in database.</td>
				    <?php } else { ?>
				    	<td align="center" class="err">Please select a status.</td>		
			        <?php }?>			
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

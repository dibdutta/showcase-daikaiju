<?php /* Smarty version 2.6.14, created on 2017-03-04 13:53:10
         compiled from admin_fixed_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_fixed_auction_manager.tpl', 274, false),array('modifier', 'number_format', 'admin_fixed_auction_manager.tpl', 281, false),array('modifier', 'date_format', 'admin_fixed_auction_manager.tpl', 317, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>
<link href="https://c15123524.ssl.cf2.rackcdn.com/font_style.css" rel="stylesheet" type="text/css" />
<link href="https://83dbb0412ecaf8e2c92c-41ffd15ff927f6ace8687112504b6f43.ssl.cf2.rackcdn.com/template_test.css" rel="stylesheet" type="text/css" />

<script>
	!window.jQuery && document.write('<script src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
</script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

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
 function redirect_to_consignment(){
 	window.location.href="admin_auction_manager.php?mode=create_fixed&encoded_string=';  echo $this->_tpl_vars['encoded_string'];  echo '";
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
     //$(\'#t\').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for buyer!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_buyer_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data==\'1\'){
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
     //$(\'#t\').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for seller!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_seller_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data==\'1\'){
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
					    var itemList=\'You are about to mark following items as shipped \\n\';
                        var obj = JSON.parse(data);
						var count = obj.length;
						for(var i=0;i<count;i++){
						  itemList += \'Poster Title: \'+obj[i].poster_title +\' (\' + obj[i].auction_type + \')\' + \'\\n\';
						}
						if(confirm(itemList)){
						   $.get("admin_manage_auction_week.php", { mode:"mark_shipped_buyer_invoice","invoice_id": id},
							function(data) {
							if(data==\'1\'){
								alert("Successfully invoice(s) are marked as shipped.");
								$(".changeStatus_"+id).attr(\'src\',"';  echo @CLOUD_STATIC_ADMIN;  echo 'shipped.png");
							}else{
								alert("Invoices are not marked as shipped.");
							}
						  });
						}
                    });
     	
        

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
		function fancy_images(i){
			$("#various_"+i).fancybox({
    		\'width\': 390,
    		\'height\': 400,
			\'onClosed\': function() {
    		parent.location.reload(true);
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
					<form action="" method="get" onsubmit="return test();">
					<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" >
							
							<tr>
								<td class="bold_text" align="center" colspan="2" >
									
                                    	<input type="hidden" name="mode" value="fixed" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
										    <option value="" selected="selected">Select Status</option>
                                        	<option value="all" <?php if ($this->_tpl_vars['search'] == 'all'): ?>selected="selected"<?php endif; ?> >All</option>
											<option value="selling" <?php if ($this->_tpl_vars['search'] == 'selling'): ?>selected="selected"<?php endif; ?>>Selling</option>
                                            <option value="pending" <?php if ($this->_tpl_vars['search'] == 'pending'): ?>selected="selected"<?php endif; ?>>Pending</option>
                                            <option value="sold" <?php if ($this->_tpl_vars['search'] == 'sold'): ?>selected="selected"<?php endif; ?>>Sold</option>
                                            <option value="unpaid" <?php if ($this->_tpl_vars['search'] == 'unpaid'): ?>selected="selected"<?php endif; ?>>Unpaid</option>
											<option value="seller_pending" <?php if ($this->_tpl_vars['search'] == 'seller_pending'): ?> selected="selected"<?php endif; ?>>Sale Pending</option>
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
											<option value="poster_title" <?php if ($this->_tpl_vars['sort_type'] == 'poster_title'): ?> selected="selected"<?php endif; ?>>Poster Title(A-Z)</option>						
											<option value="poster_title_desc" <?php if ($this->_tpl_vars['sort_type'] == 'poster_title_desc'): ?> selected="selected"<?php endif; ?>>Poster Title(Z-A)</option>
											<option value="seller" <?php if ($this->_tpl_vars['sort_type'] == 'seller'): ?> selected="selected"<?php endif; ?> >Seller(A-Z)</option>										
											<option value="seller_desc" <?php if ($this->_tpl_vars['sort_type'] == 'seller_desc'): ?> selected="selected"<?php endif; ?>>Seller(Z-A)</option>
											<option value="buyer" <?php if ($this->_tpl_vars['sort_type'] == 'buyer'): ?> selected="selected"<?php endif; ?> >Buyer(A-Z)</option>										
											<option value="buyer_desc" <?php if ($this->_tpl_vars['sort_type'] == 'buyer_desc'): ?> selected="selected"<?php endif; ?>>Buyer(Z-A)</option>
											
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
											<td align="center" class="headertext" width="8%">Poster</td>

											<td align="center" class="headertext" width="12%">Seller</td>
                                            <td align="center" class="headertext" width="6%">Ask Price</td>
                                            <td align="center" class="headertext" width="10%">Offer Price</td>
                                            <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'selling' || $_REQUEST['search'] == 'pending'): ?><td align="center" class="headertext" width="8%">Status</td><?php endif; ?>
											<td align="center" class="headertext" width="15%">Action</td>
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
												
                                                <td align="center" class="smalltext" >

                                                <img src="<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['image_path']; ?>
" style="cursor:pointer;" onclick="javascript:window.open('<?php echo $this->_tpl_vars['actualPath']; ?>
/auction_images_large.php?mode=auction_images_large&id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_id']; ?>
','mywindow','menubar=1,resizable=1,width=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['img_width']+100; ?>
,height=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['img_height']+100; ?>
,scrollbars=yes')" /><br /><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
												
												<td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
												<td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                                <td align="center" class="smalltext"><?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_reserve_offer_price'] > 0): ?>Will consider offers<?php else: ?>--<?php endif; ?></td>
                                                <?php if ($_REQUEST['search'] == '' || $_REQUEST['search'] == 'selling' || $_REQUEST['search'] == 'pending'): ?>
                                                <td id="td_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" align="center" class="smalltext">
													<?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == 0): ?>
														<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
, 1, '<?php echo $_REQUEST['search']; ?>
', 'fixed');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
, 2, '<?php echo $_REQUEST['search']; ?>
', 'fixed');" title="Disapprove" class="changeStatus" />
													<?php elseif ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == 1): ?>
														Approved &nbsp;&nbsp;
														<?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_sold'] == 0): ?>
														<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
, 2, '<?php echo $_REQUEST['search']; ?>
', 'fixed');" title="Disapprove" class="changeStatus" />
														<?php endif; ?>
                                                    <?php else: ?>
                                                    	Disapproved
													<?php endif; ?>
												</td>
                                                <?php endif; ?>
												<td align="center" class="bold_text">
                                                                                                	<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" /></a>
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=delete_auction&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
', 'auction','<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
'); return false;"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Auction" title="Delete Auction" border="0" class="changeStatus" /></a> 
                                                                                                 <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                    <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" class="changeStatus" /></a>&nbsp;&nbsp;-->
                                             		<?php if ($this->_tpl_vars['search'] == 'selling' || $this->_tpl_vars['search'] == 'sold' || $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_is_approved'] == '1'): ?><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_details_offer&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a><?php endif; ?>
													<?php if ($this->_tpl_vars['search'] == 'sold'): ?>
													<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Manage Invoice" title="Manage Invoice Buyer" border="0" class="changeStatus" width="20px" /></a>
													&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice_seller&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
													 <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
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
													&nbsp;&nbsp;
													<?php if ($this->_tpl_vars['search'] == 'sold'): ?>
													<?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['is_shipped'] == '1'): ?>
														<a href="javascript:void(0)"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
shipped.png" alt="Combined" title="Shipped on <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['shipped_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
" class="changeStatus" > </a>
													<?php else: ?>
														<a href="javascript:void(0)"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
not_shipped.png" alt="Combined" title="Not Shipped" class="changeStatus_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['invoice_id']; ?>
" onclick="mark_shipped_buyer_invoice('<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['invoice_id']; ?>
')"></a>
													<?php endif; ?>
													<?php endif; ?>
													<?php if ($this->_tpl_vars['search'] == 'selling' && $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['is_big'] == '1'): ?>
													<input type="checkbox" name="home_slider" id="home_slider_<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" value="<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
" onclick="set_for_homepage(this.value)" <?php if ($this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['is_set_for_home_big_slider'] == '1'): ?> checked="checked" <?php endif; ?> />
													<?php endif; ?>
													<?php if ($this->_tpl_vars['search'] == 'selling'): ?>
													<a id="various_<?php echo $this->_sections['counter']['index']; ?>
" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/admin_myselling.php?mode=move_to_weekly&id=<?php echo $this->_tpl_vars['auctionRows'][$this->_sections['counter']['index']]['auction_id']; ?>
"><input type="button" id="<?php echo $this->_sections['counter']['index']; ?>
" onclick="fancy_images(this.id)" class="track-btn" value="Move to weekly" /></a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endfor; endif; ?>
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="4" class="headertext"><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
											<td align="right" <?php if ($_REQUEST['search'] == 'fixed_price'): ?>colspan="2"<?php else: ?>colspan="5"<?php endif; ?> class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
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
					<?php if ($this->_tpl_vars['search'] != ''): ?>
						<td align="center" class="err">There is no auctions in database.</td>
				    <?php else: ?>
				    	<td align="center" class="err">Please select a status.</td>		
			        <?php endif; ?>			
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
<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:40:08
  from '/var/www/html/admin_templates/admin_access_cust_info_seller.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698778f8b2ccb6_57766090',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '18cd475262a7679312fa9922dc0fd01c416b77d2' => 
    array (
      0 => '/var/www/html/admin_templates/admin_access_cust_info_seller.tpl',
      1 => 1491762662,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698778f8b2ccb6_57766090 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
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
		$(function() {
			$("#start_date").datepick();
			$("#end_date").datepick();
		});
	});
	function viewInvoiceDetails(invoice_id,inv_no){
	    //var inv_no = parseInt(inv_no);
		var invoiceid = " (Invoice - "+inv_no+")";
		//alert(inv_no);
		$("#invoice").text(invoiceid);
		$('#righttable').html("<table cellpadding='0' cellspacing='0' width='100%' class='Container'  align='center'><tr><td align='center' ><img id='img' alt='' src='https://c4808190.ssl.cf2.rackcdn.com/ajax-loading.gif'  /></tr></td></table>");		
		
		$.get("admin_access_cust_info.php?mode=fetch_invoice", { invoice_id :invoice_id },
			function(data) {				
                $("#righttable").html(data);				
			});
		
	}
	function autocom(q){
	var url = "../ajax.php?mode=autocomplete_admin&q=" + q;
	jQuery.ajax({
  	type : 'GET',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	  if(data!=''){
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else{
		$("#auto_load").hide();
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	} 
	function set_result(name,id){
		document.getElementById('user').value=name;
		document.getElementById('user_id').value=id;
		$("#auto_load").hide();
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
  function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':	            	
		                $(this).val('');
		                break;    
		            
		        }
		    });
		    
		}
	function view_all(){
  	window.location.href="admin_access_cust_info.php?mode=seller";
  }	
  function fancy_images(){
    $("#various").fancybox({
        'width'				: '75%',
        'height'			: '80%',
        'autoScale'			: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe'
    });
}
  function view_seller(id){
    window.location.href="admin_report_manager.php?mode=auction_report&search=reconciliation&user_id="+id;
  }
  function notify_buyer(){
        var is_notify=confirm("Are you sure to reissue the invoice?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_auction_manager.php?mode=notify_buyer", {invoice_id :invoice_id },
                    function(data) {
                            alert("Successfully issued.");

                    });
        }
  }
  function markPaid(){
  	var is_notify=confirm("Are you sure to mark the invoice as paid?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_manage_auction_week.php?mode=mark_paid_seller_invoice", {invoice_id :invoice_id },
                    function(data) {
					      if(data==1){
						        $("#paid").hide();
								alert("Successfully marked as Paid.");
							}else{
								alert("Falied to mark as Paid.");
							}

                    });
        }
  }
  function markShipped(){
  	var is_notify=confirm("Are you sure to mark the invoice as shipped?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_manage_auction_week.php?mode=mark_shipped_buyer_invoice", {invoice_id :invoice_id },
                    function(data) {
					    if(data==1){
						$("#shipped").hide();
                            alert("Successfully marked as Shipped.");
						 }else{
							alert("Falied to mark as Shipped.");
						 }

                    });
        }
  }
  function editNote(){
  	var note=$("#note").text();
	$("#note").html('<textarea id="niteText">'+note+'</textarea>');
  }
  
  function updateNote(){
  	var note=$("#niteText").val();
	if(note!=''  || note!='undefined'){
			var invoice_id=$("#invoice_id").val();
            var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=add_note", {invoice_id :invoice_id ,auction_id:auction_id,note:note},
                    function(data) {
							$("#note").text(note);
                            alert("Successfully note updated.");
                    });
		}else{
			alert("Please update note");
		}
  }
  
  function print_all(){
  	var selected = [];
	$('.altbg input:checked').each(function() {
		selected.push($(this).attr('value'));
	});
	if(selected.length >0){
		window.open("/admin/admin_auction_manager.php?mode=invoice_bulk&invoice_Arr="+selected);
	}
  }
  
  function reset(){
   if(confirm("Confirm Reset to $0")){
		$.get("admin_access_cust_info.php?mode=mark_shipping_claimed",
			function(data) {								
					alert("Successfully reset to $0.");				 
			});
		$("#total_shipping").val('$0')
	}
  }
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
        <tr id="errorMessage">
          <td width="90%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
        </tr>
        <?php }?>
        <tr>
          <td width="100%"><form action="" method="get" onsubmit="return test();">
		     <input type="hidden" name="mode" value="seller" >
              <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor cutomersection" >
                <tr class="">
                  <td  align="left" style="width:130px;"><label>Customer Name</label>
                    <div class="UserNameSearch" style="position:relative;">
                      <div>
                        <input type="text" name="user" id="user"  class="look inputBox_long" value="<?php echo $_REQUEST['user'];?>
"  onkeyup="autocom(this.value);" />
                      </div>
                      <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
                      <input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['user_id'];?>
"  class="look inputBox_long"/>
                      <span class="err"><?php echo $_smarty_tpl->tpl_vars['user_id_err']->value;?>
</span> </div>
                    <!--<label class="rightaligned">Type</label>
                    <select>
                      <option>Buyer</option>
                    </select>-->
                  </td>
                </tr>
                <tr>
                  <td><label>Filter by Date</label>
                    <label class="small">From</label>
                    <input type="text" id="start_date" name="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date_show']->value;?>
"  class="look inputBox_small"/>
                    <label class="small">to</label>
                    <input type="text" id="end_date" name="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date_show']->value;?>
"  class="look inputBox_small"/>
					<label class="small">Type</label>
					<select name="invoice_type">
						<option value="">Select</option>
						<option value="paid" <?php if ($_REQUEST['invoice_type'] == 'paid') {?>selected='selected'<?php }?>>Paid</option>
						<option value="unpaid" <?php if ($_REQUEST['invoice_type'] == 'unpaid') {?>selected='selected'<?php }?>>Unpaid</option>
						<option value="shipped" <?php if ($_REQUEST['invoice_type'] == 'shipped') {?>selected='selected'<?php }?>>Shipped</option>
						<option value="notshipped" <?php if ($_REQUEST['invoice_type'] == 'notshipped') {?>selected='selected'<?php }?>>Not Shipped</option>
					</select>
					<input type="submit" class="submitbtn" value="Submit" />
					<input type="button" class="submitbtn" value="Reset" onclick="reset_date(this.form)"/>
					<input type="button" class="submitbtn" value="View All" onclick="view_all()"/>
                  </td>
                </tr>
              </table>
			  </form>
              <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tr>
                  <td><div class="lefttable">
                      <h2>MPE Invoice History</h2>
					  <input type="button" class=" cutomersection submitbtn" value="Seller Info" onclick="view_seller(<?php echo $_smarty_tpl->tpl_vars['user_new_id']->value;?>
)"/>
					   <input type="button" class=" cutomersection submitbtn" value="Print All" onclick="print_all()"/>
					   <input onClick="setAllCheckboxes(this.id);" type="checkbox" id="them" />All of them
					   &nbsp&nbsp <input  value="$<?php echo $_smarty_tpl->tpl_vars['shipping']->value;?>
" readonly style="width:100px;" id="total_shipping" /> <input type="button" class="submitbtn" value="Reset" onclick="reset()"/>
                      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="smallTable">
                        <tr>
						  <th width="45%">Invoice Number</th>
                          <th style="width:25%;">Date</th>                          
                          <th>Customer</th>
                          <th>Amount</th>
                        </tr>
                        <tr>
                          <td colspan="4" style="padding:5px 0;"><div class="scroll"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['invoiceData']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?> 
                              <tr class="altbg">
                                <td style="width:45%;"><input type="checkbox" name="inv" class="inv" value="<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id'];?>
"  />&nbsp;<a href="javascript:void(0)" onclick="viewInvoiceDetails(<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id'];?>
,'<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_actual_end_datetime'],"%m%d%Y");?>
-<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['inv_no'];?>
')"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_actual_end_datetime'],"%m%d%Y");?>
-<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['inv_no'];?>
 </a>
								<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_combined'] == '1') {?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
combined.png" alt="Combined" title="Combined">
									<?php } else { ?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_combined.png" alt="Combined" title="Not Combined">
								<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_approved'] == '1' || $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_paid'] == '1') {?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
approved.png" alt="Combined" title="Approved">
									<?php } else { ?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_approved.png" alt="Combined" title="Not Approved">
								<?php }?>
								&nbsp;
								<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_paid'] == '1') {?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
paid.png" alt="Combined" title="Paid on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['paid_on'],"%m/%d/%Y");?>
">
								<?php } else { ?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
unpaid.png" alt="Combined" title="Not Paid">
								<?php }?>
								&nbsp;
								<?php if ($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_shipped'] == '1') {?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
shipped.png" alt="Combined" title="Shipped on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['shipped_date'],"%m/%d/%Y");?>
">
									<?php } else { ?>
									<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_shipped.png" alt="Combined" title="Not Shipped">
								<?php }?>
								</td>
								
                                <td style="width:25%;">&nbsp;<?php if ($_REQUEST['invoice_type'] == 'paid') {?> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['paid_on'],"%m/%d/%Y");
} else {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_generated_on'],"%m/%d/%Y");?>
 <?php }?></td>
                                <td style="width:20%;"><?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</td>
                                <td style="width:10%;">$<?php echo $_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['total_amount'];?>
</td>
                              </tr>
							  <?php $_smarty_tpl->_assignInScope('total', $_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['invoiceData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['total_amount']);?>
                           <?php
}
}
?>   
                            </table></div></td>
                        </tr>
                      </table>
					  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="smallTable">
					  <tr class="bgcolr">
                        	<td align="right" colspan="4" >Overall Purchase Total</td>
                            <td align="right">$<?php echo number_format($_smarty_tpl->tpl_vars['total']->value,2);?>
&nbsp;&nbsp;</td>
                        </tr>
					  <tr class="header_bgcolor" height="26">
							<!--<td align="left" class="smalltext">&nbsp;</td>-->
							<td align="left" colspan="4" class="headertext"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
							<td align="right" <?php if ($_REQUEST['search'] == 'fixed_price') {?>colspan="2"<?php } else { ?>colspan="5"<?php }?> class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
						</tr>
					  </table>
                    </div>
                    <div class="righttable" >
                    	<h2>Invoice Details <span id="invoice"> </span></h2>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="smallTable" id="righttable">
                       
                        </table>
                    </div></td>
                </tr>
                <tr>
                  <td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top"></td>
                </tr>
              </table>
            </td>
        </tr>
        
      </table></td>
  </tr>
</table>

<?php echo '<script'; ?>
>
function setAllCheckboxes(id){

var val = $("#"+id).val();
if( $("#"+id).is(":checked") ) {
	$('.inv').each(function(){ //iterate all listed checkbox items
        this.checked = true; //change ".checkbox" checked status
    });	
}
else {
	$('.inv').each(function(){ //iterate all listed checkbox items
        this.checked = false; //change ".checkbox" checked status
    });
}

}
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

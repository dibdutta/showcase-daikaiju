<?php /* Smarty version 2.6.14, created on 2018-01-07 10:40:41
         compiled from admin_manage_invoice.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_manage_invoice.tpl', 290, false),array('modifier', 'number_format', 'admin_manage_invoice.tpl', 377, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/fancybox/jquery-min.js"></script>
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

<!--<link rel="stylesheet" href="{$actualPath}/javascript/fancybox/style.css" />-->


<script type="text/javascript">
function checkFloaNumber(number){
    aPosition = number.indexOf(".");
    return aPosition;
}
function fancy_images(){
    $("#various").fancybox({
        \'width\'				: \'75%\',
        \'height\'			: \'80%\',
        \'autoScale\'			: false,
        \'transitionIn\'		: \'none\',
        \'transitionOut\'		: \'none\',
        \'type\'				: \'iframe\'
    });
}


$(document).ready(function() {
    $("#add_charge").click(function(){
        var invoice_id=$("#invoice_id").val();
        var charge_desc=$("#charge_desc").val();
        var charge_amnt=$("#charge_amnt").val().replace(/^\\s\\s*/, \'\').replace(/\\s\\s*$/, \'\');
        var last_total_amnt=$("#total_cost_amnt").val();
        var chk_ind=/^ *[0-9]+ *$/.test(charge_amnt);
        if(charge_desc!=\'\'){
            if (!isNaN(charge_amnt) && charge_amnt !=\'\'){
                amountLength = 5;
                aPosition = checkFloaNumber(charge_amnt);
                if(aPosition != "-1"){
                    amountLength = 6;
                }
                if(charge_amnt.length <=amountLength){
                    var new_total_amnt=parseFloat(last_total_amnt) + parseFloat(charge_amnt);
                    $.get("admin_auction_manager.php?mode=update_invoice_charge", { charge_desc: charge_desc, charge_amnt: charge_amnt,invoice_id :invoice_id },
                            function(data){
                                $(\'#new_charges\').append(data);
                            });
                    //$("#total_cost_amnt").val()= new_total_amnt;
                    document.getElementById(\'total_cost_amnt\').value=new_total_amnt;
                    var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
                    $("#new_total_amnt").text(amnt_in_dollar);
                    $("#charge_desc").val(\'\');
                    $("#charge_amnt").val(\'\');
                }else{
                    $("#charge_amnt").focus();
                    alert("Please provide a proper numeric number less than six digit");
                }

            }else{
                $("#charge_amnt").focus();
                alert("Please provide a proper numeric number for charge amount");
            }
        }else{
            $("#charge_desc").focus();
            alert("Please provide a description for charge");
        }
    });

    $("#add_discount").click(function(){
        var invoice_id=$("#invoice_id").val();
        var discount_desc=$("#discount_desc").val();
        var discount_amnt=$("#discount_amnt").val().replace(/^\\s\\s*/, \'\').replace(/\\s\\s*$/, \'\');
        var last_total_amnt=$("#total_cost_amnt").val();
        var chk_ind=/^ *[0-9]+ *$/.test(discount_amnt);
        if(discount_desc!=\'\'){
            if (!isNaN(discount_amnt) && discount_amnt !=\'\'){
                amountLength = 5;
                aPosition = checkFloaNumber(discount_amnt);
                if(aPosition != "-1"){
                    amountLength = 6;
                }
                if(discount_amnt.length <= amountLength){
                    var new_total_amnt=parseFloat(last_total_amnt) - parseFloat(discount_amnt);
                    $.get("admin_auction_manager.php?mode=update_invoice_discount", { discount_desc: discount_desc, discount_amnt: discount_amnt,invoice_id :invoice_id },
                            function(data){
                                $(\'#new_charges\').append(data);
                            });
                    //$("#total_cost_amnt").val()= new_total_amnt;
                    document.getElementById(\'total_cost_amnt\').value=new_total_amnt;
                    var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
                    $("#new_total_amnt").text(amnt_in_dollar);
                    $("#discount_desc").val(\'\');
                    $("#discount_amnt").val(\'\');
                }else{
                    $("#discount_amnt").focus();
                    alert("Please provide a proper numeric number less than six digit");
                }

            }else{
                $("#discount_amnt").focus();
                alert("Please provide a proper numeric number for discount amount");
            }
        }else{
            $("#discount_desc").focus();
            alert("Please provide a description for discount");
        }
    });

    $("#approve").click(function(){
        var is_approve=confirm("Are you sure to approve?");
        if(is_approve){
            var invoice_id=$("#invoice_id").val();
			var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=approve_invoice", {invoice_id :invoice_id,auction_id:auction_id },
                    function(data) {
                        $("#track_is_approved1").hide();
                        $("#track_is_approved2").hide();
                        $("#track_is_approved3").hide();
                        $("#track_is_approved4").hide();
                        $("#approved_btn").hide();
                        $("#jst_approve").show();
                        $("#invoice_approved").show();
                        $("#invoice_not_approved_on").hide();
                        $(".del_img").hide();
                        $(".del_ind").hide();
                    });
        }

    });
    $("#cancel").click(function(){
        var is_cancel=confirm("Are you sure to cancel?");
        if(is_cancel){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_auction_manager.php?mode=cancel_invoice", {invoice_id :invoice_id },
                    function(data) {
                        $("#approved").hide();
                        $("#mark_as_paid").hide();
                        $("#cancel").hide();
                        $("#canceled").show();
                        //$("#cancel_auction").show();
                        $("#invoice_approved").hide();
                        $("#invoice_approved_on").hide();
                        $("#jst_approve").hide();
                        $("#invoice_cancelled").show();
                        $(".del_img").hide();
                        $(".del_ind").hide();
                    });
        }

    });
    $("#mark_as_paid").click(function(){
        var is_cancel=confirm("Are you sure to mark as paid?");
        if(is_cancel){
            var invoice_id=$("#invoice_id").val();
            var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=mark_as_paid_invoice", {invoice_id :invoice_id ,auction_id:auction_id},
                    function(data) {
                        $("#cancel").hide();
                        $("#mark_as_paid").hide();
                        $("#mark_as_canceled").show();
                        $("#invoice_approved_on").hide();
                        $("#mark_invoice_paid").show();
                        $(".del_img").hide();
                        $(".del_ind").hide();
                    });
        }

    });
	$("#notify_buyer").click(function(){
        var is_notify=confirm("Are you sure to reissue the invoice?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=notify_buyer", {invoice_id :invoice_id ,auction_id:auction_id},
                    function(data) {
                            alert("Successfully issued.");

                    });
        }
    });
	
	$("#add_note").click(function(){
		var note=$("#note").val();	
		if(note!=\'\'){
			var invoice_id=$("#invoice_id").val();
            var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=add_note", {invoice_id :invoice_id ,auction_id:auction_id,note:note},
                    function(data) {
                            alert("Successfully added.");

                    });
		}
	})

});

function del_charge(id){
    var is_delete=confirm("Are you sure to delete?");
    if(is_delete){
        $(".del_img").show();
        $(".del_ind").hide();
        var invoice_id=$("#invoice_id").val();
        var deletd_amnt=$("#input_"+id).val();
        var deleted_desc=$("#desc_"+id).val();
        var last_total_amnt=$("#total_cost_amnt").val();
        var new_total_amnt=parseFloat(last_total_amnt) - parseFloat(deletd_amnt);
        document.getElementById(\'total_cost_amnt\').value=new_total_amnt;
        var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
        $("#new_total_amnt").text(amnt_in_dollar);
        $.get("admin_auction_manager.php?mode=delete_invoice_charge", { charge_desc: deleted_desc, charge_amnt: deletd_amnt,invoice_id :invoice_id },
                function(data){
                    $(".del_img").hide();
                    $(".del_ind").show();
                    $("#tr_"+id).remove();
                });
    }
}

function del_discount(id)
{
    var is_delete=confirm("Are you sure to delete?");
    if(is_delete){
        $(".del_img").show();
        $(".del_ind").hide();
        var invoice_id=$("#invoice_id").val();
        var deletd_amnt=$("#input_"+id).val();
        var deleted_desc=$("#desc_"+id).val();
        var last_total_amnt=$("#total_cost_amnt").val();
        var new_total_amnt=parseFloat(last_total_amnt) + parseFloat(deletd_amnt);
        document.getElementById(\'total_cost_amnt\').value=new_total_amnt;
        var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
        $("#new_total_amnt").text(amnt_in_dollar);
        $.get("admin_auction_manager.php?mode=delete_invoice_discount", { discount_desc: deleted_desc, discount_amnt: deletd_amnt,invoice_id :invoice_id },
                function(data) {
                    $(".del_img").hide();
                    $(".del_ind").show();
                    $("#tr_"+id).remove();
                });
    }
}
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
    <tr>
        <td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
    </tr>
<?php endif; ?>
    <tr>
        <td width="100%" align="center"><a href="#" onclick="history.back();" class="action_link"><strong>&lt;&lt; Back</strong></a>
        <?php if ($this->_tpl_vars['key'] != '1'): ?>&nbsp;
            <a id="various" href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_auction_manager.php?mode=manage_invoice_seller_print&invoice_id=<?php echo $this->_tpl_vars['invoiceData']['invoice_id']; ?>
">
                <img alt="Print" title="Print" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
print_invoice.jpg" onclick="fancy_images()" style="float: right;" width="60px" border="0"></a>
        <?php endif; ?>
        </td>
    </tr>
<?php if ($this->_tpl_vars['key'] != '1'): ?>
    <tr>
        <td align="center" >
            <form name="listFrom" id="listForm" action="" method="post">
                <input type="hidden" id="invoice_id" value="<?php echo $this->_tpl_vars['invoiceData']['invoice_id']; ?>
">
				<input type="hidden" id="auction_id" value="<?php echo $_REQUEST['auction_id']; ?>
">
                <table align="center" width="60%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCCCCC;">
                    <?php if ($this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                        <tr class="header_bgcolor" height="26" id="track_is_approved1">
                            <td colspan="2" class="headertext"><b>&nbsp;Add Charges</b></td>
                        </tr>
                        <tr class="bgcolor" height="26" id="track_is_approved2">
                            <td align="left">&nbsp;Desc:&nbsp;<input type="text" maxlength="50" id="charge_desc" name="charge_desc" class="look" /></td>
                            <td align="left">&nbsp;Amount:&nbsp;&nbsp;<input type="text" maxlength="6" id="charge_amnt" name="charge_amnt" class="look-price" />&nbsp;<img id="add_charge" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
add_images.jpg"></td>
                        </tr>
                        <tr class="header_bgcolor" height="26" id="track_is_approved3">
                            <td colspan="2" class="headertext"><b>&nbsp;Add Discount</b></td>
                        </tr>
                        <tr class="bgcolor" height="26" id="track_is_approved4">
                            <td align="left">&nbsp;Desc:&nbsp;<input type="text" maxlength="50" id="discount_desc" name="charges" class="look" /></td>
                            <td align="left">&nbsp;Amount:&nbsp;&nbsp;<input type="text" maxlength="6" id="discount_amnt" name="charges" class="look-price" />&nbsp;<img id="add_discount" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
add_images.jpg"></td>
                        </tr>
                    <?php endif; ?>
					<tr class="header_bgcolor" height="26" id="track_is_approved3">
							<td class="headertext"><b>&nbsp;Add Note</b></td>
							<td  class="headertext"><b>&nbsp;Invoice Id</b></td>
					</tr>
					<tr class="bgcolor" height="26" id="track_is_approved4">
							<td align="left">&nbsp;Note:&nbsp;<textarea name="note" id="note"><?php echo $this->_tpl_vars['invoiceData']['note']; ?>
</textarea>&nbsp;<img id="add_note" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
add_images.jpg"></td>
							<td align="left">&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['auction_actual_end_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m%d%Y") : smarty_modifier_date_format($_tmp, "%m%d%Y")); ?>
-<?php echo $this->_tpl_vars['invoiceData']['invoice_id']; ?>
 </td>
								
					</tr>
                    <tr class="header_bgcolor" height="26">
                        <td colspan="2" class="headertext"><b>&nbsp;Invoice Details</b></td>
                    </tr>
                    <tr height="26">
                                            <td align="left" colspan="1">&nbsp;Date of Order: <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['invoice_generated_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
                        <td align="left" style="display:none;"  id="invoice_cancelled">Invoice Status:<font style="color:red;"> Cancelled</font></td>
                        <td align="left"  id="invoice_not_approved" style="display:none;">Invoice Status: Not Approved</td>
                        <td align="left" style="display:none;" id="invoice_approved">Invoice Status:<font style="color:green;"> Approved</font></td>
                        <td align="left" style="display:none;" id="mark_invoice_paid">Invoice Status:<font style="color:green;"> Paid</font></td>
                        <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '1' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                            <td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:black;">Approved</font></td>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                            <td align="left"  id="invoice_not_approved_on"><strong>Invoice Status: </strong><font style="color:red;"> Not Approved</font></td>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '1' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '1'): ?>
                            <td align="left"   id="invoice_cancelled"><strong>Invoice Status: </strong> <font style="color:red;">Cancelled</font></td>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '1' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '1'): ?>
                            <td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;"> Paid</font></td>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '1'): ?>
                            <td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;">Paid</font> </td>
                        <?php endif; ?>
                    </tr>
					<?php if ($this->_tpl_vars['invoiceData']['is_paid'] == '1'): ?> 
						<tr height="26">                                
							<td align="left" colspan="2">&nbsp;Date paid: <?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['paid_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td> 
						</tr> 
					<?php endif; ?> 
                    <tr height="26">
                        <td align="left">
                            <b>&nbsp;Shipping Address</b><br />
                            &nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_lastname']; ?>
<br/>
                            &nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_address1'];  if ($this->_tpl_vars['invoiceData']['shipping_address']['shipping_address2'] != ''): ?>, <?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_address2'];  endif; ?>
                            <br />&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_city']; ?>
&nbsp;
                            <?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_state']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['shipping_address']['shipping_zipcode']; ?>
<br />
                        </td>
                        <td align="left">
                            <b>Billing Address</b><br />
                            <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_lastname']; ?>
<br/>
                            <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_address1'];  if ($this->_tpl_vars['invoiceData']['billing_address']['billing_address2'] != ''): ?>, <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_address2'];  endif; ?>
                            <br /><?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_city']; ?>
&nbsp;
                            <?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_state']; ?>
&nbsp;<?php echo $this->_tpl_vars['invoiceData']['billing_address']['billing_zipcode']; ?>
<br />
                        </td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td align="left" colspan="2">
                            <table border="0" width="100%" align="left" cellpadding="2" cellspacing="0" class="invoice-main">
                                <tr>
                                    <th align="left" width="25%">Item</th>
                                    <th align="left" width="50$">Title</th>
                                    <th align="left" width="25%">Price</th>
                                </tr>
                                <tr><td colspan="3">&nbsp;</td></tr>
                                <?php $this->assign('seller_username', ''); ?>
									<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['auction_details']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
									<?php if ($this->_tpl_vars['chk_item_type'] == '1'): ?>									
									  <?php if ($this->_tpl_vars['seller_username'] != $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']): ?>
									  <?php if ($this->_tpl_vars['seller_username'] != ''): ?>	
										
										<tr>
										<td align="right" colspan="2" class="billbrdr">Shiiping Charge:</td>
										<?php if ($this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'Canada' || $this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'United States'): ?>
											<td align="left" class="billbrdr">$15</td>
											<?php $this->assign('ship_new_chrg', $this->_tpl_vars['ship_new_chrg']+15); ?>
										<?php else: ?>
											<td align="left" class="billbrdr">$21</td>
											<?php $this->assign('ship_new_chrg', $this->_tpl_vars['ship_new_chrg']+21); ?>
										<?php endif; ?>
										
										
										</tr>
									  <?php endif; ?>
										<tr><td colspan="3" class="billbrdr">Seller : <?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']; ?>
</td></tr>
									  
									  <?php endif; ?>
									<?php elseif ($this->_tpl_vars['chk_item_type'] == '2'): ?>
										<?php if ($this->_tpl_vars['seller_username'] != $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']): ?>
											<?php if ($this->_tpl_vars['seller_username'] != ''): ?>	
												<tr>
													<td align="right" colspan="2"><b>Auction wise Total:</b></td>
													<td align="left">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auction_wise_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
												</tr>
											<?php endif; ?>
											<tr><td colspan="3" class="billbrdr"><b>Auction :</b> <?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']; ?>
</td></tr>
											<?php $this->assign('auction_wise_total', 0); ?>
										<?php endif; ?>
									<?php endif; ?>
                                    <tr>
                                        <td align="left">#<?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                                        <td align="left"><?php echo $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['poster_title']; ?>
</td>
                                        <td align="left">$<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                    </tr>
                                    <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount']); ?>
									<?php if ($this->_tpl_vars['chk_item_type'] == '1' || $this->_tpl_vars['chk_item_type'] == '4'): ?>
										<?php $this->assign('seller_username', $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']); ?>
									<?php elseif ($this->_tpl_vars['chk_item_type'] == '2'): ?>
										<?php $this->assign('seller_username', $this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['seller_username']); ?>
										<?php $this->assign('auction_wise_total', $this->_tpl_vars['auction_wise_total']+$this->_tpl_vars['invoiceData']['auction_details'][$this->_sections['counter']['index']]['amount']); ?>
									<?php endif; ?>
                                <?php endfor; endif; ?>
								<?php if ($this->_tpl_vars['chk_item_type'] == '1' || $this->_tpl_vars['chk_item_type'] == '4'): ?>
									<tr>
									<td align="right" colspan="2" class="billbrdr">Shiiping Charge:</td>
									<?php if ($this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'Canada' || $this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'United States'): ?>
										<td align="left" class="billbrdr">$15.00</td>
									<?php else: ?>
										<td align="left" class="billbrdr">$21.00</td>
									<?php endif; ?>
									</tr>
									<?php if ($this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'Canada' || $this->_tpl_vars['invoiceData']['shipping_address']['shipping_country_name'] == 'United States'): ?>
										<?php $this->assign('ship_new_chrg', $this->_tpl_vars['ship_new_chrg']+15); ?>
									<?php else: ?>
										<?php $this->assign('ship_new_chrg', $this->_tpl_vars['ship_new_chrg']+21); ?>
									<?php endif; ?>
								<?php else: ?>	
									<tr>
										<td align="right" colspan="2"><b>Auction wise Total:</b></td>
										<td align="left">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auction_wise_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
									</tr>
								<?php endif; ?>
                                <tr>
                                    <td align="right" colspan="2"><b>Subtotal</b></td>
                                    <td align="left">$<?php echo ((is_array($_tmp=$this->_tpl_vars['subTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                </tr>
                                <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['additional_charges']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <tr id='tr_del_charge_<?php echo $this->_sections['counter']['index']; ?>
'>
                                        <td align="right" ><?php if ($this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                            &nbsp;
                                            <img src='<?php echo @CLOUD_STATIC_ADMIN; ?>
del_ind.jpg' style="display:none;" class="del_img">
                                            <img src='<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_charge.jpg' id='del_charge_<?php echo $this->_sections['counter']['index']; ?>
' class="del_ind" title='Delete' onclick='del_charge(this.id)'><?php else: ?>&nbsp;<?php endif; ?></td>
                                        <td align="right" >
                                            <input type='hidden' name='desc_del_charge_<?php echo $this->_sections['counter']['index']; ?>
' id='desc_del_charge_<?php echo $this->_sections['counter']['index']; ?>
' value="<?php echo $this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['description']; ?>
" />
                                            (+)&nbsp;<?php echo $this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['description']; ?>
</td>
                                        <td align="left">
                                            <input type='hidden' name='input_del_charge_<?php echo $this->_sections['counter']['index']; ?>
' id='input_del_charge_<?php echo $this->_sections['counter']['index']; ?>
' value='<?php echo $this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['amount']; ?>
' />
                                            $<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                    </tr>
                                    <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['additional_charges'][$this->_sections['counter']['index']]['amount']); ?>
                                <?php endfor; endif; ?>
                                <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['invoiceData']['discounts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <tr id='tr_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
'>
                                        <td align="right" ><?php if ($this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                            &nbsp;
                                            <img src='<?php echo @CLOUD_STATIC_ADMIN; ?>
del_ind.jpg' style="display:none;" class="del_img">
                                            <img  src='<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_charge.jpg' id='del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' class="del_ind" title='Delete' onclick='del_discount(this.id)'><?php else: ?>&nbsp;<?php endif; ?></td>
                                        <td align="right" >
                                            <input type='hidden' name='desc_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' id='desc_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' value="<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['description']; ?>
" />
                                            (-)&nbsp;<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['description']; ?>
</td>
                                        <td align="left">
                                            <input type='hidden' name='input_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' id='input_del_amnt_<?php echo $this->_sections['counter']['index']; ?>
' value='<?php echo $this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount']; ?>
' />
                                            $<?php echo ((is_array($_tmp=$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                    </tr>
                                    <?php $this->assign('subTotal', $this->_tpl_vars['subTotal']+$this->_tpl_vars['invoiceData']['discounts'][$this->_sections['counter']['index']]['amount']); ?>
                                <?php endfor; endif; ?>
                                <tr>
                                    <td id="new_charges" align="right" colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2"><b>Total</b></td>
                                    <td align="left" id="new_total_amnt"><?php if ($this->_tpl_vars['invoiceData']['additional_charges'] == '' && $this->_tpl_vars['invoiceData']['discounts'] == ''): ?>$<?php echo $this->_tpl_vars['subTotal']+$this->_tpl_vars['ship_new_chrg']; ?>
.000<?php else: ?>$<?php echo $this->_tpl_vars['invoiceData']['total_amount'];  endif; ?></td>
                                    <input type="hidden" id="total_cost_amnt" value="<?php echo $this->_tpl_vars['invoiceData']['total_amount']; ?>
"/>
                                </tr>
                                <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                    <tr style="height:40px;">
                                        <td align="left" colspan="3">&nbsp;NB: Shipping charges(and sales tax if you reside in GA or NC) will be applied at checkout. Please note that shipping charges may reflect the cost of separate packages(flat vs rolled).</td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['invoiceData']['is_approved'] == '0' && $this->_tpl_vars['invoiceData']['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                    <tr>
                                        <td colspan="3" align="center" id="approved_btn"><input type="button" name="Approve" value="Approve" id="approve" class="button"></td>
                                        <td  align="center" style="display:none" id="jst_approve" colspan="3"><input type="button" name="Approved" value="Cancel"  class="button" id="cancel">&nbsp;</td>
                                        <!--                               	 			 <td  colspan="3" align="center" style="display:none" id="cancel_auction"><input type="button" name="Canceled" value="Canceled" id="canceled" class="button" ></td>-->
                                    </tr>
                                    <?php elseif ($this->_tpl_vars['invoiceData']['is_approved'] == '1' && $this->_tpl_vars['invoiceData']['is_cancelled'] != '1' && $this->_tpl_vars['invoiceData']['is_paid'] == '0'): ?>
                                    <tr>
                                        <td  align="center" colspan="3">
                                            <input type="button" name="Cancel" value="Cancel" id="cancel" class="button">&nbsp;
                                            <input type="button" name="mark_as_paid" value="Mark as Paid" id="mark_as_paid" class="button">&nbsp;
											<input type="button" name="mark_as_paid" value="Notify Buyer" id="notify_buyer" class="button" >&nbsp;
                                            <input type="button" name="Canceled" value="Canceled" id="canceled" class="button" style="display: none;">
                                            <input type="button" name="mark_as_canceled" value="Paid" id="mark_as_canceled" class="button" style="display: none;">
                                        </td>
                                    </tr>

                                <?php endif; ?>
                            </table>
                        </td>
                    </tr>

            </form>
        </td>
    </tr>
    <?php else: ?>
    <tr>
        <td align="center">Sorry no invoice found for this auction.</td>
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
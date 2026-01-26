{include file="admin_header.tpl"}
 <script type="text/javascript" src="{$actualPath}/javascript/fancybox/jquery-min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="{$actualPath}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<!--<link rel="stylesheet" href="{$actualPath}/javascript/fancybox/style.css" />-->
 	{literal}
	<script type="text/javascript">
       
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
        $(document).ready(function() {
        	$("#add_charge").click(function(){
        		var invoice_id=$("#invoice_id").val();
        		var charge_desc=$("#charge_desc").val();
        		var charge_amnt=$("#charge_amnt").val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        		var last_total_amnt=$("#total_cost_amnt").val();
        		var chk_ind=/^ *[0-9]+ *$/.test(charge_amnt);
        		if(charge_desc!=''){
        			if (charge_amnt == parseFloat(charge_amnt) && chk_ind==true){
        				if(charge_amnt.length <=5){
        				var new_total_amnt=parseFloat(last_total_amnt) + parseFloat(charge_amnt);
        				$.get("admin_auction_manager.php?mode=update_invoice_charge", { charge_desc: charge_desc, charge_amnt: charge_amnt,invoice_id :invoice_id },
        				function(data){
        					$('#new_charges').append(data);
        				});
        				//$("#total_cost_amnt").val()= new_total_amnt;
        				document.getElementById('total_cost_amnt').value=new_total_amnt;
        				var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
        				$("#new_total_amnt").text(amnt_in_dollar);
        				$("#charge_desc").val('');
        				$("#charge_amnt").val('');
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
        		var discount_amnt=$("#discount_amnt").val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        		var last_total_amnt=$("#total_cost_amnt").val();
        		var chk_ind=/^ *[0-9]+ *$/.test(discount_amnt);
        		if(discount_desc!=''){
        			if (discount_amnt == parseFloat(discount_amnt) && chk_ind==true){
        				if(discount_amnt.length <=5){
        				var new_total_amnt=parseFloat(last_total_amnt) - parseFloat(discount_amnt);
        				$.get("admin_auction_manager.php?mode=update_invoice_discount", { discount_desc: discount_desc, discount_amnt: discount_amnt,invoice_id :invoice_id },
        				function(data){
        					$('#new_charges').append(data);
        				});
        				//$("#total_cost_amnt").val()= new_total_amnt;
        				document.getElementById('total_cost_amnt').value=new_total_amnt;
        				var amnt_in_dollar="$" + new_total_amnt.toFixed(2);
        				$("#new_total_amnt").text(amnt_in_dollar);
        				$("#discount_desc").val('');
        				$("#discount_amnt").val('');
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
        		$.get("admin_auction_manager.php?mode=approve_invoice", {invoice_id :invoice_id,sent_mail:1 },
        				function(data) {
        					$("#track_is_approved1").hide();
        					$("#track_is_approved2").hide();
        					$("#track_is_approved3").hide();
        					$("#track_is_approved4").hide();
        					$("#invoice_approved_on").hide();
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
        		document.getElementById('total_cost_amnt').value=new_total_amnt;
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
        		document.getElementById('total_cost_amnt').value=new_total_amnt;
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
 	{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
					<a href="{$actualPath}{$decoded_string}"  class="action_link"><strong>&lt;&lt; Back</strong></a>
					{if $key!='1'}&nbsp;
					<a id="various" href="{$smart.const.DOMAIN_PATH}/admin/admin_auction_manager.php?mode=manage_invoice_seller_print&invoice_id={$invoiceData.invoice_id}">
					<img alt="Print" title="Print" src="{$adminImagePath}/print_invoice.jpg" onclick="fancy_images()" style="float: right;" width="60px" border="0"></a>
					{/if}</td>
				</tr>
				
				{if $key!='1'}
                <tr>
                    <td align="center" >
                        <form name="listFrom" id="listForm" action="" method="post">
                        <input type="hidden" id="invoice_id" value="{$invoiceData.invoice_id}">
                            <table align="center" width="60%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCCCCC;">
                            	{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0'}
                            	<tr class="header_bgcolor" height="26" id="track_is_approved1">
									<td colspan="2" class="headertext"><b>&nbsp;Add Charges</b></td>
								</tr>
								<tr class="bgcolor" height="26" id="track_is_approved2">
									<td align="left">&nbsp;Desc:&nbsp;<input type="text" id="charge_desc" name="charge_desc" class="look" /></td>
                                    <td align="left">&nbsp;Amount:&nbsp;&nbsp;<input type="text" id="charge_amnt" name="charge_amnt" class="look" />&nbsp;<img id="add_charge" src="{$adminImagePath}/add_images.jpg"></td>
								</tr>
								<tr class="header_bgcolor" height="26" id="track_is_approved3">
									<td colspan="2" class="headertext"><b>&nbsp;Add Discount</b></td>
								</tr>
								<tr class="bgcolor" height="26" id="track_is_approved4">
									<td align="left">&nbsp;Desc:&nbsp;<input type="text" id="discount_desc" name="charges" class="look" /></td>
                                    <td align="left">&nbsp;Amount:&nbsp;&nbsp;<input type="text" id="discount_amnt" name="charges" class="look" /> &nbsp;<img id="add_discount" src="{$adminImagePath}/add_images.jpg"></td>
								</tr>
								{/if}
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="headertext"><b>&nbsp;Invoice Details</b></td>
								</tr>
                            	<tr height="26">
                                    {*<td align="left">Invoice # 1245</td>*}
                                    <td align="left" colspan="1">&nbsp;Date of Order: {$invoiceData.invoice_generated_on|date_format}</td>
                                	<td align="left" style="display:none;"  id="invoice_cancelled">Invoice Status:<font style="color:red;"> Cancelled</font></td>
                                	<td align="left"  id="invoice_not_approved" style="display:none;">Invoice Status: Not Approved</td>
                                	<td align="left" style="display:none;" id="invoice_approved">Invoice Status:<font style="color:green;"> Paid</font></td>
                                	{if $invoiceData.is_approved == '1' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:black;">Approved</font></td>
                                	{/if}
                                	{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
                                	<td align="left"  id="invoice_not_approved_on"><strong>Invoice Status: </strong><font style="color:red;"> Not Approved</font></td>
                                	{/if}
                                	{if $invoiceData.is_approved == '1' && $invoiceData.is_cancelled == '1'}
                                	<td align="left"   id="invoice_cancelled"><strong>Invoice Status: </strong> <font style="color:red;">Cancelled</font></td>
                               		{/if}
                               		{if $invoiceData.is_approved == '1' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '1'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;"> Paid</font></td>
                                	{/if}
                                	{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '1'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:red;">Not Approved</font> </td>
                                	{/if}
                                </tr>                                
                                 <tr height="26">
                                    
                                    <td align="left">&nbsp;
                                        <b>Billing Address</b><br />
                                        &nbsp;{$invoiceData.billing_address.billing_firstname}&nbsp;{$invoiceData.billing_address.billing_lastname}<br/>
                                        &nbsp;{$invoiceData.billing_address.billing_address1}{if $invoiceData.billing_address.billing_address != ''}, {$invoiceData.shipping_address.billing_address}{/if}
                                        <br />&nbsp;{$invoiceData.billing_address.billing_city}&nbsp;-
                                        &nbsp;{$invoiceData.billing_address.billing_zipcode},&nbsp;{$invoiceData.billing_address.billing_state}&nbsp;{$invoiceData.billing_address.billing_country_name}<br />
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
                                            {section name=counter loop=$invoiceData.auction_details}
                                        	<tr>
                                                <td align="left">#{$invoiceData.auction_details[counter].poster_sku}</td>
                                                <td align="left">{$invoiceData.auction_details[counter].poster_title}</td>
                                                <td align="left">${$invoiceData.auction_details[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.auction_details[counter].amount}
                                            {/section}
                                            <tr>
                                                <td align="right" colspan="2"><b>Subtotal</b></td>
                                                <td align="left">${$subTotal|number_format:2}</td>
                                            </tr>
                                            {section name=counter loop=$invoiceData.additional_charges}
                                            <tr id='tr_del_charge_{$smarty.section.counter.index}'>
                                             	<td align="right" >&nbsp;{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0'}
                                             	&nbsp;
                                             	<img src='../admin_images/del_ind.jpg' style="display:none;" class="del_img">
                                             	<img src='../admin_images/delete_charge.jpg' id='del_charge_{$smarty.section.counter.index}' class="del_ind" title='Delete' onclick='del_charge(this.id)'>{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_charge_{$smarty.section.counter.index}' id='desc_del_charge_{$smarty.section.counter.index}' value='{$invoiceData.additional_charges[counter].description}' />
                                                (+)&nbsp;{$invoiceData.additional_charges[counter].description}</td>
                                                <td align="left">
                                                <input type='hidden' name='input_del_charge_{$smarty.section.counter.index}' id='input_del_charge_{$smarty.section.counter.index}' value='{$invoiceData.additional_charges[counter].amount}' />
                                                ${$invoiceData.additional_charges[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.additional_charges[counter].amount}
                                            {/section}
                                            {section name=counter loop=$invoiceData.discounts}
                                            <tr id='tr_del_amnt_{$smarty.section.counter.index}'>
                                            <td align="right" >&nbsp;{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' }
                                           	<img src='../admin_images/del_ind.jpg' style="display:none;" class="del_img"> 
                                            <img  src='../admin_images/delete_charge.jpg' id='del_amnt_{$smarty.section.counter.index}'class="del_ind" title='Delete' onclick='del_discount(this.id)'>{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_amnt_{$smarty.section.counter.index}' id='desc_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].description}' />
                                                (-)&nbsp;{$invoiceData.discounts[counter].description}</td>
                                                <td align="left">
                                                <input type='hidden' name='input_del_amnt_{$smarty.section.counter.index}' id='input_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].amount}' />
                                                ${$invoiceData.discounts[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal-$invoiceData.discounts[counter].amount}
                                            {/section}
                                            <tr>
                                            	<td id="new_charges" align="right" colspan="3"></td>                                               
                                            </tr>
                                            <tr>
                                            	<td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                            	<td align="right" colspan="2"><b>Total</b></td>
                                                <td align="left" id="new_total_amnt">${$subTotal|number_format:2}</td>
                                                <input type="hidden" id="total_cost_amnt" value="{$invoiceData.total_amount}"/>
                                            </tr>
                                            
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                {if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0'}
                                	<td colspan="3" align="center" id="approved_btn"><input type="button" name="Approve" value="Approve" id="approve" class="button"></td>
                               	{else}
                               		<td colspan="3" align="center" id="approved_btn"><input type="button" name="Approve" value="Approved" class="button"></td>
                               	{/if}
                               	
                               	 	<td  align="center" style="display:none" id="jst_approve" colspan="3"><input type="button" name="Approved" value="Approved"  class="button" >&nbsp;</td>
<!--                               	<td  colspan="3" align="center" style="display:none" id="cancel_auction"><input type="button" name="Canceled" value="Canceled" id="canceled" class="button" ></td>-->
                               </tr>
                        </form>
                    </td>
                </tr>
                {else}
                <tr>
                <td align="center">Sorry no invoice found for seller.This auction yet to be paid.</td>
                </tr>
                {/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
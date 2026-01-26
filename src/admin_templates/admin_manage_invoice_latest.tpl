{include file="admin_header.tpl"}

{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#add_charge").click(function(){
		var invoice_id=$("#invoice_id").val();
		var charge_desc=$("#charge_desc").val();
		var charge_amnt=$("#charge_amnt").val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
		var last_total_amnt=$("#total_cost_amnt").val();
		if(charge_desc!=''){
			if (charge_amnt == parseFloat(charge_amnt)){
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
				alert("Please provide a proper numeric number for charge amunt");
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
		if(discount_desc!=''){
			if (discount_amnt == parseFloat(discount_amnt)){
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
				alert("Please provide a proper numeric number for discount amount");
			}
		}else{
			$("#discount_desc").focus();
			alert("Please provide a description for discount");
		}
	});
	
	$("#approve").click(function(){
		var invoice_id=$("#invoice_id").val();
		$.get("admin_auction_manager.php?mode=approve_invoice", {invoice_id :invoice_id },
				function(data) {
					$("#track_is_approved1").hide();
					$("#track_is_approved2").hide();
					$("#track_is_approved3").hide();
					$("#track_is_approved4").hide();
					$("#approved_btn").hide();
					$("#jst_approve").show();
					$("#invoice_approved").show();
					$("#invoice_not_approved_on").hide();
					
					});
		
	});
	$("#cancel").click(function(){
		var invoice_id=$("#invoice_id").val();
		$.get("admin_auction_manager.php?mode=cancel_invoice", {invoice_id :invoice_id },
				function(data) {
					$("#approved").hide();
					$("#cancel").hide();
					$("#canceled").show();
					$("#invoice_approved_on").hide();
					$("#invoice_cancelled").show();
					});
		
	});
});
	
	function del_charge(id){
		var is_delete=confirm("Are you sure to delete?");
		if(is_delete){	
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
			  $("#tr_"+id).remove();	
			});
		}
	}
	
	function del_discount(id)
	{
		var is_delete=confirm("Are you sure to delete?");
		if(is_delete){	
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
			  $("#tr_"+id).remove();	
			});
		}
	}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $key!='1'}
                <tr>
                    <td align="center" >
                        <form name="listFrom" id="listForm" action="" method="post">
                        <input type="hidden" id="invoice_id" value="{$invoiceData.invoice_id}">
                            <table align="center" width="60%" border="0" style="border:1px solid #CCCCCC;">
                            	{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
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
                                    <td align="left" colspan="1">Date of Order: {$invoiceData.invoice_generated_on|date_format}</td>
                                	<td align="left" style="display:none;"  id="invoice_cancelled">Invoice Status: Cancelled</td>
                                	<td align="left"  id="invoice_not_approved" style="display:none;">Invoice Status: Not Approved</td>
                                	<td align="left" style="display:none;" id="invoice_approved">Invoice Status: Approved</td>
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
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;">Paid</font> </td>
                                	{/if}
                                </tr>                                
                                <tr height="26">
                                    <td align="left">
                                        <b>Shipping Address</b><br />
                                        {$invoiceData.shipping_address.shipping_firstname}&nbsp;{$invoiceData.shipping_address.shipping_lastname}<br/>
                                        {$invoiceData.shipping_address.shipping_address1}{if $invoiceData.shipping_address.shipping_address2 != ''}, {$invoiceData.shipping_address.shipping_address2}{/if}
                                        <br />{$invoiceData.shipping_address.shipping_city}&nbsp;-
                                        {$invoiceData.shipping_address.shipping_zipcode},&nbsp;{$invoiceData.shipping_address.shipping_state}&nbsp;{$invoiceData.shipping_address.shipping_country_name}<br />
                                    </td>
                                    <td align="left">
                                        <b>Billing Address</b><br />
                                        {$invoiceData.billing_address.billing_firstname}&nbsp;{$invoiceData.billing_address.billing_lastname}<br/>
                                        {$invoiceData.billing_address.billing_address1}{if $invoiceData.billing_address.billing_address != ''}, {$invoiceData.shipping_address.billing_address}{/if}
                                        <br />{$invoiceData.billing_address.billing_city}&nbsp;-
                                        {$invoiceData.billing_address.billing_zipcode},&nbsp;{$invoiceData.billing_address.billing_state}&nbsp;{$invoiceData.billing_address.billing_country_name}<br />
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
                                             	<td align="right" >{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}<img src='{$smarty.const.CLOUD_STATIC_ADMIN}delete_charge.jpg' id='del_charge_{$smarty.section.counter.index}' title='Delete' onclick='del_charge(this.id)'>{else}&nbsp;{/if}</td>
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
                                            <td align="right" >{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}<img  src='{$smarty.const.CLOUD_STATIC_ADMIN}delete_charge.jpg' id='del_amnt_{$smarty.section.counter.index}' title='Delete' onclick='del_discount(this.id)'>{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_amnt_{$smarty.section.counter.index}' id='desc_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].description}' />
                                                (-)&nbsp;{$invoiceData.discounts[counter].description}</td>
                                                <td align="left">
                                                <input type='hidden' name='input_del_amnt_{$smarty.section.counter.index}' id='input_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].amount}' />
                                                ${$invoiceData.discounts[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.discounts[counter].amount}
                                            {/section}
                                            <tr>
                                            	<td id="new_charges" align="right" colspan="3">&nbsp;</td>                                               
                                            </tr>
                                            
                                            <tr>
                                            	<td align="right" colspan="2"><b>Total</b></td>
                                                <td align="left" id="new_total_amnt">${$invoiceData.total_amount}</td>
                                                <input type="hidden" id="total_cost_amnt" value="{$invoiceData.total_amount}"/>
                                            </tr>
                                            {if $invoiceData.is_approved =='0' && $invoiceData.is_cancelled=='0' && $invoiceData.is_paid == '0'}
                                            <tr>
                                			 <td colspan="3" align="center" id="approved_btn"><input type="button" name="Approve" value="Approve" id="approve" class="button"></td>
                               	 			 <td  align="center" style="display:none" id="jst_approve" colspan="3"><input type="button" name="Approved" value="Approved"  class="button" >&nbsp;</td>
                               	 			</tr>
                               	 			{elseif $invoiceData.is_approved=='1' && $invoiceData.is_cancelled!='1' && $invoiceData.is_paid == '0'}
                               	 			<tr>
                                			 
                                			 <td  align="center" colspan="3">
                                			 <input type="button" name="Approved" value="Approved" id="approved" class="button">&nbsp;
                                			 <input type="button" name="Cancel" value="Cancel" id="cancel" class="button">&nbsp;
                                			 <input type="button" name="Canceled" value="Canceled" id="canceled" class="button" style="display: none;">
                                			 </td>
                               	 			</tr>
                               	 			{elseif $invoiceData.is_cancelled=='1' && $invoiceData.is_approved=='1'}
                               	 			<tr>
                               	 				<td colspan="3" align="center"><input type="button" name="Canceled" value="Canceled" id="canceled" class="button" ></td>
                               	 			</tr>
                               	 			{elseif $invoiceData.is_paid=='1'}
                               	 			<tr>
                               	 				<td colspan="3" align="center"><input type="button" name="invoice_paid" value="Invoice Paid"  class="button" ></td>
                               	 			</tr>
                               	 			{/if}
                                        </table>
                                    </td>
                                </tr>
                                
                        </form>
                    </td>
                </tr>
                {else}
                <tr>
                <td align="center">Sorry no invoice found for this auction.</td>
                </tr>
                {/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
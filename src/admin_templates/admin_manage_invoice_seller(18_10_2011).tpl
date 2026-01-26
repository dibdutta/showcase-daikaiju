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
        //$(document).ready(function() {
            /*
            *   Examples - images
            */
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
            
        //});
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
                                    <td align="left" colspan="1">&nbsp;Date of Order: {$invoiceData.invoice_generated_on|date_format}</td>
                                	<td align="left" style="display:none;"  id="invoice_cancelled">Invoice Status:<font style="color:red;"> Cancelled</font></td>
                                	<td align="left"  id="invoice_not_approved" style="display:none;">Invoice Status: Not Approved</td>
                                	<td align="left" style="display:none;" id="invoice_approved">Invoice Status:<font style="color:green;"> Approved</font></td>
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
                                            
                                            {section name=counter loop=$invoiceData.discounts}
                                            <tr id='tr_del_amnt_{$smarty.section.counter.index}'>
                                            <td align="right" >{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
                                            <img  src='../admin_images/delete_charge.jpg' id='del_amnt_{$smarty.section.counter.index}' title='Delete' onclick='del_discount(this.id)'>{else}&nbsp;{/if}</td>
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
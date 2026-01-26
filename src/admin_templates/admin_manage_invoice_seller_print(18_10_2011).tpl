{literal}
<style>
.printer{
font-family:Calibri;	
}

.forPrint-mainBorder{
border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;
padding:5px;
margin:0px;
}

</style>
{/literal}
<table align="center" width="80%" border="1" cellspacing="0"  bordercolor="#000000" cellpadding="0" style="border-collapse:collapse; {if $invoiceData[0].is_cancelled == '1'}background: url(../images/cancelled-img.png){elseif $invoiceData[0].is_paid == '1'} background: url(../images/paid-img.png){elseif $invoiceData[0].is_cancelled=='0' && $invoiceData[0].is_paid=='0' && $invoiceData[0].is_approved=='1'}background:url(../images/approved-img.png){/if}  no-repeat center 85%;" >
                            	<tr>
    								<td style="padding:10px;"><img src="../images/logo.png" width="278" height="84" border="0" />
        							</td>
    							</tr>
                            	
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer" bgcolor="silver"><b>&nbsp;Invoice Details</b></td>
								</tr>
                            	<tr height="26" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF">
                                    {*<td align="left">Invoice # 1245</td>*}
                                    <td align="left" colspan="1">&nbsp;Date of Order: {$invoiceData[0].invoice_generated_on|date_format}</td>
                                	{if $invoiceData[0].is_approved == '1' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '0'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:black;">Approved</font></td>
                                	{/if}
                                	{if $invoiceData[0].is_approved == '0' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '0'}
                                	<td align="left"  id="invoice_not_approved_on"><strong>Invoice Status: </strong><font style="color:red;"> Not Approved</font></td>
                                	{/if}
                                	{if $invoiceData[0].is_approved == '1' && $invoiceData[0].is_cancelled == '1'}
                                	<td align="left"   id="invoice_cancelled"><strong>Invoice Status: </strong> <font style="color:red;">Cancelled</font></td>
                               		{/if}
                               		{if $invoiceData[0].is_approved == '1' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '1'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;"> Paid</font></td>
                                	{/if}
                                	{if $invoiceData[0].is_approved == '0' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '1'}
                                	<td align="left"  id="invoice_approved_on"><strong>Invoice Status: </strong><font style="color:green;">Paid</font> </td>
                                	{/if}
                                </tr>                                
                                
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr >
                                	<td align="left" colspan="2" >
                                    	<table border="1" width="100%" align="left" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" cellpadding="2" style="border-collapse:collapse;" cellspacing="0" class="invoice-main">
                                        	<tr class="printer" bgcolor="silver">
                                            	<th align="left" width="25%" >Item</th>
                                                <th align="left" width="50$" >Title</th>
                                                <th align="left" width="25%" >Price</th>
                                            </tr>
                                            <tr><td colspan="3">&nbsp;</td></tr>
                                            {section name=counter loop=$invoiceData.auction_details}
                                        	<tr class="printer" >
                                                <td align="left" >#{$invoiceData.auction_details[counter].poster_sku}</td>
                                                <td align="left">{$invoiceData.auction_details[counter].poster_title}</td>
                                                <td align="left" >${$invoiceData.auction_details[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.auction_details[counter].amount}
                                            {/section}
                                            <tr class="printer"  bgcolor="silver">
                                                <td align="right" colspan="2"><b>Subtotal</b></td>
                                                <td align="left">${$subTotal|number_format:2}</td>
                                            </tr>
                                           {section name=counter loop=$invoiceData.additional_charges}
                                            <tr class="printer">
                                             	<td align="right" >{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
                                             	<img src='../admin_images/delete_charge.jpg' id='del_charge_{$smarty.section.counter.index}' title='Delete' style="border:1px solid #cccccc;">{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                (+)&nbsp;{$invoiceData.additional_charges[counter].description}</td>
                                                <td align="left" >
                                                ${$invoiceData.additional_charges[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.additional_charges[counter].amount}
                                            {/section}
                                            {section name=counter loop=$invoiceData.discounts}
                                            <tr class="printer" >
                                            <td align="right">{if $invoiceData.is_approved == '0' && $invoiceData.is_cancelled == '0' && $invoiceData.is_paid == '0'}
                                            <img  src='../admin_images/delete_charge.jpg' id='del_amnt_{$smarty.section.counter.index}' title='Delete' onclick='del_discount(this.id)'>{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                <input type='hidden' name='desc_del_amnt_{$smarty.section.counter.index}' id='desc_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].description}' />
                                                (-)&nbsp;{$invoiceData.discounts[counter].description}</td>
                                                <td align="left" >
                                                <input type='hidden' name='input_del_amnt_{$smarty.section.counter.index}' id='input_del_amnt_{$smarty.section.counter.index}' value='{$invoiceData.discounts[counter].amount}' />
                                                ${$invoiceData.discounts[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal-$invoiceData.discounts[counter].amount}
                                            {/section}
                                            
                                            <tr>
                                            	<td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr class="printer" >
                                            	<td align="right" colspan="2" ><b>Total</b></td>
                                                <td align="left" id="new_total_amnt" >${$subTotal|number_format:2}</td>
                                                <input type="hidden" id="total_cost_amnt" value="{$invoiceData.total_amount}"/>
                                            </tr>
                                            <tr>
                                            <td colspan="3" align="center"><input type="button" value="Print" onclick="window.print();" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                        </form>
                    </td>
                </tr>
               
			</table>
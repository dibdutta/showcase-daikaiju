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
<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;{if $invoiceData[0].is_paid=='1'}background:url({$smarty.const.CLOUD_STATIC}paid-img.png){elseif $invoiceData[0].is_cancelled=='1'}background:url({$smarty.const.CLOUD_STATIC}cancelled-img.png){elseif $invoiceData[0].is_cancelled=='0' && $invoiceData[0].is_paid=='0' && $invoiceData[0].is_approved=='1' && $invoiceData[0].is_ordered=='0'}background:url({$smarty.const.CLOUD_STATIC}approved-img.png){elseif $invoiceData[0].is_paid=='0' && $invoiceData[0].is_ordered=='1'} background:url({$smarty.const.CLOUD_STATIC}payment-pending-img.png){/if} no-repeat center 75%; ">
                            	<tr>
    								<td style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="158" height="158" border="0" />
        							</td>
    							</tr>
                            	
								<tr class="header_bgcolor" height="26">
									<td colspan="2" class="printer" bgcolor="silver"><b>&nbsp;{if $invoiceData[0].is_buyers_copy=='1'}Invoice Details{else}Seller Reconcilation{/if}</b></td>
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
								{if $invoiceData[0].is_paid=='1'} 
									<tr height="26">                                
										<td align="left" colspan="2">&nbsp;Date paid: {$invoiceData[0].paid_on|date_format}</td> 
									</tr> 
								{/if}                               
                                <tr height="26">
                                 {if $invoiceData[0].is_buyers_copy=='1'}
                                    <td align="left">
                                        <b>&nbsp;Shipping Address</b><br />
                                        &nbsp;{$invoiceData.shipping_address.shipping_firstname}&nbsp;{$invoiceData.shipping_address.shipping_lastname}<br/>
                                        &nbsp;{$invoiceData.shipping_address.shipping_address1}{if $invoiceData.shipping_address.shipping_address2 != ''}, {$invoiceData.shipping_address.shipping_address2}{/if}
                                        <br />&nbsp;{$invoiceData.shipping_address.shipping_city}&nbsp;
                                        {$invoiceData.shipping_address.shipping_state}&nbsp;{$invoiceData.shipping_address.shipping_zipcode}<br />
                                    </td>
                                    {/if}
                                    <td align="left">
                                        <b>&nbsp;Billing Address</b><br />
                                        &nbsp;{$invoiceData.billing_address.billing_firstname}&nbsp;{$invoiceData.billing_address.billing_lastname}<br/>
                                        &nbsp;{$invoiceData.billing_address.billing_address1}{if $invoiceData.billing_address.billing_address2 != ''}, {$invoiceData.billing_address.billing_address2}{/if}
                                        <br />&nbsp;{$invoiceData.billing_address.billing_city}&nbsp;
                                       {$invoiceData.billing_address.billing_state}&nbsp;{$invoiceData.billing_address.billing_zipcode}<br />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr height="26">
                                    <td colspan="2" align="left" bgcolor="silver"><b>&nbsp;Email</b></td>
                                    <td colspan="2" align="left" bgcolor="silver">&nbsp;</td>

                                </tr>
                                <tr>
                                    <td>{$user_email[0].email}</td>
									<td>&nbsp;INV-{$invoiceData[0].invoice_id}</td>
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
											{assign var="seller_username" value= '' }
											{assign var="subTotal" value=0}
											{assign var="ship_new_chrg" value=0}
											{assign var="auction_wise_total" value=0}
                                            {section name=counter loop=$invoiceData.auction_details}
											{if $chk_item_type=='1' }									
												{if $seller_username !=$invoiceData.auction_details[counter].seller_username}
													{if $seller_username!=''}	
										
														<tr class="printer">
															<td align="right" colspan="2" >Shiiping Charge:</td>
														{if $invoiceData.shipping_address.shipping_country_name =='Canada' || $invoiceData.shipping_address.shipping_country_name =='United States'}
															<td align="left" >$15</td>
															{assign var="ship_new_chrg" value=$ship_new_chrg+15}
														{else}
															<td align="left" >$21</td>
															{assign var="ship_new_chrg" value=$ship_new_chrg+21}
														{/if}										
														</tr>
													{/if}
													<tr><td colspan="3" >Seller : {$invoiceData.auction_details[counter].seller_username}</td></tr>									  
												{/if}
											{elseif $chk_item_type=='2'}
												{if $seller_username !=$invoiceData.auction_details[counter].seller_username}
													{if $seller_username!=''}	
														<tr class="printer">
															<td align="right" colspan="2"><b>Auction wise Total:</b></td>
															<td align="left">${$auction_wise_total|number_format:2}</td>
														</tr>
													{/if}
													<tr><td colspan="3" ><b>Auction :</b> {$invoiceData.auction_details[counter].seller_username}</td></tr>
													{assign var="auction_wise_total" value=0}
												{/if}
											{/if}
                                        	<tr class="printer" >
                                                <td align="left" >#{$invoiceData.auction_details[counter].poster_sku}</td>
                                                <td align="left">{$invoiceData.auction_details[counter].poster_title}</td>
                                                <td align="left" >${$invoiceData.auction_details[counter].amount|number_format:2}</td>
                                            </tr>
											{assign var="subTotal" value=$subTotal+$invoiceData.auction_details[counter].amount}
											{if $chk_item_type=='1' || $chk_item_type=='4'}
												{assign var="seller_username" value= $invoiceData.auction_details[counter].seller_username }
											{elseif $chk_item_type=='2'}
												{assign var="seller_username" value= $invoiceData.auction_details[counter].seller_username }
												{assign var="auction_wise_total" value=$auction_wise_total+$invoiceData.auction_details[counter].amount}
											{/if}
                                            
                                            {/section}
											{if $chk_item_type=='1' || $chk_item_type=='4'}
												<tr>
													<td align="right" colspan="2" class="printer">Shiiping Charge:</td>
													{if $invoiceData.shipping_address.shipping_country_name =='Canada' || $invoiceData.shipping_address.shipping_country_name =='United States'}
														<td align="left" >$15.00</td>
													{else}
														<td align="left" >$21.00</td>
													{/if}
												</tr>
												{if $invoiceData.shipping_address.shipping_country_name =='Canada' || $invoiceData.shipping_address.shipping_country_name =='United States'}
													{assign var="ship_new_chrg" value=$ship_new_chrg+15}
												{else}
													{assign var="ship_new_chrg" value=$ship_new_chrg+21}
												{/if}
											{else}	
												<tr class="printer">
													<td align="right" colspan="2"><b>Auction wise Total:</b></td>
													<td align="left">${$auction_wise_total|number_format:2}</td>
												</tr>
											{/if}
                                            <tr class="printer"  bgcolor="silver">
                                                <td align="right" colspan="2"><b>Subtotal</b></td>
                                                <td align="left">${$subTotal|number_format:2}</td>
                                            </tr>
                                           {section name=counter loop=$invoiceData.additional_charges}
                                            <tr class="printer">
                                             	<td align="right" >{if $invoiceData[0].is_approved == '0' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '0'}
                                             	<img src='.{$smarty.const.CLOUD_STATIC_ADMIN}delete_charge.jpg' id='del_charge_{$smarty.section.counter.index}' title='Delete' style="border:1px solid #cccccc;">{else}&nbsp;{/if}</td>
                                                <td align="right" >
                                                (+)&nbsp;{$invoiceData.additional_charges[counter].description}</td>
                                                <td align="left" >
                                                ${$invoiceData.additional_charges[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.additional_charges[counter].amount}
                                            {/section}
                                            {section name=counter loop=$invoiceData.discounts}
                                            <tr class="printer" >
                                            <td align="right">{if $invoiceData[0].is_approved == '0' && $invoiceData[0].is_cancelled == '0' && $invoiceData[0].is_paid == '0'}
                                            <img  src='{$smarty.const.CLOUD_STATIC_ADMIN}delete_charge.jpg' id='del_amnt_{$smarty.section.counter.index}' title='Delete' onclick='del_discount(this.id)'>{else}&nbsp;{/if}</td>
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
                                                <input type="hidden" id="total_cost_amnt" value="{$invoiceData[0].total_amount|default:''}"/>
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
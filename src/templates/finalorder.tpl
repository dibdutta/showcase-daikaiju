{include file="header.tpl"}
<div id="forinnerpage-container">
	<div id="wrapper">
    	 <!--Header themepanel Starts-->
    <div id="headerthemepanel">
      <!--Header Theme Starts-->
      {include file="search-login.tpl"} 
      
       		<!--<div id="searchbar">
            	<div class="search-left-bg"></div>
                <div class="search-midrept-bg">
                	<label><img src="images/search-img.png" width="20" height="32"  /></label>
                	<input type="text" name="txt1" class="srchbox-txt" />
                    <input type="button" value="Search" class="srchbtn-main"  />
                    <input type="button" value="Refine Search" class="refine-srchbtn-main"  />
                </div>
                <div class="search-right-bg"></div>
              </div> -->
      <!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->    
    <div id="inner-container">
    {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
    	<div id="inner-left-container">
             <div id="tabbed-inner-nav">
				<div class="tabbed-inner-nav-left">
                    <ul class="menu">
						<li class="active"><a href="javascript:void(0)"><span>Order</span></a></li>
						
					</ul>
                 
				</div>	
            </div>
            <div class="innerpage-container-main">
            	<div class="top-mid"><div class="top-left"></div></div>
                
            	 <div class="left-midbg"> 
                    <div class="right-midbg">
               		 <div class="mid-rept-bg">
                <!--  inner listing starts  -->
                  <div class="display-listing-main">
                   <div>
                        <div class="gnrl-listing">
                        <div style="margin: 20px 0 0 0;">
                  
                  
                  <form name="paypalpayment" id="paypalpayment" action="" method="post">
                    {if $smarty.request.mode == 'phone_order'}
					  <input type="hidden" name="mode" value="order_now" />
					{else}
					  <input type="hidden" name="mode" value="pay_now" />
					{/if}
                    <input type="hidden" name="invoice_id" value="{$invoice_id}" />
                    <input type="hidden" name="firstname" value="{$firstname}" />
                    <input type="hidden" name="lastname" value="{$lastname}" />
                    <input type="hidden" name="cc_type" value="{$cc_type}" />
                    <input type="hidden" name="cc_number" value="{$cc_number}" />
                    <input type="hidden" name="exp_Month" value="{$exp_Month}" />
                    <input type="hidden" name="exp_Year" value="{$exp_Year}" />
                    <input type="hidden" name="cvv2Number" value="{$cvv2Number}" />
                  	<!--invoice begins here added on 20th june 2011-->
                        <div class="dashboard-main">
                            <div class="invoice-main">
                            <table width="90%" align="center" cellpadding="0" cellspacing="0" border="0" >
                                {*<tr>
                                    <td class="brdrbtm">
                                        <span>Invoice Number:</span> 1244
                                    </td>
                                    <td align="right" class="brdrbtm">
                                        <span>Date of Invoice:</span> {$smarty.now|date_format:"%d-%m-%Y"}
                                    </td>
                                </tr>*}
                                <tr>
                                    <th width="50%" class="brdrbtm"><span>Shipping Address</span></th>
                                    <th class="brdrbtm"><span>Billing Address</span></th>
                                </tr>
                                <tr>
                                    <td class="brdrbtm">
                                        <div class="tablepadn">{$invoiceData.shipping_info.shipping_firstname}&nbsp;{$invoiceData.shipping_info.shipping_lastname}</div>
                                        <div class="tablepadn">{$invoiceData.shipping_info.shipping_address1}</div>
                                        {if $invoiceData.shipping_info.shipping_address2 !=''}
                                        <div class="tablepadn">{$invoiceData.shipping_info.shipping_address2}</div>
                                        {/if}
                                        <div class="tablepadn">{$invoiceData.shipping_info.shipping_city}, {$invoiceData.shipping_info.shipping_state} - {$invoiceData.shipping_info.shipping_zipcode}</div>
                                        <div class="tablepadn">{$invoiceData.shipping_info.shipping_country_name}</div>
                                    </td>
                                    <td class="brdrbtm">
                                        <div class="tablepadn">{$invoiceData.billing_info.billing_firstname}&nbsp;{$invoiceData.billing_info.billing_lastname}</div>
                                        <div class="tablepadn">{$invoiceData.billing_info.billing_address1}</div>
                                        <div class="tablepadn">{$invoiceData.billing_info.billing_address2}</div>
                                        <div class="tablepadn">{$invoiceData.billing_info.billing_city}, {if $invoiceData.billing_info.billing_country_id=='230'}{$invoiceData.billing_info.billing_state_select}-{else}{$invoiceData.billing_info.billing_state_textbox}- {/if}{$invoiceData.billing_info.billing_zipcode}</div>
                                        <div class="tablepadn">{$invoiceData.billing_info.billing_country_name}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding:10px; border-top:1px solid #DFDFDF;">
                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="billdet" style="border-bottom:1px solid #CECECE; border-left:1px solid #CECECE;">
                                            <tr>
                                                <th align="left" width="15%">Sl No</th>
                                                <th align="left" width="50%">Title</th>                                                
                                                <th align="left" width="15%">Total Price</th>
                                            </tr>
                                            <tr><td colspan="3">&nbsp;</td></tr>
                                            
											{assign var="seller_username" value= '' }
                                            {section name=counter loop=$dataArr[0].auction_details}
											{if $chk_item_type=='1' }
											
											  {if $seller_username !=$dataArr[0].auction_details[counter].seller_username}
											  {if $seller_username!=''}	
											  	<tr>
                                                <td align="right" colspan="2" class="billbrdr">Shipping Charge:</td>
                                                {if $invoiceData.shipping_info.shipping_country_name =='Canada' || $invoiceData.shipping_info.shipping_country_name =='United States'}
                                                	<td align="left" class="billbrdr">$15.00</td>
												{else}
													<td align="left" class="billbrdr">$21.00</td>
												{/if}
                                            	</tr>
											  {/if}
                                            	<tr><td colspan="3" class="billbrdr">Seller : {$dataArr[0].auction_details[counter].seller_username}</td></tr>
											  
											  {/if}
											{/if}
                                            <tr>
                                                <td align="left" class="billbrdr">{$smarty.section.counter.index+1}</td>
                                                <td align="left" class="billbrdr">{$dataArr[0].auction_details[counter].poster_title}</td>
                                                <td align="left" class="billbrdr">${$dataArr[0].auction_details[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$dataArr[0].auction_details[counter].amount}
											{assign var="seller_username" value= $dataArr[0].auction_details[counter].seller_username }
                                            {/section}
											{if $chk_item_type=='1' || $chk_item_type=='4'}
												<tr>
                                                <td align="right" colspan="2" class="billbrdr">Shipping Charge:</td>
                                                {if $invoiceData.shipping_info.shipping_country_name =='Canada' || $invoiceData.shipping_info.shipping_country_name =='United States'}
                                                	<td align="left" class="billbrdr">$15.00</td>
												{else}
													<td align="left" class="billbrdr">$21.00</td>
												{/if}  
                                            	</tr>
											{/if}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr">Subtotal</td>
                                                <td align="left" class="billbrdr">${$subTotal|number_format:2}</td>
                                            </tr>
                                            {section name=counter loop=$dataArr[0].additional_charges}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr">(+)&nbsp;{$dataArr[0].additional_charges[counter].description}</td>
                                                <td align="left" class="billbrdr">${$dataArr[0].additional_charges[counter].amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$dataArr[0].additional_charges[counter].amount}
                                            {/section}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr"><span>Shipping Charge</span> ({$invoiceData.shipping_info.shipping_methods|upper} - {$invoiceData.shipping_info.shipping_desc})</td>
                                                <td align="left" class="billbrdr">${$invoiceData.shipping_info.shipping_charge|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.shipping_info.shipping_charge}
                                            {if $invoiceData.shipping_info.sale_tax_amount > 0}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr"><span>Sales Tax ({$invoiceData.shipping_info.sale_tax_percentage}%)</span></td>
                                                <td align="left" class="billbrdr">${$invoiceData.shipping_info.sale_tax_amount|number_format:2}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal+$invoiceData.shipping_info.sale_tax_amount}
                                            {/if}
                                            {section name=counter loop=$dataArr[0].discounts}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr">(-)&nbsp;{$dataArr[0].discounts[counter].description}</td>
                                                <td align="left" class="billbrdr">${$dataArr[0].discounts[counter].amount}</td>
                                            </tr>
                                            {assign var="subTotal" value=$subTotal-$dataArr[0].discounts[counter].amount}
                                            {/section}
                                            <tr>
                                                <td align="right" colspan="2" class="billbrdr">Total</td>
                                                <td align="left" class="billbrdr">${$subTotal|number_format:2}</td>
                                            </tr>
                                            
                                         </table>                                        
                                    </td>
                                </tr>
                            </table>
                            </div>
                             
                            <div class="div_submit" style="margin-left: 300px;">
                                <label>&nbsp;</label>
                                {if $smarty.request.mode == 'order'}
                                <input type="button" value="Continue" onclick="$(location).attr('href','{$actualPath}/my_invoicep?mode=shippinginfo&invoice_id={$invoice_id}');" class="submit-btn" />
                                {elseif $smarty.request.mode == 'finalorder'}
                                <input type="button" value="Pay Now" class="submit-btn" onclick="if(confirm('Do you want to continue payment?'))$('#paypalpayment').submit();" />
                                <input type="button" value="Cancel Payment" onclick="if(confirm('Do you want to cancel payment?'))$(location).attr('href','{$actualPath}/my_invoice?mode=cancel_payment&invoice_id={$invoice_id}');" class="cancel-btn" />
                                {elseif $smarty.request.mode == 'phone_order'}
									<input type="button" value="Confirm Order" class="cancel-btn" onclick="if(confirm('Are you sure you want to Confirm order?'))$('#paypalpayment').submit();" />
									<input type="button" value="Cancel Order" onclick="if(confirm('Are you sure you want to Cancel order?'))$(location).attr('href','{$actualPath}/my_invoice?mode=cancel_payment&invoice_id={$invoice_id}');" class="cancel-btn" />
								{/if}
                            </div>
                            <div class="clear"></div>
                        </div>
                       </form>
                       </div>
                       </div>
                       </div>
                  </div>
                  <div class="clear"></div>
                  <div style="clear:both;height: 0"></div>
					<div  style="text-align:center;">
						<div style="margin-top:10px;">
								<div>								
								<a href="https://www.paypal.com/us/verified/pal=info%40movieposterexchange%2ecom" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/verification_seal.png" border="0" alt="Official PayPal Seal"></a>
								</div>
							</div>
					</div>
					<div style="clear:both;height: 0"></div> 
                </div>
                	</div>
                    </div>
                    
                   
                </div>
               
            </div>
      
        </div></div></div>       
    
    </div>
	{include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

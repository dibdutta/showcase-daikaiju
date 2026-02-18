{include file="header.tpl"}
<div id="forinnerpage-container">
	<div id="wrapper">
    	 <!--Header themepanel Starts-->
    <div id="headerthemepanel">
        <!--Header Theme Starts-->
              {include file="search-login.tpl"} 
        <!--Header Theme Ends-->
      <!--Header Theme Starts-->
       		 
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
						<li {if $smarty.request.list == ''}class="active"{/if}><a href="javascript:void(0)"><span>My Order</span></a></li>
						
					</ul>
                    <div class="tabbed-inner-nav-right"></div>
                    </div>
				    </div>
            <div class="innerpage-container-main">
            	<div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>
                
                
                <div class="left-midbg"> 
                <div class="right-midbg">    
                <div class="mid-rept-bg">
                {if $err_msg<>""}<div class="messageBox">{$err_msg}</div>{/if}
                {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                <!--  inner listing starts  -->
                  <div class="display-listing-main">
                  <form name="paypalpayment" id="paypalpayment" action="{$smarty.const.SITE_URL}/classes/paypal_pro_express/DoExpressCheckoutPayment.php" method="post">
                        <input type="hidden" name="mode" value="pay_now" />
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
                                    <td width="50%" class="brdrbtm"><span>Shipping Address</span></td>
                                    <td class="brdrbtm"><span>Billing Address</span></td>
                                </tr>
                                <tr>
                                    <td class="brdrbtm">
                                        <div class="tablepadn">{$shipping_info.shipping_firstname}&nbsp;{$shipping_info.shipping_lastname}</div>
                                        <div class="tablepadn">{$shipping_info.shipping_address1}</div>
                                        {if $shipping_info.shipping_address2 !=''}
                                        <div class="tablepadn">{$shipping_info.shipping_address2}</div>
                                        {/if}
                                        <div class="tablepadn">{$shipping_info.shipping_city}, {$shipping_info.shipping_state} - {$shipping_info.shipping_zipcode}</div>
                                        <div class="tablepadn">{$shipping_info.shipping_country_name}</div>
                                    </td>
                                    <td class="brdrbtm">
                                        <div class="tablepadn">{$billing_info.billing_firstname}&nbsp;{$billing_info.billing_lastname}</div>
                                        <div class="tablepadn">{$billing_info.billing_address1}</div>
                                        <div class="tablepadn">{$billing_info.billing_address2}</div>
                                        <div class="tablepadn">{$billing_info.billing_city}, {$billing_info.billing_state}- {$billing_info.billing_zipcode}</div>
                                        <div class="tablepadn">{$billing_info.billing_country_name}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="billdet">
                                            <tr>
                                                <th align="left" width="10%">Sl No</th>
                                                
                                                <th align="left" width="50%">Title</th>                                                
                                                <th align="left" width="30%">Total Price</th>
                                            </tr>
                                            {section name=counter loop=$cart} 
                                            <tr>
                                                <td>{$smarty.section.counter.index+1}</td>
                                                
                                                <td>{$cart[counter].poster_title}</td>                                                
                                                <td>${$cart[counter].amount|number_format:2}</td>
                                                {assign var=subtotal value=$subtotal+$cart[counter].amount}
                                            </tr>
                                            {/section}
                                            <tr>
                                                <td colspan="2" align="right" class="billbrdr"><span>Subtotal</span></td>
                                                <td class="billbrdr">${$subtotal|number_format:2}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right" class="billbrdr"><span>Shipping Charge</span> ({$shipping_info.shipping_methods|upper} - {$shipping_info.shipping_desc})</td>
                                                <td class="billbrdr">${$shipping_info.shipping_charge|number_format:2}</td>
                                            </tr>
											{if $shipping_info.sale_tax_amount > 0}
                                            <tr>
                                                <td colspan="2" align="right" class="billbrdr"><span>Sales Tax</span> ({$shipping_info.sale_tax_percentage}%)</td>
                                                <td class="billbrdr">${$shipping_info.sale_tax_amount|number_format:2}</td>
                                            </tr>
											{assign var=subtotal value=$subtotal+$shipping_info.sale_tax_amount}
											{/if}
                                            <tr>
                                                <td colspan="2" align="right" class="billbrdr"><span>Total</span>
                                                </td>
                                                <td class="billbrdr">
                                                ${$subtotal+$shipping_info.shipping_charge|number_format:2}
                                                <input type="hidden" name="total" value="{$subtotal+$shipping_info.shipping_charge}" />
                                                </td>
                                            </tr>
                                           
                                        </table>                                        
                                    </td>
                                </tr>
                            </table>
                            </div>
                            <div class="div_submit" style="margin-left: 300px;">
                                <label>&nbsp;</label>
                                <input type="button" value="Pay Now" class="submit-btn" onclick="if(confirm('Do you want to continue payment?'))$('#paypalpayment').submit();" />
                                <input type="reset" value="Cancel Payment" class="cancel-btn" onclick="if(confirm('Do you want to cancel payment?'))$(location).attr('href', '{$actualPath}/cart.php?mode=cancel_payment');" />
                            </div>
                            <div class="clear"></div>
                        </div>
                       </form>
                  </div>
                   <div class="clear"></div>
                    <div style="clear:both;height: 0"></div>
					<div style="margin:0 auto;width:203px;overflow:hidden;">
						<div style="float:left;margin-top:10px">
						   {literal}                     
							<div id="DigiCertClickID_QklYG4Yf">
								<a href="http://www.digicert.com/">SSL Certificates</a>
							</div>
							<script type="text/javascript">
							var __dcid = __dcid || [];__dcid.push(["DigiCertClickID_QklYG4Yf", "7", "m", "black", "QklYG4Yf"]);(function(){var cid=document.createElement("script");cid.type="text/javascript";cid.async=true;cid.src=("https:" === document.location.protocol ? "https://" : "http://")+"seal.digicert.com/seals/cascade/seal.min.js";var s = document.getElementsByTagName("script");var ls = s[(s.length - 1)];ls.parentNode.insertBefore(cid, ls.nextSibling);}());
							</script>
	                     {/literal}					
						</div>
						<div style="float:left">
							<a href="https://www.paypal.com/us/verified/pal=info%40mygodzillashop%2ecom" target="_blank"><img src="https://www.paypal.com/en_US/i/icon/verification_seal.gif" border="0" alt="Official PayPal Seal"></A>
						</div>
					</div>
					<div style="clear:both;height: 0"></div>   
                </div>
                </div>
                </div>
                <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
            </div>
        </div>
    </div></div></div>   
    {include file="user-panel.tpl"}
    </div>
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}


















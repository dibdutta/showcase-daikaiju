{include file="header.tpl"}
{literal}

<script language="javascript">
$(document).ready(function(){
	//$("#shippinginfo").validate();	
	{/literal}{if $shipping_methods != ''}shippingMethod('{$shipping_methods}');{/if}{literal}
	stateOptions($('#billing_country_id').val(), 'billing_state_textbox', 'billing_state_select');
	stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});

function shipsame(form){
	if(form.sameasbilling.checked){
		form.shipping_firstname.value = form.billing_firstname.value;
		form.shipping_lastname.value = form.billing_lastname.value;
		form.shipping_address1.value = form.billing_address1.value;
		form.shipping_address2.value = form.billing_address2.value;
		form.shipping_city.value = form.billing_city.value;
		form.shipping_zipcode.value = form.billing_zipcode.value;
	
		if(form.billing_country_id.type == "Select"){
			 var bCountryIdx = form.billing_country_id.selectedIndex;
			 form.shipping_country_id.options[bCountryIdx].selected = true;
		}else{
			form.shipping_country_id.value = form.billing_country_id.value;
			
			if(form.billing_country_id.value == 230){
				stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
				form.shipping_state_select.value = form.billing_state_select.value;
			}else{
				form.shipping_state_textbox.value = form.billing_state_textbox.value;
			}
		}
	}else{
		form.shipping_firstname.value = {/literal} "{$invoiceData[0].shipping_address.shipping_firstname}" {literal};
		form.shipping_lastname.value = {/literal} "{$invoiceData[0].shipping_address.shipping_lastname}" {literal};
		form.shipping_address1.value = {/literal} "{$invoiceData[0].shipping_address.shipping_address1}" {literal};
		form.shipping_address2.value  = {/literal} "{$invoiceData[0].shipping_address.shipping_address2}" {literal};
		form.shipping_city.value={/literal} "{$invoiceData[0].shipping_address.shipping_city}" {literal};
		form.shipping_state.value = {/literal} "{$invoiceData[0].shipping_address.shipping_state}" {literal};
		form.shipping_zipcode.value = {/literal} "{$invoiceData[0].shipping_address.shipping_zipcode}" {literal};
		if(form.shipping_country_id.type == "Select"){
			 form.shipping_country_id.options[0].selected = true;
		}else{
			 form.shipping_country_id.value = {/literal} "{$invoiceData[0].shipping_address.shipping_country_id}" {literal};
			 
			if(form.shipping_country_id.value == 230){
				stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
				form.shipping_state_select.value = form.billing_state_select.value;
			}else{
				form.shipping_state_textbox.value = form.billing_state_textbox.value;
				
				if(form.shipping_country_id.value == 230){
					stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
					form.shipping_state_select.value = form.billing_state_select.value;
				}else{
					form.shipping_state_textbox.value = form.billing_state_textbox.value;
				}
			}
		}	
	}
}
</script>
{/literal}
<input type="hidden" id="weights" value="{$weight_array}">
<input type="hidden" id="total_item" value="{$total_item}">
<input type="hidden" id="invoice_key" value="{$smarty.request.invoice_key}">

<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
            <!--Header Theme Starts-->
            {include file="search-login.tpl"} 
            <!--Header Theme Ends-->
        </div>
        <!--Header themepanel Ends-->    
        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
        
            <div id="inner-left-container">
                <div class="innerpage-container-main display-listing-main">
                    
                    <!--Page body Starts-->
                    <div class="innerpage-container-main">                
                        <div class="dashboard-main">
                     		<h1>Shipping Info</h1>
							<p>Fields marked with <span class="mandatory">*</span> are mandatory </p>
                     	</div>
						
                     <div class="dashboard-main">                                 
                     <div class="right-midbg">    
                     <div class="mid-rept-bg">                	
                        <div class="">
                            <form name="shippinginfo" id="shippinginfo" action="" method="post">
                            	<input type="hidden" name="mode" value="paymentoption" />
                                <input type="hidden" name="invoice_id" value="{$invoice_id}" />
                                <input type="hidden" name="shipping_desc" id="shipping_desc" value="">
                                {*  <div class="formheading-area">
                                    
                                    <!-- form listings starts here-->
                                   <div class="dashblock_profile" style="float:none;"> 
                                       <!-- <img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}user.png" width="22" height="22" border="0"  />-->
                                        <h3>Enter your details</h3>
                                    </div>
								</div>*}
                                <div class="formarea gnrl-listing" style="display:none">
                                     <table width="100%" cellpadding="0" cellspacing="0" border="0"  >
                                     	<tr>
                                        	<td  ><label>Firstname<span class="red-star">*</span></label></td>
                                            <td  ><label>Lastname<span class="red-star">*</span></label></td>
                                            <td  ><label>Address1<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                        	<td align="left"><input type="text" name="billing_firstname" value="{$invoiceData[0].billing_address.billing_firstname}" class="input_textbox required" /><div class="disp-err">{$billing_firstname_err}</div></td>
                                            <td align="left"><input type="text" name="billing_lastname" value="{$invoiceData[0].billing_address.billing_lastname}" class="input_textbox required" /><div class="disp-err">{$billing_lastname_err}</div></td>
                                            <td align="left"><input type="text" name="billing_address1" value="{$invoiceData[0].billing_address.billing_address1}" class="input_textbox required" /><div class="disp-err">{$billing_address1_err}</div></td>
                                        </tr>
                                        <tr>
                                        	<td  ><label>Address2</label></td>
                                            <td  ><label>Country<span class="red-star">*</span></label></td>
                                            <td  ><label>State/Province</label></td>
                                        </tr>
                                        <tr>
                                        	<td align="left"><input type="text" name="billing_address2" value="{$invoiceData[0].billing_address.billing_address2}" class="input_textbox" /><div class="disp-err">{$billing_address2_err}</div></td>
                                            <td align="left">
                                                <select name="billing_country_id" id="billing_country_id" class="selectbox required" onchange="stateOptions($('#billing_country_id').val(), 'billing_state_textbox', 'billing_state_select');">
                                                <option value="" selected="selected">Select</option>
                                                {html_options values=$countryID output=$countryName selected=$invoiceData[0].billing_address.billing_country_id}
                                                </select>
                                                <div class="disp-err">{$billing_country_id_err}</div>
                                            </td>
                                            <td align="left">
                                            <!--<input type="text" name="billing_state" value="{$invoiceData[0].billing_address.billing_state}" class="input_textbox required" /><div class="disp-err">{$billing_state_err}</div> -->
                                            <input type="text" name="billing_state_textbox" id="billing_state_textbox" {if $invoiceData[0].billing_address.billing_country_id != 230} value="{$invoiceData[0].billing_address.billing_state}" {/if} class="input_textbox required" {if $invoiceData[0].country_id == 230} style="display:none;" {/if} />
                                            <select name="billing_state_select" id="billing_state_select" class="selectbox required" {if $invoiceData[0].billing_address.billing_country_id != 230} style="display:none;" {/if}>
                                                <!--<option value="" selected="selected">Select</option>-->
                                                {section name=counter loop=$us_states}
                                                <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].name == $invoiceData[0].billing_address.billing_state || $us_states[counter].abbreviation == $invoiceData[0].billing_address.billing_state} selected="selected" {/if}>{$us_states[counter].name}</option>
                                                {/section}
                                            </select>
                                            <div class="disp-err">{$billing_state_textbox_err}{$billing_state_select_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  ><label>City<span class="red-star">*</span></label></td>
                                            <td  ><label>Zipcode<span class="red-star">*</span></label></td>
                                            <td  >&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left"><input type="text" name="billing_city" value="{$invoiceData[0].billing_address.billing_city}" class="input_textbox required" /><div class="disp-err">{$billing_city_err}</div></td>
                                            <td align="left"><input type="text" name="billing_zipcode" value="{$invoiceData[0].billing_address.billing_zipcode}" class="input_textbox required" /><div class="disp-err">{$billing_zipcode_err}</div></td>
                                            <td align="left">&nbsp;</td>
                                        </tr>
                                     </table>
                                     <div class="clear"></div>
                                </div>
                                <div class="formheading-area">
                                    
                                     <div class="dashblock_profile" style="float:none;"> 
                                        <h3> Confirm shipping details</h3></div>
                                    
                                 </div>    
                                <div class="formarea-listing">
                                <div class="formarea gnrl-listing">
                                     <table width="695px" cellpadding="0" cellspacing="0" border="0">
                                     	{* <tr>
                                			<td><span><input type="checkbox" name="sameasbilling" value="checkbox" onClick="shipsame(this.form);" onchange="$('#shipping_options').remove();">&nbsp;Same as billing</span></td>
                                		</tr> *}
                                     	<tr>
                                        	<td  ><label>Firstname<span class="red-star">*</span></label></td>
                                            <td  ><label>Lastname<span class="red-star">*</span></label></td>
                                            <td  ><label>Address1<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                        	<td align="left"><input type="text" name="shipping_firstname" value="{$invoiceData[0].shipping_address.shipping_firstname}" class="input_textbox required" /><div class="disp-err">{$shipping_firstname_err}</div></td>
                                            <td align="left"><input type="text" name="shipping_lastname" value="{$invoiceData[0].shipping_address.shipping_lastname}" class="input_textbox required" /><div class="disp-err">{$shipping_lastname_err}</div></td>
                                            <td align="left"><input type="text" name="shipping_address1" id="shipping_address1" value="{$invoiceData[0].shipping_address.shipping_address1}" class="input_textbox required" onchange="$('#shipping_options').remove();" /><div class="disp-err">{$shipping_address1_err}</div></td>
                                        </tr>
                                        <tr>
                                        	<td  ><label>Address2</label></td>
                                            <td  ><label>Country<span class="red-star">*</span></label></td>
                                            <td  ><label>State/Province</label></td>
                                        </tr>
                                        <tr>
                                        	<td align="left"><input type="text" name="shipping_address2" value="{$invoiceData[0].shipping_address.shipping_address2}" class="input_textbox" /><div class="disp-err">{$shipping_address2_err}</div></td>
                                            <td align="left">
                                            {*<select name="shipping_country_id" id="shipping_country_id" class="selectbox required" onchange="$('#shipping_options').remove();">
                                                <option value="" selected="selected">Select</option>
                                                {html_options values=$countryID output=$countryName selected=$invoiceData[0].shipping_address.shipping_country_id}
                                            </select>
                                            <div class="disp-err">{$shipping_country_id_err}</div>*}                                            
                                            <select name="shipping_country_id" id="shipping_country_id" class="selectbox required" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');">
                                                <option value="" selected="selected">Select</option>
                                                {html_options values=$countryID output=$countryName selected=$invoiceData[0].shipping_address.shipping_country_id}
                                            </select>
                                            <div class="disp-err">{$shipping_country_id_err}</div>
                                            </td>
                                            <td align="left">
                                            {*<input type="text" name="shipping_state" id="shipping_state" value="{$invoiceData[0].shipping_address.shipping_state}" class="input_textbox required" onchange="$('#shipping_options').remove();" /><div class="disp-err">{$shipping_state_err}</div>*}
                                            
                                            <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" {if $invoiceData[0].shipping_address.shipping_country_id != 230} value="{$invoiceData[0].shipping_address.shipping_state}" {/if} class="input_textbox required" {if $invoiceData[0].shipping_country_id == 230} style="display:none;" {/if} />
                                            <select name="shipping_state_select" id="shipping_state_select" class="selectbox required" {if $invoiceData[0].shipping_address.shipping_country_id != 230} style="display:none;" {/if}>
                                                {*<option value="" selected="selected">Select</option>*}
                                                {section name=counter loop=$us_states}
                                                <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].name == $invoiceData[0].shipping_address.shipping_state || $us_states[counter].abbreviation == $invoiceData[0].shipping_address.shipping_state } selected="selected" {/if}>{$us_states[counter].name}</option>
                                            {/section}
                                            </select>
                                            <div class="disp-err">{$shipping_state_textbox_err}{$shipping_state_select_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  ><label>City<span class="red-star">*</span></label></td>
                                            <td  ><label>Zipcode<span class="red-star">*</span></label></td>
                                            <td  >&nbsp;</td>
                                        </tr>
                                        <tr>
                                        	<td align="left"><input type="text" name="shipping_city" id="shipping_city" value="{$invoiceData[0].shipping_address.shipping_city}" class="input_textbox required" onchange="$('#shipping_options').remove();" /><div class="disp-err">{$shipping_city_err}</div></td>
                                        	<td align="left"><input type="text" name="shipping_zipcode" id="shipping_zipcode" value="{$invoiceData[0].shipping_address.shipping_zipcode}" class="input_textbox required" onchange="$('#shipping_options').remove();" /><div class="disp-err">{$shipping_zipcode_err}</div></td>
                                            <td align="left">&nbsp;</td>
                                        </tr>
                                        <tr>
                                        	<td colspan="3" style="border-bottom:1px solid #cccccc;">&nbsp;</td>
                                        </tr>
										{if $smarty.request.invoice_key==''}
                                        <tr>
                                        	<td colspan="3" align="left" style="padding-bottom:10px;">
                                                <div class="per-field">
                                                    <div class="shippinglbl">Shipping Charges<span class="red-star">*</span>:</div>
                                                        <div class="top-fourpx">
                                                        <input type="radio" name="shipping_methods" value="usps" class="required" {if $shipping_methods == 'usps'} checked="checked" {/if} onchange="$('#shipping_options').remove();" />&nbsp;<span>USPS</span>&nbsp;
                                                        <input type="radio" name="shipping_methods" value="fedex" class="required" {if $shipping_methods == 'fedex'} checked="checked" {/if} onchange="$('#shipping_options').remove();" />&nbsp;<span>FedEx</span>
                                                        <input type="button" value="Calculate" class="calc-btn" onclick="shippingMethod($('input[name=shipping_methods]:radio:checked').val());" />
                                                	</div>
                                                </div>                      
                                                <div class="per-field">                                                   
                                                    <div id="options" class="fntsize"><div id="shipping_options"></div></div>
                                                </div>
                                                <div id="ship_price_err" class="disp-error">{$shipping_methods_err}<br />{$shipping_charge_err}</div>
                                            </td>
                                            <!--<td>&nbsp;</td>-->
                                        </tr>
										{else}
										<input type="hidden" name="shipping_methods" value="usps"  />
										<input type="hidden" name="shipping_charge" id="shipping_charge" value="{$count}"  />
										<input type="hidden" name="seller_count" id="seller_count" value="{$countTotal}"  />
										
										{/if}

                                     </table>
                                     </div>
                                     <div class="clear"></div>                                    
                                </div>
                                <div class="btn-box">     
                                    <input type="submit" value="Continue" class="submit-btn" />
                                    {*<input type="reset" value="Reset" class="submit-btn" />*}
                                </div>
                                <div class="clear"></div>
							</form>
                            <!--form listing ends here-->                       
                        </div>
                        <div class="clear"></div>
						<div style="clear:both;height: 0"></div>
						<div  style="text-align:center;">
						<div style="margin-top:10px;">
								<div>
								<a href="https://www.paypal.com/us/verified/pal=info%40mygodzillashop%2ecom" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/verification_seal.png" border="0" alt="Official PayPal Seal"></a>
								</div>
							</div>
					</div>
						<div style="clear:both;height: 0"></div>
                    </div>
                    </div>
                     </div>
                    <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                </div>
                <!--Page Body Ends-->
            </div>        
         </div></div></div>       
         
        </div>  
		
    </div>
	{include file="gavelsnipe.tpl"} 
	</div> 
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
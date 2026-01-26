{include file="admin_header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/formvalidation.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" align="center">
			<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="">
				<input type="hidden" name="mode" value="update_size" />
				<input type="hidden" name="encoded_string" value="{$encoded_string}" />
				<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Add Size Weight Cost</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top" width="25%"><span class="err">*</span> Name : </td>
						<td><input type="text" name="name" size="30" class="look" value="{$rowSize[0].name}"> 
								<br /><span class="err" id="name_err">{$name_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Length : </td>
						<td><input type="text" name="length" size="30" class="look" value="{$rowSize[0].length}"> 
								<br /><span class="err" id="length_err">{$length_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Width : </td>
						<td><input type="text" name="width" size="30" class="look" value="{$rowSize[0].width}"> 
								<br /><span class="err" id="width_err">{$width_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Height : </td>
						<td><input type="text" name="height" size="30" class="look" value="{$rowSize[0].height}"> 
								<br /><span class="err" id="height_err">{$height_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Weight(in lb) : </td>
						<td><input type="text" name="weight_lb" size="30" class="look" value="{$rowSize[0].weight_lb}"> 
								<br /><span class="err" id="weight_lb_err">{$weight_lb_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Weight(in oz) : </td>
						<td><input type="text" name="weight_oz" size="30" class="look" value="{$rowSize[0].weight_oz}"> 
								<br /><span class="err" id="weight_oz_err">{$weight_oz_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Packaging Cost : </td>
						<td><input type="text" name="packaging_cost" size="30" class="look" value="{$rowSize[0].packaging_cost}"> 
								<br /><span class="err" id="packaging_cost_err">{$packaging_cost_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
                        <td valign="top" >&nbsp;Packaging Type</td>
                        <td><input type="radio" name="flat_rolled" value="f" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
                         <input type="radio" name="flat_rolled" value="r" {if $rowSize[0].size_type == 'r'} checked="checked" {/if} /><label>&nbsp;Rolled</label>
                        </td>
                    </tr>
					<!--<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Billing Address</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Address1 : </td>
						<td><input type="text" name="address1" size="30" class="look" value="{$address1}"> 
								<br /><span class="err" id="address1_err">{$address1_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"> Address2 : </td>
						<td><input type="text" name="address2" size="30" class="look" value="{$address2}"> 
								<br /><span class="err" id="address2_err">{$address2_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Country : </td>
						<td>
                        	<select name="country_id" id="country_id" onchange="stateOptions($('#country_id').val(), 'state_textbox', 'state_select');" class="look">
                                <option value="" selected="selected">Select</option>
                                {html_options values=$countryID output=$countryName selected=$country_id}
                            </select>
                            <br /><span id="country_id_err" class="err">{$country_id_err}</span>
                        </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> State or Province : </td>
						<td>
                        {*<input type="text" name="state" size="30" class="look" value="{$state}">
						<br /><span class="err" id="state_err">{$state_err}</span>*}
                        
                        <input type="text" name="state_textbox" id="state_textbox" value="{$state_textbox}" class="look" />
                        <select name="state_select" id="state_select" class="look required" style="display:none;">
                            {*<option value="" selected="selected">Select</option>*}
                            {section name=counter loop=$us_states}
                            <option value="{$us_states[counter].name}" {if $us_states[counter].name == $state_select} selected="selected" {/if}>{$us_states[counter].name}</option>
                            {/section}
                        </select>
                        <br /><span class="err" id="state_err">{$state_textbox_err}{$state_select_err}</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> City : </td>
						<td><input type="text" name="city" size="30" class="look" value="{$city}" />
						<br /><span class="err" id="city_err">{$city_err}</span>
						</td>
					</tr>				
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Zip/Postal Code : </td>
						<td><input type="text" name="zipcode" size="30" class="look" value="{$zipcode}">
						<br /><span class="err" id="zipcode_err">{$zipcode_err}</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Day Phone : </td>
						<td><input type="text" name="contact_no" size="30" class="look" value="{$contact_no}"> 
						<br /><span class="err" id="contact_no_err">{$contact_no_err}</span></td>
					</tr>-->		 
					<!--<tr class="tr_bgcolor">
						<td valign="top">Mobile Number </td>
						<td><input type="text" name="user_mobile" size="30" maxlength="13" class="look" value="{$user_mobile}"> 
						<br /><span class="err" id="user_mobile_err">{$user_mobile_err}</span></td>
					</tr>-->
					<!--<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Shipping Address</b></td>
					</tr>-->
					<!--<tr class="tr_bgcolor">
					<td><input type="checkbox" name="sameasbilling" value="checkbox"
       onClick="shipsame(this.form);">&nbsp;Same as billing
                    </td>
                    <td>&nbsp;</td>
                    </tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Firstname : </td>
						<td><input type="text" name="shipping_firstname" size="30" class="look" value="{$shipping_firstname}"> 
						<br /><span class="err" id="shipping_firstname_err">{$shipping_firstname_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Lastname : </td>
						<td><input type="text" name="shipping_lastname" size="30" class="look" value="{$shipping_lastname}" />
						<br /><span class="err" id="shipping_lastname_err">{$shipping_lastname_err}</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Address1: </td>
						<td><input type="text" name="shipping_address1" size="30" class="look" value="{$shipping_address1}">
						<br /><span class="err" id="shipping_address1_err">{$shipping_address1_err}</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"> Shipping Address2: </td>
						<td><input type="text" name="shipping_address2" size="30" class="look" value="{$shipping_address2}">
						<br /><span class="err" id="shipping_address2_err">{$shipping_address2_err}</span>
						</td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Country: </td>
						<td>
                            <select name="shipping_country_id" id="shipping_country_id" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');" class="look">
                                <option value="" selected="selected">Select</option>
                                {html_options values=$countryID output=$countryName selected=$shipping_country_id}
                            </select>
                            <br /><span id="shipping_country_id_err" class="err">{$shipping_country_id_err}</span>
                        </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping State: </td>
						<td>
                            {*<input type="text" name="shipping_state" size="30" class="look" value="{$shipping_state}">
                            <br /><span class="err" id="shipping_state_err">{$shipping_state_err}</span>*}
                            <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" value="{$shipping_state_textbox}" class="look required" />
                            <select name="shipping_state_select" id="shipping_state_select" class="look required" style="display:none;">
                                {*<option value="" selected="selected">Select</option>*}
                                {section name=counter loop=$us_states}
                                <option value="{$us_states[counter].name}" {if $us_states[counter].name == $shipping_state_select} selected="selected" {/if}>{$us_states[counter].name}</option>
                                {/section}
                            </select>
                            <br /><span class="err">{$shipping_state_textbox_err}{$shipping_state_select_err}</span>
						</td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping City: </td>
						<td><input type="text" name="shipping_city" size="30" class="look" value="{$shipping_city}">
						<br /><span class="err" id="shipping_city_err">{$shipping_city_err}</span>
						</td>
					</tr>					
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span>Shipping Zipcode: </td>
						<td><input type="text" name="shipping_zipcode" size="30" class="look" value="{$shipping_zipcode}">
						<br /><span class="err" id="shipping_zipcode_err">{$shipping_zipcode_err}</span>
						</td>
					</tr>				  
					<tr class="tr_bgcolor">
						<td valign="top">Newsletter Subscription </td>
						<td><input type="checkbox" name="nl_subscr" class="" value="1" {if $nl_subscr == 1} checked='checked' {/if} ><br /><span class="err" id="nl_subscr_err">{$nl_subscr_err}</span></td>
					</tr>-->
					<!--					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Credit Card Details</b></td>
					</tr>
-->					
					<!--<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Card Type: </td>
						<td>
                        	<select name="card_type" id="card_type" class="look">
                                <option value="" selected="selected">Select</option>
                                <option value="American Express" {if $card_type == "American Express"} selected="selected" {/if}>American Express</option>
                                <option value="Diners Club Carte Blanche" {if $card_type == "Diners Club Carte Blanche"} selected="selected" {/if}>Diners Club Carte Blanche</option>
                                <option value="Diners Club" {if $card_type == "Diners Club"} selected="selected" {/if}>Diners Club</option>
                                <option value="Discover" {if $card_type == "Discover"} selected="selected" {/if}>Discover</option>
                                <option value="Diners Club Enroute" {if $card_type == "Diners Club Enroute"} selected="selected" {/if}>Diners Club Enroute</option>
                                <option value="JCB" {if $card_type == "JCB"} selected="selected" {/if}>JCB</option>
                                <option value="Maestro" {if $card_type == "Maestro"} selected="selected" {/if}>Maestro</option>
                                <option value="MasterCard" {if $card_type == "MasterCard"} selected="selected" {/if}>MasterCard</option>
                                <option value="Solo" {if $card_type == "Solo"} selected="selected" {/if}>Solo</option>
                                <option value="Switch" {if $card_type == "Switch"} selected="selected" {/if}>Switch</option>
                                <option value="Visa" {if $card_type == "Visa"} selected="selected" {/if}>Visa</option>
                                <option value="Visa Electron" {if $card_type == "Visa Electron"} selected="selected" {/if}>Visa Electron</option>
                                <option value="LaserCard" {if $card_type == "LaserCard"} selected="selected" {/if}>LaserCard</option>
                            </select>
                            <br /><span class="err">{$card_type_err}</span>
                        </td>
					</tr>-->
					<!--<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Card Number: </td>
						<td><input type="text" name="credit_card_no" id="credit_card_no" value="{$credit_card_no}" class="look" /><br /><span class="err">{$credit_card_no_err}</span></td>
					</tr>					
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Security Code: </td>
						<td><input type="password" name="security_code" id="security_code" value="" class="look" /><br /><span class="err">{$security_code_err}</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Expiry Date: </td>
						<td>
                            <select name="expired_mnth" id="expired_mnth" class="look" style="width:50px;">
                                {section name=mnth start=1 loop=13 step=1}
                                <option value="{$smarty.section.mnth.index}" {if $smarty.section.mnth.index==$expired_mnth} selected="selected" {/if}>{$smarty.section.mnth.index}</option>
                                {/section}
                            </select>                         
                            <select name="expired_yr" id="expired_yr" class="look" style="width:60px;">
                                {section name=year start=2005 loop=2021 step=1}
                                <option value="{$smarty.section.year.index}" {if $smarty.section.year.index==$expired_yr} selected="selected" {/if}>{$smarty.section.year.index}</option>
                                {/section}
                            </select>
                            <br /><span class="err">{$expired_mnth_err}{$expired_yr_err}</span>
                         </td>
					</tr>-->
					<tr class="tr_bgcolor">
						<td align="center" colspan="2" class="bold_text" valign="top">
						<input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$decoded_string}'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
	

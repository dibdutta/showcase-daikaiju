{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
    //$("#frm_profile").validate();
	//stateOptions($('#country_id').val(), 'state_textbox', 'state_select');
	//stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});
function shipsame(form){

	if(form.sameasbilling.checked){

		form.shipping_firstname.value = form.firstname.value;
		form.shipping_lastname.value = form.lastname.value;
		form.shipping_address1.value = form.address1.value;
		form.shipping_address2.value = form.address2.value;
		form.shipping_city.value = form.city.value;
		form.shipping_zipcode.value = form.zipcode.value;

		if(form.country_id.type == "Select"){
			var bCountryIdx = form.country_id.selectedIndex;
			form.shipping_country_id.options[bCountryIdx].selected = true;
		}else{
			form.shipping_country_id.value = form.country_id.value;
			
			if(form.country_id.value == 230){
				form.shipping_state_select.value = form.state_select.value;
			}else{
				form.shipping_state_textbox.value = form.state_textbox.value;
			}
			
			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}

	}else{
		form.shipping_firstname.value = {/literal} "{$profile[0].shipping_firstname}" {literal};
		form.shipping_lastname.value = {/literal} "{$profile[0].shipping_lastname}" {literal};
		form.shipping_address1.value = {/literal} "{$profile[0].shipping_address1}" {literal};
		form.shipping_address2.value  = {/literal} "{$profile[0].shipping_address2}" {literal};
		form.shipping_city.value = {/literal} "{$profile[0].shipping_city}" {literal};
		form.shipping_zipcode.value = {/literal} "{$profile[0].shipping_zipcode}" {literal};
		if(form.shipping_country_id.type == "Select"){
			form.shipping_country_id.options[0].selected = true;
		}else{
			form.shipping_country_id.value = {/literal} "{$profile[0].shipping_country_id}" {literal};
			 
			if(form.shipping_country_id.value == 230){
				form.shipping_state_select.value = {/literal} "{$profile[0].shipping_state}" {literal};
			}else{
				form.shipping_state_textbox.value = {/literal} "{$profile[0].shipping_state}" {literal};
			}
			
			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}
	}
}
</script>
{/literal}
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
                        <h1>Profile</h1>
                        <p>Fields marked with <span class="mandatory">*</span> are mandatory </p>
                   </div>
                           
                      
                       <div class="dashboard-main"> 
                    <div class="right-midbg">   
                        <div class="mid-rept-bg">                
                            <div class="">
                                <!--<span>Fields marked <span class="mandatory">*</span> are mandatory</span>  -->
                                <div class="formheading-area">
                                    
                                     <div class="dashblock_profile" style="float:none;"> 
                                        <h3>Enter your details</h3></div>
                                    
                                 </div>
                                {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                                <form name="frm_profile" action="" method="post" id="frm_profile">
                                <input type="hidden" name="mode" value="update_profile">
                                    <div class="formarea gnrl-listing">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td><label>Username<span class="red-star">*</span></label></td>
                                                <td><label>First Name<span class="red-star">*</span></label></td>
                                                <td><label>Last Name<span class="red-star">*</span></label></td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><input type="text" value="{$profile[0].username}"   readonly="readonly" class="register-txtfield"/></td>
                                                <td valign="top">
                                                    <input type="text" name="firstname" id="firstname" value="{$profile[0].firstname}" class="register-txtfield required" />
                                                    <div class="disp-err">{$firstname_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="lastname" value="{$profile[0].lastname}" class="register-txtfield required" />
                                                    <div class="disp-err">{$lastname_err}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>Email Address<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Address1<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Address2</label></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <input type="text" name="email" value="{$profile[0].email}" class="register-txtfield required email" />
                                                    <div class="disp-err">{$email_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="address1" value="{$profile[0].address1}" class="register-txtfield required" />
                                                    <div class="disp-err">{$address1_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="address2" value="{$profile[0].address2}" class="register-txtfield" />
                                                    <div class="disp-err">{$address2_err}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>Country<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Province/State</label></td>
                                                <td valign="top"><label>City<span class="red-star">*</span></label></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    {*<select name="country_id" id="country_id" class="selectbox required">
                                                        <option value="" selected="selected">Select</option>
                                                        {html_options values=$countryID output=$countryName selected=$profile[0].country_id}
                                                    </select>*}
                                                    <select name="country_id" id="country_id" class="selectbox required" onchange="stateOptions(this.value, 'state_textbox', 'state_select');">
                                                        <option value="" selected="selected">Select</option>
                                                        {html_options values=$countryID output=$countryName selected=$profile[0].country_id}
                                                    </select>
                                                    <div class="disp-err">{$country_id_err}</div>
                                                </td>
                                                <td valign="top">
                                                    {*<input type="text" name="state" value="{$profile[0].state}" class="register-txtfield required" />
                                                    <div class="disp-err">{$state_err}</div>*}
                                                    <input type="text" name="state_textbox" id="state_textbox" class="input_textbox required" {if $profile[0].country_id != 230} value="{$profile[0].state}"   {else} style="display:none;" {/if} />
                                                    <select name="state_select" id="state_select" class="selectbox required" {if $profile[0].country_id != 230} style="display:none;" {/if}>
                                                        {*<option value="" selected="selected">Select</option>*}
                                                        {section name=counter loop=$us_states}
                                                        <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].name == $profile[0].state || $us_states[counter].abbreviation == $profile[0].state} selected="selected" {/if}>{$us_states[counter].name}</option>
                                                        {/section}
                                                    </select>
                                                    <div class="disp-err">{$state_textbox_err}{$state_select_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="city" value="{$profile[0].city}" class="register-txtfield required" />
                                                    <div class="disp-err">{$city_err}</div>
                                                </td>                                                
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>Zipcode<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Day Phone<span class="red-star">*</span></label></td>
                                                <td valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <input type="text" name="zipcode" value="{$profile[0].zipcode}" class="register-txtfield required" />
                                                    <div class="disp-err">{$zipcode_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="contact_no" value="{$profile[0].contact_no}" maxlength="12" class="register-txtfield  required number" />
                                                    <div class="disp-err">{$contact_no_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="checkbox" name="nl_subscr" value="1" {if $profile[0].newsletter_subscription == 1} checked='checked' {/if} style="padding-top:10px;" />
                                                    <span>Newsletter Subscription</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>                               
                                    <!--Shipping info starts-->
                                    <div class="formheading-area">
                                    
                                     <div class="dashblock_profile" style="float:none;"> 
                                        <h3> Enter your shipping details</h3></div>
                                    
                                 </div>                                 
                                    <div class="formarea gnrl-listing">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                            	<td valign="top"><span><input type="checkbox" name="sameasbilling" value="checkbox" onClick="shipsame(this.form);">&nbsp;Same as billing</span></td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>First Name<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Last Name<span class="red-star">*</span></label></td>
                                                <td valign="top"><label>Address1<span class="red-star">*</span></label></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <input type="text" name="shipping_firstname" value="{$profile[0].shipping_firstname}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_firstname_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="shipping_lastname" value="{$profile[0].shipping_lastname}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_lastname_err}</div>
                                                </td>
                                                <td valign="top">
                                                    <input type="text" name="shipping_address1" value="{$profile[0].shipping_address1}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_address1_err}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><label>Address2</label></td>
                                                <td valign="top"><label>Country<span class="red-star">*</span></label></td>                                           
                                                <td valign="top"><label>Province/State</label></td> 
                                            </tr>
                                            <tr>
                                                <td valign="top">
                                                    <input type="text" name="shipping_address2" value="{$profile[0].shipping_address2}" class="input_textbox" />
                                                    <div class="disp-err">{$shipping_address2_err}</div>
                                                </td>
                                                <td valign="top">
                                                    {*<select name="shipping_country_id" id="shipping_country_id" class="selectbox required">
                                                        <option value="" selected="selected">Select</option>
                                                        {html_options values=$countryID output=$countryName selected=$profile[0].shipping_country_id}
                                                    </select>
                                                    <div class="disp-err">{$shipping_country_id_err}</div>*}
                                                    <select name="shipping_country_id" id="shipping_country_id" class="selectbox required" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');">
                                                        <option value="" selected="selected">Select</option>
                                                        {html_options values=$countryID output=$countryName selected=$profile[0].shipping_country_id}
                                                    </select>
                                                    <div class="disp-err">{$shipping_country_id_err}</div>
                                                </td>
                                                <td valign="top">
                                                    {*<input type="text" name="shipping_state" value="{$profile[0].shipping_state}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_state_err}</div>*}
                                                    <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" {if $profile[0].shipping_country_id != 230} value="{$profile[0].shipping_state}" {/if} class="input_textbox required" {if $profile[0].shipping_country_id == 230} style="display:none;" {/if} />
                                                    <select name="shipping_state_select" id="shipping_state_select" class="selectbox required" {if $profile[0].shipping_country_id != 230} style="display:none;" {/if}>
                                                        {*<option value="" selected="selected">Select</option>*}
                                                        {section name=counter loop=$us_states}
                                                        <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $profile[0].shipping_state || $us_states[counter].name == $profile[0].shipping_state} selected="selected" {/if}>{$us_states[counter].name}</option>
                                                        {/section}
                                                    </select>
                                                    <div class="disp-err">{$shipping_state_textbox_err}{$shipping_state_select_err}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td valign="top"><label>City<span class="red-star">*</span></label></td>
                                                <td valign="top"> <label>Zipcode<span class="red-star">*</span></label></td>                                                
                                            </tr>
                                            <tr> 
                                            	<td valign="top">
                                                    <input type="text" name="shipping_city" value="{$profile[0].shipping_city}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_city_err}</div>
                                                </td>                                           
                                                <td valign="top">
                                                    <input type="text" name="shipping_zipcode" value="{$profile[0].shipping_zipcode}" class="input_textbox required" />
                                                    <div class="disp-err">{$shipping_zipcode_err}</div>
                                                </td>                                                
                                            </tr>
                                        </table>
                                    </div> 
                                    <!--Shipping info ends-->                               
<!--                                    <div class="formheading-area">-->
<!--                                        <div class="righthdr">-->
<!--                                            <img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}credit-card.png" width="24" height="24" border="0" />-->
<!--                                            <span>Enter your card details</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="formarea">-->
<!--                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">-->
<!--											<tr>-->
<!--                                            	<td valign="top"><span><input type="checkbox" name="update_cc" value="1" onClick="if(this.checked) $('#credit_card_no').val(''); else $('#credit_card_no').val('XXXXXXXXXX'+{$card[0].last_digit});" {if $update_cc == 1} checked="checked" {/if}>&nbsp;Update Credit Card Info</span></td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td valign="top"><label>Card Type<span class="red-star">*</span></label></td>-->
<!--                                                <td valign="top"><label>Card Number<span class="red-star">*</span></label></td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td valign="top">-->
<!--                                                    {*if $card[0].card_type==''*}-->
<!--                                                        <select name="card_type" id="card_type" class="selectbox required">-->
<!--                                                            <option value="" selected="selected">Select</option>-->
<!--                                                            <option value="Amex" {if $card[0].card_type == "Amex"} selected="selected" {/if}>American Express</option>-->
<!--                                                            <option value="Discover" {if $card[0].card_type == "Discover"} selected="selected" {/if}>Discover</option>-->
<!--                                                            <option value="MasterCard" {if $card[0].card_type == "MasterCard"} selected="selected" {/if}>MasterCard</option>-->
<!--                                                            <option value="Visa" {if $card[0].card_type == "Visa"} selected="selected" {/if}>Visa</option>-->
<!--                                                        </select>-->
<!--                                                    {*else}-->
<!--                                                        <input type="text" name="card_type" id="card_type"  value="{$card[0].card_type}" readonly="readonly" class="input_textbox" />-->
<!--                                                    {/if*}-->
<!--                                                    <div class="disp-err">{$card_type_err}</div>-->
<!--                                                </td>-->
<!--                                                <td valign="top">-->
<!--                                                {*if $card[0].last_digit!=''*} -->
<!--                                                    <input type="text" name="credit_card_no" id="credit_card_no" value="{if $update_cc == 1}{$credit_card_no}{else}XXXXXXXXXX{$card[0].last_digit}{/if}" class="input_textbox" {*readonly="readonly"*} /><div class="disp-err">{$credit_card_no_err}</div>-->
<!--                                                {*else}-->
<!--                                                    <input type="text" name="credit_card_no" id="credit_card_no" class="input_textbox creditcard" /><div class="disp-err">{$credit_card_no_err}</div>-->
<!--                                                {/if*}-->
<!--                                                </td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td valign="top"><label>Security Code<span class="red-star">*</span></label></td>-->
<!--                                                <td valign="top"> <label>Expiry Date<span class="red-star">*</span></label></td>-->
<!--                                            </tr>-->
<!--                                            <tr>-->
<!--                                                <td valign="top">-->
<!--                                                    <input type="password" name="security_code" id="security_code" value="" class="input_textbox required" />-->
<!--                                                    <div class="disp-err">{$security_code_err}</div>-->
<!--                                                </td>-->
<!--                                                <td valign="top">-->
<!--                                                    <select name="expired_mnth" id="expired_mnth" class="selectbox" style="width:50px;">-->
<!--                                                        {section name=mnth start=1 loop=13 step=1}-->
<!--                                                        <option value="{$smarty.section.mnth.index}" {if $smarty.section.mnth.index==$expiry_month} selected="selected" {/if}>{$smarty.section.mnth.index}</option>-->
<!--                                                        {/section}-->
<!--                                                        </select>                         -->
<!--                                                        <select name="expired_yr" id="expired_yr" class="selectbox" style="width:60px;">-->
<!--                                                        {section name=year start=2012 loop=2021 step=1}-->
<!--                                                        <option value="{$smarty.section.year.index}" {if $smarty.section.year.index==$expiry_year} selected="selected" {/if}>{$smarty.section.year.index}</option>-->
<!--                                                        {/section}-->
<!--                                                    </select>-->
<!--                                                    <div class="disp-err">{$expired_mnth_err}{$expired_yr_err}</div>-->
<!--                                                </td>-->
<!--                                            </tr>-->
<!--                                        </table>-->
<!--                                    </div>                               -->
                                    <div class="btn-box">
                                        <label></label>
                                        <input type="submit" value="Submit" class="submit-btn" />
                                        <input type="reset" value="Reset" class="submit-btn" /> 
                                    </div>                                    
                                </form>                        
                            </div>
                            <div class="clear"></div>
                        </div>
                     </div>
                     </div>
                        
                       <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                        
                    </div>
                    <!--Page body Ends-->
                   
                </div>
            </div> 
            
            </div></div></div>       
            
        </div> 
		{include file="gavelsnipe.tpl"}   
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
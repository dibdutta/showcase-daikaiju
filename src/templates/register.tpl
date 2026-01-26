{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	//$("#register").validate();
	stateOptions($('#country_id').val(), 'state_textbox', 'state_select');
	stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});

//<!--
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
		form.shipping_firstname.value = "";
		form.shipping_lastname.value = "";
		form.shipping_address1.value = "";
		form.shipping_address2.value  = "";
		form.shipping_city.value = "";
		form.shipping_state_textbox.value = "";
		//$('#shipping_state_textbox').show();
		//$('#shipping_state_select').hide();
		form.shipping_zipcode.value = "";
		if(form.shipping_country_id.type == "Select"){
			 form.shipping_country_id.options[0].selected = true;
		}else{
			 form.shipping_country_id.value = "";
		}
		
		stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
	}
}
//-->

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
                <!--Page Body Starts-->
                <div class="innerpage-container-main"> 
                           	
                
                <div class="dashboard-main">
                                <h1>Register Now</h1>
                                <p>Fields marked with <span class="mandatory">*</span> are mandatory</p>
                                </div>
                
                 <!--<div class="black-midrept">
                                <span class="white-txt"><strong>Register Now</strong></span>
                                
                            </div><div class="black-right-crnr"></div>
                            <div class="black-left-crnr"></div>-->
                
                <div class="left-midbg"> 
                    <div class="right-midbg">
                <div class="mid-rept-bg">                
                    <div class="inner-area-general" style="margin:-30px 0 0 -45px;" >
                       <!-- <span>Fields marked <span class="red-star">*</span> are mandatory</span>     -->                   
                        <div class="formheading-area">
                            <div class="lefthdr">&nbsp;</div>
                            <!-- form listings starts here-->
                                <div class="righthdr dashboard-main"> 
                                    <!--<img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}user.png" width="22" height="22" border="0" />-->
                                    <h2>Enter your details</h2>
                                </div>
                                <div class="clear"></div>
                            </div>
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
						<form name="frmacc" action="" method="post" id="register">
                            <input type="hidden" name="mode" value="register">
							<div class="formarea">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr><input type="hidden" name="ip" value="" class="input_textbox required" />
                                        <td valign="top"><label>First Name<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Last Name<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Email Address<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><input type="text" name="firstname" value="{$firstname}" class="input_textbox required" /><div class="disp-err">{$firstname_err}</div></td>
                                        <td valign="top"><input type="text" name="lastname" value="{$lastname}" class="input_textbox required" /><div class="disp-err">{$lastname_err}</div></td>
                                        <td valign="top"><input type="text" name="email" value="{$email}" class="input_textbox required email" /><div class="disp-err">{$email_err}</div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><label>Username<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Password<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Confirm Password<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><input type="text" name="username" value="{$username}" class="input_textbox required" /><div class="disp-err">{$username_err}</div></td>
                                        <td valign="top"><input type="password" name="password" id="password" value="{$password}" class="input_textbox required" /><div class="disp-err">{$password_err}</div></td>
                                        <td valign="top"> <input type="password" name="cpassword" id="cpassword" value="{$cpassword}" class="input_textbox required" /><div class="disp-err">{$cpassword_err}</div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><label>Address1<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Address2</label></td>
                                        <td valign="top"><label>Country<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><input type="text" name="address1" value="{$address1}" class="input_textbox required" /><div class="disp-err">{$address1_err}</div></td>
                                        <td valign="top"><input type="text" name="address2" value="{$address2}" class="input_textbox" /><div class="disp-err">{$address2_err}</div></td>
                                        <td valign="top">
                                            <select name="country_id" id="country_id" class="selectbox required" onchange="stateOptions(this.value, 'state_textbox', 'state_select');">
                                            <option value="" selected="selected">Select</option>
                                            {html_options values=$countryID output=$countryName selected=$country_id}
                                            </select>
                                            <div class="disp-err">{$country_id_err}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><label>Province/State</label></td>
                                        <td valign="top"><label>City<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Zipcode<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                        <input type="text" name="state_textbox" id="state_textbox" value="{$state_textbox}" class="input_textbox required" />
                                        <select name="state_select" id="state_select" class="selectbox required" style="display:none;">
                                            <option value="" selected="selected">Select</option>
                                            {section name=counter loop=$us_states}
                                            <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $state_select} selected="selected" {/if}>{$us_states[counter].name}</option>
                                            {/section}
                                        </select>
                                        <div class="disp-err">{$state_textbox_err}{$state_select_err}</div>
                                        </td>
                                        <td valign="top"><input type="text" name="city" value="{$city}" class="input_textbox required" /><div class="disp-err">{$city_err}</div></td>
                                        <td valign="top"><input type="text" name="zipcode" value="{$zipcode}" class="input_textbox required" /><div class="disp-err">{$zipcode_err}</div></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><label>Day Phone<span class="red-star">*</span></label></td>
                                        <td colspan="2" valign="top">&nbsp;</td>		
                                    </tr>
                                    <tr>
                                        <td valign="top"><input type="text" name="contact_no" value="{$contact_no}" maxlength="12" class="input_textbox required number" /><p style="font-size: 11px; margin: 0px; padding: 0px; line-height: 12px;">submit numbers only, no dashes or spaces</p><div class="disp-err">{$contact_no_err}</div></td>
                                        <td colspan="2" valign="top">&nbsp;</td>		
                                    </tr>
                                </table>
                            </div>
                           <!--Shipping info starts-->
                            <div class="formheading-area">
                                <div class="righthdr dashboard-main" style="padding-top:15px;">
                                    <!--<img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}shipping.png" width="31" height="23" border="0" />-->
                                    <h2>&nbsp;Enter your shipping details</h2>                                
                                </div>
                            </div>
                            <div class="formarea">
                             	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                		<td valign="top"><input type="checkbox" name="sameasbilling" value="checkbox" onClick="shipsame(this.form);" {if $sameasbilling == 'checkbox'} checked="checked" {/if}><span>&nbsp;Same as billing</span></td>
                                	</tr>
                                	<tr>
                                    	<td valign="top"><label>First Name<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Last Name<span class="red-star">*</span></label></td>
                                        <td valign="top"><label>Address1<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">
                                        	<input type="text" name="shipping_firstname" value="{$shipping_firstname}" class="input_textbox required" />
                                        	<div class="disp-err">{$shipping_firstname_err}</div>
                                        </td>
                                        <td valign="top">
                                            <input type="text" name="shipping_lastname" value="{$shipping_lastname}" class="input_textbox required" />
                                            <div class="disp-err">{$shipping_lastname_err}</div>
                                        </td>
                                        <td valign="top">
                                            <input type="text" name="shipping_address1" value="{$shipping_address1}" class="input_textbox required" />
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
                                        	<input type="text" name="shipping_address2" value="{$shipping_address2}" class="input_textbox" />
                                        	<div class="disp-err">{$shipping_address2_err}</div>
                                        </td>
                                        <td valign="top">
                                            <select name="shipping_country_id" id="shipping_country_id" class="selectbox required" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');">
                                            <option value="" selected="selected">Select</option>
                                            {html_options values=$countryID output=$countryName selected=$shipping_country_id}
                                            </select>
											<div class="disp-err">{$shipping_country_id_err}</div>
                                        </td>
                                        <td valign="top">
                                        	{*<input type="text" name="shipping_state" value="{$shipping_state}" class="input_textbox required" />
                                        	<div class="disp-err">{$shipping_state_err}</div>*}
                                            
                                            
                                            <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" value="{$shipping_state_textbox}" class="input_textbox required" />
                                            <select name="shipping_state_select" id="shipping_state_select" class="selectbox required" style="display:none;">
                                                <option value="" selected="selected">Select</option>
                                                {section name=counter loop=$us_states}
                                                <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $shipping_state_select} selected="selected" {/if}>{$us_states[counter].name}</option>
                                                {/section}
                                            </select>
                                            <div class="disp-err">{$shipping_state_textbox_err}{$shipping_state_select_err}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top"><label>City<span class="red-star">*</span></label></td>                                        
                                        <td valign="top"><label>Zipcode<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                        	<input type="text" name="shipping_city" value="{$shipping_city}" class="input_textbox required" />
                                        	<div class="disp-err">{$shipping_city_err}</div>
                                        </td>
                                    	<td valign="top">
                                            <input type="text" name="shipping_zipcode" value="{$shipping_zipcode}" class="input_textbox required" />
                                            <div class="disp-err">{$shipping_zipcode_err}</div>
                                        </td>
                                    </tr>
                                </table>
                             </div>                            
                              <div class="formheading-area">
                             <div class="righthdr dashboard-main" style="padding-top:15px;">
                             <!--<img class="imgprpty" src="{$smarty.const.CLOUD_STATIC}security-high.png" width="22" height="22" border="0"  />-->
                              <h2>Security code</h2></div>
                             </div>
                            <div class="formarea">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                 <tr>
                                        <td width="50%"> <label>Security Code</label></td>
                                        <td><label>Verify Code<span class="red-star">*</span></label></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">
                                        <img src="{$actualPath}/securimage/securimage_show.php?sid={php} echo md5(uniqid(time())); {/php}" alt="CAPTCHA code" align="middle" id="image" /><a href="{$actualPath}/securimage/securimage_play.php"><img src="{$actualPath}/securimage/images/audio_icon.gif" alt="Listen to security code" border="0" /></a><a href="#" onclick="document.getElementById('image').src = 'securimage/securimage_show.php?sid=' + Math.random(); return false"><img src="{$actualPath}/securimage/images/refresh.gif" alt="Refresh security code" border="0" /></a>
                                        </td>
                                        <td><input type="text" name="code" value="" class="input_textbox required" equalTo='' /><div class="disp-err">{$code_err}</div></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="formarea-white">
                                <div class="per-field"><label></label><input type="checkbox" name="agree" value="1" class="required" /><span>&nbsp;I have read and agree to the Terms of use</span><div class="disp-err">{$agree_err}</div></div>
                                <div class="per-field" style="display:none;"><label></label><input type="checkbox" name="newsletter_subscription" value="1" {if $newsletter_subscription == 1} checked="checked" {/if} class="" /><span>&nbsp;Subscribe to E-mail Newsletter</span></div>
                                <div class="clear"></div>
                            </div>
                            <div class="btn-box">
                                <label></label>
                                <input type="submit" value="Submit" class="submit-btn" />
                                <input type="reset" value="Reset" class="submit-btn" />
                            </div>
						</form>
                        <div class="clear"></div>
                    </div>
                 <div class="clear"></div>
                </div>
                
                  </div>
                </div>
                
            </div>
                <!--Page Body Ends-->
            </div>        
             </div></div></div>       
            
        </div> 
		
    </div>
    
</div>
{include file="gavelsnipe.tpl"}   
</div>
<div class="clear"></div>
</div>
{include file="foot.tpl"}
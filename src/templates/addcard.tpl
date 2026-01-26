{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#frm_card").validate();
});
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
    
    	<div id="inner-left-container">
            <div class="innerpage-container-main">
            	
                <!--Page body Starts-->
                  <div class="innerpage-container-main">  
                <div class="black-topbg-main">
                    <div class="black-left-crnr"></div>
                    <div class="black-midrept">
                        <span class="white-txt"><strong>Add Card Details</strong></span>
                    </div>
                    <div class="black-right-crnr"></div>
                </div>
                <div class="mid-rept-bg">                
                    <div class="inner-area-general">
                                               
                       {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                         <form name="frm_card" action="" method="post" id="frm_card">
						<input type="hidden" name="mode" value="credit_card">
                    	<div class="formarea">
                        <!--<label>First Name<span class="red-star">*</span></label>
                        <input type="text" name="firstname" id="firstname" value="" size="32" class="input_textbox required" /><div class="disp-err">{$firstname_err}</div>
                        <label>Last Name<span class="red-star">*</span></label>
                        <input type="text" name="lastname" id="lastname" value="" size="32" class="input_textbox required" /><div class="disp-err">{$lastname_err}</div>-->
                        
                        <label>Card Type<span class="red-star">*</span></label>
                        {if $profile[0].card_type==''}
                        <select name="card_type" id="card_type" class="selectbox required">
						<option value="" selected="selected">Select</option>
                        <option value="American Express">American Express</option>
                        <option value="Diners Club Carte Blanche">Diners Club Carte Blanche</option>
                        <option value="Diners Club">Diners Club</option>
                        <option value="Discover">Discover</option>
                        <option value="Diners Club Enroute">Diners Club Enroute</option>
                        <option value="JCB">JCB</option>
                        <option value="Maestro">Maestro</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="Solo">Solo</option>
                        <option value="Switch">Switch</option>
                        <option value="Visa">Visa</option>
                        <option value="Visa Electron">Visa Electron</option>
                        <option value="LaserCard">LaserCard</option>
						</select>
                        {else}
                        <input type="text" name="card_type" id="card_type"  value="{$profile[0].card_type}" readonly="readonly" size="32" class="input_textbox" />
                        {/if}
						<div class="disp-err">{$card_type_err}</div> 
                        <label>Card Number<span class="red-star">*</span></label>
                        <input type="text" name="credit_card_no" id="credit_card_no" {if $profile[0].last_digit!=''} value="XXXXXXXXXX{$profile[0].last_digit}" readonly="readonly" {/if} size="32" class="input_textbox required " /><div class="disp-err">{$credit_card_no_err}</div>
                        <label>Security Code<span class="red-star">*</span></label>
                        <input type="text" name="security_code" id="security_code" {if $profile[0].security_code!=''} value="XXX" readonly="readonly" {/if} value="" size="32" class="input_textbox required " /><div class="disp-err">{$security_code}</div><br/>
                        
                         <label>Expiry Date<span class="red-star">*</span></label>
                        {if $profile[0].expiry_date==''} 
                        <select name="expired_mnth" id="expired_mnth" class="selectbox" style="width:50px;">
                        {section name=mnth start=1 loop=13 step=1}
						<option value="{$smarty.section.mnth.index}" >{$smarty.section.mnth.index}</option>
                        {/section}
                        </select> 
                        
                        <select name="expired_yr" id="expired_yr" class="selectbox" style="width:60px;">
                        {section name=year start=2005 loop=2021 step=1}
						<option value="{$smarty.section.year.index}" >{$smarty.section.year.index}</option>
                        {/section}
                        </select>
                        <div class="disp-err">{$category_err}</div>
                        {else}
                        <input type="text" name="card_type" id="card_type"  value="{$profile[0].expiry_date}" readonly="readonly" size="32" class="input_textbox" />
                        {/if}
                        <br/>
                        {if $profile[0].last_digit==''}
                        <input type="submit" value="Submit" class="submit-btn" />
                        <input type="reset" value="Reset" class="submit-btn" onclick="check_reset()" />
                        {/if}
                        </div>
                        </form>
                      
                    </div>

                </div>
            </div>
                <!--Page body Ends-->
                <div class="btom-main-bg"></div>
            </div>
        </div>        
        {include file="right-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#paymentoption").validate();
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
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
            <div id="inner-left-container">
                <!--Page Body Starts-->
                <div class="innerpage-container-main">            	
               <div class="dashboard-main">
                        <h1>Billing Info</h1>
                        <p>Fields marked <span class="red-star">*</span> are mandatory</p>
                   </div>
                
                
                
                <div class="left-midbg"> 
                <div class="right-midbg"> 
               	 <div class="mid-rept-bg">                
                    <div class="inner-area-general">
                                               
                        
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
						<form name="paymentoption" id="paymentoption" action="" method="post">
                            <input type="hidden" name="mode" value="finalorder">
                            <input type="hidden" name="auction_id" value="{$auction_id}">
                            <input type="hidden" name="invoice_id" value="{$invoice_id}">
							<div class="formarea" style="position:relative;">
                                <div class="per-field">
                                    <label>First Name<span class="red-star">*</span></label>
                                    <input type="text" name="firstname" value="{$firstname}" class="input_textbox required" /><div class="disp-err">{$firstname_err}</div>
                                </div>
                                <div class="per-field">
                                    <label>Last Name<span class="red-star">*</span></label>
                                    <input type="text" name="lastname" value="{$lastname}" class="input_textbox required" /><div class="disp-err">{$lastname_err}</div>
                                </div>
                                <div class="per-field">
                                    <label>Card Type<span class="red-star">*</span></label>
                                        <select name="cc_type" class="input_textbox required">
                                            <option value="Visa" {if $cc_type == 'Visa selected'} selected="selected" {/if}>Visa</option>
                                            <option value="MasterCard" {if $cc_type == 'MasterCard'} selected="selected" {/if}>MasterCard</option>                                        
                                            <option value="Discover" {if $cc_type == 'Discover'} selected="selected" {/if}>Discover</option>
                                            <option value="Amex" {if $cc_type == 'Amex'} selected="selected" {/if}>American Express</option>
                                        </select>
                                        <div class="disp-err">{$credit_card_type_err}</div>
                                </div>
                                <div class="per-field">
                                    <label>Card Number<span class="red-star">*</span></label>
                                    <input type="text" name="cc_number" value="{$cc_number}" class="input_textbox required" /><div class="disp-err">{$cc_number_err}</div>
                                </div>
                                <div class="per-field">
                                    <label>Expiration Date<span class="red-star">*</span></label>
                                    {html_select_date prefix='exp_' time=$time start_year='-0' end_year='+30' display_days=false month_value_format=%m month_format=%m class="input_textbox" style="width:65px;"}
                                    <div class="disp-err">{$exp_year_err}</div>
                                </div>
                                <div class="per-field">
                                    <label>Card Verification Number<span class="red-star">*</span></label>
                                    <input type="password" name="cvv2Number" maxlength="5" value="{$cvv2Number}" class="input_textbox required" style="width:50px;" /><div class="disp-err">{$cvv2Number_err}</div>
                                </div>  
                                <div style="clear:both;"></div>                          
							</div>
                            <div class="btn-box">
                                <label>&nbsp;</label>
                                <input type="submit" value="Continue" class="submit-btn" />
                                {*<input type="reset" value="Reset" class="submit-btn" />*}
                            </div>
                            
						</form>                        
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
                <!--Page Body Ends-->
            </div>   
        </div></div></div>      
            
        </div> 
		{include file="gavelsnipe.tpl"}     
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
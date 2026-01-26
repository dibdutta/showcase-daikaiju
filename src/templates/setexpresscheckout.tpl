{include file="header.tpl"}
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
                <div class="innerpage-container-main">  
                        <div class="dashboard-main">
                        <h1>PayPal Pro Express Checkout</h1>
                   </div>  	
                
                <div class="left-midbg"> 
                <div class="right-midbg"> 
               	 <div class="mid-rept-bg"> 
               	  {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                
                    <div class="inner-area-general" style="width: 685px;">
						<div class="formarea" style="margin-left:0; text-align:center; width:100%;">
						<input type="hidden" name="invoice_id" value="{$smarty.request.invoice_id}">
							<form {if $smarty.const.PHP_SELF == '/cart.php' } action="https://movieposterexchange.com/classes/paypal_pro_express/ReviewOrder.php" {else} action="https://{$paypal_url}/classes/paypal_pro_express/ReviewInvoice.php?invoice_id={$smarty.request.invoice_id}" {/if} method="POST">
								<input type=hidden name=paymentType value='Sale' >
								<input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
							</form> 
						</div>
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
         {include file="gavelsnipe.tpl"}  
    </div>
</div>
{include file="foot.tpl"}
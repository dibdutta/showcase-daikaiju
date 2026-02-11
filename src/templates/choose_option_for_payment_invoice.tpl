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
            <!--Page body Starts-->
            <div class="innerpage-container-main">                
                <div class="innerpage-container-main">  
                        <div class="dashboard-main">
                        <h1>Choose Payment Option</h1>
                   </div>  	
                   
                        
                       
                   
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    
                    <div class="mid-rept-bg">                
                        <div class="inner-area-general" style="width: 685px;">
                            {*<span>Fields marked <span class="mandatory">*</span> are mandatory</span>*}
                            <div class="formarea" style="margin-left:0; text-align:center; width:100%;">
                                <div class="bulkupload" style="width: 455px; text-align: center; margin: 0px auto;" >
                                    <div class="bulkinner">
                                        <div class="for-options">
                                            <div class="activity">Activities:</div>
                                            <input type="radio" name="fixed" value="1" onclick="$(location).attr('href','{$actualPath}/my_invoice?mode=do_direct_payment&invoice_id={$smarty.request.invoice_id}');" /><span>Using Credit Card</span>&nbsp;&nbsp;
                                            <input type="radio" name="weekly" value="2" onclick="$(location).attr('href','{$actualPath}/my_invoice?mode=do_express_checkout&invoice_id={$smarty.request.invoice_id}');" /><span>Using Paypal Account</span>&nbsp;&nbsp;
                                           {* <input type="radio" name="monthly" value="3" onclick="$(location).attr('href','{$actualPath}/my_invoice?mode=phone_order&invoice_id={$smarty.request.invoice_id}');" /><span>Phone Order</span> &nbsp;&nbsp;   *}          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    
                    </div>
                    </div>
                    
                    
                </div>
               
            </div>
            <!--Page body Ends-->
        </div>      
         
         </div></div></div> 
        
    </div>
    {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
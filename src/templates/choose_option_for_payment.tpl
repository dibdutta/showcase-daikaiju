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
                          	
                   
                        
                        <div class="black-midrept">
                            <span class="white-txt"><strong>Choose Payment Option</strong></span>
                        </div><div class="black-right-crnr"></div>
                        <div class="black-left-crnr"></div>
                       
                   
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    
                    <div class="mid-rept-bg">                
                        <div class="inner-area-general">
                            {*<span>Fields marked <span class="mandatory">*</span> are mandatory</span>*}
                            <div class="formarea">
                                <div class="bulkupload">
                                    <div class="bulkinner">
                                        <div class="for-options">
                                            <div class="activity">Activities:</div>
                                            <input type="radio" name="fixed" value="1" onclick="$(location).attr('href','{$actualPath}/cart.php?mode=do_direct_payment');" /><span>Using Credit Card</span>
                                            <input type="radio" name="weekly" value="2" onclick="$(location).attr('href','{$actualPath}/cart.php?mode=do_express_checkout');" /><span>Using PayPal Account</span>
                                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    
                    </div>
                    </div>
                    
                     <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                    
                </div>
               
            </div>
            <!--Page body Ends-->
        </div>      
         
         </div></div></div> 
        {include file="user-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
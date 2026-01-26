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
                 <div class="dashboard-main">
                                <h1>Account Verification</h1>                               
                                </div>
                
                
                            
                <div class="left-midbg"> 
                    <div class="right-midbg">
                <div class="mid-rept-bg">                
                    <div class="inner-area-general" style="width: 685px;">
                                            
                        <div class="formarea" style="margin-left:0; text-align:center; width:100%;">
                                <div class="bulkupload" style="text-align: center; margin: 0px auto;" > 
                                    <div class="bulkinner">
                                        <div class="for-options">
                                            <div class="activity">
                                            {if $verify_status == "success" }
                                            	&nbsp;<img src="{$smarty.const.CLOUD_STATIC}success.png" height="22" width="22" />&nbsp; Account created successfully check your mail.
                                            {elseif $verify_status == "failed" && $errorMessage != ''}
                                            	<img src="{$smarty.const.CLOUD_STATIC}error.png" height="24" width="24" />
                                            {/if}
                                            </div>
                                            <div style="padding:5px 0 0 3px; font-size:12px;">{$errorMessage}</div>
                                        </div>
                                    </div>
                                </div>
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
		{include file="gavelsnipe.tpl"}   
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#changePassword").validate({
		
	});
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
                                <h1>Change Password</h1>
                                <p>Fields marked <span class="mandatory">*</span> are mandatory</p>
                                </div>
               
               
                   
               <div class="left-midbg"> 
               <div class="right-midbg">
                <div class="mid-rept-bg">                
                    <div class="inner-area-general" style="width: 685px;" >
                       
                            <form action="" method="post" name="changePassword" id="changePassword">
                                <input type="hidden" name="mode" value="save_password" />
                                
                                <div class="formarea" style="margin-left:0; text-align:center; width:100%;">
                                
                                	{if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}  
                                    <div class="per-field" style="text-align:left; width:510px;">
                                    <label style="width:150px;">Old Password<span class="red-star">*</span></label>
                                    <input type="password" name="oldpassword" value="{$oldpassword}" minlength="4" maxlength="16" class="input_textbox required" /><br /><span class="err">{$oldpassword_err}</span>
                                    </div>
                                    <div class="per-field" style="text-align:left; width:510px;">
                                    <label style="width:150px;">New Password<span class="red-star">*</span></label>
                                    <input type="password" name="newpassword" id="newpassword" value="{$newpassword}" minlength="4" maxlength="16" class="input_textbox required" /><br /><span class="err">{$newpassword_err}</span>
                                    </div>
                                    <div class="per-field" style="text-align:left; width:510px;">
                                    <label style="width:150px;">Retype New Password<span class="red-star">*</span></label>
                                    <input type="password" name="cnewpassword" id="cnewpassword" value="{$cnewpassword}" maxlength="16" equalTo="#newpassword" class="input_textbox required" /><br><span class="err">{$cnewpassword_err}</span>
                                    </div>                                
                                	<div class="clear"></div>
                                </div>
                                <div class="btn-box">
                                    <label></label>
                                    <input type="submit" value="Submit" class="submit-btn" />
                                    {*<input type="reset" value="Reset" class="submit-btn" />*}
                                </div>
                            </form>
                        
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
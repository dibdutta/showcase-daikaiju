{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#frm_forgetpass").validate();
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
                                <h1>Forgot Password</h1>  
                                <p>Fields marked <span class="mandatory">*</span> are mandatory</p>                             
                                </div>			
                            
                <div class="left-midbg"> 
                    <div class="right-midbg">
                <div class="mid-rept-bg">                
                    <div class="inner-area-general" style="width: 685px;">
                                         
                        <div class="formarea" style="margin-left:0; text-align:center; width:100%;">
                        <div class="messageBox">{if $smarty.request.key==1} 
						Your request has successfully been submitted. Please check your email and follow instructions. Thank you!
						{elseif $smarty.request.key==2}
						Failed to send mail. Please try again.
						{else}
						{$errorMessage}
						{/if}</div>
						<form name="frm_forgetpass" id="frm_forgetpass" action="" method="post">
                        	<input type="hidden" name="mode" value="send_password">
                        	<table align="center" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td align="left" style="vertical-align:middle; padding-right:6px;"><span>User Name or Email Address</span><span class="red-star">*</span></td>
                                    <td align="left"><input type="text" name="username" value="" size="32" class="input_textbox required" /><div id="username_err" class="disp-err">{$username_err}</div></td>
                                </tr>
                                <tr>
                                	<td align="left" colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td align="left">&nbsp;</td>
                                	<td align="left"><input type="submit" value="Submit" class="submit-btn" />&nbsp;{*<input type="reset" value="Reset" class="submit-btn" />*}</td>
                                </tr>
                            </table>
                            
                            
						</form>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                
                
                  </div>
                </div>
               
<div class="btom-right"></div>
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
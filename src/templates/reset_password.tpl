{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#frm_forgetpass").validate({
		rules: {
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#d_password"
			}
		},
		messages: {
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			}
		}
	});
	
});
</script>
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
                                <h1>Reset Password</h1>
                                <p>Fields marked <span class="mandatory">*</span> are mandatory</p>                               
                                </div>
                
                
                            
                <div class="left-midbg"> 
                    <div class="right-midbg">
                <div class="mid-rept-bg">                
                    {if $show_ind > 0}              
                    <div class="inner-area-general" style="width: 685px;">
                                         
                        <div class="formarea" style="margin-left:0; text-align:center; width:100%;" >
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
						<form name="frm_forgetpass" id="frm_forgetpass" action="" method="post">
                        	<input type="hidden" name="mode" value="reset_password">
                        	<input type="hidden" name="user_setpass_code" value="{$varify_id}">
                        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td align="left" width="125" style="vertical-align:middle;"><span>New Password</span><span class="red-star">*</span></td>
                                    <td align="left"><input id="d_password" type="password" name="password"  value="" size="32" class="input_textbox" /><div id="password_err" class="disp-err">{$password_err}</div></td>
                                </tr>
                                <tr>
                                	<td align="left" width="125" style="vertical-align:middle;"><span>Re-enter Password</span><span class="red-star">*</span></td>
                                    <td align="left"><input id="confirm_password" type="password" name="confirm_password"  value="" size="32" class="input_textbox"  /><div id="re_password_err" class="disp-err">{$re_password_err}</div></td>
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
                    {else}
                	<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">New password has been set.</td>
                                </tr></table>
                	{/if}
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
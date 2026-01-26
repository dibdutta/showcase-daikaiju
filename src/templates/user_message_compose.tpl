{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#message_compose").validate();
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
            <div class="innerpage-container-main">
            	
                <!--Page body Starts-->
				<div class="innerpage-container-main">            	
                    
                    
                    <div class="black-midrept">
                                <span class="white-txt"><strong>Compose Message</strong></span>
                                {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                            </div><div class="black-right-crnr"></div>
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                        <form method="post" action="" name="message_compose" id="message_compose">
                            <input type="hidden" name="mode" value="send_message">
                            <input type="hidden" name="encoded_string" value="{$encoded_string}">
                            <div class="inner-area-general"> 
                                <div class="formarea-listing">
                                    <table align="center" width="60%" border="0" cellspacing="3" cellpadding="3" class="listbox">		
                                        <tr>
                                            <td align="left" ><label>Subject :</label></td>
                                            <td align="left"><input type="text" name="message_subject" value="{$message_subject}" class="formlisting-txtfield required" size="70" style="width:400px;"><br /><div class="disp-err">{$message_subject_err}</div></td>
                                        </tr>
                                        <tr>
                                            <td  align="left" valign="top" style="width:100px; padding-top:30px;"><label>Message:</label><br /></td>
                                            <td align="left" >{$message_body}<br /><div class="disp-err">{$message_body_err}</div></td>
                                        </tr>
                                        {*<tr height="28">
                                            <td align="center" colspan="2"><input type="submit" name="" value="Post Message" class="submit-btn">&nbsp;&nbsp;<input type="button" name="" value="Cancel" class="submit-btn" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; "></td>
                                        </tr>*}
                                    </table>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="btn-box">
                                <label></label>
                                <input type="submit" name="" value="Post Message" class="submit-btn">
                               <input type="button" name="" value="Cancel" class="submit-btn" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; ">
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                     </div>
                </div>
				</div>
                <!--Page body Ends-->
                <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
            </div>
        </div>        
        </div></div></div>       
            {include file="user-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}
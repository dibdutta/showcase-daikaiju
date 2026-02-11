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
            <div class="innerpage-container-main">
            	
                <!--Page body Starts-->
                <div class="innerpage-container-main">            	
                    
                    
                    <div class="black-midrept">
                                <span class="white-txt"><strong>Message Details</strong></span>
                            </div><div class="black-right-crnr"></div>
                            <div class="black-left-crnr"></div>
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    
                    <div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="100%">
                                <table align="center" width="85%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
                                    <tr>
                                        <td align="right" width="15%" style="font-family:Tahoma;font-size:13px;" ><b>From&nbsp;:</b></td>
                                        <td align="left" style="font-family:Tahoma;font-size:13px;">{$message[0].message_from_username}</td>
                                    </tr>
                                    <tr>
                                        <td align="right"style="font-family:Tahoma;font-size:13px;"><b>Date&nbsp;:</b></td>
                                        <td align="left" style="font-family:Tahoma;font-size:13px;" >{$message[0].message_sent_dt}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-family:Tahoma;font-size:13px;"><b>Subject&nbsp;:</b></td>
                                        <td align="left" style="font-family:Tahoma;font-size:13px;">{$message[0].message_subject}</td>
                                    </tr>
                                    <tr>
                                        <td align="right" style="font-family:Tahoma;font-size:13px;"><b>Message&nbsp;:</b></td>
                                        <td align="left" style="font-family:Tahoma;font-size:13px;">{$message[0].message_body}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center">{if ($message[0].message_to == $user_id || $message[0].message_is_fromadmin == '1') && $message[0].message_is_fromadmin == '1'}{if $smarty.request.from=='myaccount'}<input type="button" name="" value="My Dashboard" class="submit-btn" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" />{else}<input type="button" name="" value="Back to Inbox" class="submit-btn" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" />{/if}&nbsp;&nbsp;<input type="button" name="delete" value="Delete" class="submit-btn" onclick="javascript: deleteConfirmRecord('{$actualPath}/send_message?mode=delete_message&message_id={$message[0].message_id}&encoded_string={$encoded_string}', 'Message'); return false;" />&nbsp;&nbsp;<input type="button" name="reply" id="btnreply" value="Reply" class="submit-btn" onclick="javascript: location.href='{$actualPath}/send_message?mode=reply&message_id={$message[0].message_id}&encoded_string={$encoded_string}';" />{else}<input type="button" name="" value="Back to Sent Item" class="btn-main-submit-btn" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" />{/if}</td>
                        </tr>
                    </table>
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
{include file="header.tpl"}
<div id="forinnerpage-container">
	<div id="wrapper">
		<div id="headerthemepanel">
	<!--Header Theme Starts-->
		  {include file="search-login.tpl"} 
	<!--Header Theme Ends-->
		</div>
    	 <!--Header themepanel Starts-->
    
    <!--Header themepanel Ends-->
    
    <div id="inner-container">
    {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
    	<div id="inner-left-container">
        
			 <div id="tabbed-inner-nav">
             <div class="tabbed-inner-nav-left">
             	<ul class="menu">
                	<li class="active"><a href="{$actualPath}/send_message.php"><span>Inbox</span></a></li>
                    <li><a href="{$actualPath}/send_message.php?mode=sent_messages"><span>Sent Items</span></a></li>
                    <li><a href="{$actualPath}/send_message.php?mode=compose&encoded_string={$encoded_string}"><span>Compose</span></a></li>
                </ul>
                <div class="tabbed-inner-nav-right"></div>
                </div>
             </div>
             
            <div class="innerpage-container-main">
            	<div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>
                
                <div class="left-midbg"> 
                <div class="right-midbg">
                <div class="mid-rept-bg">
                {if $total>0}	
                <!--    inner listing starts-->
                  
                  <div class="display-listing-main">
                  <div style="margin:0 0 0 15px"> 
						<div class="gnrl-listing">
                        <div style="margin:0 0 0 15px"> 
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                        <form name="listFrom" id="listForm" action="" method="post">
                            	<input type="hidden" name="encoded_string" value="{$encoded_string}" />
                        	<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                	<td width="3%">
                                    </td>
                                	<td width="15%"><strong>From</strong>
                                    </td>
                                    <td width="35%"><strong>Subject</strong>
                                    </td>
                                    <td width="20%">
                                    	<strong>Date</strong>
                                    </td>
                                    <td width="25%"><strong>Actions</strong>
                                    </td>
                                </tr>
                                {section name=counter loop=$messageRows}
                                <tr>
                                	<td><input type="checkbox" name="message_ids[]" value="{$messageRows[counter].message_id}" class="checkBox" /></td>
                                    <td align="left">&nbsp;{$messageRows[counter].message_from_username}</td>
                                    <td {if $messageRows[counter].message_is_new == '1'}style="font-weight:bolder;"{/if}><span><a href="{$actualPath}/send_message.php?mode=read&message_id={$messageRows[counter].message_id}&encoded_string={$encoded_string}">{$messageRows[counter].message_subject}</a></span>
                                    </td>
                                    <td>
                                    	{$messageRows[counter].send_date}
                                    </td>
                                    <td>
                                    	
                                
                                <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$actualPath}/send_message.php?mode=delete_message&message_id={$messageRows[counter].message_id}&encoded_string={$encoded_string}', 'Message'); return false;"><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" width="23" height="23" border="0" alt="delete" title="delete" /></a>
                                    </td>
                                </tr>
                                {/section}
                                
                                
                            </table>
                           
                        </div>
                        </div>					
                  </div>    
                  </div>
                 
                  <!--    inner listing ends-->
                  
                     <div class="top-display-panel">
                        <div class="right-area">
                        	{$pageCounterTXT}
                        </div>
                        
                         <div class="left-area">
                         	<div class="results-area">
                        	<span>{$displayCounterTXT}</span>
                           </div>
                            </div>
                            <div class="left-area">
                         	<div class="results-area">
                        	<span><a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</span>
                           </div>
                            </div>
                            <div class="right-area">
                        	<span><select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
												<option value="delete_all_messages">Delete Message</option>
											</select></span>
                        	</div>
                            </div>   
                    
                       </form>
                       {else}
                       <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry No Message in your Inbox.</td>
                                </tr></table>
                       {/if}
                    <div style="clear:both;"></div>
                </div>
                </div>
                </div>
                <div class="btm-mid"><div class="btom-left"></div></div>
                <div class="btom-right"></div>
            </div>
        </div>
        </div></div></div>   
    {include file="user-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
{include file="header.tpl"}
{literal}
<script type="text/javascript">
function delete_wantlist(){
	document.getElementById('mode').value="delete_wantlist";
}
</script>
{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
    <div id="headerthemepanel">
       		{include file="search-login.tpl"} 
    </div>
    <div id="inner-container2">
    {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
    	<div id="inner-left-container">
			 <div id="tabbed-inner-nav">
             <div class="tabbed-inner-nav-left">
             	<ul class="menu">
               		<li class="active"><a href="{$actualPath}/my_want_list"><span>My Want List</span></a></li>
                	<li><a href="{$actualPath}/my_want_list?mode=add&encoded_string={$encoded_string}"><span>Add to Want List</span></a></li>
                   
                </ul>
                
			 </div>	
             </div>
            <div class="innerpage-container-main">
            	<div class="top-mid"><div class="top-left"></div></div>
                
                 <div class="left-midbg"> 
                    <div class="right-midbg">   
                <div class="mid-rept-bg">
                {if $total>0}	
                <div class="top-display-panel3"> 
							<div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
							  </div>
						  </div>
                          
                  <div class="light-grey-bg-inner">
                          <div class="inner-grey2 SelectionBtnPanel">
                            <div style="float:left; padding:0px; margin:0px;">
                              <input type="button" class="select-all-btn" onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                              <input type="button" class="deselect-all-btn"  onclick="javascript: unMarkSelectedRows('listForm'); return false;" style=" cursor:pointer;" value=""/>
                            </div>
                            
                            </div>
                          <div class="clear"></div>
                        </div>
                  <div> 
                  <div class="display-listing-main">
                  <div>
						<div class="gnrl-listing">
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                        <form name="listFrom" id="listForm" action="my_want_list" method="post">
                            	<input type="hidden" name="mode" id="mode" value="edit_wantlist" />
                        	<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0" >
                            	<tr>
                                	<th width="25px"></th>
                                	<th class="tal">Poster Title</th>
                                    <th width="100px" class="tac">Action</th>
                                </tr>
                                {section name=counter loop=$wantlist}
                                <tr>
                                	<td class="tac"><input type="checkbox" name="auction_ids[]" value="{$wantlist[counter].wantlist_id}" class="checkBox" /><input type="hidden" name="wantlist_id[]" value="{$wantlist[counter].wantlist_id}" /></td>
                                    <td class="tal">{if $wantlist[counter].total_poster > 0}<a href="{$actualPath}/my_want_list?mode=details&wantlist_id={$wantlist[counter].wantlist_id}">{$wantlist[counter].poster_title}&nbsp;&nbsp;({$wantlist[counter].total_poster})</a>{else}{$wantlist[counter].poster_title}&nbsp;(0){/if}</td>
                                    <td class="tac"><a href="javascript:void(0)" class="view_link" onclick="javascript: deleteConfirmRecord('{$actualPath}/my_want_list?mode=delete_want&wantlist_id={$wantlist[counter].wantlist_id}&encoded_string={$encoded_string}', 'wantlist'); return false;"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/delete-icon.png" width="24" height="24" border="0" alt="Delete" title="Delete" /></a>
                                    	&nbsp;<a href="{$actualPath}/my_want_list?mode=edit_want&wantlist_id={$wantlist[counter].wantlist_id}&encoded_string={$encoded_string}" class="view_link" ><img src="https://d2m46dmzqzklm5.cloudfront.net/images/edit-icon2.png" width="24" height="24" border="0" alt="Edit" title="Edit" /></a>
                                    </td>
                                </tr>
                                {/section}
                                <!--<tr>
                                <td colspan="2" style="border-right:1px solid #ffffff;">{$pageCounterTXT}</td>
                                
                                <td style="border-left:1px solid #ffffff;">{$displayCounterTXT}</td>
                                </tr>-->
                                <tr>
                                <td colspan="2" style="border-right:1px solid #ffffff;"><span><a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</span></td>
                                <td><input type="submit" value="Delete selected" class="cancel-btn" id="delete_btn"  onclick="delete_wantlist()" /></td>
                                </tr>
                            </table>
                           
                        </div>					
                       
                  </div>
                 </div>
                 </div>
                 <div class="top-display-panel3"> 
							<div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
							  </div>
						  </div>
                       </form>
                       {else}
                       <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">There is no item in your want list.</td>
                                </tr></table>
                       {/if}
                    <div class="clear"></div>
                </div>
                </div>
                </div>
                <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
            </div>
        </div>
         </div></div></div>   
        	{include file="user-panel.tpl"}
    </div>
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
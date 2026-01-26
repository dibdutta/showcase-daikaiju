{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
    //$("#frm_profile").validate();
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
                        
                           <div class="dashboard-main" style="width: 960px;">
                                <h1>Advanced Search</h1>
                                <p>&nbsp;</p>
                                <div>
                            <!--<div class="black-midrept">
                                <span class="white-txt"><strong>Advanced Search</strong></span>
                            </div><div class="black-right-crnr"></div>
                            <div class="black-left-crnr"></div>-->
                            
                           <div class="left-midbg"> 
                    <div class="right-midbg">                  
                        <div class="mid-rept-bg">                
                            <div class="inner-area-general  whitebg" style="width: 920px;">
                                {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                    
                                <form name="frm_dorefinesrc" id="frm_dorefinesrc" action="" method="get">
                                <input type="hidden" name="mode" value="dorefinesrc" />
								<input type="hidden" name="list" value="{$smarty.request.list}" />
								<input type="hidden" name="auction_week_id" value="{$smarty.request.auction_week_id}" />
                                <input type="hidden" name="is_expired" value="0" />
                                    <div class="formarea-listing buylist asearch">                                
                                    <table cellpadding="0" cellspacing="0" border="0" class="refinebox">
                                        <tr>
                                            <td width="210px" valign="top" colspan="3"><label>Keyword{*<span class="red-star">*</span>*}</label></td>
                                            <td  valign="top" ><label>Select Fixed Or Auction{*<span class="red-star">*</span>*}</label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding-top:10px;"><input type="text" name="keyword" id="keyword" value="{$keyword}" class="midSearchbg" /></td>
                                            <td style="padding-top:10px;" >
											  <div class="sortblock">
												<select name="poster_type"  class="look">
													<option value="">Select</option>
													<option value="fixed">Fixed Items</option>
													<option value="weekly">Auction Items</option>												
												</select>
											  </div>	
											</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="4">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="4"><label><span class="red-star">*</span> Choose any combination of categories but you may only click one box per category</label></td>
                                        </tr>
                                        <tr>
                                            <td class="search-heading" width="180px" valign="top"><label>Size{*<span class="red-star">*</span>*}</label></td>
                                            <td class="search-heading" width="180px" valign="top"><label>Genre{*<span class="red-star">*</span>*}</label></td>
                                            <td class="search-heading" width="180px" valign="top"><label>Decade{*<span class="red-star">*</span>*}</label></td>
                                            <td class="search-heading" width="180px" valign="top"><label>Country{*<span class="red-star">*</span>*}</label></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="padding-top:10px;">
                                                <div class="refine-srch-box">
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 1 && $catRows[counter].cat_id !='34'}
                                                        <input type="checkbox" name="poster_size_id" value="{$catRows[counter].cat_id}" />&nbsp;{$catRows[counter].cat_value}<br />
                                                        {/if}
                                                    {/section}
                                                </div>
                                            </td>
                                             <td valign="top" style="padding-top:10px;">
                                                <div class="refine-srch-box">
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 2}
                                                        <input type="checkbox" name="genre_id" value="{$catRows[counter].cat_id}" />&nbsp;{$catRows[counter].cat_value}<br />
                                                        {/if}
                                                    {/section}
                                                </div>
                                            </td>
                                             <td valign="top" style="padding-top:10px;">
                                                <div class="refine-srch-box">
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 3}
                                                        <input type="checkbox" name="decade_id" value="{$catRows[counter].cat_id}" />&nbsp;{$catRows[counter].cat_value}<br />
                                                        {/if}
                                                    {/section}
                                                </div>
                                            </td>
                                            <td valign="top" style="padding-top:10px;">
                                                <div class="refine-srch-box">
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 4}
                                                        <input type="checkbox" name="country_id" value="{$catRows[counter].cat_id}" />&nbsp;{$catRows[counter].cat_value}<br />
                                                        {assign var="selected" value=""}
                                                        {/if}
                                                    {/section}
                                                </div>
                                            </td>
                                        </tr>
                                       
                                    </table>
                                    <div class="clear"></div>
                                    <div class="btn-box">     
                                        <input type="submit" value="Search" class="submit-btn" />
                                        {*<input type="reset" value="reset" class="submit-btn" />*}
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>                      
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                        </div>
                        </div>
                    <!--Page body Ends-->
                     <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                </div>
            </div>    
            
             </div></div></div> </div>   
            
        </div>
		
    </div>
    </div>
</div>
{include file="foot.tpl"}
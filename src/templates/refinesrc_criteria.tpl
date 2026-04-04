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
                                            <td valign="top" colspan="5"><label><span class="red-star">*</span> Choose any combination of categories but you may only click one box per category</label></td>
                                        </tr>
                                        <tr>
                                            <td class="search-heading" width="160px" valign="top"><label>Size</label></td>
                                            <td class="search-heading" width="160px" valign="top"><label>Genre</label></td>
                                            <td class="search-heading" width="200px" valign="top"><label>Category</label></td>
                                            <td class="search-heading" width="200px" valign="top"><label>Subcategory</label></td>
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
                                                <div class="refine-srch-box" style="height:auto; width:190px;">
                                                    <select name="shop_cat_id" id="refine_shop_cat_id" style="width:100%; border:none; font-size:11px; padding:3px 2px; background:#fff;">
                                                        <option value="">All Categories</option>
                                                        {section name=sc loop=$shopCatRows}
                                                        <option value="{$shopCatRows[sc].shop_cat_id}">{$shopCatRows[sc].shop_cat_name}</option>
                                                        {/section}
                                                    </select>
                                                </div>
                                            </td>
                                            <td valign="top" style="padding-top:10px;">
                                                <div class="refine-srch-box" style="height:auto; width:190px;">
                                                    <select name="subcategory_id" id="refine_subcategory_id" style="width:100%; border:none; font-size:11px; padding:3px 2px; background:#fff;">
                                                        <option value="">All Subcategories</option>
                                                    </select>
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
{literal}
<script type="text/javascript">
var subcatData = {/literal}{$subcatJson|default:'{}'}{literal};
(function() {
    var subcatSelect = document.getElementById('refine_subcategory_id');
    if (!subcatSelect) return;

    function populateSubcats(shopCatId) {
        while (subcatSelect.options.length > 1) subcatSelect.remove(1);
        var items = subcatData[shopCatId] || [];
        for (var i = 0; i < items.length; i++) {
            var opt = document.createElement('option');
            opt.value = items[i].subcat_id;
            opt.text  = items[i].subcat_value;
            subcatSelect.appendChild(opt);
        }
    }

    var shopCatSelect = document.getElementById('refine_shop_cat_id');
    if (shopCatSelect) {
        shopCatSelect.addEventListener('change', function() {
            populateSubcats(this.value);
        });
    }
})();
</script>
{/literal}
{include file="foot.tpl"}
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
                                            <td valign="top"><label>Keyword</label></td>
                                            <td valign="top"><label>Select Fixed Or Auction</label></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:10px;"><input type="text" name="keyword" id="keyword" value="{$keyword}" class="midSearchbg" /></td>
                                            <td style="padding-top:10px;">
											  <div class="sortblock">
												<select name="poster_type" class="look">
													<option value="">Select</option>
													<option value="fixed">Fixed Items</option>
													<option value="weekly">Auction Items</option>
												</select>
											  </div>
											</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2"><label><span class="red-star">*</span> Select a Category first, then choose one or more Subcategories</label></td>
                                        </tr>
                                        <tr>
                                            <td class="search-heading" width="200px" valign="top"><label>Category</label></td>
                                            <td class="search-heading" width="200px" valign="top"><label>Subcategory</label></td>
                                        </tr>
                                        <tr>
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
                                                <div class="refine-srch-box" id="refine_subcategory_box" style="width:190px; padding:4px; font-size:11px;"></div>
                                            </td>
                                        </tr>

                                    </table>
                                    <div class="clear"></div>
                                    <div class="btn-box">
                                        <input type="submit" value="Search" class="submit-btn" />
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
    var box = document.getElementById('refine_subcategory_box');
    if (!box) return;

    function populateSubcats(shopCatId) {
        box.innerHTML = '';
        var items = subcatData[shopCatId] || [];
        for (var i = 0; i < items.length; i++) {
            var label = document.createElement('label');
            label.style.display = 'block';
            var cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.name = 'subcategory_id';
            cb.value = items[i].subcat_id;
            label.appendChild(cb);
            label.appendChild(document.createTextNode('\u00a0' + items[i].subcat_value));
            box.appendChild(label);
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

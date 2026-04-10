{include file="header.tpl"}
<script type="text/javascript" src="{$actualPath}/wymeditor/jquery.wymeditor.min.js"></script>
<script type="text/javascript" src="{$actualPath}/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery-ui.min.js"></script>
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery.ui.plupload.css" type="text/css" />
{literal}
<script type="text/javascript">
jQuery(function() {
    jQuery('.wymeditor').wymeditor({
        toolsItems: [
            {'name': 'Bold', 'title': 'Strong', 'css': 'wym_tools_strong'},
            {'name': 'Italic', 'title': 'Emphasis', 'css': 'wym_tools_emphasis'},
            {'name': 'Superscript', 'title': 'Superscript', 'css': 'wym_tools_superscript'},
            {'name': 'Subscript', 'title': 'Subscript', 'css': 'wym_tools_subscript'},
            {'name': 'InsertOrderedList', 'title': 'Ordered_List', 'css': 'wym_tools_ordered_list'},
            {'name': 'InsertUnorderedList', 'title': 'Unordered_List', 'css': 'wym_tools_unordered_list'},
            {'name': 'Indent', 'title': 'Indent', 'css': 'wym_tools_indent'},
            {'name': 'Outdent', 'title': 'Outdent', 'css': 'wym_tools_outdent'},
            {'name': 'Undo', 'title': 'Undo', 'css': 'wym_tools_undo'},
            {'name': 'Redo', 'title': 'Redo', 'css': 'wym_tools_redo'},
            {'name': 'InsertTable', 'title': 'Table', 'css': 'wym_tools_table'},
            {'name': 'Paste', 'title': 'Paste_From_Word', 'css': 'wym_tools_paste'},
            {'name': 'ToggleHtml', 'title': 'HTML', 'css': 'wym_tools_html'},
            {'name': 'Preview', 'title': 'Preview', 'css': 'wym_tools_preview'}
        ],
        postInit: function(wym) {}
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    var uploader = $("#uploader").plupload({
        runtimes : 'html5,flash,silverlight,html4',
        url : "../upload.php?random={/literal}{$random}{literal}",
        max_file_size : '10mb',
        chunk_size: '1mb',
        resize : { width:200, height:200, quality:90, crop:true },
        filters : [
            {title:"Image files", extensions:"jpg,gif,png"},
            {title:"Zip files", extensions:"zip,avi"}
        ],
        rename: true,
        sortable: true,
        dragdrop: true,
        views: { list:true, thumbs:true, active:'thumbs' },
        flash_swf_url : '../plupload/js/Moxie.swf',
        silverlight_xap_url : '../plupload/js/Moxie.xap'
    });
    $("#posterUpload").validate();
});

function chkPosterSize(id){
    if(id!=''){
        var url = "bid_popup";
        $.get(url, {mode:'chkPosterSizeCount', id:id}, function(data){
            var newData = data.split("-");
            if(newData[0]==1){
                $("#flat_rolled").show();
                if(newData[1]=='f'){ $("#rolled").hide(); $("#folded").show(); $("#folded_selected")[0].checked=true; }
                else if(newData[1]=='r'){ $("#folded").hide(); $("#rolled").show(); $("#rolled_selected")[0].checked=true; }
            }else if(newData[0]==2){ $("#flat_rolled").show(); $("#rolled").show(); $("#folded").show(); }
        });
    }else{ $("#flat_rolled").hide(); }
}

function checkMinOffer(){
    if($('#is_consider').is(':checked')){ $("#minOfferDiv").show(); }
    else { $("#minOfferDiv").hide(); }
}

function submitForm(){
    var all = $(".plupload_file_name").map(function(){ return this.title; }).get();
    var res = all.join().split(",");
    var unqArr = Array.from(new Set(res)).filter(function(v){return v!=='';});
    $("#poster_images").val(unqArr.join());
    var checkedRadio = $("input[name='is_default']:checked");
    if(checkedRadio.length===0 && unqArr.length>0){ $("#is_default_hidden").val(unqArr[0]); }
    document.getElementById("posterUpload").submit();
}
</script>
<style>textarea{ overflow-y:auto; resize:none; }</style>
{/literal}

<div id="forinnerpage-container">
    <div id="wrapper">
        <div id="headerthemepanel">
            {include file="search-login.tpl"}
        </div>
        <div id="inner-container">
            {include file="right-panel.tpl"}
            <div id="center"><div id="squeeze"><div class="right-corner">
                <div id="inner-left-container">
                    <div class="innerpage-container-main">
                        <div class="dashboard-main">
                            <h1>Edit Fixed Price Listing</h1>
                            <p>Fields marked with <span class="mandatory">*</span> are mandatory</p>
                        </div>
                        <div class="left-midbg">
                        <div class="right-midbg">
                        <div class="mid-rept-bg">
                        {if $view_key=='0'}
                            <div class="inner-area-general" style="padding-top:0;">

                                <form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="mode" value="update_fixed" />
                                    <input type="hidden" name="cnt" id="cnt" value="{$cnt}" />
                                    <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                    <input type="hidden" name="auction_id" value="{$auctionRow[0].auction_id}" />
                                    <input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}" />
                                    <input type="hidden" name="random" id="random" value="{$random}" />
                                    <input type="hidden" name="chk_auction_asked_price" value="{$auctionRow[0].auction_asked_price}" />
                                    <input type="hidden" name="chk_auction_offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" />
                                    <input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
                                    <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" />
                                    <input type="hidden" name="is_default" id="is_default_hidden" />

                                    <div style="max-width:780px; margin:0 auto; font-family:Arial,Helvetica,sans-serif; font-size:13px;">

                                        <!-- Section: Poster Details -->
                                        <div style="background:#fff; border:1px solid #ddd; border-radius:4px; margin-bottom:16px;">
                                            <div style="background:#6b0000; color:#fff; font-weight:bold; font-size:13px; padding:8px 14px; border-radius:4px 4px 0 0;">Poster Details</div>
                                            <div style="padding:16px;">

                                                <div style="margin-bottom:14px;">
                                                    <label style="display:block; font-weight:bold; margin-bottom:4px;">Poster Title <span style="color:#c00;">*</span></label>
                                                    <input type="text" name="poster_title" value="{$posterRow[0].poster_title}" class="formlisting-txtfield required" style="width:100%; box-sizing:border-box;" />
                                                    <div class="disp-err">{$poster_title_err}</div>
                                                </div>

                                                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:14px;">
                                                    <div style="flex:1; min-width:180px;">
                                                        <label style="display:block; font-weight:bold; margin-bottom:4px;">Condition <span style="color:#c00;">*</span>
                                                            &nbsp;<a onclick="javascript:window.open('{$actualPath}/myselling?mode=faq','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" href="javascript:void(0)" class="FAQIcon"><img src="{$smarty.const.CLOUD_STATIC}faq_fixed.png" style="vertical-align:middle;" /></a>
                                                        </label>
                                                        <select name="condition" class="formlisting-txtfield required" style="width:100%;">
                                                            <option value="" selected="selected">Select</option>
                                                            {section name=counter loop=$catRows}
                                                            {if $catRows[counter].fk_cat_type_id == 5}
                                                                {section name=posterCatCounter loop=$posterCategoryRows}
                                                                    {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                                        {assign var="selected" value="selected"}
                                                                    {/if}
                                                                {/section}
                                                                <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                                {assign var="selected" value=""}
                                                            {/if}
                                                            {/section}
                                                        </select>
                                                        <div class="disp-err">{$condition_err}</div>
                                                    </div>
                                                    <div style="flex:1; min-width:180px;">
                                                        <label style="display:block; font-weight:bold; margin-bottom:4px;">Category</label>
                                                        <select name="shop_category" id="shop_category" class="formlisting-txtfield" style="width:100%;">
                                                            <option value="">Select (optional)</option>
                                                            {section name=sc loop=$shopCatRows}
                                                            <option value="{$shopCatRows[sc].shop_cat_id}" {if $selected_shop_cat_id == $shopCatRows[sc].shop_cat_id}selected="selected"{/if}>{$shopCatRows[sc].shop_cat_name}</option>
                                                            {/section}
                                                        </select>
                                                    </div>
                                                    <div style="flex:1; min-width:180px;">
                                                        <label style="display:block; font-weight:bold; margin-bottom:4px;">Subcategory</label>
                                                        <select name="subcategory" id="subcategory" class="formlisting-txtfield" style="width:100%;">
                                                            <option value="">Select (optional)</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div style="margin-bottom:14px;">
                                                    <label style="display:block; font-weight:bold; margin-bottom:4px;">Description <span style="color:#c00;">*</span></label>
                                                    <p style="font-size:11px; color:#666; margin:0 0 6px 0;">Please give a detailed description of your item including any restoration / backing</p>
                                                    <textarea class="wymeditor required" id="textDesc" name="poster_desc" style="width:100%; box-sizing:border-box;">{$posterRow[0].poster_desc|stripslashes}</textarea>
                                                    <div class="disp-err">{$poster_desc_err}</div>
                                                </div>

                                                <div id="flat_rolled" style="margin-bottom:14px;">
                                                    {if $posterRow[0].flat_rolled == 'flat'}
                                                    <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                    <div id="rolled" style="display:none;"><input id="rolled_selected" type="radio" name="flat_rolled" value="rolled" /><label>&nbsp;Rolled</label></div>
                                                    {elseif $posterRow[0].flat_rolled == 'rolled'}
                                                    <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" /><label>&nbsp;Folded&nbsp;</label></div>
                                                    <div id="rolled"><input id="rolled_selected" type="radio" name="flat_rolled" value="rolled" checked="checked" /><label>&nbsp;Rolled</label></div>
                                                    {/if}
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Section: Pricing -->
                                        <div style="background:#fff; border:1px solid #ddd; border-radius:4px; margin-bottom:16px;">
                                            <div style="background:#6b0000; color:#fff; font-weight:bold; font-size:13px; padding:8px 14px; border-radius:4px 4px 0 0;">Pricing</div>
                                            <div style="padding:16px;">

                                                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:14px;">
                                                    <div style="flex:1; min-width:160px;">
                                                        <label style="display:block; font-weight:bold; margin-bottom:4px;">Ask Price <span style="color:#c00;">*</span></label>
                                                        <div style="display:flex; align-items:center; gap:4px;">
                                                            <span style="font-weight:bold;">$</span>
                                                            <input type="text" name="asked_price" value="{$auctionRow[0].auction_asked_price}" maxlength="8" class="formlisting-txtfield-price required number" style="width:120px;" />
                                                            <span>.00</span>
                                                        </div>
                                                        <div class="list-err">{$asked_price_err}</div>
                                                    </div>
                                                    <div style="flex:2; min-width:200px;">
                                                        <label style="display:block; font-weight:bold; margin-bottom:8px;">&nbsp;</label>
                                                        <label style="cursor:pointer;">
                                                            <input type="checkbox" name="is_consider" {if $auctionRow[0].auction_reserve_offer_price >= 1} checked="checked" {/if} id="is_consider" value="1" onclick="checkMinOffer()" />
                                                            &nbsp;I will consider offers
                                                        </label>
                                                        <div id="minOfferDiv" style="margin-top:8px; {if $auctionRow[0].auction_reserve_offer_price == 0}display:none;{/if}">
                                                            <label style="display:block; font-weight:bold; margin-bottom:4px;">Min Offer Price</label>
                                                            <div style="display:flex; align-items:center; gap:4px;">
                                                                <span style="font-weight:bold;">$</span>
                                                                <input type="text" name="offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" maxlength="8" class="formlisting-txtfield-price" style="width:120px;" />
                                                                <span>.00</span>
                                                            </div>
                                                            <div class="list-err">{$offer_price_err}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label style="display:block; font-weight:bold; margin-bottom:4px;">Notes <span style="color:#888; font-weight:normal;">(not viewable to public)</span></label>
                                                    <textarea name="auction_note" style="width:100%; height:80px; box-sizing:border-box; border:1px solid #ccc; padding:6px; font-size:12px; font-family:Arial,Helvetica,sans-serif;">{$auctionRow[0].auction_note}</textarea>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Section: Photos -->
                                        <div style="background:#fff; border:1px solid #ddd; border-radius:4px; margin-bottom:16px;">
                                            <div style="background:#6b0000; color:#fff; font-weight:bold; font-size:13px; padding:8px 14px; border-radius:4px 4px 0 0;">Photos</div>
                                            <div style="padding:16px;">
                                                <p style="font-size:11px; color:#666; margin:0 0 10px 0;">
                                                    Recommended photo size: minimum 100KB (800px longest side) to 1.26MB (2000px longest side).<br/>
                                                    <strong>Please click Start Upload before submitting. Ensure no files remain Queued.</strong>
                                                </p>

                                                <div id="existing_photos" style="overflow:hidden; margin-bottom:10px;">
                                                    {section name=counter loop=$posterImageRows}
                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                        <div id="existing_{$countID}" style="float:left; width:110px; padding:0 4px 4px 0; text-align:center;">
                                                            <img src="{$posterImageRows[counter].image_path}" height="78" width="100" style="border:2px solid #ccc;" />
                                                            <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} />
                                                            <br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('existing_{$countID}', '{$posterImageRows[counter].poster_thumb}', 'existing')" style="cursor:pointer; margin-top:4px;" />
                                                            <span id="errexisting_{$countID}"></span>
                                                        </div>
                                                    {/section}
                                                </div>

                                                <div id="uploader"></div>
                                                <div class="list-err" style="margin-top:6px;">{$poster_images_err}</div>
                                                <div class="disp-err">{$is_default_err}</div>

                                                <div id="new_photos" style="overflow:hidden; padding:6px 0;">
                                                    {section name=counter loop=$poster_images_arr}
                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                        <div id="new_{$countID}" style="float:left; width:110px; padding:0 4px 4px 0; text-align:center;">
                                                            <img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" style="border:2px solid #ccc;" />
                                                            <br /><input type="radio" name="is_default" value="{$poster_images_arr[counter]}" />
                                                            <br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('new_{$countID}', '{$poster_images_arr[counter]}', 'new')" style="cursor:pointer; margin-top:4px;" />
                                                        </div>
                                                    {/section}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <div style="display:flex; justify-content:center; gap:10px; padding:8px 0 16px 0;">
                                            <input type="submit" value="Save Changes" class="submit-btn wymupdate" onclick="submitForm()" style="width:auto; padding:6px 20px; background:#111; background-image:none; text-align:center;" />
                                            <input type="reset" value="Reset" class="submit-btn" style="width:auto; padding:6px 20px; background:#111; background-image:none; text-align:center;" />
                                            <input type="button" value="Cancel" class="submit-btn" onclick="location.href='{$decoded_string}'" style="width:auto; padding:6px 20px; background:#555; background-image:none; text-align:center;" />
                                        </div>

                                    </div>
                                </form>
                            </div>
                        {else}
                            <div class="inner-area-general">Sorry, no such auction found.</div>
                        {/if}
                        <div class="clear"></div>
                        </div>
                        </div>
                        </div>
                    </div>
                    <!--Page body Ends-->
                </div>
            </div></div></div>
        </div>
        {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{literal}
<script type="text/javascript">
var subcatData = {/literal}{$subcatJson|default:'{}'}{literal};
(function() {
    var shopCatSelect = document.getElementById('shop_category');
    var subcatSelect  = document.getElementById('subcategory');
    if (!shopCatSelect || !subcatSelect) return;
    function populateSubcats(shopCatId, selectedId) {
        while (subcatSelect.options.length > 1) subcatSelect.remove(1);
        var items = subcatData[shopCatId] || [];
        for (var i = 0; i < items.length; i++) {
            var opt = document.createElement('option');
            opt.value = items[i].subcat_id;
            opt.text  = items[i].subcat_value;
            if (selectedId && items[i].subcat_id == selectedId) opt.selected = true;
            subcatSelect.appendChild(opt);
        }
    }
    populateSubcats(shopCatSelect.value, '{/literal}{$selected_subcat_id|default:""}{literal}');
    shopCatSelect.addEventListener('change', function() { populateSubcats(this.value, ''); });
})();
</script>
{/literal}
{include file="foot.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

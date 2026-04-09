{include file="header.tpl"}


<script type="text/javascript" src="{$actualPath}/javascript/autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="{$actualPath}/javascript/autocomplete/jquery.autocomplete.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/wymeditor/jquery.wymeditor.min.js"></script>
<script type="text/javascript" src="{$actualPath}/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery-ui.min.js"></script>
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery.ui.plupload.css" type="text/css" />
{literal}
<script type="text/javascript">

jQuery(function() {
	//document.getElementByName('textDesc').value="hello";
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
		             ]        	
		,
        postInit: function(wym) {

            //wym.hovertools();
            //wym.resizable();
        }
    });
});

</script>
<script type="text/javascript">
function clearAllRadios() {
	var radList = document.getElementsByName('radioList');
	for (var i = 0; i < radList.length; i++) {
	if(radList[i].checked) radList[i].checked = false;
	}
}
</script>
<script type="text/javascript">
$(document).ready(function() {   

	var uploader = $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "../upload.php?random={/literal}{$random}{literal}",
 
        // Maximum file size
        max_file_size : '10mb',
 
        chunk_size: '1mb',
 
        // Resize images on clientside if we can
        resize : {
            width : 200,
            height : 200,
            quality : 90,
            crop: true // crop to exact dimensions
        },
 
        // Specify what files to browse for
        filters : [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip,avi"}
        ],
 
        // Rename files by clicking on their titles
        rename: true,
         
        // Sort files
        sortable: true,
 
        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,
 
        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },
 
        // Flash settings
        flash_swf_url : '../plupload/js/Moxie.swf',
     
        // Silverlight settings
        silverlight_xap_url : '../plupload/js/Moxie.xap'
    });
	$("#posterUpload").validate();
    //autoComplete('poster_title');
	});


/*function deletePhoto(divID, photo){
    $("#"+divID).remove();
    $("#poster_images").val($("#poster_images").val().replace(photo+',', ""));
    $("#browse").show();    
}*/
function chkPosterSize(id){
	if(id!=''){
	var url = "bid_popup.php";
	$.get(url, {mode : 'chkPosterSizeCount', id : id}, function(data){
	var newData = data.split("-");
	document.getElementById('no_sizes').value=newData[0];
			if( newData[0] ==1){
				$("#flat_rolled").show();
				if(newData[1]=='f'){
					$("#rolled").hide();
					$("#folded").show();
					$("#folded_selected")[0].checked = true;
				}else if(newData[1]=='r'){
					$("#folded").hide();
					$("#rolled").show();
					$("#rolled_selected")[0].checked = true;
				}
				
			}else if(newData[0]==2){
				$("#flat_rolled").show();
				$("#rolled").show();
				$("#folded").show();
			}
	 	});	
		}else{
			$("#flat_rolled").hide();
		}
}
function checkMinOffer(){
	if ($('#is_consider').is(':checked')) {
	//alert('checked');
		$("#minOfferDiv").show();
	} else {
		// alert('unchecked');
		$("#minOfferDiv").hide();
	}
 }
 
 function submitForm(){
		var all = $(".plupload_file_name").map(function() {
			return this.title;
		}).get();
		var res = all.join().split(",");
		var unqArr = Array.from(new Set(res)).filter(function(v){return v!==''});
		var post_img=unqArr.join();
		$("#poster_images").val(post_img);
		var checkedRadio = $("input[name='is_default']:checked");
		if (checkedRadio.length === 0 && unqArr.length > 0) {
			$("#is_default_hidden").val(unqArr[0]);
		}
		document.getElementById("posterUpload").submit();
	}
</script>

<style>
textarea
{
        overflow-y:auto;
		resize:none;
}

</style>
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
                <!--Page body Starts-->
                <div class="innerpage-container-main">
                  
                   <div class="dashboard-main">
                        <h1>Manual Upload for Fixed Price Posters</h1>
                        <p>Fields marked with <span class="mandatory">*</span> are mandatory </p>
                   </div>
     
                       
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">                   
                        <div class="inner-area-general">
                           
                            <!-- form listings starts here-->
                            <form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" value="fixed_upload" />
                                <input type="hidden" name="cnt" id="cnt" value="{$cnt}" />
                                <input type="hidden" name="random" id="folder" value="{$random}" />
                                <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" />
                                <input type="hidden" name="is_default" id="is_default_hidden" />

                                <div style="max-width:780px; margin:0 auto; font-family:Arial,Helvetica,sans-serif; font-size:13px;">

                                    <!-- Section: Poster Details -->
                                    <div style="background:#fff; border:1px solid #ddd; border-radius:4px; margin-bottom:16px;">
                                        <div style="background:#6b0000; color:#fff; font-weight:bold; font-size:13px; padding:8px 14px; border-radius:4px 4px 0 0;">Poster Details</div>
                                        <div style="padding:16px;">

                                            <div style="margin-bottom:14px;">
                                                <label style="display:block; font-weight:bold; margin-bottom:4px;">Poster Title <span style="color:#c00;">*</span></label>
                                                <input type="text" name="poster_title" id="poster_title" value="{$poster_title}" class="formlisting-txtfield required" style="width:100%; box-sizing:border-box;" />
                                                <div class="disp-err">{$poster_title_err}</div>
                                            </div>

                                            <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:14px;">
                                                <div style="flex:1; min-width:180px;">
                                                    <label style="display:block; font-weight:bold; margin-bottom:4px;">Condition <span style="color:#c00;">*</span>
                                                        &nbsp;<a onclick="javascript:window.open('{$actualPath}/myselling.php?mode=faq','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" href="javascript:void(0)" class="FAQIcon"><img src="{$smarty.const.CLOUD_STATIC}faq_fixed.png" style="vertical-align:middle;" /></a>
                                                    </label>
                                                    <select name="condition" class="formlisting-txtfield required" style="width:100%;">
                                                        <option value="" selected="selected">Select</option>
                                                        {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 5}
                                                            <option value="{$catRows[counter].cat_id}" {if $condition == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
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
                                                <textarea class="wymeditor required" id="textDesc" name="poster_desc" style="width:100%; box-sizing:border-box;">{$poster_desc|stripslashes}</textarea>
                                                <div class="disp-err">{$poster_desc_err}</div>
                                            </div>

                                            <div id="flat_rolled" {if $flat_rolled==''} style="display:none;" {/if} style="margin-bottom:14px;">
                                                <div id="folded" {if $flat_rolled=='rolled' && $no_sizes!='2'} style="display:none;"{/if}>
                                                    <input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
                                                </div>
                                                <div id="rolled" {if $flat_rolled=='flat' && $no_sizes!='2'} style="display:none;"{/if}>
                                                    <input id="rolled_selected" type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label>
                                                </div>
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
                                                        <input type="text" name="asked_price" value="{$asked_price}" maxlength="8" class="formlisting-txtfield-price required number" style="width:120px;" />
                                                        <span>.00</span>
                                                    </div>
                                                    <div class="list-err">{$asked_price_err}</div>
                                                </div>
                                                <div style="flex:2; min-width:200px;">
                                                    <label style="display:block; font-weight:bold; margin-bottom:8px;">&nbsp;</label>
                                                    <label style="cursor:pointer;">
                                                        <input type="checkbox" name="is_consider" {if $is_consider == 1} checked="checked" {/if} id="is_consider" value="1" onclick="checkMinOffer()" />
                                                        &nbsp;I will consider offers
                                                    </label>
                                                    <div id="minOfferDiv" style="margin-top:8px; {if $is_consider != 1}display:none;{/if}">
                                                        <label style="display:block; font-weight:bold; margin-bottom:4px;">Min Offer Price</label>
                                                        <div style="display:flex; align-items:center; gap:4px;">
                                                            <span style="font-weight:bold;">$</span>
                                                            <input type="text" name="offer_price" value="{$offer_price}" maxlength="8" class="formlisting-txtfield-price" style="width:120px;" />
                                                            <span>.00</span>
                                                        </div>
                                                        <div class="list-err">{$offer_price_err}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label style="display:block; font-weight:bold; margin-bottom:4px;">Notes <span style="color:#888; font-weight:normal;">(not viewable to public)</span></label>
                                                <textarea name="auction_note" style="width:100%; height:80px; box-sizing:border-box; border:1px solid #ccc; padding:6px; font-size:12px; font-family:Arial,Helvetica,sans-serif;">{$auction_note}</textarea>
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
                                            <div id="uploader"></div>
                                            <div class="list-err" style="margin-top:6px;">{$poster_images_err}</div>
                                            <div class="disp-err">{$is_default_err}</div>
                                            <div id="photos" style="padding:10px 0; overflow:hidden;">
                                                {section name=counter loop=$poster_images_arr}
                                                    {assign var="countID" value=$smarty.section.counter.index+1}
                                                    <div id="photo_{$countID}" style="float:left; width:110px; padding:0 4px 4px 0; text-align:center;">
                                                        <img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" style="border:2px solid #ccc;" />
                                                        <br /><input type="radio" name="is_default" value="{$poster_images_arr[counter]}" {if $is_default == $poster_images_arr[counter]} checked="checked" {/if} />
                                                        <br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('photo_{$countID}', '{$poster_images_arr[counter]}', 'new')" style="cursor:pointer; margin-top:4px;" />
                                                    </div>
                                                {/section}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div style="display:flex; justify-content:center; gap:10px; padding:8px 0 16px 0;">
                                        <input type="submit" value="Submit Listing" class="submit-btn wymupdate" onclick="submitForm()" style="width:auto; padding:0 20px 3px 20px;" />
                                        <input type="reset" value="Reset" class="submit-btn" style="width:auto; padding:0 20px 3px 20px;" />
                                    </div>

                                </div>
                            </form> 
							
							
                            <!--form listing ends here-->                       
                        </div>
                        <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                    <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                   
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
    populateSubcats(shopCatSelect.value, '');
    shopCatSelect.addEventListener('change', function() { populateSubcats(this.value, ''); });
})();
</script>
{/literal}
{include file="foot.tpl"}

<script type="text/javascript" src="{$actualPath}/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

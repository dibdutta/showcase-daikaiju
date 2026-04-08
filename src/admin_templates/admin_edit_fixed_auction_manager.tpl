{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery.ui.plupload.css" type="text/css" />
{literal}
<script type="text/javascript">
$(document).ready(function() {

	var uploader = $("#uploader").plupload({
        runtimes : 'html5,flash,silverlight,html4',
        url : "../upload.php?random={/literal}{$random}{literal}",
        max_file_size : '10mb',
        chunk_size: '1mb',
        resize : {
            width : 200,
            height : 200,
            quality : 90,
            crop: true
        },
        filters : [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip,avi"}
        ],
        rename: true,
        sortable: true,
        dragdrop: true,
        views: {
            list: true,
            thumbs: true,
            active: 'thumbs'
        },
        flash_swf_url : '../plupload/js/Moxie.swf',
        silverlight_xap_url : '../plupload/js/Moxie.xap'
    });
});

	function chkPosterSize(id){
	    if(id!=""){
    	var url = "../bid_popup.php";
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
			$("#minOfferDiv").show();
		} else {
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
		document.getElementById("configManager").submit();
	}

</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Manage Poster / Auction</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="update_fixed">
							<input type="hidden" name="cnt" id="cnt" value="{$cnt}" />
							<input type="hidden" name="auction_id" value="{$smarty.request.auction_id}">
							<input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
							<input type="hidden" name="random" id="random" value="{$random}" />
							<input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
							<input type="hidden" name="chk_auction_asked_price" value="{$auctionRow[0].auction_asked_price}" />
							<input type="hidden" name="chk_auction_offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" />
							<input type="hidden" name="encoded_string" value="{$encoded_string}" />
							<input type="hidden" name="poster_images" id="poster_images" />
							<input type="hidden" name="is_default" id="is_default_hidden" />
							<input type="hidden" id="no_sizes" name="no_sizes" value="" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Poster SKU :</td>
												<td class="smalltext">{$auctionRow[0].poster_sku}</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="{$auctionRow[0].poster_title}" size="40" class="look" /><br /><span class="err">{$poster_title_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Category :</td>
												<td class="smalltext">
													<select name="shop_category" id="shop_category" class="look">
														<option value="">Select (optional)</option>
														{section name=sc loop=$shopCatRows}
														<option value="{$shopCatRows[sc].shop_cat_id}" {if $selected_shop_cat_id == $shopCatRows[sc].shop_cat_id}selected="selected"{/if}>{$shopCatRows[sc].shop_cat_name}</option>
														{/section}
													</select>
												</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Subcategory :</td>
												<td class="smalltext">
													<select name="subcategory" id="subcategory" class="look">
														<option value="">Select (optional)</option>
													</select>
												</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                <select name="condition" class="look">
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
                                            	</select><br /><span class="err">{$condition_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext">
												{$poster_desc}<br /><span class="err">{$poster_desc_err}</span>
												</td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
												<div id="flat_rolled">
												{if $auctionRow[0].flat_rolled == 'flat'}
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected" type="radio" name="flat_rolled" value="rolled" /><label>&nbsp;Rolled</label></div>
                                                {elseif $auctionRow[0].flat_rolled == 'rolled'}
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected" type="radio" name="flat_rolled" value="rolled" checked="checked" /><label>&nbsp;Rolled</label></div>
												{/if}
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:680px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$posterImageRows}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="existing_{$countID}" style="float:left; width:110px;height:150px; padding:0px 2px 0 1px; margin:0px;"><img src="{$posterImageRows[counter].image_path}" />
                                                                        <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} />
                                                                        <br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('existing_{$countID}', '{$posterImageRows[counter].poster_thumb}', 'existing')" />
                                                                        <span id="errexisting_{$countID}"></span>
                                                                        </div>
                                                                	{/section}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
																<div id="uploader"></div>
																<div id="photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$poster_images_arr}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="photo_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" /><br /><input type="radio" name="is_default" style="margin-left:40px;" value="{$poster_images_arr[counter]}" {if $is_default == $poster_images_arr[counter]} checked="checked" {/if} /><br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('photo_{$countID}', '{$poster_images_arr[counter]}', 'new')" style="margin-left:30px;" /></div>
                                                                    {/section}
                                                                </div>
																<div class="err">{$poster_images_err}</div>
                                                                <div class="err">{$is_default_err}</div>
                                                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px;"><span class="err">Please click on <b>Start Upload</b> before Submitting the Form.<br/>Make sure there shouldn't be any files <b>Queued</b></span></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Ask Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="{$auctionRow[0].auction_asked_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$asked_price_err}</span></td>
											</tr>

                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">&nbsp;</td>
												<td class="smalltext"><input type="checkbox" name="is_consider" {if $auctionRow[0].auction_reserve_offer_price >= 1} checked="checked" {/if} id="is_consider" value="1" onclick="checkMinOffer()" >
                                                <label>I will consider offers</label></td>
											</tr>
											<tr class="tr_bgcolor" id="minOfferDiv" {if $auctionRow[0].auction_reserve_offer_price == 0} style="display:none;" {/if}>
												<td class="bold_text" valign="top">Min Offer Price :</td>
												<td class="smalltext"><input type="text" name="offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$offer_price_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Notes :</td>
												<td class="smalltext"><textarea name="auction_note" class="look" cols="70" rows="6">{$auctionRow[0].auction_note}</textarea><br /><span class="err">{$auction_note_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">ImDB link :</td>
												<td class="smalltext"><input type="text" name="imdb_link" value="{$auctionRow[0].imdb_link}" class="look" /></td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="button" name="" value="Save Changes" class="button" onclick="submitForm()" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
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
{include file="admin_footer.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

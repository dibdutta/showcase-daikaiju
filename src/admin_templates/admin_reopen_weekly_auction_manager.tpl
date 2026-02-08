{include file="admin_header.tpl"}
{literal}
<script type="text/javascript">
function choose_option(val){
	//$("#choose_option").hide();
	if(val=='fixed'){
		$("#formarea").hide();
		$("#formarea_fixed").show();
		document.getElementById('is_consider').checked = false;
	}else if(val=='weekly'){
		$("#formarea_fixed").hide();
		$("#minOfferDiv").hide();
		$("#formarea").show();
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
		function add_text_desc(id){		
		var url = "../ajax.php?mode=get_cond_desc&id=" + id;
		jQuery.ajax({
		type : 'GET',
		url : url,
		data: {
		 },
		 beforeSend : function(){
			//loading
			},
		 success : function(data){
		  if(data!=''){
			var dataHtml = data;
			FCKeditorAPI.GetInstance('poster_desc').Focus() ;
			FCKeditorAPI.GetInstance('poster_desc').InsertHtml("<p>&nbsp;"+dataHtml+"</p>")
			//FCKeditorAPI.GetInstance('poster_desc').InsertHtml("<p>&nbsp;Hello Add Me</p>")
			}else{
			FCKeditorAPI.GetInstance('poster_desc').Focus() ;
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
		}
		});
		
		
		
		
		//alert(oEditor);
		//document.getElementById('poster_desc___Frame').value="Hello Add me";
	}
</script>
{/literal}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>

<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
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
							<input type="hidden" name="mode" value="reopen_weekly_auction">
                            <input type="hidden" name="auction_id" value="{$auctionRow[0].auction_id}">
                            <input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
                            <input type="hidden" name="random" value="{$random}" />
                            <input type="hidden" name="decode_string" value="{$decoded_string}" />
                            <input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								{if $is_empty!='1'}
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Poster SKU :</td>
												<td class="smalltext">{$posterRow[0].poster_sku}</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="{$posterRow[0].poster_title}" size="40" class="look"  /><br /><span class="err">{$poster_title_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 1}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            {/if}
                                                        {/section}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	</select><br /><span class="err">{$poster_size_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look" >
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            {/if}
                                                        {/section}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	</select><br /><span class="err">{$genre_err}</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Dacade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look" >
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 3}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            {/if}
                                                        {/section}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	</select><br /><span class="err">{$dacade_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                <select name="country" class="look" >
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 4}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            {/if}
                                                        {/section}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	</select><br /><span class="err">{$country_err}</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                <select name="condition" class="look" onchange="add_text_desc(this.value)">
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
												<td class="smalltext">{$poster_desc}<br /><span class="err">{$poster_desc_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                               
												<div id="flat_rolled" >
												{if $posterRow[0].flat_rolled == 'flat'}
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
                                                {elseif $posterRow[0].flat_rolled == 'rolled'}
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $posterRow[0].flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
												
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
                                                                        <div id="existing_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$posterImageRows[counter].image_path}" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} disabled="disabled" />
                                                                        <br /></div>
                                                                	{/section}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	
                                                    </table>
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext">$<input type="text" name="asked_price" size="30" value="{$auctionRow[0].auction_asked_price}" class="look-price" readonly="readonly" />.00<br /><span class="err">{$asked_price_err}</span></td>
											</tr>
                                            
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Start Date :</td>
												<td class="smalltext"><input type="text" name="start_date" id="start_date" size="30" value="{$auctionRow[0].auction_start_date}" class="look" readonly="readonly" /><br /><span class="err">{$start_date_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>End Date :</td>
												<td class="smalltext"><input type="text" name="end_date" id="end_date" size="30" value="{$auctionRow[0].auction_end_date}" class="look" readonly="readonly" /><br /><span class="err">{$end_date_err}</span></td>
											</tr>
                                            <tr class="header_bgcolor" height="24">
                                                <td colspan="2" align="left" class="headertext">Relist Auction
                                                    <input type="radio"  value="fixed" name="choose_fixed_weekly" id="choose_fixed"  onclick="choose_option(this.value)">
                                                    <span>Fixed Price</span>
                                                    <input type="radio"  value="weekly" name="choose_fixed_weekly" id="choose_weekly"  onclick="choose_option(this .value)">
                                                    <span>Weekly Auction</span>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor" id="formarea_fixed" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Fixed Auction Area -->

                                                        <span class="err">*</span>
                                                            Ask Price :
                                                </td>

                                                <td class="smalltext">
                                                      $<input type="text" class="look-price" size="32" maxlength="8" value="" name="fixed_asked_price" id="asked_price_fixed">
                                                            .00
                                                            <input type="checkbox"  value="1" name="is_consider" id="is_consider" onclick="checkMinOffer()" >
                                                            I will consider offers
                                                </td>

                                                </tr>
												<tr class="tr_bgcolor" id="minOfferDiv" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Fixed Auction Area -->

                                                        
                                                            Min Offer Price :
                                                </td>

                                                <td class="smalltext">
                                                      $<input type="text" class="look-price" size="32" maxlength="8" value="" name="offer_price" id="asked_price_fixed">
                                                            .00
                                                            
                                                </td>

                                                </tr>
                                            <tr class="tr_bgcolor" id="formarea" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Weekly Auction Area -->

                                                            <span class="err">*</span>
                                                                Auction Week:
                                                </td>
                                                <td class="smalltext">
                                                                <select name="auction_week" id="auction_week" style="width:320px;" class="formlisting-txtfield required">
                                                                    <option value="" selected="selected">Select</option>
                                                                    {section name=counter loop=$aucetionWeeks}
                                                                        <option value="{$aucetionWeeks[counter].auction_week_id}" {if $auction_week == $aucetionWeeks[counter].auction_week_id} selected {/if}>{$aucetionWeeks[counter].auction_week_title}&nbsp;({$aucetionWeeks[counter].auction_week_start_date|date_format:"%D"}&nbsp; - {$aucetionWeeks[counter].auction_week_end_date|date_format:"%D"})
                                                                        </option>
                                                                    {/section}
                                                                </select>


                                                            <div class="per-field" style="display:none;">

                                                                $
                                                                <input type="text" class="register-txtfield required" size="32" maxlength="8" value="10" name="weekly_asked_price" id="asked_price">
                                                                .00 </div>

                                                </td>
                                            </tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
											</tr>
										</table>
									</td>
								</tr>
								{else}
								<tr><td align="center" colspan="2">Sorry no records found</td></tr>
								{/if}
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#fileUpload").fileUpload({
		'uploader': '../javascript/uploadify/uploader.swf',
		'cancelImg': '../javascript/uploadify/cancel.png',
		'script': '../javascript/uploadify/upload.php',
		'folder': '../poster_photo/temp/{/literal}{$random}{literal}',
		'fileDesc': 'Image Files',
		'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
		'auto': true,
		'buttonText': 'Add Photo(s)',
		'onComplete': function(event, ID, fileObj, response, data) {
			var fileLimit = parseInt({/literal}{$smarty.const.MAX_UPLOAD_POSTER}{literal});
			var photosArr = $("#poster_images").val().split(',');
			var flag = false;
			var image = '{/literal}{$actualPath}/poster_photo/temp/{$random}/'+fileObj.name+'{literal}';
			for(i=0;i<photosArr.length;i++){
				if(photosArr[i] == fileObj.name){
					flag = true;
				}
			}
			
			if(!flag){
			
				if(photosArr.length == 1){
					checked = 'checked';
				}else{
					checked = '';
				}

				var html = '<div id="photo_'+i+'" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img style="border:3px solid #474644;" src="'+image+'" height="78" width="100" /><input type="radio" name="is_default" style=" margin-left:40px;" value="'+fileObj.name+'" '+checked+' /><br /><img src="{/literal}{$actualPath}/images/delete-icon.png{literal}" style=" margin-left:32px;" onclick="deletePhoto(\'photo_'+i+'\', \''+fileObj.name+'\', \'new\')" /></div>';
				$("#photos").append(html);
				$("#poster_images").val($("#poster_images").val()+fileObj.name+",");
			}

			if(photosArr.length == fileLimit){
				$("#browse").hide();
			}else{
				$("#browse").show();
			}
    	}
	});
});

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
                {if $event_id_err != ''}
                <tr>
					<td width="100%" align="center"><div class="messageBox">{$event_id_err}</div></td>
				</tr>
                {/if}
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="save_monthly_auction">
                            <input type="hidden" name="random" value="{$random}" />
                            <input type="hidden" name="event_id" value="{$event_id}" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>User :</td>
												<td class="smalltext">
                                                <select name="user_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$userRow}
                                                    	{if $userRow[counter].user_id == $user_id}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
                                                        <option value="{$userRow[counter].user_id}" {$selected}>{$userRow[counter].username}</option>
                                                        {assign var="selected" value=""}
                                                    {/section}
                                            	</select><br /><span class="err">{$user_id_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="{$poster_title}" size="40" class="look" /><br /><span class="err">{$poster_title_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 1}
                                                        {if $catRows[counter].cat_id == $poster_size}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
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
                                                <select name="genre" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
                                                        {if $catRows[counter].cat_id == $genre}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
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
                                                <select name="dacade" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 3}
                                                        {if $catRows[counter].cat_id == $dacade}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
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
                                                <select name="country" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 4}
                                                        {if $catRows[counter].cat_id == $country}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
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
                                                <select name="condition" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 5}
                                                        {if $catRows[counter].cat_id == $condition}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	</select><br /><span class="err">{$condition_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext"><textarea name="poster_desc" class="look" cols="70" rows="6">{$poster_desc}</textarea><br /><span class="err">{$poster_desc_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                                <input type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Flat&nbsp;</label>
                                                <input type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="browse" style="width:680px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$posterImageRows}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="existing_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/thumbnail/{$posterImageRows[counter].poster_thumb}" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} />
                                                                        <br /><img src="{$actualPath}/images/delete-icon.png" onclick="deletePhoto('existing_{$countID}', '{$posterImageRows[counter].poster_thumb}', 'existing')" /></div>
                                                                	{/section}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
                                                                <div id="browse" style="padding:5px 0px;{if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">
                                                                	<div id="fileUpload">You have a problem with your javascript</div>
                                                                	<input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate required" />
                                                                	<div class="err">{$poster_images_err}</div>
                                                                    <div class="err">{$is_default_err}</div>
                                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 780KB<br /> (1500 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                                </div>
                                                                <div id="photos" style="width:680px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$poster_images_arr}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="photo_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" /><br /><input type="radio" name="is_default" style=" margin-left:40px;" value="{$poster_images_arr[counter]}" {if $is_default == $poster_images_arr[counter]} checked="checked" {/if} /><br /><img src="{$actualPath}/images/delete-icon.png" onclick="deletePhoto('photo_{$countID}', '{$poster_images_arr[counter]}', \'new\')" style=" margin-left:30px;" /></div>
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
												<td class="smalltext"><input type="text" name="asked_price" value="{$asked_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$asked_price_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Reserve Price :</td>
												<td class="smalltext"><input type="text" name="reserve_price" value="{$reserve_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$reserve_price_err}</span></td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
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
{include file="admin_footer.tpl"}
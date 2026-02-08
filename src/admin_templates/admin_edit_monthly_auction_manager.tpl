{include file="admin_header.tpl"}

<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function() {
document.getElementById("cnt").value=countImage();
	$("#fileUpload").fileUpload({
		'uploader': '../javascript/uploadify/uploader.swf',
		'cancelImg': '../javascript/uploadify/cancel.png',
		'script': '../javascript/uploadify/upload.php',
		'folder': '../poster_photo/temp/{/literal}{$random}{literal}',
		'fileDesc': 'Image Files',
		'sizeLimit':'2000000',
		'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
		'auto': true,
		'buttonText': 'Add Photo(s)',
		'onComplete': function(event, ID, fileObj, response, data) {
			$("#fileUploadQueue").show();
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
				var cnt=document.getElementById("cnt").value;
				cnt=Number(cnt)+1;
				document.getElementById("cnt").value=cnt;
				
				var newDate = new Date;
			    var randCount=newDate.getTime();
			    
				var html = '<div id="new_'+randCount+'" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img style="border:3px solid #474644;" src="'+image+'" height="78" width="100" /><br /><input type="radio" name="is_default" value="'+fileObj.name+'" /><br /><img src="{/literal}{$smarty.const.CLOUD_STATIC}{literal}delete-icon.png" onclick="deletePhoto(\'new_'+randCount+'\', \''+fileObj.name+'\', \'new\')"  /></div>';
				$("#new_photos").append(html);
				$("#poster_images").val($("#poster_images").val()+fileObj.name+",");
			}
			
			if(cnt==12){
				$("#browse").hide();
				$("#path").hide();
			}else{
				$("#browse").show();
				$("#path").show();
			}
    	}
	});
});
	function chkPosterSize(id){
	    if(id!=""){
    	var url = "../bid_popup.php";
    	$.get(url, {mode : 'chkPosterSizeCount', id : id}, function(data){
    	var newData = data.split("-");
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
							<input type="hidden" name="mode" value="update_monthly">
							<input type="hidden" name="cnt" value="{$cnt}" id="cnt" />
                            <input type="hidden" name="auction_id" value="{$smarty.request.auction_id}">
                            <input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
                            <input type="hidden" name="random" value="{$random}" />
                            <input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
                            <input type="hidden" name="encoded_string" value="{$encoded_string}" />
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
												<td class="smalltext"><input type="text" name="poster_title" value="{$auctionRow[0].poster_title}"  style="background-color:#CCCCCC;" size="40" class="look" /><br /><span class="err">{$poster_title_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look"  onchange="chkPosterSize(this.value)">
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
                                            	</select>
												
												<br /><span class="err">{$poster_size_err}</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look">
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
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look">
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
                                                <select name="country" class="look">
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
												<td class="smalltext">{$poster_desc}<br /><span class="err">{$poster_desc_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                               
                                         
												<div id="flat_rolled" >
												{if $auctionRow[0].flat_rolled == 'flat'}
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
                                                {elseif $auctionRow[0].flat_rolled == 'rolled'}
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $auctionRow[0].flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
												
												{/if}
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$posterImageRows}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="existing_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$posterImageRows[counter].image_path}" height="78" width="100" />
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
                                                                <div id="browse" style="padding:5px 0px;{if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">
                                                                	<div id="fileUpload">You have a problem with your javascript</div>
                                                                	<input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate required" />
                                                                	<div class="err">{$poster_images_err}</div>
                                                                    <div class="err">{$is_default_err}</div>
                                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                                </div>
                                                                
												<div id="path" style="{if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">				
																{*<strong>OR</strong>
												<br clear="all" />
												<div style=" margin-bottom:10px" >
											<span style="margin-right:10px">Paste Image URL:</span><input type="text" class="formlisting-txtfield" id="imgurl" name="imgurl"  onchange="fetchimage(this.value)"   /><a href="javascript:void(0)"  style="margin-left:10px;"><img src="{$smarty.const.CLOUD_STATIC}uplink.png" title="Upload Image" /></a>
											
											
											</div>*}</div>
											<div id="new_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                	{section name=counter loop=$poster_images_arr}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="new_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="{$poster_images_arr[counter]}" />
                                                                        <br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('new_{$countID}', '{$poster_images_arr[counter]}', 'new')" /></div>
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
                                            	<td class="bold_text" valign="top"><span class="err">*</span>Event Month :</td>
                                                <td class="smalltext">
                                                {if $auctionRow[0].auction_is_approved == 0}
                                                <select name="event_month" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$eventRows}
                                                        <option value="{$eventRows[counter].event_id}" {if $auctionRow[0].fk_event_id == $eventRows[counter].event_id} selected {/if}>{$eventRows[counter].event_title} ({$eventRows[counter].event_start_date|date_format:"%D"}&nbsp;({$eventRows[counter].event_start_date|date_format:"%H:%M:%S"}) - {$eventRows[counter].event_end_date|date_format:"%D"}&nbsp;({$eventRows[counter].event_end_date|date_format:"%H:%M:%S"}))</option>
                                                    {/section}
                                                </select><br /><span class="err">{$event_month_err}</span>
                                                {else}
                                                <input type="hidden" name="event_month" value="{$auctionRow[0].fk_event_id}" />
                                                {$auctionRow[0].event_title}&nbsp;({$auctionRow[0].event_start_date|date_format:"%D"}&nbsp;({$auctionRow[0].event_start_date|date_format:"%H:%M:%S"}) - {$auctionRow[0].event_end_date|date_format:"%D"}&nbsp;({$auctionRow[0].event_end_date|date_format:"%H:%M:%S"}))
                                                {/if}
                                                </td>
                                            </tr>
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>Start Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                {if $auctionRow[0].auction_is_approved == 0}-->
<!--                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">-->
<!--                                                        {section name=foo start=0 loop=12 step=1}-->
<!--                                                            {if $smarty.section.foo.index < 10}-->
<!--                                                                {assign var=hour value="0"|cat:$smarty.section.foo.index}-->
<!--                                                            {else}-->
<!--                                                                {assign var=hour value=$smarty.section.foo.index}-->
<!--                                                            {/if}-->
<!--                                                            <option value="{$hour}" {if $auctionRow[0].auction_start_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>-->
<!--                                                        {/section}-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" {if $auctionRow[0].auction_start_min=='00'}selected{/if}>00</option>-->
<!--                                                        {section name=foo start=15 loop=60 step=15}-->
<!--                                                            <option value="{$smarty.section.foo.index}" {if $auctionRow[0].auction_start_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>-->
<!--                                                        {/section}-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" {if $auctionRow[0].auction_start_am_pm=='am'}selected{/if}>AM</option>-->
<!--                                                        <option value="pm" {if $auctionRow[0].auction_start_am_pm=='pm'}selected{/if}>PM</option>-->
<!--                                                    </select>-->
<!--                                                {else}-->
<!--                                                	{$auctionRow[0].auction_start_hour} : {$auctionRow[0].auction_start_min} {$auctionRow[0].auction_start_am_pm|upper}-->
<!--                                                    <input type="hidden" name="auction_start_hour" value="{$auctionRow[0].auction_start_hour}" />-->
<!--                                                    <input type="hidden" name="auction_start_min" value="{$auctionRow[0].auction_start_min}" />-->
<!--                                                    <input type="hidden" name="auction_start_am_pm" value="{$auctionRow[0].auction_start_am_pm}" />-->
<!--                                                {/if}-->
<!--                                                </td>-->
<!--											</tr>-->
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>End Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                {if $auctionRow[0].auction_is_approved == 0}-->
<!--                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">-->
<!--                                                        {section name=foo start=0 loop=12 step=1}-->
<!--                                                        {if $smarty.section.foo.index < 10}-->
<!--                                                            {assign var=hour value="0"|cat:$smarty.section.foo.index}-->
<!--                                                        {else}-->
<!--                                                            {assign var=hour value=$smarty.section.foo.index}-->
<!--                                                        {/if}-->
<!--                                                        <option value="{$hour}" {if $auctionRow[0].auction_end_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>-->
<!--                                                        {/section}-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" {if $auctionRow[0].auction_end_min=='00'}selected{/if}>00</option>-->
<!--                                                        {section name=foo start=15 loop=60 step=15}-->
<!--                                                            <option value="{$smarty.section.foo.index}" {if $auctionRow[0].auction_end_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>-->
<!--                                                        {/section}-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" {if $auctionRow[0].auction_end_am_pm=='am'}selected{/if}>AM</option>-->
<!--                                                        <option value="pm" {if $auctionRow[0].auction_end_am_pm=='pm'}selected{/if}>PM</option>-->
<!--                                                    </select>-->
<!--                                                {else}-->
<!--                                                	{$auctionRow[0].auction_end_hour} : {$auctionRow[0].auction_end_min} {$auctionRow[0].auction_end_am_pm|upper}-->
<!--                                                    <input type="hidden" name="auction_end_hour" value="{$auctionRow[0].auction_end_hour}" />-->
<!--                                                    <input type="hidden" name="auction_end_min" value="{$auctionRow[0].auction_end_min}" />-->
<!--                                                    <input type="hidden" name="auction_end_am_pm" value="{$auctionRow[0].auction_end_am_pm}" />-->
<!--                                                {/if}-->
<!--                                                </td>-->
<!--											</tr>-->
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="{$auctionRow[0].auction_asked_price}"  maxlength="8" class="look-price" />.00<br /><span class="err">{$asked_price_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Reserve Price :</td>
												<td class="smalltext"><input type="text" name="reserve_price" value="{$auctionRow[0].auction_reserve_offer_price}"  maxlength="8" class="look-price" />.00<br /><span class="err">{$reserve_price_err}</span></td>
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
{literal}
<script type="text/javascript">
var xmlHttp;
function  fetchimage(image)
{
	
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="fetchimg.php";
url=url+"?imgurl="+image+"&mode=edit";
//url=url+"&sid="+Math.random();
//alert(url);
xmlHttp.onreadystatechange=stateChanged2;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged2()
{
if (xmlHttp.readyState==4 && xmlHttp.status==200)
{
var subcat_arr=xmlHttp.responseText;
//document.getElementById("onlinephotos").innerHTML=subcat_arr;
var ind=subcat_arr.indexOf("text/javascript");
if(ind==-1){

var cnt=document.getElementById("cnt").value;
cnt=Number(cnt)+1;
document.getElementById("cnt").value=cnt;
if(cnt==12)
{
$("#browse").hide();
$("#path").hide();
}
}
 $("#new_photos").append(subcat_arr);
document.getElementById("imgurl").value="";
}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
</script>
{/literal}
{include file="admin_footer.tpl"}
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
				if(cnt == 1){
				var radList = document.getElementsByName('is_default');
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}
					checked = 'checked';
				}else{
					checked = '';
				}
				var newDate = new Date;
			    var randCount=newDate.getTime();
			    
				var html = '<div id="photo_'+randCount+'" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img style="border:3px solid #474644;" src="'+image+'" height="78" width="100" /><input type="radio" name="is_default" value="'+fileObj.name+'" '+checked+' /><br /><img src="{/literal}{$smarty.const.CLOUD_STATIC}delete-icon.png{literal}" onclick="deletePhoto(\'photo_'+randCount+'\', \''+fileObj.name+'\', \'new\')" /></div>';
				$("#photos").append(html);
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
	function autocom(q){
	var url = "../ajax.php?mode=autocomplete_admin&q=" + q;
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
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else{
		$("#auto_load").hide();
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	}
	
	function set_result(name,id){
		document.getElementById('user').value=name;
		document.getElementById('user_id').value=id;
		$("#auto_load").hide();
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
							<input type="hidden" name="mode" value="save_fixed_auction">
							   <input type="hidden" name="cnt" id="cnt" value="{$cnt}" />
                            <input type="hidden" name="random" value="{$random}" />
							<input type="hidden" id="no_sizes" name="no_sizes" value="{$no_sizes}" />
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
                                                <div class="UserNameSearch" style="position:relative;">
												<div><input type="text" name="user" id="user"  class="look" value="{$user}"  onkeyup="autocom(this.value);"/></div>						
                       						    <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
												<input type="hidden" name="user_id" id="user_id" value="{$user_id}"  class="look"/>
												<br /><span class="err">{$user_id_err}</span>
                                                </div>
                                                </td>
                                                
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="{$poster_title}" size="40" class="look" /><br /><span class="err">{$poster_title_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look" onchange="chkPosterSize(this.value)">
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
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
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
												<td class="smalltext">
												{$poster_desc}<br /><span class="err">{$poster_desc_err}</span>
												</td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
												<div id="flat_rolled" {if $flat_rolled==''} style="display:none;" {/if}>
                                                <div id="folded" {if $flat_rolled=='rolled' && $no_sizes!='2'} style="display:none;"{/if}>
												<input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
												</div>
                                                <div id="rolled" {if $flat_rolled=='flat' && $no_sizes!='2'} style="display:none;"{/if}>
												<input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label>
												</div>
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                                <div id="browse" style="padding:5px 0px;{if $poster_images_arr|@sizeof  >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">
                                                                	<div id="fileUpload">You have a problem with your javascript</div>
                                                                	<input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate required" />
                                                                	<div class="err">{$poster_images_err}</div>
                                                                    <div class="err">{$is_default_err}</div>
                                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                                </div>
                                                 <div id="path" {if $poster_images_arr|@sizeof >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}>               
																{*<strong>OR</strong>
												<br clear="all" />
												<div style=" margin-bottom:10px" >
											<span style="margin-right:10px">Paste Image URL:</span><input type="text" class="formlisting-txtfield" id="imgurl" name="imgurl"  onchange="fetchimage(this.value)"   /><a href="javascript:void(0)"  style="margin-left:10px;"><img src="{$smarty.const.CLOUD_STATIC}uplink.png" title="Upload Image" /></a>
											
											
											</div>*}
											</div>
											<div id="photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$poster_images_arr}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="photo_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" /><br /><input type="radio" name="is_default" style=" margin-left:40px;" value="{$poster_images_arr[counter]}" {if $is_default == $poster_images_arr[counter]} checked="checked" {/if} /><br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('photo_{$countID}', '{$poster_images_arr[counter]}', 'new')" style=" margin-left:30px;" /></div>
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
												<td class="bold_text" valign="top"><span class="err">*</span>Ask Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="{$asked_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$asked_price_err}</span></td>
											</tr>
                                           
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">&nbsp;</td>
												<td class="smalltext">
                                                <input type="checkbox" name="is_consider" {if $is_consider == 1} checked="checked" {/if} id="is_consider"  value="1" onclick="checkMinOffer()"  ><label>I will consider offers</label>
                                                </td>
											</tr>
											<tr class="tr_bgcolor" id="minOfferDiv"  {if $is_consider != 1} style="display:none;" {/if}>
												<td class="bold_text" valign="top">Min Offer Price :</td>
												<td class="smalltext"><input type="text" name="offer_price" value="{$offer_price}" maxlength="8" class="look-price" />.00<br /><span class="err">{$offer_price_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Notes :</td>
												<td class="smalltext"><textarea name="auction_note" class="look" cols="70" rows="6">{$auction_note}</textarea><br /><span class="err">{$auction_note_err}</span></td>
											</tr>
											<tr class="tr_bgcolor" >
												<td class="bold_text" valign="top">ImDB link :</td>
												<td class="smalltext"><input type="text" name="imdb_link" value=""  class="look" /><br /><span class="err">{$asked_price_err}</span></td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Add" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
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
url=url+"?imgurl="+image;
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
if(Number(cnt) >=1)
{
var radList = document.getElementsByName('is_default');
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}	 
}
cnt=Number(cnt)+1;
document.getElementById("cnt").value=cnt;

if(cnt==12)
{
$("#browse").hide();
$("#path").hide();
}
}
$("#photos").append(subcat_arr);
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
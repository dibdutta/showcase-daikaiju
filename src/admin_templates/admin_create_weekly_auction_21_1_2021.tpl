{include file="admin_header.tpl"}
<!--<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
<!--<script type="text/javascript" src="{$actualPath}/javascript/autocomplete/jquery.autocomplete.js"></script>-->
<!--<link rel="stylesheet" href="{$actualPath}/javascript/autocomplete/jquery.autocomplete.css" type="text/css" />-->
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="{$actualPath}/javascript/plupload/jquery.ui.plupload.css" type="text/css" />
{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#uploader").plupload({
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
							<input type="hidden" name="mode" value="save_weekly_auction">
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
                                                <select name="condition" class="look" onchange="add_text_desc(this.value)">
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
												<td class="smalltext"><!--<textarea name="poster_desc" class="look" cols="70" rows="6">{$poster_desc}</textarea>-->{$poster_desc}<br /><span class="err">{$poster_desc_err}</span></td>
											</tr>
                                            <!--  <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Start Time :</td>
												<td class="smalltext">
                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">
                                                        {section name=foo start=0 loop=12 step=1}
                                                            {if $smarty.section.foo.index < 10}
                                                                {assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                            {else}
                                                                {assign var=hour value=$smarty.section.foo.index}
                                                            {/if}
                                                            <option value="{$hour}" {if $auction_start_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                        {/section}
                                                    </select>(Hour) :                                            
                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">
                                                        <option value="00" {if $auction_start_min=='00'}selected{/if}>00</option>
                                                        {section name=foo start=15 loop=60 step=15}
                                                            <option value="{$smarty.section.foo.index}" {if $auction_start_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                        {/section}
                                                    </select>(Min)
                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" {if $auction_start_am_pm=='am'}selected{/if}>AM</option>
                                                        <option value="pm" {if $auction_start_am_pm=='pm'}selected{/if}>PM</option>
                                                    </select>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>End Time :</td>
												<td class="smalltext">
                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">
                                                        {section name=foo start=0 loop=12 step=1}
                                                        {if $smarty.section.foo.index < 10}
                                                            {assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                        {else}
                                                            {assign var=hour value=$smarty.section.foo.index}
                                                        {/if}
                                                        <option value="{$hour}" {if $auction_end_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                        {/section}
                                                    </select>(Hour) :                                            
                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">
                                                        <option value="00" {if $auction_end_min=='00'}selected{/if}>00</option>
                                                        {section name=foo start=15 loop=60 step=15}
                                                            <option value="{$smarty.section.foo.index}" {if $auction_end_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                        {/section}
                                                    </select>(Min)
                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" {if $auction_end_am_pm=='am'}selected{/if}>AM</option>
                                                        <option value="pm" {if $auction_end_am_pm=='pm'}selected{/if}>PM</option>
                                                    </select>
                                                </td>
											</tr>-->
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
															<div id="uploader"></div>
                                                        	
											
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
											<tr class="tr_bgcolor" >
												<td class="bold_text" valign="top">ImDB link :</td>
												<td class="smalltext"><input type="text" name="imdb_link" value=""  class="look" /><br /><span class="err">{$asked_price_err}</span></td>
											</tr>
											{*<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>*}
                                            <tr class="tr_bgcolor" style="display:none;">
												{*<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>*}
												<td class="smalltext"><input type="text" name="asked_price" value="10" maxlength="8" class="look-price" />.00<br /><span class="err">{$asked_price_err}</span></td>
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

if(cnt==25)
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
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>
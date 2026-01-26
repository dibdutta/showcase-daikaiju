{include file="header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="{$actualPath}/javascript/autocomplete/jquery.autocomplete.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/jquery/jquery.ui.js"></script>
<script type="text/javascript" src="{$actualPath}/jquery/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="{$actualPath}/wymeditor/jquery.wymeditor.min.js"></script>
<script type="text/javascript" src="{$actualPath}/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js"></script>
<script type="text/javascript" src="{$actualPath}/wymeditor/plugins/resizable/jquery.wymeditor.resizable.js"></script>
{literal}
<script type="text/javascript">

jQuery(function() {
	//document.getElementByName('textDesc').value="hello";
    jQuery('.wymeditor').wymeditor({
    	
        stylesheet: 'styles.css',
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
            wym.hovertools();
            wym.resizable();
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
    $("#fileUpload").fileUpload({
        'uploader': 'javascript/uploadify/uploader.swf',
        'cancelImg': 'javascript/uploadify/cancel.png',
        'script': 'javascript/uploadify/upload.php',
        'folder': '{/literal}poster_photo/temp/{$random}{literal}',
		'sizeLimit':'2000000',
        'fileDesc': 'Image Files',
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
				if(cnt== 1){
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
			var tot=photosArr.length;
			//var tot= tot+ {/literal}{literal}
			//alert(tot);
			
            if(cnt==12){
                $("#browse").hide();
				$("#path").hide();
            }else{
                $("#browse").show();
				$("#path").show();
            }
        }
    });
    $("#posterUpload").validate();
    autoComplete('poster_title');
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
                  
                        
                        <div class="black-midrept">
                            <span class="white-txt"><strong>Manual Upload for Stills / Photos</strong></span>
                        </div><div class="black-right-crnr"></div>
                        <div class="black-left-crnr"></div>
                       
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">                   
                        <div class="inner-area-general">
                           
                            <!-- form listings starts here-->
                            <form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" value="stills_upload" />
                                <input type="hidden" name="cnt" id="cnt" value="{$cnt}" />
								<input type="hidden" name="random" id="folder" value="{$random}" />
								<input type="hidden" name="poster_size"  value="34" />
								<!--<input type="hidden" name="random" id="folder" value="{$random}" />-->
                                <div class="formarea-listing"> 
								<input type="hidden" id="no_sizes" name="no_sizes" value="{$no_sizes}" />
                                 <span>Fields marked <span class="mandatory">*</span> are mandatory</span>                   
                                     <table cellpadding="0" cellspacing="0" border="0" class="listbox">
                                        <tr>
                                            <td><label>Stills/Photos Title<span class="red-star">*</span></label></td>
                                            {*<td><label>Size<span class="red-star">*</span></label></td>*}
											<td><label>Genre<span class="red-star">*</span></label></td>
											<td><label>Decade<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><input type="text" name="poster_title" id="poster_title" value="{$poster_title}" class="formlisting-txtfield required" /><div class="disp-err">{$poster_title_err}</div></td>
                                            {*<td valign="top">
                                            	<select name="poster_size" class="formlisting-txtfield required" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 1}
                                                        <option value="{$catRows[counter].cat_id}" {if $poster_size == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
                                                        {/if}
                                                    {/section}
                                                </select>                                            	
                                            	<div class="disp-err">{$poster_size_err}</div>
											</td>*}
                                            <td valign="top">
                                                <select name="genre" class="formlisting-txtfield required">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
                                                        <option value="{$catRows[counter].cat_id}" {if $genre == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </select>
                                                <div class="list-err">{$genre_err}</div>
                                            </td>
											<td valign="top">
                                                <select name="decade" class="formlisting-txtfield required">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 3}
                                                        <option value="{$catRows[counter].cat_id}" {if $decade == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </select>
                                                <div class="disp-err">{$decade_err}</div>
                                            </td>
                                        </tr>
                                        <tr>                                          
                                            <td><label>Country<span class="red-star">*</span></label></td>
                                            <td><label>Condition<span class="red-star">*</span></label></td>
											<td valign="top"><label>Ask Price<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                        	
                                            <td valign="top">
                                                <select name="country" class="formlisting-txtfield required">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 4}
                                                        <option value="{$catRows[counter].cat_id}" {if $country == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </select>
                                                <div class="disp-err">{$country_err}</div>
                                            </td>
                                            <td valign="top">
                                            <div  class="FAQCondition">
                                                <select name="condition" class="formlisting-txtfield required">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 5}
                                                        <option value="{$catRows[counter].cat_id}" {if $condition == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </select>
												<span style="margin-left:10px;"><a onclick="javascript:window.open('{$actualPath}/myselling.php?mode=faq','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" href="javascript:void(0)" class="FAQIcon"><img src="{$smarty.const.CLOUD_STATIC}faq_fixed.png"/></a></span>
                                                <div class="disp-err">{$condition_err}</div>
                                                </div>
                                            </td>
											<td valign="top">
											<div >
                                                <div class="text-price">$</div>
                                                <div class="txtboxprice"><input type="text" name="asked_price" value="{$asked_price}" maxlength="8" class="formlisting-txtfield-price required number" /></div>
                                                <div class="text-price">.00</div>
                                                <div class="list-err">{$asked_price_err}</div>
											</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label>Description<span class="red-star">*</span></label>
                                                <p style="font-size:11px; margin:0px; padding:0px; line-height:40px;">please give a detailed description of your item including any restoration / backing</p>
                                            </td>
											
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
                                                {*<div style="float:left; width:450px; padding:0px; margin:0px; display:block;">*}
                                                <!--<div  style="top:10px;width:370px;height:100px;position:relative;">-->
  <textarea class="wymeditor required" id="textDesc"  name="poster_desc"   style="left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$poster_desc|stripslashes}</textarea>

<br clear="all" />
<div class="disp-err" >{$poster_desc_err}</div>
<div class="disp-err" htmlfor="textBox" generated="true"></div>
{*</div>*}
											</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label>Notes&nbsp;(Not viewable to public)</label></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
											<div id="textDiv" style="top:10px;width:370px;height:100px;position:relative;">
  												<textarea id="textBox" class="bigfield" name="auction_note" style="width:360px;height:90px;left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$auction_note}</textarea>
  												<div id="handleRight" style="height:95px;position:absolute;left:95px;top:0px;"></div>
  												<div id="handleCorner" style="position:absolute;cursor:se-resize;top:87px;left:357px;"></div>
  												<div id="handleBottom" style="height:5px;position:absolute;left:0px;top:95px;"></div>
											</div>
											</td>
                                            <td><div><input type="checkbox" name="is_consider" {if $is_consider == 1} checked="checked" {/if} id="is_consider"  value="1" onclick="checkMinOffer()"  ><label>I will consider offers</label></div>
											<br/>											
											<div id="minOfferDiv"  {if $is_consider != 1} style="display:none;" {/if}>
                                                <div class="text-price">$</div>
                                                <div class="txtboxprice"><input type="text" name="offer_price" value="{$offer_price}" maxlength="8" class="formlisting-txtfield-price " /></div>
                                                <div class="text-price">.00</div>
                                                <div class="list-err">{$offer_price_err}</div>
											</div>
											</td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="3">
												<div id="flat_rolled" >
                                                <div id="folded" {if $flat_rolled=='rolled' && $no_sizes!='2'} style="display:none;"{/if}>
												<input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
												</div>
                                                
												</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="3" width="100%">
											
                                                <div  id="browse"  {if $poster_images_arr|@sizeof >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}>
                                                <div id="fileUpload">You have a problem with your javascript</div>
                                                <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate " /><div class="list-err">{$poster_images_err}</div>
                                               
                                               <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                {*<a href="javascript:$('#fileUpload').fileUploadStart()">Start Upload</a> | <a href="javascript:$('#fileUpload').fileUploadClearQueue()">Clear Queue</a>*}
                                                </div>
                                   <div  id="path" {if $poster_images_arr|@sizeof >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}>              
								            {*<strong>OR</strong>
												<br clear="all" />
												<div style=" margin-bottom:10px" >
											<span style="margin-right:10px">Paste Image URL:</span><input type="text" class="formlisting-txtfield" id="imgurl" name="imgurl"  onchange="fetchimage(this.value)"   /><a href="javascript:void(0);"  style="margin-left:10px; vertical-align:bottom;"><img src="{$smarty.const.CLOUD_STATIC}uplink.png" title="Upload Image" /></a>
											
											
											
											</div>*}
											
											</div>
											<div class="disp-err">{$is_default_err}</div>
											<div id="photos" style="width:100%; padding:10px; margin:0px; float:left;">
                                                {section name=counter loop=$poster_images_arr}
                                                    {assign var="countID" value=$smarty.section.counter.index+1}
                                                    <div id="photo_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" /><br /><input type="radio" name="is_default" value="{$poster_images_arr[counter]}" {if $is_default == $poster_images_arr[counter]} checked="checked" {/if} /><div class="list-err">{$is_default_err}</div><br /><img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('photo_{$countID}', '{$poster_images_arr[counter]}', 'new')" /></div>
                                                    {/section}
                                                </div>
											

                                            </td>                                                
                                        </tr>
                                     </table>
                                     <div class="clear"></div>
                                     <div class="btn-box">     
                                        <input type="submit" value="Submit" class="submit-btn wymupdate" />
                                        <input type="reset" value="Reset" class="submit-btn" />
                                     </div>
                                     <div class="clear"></div>
                                </div>
                            </form> 
							
							
                            <!--form listing ends here-->                       
                        </div>
                        <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                    <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                   
                </div>
                <!--Page body Ends-->
            </div>     
            
              </div></div></div>  
             {include file="user-panel.tpl"}
        </div>    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

<script type="text/javascript" src="{$actualPath}/javascript/resize/resize.js"></script>

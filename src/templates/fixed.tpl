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
								<!--<input type="hidden" name="random" id="folder" value="{$random}" />-->
                                <div class="formarea-listing"> 
								<input type="hidden" id="no_sizes" name="no_sizes" value="{$no_sizes}" />
                                                   
                                     <table cellpadding="0" cellspacing="0" border="0" class="listbox">
                                        <tr>
                                            <td><label>Poster Title<span class="red-star">*</span></label></td>
                                            <td><label>Size<span class="red-star">*</span></label></td>
											<td><label>Genre<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><input type="text" name="poster_title" id="poster_title" value="{$poster_title}" class="formlisting-txtfield required" /><div class="disp-err">{$poster_title_err}</div></td>
                                            <td valign="top">
                                            	<select name="poster_size" class="formlisting-txtfield required" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 1}
														 {if $catRows[counter].cat_value !='Stills/Photos'}
                                                        <option value="{$catRows[counter].cat_id}" {if $poster_size == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
														 {/if}
                                                        {/if}
                                                    {/section}
                                                </select>                                            	
                                            	<div class="disp-err">{$poster_size_err}</div>
											</td>
                                            <td valign="top">
                                                <select name="genre" class="formlisting-txtfield required">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
														{if $catRows[counter].cat_value !='Stills/Photos'}
                                                        <option value="{$catRows[counter].cat_id}" {if $genre == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
														{/if}
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </select>
                                                <div class="list-err">{$genre_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Decade<span class="red-star">*</span></label></td>
                                            <td><label>Country<span class="red-star">*</span></label></td>
                                            <td><label>Condition<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
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
												&nbsp;<a onclick="javascript:window.open('{$actualPath}/myselling.php?mode=faq','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" href="javascript:void(0)" class="FAQIcon"><img src="{$smarty.const.CLOUD_STATIC}faq_fixed.png"/></a>
                                                <div class="disp-err">{$condition_err}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top:30px;"><label><strong>Description<span class="red-star">*</span></strong></label>
											<br clear="all" />
											<p style="font-size:12px; margin:0px; padding:0px;">Please give a detailed description of your item<br />
 including any restoration / backing</p>
											</td>
											<td valign="top" style="padding-top:30px;"><label><strong>Ask Price<span class="red-star">*</span></strong></label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
                                                {*<div style="float:left; width:450px; padding:0px; margin:0px; display:block;">*}
                                                <!--<div  style="top:10px;width:370px;height:100px;position:relative;">-->
  <textarea class="wymeditor required" id="textDesc"  name="poster_desc"   style="left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$poster_desc|stripslashes}</textarea>

  <!--<div id="handleRight" style="height:95px;position:absolute;left:95px;top:0px;"></div>
  <div id="handleCorner" style="position:absolute;cursor:se-resize;top:87px;left:357px;"></div>
  <div id="handleBottom" style="height:0px;position:absolute;left:0px;top:95px; clear:both;"></div>-->
<!--</div>-->
<br clear="all" />
<div class="disp-err" >{$poster_desc_err}</div>
<div class="disp-err" htmlfor="textBox" generated="true"></div>
{*</div>*}
											</td>
                                            <td valign="top">
											<div style="height:100px;position:relative;">
                                                <div class="text-price" style="width: 12px; float: left;" >$</div>
                                                <div class="txtboxprice"><input type="text" name="asked_price" value="{$asked_price}" maxlength="8" class="formlisting-txtfield-price required number" /></div>
                                                <div class="text-price">.00</div>
                                                <div class="list-err">{$asked_price_err}</div>
											</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label><strong>Notes</strong> (Not viewable to public)<strong>:</strong></label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
											<div id="textDiv" style="width:370px;height:100px;position:relative;">
  												<textarea id="textBox" class="bigfield" name="auction_note" style="width:370px;height:90px;left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px; overflow-y:scroll;">{$auction_note}</textarea>
  												<!--<div id="handleRight" style="height:95px;position:absolute;left:95px;top:0px;"></div>
  												<div id="handleCorner" style="position:absolute;cursor:se-resize;top:87px;left:357px;"></div>
  												<div id="handleBottom" style="height:5px;position:absolute;left:0px;top:95px;"></div>-->
											</div>
											</td>
                                            <td><div><input type="checkbox" name="is_consider" {if $is_consider == 1} checked="checked" {/if} id="is_consider"  value="1" onclick="checkMinOffer()" ><label> I will consider offers</label></div>
											<br/>											
											<div id="minOfferDiv"  {if $is_consider != 1} style="display:none;" {/if}>
                                               <div class="text-price" style="width: 12px; float: left;" >$</div>
                                                <div class="txtboxprice"><input type="text" name="offer_price" value="{$offer_price}" maxlength="8" class="formlisting-txtfield-price " /></div>
                                                <div class="text-price">.00</div>
                                                <div class="list-err">{$offer_price_err}</div>
											</div>
											</td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="3">
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
                                        <tr>
                                            <td align="center" colspan="3" width="100%" style="text-align:center;">
												<div id="uploader"></div>
                                                <div  id="browse" style="text-align:center; margin:0 auto;"  {if $poster_images_arr|@sizeof >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}>
                                                
                                                <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate " /><div class="list-err">{$poster_images_err}</div>
                                               
                                               <div style="font-size:11px; width:300px; margin:0 auto;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                
                                                </div>
                                   <div  id="path" {if $poster_images_arr|@sizeof >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}>              
								           
											
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
                                        <input type="submit" value="Submit" class="submit-btn wymupdate" onclick="submitForm()" />
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
{include file="foot.tpl"}

<script type="text/javascript" src="{$actualPath}/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>

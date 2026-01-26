{include file="header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
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
    	//
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

</script><script type="text/javascript">
$(document).ready(function() {
document.getElementById("cnt").value=countImage();
    $("#fileUpload").fileUpload({
        'uploader': 'javascript/uploadify/uploader.swf',
        'cancelImg': 'javascript/uploadify/cancel.png',
        'script': 'javascript/uploadify/upload.php',
        'folder': 'poster_photo/temp/{/literal}{$random}{literal}',
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
			    
                var html = '<div id="new_'+randCount+'" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img style="border:3px solid #474644;" src="'+image+'" height="78" width="100" /><br /><input type="radio" name="is_default" value="'+fileObj.name+'" /><br /><img src="{/literal}{$smarty.const.CLOUD_STATIC}{literal}delete-icon.png" onclick="deletePhoto(\'new_'+randCount+'\', \''+fileObj.name+'\', \'new\')" /></div>';
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
    
    $("#posterUpload").validate();
});
    function chkPosterSize(id){
    	var url = "bid_popup.php";
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
                	 <div class="dashboard-main">
                        <h1>Edit Fixed Auction</h1>
                        <p>Fields marked with <span class="mandatory">*</span> are mandatory </p>
                   </div>
                
                       
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    {if $view_key=='0'}                  
                        <div class="inner-area-general" style="padding-top:0;">
                           
                            <!-- form listings starts here-->
					<form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="mode" value="update_fixed" />
						&nbsp;&nbsp;<input type="hidden" name="cnt" value="{$cnt}" id="cnt" />
						<input type="hidden" name="encoded_string" value="{$encoded_string}" />
						<input type="hidden" name="auction_id" value="{$auctionRow[0].auction_id}">
						<input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
						<input type="hidden" name="random" id="random" value="{$random}" />
						<input type="hidden" name="chk_auction_asked_price" value="{$auctionRow[0].auction_asked_price}" />
						<input type="hidden" name="chk_auction_offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" />
						<input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
                                <div class="formarea-listing">   
                                 <!--<span>Fields marked <span class="mandatory">*</span> are mandatory</span>-->                             
                                     <table cellpadding="0" cellspacing="0" border="0" class="listbox">
                                     	<tr>
                                            <td><label>Poster Title<span class="red-star">*</span></label></td>
                                            <td><label>Size<span class="red-star">*</span></label></td>
                                            <td><label>Genre<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" name="poster_title" value="{$posterRow[0].poster_title}" class="formlisting-txtfield required"  /><div class="disp-err">{$poster_title_err}</div></td>
                                            <td>
                                            	<select name="poster_size" class="formlisting-txtfield required"  onchange="chkPosterSize(this.value)">
                                                   <option value="" selected="selected">Select</option>
                                                        {section name=counter loop=$catRows}
                                                        {if $catRows[counter].fk_cat_type_id == 1}
                                                            {section name=posterCatCounter loop=$posterCategoryRows}
                                                                {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                                    {assign var="selected" value="selected"}
                                                                {/if}
                                                            {/section}
															{if $catRows[counter].cat_value !='Stills/Photos'}
                                                            <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
															{/if}
                                                            {assign var="selected" value=""}
                                                        {/if}
                                                        {/section}
                                                </select>
                                               
                                                <div class="disp-err">{$poster_size_err}</div>
											</td>
                                            <td>
                                             <select name="genre" class="formlisting-txtfield required">
                                               <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
                                                        {section name=posterCatCounter loop=$posterCategoryRows}
                                                            {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                                {assign var="selected" value="selected"}
                                                            {/if}
                                                        {/section}
														{if $catRows[counter].cat_value !='Stills/Photos'}
                                                        <option value="{$catRows[counter].cat_id}" {$selected}>{$catRows[counter].cat_value}</option>
														{/if}
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            </select>
                                            <div class="disp-err">{$genre_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Decade<span class="red-star">*</span></label></td>
                                            <td><label>Country<span class="red-star">*</span></label></td>
                                            <td><label>Condition<span class="red-star">*</span></label></td>
                                        </tr>                                        
                                        <tr>
                                            <td>
                                                <select name="decade" class="formlisting-txtfield required">
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
                                                </select>
                                                <div class="disp-err">{$decade_err}</div>
                                            </td>
                                            <td>
                                                <select name="country" class="formlisting-txtfield required">
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
                                                </select>
                                                <div class="disp-err">{$country_err}</div>
                                            </td>
                                            <td valign="top">
                                            <div  class="FAQCondition">
												<select name="condition" class="formlisting-txtfield required">
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
												&nbsp;<a onclick="javascript:window.open('{$actualPath}/myselling.php?mode=faq','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" href="javascript:void(0)" class="FAQIcon" style="right:15px;"><img src="{$smarty.const.CLOUD_STATIC}faq_fixed.png"/></a>
                                                <div class="disp-err">{$condition_err}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" style="padding-top:30px;"><label><strong>Description<span class="red-star">*</span></strong></label>
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
  <textarea class="wymeditor required" id="textDesc"  name="poster_desc"   style="left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$posterRow[0].poster_desc|stripslashes}</textarea>

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
                                                <div class="txtboxprice"><input type="text" name="asked_price" value="{$auctionRow[0].auction_asked_price}" class="formlisting-txtfield-price required number" /></div>
                                                <div class="text-price">.00</div>
											</div>	
                                                <div class="list-err">{$asked_price_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label><strong>Notes</strong> (Not viewable to public)<strong>:</strong></label></td>
                                            <td>&nbsp;</td>                                             
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
											<div id="textDiv" style="width:370px;height:100px;position:relative;">
  												<textarea id="textBox" class="bigfield" name="auction_note" style="width:390px;height:90px;left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$auctionRow[0].auction_note}</textarea>
  												<!--<div id="handleRight" style="height:95px;position:absolute;left:95px;top:0px;"></div>
  												<div id="handleCorner" style="position:absolute;cursor:se-resize;top:87px;left:357px;"></div>
  												<div id="handleBottom" style="height:5px;position:absolute;left:0px;top:95px;"></div>-->
											</div>
											</td>
                                            <td><div><input type="checkbox" name="is_consider" {if $auctionRow[0].auction_reserve_offer_price >= 1} checked="checked" {/if} id="is_consider"  value="1" onclick="checkMinOffer()" ><label> I will consider offers</label></div>
											<br/>						
											<div id="minOfferDiv" {if $auctionRow[0].auction_reserve_offer_price == 0} style="display:none;" {/if}>
                                                <div class="text-price" style="width: 12px; float: left;" >$</div>
                                                <div class="txtboxprice"><input type="text" name="offer_price" value="{$auctionRow[0].auction_reserve_offer_price}" maxlength="8" class="formlisting-txtfield-price " /></div>
                                                <div class="text-price">.00</div>
                                                <div class="list-err">{$offer_price_err}</div>
											</div>
											</td>
                                        </tr>
                                        <tr>
                                        <td align="left" colspan="3">
                                         
                                         
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
                                        <tr>
                                            <td align="center" colspan="3">
                                            <div id="existing_photos" style="width:100%; padding:10px; margin:0px; float:left;">
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
                                        <td align="center" colspan="3" width="100%" style="text-align:center;">
                                            <div id="browse" style="text-align:center; margin:0 auto;" {if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">
                                                <div id="fileUpload">You have a problem with your javascript</div>
                                                <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate" />
                                                <div class="disp-err">{$poster_images_err}</div>
                                                <div class="disp-err">{$is_default_err}</div>
                                                <div style="font-size:11px; width:300px; margin:0 auto;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                            </div>
											 <div  id="path" {if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER} style="display:none;"{/if}> 
											<br clear="all" />
											{*<strong>OR</strong>
												<br clear="all" />
												<div style=" margin-bottom:10px" >
											<span style="margin-right:10px">Paste Image URL:</span><input type="text" class="formlisting-txtfield" id="imgurl" name="imgurl"  onchange="fetchimageedit(this.value)"   /><a href="javascript:void(0)"  style="margin-left:10px; vertical-align:bottom;"><img src="{$smarty.const.CLOUD_STATIC}uplink.png" title="Upload Image" /></a>
											
											
											</div>*}</div>
                                            <div id="new_photos" style="width:100%; padding:10px; margin:0px; float:left;">
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
                                     <div class="clear"></div>
                                     <div class="btn-box">     
                                        <input type="submit" value="Submit" class="submit-btn wymupdate" />
                                        <input type="reset" value="Reset" class="submit-btn" />
                                        <input type="button" value="Cancel"  class="submit-btn" onclick="location.href='{$decoded_string}'"/>
                                     </div>
                                     <div class="clear"></div>
                                </div>
                            </form>                       
                            <!--form listing ends here-->                       
                        </div>
                        {else}
                        <div class="inner-area-general">
                        Sorry no such auction found.
                        </div>
                        {/if}
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
<script type="text/javascript" src="{$actualPath}/javascript/resize/resize.js"></script>

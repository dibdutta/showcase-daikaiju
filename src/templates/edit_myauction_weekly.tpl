{include file="header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>

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
    //$("#posterUpload").validate();
    $(function() {
        $("#start_date").datepick();
        $("#end_date").datepick();
    });
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
                        <h1>Edit Weekly Auction</h1>
                        <p>Fields marked with <span class="mandatory">*</span> are mandatory </p>
                   </div>
                      
                     
                  <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg"> 
                     {if $view_key=='0'}
                        <div class="inner-area-general" style="padding-top:0;">
                           
                            <!-- form listings starts here-->
                            <form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" value="update_weekly" />
								&nbsp;&nbsp;<input type="hidden" name="cnt" value="{$cnt}" id="cnt" />
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <input type="hidden" name="auction_id" value="{$auctionRow[0].auction_id}">
                                <input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
                                <input type="hidden" name="random" id="random" value="{$random}" />
                                <input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
                                <div class="formarea-listing">                                
                                     <!--<span>Fields marked <span class="mandatory">*</span> are mandatory</span>-->
                                     <table width="100%" cellpadding="0" cellspacing="0" border="0" class="listbox" >
                                        <tr>
                                            <td valign="top"><label>Poster Title<span class="red-star">*</span></label></td>
                                            <td valign="top"><label>Size<span class="red-star">*</span></label></td>
                                            <td valign="top"><label>Genre<span class="red-star">*</span></label></td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><input type="text" name="poster_title" id="poster_title" value="{$posterRow[0].poster_title}" class="formlisting-txtfield required" {if $auctionRow[0].auction_is_approved!='0'} readonly="readonly" {/if} /><div class="list-err">{$poster_title_err}</div></td>
                                            <td valign="top">
											{if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$catRows}                                                  {if $catRows[counter].fk_cat_type_id == 1} 
												  {section name=posterCatCounter loop=$posterCategoryRows}
												  {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}     
                                                    <input type="hidden" name="poster_size" value="{$posterCategoryRows[posterCatCounter].fk_cat_id}" />
                                                    <input type="text" name="poster_size_val" value="{$catRows[counter].cat_value}" class="formlisting-txtfield required" readonly="readonly" />
													{/if}
													{/section}
													{/if}
                                                {/section}
												{else}
                                                <select name="poster_size" class="formlisting-txtfield required" {if $auctionRow[0].auction_is_sold != '0' } disabled="disabled" {/if} onchange="chkPosterSize(this.value)">
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
                                                	{section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 1}
                                                        {section name=posterCatCounter loop=$posterCategoryRows}
                                                            {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                                {assign var="selected" value="selected"}
                                                                {if $auctionRow[0].auction_is_sold != '0' } 
                                                					<input type="hidden" name="poster_size" value="{$catRows[counter].cat_id}">
																{/if}
                                                            {/if}
                                                        {/section}
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                	{/if}
                                                <div class="disp-err">{$poster_size_err}</div>
                                            </td>
                                            <td valign="top">
												{if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$catRows}                                                  {if $catRows[counter].fk_cat_type_id == 2} 
												  {section name=posterCatCounter loop=$posterCategoryRows}
												  {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}     
                                                    <input type="hidden" name="genre" value="{$posterCategoryRows[posterCatCounter].fk_cat_id}" />
                                                    <input type="text" name="genre_val" value="{$catRows[counter].cat_value}" class="formlisting-txtfield required" readonly="readonly" />
													{/if}
													{/section}
													{/if}
                                                {/section}
												{else}
                                                <select name="genre" class="formlisting-txtfield required">
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
                                                </select>
												{/if}
                                                <div class="list-err">{$genre_err}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><label>Decade<span class="red-star">*</span></label></td>
                                            <td valign="top"><label>Country<span class="red-star">*</span></label></td>
                                            <td valign="top"><label>Condition<span class="red-star">*</span></label></td>
                                        </tr>                                        
                                        <tr>
                                            <td valign="top">
											{if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$catRows}                                                  {if $catRows[counter].fk_cat_type_id == 3} 
												  {section name=posterCatCounter loop=$posterCategoryRows}
												  {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}     
                                                    <input type="hidden" name="decade" value="{$posterCategoryRows[posterCatCounter].fk_cat_id}" />
                                                    <input type="text" name="decade_val" value="{$catRows[counter].cat_value}" class="formlisting-txtfield required" readonly="readonly" />
													{/if}
													{/section}
													{/if}
                                                {/section}
												{else}
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
												{/if}
                                                <div class="disp-err">{$decade_err}</div>
                                            </td>
                                            <td valign="top">
												{if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$catRows}                                                  {if $catRows[counter].fk_cat_type_id == 4} 
												  {section name=posterCatCounter loop=$posterCategoryRows}
												  {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}     
                                                    <input type="hidden" name="country" value="{$posterCategoryRows[posterCatCounter].fk_cat_id}" />
                                                    <input type="text" name="decade_val" value="{$catRows[counter].cat_value}" class="formlisting-txtfield required" readonly="readonly" />
													{/if}
													{/section}
													{/if}
                                                {/section}
												{else}
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
												{/if}
                                                <div class="disp-err">{$country_err}</div>
                                            </td>
                                            <td valign="top">
											<div  class="FAQCondition">
												{if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$catRows}                                                  {if $catRows[counter].fk_cat_type_id == 5} 
												  {section name=posterCatCounter loop=$posterCategoryRows}
												  {if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}     
                                                    <input type="hidden" name="condition" value="{$posterCategoryRows[posterCatCounter].fk_cat_id}" />
                                                    <input type="text" name="decade_val" value="{$catRows[counter].cat_value}" class="formlisting-txtfield required" readonly="readonly" />
													{/if}
													{/section}
													{/if}
                                                {/section}
												{else}
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
												{/if}
                                                <div class="disp-err">{$condition_err}</div>
												</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" style="padding-top:30px;"><label><strong>Description<span class="red-star">*</span></strong></label></td>
                                            {*<td valign="top"><label>Starting Price<span class="red-star">*</span></label></td>*}
                                        </tr>
                                        <tr>
                                            <!--<td colspan="2" valign="top">
											
                                                <div style="float:left;padding:0px; margin:0px; display:block;">
												<div id="textDiv" style="top:10px;width:370px;height:100px;position:relative;">
  <textarea name="poster_desc" id="textBox" {if $auctionRow[0].auction_is_approved=='1'} readonly="readonly" {/if} class="bigfield required" style="width:360px;height:90px;left:0px;top:0px;position:absolute;padding:0px 0px 0px 0px;">{$posterRow[0].poster_desc}</textarea>
  <div id="handleRight" style="height:95px;position:absolute;left:95px;top:0px;"></div>
  <div id="handleCorner" style="position:absolute;cursor:se-resize;top:87px;left:357px;"></div>
  <div id="handleBottom" style="height:0px;position:absolute;left:0px;top:95px;"></div>
</div>
												<div class="disp-err" style="position:absolute;">{$poster_desc_err}</div><br clear="all" />
										<div class="disp-err" htmlfor="textBox" generated="true" style="position:absolute;"></div>
												<p style="font-size:11px; margin:0px; padding:0px; line-height:40px;">please give a detailed description of your item including any restoration / backing</p></div></td>-->
												
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
<p style="font-size:12px; margin:0px; padding:0px;">Please give a detailed description of your item<br />
 including any restoration / backing</p>{*</div>*}
											</td>
                                                <td valign="top" style="display:none;">
												 <div  style="top:10px;height:100px;position:relative;">
												<div class="text-price">$</div><div class="txtboxprice"><input type="text" name="asked_price" value="10" {if $auctionRow[0].auction_is_approved!='0'} readonly {/if} class="formlisting-txtfield-price required number" /></div><div class="text-price">.00</div>
												</div>
												<div class="list-err">{$asked_price_err}</div></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top"><label><strong>Auction Week<span class="red-star">*</span></strong></label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top">
                                            {if $auctionRow[0].auction_is_approved=='1'}
                                                {section name=counter loop=$aucetionWeeks}                                                        
                                                    <input type="hidden" name="auction_week" value="{$aucetionWeeks[counter].auction_week_id}" />
                                                    <input type="text" name="auction_week_val" value="{$aucetionWeeks[counter].auction_week_title}&nbsp;({$aucetionWeeks[counter].auction_week_start_date|date_format:'%D'} - {$aucetionWeeks[counter].auction_week_end_date|date_format:'%D'})" class="bigfield required" readonly="readonly" />
                                                {/section}
                                            {else}
                                                <select name="auction_week" style="width:320px;" class="formlisting-txtfield required"  >
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$aucetionWeeks}
                                                        <option value="{$aucetionWeeks[counter].auction_week_id}" {if $auctionRow[0].fk_auction_week_id == $aucetionWeeks[counter].auction_week_id} selected {/if}>{$aucetionWeeks[counter].auction_week_title}&nbsp;({$aucetionWeeks[counter].auction_week_start_date|date_format:'%D'} - {$aucetionWeeks[counter].auction_week_end_date|date_format:'%D'})</option>
                                                    {/section}
                                                </select>
                                            {/if}
                                            <div class="disp-err">{$auction_week_err}</div>
                                        	</td>
                                        </tr>
                                        
<!--                                        <tr>-->
<!--                                            <td valign="top"><label>Start Time</label></td>-->
<!--                                            <td valign="top"><label>End Time</label></td>-->
<!--                                            <td>&nbsp;</td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td valign="top">-->
<!--                                            {if $auctionRow[0].auction_is_approved=='1'}-->
<!--                                                <input type="text" name="display_start_time" value="{$auctionRow[0].auction_start_hour} : {$auctionRow[0].auction_start_min} {$auctionRow[0].auction_start_am_pm|upper}" class="bigfield required" style="width:75px;" readonly="readonly" />-->
<!--                                                <input type="hidden" name="auction_start_hour" value="{$auctionRow[0].auction_start_hour}" />-->
<!--                                                <input type="hidden" name="auction_start_min" value="{$auctionRow[0].auction_start_min}" />-->
<!--                                                <input type="hidden" name="auction_start_am_pm" value="{$auctionRow[0].auction_start_am_pm}" />-->
<!--                                            {else}-->
<!--                                                <select name="auction_start_hour" size="1" tabindex="7" class="dd-hour">-->
<!--                                                    {section name=foo start=0 loop=12 step=1}-->
<!--                                                        {if $smarty.section.foo.index < 10}-->
<!--                                                            {assign var=hour value="0"|cat:$smarty.section.foo.index}-->
<!--                                                        {else}-->
<!--                                                            {assign var=hour value=$smarty.section.foo.index}-->
<!--                                                        {/if}-->
<!--                                                        <option value="{$hour}" {if $auctionRow[0].auction_start_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>-->
<!--                                                    {/section}-->
<!--                                                </select><label class="time-txt">(Hour) : </label>                                          -->
<!--                                                <select name="auction_start_min" size="1" tabindex="8" class="dd-hour">-->
<!--                                                    <option value="00" {if $auction_start_min=='00'}selected{/if}>00</option>-->
<!--                                                    {section name=foo start=15 loop=60 step=15}-->
<!--                                                        <option value="{$smarty.section.foo.index}" {if $auctionRow[0].auction_start_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>-->
<!--                                                    {/section}-->
<!--                                                </select><label class="time-txt">(Min)</label>-->
<!--                                                <select name="auction_start_am_pm" size="1" tabindex="9" class="dd-hour">-->
<!--                                                    <option value="am" {if $auctionRow[0].auction_start_am_pm=='am'}selected{/if}>AM</option>-->
<!--                                                    <option value="pm" {if $auctionRow[0].auction_start_am_pm=='pm'}selected{/if}>PM</option>-->
<!--                                                </select>-->
<!--                                            {/if}-->
<!--                                            </td>-->
<!--                                            <td valign="top">-->
<!--                                            {if $auctionRow[0].auction_is_approved=='1'}-->
<!--                                                <input type="text" name="display_end_time" value="{$auctionRow[0].auction_end_hour} : {$auctionRow[0].auction_end_min} {$auctionRow[0].auction_end_am_pm|upper}" class="bigfield required" style="width:75px;" readonly="readonly" />-->
<!--                                                <input type="hidden" name="auction_end_hour" value="{$auctionRow[0].auction_end_hour}" />-->
<!--                                                <input type="hidden" name="auction_end_min" value="{$auctionRow[0].auction_end_min}" />-->
<!--                                                <input type="hidden" name="auction_end_am_pm" value="{$auctionRow[0].auction_end_am_pm}" />-->
<!---->
<!--                                            {else}-->
<!--                                                <select name="auction_end_hour" size="1" tabindex="7" class="dd-hour">-->
<!--                                                    {section name=foo start=0 loop=12 step=1}-->
<!--                                                    {if $smarty.section.foo.index < 10}-->
<!--                                                        {assign var=hour value="0"|cat:$smarty.section.foo.index}-->
<!--                                                    {else}-->
<!--                                                        {assign var=hour value=$smarty.section.foo.index}-->
<!--                                                    {/if}-->
<!--                                                    <option value="{$hour}" {if $auctionRow[0].auction_end_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>-->
<!--                                                    {/section}-->
<!--                                                </select><label class="time-txt">(Hour) : </label>                                       -->
<!--                                                <select name="auction_end_min" size="1" tabindex="8" class="dd-hour">-->
<!--                                                    <option value="00" {if $auctionRow[0].auction_end_min=='00'}selected{/if}>00</option>-->
<!--                                                    {section name=foo start=15 loop=60 step=15}-->
<!--                                                        <option value="{$smarty.section.foo.index}" {if $auctionRow[0].auction_end_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>-->
<!--                                                    {/section}-->
<!--                                                </select><label class="time-txt">(Min)</label>-->
<!--                                                <select name="auction_end_am_pm" size="1" tabindex="9" class="dd-hour">-->
<!--                                                    <option value="am" {if $auctionRow[0].auction_end_am_pm=='am'}selected{/if}>AM</option>-->
<!--                                                    <option value="pm" {if $auctionRow[0].auction_end_am_pm=='pm'}selected{/if}>PM</option>-->
<!--                                                </select>-->
<!--                                            {/if}-->
<!--                                            </td>-->
<!--                                            <td>&nbsp;</td>-->
<!--                                        </tr>-->
                                        <tr>
	                                        <td align="left" valign="top" colspan="3">
	                                         {if $auctionRow[0].auction_is_sold != '0'}
	                                         	<input type="hidden" name="flat_rolled" value="{$posterRow[0].flat_rolled}" />
	                                         	{if $posterRow[0].flat_rolled == 'flat'}
	                                         		<input type="radio" name="flat_rolled_show" value="flat" {if $posterRow[0].flat_rolled == 'flat'} checked="checked" {/if} {if $auctionRow[0].auction_is_approved != '0'} disabled="disabled" {/if} /><label>&nbsp;Flat&nbsp;</label>
	                                         	{elseif $posterRow[0].flat_rolled == 'rolled'}
	                                         		<input type="radio" name="flat_rolled_show" value="rolled" {if $posterRow[0].flat_rolled == 'rolled'} checked="checked" {/if} {if $auctionRow[0].auction_is_approved != '0'} disabled="disabled" {/if} /><label>&nbsp;Rolled</label>
	                                         	{/if}
	                                         {else}
	                                         <div id="flat_rolled" >
												{if $posterRow[0].flat_rolled == 'flat'}
                                                	<div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                	<div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
                                                {elseif $posterRow[0].flat_rolled == 'rolled'}
                                                	<div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                	<div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" {if $posterRow[0].flat_rolled == 'rolled'} checked="checked" {/if} /><label>&nbsp;Rolled</label></div>
												
												{/if}
											</div>
	                                         {/if}
	                                        </td>
                                    	</tr>
                                        <tr>
                                            <td align="center" valign="top" colspan="3" style="text-align:center;">
                                            <div id="existing_photos" style="text-align:center; margin:0 auto;" >
                                                {section name=counter loop=$posterImageRows}
                                                    {assign var="countID" value=$smarty.section.counter.index+1}
                                                    <div id="existing_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$posterImageRows[counter].image_path}" height="78" width="100" />
                                                    <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} {if $auctionRow[0].auction_is_approved=='1'} disabled="disabled"{/if}/>
                                                    <br />
													{if $auctionRow[0].auction_is_approved=='0'}
													<img src="{$smarty.const.CLOUD_STATIC}delete-icon.png" onclick="deletePhoto('existing_{$countID}', '{$posterImageRows[counter].poster_thumb}', 'existing')" />
													{/if}
                                                    <span id="errexisting_{$countID}"></span>
                                                    </div>
                                                {/section}
                                            </div>                                                          
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" colspan="3" style="text-align:center;">
                                                <div id="browse"  style="text-align:center; margin:0 auto;"{if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}">
												{if $auctionRow[0].auction_is_approved=='0'}
                                                    <div id="fileUpload">You have a problem with your javascript</div>
												{/if}	
                                                    <input type="hidden" name="poster_images" id="poster_images" value="{$poster_images}" class="validate" />
                                                    <div class="disp-err">{$poster_images_err}</div>
                                                    <div class="disp-err">{$is_default_err}</div>
												{if $auctionRow[0].auction_is_approved=='0'}	
                                                    <div style="font-size:11px; width:300px; margin:0 auto;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
												{/if}	
                                                </div>
                                              <div id="path" 	style="padding:5px 0px;{if $browse_count >= $smarty.const.MAX_UPLOAD_POSTER}display:none;{/if}" >  
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
									 {if $auctionRow[0].auction_is_approved=='0'}    
                                        <input type="submit" value="Submit" class="submit-btn wymupdate" />
									 {/if}
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
                        Sorry no such auctions found.
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

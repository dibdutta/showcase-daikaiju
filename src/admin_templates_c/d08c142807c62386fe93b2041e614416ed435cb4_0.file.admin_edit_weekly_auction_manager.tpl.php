<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:22:31
  from '/var/www/html/admin_templates/admin_edit_weekly_auction_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698774d7176065_01714576',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd08c142807c62386fe93b2041e614416ed435cb4' => 
    array (
      0 => '/var/www/html/admin_templates/admin_edit_weekly_auction_manager.tpl',
      1 => 1770484913,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698774d7176065_01714576 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<!--<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/uploadify/uploadify.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/uploadify/jquery.uploadify.js"><?php echo '</script'; ?>
>-->

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery.ui.plupload.css" type="text/css" />

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
//document.getElementById("cnt").value=countImage();
	var uploader = $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : "../upload.php?random=<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
",
 
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
	function submitForm(){
		var all = $(".plupload_file_name").map(function() {
			return this.title;
		}).get();
		var res = all.join().split(",");
		var unqArr = Array.from(new Set(res)).filter(function(v){return v!==''});
		var post_img=unqArr.join();
		$("#poster_images").val(post_img);
		document.getElementById("configManager").submit();
	}
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Manage Poster / Auction</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="update_weekly">
							<input type="hidden" name="cnt" value="<?php echo $_smarty_tpl->tpl_vars['cnt']->value;?>
" id="cnt" />
                            <input type="hidden" name="auction_id" value="<?php echo $_REQUEST['auction_id'];?>
">
                            <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['fk_poster_id'];?>
">
                            <input type="hidden" name="random" value="<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
" />
                            <input type="hidden" name="existing_images" id="existing_images" value="<?php echo $_smarty_tpl->tpl_vars['existingImages']->value;?>
" />
							<input type="hidden" name="poster_images" id="poster_images" />
                            <input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Poster SKU :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['poster_sku'];?>
</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['poster_title'];?>
"  style="background-color:#CCCCCC;" size="40" class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_title_err']->value;?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 1) {?>
                                                    	<?php
$__section_posterCatCounter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterCategoryRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_posterCatCounter_1_total = $__section_posterCatCounter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter'] = new Smarty_Variable(array());
if ($__section_posterCatCounter_1_total !== 0) {
for ($__section_posterCatCounter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] = 0; $__section_posterCatCounter_1_iteration <= $__section_posterCatCounter_1_total; $__section_posterCatCounter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']++){
?>
                                                        	<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['posterCategoryRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] : null)]['fk_cat_id']) {?>
                                                            	<?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	</select>
												
												<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_size_err']->value;?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 2) {?>
                                                    	<?php
$__section_posterCatCounter_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterCategoryRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_posterCatCounter_3_total = $__section_posterCatCounter_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter'] = new Smarty_Variable(array());
if ($__section_posterCatCounter_3_total !== 0) {
for ($__section_posterCatCounter_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] = 0; $__section_posterCatCounter_3_iteration <= $__section_posterCatCounter_3_total; $__section_posterCatCounter_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']++){
?>
                                                        	<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['posterCategoryRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] : null)]['fk_cat_id']) {?>
                                                            	<?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['genre_err']->value;?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_4_total = $__section_counter_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_4_total !== 0) {
for ($__section_counter_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_4_iteration <= $__section_counter_4_total; $__section_counter_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 3) {?>
                                                    	<?php
$__section_posterCatCounter_5_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterCategoryRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_posterCatCounter_5_total = $__section_posterCatCounter_5_loop;
$_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter'] = new Smarty_Variable(array());
if ($__section_posterCatCounter_5_total !== 0) {
for ($__section_posterCatCounter_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] = 0; $__section_posterCatCounter_5_iteration <= $__section_posterCatCounter_5_total; $__section_posterCatCounter_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']++){
?>
                                                        	<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['posterCategoryRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] : null)]['fk_cat_id']) {?>
                                                            	<?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['dacade_err']->value;?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                <select name="country" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_6_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_6_total = $__section_counter_6_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_6_total !== 0) {
for ($__section_counter_6_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_6_iteration <= $__section_counter_6_total; $__section_counter_6_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 4) {?>
                                                    	<?php
$__section_posterCatCounter_7_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterCategoryRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_posterCatCounter_7_total = $__section_posterCatCounter_7_loop;
$_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter'] = new Smarty_Variable(array());
if ($__section_posterCatCounter_7_total !== 0) {
for ($__section_posterCatCounter_7_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] = 0; $__section_posterCatCounter_7_iteration <= $__section_posterCatCounter_7_total; $__section_posterCatCounter_7_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']++){
?>
                                                        	<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['posterCategoryRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] : null)]['fk_cat_id']) {?>
                                                            	<?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['country_err']->value;?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                <select name="condition" class="look" onchange="add_text_desc(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_8_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_8_total = $__section_counter_8_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_8_total !== 0) {
for ($__section_counter_8_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_8_iteration <= $__section_counter_8_total; $__section_counter_8_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 5) {?>
                                                        <?php
$__section_posterCatCounter_9_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterCategoryRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_posterCatCounter_9_total = $__section_posterCatCounter_9_loop;
$_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter'] = new Smarty_Variable(array());
if ($__section_posterCatCounter_9_total !== 0) {
for ($__section_posterCatCounter_9_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] = 0; $__section_posterCatCounter_9_iteration <= $__section_posterCatCounter_9_total; $__section_posterCatCounter_9_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']++){
?>
                                                        	<?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['posterCategoryRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_posterCatCounter']->value['index'] : null)]['fk_cat_id']) {?>
                                                            	<?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['condition_err']->value;?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['poster_desc']->value;?>
<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_desc_err']->value;?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                               
												<div id="flat_rolled" >
												<?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['flat_rolled'] == 'flat') {?>
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($_smarty_tpl->tpl_vars['flat_rolled']->value == 'rolled') {?> checked="checked" <?php }?> /><label>&nbsp;Rolled</label></div>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['flat_rolled'] == 'rolled') {?>
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['flat_rolled'] == 'rolled') {?> checked="checked" <?php }?> /><label>&nbsp;Rolled</label></div>
												
												<?php }?>
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    <?php
$__section_counter_10_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posterImageRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_10_total = $__section_counter_10_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_10_total !== 0) {
for ($__section_counter_10_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_10_iteration <= $__section_counter_10_total; $__section_counter_10_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                                        <?php $_smarty_tpl->_assignInScope('countID', (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)+1);?>
                                                                        <div id="existing_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" />
                                                                            <br /><input type="radio" name="is_default" value="<?php echo $_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_thumb'];?>
" <?php if ($_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_default'] == 1) {?> checked="checked" <?php }?> />
                                                                            <br /><img src="<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
delete-icon.png" onclick="deletePhoto('existing_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_thumb'];?>
', 'existing','weekly')" />
                                                                            <span id="errexisting_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
"></span>
                                                                        </div>
                                                                	<?php
}
}
?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
                                                               <div id="uploader"></div>
                                                                
													
											
											<div id="new_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                	<?php
$__section_counter_11_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['poster_images_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_11_total = $__section_counter_11_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_11_total !== 0) {
for ($__section_counter_11_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_11_iteration <= $__section_counter_11_total; $__section_counter_11_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                                        <?php $_smarty_tpl->_assignInScope('countID', (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)+1);?>
                                                                        <div id="new_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/poster_photo/temp/<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
" />
                                                                        <br /><img src="<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
delete-icon.png" onclick="deletePhoto('new_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
', 'new','weekly')" /></div>
                                                                	<?php
}
}
?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
											</tr>
											<tr class="tr_bgcolor" >
												<td class="bold_text" valign="top">Note :</td>
												<td class="smalltext"><span class="err">Please click on <b>Start Upload</b> before Submitting the Form.<br/>Make sure there shouldn't be any files <b>Queued</b></span></td>
											</tr>
											<tr class="tr_bgcolor" >
												<td class="bold_text" valign="top">ImDB link :</td>
												<td class="smalltext"><input type="text" name="imdb_link" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['imdb_link'];?>
"  class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['asked_price_err']->value;?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24" style="display:none;">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="10"  maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['asked_price_err']->value;?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top">Buynow Price :</td>
												<td class="smalltext"><input type="text" name="buynow_price" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_buynow_price'];?>
" maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['buynow_price_err']->value;?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Auction Week :</td>
												<td class="smalltext">
                                                <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_is_approved'] == 0) {?>
                                                	<select name="auction_week" class="look required">
                                                        <option value="" selected="selected">Select</option>
                                                        <?php
$__section_counter_12_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['aucetionWeeks']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_12_total = $__section_counter_12_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_12_total !== 0) {
for ($__section_counter_12_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_12_iteration <= $__section_counter_12_total; $__section_counter_12_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['fk_auction_week_id'] == $_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_title'];?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_start_date'],"%D");?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_start_date'],"%H:%M:%S");?>
) - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_end_date'],"%D");?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['aucetionWeeks']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_end_date'],"%H:%M:%S");?>
))</option>
                                                        <?php
}
}
?>
                                                    </select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['auction_week_err']->value;?>
</span>
                                                <?php } else { ?>
                                                <input type="hidden" name="auction_week" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['fk_auction_week_id'];?>
" />
                                                <?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_week_title'];?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_week_start_date'],"%D");?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_week_start_date'],"%H:%M:%S");?>
) - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_week_end_date'],"%D");?>
&nbsp;(<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_week_end_date'],"%H:%M:%S");?>
))
												<?php }?>
                                                </td>
											</tr>
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>Start Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_is_approved'] == 0) {?>-->
<!--                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">-->
<!--                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_13_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_13_iteration <= 12; $__section_foo_13_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>-->
<!--                                                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>-->
<!--                                                                <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>-->
<!--                                                            <?php } else { ?>-->
<!--                                                                <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>-->
<!--                                                            <?php }?>-->
<!--                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_hour'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>-->
<!--                                                        <?php
}
}
?>-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auction_start_min']->value == '00') {?>selected<?php }?>>00</option>-->
<!--                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_14_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_14_iteration <= 3; $__section_foo_14_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>-->
<!--                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_min'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>-->
<!--                                                        <?php
}
}
?>-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'] == 'am') {?>selected<?php }?>>AM</option>-->
<!--                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'] == 'pm') {?>selected<?php }?>>PM</option>-->
<!--                                                    </select>-->
<!--                                                <?php } else { ?>-->
<!--                                                	<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_hour'];?>
 : <?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_min'];?>
 <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'], 'UTF-8');?>
-->
<!--                                                    <input type="hidden" name="auction_start_hour" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_hour'];?>
" />-->
<!--                                                    <input type="hidden" name="auction_start_min" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_min'];?>
" />-->
<!--                                                    <input type="hidden" name="auction_start_am_pm" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'];?>
" />-->
<!--                                                <?php }?>-->
<!--                                                </td>-->
<!--											</tr>-->
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>End Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_is_approved'] == 0) {?>-->
<!--                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">-->
<!--                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_15_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_15_iteration <= 12; $__section_foo_15_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>-->
<!--                                                        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>-->
<!--                                                            <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>-->
<!--                                                        <?php } else { ?>-->
<!--                                                            <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>-->
<!--                                                        <?php }?>-->
<!--                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_hour'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>-->
<!--                                                        <?php
}
}
?>-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'] == '00') {?>selected<?php }?>>00</option>-->
<!--                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_16_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_16_iteration <= 3; $__section_foo_16_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>-->
<!--                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>-->
<!--                                                        <?php
}
}
?>-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'] == 'am') {?>selected<?php }?>>AM</option>-->
<!--                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'] == 'pm') {?>selected<?php }?>>PM</option>-->
<!--                                                    </select>-->
<!--                                                <?php } else { ?>-->
<!--                                                	<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_hour'];?>
 : <?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'];?>
 <?php echo mb_strtoupper($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'], 'UTF-8');?>
-->
<!--                                                    <input type="hidden" name="auction_end_hour" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_hour'];?>
" />-->
<!--                                                    <input type="hidden" name="auction_end_min" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'];?>
" />-->
<!--                                                    <input type="hidden" name="auction_end_am_pm" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'];?>
" />-->
<!--                                                <?php }?>-->
<!--                                                </td>-->
<!--											</tr>-->
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button" onclick="submitForm()" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;
echo $_smarty_tpl->tpl_vars['decoded_string']->value;?>
'; " /></td>
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

<?php echo '<script'; ?>
 type="text/javascript">
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
if(cnt==25)
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
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery-ui.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/plupload.full.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"><?php echo '</script'; ?>
><?php }
}

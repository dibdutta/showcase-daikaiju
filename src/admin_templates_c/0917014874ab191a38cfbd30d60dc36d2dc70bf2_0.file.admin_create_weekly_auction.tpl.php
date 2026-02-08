<?php
/* Smarty version 3.1.47, created on 2026-02-03 13:11:03
  from '/var/www/html/admin_templates/admin_create_weekly_auction.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_69823a3793d0f4_28525431',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0917014874ab191a38cfbd30d60dc36d2dc70bf2' => 
    array (
      0 => '/var/www/html/admin_templates/admin_create_weekly_auction.tpl',
      1 => 1611227852,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_69823a3793d0f4_28525431 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<!--<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/uploadify/uploadify.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/uploadify/jquery.uploadify.js"><?php echo '</script'; ?>
>
<!--<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/autocomplete/jquery.autocomplete.js"><?php echo '</script'; ?>
>-->
<!--<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/autocomplete/jquery.autocomplete.css" type="text/css" />-->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/plupload/jquery.ui.plupload.css" type="text/css" />

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {   

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
                <?php if ($_smarty_tpl->tpl_vars['event_id_err']->value != '') {?>
                <tr>
					<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['event_id_err']->value;?>
</div></td>
				</tr>
                <?php }?>
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="save_weekly_auction">
							 <input type="hidden" name="cnt" id="cnt" value="<?php echo $_smarty_tpl->tpl_vars['cnt']->value;?>
" />
                            <input type="hidden" name="random" value="<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
" />
                            <input type="hidden" name="poster_images" id="poster_images" />
							<input type="hidden" id="no_sizes" name="no_sizes" value="<?php echo $_smarty_tpl->tpl_vars['no_sizes']->value;?>
" />
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
												<div><input type="text" name="user" id="user"  class="look" value="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
"  onkeyup="autocom(this.value);"/></div>						
                       						    <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
"  class="look"/>
												<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['user_id_err']->value;?>
</span>
                                                </div>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="<?php echo $_smarty_tpl->tpl_vars['poster_title']->value;?>
" size="40" class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_title_err']->value;?>
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
                                                        <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['poster_size']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
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
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_size_err']->value;?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 2) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['genre']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
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
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 3) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['dacade']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
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
$__section_counter_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_3_total = $__section_counter_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_3_total !== 0) {
for ($__section_counter_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_3_iteration <= $__section_counter_3_total; $__section_counter_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 4) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['country']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
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
$__section_counter_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['catRows']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_4_total = $__section_counter_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_4_total !== 0) {
for ($__section_counter_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_4_iteration <= $__section_counter_4_total; $__section_counter_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_cat_type_id'] == 5) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_id'] == $_smarty_tpl->tpl_vars['condition']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
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
												<td class="smalltext"><!--<textarea name="poster_desc" class="look" cols="70" rows="6"><?php echo $_smarty_tpl->tpl_vars['poster_desc']->value;?>
</textarea>--><?php echo $_smarty_tpl->tpl_vars['poster_desc']->value;?>
<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['poster_desc_err']->value;?>
</span></td>
											</tr>
                                            <!--  <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Start Time :</td>
												<td class="smalltext">
                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_5_iteration <= 12; $__section_foo_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
                                                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>
                                                                <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>
                                                            <?php } else { ?>
                                                                <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>
                                                            <?php }?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auction_start_hour']->value == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auction_start_min']->value == '00') {?>selected<?php }?>>00</option>
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_6_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_6_iteration <= 3; $__section_foo_6_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>
                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auction_start_min']->value == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Min)
                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auction_start_am_pm']->value == 'am') {?>selected<?php }?>>AM</option>
                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auction_start_am_pm']->value == 'pm') {?>selected<?php }?>>PM</option>
                                                    </select>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>End Time :</td>
												<td class="smalltext">
                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_7_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_7_iteration <= 12; $__section_foo_7_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
                                                        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>
                                                            <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>
                                                        <?php } else { ?>
                                                            <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>
                                                        <?php }?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auction_end_hour']->value == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auction_end_min']->value == '00') {?>selected<?php }?>>00</option>
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_8_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_8_iteration <= 3; $__section_foo_8_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>
                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auction_end_min']->value == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Min)
                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auction_end_am_pm']->value == 'am') {?>selected<?php }?>>AM</option>
                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auction_end_am_pm']->value == 'pm') {?>selected<?php }?>>PM</option>
                                                    </select>
                                                </td>
											</tr>-->
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                                <div id="flat_rolled" <?php if ($_smarty_tpl->tpl_vars['flat_rolled']->value == '') {?> style="display:none;" <?php }?>>
                                                <div id="folded" <?php if ($_smarty_tpl->tpl_vars['flat_rolled']->value == 'rolled' && $_smarty_tpl->tpl_vars['no_sizes']->value != '2') {?> style="display:none;"<?php }?>>
												<input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
												</div>
                                                <div id="rolled" <?php if ($_smarty_tpl->tpl_vars['flat_rolled']->value == 'flat' && $_smarty_tpl->tpl_vars['no_sizes']->value != '2') {?> style="display:none;"<?php }?>>
												<input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($_smarty_tpl->tpl_vars['flat_rolled']->value == 'rolled') {?> checked="checked" <?php }?> /><label>&nbsp;Rolled</label>
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
                                                                    <?php
$__section_counter_9_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['poster_images_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_9_total = $__section_counter_9_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_9_total !== 0) {
for ($__section_counter_9_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_9_iteration <= $__section_counter_9_total; $__section_counter_9_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                                        <?php $_smarty_tpl->_assignInScope('countID', (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)+1);?>
                                                                        <div id="photo_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/poster_photo/temp/<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
" height="78" width="100" /><br /><input type="radio" name="is_default" style=" margin-left:40px;" value="<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
" <?php if ($_smarty_tpl->tpl_vars['is_default']->value == $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]) {?> checked="checked" <?php }?> /><br /><img src="<?php echo (defined('CLOUD_STATIC') ? constant('CLOUD_STATIC') : null);?>
delete-icon.png" onclick="deletePhoto('photo_<?php echo $_smarty_tpl->tpl_vars['countID']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['poster_images_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)];?>
', 'new')" style=" margin-left:30px;" /></div>
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
												<td class="smalltext"><input type="text" name="imdb_link" value=""  class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['asked_price_err']->value;?>
</span></td>
											</tr>
											                                            <tr class="tr_bgcolor" style="display:none;">
																								<td class="smalltext"><input type="text" name="asked_price" value="10" maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['asked_price_err']->value;?>
</span></td>
											</tr>
                                           
											
											
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Add" class="button" onclick="submitForm()" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;
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

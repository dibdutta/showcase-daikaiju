<?php /* Smarty version 2.6.14, created on 2021-11-13 10:22:19
         compiled from admin_edit_weekly_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_edit_weekly_auction_manager.tpl', 347, false),array('modifier', 'cat', 'admin_edit_weekly_auction_manager.tpl', 363, false),array('modifier', 'upper', 'admin_edit_weekly_auction_manager.tpl', 381, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/jquery.uploadify.js"></script>-->

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/plupload/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/plupload/jquery.ui.plupload.css" type="text/css" />
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
//document.getElementById("cnt").value=countImage();
	var uploader = $("#uploader").plupload({
        // General settings
        runtimes : \'html5,flash,silverlight,html4\',
        url : "../upload.php?random=';  echo $this->_tpl_vars['random'];  echo '",
 
        // Maximum file size
        max_file_size : \'10mb\',
 
        chunk_size: \'1mb\',
 
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
 
        // Enable ability to drag\'n\'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,
 
        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: \'thumbs\'
        },
 
        // Flash settings
        flash_swf_url : \'../plupload/js/Moxie.swf\',
     
        // Silverlight settings
        silverlight_xap_url : \'../plupload/js/Moxie.xap\'
    });
});
	function chkPosterSize(id){
	    if(id!=""){
    	var url = "../bid_popup.php";
    	$.get(url, {mode : \'chkPosterSizeCount\', id : id}, function(data){
    	var newData = data.split("-");
    			if( newData[0] ==1){
    				$("#flat_rolled").show();
    				if(newData[1]==\'f\'){
    					$("#rolled").hide();
    					$("#folded").show();
    					$("#folded_selected")[0].checked = true;
    				}else if(newData[1]==\'r\'){
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
		type : \'GET\',
		url : url,
		data: {
		 },
		 beforeSend : function(){
			//loading
			},
		 success : function(data){
		  if(data!=\'\'){
			var dataHtml = data;
			FCKeditorAPI.GetInstance(\'poster_desc\').Focus() ;
			FCKeditorAPI.GetInstance(\'poster_desc\').InsertHtml("<p>&nbsp;"+dataHtml+"</p>")
			//FCKeditorAPI.GetInstance(\'poster_desc\').InsertHtml("<p>&nbsp;Hello Add Me</p>")
			}else{
			FCKeditorAPI.GetInstance(\'poster_desc\').Focus() ;
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
		}
		});
		
		
		
		
		//alert(oEditor);
		//document.getElementById(\'poster_desc___Frame\').value="Hello Add me";
	}
	function submitForm(){
		var all = $(".plupload_file_name").map(function() {
			return this.title;
		}).get();
		var res = all.join().split(",");
		var unqArr = Array.from(new Set(res)).filter(function(v){return v!==\'\'});
		var post_img=unqArr.join();
		$("#poster_images").val(post_img);
		document.getElementById("configManager").submit();
	}
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Manage Poster / Auction</td>
				</tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="update_weekly">
							<input type="hidden" name="cnt" value="<?php echo $this->_tpl_vars['cnt']; ?>
" id="cnt" />
                            <input type="hidden" name="auction_id" value="<?php echo $_REQUEST['auction_id']; ?>
">
                            <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $this->_tpl_vars['auctionRow'][0]['fk_poster_id']; ?>
">
                            <input type="hidden" name="random" value="<?php echo $this->_tpl_vars['random']; ?>
" />
                            <input type="hidden" name="existing_images" id="existing_images" value="<?php echo $this->_tpl_vars['existingImages']; ?>
" />
							<input type="hidden" name="poster_images" id="poster_images" />
                            <input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
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
												<td class="smalltext"><?php echo $this->_tpl_vars['auctionRow'][0]['poster_sku']; ?>
</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="<?php echo $this->_tpl_vars['auctionRow'][0]['poster_title']; ?>
"  style="background-color:#CCCCCC;" size="40" class="look" /><br /><span class="err"><?php echo $this->_tpl_vars['poster_title_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 1): ?>
                                                    	<?php unset($this->_sections['posterCatCounter']);
$this->_sections['posterCatCounter']['name'] = 'posterCatCounter';
$this->_sections['posterCatCounter']['loop'] = is_array($_loop=$this->_tpl_vars['posterCategoryRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['posterCatCounter']['show'] = true;
$this->_sections['posterCatCounter']['max'] = $this->_sections['posterCatCounter']['loop'];
$this->_sections['posterCatCounter']['step'] = 1;
$this->_sections['posterCatCounter']['start'] = $this->_sections['posterCatCounter']['step'] > 0 ? 0 : $this->_sections['posterCatCounter']['loop']-1;
if ($this->_sections['posterCatCounter']['show']) {
    $this->_sections['posterCatCounter']['total'] = $this->_sections['posterCatCounter']['loop'];
    if ($this->_sections['posterCatCounter']['total'] == 0)
        $this->_sections['posterCatCounter']['show'] = false;
} else
    $this->_sections['posterCatCounter']['total'] = 0;
if ($this->_sections['posterCatCounter']['show']):

            for ($this->_sections['posterCatCounter']['index'] = $this->_sections['posterCatCounter']['start'], $this->_sections['posterCatCounter']['iteration'] = 1;
                 $this->_sections['posterCatCounter']['iteration'] <= $this->_sections['posterCatCounter']['total'];
                 $this->_sections['posterCatCounter']['index'] += $this->_sections['posterCatCounter']['step'], $this->_sections['posterCatCounter']['iteration']++):
$this->_sections['posterCatCounter']['rownum'] = $this->_sections['posterCatCounter']['iteration'];
$this->_sections['posterCatCounter']['index_prev'] = $this->_sections['posterCatCounter']['index'] - $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['index_next'] = $this->_sections['posterCatCounter']['index'] + $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['first']      = ($this->_sections['posterCatCounter']['iteration'] == 1);
$this->_sections['posterCatCounter']['last']       = ($this->_sections['posterCatCounter']['iteration'] == $this->_sections['posterCatCounter']['total']);
?>
                                                        	<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['posterCategoryRows'][$this->_sections['posterCatCounter']['index']]['fk_cat_id']): ?>
                                                            	<?php $this->assign('selected', 'selected'); ?>
                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select>
												
												<br /><span class="err"><?php echo $this->_tpl_vars['poster_size_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 2): ?>
                                                    	<?php unset($this->_sections['posterCatCounter']);
$this->_sections['posterCatCounter']['name'] = 'posterCatCounter';
$this->_sections['posterCatCounter']['loop'] = is_array($_loop=$this->_tpl_vars['posterCategoryRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['posterCatCounter']['show'] = true;
$this->_sections['posterCatCounter']['max'] = $this->_sections['posterCatCounter']['loop'];
$this->_sections['posterCatCounter']['step'] = 1;
$this->_sections['posterCatCounter']['start'] = $this->_sections['posterCatCounter']['step'] > 0 ? 0 : $this->_sections['posterCatCounter']['loop']-1;
if ($this->_sections['posterCatCounter']['show']) {
    $this->_sections['posterCatCounter']['total'] = $this->_sections['posterCatCounter']['loop'];
    if ($this->_sections['posterCatCounter']['total'] == 0)
        $this->_sections['posterCatCounter']['show'] = false;
} else
    $this->_sections['posterCatCounter']['total'] = 0;
if ($this->_sections['posterCatCounter']['show']):

            for ($this->_sections['posterCatCounter']['index'] = $this->_sections['posterCatCounter']['start'], $this->_sections['posterCatCounter']['iteration'] = 1;
                 $this->_sections['posterCatCounter']['iteration'] <= $this->_sections['posterCatCounter']['total'];
                 $this->_sections['posterCatCounter']['index'] += $this->_sections['posterCatCounter']['step'], $this->_sections['posterCatCounter']['iteration']++):
$this->_sections['posterCatCounter']['rownum'] = $this->_sections['posterCatCounter']['iteration'];
$this->_sections['posterCatCounter']['index_prev'] = $this->_sections['posterCatCounter']['index'] - $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['index_next'] = $this->_sections['posterCatCounter']['index'] + $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['first']      = ($this->_sections['posterCatCounter']['iteration'] == 1);
$this->_sections['posterCatCounter']['last']       = ($this->_sections['posterCatCounter']['iteration'] == $this->_sections['posterCatCounter']['total']);
?>
                                                        	<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['posterCategoryRows'][$this->_sections['posterCatCounter']['index']]['fk_cat_id']): ?>
                                                            	<?php $this->assign('selected', 'selected'); ?>
                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['genre_err']; ?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 3): ?>
                                                    	<?php unset($this->_sections['posterCatCounter']);
$this->_sections['posterCatCounter']['name'] = 'posterCatCounter';
$this->_sections['posterCatCounter']['loop'] = is_array($_loop=$this->_tpl_vars['posterCategoryRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['posterCatCounter']['show'] = true;
$this->_sections['posterCatCounter']['max'] = $this->_sections['posterCatCounter']['loop'];
$this->_sections['posterCatCounter']['step'] = 1;
$this->_sections['posterCatCounter']['start'] = $this->_sections['posterCatCounter']['step'] > 0 ? 0 : $this->_sections['posterCatCounter']['loop']-1;
if ($this->_sections['posterCatCounter']['show']) {
    $this->_sections['posterCatCounter']['total'] = $this->_sections['posterCatCounter']['loop'];
    if ($this->_sections['posterCatCounter']['total'] == 0)
        $this->_sections['posterCatCounter']['show'] = false;
} else
    $this->_sections['posterCatCounter']['total'] = 0;
if ($this->_sections['posterCatCounter']['show']):

            for ($this->_sections['posterCatCounter']['index'] = $this->_sections['posterCatCounter']['start'], $this->_sections['posterCatCounter']['iteration'] = 1;
                 $this->_sections['posterCatCounter']['iteration'] <= $this->_sections['posterCatCounter']['total'];
                 $this->_sections['posterCatCounter']['index'] += $this->_sections['posterCatCounter']['step'], $this->_sections['posterCatCounter']['iteration']++):
$this->_sections['posterCatCounter']['rownum'] = $this->_sections['posterCatCounter']['iteration'];
$this->_sections['posterCatCounter']['index_prev'] = $this->_sections['posterCatCounter']['index'] - $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['index_next'] = $this->_sections['posterCatCounter']['index'] + $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['first']      = ($this->_sections['posterCatCounter']['iteration'] == 1);
$this->_sections['posterCatCounter']['last']       = ($this->_sections['posterCatCounter']['iteration'] == $this->_sections['posterCatCounter']['total']);
?>
                                                        	<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['posterCategoryRows'][$this->_sections['posterCatCounter']['index']]['fk_cat_id']): ?>
                                                            	<?php $this->assign('selected', 'selected'); ?>
                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['dacade_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                <select name="country" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 4): ?>
                                                    	<?php unset($this->_sections['posterCatCounter']);
$this->_sections['posterCatCounter']['name'] = 'posterCatCounter';
$this->_sections['posterCatCounter']['loop'] = is_array($_loop=$this->_tpl_vars['posterCategoryRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['posterCatCounter']['show'] = true;
$this->_sections['posterCatCounter']['max'] = $this->_sections['posterCatCounter']['loop'];
$this->_sections['posterCatCounter']['step'] = 1;
$this->_sections['posterCatCounter']['start'] = $this->_sections['posterCatCounter']['step'] > 0 ? 0 : $this->_sections['posterCatCounter']['loop']-1;
if ($this->_sections['posterCatCounter']['show']) {
    $this->_sections['posterCatCounter']['total'] = $this->_sections['posterCatCounter']['loop'];
    if ($this->_sections['posterCatCounter']['total'] == 0)
        $this->_sections['posterCatCounter']['show'] = false;
} else
    $this->_sections['posterCatCounter']['total'] = 0;
if ($this->_sections['posterCatCounter']['show']):

            for ($this->_sections['posterCatCounter']['index'] = $this->_sections['posterCatCounter']['start'], $this->_sections['posterCatCounter']['iteration'] = 1;
                 $this->_sections['posterCatCounter']['iteration'] <= $this->_sections['posterCatCounter']['total'];
                 $this->_sections['posterCatCounter']['index'] += $this->_sections['posterCatCounter']['step'], $this->_sections['posterCatCounter']['iteration']++):
$this->_sections['posterCatCounter']['rownum'] = $this->_sections['posterCatCounter']['iteration'];
$this->_sections['posterCatCounter']['index_prev'] = $this->_sections['posterCatCounter']['index'] - $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['index_next'] = $this->_sections['posterCatCounter']['index'] + $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['first']      = ($this->_sections['posterCatCounter']['iteration'] == 1);
$this->_sections['posterCatCounter']['last']       = ($this->_sections['posterCatCounter']['iteration'] == $this->_sections['posterCatCounter']['total']);
?>
                                                        	<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['posterCategoryRows'][$this->_sections['posterCatCounter']['index']]['fk_cat_id']): ?>
                                                            	<?php $this->assign('selected', 'selected'); ?>
                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['country_err']; ?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                <select name="condition" class="look" onchange="add_text_desc(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 5): ?>
                                                        <?php unset($this->_sections['posterCatCounter']);
$this->_sections['posterCatCounter']['name'] = 'posterCatCounter';
$this->_sections['posterCatCounter']['loop'] = is_array($_loop=$this->_tpl_vars['posterCategoryRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['posterCatCounter']['show'] = true;
$this->_sections['posterCatCounter']['max'] = $this->_sections['posterCatCounter']['loop'];
$this->_sections['posterCatCounter']['step'] = 1;
$this->_sections['posterCatCounter']['start'] = $this->_sections['posterCatCounter']['step'] > 0 ? 0 : $this->_sections['posterCatCounter']['loop']-1;
if ($this->_sections['posterCatCounter']['show']) {
    $this->_sections['posterCatCounter']['total'] = $this->_sections['posterCatCounter']['loop'];
    if ($this->_sections['posterCatCounter']['total'] == 0)
        $this->_sections['posterCatCounter']['show'] = false;
} else
    $this->_sections['posterCatCounter']['total'] = 0;
if ($this->_sections['posterCatCounter']['show']):

            for ($this->_sections['posterCatCounter']['index'] = $this->_sections['posterCatCounter']['start'], $this->_sections['posterCatCounter']['iteration'] = 1;
                 $this->_sections['posterCatCounter']['iteration'] <= $this->_sections['posterCatCounter']['total'];
                 $this->_sections['posterCatCounter']['index'] += $this->_sections['posterCatCounter']['step'], $this->_sections['posterCatCounter']['iteration']++):
$this->_sections['posterCatCounter']['rownum'] = $this->_sections['posterCatCounter']['iteration'];
$this->_sections['posterCatCounter']['index_prev'] = $this->_sections['posterCatCounter']['index'] - $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['index_next'] = $this->_sections['posterCatCounter']['index'] + $this->_sections['posterCatCounter']['step'];
$this->_sections['posterCatCounter']['first']      = ($this->_sections['posterCatCounter']['iteration'] == 1);
$this->_sections['posterCatCounter']['last']       = ($this->_sections['posterCatCounter']['iteration'] == $this->_sections['posterCatCounter']['total']);
?>
                                                        	<?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['posterCategoryRows'][$this->_sections['posterCatCounter']['index']]['fk_cat_id']): ?>
                                                            	<?php $this->assign('selected', 'selected'); ?>
                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['condition_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext"><?php echo $this->_tpl_vars['poster_desc']; ?>
<br /><span class="err"><?php echo $this->_tpl_vars['poster_desc_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
                                               
												<div id="flat_rolled" >
												<?php if ($this->_tpl_vars['auctionRow'][0]['flat_rolled'] == 'flat'): ?>
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($this->_tpl_vars['flat_rolled'] == 'rolled'): ?> checked="checked" <?php endif; ?> /><label>&nbsp;Rolled</label></div>
                                                <?php elseif ($this->_tpl_vars['auctionRow'][0]['flat_rolled'] == 'rolled'): ?>
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($this->_tpl_vars['auctionRow'][0]['flat_rolled'] == 'rolled'): ?> checked="checked" <?php endif; ?> /><label>&nbsp;Rolled</label></div>
												
												<?php endif; ?>
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['posterImageRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                                        <?php $this->assign('countID', $this->_sections['counter']['index']+1); ?>
                                                                        <div id="existing_<?php echo $this->_tpl_vars['countID']; ?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['image_path']; ?>
" />
                                                                            <br /><input type="radio" name="is_default" value="<?php echo $this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['poster_thumb']; ?>
" <?php if ($this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['is_default'] == 1): ?> checked="checked" <?php endif; ?> />
                                                                            <br /><img src="<?php echo @CLOUD_STATIC; ?>
delete-icon.png" onclick="deletePhoto('existing_<?php echo $this->_tpl_vars['countID']; ?>
', '<?php echo $this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['poster_thumb']; ?>
', 'existing','weekly')" />
                                                                            <span id="errexisting_<?php echo $this->_tpl_vars['countID']; ?>
"></span>
                                                                        </div>
                                                                	<?php endfor; endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
                                                               <div id="uploader"></div>
                                                                
													
											
											<div id="new_photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                	<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['poster_images_arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                                        <?php $this->assign('countID', $this->_sections['counter']['index']+1); ?>
                                                                        <div id="new_<?php echo $this->_tpl_vars['countID']; ?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $this->_tpl_vars['actualPath']; ?>
/poster_photo/temp/<?php echo $this->_tpl_vars['random']; ?>
/<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
" />
                                                                        <br /><img src="<?php echo @CLOUD_STATIC; ?>
delete-icon.png" onclick="deletePhoto('new_<?php echo $this->_tpl_vars['countID']; ?>
', '<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
', 'new','weekly')" /></div>
                                                                	<?php endfor; endif; ?>
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
												<td class="smalltext"><input type="text" name="imdb_link" value="<?php echo $this->_tpl_vars['auctionRow'][0]['imdb_link']; ?>
"  class="look" /><br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24" style="display:none;">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="10"  maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top">Buynow Price :</td>
												<td class="smalltext"><input type="text" name="buynow_price" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_buynow_price']; ?>
" maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $this->_tpl_vars['buynow_price_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Auction Week :</td>
												<td class="smalltext">
                                                <?php if ($this->_tpl_vars['auctionRow'][0]['auction_is_approved'] == 0): ?>
                                                	<select name="auction_week" class="look required">
                                                        <option value="" selected="selected">Select</option>
                                                        <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['aucetionWeeks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                            <option value="<?php echo $this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['fk_auction_week_id'] == $this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_title']; ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
) - <?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
))</option>
                                                        <?php endfor; endif; ?>
                                                    </select><br /><span class="err"><?php echo $this->_tpl_vars['auction_week_err']; ?>
</span>
                                                <?php else: ?>
                                                <input type="hidden" name="auction_week" value="<?php echo $this->_tpl_vars['auctionRow'][0]['fk_auction_week_id']; ?>
" />
                                                <?php echo $this->_tpl_vars['auctionRow'][0]['auction_week_title']; ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_week_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_week_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
) - <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
))
												<?php endif; ?>
                                                </td>
											</tr>
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>Start Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <?php if ($this->_tpl_vars['auctionRow'][0]['auction_is_approved'] == 0): ?>-->
<!--                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">-->
<!--                                                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>-->
<!--                                                            <?php if ($this->_sections['foo']['index'] < 10): ?>-->
<!--                                                                <?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>-->
<!--                                                            <?php else: ?>-->
<!--                                                                <?php $this->assign('hour', $this->_sections['foo']['index']); ?>-->
<!--                                                            <?php endif; ?>-->
<!--                                                            <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>-->
<!--                                                        <?php endfor; endif; ?>-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" <?php if ($this->_tpl_vars['auction_start_min'] == '00'): ?>selected<?php endif; ?>>00</option>-->
<!--                                                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)15;
$this->_sections['foo']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)15) == 0 ? 1 : (int)15;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>-->
<!--                                                            <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>-->
<!--                                                        <?php endfor; endif; ?>-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>-->
<!--                                                        <option value="pm" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>-->
<!--                                                    </select>-->
<!--                                                <?php else: ?>-->
<!--                                                	<?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_hour']; ?>
 : <?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_min']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_start_am_pm'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
-->
<!--                                                    <input type="hidden" name="auction_start_hour" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_hour']; ?>
" />-->
<!--                                                    <input type="hidden" name="auction_start_min" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_min']; ?>
" />-->
<!--                                                    <input type="hidden" name="auction_start_am_pm" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_am_pm']; ?>
" />-->
<!--                                                <?php endif; ?>-->
<!--                                                </td>-->
<!--											</tr>-->
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top"><span class="err">*</span>End Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <?php if ($this->_tpl_vars['auctionRow'][0]['auction_is_approved'] == 0): ?>-->
<!--                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">-->
<!--                                                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>-->
<!--                                                        <?php if ($this->_sections['foo']['index'] < 10): ?>-->
<!--                                                            <?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>-->
<!--                                                        <?php else: ?>-->
<!--                                                            <?php $this->assign('hour', $this->_sections['foo']['index']); ?>-->
<!--                                                        <?php endif; ?>-->
<!--                                                        <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>-->
<!--                                                        <?php endfor; endif; ?>-->
<!--                                                    </select>(Hour) :                                            -->
<!--                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">-->
<!--                                                        <option value="00" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_min'] == '00'): ?>selected<?php endif; ?>>00</option>-->
<!--                                                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)15;
$this->_sections['foo']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)15) == 0 ? 1 : (int)15;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>-->
<!--                                                            <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>-->
<!--                                                        <?php endfor; endif; ?>-->
<!--                                                    </select>(Min)-->
<!--                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">-->
<!--                                                        <option value="am" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>-->
<!--                                                        <option value="pm" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>-->
<!--                                                    </select>-->
<!--                                                <?php else: ?>-->
<!--                                                	<?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_hour']; ?>
 : <?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_min']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_end_am_pm'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
-->
<!--                                                    <input type="hidden" name="auction_end_hour" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_hour']; ?>
" />-->
<!--                                                    <input type="hidden" name="auction_end_min" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_min']; ?>
" />-->
<!--                                                    <input type="hidden" name="auction_end_am_pm" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_am_pm']; ?>
" />-->
<!--                                                <?php endif; ?>-->
<!--                                                </td>-->
<!--											</tr>-->
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button" onclick="submitForm()" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $this->_tpl_vars['actualPath'];  echo $this->_tpl_vars['decoded_string']; ?>
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
<?php echo '
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
</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/plupload/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js"></script>
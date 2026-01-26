<?php /* Smarty version 2.6.14, created on 2021-10-24 07:09:54
         compiled from admin_reopen_weekly_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_reopen_weekly_auction_manager.tpl', 327, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
function choose_option(val){
	//$("#choose_option").hide();
	if(val==\'fixed\'){
		$("#formarea").hide();
		$("#formarea_fixed").show();
		document.getElementById(\'is_consider\').checked = false;
	}else if(val==\'weekly\'){
		$("#formarea_fixed").hide();
		$("#minOfferDiv").hide();
		$("#formarea").show();
	}
}
	function checkMinOffer(){
		if ($(\'#is_consider\').is(\':checked\')) {
			//alert(\'checked\');
			$("#minOfferDiv").show();
		} else {
			// alert(\'unchecked\');
			$("#minOfferDiv").hide();
		}
    }	
	function chkPosterSize(id){
	    if(id!=""){
    	var url = "../bid_popup.php";
    	$.get(url, {mode : \'chkPosterSizeCount\', id : id}, function(data){
    	var newData = data.split("-");
		document.getElementById(\'no_sizes\').value=newData[0];
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
</script>
'; ?>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/jquery.uploadify.js"></script>
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
							<input type="hidden" name="mode" value="reopen_weekly_auction">
                            <input type="hidden" name="auction_id" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_id']; ?>
">
                            <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $this->_tpl_vars['auctionRow'][0]['fk_poster_id']; ?>
">
                            <input type="hidden" name="random" value="<?php echo $this->_tpl_vars['random']; ?>
" />
                            <input type="hidden" name="decode_string" value="<?php echo $this->_tpl_vars['decoded_string']; ?>
" />
                            <input type="hidden" name="existing_images" id="existing_images" value="<?php echo $this->_tpl_vars['existingImages']; ?>
" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<?php if ($this->_tpl_vars['is_empty'] != '1'): ?>
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Poster SKU :</td>
												<td class="smalltext"><?php echo $this->_tpl_vars['posterRow'][0]['poster_sku']; ?>
</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="<?php echo $this->_tpl_vars['posterRow'][0]['poster_title']; ?>
" size="40" class="look"  /><br /><span class="err"><?php echo $this->_tpl_vars['poster_title_err']; ?>
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
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['poster_size_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look" >
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
												<td class="bold_text" valign="top"><span class="err">*</span>Dacade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look" >
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
                                                <select name="country" class="look" >
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
												<?php if ($this->_tpl_vars['posterRow'][0]['flat_rolled'] == 'flat'): ?>
                                                <div id="folded"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled" style="display:none;"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($this->_tpl_vars['flat_rolled'] == 'rolled'): ?> checked="checked" <?php endif; ?> /><label>&nbsp;Rolled</label></div>
                                                <?php elseif ($this->_tpl_vars['posterRow'][0]['flat_rolled'] == 'rolled'): ?>
                                                <div id="folded" style="display:none;"><input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label></div>
                                                <div id="rolled"><input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($this->_tpl_vars['posterRow'][0]['flat_rolled'] == 'rolled'): ?> checked="checked" <?php endif; ?> /><label>&nbsp;Rolled</label></div>
												
												<?php endif; ?>
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:680px; padding:10px; margin:0px; float:left;">
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
" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="<?php echo $this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['poster_thumb']; ?>
" <?php if ($this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['is_default'] == 1): ?> checked="checked" <?php endif; ?> disabled="disabled" />
                                                                        <br /></div>
                                                                	<?php endfor; endif; ?>
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
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext">$<input type="text" name="asked_price" size="30" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_asked_price']; ?>
" class="look-price" readonly="readonly" />.00<br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
                                            
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Start Date :</td>
												<td class="smalltext"><input type="text" name="start_date" id="start_date" size="30" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_start_date']; ?>
" class="look" readonly="readonly" /><br /><span class="err"><?php echo $this->_tpl_vars['start_date_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>End Date :</td>
												<td class="smalltext"><input type="text" name="end_date" id="end_date" size="30" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_end_date']; ?>
" class="look" readonly="readonly" /><br /><span class="err"><?php echo $this->_tpl_vars['end_date_err']; ?>
</span></td>
											</tr>
                                            <tr class="header_bgcolor" height="24">
                                                <td colspan="2" align="left" class="headertext">Relist Auction
                                                    <input type="radio"  value="fixed" name="choose_fixed_weekly" id="choose_fixed"  onclick="choose_option(this.value)">
                                                    <span>Fixed Price</span>
                                                    <input type="radio"  value="weekly" name="choose_fixed_weekly" id="choose_weekly"  onclick="choose_option(this .value)">
                                                    <span>Weekly Auction</span>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor" id="formarea_fixed" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Fixed Auction Area -->

                                                        <span class="err">*</span>
                                                            Ask Price :
                                                </td>

                                                <td class="smalltext">
                                                      $<input type="text" class="look-price" size="32" maxlength="8" value="" name="fixed_asked_price" id="asked_price_fixed">
                                                            .00
                                                            <input type="checkbox"  value="1" name="is_consider" id="is_consider" onclick="checkMinOffer()" >
                                                            I will consider offers
                                                </td>

                                                </tr>
												<tr class="tr_bgcolor" id="minOfferDiv" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Fixed Auction Area -->

                                                        
                                                            Min Offer Price :
                                                </td>

                                                <td class="smalltext">
                                                      $<input type="text" class="look-price" size="32" maxlength="8" value="" name="offer_price" id="asked_price_fixed">
                                                            .00
                                                            
                                                </td>

                                                </tr>
                                            <tr class="tr_bgcolor" id="formarea" style="display:none;">
                                                <td class="bold_text">
                                                    <!-- Weekly Auction Area -->

                                                            <span class="err">*</span>
                                                                Auction Week:
                                                </td>
                                                <td class="smalltext">
                                                                <select name="auction_week" id="auction_week" style="width:320px;" class="formlisting-txtfield required">
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
" <?php if ($this->_tpl_vars['auction_week'] == $this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_id']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_title']; ?>
&nbsp;(<?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
&nbsp; - <?php echo ((is_array($_tmp=$this->_tpl_vars['aucetionWeeks'][$this->_sections['counter']['index']]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
)
                                                                        </option>
                                                                    <?php endfor; endif; ?>
                                                                </select>


                                                            <div class="per-field" style="display:none;">

                                                                $
                                                                <input type="text" class="register-txtfield required" size="32" maxlength="8" value="10" name="weekly_asked_price" id="asked_price">
                                                                .00 </div>

                                                </td>
                                            </tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $this->_tpl_vars['actualPath'];  echo $this->_tpl_vars['decoded_string']; ?>
'; " /></td>
											</tr>
										</table>
									</td>
								</tr>
								<?php else: ?>
								<tr><td align="center" colspan="2">Sorry no records found</td></tr>
								<?php endif; ?>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
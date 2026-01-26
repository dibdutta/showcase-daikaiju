<?php /* Smarty version 2.6.14, created on 2018-01-07 10:17:40
         compiled from admin_view_fixed_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'admin_view_fixed_auction_manager.tpl', 156, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/jquery.uploadify.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                	<td width="100%" align="center"><a href="#" onclick="history.back();" class="action_link"><strong>&lt;&lt; Back</strong></a></td>
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
							<input type="hidden" name="mode" value="update_fixed">
                            <input type="hidden" name="auction_id" value="<?php echo $this->_tpl_vars['auctionRow'][0]['auction_id']; ?>
">
                            <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $this->_tpl_vars['auctionRow'][0]['fk_poster_id']; ?>
">
                            <input type="hidden" name="random" id="random" value="<?php echo $this->_tpl_vars['random']; ?>
" />
                            <input type="hidden" name="existing_images" id="existing_images" value="<?php echo $this->_tpl_vars['existingImages']; ?>
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
												<td class="smalltext"><?php echo $this->_tpl_vars['posterRow'][0]['poster_sku']; ?>
</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><?php echo $this->_tpl_vars['posterRow'][0]['poster_title']; ?>
<br /><span class="err"><?php echo $this->_tpl_vars['poster_title_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
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
                                                            	<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>

                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                
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
                                                            	 <?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>

                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                       
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>

                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>

                                                            <?php endif; ?>
                                                        <?php endfor; endif; ?>
                                                        
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext"><?php echo $this->_tpl_vars['posterRow'][0]['poster_desc']; ?>
<br /><span class="err"><?php echo $this->_tpl_vars['poster_desc_err']; ?>
</span></td>
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
"  />
                                                                        <br /><input type="radio" name="is_default" value="<?php echo $this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['poster_thumb']; ?>
" <?php if ($this->_tpl_vars['posterImageRows'][$this->_sections['counter']['index']]['is_default'] == 1): ?> checked="checked" <?php endif; ?> disabled="disabled" />
                                                                        </div>
                                                                	<?php endfor; endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
                                                                
                                                                <div id="new_photos" style="width:680px; padding:10px; margin:0px; float:left;">
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
												<td class="bold_text" valign="top"><span class="err">*</span>Asked Price :</td>
												<td class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRow'][0]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
                                            
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">&nbsp;</td>
												<td class="smalltext"><input type="checkbox" name="is_consider" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_reserve_offer_price'] == 1): ?> checked="checked" <?php endif; ?> id="is_consider" disabled="disabled"  value="1" > &nbsp;I will consider offers</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Notes :</td>
												<td class="smalltext"><?php echo $this->_tpl_vars['auctionRow'][0]['auction_note']; ?>
<br /><span class="err"><?php echo $this->_tpl_vars['auction_note_err']; ?>
</span></td>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
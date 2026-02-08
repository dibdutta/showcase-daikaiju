<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:23:56
  from '/var/www/html/admin_templates/admin_view_weekly_auction_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6987752c3e03b8_02088505',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cf5d5669a21f83dc72c660cf5e5dc7f616abe82' => 
    array (
      0 => '/var/www/html/admin_templates/admin_view_weekly_auction_manager.tpl',
      1 => 1487960112,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6987752c3e03b8_02088505 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
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
>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                	<td width="100%" align="center"><a href="#" onclick="history.back();" class="action_link"><strong>&lt;&lt; Back</strong></a></td>
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
                            <input type="hidden" name="auction_id" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_id'];?>
">
                            <input type="hidden" name="poster_id" id="poster_id" value="<?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['fk_poster_id'];?>
">
                            <input type="hidden" name="random" value="<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
" />
                            <input type="hidden" name="existing_images" id="existing_images" value="<?php echo $_smarty_tpl->tpl_vars['existingImages']->value;?>
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
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['posterRow']->value[0]['poster_sku'];?>
</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['posterRow']->value[0]['poster_title'];?>
</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>

                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>

                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>

                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                
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
                                                            	<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>

                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                               
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
                                                            	<?php echo $_smarty_tpl->tpl_vars['catRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_value'];?>

                                                            <?php }?>
                                                        <?php
}
}
?>
                                                        
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php }?>
                                                    <?php
}
}
?>
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['posterRow']->value[0]['poster_desc'];?>
</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:680px; padding:10px; margin:0px; float:left;">
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
"  />
                                                                        <br /><input type="radio" name="is_default" value="<?php echo $_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_thumb'];?>
" <?php if ($_smarty_tpl->tpl_vars['posterImageRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_default'] == 1) {?> checked="checked" <?php }?> disabled="disabled" />
                                                                        <br /></div>
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
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Starting Price :</td>
												<td class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_asked_price'],2);?>
<br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['asked_price_err']->value;?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Buynow Price :</td>
												<td class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_buynow_price'],2);?>
</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Start Date :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_date'];?>
</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>End Date :</td>
												<td class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_date'];?>
</td>
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
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

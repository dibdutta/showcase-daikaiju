<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:45:09
  from '/var/www/html/admin_templates/admin_email_template_item_specific.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981edd5dbfc64_30619052',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f56bd81714b7bbc9e8aba975d7e4d97ad52a826' => 
    array (
      0 => '/var/www/html/admin_templates/admin_email_template_item_specific.tpl',
      1 => 1487960250,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981edd5dbfc64_30619052 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/ZeroClipboard.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
	ZeroClipboard.setMoviePath('http://davidwalsh.name/demo/ZeroClipboard.swf');
	var clip = new ZeroClipboard.Client();
	$("#copy").click(function() {
		$.ajax({
			url: 'admin_account_manager.php?mode=view_template_item_specific', success: function(data) { 
				//alert(data); 
				//clip.addEventListener('mousedown',function() {
				clip.setText(data);
				//});
				clip.addEventListener('complete',function(client,text) {
					alert('Html Successfully Copied!');
				});
				//glue it to the button
				clip.glue('copy');
			} 	 
		});
	});
});

<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>Set Email Template</strong></a></td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_email_template_item_specific">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Email Template</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Auction Id :</td>
												<td valign="top"><input type="text"  name="first_name" value="<?php echo $_smarty_tpl->tpl_vars['auction_id']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Banner Text :</td>
												<td valign="top"><input type="text"  name="banner_text" value="<?php echo $_smarty_tpl->tpl_vars['banner_text']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Banner Link :</td>
												<td valign="top"><input type="text"  name="banner_link" value="<?php echo $_smarty_tpl->tpl_vars['banner_link']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Second Banner Text :</td>
												<td valign="top"><input type="text"  name="fixed_text" value="<?php echo $_smarty_tpl->tpl_vars['fixed_text']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Second Banner Link :</td>
												<td valign="top"><input type="text"  name="second_banner_link" value="<?php echo $_smarty_tpl->tpl_vars['second_banner_link']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Title of the Template :</td>
												<td valign="top"><input type="text"  name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" maxlength="400" size="32" /><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"><span class="err">*</span> Is Auction Item :</td>
												<td valign="top"><input type="checkbox" name="is_auction" value="1" <?php if ($_smarty_tpl->tpl_vars['is_auction']->value == 1) {?>checked <?php }?>/><br><span class="err"><?php echo $_smarty_tpl->tpl_vars['first_name_err']->value;?>
</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="View Template" class="button" onclick="javascript:window.open('admin_account_manager.php?mode=view_template_item_specific','_blank');"/>&nbsp;&nbsp;
												<input type="button" name="copy" id="copy" value="Copy Html" class="button" onclick="emailtemplate();"/></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

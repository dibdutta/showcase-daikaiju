<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:57:31
  from '/var/www/html/admin_templates/admin_add_auction_week.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981f0bbb9a176_71896497',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb27fc28ab8f1882d911185b9e81fa002c5bc03b' => 
    array (
      0 => '/var/www/html/admin_templates/admin_add_auction_week.tpl',
      1 => 1487960140,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_6981f0bbb9a176_71896497 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/formvalidation.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/jquery.validate.js"><?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
	$("#frm_add_event").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
	<tr>
		<td width="100%" align="center">
			<form name="frm_add_event" id="frm_add_event" method="post" action="">
				<input type="hidden" name="mode" value="save_auction_week" />
                <input type="hidden" name="event_id" value="<?php echo $_smarty_tpl->tpl_vars['event']->value[0]['event_id'];?>
" />
				<input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
				<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Add Auction Week</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top" width="25%"><span class="err">*</span> Start Date : </td>
						<td><input type="text" name="start_date" id="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" class="look required" />
                         <!--<div class="list-err"><?php echo $_smarty_tpl->tpl_vars['start_date_err']->value;?>
</div>-->
                         <br /><span class="err" id="start_date_err"><?php echo $_smarty_tpl->tpl_vars['start_date_err']->value;?>
</span>
                         </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> End Date : </td>
						<td><input type="text" name="end_date" id="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
" class="look required" />&nbsp;(End date must greater than today & start date)
                       <!-- <div class="list-err"><?php echo $_smarty_tpl->tpl_vars['end_date_err']->value;?>
</div>-->
                       <br /><span class="err" id="end_date_err"><?php echo $_smarty_tpl->tpl_vars['end_date_err']->value;?>
</span>
                       </td>
					</tr>
					<tr class="tr_bgcolor">
												<td class="bold" valign="top">&nbsp;&nbsp;Start Time :</td>
												<td class="smalltext">
                                                
                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_0_iteration <= 12; $__section_foo_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
                                                            <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>
                                                                <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>
                                                            <?php } else { ?>
                                                                <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>
                                                            <?php }?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_hour'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_min'] == '00') {?>selected<?php }?>>00</option>
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_1_iteration <= 3; $__section_foo_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>
                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_min'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Min)
                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'] == 'am') {?>selected<?php }?>>AM</option>
                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_start_am_pm'] == 'pm') {?>selected<?php }?>>PM</option>
                                                    </select>
                                                
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="text" valign="top">&nbsp;&nbsp;End Time :</td>
												<td class="smalltext">
                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 0; $__section_foo_2_iteration <= 12; $__section_foo_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']++){
?>
                                                        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null) < 10) {?>
                                                            <?php $_smarty_tpl->_assignInScope('hour', ("0").((isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)));?>
                                                        <?php } else { ?>
                                                            <?php $_smarty_tpl->_assignInScope('hour', (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null));?>
                                                        <?php }?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_hour'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['hour']->value;?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'] == '00') {?>selected<?php }?>>00</option>
                                                        <?php
$_smarty_tpl->tpl_vars['__smarty_section_foo'] = new Smarty_Variable(array());
if (true) {
for ($__section_foo_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] = 15; $__section_foo_3_iteration <= 3; $__section_foo_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] += 15){
?>
                                                            <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_min'] == (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null)) {?>selected<?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_foo']->value['index'] : null);?>
</option>
                                                        <?php
}
}
?>
                                                    </select>(Min)
                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'] == 'am') {?>selected<?php }?>>AM</option>
                                                        <option value="pm" <?php if ($_smarty_tpl->tpl_vars['auctionRow']->value[0]['auction_end_am_pm'] == 'pm') {?>selected<?php }?>>PM</option>
                                                    </select>
                                              
                                                </td>
											</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Auction Week Tilte: </td>
						<td><input type="text" size="45" name="event_title" id="event_title" value="<?php echo $_smarty_tpl->tpl_vars['event_title']->value;?>
" class="look required" /> 
						<!--<div class="list-err"><?php echo $_smarty_tpl->tpl_vars['event_title']->value;?>
</div>-->
                        <br /><span class="err" id="event_title"><?php echo $_smarty_tpl->tpl_vars['event_title_err']->value;?>
</span>
                        </td>
					</tr>
					<tr>
					<td colspan="2">Please add Auction title not more than 19 or 20 letters.</td>
					</tr>
					<tr class="tr_bgcolor">
                        <td valign="top">&nbsp;</td>
                        <td><input type="checkbox" size="45" name="is_still"  value="1"  />
                            &nbsp;Auction For Stills/Photos
                        </td>
                    </tr>
                     <tr class="tr_bgcolor">
                        <td valign="top">Hide Auction From Front End</td>
                        <td><input type="checkbox" size="45" name="is_test"  value="1"  />
                            &nbsp;
                        </td>
                    </tr>
					
					<tr class="tr_bgcolor">
						<td align="center" colspan="2" class="bold_text" valign="top">
						<input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;
                        <input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['decoded_string']->value;?>
'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	
<?php }
}

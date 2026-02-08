<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:27:00
  from '/var/www/html/admin_templates/admin_proxy_auction_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698775e44831f2_08580494',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '980b9dbcba2d3a570fddf8d4758708d55e9f8026' => 
    array (
      0 => '/var/www/html/admin_templates/admin_proxy_auction_details.tpl',
      1 => 1487960176,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698775e44831f2_08580494 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
                    </tr>
                <?php }?> 
                    <tr>
                    	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;
echo $_smarty_tpl->tpl_vars['decoded_string']->value;?>
'; " class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                    </tr>              		
             	<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
                    <tr>
                    	<td align="left">
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                	<tr class="header_bgcolor" height="26">
                                        <td align="left" class="headertext" width="25%">Proxy Bid Person</td>
                                        <td align="center" class="headertext" width="20%">Proxy Bid Day</td>
                                        <td align="center" class="headertext" width="12%">Proxy amount</td>
<!--                                        <td width="8%">&nbsp;</td>-->
                                    </tr>
                                    <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['bidData']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                        <tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                                            <td align="left" class="smalltext">&nbsp;<?php echo $_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</td>
                                            <td align="center" class="smalltext">&nbsp;<?php if ($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'] > $_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['proxy_date'],"%m-%d-%Y");?>
 <?php } else { ?> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['post_date'],"%m-%d-%Y");?>
 <?php }?> </td>
                                            <td align="center" class="smalltext">&nbsp;<?php if ($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'] > $_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount']) {?>$<?php echo number_format($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
 <?php } else { ?> $<?php echo number_format($_smarty_tpl->tpl_vars['bidData']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_amount'],2);?>
 <?php }?></td>
<!--                                           <td align="center" class="bold_text">-->
<!--                                           		<a href="#"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
proxy-edit-icon.png" width="16" height="16" border="0" /></a>-->
<!--                                                <a href="#"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
proxy-del-icon.png" width="16" height="16" border="0" /></a>-->
<!--                                            </td>-->
                                        </tr>
                                    <?php
}
}
?>
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="smalltext" ></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
						</td>
                    </tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no proxy bid set for this poster.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

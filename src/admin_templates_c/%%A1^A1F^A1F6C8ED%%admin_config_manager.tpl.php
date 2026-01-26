<?php /* Smarty version 2.6.14, created on 2021-08-02 13:49:39
         compiled from admin_config_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'admin_config_manager.tpl', 106, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Change Configuration</td>
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
							<input type="hidden" name="mode" value="save_config">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Administrative Section</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%" >Admin Page Title :</td>
												<td class="smalltext"><input type="text" name="pageTitle" value="<?php echo $this->_tpl_vars['pageTitle']; ?>
" size="40" class="look" /><br><span class="err"><?php echo $this->_tpl_vars['pageTitle_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Admin Copyright Text :</td>
												<td class="smalltext"><input type="text" name="copyRight" value="<?php echo $this->_tpl_vars['copyRight']; ?>
" class="look" style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['copyRight_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Admin Welcome Text :</td>
												<td class="smalltext"><input type="text" name="welcomeText" value="<?php echo $this->_tpl_vars['welcomeText']; ?>
" class="look" style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['welcomeText_err']; ?>
</span></td>
											</tr>
                                            <tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Paypal Account Details</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Username :</td>
												<td class="smalltext"><input type="text" name="paypal_api_username" value="<?php echo $this->_tpl_vars['paypal_api_username']; ?>
" class="look" style="width:250px;" /><br /><span class="err"><?php echo $this->_tpl_vars['paypal_api_username_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Password :</td>
												<td class="smalltext"><input type="text" name="paypal_api_password" value="<?php echo $this->_tpl_vars['paypal_api_password']; ?>
" class="look" style="width:250px;" /><br /><span class="err"><?php echo $this->_tpl_vars['paypal_api_password_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Signature :</td>
												<td class="smalltext"><input type="text" name="paypal_api_signature" value="<?php echo $this->_tpl_vars['paypal_api_signature']; ?>
" class="look" style="width:250px;" /><br /><span class="err"><?php echo $this->_tpl_vars['paypal_api_signature_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Is Test Mode :</td>
												<td class="smalltext"><input type="checkbox" name="paypal_is_test_mode" value="1" <?php if ($this->_tpl_vars['paypal_is_test_mode'] == '1'): ?> checked="checked" <?php endif; ?> /><br><span class="err"><?php echo $this->_tpl_vars['pageTitle_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Administrator's Information</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Administrator's Name :</td>
												<td class="smalltext"><input type="text" name="adminName" value="<?php echo $this->_tpl_vars['adminName']; ?>
" class="look" style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['adminName_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Administrator's Email :</td>
												<td class="smalltext"><input type="text" name="adminEmail" value="<?php echo $this->_tpl_vars['adminEmail']; ?>
" class="look"  style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['adminEmail_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Peter Contarino's Email :</td>
												<td class="smalltext"><input type="text" name="peterEmail" value="<?php echo $this->_tpl_vars['peterEmail']; ?>
" class="look"  style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['peterEmail_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Halley's Email :</td>
												<td class="smalltext"><input type="text" name="seanEmail" value="<?php echo $this->_tpl_vars['seanEmail']; ?>
" class="look"  style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['seanEmail_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24" style="display:none;">
												<td colspan="2" align="left" class="headertext">Administrator's Instruction</td>
											</tr>
											<tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top">Instruction :</td>
												<td class="smalltext"><textarea name="instruction" class="look" cols="70" rows="6"><?php echo $this->_tpl_vars['instruction']; ?>
</textarea><br><span class="err"><?php echo $this->_tpl_vars['instruction_err']; ?>
</span></td>
											</tr>
											  <tr class="header_bgcolor" height="24">
									            <td colspan="2" align="left" class="headertext">Site Global SEO Information</td>
									           </tr>
									           <tr class="tr_bgcolor">
									            <td class="bold_text" valign="top">Meta Description :</td>
									            <td class="smalltext"><textarea name="metaKeywords" rows="6" cols="85" class="look" ><?php echo $this->_tpl_vars['metaKeywords']; ?>
</textarea></td>
									           </tr>
									           <tr class="tr_bgcolor">
									            <td class="bold_text" valign="top">Meta Keywords :</td>
									            <td class="smalltext"><textarea name="metaDescription" rows="6" cols="85" class="look"><?php echo $this->_tpl_vars['metaDescription']; ?>
</textarea></td>
									           </tr>           
									           <tr class="tr_bgcolor">
									            <td class="bold_text" valign="top">Meta Tags :</td>
									            <td class="smalltext"><textarea name="metaTags" rows="6" cols="85" class="look"><?php echo $this->_tpl_vars['metaTags']; ?>
</textarea></td>
									          </tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Settings</td>
											</tr>
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top">Start Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <select name="auction_start_hour" size="1" tabindex="7">-->
<!--                                                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)1;
$this->_sections['foo']['loop'] = is_array($_loop=13) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<!--                                                	<?php if ($this->_sections['foo']['index'] < 10): ?>-->
<!--                                                    	<?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>-->
<!--                                                    <?php else: ?>-->
<!--                                                    	<?php $this->assign('hour', $this->_sections['foo']['index']); ?>-->
<!--                                                    <?php endif; ?>-->
<!--                                                  <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auction_start_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>-->
<!--                                                   <?php endfor; endif; ?>-->
<!--                                                </select>(Hour) :-->
<!--                                               -->
<!--                                                <select name="auction_start_min" size="1" tabindex="8" >-->
<!--                                                  <option value="00" <?php if ($this->_tpl_vars['auction_start_min'] == '00'): ?>selected<?php endif; ?>>00</option>-->
<!--                                                 <?php unset($this->_sections['foo']);
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
<!--                                                  <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auction_start_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>-->
<!--                                                  <?php endfor; endif; ?>-->
<!--                                                  </select>(Min)-->
<!--                                                  <select name="auction_start_am_pm" size="1" tabindex="9" >-->
<!--                                                    <option value="am" <?php if ($this->_tpl_vars['auction_start_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>-->
<!--                                                    <option value="pm" <?php if ($this->_tpl_vars['auction_start_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>-->
<!--                                                  </select>-->
<!--                                                </td>-->
<!--											</tr>-->
<!--                                            <tr class="tr_bgcolor">-->
<!--												<td class="bold_text" valign="top">End Time :</td>-->
<!--												<td class="smalltext">-->
<!--                                                <select name="auction_end_hour" size="1" tabindex="7" >-->
<!--                                                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)1;
$this->_sections['foo']['loop'] = is_array($_loop=13) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<!--                                                	<?php if ($this->_sections['foo']['index'] < 10): ?>-->
<!--                                                    	<?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>-->
<!--                                                    <?php else: ?>-->
<!--                                                    	<?php $this->assign('hour', $this->_sections['foo']['index']); ?>-->
<!--                                                    <?php endif; ?>-->
<!--                                                  <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auction_end_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>-->
<!--                                                   <?php endfor; endif; ?>-->
<!--                                                </select>(Hour) :                                               -->
<!--                                                <select name="auction_end_min" size="1" tabindex="8" >-->
<!--                                                  <option value="00" <?php if ($this->_tpl_vars['auction_end_min'] == '00'): ?>selected<?php endif; ?>>00</option>-->
<!--                                                 <?php unset($this->_sections['foo']);
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
<!--                                                  <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auction_end_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>-->
<!--                                                  <?php endfor; endif; ?>-->
<!--                                                  </select>(Min)-->
<!--                                                  <select name="auction_end_am_pm" size="1" tabindex="9" >-->
<!--                                                    <option value="am" <?php if ($this->_tpl_vars['auction_end_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>-->
<!--                                                    <option value="pm" <?php if ($this->_tpl_vars['auction_end_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>-->
<!--                                                  </select>-->
<!--                                                </td>-->
<!--											</tr>-->
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Set Increase Time Before:</td>
												<td class="smalltext">
                                                <select name="auction_incr_min_span" size="1" tabindex="7" >
                                                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
                                                	<?php if ($this->_sections['foo']['index'] < 10): ?>
                                                    	<?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>
                                                    <?php else: ?>
                                                    	<?php $this->assign('hour', $this->_sections['foo']['index']); ?>
                                                    <?php endif; ?>
                                                  <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auction_incr_min_span'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>
                                                   <?php endfor; endif; ?>
                                                </select>(Min)
                                               
                                                <select name="auction_incr_sec_span" size="1" tabindex="8" >
                                                  <option value="00" <?php if ($this->_tpl_vars['auction_incr_sec_span'] == '00'): ?>selected<?php endif; ?>>00</option>
                                                  <option value="05" <?php if ($this->_tpl_vars['auction_incr_sec_span'] == '05'): ?>selected<?php endif; ?>>05</option>
                                                 <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)10;
$this->_sections['foo']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)5) == 0 ? 1 : (int)5;
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
?>
                                                  <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auction_incr_sec_span'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>
                                                  <?php endfor; endif; ?>
                                                  </select>(Sec)
                                                  
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Increase Time :</td>
												<td class="smalltext">
                                                <select name="auction_incr_by_min" size="1" tabindex="7" >
                                                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
?>
                                                	<?php if ($this->_sections['foo']['index'] < 10): ?>
                                                    	<?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>
                                                    <?php else: ?>
                                                    	<?php $this->assign('hour', $this->_sections['foo']['index']); ?>
                                                    <?php endif; ?>
                                                    <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auction_incr_by_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>
                                                  <?php endfor; endif; ?>  
                                                </select>(Min)
                                               
                                                <select name="auction_incr_by_sec" size="1" tabindex="8" >
                                                  <option value="00" <?php if ($this->_tpl_vars['auction_incr_by_sec'] == '00'): ?>selected<?php endif; ?>>00</option>
                                                  <option value="05" <?php if ($this->_tpl_vars['auction_incr_by_sec'] == '05'): ?>selected<?php endif; ?>>05</option>
                                                 <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)10;
$this->_sections['foo']['loop'] = is_array($_loop=60) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)5) == 0 ? 1 : (int)5;
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
?>
                                                  <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auction_incr_by_sec'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>
                                                  <?php endfor; endif; ?>
                                                 </select>(Sec)
                                                  
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Merchant Fee</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Merchant Fee:</td>
												<td class="smalltext"><input type="text" name="marchant_fee" value="<?php echo $this->_tpl_vars['marchant_fee']; ?>
" class="look" maxlength="5" style="width:50px;" />&nbsp;%<br /><span class="err"><?php echo $this->_tpl_vars['marchant_fee_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">MPE Charge</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">MPE Charge(Fixed):</td>
												<td class="smalltext"><input type="text" name="mpe_charge" value="<?php echo $this->_tpl_vars['mpe_charge']; ?>
" class="look" maxlength="5" style="width:50px;" />&nbsp;%<br /><span class="err"><?php echo $this->_tpl_vars['mpe_charge_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
                                                <td class="bold_text" valign="top">MPE Charge(Weekly):</td>
                                                <td class="smalltext"><input type="text" name="mpe_charge_weekly" value="<?php echo $this->_tpl_vars['mpe_charge_weekly']; ?>
" class="look" maxlength="5" style="width:50px;" />&nbsp;%<br /><span class="err"><?php echo $this->_tpl_vars['mpe_charge_weekly_err']; ?>
</span></td>
                                            </tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Sale Tax Settings</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Sales Tax for Gorgia:</td>
												<td class="smalltext"><input type="text" name="sale_tax_ga" value="<?php echo $this->_tpl_vars['sale_tax_ga']; ?>
" class="look" maxlength="5" style="width:50px;" />&nbsp;%<br /><span class="err"><?php echo $this->_tpl_vars['ga_sale_tax_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Sales Tax for North Carolina:</td>
												<td class="smalltext"><input type="text" name="sale_tax_nc" value="<?php echo $this->_tpl_vars['sale_tax_nc']; ?>
" class="look" maxlength="5" style="width:50px;" />&nbsp;%<br /><span class="err"><?php echo $this->_tpl_vars['nc_sale_tax_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Banner Settings</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Banner Title :</td>
												<td class="smalltext"><input type="text" name="bannerTitle" value="<?php echo $this->_tpl_vars['bannerTitle']; ?>
" class="look"  style="width:250px;" maxlength="50" /><br><span class="err"><?php echo $this->_tpl_vars['bannerTitle_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Banner Link :</td>
												<td class="smalltext"><input type="text" name="bannerLink" value="<?php echo $this->_tpl_vars['bannerLink']; ?>
" class="look"  style="width:250px;" /><br><span class="err"><?php echo $this->_tpl_vars['bannerLink_err']; ?>
</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Shorting Settings</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Shorting Type :</td>
												<td class="smalltext"><input type="radio" name="shortType" value="1" <?php if ($this->_tpl_vars['short_type'] == '1'): ?> checked="checked" <?php endif; ?>  />&nbsp;Auction Id
												<input type="radio" name="shortType" value="2" <?php if ($this->_tpl_vars['short_type'] == '2'): ?> checked="checked" <?php endif; ?>   />&nbsp;Highest to Lowest
												</td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button"></td>
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
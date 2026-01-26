<?php /* Smarty version 2.6.14, created on 2017-03-04 13:53:07
         compiled from admin_add_auction_week.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'admin_add_auction_week.tpl', 55, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/formvalidation.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/jquery.validate.js"></script>

<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#frm_add_event").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
	<tr>
		<td width="100%" align="center">
			<form name="frm_add_event" id="frm_add_event" method="post" action="">
				<input type="hidden" name="mode" value="save_auction_week" />
                <input type="hidden" name="event_id" value="<?php echo $this->_tpl_vars['event'][0]['event_id']; ?>
" />
				<input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
" />
				<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Add Auction Week</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top" width="25%"><span class="err">*</span> Start Date : </td>
						<td><input type="text" name="start_date" id="start_date" value="<?php echo $this->_tpl_vars['start_date']; ?>
" class="look required" />
                         <!--<div class="list-err"><?php echo $this->_tpl_vars['start_date_err']; ?>
</div>-->
                         <br /><span class="err" id="start_date_err"><?php echo $this->_tpl_vars['start_date_err']; ?>
</span>
                         </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> End Date : </td>
						<td><input type="text" name="end_date" id="end_date" value="<?php echo $this->_tpl_vars['end_date']; ?>
" class="look required" />&nbsp;(End date must greater than today & start date)
                       <!-- <div class="list-err"><?php echo $this->_tpl_vars['end_date_err']; ?>
</div>-->
                       <br /><span class="err" id="end_date_err"><?php echo $this->_tpl_vars['end_date_err']; ?>
</span>
                       </td>
					</tr>
					<tr class="tr_bgcolor">
												<td class="bold" valign="top">&nbsp;&nbsp;Start Time :</td>
												<td class="smalltext">
                                                
                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">
                                                        <?php unset($this->_sections['foo']);
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
?>
                                                            <?php if ($this->_sections['foo']['index'] < 10): ?>
                                                                <?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>
                                                            <?php else: ?>
                                                                <?php $this->assign('hour', $this->_sections['foo']['index']); ?>
                                                            <?php endif; ?>
                                                            <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>
                                                        <?php endfor; endif; ?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_min'] == '00'): ?>selected<?php endif; ?>>00</option>
                                                        <?php unset($this->_sections['foo']);
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
?>
                                                            <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>
                                                        <?php endfor; endif; ?>
                                                    </select>(Min)
                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>
                                                        <option value="pm" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_start_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>
                                                    </select>
                                                
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="text" valign="top">&nbsp;&nbsp;End Time :</td>
												<td class="smalltext">
                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">
                                                        <?php unset($this->_sections['foo']);
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
?>
                                                        <?php if ($this->_sections['foo']['index'] < 10): ?>
                                                            <?php $this->assign('hour', ((is_array($_tmp='0')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_sections['foo']['index']) : smarty_modifier_cat($_tmp, $this->_sections['foo']['index']))); ?>
                                                        <?php else: ?>
                                                            <?php $this->assign('hour', $this->_sections['foo']['index']); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['hour']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_hour'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['hour']; ?>
</option>
                                                        <?php endfor; endif; ?>
                                                    </select>(Hour) :                                            
                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">
                                                        <option value="00" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_min'] == '00'): ?>selected<?php endif; ?>>00</option>
                                                        <?php unset($this->_sections['foo']);
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
?>
                                                            <option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_min'] == $this->_sections['foo']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>
                                                        <?php endfor; endif; ?>
                                                    </select>(Min)
                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_am_pm'] == 'am'): ?>selected<?php endif; ?>>AM</option>
                                                        <option value="pm" <?php if ($this->_tpl_vars['auctionRow'][0]['auction_end_am_pm'] == 'pm'): ?>selected<?php endif; ?>>PM</option>
                                                    </select>
                                              
                                                </td>
											</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Auction Week Tilte: </td>
						<td><input type="text" size="45" name="event_title" id="event_title" value="<?php echo $this->_tpl_vars['event_title']; ?>
" class="look required" /> 
						<!--<div class="list-err"><?php echo $this->_tpl_vars['event_title']; ?>
</div>-->
                        <br /><span class="err" id="event_title"><?php echo $this->_tpl_vars['event_title_err']; ?>
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
                        <input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $this->_tpl_vars['decoded_string']; ?>
'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	
<?php /* Smarty version 2.6.14, created on 2019-02-10 12:48:30
         compiled from admin_auction_reconciliation_report_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin_auction_reconciliation_report_manager.tpl', 103, false),array('modifier', 'count', 'admin_auction_reconciliation_report_manager.tpl', 212, false),array('modifier', 'number_format', 'admin_auction_reconciliation_report_manager.tpl', 242, false),array('function', 'cycle', 'admin_auction_reconciliation_report_manager.tpl', 228, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/datepicker/jquery.datepick.js"></script>
<!--<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/formvalidation.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/jquery.validate.js"></script>-->
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

//function reset_date(){
//	$(\'#start_date\')[0].reset;
//
//}

function reset_date(ele) {
    $(ele).find(\':input\').each(function() {
        switch(this.type) {
        	case \'text\':
        	case \'select-one\':	
                $(this).val(\'\');
                break;    
            
        }
    });
    document.getElementById(\'auction_week\').style.display="none";
}
function test(){
if(document.getElementById(\'start_date\').value!=\'\'){
	if(document.getElementById(\'end_date\').value!=\'\'){
		return true;
	}else{
		alert("Please select a end date");
		document.getElementById(\'end_date\').focus();
		return false;
}
}	
}
function check_auction_type(val){
    if(val==\'weekly\'){
        document.getElementById(\'auction_week\').style.display="block";
    }else{
        document.getElementById(\'auction_week\').style.display="none";
		$("#auction_week").val(\'\');
    }
	if(val==\'stills\'){
        document.getElementById(\'auction_stills\').style.display="block";
    }else{
        document.getElementById(\'auction_stills\').style.display="none";
		$("#auction_stills").val(\'\');
    }
}
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td width="100%">
					<form action="" method="get" name="search_criteria" id="search_criteria" onsubmit="return test();">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2">							
							
							<tr>
								<td  class="bold_text" style="padding:5px 0 0 0;" align="right"   >
									
                                    	<input type="hidden" name="mode" value="auction_report" />
										Select : 
										</td>
										<td >
                                            <select name="search" class="look" id='search_id'  >
                                                
                                                <option value="reconciliation" <?php if ($this->_tpl_vars['search'] == 'reconciliation'): ?> selected="selected"<?php endif; ?> >Reconciliation</option>

                                            </select>
                                        <td>
                                        <td>
                                            <select name="auction_type" class="look" id='search_id' onchange="check_auction_type(this.value);"  >
                                                <option value="" selected="selected" >All</option>
                                                <option value="fixed" <?php if ($this->_tpl_vars['auction_type'] == 'fixed'): ?> selected="selected"<?php endif; ?> >Fixed</option>
                                                <option value="weekly" <?php if ($this->_tpl_vars['auction_type'] == 'weekly'): ?> selected="selected"<?php endif; ?> >Weekly</option>
                                                <option value="stills" <?php if ($this->_tpl_vars['auction_type'] == 'stills'): ?> selected="selected"<?php endif; ?> >Stills/Photos</option>
                                            </select>
                                        </td>
                                        <td>
										  <select name="auction_week"  class="look" id="auction_week" <?php if ($this->_tpl_vars['auction_type'] != 'weekly'): ?>style="display: none;"<?php endif; ?>>
                                            <option value="" selected="selected">All Auction</option>
											<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionWeek']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
												<option value="<?php echo $this->_tpl_vars['auctionWeek'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" <?php if ($_REQUEST['auction_week'] == $this->_tpl_vars['auctionWeek'][$this->_sections['counter']['index']]['auction_week_id']): ?> selected <?php endif; ?> >MPE Weekly Auction&nbsp;( <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionWeek'][$this->_sections['counter']['index']]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
)</option>
											<?php endfor; endif; ?>
                                         </select>
										 <select name="auction_stills"  class="look" id="auction_stills" <?php if ($this->_tpl_vars['auction_type'] != 'stills'): ?>style="display: none;"<?php endif; ?>>
                                            <option value="" selected="selected">All Stills Auction</option>
											<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionWeekStills']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
												<option value="<?php echo $this->_tpl_vars['auctionWeekStills'][$this->_sections['counter']['index']]['auction_week_id']; ?>
" <?php if ($_REQUEST['auction_stills'] == $this->_tpl_vars['auctionWeekStills'][$this->_sections['counter']['index']]['auction_week_id']): ?> selected <?php endif; ?> >MPE Stills Auction&nbsp;( <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionWeekStills'][$this->_sections['counter']['index']]['auction_week_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
)</option>
											<?php endfor; endif; ?>
                                         </select>
     								    </td >
								<td class="bold_text" width="10%" align="right" style="padding:5px 0 0 0;"  valign="top" >Seller:&nbsp;</td>
								<td>
								<select name="user_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['userRow']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                                    	<?php if ($this->_tpl_vars['userRow'][$this->_sections['counter']['index']]['user_id'] == $this->_tpl_vars['user_id']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['userRow'][$this->_sections['counter']['index']]['user_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['userRow'][$this->_sections['counter']['index']]['firstname']; ?>
 &nbsp;<?php echo $this->_tpl_vars['userRow'][$this->_sections['counter']['index']]['lastname']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['user_id_err']; ?>
</span></td>
                                 <td width="16%" valign="top">&nbsp;</td>
								
							</tr>
							<tr>
								<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date&nbsp;
								</td>
								<td>
								<input type="text" name="start_date" id="start_date" value="<?php echo $this->_tpl_vars['start_date_show']; ?>
"  class="look required" /></td>
								<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date&nbsp;
								</td>
								<td>
								<input type="text" name="end_date" id="end_date" value="<?php echo $this->_tpl_vars['end_date_show']; ?>
"  class="look required" /></td>
								
								<td width="16%" valign="top"><input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" ></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				<?php if ($this->_tpl_vars['total'] > 0): ?>
					<tr>
						<td align="center">
							<?php if ($this->_tpl_vars['nextParent'] <> ""): ?><div style="width: 96%; text-align: right;"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_category_manager.php?parent_id=<?php echo $this->_tpl_vars['nextParent']; ?>
&language_id=<?php echo $this->_tpl_vars['language_id']; ?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php endif; ?>
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="<?php echo $this->_tpl_vars['encoded_string']; ?>
" />
								<table align="center" width="60%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td  class="headertext" colspan="6">&nbsp;Sales Reconciliation Report</td >
											
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total poster:</td >
											<td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total']; ?>
&nbsp;<?php if ($this->_tpl_vars['total'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['total']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td class="bold_text" colspan="3">Total sold:</td >
											<td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_sold']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_amount_sold_by_mpe'] > 0): ?>&nbsp;($<?php echo $this->_tpl_vars['total_amount_sold_by_mpe']; ?>
) <?php endif;  if ($this->_tpl_vars['total_sold'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=sold&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>
										</tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Paid by Buyer:</td >
                                            <td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_paid_by_buyer']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_amount_paid_by_buyer'] > 0): ?>&nbsp;($<?php echo $this->_tpl_vars['total_amount_paid_by_buyer']; ?>
) <?php endif;  if ($this->_tpl_vars['total_paid_by_buyer'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid_by_buyer&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>


                                        </tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Unpaid by Buyer:</td >
                                            <td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_unpaid']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_amount_unpaid_by_buyer'] > 0): ?>&nbsp;($<?php echo $this->_tpl_vars['total_amount_unpaid_by_buyer']; ?>
)<?php endif;  if ($this->_tpl_vars['total_unpaid'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=unpaid&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>


                                        </tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Paid by MPE:</td >
											<td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_paid_by_admin']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_amount_paid_by_admin'] > 0): ?>($<?php echo $this->_tpl_vars['total_amount_paid_by_admin']; ?>
)&nbsp;<?php endif;  if ($this->_tpl_vars['total_paid_by_admin'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" title="details" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total to be Paid by MPE:</td >
										
											<td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_yet_paid']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_yet_paid'] > 0): ?><span id="seller_own_amount"></span>&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" title="View & Print" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=yet_to_pay&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Unsold:</td >
											<td colspan="3">&nbsp;<?php echo $this->_tpl_vars['total_unsold']; ?>
&nbsp;<?php if ($this->_tpl_vars['total_unsold'] > 0): ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=unsold&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php endif; ?></td>
										</tr>
																				<?php if ($this->_tpl_vars['total_yet_paid'] > 0 && count($this->_tpl_vars['paidAuctionDetails']) > 0): ?>
										<tr class="header_bgcolor" height="26">
											<td class="headertext" colspan="6">&nbsp;Yet to pay auction details</td >
										</tr>
										
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="16%">Poster</td >
											<td align="center" class="headertext" width="14%">Auction Type</td>
											<td align="center" class="headertext" width="15%">Sold Amount</td>
																						<td align="center" class="headertext" width="15%">Charges</td>
											<td align="center" class="headertext" width="15%">Discounts</td>
											<td align="center" class="headertext" width="15%">Seller Owed</td>
										</tr>
										<?php $this->assign('oldInvoice', 0); ?>
										<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
											<tr class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['image']; ?>
" ><br/>
												<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['poster_title']; ?>
(#<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['poster_sku']; ?>
)
												</td >
												
												
												<td align="center" class="smalltext"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '1'): ?>Fixed Price Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '2'): ?>Weekly Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '3'): ?>Monthly Auction<?php elseif ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['fk_auction_type_id'] == '5'): ?>Stills/Photo Auction<?php endif; ?></td>
												
												<td align="center" class="smalltext"><?php if ($this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt'] > 0): ?>$<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt'];  else: ?>--<?php endif; ?></td>
																								<?php if ($this->_tpl_vars['oldInvoice'] != $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['invoice_id']): ?>
												<td align="center" class="smalltext">
												<?php $this->assign('subTotalDis', 0); ?>
												<?php unset($this->_sections['counterdiscount']);
$this->_sections['counterdiscount']['name'] = 'counterdiscount';
$this->_sections['counterdiscount']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counterdiscount']['show'] = true;
$this->_sections['counterdiscount']['max'] = $this->_sections['counterdiscount']['loop'];
$this->_sections['counterdiscount']['step'] = 1;
$this->_sections['counterdiscount']['start'] = $this->_sections['counterdiscount']['step'] > 0 ? 0 : $this->_sections['counterdiscount']['loop']-1;
if ($this->_sections['counterdiscount']['show']) {
    $this->_sections['counterdiscount']['total'] = $this->_sections['counterdiscount']['loop'];
    if ($this->_sections['counterdiscount']['total'] == 0)
        $this->_sections['counterdiscount']['show'] = false;
} else
    $this->_sections['counterdiscount']['total'] = 0;
if ($this->_sections['counterdiscount']['show']):

            for ($this->_sections['counterdiscount']['index'] = $this->_sections['counterdiscount']['start'], $this->_sections['counterdiscount']['iteration'] = 1;
                 $this->_sections['counterdiscount']['iteration'] <= $this->_sections['counterdiscount']['total'];
                 $this->_sections['counterdiscount']['index'] += $this->_sections['counterdiscount']['step'], $this->_sections['counterdiscount']['iteration']++):
$this->_sections['counterdiscount']['rownum'] = $this->_sections['counterdiscount']['iteration'];
$this->_sections['counterdiscount']['index_prev'] = $this->_sections['counterdiscount']['index'] - $this->_sections['counterdiscount']['step'];
$this->_sections['counterdiscount']['index_next'] = $this->_sections['counterdiscount']['index'] + $this->_sections['counterdiscount']['step'];
$this->_sections['counterdiscount']['first']      = ($this->_sections['counterdiscount']['iteration'] == 1);
$this->_sections['counterdiscount']['last']       = ($this->_sections['counterdiscount']['iteration'] == $this->_sections['counterdiscount']['total']);
?>
												<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['description']; ?>
:$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <br/>
												<?php $this->assign('subTotalDis', $this->_tpl_vars['subTotalDis']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount']); ?>
												<?php $this->assign('TotalDis', $this->_tpl_vars['TotalDis']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['discounts'][$this->_sections['counterdiscount']['index']]['amount']); ?>												
												<?php endfor; endif; ?>
												
												</td>
												<td align="center" class="smalltext">
												<?php $this->assign('subTotalCharge', 0); ?>
												<?php unset($this->_sections['countercharge']);
$this->_sections['countercharge']['name'] = 'countercharge';
$this->_sections['countercharge']['loop'] = is_array($_loop=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['countercharge']['show'] = true;
$this->_sections['countercharge']['max'] = $this->_sections['countercharge']['loop'];
$this->_sections['countercharge']['step'] = 1;
$this->_sections['countercharge']['start'] = $this->_sections['countercharge']['step'] > 0 ? 0 : $this->_sections['countercharge']['loop']-1;
if ($this->_sections['countercharge']['show']) {
    $this->_sections['countercharge']['total'] = $this->_sections['countercharge']['loop'];
    if ($this->_sections['countercharge']['total'] == 0)
        $this->_sections['countercharge']['show'] = false;
} else
    $this->_sections['countercharge']['total'] = 0;
if ($this->_sections['countercharge']['show']):

            for ($this->_sections['countercharge']['index'] = $this->_sections['countercharge']['start'], $this->_sections['countercharge']['iteration'] = 1;
                 $this->_sections['countercharge']['iteration'] <= $this->_sections['countercharge']['total'];
                 $this->_sections['countercharge']['index'] += $this->_sections['countercharge']['step'], $this->_sections['countercharge']['iteration']++):
$this->_sections['countercharge']['rownum'] = $this->_sections['countercharge']['iteration'];
$this->_sections['countercharge']['index_prev'] = $this->_sections['countercharge']['index'] - $this->_sections['countercharge']['step'];
$this->_sections['countercharge']['index_next'] = $this->_sections['countercharge']['index'] + $this->_sections['countercharge']['step'];
$this->_sections['countercharge']['first']      = ($this->_sections['countercharge']['iteration'] == 1);
$this->_sections['countercharge']['last']       = ($this->_sections['countercharge']['iteration'] == $this->_sections['countercharge']['total']);
?>
												<?php echo $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['description']; ?>
:$<?php echo ((is_array($_tmp=$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
 <br/>
												<?php $this->assign('subTotalCharge', $this->_tpl_vars['subTotalCharge']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount']); ?>												
												<?php $this->assign('TotalCharge', $this->_tpl_vars['TotalCharge']+$this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['additional_charges'][$this->_sections['countercharge']['index']]['amount']); ?>
												<?php endfor; endif; ?>
												
												</td>
												<?php else: ?>
												 <?php $this->assign('subTotalCharge', 0); ?>	
												 <?php $this->assign('subTotalDis', 0); ?>
												     <td align="center" class="smalltext"> -- </td>
													 <td align="center" class="smalltext"> -- </td>
												<?php endif; ?>
												
												<td align="center" class="smalltext">
												<?php $this->assign('soldamnt', $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['soldamnt']); ?>
												<?php $this->assign('totalOwn', $this->_tpl_vars['subTotalCharge']+$this->_tpl_vars['soldamnt']); ?>
												<?php $this->assign('sellerOwn', $this->_tpl_vars['totalOwn']-$this->_tpl_vars['subTotalDis']); ?>
												$<?php echo ((is_array($_tmp=$this->_tpl_vars['sellerOwn'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>

																								
												</td>
											<?php $this->assign('oldInvoice', $this->_tpl_vars['paidAuctionDetails'][$this->_sections['counter']['index']]['invoice_id']); ?>		
											</tr>
											
										<?php endfor; endif; ?>
										
										<tr class="header_bgcolor" height="26">
												<td align="center" class="headertext" width="20%">&nbsp;&nbsp;
												Total
												</td >
												
												
												<td align="center" class="smalltext"></td>
												
												<td align="center" class="headertext"><?php if ($this->_tpl_vars['total_sold_price'] > 0): ?>$<?php echo $this->_tpl_vars['total_sold_price'];  else: ?>--<?php endif; ?></td>
												<td align="center" class="headertext" ><?php if ($this->_tpl_vars['TotalDis'] > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['TotalDis'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  else: ?>--<?php endif; ?></td>
												<td align="center" class="headertext"><?php if ($this->_tpl_vars['TotalCharge'] > 0): ?>$<?php echo ((is_array($_tmp=$this->_tpl_vars['TotalCharge'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2));  else: ?>--<?php endif; ?></td>
												<td align="center" class="headertext">
												<?php $this->assign('totsoldamnt', $this->_tpl_vars['total_sold_price']); ?>
												<?php $this->assign('tottotalOwn', $this->_tpl_vars['TotalCharge']+$this->_tpl_vars['totsoldamnt']); ?>
												<?php $this->assign('totsellerOwn', $this->_tpl_vars['tottotalOwn']-$this->_tpl_vars['TotalDis']); ?>
												$<?php echo ((is_array($_tmp=$this->_tpl_vars['totsellerOwn'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
<input type="hidden" name="seller_own" id="seller_own" value="<?php echo $this->_tpl_vars['totsellerOwn']; ?>
" /></td>
											</tr>
											
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" <?php if (@MULTIUSER_ADMIN == 1 && $_SESSION['superAdmin'] == 1): ?> colspan="3" <?php else: ?> colspan="3"<?php endif; ?>><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>-->
<!--											<td align="right" class="headertext" colspan="3"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>-->
<!--										</tr>-->
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											                        					<input type="button" value="Pay Now" class="button" onclick="javascript:window.open('<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=pay_now_seller&search=yet_to_pay&user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&start_date=<?php echo $this->_tpl_vars['start_date']; ?>
&end_date=<?php echo $this->_tpl_vars['end_date']; ?>
&auction_type=<?php echo $this->_tpl_vars['auction_type']; ?>
&auction_week=<?php echo $this->_tpl_vars['auction_week']; ?>
&auction_stills=<?php echo $this->_tpl_vars['auction_stills']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&toshow=<?php echo $this->_tpl_vars['toshow']; ?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
										<?php endif; ?>
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				<?php else: ?>
					<tr>
						<td align="center" class="err">There is no auction in database.</td>
					</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>		
</table>
<?php echo '
<script type="text/javascript">
var total_own=$("#seller_own").val();
if(total_own >0){
	var seller_own = "($"+total_own+")";
	$("#seller_own_amount").text(seller_own);
}

</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:31:12
  from '/var/www/html/admin_templates/admin_auction_reconciliation_report_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698776e05fa027_15910734',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd214995754e01f40e22abd9c4c627c6dc12d4ee6' => 
    array (
      0 => '/var/www/html/admin_templates/admin_auction_reconciliation_report_manager.tpl',
      1 => 1770484942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698776e05fa027_15910734 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),1=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.css" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/datepicker/jquery.datepick.js"><?php echo '</script'; ?>
>
<!--<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/formvalidation.js"><?php echo '</script'; ?>
>-->
<!--<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/jquery.validate.js"><?php echo '</script'; ?>
>-->

<?php echo '<script'; ?>
 type="text/javascript">
$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

//function reset_date(){
//	$('#start_date')[0].reset;
//
//}

function reset_date(ele) {
    $(ele).find(':input').each(function() {
        switch(this.type) {
        	case 'text':
        	case 'select-one':	
                $(this).val('');
                break;    
            
        }
    });
    document.getElementById('auction_week').style.display="none";
}
function test(){
if(document.getElementById('start_date').value!=''){
	if(document.getElementById('end_date').value!=''){
		return true;
	}else{
		alert("Please select a end date");
		document.getElementById('end_date').focus();
		return false;
}
}	
}
function check_auction_type(val){
    if(val=='weekly'){
        document.getElementById('auction_week').style.display="block";
    }else{
        document.getElementById('auction_week').style.display="none";
		$("#auction_week").val('');
    }
	if(val=='stills'){
        document.getElementById('auction_stills').style.display="block";
    }else{
        document.getElementById('auction_stills').style.display="none";
		$("#auction_stills").val('');
    }
}
<?php echo '</script'; ?>
>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                
				<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div></td>
					</tr>
				<?php }?>
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
                                                
                                                <option value="reconciliation" <?php if ($_smarty_tpl->tpl_vars['search']->value == "reconciliation") {?> selected="selected"<?php }?> >Reconciliation</option>

                                            </select>
                                        <td>
                                        <td>
                                            <select name="auction_type" class="look" id='search_id' onchange="check_auction_type(this.value);"  >
                                                <option value="" selected="selected" >All</option>
                                                <option value="fixed" <?php if ($_smarty_tpl->tpl_vars['auction_type']->value == "fixed") {?> selected="selected"<?php }?> >Fixed</option>
                                                <option value="weekly" <?php if ($_smarty_tpl->tpl_vars['auction_type']->value == "weekly") {?> selected="selected"<?php }?> >Weekly</option>
                                                <option value="stills" <?php if ($_smarty_tpl->tpl_vars['auction_type']->value == "stills") {?> selected="selected"<?php }?> >Stills/Photos</option>
                                            </select>
                                        </td>
                                        <td>
										  <select name="auction_week"  class="look" id="auction_week" <?php if ($_smarty_tpl->tpl_vars['auction_type']->value != 'weekly') {?>style="display: none;"<?php }?>>
                                            <option value="" selected="selected">All Auction</option>
											<?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionWeek']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['auctionWeek']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" <?php if ($_REQUEST['auction_week'] == $_smarty_tpl->tpl_vars['auctionWeek']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id']) {?> selected <?php }?> >MPE Weekly Auction&nbsp;( <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionWeek']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_end_date'],"%D");?>
)</option>
											<?php
}
}
?>
                                         </select>
										 <select name="auction_stills"  class="look" id="auction_stills" <?php if ($_smarty_tpl->tpl_vars['auction_type']->value != 'stills') {?>style="display: none;"<?php }?>>
                                            <option value="" selected="selected">All Stills Auction</option>
											<?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionWeekStills']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['auctionWeekStills']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id'];?>
" <?php if ($_REQUEST['auction_stills'] == $_smarty_tpl->tpl_vars['auctionWeekStills']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_id']) {?> selected <?php }?> >MPE Stills Auction&nbsp;( <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionWeekStills']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_week_end_date'],"%D");?>
)</option>
											<?php
}
}
?>
                                         </select>
     								    </td >
								<td class="bold_text" width="10%" align="right" style="padding:5px 0 0 0;"  valign="top" >Seller:&nbsp;</td>
								<td>
								<select name="user_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['userRow']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                                    	<?php if ($_smarty_tpl->tpl_vars['userRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id'] == $_smarty_tpl->tpl_vars['user_id']->value) {?>
                                                            <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                                        <?php }?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['userRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['userRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
 &nbsp;<?php echo $_smarty_tpl->tpl_vars['userRow']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</option>
                                                        <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                                    <?php
}
}
?>
                                            	</select><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['user_id_err']->value;?>
</span></td>
                                 <td width="16%" valign="top">&nbsp;</td>
								
							</tr>
							<tr>
								<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date&nbsp;
								</td>
								<td>
								<input type="text" name="start_date" id="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date_show']->value;?>
"  class="look required" /></td>
								<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date&nbsp;
								</td>
								<td>
								<input type="text" name="end_date" id="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date_show']->value;?>
"  class="look required" /></td>
								
								<td width="16%" valign="top"><input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" ></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
					<tr>
						<td align="center">
							<?php if ($_smarty_tpl->tpl_vars['nextParent']->value <> '') {?><div style="width: 96%; text-align: right;"><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_category_manager.php?parent_id=<?php echo $_smarty_tpl->tpl_vars['nextParent']->value;?>
&language_id=<?php echo $_smarty_tpl->tpl_vars['language_id']->value;?>
" class="new_link"><strong>&laquo; Back </strong></a></div><?php }?>
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
								<table align="center" width="60%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td  class="headertext" colspan="6">&nbsp;Sales Reconciliation Report</td >
											
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total poster:</td >
											<td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td class="bold_text" colspan="3">Total sold:</td >
											<td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_sold']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_amount_sold_by_mpe']->value > 0) {?>&nbsp;($<?php echo $_smarty_tpl->tpl_vars['total_amount_sold_by_mpe']->value;?>
) <?php }
if ($_smarty_tpl->tpl_vars['total_sold']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=sold&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>
										</tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Paid by Buyer:</td >
                                            <td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_paid_by_buyer']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_amount_paid_by_buyer']->value > 0) {?>&nbsp;($<?php echo $_smarty_tpl->tpl_vars['total_amount_paid_by_buyer']->value;?>
) <?php }
if ($_smarty_tpl->tpl_vars['total_paid_by_buyer']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid_by_buyer&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>


                                        </tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Unpaid by Buyer:</td >
                                            <td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_unpaid']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_amount_unpaid_by_buyer']->value > 0) {?>&nbsp;($<?php echo $_smarty_tpl->tpl_vars['total_amount_unpaid_by_buyer']->value;?>
)<?php }
if ($_smarty_tpl->tpl_vars['total_unpaid']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=unpaid&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>


                                        </tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Paid by MPE:</td >
											<td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_paid_by_admin']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_amount_paid_by_admin']->value > 0) {?>($<?php echo $_smarty_tpl->tpl_vars['total_amount_paid_by_admin']->value;?>
)&nbsp;<?php }
if ($_smarty_tpl->tpl_vars['total_paid_by_admin']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" title="details" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total to be Paid by MPE:</td >
										
											<td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_yet_paid']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_yet_paid']->value > 0) {?><span id="seller_own_amount"></span>&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" title="View & Print" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=yet_to_pay&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Unsold:</td >
											<td colspan="3">&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_unsold']->value;?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['total_unsold']->value > 0) {?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=admin_auction_seller_detail&search=unsold&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" /><?php }?></td>
										</tr>
																				<?php if ($_smarty_tpl->tpl_vars['total_yet_paid']->value > 0 && count($_smarty_tpl->tpl_vars['paidAuctionDetails']->value) > 0) {?>
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
										<?php $_smarty_tpl->_assignInScope('oldInvoice', 0);?>
										<?php
$__section_counter_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['paidAuctionDetails']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_3_total = $__section_counter_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_3_total !== 0) {
for ($__section_counter_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_3_iteration <= $__section_counter_3_total; $__section_counter_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
											<tr class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image'];?>
" ><br/>
												<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
(#<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
)
												</td >
												
												
												<td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '1') {?>Fixed Price Auction<?php } elseif ($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '2') {?>Weekly Auction<?php } elseif ($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '3') {?>Monthly Auction<?php } elseif ($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '5') {?>Stills/Photo Auction<?php }?></td>
												
												<td align="center" class="smalltext"><?php if ($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['soldamnt'] > 0) {?>$<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['soldamnt'];
} else { ?>--<?php }?></td>
																								<?php if ($_smarty_tpl->tpl_vars['oldInvoice']->value != $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id']) {?>
												<td align="center" class="smalltext">
												<?php $_smarty_tpl->_assignInScope('subTotalDis', 0);?>
												<?php
$__section_counterdiscount_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['discounts']) ? count($_loop) : max(0, (int) $_loop));
$__section_counterdiscount_4_total = $__section_counterdiscount_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counterdiscount'] = new Smarty_Variable(array());
if ($__section_counterdiscount_4_total !== 0) {
for ($__section_counterdiscount_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index'] = 0; $__section_counterdiscount_4_iteration <= $__section_counterdiscount_4_total; $__section_counterdiscount_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index']++){
?>
												<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index'] : null)]['description'];?>
:$<?php echo number_format($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index'] : null)]['amount'],2);?>
 <br/>
												<?php $_smarty_tpl->_assignInScope('subTotalDis', $_smarty_tpl->tpl_vars['subTotalDis']->value+$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index'] : null)]['amount']);?>
												<?php $_smarty_tpl->_assignInScope('TotalDis', $_smarty_tpl->tpl_vars['TotalDis']->value+$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['discounts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counterdiscount']->value['index'] : null)]['amount']);?>												
												<?php
}
}
?>
												
												</td>
												<td align="center" class="smalltext">
												<?php $_smarty_tpl->_assignInScope('subTotalCharge', 0);?>
												<?php
$__section_countercharge_5_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['additional_charges']) ? count($_loop) : max(0, (int) $_loop));
$__section_countercharge_5_total = $__section_countercharge_5_loop;
$_smarty_tpl->tpl_vars['__smarty_section_countercharge'] = new Smarty_Variable(array());
if ($__section_countercharge_5_total !== 0) {
for ($__section_countercharge_5_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index'] = 0; $__section_countercharge_5_iteration <= $__section_countercharge_5_total; $__section_countercharge_5_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index']++){
?>
												<?php echo $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index'] : null)]['description'];?>
:$<?php echo number_format($_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index'] : null)]['amount'],2);?>
 <br/>
												<?php $_smarty_tpl->_assignInScope('subTotalCharge', $_smarty_tpl->tpl_vars['subTotalCharge']->value+$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index'] : null)]['amount']);?>												
												<?php $_smarty_tpl->_assignInScope('TotalCharge', $_smarty_tpl->tpl_vars['TotalCharge']->value+$_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['additional_charges'][(isset($_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_countercharge']->value['index'] : null)]['amount']);?>
												<?php
}
}
?>
												
												</td>
												<?php } else { ?>
												 <?php $_smarty_tpl->_assignInScope('subTotalCharge', 0);?>	
												 <?php $_smarty_tpl->_assignInScope('subTotalDis', 0);?>
												     <td align="center" class="smalltext"> -- </td>
													 <td align="center" class="smalltext"> -- </td>
												<?php }?>
												
												<td align="center" class="smalltext">
												<?php $_smarty_tpl->_assignInScope('soldamnt', $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['soldamnt']);?>
												<?php $_smarty_tpl->_assignInScope('totalOwn', $_smarty_tpl->tpl_vars['subTotalCharge']->value+$_smarty_tpl->tpl_vars['soldamnt']->value);?>
												<?php $_smarty_tpl->_assignInScope('sellerOwn', $_smarty_tpl->tpl_vars['totalOwn']->value-$_smarty_tpl->tpl_vars['subTotalDis']->value);?>
												$<?php echo number_format($_smarty_tpl->tpl_vars['sellerOwn']->value,2);?>

																								
												</td>
											<?php $_smarty_tpl->_assignInScope('oldInvoice', $_smarty_tpl->tpl_vars['paidAuctionDetails']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id']);?>		
											</tr>
											
										<?php
}
}
?>
										
										<tr class="header_bgcolor" height="26">
												<td align="center" class="headertext" width="20%">&nbsp;&nbsp;
												Total
												</td >
												
												
												<td align="center" class="smalltext"></td>
												
												<td align="center" class="headertext"><?php if ($_smarty_tpl->tpl_vars['total_sold_price']->value > 0) {?>$<?php echo $_smarty_tpl->tpl_vars['total_sold_price']->value;
} else { ?>--<?php }?></td>
												<td align="center" class="headertext" ><?php if ($_smarty_tpl->tpl_vars['TotalDis']->value > 0) {?>$<?php echo number_format($_smarty_tpl->tpl_vars['TotalDis']->value,2);
} else { ?>--<?php }?></td>
												<td align="center" class="headertext"><?php if ($_smarty_tpl->tpl_vars['TotalCharge']->value > 0) {?>$<?php echo number_format($_smarty_tpl->tpl_vars['TotalCharge']->value,2);
} else { ?>--<?php }?></td>
												<td align="center" class="headertext">
												<?php $_smarty_tpl->_assignInScope('totsoldamnt', $_smarty_tpl->tpl_vars['total_sold_price']->value);?>
												<?php $_smarty_tpl->_assignInScope('tottotalOwn', $_smarty_tpl->tpl_vars['TotalCharge']->value+$_smarty_tpl->tpl_vars['totsoldamnt']->value);?>
												<?php $_smarty_tpl->_assignInScope('totsellerOwn', $_smarty_tpl->tpl_vars['tottotalOwn']->value-$_smarty_tpl->tpl_vars['TotalDis']->value);?>
												$<?php echo number_format($_smarty_tpl->tpl_vars['totsellerOwn']->value,2);?>
<input type="hidden" name="seller_own" id="seller_own" value="<?php echo $_smarty_tpl->tpl_vars['totsellerOwn']->value;?>
" /></td>
											</tr>
											
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" <?php if ((defined('MULTIUSER_ADMIN') ? constant('MULTIUSER_ADMIN') : null) == 1 && $_SESSION['superAdmin'] == 1) {?> colspan="3" <?php } else { ?> colspan="3"<?php }?>><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>-->
<!--											<td align="right" class="headertext" colspan="3"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>-->
<!--										</tr>-->
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											                        					<input type="button" value="Pay Now" class="button" onclick="javascript:window.open('<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=pay_now_seller&search=yet_to_pay&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&start_date=<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
&end_date=<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
&auction_type=<?php echo $_smarty_tpl->tpl_vars['auction_type']->value;?>
&auction_week=<?php echo $_smarty_tpl->tpl_vars['auction_week']->value;?>
&auction_stills=<?php echo $_smarty_tpl->tpl_vars['auction_stills']->value;?>
&offset=<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
&toshow=<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<td align="center" class="err">There is no auction in database.</td>
					</tr>
				<?php }?>
			</table>
		</td>
	</tr>		
</table>

<?php echo '<script'; ?>
 type="text/javascript">
var total_own=$("#seller_own").val();
if(total_own >0){
	var seller_own = "($"+total_own+")";
	$("#seller_own_amount").text(seller_own);
}

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

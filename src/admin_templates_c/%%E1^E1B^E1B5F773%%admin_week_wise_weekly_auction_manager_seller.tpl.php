<?php /* Smarty version 2.6.14, created on 2018-06-09 15:51:59
         compiled from admin_week_wise_weekly_auction_manager_seller.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'admin_week_wise_weekly_auction_manager_seller.tpl', 102, false),array('modifier', 'date_format', 'admin_week_wise_weekly_auction_manager_seller.tpl', 120, false),array('function', 'cycle', 'admin_week_wise_weekly_auction_manager_seller.tpl', 115, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
function combine_buyer_invoice(id){
    var allVals = [];
    var newVals=$("#"+id).val();
    var mySplitResult = newVals.split(",");
    for(i = 0; i < mySplitResult.length; i++){
        allVals.push(mySplitResult[i]);
        }
    var totalInv=allVals.length;
    if(totalInv >1){
        //alert(allVals);
        if(confirm("Are you sure to combine invoices for seller!")){

            $.get("admin_manage_auction_week.php", { mode:"combine_seller_invoice","auction_id[]": allVals},
                    function(data) {
                        if(data==\'1\'){
                            alert("Successfully invoices are combined");
                        }else{
                            alert("invoices are not combined");
                        }
                    });

        }
    }else{
        alert("Please select atleast two invoices to combine.");

    }
}
function mark_paid_seller_invoice(id){

    if(confirm("Are you sure to combine invoices for seller!")){

        $.get("admin_manage_auction_week.php", { mode:"mark_paid_seller_invoice","invoice_id": id},
                function(data) {
                    if(data==\'1\'){
                        alert("Successfully invoice(s) are marked as paid.");
                    }else{
                        alert("Invoices are not marked as paid.");
                    }
                });

    }
}
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td align="center"><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php" class="action_link"><strong>&lt; &lt; Back to Auction Week Manager</strong></a></td>
                </tr>


                    <tr  height="26">
                        <td class="headertext">&nbsp;</td>
                    </tr>


                    <tr  height="26">
                        <td class="headertext">&nbsp;</td>
                    </tr>
                    <tr  class="header_bgcolor" height="26">
                        <td class="headertext" colspan="5">&nbsp;Sold (<?php if ($this->_tpl_vars['total_sold'] > 0):  echo $this->_tpl_vars['total_sold'];  else: ?>0<?php endif; ?>)</td>
                    </tr>
                    <tr  height="26">
                        <td class="headertext">&nbsp;</td>
                    </tr>
                <?php if ($this->_tpl_vars['total_sold'] > 0): ?>
                <tr>
                    <td align="center">
                        <div id="messageBox" class="messageBox" style="display:none;"></div>
                        <form name="listFrom" id="listForm" action="" method="post">
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>

                                <tr class="header_bgcolor" height="26">
                                    <!--<td align="center" class="headertext" width="6%"></td>-->
                                    <td align="center" class="headertext" width="15%">Poster</td>
                                    <td align="center" class="headertext" width="15%">Seller Owned<br/>(Sold price -(MPE Charge + Merchant Fee)) </td>
                                    <td align="center" class="headertext" width="14%">Auction Week</td>
                                    <td align="center" class="headertext" width="14%">Sold Date</td>
                                    <td align="center" class="headertext" width="14%">Status</td>
                                    <td align="center" class="headertext" width="10%">Action</td>
                                </tr>
                                    <?php $this->assign('user_id', ""); ?>

                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionRows_sold']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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

                                    <tr height="50">
                                        <?php if ($this->_tpl_vars['user_id'] != $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['user_id']): ?>

                                            <td style=" background:url(<?php echo @CLOUD_STATIC_ADMIN; ?>
admin_gradient.jpg)"><b>Seller:</b> <?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['firstname']; ?>
&nbsp;<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
                                            <td style=" background:url(<?php echo @CLOUD_STATIC_ADMIN; ?>
admin_gradient.jpg)"><b>Total Poster:</b> <?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['tot_poster']; ?>
</td>
                                            <td style=" background:url(<?php echo @CLOUD_STATIC_ADMIN; ?>
admin_gradient.jpg)" colspan="2"><b>Price:</b> $<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['tot_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                            <td style=" background:url(<?php echo @CLOUD_STATIC_ADMIN; ?>
admin_gradient.jpg)" colspan="2"><b>More Action:</b>&nbsp;<input type="hidden" name="auction_id[]" id="auction_id_<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['user_id']; ?>
" value="<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['tot_auction']; ?>
">
                                                                                        <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_combined'] == '0'): ?>
                                                <a href="javascript:void(0);" onclick="combine_buyer_invoice('auction_id_<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['user_id']; ?>
')">combine</a>
                                             <?php endif; ?>
                                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_approved'] == '1' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_paid'] == '0'): ?>
                                                <a href="javascript:void(0);" onclick="mark_paid_seller_invoice('<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['invoice_id']; ?>
')">Mark as paid</a>
                                            <?php endif; ?>
                                            </td>
                                        <?php endif; ?>

                                    </tr>
                                    <tr id="tr_<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['image_path']; ?>
" height="78" width="100" /><br /><?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                                        <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_week_title']; ?>
</td>
                                        <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['invoice_generated_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
</td>
                                        <td>&nbsp;
                                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_combined'] == '1'): ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
combined.png" alt="Combined" title="Combined">
                                                <?php else: ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
not_combined.png" alt="Combined" title="Not Combined">
                                            <?php endif; ?>
                                            &nbsp;
                                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_approved'] == '1'): ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
approved.png" alt="Combined" title="Approved">
                                                <?php else: ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
not_approved.png" alt="Combined" title="Not Approved">
                                            <?php endif; ?>
                                            &nbsp;
                                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_paid'] == '1'): ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
paid.png" alt="Combined" title="Paid on <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['paid_on'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
">
                                            <?php else: ?>
                                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
unpaid.png" alt="Combined" title="Not Paid">
                                            <?php endif; ?>
                                        </td>
                                        <td align="center" class="bold_text">
                                            &nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice_seller&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>

                                        </td>
                                    </tr>
                                        <?php $this->assign('user_id', $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['user_id']); ?>
                                    <?php endfor; endif; ?>

                                <tr class="header_bgcolor" height="26">
                                    <!--<td align="left" class="smalltext">&nbsp;</td>-->
                                    <td align="left" colspan="2" class="headertext"><?php echo $this->_tpl_vars['pageCounterTXT']; ?>
</td>
                                    <td align="right" <?php if ($_REQUEST['mode'] == 'fixed_price'): ?>colspan="2"<?php else: ?>colspan="5"<?php endif; ?> class="headertext"><?php echo $this->_tpl_vars['displayCounterTXT']; ?>
</td>
                                </tr>
                                </tbody>
                            </table>

                        </form>
                    </td>
                </tr>
                    <?php else: ?>
                <tr>
                    <td align="center" class="err">There is no sold for this weekly auction.</td>
                </tr>
                <?php endif; ?>
                <tr  height="26">
                    <td class="headertext">&nbsp;</td>
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
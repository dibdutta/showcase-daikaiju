<?php /* Smarty version 2.6.14, created on 2021-01-21 02:47:42
         compiled from admin_week_wise_weekly_auction_manager.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'admin_week_wise_weekly_auction_manager.tpl', 89, false),array('modifier', 'number_format', 'admin_week_wise_weekly_auction_manager.tpl', 92, false),array('modifier', 'date_format', 'admin_week_wise_weekly_auction_manager.tpl', 292, false),)), $this); ?>
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
            if(confirm("Are you sure to combine invoices for buyer!")){

                $.get("admin_manage_auction_week.php", { mode:"combine_buyer_invoice","auction_id[]": allVals},
                        function(data) {
                            if(data==\'1\'){
                                alert("Successfully invoices are combined");
								window.location.reload();
                            }else{
                                alert("invoices are not combined");
                            }
                        });

            }
        }else{
            alert("Please select atleast two invoices to combine.");

        }
    }
    function mark_shipped_buyer_invoice(id)
    {
        if(confirm("Are you sure to mark invoices as shipped!")){

            $.get("admin_manage_auction_week.php", { mode:"mark_shipped_buyer_invoice","invoice_id": id},
                    function(data) {
                        if(data==\'1\'){
                            alert("Successfully invoice(s) are marked as shipped.");
                        }else{
                            alert("Invoices are not marked as shipped.");
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
    <td align="center"><?php if ($this->_tpl_vars['is_stills'] == 0): ?><a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php?mode=create_new_weekly_auction&week_id=<?php echo $this->_tpl_vars['week_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link"><?php else: ?>
	<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=create_stills_auction&week_id=<?php echo $this->_tpl_vars['week_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="action_link">
	<?php endif; ?><strong>Add Consignment Item</strong></a>&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_manage_auction_week.php" class="action_link"><strong>&lt; &lt; Back to Auction Week Manager</strong></a></td>
</tr>
<?php if ($this->_tpl_vars['is_stills'] == 0): ?>
<tr  class="header_bgcolor" height="26" >
    <td class="headertext" colspan="5" >&nbsp;All Upcoming (<?php if ($this->_tpl_vars['total_pending'] > 0):  echo $this->_tpl_vars['total_pending'];  else: ?> 0 <?php endif; ?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>

<?php if ($this->_tpl_vars['total_pending'] > 0): ?>
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Starting Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    <?php if ($this->_tpl_vars['search'] == '' || $this->_tpl_vars['search'] == 'pending' || $this->_tpl_vars['search'] == 'waiting_receive'): ?><td align="center" class="headertext" width="8%">Status</td><?php endif; ?>
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionRows_pending']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <tr id="tr_<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['image_path']; ?>
" height="78" width="100" /><br /><?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                        <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionWeekTitle']; ?>
</td>
                        <?php if ($this->_tpl_vars['search'] == '' || $this->_tpl_vars['search'] == 'pending' || $this->_tpl_vars['search'] == 'waiting_receive'): ?>
                            <td id="td_<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
" align="center" class="smalltext">
                                <?php if ($this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_is_approved'] == 0 && $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['is_approved_for_monthly_auction'] == 0): ?>
                                    <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
, 1, '<?php echo $_REQUEST['search']; ?>
', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
, 2, '<?php echo $_REQUEST['search']; ?>
', 'monthly');" title="Disapprove" class="changeStatus" />
                                    <?php elseif ($this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_is_approved'] == 1): ?>

                                    Approved
                                    <?php elseif ($this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_is_approved'] == 2): ?>
                                    Disapproved
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td align="center" class="bold_text">

                            <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

							
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            
                            <?php if ($this->_tpl_vars['search'] == 'sold'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
">Reopen Auction</a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_pending'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endfor; endif; ?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php else: ?>
<tr>
    <td align="center" class="err">There is no  Pending auctions for this weekly auction.</td>
</tr>
<?php endif; ?>
<?php endif; ?>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Active Selling (<?php if ($this->_tpl_vars['total_selling'] > 0):  echo $this->_tpl_vars['total_selling'];  else: ?>0<?php endif; ?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<?php if ($this->_tpl_vars['total_selling'] > 0): ?>
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Starting Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    <?php if ($this->_tpl_vars['search'] == '' || $this->_tpl_vars['search'] == 'pending' || $this->_tpl_vars['search'] == 'waiting_receive'): ?><td align="center" class="headertext" width="8%">Status</td><?php endif; ?>
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionRows_selling']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <tr id="tr_<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['image_path']; ?>
" height="78" width="100" /><br /><?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                        <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionWeekTitle']; ?>
</td>
                        <?php if ($this->_tpl_vars['search'] == '' || $this->_tpl_vars['search'] == 'pending' || $this->_tpl_vars['search'] == 'waiting_receive'): ?>
                            <td id="td_<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
" align="center" class="smalltext">
                                <?php if ($this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_is_approved'] == 0 && $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['is_approved_for_monthly_auction'] == 0): ?>
                                    <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
, 1, '<?php echo $_REQUEST['search']; ?>
', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
, 2, '<?php echo $_REQUEST['search']; ?>
', 'monthly');" title="Disapprove" class="changeStatus" />
                                    <?php elseif ($this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_is_approved'] == 1): ?>

                                    Approved
                                    <?php elseif ($this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_is_approved'] == 2): ?>
                                    Disapproved
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td align="center" class="bold_text">

                            <?php if ($this->_tpl_vars['is_stills'] == 0): ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php else: ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php endif; ?>
							
							<img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($this->_tpl_vars['search'] == 'sold'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
">Reopen Auction</a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_selling'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endfor; endif; ?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php else: ?>
<tr>
    <td align="center" class="err">There is no active selling for this weekly auction.</td>
</tr>
<?php endif; ?>
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
                    <td align="center" class="headertext" width="15%">Sold Price</td>
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
admin_gradient.jpg)"><b>Buyer:</b> <?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['firstname']; ?>
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
                                <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_paid'] == '1' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_shipped'] == '0'): ?>
                                    <a href="javascript:void(0);" onclick="mark_shipped_buyer_invoice('<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['invoice_id']; ?>
')">Mark as shipped</a>
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
                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionWeekTitle']; ?>
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
                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_approved'] == '1' || $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_paid'] == '1'): ?>
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
								<?php if ($this->_tpl_vars['is_stills'] == 0): ?>
                            		<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
								<?php else: ?>
									<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_stills&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
								<?php endif; ?><img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg"></a>
                            <?php endif; ?>
                            &nbsp;
                            <?php if ($this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['is_shipped'] == '1'): ?>
                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
shipped.png" alt="Combined" title="Shipped on <?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['shipped_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
">
                                <?php else: ?>
                                <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
not_shipped.png" alt="Combined" title="Not Shipped">
                            <?php endif; ?>
                        </td>
                        <td align="center" class="bold_text">

                             <?php if ($this->_tpl_vars['is_stills'] == 0): ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php else: ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php endif; ?><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($this->_tpl_vars['search'] == 'sold'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
">Reopen Auction</a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_sold'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
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
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Unsold (<?php if ($this->_tpl_vars['total_unsold'] > 0):  echo $this->_tpl_vars['total_unsold'];  else: ?>0<?php endif; ?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<?php if ($this->_tpl_vars['total_unsold'] > 0): ?>
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Start Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    <td align="center" class="headertext" width="14%">End Date</td>

                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>


                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['auctionRows_unsold']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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

                    <tr id="tr_<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
" class="<?php echo smarty_function_cycle(array('values' => "odd_tr,even_tr"), $this);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $this->_tpl_vars['posterRows'][$this->_sections['counter']['index']]['poster_id']; ?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['image_path']; ?>
" height="78" width="100" /><br /><?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['poster_title']; ?>
<br /><b>SKU: </b><?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['poster_sku']; ?>
</td>
                        <td align="center" class="smalltext">$<?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_asked_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>
                        <td align="center" class="smalltext"><?php echo $this->_tpl_vars['auctionWeekTitle']; ?>
</td>
                        <td align="center" class="smalltext"><?php echo ((is_array($_tmp=$this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_actual_end_datetime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m/%d/%Y") : smarty_modifier_date_format($_tmp, "%m/%d/%Y")); ?>
</td>
                        <td align="center" class="bold_text">

                           <?php if ($this->_tpl_vars['is_stills'] == 0): ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php else: ?>
								<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php endif; ?>
						   <img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($this->_tpl_vars['search'] == 'sold'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
">Reopen Auction</a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unpaid' && $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id'] == '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php elseif ($this->_tpl_vars['search'] == 'unsold' && $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id'] != '0'): ?>
                                <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['reopen_auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['is_stills'] == 0): ?>
                            <a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php else: ?>
							<a href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/admin_auction_manager.php?mode=reopen_stills&auction_id=<?php echo $this->_tpl_vars['auctionRows_unsold'][$this->_sections['counter']['index']]['auction_id']; ?>
&encoded_string=<?php echo $this->_tpl_vars['encoded_string']; ?>
" class="view_link">
							<?php endif; ?><img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="<?php echo @CLOUD_STATIC_ADMIN; ?>
reopen_auction.jpg"></a>
                        </td>
                    </tr>

                    <?php endfor; endif; ?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php else: ?>
<tr>
    <td align="center" class="err">There is no unsold poster for this weekly auction.</td>
</tr>
<?php endif; ?>
</table>
</td>
</tr>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
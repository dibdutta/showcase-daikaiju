<?php
/* Smarty version 3.1.47, created on 2026-02-03 13:09:50
  from '/var/www/html/admin_templates/admin_week_wise_weekly_auction_manager.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698239ee2bba14_96203733',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '031e3e783d7fce2b8904cbe8fc107ec61241c3a8' => 
    array (
      0 => '/var/www/html/admin_templates/admin_week_wise_weekly_auction_manager.tpl',
      1 => 1611163634,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698239ee2bba14_96203733 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),1=>array('file'=>'/var/www/html/libs/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 type="text/javascript">
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
                            if(data=='1'){
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
                        if(data=='1'){
                            alert("Successfully invoice(s) are marked as shipped.");
                        }else{
                            alert("Invoices are not marked as shipped.");
                        }
                    });

        }

    }
<?php echo '</script'; ?>
>

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
    <td align="center"><?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?><a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php?mode=create_new_weekly_auction&week_id=<?php echo $_smarty_tpl->tpl_vars['week_id']->value;?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link"><?php } else { ?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=create_stills_auction&week_id=<?php echo $_smarty_tpl->tpl_vars['week_id']->value;?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="action_link">
	<?php }?><strong>Add Consignment Item</strong></a>&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_manage_auction_week.php" class="action_link"><strong>&lt; &lt; Back to Auction Week Manager</strong></a></td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
<tr  class="header_bgcolor" height="26" >
    <td class="headertext" colspan="5" >&nbsp;All Upcoming (<?php if ($_smarty_tpl->tpl_vars['total_pending']->value > 0) {
echo $_smarty_tpl->tpl_vars['total_pending']->value;
} else { ?> 0 <?php }?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>

<?php if ($_smarty_tpl->tpl_vars['total_pending']->value > 0) {?>
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
                    <?php if ($_smarty_tpl->tpl_vars['search']->value == '' || $_smarty_tpl->tpl_vars['search']->value == 'pending' || $_smarty_tpl->tpl_vars['search']->value == 'waiting_receive') {?><td align="center" class="headertext" width="8%">Status</td><?php }?>
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionRows_pending']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" height="78" width="100" /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
                        <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'],2);?>
</td>
                        <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionWeekTitle']->value;?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['search']->value == '' || $_smarty_tpl->tpl_vars['search']->value == 'pending' || $_smarty_tpl->tpl_vars['search']->value == 'waiting_receive') {?>
                            <td id="td_<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" align="center" class="smalltext">
                                <?php if ($_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 0 && $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_approved_for_monthly_auction'] == 0) {?>
                                    <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 1, '<?php echo $_REQUEST['search'];?>
', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 2, '<?php echo $_REQUEST['search'];?>
', 'monthly');" title="Disapprove" class="changeStatus" />
                                    <?php } elseif ($_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 1) {?>

                                    Approved
                                    <?php } elseif ($_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 2) {?>
                                    Disapproved
                                <?php }?>
                            </td>
                        <?php }?>
                        <td align="center" class="bold_text">

                            <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

							
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
">Reopen Auction</a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_pending']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php
}
}
?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php } else { ?>
<tr>
    <td align="center" class="err">There is no  Pending auctions for this weekly auction.</td>
</tr>
<?php }
}?>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Active Selling (<?php if ($_smarty_tpl->tpl_vars['total_selling']->value > 0) {
echo $_smarty_tpl->tpl_vars['total_selling']->value;
} else { ?>0<?php }?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['total_selling']->value > 0) {?>
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
                    <?php if ($_smarty_tpl->tpl_vars['search']->value == '' || $_smarty_tpl->tpl_vars['search']->value == 'pending' || $_smarty_tpl->tpl_vars['search']->value == 'waiting_receive') {?><td align="center" class="headertext" width="8%">Status</td><?php }?>
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    <?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionRows_selling']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" height="78" width="100" /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
                        <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'],2);?>
</td>
                        <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionWeekTitle']->value;?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['search']->value == '' || $_smarty_tpl->tpl_vars['search']->value == 'pending' || $_smarty_tpl->tpl_vars['search']->value == 'waiting_receive') {?>
                            <td id="td_<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" align="center" class="smalltext">
                                <?php if ($_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 0 && $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_approved_for_monthly_auction'] == 0) {?>
                                    <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 1, '<?php echo $_REQUEST['search'];?>
', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction(<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, 2, '<?php echo $_REQUEST['search'];?>
', 'monthly');" title="Disapprove" class="changeStatus" />
                                    <?php } elseif ($_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 1) {?>

                                    Approved
                                    <?php } elseif ($_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_is_approved'] == 2) {?>
                                    Disapproved
                                <?php }?>
                            </td>
                        <?php }?>
                        <td align="center" class="bold_text">

                            <?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php } else { ?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php }?>
							
							<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
">Reopen Auction</a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_selling']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                        </td>
                    </tr>
                    <?php
}
}
?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php } else { ?>
<tr>
    <td align="center" class="err">There is no active selling for this weekly auction.</td>
</tr>
<?php }?>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Sold (<?php if ($_smarty_tpl->tpl_vars['total_sold']->value > 0) {
echo $_smarty_tpl->tpl_vars['total_sold']->value;
} else { ?>0<?php }?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['total_sold']->value > 0) {?>
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
                    <?php $_smarty_tpl->_assignInScope('user_id', '');?>

                    <?php
$__section_counter_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionRows_sold']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_2_total = $__section_counter_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_2_total !== 0) {
for ($__section_counter_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_2_iteration <= $__section_counter_2_total; $__section_counter_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>

                    <tr height="50">
                        <?php if ($_smarty_tpl->tpl_vars['user_id']->value != $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id']) {?>

                            <td style=" background:url(<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
admin_gradient.jpg)"><b>Buyer:</b> <?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['firstname'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['lastname'];?>
</td>
                            <td style=" background:url(<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
admin_gradient.jpg)"><b>Total Poster:</b> <?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['tot_poster'];?>
</td>
                            <td style=" background:url(<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
admin_gradient.jpg)" colspan="2"><b>Price:</b> $<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['tot_amount'],2);?>
</td>
                            <td style=" background:url(<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
admin_gradient.jpg)" colspan="2"><b>More Action:</b>&nbsp;<input type="hidden" name="auction_id[]" id="auction_id_<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['tot_auction'];?>
">
                                                            <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_combined'] == '0') {?>
                                    <a href="javascript:void(0);" onclick="combine_buyer_invoice('auction_id_<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id'];?>
')">combine</a>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_paid'] == '1' && $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_shipped'] == '0') {?>
                                    <a href="javascript:void(0);" onclick="mark_shipped_buyer_invoice('<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_id'];?>
')">Mark as shipped</a>
                                <?php }?>
                            </td>
                        <?php }?>

                    </tr>
                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" height="78" width="100" /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
                        <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['amount'],2);?>
</td>
                        <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionWeekTitle']->value;?>
</td>
                        <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['invoice_generated_on'],"%m/%d/%Y");?>
</td>
                        <td>&nbsp;
                            <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_combined'] == '1') {?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
combined.png" alt="Combined" title="Combined">
                                <?php } else { ?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_combined.png" alt="Combined" title="Not Combined">
                            <?php }?>
                            &nbsp;
                            <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_approved'] == '1' || $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_paid'] == '1') {?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
approved.png" alt="Combined" title="Approved">
                                <?php } else { ?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_approved.png" alt="Combined" title="Not Approved">
                            <?php }?>
                            &nbsp;
                            <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_paid'] == '1') {?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
paid.png" alt="Combined" title="Paid on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['paid_on'],"%m/%d/%Y");?>
">
                                <?php } else { ?>
                                	<img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
unpaid.png" alt="Combined" title="Not Paid">
								<?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
                            		<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
								<?php } else { ?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_stills&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
								<?php }?><img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg"></a>
                            <?php }?>
                            &nbsp;
                            <?php if ($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['is_shipped'] == '1') {?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
shipped.png" alt="Combined" title="Shipped on <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['shipped_date'],"%m/%d/%Y");?>
">
                                <?php } else { ?>
                                <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
not_shipped.png" alt="Combined" title="Not Shipped">
                            <?php }?>
                        </td>
                        <td align="center" class="bold_text">

                             <?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php } else { ?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php }?><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
">Reopen Auction</a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                        </td>
                    </tr>
                        <?php $_smarty_tpl->_assignInScope('user_id', $_smarty_tpl->tpl_vars['auctionRows_sold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['user_id']);?>
                    <?php
}
}
?>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="left" class="smalltext">&nbsp;</td>-->
                    <td align="left" colspan="2" class="headertext"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</td>
                    <td align="right" <?php if ($_REQUEST['mode'] == 'fixed_price') {?>colspan="2"<?php } else { ?>colspan="5"<?php }?> class="headertext"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</td>
                </tr>
                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php } else { ?>
<tr>
    <td align="center" class="err">There is no sold for this weekly auction.</td>
</tr>
<?php }?>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Unsold (<?php if ($_smarty_tpl->tpl_vars['total_unsold']->value > 0) {
echo $_smarty_tpl->tpl_vars['total_unsold']->value;
} else { ?>0<?php }?>)</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['total_unsold']->value > 0) {?>
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


                    <?php
$__section_counter_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionRows_unsold']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_3_total = $__section_counter_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_3_total !== 0) {
for ($__section_counter_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_3_iteration <= $__section_counter_3_total; $__section_counter_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>

                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="<?php echo smarty_function_cycle(array('values'=>"odd_tr,even_tr"),$_smarty_tpl);?>
">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['posterRows']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_id'];?>
" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
" height="78" width="100" /><br /><?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
<br /><b>SKU: </b><?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_sku'];?>
</td>
                        <td align="center" class="smalltext">$<?php echo number_format($_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'],2);?>
</td>
                        <td align="center" class="smalltext"><?php echo $_smarty_tpl->tpl_vars['auctionWeekTitle']->value;?>
</td>
                        <td align="center" class="smalltext"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_actual_end_datetime'],"%m/%d/%Y");?>
</td>
                        <td align="center" class="bold_text">

                           <?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php } else { ?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=edit_stills_auction&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php }?>
						   <img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'sold') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=manage_invoice&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
">Reopen Auction</a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unpaid' && $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] == '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_monthly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                <?php } elseif ($_smarty_tpl->tpl_vars['search']->value == 'unsold' && $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'] != '0') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=view_fixed&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['reopen_auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['is_stills']->value == 0) {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_weekly&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php } else { ?>
							<a href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/admin_auction_manager.php?mode=reopen_stills&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionRows_unsold']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&encoded_string=<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" class="view_link">
							<?php }?><img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
reopen_auction.jpg"></a>
                        </td>
                    </tr>

                    <?php
}
}
?>
                                </tbody>
            </table>

        </form>
    </td>
</tr>
    <?php } else { ?>
<tr>
    <td align="center" class="err">There is no unsold poster for this weekly auction.</td>
</tr>
<?php }?>
</table>
</td>
</tr>
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

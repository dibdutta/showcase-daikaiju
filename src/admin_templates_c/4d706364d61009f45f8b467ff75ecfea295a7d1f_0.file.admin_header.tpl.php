<?php
/* Smarty version 3.1.47, created on 2026-02-03 07:36:28
  from '/var/www/html/admin_templates/admin_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6981ebcc131c69_13247674',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d706364d61009f45f8b467ff75ecfea295a7d1f' => 
    array (
      0 => '/var/www/html/admin_templates/admin_header.tpl',
      1 => 1669735080,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6981ebcc131c69_13247674 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="history" content="">
		<meta name="author" content="Verdana Core, phpdoc.net Inc.">
		<title><?php echo (defined('ADMIN_PAGE_TITLE') ? constant('ADMIN_PAGE_TITLE') : null);?>
</title>
		<link href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/adminStyle.css" rel="stylesheet">
        <link href="<?php echo $_smarty_tpl->tpl_vars['adminActualPath']->value;?>
/dropdown_menu.css" rel="stylesheet">
        <?php echo '<script'; ?>
 src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo (defined('PAGE_LINK') ? constant('PAGE_LINK') : null);?>
/javascript/dropdown_menu.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo (defined('PAGE_LINK') ? constant('PAGE_LINK') : null);?>
/javascript/adminCommon.js.php"><?php echo '</script'; ?>
>
	</head>
	<body>
		<table align="center" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<!-- Top Part Start -->
			<tr>
				<td valign="top" height="80">
					<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
						<tr>
						   <td height="72" class="header_bg">
						   		<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
									<tr>
										<td width="40%">&nbsp;</td>
										<td width="60%" valign="bottom" align="right">
											<table width="100%" border="0" cellspacing="0" cellpadding="3">
												<tr>
													<td align="right" class="headertext" height="34"><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_main.php" class="top_link">Home</a><?php if((MULTIUSER_ADMIN == true && in_array('admin_config_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ ?>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['adminTracker']->value == 1) {?>||&nbsp;&nbsp;<a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_config_manager.php" class="top_link">Settings</a><?php }
} ?>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_login.php?mode=adminLogout" class="top_link">Logout</a>&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text"><?php if ($_SESSION['administratorNames'] != '') {?>Signed in as : <strong><?php echo mb_strtoupper($_SESSION['administratorNames'], 'UTF-8');?>
 &nbsp;<?php echo $_smarty_tpl->tpl_vars['adminCurrentDate']->value;?>
</strong><?php }?>&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text"><strong>Last logged in on <?php echo $_smarty_tpl->tpl_vars['adminLastLoginDate']->value;?>
</strong>&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
						   </td>
						</tr>
						<tr>
							<td align="left" valign="top" height="8" class="horizontal_line"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
blank.gif" border="0" alt="" width="1" height="1"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" height="28" class="top_menu_portion">
                    <ul id="jsddm">
					<?php if ($_smarty_tpl->tpl_vars['adminTracker']->value == 1) {?>
                        <li><a href="#">MY ACCOUNT</a>
                            <ul>
                                <?php if(MULTIUSER_ADMIN == true && $_SESSION['superAdmin'] == true){?>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_super_manager.php">Admin Manager Section</a></li>
                                <!--<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_super_manager.php?mode=create_user">Add New Administrator</a></li>-->
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
                                <?php }elseif((MULTIUSER_ADMIN == true && in_array('admin_account_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){?>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=email_template">Email Template Auctions</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=email_template_item_specific">Email Template Item Specefic</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=home_template">Home Template</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_account_manager.php?mode=calender_template">Auction Calender</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/mpe/admin/admin_account_manager.php?mode=blacklist">Blacklist</a></li>
								<li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/mpe/admin/admin_account_manager.php?mode=shipping">Year wise Shipping Collection</a></li>
                                <?php }?>
                            </ul>
                        </li>
                        <li><a href="#">CMS</a>
                            <ul>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_content_manager.php?type=fixed">Content Manager</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['smart']->value['const']['DOMAIN_PATH'];?>
/admin/admin_meta_manager.php?type=fixed">Meta Manager</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_user_manager.php">USER MANAGER</a></li>
						<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_size_weight_cost.php">SIZE WEIGHT COST MASTER</a></li>
                        <li><a href="#">CATEGORY MANAGER</a>
                            <ul>
                            	<?php
$__section_counter_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['commonCatTypes']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_3_total = $__section_counter_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_3_total !== 0) {
for ($__section_counter_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_3_iteration <= $__section_counter_3_total; $__section_counter_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_category_manager.php?cat_type_id=<?php echo $_smarty_tpl->tpl_vars['commonCatTypes']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_type_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['commonCatTypes']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['cat_type'];?>
</a></li>
                                <?php
}
}
?>
                            </ul>
                        </li>
                        <li><a href="#">MESSAGE</a>
                         	<ul>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_messages.php?mode=inbox">Inbox (<span class="err"><?php echo $_smarty_tpl->tpl_vars['countMsg']->value;?>
</span>)</a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_messages.php?mode=sent_messages">Sent Messages</a></li>
                            </ul>
                        </li>
                        <li><a href="#">MANAGE AUCTION</a>
                        	<ul style="z-index: 100">
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=fixed">Fixed Price</a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=weekly">Weekly Auctions</a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=monthly">Monthly Auction</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=stills">Stills/Photos</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=stills_auction">Stills/Photos(Auction)</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_alternate_poster.php?mode=alternate_posters">Alternative Posters</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=phone_order">Phone Order Invoice</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=bulkupload">Bulk Upload</a></li>
								<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_auction_manager.php?mode=bulkupload_pending">Bulk Upload Pending</a></li>
						  </ul>
                        </li>
                        <li><a href="#">MANAGE EVENT</a>
                        	<ul>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_event_manager.php?mode=show_all_event">Show All Event</a></li>
                                
                            </ul>
                        </li>
						<?php }?>
                        <li><a href="#">MANAGE AUCTION WEEKS</a>
                        	<ul>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_manage_auction_week.php?mode=show_all_auction_week">Show All Auction Weeks</a></li>
                                
                            </ul>
                        </li>
						<?php if ($_smarty_tpl->tpl_vars['adminTracker']->value == 1) {?>
                        <li><a href="#">REPORT MANAGER</a>
                        	<ul>
                                <!--<li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=user_report">User Report</a></li>-->
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=auction_report&search=reconciliation">Reconciliation</a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_report_manager.php?mode=auction_payment_report">Seller Payment Report</a></li>
                            </ul>
                        </li>
                         <li><a href="#">SET FIRST POSTER IN HOME PAGE</a>
                        	<ul>                        	
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_set_first_image_for_home.php?mode=fixed&search=selling">Featured Items for Sale </a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_set_first_image_for_home.php?mode=auction&search=selling">Featured Auction Items </a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_set_first_image_for_home.php?mode=fixed&search=sold">Recent Sales Results </a></li>
                                <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_set_first_image_for_home.php?search=upcoming">Featured Upcoming Items</a></li>
                            </ul>
                        </li>
						<li><a href="#">Access Customer Information</a>
							<ul>
							  <li><a href="<?php echo (defined('ADMIN_PAGE_LINK') ? constant('ADMIN_PAGE_LINK') : null);?>
/admin_access_cust_info.php?mode=seller">Customer Master Invoice</a></li>							  
							</ul>							
						</li>
						<?php }?>
                    </ul>
				</td>
			</tr>
			<!-- Top Part End -->
			<!-- Middle Part Start -->
			<tr>
				<td valign="top">
					<table width="98%" border="0" cellspacing="0" cellpadding="5" align="center">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="bottom" align="left" height="50" class="page_heading_small"><img src="<?php echo (defined('CLOUD_STATIC_ADMIN') ? constant('CLOUD_STATIC_ADMIN') : null);?>
icon_control_panel.gif" alt="" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo (defined('PAGE_HEADER_TEXT') ? constant('PAGE_HEADER_TEXT') : null);?>
</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="top" align="left" class="box">
								<!-- content portion start --><?php }
}

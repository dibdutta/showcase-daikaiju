<?php /* Smarty version 2.6.14, created on 2023-04-15 23:23:10
         compiled from admin_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'admin_header.tpl', 32, false),)), $this); ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="history" content="">
		<meta name="author" content="Verdana Core, phpdoc.net Inc.">
		<title><?php echo @ADMIN_PAGE_TITLE; ?>
</title>
		<link href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/adminStyle.css" rel="stylesheet">
        <link href="<?php echo $this->_tpl_vars['adminActualPath']; ?>
/dropdown_menu.css" rel="stylesheet">
        <script src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo @PAGE_LINK; ?>
/javascript/dropdown_menu.js"></script>
		<script type="text/javascript" src="<?php echo @PAGE_LINK; ?>
/javascript/adminCommon.js.php"></script>
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
													<td align="right" class="headertext" height="34"><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_main.php" class="top_link">Home</a><?php if((MULTIUSER_ADMIN == true && in_array('admin_config_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){  ?>&nbsp;&nbsp;<?php if ($this->_tpl_vars['adminTracker'] == 1): ?>||&nbsp;&nbsp;<a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_config_manager.php" class="top_link">Settings</a><?php endif;   }  ?>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_login.php?mode=adminLogout" class="top_link">Logout</a>&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text"><?php if ($_SESSION['administratorNames'] != ""): ?>Signed in as : <strong><?php echo ((is_array($_tmp=$_SESSION['administratorNames'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
 &nbsp;<?php echo $this->_tpl_vars['adminCurrentDate']; ?>
</strong><?php endif; ?>&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text"><strong>Last logged in on <?php echo $this->_tpl_vars['adminLastLoginDate']; ?>
</strong>&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
						   </td>
						</tr>
						<tr>
							<td align="left" valign="top" height="8" class="horizontal_line"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
blank.gif" border="0" alt="" width="1" height="1"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" height="28" class="top_menu_portion">
                    <ul id="jsddm">
					<?php if ($this->_tpl_vars['adminTracker'] == 1): ?>
                        <li><a href="#">MY ACCOUNT</a>
                            <ul>
                                <?php if(MULTIUSER_ADMIN == true && $_SESSION['superAdmin'] == true){ ?>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_super_manager.php">Admin Manager Section</a></li>
                                <!--<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_super_manager.php?mode=create_user">Add New Administrator</a></li>-->
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
                                <?php }elseif((MULTIUSER_ADMIN == true && in_array('admin_account_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ ?>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=email_template">Email Template Auctions</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=email_template_item_specific">Email Template Item Specefic</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=home_template">Home Template</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_account_manager.php?mode=calender_template">Auction Calender</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/mpe/admin/admin_account_manager.php?mode=blacklist">Blacklist</a></li>
								<li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/mpe/admin/admin_account_manager.php?mode=shipping">Year wise Shipping Collection</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="#">CMS</a>
                            <ul>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_content_manager.php?type=fixed">Content Manager</a></li>
                                <li><a href="<?php echo $this->_tpl_vars['smart']['const']['DOMAIN_PATH']; ?>
/admin/admin_meta_manager.php?type=fixed">Meta Manager</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_user_manager.php">USER MANAGER</a></li>
						<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_size_weight_cost.php">SIZE WEIGHT COST MASTER</a></li>
                        <li><a href="#">CATEGORY MANAGER</a>
                            <ul>
                            	<?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['commonCatTypes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_category_manager.php?cat_type_id=<?php echo $this->_tpl_vars['commonCatTypes'][$this->_sections['counter']['index']]['cat_type_id']; ?>
"><?php echo $this->_tpl_vars['commonCatTypes'][$this->_sections['counter']['index']]['cat_type']; ?>
</a></li>
                                <?php endfor; endif; ?>
                            </ul>
                        </li>
                        <li><a href="#">MESSAGE</a>
                         	<ul>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_messages.php?mode=inbox">Inbox (<span class="err"><?php echo $this->_tpl_vars['countMsg']; ?>
</span>)</a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_messages.php?mode=sent_messages">Sent Messages</a></li>
                            </ul>
                        </li>
                        <li><a href="#">MANAGE AUCTION</a>
                        	<ul style="z-index: 100">
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=fixed">Fixed Price</a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=weekly">Weekly Auctions</a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=monthly">Monthly Auction</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=stills">Stills/Photos</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=stills_auction">Stills/Photos(Auction)</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_alternate_poster.php?mode=alternate_posters">Alternative Posters</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=phone_order">Phone Order Invoice</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=bulkupload">Bulk Upload</a></li>
								<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_auction_manager.php?mode=bulkupload_pending">Bulk Upload Pending</a></li>
						  </ul>
                        </li>
                        <li><a href="#">MANAGE EVENT</a>
                        	<ul>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_event_manager.php?mode=show_all_event">Show All Event</a></li>
                                
                            </ul>
                        </li>
						<?php endif; ?>
                        <li><a href="#">MANAGE AUCTION WEEKS</a>
                        	<ul>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_manage_auction_week.php?mode=show_all_auction_week">Show All Auction Weeks</a></li>
                                
                            </ul>
                        </li>
						<?php if ($this->_tpl_vars['adminTracker'] == 1): ?>
                        <li><a href="#">REPORT MANAGER</a>
                        	<ul>
                                <!--<li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=user_report">User Report</a></li>-->
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=auction_report&search=reconciliation">Reconciliation</a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_report_manager.php?mode=auction_payment_report">Seller Payment Report</a></li>
                            </ul>
                        </li>
                         <li><a href="#">SET FIRST POSTER IN HOME PAGE</a>
                        	<ul>                        	
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_set_first_image_for_home.php?mode=fixed&search=selling">Featured Items for Sale </a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_set_first_image_for_home.php?mode=auction&search=selling">Featured Auction Items </a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_set_first_image_for_home.php?mode=fixed&search=sold">Recent Sales Results </a></li>
                                <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_set_first_image_for_home.php?search=upcoming">Featured Upcoming Items</a></li>
                            </ul>
                        </li>
						<li><a href="#">Access Customer Information</a>
							<ul>
							  <li><a href="<?php echo @ADMIN_PAGE_LINK; ?>
/admin_access_cust_info.php?mode=seller">Customer Master Invoice</a></li>							  
							</ul>							
						</li>
						<?php endif; ?>
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
										<td valign="bottom" align="left" height="50" class="page_heading_small"><img src="<?php echo @CLOUD_STATIC_ADMIN; ?>
icon_control_panel.gif" alt="" border="0" align="absmiddle">&nbsp;&nbsp;<?php echo @PAGE_HEADER_TEXT; ?>
</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="top" align="left" class="box">
								<!-- content portion start -->
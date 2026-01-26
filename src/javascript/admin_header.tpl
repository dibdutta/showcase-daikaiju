<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="history" content="">
		<meta name="author" content="Verdana Core, phpdoc.net Inc.">
		<title>{$smarty.const.ADMIN_PAGE_TITLE}</title>
		<link href="https://d2m46dmzqzklm5.cloudfront.net/css/adminStyle.css" rel="stylesheet">
        <link href="https://d2m46dmzqzklm5.cloudfront.net/css/dropdown_menu.css" rel="stylesheet">
        <script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery-1.4.2.js"></script>
		<!--<script src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery-1.10.2.js"></script>-->
        <script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/dropdown_menu.js"></script>
		<script type="text/javascript" src="http://54.213.214.96/javascript/adminCommon.js.php"></script>
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
													<td align="right" class="headertext" height="34"><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_main.php" class="top_link">Home</a>{php}if((MULTIUSER_ADMIN == true && in_array('admin_config_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ {/php}&nbsp;&nbsp;{if $adminTracker==1}||&nbsp;&nbsp;<a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_config_manager.php" class="top_link">Settings</a>{/if}{php} } {/php}&nbsp;&nbsp;||&nbsp;&nbsp;<a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_login.php?mode=adminLogout" class="top_link">Logout</a>&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text">{if $smarty.session.administratorNames!=""}Signed in as : <strong>{$smarty.session.administratorNames|upper} &nbsp;{$adminCurrentDate}</strong>{/if}&nbsp;</td>
												</tr>
												<tr>
													<td align="right" class="header_welcome_text"><strong>Last logged in on {$adminLastLoginDate}</strong>&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
						   </td>
						</tr>
						<tr>
							<td align="left" valign="top" height="8" class="horizontal_line"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}blank.gif" border="0" alt="" width="1" height="1"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle" height="28" class="top_menu_portion">
                    <ul id="jsddm">
					{if $adminTracker==1}
                        <li><a href="#">MY ACCOUNT</a>
                            <ul>
                                {php}if(MULTIUSER_ADMIN == true && $_SESSION['superAdmin'] == true){{/php}
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_super_manager.php">Admin Manager Section</a></li>
                                <!--<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_super_manager.php?mode=create_user">Add New Administrator</a></li>-->
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
                                {php}}elseif((MULTIUSER_ADMIN == true && in_array('admin_account_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){{/php}
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php">Update Profile</a></li>
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=change_password">Change Password</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=email_template">Email Template Auctions</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=email_template_item_specific">Email Template Item Specefic</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=home_template">Home Template</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=calender_template">Auction Calender</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=blacklist">Blacklist</a></li>
								<li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=shipping">Year wise Shipping Collection</a></li>
                                {php}}{/php}
                            </ul>
                        </li>
                        <li><a href="#">CMS</a>
                            <ul>
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_content_manager.php?type=fixed">Content Manager</a></li>
                                <li><a href="{$smart.const.DOMAIN_PATH}/admin/admin_meta_manager.php?type=fixed">Meta Manager</a></li>
                            </ul>
                        </li>
                        <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_user_manager.php">USER MANAGER</a></li>
						<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_size_weight_cost.php">SIZE WEIGHT COST MASTER</a></li>
                        <li><a href="#">CATEGORY MANAGER</a>
                            <ul>
                            	{section name=counter loop=$commonCatTypes}
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_category_manager.php?cat_type_id={$commonCatTypes[counter].cat_type_id}">{$commonCatTypes[counter].cat_type}</a></li>
                                {/section}
                            </ul>
                        </li>
                        <!--<li><a href="#">MESSAGE</a>
                         	<ul>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_messages.php?mode=inbox">Inbox (<span class="err">{$countMsg}</span>)</a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_messages.php?mode=sent_messages">Sent Messages</a></li>
                            </ul>
                        </li>-->
                        <li><a href="#">MANAGE AUCTION</a>
                        	<ul style="z-index: 100">
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=fixed">Fixed Price</a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=weekly">Weekly Auctions</a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=monthly">Monthly Auction</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=stills">Stills/Photos</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=stills_auction">Stills/Photos(Auction)</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_alternate_poster.php?mode=alternate_posters">Alternative Posters</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=phone_order">Phone Order Invoice</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=bulkupload">Bulk Upload</a></li>
								<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_auction_manager.php?mode=bulkupload_pending">Bulk Upload Pending</a></li>
						  </ul>
                        </li>
                        <li><a href="#">MANAGE EVENT</a>
                        	<ul>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_event_manager.php?mode=show_all_event">Show All Event</a></li>
                                
                            </ul>
                        </li>
						{/if}
                        <li><a href="#">MANAGE AUCTION WEEKS</a>
                        	<ul>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_manage_auction_week.php?mode=show_all_auction_week">Show All Auction Weeks</a></li>
                                
                            </ul>
                        </li>
						{if $adminTracker==1}
                        <li><a href="#">REPORT MANAGER</a>
                        	<ul>
                                <!--<li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=user_report">User Report</a></li>-->
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=auction_report&search=reconciliation">Reconciliation</a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=auction_payment_report">Seller Payment Report</a></li>
                            </ul>
                        </li>
                         <li><a href="#">SET FIRST POSTER IN HOME PAGE</a>
                        	<ul>                        	
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_set_first_image_for_home.php?mode=fixed&search=selling">Featured Items for Sale </a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_set_first_image_for_home.php?mode=auction&search=selling">Featured Auction Items </a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_set_first_image_for_home.php?mode=fixed&search=sold">Recent Sales Results </a></li>
                                <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_set_first_image_for_home.php?search=upcoming">Featured Upcoming Items</a></li>
                            </ul>
                        </li>
						<li><a href="#">Access Customer Information</a>
							<ul>
							  <li><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_access_cust_info.php?mode=seller&user=&user_id=&start_date=&end_date=&invoice_type=unpaid">Customer Master Invoice</a></li>							  
							</ul>							
						</li>
						{/if}
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
										<td valign="bottom" align="left" height="50" class="page_heading_small"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_control_panel.gif" alt="" border="0" align="absmiddle">&nbsp;&nbsp;{$smarty.const.PAGE_HEADER_TEXT}</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="top" align="left" class="box">
								<!-- content portion start -->
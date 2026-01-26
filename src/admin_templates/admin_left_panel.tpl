<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="border-right: 0px solid {$smarty.const.ADMIN_BORDER_COLOR};">
									<tr>
										<td valign="top" align="left" width="100%" bgcolor="{$smarty.const.ADMIN_LEFT_PANEL_TOP_BGCOLOR}" class="left_heading" style="padding-bottom: 5px; padding-top: 5px;" height="30"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt="" vspace="6"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle">Administrative Menu</td>
									</tr>
									<tr>
										<td valign="top" align="left" width="100%" height="3" background="{$smarty.const.ADMIN_IMAGE_LINK}/heading_bottom_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
									</tr>
									<tr>
										<td valign="top" align="left" width="100%" bgcolor="{$smarty.const.ADMIN_LEFT_PANEL_BGCOLOR}">
											<!-- Left Menu Start -->
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												{php}if((MULTIUSER_ADMIN == true && (in_array('admin_super_manager.php', $_SESSION['accessPages']) or in_array('admin_account_manager.php', $_SESSION['accessPages']))) or MULTIUSER_ADMIN == false){ {/php}
												<tr>
													<td valign="middle" align="left" width="" height="29" class='off' onMouseOver="this.className='on';document.all.a_am.style.color='{$smarty.const.ADMIN_MENU_TEXT_HOVER_COLOR}';" onMouseOut="this.className='off';document.all.a_am.style.color='{$smarty.const.ADMIN_MENU_TEXT_COLOR}';" onclick="javascript: location.href='{if $smarty.session.superAdmin == 1}{$smarty.const.ADMIN_PAGE_LINK}/admin_super_manager.php{else}{$smarty.const.ADMIN_PAGE_LINK}/admin_account_manager.php{/if}'; return true;"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt=""><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><a {if $smarty.session.superAdmin == 1}href="{$smarty.const.ADMIN_PAGE_LINK}/admin_super_manager.php"{else}href="{$smarty.const.ADMIN_PAGE_LINK}/admin_account_manager.php"{/if} class="left_link" name="a_am">Account Manager &raquo;</A></td>
												</tr>
												<tr>
													<td valign="top" align="left" width="" height="1" background="{$smarty.const.ADMIN_IMAGE_LINK}/bg_top_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
												</tr>
												{php} } {/php}
												{php}if((MULTIUSER_ADMIN == true && in_array('admin_content_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ {/php}
												<tr>
													<td valign="middle" align="left" width="" height="29" class='off' onMouseOver="this.className='on';document.all.a_cm.style.color='{$smarty.const.ADMIN_MENU_TEXT_HOVER_COLOR}';" onMouseOut="this.className='off';document.all.a_cm.style.color='{$smarty.const.ADMIN_MENU_TEXT_COLOR}';" onclick="javascript: location.href='{$smarty.const.ADMIN_PAGE_LINK}/admin_content_manager.php?type=fixed'; return true;"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt=""><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_content_manager.php?type=fixed" class="left_link" name="a_cm">Content Manager &raquo;</A></td>
												</tr>
												<tr>
													<td valign="top" align="left" width="" height="1" background="{$smarty.const.ADMIN_IMAGE_LINK}/bg_top_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
												</tr>
												{php} } {/php}
												{php}if((MULTIUSER_ADMIN == true && in_array('admin_meta_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ {/php}
												<tr>
													<td valign="middle" align="left" width="" height="29" class='off' onMouseOver="this.className='on';document.all.a_mm.style.color='{$smarty.const.ADMIN_MENU_TEXT_HOVER_COLOR}';" onMouseOut="this.className='off';document.all.a_mm.style.color='{$smarty.const.ADMIN_MENU_TEXT_COLOR}';" onclick="javascript: location.href='{$smarty.const.ADMIN_PAGE_LINK}/admin_meta_manager.php?type=fixed'; return true;"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt=""><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_meta_manager.php?type=fixed" class="left_link" name="a_mm">Meta Manager &raquo;</A></td>
												</tr>
												<tr>
													<td valign="top" align="left" width="" height="1" background="{$smarty.const.ADMIN_IMAGE_LINK}/bg_top_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
												</tr>
												{php} } {/php}
												{php}if((MULTIUSER_ADMIN == true && in_array('admin_config_manager.php', $_SESSION['accessPages'])) or MULTIUSER_ADMIN == false){ {/php}
												<tr>
													<td valign="middle" align="left" width="" height="29" class='off' onMouseOver="this.className='on';document.all.a_config.style.color='{$smarty.const.ADMIN_MENU_TEXT_HOVER_COLOR}';" onMouseOut="this.className='off';document.all.a_config.style.color='{$smarty.const.ADMIN_MENU_TEXT_COLOR}';" onclick="javascript: location.href='{$smarty.const.ADMIN_PAGE_LINK}/admin_config_manager.php'; return true;"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt=""><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_config_manager.php" class="left_link" name="a_config">Config Manager &raquo;</A></td>
												</tr>
												<tr>
													<td valign="top" align="left" width="" height="1" background="{$smarty.const.ADMIN_IMAGE_LINK}/bg_top_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
												</tr>
												{php} } {/php}
												<tr>
													<td valign="middle" align="left" width="" height="29" class='off' onMouseOver="this.className='on';document.all.a_log.style.color='{$smarty.const.ADMIN_MENU_TEXT_HOVER_COLOR}';" onMouseOut="this.className='off';document.all.a_log.style.color='{$smarty.const.ADMIN_MENU_TEXT_COLOR}';" onclick="javascript: location.href='{$smarty.const.ADMIN_PAGE_LINK}/admin_login.php?mode=adminLogout'; return true;"><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><img src="{$smarty.const.ADMIN_IMAGE_LINK}/bullet.jpg" align="absmiddle" border=0 alt=""><img src="spacer.gif" border=0 alt="" width="4" height="1" align="absmiddle"><a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_login.php?mode=adminLogout" class="left_link" name="a_log">Logout &raquo;</A></td>
												</tr>
												<tr>
													<td valign="top" align="left" width="" height="1" background="{$smarty.const.ADMIN_IMAGE_LINK}/bg_top_line.jpg"><img src="#" border="0" alt="" height="0" width="0"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="10%">Name</td >
											<td align="center" class="headertext" width="17%">{$userNameTXT}</td>
											<td align="center" class="headertext" width="20%">Address</td>
											<td align="center" class="headertext" width="12%">Contact</td >
											<td align="center" class="headertext" width="17%">{$emailTXT}</td>
											<td align="center" class="headertext" width="12%">{$statusTXT}</td >
											
										</tr>
										{section name=counter loop=$userID}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="smalltext" width="10%">{$userFNAME[counter]}&nbsp;{$userLNAME[counter]}</td >
												<td align="center" class="smalltext">{$userName[counter]}</td>
												<td align="center" class="smalltext">{if $address1[counter]!=''}{$address1[counter]},{/if}{if $address2[counter]!=''}{$address2[counter]},{/if}{if $city[counter]!=''}{$city[counter]},{/if}{if $state[counter]!=''}{$state[counter]},{/if}{$country[counter]}</td>
												<td align="center" class="smalltext">{$userCONTACT[counter]}</td>
												<td align="center" class="smalltext">{$email[counter]}</td>
												<td align="center" class="smalltext" id="changeStatusPortion_{$userID[counter]}">
													{if $status[counter] == 1}
														Active
													{else}
														Inactive
													{/if}
												</td>
												
											</tr>
										{/section}
										<tr class="tr_bgcolor" >
											<td align="center" colspan="6" class="bold_text" valign="top">
											<input type="button" value="View & Print" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=print_user_report','mywindow','menubar=1,resizable=1,width=500,height=300')">&nbsp;&nbsp;&nbsp;
                        					
											</td>
										</tr>
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no user in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center">
						<table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center"><a href="{$adminActualPath}/admin_messages.php?mode=compose&encoded_string={$encoded_string}" class="action_link"><strong>Compose</strong></a></td>
							</tr>
						</table>
					</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				{if $total>0}
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post">
                            	<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="85%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="6%"></td>
											<td align="center" class="headertext" width="25%">From</td>
                                            <td align="center" class="headertext" width="39%">Subject</td>
                                            <td align="center" class="headertext" width="20%">Date</td>
                                            <td align="center" class="headertext" width="10%">Action</td>
										</tr>
										{section name=counter loop=$messageRows}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="smalltext"><input type="checkbox" name="message_ids[]" value="{$messageRows[counter].message_id}" class="checkBox" /></td>
                                                <td align="center" class="smalltext">{$messageRows[counter].message_from_username}</td>
                                                <td align="center" class="smalltext" {if $messageRows[counter].message_is_new == '1'}style="font-weight:bolder;"{/if}><a href="{$adminActualPath}/admin_messages.php?mode=read&message_id={$messageRows[counter].message_id}&encoded_string={$encoded_string}">{$messageRows[counter].message_subject}</a> </td>
                                                <td align="center" class="smalltext">{$messageRows[counter].send_date}</td>
												<td align="center" class="bold_text">
													<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_messages.php?mode=delete_message&message_id={$messageRows[counter].message_id}&encoded_string={$encoded_string}', 'Message'); return false;"><img src="{$adminImagePath}/delete_image.png" align="absmiddle" alt="Delete Message" title="Delete Message" border="0" class="changeStatus" /></a>
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext">&nbsp;</td>
											<td align="left" class="headertext" colspan="2">{$pageCounterTXT}</td>
											<td align="right" class="headertext" colspan="2">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$adminImagePath}/arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
												<option value="delete_all_messages">Delete Message</option>
											</select>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no messages.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
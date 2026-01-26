{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table align="center" width="60%" border="0" cellspacing="3" cellpadding="3">
							<form method="post" action="">
							<input type="hidden" name="mode" value="send_reply">
                            <!--<input type="hidden" name="message_to" value="{$message_id}">-->
                            <input type="hidden" name="message_to" value="{$message[0].message_from}">
							<input type="hidden" name="encoded_string" value="{$encoded_string}">
							<tr>
								<td align="left" class="bold_text">Subject :</td>
                                <td align="left"><input type="text" name="message_subject" value="Re: {$message[0].message_subject}" class="look" size="70"><br /><span class="err">{$message_subject_err}</span></td>
							</tr>
                            <tr>
                                <td class="bold_text">Message :<br /></td>
                                <td align="left">{$message_body}<br /><span class="err">{$message_body_err}</span></td>
                            </tr>
                            <tr height="28">
                                <td align="center" colspan="2"><input type="submit" name="" value="Post Message" class="button">&nbsp;&nbsp;<input type="button" name="" value="Discard" class="button" onclick="javascript: location.href='{$adminActualPath}/admin_messages.php?mode=read&message_id={$message_id}&encoded_string={$encoded_string}'; "></td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
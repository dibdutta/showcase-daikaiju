{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
		<td width="100%">
            <table align="center" width="85%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
                <tr>
                    <td align="right" width="15%" class="header_bgcolor"><b>From</b></td>
                    <td align="left" class="odd_tr">{$message[0].message_from_username}</td>
                </tr>
                <tr>
                    <td align="right" class="header_bgcolor"><b>Date</b></td>
                    <td align="left" class="even_tr">{$message[0].message_sent_dt}</td>
                </tr>
                <tr>
                    <td align="right" class="header_bgcolor"><b>Subject</b></td>
                    <td align="left" class="odd_tr">{$message[0].message_subject}</td>
                </tr>
                <tr>
                    <td align="right" class="header_bgcolor"><b>Message</b></td>
                    <td align="left" class="even_tr">{$message[0].message_body}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td align="center">
    	{if $message[0].message_is_fromadmin!=1}<input type="button" name="" value="Back to Inbox" class="button" onclick="javascript: location.href='{$actualPath}/admin/admin_messages.php?mode=inbox';" />
    	&nbsp;&nbsp;<input type="button" name="delete" value="Delete" class="button" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_messages.php?mode=delete_message&message_id={$message[0].message_id}&encoded_string={$encoded_string}', 'Message'); return false;" />&nbsp;&nbsp;<input type="button" name="reply" id="btnreply" value="Reply" class="button" onclick="javascript: location.href='{$adminActualPath}/admin_messages.php?mode=reply&message_id={$message[0].message_id}&encoded_string={$encoded_string}';" />{else}<input type="button" name="" value="Back to Sent Messages" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" />{/if}</td>
    </tr>
</table>
{include file="admin_footer.tpl"}
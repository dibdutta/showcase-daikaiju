
	<link rel="stylesheet" href="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/css/common.css" type="text/css" />
	<link type="text/css" rel="stylesheet" href="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/css/jquery-ui.css" />
	<link type="text/css" href="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/css/ui.multiselect.css" rel="stylesheet" />
	{include file="admin_header.tpl"}
<!--	<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/js/jquery-min.js"></script>
-->	<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/js/jquery-ui-min.js"></script>
	<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
	<!--<script type="text/javascript" src="js/plugins/scrollTo/jquery.scrollTo-min.js"></script>-->
	<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/js/ui.multiselect.js"></script>
	{literal}
	<script type="text/javascript">
		$(function(){
			$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
			$(".multiselect").multiselect();
			$('#switcher').themeswitcher();
		});
	</script>
	{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
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
							<input type="hidden" name="mode" value="send_message">
							<input type="hidden" name="encoded_string" value="{$encoded_string}">
							
							<tr>
								<td align="left" class="bold_text">To :</td>
                                <td align="left">
                                <div >							
								 <select id="countries" class="multiselect" multiple="multiple" name="user_ids[]">
                                {section name=counter loop=$userRow}
                                	{section name=chkCounter loop=$user_ids}
                                		{if $userRow[counter].user_id == $user_ids[chkCounter].user_ids}
                                        	{assign var="checked" value="checked"}
                                        {/if}
                                    {/section}
                                    <!--<input type="checkbox" name="user_ids[]" value="{$userRow[counter].user_id}" {$checked} class="checkBox" />&nbsp;{$userRow[counter].username}<br />-->
									<option value="{$userRow[counter].user_id}" >{$userRow[counter].firstname}&nbsp;{$userRow[counter].lastname}&nbsp;({$userRow[counter].username})</option>
                                    {assign var="checked" value=""}
                                {/section}
								</select>
								(To select click on the user or drag the user to selection panel)
                                </div>
                                <span class="err">{$user_ids_err}</span>
                                </td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							</tr>
							<tr height="28">
								<td align="left" class="bold_text">Subject :</td>
                                <td align="left"><input type="text" name="message_subject" value="{$message_subject}" class="look" size="70"><br /><span class="err">{$message_subject_err}</span></td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							</tr>
                            <tr height="28">
                                <td class="bold_text">Message :<br /></td>
                                <td align="left">{$message_body}<br /><span class="err">{$message_body_err}</span></td>
                            </tr>
                            <tr height="28">
                                <td align="center" colspan="2"><input type="submit" name="" value="Post Message" class="button">&nbsp;&nbsp;<input type="button" name="" value="Cancel" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; "></td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/multiselect/js/jquery_new.js"></script>
{include file="admin_footer.tpl"}
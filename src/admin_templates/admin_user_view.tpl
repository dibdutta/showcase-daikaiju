{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" align="center">
			<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
				<tr class="header_bgcolor" height="26">
					<td colspan="2" class="headertext"><b>&nbsp;View User Details</b></td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" width="30%" valign="top">LogIn Name :</td>
					<td valign="top" align="left" width="70%">{$userName}</td>
				</tr>
				<!--tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Name :</td>
					<td valign="top">{$userFirstName}&nbsp;{$userLastName}</td>
				</tr-->
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Address  :</td>
					<td valign="top">{$userAddress}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Zip/Postal Code :</td>
					<td valign="top">{$userZip}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">City  :</td>
					<td valign="top">{$userCity}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">State or Province  :</td>
					<td valign="top">{$userState}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Country :</td>
					<td valign="top">{$userCountryName}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Email :</td>
					<td valign="top">{$userEmail}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Contact Number :</td>
					<td valign="top">{$userContactNo}</td>
				</tr>
				<!--tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Mobile Number :</td>
					<td valign="top">{$userMobile}</td>
				</tr-->
				<tr class="tr_bgcolor">
					<td align="left" class="bold_text" valign="top">Newsletter Subscription :</td>
					<td valign="top">{if $userNewletterSubscription ==1}Yes{else}No{/if}</td>
				</tr>
				<tr class="tr_bgcolor">
					<td align="center" colspan="2" class="bold_text" valign="top">
					<a href="{$adminActualPath}/admin_user_manager.php?mode=edit_user&user_id={$userID}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}btn_edit.jpg" align="absmiddle" alt="Edit" title="Edit" border="0" class="changeStatus" /></a> &nbsp; &nbsp; 
					
					<input type="button" class="look" value="« Back" onclick="javascript: history.go(-1);" /></td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
	

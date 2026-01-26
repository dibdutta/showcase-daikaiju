{include file="admin_header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/fancybox/jquery-min.js"></script>
<script>
    !window.jQuery && document.write('<script src="{$actualPath}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
</script>
<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

{literal}

<script type="text/javascript">

	function fancy_images(){
		$("#various").fancybox({
			'width'				: '75%',
			'height'			: '80%',
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>MPE Blacklist Section</strong></a></td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="save_blacklist">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											<tr class="header_bgcolor" height="26">
												<td colspan="2" class="headertext"><b>Add Blacklisted Users Details Here (for multiple values add comma separator)</b>
												</td>
											</tr>
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> By Domain Name :</td>
												<td valign="top"><input type="text"  name="domain" value="{$domain}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> By First Name :</td>
												<td valign="top"><input type="text"  name="firstname" value="{$firstname}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> By Last Name :</td>
												<td valign="top"><input type="text"  name="lastname" value="{$lastname}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> By Email Id :</td>
												<td valign="top"><input type="text"  name="email" value="{$email}" maxlength="400" size="45" /><br><span class="err">{$first_name_err}</span></td>
											</tr>									
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Save" >&nbsp;&nbsp;&nbsp;&nbsp;
												<a id="various" href="{$smart.const.DOMAIN_PATH}/admin/admin_account_manager.php?mode=viewBlacklistHistory">
													<input type="button" name="submit" class="button" value="History" onclick="fancy_images()" />
												</a>
												</td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
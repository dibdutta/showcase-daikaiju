{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Change Configuration</td>
				</tr>
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="save_config">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Administrative Section</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%" >Admin Page Title :</td>
												<td class="smalltext"><input type="text" name="pageTitle" value="{$pageTitle}" size="40" class="look" /><br><span class="err">{$pageTitle_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Admin Copyright Text :</td>
												<td class="smalltext"><input type="text" name="copyRight" value="{$copyRight}" class="look" style="width:250px;" /><br><span class="err">{$copyRight_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Admin Welcome Text :</td>
												<td class="smalltext"><input type="text" name="welcomeText" value="{$welcomeText}" class="look" style="width:250px;" /><br><span class="err">{$welcomeText_err}</span></td>
											</tr>
                                            <tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Paypal Account Details</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Username :</td>
												<td class="smalltext"><input type="text" name="paypal_api_username" value="{$paypal_api_username}" class="look" style="width:250px;" /><br /><span class="err">{$paypal_api_username_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Password :</td>
												<td class="smalltext"><input type="text" name="paypal_api_password" value="{$paypal_api_password}" class="look" style="width:250px;" /><br /><span class="err">{$paypal_api_password_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">API Signature :</td>
												<td class="smalltext"><input type="text" name="paypal_api_signature" value="{$paypal_api_signature}" class="look" style="width:250px;" /><br /><span class="err">{$paypal_api_signature_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Is Test Mode :</td>
												<td class="smalltext"><input type="checkbox" name="paypal_is_test_mode" value="1" {if $paypal_is_test_mode == '1'} checked="checked" {/if} /><br><span class="err">{$pageTitle_err}</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Administrator's Information</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Administrator's Name :</td>
												<td class="smalltext"><input type="text" name="adminName" value="{$adminName}" class="look" style="width:250px;" /><br><span class="err">{$adminName_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Administrator's Email :</td>
												<td class="smalltext"><input type="text" name="adminEmail" value="{$adminEmail}" class="look"  style="width:250px;" /><br><span class="err">{$adminEmail_err}</span></td>
											</tr>
											<tr class="header_bgcolor" height="24" style="display:none;">
												<td colspan="2" align="left" class="headertext">Administrator's Instruction</td>
											</tr>
											<tr class="tr_bgcolor" style="display:none;">
												<td class="bold_text" valign="top">Instruction :</td>
												<td class="smalltext"><textarea name="instruction" class="look" cols="70" rows="6">{$instruction}</textarea><br><span class="err">{$instruction_err}</span></td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Settings</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Start Time :</td>
												<td class="smalltext">
                                                <select name="auction_start_hour" size="1" tabindex="7">
                                                {section name=foo start=1 loop=13 step=1}
                                                	{if $smarty.section.foo.index < 10}
                                                    	{assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                    {else}
                                                    	{assign var=hour value=$smarty.section.foo.index}
                                                    {/if}
                                                  <option value="{$hour}" {if $auction_start_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                   {/section}
                                                </select>(Hour) :
                                               
                                                <select name="auction_start_min" size="1" tabindex="8" >
                                                  <option value="00" {if $auction_start_min=='00'}selected{/if}>00</option>
                                                 {section name=foo start=15 loop=60 step=15}
                                                  <option value="{$smarty.section.foo.index}" {if $auction_start_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                  {/section}
                                                  </select>(Min)
                                                  <select name="auction_start_am_pm" size="1" tabindex="9" >
                                                    <option value="am" {if $auction_start_am_pm=='am'}selected{/if}>AM</option>
                                                    <option value="pm" {if $auction_start_am_pm=='pm'}selected{/if}>PM</option>
                                                  </select>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">End Time :</td>
												<td class="smalltext">
                                                <select name="auction_end_hour" size="1" tabindex="7" >
                                                {section name=foo start=1 loop=13 step=1}
                                                	{if $smarty.section.foo.index < 10}
                                                    	{assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                    {else}
                                                    	{assign var=hour value=$smarty.section.foo.index}
                                                    {/if}
                                                  <option value="{$hour}" {if $auction_end_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                   {/section}
                                                </select>(Hour) :
                                               
                                                <select name="auction_end_min" size="1" tabindex="8" >
                                                  <option value="00" {if $auction_end_min=='00'}selected{/if}>00</option>
                                                 {section name=foo start=15 loop=60 step=15}
                                                  <option value="{$smarty.section.foo.index}" {if $auction_end_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                  {/section}
                                                  </select>(Min)
                                                  <select name="auction_end_am_pm" size="1" tabindex="9" >
                                                    <option value="am" {if $auction_end_am_pm=='am'}selected{/if}>AM</option>
                                                    <option value="pm" {if $auction_end_am_pm=='pm'}selected{/if}>PM</option>
                                                  </select>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Set Increase Time Before:</td>
												<td class="smalltext">
                                                <select name="auction_incr_min_span" size="1" tabindex="7" >
                                                {section name=foo start=0 loop=11 step=1}
                                                	{if $smarty.section.foo.index < 10}
                                                    	{assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                    {else}
                                                    	{assign var=hour value=$smarty.section.foo.index}
                                                    {/if}
                                                  <option value="{$hour}" {if $auction_incr_min_span==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                   {/section}
                                                </select>(Min)
                                               
                                                <select name="auction_incr_sec_span" size="1" tabindex="8" >
                                                  <option value="00" {if $auction_incr_sec_span=='00'}selected{/if}>00</option>
                                                  <option value="05" {if $auction_incr_sec_span=='05'}selected{/if}>05</option>
                                                 {section name=foo start=10 loop=60 step=5}
                                                  <option value="{$smarty.section.foo.index}" {if $auction_incr_sec_span==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                  {/section}
                                                  </select>(Sec)
                                                  
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Increase Time :</td>
												<td class="smalltext">
                                                <select name="auction_incr_by_min" size="1" tabindex="7" >
                                                {section name=foo start=0 loop=11 step=1}
                                                	{if $smarty.section.foo.index < 10}
                                                    	{assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                    {else}
                                                    	{assign var=hour value=$smarty.section.foo.index}
                                                    {/if}
                                                    <option value="{$hour}" {if $auction_incr_by_min==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                  {/section}  
                                                </select>(Min)
                                               
                                                <select name="auction_incr_by_sec" size="1" tabindex="8" >
                                                  <option value="00" {if $auction_incr_by_sec=='00'}selected{/if}>00</option>
                                                  <option value="05" {if $auction_incr_by_sec=='05'}selected{/if}>05</option>
                                                 {section name=foo start=10 loop=60 step=5}
                                                  <option value="{$smarty.section.foo.index}" {if $auction_incr_by_sec==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                  {/section}
                                                 </select>(Sec)
                                                  
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Sale Tax Settings</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Sale Tax for Gorgia:</td>
												<td class="smalltext"><input type="text" name="sale_tax_ga" value="{$sale_tax_ga}" class="look" maxlength="2" style="width:50px;" />&nbsp;%<br /><span class="err">{$ga_sale_tax_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Sale Tax for North Carolina:</td>
												<td class="smalltext"><input type="text" name="sale_tax_nc" value="{$sale_tax_nc}" class="look" maxlength="2" style="width:50px;" />&nbsp;%<br /><span class="err">{$nc_sale_tax_err}</span></td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Save Changes" class="button"></td>
											</tr>
										</table>
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
{include file="admin_footer.tpl"}
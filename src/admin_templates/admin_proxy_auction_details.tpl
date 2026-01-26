{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                {if $errorMessage<>""}
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if} 
                    <tr>
                    	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                    </tr>              		
             	{if $total>0}
                    <tr>
                    	<td align="left">
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                	<tr class="header_bgcolor" height="26">
                                        <td align="left" class="headertext" width="25%">Proxy Bid Person</td>
                                        <td align="center" class="headertext" width="20%">Proxy Bid Day</td>
                                        <td align="center" class="headertext" width="12%">Proxy amount</td>
<!--                                        <td width="8%">&nbsp;</td>-->
                                    </tr>
                                    {section name=counter loop=$bidData}
                                        <tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="left" class="smalltext">&nbsp;{$bidData[counter].firstname}&nbsp;{$bidData[counter].lastname}</td>
                                            <td align="center" class="smalltext">&nbsp;{if $bidData[counter].amount > $bidData[counter].bid_amount}{$bidData[counter].proxy_date|date_format:"%m-%d-%Y"} {else} {$bidData[counter].post_date|date_format:"%m-%d-%Y"} {/if} </td>
                                            <td align="center" class="smalltext">&nbsp;{if $bidData[counter].amount > $bidData[counter].bid_amount}${$bidData[counter].amount|number_format:2} {else} ${$bidData[counter].bid_amount|number_format:2} {/if}</td>
<!--                                           <td align="center" class="bold_text">-->
<!--                                           		<a href="#"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}proxy-edit-icon.png" width="16" height="16" border="0" /></a>-->
<!--                                                <a href="#"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}proxy-del-icon.png" width="16" height="16" border="0" /></a>-->
<!--                                            </td>-->
                                        </tr>
                                    {/section}
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="smalltext" ></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
						</td>
                    </tr>
				{else}
					<tr>
						<td align="center" class="err">There is no proxy bid set for this poster.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
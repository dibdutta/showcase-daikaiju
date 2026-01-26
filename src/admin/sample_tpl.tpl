{include file="header.tpl"}
	<table border="0" cellpadding="10" cellspacing="0" width="100%">
		{if $pageHeaderName <> ""}
			<tr>
				<td>{$pageHeaderName}</td>
			</tr>
		{/if}	
		<tr>
			<td>
				{$pageContent}
			</td>
		</tr>	
	</table>
{include file="footer.tpl"}
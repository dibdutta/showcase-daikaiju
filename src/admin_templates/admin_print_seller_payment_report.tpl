{literal}
<style>
.printer{
font-family:Calibri;	
}
}
</style>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                
					<tr>
						<td align="center">
							
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="96%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000" >
									<tbody>
										<tr>
    										<td  style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="278" height="84" border="0" />
        									</td>
        									<td >&nbsp;</td>
    									</tr>
										<tr>
											<td colspan="2" align="center" class="printer"><b>Seller&nbsp;:&nbsp;{$userRow[0].firstname}&nbsp;{$userRow[0].lastname}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment Report Manager {if $start_date!=''}From {$start_date|date_format:"%m-%d-%Y"} To {$end_date|date_format:"%m-%d-%Y"}{/if}</b></td>
										</tr>
										<tr class="header_bgcolor" height="26">
											<td align="center" width="16%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Paid Amount</font></td >
											<td align="center" width="12%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Date</font></td>
											</tr>
										{section name=counter loop=$dataPayment}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" ><font style="font-size:12px; font-family:Arial;">${$dataPayment[counter].payment_amount}</font></td>
												<td align="center"  ><font style="font-size:12px; font-family:Arial;">{$dataPayment[counter].payment_date|date_format}</font></td>
											</tr>
										{/section}
										<tr class="tr_bgcolor" >
											<td align="center" colspan="2" valign="top">
											<input type="submit" value="Print" class="button" onclick="javascript:window.print()">&nbsp;&nbsp;&nbsp;
                        					
											</td>
										</tr>
										
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
		
			</table>
		</td>
	</tr>		
</table>

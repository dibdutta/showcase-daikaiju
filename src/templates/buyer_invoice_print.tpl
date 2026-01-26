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
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr>
											<td colspan="7"  class="printer"><b> Preview Invoice  </b></td>
										</tr>
										<tr>
										<td colspan="7"  class="printer"><hr></td>
										</tr>
										<tr>
										<td colspan="7"  bgcolor="Silver" class="printer"><b>Invoice</b></td>
										</tr>
										<tr>
										<td colspan="7" class="printer">{$invoiceData[0].firstname}&nbsp;{$invoiceData[0].lastname}</td>
										</tr>
										<tr>
										<td colspan="2" class="printer">{$invoiceData[0].email}</td>
										<td  class="printer">Bill Date:{$invoiceData[0].post_date}</td>
										</tr>
										<tr class="printer" height="26" bgcolor="Silver">
											<td align="center" class="printer" width="10%">Poster Title</td >
											<td align="center" class="printer" width="17%">Description</td>
											<td align="center" class="printer" width="12%">Amount</td >
										</tr>
										{section name=counter loop=$invoiceData}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="printer" width="10%">{$invoiceData[counter].poster_title}&nbsp;({$invoiceData[counter].poster_sku})</td >
												<td align="center" class="printer">{$invoiceData[counter].poster_desc}</td>
												<td align="right" class="printer">${$invoiceData[counter].amount}</td>
											</tr>
										{/section}	
											<tr><td colspan="3">&nbsp;</td></tr>
											<tr>
												<td align="right" colspan="2" class="printer">MPE Charge(10 Percent):</td >
												<td align="right" class="printer">${$invoiceData[0].mpe_charge}</td>
											</tr>
											<tr>
												<td align="right" colspan="2" class="printer">Transaction Charge(2.3 Percent):</td >
												<td align="right" class="printer">${$invoiceData[0].transaction_charge}</td>
											</tr>
											<tr>
												<td align="right" colspan="2" class="printer">Total:</td >
												<td align="right" class="printer">${$invoiceData[0].pay_amount}</td>
											</tr>
										<tr class="tr_bgcolor" >
											<td align="center" colspan="7" class="bold_text" valign="top">
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

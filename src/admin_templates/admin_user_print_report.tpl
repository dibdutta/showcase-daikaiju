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
								<table align="center" width="96%" border="1" cellspacing="1" cellpadding="2"  >
									<tbody>
									 <tr>
									 <td colspan="6" align="center" class="printer"><b>User Report Manager</b></td>
									 </tr>
										<tr  height="26">
											<td align="center"  width="10%" class="printer">Name</td >
											<td align="center"  width="17%" class="printer">{$userNameTXT}</td>
											<td align="center"  width="20%" class="printer">Address</td>
											<td align="center"  width="12%" class="printer">Contact</td >
											<td align="center"  width="17%" class="printer">{$emailTXT}</td>
											<td align="center"  width="12%" class="printer">{$statusTXT}</td >
											
										</tr>
										{section name=counter loop=$userID}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center"  width="10%">{$userFNAME[counter]}&nbsp;{$userLNAME[counter]}</td >
												<td align="center" >{$userName[counter]}</td>
												<td align="center" >{if $address1[counter]!=''}{$address1[counter]},{/if}{if $address2[counter]!=''}{$address2[counter]},{/if}{if $city[counter]!=''}{$city[counter]},{/if}{if $state[counter]!=''}{$state[counter]},{/if}{$country[counter]}</td>
												<td align="center" >{$userCONTACT[counter]}</td>
												<td align="center" >{$email[counter]}</td>
												<td align="center"  >
													{if $status[counter] == 1}
														Active
													{else}
														Inactive
													{/if}
												</td>
												
											</tr>
										{/section}
										<tr class="tr_bgcolor" >
											<td align="center" colspan="6" class="bold_text" valign="top">
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

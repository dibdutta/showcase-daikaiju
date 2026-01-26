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
								<table align="center" width="60%" border="1" cellspacing="1" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000" >
									<tbody>
										<tr height="26">
											<td colspan="5" align="center" class="printer"><b>{$search} Auction Report Manager {if $start_date!=''}From {$start_date|date_format:"%m-%d-%Y"} To {$end_date|date_format:"%m-%d-%Y"}{/if}</b></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total poster </td >			
											<td style="border:none;" colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td class="printer"  colspan="2">Total sold</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_sold}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total paid</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_paid}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total unpaid</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_unpaid}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total selling</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_selling}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total pending</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_pending}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total expired and unsold</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_unsold}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total reopened</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_reopen}</font></td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="printer"  colspan="2">Total upcoming</td >
											<td colspan="3">&nbsp;<font style="font-size:12px; font-family:Arial;">{$total_upcoming}</font></td>
										</tr>
										{if $total_paid >0}
										<tr class="header_bgcolor" height="26">
											<td class="printer" colspan="5">&nbsp;<font style="font-size:12px; font-family:Arial;">Payment Details</font></td >
										</tr>
										
										<tr class="header_bgcolor" height="26">
											<td align="center" width="16%"><font style="font-size:12px; font-family:Arial; font-weight:bold;"> Poster</font></td >
											<td align="center" width="14%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Auction Type</font></td>
											<td align="center" width="15%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Sold Amount</font></td>
											<td align="center" width="15%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">MPE Commission</font><font style="font-size:9px; font-family:Arial;"><br/>(MPE charge + transaction fee)</font></td>
											<td align="center" width="15%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Seller Owned</font></td>
										</tr>
										{section name=counter loop=$paidAuctionDetails}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="{$actualPath}/poster_photo/thumbnail/{$paidAuctionDetails[counter].poster_thumb}" ><br/>
												<font style="font-size:12px; font-family:Arial;">{$paidAuctionDetails[counter].poster_title}(#{$paidAuctionDetails[counter].poster_sku})</font>
												</td >
												
												
												<td align="center" class="smalltext"><font style="font-size:12px; font-family:Arial;">{if $paidAuctionDetails[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='3'}Monthly Auction{/if}</font></td>
												
												<td align="center" class="smalltext"><font style="font-size:12px; font-family:Arial;">{if $paidAuctionDetails[counter].sold_price > 0}${$paidAuctionDetails[counter].sold_price}{else}--{/if}</font></td>
												<td align="center" class="smalltext" ><font style="font-size:12px; font-family:Arial;">{if $paidAuctionDetails[counter].sold_price > 0}${$paidAuctionDetails[counter].mpe_charge} + ${$paidAuctionDetails[counter].trans_charge}{else}--{/if}</font></td>
												<td align="center" class="smalltext"><font style="font-size:12px; font-family:Arial;">{if $paidAuctionDetails[counter].sold_price > 0}${$paidAuctionDetails[counter].seller_owned}{else}--{/if}</font></td>
												
											</tr>
											
										{/section}
										
										<tr class="header_bgcolor" height="26">
												<td align="center" class="headertext" width="20%">&nbsp;&nbsp;
												<font style="font-size:12px; font-family:Arial;">Total</font>
												</td >
												
												
												<td align="center" class="smalltext"></td>
												
												<td align="center" class="headertext"><font style="font-size:12px; font-family:Arial;">{if $total_sold_price > 0}${$total_sold_price}{else}--{/if}</font></td>
												<td align="center" class="headertext" ><font style="font-size:12px; font-family:Arial;">{if $total_fee > 0}${$total_fee}{else}--{/if}</font></td>
												<td align="center" class="headertext"><font style="font-size:12px; font-family:Arial;">{if $total_own > 0}${$total_own}{else}--{/if}</font></td>
												
											</tr>
										{/if}	
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>-->
<!--											<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>-->
<!--										</tr>-->
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											<input type="button" value="Print" class="button" onclick="window.print();">&nbsp;&nbsp;&nbsp;
                        					
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
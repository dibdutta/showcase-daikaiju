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
								<table align="center" width="96%" border="1" cellspacing="1" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000" >
									<tbody>
										<tr>
    										<td  style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="278" height="84" border="0" />
        									</td>
        									<td colspan="7">&nbsp;</td>
    									</tr>
										<tr>
											<td colspan="7" align="center" class="printer"><b>{$search} Auction Report Manager {if $start_date!=''}From {$start_date|date_format:"%m-%d-%Y"} To {$end_date|date_format:"%m-%d-%Y"}{/if}</b></td>
										</tr>
										<tr class="header_bgcolor" height="26">
											<td align="center" width="16%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Poster</font></td >
											<td align="center" width="12%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Seller</font></td>
											<td align="center" width="12%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Buyer</font></td >
											<td align="center" width="14%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Auction Type</font></td>
											<td align="center" width="15%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Auction Pricing</font></td>
											<td align="center" width="15%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Auction Timings</font></td>
											<td align="center" width="8%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Sold Price</font></td>
											<td align="center" width="12%"><font style="font-size:12px; font-family:Arial; font-weight:bold;">Status</font></td >
										</tr>
										{section name=counter loop=$dataAuction}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left">&nbsp;&nbsp;<img src="{$dataAuction[counter].image_path}" ><br/>
												<font style="font-size:12px; font-family:Arial;">{$dataAuction[counter].poster_title}(#{$dataAuction[counter].poster_sku})</font>
												</td >
												<td align="center" ><font style="font-size:12px; font-family:Arial;">{$dataAuction[counter].firstname}&nbsp;{$dataAuction[counter].lastname}</font></td>
												<td align="center" ><font style="font-size:12px; font-family:Arial;">{if $dataAuction[counter].winnerName<>''}{$dataAuction[counter].winnerName}{else}NA{/if}</font></td>
												<td align="center" ><font style="font-size:12px; font-family:Arial;">{if $dataAuction[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $dataAuction[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $dataAuction[counter].fk_auction_type_id=='3'}Monthly Auction{/if}</font></td>
												<td align="center" ><font style="font-size:12px; font-family:Arial;">{if $dataAuction[counter].fk_auction_type_id=='1'}Asking Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>{if $dataAuction[counter].auction_reserve_offer_price > 0}Will consider offers{/if} {/if}
																					 {if $dataAuction[counter].fk_auction_type_id=='2'}Starting Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>Buynow Price:&nbsp;${$dataAuction[counter].auction_buynow_price|number_format:2}{/if}
																					 {if $dataAuction[counter].fk_auction_type_id=='3'}Starting Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>{if $dataAuction[counter].auction_reserve_offer_price > 0}Reserve Price:&nbsp;${$dataAuction[counter].auction_reserve_offer_price|number_format:2}{else}Reserve Not Meet{/if}{/if}
												</font></td>
												<td align="center" ><font style="font-size:12px; font-family:Arial;">{if $dataAuction[counter].fk_auction_type_id!='1'}Start Time&nbsp;{$dataAuction[counter].auction_actual_start_datetime|date_format:"%m-%d-%Y %H:%M:%S"}<br>End Time&nbsp;{$dataAuction[counter].auction_actual_end_datetime|date_format:"%m-%d-%Y %H:%M:%S"}{else}----{/if}</font></td>
												<td align="center"  ><font style="font-size:12px; font-family:Arial;">{if $dataAuction[counter].soldamnt!=''}${$dataAuction[counter].soldamnt}{else}----{/if}</font></td>
												<td align="center"  ><font style="font-size:12px; font-family:Arial;">
																					  {if $dataAuction[counter].fk_auction_type_id!='1'}
																					 {if $dataAuction[counter].auction_is_approved=='0' || ($dataAuction[counter].fk_auction_type_id==3 && $dataAuction[counter].is_approved_for_monthly_auction=='0') }
																					 Pending
																					 {elseif $dataAuction[counter].auction_is_approved=='2'}
																					 Disapproved
																					 {elseif $dataAuction[counter].auction_is_approved=='1' && $dataAuction[counter].auction_is_sold=='0' && $dataAuction[counter].auction_actual_start_datetime > $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Upcoming
																					 {elseif $dataAuction[counter].auction_is_approved=='1' && $dataAuction[counter].auction_is_sold=='0' && $dataAuction[counter].auction_actual_start_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" &&  $dataAuction[counter].auction_actual_end_datetime > $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Selling
																					 {elseif $dataAuction[counter].auction_is_approved=='1' && $dataAuction[counter].auction_is_sold=='0' && $dataAuction[counter].auction_actual_start_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" &&  $dataAuction[counter].auction_actual_end_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Expired & Unsold
																					 {elseif $dataAuction[counter].auction_is_sold=='1'}
																					 Sold
																					 {elseif $dataAuction[counter].auction_is_sold=='2'}
																					 Sold by Buy Now
																					 {/if}
																					 {/if}
																					 {if $dataAuction[counter].fk_auction_type_id=='1'}
																					 {if $dataAuction[counter].auction_is_sold=='1'}
																					 Sold
																					 {elseif $dataAuction[counter].auction_is_sold=='2'}
																					 Sold by Buy Now
																					 {elseif $dataAuction[counter].auction_is_approved=='0'}
																					 Pending
																					 {elseif $dataAuction[counter].auction_is_approved=='2'}
																					 Disapproved
																					 {elseif $dataAuction[counter].auction_is_approved=='1' && $dataAuction[counter].auction_is_sold=='0'}
																					 Selling
																					 {/if}
																					 {/if}
												</font></td>
												
											</tr>
										{/section}
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" valign="top">
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

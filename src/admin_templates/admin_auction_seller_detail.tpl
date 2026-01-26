{literal}
<script type="text/javascript" src="/javascript/jquery-1.4.2.js"></script>
<script type="text/javascript">
 function check_user(){
	if(document.getElementById('user_id').value==''){
		alert('Please select an seller to pay');
		return false;
	} 
	else{
		document.forms["listFrom"].submit();
	}
 }
 function printPage(){    
	$(".buyerCloumn").hide();
	javascript:window.print();
 }
</script>
<style type="text/css">
.printer{
font-family:Calibri;	
}
.print_data{
	font-size:12px; font-family:Arial;
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
                
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				
				{if $total>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="mode" value="complete_payment" />
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="96%" border="1" cellspacing="1" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000"  >
									<tbody>
										<tr>
											<td {if $smarty.request.auction_type!='weekly'}colspan="8"{else}colspan="7"{/if} align="center" class="printer"><b>MPE Report:{if $search=='' && $auction_type==''} All Posters {elseif $search=='' && $auction_type!=''} {$smarty.request.auction_type|lower|capitalize} {/if}{if $search!=''}{if $search=='yet_to_pay'} Total(s) to be Paid by MPE {elseif $search=='unpaid'}Total Unpaid by Buyer{elseif $search=='paid'} Total Payments to Seller(s){elseif $search=='paid_by_buyer'} Total Paid by Buyer(s) {else} {$search|lower|capitalize} Items{/if}  {/if}{if $start_date!=''}From {$start_date|date_format:"%m-%d-%Y"} To {$end_date|date_format:"%m-%d-%Y"}{/if}</b></td>
										</tr>
										
										
										<tr height="26" class="header_bgcolor">
											<th align="center" width="16%">Poster</td>
											<th align="center" width="12%">Seller</td>
											<th align="center" width="12%" class="buyerCloumn">Buyer</td>

											<th align="center" width="14%">Auction Type</td>
                                            {if $smarty.request.auction_type!='weekly'}
											<th align="center" width="15%">Auction Pricing</td>
                                            {/if}
											<th align="center" width="15%">Auction Timings</td>
											<th align="center" width="8%">Sold Price</td>
											{if $smarty.request.search=='yet_to_pay' || $smarty.request.search=='paid'}
												<th align="center"  width="15%">Charges</th>
												<th align="center"  width="15%">Discounts</th>
												<th align="center"  width="15%">Seller Owed</th>
											{/if}
											<th align="center" width="12%">Status</td>
											
										</tr>
										{assign var="oldInvoice" value=0}
										{section name=counter loop=$paidAuctionDetails}
											<tr >
												<td align="left"  width="20%" class="print_data">&nbsp;&nbsp;<img src="{$paidAuctionDetails[counter].image}" ><br/>
                                                   {*$smarty.section.counter.index*}{$paidAuctionDetails[counter].poster_title}(#{$paidAuctionDetails[counter].poster_sku})
												</td >
												
												<td align="center"  >{$paidAuctionDetails[counter].firstname}&nbsp;{$paidAuctionDetails[counter].lastname}</td>
												
												<td align="center"  class="buyerCloumn">{if $paidAuctionDetails[counter].winnerName<>''}{$paidAuctionDetails[counter].winnerName}{else}NA{/if}</td>
												<td align="center"  class="print_data">{if $paidAuctionDetails[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='3'}Monthly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='4'}Stills/Photos{elseif $paidAuctionDetails[counter].fk_auction_type_id=='5'}Stills/Photos Auction{/if}</td>
                                                {if $smarty.request.auction_type!='weekly'}
                                                <td align="center" class="print_data">{if $paidAuctionDetails[counter].fk_auction_type_id=='1' || $paidAuctionDetails[counter].fk_auction_type_id=='4'}Asking Price:&nbsp;${$paidAuctionDetails[counter].auction_asked_price|number_format:2}<br>Offer Price:&nbsp;${$paidAuctionDetails[counter].auction_reserve_offer_price|number_format:2}{/if}
																					 {if $paidAuctionDetails[counter].fk_auction_type_id=='2' || $paidAuctionDetails[counter].fk_auction_type_id=='5'}Starting Price:&nbsp;${$paidAuctionDetails[counter].auction_asked_price|number_format:2}<br>Buynow Price:&nbsp;${$paidAuctionDetails[counter].auction_buynow_price|number_format:2}{/if}
																					 {if $paidAuctionDetails[counter].fk_auction_type_id=='3'}Starting Price:&nbsp;${$paidAuctionDetails[counter].auction_asked_price|number_format:2}<br>{if $paidAuctionDetails[counter].auction_reserve_offer_price > 0}Reserve Price:&nbsp;${$paidAuctionDetails[counter].auction_reserve_offer_price|number_format:2}{else}Reserve Not Meet{/if}{/if}
												</td>
                                                {/if}
												<td align="center" class="print_data">{if $paidAuctionDetails[counter].fk_auction_type_id!='1' && $paidAuctionDetails[counter].fk_auction_type_id!='4'}Start Time&nbsp;{$paidAuctionDetails[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y %H:%M:%S"}<br>End Time&nbsp;{$paidAuctionDetails[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y %H:%M:%S"}{else}----{/if}</td>
												<td align="center" class="print_data">{if $paidAuctionDetails[counter].soldamnt!=''}${$paidAuctionDetails[counter].soldamnt}{else}----{/if}</td>
												{if $smarty.request.search=='yet_to_pay' || $smarty.request.search=='paid'}
												{if $oldInvoice!=$paidAuctionDetails[counter].invoice_id}
													<td align="center" class="smalltext">
													{assign var="subTotalDis" value=0}
													{section name=counterdiscount loop=$paidAuctionDetails[counter].discounts}
													{$paidAuctionDetails[counter].discounts[counterdiscount].description}:${$paidAuctionDetails[counter].discounts[counterdiscount].amount|number_format:2} <br/>
													{assign var="subTotalDis" value=$subTotalDis+$paidAuctionDetails[counter].discounts[counterdiscount].amount}
													{assign var="TotalDis" value=$TotalDis+$paidAuctionDetails[counter].discounts[counterdiscount].amount}
													
													{/section}
													
													</td>
													<td align="center" class="smalltext">
													{assign var="subTotalCharge" value=0}
													{section name=countercharge loop=$paidAuctionDetails[counter].additional_charges}
													{$paidAuctionDetails[counter].additional_charges[countercharge].description}:${$paidAuctionDetails[counter].additional_charges[countercharge].amount|number_format:2} <br/>
													{assign var="subTotalCharge" value=$subTotalCharge+$paidAuctionDetails[counter].additional_charges[countercharge].amount}
													{assign var="TotalCharge" value=$TotalCharge+$paidAuctionDetails[counter].additional_charges[countercharge].amount}
													{/section}
													
													</td>
												  {else}
												    {assign var="subTotalCharge" value=0}	
													{assign var="subTotalDis" value=0}
												     <td align="center" > -- </td>
													 <td align="center" > -- </td>
												  {/if}	
													<td align="center" class="smalltext">
													{assign var="soldamnt" value=$paidAuctionDetails[counter].soldamnt}
													{assign var="totalOwn" value=$subTotalCharge+$soldamnt}
													{assign var="sellerOwn" value=$totalOwn-$subTotalDis}
													${$sellerOwn|number_format:2}
													{*if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].seller_owned}{else}--{/if*}
													
													</td>
												 {/if}	
												<td align="center" class="print_data"> {if $paidAuctionDetails[counter].fk_auction_type_id!='1'}
																					 {if $paidAuctionDetails[counter].auction_is_approved=='0' || ($paidAuctionDetails[counter].fk_auction_type_id==3 && $paidAuctionDetails[counter].is_approved_for_monthly_auction=='0') }
																					 Pending
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='2'}
																					 Disapproved
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='1' && $paidAuctionDetails[counter].auction_is_sold=='0' && $paidAuctionDetails[counter].auction_actual_start_datetime > $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Upcoming
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='1' && $paidAuctionDetails[counter].auction_is_sold=='0' && $paidAuctionDetails[counter].auction_actual_start_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" &&  $paidAuctionDetails[counter].auction_actual_end_datetime > $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Selling
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='1' && $paidAuctionDetails[counter].auction_is_sold=='0' && $paidAuctionDetails[counter].auction_actual_start_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" &&  $paidAuctionDetails[counter].auction_actual_end_datetime < $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
																					 Expired & Unsold
																					 {elseif $paidAuctionDetails[counter].auction_is_sold=='1'}
																					 Sold
																					 {elseif $paidAuctionDetails[counter].auction_is_sold=='2'}
																					 Sold by Buy Now
																					 {/if}
																					 {/if}
																					 {if $paidAuctionDetails[counter].fk_auction_type_id=='1'}
																					 {if $paidAuctionDetails[counter].auction_is_sold=='1'}
																					 Sold
																					 {elseif $paidAuctionDetails[counter].auction_is_sold=='2'}
																					 Sold by Buy Now
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='0'}
																					 Pending
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='2'}
																					 Disapproved
																					 {elseif $paidAuctionDetails[counter].auction_is_approved=='1' && $paidAuctionDetails[counter].auction_is_sold=='0'}
																					 Selling
																					 {/if}
																					 {/if}</td>
												
											{assign var="oldInvoice" value=$paidAuctionDetails[counter].invoice_id}	
											
											</tr>
                                            {assign var="subTotal" value=$subTotal+$paidAuctionDetails[counter].soldamnt}
										{/section}
                                        {if $smarty.request.search=='sold'}
                                            <tr>
                                                <td colspan="7" align="right" class="print_data">Total Amount:</td>
                                                <td class="print_data">&nbsp;{if $subTotal > 0}&nbsp;${$subTotal|number_format:2}{/if}</td>
                                            </tr>
                                        {/if}
										{if $smarty.request.search=='yet_to_pay'}
										<tr>
										<td colspan="9" align="right" class="print_data">Total Payable From MPE to seller:</td>
										<td class="print_data" colspan="2" align="left">&nbsp;&nbsp;${assign var="totsoldamnt" value=$total_sold_price}
												{assign var="tottotalOwn" value=$TotalCharge+$totsoldamnt}
												{assign var="totsellerOwn" value=$tottotalOwn-$TotalDis}
												{$totsellerOwn|number_format:2}</td>
										</tr>
										{/if}
                                        {if $smarty.request.search=='paid_by_buyer'}
                                        <tr>
                                            <td colspan="7" align="right" class="print_data">Total Paid by Buyer:</td>
                                            <td class="print_data">&nbsp;{if $subTotal > 0}{if $subTotal > 0}&nbsp;${$subTotal|number_format:2}{/if}{/if}</td>
                                        </tr>
                                        {/if}
										{if $smarty.request.search=='paid'}
										<tr>
										<td {if $smarty.request.auction_type!='weekly'}colspan="9"{else}colspan="8"{/if} align="right" class="print_data">Total amount paid by MPE to seller:</td>
										<td colspan="2"  class="print_data">&nbsp;&nbsp;${assign var="totsoldamnt" value=$total_sold_price}
												{assign var="tottotalOwn" value=$TotalCharge+$totsoldamnt}
												{assign var="totsellerOwn" value=$tottotalOwn-$TotalDis}
												{$totsellerOwn|number_format:2}</td>
										</tr>
										{/if}
                                        {if $smarty.request.search=='unpaid'}
                                        <tr>
                                            <td {if $smarty.request.auction_type!='weekly'}colspan="7"{else}colspan="6"{/if} align="right" class="print_data">Total amount Unpaid by Buyer:</td>
                                            <td class="print_data">&nbsp;{if $subTotal > 0}&nbsp;${$subTotal|number_format:2}{/if}</td>
                                        </tr>
                                        {/if}
										<tr class="header_bgcolor" height="26">
										<td {if $smarty.request.auction_type!='weekly'}colspan="8"{else}colspan="7"{/if} align='center'><input type="button" value="print" onclick="printPage()"></td>
										</tr>
											
										
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no auction in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>

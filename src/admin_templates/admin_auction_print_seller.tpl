{include file="admin_header.tpl"}
<link rel="stylesheet" href="/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="/javascript/datepicker/jquery.datepick.js"></script>
{literal}
<script type="text/javascript">
 function check_user(){
	var pay_amnt=document.getElementById('pay_amnt').value; 

	//var chk_ind=/^ *.?[0-9]+ *$/.test(pay_amnt);
 	if(isNaN(pay_amnt)){
 		alert('Please enter proper numeric value');
		return false;
 	}else if(document.getElementById('user_id').value==''){
		alert('Please select an seller to pay');
		return false;
	}else if(document.getElementById('pay_amnt').value == 0){
		alert('Please select a valid amount');
		document.getElementById('pay_amnt').focus();
		return false;
	}else{
	    if(confirm("Are sure to Pay "+pay_amnt+ " to the seller." )){
			document.forms["listFrom"].submit();
		}
	}
 }
 $(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
	});
});
</script>
<style type="text/css">

.adminPrint{

	border-collapse:collapse;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}

.adminPrint tr th{
	border:1px solid #024552;
	background-color:#356d79;
	color:#FFFFFF;
}

.adminPrint tr td{
	border:1px solid #999999;
	
}

.adminPrint tr.odd_tr{
	background-color:#f4f4f4;
}

.adminPrint tr.totline{
	background-color:#356d79;
	color:#FFFFFF;
}

.adminPrint tr.payNow{
	background-color:#d8eaee;
	
}

input.button{
	border: 1px solid #000000;
	padding: 2px 3px 2px 3px;
    font-weight: normal;
    font-size: 11px;
    font-family: tahoma, verdana, arial, helvetica, sans-serif;
	color:#ffffff;
	background: #ffffff url(http://c4922595.r95.cf2.rackcdn.com/button_bg.gif) repeat-x;
	cursor: pointer;
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
				
				{if $total_yet_paid>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="mode" value="complete_payment" />
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="60%" cellspacing="1" cellpadding="2" class="adminPrint" >
									<tbody>
										
										{if $total_yet_paid >0}
										
										<tr height="26">
											<th align="center" width="16%">Poster</th>
											<th align="center" width="14%">Auction Type</th>
											<th align="center" width="15%">Sold Amount</th>
											<th align="center" width="15%">Charges</th>
											<th align="center" width="15%">Discounts</th>
											<th align="center" width="15%">Seller Owed</th>
										</tr>
										{assign var="oldInvoice" value=0}
										{section name=counter loop=$paidAuctionDetails}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left"  width="20%">&nbsp;&nbsp;<img src="{$paidAuctionDetails[counter].image}" ><br/>
												{$paidAuctionDetails[counter].poster_title}(#{$paidAuctionDetails[counter].poster_sku})
												<input type="hidden" name="auction_id[]" value="{$paidAuctionDetails[counter].auction_id}" />
												<input type="hidden" name="user_id" id="user_id" value="{$smarty.request.user_id}" />
												</td >
												
												<td align="center" >{if $paidAuctionDetails[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='3'}Monthly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='5'}Stills/Photo Auction{/if}</td>
												
												<td align="center" >{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].soldamnt}{else}--{/if}</td>
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
												     <td align="center" class="smalltext"> -- </td>
													 <td align="center" class="smalltext"> -- </td>
													{/if}
													<td align="center" class="smalltext">
														{assign var="soldamnt" value=$paidAuctionDetails[counter].soldamnt}
														{assign var="totalOwn" value=$subTotalCharge+$soldamnt}
														{assign var="sellerOwn" value=$totalOwn-$subTotalDis}
														${$sellerOwn|number_format:2}
														{*if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].seller_owned}{else}--{/if*}
													
													</td>
											{assign var="oldInvoice" value=$paidAuctionDetails[counter].invoice_id}		
											</tr>
											
										{/section}
										
										<tr class="totline" height="26">
												<td align="center" width="20%">&nbsp;&nbsp;
												<strong>Total</strong>
												</td >
												
												
												<td align="center" ></td>
												
												<td align="center">{if $total_sold_price > 0}${$total_sold_price}{else}--{/if}</td>
												<td align="center" class="headertext" >{if $TotalDis > 0}${$TotalDis|number_format:2}{else}--{/if}</td>
												<td align="center" class="headertext">{if $TotalCharge > 0}${$TotalCharge|number_format:2}{else}--{/if}</td>
												<td align="center" class="headertext">
												{assign var="totsoldamnt" value=$total_sold_price}
												{assign var="tottotalOwn" value=$TotalCharge+$totsoldamnt}
												{assign var="totsellerOwn" value=$tottotalOwn-$TotalDis}
												${$totsellerOwn|number_format:2}</td>
												
											</tr>
											{/if}
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>-->
<!--											<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>-->
<!--										</tr>-->
										<tr class="payNow" >
										    <td id='start_date_td'  style="padding:5px 0 0 0;" colspan="2" align="center" valign="top">Payment Date&nbsp;
											<input type="text" name="start_date" id="start_date" value="{$start_date_show}"  class="look required" /></td>
											<td align="center" colspan="5" class="bold_text" valign="top">
											$<input type="text" name="pay_amnt" id="pay_amnt" value="{$totsellerOwn|number_format:2}" />
                        					<input type="button" value="Pay Now" class="button" onclick="check_user()">&nbsp;&nbsp;&nbsp;
											
											</td>
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

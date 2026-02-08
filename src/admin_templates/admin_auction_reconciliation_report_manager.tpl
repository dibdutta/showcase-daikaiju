{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>
<!--<script type="text/javascript" src="{$actualPath}/javascript/formvalidation.js"></script>-->
<!--<script type="text/javascript" src="{$actualPath}/javascript/jquery.validate.js"></script>-->
{literal}
<script type="text/javascript">
$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

//function reset_date(){
//	$('#start_date')[0].reset;
//
//}

function reset_date(ele) {
    $(ele).find(':input').each(function() {
        switch(this.type) {
        	case 'text':
        	case 'select-one':	
                $(this).val('');
                break;    
            
        }
    });
    document.getElementById('auction_week').style.display="none";
}
function test(){
if(document.getElementById('start_date').value!=''){
	if(document.getElementById('end_date').value!=''){
		return true;
	}else{
		alert("Please select a end date");
		document.getElementById('end_date').focus();
		return false;
}
}	
}
function check_auction_type(val){
    if(val=='weekly'){
        document.getElementById('auction_week').style.display="block";
    }else{
        document.getElementById('auction_week').style.display="none";
		$("#auction_week").val('');
    }
	if(val=='stills'){
        document.getElementById('auction_stills').style.display="block";
    }else{
        document.getElementById('auction_stills').style.display="none";
		$("#auction_stills").val('');
    }
}
</script>
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
				<tr>
					<td width="100%">
					<form action="" method="get" name="search_criteria" id="search_criteria" onsubmit="return test();">
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2">							
							
							<tr>
								<td  class="bold_text" style="padding:5px 0 0 0;" align="right"   >
									
                                    	<input type="hidden" name="mode" value="auction_report" />
										Select : 
										</td>
										<td >
                                            <select name="search" class="look" id='search_id'  >
                                                
                                                <option value="reconciliation" {if $search == "reconciliation"} selected="selected"{/if} >Reconciliation</option>

                                            </select>
                                        <td>
                                        <td>
                                            <select name="auction_type" class="look" id='search_id' onchange="check_auction_type(this.value);"  >
                                                <option value="" selected="selected" >All</option>
                                                <option value="fixed" {if $auction_type == "fixed"} selected="selected"{/if} >Fixed</option>
                                                <option value="weekly" {if $auction_type == "weekly"} selected="selected"{/if} >Weekly</option>
                                                <option value="stills" {if $auction_type == "stills"} selected="selected"{/if} >Stills/Photos</option>
                                            </select>
                                        </td>
                                        <td>
										  <select name="auction_week"  class="look" id="auction_week" {if $auction_type!='weekly'}style="display: none;"{/if}>
                                            <option value="" selected="selected">All Auction</option>
											{section name=counter loop=$auctionWeek}
												<option value="{$auctionWeek[counter].auction_week_id}" {if $smarty.request.auction_week == $auctionWeek[counter].auction_week_id} selected {/if} >MPE Weekly Auction&nbsp;( {$auctionWeek[counter].auction_week_end_date|date_format:"%D"})</option>
											{/section}
                                         </select>
										 <select name="auction_stills"  class="look" id="auction_stills" {if $auction_type!='stills'}style="display: none;"{/if}>
                                            <option value="" selected="selected">All Stills Auction</option>
											{section name=counter loop=$auctionWeekStills}
												<option value="{$auctionWeekStills[counter].auction_week_id}" {if $smarty.request.auction_stills == $auctionWeekStills[counter].auction_week_id} selected {/if} >MPE Stills Auction&nbsp;( {$auctionWeekStills[counter].auction_week_end_date|date_format:"%D"})</option>
											{/section}
                                         </select>
     								    </td >
								<td class="bold_text" width="10%" align="right" style="padding:5px 0 0 0;"  valign="top" >Seller:&nbsp;</td>
								<td>
								<select name="user_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$userRow}
                                                    	{if $userRow[counter].user_id == $user_id}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
                                                        <option value="{$userRow[counter].user_id}" {$selected}>{$userRow[counter].firstname} &nbsp;{$userRow[counter].lastname}</option>
                                                        {assign var="selected" value=""}
                                                    {/section}
                                            	</select><br /><span class="err">{$user_id_err}</span></td>
                                 <td width="16%" valign="top">&nbsp;</td>
								
							</tr>
							<tr>
								<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date&nbsp;
								</td>
								<td>
								<input type="text" name="start_date" id="start_date" value="{$start_date_show}"  class="look required" /></td>
								<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date&nbsp;
								</td>
								<td>
								<input type="text" name="end_date" id="end_date" value="{$end_date_show}"  class="look required" /></td>
								
								<td width="16%" valign="top"><input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" ></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				{if $total>0}
					<tr>
						<td align="center">
							{if $nextParent <> ""}<div style="width: 96%; text-align: right;"><a href="{$adminActualPath}/admin_category_manager.php?parent_id={$nextParent}&language_id={$language_id}" class="new_link"><strong>&laquo; Back </strong></a></div>{/if}
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="60%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td  class="headertext" colspan="6">&nbsp;Sales Reconciliation Report</td >
											
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total poster:</td >
											<td colspan="3">&nbsp;{$total}&nbsp;{if $total > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$total}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td class="bold_text" colspan="3">Total sold:</td >
											<td colspan="3">&nbsp;{$total_sold}&nbsp;{if $total_amount_sold_by_mpe > 0}&nbsp;(${$total_amount_sold_by_mpe}) {/if}{if $total_sold > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" title="details" style="cursor: pointer;" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=sold&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Paid by Buyer:</td >
                                            <td colspan="3">&nbsp;{$total_paid_by_buyer}&nbsp;{if $total_amount_paid_by_buyer > 0}&nbsp;(${$total_amount_paid_by_buyer}) {/if}{if $total_paid_by_buyer > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid_by_buyer&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>


                                        </tr>
                                        <tr class="tr_bgcolor" height="26">
                                            <td  class="bold_text" colspan="3">Total Unpaid by Buyer:</td >
                                            <td colspan="3">&nbsp;{$total_unpaid}&nbsp;{if $total_amount_unpaid_by_buyer > 0}&nbsp;(${$total_amount_unpaid_by_buyer}){/if}{if $total_unpaid > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=unpaid&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>


                                        </tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Paid by MPE:</td >
											<td colspan="3">&nbsp;{$total_paid_by_admin}&nbsp;{if $total_amount_paid_by_admin > 0}(${$total_amount_paid_by_admin})&nbsp;{/if}{if $total_paid_by_admin > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" title="details" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=paid&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total to be Paid by MPE:</td >
										
											<td colspan="3">&nbsp;{$total_yet_paid}&nbsp;{if $total_yet_paid > 0}<span id="seller_own_amount"></span>{*if $total_own > 0}&nbsp;(${$total_own}){/if*}&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" title="View & Print" width="19" height="19" border="0" style="cursor: pointer;" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=yet_to_pay&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total Unsold:</td >
											<td colspan="3">&nbsp;{$total_unsold}&nbsp;{if $total_unsold > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=unsold&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										{*
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total selling:</td >
											<td colspan="3">&nbsp;{$total_selling}&nbsp;{if $total_selling > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=selling&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total pending:</td >
											<td colspan="3">&nbsp;{$total_pending}&nbsp;{if $total_pending > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=pending&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total reopened:</td >
											<td colspan="3">&nbsp;{$total_reopen}&nbsp;{if $total_reopen > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=reopen&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total upcoming:</td >
											<td colspan="3">&nbsp;{$total_upcoming}&nbsp;{if $total_upcoming > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="details" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=upcoming&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="3">Total unapproved:</td >
											<td colspan="3">&nbsp;{$total_unapproved}&nbsp;{if $total_unapproved > 0}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" class="iconViewAlign" width="19" height="19" border="0" style="cursor: pointer;" title="details" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=admin_auction_seller_detail&search=unapproved&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</td>
										</tr>
										*}
										{if $total_yet_paid >0 && $paidAuctionDetails|@count > 0}
										<tr class="header_bgcolor" height="26">
											<td class="headertext" colspan="6">&nbsp;Yet to pay auction details</td >
										</tr>
										
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="16%">Poster</td >
											<td align="center" class="headertext" width="14%">Auction Type</td>
											<td align="center" class="headertext" width="15%">Sold Amount</td>
											{*<td align="center" class="headertext" width="15%">MPE Commission<font style="font-size:8px;"><br/>(MPE charge + Merchant fee)</font></td>*}
											<td align="center" class="headertext" width="15%">Charges</td>
											<td align="center" class="headertext" width="15%">Discounts</td>
											<td align="center" class="headertext" width="15%">Seller Owed</td>
										</tr>
										{assign var="oldInvoice" value=0}
										{section name=counter loop=$paidAuctionDetails}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="{$paidAuctionDetails[counter].image}" ><br/>
												{$paidAuctionDetails[counter].poster_title}(#{$paidAuctionDetails[counter].poster_sku})
												</td >
												
												
												<td align="center" class="smalltext">{if $paidAuctionDetails[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='3'}Monthly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='5'}Stills/Photo Auction{/if}</td>
												
												<td align="center" class="smalltext">{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].soldamnt}{else}--{/if}</td>
												{*<td align="center" class="smalltext" >{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].mpe_charge} + ${$paidAuctionDetails[counter].trans_charge}{else}--{/if}</td>*}
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
										
										<tr class="header_bgcolor" height="26">
												<td align="center" class="headertext" width="20%">&nbsp;&nbsp;
												Total
												</td >
												
												
												<td align="center" class="smalltext"></td>
												
												<td align="center" class="headertext">{if $total_sold_price > 0}${$total_sold_price}{else}--{/if}</td>
												<td align="center" class="headertext" >{if $TotalDis > 0}${$TotalDis|number_format:2}{else}--{/if}</td>
												<td align="center" class="headertext">{if $TotalCharge > 0}${$TotalCharge|number_format:2}{else}--{/if}</td>
												<td align="center" class="headertext">
												{assign var="totsoldamnt" value=$total_sold_price}
												{assign var="tottotalOwn" value=$TotalCharge+$totsoldamnt}
												{assign var="totsellerOwn" value=$tottotalOwn-$TotalDis}
												${$totsellerOwn|number_format:2}<input type="hidden" name="seller_own" id="seller_own" value="{$totsellerOwn}" /></td>
											</tr>
											
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>-->
<!--											<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>-->
<!--										</tr>-->
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											{*<input type="button" value="View & Print" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=print_auction_report&search={$search}&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')">&nbsp;&nbsp;&nbsp;*}
                        					<input type="button" value="Pay Now" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=pay_now_seller&search=yet_to_pay&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$auction_week}&auction_stills={$auction_stills}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
										{/if}
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
{literal}
<script type="text/javascript">
var total_own=$("#seller_own").val();
if(total_own >0){
	var seller_own = "($"+total_own+")";
	$("#seller_own_amount").text(seller_own);
}

</script>
{/literal}
{include file="admin_footer.tpl"}
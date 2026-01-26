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
								<td width="10%" class="bold_text" style="padding:5px 0 0 0;" align="right"  valign="top" >
									
                                    	<input type="hidden" name="mode" value="auction_report" />
										Select : 
										</td>
										<td >
										<select name="search" class="look" id='search_id'  >
                                        	<option value="" selected="selected" >All</option>
                                        	<option value="fixed" {if $search == "fixed"} selected="selected"{/if} >Fixed</option>
                                        	<option value="weekly" {if $search == "weekly"} selected="selected"{/if} >Weekly</option>
                                        	<option value="monthly" {if $search == "monthly"} selected="selected"{/if} >Monthly</option>
											<option value="selling" {if $search == "selling"} selected="selected"{/if} >Selling</option>
                                            <option value="pending" {if $search == "pending"} selected="selected"{/if} >Pending</option>
                                            <option value="sold" {if $search == "sold"} selected="selected"{/if} >Sold</option>
                                            <option value="upcoming" {if $search == "upcoming"} selected="selected"{/if} >Upcoming</option>
                                            <option value="unsold" {if $search == "unsold"} selected="selected"{/if} >Expired & UnSold </option>
                                            <option value="reopen" {if $search == "reopen"} selected="selected"{/if} >Reopen</option>
                                            <option value="reconciliation" {if $search == "reconciliation"} selected="selected"{/if} >Reconciliation</option>
											
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									
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
								<input type="text" name="start_date" id="start_date" value="{$start_date}"  class="look required" /></td>
								<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date&nbsp;
								</td>
								<td>
								<input type="text" name="end_date" id="end_date" value="{$end_date}"  class="look required" /></td>
								
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
											<td  class="headertext" colspan="5">&nbsp;Reconciliation&nbsp;report</td >
											
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total poster:</td >
											<td colspan="3">&nbsp;{$total}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td class="bold_text" colspan="2">Total sold:</td >
											<td colspan="3">&nbsp;{$total_sold}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total paid:</td >
											<td colspan="3">&nbsp;{$total_paid}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total unpaid:</td >
											<td colspan="3">&nbsp;{$total_unpaid}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total selling:</td >
											<td colspan="3">&nbsp;{$total_selling}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total pending:</td >
											<td colspan="3">&nbsp;{$total_pending}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total expired and unsold:</td >
											<td colspan="3">&nbsp;{$total_unsold}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total reopened:</td >
											<td colspan="3">&nbsp;{$total_reopen}</td>
										</tr>
										<tr class="tr_bgcolor" height="26">
											<td  class="bold_text" colspan="2">Total upcoming:</td >
											<td colspan="3">&nbsp;{$total_upcoming}</td>
										</tr>
										{if $total_paid >0}
										<tr class="header_bgcolor" height="26">
											<td class="headertext" colspan="5">&nbsp;Payment Details</td >
										</tr>
										
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="16%">Poster</td >
											<td align="center" class="headertext" width="14%">Auction Type</td>
											<td align="center" class="headertext" width="15%">Sold Amount</td>
											<td align="center" class="headertext" width="15%">MPE Commission<font style="font-size:8px;"><br/>(MPE charge + transaction fee)</font></td>
											<td align="center" class="headertext" width="15%">Seller Owned</td>
										</tr>
										{section name=counter loop=$paidAuctionDetails}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="{$actualPath}/poster_photo/thumbnail/{$paidAuctionDetails[counter].poster_thumb}" ><br/>
												{$paidAuctionDetails[counter].poster_title}(#{$paidAuctionDetails[counter].poster_sku})
												</td >
												
												
												<td align="center" class="smalltext">{if $paidAuctionDetails[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $paidAuctionDetails[counter].fk_auction_type_id=='3'}Monthly Auction{/if}</td>
												
												<td align="center" class="smalltext">{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].soldamnt}{else}--{/if}</td>
												<td align="center" class="smalltext" >{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].mpe_charge} + ${$paidAuctionDetails[counter].trans_charge}{else}--{/if}</td>
												<td align="center" class="smalltext">{if $paidAuctionDetails[counter].soldamnt > 0}${$paidAuctionDetails[counter].seller_owned}{else}--{/if}</td>
												
											</tr>
											
										{/section}
										
										<tr class="header_bgcolor" height="26">
												<td align="center" class="headertext" width="20%">&nbsp;&nbsp;
												Total
												</td >
												
												
												<td align="center" class="smalltext"></td>
												
												<td align="center" class="headertext">{if $total_sold_price > 0}${$total_sold_price}{else}--{/if}</td>
												<td align="center" class="headertext" >{if $total_fee > 0}${$total_fee}{else}--{/if}</td>
												<td align="center" class="headertext">{if $total_own > 0}${$total_own}{else}--{/if}</td>
												
											</tr>
											{/if}
<!--										<tr class="header_bgcolor" height="26">-->
<!--											<td align="left" class="smalltext" colspan="2">&nbsp;</td>-->
<!--											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>-->
<!--											<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>-->
<!--										</tr>-->
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											<input type="button" value="View & Print" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=print_auction_report&search={$search}&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=500,height=300,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
                        					
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
{include file="admin_footer.tpl"}
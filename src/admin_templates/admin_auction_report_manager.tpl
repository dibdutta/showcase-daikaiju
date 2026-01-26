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
                                            <option value="unapproved" {if $search == "unapproved"} selected="selected"{/if} >Unapproved</option>
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
                                 <td width="16%" valign="top">Sort By:
                                 <select name="sort" class="look" id='search_id' onChange="this.form.submit();">
<!--                                        	<option value="USERNAME" selected="selected" >Message To</option>-->
                                        	
                                        	<option value="auction_id" {if $sort == "auction_id"}selected="selected"{/if} >Auction Wise</option>
                                        	<option value="poster_title" {if $sort == "poster_title"} selected="selected" {/if}>Poster Title</option>
                                        	<option value="auction_actual_start_datetime" {if $sort == "auction_actual_start_datetime"} selected="selected" {/if}>Auction Start Time</option>
                                        	<option value="auction_actual_end_datetime" {if $sort == "auction_actual_end_datetime"} selected="selected" {/if}>Auction End Time</option>
<!--                                        	<option value="monthly" {if $search == "monthly"} selected="selected"{/if} >Monthly</option>-->
								</select></td>
								
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
								<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<td align="center" class="headertext" width="16%">Poster</td >
											<td align="center" class="headertext" width="12%">Seller</td>
											<td align="center" class="headertext" width="12%">Buyer</td >
											<td align="center" class="headertext" width="14%">Auction Type</td>
											<td align="center" class="headertext" width="15%">Auction Pricing</td>
											<td align="center" class="headertext" width="15%">Auction Timings</td>
											<td align="center" class="headertext" width="8%">Sold Price</td>
											<td align="center" class="headertext" width="12%">Status</td >
										</tr>
										{section name=counter loop=$dataAuction}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="left" class="smalltext" width="20%">&nbsp;&nbsp;<img src="{$dataAuction[counter].image_path}" ><br/>
												{$dataAuction[counter].poster_title}(#{$dataAuction[counter].poster_sku})
												</td >
												<td align="center" class="smalltext">{$dataAuction[counter].firstname}&nbsp;{$dataAuction[counter].lastname}</td>
												<td align="center" class="smalltext">{if $dataAuction[counter].winnerName<>''}{$dataAuction[counter].winnerName}{else}NA{/if}</td>
												<td align="center" class="smalltext">{if $dataAuction[counter].fk_auction_type_id=='1'}Fixed Price Auction{elseif $dataAuction[counter].fk_auction_type_id=='2'}Weekly Auction{elseif $dataAuction[counter].fk_auction_type_id=='3'}Monthly Auction{/if}</td>
												<td align="center" class="smalltext">{if $dataAuction[counter].fk_auction_type_id=='1'}Asking Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>{if $dataAuction[counter].auction_reserve_offer_price > 0}Will consider offers{/if} {/if}
																					 {if $dataAuction[counter].fk_auction_type_id=='2'}Starting Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>Buynow Price:&nbsp;${$dataAuction[counter].auction_buynow_price|number_format:2}{/if}
																					 {if $dataAuction[counter].fk_auction_type_id=='3'}Starting Price:&nbsp;${$dataAuction[counter].auction_asked_price|number_format:2}<br>{if $dataAuction[counter].auction_reserve_offer_price > 0}Reserve Price:&nbsp;${$dataAuction[counter].auction_reserve_offer_price|number_format:2}{else}Reserve Not Meet{/if}{/if}
												</td>
												<td align="center" class="smalltext">{if $dataAuction[counter].fk_auction_type_id!='1'}Start Time&nbsp;{$dataAuction[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y %H:%M:%S"}<br>End Time&nbsp;{$dataAuction[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y %H:%M:%S"}{else}----{/if}</td>
												<td align="center" class="smalltext" >{if $dataAuction[counter].soldamnt!=''}${$dataAuction[counter].soldamnt}{else}----{/if}</td>
												<td align="center" class="smalltext" >
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
																					 
												</td>
												
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<td align="left" class="smalltext" colspan="2">&nbsp;</td>
											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} colspan="3" {else} colspan="3"{/if}>{$pageCounterTXT}</td>
											<td align="right" class="headertext" colspan="3">{$displayCounterTXT}</td>
										</tr>
										<tr class="tr_bgcolor" >
											<td align="center" colspan="8" class="bold_text" valign="top">
											<input type="button" value="View & Print" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=print_auction_report&search={$search}&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&offset={$offset}&toshow={$toshow}&sort={$sort}','mywindow','menubar=1,resizable=1,width=500,height=300,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
                        					
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
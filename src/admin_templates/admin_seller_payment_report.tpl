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
		if(document.getElementById('user_id').value==''){
			alert("Please select a seller");
			return false;	
		}
		else if(document.getElementById('start_date').value!=''){
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
						<input type="hidden" name="mode" value="auction_payment_report" />
						<table align="center" width="96%" border="0" cellspacing="1" cellpadding="2">							
							<tr>
								
										
								<td class="bold_text" width="10%" align="right" style="padding:5px 0 0 0;"  valign="top" >Seller:&nbsp;</td>
								<td>
								<select name="user_id" id="user_id" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    {section name=counter loop=$userRow}
                                                    	{if $userRow[counter].user_id == $user_id}
                                                            {assign var="selected" value="selected"}
                                                        {/if}
                                                        <option value="{$userRow[counter].user_id}" {$selected}>{$userRow[counter].firstname} &nbsp;{$userRow[counter].lastname}</option>
                                                        {assign var="selected" value=""}
                                                    {/section}
                                            	</select><br /><span class="err">{$user_id_err}</span></td>
							
								<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date&nbsp;
								</td>
								<td>
								<input type="text" name="start_date" id="start_date" value="{$start_date_show}"  class="look required" /></td>
								<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date&nbsp;
								</td>
								<td>
								<input type="text" name="end_date" id="end_date" value="{$end_date_show}"  class="look required" /></td>
								
								<td width="16%" valign="top"><input type="submit" name="search" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" ></td>
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
											<td align="center" class="headertext" width="16%">Paid Amount</td >
											<td align="center" class="headertext" width="12%">Date</td>
											
										</tr>
										{section name=counter loop=$dataPayment}
											<tr class="{cycle values="odd_tr,even_tr"}">
												<td align="center" class="smalltext">${$dataPayment[counter].payment_amount}</td>
												<td align="center" class="smalltext">{$dataPayment[counter].payment_date|date_format}</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											
											<td align="left" class="headertext" {if $smarty.const.MULTIUSER_ADMIN == 1 and $smarty.session.superAdmin == 1} {else} {/if}>{$pageCounterTXT}</td>
											<td align="right" class="headertext" >{$displayCounterTXT}</td>
										</tr>
										<tr class="tr_bgcolor" >
											<td align="center" colspan="2" class="bold_text" valign="top">
											<input type="button" value="View & Print" class="button" onclick="javascript:window.open('{$smarty.const.ADMIN_PAGE_LINK}/admin_report_manager.php?mode=print_seller_payment_report&user_id={$user_id}&start_date={$start_date}&end_date={$end_date}&offset={$offset}&toshow={$toshow}','mywindow','menubar=1,resizable=1,width=500,height=300,scrollbars=yes')">&nbsp;&nbsp;&nbsp;
                        					
											</td>
										</tr>
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				{else}
				{if $key!=0}
					<tr>
						<td align="center" class="err">There is no payment made to this seller.</td>
					</tr>
				{/if}
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
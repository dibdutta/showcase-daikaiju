{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/formvalidation.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/jquery.validate.js"></script>

{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#frm_add_event").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

function myFunction(){
	check = $("#is_test").is(":checked");
	var auction_week_id=$("#auction_week_id").val();
    if(check) {
        $.get("admin_manage_auction_week.php?mode=update_auction_status", { auction_week_id: auction_week_id, val: '1'},
		function(data){
			alert('Auction is successfully shifted to hidden mode')
		});
    } else {
        $.get("admin_manage_auction_week.php?mode=update_auction_status", { auction_week_id: auction_week_id, val: '0'},
		function(data){
			alert('Auction is successfully shifted to live mode')
		});
    }
}

</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
	<tr>
		<td width="100%" align="center">
			<form name="frm_add_event" id="frm_add_event" method="post" action="">
				<input type="hidden" name="mode" value="update_auction_week" />
                <input type="hidden" name="auction_week_id" id="auction_week_id" value="{$auction_week[0].auction_week_id}" />
				<input type="hidden" name="encoded_string" value="{$encoded_string}" />
				<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Edit Event</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top" width="25%"><span class="err">*</span> Start Date : </td>
						<td><input type="text" name="start_date" id="start_date" value="{$auction_week[0].start_date}" class="look required" />
                         <!--<div class="list-err">{$start_date_err}</div>-->
                         <br /><span class="err" id="start_date_err">{$start_date_err}</span>
                         </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> End Date : </td>
						<td><input type="text" 1 name="end_date" id="end_date" value="{$auction_week[0].end_date}" class="look required" />
                       <!-- <div class="list-err">{$end_date_err}</div>-->
                       <br /><span class="err" id="end_date_err">{$end_date_err}</span>
                       </td>
					</tr>
					<tr class="tr_bgcolor">
												<td class="bold" valign="top">&nbsp;&nbsp;Start Time :</td>
												<td class="smalltext">
                                                
                                                    <select name="auction_start_hour" size="1" tabindex="7" class="look">
                                                        {section name=foo start=0 loop=12 step=1}
                                                            {if $smarty.section.foo.index < 10}
                                                                {assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                            {else}
                                                                {assign var=hour value=$smarty.section.foo.index}
                                                            {/if}
                                                            <option value="{$hour}" {if $auction_week[0].auction_start_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                        {/section}
                                                    </select>(Hour) :                                            
                                                    <select name="auction_start_min" size="1" tabindex="8" class="look">
                                                        <option value="00" {if $auction_week[0].auction_start_min=='00'}selected{/if}>00</option>
                                                        {section name=foo start=15 loop=60 step=15}
                                                            <option value="{$smarty.section.foo.index}" {if $auction_week[0].auction_start_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                        {/section}
                                                    </select>(Min)
                                                    <select name="auction_start_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" {if $auction_week[0].auction_start_am_pm=='am'}selected{/if}>AM</option>
                                                        <option value="pm" {if $auction_week[0].auction_start_am_pm=='pm'}selected{/if}>PM</option>
                                                    </select>
                                                
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="text" valign="top">&nbsp;&nbsp;End Time :</td>
												<td class="smalltext">
                                                    <select name="auction_end_hour" size="1" tabindex="7" class="look">
                                                        {section name=foo start=0 loop=12 step=1}
                                                        {if $smarty.section.foo.index < 10}
                                                            {assign var=hour value="0"|cat:$smarty.section.foo.index}
                                                        {else}
                                                            {assign var=hour value=$smarty.section.foo.index}
                                                        {/if}
                                                        <option value="{$hour}" {if $auction_week[0].auction_end_hour==$smarty.section.foo.index}selected{/if}>{$hour}</option>
                                                        {/section}
                                                    </select>(Hour) :                                            
                                                    <select name="auction_end_min" size="1" tabindex="8" class="look">
                                                        <option value="00" {if $auction_week[0].auction_end_min=='00'}selected{/if}>00</option>
                                                        {section name=foo start=15 loop=60 step=15}
                                                            <option value="{$smarty.section.foo.index}" {if $auction_week[0].auction_end_min==$smarty.section.foo.index}selected{/if}>{$smarty.section.foo.index}</option>
                                                        {/section}
                                                    </select>(Min)
                                                    <select name="auction_end_am_pm" size="1" tabindex="9" class="look">
                                                        <option value="am" {if $auction_week[0].auction_end_am_pm=='am'}selected{/if}>AM</option>
                                                        <option value="pm" {if $auction_week[0].auction_end_am_pm=='pm'}selected{/if}>PM</option>
                                                    </select>
                                              
                                                </td>
											</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Auction Week Tilte: </td>
						<td><input type="text" size="45" name="event_title" id="event_title" value="{$auction_week[0].auction_week_title}" class="look required" /> 
						<!--<div class="list-err">{$event_title}</div>-->
                        <br /><span class="err" id="event_title">{$event_title_err}</span>
                        </td>
					</tr>
					<tr class="tr_bgcolor">
                        <td valign="top">&nbsp;</td>
                        <td><input type="checkbox" size="45" name="is_still"  value="1" {if $auction_week[0].is_stills==1}checked="checked" {/if}  />
                            &nbsp;Auction For Stills/Photos
                        </td>
                    </tr>
                    <tr class="tr_bgcolor">
                        <td valign="top">Hide Auction From Front End</td>
                        <td><input type="checkbox" size="45" name="is_test"  value="1" {if $auction_week[0].is_test==1}checked="checked" {/if} id="is_test" onchange="myFunction()"  />
                            &nbsp;
                        </td>
                    </tr>
					<tr class="tr_bgcolor">
						<td align="center" colspan="2" class="bold_text" valign="top">
						<input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;
						<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='{$decoded_string}'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
	

{include file="admin_header.tpl"}
{literal}
<script type="text/javascript">
    function combine_buyer_invoice(id){
        var allVals = [];
        var newVals=$("#"+id).val();
        var mySplitResult = newVals.split(",");
        for(i = 0; i < mySplitResult.length; i++){
            allVals.push(mySplitResult[i]);
        }
        var totalInv=allVals.length;
        if(totalInv >1){
            //alert(allVals);
            if(confirm("Are you sure to combine invoices for buyer!")){

                $.get("admin_manage_auction_week.php", { mode:"combine_buyer_invoice","auction_id[]": allVals},
                        function(data) {
                            if(data=='1'){
                                alert("Successfully invoices are combined");
								window.location.reload();
                            }else{
                                alert("invoices are not combined");
                            }
                        });

            }
        }else{
            alert("Please select atleast two invoices to combine.");

        }
    }
    function mark_shipped_buyer_invoice(id)
    {
        if(confirm("Are you sure to mark invoices as shipped!")){

            $.get("admin_manage_auction_week.php", { mode:"mark_shipped_buyer_invoice","invoice_id": id},
                    function(data) {
                        if(data=='1'){
                            alert("Successfully invoice(s) are marked as shipped.");
                        }else{
                            alert("Invoices are not marked as shipped.");
                        }
                    });

        }

    }
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
{if $errorMessage<>""}
<tr id="errorMessage">
    <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
</tr>
{/if}
<tr>
    <td align="center">{if $is_stills==0}<a href="{$adminActualPath}/admin_manage_auction_week.php?mode=create_new_weekly_auction&week_id={$week_id}&encoded_string={$encoded_string}" class="action_link">{else}
	<a href="{$adminActualPath}/admin_auction_manager.php?mode=create_stills_auction&week_id={$week_id}&encoded_string={$encoded_string}" class="action_link">
	{/if}<strong>Add Consignment Item</strong></a>&nbsp;<a href="{$adminActualPath}/admin_manage_auction_week.php" class="action_link"><strong>&lt; &lt; Back to Auction Week Manager</strong></a></td>
</tr>
{if $is_stills==0}
<tr  class="header_bgcolor" height="26" >
    <td class="headertext" colspan="5" >&nbsp;All Upcoming ({if $total_pending> 0}{$total_pending}{else} 0 {/if})</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>

{if $total_pending>0}
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Starting Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}<td align="center" class="headertext" width="8%">Status</td>{/if}
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    {section name=counter loop=$auctionRows_pending}
                    <tr id="tr_{$auctionRows_pending[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="{$auctionRows_pending[counter].image_path}" height="78" width="100" /><br />{$auctionRows_pending[counter].poster_title}<br /><b>SKU: </b>{$auctionRows_pending[counter].poster_sku}</td>
                        <td align="center" class="smalltext">${$auctionRows_pending[counter].auction_asked_price|number_format:2}</td>
                        <td align="center" class="smalltext">{$auctionWeekTitle}</td>
                        {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}
                            <td id="td_{$auctionRows_pending[counter].auction_id}" align="center" class="smalltext">
                                {if $auctionRows_pending[counter].auction_is_approved == 0 && $auctionRows_pending[counter].is_approved_for_monthly_auction == 0}
                                    <img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction({$auctionRows_pending[counter].auction_id}, 1, '{$smarty.request.search}', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction({$auctionRows_pending[counter].auction_id}, 2, '{$smarty.request.search}', 'monthly');" title="Disapprove" class="changeStatus" />
                                    {elseif $auctionRows_pending[counter].auction_is_approved == 1 }

                                    Approved
                                    {elseif $auctionRows_pending[counter].auction_is_approved == 2}
                                    Disapproved
                                {/if}
                            </td>
                        {/if}
                        <td align="center" class="bold_text">

                            <a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_weekly&auction_id={$auctionRows_pending[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

							
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            
                            {if $search == 'sold'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows_pending[counter].auction_id}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unpaid' && $auctionRows_pending[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_pending[counter].auction_id}&encoded_string={$encoded_string}">Reopen Auction</a>
                                {elseif $search == 'unpaid' && $auctionRows_pending[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_pending[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unsold' && $auctionRows_pending[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_pending[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                {elseif $search == 'unsold' && $auctionRows_pending[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_pending[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                        </td>
                    </tr>
                    {/section}
                {*
             <tr class="header_bgcolor" height="26">
                 <!--<td align="left" class="smalltext">&nbsp;</td>-->
                 <td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
                 <td align="right" {if $smarty.request.mode == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
             </tr>
                *}
                </tbody>
            </table>

        </form>
    </td>
</tr>
    {else}
<tr>
    <td align="center" class="err">There is no  Pending auctions for this weekly auction.</td>
</tr>
{/if}
{/if}
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Active Selling ({if $total_selling> 0}{$total_selling}{else}0{/if})</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
{if $total_selling>0}
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Starting Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}<td align="center" class="headertext" width="8%">Status</td>{/if}
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    {section name=counter loop=$auctionRows_selling}
                    <tr id="tr_{$auctionRows_selling[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="{$auctionRows_selling[counter].image_path}" height="78" width="100" /><br />{$auctionRows_selling[counter].poster_title}<br /><b>SKU: </b>{$auctionRows_selling[counter].poster_sku}</td>
                        <td align="center" class="smalltext">${$auctionRows_selling[counter].auction_asked_price|number_format:2}</td>
                        <td align="center" class="smalltext">{$auctionWeekTitle}</td>
                        {if $search == '' || $search == 'pending' || $search == 'waiting_receive'}
                            <td id="td_{$auctionRows_selling[counter].auction_id}" align="center" class="smalltext">
                                {if $auctionRows_selling[counter].auction_is_approved == 0 && $auctionRows_selling[counter].is_approved_for_monthly_auction == 0}
                                    <img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction({$auctionRows_selling[counter].auction_id}, 1, '{$smarty.request.search}', 'monthly');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction({$auctionRows_selling[counter].auction_id}, 2, '{$smarty.request.search}', 'monthly');" title="Disapprove" class="changeStatus" />
                                    {elseif $auctionRows_selling[counter].auction_is_approved == 1 }

                                    Approved
                                    {elseif $auctionRows_selling[counter].auction_is_approved == 2}
                                    Disapproved
                                {/if}
                            </td>
                        {/if}
                        <td align="center" class="bold_text">

                            {if $is_stills==0}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_weekly&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{else}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_stills_auction&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{/if}
							
							<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_weekly&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_details&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            {if $search == 'sold'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows_selling[counter].auction_id}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unpaid' && $auctionRows_selling[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}">Reopen Auction</a>
                                {elseif $search == 'unpaid' && $auctionRows_selling[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_selling[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unsold' && $auctionRows_selling[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_selling[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                {elseif $search == 'unsold' && $auctionRows_selling[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_selling[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                        </td>
                    </tr>
                    {/section}
                {*
                <tr class="header_bgcolor" height="26">
                    <!--<td align="left" class="smalltext">&nbsp;</td>-->
                    <td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
                    <td align="right" {if $smarty.request.mode == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
                </tr>*}
                </tbody>
            </table>

        </form>
    </td>
</tr>
    {else}
<tr>
    <td align="center" class="err">There is no active selling for this weekly auction.</td>
</tr>
{/if}
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Sold ({if $total_sold> 0}{$total_sold}{else}0{/if})</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
{if $total_sold > 0}
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Sold Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    <td align="center" class="headertext" width="14%">Sold Date</td>
                    <td align="center" class="headertext" width="14%">Status</td>
                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>
                    {assign var="user_id" value=""}

                    {section name=counter loop=$auctionRows_sold}

                    <tr height="50">
                        {if $user_id !=$auctionRows_sold[counter].user_id}

                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)"><b>Buyer:</b> {$auctionRows_sold[counter].firstname}&nbsp;{$auctionRows_sold[counter].lastname}</td>
                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)"><b>Total Poster:</b> {$auctionRows_sold[counter].tot_poster}</td>
                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)" colspan="2"><b>Price:</b> ${$auctionRows_sold[counter].tot_amount|number_format:2}</td>
                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)" colspan="2"><b>More Action:</b>&nbsp;<input type="hidden" name="auction_id[]" id="auction_id_{$auctionRows_sold[counter].user_id}" value="{$auctionRows_sold[counter].tot_auction}">
                            {*if $auctionRows_sold[counter].is_combined=='0' && $auctionRows_sold[counter].is_approved=='0' && $auctionRows_sold[counter].is_paid=='0'*}
                                {if $auctionRows_sold[counter].is_combined=='0' }
                                    <a href="javascript:void(0);" onclick="combine_buyer_invoice('auction_id_{$auctionRows_sold[counter].user_id}')">combine</a>
                                {/if}
                                {if $auctionRows_sold[counter].is_paid=='1' && $auctionRows_sold[counter].is_shipped=='0'}
                                    <a href="javascript:void(0);" onclick="mark_shipped_buyer_invoice('{$auctionRows_sold[counter].invoice_id}')">Mark as shipped</a>
                                {/if}
                            </td>
                        {/if}

                    </tr>
                    <tr id="tr_{$auctionRows_sold[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="{$auctionRows_sold[counter].image_path}" height="78" width="100" /><br />{$auctionRows_sold[counter].poster_title}<br /><b>SKU: </b>{$auctionRows_sold[counter].poster_sku}</td>
                        <td align="center" class="smalltext">${$auctionRows_sold[counter].amount|number_format:2}</td>
                        <td align="center" class="smalltext">{$auctionWeekTitle}</td>
                        <td align="center" class="smalltext">{$auctionRows_sold[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                        <td>&nbsp;
                            {if $auctionRows_sold[counter].is_combined=='1'}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}combined.png" alt="Combined" title="Combined">
                                {else}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_combined.png" alt="Combined" title="Not Combined">
                            {/if}
                            &nbsp;
                            {if $auctionRows_sold[counter].is_approved=='1' || $auctionRows_sold[counter].is_paid=='1'}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}approved.png" alt="Combined" title="Approved">
                                {else}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_approved.png" alt="Combined" title="Not Approved">
                            {/if}
                            &nbsp;
                            {if $auctionRows_sold[counter].is_paid=='1'}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}paid.png" alt="Combined" title="Paid on {$auctionRows_sold[counter].paid_on|date_format:"%m/%d/%Y"}">
                                {else}
                                	<img src="{$smarty.const.CLOUD_STATIC_ADMIN}unpaid.png" alt="Combined" title="Not Paid">
								{if $is_stills==0}
                            		<a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_weekly&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
								{else}
									<a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_stills&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
								{/if}<img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg"></a>
                            {/if}
                            &nbsp;
                            {if $auctionRows_sold[counter].is_shipped=='1'}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}shipped.png" alt="Combined" title="Shipped on {$auctionRows_sold[counter].shipped_date|date_format:"%m/%d/%Y"}">
                                {else}
                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_shipped.png" alt="Combined" title="Not Shipped">
                            {/if}
                        </td>
                        <td align="center" class="bold_text">

                             {if $is_stills==0}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_weekly&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{else}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_stills_auction&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{/if}<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_weekly&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_details&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            {if $search == 'sold'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows_sold[counter].auction_id}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unpaid' && $auctionRows_sold[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}">Reopen Auction</a>
                                {elseif $search == 'unpaid' && $auctionRows_sold[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_sold[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unsold' && $auctionRows_sold[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                {elseif $search == 'unsold' && $auctionRows_sold[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_sold[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                        </td>
                    </tr>
                        {assign var="user_id" value=$auctionRows_sold[counter].user_id}
                    {/section}

                <tr class="header_bgcolor" height="26">
                    <!--<td align="left" class="smalltext">&nbsp;</td>-->
                    <td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
                    <td align="right" {if $smarty.request.mode == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
                </tr>
                </tbody>
            </table>

        </form>
    </td>
</tr>
    {else}
<tr>
    <td align="center" class="err">There is no sold for this weekly auction.</td>
</tr>
{/if}
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
<tr  class="header_bgcolor" height="26">
    <td class="headertext" colspan="5">&nbsp;Unsold ({if $total_unsold> 0}{$total_unsold}{else}0{/if})</td>
</tr>
<tr  height="26">
    <td class="headertext">&nbsp;</td>
</tr>
{if $total_unsold > 0}
<tr>
    <td align="center">
        <div id="messageBox" class="messageBox" style="display:none;"></div>
        <form name="listFrom" id="listForm" action="" method="post">
            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tbody>

                <tr class="header_bgcolor" height="26">
                    <!--<td align="center" class="headertext" width="6%"></td>-->
                    <td align="center" class="headertext" width="15%">Poster</td>
                    <td align="center" class="headertext" width="15%">Start Price</td>
                    <td align="center" class="headertext" width="14%">Auction Week</td>
                    <td align="center" class="headertext" width="14%">End Date</td>

                    <td align="center" class="headertext" width="10%">Action</td>
                </tr>


                    {section name=counter loop=$auctionRows_unsold}

                    <tr id="tr_{$auctionRows_unsold[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                        <td align="center" class="smalltext"><img src="{$auctionRows_unsold[counter].image_path}" height="78" width="100" /><br />{$auctionRows_unsold[counter].poster_title}<br /><b>SKU: </b>{$auctionRows_unsold[counter].poster_sku}</td>
                        <td align="center" class="smalltext">${$auctionRows_unsold[counter].auction_asked_price|number_format:2}</td>
                        <td align="center" class="smalltext">{$auctionWeekTitle}</td>
                        <td align="center" class="smalltext">{$auctionRows_unsold[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</td>
                        <td align="center" class="bold_text">

                           {if $is_stills==0}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_weekly&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{else}
								<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_stills_auction&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{/if}
						   <img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update Poster" title="Update Poster" border="0" class="changeStatus" /></a>

                            <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_weekly&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a>
                            <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Poster" title="Delete Poster" border="0" class="changeStatus" /></a>-->

                            &nbsp;&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_details&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>
                            {if $search == 'sold'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows_unsold[counter].auction_id}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unpaid' && $auctionRows_unsold[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}">Reopen Auction</a>
                                {elseif $search == 'unpaid' && $auctionRows_unsold[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_unsold[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $search == 'unsold' && $auctionRows_unsold[counter].reopen_auction_id=='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_monthly&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
                                {elseif $search == 'unsold' && $auctionRows_unsold[counter].reopen_auction_id!='0'}
                                <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows_unsold[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
                            {/if}
                            {if $is_stills==0}
                            <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_weekly&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{else}
							<a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_stills&auction_id={$auctionRows_unsold[counter].auction_id}&encoded_string={$encoded_string}" class="view_link">
							{/if}<img width="20px" border="0" align="absmiddle" class="changeStatus" title="Reopen Auction" alt="Reopen Auction" src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg"></a>
                        </td>
                    </tr>

                    {/section}
                {*
                <tr class="header_bgcolor" height="26">
                    <!--<td align="left" class="smalltext">&nbsp;</td>-->
                    <td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
                    <td align="right" {if $smarty.request.mode == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
                </tr>
                *}
                </tbody>
            </table>

        </form>
    </td>
</tr>
    {else}
<tr>
    <td align="center" class="err">There is no unsold poster for this weekly auction.</td>
</tr>
{/if}
</table>
</td>
</tr>
</table>
{include file="admin_footer.tpl"}
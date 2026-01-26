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
        if(confirm("Are you sure to combine invoices for seller!")){

            $.get("admin_manage_auction_week.php", { mode:"combine_seller_invoice","auction_id[]": allVals},
                    function(data) {
                        if(data=='1'){
                            alert("Successfully invoices are combined");
                        }else{
                            alert("invoices are not combined");
                        }
                    });

        }
    }else{
        alert("Please select atleast two invoices to combine.");

    }
}
function mark_paid_seller_invoice(id){

    if(confirm("Are you sure to combine invoices for seller!")){

        $.get("admin_manage_auction_week.php", { mode:"mark_paid_seller_invoice","invoice_id": id},
                function(data) {
                    if(data=='1'){
                        alert("Successfully invoice(s) are marked as paid.");
                    }else{
                        alert("Invoices are not marked as paid.");
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
                    <td align="center"><a href="{$adminActualPath}/admin_manage_auction_week.php" class="action_link"><strong>&lt; &lt; Back to Auction Week Manager</strong></a></td>
                </tr>


                    <tr  height="26">
                        <td class="headertext">&nbsp;</td>
                    </tr>


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
                                    <td align="center" class="headertext" width="15%">Seller Owned<br/>(Sold price -(MPE Charge + Merchant Fee)) </td>
                                    <td align="center" class="headertext" width="14%">Auction Week</td>
                                    <td align="center" class="headertext" width="14%">Sold Date</td>
                                    <td align="center" class="headertext" width="14%">Status</td>
                                    <td align="center" class="headertext" width="10%">Action</td>
                                </tr>
                                    {assign var="user_id" value=""}

                                    {section name=counter loop=$auctionRows_sold}

                                    <tr height="50">
                                        {if $user_id !=$auctionRows_sold[counter].user_id}

                                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)"><b>Seller:</b> {$auctionRows_sold[counter].firstname}&nbsp;{$auctionRows_sold[counter].lastname}</td>
                                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)"><b>Total Poster:</b> {$auctionRows_sold[counter].tot_poster}</td>
                                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)" colspan="2"><b>Price:</b> ${$auctionRows_sold[counter].tot_amount|number_format:2}</td>
                                            <td style=" background:url({$smarty.const.CLOUD_STATIC_ADMIN}admin_gradient.jpg)" colspan="2"><b>More Action:</b>&nbsp;<input type="hidden" name="auction_id[]" id="auction_id_{$auctionRows_sold[counter].user_id}" value="{$auctionRows_sold[counter].tot_auction}">
                                            {*if $auctionRows_sold[counter].is_combined=='0' && $auctionRows_sold[counter].is_approved=='0' && $auctionRows_sold[counter].is_paid=='0'*}
                                            {if $auctionRows_sold[counter].is_combined=='0' }
                                                <a href="javascript:void(0);" onclick="combine_buyer_invoice('auction_id_{$auctionRows_sold[counter].user_id}')">combine</a>
                                             {/if}
                                            {if $auctionRows_sold[counter].is_approved=='1' && $auctionRows_sold[counter].is_paid=='0'}
                                                <a href="javascript:void(0);" onclick="mark_paid_seller_invoice('{$auctionRows_sold[counter].invoice_id}')">Mark as paid</a>
                                            {/if}
                                            </td>
                                        {/if}

                                    </tr>
                                    <tr id="tr_{$auctionRows_sold[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext"><img src="{$auctionRows_sold[counter].image_path}" height="78" width="100" /><br />{$auctionRows_sold[counter].poster_title}<br /><b>SKU: </b>{$auctionRows_sold[counter].poster_sku}</td>
                                        <td align="center" class="smalltext">${$auctionRows_sold[counter].amount|number_format:2}</td>
                                        <td align="center" class="smalltext">{$auctionRows_sold[counter].auction_week_title}</td>
                                        <td align="center" class="smalltext">{$auctionRows_sold[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                                        <td>&nbsp;
                                            {if $auctionRows_sold[counter].is_combined=='1'}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}combined.png" alt="Combined" title="Combined">
                                                {else}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_combined.png" alt="Combined" title="Not Combined">
                                            {/if}
                                            &nbsp;
                                            {if $auctionRows_sold[counter].is_approved=='1'}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}approved.png" alt="Combined" title="Approved">
                                                {else}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_approved.png" alt="Combined" title="Not Approved">
                                            {/if}
                                            &nbsp;
                                            {if $auctionRows_sold[counter].is_paid=='1'}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}paid.png" alt="Combined" title="Paid on {$auctionRows_sold[counter].paid_on|date_format:"%m/%d/%Y"}">
                                            {else}
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}unpaid.png" alt="Combined" title="Not Paid">
                                            {/if}
                                        </td>
                                        <td align="center" class="bold_text">
                                            &nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice_seller&auction_id={$auctionRows_sold[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>

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


			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
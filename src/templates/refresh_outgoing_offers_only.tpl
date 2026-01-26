<div>
{if $total > 0}
    <table class="list-bid-det-main" cellpadding="0" cellspacing="0" border="0" >
        {section name=counter loop=$auctionRows}
            <tr>
                <td width="1%" valign="top"><p class="poster-txt"><input type="checkbox" name="auction_id[]" value="{$auctionRows[counter].auction_id}"> </p></td>
                <td width="18%" valign="top" align="center">
                    <div id="gallery_{$smarty.section.counter.index}" class="posterdetails">
                        <table align="left"><tbody><tr><td align="center" valign="middle" style="border:none; vertical-align:text-top;">
                            <div class="buylisttb">
                                <div> <img  class="image-brdr" src="{$auctionRows[counter].image_path}" border="0"  border="0" onclick="redirect_poster_details({$auctionRows[counter].auction_id});" style="cursor:pointer;" /></div></div>
                        </td></tr></tbody></table>
                    </div>
                </td>
                <td width="21%" valign="top">
                    <p class="poster-txt" style="cursor:pointer;" onclick="redirect_poster_details({$auctionRows[counter].auction_id});">{$auctionRows[counter].poster_title}&nbsp;{*$auctionRows[counter].poster_sku*}</p>
                    <p class="poster-txt">
                        {section name=catCounter loop=$auctionRows[counter].categories}
                            {if $auctionRows[counter].categories[catCounter].fk_cat_type_id == 1}
                                <b>Size : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
                                {elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 2}
                                <b>Genre : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
                                {elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 3}
                                <b>Decade : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
                                {elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 4}
                                <b>Country : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
                                {elseif $auctionRows[counter].categories[catCounter].fk_cat_type_id == 5}
                                <b>Condition : </b> {$auctionRows[counter].categories[catCounter].cat_value}<br />
                            {/if}
                        {/section}
                    </p>
                </td>
                <td width="25%" valign="top"><p class="poster-txt">{$auctionRows[counter].poster_desc}</p></td>
                <td width="25%" valign="top" class="poster-txt">
                    {if $auctionRows[counter].count_offer > 0}
                        <p class="poster-txt" onMouseOver="toggleDiv('div_{$auctionRows[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auctionRows[counter].auction_id}',0)" style="cursor:pointer;">Total Offers: {$auctionRows[counter].count_offer}</p>

                        <!-- Tooltip starts Here -->

                        <div id="div_{$auctionRows[counter].auction_id}" class="div">
                            <ui>
                                {section name=pop_counter loop=$auctionRows[counter].tot_offers}
                                    <li><b>&nbsp;Amount:</b>&nbsp; ${$auctionRows[counter].tot_offers[pop_counter].offer_amount}&nbsp;</li>
                                {/section}
                            </ui>
                        </div>

                        <!-- Tooltip ends Here -->
                        <p class="poster-txt">Highest Offer: <b>${$auctionRows[counter].highest_offer}</b></p>
                    {/if}
                    {if $auctionRows[counter].auction_is_sold=='1' || $auctionRows[counter].auction_is_sold=='2'}<p class="poster-txt">Item Status: <b>Sold{elseif $auctionRows[counter].auction_is_sold=='3'}<p >Item Status: <b>Sale Pending{elseif $auctionRows[counter].auction_is_sold=='0'}<p class="poster-txt">Item Status: <b>Selling{/if}</b></p>
                </td>
            </tr>
            {assign var='offers' value=$auctionRows[counter].offers}
            <tr>
                <td colspan="5">
                    <div class="gnrl-listing">
                      <div style="margin:0; border-bottom:1px solid #DFDFDF;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            {*<td width="10%"class="text bold">Offer Accepted/Rejected</td>*}
                                <th width="10%" class="text bold">Offer</th>
								<th width="10%" class="text bold">Offer Status</th>
								<th width="13%" class="text bold">Offer Date</th>
								<th width="13%" class="text bold">Counter Offer</th>
								<th width="30%" class="text bold">Counter Offer Status</th>
								<th width="13%" class="text bold">Counter Offer Date</th>
                            </tr>
                            {section name=offerCounter loop=$offers}
                                <tr>
                                {*<td align="left">
                                {if $offers[offerCounter].offer_is_accepted == '1'}
                                    <img src="images/winning-bid-img.png" border="0" />
                                {elseif $offers[offerCounter].offer_is_accepted == '2'}
                                    <img src="images/losing-bid-img.png" border="0" />
                                {/if}
                                </td>*}
                                    <td  style="text-align:center;" class="text">${$offers[offerCounter].offer_amount}</td>
                                    <td id="ofr_status_{$offers[offerCounter].offer_id}"  style="text-align:center;" class="text">
                                        {if $offers[offerCounter].offer_is_accepted == 0}
                                            Pending
                                            {elseif $offers[offerCounter].offer_is_accepted == 1}
                                            Accepted
                                            {elseif $offers[offerCounter].offer_is_accepted == 2}
                                            Rejected
                                        {/if}
                                    </td>
                                    <td class="text" style="text-align:center;">{$offers[offerCounter].post_date|date_format:"%m/%d/%Y"}</td>
                                    <td style="text-align:center;" class="text">
                                        {if $offers[offerCounter].cntr_offer_id > 0}
                                            ${$offers[offerCounter].cntr_ofr_offer_amount}
                                            {else}
                                            --
                                        {/if}
                                    </td>
                                    <td id="cntr_ofr_status_{$offers[offerCounter].offer_id}" style="text-align:center;" class="text">
                                        {if $offers[offerCounter].cntr_offer_id > 0}
                                            {if $offers[offerCounter].cntr_ofr_offer_is_accepted == 0}
                                                <div style="margin:0 auto;"><input type="button" value="Accept" class="track-btn-small" style="margin: 5px 2px;" onclick="acceptOfferModified({$auctionRows[counter].auction_id}, {$offers[offerCounter].offer_id}, {$offers[offerCounter].cntr_offer_id}, 'buyer');" /></div>
                                                <div style="margin:0 auto;"><input type="button" value="Reject" class="track-btn-small" style="margin: 0 2px 5px 2px;" onclick="rejectOfferModified({$offers[offerCounter].offer_id}, {$offers[offerCounter].cntr_offer_id}, 'buyer');" /></div>
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 1}
                                                Accepted
                                                {elseif $offers[offerCounter].cntr_ofr_offer_is_accepted == 2}
                                                Rejected
                                            {/if}
                                            {else}
                                            --
                                        {/if}
                                    </td>
                                    <td class="text" style="text-align:center;">{if $offers[offerCounter].cntr_offer_id > 0} {$offers[offerCounter].cntr_ofr_post_date|date_format:"%m/%d/%Y"}{else} --{/if}</td>
                                </tr>
                            {/section}
                        </table>
                    </div></div>
                </td>
            </tr>
        {/section}
    </table>
{else}

    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">No records found!</td>
                                </tr></table>
{/if}
</div>
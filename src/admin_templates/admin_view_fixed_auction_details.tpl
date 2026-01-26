{include file="admin_header.tpl"}
{literal}
 <script type="text/javascript">
  function delete_offer_details(id){
   var status = confirm("Are you sure that you want to clear all offers ?");
   if(status == true){
       $.post("admin_auction_manager.php", { mode: "clearOffer", auction_id: id },
       function(data) {
      if(data == "1"){
       $("#list_offer").html("");
       $("#clear_button").html("");
       $("#offer_details").html("");       
       alert("All offers has been deleted successfully");
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
                <tr>
                 <td width="100%" align="center"><a href="#" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                </tr>
                {if $errorMessage<>""}
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                <tr>
                    <td align="center">
                        <div id="messageBox" class="messageBox" style="display:none;"></div>
                        <form name="listFrom" id="listForm" action="" method="post">
                            <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                    <tr class="header_bgcolor" height="26">
                                        <!--<td align="center" class="headertext" width="6%"></td>-->
                                        <td align="center" class="headertext" width="15%">Poster</td>
                                        <td align="center" class="headertext" width="12%">Pricing</td>
                                        <td align="center" class="headertext" width="13%">Brief Offers</td>
                                        <td align="center" class="headertext" width="12%">Status</td>
                                        
                                    </tr>
         <tr id="tr_{$auctionArr[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext"><img src="{$auctionArr[0].image_path}"  /><br />{$auctionArr[0].poster_title}<br /><b>SKU: </b>{$auctionArr[0].poster_sku}</td>
                                        <td align="center" class="smalltext">Ask Price : ${$auctionArr[0].auction_asked_price|number_format:2}<br/>{if $auctionArr[0].auction_reserve_offer_price > 0}&nbsp;Will consider offers{/if}</td>
                                         <td align="center" class="smalltext" id="offer_details">
                                          {if $auctionArr[0].auction_is_sold!='2'}
                                             {if $auctionArr[0].count_offer > 0}
                                                 Number of Offers: {$auctionArr[0].count_offer}<br/>
                                                 {if $auctionArr[0].highest_offer != ''}Highest Offer: ${$auctionArr[0].highest_offer|number_format:2}{/if}
                                              {if $invoiceData[2] > 0}
                                               <br/>
                                               Sold Price: ${$invoiceData[2]}<br/>
                                                  (Including all the charges)
                                                 {/if}
                                             {/if}
                                            {elseif $auctionArr[0].auction_is_sold=='2'}
                                             Buyer Name: {$invoiceData[0]}&nbsp;{$invoiceData[1]}<br/>
                                                Sold Price: ${$invoiceData[2]}<br/>
                                             (Including all the charges)
                                            {/if}
                                        </td>
                                        <td align="center" class="bold_text">
                                            {if $auctionArr[0].auction_is_sold=='0'}
                                                Item is not Sold &nbsp; 
                                                {if $total > 0}
                                                <span id="clear_button">
                                                 <a href="javascript:void(0);" onclick="delete_offer_details({$auctionArr[0].auction_id})"><img src="http://c4922595.r95.cf2.rackcdn.com/delete_charge.jpg" alt="clear all offers" title="clear all offers"></a>
                                                </span>
                                                {/if}
                                                {elseif $auctionArr[0].auction_is_sold=='1'}
                                                Item is Sold by Offering &nbsp;<br/><br/>View buyer invoice:<a href="{$actualPath}/admin/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionArr[0].auction_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer" border='0'></a>
                                                {elseif $auctionArr[0].auction_is_sold=='2'}
                                                Item is Sold by Direct Buy Now.&nbsp;<br/><br/>View buyer invoice:<a href="{$actualPath}/admin/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionArr[0].auction_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
												{elseif $auctionArr[0].auction_is_sold=='3'}
                                                Item is not sold. Opted for Buy Now.&nbsp;<br/><br/>View buyer invoice:<a href="{$actualPath}/admin/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionArr[0].auction_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
                                            
											{/if}
                                        </td>
         </tr>          
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
              {if $total>0}
     <tr>
                     <td align="left" id="list_offer">
                            <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                    <tr class="header_bgcolor" height="26">
                                            <td align="center" class="headertext" width="10%">Offer Person</td>
                                            <td align="center" class="headertext" width="17%">Offer Time</td>
                                            {*<td align="left" class="headertext" width="17%">Offer Day</td>*}
                                            <td align="center" class="headertext" width="17%">Offer Date</td>
                                            <td align="center" class="headertext" width="12%">Offer</td>
                                            <td align="center" class="headertext" width="12%">Counter Offer</td>
                                        </tr>
                                    {section name=counter loop=$auctionArr[0].offers}
                                        {*<tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="left" class="smalltext">&nbsp;{$auctionArr[0].offers[counter].username}</td>
                                            <td align="left" class="smalltext paddingLeftmain">{$auctionArr[0].offers[counter].post_date|date_format:"%I:%M:00 %p"} EDT</td>
                                            <td align="left" class="smalltext paddingLeftmain">{$auctionArr[0].offers[counter].post_date|date_format:"%m/%d/%Y"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>
                                            <td align="left" class="smalltext paddingLeftmain">
                                            ${$auctionArr[0].offers[counter].offer_amount|number_format:2}
                                            {if ($auctionArr[0].offers[counter].offer_is_accepted=='1' ) && $auctionArr[0].auction_is_sold <>'2'}
                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
                                            {/if}
                                            </td>
                                            <td align="left" class="smalltext paddingLeftmain">
                                            {if $auctionArr[0].offers[counter].cntr_ofr_offer_amount > 0}
                                                ${$auctionArr[0].offers[counter].cntr_ofr_offer_amount|number_format:2} 
                                                {if ($auctionArr[0].offers[counter].cntr_ofr_offer_is_accepted == '1' ) && $auctionArr[0].auction_is_sold <> '2'}
                                                    &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
                                                {/if}
                                            {else}
                                             -
                                            {/if}
                                        </tr>*}
                                        <tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="center" class="smalltext">&nbsp;{$auctionArr[0].offers[counter].username}</td>
                                            <td align="center" class="smalltext">{$auctionArr[0].offers[counter].post_date|date_format:"%I:%M:00 %p"} EDT</td>
                                            <td align="center" class="smalltext">{$auctionArr[0].offers[counter].post_date|date_format:"%m/%d/%Y"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>
                                            <td align="center" class="smalltext">
                                             <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
                                                 <tr>
                                                     <td align="left" style="padding-left:40px;">${$auctionArr[0].offers[counter].offer_amount|number_format:2}</td>
                                                        {if ($auctionArr[0].offers[counter].offer_is_accepted=='1' ) && $auctionArr[0].auction_is_sold <>'2'}
               <td align="right"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" /></td>
                                                        {/if}
                                              </tr>
                                                 </table>
                                            </td>
                                            <td align="center" class="smalltext">
                                             <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
                                                 <tr>
                                              {if $auctionArr[0].offers[counter].cntr_ofr_offer_amount > 0}
                                                     <td align="left" style="padding-left:40px;">${$auctionArr[0].offers[counter].cntr_ofr_offer_amount|number_format:2}</td>
                                                        {if ($auctionArr[0].offers[counter].cntr_ofr_offer_is_accepted == '1' ) && $auctionArr[0].auction_is_sold <> '2'}
                                                          <td align="right"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" /></td>
                                                        {else}
                                                         <td align="right">&nbsp;</td>
                                                        {/if}
                                                    {else}
                                                        <td align="left" style="padding-left:40px;">-</td>
                                                    {/if}
                                                    </tr>
                                                </table>
           </td>
                                        </tr>
                                    {/section}
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="headertext" colspan="3"></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
    {else}
     <tr>
      <td align="center" class="err">There is no offer in database.</td>
     </tr>
    {/if}
    <tr>
     <td>&nbsp;</td>
    </tr>
                {*<tr>
                 <td align="center" ><input type="button" name="cancel" value="Back" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
                </tr>*}
   </table>
  </td>
 </tr>  
</table>
{include file="admin_footer.tpl"}
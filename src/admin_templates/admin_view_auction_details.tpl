{include file="admin_header.tpl"}
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
                    	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                    </tr>              		
					<tr>
						<td align="center">
                        	<div id="messageBox" class="messageBox" style="display:none;"></div>
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="15%">Poster</td>
                                            <td align="center" class="headertext" width="12%">Pricing</td>
                                            <td align="center" class="headertext" width="13%">Brief Auction</td>
                                            <td align="center" class="headertext" width="12%">Status</td>
										</tr>
											<tr id="tr_{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="{$auctionArr[0].image_path}"  /><br />{$auctionArr[0].poster_title}<br /><b>SKU: </b>{$auctionArr[0].poster_sku}</td>
												<td align="center" class="smalltext">
												{if $auctionArr[0].fk_auction_type_id=='2' || $auctionArr[0].fk_auction_type_id=='5'}
												Start Price :&nbsp;${$auctionArr[0].auction_asked_price|number_format:2}<br/>Buynow Price :&nbsp;${$auctionArr[0].auction_buynow_price|number_format:2}
                                                {elseif $auctionArr[0].fk_auction_type_id=='3'}
                                                Start Price :&nbsp;${$auctionArr[0].auction_asked_price|number_format:2}<br/>Reserve Price :&nbsp;${$auctionArr[0].auction_reserve_offer_price|number_format:2}
                                                {/if}
                                                </td>
                                                <td align="center" class="smalltext">
                                                {if $auctionArr[0].auction_is_sold!='2'}
                                                Number of Bid: {$auctionArr[0].count_bid|number_format}<br/>
                                                {if $auctionArr[0].highest_bid != ''}Highest Bid: ${$auctionArr[0].highest_bid|number_format:2}{/if}
	                                             {if $invoiceData[2] > 0}
	                                             	<br/>  	
	                                               	Sold Price: ${$invoiceData[2]}<br/>
	                                                (Including all the charges)
	                                             {/if}   
                                               	{else}
                                               	Buyer Name: {$invoiceData[0]}&nbsp;{$invoiceData[1]}<br/>
                                                Sold Price: ${$invoiceData[2]}<br/>
                                                (Including all the charges)
                                               	{/if}
                                                </td>                                                
												<td align="center" class="bold_text">
                                                {if $auctionArr[0].auction_is_sold=='0'}
                                                Item is not Sold
                                                {elseif $auctionArr[0].auction_is_sold=='1'}
                                                Item is Sold by Bidding &nbsp;View buyer invoice:<br/><br/><a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionArr[0].auction_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer" border='0'></a>
                                                {elseif $auctionArr[0].auction_is_sold=='2'}
                                                Item is Sold by Direct Buy Now. &nbsp;View buyer invoice:<br/><br/><a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionArr[0].auction_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
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
                    	<td align="left">
                    	 <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_border-noBtom" >
                                <tbody>
                                	<tr class="header_bgcolor" height="26">
                                        <td align="left" class="headertext" width="25%">Bid Person</td>
                                        <td align="center" class="headertext" width="20%">Bid Time</td>
                                        {*<td align="center" class="headertext" width="20%">Bid Day</td>*}
                                        <td align="center" class="headertext" width="12%">Bid Date</td >
                                        <td align="center" class="headertext" width="12%">Amount</td>
                                        <td width="8%">&nbsp;</td>
                                    </tr>
                                    {section name=counter loop=$auctionArr[0].bids}
                                    	
                                    	{if $max_amount_no > 0}
                                    	{if (($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].bids[counter].bid_is_won=='0')  || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='1'}
                                    	
                                    	<tr>
                                    		
                                    		
                                    		<td align="left" class="smalltext">&nbsp;{$auctionArr[0].bids[counter].username}</td>
                                            <td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                            {*<td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%A"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>*}
                                            <td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%m/%d/%Y"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>
                                            <td align="center" class="smalltext">${$auctionArr[0].bids[counter].bid_amount|number_format:2}</td>
                                            <td align="center" class="bold_text">
	                                            {if $max_amount_no==0}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {else}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='1'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='0'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold =='2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if $auctionArr[0].highest_bid > $auctionArr[0].bids[counter].bid_amount}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="losing" />
	                                            {/if}
                                            </td>
                                           
                                            
                                             
                                           
                                    	</tr>
                                    	{/if}
                                    	{/if}
                                    	
                                    	
                                    
                                       
                                       
                                    {/section}
                                   
                                </tbody>
                            </table>
                    	
                    	
                            <table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_border-notop" >
                                <tbody>
                                	
                                    {section name=counter loop=$auctionArr[0].bids}
                                    	{if $max_amount_no > 0}
                                    	
                                    	{if (($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].bids[counter].bid_is_won=='0')  || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='1'}
                                    	
                                    	
                                    		
                                    		
                                            
                                            
                                           
                                    	
                                    	{else}
                                    	
                                    	<tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="left" class="smalltext" width="25%">&nbsp;{$auctionArr[0].bids[counter].username}</td>
                                            <td align="center" class="smalltext" width="20%">{$auctionArr[0].bids[counter].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                            {*<td align="center" class="smalltext" width="20%">{$auctionArr[0].bids[counter].bid_time|date_format:"%A"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>*}
                                            <td align="center" class="smalltext" width="12%">{$auctionArr[0].bids[counter].bid_time|date_format:"%m/%d/%Y"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>
                                            <td align="center" class="smalltext" width="12%">${$auctionArr[0].bids[counter].bid_amount|number_format:2}</td>
                                            <td align="center" class="bold_text" width="8%">
	                                            {if $max_amount_no==0}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {else}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='1'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='0'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold =='2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if $auctionArr[0].highest_bid > $auctionArr[0].bids[counter].bid_amount}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="losing" />
	                                            {/if}
                                            </td>
                                        </tr>
                                    	{/if}
                                    	{else}
                                        <tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="left" class="smalltext">&nbsp;{$auctionArr[0].bids[counter].username}</td>
                                            <td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%I:%M:00 %p"} EDT</td>
                                            {*<td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%A"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>*}
                                            <td align="center" class="smalltext">{$auctionArr[0].bids[counter].bid_time|date_format:"%m/%d/%Y"} &nbsp;&nbsp;{$bidDetails[counter].bids[bid_count].post_date}</td>
                                            <td align="center" class="smalltext">${$auctionArr[0].bids[counter].bid_amount|number_format:2}</td>
                                            <td align="center" class="bold_text">
	                                            {if $max_amount_no==0}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {else}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='1'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}winning-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold <>'2' && $auctionArr[0].bids[counter].is_proxy=='0'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {/if}
	                                            {if ($auctionArr[0].bids[counter].bid_is_won=='1' || $auctionArr[0].highest_bid <= $auctionArr[0].bids[counter].bid_amount) && $auctionArr[0].auction_is_sold =='2'}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="winning" />
	                                            {/if}
	                                            {if $auctionArr[0].highest_bid > $auctionArr[0].bids[counter].bid_amount}
	                                            &nbsp;&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}losing-bid-img.png" border="0" title="losing" />
	                                            {/if}
                                            </td>
                                        </tr>
                                        {/if}
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
						<td align="center" class="err">There is no Bid in database.</td>
					</tr>
				{/if}
				
				{*<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center"><input type="button" name="cancel" value="Back" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
				</tr>*}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
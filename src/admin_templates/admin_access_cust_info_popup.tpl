
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="smallTable" id="righttable">
	<tr>
	  <th style="width:25%;">Item</th>
	  <th>Title</th>
	  <th>Seller</th>
	  <th>Type</th>
	  <th>Price</th>
	  
	</tr>
	<input type="hidden" name="invoice_id" id="invoice_id" value="{$smarty.request.invoice_id}" />
	{section name=counter loop=$invoiceData.auction_details}
		<tr class="altbg">
			<td><img src="{$invoiceData.auction_details[counter].image}" alt="" width="36px" height="30px"/><br/>#{$invoiceData.auction_details[counter].poster_sku}</td>
			<td>{$invoiceData.auction_details[counter].poster_title}</td>
			<td>{$invoiceData.auction_details[counter].name}</td>
			<td>{if $invoiceData.auction_details[counter].fk_auction_type_id=='1'} Fixed {elseif $invoiceData.auction_details[counter].fk_auction_type_id=='2'} Weekly {elseif $invoiceData.auction_details[counter].fk_auction_type_id=='2'} Stills/Photos {/if}</td>
			<td>${$invoiceData.auction_details[counter].amount|number_format:2}</td>
			
		</tr>
		{assign var="subTotal" value=$subTotal+$invoiceData.auction_details[counter].amount}
	{/section}
		<tr> 
		    <td colspan="2" align="left">
			<a id="various" href="{$smart.const.DOMAIN_PATH}/admin/admin_auction_manager.php?mode=manage_invoice_seller_print&invoice_id={$invoiceData.invoice_id}">
			<img src="{$smarty.const.CLOUD_STATIC_ADMIN}view_print.png" onclick="fancy_images()" alt=""/></a>
			&nbsp;<input type="button" name="mark_as_paid" value="Notify Buyer" id="notify_buyer" class="button" onclick="notify_buyer()" >&nbsp;
			&nbsp;{if $invoiceData.is_paid=='0'}<span id="paid"><a href="javascript:void(0)" onclick="markPaid()">Mark Paid</a></span>{/if}
			&nbsp;{if $invoiceData.is_shipped=='0'}<span id="shipped"><a href="javascript:void(0)" onclick="markShipped()">Mark Shipped</a></span>{/if}
			&nbsp;<span id="shipped"><a href="javascript:void(0)" onclick="updateNote()">Save Note</a></span>
			</td>
			<td align="right" colspan="2"><b>Subtotal</b></td>
			<td align="left">${$subTotal|number_format:2}</td>
		</tr>
	{section name=counter loop=$invoiceData.additional_charges}
		<tr id='tr_del_charge_{$smarty.section.counter.index}'>			
			<td align="right" colspan="4">
			 {$invoiceData.additional_charges[counter].description}</td>
			<td align="left">			
			${$invoiceData.additional_charges[counter].amount|number_format:2}</td>
		</tr>
		{assign var="subTotal" value=$subTotal+$invoiceData.additional_charges[counter].amount}
		{/section}
		{section name=counter loop=$invoiceData.discounts} 
		<tr id='tr_del_amnt_{$smarty.section.counter.index}'>	
            			
			<td align="right" colspan="4">
			{$invoiceData.discounts[counter].description}</td>
			<td align="left">			
			${$invoiceData.discounts[counter].amount|number_format:2}</td>
		</tr>
		{assign var="subTotal" value=$subTotal+$invoiceData.discounts[counter].amount}
		{/section}
		
		<tr>
			<td align="left" colspan="3" width="50%"><b style="font-size:17px;color:#CC0000;">Note:</b>&nbsp;<b style="font-size:13px;" id="note">{$invoiceData.note}</b></td>
			<td align="right" width="20%"><img src="http://c4922595.r95.cf2.rackcdn.com/icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" onclick="editNote()">&nbsp;&nbsp;<b>Total</b></td>
			<td align="left" id="new_total_amnt">${$invoiceData.total_amount}</td>
			<input type="hidden" id="total_cost_amnt" value="{$invoiceData.total_amount}"/>
		</tr>	
   </table>

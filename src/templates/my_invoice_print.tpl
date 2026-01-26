{literal}
<style type="text/css" media="all">

.print {visibility:visible;} 

.forPrint-allBorder{
border:1px solid #CCCCCC;
}


.forPrint-topBorder{
border-top:1px solid #CCCCCC;
}

.forPrint-topLeftBorder{
border-top:1px solid #CCCCCC;
border-left:1px solid #CCCCCC;
}

.forPrint-topLeftBtomBorder{
border-top:1px solid #CCCCCC;
border-left:1px solid #CCCCCC;
border-bottom:1px solid #CCCCCC;
}

.forPrint-topBtomBorder{
border-top:1px solid #CCCCCC;
border-bottom:1px solid #CCCCCC;
}

.forPrint-main{
font-size:14px; font-family:Arial, Helvetica, sans-serif;
}

.forPrint-txt{
	color:#009933; font-weight:bold; padding-right:20px;
}

.forPrint-mainBorder{
border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;
padding:5px;
margin:0px;
}

</style>
{/literal}
<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;{if $invoiceData[0].is_paid=='1'}background:url({$smarty.const.CLOUD_STATIC}paid-img.png){elseif $invoiceData[0].is_cancelled=='1'}background:url({$smarty.const.CLOUD_STATIC}cancelled-img.png){elseif $invoiceData[0].is_cancelled=='0' && $invoiceData[0].is_paid=='0' && $invoiceData[0].is_approved=='1' && $invoiceData[0].is_ordered=='0'}background:url({$smarty.const.CLOUD_STATIC}approved-img.png){elseif $invoiceData[0].is_paid=='0' && $invoiceData[0].is_ordered=='1'} background:url({$smarty.const.CLOUD_STATIC}payment-pending-img.png){/if} no-repeat center 80%; ">
	<tr>
    	<td style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="142" height="189" border="0" />
        </td>
    </tr>
    <tr bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" height="26">
    	<td colspan="2"  bgcolor="Silver"><b>&nbsp;Invoice Details</b></td>
    </tr>
    <tr bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" height="26">
        <td align="left" style="padding:4px;" class="print"><b>Date of Invoice:</b> {$invoiceData[0].invoice_generated_on|date_format}</td>
        <td align="right" style="padding:4px;" >{if $invoiceData[0].is_paid=='1'}Paid{/if}</td>
    </tr>
	{if $invoiceData[0].is_paid=='1'} 
	<tr bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" height="26">
        <td align="left" style="padding:4px;" class="print" colspan="2"><b>Date Paid:</b> {$invoiceData[0].paid_on|date_format}</td>
        
    </tr>
	{/if}
    <tr>
    	<td align="left" colspan="2"></td>
    </tr>
    <tr bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" height="32">
        <td align="left" style="padding:4px;">
        {if $invoiceData[0].billing_address != ''}
            <b>Billing Address</b><br />
            {$invoiceData[0].billing_address.billing_firstname}&nbsp;{$invoiceData[0].billing_address.billing_lastname}<br/>
            {$invoiceData[0].billing_address.billing_address1}{if $invoiceData[0].billing_address.billing_address != ''}, {$invoiceData[0].shipping_address.billing_address}{/if}
            <br />{$invoiceData[0].billing_address.billing_city}&nbsp;-
            {$invoiceData[0].billing_address.billing_zipcode},&nbsp;{$invoiceData[0].billing_address.billing_state}&nbsp;{$invoiceData[0].billing_address.billing_country_name}<br />
        {/if}
        </td>
        <td align="left" style="padding:4px;">
        {if $invoiceData[0].shipping_address != ''}
            <b>Shipping Address</b><br />
            {$invoiceData[0].shipping_address.shipping_firstname}&nbsp;{$invoiceData[0].shipping_address.shipping_lastname}<br/>
            {$invoiceData[0].shipping_address.shipping_address1}{if $invoiceData[0].shipping_address.shipping_address2 != ''}, {$invoiceData[0].shipping_address.shipping_address2}{/if}
            <br />{$invoiceData[0].shipping_address.shipping_city}&nbsp;-
            {$invoiceData[0].shipping_address.shipping_zipcode},&nbsp;{$invoiceData[0].shipping_address.shipping_state}&nbsp;{$invoiceData[0].shipping_address.shipping_country_name}<br />
        {/if}
        </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF">
        <td bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" align="left" colspan="2">
            <table border="1" style="border-collapse:collapse; font-size:14px;" width="100%" align="left" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" cellpadding="0" cellspacing="0">
                <tr bgcolor="#c4c4c4">
                    <td style="padding:4px;" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" align="left" width="25%" <b>Item</b></td>
                    <td style="padding:4px;" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" align="left" width="50%"><b>Title</b></td>
                    <td style="padding:4px;" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" align="left" width="25%"><b>Price</b></td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
				{assign var="seller_username" value= '' }
				{section name=counter loop=$invoiceData[0].auction_details}
				{if $chk_item_type=='1' }
				
				  {if $seller_username !=$invoiceData[0].auction_details[counter].seller_username}
				  {if $seller_username!=''}	
					<tr>
					<td align="right" colspan="2" style="padding:4px;">Shipping Charge:</td>
					{if $invoiceData[0].shipping_address.shipping_country_name =='Canada' || $invoiceData[0].shipping_address.shipping_country_name =='United States' || $invoiceData[0].is_old==1 }
                            <td align="left" style="padding:4px;">$15.00</td>
					{else}
							<td align="left" style="padding:4px;">$21.00</td>
					{/if} 
					</tr>
				  {/if}
					<tr><td colspan="3" style="padding:4px;">Seller : {$invoiceData[0].auction_details[counter].seller_username}</td></tr>
				  
				  {/if}
				{/if}
                <tr  >
                    <td style="padding:4px;" align="left">{$smarty.section.counter.index+1}</td>
                    <td style="padding:4px;" align="left">{$invoiceData[0].auction_details[counter].poster_title}{if $invoiceData[0].is_buyers_copy=='0'}&nbsp;(#{$invoiceData[0].auction_details[counter].poster_sku}){/if}</td>
                    <td style="padding:4px;" align="left">${$invoiceData[0].auction_details[counter].amount|number_format:2}</td>
                </tr>
                {assign var="subTotal" value=$subTotal+$invoiceData[0].auction_details[counter].amount}
				{assign var="seller_username" value= $invoiceData[0].auction_details[counter].seller_username }
                {/section}
				{if $chk_item_type=='1' || $chk_item_type=='4'}
						<tr>
						<td align="right" colspan="2" style="padding:4px;">Shipping Charge:</td>
						{if $invoiceData[0].shipping_address.shipping_country_name =='Canada' || $invoiceData[0].shipping_address.shipping_country_name =='United States' || $invoiceData[0].is_old==1}
                            <td align="left" style="padding:4px;">$15.00</td>
						{else}
							<td align="left" style="padding:4px;">$21.00</td>
						{/if}
						</tr>
					{/if}
                <tr>
                    <td style="padding:4px;" align="right" colspan="2"  >Subtotal</td>
                    <td style="padding:4px;" align="left"  >${$subTotal|number_format:2}</td>
                </tr>
                {section name=counter loop=$invoiceData[0].additional_charges}
                <tr >
                    <td style="padding:4px;" align="right" colspan="2" >(+)&nbsp;{$invoiceData[0].additional_charges[counter].description}</td>
                    <td style="padding:4px;" align="left" >${$invoiceData[0].additional_charges[counter].amount|number_format:2}</td>
                </tr>
                {assign var="subTotal" value=$subTotal+$invoiceData[0].additional_charges[counter].amount}
                {/section}
                {section name=counter loop=$invoiceData[0].discounts}
                <tr >
                    <td style="padding:4px;" align="right" colspan="2" >(-)&nbsp;{$invoiceData[0].discounts[counter].description}</td>
                    <td style="padding:4px;" align="left" >${$invoiceData[0].discounts[counter].amount}</td>
                </tr>
                {assign var="subTotal" value=$subTotal+$invoiceData[0].discounts[counter].amount}
                {/section}
                <tr>
                    <td style="padding:4px;" align="right" colspan="2" >Total</td>
                    <td style="padding:4px;" align="left" >${$invoiceData[0].total_amount}</td>
                </tr>
                <tr>
                	<td colspan="3" align="center"><input type="button" name="Approved" value="Print"  onclick="window.print();"></td>
                </tr>
            </table>
        </td>
    </tr>    
</table>
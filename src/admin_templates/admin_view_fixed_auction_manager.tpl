{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/uploadify/jquery.uploadify.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                	<td width="100%" align="center"><a href="#" onclick="history.back();" class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                </tr>
				{*<tr>
					<td align="center" valign="top" class="bold_text">Manage Poster / Auction</td>
				</tr>*}
				{if $errorMessage<>""}
					<tr>
						<td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
					</tr>
				{/if}
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="update_fixed">
                            <input type="hidden" name="auction_id" value="{$auctionRow[0].auction_id}">
                            <input type="hidden" name="poster_id" id="poster_id" value="{$auctionRow[0].fk_poster_id}">
                            <input type="hidden" name="random" id="random" value="{$random}" />
                            <input type="hidden" name="existing_images" id="existing_images" value="{$existingImages}" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%">Poster SKU :</td>
												<td class="smalltext">{$posterRow[0].poster_sku}</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext">{$posterRow[0].poster_title}<br /><span class="err">{$poster_title_err}</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 5}
                                                        {section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            	{$catRows[counter].cat_value}
                                                            {/if}
                                                        {/section}
                                                        
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 2}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            	 {$catRows[counter].cat_value}
                                                            {/if}
                                                        {/section}
                                                       
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 3}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            	{$catRows[counter].cat_value}
                                                            {/if}
                                                        {/section}
                                                        
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                
                                                    {section name=counter loop=$catRows}
                                                    {if $catRows[counter].fk_cat_type_id == 4}
                                                    	{section name=posterCatCounter loop=$posterCategoryRows}
                                                        	{if $catRows[counter].cat_id == $posterCategoryRows[posterCatCounter].fk_cat_id}
                                                            	{assign var="selected" value="selected"}
                                                            	{$catRows[counter].cat_value}
                                                            {/if}
                                                        {/section}
                                                        
                                                        {assign var="selected" value=""}
                                                    {/if}
                                                    {/section}
                                            	
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext">{$posterRow[0].poster_desc}<br /><span class="err">{$poster_desc_err}</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                            	<div id="existing_photos" style="width:680px; padding:10px; margin:0px; float:left;">
                                                                    {section name=counter loop=$posterImageRows}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="existing_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$posterImageRows[counter].image_path}"  />
                                                                        <br /><input type="radio" name="is_default" value="{$posterImageRows[counter].poster_thumb}" {if $posterImageRows[counter].is_default == 1} checked="checked" {/if} disabled="disabled" />
                                                                        </div>
                                                                	{/section}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    	<tr>
                                                        	<td align="center">
                                                                
                                                                <div id="new_photos" style="width:680px; padding:10px; margin:0px; float:left;">
                                                                	{section name=counter loop=$poster_images_arr}
                                                                        {assign var="countID" value=$smarty.section.counter.index+1}
                                                                        <div id="new_{$countID}" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="{$actualPath}/poster_photo/temp/{$random}/{$poster_images_arr[counter]}" height="78" width="100" />
                                                                        <br /><input type="radio" name="is_default" value="{$poster_images_arr[counter]}" />
                                                                        <br /></div>
                                                                	{/section}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Asked Price :</td>
												<td class="smalltext">${$auctionRow[0].auction_asked_price|number_format:2}<br /><span class="err">{$asked_price_err}</span></td>
											</tr>
                                            
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top">&nbsp;</td>
												<td class="smalltext"><input type="checkbox" name="is_consider" {if $auctionRow[0].auction_reserve_offer_price == 1} checked="checked" {/if} id="is_consider" disabled="disabled"  value="1" > &nbsp;I will consider offers</td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Notes :</td>
												<td class="smalltext">{$auctionRow[0].auction_note}<br /><span class="err">{$auction_note_err}</span></td>
											</tr>
											{*<tr class="tr_bgcolor">
												
												<td align="center" colspan="2"><input type="button" name="cancel" value="Back" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
											</tr>*}
										</table>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}
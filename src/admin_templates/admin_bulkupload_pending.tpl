{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
<!--                <tr>-->
<!--                	<td width="100%" align="center"><a href="#" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" class="action_link"><strong>&lt;&lt; Back</strong></a></td>-->
<!--                </tr>-->
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
                                        <td align="center" class="headertext" width="15%">Uploader Name</td>
                                        <td align="center" class="headertext" width="12%">Uploaded Date</td>
                                        <td align="center" class="headertext" width="13%">File Size</td>
                                        <td align="center" class="headertext" width="12%">Action</td>
                                        
                                    </tr>
                                    {if $total >0}
                                    {section name=counter loop=$bulkRows}
									<tr id="tr_{$bulkRows[counter].bulkupload_id}" class="{cycle values="odd_tr,even_tr"}">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext">{$bulkRows[counter].firstname}&nbsp;{$bulkRows[counter].lastname}&nbsp;({$bulkRows[counter].username})</td>
                                        <td align="center" class="smalltext">{$bulkRows[counter].upload_date|date_format:"%m/%d/%Y"}</td>
                                         <td align="center" class="smalltext">
                                         	{$bulkRows[counter].file_size} MB
                                        </td>
                                        <td align="center"><a href="{$adminActualPath}/admin_auction_manager.php?mode=download_bulk&file={$bulkRows[counter].file_name}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}uplink.png" align="absmiddle" alt="Download Zip" title="Download Zip" border="0" class="changeStatus" /></a>&nbsp;|&nbsp;<a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_auction_manager.php?mode=delete_bulk&bulkupload_id={$bulkRows[counter].bulkupload_id}&encoded_string={$encoded_string}', 'record'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Record" title="Delete Record" border="0" class="changeStatus" /></a></td>
									</tr>
									{/section}
									{else}	
									<tr>
									<td colspan='4' align='center' style="color: red;">No record found</td>
									</tr>
									{/if}									
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
                
				
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
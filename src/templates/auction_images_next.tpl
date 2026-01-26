<table cellpadding="0" cellspacing="0" width="100%" class="Container" bgcolor="silver">
			<tr>
				<td height="20" class="BottomPopup" valign="middle" align="right"><a href="javascript: void(0);" onclick="javascript: window.close();"><img  src="{$smarty.const.CLOUD_STATIC}close-button.png" style="border:none;"></a>&nbsp;&nbsp;</td>
			</tr>
			<tr>
			<input type="hidden" id="image_width" value="{$width}" />
			<input type="hidden" id="image_height" value="{$height}" />
				<td class="Container">
			<table cellpadding="0" cellspacing="0" width="100%">
			{section name=counter loop=$imgArr}
			<tr>
				<td class="PImageImageCell" align="center" id='loader'>
					<img id="img" alt="" src="{$imgArr[counter].image_path}"  />
					</td>
			</tr>
			{/section}
			</table>
			
				</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>
			</table>
{literal}
<script type="text/javascript">

function close_window(){
	window.opener.location.href = window.opener.location.href;
	  if (window.opener.progressWindow)
	 {
	    window.opener.progressWindow.close()
	  }
	  window.close();
		
}

</script>
<style type="text/css">

.adminSuccess{

		border-collapse:collapse;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	background-color:#d8eaee;
}

.adminPrint{

		border-collapse:collapse;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}

.adminPrint tr th{
	border:1px solid #024552;
	background-color:#356d79;
	color:#FFFFFF;
}

.adminPrint tr td{
	border:1px solid #999999;
	
}

.adminPrint tr.odd_tr{
	background-color:#f4f4f4;
}

.adminPrint tr.totline{
	background-color:#356d79;
	color:#FFFFFF;
}

.adminPrint tr.payNow{
	background-color:#d8eaee;
	
}

input.button{
	border: 1px solid #000000;
	padding: 2px 3px 2px 3px;
    font-weight: normal;
    font-size: 11px;
    font-family: tahoma, verdana, arial, helvetica, sans-serif;
	color:#ffffff;
	background: #ffffff url(http://c4922595.r95.cf2.rackcdn.com/button_bg.gif) repeat-x;
	cursor: pointer;
}
</style>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center"></td>
				</tr>
                
				
				
				
					<tr>
						<td align="center">
							<form name="listFrom" id="listForm" action="" method="post" >
								<input type="hidden" name="mode" value="complete_payment" />
								<input type="hidden" name="encoded_string" value="{$encoded_string}" />
								<table align="center" width="60%" cellspacing="1" cellpadding="2" class="adminSuccess" >
									<tbody>
										
										
										<tr>
                                        	<td align="right">
                                            	
                                                	<img src="../admin_images/close-button.png" width="29" height="29" border="0" style="curser:pointer;" onclick="close_window()" />
                                                
                                            </td>
                                        </tr>
										<tr height="26" >
											<td align="center" valign="middle">Payment Done Successfully!</td>
										</tr>
										<tr height="26" >
											<td align="center" valign="middle">&nbsp;</td>
										</tr>
										
										
										
									</tbody>
								</table>
								
							</form>
						</td>
					</tr>
				
			</table>
		</td>
	</tr>		
</table>

{literal}
<style>
.printer{
font-family:Calibri;	
}

.forPrint-mainBorder{
border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;
padding:5px;
margin:0px;
} 

</style>
{/literal}
<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;{if $invoiceData[0].is_paid=='1'}background:url({$smarty.const.CLOUD_STATIC}paid-img.png){elseif $invoiceData[0].is_cancelled=='1'}background:url({$smarty.const.CLOUD_STATIC}cancelled-img.png){elseif $invoiceData[0].is_cancelled=='0' && $invoiceData[0].is_paid=='0' && $invoiceData[0].is_approved=='1' && $invoiceData[0].is_ordered=='0'}background:url({$smarty.const.CLOUD_STATIC}approved-img.png){elseif $invoiceData[0].is_paid=='0' && $invoiceData[0].is_ordered=='1'} background:url({$smarty.const.CLOUD_STATIC}payment-pending-img.png){/if} no-repeat center 75%; ">
                            	                               
                                <tr >
                                	<td align="left" colspan="2" >
                                    	<table border="1" width="100%" align="left" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" cellpadding="2" style="border-collapse:collapse;" cellspacing="0" class="invoice-main">
                                        	<tr class="printer" bgcolor="silver">
                                            	<th align="left" width="20%" >Sl No</th>
                                                <th align="left" width="20$" >Domain Name</th>
                                                <th align="left" width="20%" >First Name</th>
                                                <th align="left" width="20%" >Last Name</th>
                                                <th align="left" width="20%" >Email Id</th>
                                            </tr>
                                            
                                            {section name=counter loop=$data}											
                                        	<tr class="printer" >
                                                <td align="left" >{$data[counter].idtbl_blacklist}</td>
                                                <td align="left" >{$data[counter].domain}</td>
                                                <td align="left" >{$data[counter].firstname}</td>
                                                <td align="left" >{$data[counter].lastname}</td>
                                                <td align="left" >{$data[counter].email}</td>
                                               
                                            </tr>
											{/section}
                                            
                                        </table>
                                    </td>
                                </tr>
                                
                        </form>
                    </td>
                </tr>
               
			</table>
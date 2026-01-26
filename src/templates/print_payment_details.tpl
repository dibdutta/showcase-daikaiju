{literal}
<style>
.printer{
font-family:Calibri;	
}
}
</style>
{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->
        
        <!--Header themepanel Ends-->    
        <div id="inner-container">
            <div id="inner-left-container">
                 
                <div class="innerpage-container-main">
                    <div class="top-main-bg"></div>
                    <div class="mid-rept-bg">
                    {if $total>0}	
                        <!--  inner listing starts-->                    
                        <div class="display-listing-main">
                            <div class="gnrl-listing">
                            {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                            <form name="listFrom" id="listForm" action="" method="post">
                                <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000">
                            
                                    <tr>
    								  <td  style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="142" height="189" border="0" />
        								</td>
        								<td  >&nbsp;</td>
    								</tr>
                                    <tr class="printer" bgcolor="silver">
                                        <td width="33%" align="center"><strong>Sl No.</strong></td>
                                        <td width="33%" align="center"><strong>Paid Amount</strong></td>                                    
                                        <td width="25%" align="center"><strong>Payment Date</strong></td>
                                    </tr>
                                    
                                    {section name=counter loop=$dataPayment}
                                    <tr class="printer">                                	
                                        <td align="center">
                                        
                                             {math equation="x + y" x=$smarty.section.counter.index y=1}
                                        
                                        </td>
                                        <td align="center">${$dataPayment[counter].payment_amount}</td>
                                        <td align="center">{$dataPayment[counter].payment_date|date_format:"%m/%d/%Y"}</td>
                                    </tr>
                                    {/section}
                                    <tr>
                                    <td align="center" colspan="5">&nbsp;
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                    <td align="center" colspan="5">
                                        
                                        <input type="button" name="print" value="Print" onClick="window.print()"/>
                                        
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            </div>					
                        </div>
                    {else}
                    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                        <tr>
                            <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry No Report to Display.</td>
                        </tr>
                    </table>
                   {/if}            
                    </div>
                    <div class="btom-main-bg"></div>
                </div>
            </div>
        </div>    
    </div>
    <div class="clear"></div>
</div>

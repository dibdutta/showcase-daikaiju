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
                                <table width="100%" border="1" cellspacing="1" cellpadding="2" style="border-collapse:collapse;" bordercolor="#000000">
                            		<tr>
    								  <td  style="padding:10px;"><img src="{$smarty.const.CLOUD_STATIC}logo.png" width="142" height="189" border="0" />
        								</td>
        								<td align="right" valign="top" style="padding: 10px 10px 0;" colspan='5' class="printer"></td>
    								</tr>
                                    
                                    <tr>
                                    	<td align="center" valign="top"  colspan='6' class="printer">
                                        	Seller name: <strong> {$userName}</strong>                                     
                                       
                                       
                                        </td>
                                    </tr>
                                    
                                    <tr class="printer" bgcolor="silver">
                                        <td width="30%"><strong>Poster Title</strong></td>
                                        <td width="15%"><strong>Billing Date</strong></td>                                    
                                        <td width="12%"><strong>Sold Price</strong></td>
                                        
                                    </tr>
                                    
                                    {section name=counter loop=$reportData}
                                    <tr class="printer">                                	
                                        <td align="left">
											 
                                             {$reportData[counter].poster_title}&nbsp;(#{$reportData[counter].poster_sku})<br />
                                        
                                        </td>
                                        <td align="left">{$reportData[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                                        <td align="center">
                                        
                                        ${$reportData[counter].amount}&nbsp;
                                        
                                        </td>
                                        
                                    </tr>
                                    {/section}
                                    <tr>
                                    <td align="center" style="padding:10px 0;" colspan="6">
                                        
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
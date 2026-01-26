{include file="header.tpl"}
	<script>
		!window.jQuery && document.write('<script src="{$actualPathJSCSS}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	{literal}
	<script type="text/javascript">
        function fancy_images(i){
            $("#various_"+i).fancybox({
                'width'				: '75%',
                'height'			: '100%',
                'autoScale'			: false,
                'transitionIn'		: 'none',
                'transitionOut'		: 'none',
                'type'				: 'iframe'
            });
        }
            
        //});
	</script>
 	{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
		  {include file="search-login.tpl"} 
        </div>
        <div id="inner-container2">
        {include file="right-panel.tpl"}
         <div id="center"><div id="squeeze"><div class="right-corner">
            <div id="inner-left-container">
                 <div id="tabbed-inner-nav">
                 	<div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li ><a href="{$actualPathJSCSS}/my_invoice.php"><span>My Invoice(Buyer)</span></a></li>
						<li ><a href="{$actualPathJSCSS}/my_invoice.php?mode=archive_invoice"><span>My Archived Invoices(Buyer)</span></a></li>
                        <li class="active"><a href="{$actualPathJSCSS}/my_invoice.php?mode=buyer"><span>Reconciliation(Seller)</span></a></li>
                    </ul>
                  	
					</div>	
                 </div>
                <div class="innerpage-container-main">
                   <div class="top-mid"><div class="top-left"></div></div>
                
                   
                   <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    
                    <div class="mid-rept-bg">
                    {if $total>0}	
                        <!--  inner listing starts-->
                        <div>                    
                        <div class="display-listing-main">
						 
						<div class="gnrl-listing">
                        <div style="margin:0 0 0 12px;">
                            
                            {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                            <form name="listFrom" id="listForm" action="" method="post">
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                                    <tr>
                                        <th width="45px" class="tac">Sl No</th>
                                        <th class="tal">Poster Title</th>
                                        <th width="80px" class="tac">Billing Date</th>
                                        <th width="70px" class="tac pr10">Price</th>
                                        <th width="100px" class="tac">Action</th>
                                    </tr>
                                    {section name=counter loop=$invoiceData}
                                        <tr>
                                            <td class="tac">{$smarty.section.counter.index+1}</td>
                                            <td class="tal">
                                                {section name=adCounter loop=$invoiceData[counter].auction_details}
                                                    {$smarty.section.adCounter.index+1}.&nbsp;{$invoiceData[counter].auction_details[adCounter].poster_title}&nbsp;(#{$invoiceData[counter].auction_details[adCounter].poster_sku})<br />
                                                {/section}
                                            </td>
                                            <td class="tac">{if $invoiceData[counter].is_paid=='1'}
                                                            {$invoiceData[counter].paid_on|date_format:"%m/%d/%Y"}
                                                         {elseif $invoiceData[counter].is_paid=='0'}
                                                            {$invoiceData[counter].approved_on|date_format:"%m/%d/%Y"}
                                                         {/if}</td>
                                            <td class="tar">${$invoiceData[counter].total_amount}</td>
                                            <td class="tac">{if $invoiceData[counter].is_paid=='0'}
                                                Approved{else}Paid{/if} &nbsp;<a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice.php?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img src="../images/print.png" alt="Print" width="15" height="15" title="Print" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                            </td>
                                        </tr>
                                    {/section}
                                </table>
                            </form>
                            </div>	
                        </div>				
                       </div>
                        </div>
                    {else}
                    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                        <tr>
                            <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry No Invoice to Display.</td>
                        </tr>
                    </table>
                   {/if}  
                   <div class="clear"></div>          
                    </div>
                    
                    </div>
                    </div>
              
                <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                </div>
            </div>
         </div></div></div>       
        {include file="user-panel.tpl"}
        </div>    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
{include file="header.tpl"}
    
	<script>
		!window.jQuery && document.write('<script src="{$actualPathJSCSS}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPathJSCSS}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	{literal}
	<script type="text/javascript">
        //$(document).ready(function() {
            /*
            *   Examples - images
            */
        function fancy_images(i){
            $("#various_"+i).fancybox({
                'width'				: '90%',
                'height'			: '100%',
                'autoScale'			: false,
                'transitionIn'		: 'none',
                'transitionOut'		: 'none',
                'type'				: 'iframe'
            });
        }
        function combine_buyer_invoice(){
            //var checkBoxs = $(":checkbox").filter(":checked").size();


            var allVals = [];
            $(":checkbox").filter(":checked").each(function() {
                allVals.push($(this).val());
            });
            var totalInv=allVals.length;
            if(totalInv >1){

                if(confirm("Are you sure to combine invoices!")){
                    //alert(allVals);
                    $.get("my_invoice", { mode:"combine_buyer_invoice","invoice_id[]": allVals},
                            function(data) {
                                if(data=='1'){
                                    alert("Successfully invoices are combined");
                                    window.location.reload();
                                }else{
                                    alert("invoices are not combined");
                                }
                            });
                    $(":checkbox").filter(":checked").each(function() {
                        $(this).removeAttr("checked");
                    });
                }else{
                    $(":checkbox").filter(":checked").each(function() {
                        $(this).removeAttr("checked");
                    });
                }
            }else{
                alert("Please select atleast two invoices to combine.");
                $(":checkbox").filter(":checked").each(function() {
                    $(this).removeAttr("checked");
                });
            }

        }
        //});
	</script>
 	{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->

        <div id="headerthemepanel">
        {include file="search-login.tpl"}
          <!--Header Theme Starts-->
                <!--<div id="searchbar">
                    <div class="search-left-bg"></div>
                    <div class="search-midrept-bg">
                        <label><img src="images/search-img.png" width="20" height="32"  /></label>
                        <input type="text" name="txt1" class="srchbox-txt" />
                        <input type="button" value="Search" class="srchbtn-main"  />
                        <input type="button" value="Refine Search" class="refine-srchbtn-main"  />
                    </div>
                    <div class="search-right-bg"></div>
                  </div>--> 
          <!--Header Theme Ends-->
        </div>
        <!--Header themepanel Ends-->    
        <div id="inner-container">
        {include file="right-panel.tpl"}
          <div id="center"><div id="squeeze"><div class="right-corner">
            <div id="inner-left-container">
                 <div id="tabbed-inner-nav">
                 <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li class="active"><a href="{$actualPathJSCSS}/my_invoice"><span>My Invoice(Buyer)</span></a></li>
                        <li ><a href="{$actualPathJSCSS}/my_invoice?mode=buyer"><span>Reconciliation(Seller)</span></a></li>
                    </ul>
                    
 					<div class="tabbed-inner-nav-right"></div>
                    </div>
                 </div>
                <div class="innerpage-container-main">
                    <div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div> 
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    {if $total>0}	
                        <!--  inner listing starts-->                    
                        <div class="display-listing-main">
                        {if $key=='2'}
                            <input type="button" onclick="combine_buyer_invoice()" style="font-size:11px;" class="track-btn" value="Combine">
							<div class="messageBox" style="margin-top:30px;width:600px;background-color:pink;">If you wish to combine multiple unpaid invoices, please select each invoice checkbox and press Combine button.</div>
                         {/if}   
                        <div>
                            <div class="gnrl-listing">
                            <div style="margin:0 0 0 12px;">
                            
                            <form name="listFrom" id="listForm" action="" method="post">
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                                    <tr>
                                        <td width="6%"><strong>Select</strong></td>
                                        <td width="6%"><strong>Sl No</strong></td>
                                        <td width="40%"><strong>Poster Title</strong></td>
                                        <td width="20%"><strong>Billing Date</strong></td>                                    
                                        <td width="15%"><strong>Price</strong></td>
                                        <td><strong>Action</strong></td>
                                    </tr>
                                    {section name=counter loop=$invoiceData}
                                    <tr>
                                        <td>
                                            {if $invoiceData[counter].is_paid == '0'}
                                            <input type="checkbox" name="invoice_id" value="{$invoiceData[counter].invoice_id}">
                                            {/if}
                                        </td>
                                       <td>
                                           {$smarty.section.counter.index+1}
                                       </td>
                                        <td align="left">
                                        {section name=adCounter loop=$invoiceData[counter].auction_details}
                                            {$smarty.section.adCounter.index+1}.&nbsp;{$invoiceData[counter].auction_details[adCounter].poster_title|stripslashes} &nbsp;<br />
                                        {/section}
                                        </td>
                                        <td align="left">{$invoiceData[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                                        <td align="left">${$invoiceData[counter].total_amount}</td>
                                        <td align="center">
                                        {if $invoiceData[counter].is_cancelled == '1'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="{$smarty.const.CLOUD_STATIC}print.jpg" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {elseif $invoiceData[counter].is_paid == '1'}
                                        PAID &nbsp;<a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="{$smarty.const.CLOUD_STATIC}print.jpg" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {elseif $invoiceData[counter].is_paid == '0' && $invoiceData[counter].is_cancelled == '0'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=order&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Pay Now" title="Pay Now" width="70" src="{$smarty.const.CLOUD_STATIC}pay_now.png" /></a>
                                        {elseif $invoiceData[counter].is_paid == '1' || $invoiceData[counter].is_cancelled == '1'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="{$smarty.const.CLOUD_STATIC}print.jpg" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {/if}
                                        </td>
                                    </tr>
                                    {/section}
                                </table>
                            </form>
                            </div>
                            </div>		
                        </div>
                        {if $key=='2'}
                            <input type="button" onclick="combine_buyer_invoice()" style="font-size:11px;" class="track-btn" value="Combine">
						{/if}    
                        </div>
						
                    {else}
                    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                        <tr>
                            <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry No Invoice to Display.</td>
                        </tr>
                    </table>
                   {/if}  
                   <div class="clear"></div>  
				   {if $key=='2'}
					<div class="messageBox"  style="width:600px;background-color:pink;">If you wish to combine multiple unpaid invoices, please select each invoice checkbox and press Combine button.</div>
                   {/if}
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
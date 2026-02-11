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
            var allVals = [];
			var values= [];
			var statusArr = [];
            $(":checkbox").filter(":checked").each(function() {
			    values=$(this).val().split('-');
				auction_id=values[0];
				invoice_status=values[1];				
                allVals.push(auction_id);
				statusArr.push(invoice_status);
            });
            var totalInv=allVals.length;
			var result = in_array(statusArr, 'paid');			
			if(!result){
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
		  }else{
			 alert("Please select only unpaid invoices to combine.");
			 $(":checkbox").filter(":checked").each(function() {
				$(this).removeAttr("checked");
			 });
		  }
        }
		function archive_invoice(){
			
            var allVals = [];
			var values= [];
			var statusArr = [];
            $(":checkbox").filter(":checked").each(function() {
			    values=$(this).val().split('-');
				auction_id=values[0];
				invoice_status=values[1];				
                allVals.push(auction_id);
				statusArr.push(invoice_status);
            });
            var totalInv=allVals.length;
			var result = in_array(statusArr, 'unpaid');			
			if(!result){
            if(totalInv >0){				
                if(confirm("Are you sure to archive invoices!")){
				
                    $.get("my_invoice", { mode:"archive_buyer_invoice","invoice_id[]": allVals},
                            function(data) {							
                                if(data=='1'){
                                    alert("Successfully invoices are archived");
                                    window.location.reload();
                                }else{
                                    alert("invoices are not archived");
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
                alert("Please select atleast one invoice to archived.");
                $(":checkbox").filter(":checked").each(function() {
                    $(this).removeAttr("checked");
                });
            }
		  }else{
			 alert("Please select only paid invoices to archive.");
			 $(":checkbox").filter(":checked").each(function() {
				$(this).removeAttr("checked");
			 });
		  }
        
		}
		function in_array(array, id) {
		  for(var i=0;i<array.length;i++) {
			if(array[i] === id) {
            return true;
			}
		  }
		  return false;
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
        <div id="inner-container2">
        {include file="right-panel.tpl"}
          <div id="center"><div id="squeeze"><div class="right-corner">
            <div id="inner-left-container">
                 <div id="tabbed-inner-nav">
                 <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li ><a href="{$actualPathJSCSS}/my_invoice"><span>My Invoice(Buyer)</span></a></li>
						<li class="active"><a href="{$actualPathJSCSS}/my_invoice?mode=archive_invoice"><span>My Archived Invoices(Buyer)</span></a></li>
                        <li ><a href="{$actualPathJSCSS}/my_invoice?mode=buyer"><span>Reconciliation(Seller)</span></a></li>
                    </ul>
                    
 					
                    </div>
                 </div>
                <div class="innerpage-container-main">
                    <div class="top-mid"><div class="top-left"></div></div>
                
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    {if $total>0}	
                        <!--  inner listing starts-->                    
                        <div class="display-listing-main">
                        {if $key=='2'}
                            <input type="button" onclick="combine_buyer_invoice()" style="font-size:11px;" class="track-btn" value="Combine">
							<input type="button" onclick="archive_invoice()" style="font-size:11px;" class="track-btn" value="Archive Invoice">
                         {/if}   
                        <div>
                            <div class="gnrl-listing">
                            <div style="margin:0 0 0 12px;">
                            
                            <form name="listFrom" id="listForm" action="" method="post">
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                                    <tr>
                                        <th width="45px" class="tac">Sl No</th>
                                        <th class="ta1">Poster Title</th>
                                        <th width="80px" class="tac">Billing Date</th>                                    
                                        <th width="70px" class="tac pr10">Price</th>
                                        <th width="100px" class="tac">Action</th>
                                    </tr>
                                    {section name=counter loop=$invoiceData}
                                    <tr>
                                        
                                       <td class="tac">
                                           {$smarty.section.counter.index+1}
                                       </td>
                                        <td  class="tal">
                                        {section name=adCounter loop=$invoiceData[counter].auction_details}
                                            {$smarty.section.adCounter.index+1}.&nbsp;{$invoiceData[counter].auction_details[adCounter].poster_title|stripslashes} &nbsp;<br />
                                        {/section}
                                        </td>
                                        <td  class="tac">{$invoiceData[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
                                        <td  class="tar">${$invoiceData[counter].total_amount}</td>
                                        <td  class="tac">
                                        {if $invoiceData[counter].is_cancelled == '1'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="../images/print.png" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {elseif $invoiceData[counter].is_paid == '1'}
                                        PAID &nbsp;<a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="../images/print.png" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {elseif $invoiceData[counter].is_paid == '0' && $invoiceData[counter].is_cancelled == '0' && $invoiceData[counter].is_ordered == '0'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=order&invoice_id={$invoiceData[counter].invoice_id}"><img src="../images/pay_now.png" alt="Pay Now" width="67" height="17" title="Pay Now" /></a>
                                        {elseif $invoiceData[counter].is_paid == '1' || $invoiceData[counter].is_cancelled == '1'}
                                        <a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="../images/print.png" onclick="fancy_images({$smarty.section.counter.index})"></a>
                                        {elseif $invoiceData[counter].is_ordered == '1' && $invoiceData[counter].is_cancelled == '0'}
										<a id="various_{$smarty.section.counter.index}" href="{$actualPathJSCSS}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Phone Ordered" title="Phone Ordered" src="../images/success_order.png" onclick="fancy_images({$smarty.section.counter.index})"></a>
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
							<input type="button" onclick="archive_invoice()" style="font-size:11px;" class="track-btn" value="Archive Invoice">
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
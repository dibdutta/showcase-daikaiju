{include file="header.tpl"}
    
    
	
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!-- 	<link rel="stylesheet" href="{$actualPath}/javascript/fancybox/style.css" />-->
 	<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
	<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>
 	<script type="text/javascript" src="{$actualPath}/javascript/formvalidation.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/jquery.validate.js"></script>
 	{literal}
 	<script type="text/javascript">
 	$(document).ready(function() {
		$(function() {
			$("#start_date").datepick();
			$("#end_date").datepick();
		});
 		$("#listFrom").validate();
	});
		//$(document).ready(function() {
			/*
			*   Examples - images
			*/
		function fancy_images(i){
			$("#various_"+i).fancybox({
				'width'				: '88%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		}
			
		//});
		function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':
		                $(this).val('');
		                break;
		            
		        }
		    });
	//$('#search_criteria')[0].reset();
		}
		</script>
 	{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
    <!--Header Theme Starts-->
		  {include file="search-login.tpl"} 
	<!--Header Theme Ends-->
          <!--Header Theme Starts-->
                
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
                        <li ><a href="{$actualPath}/my_report"><span>My Report </span></a></li>
                        <li class="active"><a href="{$actualPath}/my_report?mode=payment_from_mpe"><span>Payments from MPE</span></a></li>
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
                        <div class="display-listing-main">
                        <div>
                            <div class="gnrl-listing">
                            <div style="margin:0 0 0 12px; padding:10px 0 0 0;">
                            {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                            <form name="listFrom" id="listFrom" action="" method="post">
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <input type="hidden" name="mode" value="payment_from_mpe" />
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0" class="mb10">
                                 <tr>
                                <td width="220"><div style="width:80px; float:left; margin-top: 3px;">Start Date&nbsp;</div><input type="text" name="start_date" id="start_date" value="{$start_date}"  class="formlisting-txtfield required" /></td>
								<td width="220"><div style="width:80px; float:left; margin-top: 3px;">End date&nbsp;</div><input type="text" 1 name="end_date" id="end_date"  value="{$end_date}"  class="formlisting-txtfield required" /></td>
								<td><input type="submit" value="Search" class="submit-btn"> <input type="button" value="Reset" class="submit-btn" onclick="reset_date(this.form)" ></td>
								<td width="30"><div style="width:30px; float:left; margin: 3px 0px 0px 13px;"><a id="various_{$smarty.section.counter.index}" href="{$actualPath}/my_report?mode=print_payment_details&start_date={$start_date}&end_date={$end_date}"><img src="../images/print.png" alt="Print" width="15" height="15" title="Print" onclick="fancy_images({$smarty.section.counter.index})"></a></div></td>
							     </tr>
                                
                                </table>
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                                  
                                   
                                   
                                    <tr>
                                        <th width="25">Sl No.</th>
                                        <th width="">Paid Amount</th>                                    
                                        <th width="100">Payment Date</th>
<!--                                        <td><strong>Action</strong></td>-->
                                    </tr>
                                    
                                    {section name=counter loop=$dataPayment}
                                    <tr>                                	
                                        <td align="left" class="tac">
                                         {math equation="x + y" x=$smarty.section.counter.index y=1}.
                                        </td>
                                        <td align="left">${$dataPayment[counter].payment_amount}</td>
                                        <td align="left" class="tac">{$dataPayment[counter].payment_date|date_format:"%m/%d/%Y"}</td>
                                        
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
                            <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry no payment report to display.</td>
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
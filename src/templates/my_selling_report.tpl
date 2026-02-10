{include file="header.tpl"}
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
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
			
		function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':
		                $(this).val('');
		                break;
		            
		        }
		    });
		}
		function check_auction_type(val){
			if(val=='weekly'){
				document.getElementById('auction_week').style.display="block";
			}else{
				document.getElementById('auction_week').style.display="none";
				$("#date_field").show();
				$("#auction_week").val('');
			}
			if(val=='stills'){
        		document.getElementById('auction_stills').style.display="block";
    		}else{
        		document.getElementById('auction_stills').style.display="none";
				$("#auction_stills").val('');
    		}
		}
		function check_auction_week_type(val){
			if(val==''){
				$("#date_field").show();				
			}else{
				$("#date_field").hide();
				$("#start_date").val('');
				$("#end_date").val('');
				
			}
		}
		</script>
 	{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
    <!--Header Theme Starts-->
		  {include file="search-login.tpl"} 
        </div>
        <!--Header themepanel Ends-->    
        <div id="inner-container2">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
        
            <div id="inner-left-container">
                 <div id="tabbed-inner-nav">
                 <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li class="active"><a href="{$actualPath}/my_report.php"><span>My Report </span></a></li>
                        {*<li ><a href="{$actualPath}/my_report.php?mode=payment_from_mpe"><span>Payments from MPE</span></a></li>*}
                    </ul>
                     
                    </div>
                 </div>
                <div class="innerpage-container-main">
                
                   <div class="top-mid"><div class="top-left"></div></div>
                
							
                     <div class="left-midbg"> 
                    <div class="right-midbg">   
                    <div class="mid-rept-bg">					
                    
							
                        <!--  inner listing starts-->                    
                        <div class="display-listing-main">
                        <div>
                            <div class="gnrl-listing">
                            <div style="margin:0 0 0 12px; padding:10px 0 0 0;">
                            {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                            <form name="listFrom" id="listFrom" action="" method="get">
                                <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                <input type="hidden" name="mode" value="view_report" />
                                <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0" class="mb10">
								
                                   <tr>
								     <td width="245"><div style="width:80px; float:left; margin-top: 3px;">Select:</div>
										<select name="auction_type" class="formlisting-txtfield w160"  id='search_id' onchange="check_auction_type(this.value);"  >
											<option value="" selected="selected" >All</option>
											<option value="fixed" {if $auction_type == "fixed"} selected="selected"{/if} >Fixed</option>
											<option value="weekly" {if $auction_type == "weekly"} selected="selected"{/if} >Auction</option>
											 <option value="stills" {if $auction_type == "stills"} selected="selected"{/if} >Stills/Photos</option>
											<!--<option value="monthly" {if $auction_type == "monthly"} selected="selected"{/if} >Monthly</option>-->
										</select>
                                     </td>
									 
									 <td width="230">
										  <select name="auction_week"  class="formlisting-txtfield" id="auction_week" {if $auction_type!='weekly'}style="display: none;"{/if} onchange="check_auction_week_type(this.value);" >
                                            <option value="" selected="selected">All Auction</option>
											{section name=counter loop=$auctionWeek}
												<option value="{$auctionWeek[counter].auction_week_id}" {if $smarty.request.auction_week == $auctionWeek[counter].auction_week_id} selected {/if} >MPE Weekly Auction&nbsp;( {$auctionWeek[counter].auction_week_end_date|date_format:'%D'})</option>
											{/section}
                                         </select>
										 
										 <select name="auction_stills"  class="look" id="auction_stills" {if $auction_type!='stills'}style="display: none;"{/if}>
                                            <option value="" selected="selected">All Stills Auction</option>
											{section name=counter loop=$auctionWeekStills}
												<option value="{$auctionWeekStills[counter].auction_week_id}" {if $smarty.request.auction_stills == $auctionWeekStills[counter].auction_week_id} selected {/if} >MPE Stills Auction&nbsp;( {$auctionWeekStills[counter].auction_week_end_date|date_format:'%D'})</option>
											{/section}
                                         </select>
     								 </td>
									 <td><input type="submit" value="Search" class="submit-btn"> <input type="button" value="Reset Date" class="submit-btn" onclick="reset_date(this.form)"></td>
									 
								   </tr>
								   <tr id="date_field" {if $smarty.request.auction_week!=''} style="display:none;" {/if}>
									<td><div style="width:80px; float:left; margin-top: 3px;">Start Date</div><input type="text" name="start_date" id="start_date" value="{$start_date}"  class="formlisting-txtfield w160" /></td>
									<td><div style="width:65px; float:left; margin-top: 3px;">End Date</div><input type="text" 1 name="end_date" id="end_date"  value="{$end_date}"  class="formlisting-txtfield w160" /></td>
									<td>&nbsp;</td>
							       </tr>
                                   {if $total_sold>0}
                                   </table>
                                   <div style="background-color: #fff; width: 100%; float: left; text-align: center; padding: 10px 0;">
                                   <table width="50%" cellpadding="3" cellspacing="1" align="center" border="0" style="margin:0 auto; border-left:1px solid #DFDFDF; border-bottom:1px solid #DFDFDF;">
								   <tr>
                                        <th colspan="3">Seller: {$userName}</th>
                                        
                                    </tr>
                                   <!--<tr>
                                        <td colspan="3"><strong>&nbsp;</strong></td>
                                        
                                    </tr>-->
									
									<tr >
										<td width="150"  >Total sold:</td >
									  <td><div style="float:left; padding-right: 10px;">&nbsp;{$total_sold}&nbsp;{if $total_sold > 0}&nbsp;(${$total_amount_sold_by_mpe})</div><div style="float:left; padding-top: 0px;"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/icon_view.png" class="iconViewAlign" width="16" height="15" border="0" title="View & Print" style="cursor: pointer;" onclick="javascript:window.open('{$actualPath}/my_report.php?mode=print&search=sold&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$smarty.request.auction_week}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</div></td>
									</tr>
									<tr >
										<td >Total Paid by Buyer:</td >
										<td><div style="float:left; padding-right: 10px;">&nbsp;{$total_paid_by_buyer}&nbsp;{if $total_paid_by_buyer > 0}&nbsp;(${$total_amount_paid_by_buyer})</div><div style="float:left; padding-top: 0px;"> <img src="https://d2m46dmzqzklm5.cloudfront.net/images/icon_view.png" class="iconViewAlign" width="16" height="15" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$actualPath}/my_report.php?mode=print&search=paid_by_buyer&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$smarty.request.auction_week}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</div></td>
									</tr>
									<tr >
										<td  >Total Unpaid by Buyer:</td >
										<td><div style="float:left; padding-right: 10px;">&nbsp;{$total_unpaid}&nbsp;{if $total_unpaid > 0}&nbsp;(${$total_amount_unpaid_by_buyer})</div><div style="float:left; padding-top: 0px;"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/icon_view.png" width="16" height="15" border="0" style="cursor: pointer;" title="View & Print" onclick="javascript:window.open('{$actualPath}/my_report.php?mode=print&search=unpaid&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$smarty.request.auction_week}','mywindow','menubar=1,resizable=1,width=700,height=500,scrollbars=yes')" />{/if}</div></td>
									</tr>
                                    <!--<tr>
                                        <td width="33%"><strong>Poster Title</strong></td>
                                        <td width="33%"><strong>Billing Date</strong></td>                                    
                                        <td width="25%"><strong>Seller Owed</strong></td>
                                    </tr>-->
                                    
                                    {section name=counter loop=$invoiceData}
                                    <!--<tr>                                	
                                        <td align="left">
                                        {section name=adCounter loop=$invoiceData[counter].auction_details}
                                         {math equation="x + y" x=$smarty.section.counter.index y=1}.&nbsp;{$invoiceData[counter].auction_details[adCounter].poster_title}&nbsp;(#{$invoiceData[counter].auction_details[adCounter].poster_sku})<br />
                                        {/section}
                                        </td>
                                        <td align="left">{$invoiceData[counter].paid_on|date_format:"%m/%d/%Y"}</td>
                                        <td align="left">${$invoiceData[counter].total_amount}</td>
                                        
                                    </tr>-->
                                    {/section}
                                    <!--<tr>
										<td align="center" colspan="3">                                        
											<a id="various_{$smarty.section.counter.index}" href="{$actualPath}/my_report.php?mode=print&start_date={$start_date}&end_date={$end_date}&auction_type={$auction_type}&auction_week={$smarty.request.auction_week}"><img alt="Print" title="Print" src="https://d2m46dmzqzklm5.cloudfront.net/images/print.jpg" onclick="fancy_images({$smarty.section.counter.index})"></a>                                     
										</td>
                                    </tr>-->
									{else}
                    
										<tr>
											<td colspan="2" align="center" style="font-size:11px; font-weight:bold;">Sorry No Report to Display.</td>
										</tr>
                   
									{/if} 
                                </table>
                                	</div>
                            </form>
                            </div>
                            </div>		
                        </div>			
                        </div>
                    
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
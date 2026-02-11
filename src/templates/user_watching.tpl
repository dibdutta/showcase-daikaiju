{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>

{literal}
<script type="text/javascript">
$(document).ready(function(){
	dataArr = {/literal}{$json_arr}{literal};
	var mode= {/literal}{if $smarty.request.mode==''}''{else}'{$smarty.request.mode}'{/if}{literal};
	if(mode==''){
		//setInterval(function() { timeLeft(dataArr,'weekly'); }, 2000);	
		setTimeout(function() { timeLeft(dataArr,'weekly'); }, 3000);
	}				   
})

function redirect_poster_details(auction_id)
{
	window.location="buy?mode=poster_details&auction_id="+auction_id;
}
</script>
<script type="text/javascript">
function toggleDiv(id,flagit,type,track) {
 	 var url = "bid_popup.php";
	 if(type==1 && track==1){
	 	$.get(url, {mode : 'offer_popup', id : id}, function(data){
			$('#'+id).html(data);
	 	});
	 }else if(type==0 && track==1){
	 	$.get(url, {mode : 'bid_popup', id : id}, function(data, textStatus){
	 		$('#'+id).html(data);
	 	});
	 }
	if (flagit=="1"){
	document.getElementById(''+id+'').style.visibility = "visible";
	/*if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"*/
	}
	else
	if (flagit=="0"){
	document.getElementById(''+id+'').style.visibility = "hidden";
	/*if (document.layers) document.layers[''+id+''].visibility = "hide"
	else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"*/
	}
}
	function test_enter(auction_id){
		var newData = auction_id.split("_");
		$('#'+newData[2]).html("");
		$("#offer_bttn_"+newData[2]).click();
					 
		}
	function test_enter_for_bid(auction_id){
		var newData = auction_id.split("_");
		$('#'+newData[2]).html("");
		$("#bid_bttn_"+newData[2]).click();
	}	
	function test_blur(auction_id){
		var newData = auction_id.split("_");
		$('#'+auction_id).unbind('keypress');
		$('#offer_bttn_'+newData[2]).unbind('click');

	}
	function test_blur_for_bid(auction_id){
		var newData = auction_id.split("_");
		$('#'+auction_id).unbind('keypress');
		$('#bid_bttn_'+newData[2]).unbind('click');
	}
	function add_note(id){
	  var add_note_text = $('#add_note_text').val();
	  var r=confirm("Are you sure to add this note?");
	  if(r){
		  $.get('user_watching.php', {mode : 'add_note', id : id,add_note_text : add_note_text}, function(data){
				$('#add_note_text').hide();
				$('#add_note_img').hide();
				$('#added_note').html(add_note_text);
			});
	   }
	}
</script>
<style type="text/css">
.popDiv_Auction {
	position:absolute;
	min-width:100px;
	list-style-type:none;
	background-color:#881318;
	visibility:hidden;
	color:white;
	z-index:1000;
	font-size:12px;
	margin-left:260px;
	margin-top:165px;
	padding:6px;
	outline:4px solid #881318;
	border: 1px solid #a3595c;
	}
.div {
	position:absolute;
	min-width:100px;
	list-style-type:none;
	background-color:#881318;
	visibility:hidden;
	color:white;
	z-index:1000;
	font-size:12px;
	margin-left:260px;
	margin-top:165px;
	padding:6px;
	outline:4px solid #881318;
	border: 1px solid #a3595c;
	}	
.popDiv {
	position:absolute;
	min-width:100px;
	list-style-type:none;
	background-color:#881318;
	visibility:hidden;
	color:white;
	z-index:1000;
	left: 510px;
	font-size:12px;
	margin-top:230px;
	padding:6px;
	outline:4px solid #881318;
	border: 1px solid #a3595c;
	}
</style>

{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
	<!--Header themepanel Starts-->
		<div id="headerthemepanel">
	<!--Header Theme Starts-->
		  {include file="search-login.tpl"} 
	<!--Header Theme Ends-->
		</div>
	<!--Header themepanel Ends-->
		
	<!-- page listing starts -->
		<div id="inner-container">
        {include file="right-panel.tpl"}
         <div id="center"><div id="squeeze"><div class="right-corner">
        
			<div id="inner-left-container">
				 <div id="tabbed-inner-nav">
            	<div class="tabbed-inner-nav-left">
					<ul class="menu">
						<li {if $smarty.request.type == ''}class="active"{/if}><a href="{$actualPath}/user_watching"><span>My Auction Watch List</span></a></li>
						<li {if $smarty.request.type=='fixed'}class="active"{/if}><a href="{$actualPath}/user_watching?type=fixed"><span>My Fixed Price Watch List</span></a></li>
						<li {if $smarty.request.type=='sold'}class="active"{/if}><a href="{$actualPath}/user_watching?type=sold"><span>My Sold Watch List</span></a></li>
						
					</ul>
                    
                	</div>
				</div>	
                <form name="listFrom" id="listForm" action="" method="post">
                <input type="hidden" name="mode" value="select_watchlist" />
				<input type="hidden" name="total" value="{$total}" />
				<input type="hidden" name="toshow" value="{$toshow}" />
				<input type="hidden" name="offset" value="{$offset}" />
				<div class="innerpage-container-main">  
                <div class="top-mid"><div class="top-left"></div></div>
                              
					  <div class="left-midbg"> 
                    <div class="right-midbg">                     
					<div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
					<div class="top-display-panel">
								<div class="left-area" style="width:200px;">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">									
                                        <li class="lista"><span class="active"></span> </li>
										|
                                        <li class="grid"><a href="user_watching?view_mode=grid&type={$smarty.request.type}"></a></li>
                                    </ul>
                                </div>
								<div class="sortblock">{$displaySortByTXT}</div>
								<div class="left-area" style="width:300px;">
									<div class="results-area" style="width:150px;">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>                        
							</div>
                    {if $total > 0}
                     <div class="light-grey-bg-inner">    
                           <div class="inner-grey SelectionBtnPanel sortblock">           
							<input type="button" class="select-all-btn" value=""  onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;"/>
							<input type="button" class="deselect-all-btn" value="" onclick="javascript: unMarkSelectedRows('listForm'); return false;" style="cursor:pointer;" />
							<span>
                                <select name="del_mode" class="look" onchange="javascript: this.form.submit();" >
                                    <option value="" selected="selected">With Selected</option>
                                    <option value="delete_all_watching">Delete </option>
                                </select>
                            </span>
							{if $smarty.request.type==''}
                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="" />
							{/if}
                            </div>
                           <div class="clear"></div> 
						</div>                    				                    
						{section name=counter loop=$watchingItems}  
						<!-- start of movie posters --->  	
						<div class="display-listing-main mb02">
                        	<div class="buylist pt20 pb20">
							<table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
                            <tr>
							<td width="25" valign="top" class="pt10 tac">
								  
                                   	<input type="checkbox" name="watching_ids[]" value="{$watchingItems[counter].watching_id}"/>
                                   
						    </td>
							<td width="200" class="buylisttb">
<div><a href="#"><img  class="image-brdr"  src="{$watchingItems[counter].image_path}"  onclick="redirect_poster_details({$watchingItems[counter].auction_id});" style="cursor:pointer;"  /></a>
                                           
										   </div>								
								 
						   </td>
							<td valign="top" class="pr10">
                  <!--3rd td-->  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								    <tr>
        							<td class="pb20"><h1><a href="{$actualPath}/buy?mode=poster_details&auction_id={$watchingItems[counter].auction_id}" style="cursor:pointer;" ><strong>{$watchingItems[counter].poster_title}&nbsp;</strong></a> </h1></td>
      							  </tr>
								    <tr>
									<td class="buylisttbtopbg"></td>
								  </tr>
								    {*<tr>
								 	<td class="pb10">
									<div class="descrp-area">
										<div class="desp-txt"><b>Size : </b> {$watchingItems[counter].poster_size}</div>
										<div class="desp-txt"><b>Genre : </b> {$watchingItems[counter].genre}</div>
										<div class="desp-txt"><b>Decade : </b> {$watchingItems[counter].decade}</div>
										<div class="desp-txt"><b>Country : </b> {$watchingItems[counter].country}</div>
										<div class="desp-txt"><b>Condition : </b> {$watchingItems[counter].cond}</div>
									</div>
        							</td>
								</tr>
								    <tr>
        						 <td class="buylisttbtopbg"></td>
      							</tr>*}
								{if ($smarty.request.type == "sold" ) }
									<tr>										
										<td class="buylist_cbid pb10">Sold Amount <span class="SoldPrice">{if $watchingItems[counter].soldamnt > 0}${$watchingItems[counter].soldamnt|number_format:2}{else}0.00{/if}</span></td>								  
									 
									</tr>
									
									<tr>										
										<td class="buylist_cbid pb10">Sold Date <span class="SoldPrice"> {$watchingItems[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</span></td>			  
									 
									</tr>
									
								{/if}
								{if $watchingItems[counter].auction_is_sold == '0'}
								{if $watchingItems[counter].fk_auction_type_id == 1 }	
								<tr><td>
								<div class="auction-row">											
                                            <div id="auction_data_{$watchingItems[counter].auction_id}" {if $watchingItems[counter].count_offer == 0} style="display:none" {/if}>
                                                
                                                
                                                
                                            </div>
                                        </div>
								</td></tr>
								{/if}
								<tr>
								<td><!--   popup starts -->
								  <div id="{$watchingItems[counter].auction_id}" {if $watchingItems[counter].fk_auction_type_id == '1'} class="Popdiv" {else} class="div" {/if}>
												
                                  </div>
											<!--   popup ends --></td>
								</tr>
								{if $watchingItems[counter].fk_auction_type_id == 1}
									<tr><td>
							<div class="auction-row">
                                    <div id="auction_data_{$watchingItems[counter].auction_id}" >
                                      
                                    </div>
                            </div>
							</td></tr>
									<div id="{$watchingItems[counter].auction_id}" class="popDiv_Auction"> </div>
							{if $watchingItems[counter].auction_is_sold != '3'}
                            		
							 <tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal">${$watchingItems[counter].auction_asked_price|number_format:2}</div>
											
											 </div></td>
										  <td><div>
											<input type="button" id="buynow_bttn_{$watchingItems[counter].auction_id}" value="" onclick="redirect_to_cart({$watchingItems[counter].auction_id}, '{$watchingItems[counter].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
									 
                             <tr><td> 
							{if $watchingItems[counter].auction_reserve_offer_price > 0}
							{if $watchingItems[counter].is_reopened == '0'}
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								
								<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="offer_price_{$watchingItems[counter].auction_id}" id="offer_price_{$watchingItems[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var auc_id=this.id;
			test_enter(auc_id);
			}	
		}); {/literal}" onblur="test_blur(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="offer_bttn_{$watchingItems[counter].auction_id}" value="" onclick="postOffer({$watchingItems[counter].auction_id}, '{$watchingItems[counter].fk_user_id}','{$watchingItems[counter].auction_asked_price}');" class="bidnow-btn makeoffer" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
							</table>
                             
							  {/if}
							  {/if}
							   </td></tr>
                              </table>
                              	</td>
                              </tr>
                                {/if}
								{elseif $watchingItems[counter].fk_auction_type_id == 2 || $watchingItems[counter].fk_auction_type_id=='5'}
									{if  $watchingItems[counter].auction_actual_start_datetime <= $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" && $watchingItems[counter].auction_actual_end_datetime >= $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
										<tr>
										<td class="buylisttbcenter">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td width="65"><div class="boldItalics time-left">Time Left</div></td>
											<td width="146"><div class="timerwrapper" style="float:right">
																	 <!-- <div class="timer-left"></div>-->
																	  <div class="text-timer" id="timer_($watchingItems[counter].auction_id}">{$watchingItems[counter].auction_countdown}</div>
																	  <!--<div class="timer-right"></div>-->
																	  </div></td>
											<td class="pl20"><div class="auction-row" id="auction_end_time_{$watchingItems[counter].auction_id}">
																	  <div class="buy-text boldItalics" style="margin-right:5px">End Time: </div>
																	  <div class="buy-text" style="float:none;">{$watchingItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
																	  <div class="buy-text bold" style="margin-right:5px">{$watchingItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
																	  <div class="buy-text">{$watchingItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
																	</div></td>
										  </tr>
										</table>
										</td>
									  </tr>
								 	{/if} 
								    <tr>
        							<td class="buylisttbbottombg"></td>
      							  </tr>
								 	<div id="{$watchingItems[counter].auction_id}" class="popDiv"> </div>								  
								
								    <tr><td>
								<div id="auction_data_{$watchingItems[counter].auction_id}">
								{if $watchingItems[counter].last_bid_amount > 0}								   
                                    <div class="auction-row">
                                      
                                    </div>								   	
                                 {/if}
								 </div> 
								 </td></tr>
								 	{if  $watchingItems[counter].auction_actual_start_datetime <= $smarty.now|date_format:"%Y-%m-%d %H:%M:%S" && $watchingItems[counter].auction_actual_end_datetime >= $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
                              		 	<tr><td>
                                
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="bid_price_{$watchingItems[counter].auction_id}" id="bid_price_{$watchingItems[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="bid_bttn_{$watchingItems[counter].auction_id}" value="" onclick="postBid({$watchingItems[counter].auction_id}, '{$watchingItems[counter].fk_user_id}',{$watchingItems[counter].auction_buynow_price});" class="bidnow-hammer-btn" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
                                    
                                    
								</table>
                                  </td></tr>
                                 
									{elseif $watchingItems[counter].auction_actual_start_datetime >= $smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
                                        <tr><td>
											<div class="text bold Minimum"><span class="BigFont">This is an upcoming auction</span></div>
										</td></tr>
                                    {else}
										<tr><td>	
                                        	<div class="text bold Minimum"><span class="BigFont">This is an expired auction</span></div>
										</td></tr>	
                                	{/if}
								{/if}
								{elseif $watchingItems[counter].auction_is_sold == '1'}
									{if $watchingItems[counter].highest_bid > 0}
										<tr><td>
                                                <div class="text"><b>Sold For</b> <span class="SoldForPrice">${$watchingItems[counter].highest_bid}</span>&nbsp;&nbsp;
                                                <span class="text"><b class="SoldForCount" >{$watchingItems[counter].count_bid} Bids</b></span></div>
                                            	<!--   popup starts -->
											<div id="{$watchingItems[counter].auction_id}" class="div">
												
                                    		</div>
										</td></tr>
                                    {/if}
									{if $watchingItems[counter].fk_auction_type_id == '1' && $watchingItems[counter].auction_reserve_offer_price > 0}
                                            <tr><td><div class="text"><b>Sold For</b> <span class="SoldForPrice">${$watchingItems[counter].highest_offer}</span>&nbsp;&nbsp;
                                                <span class="text"><b class="SoldForCount" style="cursor:pointer;" onMouseOver="toggleDiv({$watchingItems[counter].auction_id},1,1,1)" onMouseOut="toggleDiv({$watchingItems[counter].auction_id},0,1,0)">{$watchingItems[counter].count_offer} Offers</b></span></div></td></tr>
                                            <!--   popup starts -->
											<tr><td><div id="{$watchingItems[counter].auction_id}" class="Popdiv">
												
                                    		</div></td></tr>
											<!--   popup ends -->
                                    {/if}
									<tr><td><div class="text bold" ><b class="SoldForCount BigFont">This poster has been sold</b></div> </td></tr>
									{if $watchingItems[counter].fk_auction_type_id != '1'}       
                                           <tr><td> <div class="buy-text" style="margin-right:5px;"><b>End Time</b>{$watchingItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
											<div class="buy-text bold" style="float:none;">{$watchingItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
											<div class="buy-text" style="margin-right:5px;">{$watchingItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div></td></tr>
									{/if}
								{elseif  $watchingItems[counter].auction_is_sold == '2'}
                                            <tr><td><div class="text"><b>Sold For</b> <span class="SoldForPrice">${$watchingItems[counter].auction_asked_price}</span></div>
<!--                                        	<span class="text"><b>{$watchingItems[counter].count_offer}</b> Offers</span></div>-->
                                        	<div class="text bold" ><b class="SoldForCount BigFont">This poster has been sold.</b></div></td></tr>
								{elseif  $watchingItems[counter].auction_is_sold == '3'}
                                            <tr><td><div class="text bold" ><b class="SoldForCount BigFont">Sale Pending.</b></div></td></tr>				
								{/if}
							</table></td>
								 </tr>
								 {if ($smarty.request.type <> "sold" ) }
								 <tr>
								 <td colspan="3">
								  <table class="list-view-main" cellpadding="0" cellspacing="0" border="0"  >
								  <tr>
							      <td width="25" valign="top" style="color:#FF0000;" >
								 &nbsp;&nbsp;Notes:
								 
								 </td></tr>
								 <tr>
							      <td width="25" valign="top" style="border-collapse: separate;border-spacing: 2px;border-color: gray;" >
								 
							
							{if $watchingItems[counter].add_note !=''}
							&nbsp;&nbsp;{$watchingItems[counter].add_note}
							
							{else}
							<!--<input type="text" name="add_note_text" id="add_note_text" />-->
							&nbsp;&nbsp;<textarea name="add_note_text" id="add_note_text" style="width:400px;height:70px;"></textarea>
							 <img  alt="Add Note" title="Add Note" src="http://3c514cb7d2d88d109eb9-1000d3d367b7fad333f1e36c27dd4ec3.r35.cf2.rackcdn.com/add_note.png" width="25" onclick="add_note({$watchingItems[counter].watching_id});" id="add_note_img" />	
							<span id="added_note"></span>
							{/if}
							</td></tr>
								  </table>
								 </td>
								 </tr>
								{/if}
							</table>	
                            </div>				
						</div>
						{/section}
						<!-- end of movie posters --->						                    
                        	
                        <div class="top-display-panel2">
								<div class="sortblock">{$displaySortByTXT}</div>
								<div class="left-area">
									<div class="results-area">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>                        
							</div>
                         
                         <div class="light-grey-bg-inner">
                        	<div class="inner-grey SelectionBtnPanel sortblock">
                            <input type="button" class="select-all-btn" value=""  onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;"/>
                            <input type="button" class="deselect-all-btn" value="" onclick="javascript: unMarkSelectedRows('listForm'); return false;" style="cursor:pointer;" />
                            <span><select name="mode" class="look" onchange="javascript: this.form.submit();" >
                            <option value="" selected="selected">With Selected</option>
                            <option value="delete_all_watching">Delete </option>
                            </select></span>
							{if $smarty.request.type ==''}
                                <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="" />
							{/if}	
                            </div>
                            <div class="clear"></div>
                        </div>  
                          
                         
					{else}
						<div class="top-display-panel">No records found!</div>
					{/if}  
                    <div class="clear"></div>                
					</div>
					</div>
                    </div>
                    
                    <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
				</div>
                </form>            
			</div>
            
            </div></div></div>
			
		</div>   
	{include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}
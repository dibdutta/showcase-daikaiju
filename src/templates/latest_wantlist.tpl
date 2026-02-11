{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	dataArr = {/literal}{$json_arr}{literal};
	setTimeout(function() { timeLeft(dataArr); }, 3000);
})

function redirect_poster_details(auction_id)
{
	window.location="buy?mode=poster_details&auction_id="+auction_id;
}
function lightbox_images_poster(){
    $(function() {
        $('#gallery a').lightBox();
    });
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
/*	if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
*/	}
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
</script>
<style type="text/css">.div {position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ;color:white; z-index:1000;font-size:12px;margin-left:220px;margin-top:165px;visibility:hidden; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; }
.Popdiv {position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ;color:white; z-index:1000;font-size:12px; margin-left:220px;visibility:hidden;margin-top:165px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; }
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
						<li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/my_want_list"><span>My Want List </span></a></li>
					</ul>
                    
                    </div>
				</div>
               {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                
				<div class="innerpage-container-main">
					<div class="top-mid"><div class="top-left"></div></div>
                
                    
                     <div class="left-midbg"> 
                     
					<div class="mid-rept-bg">
                    {if $total > 0}				                    
						{section name=counter loop=$mywantlist_array}  
						<!-- start of movie posters --->  	
						<div class="display-listing-main mb02">
                        	<div class="buylist pt20 pb20">
                            
							<table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
                            <tr>
							<td width="200" valign="top" class="buylisttb">
							<div><a href="#"><img  class="image-brdr"  src="{$mywantlist_array[counter].image_path}" border="0" onclick="redirect_poster_details({$mywantlist_array[counter].auction_id});" style="cursor:pointer;" /></a>
                                           
										   </div>	
							</td>
							
							<td valign="top" class="pr10">
                  <!--3rd td-->  <table width="100%" border="0" cellspacing="0" cellpadding="0">
								    <tr>
        							<td class="pb20"><h1><a href="{$actualPath}/buy?mode=poster_details&auction_id={$mywantlist_array[counter].auction_id}" style="cursor:pointer;" ><strong>{$mywantlist_array[counter].poster_title}&nbsp;</strong></a> </h1></td>
      							  </tr>
								    <tr>
									<td class="buylisttbtopbg"></td>
								  </tr>
								    <tr>
								 	<td class="pb10">
									<div class="descrp-area">
											{section name=catCounter loop=$mywantlist_array[counter].categories}
												{if $mywantlist_array[counter].categories[catCounter].fk_cat_type_id == 1}
												<div class="desp-txt"><b>Size : </b> {$mywantlist_array[counter].categories[catCounter].cat_value}</div>
												{elseif $mywantlist_array[counter].categories[catCounter].fk_cat_type_id == 2}
												<div class="desp-txt"><b>Genre : </b> {$mywantlist_array[counter].categories[catCounter].cat_value}</div>
												{elseif $mywantlist_array[counter].categories[catCounter].fk_cat_type_id == 3}
												<div class="desp-txt"><b>Decade : </b> {$mywantlist_array[counter].categories[catCounter].cat_value}</div>
												{elseif $mywantlist_array[counter].categories[catCounter].fk_cat_type_id == 4}
												<div class="desp-txt"><b>Country : </b> {$mywantlist_array[counter].categories[catCounter].cat_value}</div>
												{elseif $mywantlist_array[counter].categories[catCounter].fk_cat_type_id == 5}
												<div class="desp-txt"><b>Condition : </b> {$mywantlist_array[counter].categories[catCounter].cat_value}</div>
												{/if}
											{/section} 
											</div>
        							</td>
								</tr>
								    <tr>
        						 <td class="buylisttbtopbg"></td>
      							</tr>
								
								<!-- Auction Items for Weekly And Stills Starts Here -->
								{if $mywantlist_array[counter].fk_auction_type_id == 2 || $mywantlist_array[counter].fk_auction_type_id=='5'}
								
									<tr>
									<td class="buylisttbcenter">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="65"><div class="boldItalics time-left">Time Left</div></td>
										<td width="146"><div class="timerwrapper" style="float:right">
																 <!-- <div class="timer-left"></div>-->
																  <div class="text-timer" id="timer_($mywantlist_array[counter].auction_id}">{$mywantlist_array[counter].auction_countdown}</div>
																  <!--<div class="timer-right"></div>-->
																  </div></td>
										<td class="pl20"><div class="auction-row" id="auction_end_time_{$mywantlist_array[counter].auction_id}">
																  <div class="buy-text boldItalics" style="margin-right:5px">End Time: </div>
																  <div class="buy-text" style="float:none;">{$mywantlist_array[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
																  <div class="buy-text bold" style="margin-right:5px">{$mywantlist_array[counter].auction_actual_end_datetime|date_format:"%A"}</div>
																  <div class="buy-text">{$mywantlist_array[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
																</div></td>
									  </tr>
									</table>
                                    </td>
								  </tr>
								     <tr>
        							<td class="buylisttbbottombg"></td>
      							  </tr>
								 	<div id="{$mywantlist_array[counter].auction_id}" class="Popdiv"> </div>								  
								
								    <tr><td>
								<div id="auction_data_{$mywantlist_array[counter].auction_id}">
								{if $mywantlist_array[counter].last_bid_amount > 0}								   
                                    <div class="auction-row">
                                      
                                    </div>								   	
                                 {/if}
								 </div> 
								 </td></tr>
                              		 <tr><td>
                                 
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="bid_price_{$mywantlist_array[counter].auction_id}" id="bid_price_{$mywantlist_array[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="bid_bttn_{$mywantlist_array[counter].auction_id}" value="" onclick="postBid({$mywantlist_array[counter].auction_id}, '{$mywantlist_array[counter].fk_user_id}',{$mywantlist_array[counter].auction_buynow_price});" class="bidnow-hammer-btn" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
                                    
                                    
								</table>
                                  </td></tr>
                                  
                              <!-- Auction Items for Weekly And Stills Ends Here -->
							<!-- Fixed Items  Starts Here -->    
                              {elseif  $mywantlist_array[counter].fk_auction_type_id == 1}
									<tr><td>
							<div class="auction-row">
                                    <div id="auction_data_{$mywantlist_array[counter].auction_id}" >
                                      
                                    </div>
                            </div>
							</td></tr>
									<div id="{$mywantlist_array[counter].auction_id}" class="div"> </div>
							{if $mywantlist_array[counter].auction_is_sold != '3'}
                            		
							 <tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal">${$mywantlist_array[counter].auction_asked_price|number_format:2}</div>
											
											 </div></td>
										  <td><div>
											<input type="button" id="buynow_bttn_{$mywantlist_array[counter].auction_id}" value="" onclick="redirect_to_cart({$mywantlist_array[counter].auction_id}, '{$mywantlist_array[counter].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" />
											</div></td>
										  </tr>
										</table>
                                        </div>
                                      </td>
									</tr>
									 
                             <tr><td> 
							{if $mywantlist_array[counter].auction_reserve_offer_price > 0}
							{if $mywantlist_array[counter].is_reopened == '0'}
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								
								<tr>
									  <td class="pb10">
                                      <div class="buylistbid">
                                      <table width="260" border="0" cellspacing="0" cellpadding="0">
										<tr>
										  <td><div ><div class="CurrencyDecimal"> $</div>
											<input type="text" name="offer_price_{$mywantlist_array[counter].auction_id}" id="offer_price_{$mywantlist_array[counter].auction_id}" maxlength="8" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var auc_id=this.id;
			test_enter(auc_id);
			}	
		}); {/literal}" onblur="test_blur(this.id)"  />
											<div class="CurrencyDecimal">.00</div> </div></td>
										  <td><div>
											<input type="button" id="offer_bttn_{$mywantlist_array[counter].auction_id}" value="" onclick="postOffer({$mywantlist_array[counter].auction_id}, '{$mywantlist_array[counter].fk_user_id}','{$mywantlist_array[counter].auction_asked_price}');" class="bidnow-btn makeoffer" style="margin:1px 0 0 0;" />
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
                             {/if} 
							   </td></tr>
                              </table>
                              	</td></tr>		
							</table>
                            <div class="btomgrey-bg"></div>
                            </div>
                         </div>					
						
						{/section}
						<!-- end of movie posters --->
					{else}
						<div class="top-display-panel">No records found!</div>
					{/if}  
                    <div class="clear"></div>                 
					</div>
                    </div>
                    </div>
                    
					<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
				</div>
                
                <div class="light-grey-bg-inner">
<!--                <input type="button" class="select-all-btn"  onclick="javascript: markAllSelectedRows('listForm'); return false;" style=" cursor:pointer;"/>
-->               <!-- <a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a>
                <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                        	
                </div>
                
                         
			</div>
            
            </div></div></div>
			
		</div>   
		{include file="gavelsnipe.tpl"}
	<!-- page listing ends -->
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
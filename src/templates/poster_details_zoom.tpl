{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/magnifier.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/Event.js"></script>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/Magnifier.js"></script>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	
	
	{/literal}
	    {if $itemType=='Stills'}
		 {if $liveStilltrack ==1}
	{literal}
			dataArr = {/literal}{$json_arr}{literal};
			//setInterval(function() { timeLeftPosterDetails(dataArr); }, 1500);	
			setTimeout(function() { timeLeftPosterDetails(dataArr); }, 3000);
	{/literal}
		 {/if}
		{else}
	{literal}	
			dataArr = {/literal}{$json_arr}{literal};
			setTimeout(function() { timeLeftPosterDetails(dataArr); }, 3000);
			//setInterval(function() { timeLeftPosterDetails(dataArr); }, 1500);	
	{/literal}		
		{/if}
	{literal}				   
})
</script>
<script type="text/javascript">
function highlight()
		{
			
			document.getElementById('highlight').style.backgroundColor="#64FE2E";
		}
function toggleDiv(id,flagit,type,track) {
 	 var url = "bid_popup";
	 if(type==1 && track==1){
	 	$.post(url, {mode : 'offer_popup', id : id}, function(data){
			$('#'+id).html(data);
	 	});
	 }else if(type==0 && track==1){
	 	$.post(url, {mode : 'bid_popup', id : id}, function(data, textStatus){
	 		$('#'+id).html(data);
	 	});
	 }
	if (flagit=="1"){
		document.getElementById(''+id+'').style.visibility = "visible";
	//if (document.layers) document.layers[''+id+''].visibility = "show"
	//else if (document.all) document.all[''+id+''].style.visibility = "visible"
	//else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
	}
	else
	if (flagit=="0"){
		document.getElementById(''+id+'').style.visibility = "hidden";
	//if (document.layers) document.layers[''+id+''].visibility = "hide"
	//else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	//else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"
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
	function changeImage(src,id){
		$("#org_id").fadeOut();
		$("#org_id").fadeIn();
		$('#org_id').attr('src', src);
		$('#photo_index').val(id);
		
	}
	function open_new_window(){
		index_id = $('#photo_index').val();
		
		window.open('{/literal}{$actualPath}{literal}/auction_images_large?mode=auction_images_large&id={/literal}{$auctionDetails[0].poster_id}{literal}&auction_id={/literal}{$auctionDetails[0].auction_id}{literal}&page_index='+index_id,'mywindow','menubar=1,resizable=1,width={/literal}{$width+100}{literal},height={/literal}{$height+100}{literal},scrollbars=yes')
	}
</script>
<style type="text/css">.div {position:absolute;  min-width:120px; left:200px; top:50px; list-style-type:none; visibility:hidden;background-color:#881318;color:white; z-index:50;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c;}
.popDiv_Auction{position:absolute;  min-width:120px; left:140px; top:50px; list-style-type:none; visibility:hidden;background-color:#881318;color:white; z-index:50;font-size:12px; margin-left:80px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c;}
</style>

{/literal}

<div id="forinnerpage-container">
 {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}	
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
		<input type="hidden" name="photo_index" id="photo_index" value="0" />
			 <div id="tabbed-inner-nav">
             	<div class="tabbed-inner-nav-left">
             	<ul class="menu" >
                	{*<li><a class="active" href="{$actualPath}/buy"><span>See all Items</span></a></li>*}
                    <li><a href="{$actualPath}/buy?list=fixed"><span>Fixed Price</span></a></li>
					{if $live_count<=1}
                    	<li {if $smarty.request.list == 'weekly' && $smarty.request.track_is_expired != '1'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly"><span>{if $totalLiveWeekly > 0}{$auctionWeeksData[0].auction_week_title}{else}Auction Results{/if}</span></a></li>
                    	{*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy?list=monthly"><span>Event Auctions</span></a></li>*}
                    	{if $upcomingTotal >0}
                    		<li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						{else}
							<li {if $smarty.request.track_is_expired == '1'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly&track_is_expired=1"><span> Auction Results</span></a></li>
						{/if}
						{elseif $live_count>1}
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[0].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[0].auction_week_id}"><span>{$auctionWeeksData[0].auction_week_title}</span></a></li>
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[1].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[1].auction_week_id}"><span>{$auctionWeeksData[1].auction_week_title}</span></a></li>	
						{/if}
						
                    
					<li {if $smarty.request.list == 'alternative'} class="active" {/if}><a href="{$actualPath}/buy?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
					{*<li {if $smarty.request.list == 'stills'} class="active" {/if}><a href="{$actualPath}/buy?list=stills"><span>Fixed Stills</span></a></li>*}
                </ul>
                
                
                </div>	
             </div>
             
             <div class="innerpage-container-main">
             <div class="top-mid"><div class="top-left"></div></div>
                
             
               <div class="left-midbg mb20" style="width:150%"> 
                    <div class="right-midbg whitebg">  
                    
                    <div class="mid-rept-bg">
                    
                    <div class="display-listing-main">
                    
                  	<div>
                  	<!--poster details begins here-->
                    {if $auctionDetails[0].poster_id > 0}
                  	<div class="poster-det-main pt20 pb20" >
                  	
<!--                        <h2>{$auctionDetails[0].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$auctionDetails[0].poster_sku}){/if*}</h2>-->
                    	<div class="for-pict">
							<span style="margin-left:40px; color:#CC0033;">Click image to enlarge</span>
                            <div id="gallery_0" class="image-hldr2" style="padding-bottom:20px;" >
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tac"><tbody><tr><td align="left" valign="middle" style="border:none;">
                                <div class="buygrid_big">
                                       <div>
									    <a class="magnifier-thumb-wrapper demo" href="javascript:void(0)">											
											<img  src="{$auctionDetails[0].large_image}"   border="0"  id="org_id" onmouseover="bigImg(this)" />
										</a>                             								
									
									</div></div>
                            </td></tr></tbody></table>
                               
                                    
									
								{if $auctionDetails[0].total_poster > 1}
								
									<div style="text-align:left; margin-left:10px;">
								 {section name=counter loop=$itemImageArry}
								 	<img src="{$itemImageArry[counter].image_path}" width="80px;" style="cursor:pointer;" onclick="changeImage('{$itemImageArry[counter].big_image}','{$smarty.section.counter.index}')"  />
									{if ($smarty.section.counter.index) != 0}
                                        {if (($smarty.section.counter.index +1) % 4) == 0}                                         
                                         </div> 
										 <div style="text-align:left; margin-left:10px;">
										 {/if}
                                    {/if} 
								 {/section}
								</div>
							{/if}
                            
                            </div> 
                            
                      </div>
					  <!---- Look here -->
						<div class="poster-det-cntnt magnifier-preview example heading"   style="width: 650px; height: 500px" id="preview1">
							
							<div class="mainHeading2 pt10">
								<h2>{$auctionDetails[0].poster_title}&nbsp;{if $smarty.session.sessUserID <> ""}{*$auctionDetails[0].poster_sku*}{/if}</h2>
                        	 
								<div class="clear"></div>
							</div>
                        
							<div class="buylist pt20 pb20">
                        
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
							<tr>
								<td class="pb05">
								{if $auction_key_approved!='0'}
									{if $auctionDetails[0].fk_auction_type_id==1 || $auctionDetails[0].fk_auction_type_id==4}
										<table width="100%" cellpadding="0" cellspacing="0" border="0" align="right" style="padding-right:20px;">
                                
											{if $auctionDetails[0].auction_reserve_offer_price > 0   || $auctionDetails[0].auction_is_sold=='3' || $auctionDetails[0].in_cart=='1'}
												<tr>
													<td valign="top" id="auction_data_{$auctionDetails[0].auction_id}" class="text" colspan="3"><div class="auction-row"></div></td>
												</tr>
											{/if}
											<!--   popup starts -->
												<div id="{$auctionDetails[0].auction_id}" class="popDiv_Auction">
													
												</div>
												<!--   popup ends -->
											{if $auctionDetails[0].auction_is_sold=='0'}
												<tr>
													<td colspan="2" class="pb10">
														<div class="buylistbid">
															<table width="260" cellspacing="0" cellpadding="0" border="0">
																<tr>
																	<td valign="middle"><div><div class="CurrencyDecimal">${$auctionDetails[0].auction_asked_price|number_format:2}</div></div></td>
																	<td valign="top" colspan="2"><input type="button" id="buynow_bttn_{$auctionDetails[0].auction_id}" value="" onclick="redirect_to_cart({$auctionDetails[0].auction_id}, '{$auctionDetails[0].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" /></td>
																</tr>
															</table>
														</div>
													</td>
												</tr>
											
											{if $auctionDetails[0].auction_reserve_offer_price > 0}
												<tr>                                                                          
													<td colspan="2" class="pb10">
														<div class="buylistbid">
															<table width="260" cellspacing="0" cellpadding="0" border="0">
																<tr>
																	<td valign="middle"><div class="CurrencyDecimal">$ </div><input type="text" name="offer_price_{$auctionDetails[0].auction_id}" id="offer_price_{$auctionDetails[0].auction_id}" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13' && keycode != ''){
					var auc_id=this.id;
					test_enter(auc_id);
					}	
				}); {/literal}" onblur="test_blur(this.id)"  /><div class="CurrencyDecimal"> .00</div></td>
																	<td valign="top"><input type="button" id="offer_bttn_{$auctionDetails[0].auction_id}" value="" onclick="postOffer({$auctionDetails[0].auction_id}, '{$auctionDetails[0].fk_user_id}','{$auctionDetails[0].auction_asked_price}');"  class="bidnow-btn makeoffer" style="margin:1px 0 0 0;" /></td>
																</tr>
															</table>
														</div>
													</td>
												</tr>
											{/if}
											{if $auctionDetails[0].auction_is_sold=='0' && $auctionDetails[0].fk_auction_type_id != 4}
												<tr>
													<td>
														<div >
															<div class="CurrencyDecimal">Seller : {$auctionDetails[0].username}</div>											
														</div>
													</td>
												</tr>
											{/if}
										{elseif $auctionDetails[0].auction_is_sold=='1'}
											<tr>
												<td valign="top" class="text" colspan="3">
													<div class="auction-row">
														<div class="buy-text bold">Sold for:</div>
														<div class="buy-text"><span class="offer_buyprice">${$auctionDetails[0].soldamnt|number_format:2}</span></div>
														<div class="buy-text" ><b class="BigFont" >{$auctionDetails[0].count_offer} Offers </b></div>
													</div>
												</td>
											</tr>
										{elseif $auctionDetails[0].auction_is_sold=='2'}
											{if $auctionDetails[0].count_offer == 0 && $auctionDetails[0].auction_reserve_offer_price < 1}
												<tr>
													<td valign="top" colspan="3" >
														<div class="text bold" style="font-size:16px;">This poster has been sold.</div>
													</td>
												</tr>
											{/if}
											<tr>
												<td valign="top" class="text" colspan="3">
													<div class="auction-row"><div class="buy-text bold"><span class="SoldDirect">Sold by direct buy now.</span></div></div>
													<div class="auction-row"><div class="buy-text bold">Sold for:</div><div class="buy-text" ><span class="offer_buyprice">${$auctionDetails[0].soldamnt}</span></div></div>
												</td>
											</tr>
										{/if}
										</table>                                
									{/if}
							{if $auctionDetails[0].fk_auction_type_id==6 }
							
								<table width="100%" cellpadding="0" cellspacing="0" border="0" align="right" style="padding-right:20px;">
								
                                {if $auctionDetails[0].quantity >0}
                                    <tr>
                                    <td colspan="2" class="pb10">
                                    <div class="buylistbid">
                                      <table width="260" cellspacing="0" cellpadding="0" border="0">
                                      <tr>
                                        <td valign="middle"><div><div class="CurrencyDecimal">${$auctionDetails[0].auction_asked_price|number_format:2}</div></div></td>
                                        <td valign="top" colspan="2"><input type="button" id="buynow_bttn_{$auctionDetails[0].auction_id}" value="" onclick="redirect_to_cart({$auctionDetails[0].auction_id}, '{$auctionDetails[0].fk_user_id}')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" /></td>
                                        </tr>
                                        </table>
                                        </div>
                                        </td>
                                    </tr>
                                   
                                {else}
                                	<tr>
                                  	<td valign="top" colspan="3" >
                                   	<div class="text bold" style="font-size:16px;">This poster has been sold.</div>
                                  	</td>
                                 	</tr>
                                
                                {/if}
                            </table>
							{/if}
                            {if $auctionDetails[0].fk_auction_type_id==2 || $auctionDetails[0].fk_auction_type_id == 5}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="right">
                                
                                <tr>
                                    <td class="text" colspan="3" id="auction_data_{$auctionDetails[0].auction_id}">
									{if $auctionDetails[0].count_bid > 0}
									<div class="auction-row">
									
									</div>
									{/if}
									</td>
                                </tr>
                                
								<!--   popup starts -->
								<div id="{$auctionDetails[0].auction_id}" class="div">
												
                                </div>
								<!--   popup ends -->
                               <!--<tr>
                                    <td class="text" colspan="3"><b>Highest Bid:</b>{$auctionDetails[0].highest_bid}</td>
                               </tr>-->
                               {if $auctionDetails[0].is_selling == 1}                             
                                    <tr>
                                    <td class="pb10">
 									<div class="buylistbid">
                                     <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                     <tr>
                                        <td valign="middle" class=""><div class="CurrencyDecimal">$</div>&nbsp;<input type="text" name="bid_price_{$auctionDetails[0].auction_id}" id="bid_price_{$auctionDetails[0].auction_id}" class="inner-txtfld fll" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)" /><div class="CurrencyDecimal">.00</div></td>
										<td><!--<b>Start Price</b> ${$auctionDetails[0].auction_asked_price|number_format:2}-->
										<input type="button" id="bid_bttn_{$auctionDetails[0].auction_id}" value="" onclick="postBid({$auctionDetails[0].auction_id}, '{$auctionDetails[0].fk_user_id}',{$auctionDetails[0].auction_buynow_price});" class="bidnow-hammer-btn"/>
										</td>
                                     </tr>
                                     </table>
                                     </div>
                                     </td>
                                        
                                        <!--<td valign="top" class="text"></td>-->
                                    </tr> 
                                    <!--   popup starts -->
										<div id="{$auctionDetails[0].auction_id}" class="div">
												
                                		</div>
									<!--   popup ends -->            
                                    {if $auctionDetails[0].auction_buynow_price > 0}
                                        <tr>
                                            <td valign="middle" class="text"><b>Buy Now</b> &nbsp;<span class="buynowprice">${$auctionDetails[0].auction_buynow_price|number_format:2}</span></td>
                                            <td valign="top" colspan="2" class="text"><input type="button" id="buynow_bttn_{$auctionDetails[0].auction_id}" value="Buy Now!!" onclick="redirect_to_cart({$auctionDetails[0].auction_id},'{$auctionDetails[0].fk_user_id}')" class="bidnow-btn BuyNow" /></td>
                                        </tr>
                                    {/if}
                                {/if}   
                                <tr>
								<td class="buylisttbtopbg" colspan="2"></td>
						  		</tr>  
                                <tr>
                                    <td valign="top" colspan="3" class="buylisttbcenter">                                       
                                        <div id="auction_{$auctionDetails[0].auction_id}">
                                        {if $auctionDetails[0].auction_is_sold=='0'}
                                            {if $auctionDetails[0].is_selling == 1}
                                                <div class="" style="width:125px; float:left; margin-right:5px;">
                                                    <div class="boldItalics time-left" style="padding-top:0;">Time Left:</div>
                                                    <div class="timerwrapper">
                                                    <div class="text-timer" id="timer_($auctionDetails[0].auction_id}">{$auctionDetails[0].auction_countdown}</div>
                                                    </div>
                                                </div>
                                              {else}
                                                <div class="" style="width:125px; float:left;">
                                                <div style="width:170px; float:left;">
                                                <div class="buy-text boldItalics" style="margin-right:5px;" >Start Time</div>
                                                    <div class="buy-text" style="float:none;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    <div class="buy-text bold" style="margin-right:5px;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%A"}</div>
                                                    <div class="buy-text">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                                </div> 
                                                </div>
                                                
                                             {/if}
                                          {elseif $auctionDetails[0].auction_is_sold=='1'}
                                             <div>
												 <div style="width:170px; float:left;">
												 <div class="buy-text bold">Sold for:</div>
												 <div class="buy-text"><span class="offer_buyprice">${$auctionDetails[0].max_bid_amount|number_format:2}</span></div>
												 <div class="buy-text"><b class="BigFont"   >{$auctionDetails[0].bid_count} Bids</b></div>
												 </div>
                                             </div>
                                             <!--   popup starts -->
												<div id="{$auctionDetails[0].auction_id}" class="div">
												
                                				</div>
											<!--   popup ends -->
                                          {else}
                                            <tr>
                                                <td valign="top" class="text" colspan="3">
                                                <div>
                                                <div style="width:170px; float:left;">
                                                <div class="buy-text bold"><span class="message">Sold by direct buy now.</span></div>
                                                </div>
                                                <div class="auction-row">
                                                <div class="buy-text bold">Sold for:</div>
                                                <div class="buy-text" ><span class="offer_buyprice">${$auctionDetails[0].soldamnt}</span></div>
                                                </div></div>
                                                </td>
                                            </tr>
                                         {/if}
                                         {if $auctionDetails[0].auction_is_sold!='2' && $smarty.session.sessUserID <> ""}
                                            <div>
                                            <div style="width:170px; float:left;">
                                                <div class="buy-text boldItalics" style="margin-right:5px;">End Time: </div>
                                                <div class="buy-text" style="Float:none;">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                <div class="buy-text bold" style="margin-right:5px;">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%A"}</div>
                                                <div class="buy-text">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                            </div></div>
                                        {/if} 
                                        </div>
                                    </td>
                                </tr>  
                                                       
                            </table>
                            {/if}
							{else}
                           <div class="BigFont bold">This is an unapproved poster.
                    		</div>  
                            {/if}
                            
                            
                            </td>
                          </tr>
                         
                          <tr>
							<td class="buylisttbtopbg"></td>
						  </tr>
                          <tr>
                            <td class="pt10 pb10">
                            <div class="socialIcon">
                             	<div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_facebook"></a>
                                <a class="addthis_button_twitter"></a>                                
								<a class="addthis_button_pinterest_pinit"></a>
								<a class="addthis_button_tumblr"></a>
                                </div>
								<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e76e64247cca97b"></script>
                        	</div>
                            </td>
                          </tr>
                          <tr>
							<td class="buylisttbbottombg"></td>
						  </tr>
                          <tr>
                            <td class="pt10 pb10"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
                                
                                {if $auctionDetails[0].fk_auction_type_id!='6'}
								<tr>
                                    <td colspan="3" class="descrp-area">
                                        <b>Size:</b> {$auctionDetails[0].poster_size}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="descrp-area"><b>Genre:</b> {$auctionDetails[0].genre}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="descrp-area"><b>Decade:</b> {$auctionDetails[0].decade}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="descrp-area"><b>Country:</b> {$auctionDetails[0].country}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="descrp-area"><b>Condition:</b> {$auctionDetails[0].cond}</td>
                                </tr>
								{else}
								<tr>
                                    <td colspan="3" class="descrp-area"><i>{$auctionDetails[0].poster_size}</i>
                                    </td>
                                </tr>
								<tr>
                                    <td colspan="3" class="descrp-area"><i>{$auctionDetails[0].artist}</i></td>
                                </tr>
							   {if $auctionDetails[0].field_1 <> ''}
								<tr>
									<td colspan="3" class="descrp-area"> <i>{$auctionDetails[0].field_1}</i></td>
								</tr>
								{/if}
								{if $auctionDetails[0].field_2 <> ''}
								<tr>
									<td colspan="3" class="descrp-area"><i>{$auctionDetails[0].field_2}</i></td>
								</tr>
								{/if}
								{if $auctionDetails[0].field_3 <> ''}
								<tr>
									<td colspan="3" class="descrp-area"><i>{$auctionDetails[0].field_3}</i></td>
								</tr>
								{/if}
                                {/if}
								{if $auctionDetails[0].imdb_link!=''}
								<tr>
                                    <td colspan="3" class="descrp-area" style=" background-color:#FFFF00;"><a href="{$auctionDetails[0].imdb_link}" target="_blank" style="text-decoration:none;color:#000000;" ><b>View film details at IMDb&nbsp;&nbsp;&nbsp;</b></a></td>
                                </tr>
                               {/if}
                            
                            	{if $auctionDetails[0].fk_auction_type_id==3}
                                  <tr>
                                   <td colspan="3" class="descrp-area"><b class="EventType" style="border:none; margin:0; padding-right:0;  padding-top:0;  padding-bottom:0;">Event :</b>{$auctionDetails[0].event_title}</td>
                                 </tr>
                                {/if} 
								<tr><td colspan="3" class="descrp-area"><div class="poster-area-list">   
							{if $smarty.session.sessUserID <> "" &&  $auctionDetails[0].fk_auction_type_id <>6 }                	  
                            {if $auctionDetails[0].watch_indicator ==0 && $auctionDetails[0].auction_is_sold=='0' &&  $auction_key_approved!='0'}									
                                
                                 <input type="button" value="Watch this item" class="track-btn"  onclick="add_watchlist({$auctionDetails[0].auction_id});" id="watch_{$auctionDetails[0].auction_id}" />
                            {elseif $auctionDetails[0].auction_is_sold=='0' && $auctionDetails[0].watch_indicator >0}
                                <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$auctionDetails[0].auction_id});" class="track-btn"  />

                            {/if} 
							{/if}
</div></td></tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td>
                            <div class="dashboard-main2"><h2>Description</h2>
                            <p>{$auctionDetails[0].poster_desc}</p></div>
                            </td>
                          </tr>
                        </table>

                        </div>
                        
                        
                        <!--   --->      
                            {if $auction_key_approved!='0'}                              
                                                          
                            {if $auctionDetails[0].fk_auction_type_id==3}
                            <table width="62%" cellpadding="0" cellspacing="0" border="0" align="right" style="padding-right:10px;">
                              
							
                              {if $auctionDetails[0].auction_is_sold=='0' && $auctionDetails[0].auction_actual_end_datetime > $smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}  
							   
									<tr>
										<td class="text" colspan="3" id="auction_data_{$auctionDetails[0].auction_id}">
										{if $auctionDetails[0].count_bid >0}
										<div class="auction-row">
										</div>
										{/if}
										</td>
									</tr>
							   <!--   popup starts -->
								<div id="{$auctionDetails[0].auction_id}" class="div">
												
                                </div>
								<!--   popup ends -->	
                              {elseif $auctionDetails[0].auction_is_sold=='1'}
                              <tr>
                                    <td class="text" colspan="3" >
                                    <div class="auction-row">
                                    <div class="buy-text bold">Sold for:</div>
                                    <div class="buy-text"><span class="offer_buyprice">${$auctionDetails[0].highest_bid|number_format:2}</span></div>
                                    <div class="buy-text"><b class="BigFont" style="cursor:pointer;" onMouseOver="toggleDiv('{$auctionDetails[0].auction_id}',1,0,1)" onMouseOut="toggleDiv('{$auctionDetails[0].auction_id}',0,0,0)">{$auctionDetails[0].count_bid} Bids</b></div>
                                    </div>
                                    </td>
                               </tr>
                               <!--   popup starts -->
								<div id="{$auctionDetails[0].auction_id}" class="div">
												
                                </div>
								<!--   popup ends -->
                              {else}
                              	<tr>
                                    <td class="text" colspan="3" >
                                    <div class="auction-row">
                                    <div class="buy-text bold">This poster has been unsold.</div>
                                    </div>
                                    </td>
                               </tr>
                              {/if}  
                             {*/if*}  
                                
                                <tr>
                                        <td valign="top" align="right" colspan="3">
                                            {if $auctionDetails[0].auction_reserve_offer_price > 0}
                                                <div  id="rp_{$auctionDetails[0].auction_id}">
                                                </div>
                                             {else}
                                            	<div class="text NoPrice" style="font-size:11px;">(No Reserve)</div>   
                                            {/if}
                                        </td>
                                    </tr>
                                {if $auctionDetails[0].auction_is_sold!='1' }
                                    {if $auctionDetails[0].is_selling == 1}
                                    <tr>
                                    <td>
                                    <div class="buylistbid">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td valign="middle" class="text">
                                        $&nbsp;
                                        <input type="text" name="bid_price_{$auctionDetails[0].auction_id}" 
                                        id="bid_price_{$auctionDetails[0].auction_id}" maxlength="8" class="inner-txtfld" onfocus="{literal}$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
			var auc_id=this.id;
			test_enter_for_bid(auc_id);
			}	
		}); {/literal}" onblur="test_blur_for_bid(this.id)" />.00
                                        </td>  
										<td valign="top" class="text" align="right">
                                       <!-- <b>Start Price</b> ${$auctionDetails[0].auction_asked_price|number_format:2}-->
									   <input type="button" id="bid_bttn_{$auctionDetails[0].auction_id}" value="Bid Now!!" onclick="postBid({$auctionDetails[0].auction_id}, '{$auctionDetails[0].fk_user_id}',{$auctionDetails[0].auction_buynow_price});" class="bidnow-hammer-btn" />
                                        </td>                           
                                   </tr>
                                   </table>
                                   </div>
                                   </td>
                                    </tr>
                                     
                                    
                                    {/if}
                                
                                {/if}
                                <tr>
                                    <td valign="top" colspan="3">                                        
                                    <div id="auction_{$auctionDetails[0].auction_id}">
                                        <div class="auction-row">
                                         {if $auctionDetails[0].auction_is_sold!='1'}
                                            {if $auctionDetails[0].is_selling == 1}
                                                <div class="time-left boldItalics" style="padding-top:0;">Time Left</div> 
                                                <div class="timerwrapper" style="float:right">                                           
                                                <div class="timer-left"></div>
                                                <div class="text-timer" id="timer_($auctionDetails[0].auction_id}">{$auctionDetails[0].auction_countdown}</div>
                                                <div class="timer-right"></div>
                                                </div>
                                                <div class="clear"></div>
                                            {else}
                                            	{if $auctionDetails[0].auction_is_sold=='0' && $auctionDetails[0].auction_actual_end_datetime > $smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}  
                                                	<div class="auction-row">
                                                    	<div class="buy-text boldItalics" style="margin-right:5px;">Start Time</div>
                                                    	<div class="buy-text" style="float:none;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    	<div class="buy-text bold" style="margin-right:5px;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%A"}</div>
                                                    	<div class="buy-text">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                                	</div> 
                                                {/if}
                                            {/if}
                                         {/if}
                                            <div class="auction-row">
                                                    <div class="buy-text boldItalics" style="margin-right:5px;" >Start Time</div>
                                                    <div class="buy-text" style="float:none;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    <div class="buy-text bold" style="margin-right:5px;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%A"}</div>
                                                    <div class="buy-text">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                                </div>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                
                            </table>
                            {/if}
                            
                            {/if}
                            
							<div class="clear"></div>
                        
                       </div>                        
                        <div class="clear"></div> 
                        
                        			
                        </div>  
                    <!-- poster details ends here-->
                    
                    {else}
					<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                    	<tr>
                    		<td align="center" style="font-size:11px; font-weight:bold;">No poster found.</td>
                    	</tr>
					</table>
                    {/if}
                    </div>
                    </div>
                    
                    <div class="clear"></div>
                    </div>
                    
                    </div>
                    </div>
                    
             
             </div>
             
             
         </div>
         
            
             </div></div></div>
            
        </div>  
		{*include file="gavelsnipe.tpl"*}
		<!-- page listing ends -->
		</div>
		<div class="clear"></div>
   </div>
{literal}
<script>

function bigImg(imgBig){
    //console.log(imgBig)
    imgArr=imgBig.src.split('/');
	imgBigC="https://d2bqhgoagefnx4.cloudfront.net/"+imgArr[3]
	console.log(imgBig.src)
	$('#org_id-lens').css('background-image', 'url(' + imgBig.src + ')');
	$('#org_id-large').attr('src', imgBigC);
	
	var evt = new Event(),
		m = new Magnifier(evt, {
			largeWrapper: document.getElementById('preview1')
		})
		;

	m.attach({
		thumb: '#org_id',
		large: imgBigC,
		largeWrapper: 'preview1',
		zoom: 2,
		zoomable: false
	});
}

</script>
{/literal}
{include file="foot.tpl"}
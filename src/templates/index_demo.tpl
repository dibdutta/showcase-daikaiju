{include file="header-index.tpl"}
{literal}

<script>
function tipsy(id){
    $('#'+id).tipsy({fade: true});
  }
$(function(){
	$('#slides_1').slides({
		preload: true,
		generateNextPrev: true,
		generatePagination: false
	});
});
$(function(){
	$('#slides_2').slides({
		preload: true,
		generateNextPrev: true,
		generatePagination: false
	});
});
$(function(){
	$('#slides_3').slides({
		preload: true,
		generateNextPrev: true,
		generatePagination: false
	});
});
$(function(){
	$('#slides_4').slides({
		preload: true,
		generateNextPrev: true,
		generatePagination: false
	});
});
function formSubmit()
{
document.getElementById("frm1").submit();
}
</script>
{/literal}


<div id="outer-container">
<div id="wrapper">
    <div class="featuredgallerydiv">
    
    <div id="fg_leftdiv">
    		<!-- Slider Div  -->
            <div id="container">
          	<div id="example">
			<!--<img src="img/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">-->
			<div id="slides">
			  <div class="slides_container slides_containerbg" style="width:570px;">
				{section name=counterslider loop=$dataArrSlider}
			  		<div class="slide">
						<a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrSlider[counterslider].auction_id}" title="{$dataArrSlider[counterslider].poster_title}" ><img src="{$dataArrSlider[counterslider].big_image}"  alt="Slide 2"></a>
						<div class="caption">
							<p>{$dataArrSlider[counterslider].poster_title}</p>
					  </div>
				</div>
			  {/section}				
				
			  </div>
				<a href="#" class="prev"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
			<img src="https://d2m46dmzqzklm5.cloudfront.net/images/example-frame.png" alt="Example Frame" name="frame" width="739" height="500" id="frame">
		</div>
        </div>
            </div>
            
             <div id="fg_rightdiv">
             <div class="newsletter">
             <h3>Join Our Mailing List</h3>
             <form name="ccoptin" id="frm1" action="https://visitor.r20.constantcontact.com/d.jsp" target="_blank" method="post" style="margin-bottom:2;">
             <div style="width:315px; height:27px; border:1px solid #cecfd0; float:left; margin:0 0 10px 0; background-color:#fff;">
				<input type="hidden" name="llr" value="bwdjsljab">
				<input type="hidden" name="m" value="1109563576001">
				<input type="hidden" name="p" value="oi">
				<input type="text" name="ea" size="20" value="" style="float:left\9;" /> <input name="" type="button" onclick="formSubmit();" style="float:right\9;" />
                </div>
				<!-- Here will be our enter button-->
				<!--<input type="submit" name="go" value="Go" class="submit" style="font-family:Verdana,Geneva,Arial,Helvetica,sans-serif; font-size:10pt;">-->
			</form>
             </div>
            <!-- <div class="clear"></div>
             <div class="bannersidebar pb12"><table width="315" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="bannersidebartopbg"></td>
    </tr>
  <tr>
    <td class="bannersidebarcenter pl14 pr10">
    <a href="{$smarty.const.BANNER_LINK}"><h3>Click Here</h3>
    <h1>{$smarty.const.BANNER_TITLE}</h1></a>
    </td>
  </tr>
  <tr>
    <td class="bannersidebarbottombg"></td>
  </tr>
             </table>
</div>-->
<div class="clear"></div>
			 <div style="padding:6px 0;" class="dashboard-main">
			 <div class="dashblock mr24" style="margin-left:-15px; width:300px;">
                                      
                  						<table width="100%" cellpadding="0" cellspacing="0" border="0"  >
                                        	<tr>
                                                <th width="80%" align="left" valign="top" class="tal" style="background-color:#bd1a21; color:#FFFFFF;">Event Calendar</th>                                            
                                            </tr>
                                        </table>
                                        <div class="scrollable" style="width:300px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:30px; color: blue;">                                            
                                            
                                            <tr>
                                                <td  width="100%"><b><i><u><a href="{$calenderArray.auction_1_link}" style="color: blue;font-size:15px;">{$calenderArray.auction_1} </a></u></i></b></td>
                                            </tr>                                        
                                             <tr>
                                                <td  width="100%"><b><i><u><a href="{$calenderArray.auction_2_link}" style="color: blue;font-size:15px;">{$calenderArray.auction_2} </a></u></i></b></td>
                                            </tr> 
											<tr>
                                                <td  width="100%"><b><i><u><a href="{$calenderArray.auction_3_link}" style="color: blue;font-size:15px;">{$calenderArray.auction_3} </a></u></i></b></td>
                                            </tr> 
											<tr>
                                                <td  width="100%"><b><i><u><a href="{$calenderArray.auction_4_link}" style="color: blue;font-size:15px;">{$calenderArray.auction_4} </a></u></i></b></td>
                                            </tr> 
											<tr>
                                                <td  width="100%"><b><i><u><a href="{$calenderArray.auction_5_link}" style="color: blue;font-size:15px;">{$calenderArray.auction_5} </a></u></i></b></td>
                                            </tr> 
                                        </table>
                                        
                                      </div>
                                        
                                        <div class="dashboard-main_shadow" style="width:300px;"></div>
                                    </div>
			 </div>
             <div class="clear"></div>
             <div class=" pb05"><a href="http://www.gavelsnipe.com/" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/banner_gavel.png" width="315" height="42" /></a></div>
             <div class="clear"></div>
             <div>            
			<table cellspacing="0" cellpadding="0" border="0" width="310" height="280">
				<tbody>
					<tr>
						<td>
						<table cellspacing="0" cellpadding="0" border="0" width="310" class="npa">
							<tbody>
								<tr>
									<td colspan="3" class="featuredposter_header" style="padding:8px;"><span><a href="{$dataArrSmall[0].home_link}">{$dataArrSmall[0].home_text}</a></span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td>
						<table cellspacing="0" cellpadding="0" border="0" width="310" id="npa" style="border:0;">
							<tbody>
								<tr>
									<td width="148" class="tac vat pt10 pl10 pr10 pb10"><a href="{$dataArrSmall[0].home_link}"><img  src="{$dataArrSmall[0].image_path}" alt="" /></a></td>
									
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
             </div>            
             </div>
            
    </div>
<form name="listFrom" id="listFrom"><input type="hidden" name="mode" value="select_watchlist" />
<input type="hidden" name="is_track" id="is_track" value="" />	
{if $totWeekly > 1}    
<div class="home_fi">
<h2>Featured Auction Items</h2>

<div id="slides_1" style="margin-top:25px;">
		<div class="slides_container1 slider1 slides_container" style="width:950px;">
			
			<div class="slide" style="width:970px;">			
			 {section name=counter loop=$dataArrWeekly}
			 {assign var="count" value=$smarty.section.counter.index}
				<div class="item">
					<div class="fisdiv"><a href="#"><img class="image-brdr" src="{$dataArrWeekly[counter].image_path}" alt="" onclick="redirect_poster_details({$dataArrWeekly[counter].auction_id});" style="cursor:pointer;" id="{$dataArrWeekly[counter].auction_id}" /></a></div>
                    <div class="fisdetails">
					{if $smarty.session.sessUserID <> ""}
                    	<h2 class="pb10">${if $dataArrWeekly[counter].last_bid_amount|number_format:2 > 0}{$dataArrWeekly[counter].last_bid_amount|number_format:2}{else}{$dataArrWeekly[counter].auction_asked_price|number_format:2}{/if}</h2>
					{/if}
                    <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrWeekly[counter].auction_id}" title="{$dataArrWeekly[counter].poster_title}"  id="tipsy_{$dataArrWeekly[counter].auction_id}" onMouseOver="tipsy(this.id)" ><h3 class="pb10">{$dataArrWeekly[counter].poster_title|substr:0:10}..</h3></a>
					{if $dataArrWeekly[counter].watch_indicator == 0}
                    <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrWeekly[counter].auction_id}');" id="watch_{$dataArrWeekly[counter].auction_id}" />
					{else}
					<input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrWeekly[counter].auction_id});" class="track-btn" />
					{/if}
                    </div>
			  </div>		
                
			  {if ($smarty.section.counter.index) != 0}
				{if (($smarty.section.counter.index +1) % 4) == 0 && ($smarty.section.counter.index) <= 11} 
				 <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
				 </div>
				 {if $smarty.section.counter.index < 11}
				 <div class="slide" style="width:970px;">
				 {/if}
				 {/if}
			  {/if}
			  {/section}
			  {if $count < 11}
				</div>		
			  {/if}
		</div>
	</div>

<div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=weekly');" /></div>
</div>    
{/if} 

{if $totUpcoming > 1}    
<div class="home_fi">
<h2>Featured Upcoming Auction</h2>

<div id="slides_4" style="margin-top:25px;">
		<div class="slides_container4 slider4 slides_container" style="width:950px;">
			
			<div class="slide" style="width:970px;">			
			 {section name=counter loop=$dataArrUpcoming}
			 {assign var="count" value=$smarty.section.counter.index}
				<div class="item">
					<div class="fisdiv"><img src="{$dataArrUpcoming[counter].image_path}" style="cursor:pointer;" id="{$dataArrUpcoming[counter].auction_id}"  onclick="redirect_poster_details({$dataArrUpcoming[counter].auction_id});" /></div>
                    <div class="fisdetails">
					{if $smarty.session.sessUserID <> ""}
                    	<h2 class="pb10">${$dataArrUpcoming[counter].auction_asked_price|number_format:2}</h2>
					{/if}
                    <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrUpcoming[counter].auction_id}" title="{$dataArrUpcoming[counter].poster_title}"  id="tipsy_{$dataArrUpcoming[counter].auction_id}" onMouseOver="tipsy(this.id)" ><h3 class="pb10">{$dataArrUpcoming[counter].poster_title|substr:0:10}..</h3></a>
					{if $dataArrUpcoming[counter].watch_indicator == 0}
                    <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrUpcoming[counter].auction_id}');" id="watch_{$dataArrUpcoming[counter].auction_id}" />
					{else}
					<input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrUpcoming[counter].auction_id});" class="track-btn" />
					{/if}
                    </div>
			  </div>		
                
			  {if ($smarty.section.counter.index) != 0}
				{if (($smarty.section.counter.index +1) % 4) == 0 && ($smarty.section.counter.index) <= 11} 
				 <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
				 </div>
				 {if $smarty.section.counter.index < 11}
				 <div class="slide" style="width:970px;">
				 {/if}
				 {/if}
			  {/if}
			  {/section}
			  {if $count < 11}
				</div>		
			  {/if}
		</div>
	</div>

<div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=upcoming');" /></div>
</div>    
{/if} 	
{if $totFixed > 0}    
<div class="home_fi">
<h2>Featured Items for Sale</h2>

<div id="slides_3" style="margin-top:25px;">
		<div class="slides_container3 slider3 slides_container" style="width:950px;">
			
			<div class="slide" style="width:970px;">			
			 {section name=counter loop=$dataArrFixed}
			 {assign var="count" value=$smarty.section.counter.index}
				<div class="item">
					<div class="fisdiv"><img src="{$dataArrFixed[counter].image_path}" style="cursor:pointer;" id="{$dataArrFixed[counter].auction_id}"  onclick="redirect_poster_details({$dataArrFixed[counter].auction_id});" /></div>
                    <div class="fisdetails">
					{if $smarty.session.sessUserID <> ""}
                   	 <h2 class="pb10">${$dataArrFixed[counter].auction_asked_price|number_format:2}</h2>
					{/if}
                    <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrFixed[counter].auction_id}" title="{$dataArrFixed[counter].poster_title}"  id="tipsy_{$dataArrFixed[counter].auction_id}" onMouseOver="tipsy(this.id)" ><h3 class="pb10">{$dataArrFixed[counter].poster_title|substr:0:10}..</h3></a>
					{if $dataArrFixed[counter].watch_indicator == 0}
                    <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrFixed[counter].auction_id}');" id="watch_{$dataArrFixed[counter].auction_id}" />
					{else}
					<input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrFixed[counter].auction_id});" class="track-btn" />
					{/if}
                    </div>
			  </div>		
                
			  {if ($smarty.section.counter.index) != 0}
				{if (($smarty.section.counter.index +1) % 4) == 0 && ($smarty.section.counter.index) <= 11} 
				 <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
				 </div>
				 {if $smarty.section.counter.index < 11}
				 <div class="slide" style="width:970px;">
				 {/if}
				 {/if}
			  {/if}
			  {/section}
			  {if $count < 11}
				</div>		
			  {/if}
		</div>
	</div>

<div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=fixed');" /></div>
</div>    
{/if}    
 
 
{if $totJstFinished > 0}   
<div class="home_fi">
<h2>Featured Sales Results</h2>

<div id="slides_2" style="margin-top:25px; margin-bottom:-38px;">
		<div class="slides_container2 slider2 slides_container" style="width:950px;">
			
			<div class="slide" style="width:970px;">			
			 {section name=counter loop=$dataJstFinishedAuction}
			 {assign var="count" value=$smarty.section.counter.index}
				<div class="item">
					<div class="fisdiv"><img class="image-brdr" src="{$dataJstFinishedAuction[counter].image_path}"   alt=""  onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;"  id="{$dataJstFinishedAuction[counter].auction_id}"/></div>
                    <div class="fisdetails">
					{if $smarty.session.sessUserID <> ""}
                    	<h2 class="pb10">${if $dataJstFinishedAuction[counter].soldamnt==''}0.00{else}{$dataJstFinishedAuction[counter].soldamnt}{/if}</h2>
					{/if}	
					<a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" title="{$dataJstFinishedAuction[counter].poster_title}" id="tipsy_{$dataJstFinishedAuction[counter].auction_id}" onMouseOver="tipsy(this.id)" ><h3 class="pb10">{$dataJstFinishedAuction[counter].poster_title|substr:0:10}..</h3></a>                    
					
                    </div>
			  </div>		
                
			  {if ($smarty.section.counter.index) != 0}
				{if (($smarty.section.counter.index +1) % 4) == 0 && ($smarty.section.counter.index) <= 11} 
				 <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
				 </div>
				 {if $smarty.section.counter.index < 11}
				 <div class="slide" style="width:970px;">
				 {/if}
				 {/if}
			  {/if}
			  {/section}
			  {if $count < 11}
				</div>		
			  {/if}
		</div>
	</div>

<div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/sold_item');" /></div>
</div>    
{/if}    
</form>

 <div class="clear"></div>
 </div>
 </div>
{include file="footer_index.tpl"}
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/project.js"></script>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.metadata.js"></script>
{if $smarty.const.PHP_SELF != '/index.php' && $smarty.const.PHP_SELF != ''}
    <script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.validate.js"></script>
{/if}

{include file="header.tpl"}
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"></script>
{literal}
<script type="text/javascript">
function highlight()
		{
			
			document.getElementById('highlight').style.backgroundColor="#64FE2E";
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
                    <ul class="menu">
                        {*<li><a class="active" href="{$actualPath}/buy"><span>See all Items</span></a></li>*}
                        <li><a href="{$actualPath}/buy?list=fixed"><span>Fixed Price</span></a></li>
                       {if $live_count<=1}
                    		<li {if $smarty.request.list == 'weekly'}class="active"{/if}><a href="{$actualPath}/buy?list=weekly"><span>{if $totalLiveWeekly > 0}{$auctionWeeksData[0].auction_week_title}{else}{$latestEndedAuction} Results{/if}</span></a></li>
                    		{*<li {if $smarty.request.list == 'monthly'}class="active"{/if}><a href="{$actualPath}/buy?list=monthly"><span>Event Auctions</span></a></li>*}
                    		<li {if $smarty.request.list == 'upcoming'}class="active"{/if}><a href="{$actualPath}/buy?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						{elseif $live_count>1}
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[0].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[0].auction_week_id}"><span>{$auctionWeeksData[0].auction_week_title}</span></a></li>
							<li {if $smarty.request.auction_week_id ==$auctionWeeksData[1].auction_week_id} class="active"{/if}><a href="{$actualPath}/buy?list=weekly&auction_week_id={$auctionWeeksData[1].auction_week_id}"><span>{$auctionWeeksData[1].auction_week_title}</span></a></li>	
						{/if}
            {if $extendedAuction != ""}					    
						  <li {if $smarty.request.list == 'extended'} class="active" {/if}><a href="{$actualPath}/buy?list=extended&view_mode=grid"><span>Extended Auction {$extendedAuction}</span></a></li>
						{/if}
						<li {if $smarty.request.list == 'alternative'} class="active" {/if}><a href="{$actualPath}/buy?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
						{*<li {if $smarty.request.list == 'stills'} class="active" {/if}><a href="{$actualPath}/buy?list=stills"><span>Fixed Price Stills</span></a></li>*}
                    </ul>
					
                	</div>
				</div>	
            <div class="innerpage-container-main">
            	<div class="top-mid"><div class="top-left"></div></div>
               
                
                 <div class="left-midbg"> 
                    <div class="right-midbg whitebg">  
                <div class="mid-rept-bg">
                <!--    inner listing starts-->
                <form name="listFrom" id="listForm" action="" method="post">
                <input type="hidden" name="mode" value="select_watchlist" />
                <input type="hidden" name="is_track" id="is_track" value="" />
                	{if $auctionDetails[0].poster_id > 0}
                    <div class="display-listing-main">
                    	<div>
                        	<div class="poster-det-main pt20 pb20">
                        <div class="for-pict">
						<span style="margin-left:40px; color:#CC0033;">Click image to enlarge</span>
                        <div id="gallery_0" class="image-hldr2" style="padding-bottom:20px;" >
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tac"><tbody><tr><td align="left" valign="middle" style="border:none;">
                                <div class="buygrid_big">
                                       <div><img class="image-brdr" src="{$auctionDetails[0].large_image}"   border="0" {if $smarty.session.sessUserID != ""} style="cursor:pointer;width:318px;" {else}style="cursor:pointer;width:318px;"{/if}   onclick="open_new_window()"  id="org_id" />
									</div></div>
                            </td></tr></tbody></table>
                               
                                 {*  <input type="button" value="Click to enlarge" class="track-btn"  onclick="javascript:window.open('{$actualPath}/auction_images_large?mode=auction_images_large&id={$auctionDetails[0].poster_id}','mywindow','menubar=1,resizable=1,width={$width+100},height={$height+100},scrollbars=yes')"/>*}
                                     {if $auctionDetails[0].total_poster > 1}
                                        {* <div style="padding:0; margin:4px 0 0 0;">
                                             <a href="#" class="posternumber" onclick="javascript:window.open('{$actualPath}/auction_images_large?mode=auction_images_large&id={$auctionDetails[0].poster_id}','mywindow','menubar=1,resizable=1,width={$width+100},height={$height+100},scrollbars=yes')">
                                                 <u>{$auctionDetails[0].total_poster}&nbsp;Images </u></a> 
								</div>*}
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
                        
                        <div class="poster-det-cntnt_upcoming">
                        <div class="buylist pt20 pb20">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pb20"><h1>{$auctionDetails[0].poster_title}</h1></td>
      </tr>
      <tr>
        <td class="buylisttbtopbg"></td>
      </tr>
     {if $auction_key_approved!='0'}
      <tr>
        <td class="buylisttbcenter">
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  			<tr>
    <td width="135" valign="top"><div class="boldItalics time-left">Time Left to Start</div></td>
    <td rowspan="2" valign="top"><div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                                      <div class="buy-text boldItalics" style="margin-right:5px">Start Time: </div>
                                      <div class="buy-text" style="float:none;">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                      <div class="buy-text bold" style="margin-right:5px">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%A"}</div>
                                      <div class="buy-text">{$auctionDetails[0].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
                                    </div>
			<div class="auction-row">
                                                    <div class="buy-text boldItalics" style="margin-right:5px;">End Time</div>
                                                    <div class="buy-text" style="float:none;">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                                    <div class="buy-text bold" style="margin-right:5px;">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%A"}</div>
                                                    <div class="buy-text">{$auctionDetails[0].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                                </div>	</td>
  </tr>
  			<tr>
    <td valign="top"><div class="timerwrapper">
                                      
                                      <div class="text-timer" id="timer_($auctionDetails[0].auction_id}">{$auctionDetails[0].auction_countdown}</div>
                                      
                                      </div></td>
    </tr>
		</table>       
        
        </td>
      </tr>
      <tr>
        <td class="buylisttbbottombg"></td>
      </tr>
	  {else} 
	  <tr><td class="pb05">
	        <div class="BigFont bold">This is an unapproved poster.</div>  
       </td></tr>
     {/if}
	 
      
      </table>
                        
     					<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
		  <div class="pt10 pb10">
          <table width="260" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div class="socialIcon">
                             	<div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_preferred_1"></a>
                                <a class="addthis_button_preferred_2"></a>
                                <a class="addthis_button_preferred_3"></a>
                                <a class="addthis_button_preferred_4"></a>
                                <a class="addthis_button_compact"></a>
                                <a class="addthis_counter addthis_bubble_style"></a>
                                </div>
								<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e76e64247cca97b"></script>
                        </div></td>
              <td></td>
              </tr>
            </table></div>
		  </td>
        </tr>
        <tr>
        <td class="buylisttbbottombg"></td>
      </tr>
       <tr>
        <td class="pt10 pb10">
        	<div class="descrp-area">
                <div class="desp-txt"><b>Size : </b> {$auctionDetails[0].poster_size}</div>
                <div class="desp-txt"><b>Genre : </b> {$auctionDetails[0].genre}</div>
                <div class="desp-txt"><b>Decade : </b> {$auctionDetails[0].decade}</div>
                <div class="desp-txt"><b>Country : </b> {$auctionDetails[0].country}</div>
                <div class="desp-txt"><b>Condition : </b> {$auctionDetails[0].cond}</div>
            </div>
        </td>
      </tr>
	  {if $auctionDetails[0].imdb_link!=''}
		<tr>
			<td colspan="3" class="descrp-area" style=" background-color:#FFFF00;"><a href="{$auctionDetails[0].imdb_link}" target="_blank" style="text-decoration:none;color:#000000;" ><b>View film details at IMDb&nbsp;&nbsp;&nbsp;</b></a></td>
		</tr>
      {/if}
      <tr>
	  <tr><td>&nbsp;</td></tr>
	  {if $auction_key_approved!='0'}
      <td class="pb10">
      {if $auctionItems[counter].watch_indicator ==0}
                                    <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist({$auctionItems[counter].auction_id});" />
                                    {else}
                                        <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$auctionItems[counter].auction_id});" class="track-btn"  />
                                    {/if}
      </td>
	  {/if}
      </tr>
        <tr>
                            <td>
                            <div class="dashboard-main2"><h2>Description</h2>
                            <p>{$auctionDetails[0].poster_desc}</p></div>
                            </td>
        </tr>
        
      </table>                  
                        
                        </div>
                        </div>
                        
                        
                                                       
    
    </td>
    <td valign="top" class="pr10">
      
      </td>
  </tr>
</table></div>
                    
                    
                    
                    <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                    {else}
					<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                    	<tr>
                    		<td align="center" style="font-size:11px; font-weight:bold;">No poster found.</td>
                    	</tr>
					</table>
                    {/if}
					</form>
                <!--    inner listing ends-->
                <div class="clear"></div>
                </div>
                </div>
                </div>
                
              <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
            </div>
        </div>  
        
        </div></div></div>
        {include file="gavelsnipe.tpl"}
		
		<!-- page listing ends -->
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
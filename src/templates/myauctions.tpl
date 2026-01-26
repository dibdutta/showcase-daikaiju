{include file="header.tpl"}
<script type="text/javascript" src="{$actualPath}/javascript/fancy/jquery-min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="{$actualPath}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
{literal}
<script type="text/javascript">
function toggleDiv(id,flagit) {
	if (flagit=="1"){
	if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"
	}
	else
	if (flagit=="0"){
	if (document.layers) document.layers[''+id+''].visibility = "hide"
	else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"
	}
}
function fancy_images(i){
			$("#various_"+i).fancybox({
    		'width': 390,
    		'height': 400,
			'onClosed': function() {
    		parent.location.reload(true);
  				}
  			});
		}
function clear_text(){
	if($("#search_buy_items").val()=='Search by title..'){
		document.getElementById('search_buy_items').value='';
	}
}	
</script>
<style type="text/css">.div {position:absolute;left:300px; min-width:120px; list-style-type:none; visibility:hidden;background-color:#881318;color:white; z-index:40;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c;}
.popDiv_Auction { position:absolute;left:300px; min-width:120px; list-style-type:none; background-color:#881318 ;color:white; z-index:1000;font-size:12px; margin-left:80px;visibility:hidden; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c;}</style>
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
        <div id="inner-container"> 
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">
             
            <div id="inner-left-container">
                <div id="tabbed-inner-nav">
                <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li {if $smarty.request.mode == 'selling'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=selling"><span>Selling (Auction)</span></a></li>
						<li {if $smarty.request.mode == 'fixed_selling'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=fixed_selling"><span>Selling (Fixed)</span></a></li>
                        <li {if $smarty.request.mode == 'pending'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=pending"><span>Pending</span></a></li>
                        <li {if $smarty.request.mode == 'sold'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=sold"><span>Sold</span></a></li>
                        <li {if $smarty.request.mode == 'unsold'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=unsold"><span>Unsold/Closed</span></a></li>
                        <li {if $smarty.request.mode == 'upcoming'}class="active"{/if}><a href="{$actualPath}/myselling.php?mode=upcoming"><span>Upcoming</span></a></li>
						<li {if $smarty.request.mode == 'unpaid'} class="active"{/if}><a href="{$actualPath}/myselling.php?mode=unpaid"><span>Sale Pending</span></a></li>
					</ul>
                
				</div>
                </div>           
                <div class="innerpage-container-main">
                   <div class="top-mid"><div class="top-left"></div></div>
               
                   
                   <div class="left-midbg"> 
                    <div class="right-midbg"> 
                    <div class="mid-rept-bg">
                    {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                    {if $total > 0}
					<form action="" method="get" onsubmit="return test();">
					 <input type="hidden" name="mode" value="{$smarty.request.mode}" />
					 <input type="hidden" name="offset" value="{$offset}" />
					 <input type="hidden" name="toshow" value="{$toshow}" />
                        <div class="top-display-panel">
                            
							<div class="soldSearchblock">
                            <div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;">	                             
                            	<input type="text" onclick="clear_text()" {if $smarty.request.search_sold!=''} value="{$smarty.request.search_sold}" {else}  value="Search by title.." {/if} name="search_sold" id="search_buy_items" class="midSearchbg_edit fll" style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;" >
                                <input type="submit" value="" class="rightSearchbg">
                            </div>
                            </div>
							<div class="sortblock" style="width:165px;" ><span class="headertext">Sort By:</span>
								<select name="sort_by" class="look" style="height:27px;"  onChange="this.form.submit();">
								<option value="" selected="selected">Select</option>
								<option value="price" {if $sort_by=='price'} selected="selected"{/if}>Price</option>
								<option value="title" {if $sort_by=='title'} selected="selected"{/if}>Title</option>
								{if $smarty.request.mode!='pending' &&  $smarty.request.mode!='sold'}
									<option value="listing_date" {if $sort_by=='listing_date'} selected="selected"{/if}>Listing Date</option>
								{else if $smarty.request.mode!='sold'}	
									<option value="uploaded_date" {if $sort_by=='uploaded_date'} selected="selected"{/if}>Uploaded Date</option>
								{/if}
								{if $smarty.request.mode=='sold'}
									<option value="sold_date" {if $sort_by=='sold_date'} selected="selected"{/if}>Sold Date</option>
								{/if}
								</select>
								</div> 
							
                        </div>
                        
                        <div class="top-display-panel2"> 
                        	<div class="left-area">
                                <div class="results-area" style="width:160px;"><span>{$displayCounterTXT}</span></div>
                                <div class="pagination" style="padding:0px 5px;">{$pageCounterTXT}</div>								                           
                            </div>
                        </div>
						</form>                   
                        <div class="display-listing-main">
                        
                        
                         <div>
                            {section name=counter loop=$auction}  
							
							<div class="buylist pt20 pb20 mb02">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="200" valign="top" class="buylisttb">
								{if $auction[counter].fk_auction_type_id==1 }
									 <div><a href="javascript:void(0);"><img  class="image-brdr"  src="{$auction[counter].image_path}"  style="cursor:pointer;" onclick="javascript:window.open('{$actualPath}/auction_images_large.php?mode=auction_images_large&id={$auction[counter].poster_id}&fixed=1','mywindow','menubar=1,resizable=1,width={$auction[counter].img_width+100},height={$auction[counter].img_height+100},scrollbars=yes')"   /></a>
									</div>
								{else}
									 <div><a href="javascript:void(0);"><img  class="image-brdr"  src="{$auction[counter].image_path}"  style="cursor:pointer;" onclick="javascript:window.open('{$actualPath}/auction_images_large.php?mode=auction_images_large&id={$auction[counter].poster_id}','mywindow','menubar=1,resizable=1,width={$auction[counter].img_width+100},height={$auction[counter].img_height+100},scrollbars=yes')"   /></a>
									</div>
								{/if}
                               								
								{*if $auction[counter].fk_auction_type_id==1 && $smarty.request.mode=='selling'}
                                    
												 <a id="various_{$smarty.section.counter.index}" href="{$actualPath}/myselling.php?mode=move_to_weekly&id={$auction[counter].auction_id}"><input type="button" id="{$smarty.section.counter.index}" onclick="fancy_images(this.id)" class="track-btn" value="Move to weekly" /></a>
                							
                                {/if*}
											
								{if $auction[counter].fk_auction_type_id==2  && $smarty.request.mode=='unsold'}
                                    
												 <a id="various_{$smarty.section.counter.index}" href="{$actualPath}/myselling.php?mode=weekly_relist&id={$auction[counter].auction_id}"><input type="button" id="{$smarty.section.counter.index}" onclick="fancy_images(this.id)" class="track-btn" value="Relist" /></a>
                							
                                {/if} 
								  </td>
                            <td class="pr10">
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td class="pb20">
									<div class="poster-area-list">
                                            {if $auction[counter].fk_auction_type_id == 1}
                                                <div class="left"><a href="{$actualPath}/edit_myauction.php?auction_id={$auction[counter].auction_id}&type=fixed&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC}edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {elseif ($auction[counter].fk_auction_type_id == 2 || $auction[counter].fk_auction_type_id == 5) && $auction[counter].auction_is_approved==0}
                                                <div class="left"><a href="{$actualPath}/edit_myauction.php?auction_id={$auction[counter].auction_id}&type=weekly&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC}edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {elseif $auction[counter].fk_auction_type_id == 3 && $auction[counter].auction_is_approved==0}
                                                <div class="left"><a href="{$actualPath}/edit_myauction.php?auction_id={$auction[counter].auction_id}&type=monthly&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC}edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
                                            {elseif $auction[counter].fk_auction_type_id == 4 && $auction[counter].auction_is_approved==0}
												<div class="left"><a href="{$actualPath}/edit_myauction.php?auction_id={$auction[counter].auction_id}&type=stills&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC}edit-icon.png" alt="Modify" title="Modify" height="16px" width="16px" border="0" /></a></div>
											{/if}
                                            &nbsp;
											{if (($auction[counter].fk_auction_type_id != 3 && $auction[counter].fk_auction_type_id != 2) || $auction[counter].auction_is_approved==0)}
                                              <img src="{$smarty.const.CLOUD_STATIC}delete_image.png" alt="Delete" title="Delete" height="16px" width="16px" border="0" onclick="javascript: deleteConfirmRecord('{$actualPath}/edit_myauction.php?mode=delete_auction&auction_id={$auction[counter].auction_id}&status={$smarty.request.mode}&encoded_string={$encoded_string}&toshow={$toshow}&offset={$offset}', 'auction');" style="cursor: pointer;" />
											 {/if} 
                                            &nbsp;
                                          
                                        </div>
										{if $auction[counter].fk_auction_type_id == 1}
											<h1><span style="cursor:pointer;" onclick="redirect_poster_details({$auction[counter].auction_id},1);">{$auction[counter].poster_title}&nbsp;(#{$auction[counter].poster_sku})</span></h1>
										{else}
											<h1><span style="cursor:pointer;" onclick="redirect_poster_details({$auction[counter].auction_id});">{$auction[counter].poster_title}&nbsp;(#{$auction[counter].poster_sku})</span></h1>
										{/if} 
									
									
									</td>
                                  </tr>
                                  <tr>
                                    <td class="buylisttbtopbg"></td>
                                  </tr>
								  {if $smarty.request.mode!='sold'}
                                  <tr>
                                    <td class="pt10 pb10">
                                    	<div class="descrp-area">
                                            <div class="desp-txt"><b>Size : </b> {$auction[counter].poster_size}</div>
                                            <div class="desp-txt"><b>Genre : </b> {$auction[counter].genre}</div>
                                            <div class="desp-txt"><b>Decade : </b> {$auction[counter].decade}</div>
                                            <div class="desp-txt"><b>Country : </b> {$auction[counter].country}</div>
                                            <div class="desp-txt"><b>Condition : </b> {$auction[counter].cond}</div>
										</div>
                                    </td>
                                  </tr>
								  {/if}
                                  
                                  
                                  
                                   {if $auction[counter].fk_auction_type_id==1} 
								   
								   <tr>
                                     <td class="buylisttbtopbg"></td>
                                   </tr>
                                   <tr> 								
									 <td class="buylisttbcenter" valign="top">
                                        <div class="auction-row">

                                            <div class="buy-text bold">Ask Price</div>

                                            <div class="buy-text offer_buyprice">${$auction[counter].auction_asked_price|number_format:2}</div>
                                        </div>
                                        {if $auction[counter].auction_reserve_offer_price > 0}
                                        <div class="auction-row">
                                             <div class="buy-text bold">You will consider offers</div>
                                        </div>
                                        
                                        {/if}
                                        {if $auction[counter].count_offer > 0}
                                        <div class="auction-row" style=" position:relative;">
                                                <div class="buy-text bold" style=" position:relative; cursor:pointer; font-size:16px; margin-top:-3px;" {if $smarty.request.mode != 'sold'} onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" {/if}>{$auction[counter].count_offer}</div>
												<div class="buy-text" style=" position:relative; cursor:pointer; margin-right:10px;" {if $smarty.request.mode != 'sold'} onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)"{/if} ><b style="margin-left:5px">Offer(s)</b></div>
												
										</div>		
										<!-- Tooltip starts Here -->
                                   
										<div id="div_{$auction[counter].auction_id}" class="popDiv_Auction">									
											<ul>
											{section name=pop_counter loop=$auction[counter].tot_offers}
											<li><b>&nbsp;Amount:</b>&nbsp; ${$auction[counter].tot_offers[pop_counter].offer_amount}&nbsp;</li>
											{/section}
											</ul>
										</div>
                                        
										<div class="auction-row" >
                                    			<!-- Tooltip ends Here -->
                                                <div class="buy-text bold">Highest Offer</div>
												<div class="buy-text" style="font-size:16px; margin-top:-3px; font-weight:bold; padding-left:5px;"><div class="BigFont">${$auction[counter].highest_offer|number_format:2}</div>
                                            </div>
										</div>	
                                        {/if}
										<div class="auction-row" >
                                        	<div class="buy-text bold">Note:&nbsp;&nbsp;</div>
                                        	<div class="note-txt">{$auction[counter].auction_note}</div>
                                        </div>
										
                                         {if $smarty.request.mode=='sold'}
                                        	{if $auction[counter].soldamnt>0}
											<div class="auction-row">
												<div class="buy-text bold">
												Sold Price:&nbsp;&nbsp;</div>
                                        		<div class="buy-text offer_buyprice">${$auction[counter].soldamnt|number_format:2}</div>
											</div>
											{if $smarty.request.mode!='sold'}	
											<div class="auction-row">
												<div class="buy-text bold">
												Listing Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].up_date|date_format:"%m/%d/%Y"}</div>
											</div>
											{/if}
											<div class="auction-row">
												<div class="buy-text bold">
												Sold Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</div>
											</div>	
                                        	{/if}
									    {elseif $smarty.request.mode=='selling' || $smarty.request.mode=='unpaid' || $smarty.request.mode=='upcoming' || $smarty.request.mode=='unsold'}				<div class="auction-row">
												<div class="buy-text bold">
												Listing Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].up_date|date_format:"%m/%d/%Y"}</div>
											</div>
										{elseif $smarty.request.mode=='pending'}
										    <div class="auction-row">
												<div class="buy-text bold">
												Uploaded Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].post_date|date_format:"%m/%d/%Y"}</div>	
											</div>
                                        {/if}
                                    </td>
									</tr>
									<tr>
                                    <td class="buylisttbbottombg"></td>
                                  </tr>
								   {elseif ($auction[counter].fk_auction_type_id==2 || $auction[counter].fk_auction_type_id==5)}
								   
								   <tr>
                                     <td class="buylisttbtopbg"></td>
                                   </tr>
								   <tr>
                                     <td class="buylisttbcenter" style=" width:55%;" valign="top">
                                        <div class="auction-row">
                                            <div class="buy-text bold">Start Bid</div>
                                            <div class="buy-text"><span class="offer_buyprice">${$auction[counter].auction_asked_price|number_format:2}</span></div>
                                        </div>
                                        
                                        <div class="auction-row">
                                            <div class="buy-text bold" style="margin-right:5px;">End Time</div>
                                            <div class="buy-text" style="float:none;">{$auction[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                                            <div class="buy-text" style="margin-right:5px;">{$auction[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                                            <div class="buy-text">{$auction[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                                        </div>                                        
                                        {if $auction[counter].count_bid > 0}
                                            <div class="auction-row" style=" position:relative;">
                                                <div class="buy-text bold BigFont" {if $smarty.request.mode != 'sold'}  onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" style="cursor:pointer;" {/if}>{$auction[counter].count_bid}</div>
												<div class="buy-text" {if $smarty.request.mode != 'sold'} onMouseOver="toggleDiv('div_{$auction[counter].auction_id}',1)" onMouseOut="toggleDiv('div_{$auction[counter].auction_id}',0)" style="cursor:pointer;"{/if}>
                                                <b style="margin:0 5px;">Bid(s)</b></div>									
												<!-- Tooltip starts Here -->
                                            </div>
											
												<div id="div_{$auction[counter].auction_id}" class="div">
												<ul>
												{section name=pop_counter loop=$auction[counter].bid_popup}
												<li>&nbsp;<b>{$auction[counter].bid_popup[pop_counter].user_name}:</b>&nbsp;${$auction[counter].bid_popup[pop_counter].bid_amount}&nbsp;</li>
												{/section}
												</ul>
												</div>
                                    		
                                    			<!-- Tooltip ends Here -->
											<div class="auction-row">	
                                                <div class="buy-text bold" style="margin-left:5px;">Highest Bid</div>
												<div class="buy-text"> <b class="BigFont" style="margin-left:5px;">${$auction[counter].highest_bid|number_format:2}</b></div>
                                            </div>
                                        {/if}
                                        {if $smarty.request.mode=='sold'}
                                        	{if $auction[counter].soldamnt>0}
											<div class="auction-row">
                                        		<div class="buy-text bold">
                                        		Sold Price:&nbsp;&nbsp;</div>
                                        		<div class="buy-text offer_buyprice">${$auction[counter].soldamnt|number_format:2}</div>
											</div>	
											{if $smarty.request.mode!='sold'}
											<div class="auction-row">
												<div class="buy-text bold">
												Listing Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>
											</div>
											{/if}
											<div class="auction-row">
												<div class="buy-text bold">
												Sold Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</div>
											</div>
                                        	{/if}
										{elseif $smarty.request.mode=='selling' || $smarty.request.mode=='unpaid' || $smarty.request.mode=='upcoming' || $smarty.request.mode=='unsold'}				<div class="auction-row">
												<div class="buy-text bold">
												Listing Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].auction_actual_start_datetime|date_format:"%m/%d/%Y"}</div>	
											</div>
                                        {elseif $smarty.request.mode=='pending'}
										    <div class="auction-row">
												<div class="buy-text bold">
												Uploaded Date:&nbsp;&nbsp;</div>
												<div class="buy-text offer_buyprice">{$auction[counter].post_date|date_format:"%m/%d/%Y"}</div>
											</div>
										{/if}
                                    </td>
									</tr>
									<tr>
                                    <td class="buylisttbbottombg"></td>
                                  </tr>
								   {/if}
                                  
                                  
                                </table>
                                
                            </td>
                          </tr>
                        </table>

                        
                        </div>
	
                            {/section}
                            </div>
                        </div>
                        <div class="btomgrey-bg"></div>
						 <div class="top-display-panel2">
                        <div class="left-area">
                                <div class="results-area" style="width:160px;"><span>{$displayCounterTXT}</span></div>
                                <div class="pagination" style="padding:0px 5px;">{$pageCounterTXT}</div> 
								                           
                            </div>
							</div>
                    {else}
                        {if $status=='selling'}
                        	<div class="msgsearchnorecords">There are no auctions currently running. Check out Upcoming tab to see scheduled auctions.</div>
                      	{elseif $status=='upcoming'}
                      		<div class="msgsearchnorecords">Upcoming Auctions are in the process of loading. Please check back!</div>
						{elseif $status=='fixed_selling'}
                      		<div class="msgsearchnorecords">There is no fixed selling items now!</div>
                      	{else}
                      		<div class="msgsearchnorecords">There are no auctions at this time.</div>	
                      	{/if}
                    {/if}
                    <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    
                   <!-- <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
                    
                </div>
            </div>
            
            </div></div></div>
          
        </div>
		{include file="gavelsnipe.tpl"} 
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
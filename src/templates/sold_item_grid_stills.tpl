{include file="header.tpl"}
{literal}
<script type="text/javascript">
function clear_text(){
	$("#search_sold").val('');
}
function show_text(){
	$("#search_sold").val('Search sold items by their title..');
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
						<li ><a href="{$actualPath}/sold_item.php"><span>All</span></a></li>
                        <li ><a href="{$actualPath}/sold_item.php?mode=fixed"><span>Fixed Price</span></a></li>
                        <li ><a href="{$actualPath}/sold_item.php?mode=weekly"><span>Auction</span></a></li>
						<li class="active" ><a href="{$actualPath}/sold_item.php?mode=stills" ><span>Stills/Photos</span></a></li>
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
                            <div class="top-display-panel">
							<div class="left-area_auction" style="width:150px;">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
									{if $smarty.request.mode=='search_sold_stills'}
										<li class="list"><a href="sold_item.php?view_mode=list&mode=search_sold_stills&search_sold={$smarty.request.search_sold|urlencode}">&nbsp;</a> </li>
									{else}
                                        <li class="list"><a href="sold_item.php?view_mode=list&mode=stills">&nbsp;</a> </li>
									{/if}	
                                        |
                                        <li class="grida"><span class="active">&nbsp;</span></li>
                                    </ul>
                            </div>
							<form name="form1" method="get" >
                        <input type="hidden" value="search_sold_stills" name="mode" >
                        <input type="hidden" value="{$smarty.request.offset}" name="offset" >
                        <input type="hidden" value="{$smarty.request.toshow}" name="toshow" >
							<div class="soldSearchblock" style="clear:right;">
                            	
								<div style="width:500px; height:26px; border:1px solid #cecfd0; float:left;">
                                
                                <input type="text" style="width:450px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 5px;" class="midSearchbg_auction fll" id="search_sold" name="search_sold" {if $smarty.request.mode == 'search_sold_stills'} value="{$smarty.request.search_sold}" {else} value="Search sold items by their title.."{/if} onfocus="clear_text()"  />
                                <input type="submit" class="rightSearchbg" value="" />
                            </div>
                            </div>
							
							
                        	 {if $total > 0}
                              <div class="sortblock_auction2" style="clear: both; width: 290px; margin-top:8px; margin-left:0; text-align:left;" ><span class="headertext">&nbsp;</span><b>Sort By:</b>
						  <select name="auction_week" style="width:230px; margin-left:5px;"  class="look" onchange="javascript: this.form.submit();">
                                 <option value="" selected="selected">All Auction</option>
                                 {section name=counter loop=$auctionWeek}
                                     <option value="{$auctionWeek[counter].auction_week_id}" {if $smarty.request.auction_week == $auctionWeek[counter].auction_week_id} selected {/if} >MPE Stills Auction&nbsp;( {$auctionWeek[counter].auction_week_end_date|date_format '%D'})</option>
                                 {/section}
                             </select></div>
							<div class="sortblock_auction" style="margin-top: 8px;">{$displaySortByTXT}</div>
							{/if}
                        </form>
                       
						</div>
                        <div class="top-display-panel2">
                        <div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination" style=" padding:0px 5px;">{$pageCounterTXT}</div>
							</div>
                        </div>
                        {/if}
                        {if $smarty.session.sessUserID <> ""}					
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        {/if}
                        <div class="clear"></div>
                        {if $total > 0}
                        						
                            <div class="display-listing-main buygrid">     
                            <div>  
                            <div class="btomgrey-bg"></div>                 
                                {section name=counter loop=$dataJstFinishedAuction}	
                               
                                    <div>							
                                    <div {if $smarty.session.sessUserID == ""} class="grid-view-main gridMrgn" {else} class="grid-view-main " {/if}>
                                    
                                        <div class="poster-area">
                                        
                                             
                                            
                                             <div class="inner-cntnt-each-poster">
                                                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                     <div class="buygridtb">
                                       <div><img class="image-brdr" src="{$dataJstFinishedAuction[counter].image_path}" onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;" /></div></div>
                                       <div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" style="cursor:pointer;" >{$dataJstFinishedAuction[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataJstFinishedAuction[counter].poster_sku}){/if*}</a> </h3></div>
                                                </div>                                            
                                                
                                             </div>										
                                            <div class="inner-cntnt-each-poster">                                        
                                                <div class="price-box tac">									
                                                	<!-- Buy Now section for fixed price sell items -->
                                                    <div class="buylist_cbid" style="width:230px; margin-right:0;">&nbsp;&nbsp;Sold Date: <span class="SoldPrice">{$dataJstFinishedAuction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</span></div>
                                                    <!-- Make Offer section for fixed price sell items -->
												</div>
                                            </div>
                                            <div class="inner-cntnt-each-poster">
												<div class="price-box tac">
												{*if $smarty.session.sessUserID <> ""*}
												<!-- Buy Now section for fixed price sell items -->
                                                    <div class="buylist_cbid" style="width:230px; margin-right:0;">&nbsp;&nbsp;Sold Amount : <span class="SoldPrice">{if $dataJstFinishedAuction[counter].soldamnt > 0}${$dataJstFinishedAuction[counter].soldamnt|number_format:2}{else}0.00{/if}{*$dataJstFinishedAuction[counter].auction_id*}</span></div>
                                                    <!-- Make Offer section for fixed price sell items -->
												{*else}
													<div class="buylist_cbid" style="width:230px; margin-right:0;font-size:12px;">&nbsp;&nbsp;<a href="javascript:void(0)" onclick="showLogIn();">Sign In</a> or <a href="register.php">Register</a> to view details</div>	
												{/if*}
                                                </div>
											</div>
                                           
                                        </div>
                                       
                                    </div>
                                    </div>
                                    {if ($smarty.section.counter.index) != 0}
                                        {if (($smarty.section.counter.index +1) % 3) == 0} 
                                         <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
                                         <div class="btomgrey-bg"></div> {/if}
                                    {/if} 
                                {/section} 
                                  <div class="btomgrey-bg"></div>  
                                </div>
                            </div>
                            <div class="btomgrey-bg"></div>	
							<div class="top-display-panel">
								<div class="sortblock"> <b>Sort By: </b>{$displaySortByTXT}</div>
                             </div>
                            <div class="top-display-panel2">
                              <div class="left-area">
                                <div class="results-area">{$displayCounterTXT}</div>
                                <div class="pagination" style="width:270px;">{$pageCounterTXT}</div>
                              </div>
							</div>
						{else}
							<div class="top-display-panel">
                        	<div class="msgsearchnorecords">Sorry no records found.</div></div>
						{/if}
                        {if $smarty.session.sessUserID <> ""}
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        {/if}
						
                        <div class="clear"></div>			
					</div>
                    </div>
                    </div>
                    
                    
					
				</div>
				</form>	
			</div>	
			
             </div></div></div>	
		</div>
 {include file="gavelsnipe.tpl"}     
	<!-- page listing ends -->
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
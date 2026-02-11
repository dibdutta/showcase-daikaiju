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
						<li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/sold_item?mode=premier&toshow=20&order_by=auction_asked_price&order_type=DESC"><span>Premier Auction Results</span></a></li>
						
					</ul>
				<div class="tabbed-inner-nav-right"></div>
                </div>
				</div>
				<div class="innerpage-container-main">
					<div class="top-mid"><div class="top-left"></div></div>
                <div class="top-right"></div>
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg">                                       
					<div class="mid-rept-bg">
                     {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                      {if $total > 0}	
						<div class="top-display-panel">
							
							<div class="sortblock">{$displaySortByTXT}</div>
							<div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination">{$pageCounterTXT}</div>
							</div>                        
						</div>
                      {/if}  
                        
                        <div class="top-display-panel">
                        <form name="form1" method="get" >
                        <input type="hidden" value="search_sold_premier" name="mode" >
                        <input type="hidden" value="{$smarty.request.offset}" name="offset" >
                        <input type="hidden" value="{$smarty.request.toshow}" name="toshow" >
                        	 {if $total > 0}
							<div class="soldSearchblock" style="margin-bottom:20px;">
                            	<div class="leftSearchbg"></div>
                                
                            	<input type="text" style="width:160px;" class="midSearchbg" id="search_sold" name="search_sold" {if $smarty.request.mode == 'search_sold_premier'} value="{$smarty.request.search_sold}" {else} value="Search sold items by their title.."{/if} onfocus="clear_text()"  />
                                <input type="submit" class="rightSearchbg" value="" />
                            </div>
							{/if}
                        </form>
                        </div>
                       
                        
                        
                        {if $total > 0}                    
                            
                            <!-- start of movie posters ---> 
                            {section name=counter loop=$dataJstFinishedAuction}  
                            <div>
                            <div class="display-listing-main">
                                <table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
                                <tr class="list-poster-box" valign="top"><td colspan="3"><div class="poster-area-list"><a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" style="cursor:pointer;" ><strong>{$dataJstFinishedAuction[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataJstFinishedAuction[counter].poster_sku}){/if*}</strong></a></div></td></tr>
                                    <tr>
                                        <td class="list-poster-box" valign="top">                                               
                                            <div class="poster-area-list">
                                               
												   
                                                {if $dataJstFinishedAuction[counter].fk_auction_type_id=='3'}
                                                <div  style="font-family:Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Event :{$dataJstFinishedAuction[counter].event_title}</div>
                                                {/if}
                                            </div>
                                             <div class="poster-area-list">
                                                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                        <div class="shadowbottom">
                                       <div class="shadow-bringer shadow"><img  class="image-brdr" src="{$actualPath}/poster_photo/thumbnail/{$dataJstFinishedAuction[counter].poster_thumb}"  onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;" /></div></div>
                                                </div>
                                                <div class="descrp-area">
                                                {section name=catCounter loop=$dataJstFinishedAuction[counter].categories}
                                                    {if $dataJstFinishedAuction[counter].categories[catCounter].fk_cat_type_id == 1}
                                                    <div class="desp-txt"><b>Size : </b> {$dataJstFinishedAuction[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $dataJstFinishedAuction[counter].categories[catCounter].fk_cat_type_id == 2}
                                                    <div class="desp-txt"><b>Genre : </b> {$dataJstFinishedAuction[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $dataJstFinishedAuction[counter].categories[catCounter].fk_cat_type_id == 3}
                                                    <div class="desp-txt"><b>Decade : </b> {$dataJstFinishedAuction[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $dataJstFinishedAuction[counter].categories[catCounter].fk_cat_type_id == 4}
                                                    <div class="desp-txt"><b>Country : </b> {$dataJstFinishedAuction[counter].categories[catCounter].cat_value}</div>
                                                    {elseif $dataJstFinishedAuction[counter].categories[catCounter].fk_cat_type_id == 5}
                                                    <div class="desp-txt"><b>Condition : </b> {$dataJstFinishedAuction[counter].categories[catCounter].cat_value}</div>
                                                    {/if}
                                                {/section} 
                                                </div>                                  
                                            </div>
                                            <div class="poster-area-list">
                                                <!--<input type="button" class="bidnow-btn" value="Details" onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});"/>-->
                                            </div>                                        
                                                                                  
                                        </td>                                    					
                                        <td class="list-bid-det" valign="top">
                                            <div class="price-box">									
                                                	<!-- Buy Now section for fixed price sell items -->
                                                    <div class="text bold Minimum" style="width:200px;">&nbsp;&nbsp;Sold Date: <span class="SoldPrice">{$dataJstFinishedAuction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</span></div>
                                                    <!-- Make Offer section for fixed price sell items -->
                                            </div>
                                      
                                           								 
                                        </td>
                                        <td class="list-bid-det" valign="top">
                                            <div class="price-box">									
                                               
                                                	<!-- Buy Now section for fixed price sell items -->
                                                    <div class="text bold Minimum" style="width:200px;">&nbsp;&nbsp;Sold Amount : <span class="SoldPrice">{if $dataJstFinishedAuction[counter].soldamnt > 0}${$dataJstFinishedAuction[counter].soldamnt|number_format:2}{else}0.00{/if}{*$dataJstFinishedAuction[counter].auction_id*}</span></div>
                                                    <!-- Make Offer section for fixed price sell items -->
                                                        
                                                   
                                       
                                            </div>
                                        </td>
                                     </tr>
                                </table>				
                            </div>
                            </div> 	
                            {/section}  
							{if $total > 0}	
                            
                                <div class="btomgrey-bg"></div>	
							<div class="top-display-panel">
								<div class="sortblock">{$displaySortByTXT}</div>
								<div class="left-area">
									<div class="results-area">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>                        
							</div>
                      		{/if}                      
                            <!-- end of movie posters --->
                        {else}
                        	<table width="90%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry no records found.</td>
                                </tr></table>
                        {/if}
                        
                         <div class="clear"></div>                
					</div>
                    </div>
                    </div>
                    
					  <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                </form>
			</div>
             </div>
             </div></div></div>       
            {include file="user-panel.tpl"}
		</div>   
	<!-- page listing ends -->
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
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
                        <li ><a href="{$actualPath}/sold_item"><span>All</span></a></li>
                        <li class="active"><a href="{$actualPath}/sold_item?mode=fixed"><span>Fixed Price</span></a></li>
                        <li ><a href="{$actualPath}/sold_item?mode=weekly"><span>Auctions</span></a></li>
						{*<li ><a href="{$actualPath}/sold_item?mode=stills"><span>Stills/Photos</span></a></li>*}
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
							<div class="left-area">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
										<li class="lista"><span class="active"></span></li>|
									{if $smarty.request.mode=='search_sold_fixed'}
										<li class="grid"><a href="sold_item?view_mode=gallery&mode=search_sold_fixed&search_sold={$smarty.request.search_sold|urlencode}"></a> </li>
									{else}
                                        <li class="grid"><a href="sold_item?view_mode=gallery&mode=fixed"></a> </li>
									{/if}                                        
                                    </ul>
                            </div>
                            <form name="form1" method="get" >
                        <input type="hidden" value="search_sold_fixed" name="mode" >
                        <input type="hidden" value="{$smarty.request.offset}" name="offset" >
                        <input type="hidden" value="{$smarty.request.toshow}" name="toshow" >
                        	 {if $total > 0}
							<div class="soldSearchblock">
                            <div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;"> 	
                            	<input style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;"  type="text" class="midSearchbg_edit fll" id="search_sold" name="search_sold" {if $smarty.request.mode == 'search_sold_fixed'} value="{$smarty.request.search_sold}" {else} value="Search sold items by their title.."{/if} onfocus="clear_text()"  />
                                <input type="submit" class="rightSearchbg" value="" />
                            </div>
                            </div>
							{/if}
                        </form>
                            
                            
                            
                            
                            
							<div class="sortblock">{$displaySortByTXT}</div>
                            </div>
                            <div class="top-display-panel2"> 
							<div class="left-area">
								<div class="results-area">{$displayCounterTXT}</div>
								<div class="pagination" style="width:270px;">{$pageCounterTXT}</div>
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
                            
                            <!-- start of movie posters ---> 
                            {section name=counter loop=$dataJstFinishedAuction}  
                            <div>
                            <!-- Amol Code starts here --->
                            
                            <div class="buylist pt20">
                         
                          	<table width="711" border="0" cellspacing="0" cellpadding="0" class="mb30">
								  <tr>
									
									<td width="200" class="buylisttb">
									<div><img  class="image-brdr" src="{$dataJstFinishedAuction[counter].image_path}"  onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;" /></div>
									 
																   
																 
									
									</td>
									<td valign="top" class="pr10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td class="pb20"><a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" style="cursor:pointer;" ><h1>{$dataJstFinishedAuction[counter].poster_title}&nbsp;</h1></a></td>
									  </tr>
									  <tr>
										<td class="buylisttbtopbg"></td>
									  </tr>
									  {*
									  <tr>
										<td class="pb10">
											<div class="descrp-area">
												<div class="desp-txt"><b>Size : </b> {$dataJstFinishedAuction[counter].poster_size}</div>
												<div class="desp-txt"><b>Genre : </b> {$dataJstFinishedAuction[counter].genre}</div>
												<div class="desp-txt"><b>Decade : </b> {$dataJstFinishedAuction[counter].decade}</div>
												<div class="desp-txt"><b>Country : </b> {$dataJstFinishedAuction[counter].country}</div>
												<div class="desp-txt"><b>Condition : </b> {$dataJstFinishedAuction[counter].cond}</div>
											</div>
										</td>
									  </tr>
									  *}
									  <tr>
										<td class="buylisttbtopbg"></td>
									  </tr>
      
      
									  <tr>
										<td class="pt10"><div class="buylist_cbid">Sold Date: {$dataJstFinishedAuction[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</div></td>
									  </tr>
									  <tr>
										{*if $smarty.session.sessUserID <> ""*}
										<td class="buylist_cbid pb10">Sold Amount <span class="SoldPrice">{if $dataJstFinishedAuction[counter].soldamnt > 0}${$dataJstFinishedAuction[counter].soldamnt|number_format:2}{else}0.00{/if}{*$dataJstFinishedAuction[counter].auction_id*}</span></td>
									  {*else}
									  	<td class="buylist_cbid pb10" style="font-size:12px;"><a href="javascript:void(0)" onclick="showLogIn();">Sign in</a> or <a href="register">Register</a> to view details</td>	
									  {/if*}
									  </tr>
											<tr>
										<td class="buylisttbbottombg"></td>
									  </tr>

								  </table>
								  
								  </td>
							  </tr>
							</table>
                            </div>
                            
                            
                            
                            
                            <!-- Amol Code ends here --->
                            
                            
                            </div> 	
                            {/section}  
							{if $total > 0}	
                            
                                <div class="btomgrey-bg"></div>	
							<div class="top-display-panel">
								<div class="sortblock">{$displaySortByTXT}</div>
                             </div>   
                                
                            <div class="top-display-panel2">    
								<div class="left-area">
									<div class="results-area">{$displayCounterTXT}</div>
									<div class="pagination">{$pageCounterTXT}</div>
								</div>
                            </div>                            
							</div>
                      		{/if}                      
                            <!-- end of movie posters --->
                        {else}
                        <div class="top-display-panel">
                        	<div class="msgsearchnorecords">Sorry no records found.</div></div>
                        {/if}
                        
                         <div class="clear"></div>                
					</div>
                    </div>
                    </div>
                    
                </form>
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
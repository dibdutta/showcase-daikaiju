{include file="header.tpl"}
<div id="forinnerpage-container">
	<div id="wrapper">
	<!--Header themepanel Starts-->
		<div id="headerthemepanel">
		  <!--Header Theme Starts-->
			<div id="searchbar">
			<div class="search-left-bg"></div>
				<div class="search-midrept-bg">
					<label><img src="images/search-img.png" width="20" height="32" /></label>
					<input type="text" name="txt1" class="srchbox-txt" />
					<input type="button" value="Search" class="srchbtn-main" />
					<input type="button" value="Refine Search" class="refine-srchbtn-main" />
				</div>
				<div class="search-right-bg"></div>
			</div> 
		  <!--Header Theme Ends-->
		</div>
	<!--Header themepanel Ends-->    
		<div id="inner-container">		
			<div id="inner-left-container">
				<div id="tabbed-inner-nav">
                <div class="tabbed-inner-nav-left">
					<ul class="menu">
						<li><a href="{$actualPath}/myselling.php"><span>Selling</span></a></li>
						<li class="active"><a href="{$actualPath}/myselling.php?mode=pending"><span>Pending</span></a></li>
						<li><a href="{$actualPath}/myselling.php?mode=sold"><span>Sold</span></a></li>
						<li><a href="{$actualPath}/myselling.php?mode=unsold">Unsold</a></li>
					</ul>
                    <div class="tabbed-inner-nav-right"></div>
				</div>	
				</div>			 
				<div class="innerpage-container-main">
					<div class="top-main-bg"></div>
					<div class="mid-rept-bg">
						<div class="top-display-panel">
							<div class="left-area">
								<div class="results-area" style="width:200px;"><span>{$displayCounterTXT}</span></div>
								<div class="pagination" style="width:200px;">{$pageCounterTXT}</div>							
							</div>						
						</div>
						<div class="display-listing-main">
						{section name=counter loop=$auction}
						<table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td class="list-poster-box">
										<div class="poster-area-list">
											<span><strong>&nbsp;&nbsp;&nbsp;<u>{$auction[counter].poster_title}</u></strong></span>
										</div>
										<div class="poster-area-list">
											<div class="shadowbottom">
                                       <div class="shadow-bringer shadow"><a href="javascript:void(0)"><img class="image-brdr" src="poster_photo/thumbnail/{$auction[counter].poster_thumb}" border="0" width="83" height="78" border="0" /></a></div></div><p>{$auction[counter].poster_desc}</p>
										</div>
										<div class="poster-area-list">
											<span><strong>&nbsp;</strong></span><br />
											<span><strong> &nbsp;</strong></span>									
										</div>
									</td>
									{if $auction[counter].fk_auction_type_id==3}
									<td class="list-auction-det">
										<label><strong>Start Bid</strong></label><br />
										<span><em>${$auction[counter].auction_asked_price}</em></span><br /><br />
										<span><strong><em>Time Left</em></strong></span><br />
										<span>
											{if $auction[counter].months >0}{$auction[counter].months} &nbsp;Monts&nbsp;{/if}
											{if $auction[counter].days >0}{$auction[counter].days} &nbsp;Days&nbsp;{/if}
											{if $auction[counter].hours >0}{$auction[counter].hours} &nbsp;Hours&nbsp;{/if}
											{if $auction[counter].min >0}{$auction[counter].min} &nbsp;Min&nbsp;{/if}
										</span><br /><br />
										<span><strong><em>End Time</em></strong></span><br />
										<span>{$auction[counter].time} EDT</span><br />
										<span>{$auction[counter].weekday}</span><br />
										<span>{$auction[counter].enddate}</span><br />
									</td>
									<td class="list-bid-det">
										<div class="price-box">
											<span><strong></strong></span>
											&nbsp;
											<span><strong>&nbsp;</strong></span>
										</div>
										<br /><br />
										<span><strong><em>Auctions cannot be modified until they expire.</em></strong></span><br />
										<span><strong> &nbsp;</strong></span>                                     
									</td> 
									{/if} 
									{if $auction[counter].fk_auction_type_id==2}
									<td class="list-auction-det">
										<label><strong>Start Bid</strong></label><br />
										<span><em>${$auction[counter].auction_asked_price}</em></span><br />
										<label><strong>Buy Now</strong></label><br />
										<span><em>${$auction[counter].auction_buynow_price}</em></span><br />
										<span><strong><em>Time Left</em></strong></span><br />
										<span>
											{if $auction[counter].months >0}{$auction[counter].months} &nbsp;Monts&nbsp;{/if}
											{if $auction[counter].days >0}{$auction[counter].days} &nbsp;Days&nbsp;{/if}
											{if $auction[counter].hours >0}{$auction[counter].hours} &nbsp;Hours&nbsp;{/if}
											{if $auction[counter].min >0}{$auction[counter].min} &nbsp;Min&nbsp;{/if}
										</span><br /><br />
										<span><strong><em>End Time</em></strong></span><br />
										<span>{$auction[counter].time} EDT</span><br />
										<span>{$auction[counter].weekday}</span><br />
										<span>{$auction[counter].enddate}</span><br />
									</td>                            
									<td class="list-bid-det">
										<div class="price-box">
											<span><strong></strong></span>
											&nbsp;
											<span><strong>&nbsp;</strong></span>
										</div>
										<br /><br />
										<span><strong><em>Auctions cannot be modified until they expire.</em></strong></span><br />
										<span><strong> &nbsp;</strong></span>                                     
									</td> 
									{/if} 
									{if $auction[counter].fk_auction_type_id==1}
									<td class="list-auction-det">
										<label><strong>Asking Price</strong></label><br />
										<span><em>${$auction[counter].auction_asked_price}</em></span><br /><br />
										<span><strong><em>&nbsp;</em></strong></span><br />
										<span></span><br /><br />
										<span><strong><em>&nbsp;</em></strong></span><br />
										<span>&nbsp;</span><br />
										<span>&nbsp;</span><br />
										<span>&nbsp;</span><br />
									</td>                            
									<td class="list-bid-det">
										<div class="price-box">
											<span><strong></strong></span>
											&nbsp;
											<span><strong>&nbsp;</strong></span>
										</div>
										<br /><br />
										<span><strong><em><a href="#">Modify</a></em></strong></span><br />
										<span><strong>Remove</strong></span>                                     
									</td> 
									{/if} 
								</tr>
							</table>
						{/section}
						</div>
					</div>
					<div class="btom-main-bg"></div>
				</div>
			</div>
			{include file="right-panel.tpl"}
		</div>
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}
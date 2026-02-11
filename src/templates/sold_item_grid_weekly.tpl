{include file="header.tpl"}
<link href="http://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.css" rel="stylesheet" type="text/css">
<link href="{$actualPath}/css/on-off-switch.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$actualPath}/javascript/on-off-switch.js"></script>
{literal}

<style>

.modal-box {
  display: none;
  position: fixed;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
  top: 50%;
  left: 50%;
}
@media (min-width: 32em) {

.modal-box { width: 50%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  /*background: rgba(0, 0, 0, 0.3) !important;*/
  /*height:1200px;*/
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
</style>

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
                        <li ><a href="{$actualPath}/sold_item?mode=fixed"><span>Fixed Price</span></a></li>
                        <li class="active"><a href="{$actualPath}/sold_item?mode=weekly"><span>Auction</span></a></li>
						{*<li  ><a href="{$actualPath}/sold_item?mode=stills" ><span>Stills/Photos</span></a></li>*}
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
									{if $smarty.request.mode=='search_sold_weekly'}
										<li class="list"><a href="sold_item?view_mode=list&mode=search_sold_weekly&search_sold={$smarty.request.search_sold|urlencode}">&nbsp;</a> </li>
									{else}
                                        <li class="list"><a href="sold_item?view_mode=list&mode=weekly">&nbsp;</a> </li>
									{/if}	
                                        |
                                        <li class="grida"><span class="active">&nbsp;</span></li>
                                    </ul>
                            </div>
							<form name="form1" method="get" >
                        <input type="hidden" value="search_sold_weekly" name="mode" >
                        <input type="hidden" value="{$smarty.request.offset}" name="offset" >
                        <input type="hidden" value="{$smarty.request.toshow}" name="toshow" >
                        	 {if $total > 0}
							<div class="soldSearchblock" style="clear:right;">
                            	
								<div style="width:500px; height:26px; border:1px solid #cecfd0; float:left;">
                                
                                <input type="text" style="width:450px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 5px;" class="midSearchbg_auction fll" id="search_sold" name="search_sold" {if $smarty.request.mode == 'search_sold_weekly'} value="{$smarty.request.search_sold}" {else} value="Search sold items by their title.."{/if} onfocus="clear_text()"  />
                                <input type="submit" class="rightSearchbg" value="" />
                            </div>
                            </div>
							
							
                              <div class="sortblock_auction2" style="clear: both; width: 285px; margin-top:8px; margin-left:0; text-align:left;" ><span class="headertext">&nbsp;</span><b>Sort By:</b>
						  <select name="auction_week" class="look" onchange="javascript: this.form.submit();">
                                 <option value="" selected="selected">All Auction</option>
                                 {section name=counter loop=$auctionWeek}
                                     <option value="{$auctionWeek[counter].auction_week_id}" {if $smarty.request.auction_week == $auctionWeek[counter].auction_week_id} selected {/if} >MPE Weekly Auction&nbsp;( {$auctionWeek[counter].auction_week_end_date|date_format:'%D'})</option>
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
							<div class="checkbox-container">
								<input type="checkbox" id="on-off-switch" name="switch1" checked>
								<input type="hidden" id="on-off-switch-val" value="true" >
							</div>
							<div id="listener-text">

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
                                        
                                             
                                            
                                             <div class="inner-cntnt-each-poster" id="item_{$smarty.section.counter.index}">
                                                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                    <div class="buygridtb">
														<div>
															<a class="js-open-modal btn" href="#" data-modal-id="popup1"> <img src="{$dataJstFinishedAuction[counter].image_path}" id="{$dataJstFinishedAuction[counter].poster_title}" /></a> 
															<!--<img class="image-brdr" src="{$dataJstFinishedAuction[counter].image_path}" onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;" />-->
														</div>
													</div>
													<div class="pb05 pl10 pr10 tac" style="height:40px;">
														<h3><a class="gridView" href="{$actualPath}/buy?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" style="cursor:pointer;" >{$dataJstFinishedAuction[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataJstFinishedAuction[counter].poster_sku}){/if*}</a> </h3>
													</div>
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
													<div class="buylist_cbid" style="width:230px; margin-right:0;font-size:12px;">&nbsp;&nbsp;<a href="javascript:void(0)" onclick="showLogIn();">Sign In</a> or <a href="register">Register</a> to view details</div>	
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

<div id="popup1" class="modal-box">
  <header> <a href="javascript:void(0)" class="js-modal-close close">×</a>
    <h3 id="img_title">Image Title</h3>
  </header>
  <div class="modal-body">
    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut commodo at felis vitae facilisis. Cras volutpat fringilla nunc vitae hendrerit. Donec porta id augue quis sodales. Sed sit amet metus ornare, mattis sem at, dignissim arcu. Cras rhoncus ornare mollis. Ut tempor augue mi, sed luctus neque luctus non. Vestibulum mollis tristique blandit. Aenean condimentum in leo ac feugiat. Sed posuere, est at eleifend suscipit, erat ante pretium turpis, eget semper ex risus nec dolor. Etiam pellentesque nulla neque, ut ullamcorper purus facilisis at. Nam imperdiet arcu felis, eu placerat risus dapibus sit amet. Praesent at justo at lectus scelerisque mollis. Mauris molestie mattis tellus ut facilisis. Sed vel ligula ornare, posuere velit ornare, consectetur erat.</p>-->
	<img src="https://d1o27s03otm3kw.cloudfront.net/62587.jpg" id="currImg" />
  </div>
  <!--<footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>-->
</div>

{literal}
<script>

$(function(){
	
	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
	$('a[data-modal-id]').mouseenter(function(e) {
	if($('#on-off-switch-val').val()=='true'){
		e.preventDefault();
		imgArr=e.target.src.split('/')
		currImg='https://d1o27s03otm3kw.cloudfront.net/'+imgArr[imgArr.length-1]
		$('#img_title').text(e.target.id);
		$('#currImg').attr('src', currImg);
		$("body").append(appendthis);
		$(".modal-overlay").fadeTo(500, 0.7);
			var modalBox = $(this).attr('data-modal-id');
			$('#'+modalBox).fadeIn($(this).data());
	  }
	}); 

  
$(".js-modal-close, .modal-overlay").click(function() {
//$('a[data-modal-id]').mouseleave(function(e) {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});

new DG.OnOffSwitch({
        el: '#on-off-switch',
        textOn: 'Show popup',
        textOff: 'Hide popup',
        listener:function(name, checked){
			$("#on-off-switch-val").val(checked)
            //$("#listener-text").html("Listener called for " + name + ", checked: " + checked);
        }
    });
</script>
{/literal}
{include file="foot.tpl"}
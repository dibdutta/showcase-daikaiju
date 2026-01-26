{include file="header-index.tpl"}

{literal}
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        visible: 4
    });
    jQuery(document).ready(function() {
        jQuery('#mycarousel1').jcarousel({
            visible: 4
        });
    });
    jQuery(document).ready(function() {
        jQuery('#mycarousel12').jcarousel({
            visible: 4
        });
    });
    jQuery(document).ready(function() {
        jQuery('#mycarousel13').jcarousel({
            visible: 4
        });
    });
});


function tipsy(id){
    $('#'+id).tipsy({fade: true});
  }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var cont_left = $("#container").position().left;
        $("a img").hover(function() {
		    var img_id= this.id;
			var src = $("#large_image_id_"+img_id).val();
			//var newSrc = src.split("/");
            // hover in
            $(this).parent().parent().css("z-index", 10);
            $("#"+img_id).attr("src", src);
			$(this).animate({
			   position: "absolute",
            }, "fast");
        }, function() {
			var img_id= this.id;
            var src = $("#small_image_id_"+img_id).val();
			//var newSrc = src.split("/");
            // hover out
            $(this).parent().parent().css("z-index", 0);
            $("#"+img_id).attr("src", src);
			$(this).animate({
			   position: "absolute",
            }, "fast");
        });

        $(".img").each(function(index) {
            var left = (index * 160) + cont_left;
            $(this).css("left", left + "px");
        });
    });
    </script>



<style type="text/css">
.jcarousel-skin-tango .jcarousel-container-horizontal {
    width: 90%;
	height:50%;
}
.jcarousel-skin-tango .jcarousel-clip-horizontal {
    width: 100%;
	height:50%;
    margin:0 auto;
}
</style>

{/literal}
<div id="outer-container">
	<div id="wrapper">
    <!--Header themepanel Starts-->
      {*include file="search-login.tpl"*}
    <!--Header themepanel Ends-->
    <div id="auctionboxes">
    <form name="listFrom" id="listFrom">
           <input type="hidden" name="mode" value="select_watchlist" />
           <input type="hidden" name="is_track" id="is_track" value="" />
           {if $errorMessage <> ""}<div class="messageBox" style="margin-top: 10px;">{$errorMessage}</div>{/if}
           {if $totMonthly > 0 || $totWeekly > 1}
             <div id="featured-auction">
               <div class="black-topbg-main">

                   <div class="black-left-crnr"></div>
                   <div class="black-midrept">
                       <span class="white-txt"><strong>Featured Auction Items</strong></span>
                   </div>
                   <div class="black-right-crnr"></div>
               </div>
               <div class="inner-white-box">
                   <div class="poster-container">
                       <div class="vertical-spacer"></div>
                       <div id="container">
                           <div id="wrap">

                               <ul id="mycarousel12" class="jcarousel-skin-tango">
                                   {if $totMonthly > 0}
                                       {section name=counter loop=$dataArrMonthly}
                                           <li>
                                               <div>
                                                   <div id="gallery_monthly{$smarty.section.counter.index}" class="image-hldr">
                                                       <table align="center"><tbody><tr><td align="center" valign="bottom">
                                                           <div class="shadowbottom">
                                                               <div class="shadow-bringer shadow"><div class="img"><a href="#"><img src="http://www.movieposterexchange.com/poster_photo/thumb_buy/{$dataArrMonthly[counter].poster_thumb}"   alt="" align="bottom" class="image-brdr" style="cursor:pointer;" id="{$dataArrMonthly[counter].auction_id}" onclick="redirect_poster_details({$dataArrMonthly[counter].auction_id});" /></a>
                                                               </div></div></div></td></tr></tbody></table>
                                                   </div>


                                                   <div class="poster-detail">${$dataArrMonthly[counter].auction_asked_price|number_format:2}</div>
                                                   <div class="poster-det-caraousel">
                                                       <a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataArrMonthly[counter].auction_id}" title="{$dataArrMonthly[counter].poster_title}"  id="tipsy_{$dataArrMonthly[counter].auction_id}" onMouseOver="tipsy(this.id)">{$dataArrMonthly[counter].poster_title|substr:0:10}..&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataArrMonthly[counter].poster_sku}){/if*}</a>

                                                   </div>
                                                   {if $dataArrMonthly[counter].watch_indicator == 0}
                                                       <div class="poster-area-list" style="margin-left:18px;">
                                                           <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrMonthly[counter].auction_id}');" />
                                                       </div>
                                                   {else}
                                                       <div class="poster-area-list" style="margin-left:18px;">
                                                           <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrMonthly[counter].auction_id});" class="track-btn"  />
                                                       </div>
                                                   {/if}
                                               </div>

                                           </li>
                                       {/section}
                                   {/if}
                                   {if $totWeekly > 0}
                                       {section name=counter loop=$dataArrWeekly}
                                           <li>
                                               <div>
                                                   <div id="gallery_weekly{$smarty.section.counter.index}" class="image-hldr">
                                                       <table align="center"><tbody><tr><td align="center" valign="bottom">
                                                           <div class="shadowbottom">
                                                               <div class="shadow-bringer shadow"><div class="img"><a href="#"><img class="image-brdr" src="{$dataArrWeekly[counter].image_path}" alt="" onclick="redirect_poster_details({$dataArrWeekly[counter].auction_id});" style="cursor:pointer;" id="{$dataArrWeekly[counter].auction_id}" /></a>
                                                                   <input type="hidden" value="{$dataArrWeekly[counter].large_image}" id="large_image_id_{$dataArrWeekly[counter].auction_id}">
                                                                   <input type="hidden" value="{$dataArrWeekly[counter].image_path}" id="small_image_id_{$dataArrWeekly[counter].auction_id}">
                                                               </div>
                                                               </div></div></td></tr></tbody></table>
                                                   </div>
                                                   <div class="poster-detail">${if $dataArrWeekly[counter].last_bid_amount|number_format:2 > 0}{$dataArrWeekly[counter].last_bid_amount|number_format:2}{else}{$dataArrWeekly[counter].auction_asked_price|number_format:2}{/if}</div>
                                                   <div class="poster-det-caraousel">

                                                       <a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataArrWeekly[counter].auction_id}" title="{$dataArrWeekly[counter].poster_title}" id="tipsy_{$dataArrWeekly[counter].auction_id}" onMouseOver="tipsy(this.id)" >{$dataArrWeekly[counter].poster_title|substr:0:10}..&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataArrWeekly[counter].poster_sku}){/if*}</a>								</div>




                                                   {if $dataArrWeekly[counter].watch_indicator == 0}
                                                       <div class="poster-area-list" style="margin-left:18px;">
                                                           <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrWeekly[counter].auction_id}');" />
                                                       </div>
                                                   {else}
                                                       <div class="poster-area-list" style="margin-left:18px;">
                                                           <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrWeekly[counter].auction_id});" class="track-btn"  />
                                                       </div>
                                                   {/if}
                                               </div>

                                           </li>
                                       {/section}
                                   {/if}
                               </ul>

                           {if $totMonthly < 1 && $totWeekly < 1}
                               <ul class="jcarousel-skin-tango">
                                   <li style="margin-left: 350px;"><b>No records found.</b></li>
                               </ul>
                           {/if}
                           </div>
                       </div>
                   </div>
               {if $totMonthly > 0 || $totWeekly > 0}
                   <div class="lower-poster-area">
                       
                       <input type="button" value="See All " class="more-btn" onclick="$(location).attr('href', '{$actualPath}/buy.php?list=weekly');" />
                   </div>
               {/if}
               </div>
               <div class="poster-end-bg-container">
                   <div class="left-corner"></div>
                   <div class="midrept"></div>
                   <div class="right-corner"></div>
               </div>
           </div>
           {/if}

           <!-- Upcoming Auction Section -->
           {if $totUpcoming>1}

           <div id="featured-auction">
               <div class="black-topbg-main">

                   <div class="black-left-crnr"></div>
                   <div class="black-midrept">
                       <span class="white-txt" ><strong style="cursor:pointer" onclick="$(location).attr('href', '{$actualPath}/buy.php?list=upcoming');">Featured Upcoming Auction </strong></span>
                   </div>
                   <div class="black-right-crnr"></div>
               </div>
               <div class="inner-white-box">
                   <div class="poster-container">
                       <div class="vertical-spacer"></div>
                       <div id="container">
                           <div id="wrap">
                               {if $totFixed > 0}
                                   <ul id="mycarousel13" class="jcarousel-skin-tango">
                                       {section name=counter loop=$dataArrUpcoming}
                                           <li>
                                               <div>

                                                   <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                                                       <table align="center"><tbody><tr><td align="center" valign="bottom"><div class="shadowbottom"><div class="shadow-bringer shadow">
                                                           <div class="img">
                                                               <a href="#">
                                                                   <img class="image-brdr" src="{$dataArrUpcoming[counter].image_path}"   alt=""  style="cursor:pointer;"  id="{$dataArrUpcoming[counter].auction_id}"  onclick="redirect_poster_details({$dataArrUpcoming[counter].auction_id});"/>
                                                               </a>
                                                               <input type="hidden" value="{$dataArrUpcoming[counter].large_image}" id="large_image_id_{$dataArrUpcoming[counter].auction_id}">
                                                               <input type="hidden" value="{$dataArrUpcoming[counter].image_path}" id="small_image_id_{$dataArrUpcoming[counter].auction_id}">
                                                           </div>
                                                       </div></div></td></tr></tbody></table>
                                                   </div>

                                                   <div class="poster-detail">${$dataArrUpcoming[counter].auction_asked_price|number_format:2}</div>
                                                   <div class="poster-det-caraousel">
                                                       <a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataArrUpcoming[counter].auction_id}" title="{$dataArrUpcoming[counter].poster_title}"  id="tipsy_{$dataArrUpcoming[counter].auction_id}" onMouseOver="tipsy(this.id)" >{$dataArrUpcoming[counter].poster_title|substr:0:10}..&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataArrUpcoming[counter].poster_sku}){/if*}</a>
                                                   </div>
                                                   {if $dataArrUpcoming[counter].watch_indicator == 0}
                                                       <div class="poster-area-list" style="margin-left:28px;">
                                                           <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrUpcoming[counter].auction_id}');" />
                                                       </div>
                                                       {else}
                                                       <div class="poster-area-list" style="margin-left:18px;">
                                                           <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrUpcoming[counter].auction_id});" class="track-btn"  />
                                                       </div>
                                                   {/if}
                                               </div>

                                           </li>

                                       {/section}
                                   </ul>
                                   {else}
                                   <ul  class="jcarousel-skin-tango">
                                       <li style="margin-left: 350px;">
                                           <b>No records found.</b>
                                       </li>
                                   </ul>
                               {/if}
                           </div>
                       </div>
                   </div>
                   {if $totUpcoming > 0}
                       <div class="lower-poster-area">

                           <input type="button" value="See All " class="more-btn" onclick="$(location).attr('href', '{$actualPath}/buy.php?list=upcoming');" />
                       </div>
                   {/if}
               </div>
               <div class="poster-end-bg-container">
                   <div class="left-corner"></div>
                   <div class="midrept"></div>
                   <div class="right-corner"></div>
               </div>
           </div>

           {/if}
        <div class="auction-panels">


            <div class="black-topbg-main">
            {*if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div><div>&nbsp;</div>{/if*}
        		            	<div class="black-left-crnr"></div>
                <div class="black-midrept">
                	<span class="white-txt" ><strong style="cursor:pointer" onclick="$(location).attr('href', '{$actualPath}/buy.php?list=fixed');">Featured Items for Sale</strong></span>
                </div>
                <div class="black-right-crnr"></div>
            </div>
            <div class="inner-white-box">
            	<div class="poster-container">
                <div class="vertical-spacer"></div>
				<div id="container">
                <div id="wrap">
                {if $totFixed > 0}
                <ul id="mycarousel" class="jcarousel-skin-tango">
                {section name=counter loop=$dataArrFixed}
                <li>
                <div>

                <div id="gallery_{$smarty.section.counter.index}" class="image-hldr">
                   <table align="center"><tbody><tr><td align="center" valign="bottom"><div class="shadowbottom"><div class="shadow-bringer shadow">
				   <div class="img">
				   <a href="#">
				   <img class="image-brdr" src="{$dataArrFixed[counter].image_path}"   alt=""  style="cursor:pointer;"  id="{$dataArrFixed[counter].auction_id}"  onclick="redirect_poster_details({$dataArrFixed[counter].auction_id});"/>
				   </a>
                       <input type="hidden" value="{$dataArrFixed[counter].large_image}" id="large_image_id_{$dataArrFixed[counter].auction_id}">
                       <input type="hidden" value="{$dataArrFixed[counter].image_path}" id="small_image_id_{$dataArrFixed[counter].auction_id}">
				   </div>
				   </div></div></td></tr></tbody></table>
				 </div>

                <div class="poster-detail">${$dataArrFixed[counter].auction_asked_price|number_format:2}</div>
                <div class="poster-det-caraousel">
                <a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataArrFixed[counter].auction_id}" title="{$dataArrFixed[counter].poster_title}"  id="tipsy_{$dataArrFixed[counter].auction_id}" onMouseOver="tipsy(this.id)" >{$dataArrFixed[counter].poster_title|substr:0:10}..&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataArrFixed[counter].poster_sku}){/if*}</a>
				</div>
                    {if $dataArrFixed[counter].watch_indicator == 0}
                        <div class="poster-area-list" style="margin-left:28px;">
                            <input type="button" value="Watch this item" class="track-btn" onclick="add_watchlist('{$dataArrFixed[counter].auction_id}');" />
                        </div>
                    {else}
                        <div class="poster-area-list" style="margin-left:18px;">
                            <input type="button" value="You are watching&nbsp;&nbsp;" onclick="redirect_watchlist({$dataArrFixed[counter].auction_id});" class="track-btn"  />
                        </div>
                	{/if}
                </div>

                </li>

                {/section}
                </ul>
                {else}
                <ul  class="jcarousel-skin-tango">
                <li style="margin-left: 350px;">
                <b>No records found.</b>
                </li>
                </ul>
                {/if}
                </div>
				</div>
           </div>
           {if $totFixed > 0}
            <div class="lower-poster-area">
<!--              	<input type="button" value="Bid Now!!" class="bidnow-btn"/>-->
                    <input type="button" value="See All " class="more-btn" onclick="$(location).attr('href', '{$actualPath}/buy.php?list=fixed');" />
                </div>
                {/if}


        </div>

         <div class="poster-end-bg-container">
            	<div class="left-corner"></div>
                <div class="midrept"></div>
                <div class="right-corner"></div>
         </div>

          <div class="black-topbg-main">
        		            	<div class="black-left-crnr"></div>
                <div class="black-midrept">
                	<span class="white-txt" ><strong style="cursor:pointer" onclick="$(location).attr('href', '{$actualPath}/sold_item.php');">Recent Sales Results</strong></span>
                </div>
                <div class="black-right-crnr"></div>
            </div>

            <div class="inner-white-box">
            	<div class="poster-container">
                <div class="vertical-spacer"></div>
                <div id="container">
                <div id="wrap">
                {if $totJstFinished > 0}
                <ul id="mycarousel1" class="jcarousel-skin-tango">
                {section name=counter loop=$dataJstFinishedAuction}
                <li>
                <div>

                <div id="gallery_sold{$smarty.section.counter.index}" class="image-hldr">
                   <table align="center"><tbody><tr><td align="center" valign="bottom"><div class="shadowbottom"><div class="shadow-bringer shadow"><div class="img"><a href="#"><img class="image-brdr" src="{$dataJstFinishedAuction[counter].image_path}"   alt=""  onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});" style="cursor:pointer;"  id="{$dataJstFinishedAuction[counter].auction_id}"/></a>
                       <input type="hidden" value="{$dataJstFinishedAuction[counter].large_image}" id="large_image_id_{$dataJstFinishedAuction[counter].auction_id}">
                       <input type="hidden" value="{$dataJstFinishedAuction[counter].image_path}" id="small_image_id_{$dataJstFinishedAuction[counter].auction_id}">
                   </div></div></div></td></tr></tbody></table>
				 </div>




                <div class="poster-detail">${if $dataJstFinishedAuction[counter].soldamnt==''}0.00{else}{$dataJstFinishedAuction[counter].soldamnt}{/if}</div>
                <div class="poster-det-caraousel"><a href="{$actualPath}/buy.php?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}" title="{$dataJstFinishedAuction[counter].poster_title}" id="tipsy_{$dataJstFinishedAuction[counter].auction_id}" onMouseOver="tipsy(this.id)" >{$dataJstFinishedAuction[counter].poster_title|substr:0:10}..&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$dataJstFinishedAuction[counter].poster_sku}){/if*}</a></div>
                </div>

                </li>

                {/section}
                </ul>
                {else}
                <ul class="jcarousel-skin-tango">
                <li style="margin-left: 350px;">
                <b>No records found.</b>
                </li>
                </ul>
                {/if}
                </div>
                </div>
                </div>

            </div>
             <div class="poster-end-bg-container">
            	<div class="left-corner"></div>
                <div class="midrept"></div>
                <div class="right-corner"></div>
            </div>

    </div>

    </form>
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}

<script type="text/javascript" src="{$actualPath}/javascript/tooltip/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/slider/lib/jquery.jcarousel.min.demo.js"></script>
<script type="text/javascript" src="https://c15123524.ssl.cf2.rackcdn.com/jquery.metadata.js"></script>
{if $smarty.const.PHP_SELF != '/index.php' && $smarty.const.PHP_SELF != ''}
    <script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/jquery.validate.js"></script>
{/if}

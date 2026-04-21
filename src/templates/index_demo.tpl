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
        preload: false,
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
function formSubmit(){
    document.getElementById("frm1").submit();
}
</script>

<style>
/* Grid card layout — only affects interior of .home_fi sections */
.hp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    padding: 14px 0 4px;
}
.hp-card {
    background: #fff;
    border: 1px solid #ddd;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.hp-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.18); }
.hp-card-img-wrap {
    width: 100%;
    background: #e8e8e8;
    overflow: hidden;
    text-align: center;
}
.hp-card-img-wrap img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    cursor: pointer;
}
.hp-card-body {
    padding: 7px 8px 9px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}
.hp-card-price {
    color: #bd1a21;
    font-weight: bold;
    font-size: 13px;
}
.hp-card-title a {
    color: #222;
    text-decoration: none;
    line-height: 1.3;
    display: block;
}
.hp-card-title a:hover { color: #bd1a21; }
.hp-card-watch {
    margin-top: 5px;
    padding: 3px 10px;
    font-size: 11px;
    background: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    align-self: flex-start;
}
.hp-card-watch:hover { background: #bd1a21; }
</style>
{/literal}

<div id="outer-container">
<div id="wrapper">

    {* ── Hero: big slider + sidebar ─────────────────────────────────────────── *}
    <div class="featuredgallerydiv">

        <div id="fg_leftdiv">
            <div id="container">
            <div id="example">
            <div id="slides">
              <div class="slides_container slides_containerbg" style="width:570px;">
                {section name=counterslider loop=$dataArrSlider}
                  <div class="slide">
                    <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrSlider[counterslider].auction_id}"
                       title="{$dataArrSlider[counterslider].poster_title}">
                      <img src="{$dataArrSlider[counterslider].big_image}" alt="Slide">
                    </a>
                    <div class="caption"><p>{$dataArrSlider[counterslider].poster_title}</p></div>
                  </div>
                {/section}
              </div>
              <a href="#" class="prev"><img src="https://d294w6g1afjpvs.cloudfront.net/images/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
              <a href="#" class="next"><img src="https://d294w6g1afjpvs.cloudfront.net/images/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
            </div>
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
                        <input type="text" name="ea" size="20" value="" style="float:left\9;" />
                        <input name="" type="button" onclick="formSubmit();" style="float:right\9;" />
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <div class="bannersidebar pb12">
                <table width="315" border="0" cellspacing="0" cellpadding="0">
                    <tr><td class="bannersidebartopbg"></td></tr>
                    <tr>
                        <td class="bannersidebarcenter pl14 pr10">
                            <a href="{$smarty.const.BANNER_LINK}"><h3>Click Here</h3><h1>{$smarty.const.BANNER_TITLE}</h1></a>
                        </td>
                    </tr>
                    <tr><td class="bannersidebarbottombg"></td></tr>
                </table>
            </div>
            <div class="clear"></div>
            <div style="padding:6px 0;" class="dashboard-main">
                <div class="dashblock mr24" style="margin-left:-15px; width:300px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr><th width="80%" align="left" valign="top" class="tal" style="background-color:#bd1a21; color:#FFFFFF;">Event Calendar</th></tr>
                    </table>
                    <div class="scrollable" style="width:300px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:30px; color:blue;">
                            <tr><td width="100%"><b><i><u><a href="{$calenderArray.auction_1_link}" style="color:blue;font-size:15px;">{$calenderArray.auction_1}</a></u></i></b></td></tr>
                            <tr><td width="100%"><b><i><u><a href="{$calenderArray.auction_2_link}" style="color:blue;font-size:15px;">{$calenderArray.auction_2}</a></u></i></b></td></tr>
                            <tr><td width="100%"><b><i><u><a href="{$calenderArray.auction_3_link}" style="color:blue;font-size:15px;">{$calenderArray.auction_3}</a></u></i></b></td></tr>
                            <tr><td width="100%"><b><i><u><a href="{$calenderArray.auction_4_link}" style="color:blue;font-size:15px;">{$calenderArray.auction_4}</a></u></i></b></td></tr>
                            <tr><td width="100%"><b><i><u><a href="{$calenderArray.auction_5_link}" style="color:blue;font-size:15px;">{$calenderArray.auction_5}</a></u></i></b></td></tr>
                        </table>
                    </div>
                    <div class="dashboard-main_shadow" style="width:300px;"></div>
                </div>
            </div>
            <div style="padding:6px 0;" class="dashboard-main">
                <div class="dashblock mr24" style="margin-left:-15px; width:300px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr><th width="80%" align="left" valign="top" class="tal" style="background-color:#bd1a21; color:#FFFFFF;">Featured Articles</th></tr>
                    </table>
                    <div class="scrollable" style="width:300px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px; color:blue;">
                            {if $featuredArticles}
                                {foreach from=$featuredArticles item=article}
                                <tr><td width="100%"><b><i><u><a href="{$smarty.const.DOMAIN_PATH}/blog.php?slug={$article.slug}" style="color:blue;font-size:14px;">{$article.title}</a></u></i></b></td></tr>
                                {/foreach}
                            {else}
                                <tr><td style="font-size:11px;color:#888;padding:4px 0;">No articles yet.</td></tr>
                            {/if}
                        </table>
                    </div>
                    <div class="dashboard-main_shadow" style="width:300px;"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

    </div>{* end .featuredgallerydiv — floats cleared by .home_fi clear:both below *}

    {* ── Grid sections — .home_fi provides clear:both, width, black h2 header ── *}
    <form name="listFrom" id="listFrom">
        <input type="hidden" name="mode" value="select_watchlist" />
        <input type="hidden" name="is_track" id="is_track" value="" />

        {if $totWeekly > 0}
        <div class="home_fi">
            <h2>Featured Auction Items</h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrWeekly}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrWeekly[counter].image_path}"
                             alt="{$dataArrWeekly[counter].poster_title}"
                             onclick="redirect_poster_details({$dataArrWeekly[counter].auction_id});">
                    </div>
                    <div class="hp-card-body">
                        {if $smarty.session.sessUserID <> ""}
                        <div class="hp-card-price">
                            ${if $dataArrWeekly[counter].last_bid_amount > 0}{$dataArrWeekly[counter].last_bid_amount|number_format:2}{else}{$dataArrWeekly[counter].auction_asked_price|number_format:2}{/if}
                        </div>
                        {/if}
                        <div class="hp-card-title">
                            <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrWeekly[counter].auction_id}"
                               title="{$dataArrWeekly[counter].poster_title}"
                               id="tipsy_{$dataArrWeekly[counter].auction_id}"
                               onmouseover="tipsy(this.id)">{$dataArrWeekly[counter].poster_title}</a>
                        </div>
                        {if $dataArrWeekly[counter].watch_indicator == 0}
                        <button class="hp-card-watch" onclick="add_watchlist('{$dataArrWeekly[counter].auction_id}');" id="watch_{$dataArrWeekly[counter].auction_id}">Watch this item</button>
                        {else}
                        <button class="hp-card-watch" onclick="redirect_watchlist({$dataArrWeekly[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
            <div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=weekly');" /></div>
        </div>
        {/if}

        {if $totUpcoming > 1}
        <div class="home_fi">
            <h2>Featured Upcoming Auction</h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrUpcoming}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrUpcoming[counter].image_path}"
                             alt="{$dataArrUpcoming[counter].poster_title}"
                             onclick="redirect_poster_details({$dataArrUpcoming[counter].auction_id});">
                    </div>
                    <div class="hp-card-body">
                        {if $smarty.session.sessUserID <> ""}
                        <div class="hp-card-price">${$dataArrUpcoming[counter].auction_asked_price|number_format:2}</div>
                        {/if}
                        <div class="hp-card-title">
                            <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrUpcoming[counter].auction_id}"
                               title="{$dataArrUpcoming[counter].poster_title}"
                               id="tipsy_{$dataArrUpcoming[counter].auction_id}"
                               onmouseover="tipsy(this.id)">{$dataArrUpcoming[counter].poster_title}</a>
                        </div>
                        {if $dataArrUpcoming[counter].watch_indicator == 0}
                        <button class="hp-card-watch" onclick="add_watchlist('{$dataArrUpcoming[counter].auction_id}');" id="watch_{$dataArrUpcoming[counter].auction_id}">Watch this item</button>
                        {else}
                        <button class="hp-card-watch" onclick="redirect_watchlist({$dataArrUpcoming[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
            <div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=upcoming');" /></div>
        </div>
        {/if}

        {if $totFixed > 0}
        <div class="home_fi">
            <h2>Featured Items for Sale</h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrFixed}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrFixed[counter].image_path}"
                             alt="{$dataArrFixed[counter].poster_title}"
                             onclick="redirect_poster_details({$dataArrFixed[counter].auction_id});">
                    </div>
                    <div class="hp-card-body">
                        {if $smarty.session.sessUserID <> ""}
                        <div class="hp-card-price">${$dataArrFixed[counter].auction_asked_price|number_format:2}</div>
                        {/if}
                        <div class="hp-card-title">
                            <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataArrFixed[counter].auction_id}"
                               title="{$dataArrFixed[counter].poster_title}"
                               id="tipsy_{$dataArrFixed[counter].auction_id}"
                               onmouseover="tipsy(this.id)">{$dataArrFixed[counter].poster_title}</a>
                        </div>
                        {if $dataArrFixed[counter].watch_indicator == 0}
                        <button class="hp-card-watch" onclick="add_watchlist('{$dataArrFixed[counter].auction_id}');" id="watch_{$dataArrFixed[counter].auction_id}">Watch this item</button>
                        {else}
                        <button class="hp-card-watch" onclick="redirect_watchlist({$dataArrFixed[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
            <div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/buy?list=fixed');" /></div>
        </div>
        {/if}

        {if $totJstFinished > 0}
        <div class="home_fi">
            <h2>Featured Sales Results</h2>
            <div class="hp-grid">
            {section name=counter loop=$dataJstFinishedAuction}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataJstFinishedAuction[counter].image_path}"
                             alt="{$dataJstFinishedAuction[counter].poster_title}"
                             onclick="redirect_poster_details({$dataJstFinishedAuction[counter].auction_id});">
                    </div>
                    <div class="hp-card-body">
                        {if $smarty.session.sessUserID <> ""}
                        <div class="hp-card-price">Sold: ${if $dataJstFinishedAuction[counter].soldamnt == ''}0.00{else}{$dataJstFinishedAuction[counter].soldamnt}{/if}</div>
                        {/if}
                        <div class="hp-card-title">
                            <a href="{$actualPath}/buy?mode=poster_details&auction_id={$dataJstFinishedAuction[counter].auction_id}"
                               title="{$dataJstFinishedAuction[counter].poster_title}"
                               id="tipsy_{$dataJstFinishedAuction[counter].auction_id}"
                               onmouseover="tipsy(this.id)">{$dataJstFinishedAuction[counter].poster_title}</a>
                        </div>
                    </div>
                </div>
            {/section}
            </div>
            <div class="seeall lower-poster-area"><input type="button" value="" class="seeall-btn" onclick="$(location).attr('href', '{$actualPath}/sold_item');" /></div>
        </div>
        {/if}

    </form>

    <div class="clear"></div>
</div>{* end #wrapper *}
</div>{* end #outer-container *}

{include file="footer_index.tpl"}
<script type="text/javascript" src="https://d294w6g1afjpvs.cloudfront.net/js/project.js"></script>
<script type="text/javascript" src="https://d294w6g1afjpvs.cloudfront.net/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="https://d294w6g1afjpvs.cloudfront.net/js/jquery.metadata.js"></script>
{if $smarty.const.PHP_SELF != '/index.php' && $smarty.const.PHP_SELF != ''}
    <script type="text/javascript" src="https://d294w6g1afjpvs.cloudfront.net/js/jquery.validate.js"></script>
{/if}

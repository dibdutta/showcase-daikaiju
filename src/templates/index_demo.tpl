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
/* ── Section headers — overrides .home_fi h2 sprite style ─────────────────── */
.home_fi h2 {
    background-image: none !important;
    background-color: #1c1c1c !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    font-family: Arial, Helvetica, sans-serif !important;
    letter-spacing: 2.5px !important;
    text-transform: uppercase !important;
    padding: 13px 18px 13px 16px !important;
    margin: 0 0 0 0 !important;
    border-left: 4px solid #bd1a21 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.home_fi h2 .h2-seeall {
    font-size: 11px;
    font-weight: 400;
    letter-spacing: 0.5px;
    text-transform: none;
    color: #bd1a21;
    text-decoration: none;
    border: 1px solid #bd1a21;
    padding: 3px 10px;
    border-radius: 2px;
    transition: all 0.2s;
}
.home_fi h2 .h2-seeall:hover {
    background: #bd1a21;
    color: #fff;
}

/* ── Card grid ─────────────────────────────────────────────────────────────── */
.hp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
    padding: 16px 0 8px;
}
.hp-card {
    background: #fff;
    border: 1px solid #e2e2e2;
    border-radius: 3px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.15s, box-shadow 0.15s;
}
.hp-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0,0,0,0.13);
}
.hp-card-img-wrap {
    width: 100%;
    background: #efefef;
    overflow: hidden;
}
.hp-card-img-wrap img {
    width: 100%;
    height: 185px;
    object-fit: cover;
    display: block;
    cursor: pointer;
    transition: transform 0.2s;
}
.hp-card:hover .hp-card-img-wrap img { transform: scale(1.04); }
.hp-card-body {
    padding: 9px 10px 11px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}
.hp-card-price {
    color: #bd1a21;
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 0.3px;
}
.hp-card-title a {
    color: #2c2c2c;
    text-decoration: none;
    line-height: 1.35;
    display: block;
    font-size: 12px;
}
.hp-card-title a:hover { color: #bd1a21; }

/* ── Watch button ──────────────────────────────────────────────────────────── */
.hp-card-watch {
    margin-top: 7px;
    padding: 6px 12px;
    font-size: 10px;
    font-weight: 700;
    font-family: Arial, Helvetica, sans-serif;
    letter-spacing: 1px;
    text-transform: uppercase;
    background: transparent;
    color: #555;
    border: 1.5px solid #bbb;
    border-radius: 2px;
    cursor: pointer;
    align-self: flex-start;
    transition: all 0.18s;
}
.hp-card-watch:hover {
    border-color: #bd1a21;
    color: #bd1a21;
    background: #fff5f5;
}
.hp-card-watch--watching {
    border-color: #3a6152;
    color: #3a6152;
}
.hp-card-watch--watching:hover {
    background: #f0f7f4;
    border-color: #2d4f42;
    color: #2d4f42;
}
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
            <h2>Featured Auction Items <a href="{$actualPath}/buy?list=weekly" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrWeekly}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrWeekly[counter].large_image}"
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
                        <button class="hp-card-watch hp-card-watch--watching" onclick="redirect_watchlist({$dataArrWeekly[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
        </div>
        {/if}

        {if $totUpcoming > 1}
        <div class="home_fi">
            <h2>Featured Upcoming Auction <a href="{$actualPath}/buy?list=upcoming" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrUpcoming}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrUpcoming[counter].large_image}"
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
                        <button class="hp-card-watch hp-card-watch--watching" onclick="redirect_watchlist({$dataArrUpcoming[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
        </div>
        {/if}

        {if $totFixed > 0}
        <div class="home_fi">
            <h2>Featured Items for Sale <a href="{$actualPath}/buy?list=fixed" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-grid">
            {section name=counter loop=$dataArrFixed}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataArrFixed[counter].large_image}"
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
                        <button class="hp-card-watch hp-card-watch--watching" onclick="redirect_watchlist({$dataArrFixed[counter].auction_id});">You are watching</button>
                        {/if}
                    </div>
                </div>
            {/section}
            </div>
        </div>
        {/if}

        {if $totJstFinished > 0}
        <div class="home_fi">
            <h2>Featured Sales Results <a href="{$actualPath}/sold_item" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-grid">
            {section name=counter loop=$dataJstFinishedAuction}
                <div class="hp-card">
                    <div class="hp-card-img-wrap">
                        <img src="{$dataJstFinishedAuction[counter].large_image}"
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

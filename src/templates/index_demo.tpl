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

$(function(){
    $('.hp-carousel-wrap').each(function(){
        updateArrows($(this));
    });
});
function hpSlide(btn, dir) {
    var wrap  = $(btn).closest('.hp-carousel-wrap');
    var track = wrap.find('.hp-track');
    var card  = track.find('.hp-card').first();
    var cardW = card.outerWidth(true);
    var visible = 5;
    var total   = track.find('.hp-card').length;
    var maxPos  = Math.max(0, total - visible);
    var pos     = parseInt(track.data('pos') || 0);
    pos = Math.max(0, Math.min(maxPos, pos + dir));
    track.data('pos', pos);
    track.stop(true).animate({ left: -(pos * cardW) + 'px' }, 280);
    updateArrows(wrap);
}
function updateArrows(wrap) {
    var track   = wrap.find('.hp-track');
    var visible = 5;
    var total   = track.find('.hp-card').length;
    var pos     = parseInt(track.data('pos') || 0);
    wrap.find('.hp-prev').toggleClass('hp-arrow-disabled', pos === 0);
    wrap.find('.hp-next').toggleClass('hp-arrow-disabled', pos >= total - visible);
}
</script>

{/literal}

{if $liveHero}
{* ── Live auction hero: replaces the slider + sidebar while a weekly auction runs ── *}
<script>var _klLive = {ldelim}end: {$liveHero.end_ms}, server: {$liveHero.server_ms}{rdelim};</script>
<section class="kl-live-hero" aria-label="{$liveHero.title|escape:'html'} is live">
    <div class="kl-live-inner">
        <div class="kl-live-main">
            <div class="kl-live-eyebrow"><span class="kl-live-dot"></span>LIVE NOW &middot; BIDDING OPEN</div>
            <h1 class="kl-live-title{if $liveHero.is_long} kl-live-title--long{/if}">{$liveHero.title_lead|escape:'html'}{if $liveHero.title_accent}<br><span>{$liveHero.title_accent|escape:'html'}</span>{/if}</h1>
            <p class="kl-live-lede">{$liveHero.lots} lot{if $liveHero.lots != 1}s{/if} of rare kaiju collectibles up for bid. Bidding closes {$liveHero.end_day} at {$liveHero.end_time}.</p>
            <div class="kl-live-countdown-label" id="klLiveLabel">AUCTION ENDS IN</div>
            <div class="kl-live-countdown" id="klLiveCountdown" role="timer">
                <div class="kl-live-unit"><span data-unit="d">--</span><small>DAYS</small></div>
                <div class="kl-live-unit"><span data-unit="h">--</span><small>HOURS</small></div>
                <div class="kl-live-unit"><span data-unit="m">--</span><small>MINUTES</small></div>
                <div class="kl-live-unit"><span data-unit="s">--</span><small>SECONDS</small></div>
            </div>
            <div class="kl-live-ctas">
                <a class="kl-live-btn" href="{$actualPath}/buy?list=weekly">BROWSE ALL LOTS &rarr;</a>
                <a class="kl-live-btn kl-live-btn--ghost" href="{$actualPath}/faq">How bidding works</a>
            </div>
            <div class="kl-live-stats">
                <span><strong>{$liveHero.lots}</strong> lot{if $liveHero.lots != 1}s{/if}</span>
                <span><strong>{$liveHero.bids}</strong> bid{if $liveHero.bids != 1}s{/if} placed</span>
                {if $liveHero.bidders > 0}<span><strong>{$liveHero.bidders}</strong> bidder{if $liveHero.bidders != 1}s{/if}</span>{/if}
            </div>
        </div>

        {if $liveHero.featured}
        <article class="kl-live-lot">
            <a class="kl-live-lot-img" href="{$liveHero.featured.poster_url}">
                <img src="{$liveHero.featured.big_image}" alt="{$liveHero.featured.poster_title}">
                <span class="kl-live-tag">FEATURED LOT</span>
            </a>
            <div class="kl-live-lot-body">
                <h2><a href="{$liveHero.featured.poster_url}">{$liveHero.featured.poster_title}</a></h2>
                <div class="kl-live-lot-meta">
                    {if $smarty.session.sessUserID <> ""}
                    <div>
                        <small>{if $liveHero.featured.last_bid_amount > 0}Current bid{else}Starting bid{/if}</small>
                        <strong>${if $liveHero.featured.last_bid_amount > 0}{$liveHero.featured.last_bid_amount|number_format:2}{else}{$liveHero.featured.auction_asked_price|number_format:2}{/if}</strong>
                    </div>
                    {else}
                    <div>
                        <small>Current bid</small>
                        <a href="javascript:void(0);" onclick="showLogIn();" class="kl-live-signin">Sign in to see bids</a>
                    </div>
                    {/if}
                    <span>{$liveHero.featured.bid_count|default:0} bid{if $liveHero.featured.bid_count != 1}s{/if}</span>
                </div>
                <a class="kl-live-btn kl-live-btn--block" href="{$liveHero.featured.poster_url}">PLACE A BID</a>
            </div>
        </article>
        {/if}
    </div>
</section>
{if $liveHero.next}
<div class="kl-live-next">
    <div class="kl-live-next-inner">
        Coming up next: <strong>{$liveHero.next.title|escape:'html'}</strong> &mdash; starts {$liveHero.next.starts}
        <a href="{$actualPath}/buy?list=upcoming">Preview lots &rarr;</a>
    </div>
</div>
{/if}
{literal}
<script>
(function(){
    var cfg = window._klLive, box = document.getElementById('klLiveCountdown');
    if (!cfg || !box) return;
    var offset = cfg.server - Date.now(); // trust the server clock, not the visitor's
    var units = {};
    ['d','h','m','s'].forEach(function(u){ units[u] = box.querySelector('[data-unit="' + u + '"]'); });
    function pad(n){ return (n < 10 ? '0' : '') + n; }
    function tick(){
        var ms = cfg.end - (Date.now() + offset);
        if (ms <= 0) {
            ms = 0;
            document.getElementById('klLiveLabel').textContent = 'BIDDING HAS CLOSED';
            clearInterval(timer);
        }
        units.d.textContent = pad(Math.floor(ms / 864e5));
        units.h.textContent = pad(Math.floor(ms / 36e5) % 24);
        units.m.textContent = pad(Math.floor(ms / 6e4) % 60);
        units.s.textContent = pad(Math.floor(ms / 1e3) % 60);
    }
    var timer = setInterval(tick, 1000);
    tick();
})();
</script>
{/literal}
{/if}

<div id="outer-container">
<div id="wrapper">

    {if !$liveHero}
    {* ── Hero: big slider + sidebar ─────────────────────────────────────────── *}
    <div class="featuredgallerydiv">

        <div id="fg_leftdiv">
            <div id="container">
            <div id="example">
            <div id="slides">
              <div class="slides_container slides_containerbg" style="width:570px;">
                {section name=counterslider loop=$dataArrSlider}
                  <div class="slide">
                    <a href="{$dataArrSlider[counterslider].poster_url}"
                       title="{$dataArrSlider[counterslider].poster_title}">
                      <img src="{$dataArrSlider[counterslider].big_image}" alt="Slide">
                    </a>
                    <div class="caption"><p>{$dataArrSlider[counterslider].poster_title}</p></div>
                  </div>
                {/section}
              </div>
              <a href="#" class="prev"><img src="{$smarty.const.CLOUD_STATIC}arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
              <a href="#" class="next"><img src="{$smarty.const.CLOUD_STATIC}arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
            </div>
            </div>
            </div>
        </div>

        <div id="fg_rightdiv">
            {* MAILING LIST — commented out, will use later
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
            *}
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
                                <tr><td width="100%"><b><i><u><a href="{$actualPath}/blog/{$article.slug}" style="color:blue;font-size:14px;">{$article.title}</a></u></i></b></td></tr>
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
    {/if}

    {* ── Carousel sections ──────────────────────────────────────────────────── *}
    <form name="listFrom" id="listFrom">
        <input type="hidden" name="mode" value="select_watchlist" />
        <input type="hidden" name="is_track" id="is_track" value="" />

        {if $totWeekly > 0}
        <div class="home_fi">
            <h2>{if $liveHero}<span><span class="kl-live-dot"></span>More lots in the {$liveHero.title|escape:'html'}</span>{else}Featured Auction Items{/if} <a href="{$actualPath}/buy?list=weekly" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-carousel-wrap">
                <button type="button" class="hp-prev" onclick="hpSlide(this, -1)">&#8249;</button>
                <div class="hp-viewport">
                    <div class="hp-track">
                    {section name=counter loop=$dataArrWeekly}
                        <div class="hp-card">
                            <div class="hp-card-img-wrap">
                                <a href="{$dataArrWeekly[counter].poster_url}">
                                <img src="{$dataArrWeekly[counter].large_image}"
                                     alt="{$dataArrWeekly[counter].poster_title}">
                                </a>
                                {if $liveHero}<span class="kl-live-badge"><span class="kl-live-dot"></span>LIVE</span>{/if}
                            </div>
                            <div class="hp-card-body">
                                {if $smarty.session.sessUserID <> ""}
                                <div class="hp-card-price">${if $dataArrWeekly[counter].last_bid_amount > 0}{$dataArrWeekly[counter].last_bid_amount|number_format:2}{else}{$dataArrWeekly[counter].auction_asked_price|number_format:2}{/if}</div>
                                {/if}
                                <div class="hp-card-title">
                                    <a href="{$dataArrWeekly[counter].poster_url}"
                                       title="{$dataArrWeekly[counter].poster_title}"
                                       id="tipsy_{$dataArrWeekly[counter].auction_id}"
                                       onmouseover="tipsy(this.id)">{$dataArrWeekly[counter].poster_title}</a>
                                </div>
                                {if $liveHero}
                                <div class="hp-card-bids">{$dataArrWeekly[counter].bid_count|default:0} bid{if $dataArrWeekly[counter].bid_count != 1}s{/if}</div>
                                {/if}
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
                <button type="button" class="hp-next" onclick="hpSlide(this, 1)">&#8250;</button>
            </div>
        </div>
        {/if}

        {if $totUpcoming > 1}
        <div class="home_fi">
            <h2>Featured Upcoming Auction <a href="{$actualPath}/buy?list=upcoming" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-carousel-wrap">
                <button type="button" class="hp-prev" onclick="hpSlide(this, -1)">&#8249;</button>
                <div class="hp-viewport">
                    <div class="hp-track">
                    {section name=counter loop=$dataArrUpcoming}
                        <div class="hp-card">
                            <div class="hp-card-img-wrap">
                                <a href="{$dataArrUpcoming[counter].poster_url}">
                                <img src="{$dataArrUpcoming[counter].large_image}"
                                     alt="{$dataArrUpcoming[counter].poster_title}">
                                </a>
                            </div>
                            <div class="hp-card-body">
                                {if $smarty.session.sessUserID <> ""}
                                <div class="hp-card-price">${$dataArrUpcoming[counter].auction_asked_price|number_format:2}</div>
                                {/if}
                                <div class="hp-card-title">
                                    <a href="{$dataArrUpcoming[counter].poster_url}"
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
                <button type="button" class="hp-next" onclick="hpSlide(this, 1)">&#8250;</button>
            </div>
        </div>
        {/if}

        {if $totFixed > 0}
        <div class="home_fi">
            <h2>Featured Items for Sale <a href="{$actualPath}/buy?list=fixed" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-carousel-wrap">
                <button type="button" class="hp-prev" onclick="hpSlide(this, -1)">&#8249;</button>
                <div class="hp-viewport">
                    <div class="hp-track">
                    {section name=counter loop=$dataArrFixed}
                        <div class="hp-card">
                            <div class="hp-card-img-wrap">
                                <a href="{$dataArrFixed[counter].poster_url}">
                                <img src="{$dataArrFixed[counter].large_image}"
                                     alt="{$dataArrFixed[counter].poster_title}">
                                </a>
                            </div>
                            <div class="hp-card-body">
                                {if $smarty.session.sessUserID <> ""}
                                <div class="hp-card-price">${$dataArrFixed[counter].auction_asked_price|number_format:2}</div>
                                {/if}
                                <div class="hp-card-title">
                                    <a href="{$dataArrFixed[counter].poster_url}"
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
                <button type="button" class="hp-next" onclick="hpSlide(this, 1)">&#8250;</button>
            </div>
        </div>
        {/if}

        {if $totJstFinished > 0}
        <div class="home_fi">
            <h2>Featured Sales Results <a href="{$actualPath}/sold_item" class="h2-seeall">See All &rarr;</a></h2>
            <div class="hp-carousel-wrap">
                <button type="button" class="hp-prev" onclick="hpSlide(this, -1)">&#8249;</button>
                <div class="hp-viewport">
                    <div class="hp-track">
                    {section name=counter loop=$dataJstFinishedAuction}
                        <div class="hp-card">
                            <div class="hp-card-img-wrap">
                                <a href="{$dataJstFinishedAuction[counter].poster_url}">
                                <img src="{$dataJstFinishedAuction[counter].large_image}"
                                     alt="{$dataJstFinishedAuction[counter].poster_title}">
                                </a>
                            </div>
                            <div class="hp-card-body">
                                {if $smarty.session.sessUserID <> ""}
                                <div class="hp-card-price">Sold: ${if $dataJstFinishedAuction[counter].soldamnt == ''}0.00{else}{$dataJstFinishedAuction[counter].soldamnt}{/if}</div>
                                {/if}
                                <div class="hp-card-title">
                                    <a href="{$dataJstFinishedAuction[counter].poster_url}"
                                       title="{$dataJstFinishedAuction[counter].poster_title}"
                                       id="tipsy_{$dataJstFinishedAuction[counter].auction_id}"
                                       onmouseover="tipsy(this.id)">{$dataJstFinishedAuction[counter].poster_title}</a>
                                </div>
                            </div>
                        </div>
                    {/section}
                    </div>
                </div>
                <button type="button" class="hp-next" onclick="hpSlide(this, 1)">&#8250;</button>
            </div>
        </div>
        {/if}

    </form>

    {* Featured Articles move here while the live hero has replaced the sidebar *}
    {if $liveHero && $featuredArticles}
    <div class="home_fi kl-blog-strip">
        <h2>From the Blog <a href="{$actualPath}/blog" class="h2-seeall">See All &rarr;</a></h2>
        <ul>
            {foreach from=$featuredArticles item=article}
            <li>
                <a href="{$actualPath}/blog/{$article.slug}">{$article.title}</a>
                <span>{$article.post_date|date_format:"%b %e, %Y"}</span>
            </li>
            {/foreach}
        </ul>
    </div>
    {/if}

    <div class="clear"></div>
</div>{* end #wrapper *}
</div>{* end #outer-container *}

{include file="footer_index.tpl"}
<script type="text/javascript" src="{$actualPathJSCSS}js/project.js"></script>
<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.tipsy.js"></script>
<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.metadata.js"></script>
{if $smarty.const.PHP_SELF != '/index.php' && $smarty.const.PHP_SELF != ''}
    <script type="text/javascript" src="{$actualPathJSCSS}js/jquery.validate.js"></script>
{/if}

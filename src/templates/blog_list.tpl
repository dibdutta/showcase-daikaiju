{include file="header.tpl"}
<div id="forinnerpage-container">
    <div id="wrapper">
        {include file="search-login.tpl"}
        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">

            <div id="inner-left-container">
                <div class="innerpage-container-main">

                    <div class="dashboard-main">
                        <h1>Blog &amp; Articles</h1>
                    </div>

                    <div class="left-midbg">
                    <div class="right-midbg">
                    <div class="mid-rept-bg">
                    <div class="inner-area-general">

                    {if $total > 0}
                        {foreach from=$posts item=p}
                        <div style="border-bottom:1px solid #e0e0e0; padding:16px 0 12px 0;">
                            {if $p.featured_image != ""}
                                <a href="{$smarty.const.DOMAIN_PATH}blog.php?slug={$p.slug}">
                                    <img src="{$smarty.const.DOMAIN_PATH}blog_images/{$p.featured_image}" alt="{$p.title|escape}" style="max-width:220px; float:left; margin:0 16px 8px 0; border:1px solid #ddd;" />
                                </a>
                            {/if}
                            <h2 style="margin:0 0 6px 0; font-size:16px;">
                                <a href="{$smarty.const.DOMAIN_PATH}blog.php?slug={$p.slug}" style="color:#bd1a21; text-decoration:none;">{$p.title|escape}</a>
                            </h2>
                            <p style="color:#888; font-size:11px; margin:0 0 8px 0;">{$p.post_date|date_format:"%B %d, %Y"}</p>
                            <p style="font-size:12px; color:#444;">
                                {$p.content|strip_tags|truncate:200:"...":false}
                            </p>
                            <a href="{$smarty.const.DOMAIN_PATH}blog.php?slug={$p.slug}" style="font-size:12px; color:#bd1a21;">Read more &raquo;</a>
                            <div class="clear"></div>
                        </div>
                        {/foreach}

                        <div style="padding:10px 0;">
                            {$pageCounterTXT}
                            &nbsp;&nbsp;{$displayCounterTXT}
                        </div>
                    {else}
                        <p>No articles have been published yet. Please check back soon.</p>
                    {/if}

                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="btom-right"></div>
                </div>
            </div>

        </div></div></div>
        </div>
        {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

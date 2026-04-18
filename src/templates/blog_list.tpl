{include file="header.tpl"}
<div id="forinnerpage-container">
    <div id="wrapper">
        <div id="headerthemepanel">
            {include file="search-login.tpl"}
        </div>
        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">

            <div id="inner-left-container">
                <div class="innerpage-container-main">
                    <div class="innerpage-container-main">

                        <div class="dashboard-main">
                            <h1>Blog &amp; Articles</h1>
                        </div>

                        <div class="left-midbg">
                        <div class="right-midbg">
                        <div class="mid-rept-bg">
                            <div class="inner-area-general" style="margin-left:16px; background-color:#FFF;">
                            <div class="mandatoryTxt" style="margin-left:18px;">

                            {if $total > 0}
                                {foreach from=$posts item=p}
                                <div style="border-bottom:1px solid #e8e8e8; padding:16px 0 14px 0; overflow:hidden;">
                                    {if $p.featured_image != ""}
                                        <a href="{$smarty.const.DOMAIN_PATH}/blog.php?slug={$p.slug}">
                                            <img src="{$smarty.const.BLOG_IMAGE_BASE_URL}{$p.featured_image}" alt="{$p.title|escape}" style="width:160px; height:110px; object-fit:cover; float:left; margin:0 14px 6px 0; border:1px solid #ddd;" />
                                        </a>
                                    {/if}
                                    <h2 style="margin:0 0 4px 0; font-size:15px; line-height:1.3;">
                                        <a href="{$smarty.const.DOMAIN_PATH}/blog.php?slug={$p.slug}" style="color:#bd1a21; text-decoration:none;">{$p.title|escape}</a>
                                    </h2>
                                    <p style="color:#999; font-size:11px; margin:0 0 8px 0;">{$p.post_date|date_format:"%B %d, %Y"}</p>
                                    <p style="font-size:12px; color:#555; margin:0 0 8px 0; line-height:1.6;">
                                        {$p.content|strip_tags|truncate:200:"...":false}
                                    </p>
                                    <a href="{$smarty.const.DOMAIN_PATH}/blog.php?slug={$p.slug}" style="font-size:11px; color:#bd1a21; font-weight:bold;">Read More &raquo;</a>
                                    <div class="clear"></div>
                                </div>
                                {/foreach}

                                <div style="padding:10px 0; font-size:12px;">
                                    {$pageCounterTXT}&nbsp;&nbsp;{$displayCounterTXT}
                                </div>
                            {else}
                                <p style="color:#666; font-size:13px;">No articles have been published yet. Please check back soon.</p>
                            {/if}

                            </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>

        </div></div></div>
        </div>
        {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

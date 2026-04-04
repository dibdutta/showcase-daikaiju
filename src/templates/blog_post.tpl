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
                            <h1>{$post.title|escape}</h1>
                            <p style="color:#999; font-size:11px; margin:2px 0 0 0;">{$post.post_date|date_format:"%B %d, %Y"}</p>
                        </div>

                        <div class="left-midbg">
                        <div class="right-midbg">
                        <div class="mid-rept-bg">
                            <div class="inner-area-general" style="margin-left:16px; background-color:#FFF;">
                            <div class="mandatoryTxt" style="margin-left:18px;">

                                {if $post.featured_image != ""}
                                <div style="margin-bottom:16px;">
                                    <img src="{$smarty.const.DOMAIN_PATH}/blog_images/{$post.featured_image}" alt="{$post.title|escape}" style="max-width:100%; border:1px solid #ddd;" />
                                </div>
                                {/if}

                                <div style="font-size:13px; line-height:1.8; color:#333;">
                                    {$post.content}
                                </div>

                                <div style="margin-top:16px; padding-top:10px; border-top:1px solid #e0e0e0;">
                                    <a href="{$smarty.const.DOMAIN_PATH}/blog.php" style="font-size:12px; color:#bd1a21; font-weight:bold;">&laquo; Back to Articles</a>
                                </div>

                                <div class="clear"></div>

                                {* ── Comments ──────────────────────────────────── *}
                                <div style="margin-top:24px; border-top:2px solid #bd1a21; padding-top:14px;">
                                    <h3 style="color:#bd1a21; font-size:14px; margin:0 0 12px 0; text-transform:uppercase; letter-spacing:1px;">Comments</h3>

                                    {if $comment_ok != ""}
                                        <div style="background:#d4edda; border:1px solid #28a745; padding:10px 12px; margin-bottom:12px; font-size:12px; color:#155724;">{$comment_ok}</div>
                                    {/if}
                                    {if $comment_err != ""}
                                        <div style="background:#f8d7da; border:1px solid #f5c6cb; padding:10px 12px; margin-bottom:12px; font-size:12px; color:#721c24;">{$comment_err}</div>
                                    {/if}

                                    {if $comments}
                                        {foreach from=$comments item=c}
                                        <div style="border-bottom:1px solid #f0f0f0; padding:10px 0;">
                                            <strong style="font-size:12px; color:#333;">{$c.commenter_name|escape}</strong>
                                            <span style="color:#aaa; font-size:11px; margin-left:8px;">{$c.post_date|date_format:"%B %d, %Y"}</span>
                                            <p style="margin:6px 0 0 0; font-size:12px; color:#555; line-height:1.6;">{$c.comment_text|escape|nl2br}</p>
                                        </div>
                                        {/foreach}
                                    {else}
                                        <p style="font-size:12px; color:#999;">No comments yet. Be the first to comment!</p>
                                    {/if}

                                    {* ── Comment form ───────────────────────────── *}
                                    <div style="margin-top:20px; background:#f9f9f9; border:1px solid #e8e8e8; padding:16px;">
                                        <h4 style="color:#444; margin:0 0 12px 0; font-size:13px; text-transform:uppercase; letter-spacing:1px;">Leave a Comment</h4>
                                        <form method="post" action="{$smarty.const.DOMAIN_PATH}/blog.php">
                                            <input type="hidden" name="mode" value="post_comment" />
                                            <input type="hidden" name="blog_id" value="{$post.blog_id}" />
                                            <input type="hidden" name="slug" value="{$post.slug}" />
                                            <table border="0" cellpadding="5" cellspacing="2" width="100%">
                                                <tr>
                                                    <td width="15%" style="font-size:12px; font-weight:bold; color:#555;"><span style="color:#bd1a21;">*</span> Name:</td>
                                                    <td><input type="text" name="commenter_name" class="look" style="width:300px;" /></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:12px; font-weight:bold; color:#555;"><span style="color:#bd1a21;">*</span> Email:</td>
                                                    <td>
                                                        <input type="email" name="commenter_email" class="look" style="width:300px;" />
                                                        <br /><small style="color:#aaa; font-size:10px;">Your email will not be published.</small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:12px; font-weight:bold; color:#555;" valign="top"><span style="color:#bd1a21;">*</span> Comment:</td>
                                                    <td><textarea name="comment_text" class="look" rows="5" style="width:98%;"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top:6px;">
                                                        <input type="submit" value="Submit Comment" class="button" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>

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

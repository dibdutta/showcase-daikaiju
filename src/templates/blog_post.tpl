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
                        <h1>{$post.title|escape}</h1>
                        <p style="color:#888; font-size:11px; margin:4px 0 0 0;">{$post.post_date|date_format:"%B %d, %Y"}</p>
                    </div>

                    <div class="left-midbg">
                    <div class="right-midbg">
                    <div class="mid-rept-bg">
                    <div class="inner-area-general">

                        {if $post.featured_image != ""}
                        <div style="margin-bottom:16px;">
                            <img src="{$smarty.const.DOMAIN_PATH}blog_images/{$post.featured_image}" alt="{$post.title|escape}" style="max-width:100%; border:1px solid #ddd;" />
                        </div>
                        {/if}

                        <div class="mandatoryTxt" style="font-size:13px; line-height:1.7;">
                            {$post.content}
                        </div>

                        <div style="margin-top:20px;">
                            <a href="{$smarty.const.DOMAIN_PATH}blog.php" style="font-size:12px; color:#bd1a21;">&laquo; Back to Articles</a>
                        </div>

                        <div class="clear"></div>

                        {* ── Comments section ───────────────────────────────────── *}
                        <div style="margin-top:30px; border-top:2px solid #bd1a21; padding-top:16px;">
                            <h3 style="color:#bd1a21; margin:0 0 14px 0;">Comments</h3>

                            {if $comment_ok != ""}
                                <div style="background:#d4edda; border:1px solid #28a745; padding:10px; margin-bottom:12px; font-size:12px;">{$comment_ok}</div>
                            {/if}
                            {if $comment_err != ""}
                                <div style="background:#f8d7da; border:1px solid #f5c6cb; padding:10px; margin-bottom:12px; font-size:12px;">{$comment_err}</div>
                            {/if}

                            {if $comments}
                                {foreach from=$comments item=c}
                                <div style="border-bottom:1px solid #eee; padding:10px 0;">
                                    <strong style="font-size:12px;">{$c.commenter_name|escape}</strong>
                                    <span style="color:#888; font-size:11px; margin-left:8px;">{$c.post_date|date_format:"%B %d, %Y"}</span>
                                    <p style="margin:6px 0 0 0; font-size:12px; color:#444;">{$c.comment_text|escape|nl2br}</p>
                                </div>
                                {/foreach}
                            {else}
                                <p style="font-size:12px; color:#888;">No comments yet. Be the first!</p>
                            {/if}

                            {* ── Leave a comment form ───────────────────────────── *}
                            <div style="margin-top:20px;">
                                <h4 style="color:#333; margin:0 0 10px 0; font-size:13px;">Leave a Comment</h4>
                                <form method="post" action="{$smarty.const.DOMAIN_PATH}blog.php">
                                    <input type="hidden" name="mode" value="post_comment" />
                                    <input type="hidden" name="blog_id" value="{$post.blog_id}" />
                                    <input type="hidden" name="slug" value="{$post.slug}" />
                                    <table border="0" cellpadding="4" cellspacing="2" width="100%">
                                        <tr>
                                            <td width="18%" class="bold_text" style="font-size:12px;"><span class="err">*</span> Name:</td>
                                            <td><input type="text" name="commenter_name" class="look" style="width:280px;" /></td>
                                        </tr>
                                        <tr>
                                            <td class="bold_text" style="font-size:12px;"><span class="err">*</span> Email:</td>
                                            <td><input type="email" name="commenter_email" class="look" style="width:280px;" />
                                            <br /><small style="color:#888;">Not published.</small></td>
                                        </tr>
                                        <tr>
                                            <td class="bold_text" style="font-size:12px;" valign="top"><span class="err">*</span> Comment:</td>
                                            <td><textarea name="comment_text" class="look" rows="5" style="width:98%;"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" value="Submit Comment" class="button" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>

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

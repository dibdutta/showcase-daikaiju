{if $jsonLd}<script type="application/ld+json">{$jsonLd nofilter}</script>{/if}
{include file="header.tpl"}

<style>
/* ── Blog Post Styles ─────────────────────────────────────────── */
.bp-wrap {
    max-width: 820px;
    margin: 0 auto;
    padding: 0 16px 40px;
}

/* Hero image */
.bp-hero {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    display: block;
    border-radius: 4px;
    margin-bottom: 28px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.13);
}

/* Header */
.bp-header {
    margin-bottom: 22px;
    border-bottom: 2px solid #bd1a21;
    padding-bottom: 16px;
}
.bp-header h1 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 10px 0;
    line-height: 1.35;
}
.bp-meta {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
    font-size: 12px;
    color: #888;
}
.bp-meta-date {
    display: flex;
    align-items: center;
    gap: 5px;
}
.bp-meta-date svg { opacity:.6; }
.bp-reading-time {
    display: flex;
    align-items: center;
    gap: 5px;
    background: #f5f0f0;
    color: #bd1a21;
    padding: 2px 9px;
    border-radius: 20px;
    font-weight: 600;
}

/* Content */
.bp-content {
    font-size: 15px;
    line-height: 1.85;
    color: #2d2d2d;
}
.bp-content h2, .bp-content h3, .bp-content h4 {
    color: #1a1a1a;
    margin-top: 28px;
    margin-bottom: 10px;
}
.bp-content p { margin: 0 0 16px; }
.bp-content img { max-width: 100%; height: auto; border-radius: 4px; margin: 12px 0; }
.bp-content a { color: #bd1a21; }
.bp-content blockquote {
    border-left: 4px solid #bd1a21;
    margin: 20px 0;
    padding: 10px 18px;
    background: #fdf5f5;
    color: #555;
    font-style: italic;
}
.bp-content ul, .bp-content ol { padding-left: 22px; margin-bottom: 16px; }
.bp-content li { margin-bottom: 6px; }
.bp-content table { border-collapse: collapse; width: 100%; margin-bottom: 16px; font-size: 13px; }
.bp-content table td, .bp-content table th { border: 1px solid #e0e0e0; padding: 7px 10px; }
.bp-content table th { background: #f5f5f5; font-weight: 700; }

/* Back link */
.bp-back {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #bd1a21;
    font-weight: 700;
    text-decoration: none;
    margin-top: 28px;
    padding: 7px 14px;
    border: 1px solid #bd1a21;
    border-radius: 3px;
    transition: background .15s, color .15s;
}
.bp-back:hover { background: #bd1a21; color: #fff; }

/* Divider */
.bp-divider {
    border: none;
    border-top: 1px solid #e8e8e8;
    margin: 32px 0;
}

/* Comments */
.bp-comments-heading {
    font-size: 16px;
    font-weight: 700;
    color: #bd1a21;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.bp-comment {
    border-bottom: 1px solid #f0f0f0;
    padding: 14px 0;
}
.bp-comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}
.bp-comment-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #bd1a21;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
}
.bp-comment-name { font-size: 13px; font-weight: 700; color: #333; }
.bp-comment-date { font-size: 11px; color: #aaa; margin-left: auto; }
.bp-comment-text { font-size: 13px; color: #555; line-height: 1.65; padding-left: 44px; }
.bp-no-comments { font-size: 13px; color: #999; font-style: italic; padding: 8px 0; }

/* Comment form */
.bp-form-box {
    background: #fafafa;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    padding: 20px;
    margin-top: 22px;
}
.bp-form-box h4 {
    font-size: 13px;
    font-weight: 700;
    color: #444;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 16px;
}
.bp-form-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.bp-form-group {
    flex: 1;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.bp-form-group label {
    font-size: 12px;
    font-weight: 600;
    color: #555;
}
.bp-form-group label span { color: #bd1a21; }
.bp-form-group input,
.bp-form-group textarea {
    padding: 7px 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    font-size: 13px;
    font-family: inherit;
    background: #fff;
    transition: border-color .15s;
}
.bp-form-group input:focus,
.bp-form-group textarea:focus {
    outline: none;
    border-color: #bd1a21;
}
.bp-form-group small { font-size: 10px; color: #aaa; }
.bp-submit-btn {
    background: #bd1a21;
    color: #fff;
    border: none;
    padding: 10px 28px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: .5px;
    text-transform: uppercase;
    border-radius: 3px;
    transition: background .15s;
}
.bp-submit-btn:hover { background: #9e1519; }
.bp-alert-ok {
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    padding: 10px 14px;
    font-size: 12px;
    border-radius: 3px;
    margin-bottom: 14px;
}
.bp-alert-err {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 10px 14px;
    font-size: 12px;
    border-radius: 3px;
    margin-bottom: 14px;
}
</style>

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

                    <div class="bp-wrap">

                        {* ── Hero image ───────────────────────────── *}
                        {if $post.featured_image != ""}
                            {if $post.featured_image|substr:0:4 == 'http'}
                                <img class="bp-hero" src="{$post.featured_image}" alt="{$post.title|escape}">
                            {else}
                                <img class="bp-hero" src="{$smarty.const.BLOG_IMAGE_BASE_URL}{$post.featured_image}" alt="{$post.title|escape}">
                            {/if}
                        {/if}

                        {* ── Post header ──────────────────────────── *}
                        <div class="bp-header">
                            <h1>{$post.title|escape}</h1>
                            <div class="bp-meta">
                                <span class="bp-meta-date">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {$post.post_date|date_format:"%B %d, %Y"}
                                </span>
                                {if $comments|@count > 0}
                                <span class="bp-meta-date">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    {$comments|@count} comment{if $comments|@count != 1}s{/if}
                                </span>
                                {/if}
                            </div>
                        </div>

                        {* ── Body content ─────────────────────────── *}
                        <div class="bp-content">
                            {$post.content nofilter}
                        </div>

                        <a href="/blog" class="bp-back">&#8592; Back to Articles</a>

                        <hr class="bp-divider">

                        {* ── Comments ─────────────────────────────── *}
                        <div>
                            <h3 class="bp-comments-heading">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                Comments
                                {if $comments}{assign var="cc" value=$comments|@count}({$cc}){/if}
                            </h3>

                            {if $comment_ok != ""}
                                <div class="bp-alert-ok">{$comment_ok}</div>
                            {/if}
                            {if $comment_err != ""}
                                <div class="bp-alert-err">{$comment_err}</div>
                            {/if}

                            {if $comments}
                                {foreach from=$comments item=c}
                                <div class="bp-comment">
                                    <div class="bp-comment-header">
                                        <div class="bp-comment-avatar">{$c.commenter_name|substr:0:1}</div>
                                        <span class="bp-comment-name">{$c.commenter_name|escape}</span>
                                        <span class="bp-comment-date">{$c.post_date|date_format:"%B %d, %Y"}</span>
                                    </div>
                                    <div class="bp-comment-text">{$c.comment_text|escape|nl2br}</div>
                                </div>
                                {/foreach}
                            {else}
                                <p class="bp-no-comments">No comments yet. Be the first to share your thoughts!</p>
                            {/if}

                            {* ── Comment form ─────────────────────── *}
                            <div class="bp-form-box">
                                <h4>Leave a Comment</h4>
                                <form method="post" action="/blog.php">
                                    <input type="hidden" name="mode" value="post_comment">
                                    <input type="hidden" name="blog_id" value="{$post.blog_id}">
                                    <input type="hidden" name="slug" value="{$post.slug}">

                                    <div class="bp-form-row">
                                        <div class="bp-form-group">
                                            <label><span>*</span> Name</label>
                                            <input type="text" name="commenter_name" placeholder="Your name" required>
                                        </div>
                                        <div class="bp-form-group">
                                            <label><span>*</span> Email</label>
                                            <input type="email" name="commenter_email" placeholder="your@email.com" required>
                                            <small>Your email will not be published.</small>
                                        </div>
                                    </div>
                                    <div class="bp-form-group" style="margin-bottom:14px;">
                                        <label><span>*</span> Comment</label>
                                        <textarea name="comment_text" rows="5" placeholder="Share your thoughts…" required></textarea>
                                    </div>
                                    <button type="submit" class="bp-submit-btn">Post Comment</button>
                                </form>
                            </div>
                        </div>

                    </div>{* /.bp-wrap *}

                </div>
            </div>

        </div></div></div>
        </div>
        {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

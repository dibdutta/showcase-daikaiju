{if $jsonLd}<script type="application/ld+json">{$jsonLd nofilter}</script>{/if}
{include file="header.tpl"}

<style>
.bp-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 28px 30px 30px;
    margin: 0 0 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}

.bp-title {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 8px;
    line-height: 1.35;
    border-bottom: 2px solid #bd1a21;
    padding-bottom: 12px;
}

.bp-meta {
    font-size: 11px;
    color: #999;
    margin-bottom: 20px;
}

.bp-featured-img {
    float: right;
    max-width: 260px;
    margin: 0 0 14px 20px;
    border: 1px solid #ddd;
    border-radius: 3px;
}
.bp-featured-img img {
    display: block;
    width: 100%;
    height: auto;
}

.bp-content {
    font-size: 13px;
    line-height: 1.8;
    color: #333;
}
.bp-content strong,
.bp-content b {
    font-weight: 700 !important;
    color: inherit;
}
.bp-content em, .bp-content i { font-style: italic; }
.bp-content p { margin: 0 0 12px; }
.bp-content h2, .bp-content h3, .bp-content h4 {
    color: #1a1a1a;
    font-weight: 700;
    margin: 20px 0 8px;
}
.bp-content h2 { font-size: 17px; }
.bp-content h3 { font-size: 15px; }
.bp-content img { max-width: 100%; height: auto; margin: 8px 0; }
.bp-content a { color: #bd1a21; }
.bp-content a:hover { text-decoration: underline; }
.bp-content ul, .bp-content ol { padding-left: 22px; margin-bottom: 12px; }
.bp-content li { margin-bottom: 4px; }
.bp-content blockquote {
    border-left: 3px solid #bd1a21;
    margin: 16px 0;
    padding: 8px 14px;
    background: #fdf5f5;
    color: #555;
    font-style: italic;
}
.bp-content table { border-collapse: collapse; width: 100%; margin-bottom: 12px; font-size: 12px; }
.bp-content table td, .bp-content table th { border: 1px solid #e0e0e0; padding: 6px 9px; }
.bp-content table th { background: #f5f5f5; font-weight: 700; }
.bp-clear { clear: both; }

.bp-back {
    display: inline-block;
    margin-top: 20px;
    font-size: 12px;
    color: #bd1a21;
    font-weight: 700;
    text-decoration: none;
    border-bottom: 1px solid #bd1a21;
    padding-bottom: 1px;
}
.bp-back:hover { color: #9e1519; }

.bp-comments-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 22px 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.bp-comments-heading {
    font-size: 14px;
    font-weight: 700;
    color: #bd1a21;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 16px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
.bp-comment {
    border-bottom: 1px solid #f2f2f2;
    padding: 12px 0;
}
.bp-comment:last-of-type { border-bottom: none; }
.bp-comment-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
}
.bp-comment-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #bd1a21;
    color: #fff;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
}
.bp-comment-name { font-size: 12px; font-weight: 700; color: #333; }
.bp-comment-date { font-size: 11px; color: #bbb; margin-left: auto; }
.bp-comment-text { font-size: 12px; color: #555; line-height: 1.65; padding-left: 38px; }
.bp-no-comments { font-size: 12px; color: #aaa; font-style: italic; margin: 4px 0 16px; }

.bp-form-section { margin-top: 20px; border-top: 1px solid #eee; padding-top: 18px; }
.bp-form-section h4 {
    font-size: 12px;
    font-weight: 700;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 14px;
}
.bp-form-row { display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap; }
.bp-form-group { flex: 1; min-width: 160px; display: flex; flex-direction: column; gap: 3px; }
.bp-form-group label { font-size: 11px; font-weight: 600; color: #666; }
.bp-form-group label span { color: #bd1a21; }
.bp-form-group input, .bp-form-group textarea {
    padding: 6px 9px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 12px;
    font-family: inherit;
    background: #fff;
}
.bp-form-group input:focus, .bp-form-group textarea:focus {
    outline: none;
    border-color: #bd1a21;
}
.bp-form-group small { font-size: 10px; color: #bbb; }
.bp-submit-btn {
    background: #bd1a21;
    color: #fff;
    border: none;
    padding: 8px 22px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: .5px;
    text-transform: uppercase;
    border-radius: 3px;
}
.bp-submit-btn:hover { background: #9e1519; }
.bp-alert-ok {
    background: #d4edda; border: 1px solid #28a745; color: #155724;
    padding: 8px 12px; font-size: 12px; border-radius: 3px; margin-bottom: 12px;
}
.bp-alert-err {
    background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;
    padding: 8px 12px; font-size: 12px; border-radius: 3px; margin-bottom: 12px;
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

                    {* ── Post card ────────────────────────────────── *}
                    <div class="bp-card">

                        <h1 class="bp-title">{$post.title|escape}</h1>
                        <div class="bp-meta">{$post.post_date|date_format:"%B %d, %Y"}</div>

                        <div class="bp-content">
                            {* Featured image floated right inside content, not a full-width hero *}
                            {if $post.featured_image != ""}
                            <div class="bp-featured-img">
                                {if $post.featured_image|substr:0:4 == 'http'}
                                    <img src="{$post.featured_image}" alt="{$post.title|escape}">
                                {else}
                                    <img src="{$smarty.const.BLOG_IMAGE_BASE_URL}{$post.featured_image}" alt="{$post.title|escape}">
                                {/if}
                            </div>
                            {/if}

                            {$post.content nofilter}

                            <div class="bp-clear"></div>
                        </div>

                        <a href="/blog" class="bp-back">&laquo; Back to Articles</a>
                    </div>

                    {* ── Comments card ────────────────────────────── *}
                    <div class="bp-comments-card">

                        <div class="bp-comments-heading">
                            Comments{if $comments} ({$comments|@count}){/if}
                        </div>

                        {if $comment_ok != ""}<div class="bp-alert-ok">{$comment_ok}</div>{/if}
                        {if $comment_err != ""}<div class="bp-alert-err">{$comment_err}</div>{/if}

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

                        <div class="bp-form-section">
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
                                <div class="bp-form-group" style="margin-bottom:12px;">
                                    <label><span>*</span> Comment</label>
                                    <textarea name="comment_text" rows="5" placeholder="Share your thoughts…" required></textarea>
                                </div>
                                <button type="submit" class="bp-submit-btn">Post Comment</button>
                            </form>
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

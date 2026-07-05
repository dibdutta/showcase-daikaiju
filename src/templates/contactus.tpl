{include file="header.tpl"}

<style>
/* ── Page shell ─────────────────────────────────────────── */
.cu-page { padding: 24px 0 48px; }

/* ── Hero header ────────────────────────────────────────── */
.cu-hero {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    border-radius: 6px 6px 0 0;
    padding: 22px 28px 18px;
    display: flex; align-items: center; gap: 14px;
}
.cu-hero svg { fill: rgba(255,255,255,0.85); width: 26px; height: 26px; flex-shrink: 0; }
.cu-hero h1 {
    margin: 0; font-size: 17px; font-weight: 700;
    color: #fff; letter-spacing: .3px;
}

/* ── Card ───────────────────────────────────────────────── */
.cu-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 20px;
}

/* ── CMS content block ──────────────────────────────────── */
.cu-cms-body { padding: 22px 28px; }
.cu-cms-body h1 {
    color: #bd1a21; font-size: 15px; font-weight: 700;
    margin: 24px 0 10px; padding: 0 0 8px;
    border-bottom: 2px solid #f0f0f0;
}
.cu-cms-body h1:first-child { margin-top: 0; }
.cu-cms-body h2 { color: #333; font-size: 13px; font-weight: 700; margin: 16px 0 8px; }
.cu-cms-body p  { font-size: 12px; color: #444; line-height: 1.75; margin: 0 0 10px; }
.cu-cms-body ul, .cu-cms-body ol { margin: 0 0 12px; padding-left: 20px; }
.cu-cms-body li { font-size: 12px; color: #444; line-height: 1.75; margin-bottom: 4px; }
.cu-cms-body a  { color: #bd1a21; text-decoration: none; }
.cu-cms-body a:hover { text-decoration: underline; }
.cu-cms-body strong { color: #222; }
.cu-cms-body hr { border: none; border-top: 1px solid #f0f0f0; margin: 18px 0; }

/* ── Form section header ────────────────────────────────── */
.cu-form-head {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 28px; border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
}
.cu-form-head svg { fill: #bd1a21; width: 16px; height: 16px; flex-shrink: 0; }
.cu-form-head span { font-size: 12px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: .5px; }

/* ── Contact form ───────────────────────────────────────── */
.cu-form-body { padding: 22px 28px 26px; }

.cu-alert-ok  { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px; padding: 10px 14px; font-size: 12px; margin-bottom: 16px; }
.cu-alert-err { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px; padding: 10px 14px; font-size: 12px; margin-bottom: 16px; }

.cu-field { margin-bottom: 16px; }
.cu-field label {
    display: block; font-size: 11px; font-weight: 700;
    color: #555; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;
}
.cu-field label .req { color: #bd1a21; margin-left: 2px; }
.cu-input, .cu-textarea {
    width: 100%; box-sizing: border-box;
    border: 1px solid #d0d0d0; border-radius: 4px;
    padding: 9px 12px; font-size: 12px; color: #333;
    font-family: inherit; transition: border-color .15s, box-shadow .15s;
    outline: none; background: #fff;
}
.cu-input:focus, .cu-textarea:focus {
    border-color: #bd1a21;
    box-shadow: 0 0 0 3px rgba(189,26,33,0.08);
}
.cu-textarea { resize: vertical; min-height: 110px; }
.cu-field-err { font-size: 11px; color: #bd1a21; margin-top: 4px; }

.cu-form-row { display: flex; gap: 16px; }
.cu-form-row .cu-field { flex: 1; min-width: 0; }

.cu-actions { display: flex; gap: 10px; margin-top: 4px; }
.cu-btn-submit {
    background: linear-gradient(135deg, #bd1a21, #8b0000);
    color: #fff; border: none; border-radius: 4px;
    padding: 10px 24px; font-size: 12px; font-weight: 700;
    cursor: pointer; letter-spacing: .3px; transition: opacity .15s;
}
.cu-btn-submit:hover { opacity: .88; }
.cu-btn-reset {
    background: #fff; color: #666; border: 1px solid #ccc;
    border-radius: 4px; padding: 10px 18px; font-size: 12px;
    font-weight: 600; cursor: pointer; transition: background .15s;
}
.cu-btn-reset:hover { background: #f5f5f5; }

@media (max-width: 520px) {
    .cu-form-row { flex-direction: column; }
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

            <div class="innerpage-container-main cu-page">

                {* ── CMS content card ──────────────────── *}
                {if $pageContent != ''}
                <div class="cu-card">
                    <div class="cu-hero">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <h1>{if $pageHeaderName != ''}{$pageHeaderName}{else}Contact Us{/if}</h1>
                    </div>
                    <div class="cu-cms-body">
                        {$pageContent nofilter}
                    </div>
                </div>
                {/if}

                {* ── Contact form card ─────────────────── *}
                <div class="cu-card">
                    {if $pageContent == ''}
                    <div class="cu-hero">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <h1>{if $pageHeaderName != ''}{$pageHeaderName}{else}Contact Us{/if}</h1>
                    </div>
                    {/if}
                    <div class="cu-form-head">
                        <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                        <span>Send us a message</span>
                    </div>
                    <div class="cu-form-body">

                        {if $errorMessage != ''}
                            {if $errorMessage == 'Thank You for Contacting with us. We will get back to you soon!'}
                                <div class="cu-alert-ok">{$errorMessage}</div>
                            {else}
                                <div class="cu-alert-err">{$errorMessage}</div>
                            {/if}
                        {/if}

                        <form name="frm_contact" id="frm_contact" action="" method="post">
                            <input type="hidden" name="mode" value="insert_contact">

                            <div class="cu-form-row">
                                <div class="cu-field">
                                    <label>Name <span class="req">*</span></label>
                                    <input type="text" name="firstname" id="firstname"
                                           value="{$profile[0].firstname}"
                                           class="cu-input" placeholder="Your full name">
                                    {if $firstname_err != ''}<div class="cu-field-err">{$firstname_err}</div>{/if}
                                </div>
                                <div class="cu-field">
                                    <label>Email Address <span class="req">*</span></label>
                                    <input type="email" name="email"
                                           value="{$profile[0].email}"
                                           class="cu-input" placeholder="you@example.com">
                                    {if $email_err != ''}<div class="cu-field-err">{$email_err}</div>{/if}
                                </div>
                            </div>

                            <div class="cu-field">
                                <label>Message <span class="req">*</span></label>
                                <textarea name="comments" class="cu-textarea"
                                          placeholder="How can we help you?"></textarea>
                            </div>

                            <div class="cu-actions">
                                <button type="submit" class="cu-btn-submit">Send Message</button>
                                <button type="reset"  class="cu-btn-reset">Clear</button>
                            </div>
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

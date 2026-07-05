{include file="header.tpl"}

<style>
/* ── Page shell ─────────────────────────────────────────── */
.policy-page { padding: 24px 0 48px; }

/* ── Hero header ────────────────────────────────────────── */
.policy-hero {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    border-radius: 6px 6px 0 0;
    padding: 22px 28px 18px;
    display: flex; align-items: center; gap: 14px;
}
.policy-hero svg { fill: rgba(255,255,255,0.85); width: 26px; height: 26px; flex-shrink: 0; }
.policy-hero h1 {
    margin: 0; font-size: 17px; font-weight: 700;
    color: #fff; letter-spacing: .3px;
}

/* ── Card ───────────────────────────────────────────────── */
.policy-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 24px;
}
.policy-body { padding: 24px 28px 28px; }

/* ── CMS content styles ─────────────────────────────────── */
.policy-body h1 {
    color: #bd1a21;
    font-size: 15px;
    font-weight: 700;
    margin: 28px 0 10px;
    padding: 0 0 8px;
    border-bottom: 2px solid #f0f0f0;
    letter-spacing: .2px;
}
.policy-body h1:first-child { margin-top: 0; }

.policy-body h2 {
    color: #333;
    font-size: 13px;
    font-weight: 700;
    margin: 18px 0 8px;
}

.policy-body h3 {
    color: #555;
    font-size: 12px;
    font-weight: 700;
    margin: 14px 0 6px;
}

.policy-body p {
    font-size: 12px;
    color: #444;
    line-height: 1.75;
    margin: 0 0 10px;
}
.policy-body p:last-child { margin-bottom: 0; }

.policy-body ul, .policy-body ol {
    margin: 0 0 12px 0;
    padding-left: 20px;
}
.policy-body li {
    font-size: 12px;
    color: #444;
    line-height: 1.75;
    margin-bottom: 5px;
}

.policy-body a { color: #bd1a21; text-decoration: none; }
.policy-body a:hover { text-decoration: underline; }

.policy-body strong { color: #222; }

.policy-body blockquote {
    border-left: 3px solid #bd1a21;
    margin: 0 0 16px 0;
    padding: 10px 16px;
    background: #fdf5f5;
    border-radius: 0 4px 4px 0;
}
.policy-body blockquote p { color: #555; }

.policy-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    margin: 14px 0 18px;
}
.policy-body table th,
.policy-body table td {
    padding: 8px 12px;
    border: 1px solid #e0e0e0;
    vertical-align: top;
    color: #333;
    line-height: 1.55;
}
.policy-body table th {
    background: #4a4a4a;
    color: #fff;
    font-weight: 700;
}
.policy-body table tr:nth-child(even) td { background: #fafafa; }

.policy-body hr {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 20px 0;
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

            <div class="innerpage-container-main policy-page">

                <div class="policy-card">

                    <div class="policy-hero">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        <h1>{if $pageHeaderName != ''}{$pageHeaderName}{else}User Agreement{/if}</h1>
                    </div>

                    <div class="policy-body">
                        {$pageContent nofilter}
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

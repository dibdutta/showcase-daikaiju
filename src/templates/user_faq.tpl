{include file="header.tpl"}

<style>
/* ── Page shell ─────────────────────────────────────────── */
.faq-page { padding: 24px 0 48px; }

/* ── Hero header ────────────────────────────────────────── */
.faq-hero {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    border-radius: 6px 6px 0 0;
    padding: 22px 28px 18px;
    display: flex; align-items: center; gap: 14px;
}
.faq-hero svg { fill: rgba(255,255,255,0.85); width: 26px; height: 26px; flex-shrink: 0; }
.faq-hero h1 {
    margin: 0; font-size: 17px; font-weight: 700;
    color: #fff; letter-spacing: .3px;
}

/* ── Card ───────────────────────────────────────────────── */
.faq-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 24px;
}
.faq-body { padding: 24px 28px 28px; }

/* ── CMS content styles ─────────────────────────────────── */
.faq-body h1 {
    color: #bd1a21;
    font-size: 15px;
    font-weight: 700;
    margin: 28px 0 10px;
    padding: 0 0 8px;
    border-bottom: 2px solid #f0f0f0;
    letter-spacing: .2px;
}
.faq-body h1:first-child { margin-top: 0; }

.faq-body h2 {
    color: #333;
    font-size: 13px;
    font-weight: 700;
    margin: 18px 0 8px;
}

.faq-body p {
    font-size: 12px;
    color: #444;
    line-height: 1.7;
    margin: 0 0 10px;
}
.faq-body p:last-child { margin-bottom: 0; }

.faq-body ul, .faq-body ol {
    margin: 0 0 12px 0;
    padding-left: 20px;
}
.faq-body li {
    font-size: 12px;
    color: #444;
    line-height: 1.7;
    margin-bottom: 4px;
}
.faq-body li a { color: #bd1a21; text-decoration: none; }
.faq-body li a:hover { text-decoration: underline; }

.faq-body a {
    color: #bd1a21;
    text-decoration: none;
}
.faq-body a:hover { text-decoration: underline; }

/* ── Grading / data tables ──────────────────────────────── */
.faq-body table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    margin: 14px 0 18px;
}
.faq-body table th,
.faq-body table td {
    padding: 8px 12px;
    border: 1px solid #e0e0e0;
    vertical-align: top;
    color: #333;
    line-height: 1.55;
}
.faq-body table td[bgcolor="#666666"],
.faq-body table th {
    background: #4a4a4a !important;
    color: #fff !important;
    font-weight: 700;
}
.faq-body table tr:nth-child(even) td { background: #fafafa; }
.faq-body table td[bgcolor="#f3f3f3"] { background: #f7f7f7 !important; }

.faq-body blockquote {
    border-left: 3px solid #bd1a21;
    margin: 0 0 16px 0;
    padding: 10px 16px;
    background: #fdf5f5;
    border-radius: 0 4px 4px 0;
}
.faq-body blockquote p { color: #555; }

/* ── Top-anchor link ────────────────────────────────────── */
.faq-body a.top {
    display: inline-block;
    color: #bd1a21;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    background: #fdf5f5;
    border: 1px solid #f0d0d0;
    border-radius: 3px;
    text-decoration: none;
}
.faq-body a.top:hover { background: #f9e0e0; }

.faq-body hr {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 20px 0;
}
</style>

<div id="forinnerpage-container">
    <div id="wrapper">
        <div id="headerthemepanel"></div>
        <div id="inner-container2">
        <div id="center"><div id="squeeze"><div class="right-corner">
        <div id="inner-left-container">

            <div class="innerpage-container-main faq-page">

                <div class="faq-card">

                    <div class="faq-hero">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
                        <h1>{if $pageHeaderName != ''}{$pageHeaderName}{else}FAQ{/if}</h1>
                    </div>

                    <div class="faq-body">
                        {$pageContent|nofilter}
                    </div>

                </div>

            </div>
        </div>
        </div></div></div>
        </div>
    </div>
</div>

{include file="foot.tpl"}

<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page Not Found &mdash; KaijuLink</title>
<meta name="robots" content="noindex, nofollow">
<link rel="shortcut icon" href="https://img1.wsimg.com/isteam/ip/92d26c02-334b-45d8-a4c8-8d3a1ef3f97b/favicon/111624e5-c88b-4ca0-8e89-53a48821379c.jpg/:/rs=w:24,h:24,m">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f4f4;
    color: #333;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ── Top bar ────────────────────────────────────────────── */
.err-topbar {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    padding: 14px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.err-topbar a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: .5px;
}
.err-topbar a:hover { opacity: .85; }

/* ── Main card ──────────────────────────────────────────── */
.err-wrap {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
.err-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 48px 40px 40px;
    max-width: 520px;
    width: 100%;
    text-align: center;
}

/* ── 404 number ─────────────────────────────────────────── */
.err-code {
    font-size: 96px;
    font-weight: 800;
    color: #f0d0d0;
    line-height: 1;
    letter-spacing: -4px;
    margin-bottom: 4px;
    position: relative;
}
.err-code::after {
    content: '404';
    position: absolute;
    inset: 0;
    color: #bd1a21;
    opacity: .15;
    font-size: inherit;
}

/* ── Kaiju icon ─────────────────────────────────────────── */
.err-icon {
    font-size: 52px;
    margin: 8px 0 16px;
    display: block;
    line-height: 1;
}

.err-title {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 12px;
}
.err-desc {
    font-size: 13px;
    color: #777;
    line-height: 1.7;
    margin-bottom: 28px;
}
.err-desc strong { color: #bd1a21; }

/* ── Divider ────────────────────────────────────────────── */
.err-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 0 0 24px;
}

/* ── Nav links ──────────────────────────────────────────── */
.err-nav {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.err-btn-primary {
    display: block;
    background: linear-gradient(135deg, #bd1a21, #8b0000);
    color: #fff;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 700;
    transition: opacity .15s;
}
.err-btn-primary:hover { opacity: .88; }

.err-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}
.err-link {
    display: inline-block;
    padding: 10px 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 12px;
    color: #555;
    text-decoration: none;
    font-weight: 600;
    background: #fafafa;
    transition: background .15s, color .15s;
    flex: 1;
    min-width: 120px;
}
.err-link:hover { background: #f0f0f0; color: #333; }

/* ── Footer ─────────────────────────────────────────────── */
.err-footer {
    text-align: center;
    padding: 16px;
    font-size: 11px;
    color: #bbb;
    border-top: 1px solid #e8e8e8;
    background: #fff;
}

@media (max-width: 480px) {
    .err-card { padding: 36px 20px 28px; }
    .err-code  { font-size: 72px; }
}
</style>
</head>
<body>

<div class="err-topbar">
    <a href="https://www.kaijulink.com/">&#127922; KaijuLink</a>
</div>

<div class="err-wrap">
    <div class="err-card">

        <div class="err-code">404</div>
        <span class="err-icon">&#129425;</span>

        <h1 class="err-title">This page has escaped into the wild</h1>
        <p class="err-desc">
            The page you're looking for doesn't exist, was moved, or the URL may be mistyped.<br>
            Try browsing our collection of <strong>rare Godzilla &amp; kaiju collectibles</strong> instead.
        </p>

        <hr class="err-divider">

        <nav class="err-nav">
            <a href="https://www.kaijulink.com/" class="err-btn-primary">&#127968; Go to Homepage</a>
            <div class="err-links">
                <a href="https://www.kaijulink.com/buy?list=fixed"  class="err-link">&#127914; Browse Kaiju Memorabilia</a>
                <a href="https://www.kaijulink.com/buy?list=weekly" class="err-link">&#128197; Weekly Auction</a>
                <a href="https://www.kaijulink.com/contactus"       class="err-link">&#9993; Contact Us</a>
            </div>
        </nav>

    </div>
</div>

<footer class="err-footer">
    &copy; <?php echo date('Y'); ?> KaijuLink &mdash; Connecting collectors the world over.
</footer>

</body>
</html>

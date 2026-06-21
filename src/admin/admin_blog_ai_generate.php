<?php
define('PAGE_HEADER_TEXT', 'AI Blog Post Generator');
ob_start();
define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';
require_once INCLUDE_PATH . 'lib/BedrockRuntime.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

$mode = $_REQUEST['mode'] ?? '';
if ($mode === 'find_items') {
    ajax_find_items();
} elseif ($mode === 'generate') {
    ajax_generate();
} else {
    show_page();
}
ob_end_flush();

// ── Fetch items matching keywords from both fixed and live tables ────────────

function fetch_items(array $keywords): array
{
    $db    = $GLOBALS['db_connect'];
    $items = [];

    if (empty($keywords)) return $items;

    $parts = [];
    foreach ($keywords as $kw) {
        $kw      = mysqli_real_escape_string($db, $kw);
        $parts[] = "p.poster_title LIKE '%{$kw}%'";
        $parts[] = "p.poster_desc  LIKE '%{$kw}%'";
    }
    $where = implode(' OR ', $parts);

    // All items from tbl_auction (active, sold, relisted) — blog content can reference any item
    $r = mysqli_query($db,
        "SELECT a.auction_id, p.poster_title, p.poster_desc, a.auction_asked_price, pi.poster_thumb,
                a.auction_is_sold
         FROM tbl_auction a
         JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
         LEFT JOIN tbl_poster_images pi ON p.poster_id = pi.fk_poster_id AND pi.is_default = '1'
         WHERE ($where)
           AND a.auction_is_approved = '1'
         ORDER BY a.auction_is_sold ASC, a.auction_id DESC LIMIT 15"
    );
    while ($r && $row = mysqli_fetch_assoc($r)) {
        $row['poster_url'] = PAGE_LINK . '/poster/' . (int)$row['auction_id'] . '/' . generatePosterSlug($row['poster_title']);
        $row['image_url']  = CLOUD_POSTER_THUMB_BUY . $row['poster_thumb'];
        $row['type']       = $row['auction_is_sold'] == '0' ? 'Fixed Price' : 'Sold';
        $items[]           = $row;
    }

    // Live auctions (active and recently closed)
    $r = mysqli_query($db,
        "SELECT a.auction_id, p.poster_title, p.poster_desc, a.auction_asked_price, pi.poster_thumb,
                a.auction_is_sold
         FROM tbl_auction_live a
         JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
         LEFT JOIN tbl_poster_images_live pi ON p.poster_id = pi.fk_poster_id AND pi.is_default = '1'
         WHERE ($where)
           AND a.auction_is_approved = '1'
         ORDER BY a.auction_is_sold ASC, a.auction_id DESC LIMIT 15"
    );
    while ($r && $row = mysqli_fetch_assoc($r)) {
        $row['poster_url'] = PAGE_LINK . '/poster/' . (int)$row['auction_id'] . '/' . generatePosterSlug($row['poster_title']);
        $row['image_url']  = CLOUD_POSTER_THUMB_BUY . $row['poster_thumb'];
        $row['type']       = $row['auction_is_sold'] == '0' ? 'Live Auction' : 'Sold';
        $items[]           = $row;
    }

    return $items;
}

function build_prompt(string $topic, array $items): string
{
    $itemLines = '';
    foreach ($items as $i => $item) {
        $desc   = substr(strip_tags($item['poster_desc'] ?? ''), 0, 200);
        $price  = number_format((float)($item['auction_asked_price'] ?? 0), 2);
        $n      = $i + 1;
        $itemLines .= "{$n}. {$item['poster_title']}\n";
        $itemLines .= "   Price: \${$price} ({$item['type']})\n";
        if ($desc) $itemLines .= "   Description: {$desc}\n";
        $itemLines .= "   Shop URL: {$item['poster_url']}\n";
        $itemLines .= "   Image URL: {$item['image_url']}\n\n";
    }

    return <<<PROMPT
You are writing a blog post for KaijuLink.com, a premier online marketplace for kaiju collectibles, sofubi vinyl figures, and vintage Godzilla/Toho memorabilia. Your audience is serious collectors who know the hobby deeply.

Blog post topic: {$topic}

Items currently available in our shop relevant to this topic:

{$itemLines}

Write an engaging, informative HTML blog post following these rules exactly:
1. 700–950 words of prose (not counting HTML tags)
2. Use ONLY these tags: <h2> <h3> <p> <ul> <li> <strong> <em> <a> <img>
3. Do NOT output <html> <head> <body> <style> <script> or doctype — body content only
4. Reference shop items naturally within paragraphs — do not dump them all at the end
5. For each item image you embed, use exactly this HTML (no changes to the style):
   <a href="SHOP_URL"><img src="IMAGE_URL" alt="ITEM_TITLE" style="float:right;margin:0 0 16px 20px;width:140px;height:140px;object-fit:contain;border:1px solid #ddd;background:#fafafa;" loading="lazy"></a>
6. Place each item image immediately before the paragraph that discusses that item
7. Write with authority — speak to collectors, not beginners. Use hobby-specific terminology.
8. Do NOT invent specifications, production years, or edition details not given above
9. Write editorial content, not a sales pitch
10. End with a short paragraph linking to the shop. Use this exact URL for that link: PAGE_LINK/buy?list=fixed
11. Open with an <h2> that is a compelling hook — NOT a repeat of the topic title

Output the HTML content only. No preamble, no explanation, no markdown code fences.
PROMPT;
}

function build_slug(string $title): string
{
    $s = strtolower($title);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return substr(trim($s, '-'), 0, 80);
}

// ── AJAX: preview matching items ─────────────────────────────────────────────

function ajax_find_items(): void
{
    ob_clean();
    header('Content-Type: application/json');

    $keywords = array_filter(array_map('trim', explode(',', $_POST['keywords'] ?? '')));
    if (empty($keywords)) {
        echo json_encode(['error' => 'Enter at least one keyword']);
        exit;
    }

    $items = fetch_items($keywords);
    echo json_encode(['items' => $items, 'count' => count($items)]);
    exit;
}

// ── AJAX: generate draft blog post ───────────────────────────────────────────

function ajax_generate(): void
{
    ob_clean();
    header('Content-Type: application/json');

    $topic    = trim($_POST['topic']    ?? '');
    $keywords = array_filter(array_map('trim', explode(',', $_POST['keywords'] ?? '')));

    if (!$topic)        { echo json_encode(['error' => 'Topic is required']);    exit; }
    if (empty($keywords)) { echo json_encode(['error' => 'Keywords are required']); exit; }

    $items = fetch_items($keywords);

    $bedrock = new BedrockRuntime();
    $prompt  = build_prompt($topic, $items);
    $result  = $bedrock->invoke($prompt);

    if (!empty($result['error'])) {
        echo json_encode(['error' => $result['error']]);
        exit;
    }

    $content = str_replace('PAGE_LINK', PAGE_LINK, $result['content']);

    // Save as draft (status = 0)
    $db   = $GLOBALS['db_connect'];
    $slug = build_slug($topic);
    $base = $slug;
    $n    = 1;
    while (true) {
        $s   = mysqli_real_escape_string($db, $slug);
        $chk = mysqli_query($db, "SELECT blog_id FROM tbl_blog WHERE slug = '$s' LIMIT 1");
        if (!$chk || mysqli_num_rows($chk) === 0) break;
        $slug = $base . '-' . (++$n);
    }

    $featImg = $items[0]['image_url'] ?? '';
    $ip      = $_SERVER['REMOTE_ADDR'] ?? '';

    mysqli_query($db,
        "INSERT INTO tbl_blog (title, slug, content, featured_image, status, post_date, post_ip)
         VALUES (
           '" . mysqli_real_escape_string($db, $topic)    . "',
           '" . mysqli_real_escape_string($db, $slug)     . "',
           '" . mysqli_real_escape_string($db, $content)  . "',
           '" . mysqli_real_escape_string($db, $featImg)  . "',
           0,
           NOW(),
           '" . mysqli_real_escape_string($db, $ip)       . "'
         )"
    );
    $blogId = (int)mysqli_insert_id($db);

    echo json_encode([
        'success'    => true,
        'blog_id'    => $blogId,
        'slug'       => $slug,
        'edit_url'   => 'admin_blog_manager.php?mode=edit&blog_id=' . $blogId,
        'item_count' => count($items),
    ]);
    exit;
}

// ── Main page ─────────────────────────────────────────────────────────────────

function show_page(): void
{
    // Quick credential check
    $bedrock    = new BedrockRuntime();
    $hasCredentials = true; // BedrockRuntime resolves silently; we'll surface errors on generate

    $suggestions = [
        ['topic' => 'Marmit Sofubi Figures: The Complete Collector\'s Guide',         'keywords' => 'marmit'],
        ['topic' => 'Matango Attack of the Mushroom People: Rarest Kaiju Collectibles', 'keywords' => 'matango'],
        ['topic' => 'X-Plus Godzilla Figures: What Every Fan Should Know',             'keywords' => 'x-plus,x plus'],
        ['topic' => 'King Ghidorah Collectibles: Rarest Finds for Serious Fans',       'keywords' => 'king ghidorah,ghidorah'],
        ['topic' => 'Hedorah (The Smog Monster) Rare Collectibles Guide',              'keywords' => 'hedorah'],
        ['topic' => 'Bullmark vs Marusan: Vintage Kaiju Vinyl History',                'keywords' => 'bullmark,marusan'],
        ['topic' => 'M1go Designer Sofubi Figures: A Collector\'s Guide',              'keywords' => 'm1go,m1'],
        ['topic' => 'How to Buy Authentic Toho Movie Posters',                        'keywords' => 'toho,godzilla'],
    ];

    $suggestionsJson = htmlspecialchars(json_encode($suggestions), ENT_QUOTES);
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>AI Blog Generator | Admin</title>
<style>
body { font-family: Arial, sans-serif; font-size: 13px; background: #f4f4f4; margin: 0; padding: 20px; color: #333; }
h1 { font-size: 18px; margin: 0 0 20px; color: #333; border-bottom: 2px solid #bd1a21; padding-bottom: 8px; }
h2 { font-size: 14px; margin: 0 0 12px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; }
.card { background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 20px; margin-bottom: 20px; }
label { font-weight: bold; font-size: 12px; display: block; margin-bottom: 4px; color: #444; }
input[type=text], textarea {
    width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px;
    padding: 8px 10px; font-size: 13px; font-family: Arial, sans-serif;
}
textarea { resize: vertical; }
.btn {
    display: inline-block; padding: 9px 22px; border: none; border-radius: 3px;
    font-size: 13px; font-weight: bold; cursor: pointer; letter-spacing: 0.3px;
}
.btn-primary { background: #bd1a21; color: #fff; }
.btn-primary:hover { background: #9e1519; }
.btn-secondary { background: #555; color: #fff; margin-left: 8px; }
.btn-secondary:hover { background: #333; }
.btn-green { background: #28a745; color: #fff; }
.btn-green:hover { background: #218838; }
.suggestions { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
.sug-chip {
    background: #f0f0f0; border: 1px solid #ccc; border-radius: 20px;
    padding: 5px 14px; font-size: 12px; cursor: pointer; transition: background 0.15s;
}
.sug-chip:hover { background: #bd1a21; color: #fff; border-color: #bd1a21; }
.item-grid { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px; }
.item-card {
    width: 130px; text-align: center; background: #fafafa;
    border: 1px solid #e0e0e0; border-radius: 4px; padding: 8px;
}
.item-card img { width: 110px; height: 110px; object-fit: contain; background: #fff; border: 1px solid #eee; }
.item-card .item-title { font-size: 10px; color: #444; margin-top: 5px; line-height: 1.3; }
.item-card .item-price { font-size: 11px; color: #bd1a21; font-weight: bold; margin-top: 3px; }
.item-card .item-type  { font-size: 10px; color: #888; }
.status { padding: 10px 14px; border-radius: 3px; margin-top: 12px; font-size: 13px; }
.status-info    { background: #e8f4fd; border: 1px solid #b8daff; color: #0c5460; }
.status-success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
.status-error   { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
.spinner { display: inline-block; width: 14px; height: 14px; border: 2px solid #ccc; border-top-color: #bd1a21; border-radius: 50%; animation: spin 0.7s linear infinite; vertical-align: middle; margin-right: 6px; }
@keyframes spin { to { transform: rotate(360deg); } }
.back-link { font-size: 12px; color: #bd1a21; text-decoration: none; display: inline-block; margin-bottom: 16px; }
.back-link:hover { text-decoration: underline; }
.model-note { font-size: 11px; color: #888; margin-top: 6px; }
</style>
</head>
<body>

<a href="admin_blog_manager.php" class="back-link">&laquo; Back to Blog Manager</a>
<h1>AI Blog Post Generator</h1>

<div class="card">
    <h2>1. Choose a Topic</h2>
    <p style="font-size:12px;color:#666;margin:0 0 10px;">Click a suggestion to auto-fill, or type your own topic and keywords.</p>
    <div class="suggestions" id="suggestions"></div>

    <div style="margin-top:14px;">
        <label for="topic">Blog Post Title / Topic</label>
        <input type="text" id="topic" placeholder="e.g. Marmit Sofubi Figures: The Complete Collector's Guide" style="width:100%;">
    </div>
    <div style="margin-top:12px;">
        <label for="keywords">Search Keywords <span style="font-weight:normal;color:#888;">(comma-separated — used to find relevant items in the shop)</span></label>
        <input type="text" id="keywords" placeholder="e.g. marmit, sofubi">
    </div>
</div>

<div class="card">
    <h2>2. Preview Matching Items</h2>
    <p style="font-size:12px;color:#666;margin:0 0 10px;">The AI will reference these items and embed their images in the blog post.</p>
    <button class="btn btn-secondary" onclick="findItems()">Find Matching Items</button>
    <div id="items-status"></div>
    <div class="item-grid" id="item-grid"></div>
</div>

<div class="card">
    <h2>3. Generate Draft Blog Post</h2>
    <p style="font-size:12px;color:#666;margin:0 0 10px;">
        The AI will write a 700–950 word post embedding actual product images from your shop.
        The post will be saved as a <strong>draft</strong> — you review and publish from the Blog Manager.
    </p>
    <p class="model-note">Model: Claude 3.5 Haiku on AWS Bedrock (us-east-1) &mdash; ~$0.007 per post</p>
    <button class="btn btn-primary" onclick="generate()" id="gen-btn">Generate Draft Post</button>
    <div id="gen-status"></div>
</div>

<script>
var suggestions = <?= $suggestionsJson ?>;

// Render suggestion chips
var sEl = document.getElementById('suggestions');
suggestions.forEach(function(s) {
    var chip = document.createElement('span');
    chip.className = 'sug-chip';
    chip.textContent = s.topic;
    chip.onclick = function() {
        document.getElementById('topic').value    = s.topic;
        document.getElementById('keywords').value = s.keywords;
    };
    sEl.appendChild(chip);
});

function findItems() {
    var keywords = document.getElementById('keywords').value.trim();
    if (!keywords) { alert('Enter keywords first'); return; }

    setStatus('items-status', '<span class="spinner"></span>Searching shop items…', 'info');
    document.getElementById('item-grid').innerHTML = '';

    fetch('admin_blog_ai_generate.php?mode=find_items', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'keywords=' + encodeURIComponent(keywords)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.error) { setStatus('items-status', '&#x26A0; ' + data.error, 'error'); return; }
        setStatus('items-status', '&#10003; Found ' + data.count + ' matching item(s).', 'success');
        renderItems(data.items);
    })
    .catch(function(e) { setStatus('items-status', 'Request failed: ' + e.message, 'error'); });
}

function renderItems(items) {
    var grid = document.getElementById('item-grid');
    grid.innerHTML = '';
    items.forEach(function(item) {
        var price = parseFloat(item.auction_asked_price || 0).toFixed(2);
        var div = document.createElement('div');
        div.className = 'item-card';
        div.innerHTML =
            '<img src="' + item.image_url + '" onerror="this.src=\'https://via.placeholder.com/110x110?text=No+Image\'">' +
            '<div class="item-title">' + item.poster_title + '</div>' +
            '<div class="item-price">$' + price + '</div>' +
            '<div class="item-type">' + item.type + '</div>';
        grid.appendChild(div);
    });
}

function generate() {
    var topic    = document.getElementById('topic').value.trim();
    var keywords = document.getElementById('keywords').value.trim();
    if (!topic)    { alert('Enter a topic first');    return; }
    if (!keywords) { alert('Enter keywords first');   return; }

    var btn = document.getElementById('gen-btn');
    btn.disabled = true;
    setStatus('gen-status', '<span class="spinner"></span>Generating blog post via AWS Bedrock… this may take 15–30 seconds.', 'info');

    fetch('admin_blog_ai_generate.php?mode=generate', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'topic=' + encodeURIComponent(topic) + '&keywords=' + encodeURIComponent(keywords)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        btn.disabled = false;
        if (data.error) { setStatus('gen-status', '&#x26A0; ' + data.error, 'error'); return; }
        setStatus('gen-status',
            '&#10003; Draft saved! Used ' + data.item_count + ' shop item(s). ' +
            '<a href="' + data.edit_url + '" style="color:#155724;font-weight:bold;">Review &amp; Edit Draft &rarr;</a>',
            'success'
        );
    })
    .catch(function(e) { btn.disabled = false; setStatus('gen-status', 'Request failed: ' + e.message, 'error'); });
}

function setStatus(id, msg, type) {
    var el = document.getElementById(id);
    el.className = 'status status-' + type;
    el.innerHTML = msg;
}
</script>

</body>
</html>
<?php
}

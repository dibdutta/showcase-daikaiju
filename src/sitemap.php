<?php
define("INCLUDE_PATH", "./");
require_once INCLUDE_PATH . "lib/configures.php";

$db   = $GLOBALS['db_connect'];
$base = SITE_URL;

$urls = [];

// Static pages
$static = [
    ['loc' => $base . '/',               'changefreq' => 'daily',   'priority' => '1.0'],
    ['loc' => $base . '/buy?list=fixed', 'changefreq' => 'daily',   'priority' => '0.9'],
    ['loc' => $base . '/buy?list=weekly','changefreq' => 'daily',   'priority' => '0.9'],
    ['loc' => $base . '/sell',           'changefreq' => 'monthly', 'priority' => '0.6'],
    ['loc' => $base . '/faq',            'changefreq' => 'monthly', 'priority' => '0.5'],
    ['loc' => $base . '/contactus',      'changefreq' => 'monthly', 'priority' => '0.5'],
    ['loc' => $base . '/aboutus',        'changefreq' => 'monthly', 'priority' => '0.5'],
    ['loc' => $base . '/sold_item',      'changefreq' => 'daily',   'priority' => '0.6'],
    ['loc' => $base . '/blog',           'changefreq' => 'weekly',  'priority' => '0.7'],
];
foreach ($static as $s) {
    $urls[] = $s;
}

// Closed auctions from tbl_auction — fixed price (type 1) and completed live (type 2,3,4)
$r = mysqli_query($db,
    "SELECT a.auction_id, a.fk_auction_type_id, a.auction_actual_start_datetime
     FROM tbl_auction a
     WHERE a.auction_is_approved = '1'
       AND a.fk_auction_type_id = '1'
     ORDER BY a.auction_id DESC
     LIMIT 10000"
);
if ($r) {
    while ($row = mysqli_fetch_assoc($r)) {
        $lastmod = !empty($row['auction_actual_start_datetime'])
            ? date('Y-m-d', strtotime($row['auction_actual_start_datetime']))
            : date('Y-m-d');
        $urls[] = [
            'loc'        => $base . '/buy?mode=poster_details&auction_id=' . (int)$row['auction_id'] . '&fixed=1',
            'lastmod'    => $lastmod,
            'changefreq' => 'weekly',
            'priority'   => '0.8',
        ];
    }
}

// Completed live auctions (types 2,3,4) from tbl_auction — accessed with &sold=1
$r = mysqli_query($db,
    "SELECT a.auction_id, a.auction_actual_start_datetime
     FROM tbl_auction a
     WHERE a.auction_is_approved = '1'
       AND a.fk_auction_type_id IN ('2','3','4')
       AND a.auction_is_sold != '0'
     ORDER BY a.auction_id DESC
     LIMIT 10000"
);
if ($r) {
    while ($row = mysqli_fetch_assoc($r)) {
        $lastmod = !empty($row['auction_actual_start_datetime'])
            ? date('Y-m-d', strtotime($row['auction_actual_start_datetime']))
            : date('Y-m-d');
        $urls[] = [
            'loc'        => $base . '/buy?mode=poster_details&auction_id=' . (int)$row['auction_id'] . '&sold=1',
            'lastmod'    => $lastmod,
            'changefreq' => 'monthly',
            'priority'   => '0.6',
        ];
    }
}

// Currently live auctions from tbl_auction_live — highest priority, change daily
$r = mysqli_query($db,
    "SELECT a.auction_id, a.auction_actual_start_datetime
     FROM tbl_auction_live a
     WHERE a.auction_is_approved = '1'
       AND a.auction_is_sold = '0'
     ORDER BY a.auction_id DESC
     LIMIT 1000"
);
if ($r) {
    while ($row = mysqli_fetch_assoc($r)) {
        $lastmod = !empty($row['auction_actual_start_datetime'])
            ? date('Y-m-d', strtotime($row['auction_actual_start_datetime']))
            : date('Y-m-d');
        $urls[] = [
            'loc'        => $base . '/buy?mode=poster_details&auction_id=' . (int)$row['auction_id'],
            'lastmod'    => $lastmod,
            'changefreq' => 'daily',
            'priority'   => '0.9',
        ];
    }
}

// Published blog posts
$r = mysqli_query($db,
    "SELECT slug, post_date FROM tbl_blog WHERE status = 1 ORDER BY blog_id DESC LIMIT 1000"
);
if ($r) {
    while ($row = mysqli_fetch_assoc($r)) {
        $lastmod = !empty($row['post_date'])
            ? date('Y-m-d', strtotime($row['post_date']))
            : date('Y-m-d');
        $urls[] = [
            'loc'        => $base . '/blog?slug=' . urlencode($row['slug']),
            'lastmod'    => $lastmod,
            'changefreq' => 'monthly',
            'priority'   => '0.6',
        ];
    }
}

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
    if (!empty($u['lastmod'])) {
        echo "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
    }
    echo "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
    echo "    <priority>" . $u['priority'] . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";

<?php
/**
 * Generates sitemap XML and writes it to src/sitemap.xml.
 * Called by admin/admin_generate_sitemap.php or CLI.
 */
function _sitemap_slug($title) {
    if (function_exists('generatePosterSlug')) {
        return generatePosterSlug($title);
    }
    $slug = mb_strtolower($title ?? '', 'UTF-8');
    $slug = preg_replace('/[^\x00-\x7F]/u', '', $slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return substr($slug, 0, 60);
}

function generate_sitemap_xml($db, $base)
{
    $urls = [];

    // Static pages
    $static = [
        ['loc' => $base . '/',                'changefreq' => 'daily',   'priority' => '1.0'],
        ['loc' => $base . '/buy?list=fixed',  'changefreq' => 'daily',   'priority' => '0.9'],
        ['loc' => $base . '/buy?list=weekly', 'changefreq' => 'daily',   'priority' => '0.9'],
        ['loc' => $base . '/sell',            'changefreq' => 'monthly', 'priority' => '0.6'],
        ['loc' => $base . '/faq',             'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => $base . '/contactus',       'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => $base . '/aboutus',         'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => $base . '/sold_item',       'changefreq' => 'daily',   'priority' => '0.6'],
        ['loc' => $base . '/blog',            'changefreq' => 'weekly',  'priority' => '0.7'],
    ];
    foreach ($static as $s) {
        $urls[] = $s;
    }

    // Fixed-price listings from tbl_auction (type 1)
    $r = mysqli_query($db,
        "SELECT a.auction_id, a.auction_actual_start_datetime, p.poster_title
         FROM tbl_auction a
         LEFT JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
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
            $slug = _sitemap_slug($row['poster_title'] ?? '');
            $urls[] = [
                'loc'        => $base . '/poster/' . (int)$row['auction_id'] . '/' . $slug,
                'lastmod'    => $lastmod,
                'changefreq' => 'weekly',
                'priority'   => '0.8',
            ];
        }
    }

    // Completed live auctions (types 2,3,4) from tbl_auction
    $r = mysqli_query($db,
        "SELECT a.auction_id, a.auction_actual_start_datetime, p.poster_title
         FROM tbl_auction a
         LEFT JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
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
            $slug = _sitemap_slug($row['poster_title'] ?? '');
            $urls[] = [
                'loc'        => $base . '/poster/' . (int)$row['auction_id'] . '/' . $slug,
                'lastmod'    => $lastmod,
                'changefreq' => 'monthly',
                'priority'   => '0.6',
            ];
        }
    }

    // Currently live auctions from tbl_auction_live
    $r = mysqli_query($db,
        "SELECT a.auction_id, a.auction_actual_start_datetime, p.poster_title
         FROM tbl_auction_live a
         LEFT JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
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
            $slug = _sitemap_slug($row['poster_title'] ?? '');
            $urls[] = [
                'loc'        => $base . '/poster/' . (int)$row['auction_id'] . '/' . $slug,
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

    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
        if (!empty($u['lastmod'])) {
            $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
        }
        $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
        $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>' . "\n";

    return ['xml' => $xml, 'count' => count($urls)];
}

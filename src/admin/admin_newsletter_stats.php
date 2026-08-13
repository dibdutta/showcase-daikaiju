<?php
/**
 * Newsletter Click Stats — read-only report over tbl_newsletter_click_log,
 * populated by nl_click.php as recipients click links in a manually-sent
 * newsletter (see admin_auction_newsletter.php).
 *
 * Access: /admin/admin_newsletter_stats.php  (requires admin session)
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('PAGE_HEADER_TEXT', 'Newsletter Click Stats');

ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

show_stats();

function get_campaigns($db) {
    $rs = mysqli_query($db, "SELECT campaign, COUNT(*) AS clicks, MAX(clicked_at) AS last_click
                              FROM tbl_newsletter_click_log
                              GROUP BY campaign
                              ORDER BY last_click DESC");
    $rows = [];
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function show_stats() {
    require_once INCLUDE_PATH . 'lib/adminCommon.php';
    $db = $GLOBALS['db_connect'];

    $campaigns = get_campaigns($db);
    $selected  = trim($_REQUEST['campaign'] ?? '');
    if ($selected === '' && !empty($campaigns)) {
        $selected = $campaigns[0]['campaign']; // most recently active campaign
    }
    $selectedSafe = mysqli_real_escape_string($db, $selected);
    $where = $selected !== '' ? "WHERE campaign = '$selectedSafe'" : '';

    // Summary
    $totalClicks = 0; $identifiedClicks = 0; $uniqueEmails = 0;
    $rs = mysqli_query($db, "SELECT COUNT(*) AS total,
                                     SUM(CASE WHEN email IS NOT NULL THEN 1 ELSE 0 END) AS identified,
                                     COUNT(DISTINCT email) AS unique_emails
                              FROM tbl_newsletter_click_log $where");
    if ($rs && ($row = mysqli_fetch_assoc($rs))) {
        $totalClicks = (int)$row['total'];
        $identifiedClicks = (int)$row['identified'];
        $uniqueEmails = (int)$row['unique_emails'];
    }

    // Per-item breakdown, joined back to the poster title where item_ref is a
    // real auction_id (falls back to '(item no longer live)' if it isn't found
    // in tbl_auction_live anymore, and labels the CTA button separately).
    $itemStats = [];
    $rs = mysqli_query($db, "SELECT item_ref, COUNT(*) AS clicks, COUNT(DISTINCT email) AS unique_emails
                              FROM tbl_newsletter_click_log $where
                              GROUP BY item_ref
                              ORDER BY clicks DESC");
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $itemStats[] = $row;
        }
    }
    // Look up poster titles for numeric item_refs in one batch query.
    $auctionIds = [];
    foreach ($itemStats as $row) {
        if (ctype_digit($row['item_ref'])) $auctionIds[] = (int)$row['item_ref'];
    }
    $titles = [];
    if (!empty($auctionIds)) {
        $rs = mysqli_query($db, "SELECT a.auction_id, p.poster_title
                                  FROM tbl_auction_live a
                                  INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
                                  WHERE a.auction_id IN (" . implode(',', $auctionIds) . ")");
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $titles[(int)$row['auction_id']] = $row['poster_title'];
            }
        }
    }
    foreach ($itemStats as &$row) {
        if ($row['item_ref'] === 'cta') {
            $row['label'] = 'See All Items button';
        } elseif (ctype_digit($row['item_ref']) && isset($titles[(int)$row['item_ref']])) {
            $row['label'] = $titles[(int)$row['item_ref']] . ' (#' . $row['item_ref'] . ')';
        } else {
            $row['label'] = 'Item #' . $row['item_ref'] . ' (no longer live)';
        }
    }
    unset($row);

    // Individually identified clicks (logged-in visitor at click time), most recent first.
    $identifiedLog = [];
    $rs = mysqli_query($db, "SELECT email, item_ref, clicked_at
                              FROM tbl_newsletter_click_log
                              $where " . ($where ? 'AND' : 'WHERE') . " email IS NOT NULL
                              ORDER BY clicked_at DESC
                              LIMIT 300");
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $row['label'] = $row['item_ref'] === 'cta' ? 'See All Items button'
                : (isset($titles[(int)$row['item_ref']]) ? $titles[(int)$row['item_ref']] . ' (#' . $row['item_ref'] . ')' : 'Item #' . $row['item_ref']);
            $identifiedLog[] = $row;
        }
    }

    $smarty->assign('campaigns', $campaigns);
    $smarty->assign('selected_campaign', $selected);
    $smarty->assign('total_clicks', $totalClicks);
    $smarty->assign('identified_clicks', $identifiedClicks);
    $smarty->assign('anonymous_clicks', $totalClicks - $identifiedClicks);
    $smarty->assign('unique_emails', $uniqueEmails);
    $smarty->assign('item_stats', $itemStats);
    $smarty->assign('identified_log', $identifiedLog);
    $smarty->display('admin_newsletter_stats.tpl');
}

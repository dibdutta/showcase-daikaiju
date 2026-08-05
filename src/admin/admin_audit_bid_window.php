<?php
/**
 * Bid Timing Audit — read-only diagnostic page.
 *
 * For every item currently in tbl_auction_live, looks up the auction week it
 * belongs to (tbl_auction_week) and reports any tbl_bid or tbl_proxy_bid_live
 * rows whose timestamp falls outside that week's start/end window — i.e. bids
 * placed before the auction opened or after it closed (bidding a live item
 * before/after its window shouldn't be possible through normal UI flow, so
 * any hits here point at a bug, a stale item stuck in tbl_auction_live past
 * its window, or a bid inserted some other way).
 *
 * No writes are performed anywhere in this file.
 *
 * Access: /admin/admin_audit_bid_window.php  (requires admin session)
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('PAGE_HEADER_TEXT', 'Bid Timing Audit');
ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

function run_bid_window_audit($db) {
    $out = [
        'error'        => null,
        'items_total'  => 0,
        'items_no_week'=> 0,
        'items_flagged'=> [],
        'bid_count'    => 0,
        'proxy_count'  => 0,
    ];

    $sql = "SELECT a.auction_id, a.fk_auction_week_id,
                   pl.poster_title, pl.poster_sku,
                   aw.auction_week_title, aw.auction_week_start_date, aw.auction_week_end_date
            FROM tbl_auction_live a
            LEFT JOIN tbl_poster_live pl ON a.fk_poster_id = pl.poster_id
            LEFT JOIN tbl_auction_week aw ON a.fk_auction_week_id = aw.auction_week_id
            ORDER BY a.auction_id";
    $rs = mysqli_query($db, $sql);
    if (!$rs) {
        $out['error'] = mysqli_error($db);
        return $out;
    }

    while ($row = mysqli_fetch_assoc($rs)) {
        $out['items_total']++;

        $start = $row['auction_week_start_date'];
        $end   = $row['auction_week_end_date'];
        if (empty($start) || empty($end)) {
            // Item has no auction week attached (or the week has no schedule) —
            // nothing to compare bid timestamps against, so skip it.
            $out['items_no_week']++;
            continue;
        }

        $auctionId  = (int)$row['auction_id'];
        $startSafe  = mysqli_real_escape_string($db, $start);
        $endSafe    = mysqli_real_escape_string($db, $end);

        $badBids = [];
        $bidRs = mysqli_query($db, "
            SELECT bid_id, bid_fk_user_id, bid_amount, is_proxy, post_date
            FROM tbl_bid
            WHERE bid_fk_auction_id = $auctionId
              AND (post_date < '$startSafe' OR post_date > '$endSafe')
            ORDER BY post_date");
        if ($bidRs) {
            while ($b = mysqli_fetch_assoc($bidRs)) {
                $badBids[] = $b;
            }
        }

        $badProxy = [];
        $proxyRs = mysqli_query($db, "
            SELECT proxy_id, fk_user_id, amount, is_override, proxy_date
            FROM tbl_proxy_bid_live
            WHERE fk_auction_id = $auctionId
              AND (proxy_date < '$startSafe' OR proxy_date > '$endSafe')
            ORDER BY proxy_date");
        if ($proxyRs) {
            while ($p = mysqli_fetch_assoc($proxyRs)) {
                $badProxy[] = $p;
            }
        }

        if ($badBids || $badProxy) {
            $out['items_flagged'][] = [
                'auction_id'   => $auctionId,
                'poster_title' => $row['poster_title'],
                'poster_sku'   => $row['poster_sku'],
                'week_id'      => $row['fk_auction_week_id'],
                'week_title'   => $row['auction_week_title'],
                'week_start'   => $start,
                'week_end'     => $end,
                'bad_bids'     => $badBids,
                'bad_proxy'    => $badProxy,
            ];
            $out['bid_count']   += count($badBids);
            $out['proxy_count'] += count($badProxy);
        }
    }

    return $out;
}

$result = run_bid_window_audit($GLOBALS['db_connect']);

require_once INCLUDE_PATH . 'lib/adminCommon.php';
ob_end_clean();
ob_start();
$smarty->display('admin_header.tpl');
echo ob_get_clean();
?>
<style>
.diag-section { background:#fff; border:1px solid #ddd; border-radius:5px; padding:18px 20px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.diag-section h3 { font-size:13px; font-weight:700; color:#0f3460; margin:0 0 12px; border-bottom:1px solid #eee; padding-bottom:8px; text-transform:uppercase; letter-spacing:.5px; }
.diag-kv { display:flex; gap:8px; font-size:12px; margin-bottom:6px; align-items:flex-start; }
.diag-kv dt { color:#777; width:160px; flex-shrink:0; }
.diag-kv dd { color:#222; font-family:monospace; margin:0; word-break:break-all; }
.diag-box-ok  { background:#d4edda; border:1px solid #28a745; color:#155724; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-box-err { background:#f8d7da; border:1px solid #dc3545; color:#721c24; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-box-warn{ background:#fff3cd; border:1px solid #ffc107; color:#664d03; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.audit-item-head { font-size:13px; font-weight:700; color:#0f3460; margin-bottom:4px; }
.audit-item-sub { font-size:11px; color:#777; margin-bottom:10px; }
.audit-table { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:14px; }
.audit-table th { background:#f5f5f5; text-align:left; padding:6px 8px; border-bottom:2px solid #ddd; }
.audit-table td { padding:5px 8px; border-bottom:1px solid #eee; }
.audit-table tr:last-child td { border-bottom:none; }
.audit-late { color:#dc3545; font-weight:700; }
.audit-early { color:#856404; font-weight:700; }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td align="center" class="bold_text" style="padding:10px 0 6px;">Bid Timing Audit</td></tr>
<tr><td align="center"><a href="#" onclick="history.back();return false;" class="action_link">&lt;&lt; Back</a></td></tr>
</table>

<div style="max-width:900px;margin:16px auto;">

<div class="diag-section">
    <h3>What this checks</h3>
    <p style="font-size:12px;color:#555;line-height:1.6;margin:0;">
        For every item currently in <code>tbl_auction_live</code>, this looks up its auction
        week's <code>auction_week_start_date</code> / <code>auction_week_end_date</code> and
        reports any <code>tbl_bid</code> or <code>tbl_proxy_bid_live</code> entry whose
        timestamp falls outside that window — placed before the week opened or after it
        closed. Read-only — no data is changed by running this page.
    </p>
</div>

<?php if ($result['error']): ?>
    <div class="diag-box-err">&#10007; Query failed: <?= htmlspecialchars($result['error']) ?></div>
<?php else: ?>

    <div class="diag-section">
        <h3>Summary</h3>
        <dl>
            <div class="diag-kv"><dt>Live items scanned</dt><dd><?= (int)$result['items_total'] ?></dd></div>
            <div class="diag-kv"><dt>Skipped (no week/schedule)</dt><dd><?= (int)$result['items_no_week'] ?></dd></div>
            <div class="diag-kv"><dt>Items flagged</dt><dd><?= count($result['items_flagged']) ?></dd></div>
            <div class="diag-kv"><dt>Out-of-window bids</dt><dd><?= (int)$result['bid_count'] ?></dd></div>
            <div class="diag-kv"><dt>Out-of-window proxy bids</dt><dd><?= (int)$result['proxy_count'] ?></dd></div>
        </dl>
    </div>

    <?php if (empty($result['items_flagged'])): ?>
        <div class="diag-box-ok">&#10003; No out-of-window bids or proxy bids found across <?= (int)$result['items_total'] ?> live auction item(s).</div>
    <?php else: ?>
        <div class="diag-box-warn">&#9888; <?= count($result['items_flagged']) ?> item(s) have bids or proxy bids logged outside their auction week window.</div>

        <?php foreach ($result['items_flagged'] as $item): ?>
        <div class="diag-section">
            <div class="audit-item-head">
                Auction #<?= (int)$item['auction_id'] ?> &mdash; <?= htmlspecialchars($item['poster_title'] ?: '(untitled)') ?>
                <?php if ($item['poster_sku']): ?><span style="color:#999;font-weight:400;">(SKU: <?= htmlspecialchars($item['poster_sku']) ?>)</span><?php endif; ?>
            </div>
            <div class="audit-item-sub">
                Week #<?= (int)$item['week_id'] ?><?= $item['week_title'] ? ' — ' . htmlspecialchars($item['week_title']) : '' ?>
                &nbsp;|&nbsp; Window: <?= htmlspecialchars($item['week_start']) ?> &rarr; <?= htmlspecialchars($item['week_end']) ?>
            </div>

            <?php if ($item['bad_bids']): ?>
            <table class="audit-table">
                <tr><th>Bid ID</th><th>User ID</th><th>Amount</th><th>Proxy?</th><th>Posted</th><th>Issue</th></tr>
                <?php foreach ($item['bad_bids'] as $b): ?>
                <tr>
                    <td><?= (int)$b['bid_id'] ?></td>
                    <td><?= (int)$b['bid_fk_user_id'] ?></td>
                    <td>$<?= number_format((float)$b['bid_amount'], 2) ?></td>
                    <td><?= $b['is_proxy'] == '1' ? 'Yes' : 'No' ?></td>
                    <td><?= htmlspecialchars($b['post_date']) ?></td>
                    <td>
                        <?php if ($b['post_date'] < $item['week_start']): ?>
                            <span class="audit-early">Before window opened</span>
                        <?php else: ?>
                            <span class="audit-late">After window closed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>

            <?php if ($item['bad_proxy']): ?>
            <table class="audit-table">
                <tr><th>Proxy ID</th><th>User ID</th><th>Max Amount</th><th>Overridden?</th><th>Posted</th><th>Issue</th></tr>
                <?php foreach ($item['bad_proxy'] as $p): ?>
                <tr>
                    <td><?= (int)$p['proxy_id'] ?></td>
                    <td><?= (int)$p['fk_user_id'] ?></td>
                    <td>$<?= number_format((float)$p['amount'], 2) ?></td>
                    <td><?= $p['is_override'] == '1' ? 'Yes' : 'No' ?></td>
                    <td><?= htmlspecialchars($p['proxy_date']) ?></td>
                    <td>
                        <?php if ($p['proxy_date'] < $item['week_start']): ?>
                            <span class="audit-early">Before window opened</span>
                        <?php else: ?>
                            <span class="audit-late">After window closed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php endif; ?>

</div>
</td></tr>
</table>
<?php $smarty->display('admin_footer.tpl'); ?>

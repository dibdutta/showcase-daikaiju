<?php
/**
 * Auction Week Invoice Reconciliation — read-only diagnostic page.
 *
 * Given an auction_week_id, checks every archived item in tbl_auction for
 * that week and buckets it into one of three categories:
 *   1. Sold — Invoice OK        auction_is_sold='1' AND an invoice exists
 *   2. Sold — Invoice MISSING   auction_is_sold='1', has bids, but no invoice
 *                                (exactly the failure mode left behind when
 *                                 cron.php's per-item archival loop dies
 *                                 partway through — see cron.php's
 *                                 updateBidCronJob()/generateInvoice())
 *   3. Unsold                   everything else (no bids, reserve not met,
 *                                 reopened, etc.)
 *
 * No writes are performed anywhere in this file.
 *
 * Access: /admin/admin_audit_week_invoices.php  (requires admin session)
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('PAGE_HEADER_TEXT', 'Auction Week Invoice Reconciliation');

ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

function get_week_info($db, $weekId) {
    $rs = mysqli_query($db, "SELECT auction_week_id, auction_week_title, auction_week_start_date, auction_week_end_date
                              FROM tbl_auction_week WHERE auction_week_id = " . (int)$weekId . " LIMIT 1");
    return $rs ? mysqli_fetch_assoc($rs) : null;
}

function run_reconciliation($db, $weekId) {
    $out = ['error' => null, 'sold_ok' => [], 'sold_missing_invoice' => [], 'unsold' => []];

    $sql = "SELECT a.auction_id, a.auction_is_sold, a.bid_count, a.max_bid_amount, a.highest_user,
                   a.auction_actual_end_datetime,
                   p.poster_id, p.poster_title, p.poster_sku,
                   u.firstname, u.lastname, u.email,
                   COUNT(ita.fk_invoice_id) AS invoice_count
            FROM tbl_auction a
            JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
            LEFT JOIN " . USER_TABLE . " u ON u.user_id = a.highest_user
            LEFT JOIN tbl_invoice_to_auction ita ON ita.fk_auction_id = a.auction_id
            WHERE a.fk_auction_week_id = " . (int)$weekId . "
            GROUP BY a.auction_id
            ORDER BY p.poster_title";
    $rs = mysqli_query($db, $sql);
    if (!$rs) {
        $out['error'] = mysqli_error($db);
        return $out;
    }

    while ($row = mysqli_fetch_assoc($rs)) {
        $hasBid = ((float)$row['max_bid_amount'] > 0) || ((int)$row['bid_count'] > 0);
        if ($row['auction_is_sold'] == '1' && (int)$row['invoice_count'] > 0) {
            $out['sold_ok'][] = $row;
        } elseif ($row['auction_is_sold'] == '1' && $hasBid && (int)$row['invoice_count'] == 0) {
            $out['sold_missing_invoice'][] = $row;
        } else {
            $out['unsold'][] = $row;
        }
    }
    return $out;
}

$weekId = (int)($_REQUEST['auction_week_id'] ?? 0);
$week = null;
$result = null;
if ($weekId > 0) {
    $week = get_week_info($GLOBALS['db_connect'], $weekId);
    $result = run_reconciliation($GLOBALS['db_connect'], $weekId);
}

require_once INCLUDE_PATH . 'lib/adminCommon.php';
ob_end_clean();
ob_start();
$smarty->display('admin_header.tpl');
echo ob_get_clean();
?>
<style>
.diag-section { background:#fff; border:1px solid #ddd; border-radius:5px; padding:18px 20px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.diag-section h3 { font-size:13px; font-weight:700; color:#0f3460; margin:0 0 12px; border-bottom:1px solid #eee; padding-bottom:8px; text-transform:uppercase; letter-spacing:.5px; }
.diag-box-ok  { background:#d4edda; border:1px solid #28a745; color:#155724; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-box-err { background:#f8d7da; border:1px solid #dc3545; color:#721c24; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-box-warn{ background:#fff3cd; border:1px solid #ffc107; color:#664d03; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.diag-form input[type=number] { padding:7px 10px; border:1px solid #ccc; border-radius:3px; font-size:13px; width:160px; }
.diag-btn { background:#0f3460; color:#fff; border:none; padding:9px 22px; font-size:12px; font-weight:700; border-radius:3px; cursor:pointer; text-transform:uppercase; letter-spacing:.5px; }
.diag-btn:hover { background:#1a3a6e; }
.audit-table { width:100%; border-collapse:collapse; font-size:12px; }
.audit-table th { background:#f5f5f5; text-align:left; padding:6px 8px; border-bottom:2px solid #ddd; }
.audit-table td { padding:5px 8px; border-bottom:1px solid #eee; }
.audit-table tr:last-child td { border-bottom:none; }
.pill { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700; }
.pill-ok   { background:#d4edda; color:#155724; }
.pill-bad  { background:#f8d7da; color:#721c24; }
.pill-none { background:#e9ecef; color:#555; }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td align="center" class="bold_text" style="padding:10px 0 6px;">Auction Week Invoice Reconciliation</td></tr>
<tr><td align="center"><a href="#" onclick="history.back();return false;" class="action_link">&lt;&lt; Back</a></td></tr>
</table>

<div style="max-width:1000px;margin:16px auto;">

<div class="diag-section">
    <h3>Look up a week</h3>
    <form method="get" class="diag-form">
        <label>Auction Week ID:</label>
        &nbsp;<input type="number" name="auction_week_id" min="1" value="<?= (int)$weekId ?: '' ?>" required>
        &nbsp;<button type="submit" class="diag-btn">Check</button>
    </form>
</div>

<?php if ($weekId > 0): ?>

    <?php if (!$week): ?>
        <div class="diag-box-err">&#10007; No auction week found with auction_week_id = <?= (int)$weekId ?>.</div>
    <?php elseif ($result['error']): ?>
        <div class="diag-box-err">&#10007; Query failed: <?= htmlspecialchars($result['error']) ?></div>
    <?php else: ?>

        <div class="diag-section">
            <h3>Week</h3>
            <p style="font-size:12px;color:#555;margin:0;">
                <b>#<?= (int)$week['auction_week_id'] ?></b>
                <?= $week['auction_week_title'] ? '&mdash; ' . htmlspecialchars($week['auction_week_title']) : '' ?><br>
                <?= htmlspecialchars($week['auction_week_start_date']) ?> &rarr; <?= htmlspecialchars($week['auction_week_end_date']) ?>
            </p>
        </div>

        <div class="diag-section">
            <h3>Summary</h3>
            <p style="font-size:12px;">
                <span class="pill pill-ok">Sold — Invoice OK: <?= count($result['sold_ok']) ?></span>
                &nbsp;
                <span class="pill pill-bad">Sold — Invoice MISSING: <?= count($result['sold_missing_invoice']) ?></span>
                &nbsp;
                <span class="pill pill-none">Unsold: <?= count($result['unsold']) ?></span>
            </p>
        </div>

        <?php if (!empty($result['sold_missing_invoice'])): ?>
        <div class="diag-section">
            <h3>&#9888; Sold — Invoice Missing (<?= count($result['sold_missing_invoice']) ?>)</h3>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>SKU</th><th>Winner</th><th>Bid Count</th><th>Max Bid</th><th>Ended</th></tr>
                <?php foreach ($result['sold_missing_invoice'] as $r): ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><?= htmlspecialchars($r['poster_sku']) ?></td>
                    <td><?= $r['firstname'] ? htmlspecialchars($r['firstname'] . ' ' . $r['lastname'] . ' <' . $r['email'] . '>') : '<span style="color:#999;">(no winner on record)</span>' ?></td>
                    <td><?= (int)$r['bid_count'] ?></td>
                    <td>$<?= number_format((float)$r['max_bid_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($r['auction_actual_end_datetime']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <div class="diag-section">
            <h3>Sold — Invoice OK (<?= count($result['sold_ok']) ?>)</h3>
            <?php if ($result['sold_ok']): ?>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>SKU</th><th>Winner</th><th>Max Bid</th></tr>
                <?php foreach ($result['sold_ok'] as $r): ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><?= htmlspecialchars($r['poster_sku']) ?></td>
                    <td><?= $r['firstname'] ? htmlspecialchars($r['firstname'] . ' ' . $r['lastname']) : '' ?></td>
                    <td>$<?= number_format((float)$r['max_bid_amount'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p style="font-size:12px;color:#999;">None.</p>
            <?php endif; ?>
        </div>

        <div class="diag-section">
            <h3>Unsold (<?= count($result['unsold']) ?>)</h3>
            <?php if ($result['unsold']): ?>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>SKU</th><th>Status</th><th>Bid Count</th><th>Max Bid</th></tr>
                <?php foreach ($result['unsold'] as $r):
                    $statusLabel = ['0' => 'Active/Unresolved', '1' => 'Sold', '2' => 'Reserve Not Met', '3' => 'Reopened'][$r['auction_is_sold']] ?? $r['auction_is_sold'];
                ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><?= htmlspecialchars($r['poster_sku']) ?></td>
                    <td><?= htmlspecialchars($statusLabel) ?></td>
                    <td><?= (int)$r['bid_count'] ?></td>
                    <td>$<?= number_format((float)$r['max_bid_amount'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p style="font-size:12px;color:#999;">None.</p>
            <?php endif; ?>
        </div>

    <?php endif; ?>

<?php endif; ?>

</div>
</td></tr>
</table>
<?php $smarty->display('admin_footer.tpl'); ?>

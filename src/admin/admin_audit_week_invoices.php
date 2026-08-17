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
 * It also runs a second, independent audit over BID DATA INTEGRITY for the same
 * week — see run_bid_integrity_audit() below. That exists because a bid-archival
 * bug could silently move bids between auctions (tbl_bid is keyed by
 * tbl_auction_live IDs while tbl_bid_archive is keyed by tbl_auction IDs, and the
 * two sequences collide), corrupting one item's history while wiping another's.
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

/**
 * Bid-data integrity audit. Three independent invariant checks over
 * tbl_bid_archive for one auction week, plus a drill-down of the raw archive
 * rows for anything flagged. Read-only.
 */
function run_bid_integrity_audit($db, $weekId) {
    $weekId = (int)$weekId;
    $out = ['impossible' => [], 'count_mismatch' => [], 'winner_issues' => [], 'detail' => []];

    // CHECK 1 — Impossible bid amounts.
    // max_bid_amount is by definition the highest bid on that auction, so an archived
    // bid larger than it cannot belong to this item. Strongest signal: no legitimate
    // cron behaviour produces it.
    $rs = mysqli_query($db, "
        SELECT a.auction_id, p.poster_title, a.bid_count, a.max_bid_amount,
               COUNT(b.bid_id) AS offending_count, MAX(b.bid_amount) AS biggest
        FROM tbl_auction a
        JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
        JOIN tbl_bid_archive b ON b.bid_fk_auction_id = a.auction_id
        WHERE a.fk_auction_week_id = $weekId
          AND b.bid_amount > a.max_bid_amount
        GROUP BY a.auction_id
        ORDER BY offending_count DESC");
    if ($rs) { while ($r = mysqli_fetch_assoc($rs)) { $out['impossible'][] = $r; } }

    // CHECK 2 — Archived row count vs the bid_count snapshot copied from
    // tbl_auction_live at archive time (i.e. taken before any later corruption).
    // Surplus = received foreign bids. Deficit = lost its own bids.
    // NOTE: delta of exactly +1 is frequently legitimate — Branch B of
    // updateBidCronJob() inserts a closing proxy bid without incrementing
    // bid_count (Branch A does increment). Treat |delta| >= 2 as real signal.
    $rs = mysqli_query($db, "
        SELECT a.auction_id, p.poster_title, a.bid_count AS expected,
               COUNT(b.bid_id) AS actual, (COUNT(b.bid_id) - a.bid_count) AS delta
        FROM tbl_auction a
        JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
        LEFT JOIN tbl_bid_archive b ON b.bid_fk_auction_id = a.auction_id
        WHERE a.fk_auction_week_id = $weekId
        GROUP BY a.auction_id
        HAVING delta <> 0
        ORDER BY delta");
    if ($rs) { while ($r = mysqli_fetch_assoc($rs)) { $out['count_mismatch'][] = $r; } }

    // CHECK 3 — Winner sanity. A sold auction should have exactly one bid_is_won=1.
    // 0 winners => invoice / tbl_sold_archive likely never generated.
    // 2+ winners => duplicate closing bid.
    $rs = mysqli_query($db, "
        SELECT a.auction_id, p.poster_title,
               SUM(CASE WHEN b.bid_is_won = '1' THEN 1 ELSE 0 END) AS winners
        FROM tbl_auction a
        JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
        LEFT JOIN tbl_bid_archive b ON b.bid_fk_auction_id = a.auction_id
        WHERE a.fk_auction_week_id = $weekId AND a.auction_is_sold = '1'
        GROUP BY a.auction_id
        HAVING winners <> 1
        ORDER BY winners DESC");
    if ($rs) { while ($r = mysqli_fetch_assoc($rs)) { $out['winner_issues'][] = $r; } }

    // Drill-down: raw archive rows for every flagged auction.
    $flagged = [];
    foreach (['impossible', 'count_mismatch', 'winner_issues'] as $k) {
        foreach ($out[$k] as $r) { $flagged[(int)$r['auction_id']] = true; }
    }
    if (!empty($flagged)) {
        $ids = implode(',', array_keys($flagged));
        $rs = mysqli_query($db, "
            SELECT b.bid_id, b.bid_fk_auction_id, b.bid_fk_user_id, b.bid_amount,
                   b.is_proxy, b.bid_is_won, b.post_date, b.post_ip,
                   u.firstname, u.lastname,
                   a.max_bid_amount
            FROM tbl_bid_archive b
            LEFT JOIN " . USER_TABLE . " u ON u.user_id = b.bid_fk_user_id
            LEFT JOIN tbl_auction a ON a.auction_id = b.bid_fk_auction_id
            WHERE b.bid_fk_auction_id IN ($ids)
            ORDER BY b.bid_fk_auction_id, b.bid_id");
        if ($rs) {
            while ($r = mysqli_fetch_assoc($rs)) {
                $out['detail'][(int)$r['bid_fk_auction_id']][] = $r;
            }
        }
    }

    return $out;
}

$weekId = (int)($_REQUEST['auction_week_id'] ?? 0);
$week = null;
$result = null;
$bidAudit = null;
if ($weekId > 0) {
    $week = get_week_info($GLOBALS['db_connect'], $weekId);
    $result = run_reconciliation($GLOBALS['db_connect'], $weekId);
    $bidAudit = run_bid_integrity_audit($GLOBALS['db_connect'], $weekId);
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

        <?php
        $bidIssueCount = count($bidAudit['impossible']) + count($bidAudit['count_mismatch']) + count($bidAudit['winner_issues']);
        ?>
        <div class="diag-section" style="border-top:4px solid #0f3460;">
            <h3>Bid Data Integrity</h3>
            <p style="font-size:12px;color:#555;margin:0 0 10px;">
                Independent of the invoice checks above. Verifies that each auction's archived bid
                history in <code>tbl_bid_archive</code> is internally consistent — catching bids that
                were mis-filed onto the wrong auction.
            </p>
            <?php if ($bidIssueCount === 0): ?>
                <div class="diag-box-ok">&#10003; No bid-data anomalies found for this week.</div>
            <?php else: ?>
                <div class="diag-box-warn">&#9888; <?= $bidIssueCount ?> anomaly finding(s) below. Review before treating this week's bid history as accurate.</div>
            <?php endif; ?>
        </div>

        <?php if ($bidAudit['impossible']): ?>
        <div class="diag-section">
            <h3>&#9888; 1. Impossible Bid Amounts (<?= count($bidAudit['impossible']) ?>)</h3>
            <p style="font-size:12px;color:#555;margin:0 0 10px;">
                Archived bids <em>larger</em> than the auction's own <code>max_bid_amount</code>.
                Since <code>max_bid_amount</code> is by definition the highest bid on that item,
                these rows cannot belong to it — they were filed onto the wrong auction.
                <strong>This is the highest-confidence check; no normal cron behaviour produces it.</strong>
            </p>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>Recorded Bids</th><th>Recorded Max Bid</th><th>Impossible Rows</th><th>Largest Found</th></tr>
                <?php foreach ($bidAudit['impossible'] as $r): ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><?= (int)$r['bid_count'] ?></td>
                    <td>$<?= number_format((float)$r['max_bid_amount'], 2) ?></td>
                    <td><span class="pill pill-bad"><?= (int)$r['offending_count'] ?></span></td>
                    <td>$<?= number_format((float)$r['biggest'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <?php if ($bidAudit['count_mismatch']): ?>
        <div class="diag-section">
            <h3>2. Bid Count Mismatch (<?= count($bidAudit['count_mismatch']) ?>)</h3>
            <p style="font-size:12px;color:#555;margin:0 0 10px;">
                <code>tbl_auction.bid_count</code> is snapshotted from the live table at archive time,
                <em>before</em> any later corruption — so it's the trustworthy figure. A
                <strong>surplus</strong> means the item received foreign bids; a <strong>deficit</strong>
                means it lost its own. Surplus and deficit rows usually pair up as donor/victim.
                <br><em>Note: only a delta of exactly <strong>+1</strong> is routinely benign — Branch B of the
                cron inserts a closing proxy bid without incrementing <code>bid_count</code>. A
                <strong>negative</strong> delta means archived bid rows are outright missing, which is never
                expected and often accompanies a missing invoice.</em>
            </p>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>Expected (bid_count)</th><th>Actual Rows</th><th>Delta</th><th>Reading</th></tr>
                <?php foreach ($bidAudit['count_mismatch'] as $r):
                    $delta = (int)$r['delta'];
                    // Only +1 is routinely benign: Branch B of updateBidCronJob() inserts a
                    // closing proxy bid without incrementing bid_count. Every other delta —
                    // including any negative one, which means archived rows are outright
                    // missing — is a genuine finding.
                    $strong = ($delta !== 1);
                ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><?= (int)$r['expected'] ?></td>
                    <td><?= (int)$r['actual'] ?></td>
                    <td><span class="pill <?= $strong ? 'pill-bad' : 'pill-none' ?>"><?= $delta > 0 ? '+' : '' ?><?= $delta ?></span></td>
                    <td><?= $delta > 0 ? 'Received foreign bids' : 'Lost its own bids' ?><?= $strong ? '' : ' <span style="color:#999;">(likely benign)</span>' ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <?php if ($bidAudit['winner_issues']): ?>
        <div class="diag-section">
            <h3>3. Winner Anomalies (<?= count($bidAudit['winner_issues']) ?>)</h3>
            <p style="font-size:12px;color:#555;margin:0 0 10px;">
                A sold auction should have exactly one <code>bid_is_won='1'</code> row.
                <strong>0</strong> usually means the invoice and <code>tbl_sold_archive</code> row were never
                generated; <strong>2+</strong> means a duplicate closing bid was created.
            </p>
            <table class="audit-table">
                <tr><th>Auction ID</th><th>Poster</th><th>Winning Rows</th><th>Reading</th></tr>
                <?php foreach ($bidAudit['winner_issues'] as $r): ?>
                <tr>
                    <td><?= (int)$r['auction_id'] ?></td>
                    <td><?= htmlspecialchars($r['poster_title']) ?></td>
                    <td><span class="pill pill-bad"><?= (int)$r['winners'] ?></span></td>
                    <td><?= (int)$r['winners'] === 0 ? 'No winner recorded — invoice likely missing' : 'Duplicate winning bid' ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>

        <?php if (!empty($bidAudit['detail'])): ?>
        <div class="diag-section">
            <h3>Drill-down — Archived Bids for Flagged Auctions</h3>
            <p style="font-size:12px;color:#555;margin:0 0 10px;">
                Rows exceeding the auction's max bid are highlighted — those are the mis-filed ones.
                An empty <strong>Post IP</strong> marks a cron-generated bid (the CLI cron has no
                <code>REMOTE_ADDR</code>), which is normal for a closing proxy bid but never for a user bid.
            </p>
            <?php foreach ($bidAudit['detail'] as $aucId => $rows): ?>
                <div style="font-size:12px;font-weight:700;color:#0f3460;margin:14px 0 6px;">
                    Auction #<?= (int)$aucId ?>
                    <span style="font-weight:400;color:#777;">(recorded max bid: $<?= number_format((float)$rows[0]['max_bid_amount'], 2) ?>)</span>
                </div>
                <table class="audit-table">
                    <tr><th>Bid ID</th><th>Bidder</th><th>Amount</th><th>Proxy?</th><th>Won?</th><th>Posted</th><th>Post IP</th></tr>
                    <?php foreach ($rows as $b):
                        $suspect = (float)$b['bid_amount'] > (float)$b['max_bid_amount'];
                    ?>
                    <tr<?= $suspect ? ' style="background:#f8d7da;"' : '' ?>>
                        <td><?= (int)$b['bid_id'] ?></td>
                        <td><?= $b['firstname'] ? htmlspecialchars($b['firstname'] . ' ' . $b['lastname']) : '' ?> <span style="color:#999;">(<?= (int)$b['bid_fk_user_id'] ?>)</span></td>
                        <td>$<?= number_format((float)$b['bid_amount'], 2) ?><?= $suspect ? ' &#9888;' : '' ?></td>
                        <td><?= $b['is_proxy'] == '1' ? 'Yes' : 'No' ?></td>
                        <td><?= $b['bid_is_won'] == '1' ? '<strong>Yes</strong>' : 'No' ?></td>
                        <td><?= htmlspecialchars($b['post_date']) ?></td>
                        <td><?= $b['post_ip'] !== '' ? htmlspecialchars($b['post_ip']) : '<span style="color:#c0392b;">(cron)</span>' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>

</div>
</td></tr>
</table>
<?php $smarty->display('admin_footer.tpl'); ?>

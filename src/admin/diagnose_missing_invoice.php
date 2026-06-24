<?php
/**
 * Diagnostic script: trace why generateInvoice was not called for a specific auction_id.
 * Usage: /admin/diagnose_missing_invoice.php?auction_id=<id>
 *
 * READ-ONLY — no writes to any table.
 */

define ("INCLUDE_PATH", $_SERVER['DOCUMENT_ROOT']."/");
require_once INCLUDE_PATH."lib/inc.php";

$db = $GLOBALS['db_connect'];

$auction_id = isset($_GET['auction_id']) ? (int)$_GET['auction_id'] : 0;

header('Content-Type: text/plain; charset=utf-8');

if (!$auction_id) {
    die("Usage: ?auction_id=<id>\n");
}

function diag_row($db, $sql) {
    $rs = mysqli_query($db, $sql);
    if (!$rs) return ["QUERY_ERROR" => mysqli_error($db)];
    $rows = [];
    while ($r = mysqli_fetch_assoc($rs)) $rows[] = $r;
    return $rows;
}

function diag_print($label, $rows) {
    echo "\n=== $label ===\n";
    if (empty($rows)) {
        echo "(no rows)\n";
    } else {
        foreach ($rows as $i => $r) {
            echo "  [$i] ";
            foreach ($r as $k => $v) echo "$k=$v  ";
            echo "\n";
        }
    }
}

echo "=======================================================\n";
echo "AUCTION ID: $auction_id\n";
echo "=======================================================\n";

// ── 1. tbl_auction record ─────────────────────────────────
$rows = diag_row($db, "SELECT auction_id, fk_poster_id, fk_auction_type_id, fk_auction_week_id,
    bid_count, max_bid_amount, highest_user, auction_is_sold, auction_is_approved
    FROM tbl_auction WHERE auction_id=$auction_id");
diag_print("tbl_auction", $rows);
if (empty($rows) || isset($rows[0]['QUERY_ERROR'])) {
    die("\nAuction not found in tbl_auction — already cleaned up or wrong ID.\n");
}
$auc = $rows[0];

// ── 2. tbl_poster record ──────────────────────────────────
$rows = diag_row($db, "SELECT poster_id, poster_title, fk_user_id
    FROM tbl_poster WHERE poster_id=" . (int)$auc['fk_poster_id']);
diag_print("tbl_poster", $rows);

// ── 3. tbl_bid (live — what cron would JOIN against) ──────
$rows = diag_row($db, "SELECT bid_id, bid_fk_user_id, bid_amount, is_proxy, bid_is_won, post_date
    FROM tbl_bid WHERE bid_fk_auction_id=$auction_id ORDER BY bid_id");
diag_print("tbl_bid (current — should be empty after cron moves bids)", $rows);
$tbl_bid_count = count($rows);

// ── 4. tbl_bid_archive ────────────────────────────────────
$rows = diag_row($db, "SELECT bid_id, bid_fk_user_id, bid_amount, is_proxy, bid_is_won, post_date
    FROM tbl_bid_archive WHERE bid_fk_auction_id=$auction_id ORDER BY bid_id");
diag_print("tbl_bid_archive (bids moved here by fetchExpiredAuctionDetails)", $rows);

// ── 5. tbl_proxy_bid ─────────────────────────────────────
$rows = diag_row($db, "SELECT proxy_id, fk_user_id, amount, is_override
    FROM tbl_proxy_bid WHERE fk_auction_id=$auction_id ORDER BY proxy_id");
diag_print("tbl_proxy_bid", $rows);

// ── 6. tbl_sold_archive & tbl_invoice_to_auction ─────────
$rows = diag_row($db, "SELECT * FROM tbl_sold_archive WHERE auction_id=$auction_id");
diag_print("tbl_sold_archive", $rows);

$rows = diag_row($db, "SELECT * FROM tbl_invoice_to_auction WHERE fk_auction_id=$auction_id");
diag_print("tbl_invoice_to_auction", $rows);

// ── 7. Reproduce fetchExpiredAuctionDetailsList query ────
$main_sql = "SELECT
    a.auction_id,
    a.fk_auction_type_id,
    a.fk_auction_week_id,
    tb.bid_id  AS last_bid_id,
    MAX(tb.bid_amount) AS bid_amount_from_bid,
    a.bid_count,
    a.highest_user,
    a.max_bid_amount,
    p.fk_user_id,
    a.fk_poster_id,
    max(p.amount) as proxy_amount
    FROM tbl_auction a
    LEFT JOIN tbl_proxy_bid p
          ON a.auction_id = p.fk_auction_id
    AND p.is_override ='0'
    AND p.amount = ( SELECT MAX(amount) FROM tbl_proxy_bid WHERE is_override ='0' AND fk_auction_id=a.auction_id GROUP BY fk_auction_id )
    LEFT JOIN tbl_bid tb
          ON a.auction_id = tb.bid_fk_auction_id
        AND CASE WHEN countMax(a.auction_id) = 1
                 THEN tb.bid_amount = (SELECT MAX(ntb.bid_amount) FROM tbl_bid ntb WHERE ntb.bid_fk_auction_id = a.auction_id GROUP BY ntb.bid_fk_auction_id)
                 WHEN countMax(a.auction_id) > 1
                 THEN tb.bid_amount = (SELECT MAX(ntb.bid_amount) FROM tbl_bid ntb WHERE ntb.bid_fk_auction_id = a.auction_id GROUP BY ntb.bid_fk_auction_id)
                      AND tb.is_proxy = '1'
                 END
    WHERE a.auction_id = $auction_id
    GROUP BY a.auction_id";

echo "\n=== fetchExpiredAuctionDetailsList query result ===\n";
echo "SQL:\n$main_sql\n\n";
$rows = diag_row($db, $main_sql);
if (isset($rows[0]['QUERY_ERROR'])) {
    echo "QUERY FAILED: " . $rows[0]['QUERY_ERROR'] . "\n";
} else {
    diag_print("Result", $rows);
}

$item = $rows[0] ?? null;

// ── 8. Decision tree walkthrough ─────────────────────────
echo "\n=======================================================\n";
echo "DECISION TREE (mimicking updateBidCronJob loop)\n";
echo "=======================================================\n";

if (!$item || isset($item['QUERY_ERROR'])) {
    echo "[SKIP] fetchExpiredAuctionDetailsList returned no row for this auction_id.\n";
    echo "       This auction was NOT included in the cron's processing batch.\n";
    echo "       Possible cause: auction_id not in the \$auction_ids array built by fetchExpiredAuctionDetails.\n";
    echo "       Check tbl_auction_mapping to see if this new auction_id was registered:\n";
    $rows = diag_row($db, "SELECT * FROM tbl_auction_mapping WHERE auction_id_new=$auction_id");
    diag_print("tbl_auction_mapping (auction_id_new=$auction_id)", $rows);
    exit;
}

echo "\n  bid_count       = {$item['bid_count']}\n";
echo "  fk_auction_type_id = {$item['fk_auction_type_id']}\n";
echo "  highest_user    = {$item['highest_user']}\n";
echo "  max_bid_amount  = {$item['max_bid_amount']}\n";
echo "  fk_user_id (proxy holder) = {$item['fk_user_id']}\n";
echo "  proxy_amount    = {$item['proxy_amount']}\n";
echo "  last_bid_id     = {$item['last_bid_id']}\n";
echo "  bid_amount_from_bid = {$item['bid_amount_from_bid']}\n";

echo "\n";

// Gate 1
if ((int)$item['bid_count'] <= 0) {
    echo "[SKIP] bid_count=0 → item treated as UNSOLD, no generateInvoice called.\n";
    exit;
}
echo "[PASS] bid_count > 0 → enters bid-won processing.\n";

// Gate 2 — auction type
if ($item['fk_auction_type_id'] == '2' || $item['fk_auction_type_id'] == '5') {
    echo "[PASS] fk_auction_type_id={$item['fk_auction_type_id']} → weekly auction branch.\n";

    $proxy_amount     = (float)$item['proxy_amount'];
    $max_bid_amount   = (float)$item['max_bid_amount'];
    $proxy_user       = $item['fk_user_id'];
    $highest_user     = $item['highest_user'];
    $bid_amount_bid   = (float)$item['bid_amount_from_bid'];

    // Branch A: proxy holder outbids winner
    if ($proxy_amount > $max_bid_amount && $highest_user != $proxy_user) {
        echo "[BRANCH A] proxy_amount($proxy_amount) > max_bid_amount($max_bid_amount) AND different users → proxy outbid path.\n";
        echo "           processExpiredAuction WOULD be called after proxy bid insertion.\n";
        exit;
    }

    // Branch B: proxy holder IS the winner
    if ($max_bid_amount > $bid_amount_bid && $highest_user == $proxy_user) {
        echo "[BRANCH B] proxy holder IS the tbl_auction winner → cron inserts a formal closing bid.\n";
        echo "           processExpiredAuction WOULD be called.\n";
        exit;
    }

    // Branch C: non-proxy winner
    echo "[BRANCH C] Non-proxy winner path.\n";
    echo "           Cron queries tbl_bid for: user_id=$highest_user, auction_id=$auction_id, amount=$max_bid_amount, is_proxy=0\n";
    $existing = diag_row($db,
        "SELECT bid_id, bid_fk_user_id, bid_amount, is_proxy FROM tbl_bid
         WHERE bid_fk_user_id='$highest_user'
           AND bid_fk_auction_id='$auction_id'
           AND bid_amount='$max_bid_amount'
           AND is_proxy='0'
         ORDER BY bid_id DESC LIMIT 1");
    diag_print("tbl_bid lookup for non-proxy winner", $existing);

    if (!empty($existing) && !isset($existing[0]['QUERY_ERROR'])) {
        echo "[PASS] Found existing bid → processExpiredAuction WOULD be called.\n";
    } else {
        echo "[FAIL] *** No matching row in tbl_bid ***\n";
        echo "       This is the likely reason generateInvoice was NOT called.\n";
        echo "\n       The bid was probably moved to tbl_bid_archive by fetchExpiredAuctionDetails\n";
        echo "       before this branch queried tbl_bid — so the lookup returns nothing.\n";
        echo "\n       Checking tbl_bid_archive for same criteria...\n";
        $archived = diag_row($db,
            "SELECT bid_id, bid_fk_user_id, bid_amount, is_proxy, bid_is_won FROM tbl_bid_archive
             WHERE bid_fk_user_id='$highest_user'
               AND bid_fk_auction_id='$auction_id'
               AND bid_amount='$max_bid_amount'
               AND is_proxy='0'
             ORDER BY bid_id DESC LIMIT 1");
        diag_print("tbl_bid_archive lookup (same criteria)", $archived);
        if (!empty($archived) && !isset($archived[0]['QUERY_ERROR'])) {
            echo "\n[CONFIRMED] Winning bid IS in tbl_bid_archive (bid_id={$archived[0]['bid_id']}).\n";
            echo "            Root cause: fetchExpiredAuctionDetails archived the bid first,\n";
            echo "            then updateBidCronJob's Branch C queried tbl_bid and found nothing.\n";
            echo "\n  FIX: In cron.php Branch C, also check tbl_bid_archive when tbl_bid returns empty.\n";
            echo "  RECOVERY: Run the recovery script with auction_id=$auction_id and bid_id={$archived[0]['bid_id']}\n";
        } else {
            echo "\n  Winning bid not found in tbl_bid_archive either — investigate manually.\n";
        }
    }

} elseif ($item['fk_auction_type_id'] == '3') {
    echo "[BRANCH] Monthly auction (type 3).\n";
    $rows = diag_row($db, "SELECT auction_reserve_offer_price FROM tbl_auction WHERE auction_id=$auction_id");
    $reserve = $rows[0]['auction_reserve_offer_price'] ?? 'n/a';
    $last_bid = $item['bid_amount_from_bid'];
    echo "  auction_reserve_offer_price = $reserve\n";
    echo "  last_bid_amount (from bid)  = $last_bid\n";
    if ((float)$reserve <= (float)$last_bid) {
        echo "[PASS] reserve($reserve) <= last_bid($last_bid) → processExpiredAuction WOULD be called.\n";
    } else {
        echo "[FAIL] reserve($reserve) > last_bid($last_bid) → processExpiredAuction NOT called.\n";
    }
} else {
    echo "[SKIP] fk_auction_type_id={$item['fk_auction_type_id']} — not handled by weekly/monthly auction branch.\n";
}

echo "\n=======================================================\n";
echo "END OF DIAGNOSIS\n";
echo "=======================================================\n";
?>

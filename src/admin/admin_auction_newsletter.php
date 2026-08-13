<?php
/**
 * Auction Newsletter Template Generator — builds an editable "auction ending
 * soon" email (highlighting the currently running auction week's end date
 * and the top live items ranked by current bid, same data source as
 * /buy?list=weekly) as raw HTML the admin can copy into whatever tool they
 * send the actual campaign through, plus a deduplicated list of every
 * registered user's email address to use as the recipient list.
 *
 * This page never sends anything itself — read-only + template rendering only.
 *
 * Access: /admin/admin_auction_newsletter.php  (requires admin session)
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('PAGE_HEADER_TEXT', 'Auction Newsletter Template');

ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

show_preview();

// ─── helpers ──────────────────────────────────────────────────────────────────

function get_active_week() {
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT auction_week_id, auction_week_title, auction_week_start_date, auction_week_end_date
         FROM tbl_auction_week
         WHERE auction_week_start_date <= NOW() AND auction_week_end_date >= NOW()
         ORDER BY auction_week_end_date ASC LIMIT 1");
    $row = $rs ? mysqli_fetch_assoc($rs) : null;
    if ($row) return $row;

    // No week live right now — fall back to the next upcoming one so the
    // preview still has something sensible to show/edit.
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT auction_week_id, auction_week_title, auction_week_start_date, auction_week_end_date
         FROM tbl_auction_week
         WHERE auction_week_end_date >= NOW()
         ORDER BY auction_week_start_date ASC LIMIT 1");
    return $rs ? mysqli_fetch_assoc($rs) : null;
}

function get_popular_items($limit) {
    $limit = max(1, min(12, (int)$limit));
    $rs = mysqli_query($GLOBALS['db_connect'], "
        SELECT a.auction_id, a.max_bid_amount, a.bid_count, a.auction_actual_end_datetime,
               p.poster_title, pi.poster_thumb
        FROM tbl_auction_live a
        INNER JOIN tbl_poster_live p ON a.fk_poster_id = p.poster_id
        INNER JOIN tbl_poster_images_live pi ON a.fk_poster_id = pi.fk_poster_id
        WHERE pi.is_default = '1'
          AND a.auction_is_approved = '1'
          AND a.auction_is_sold = '0'
          AND a.in_cart = '0'
          AND a.auction_actual_start_datetime <= NOW()
          AND a.auction_actual_end_datetime >= NOW()
        ORDER BY a.max_bid_amount DESC, a.bid_count DESC
        LIMIT $limit");
    $items = [];
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $items[] = $row;
        }
    }
    return $items;
}

// All unique registered-user email addresses, case-insensitively deduplicated.
// newsletter_subscription is no longer collected at registration (opt-in is
// now folded into Terms & Conditions acceptance), so every registered user
// with a valid email is a recipient.
function get_all_unique_recipient_emails() {
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT MIN(email) AS email
         FROM " . USER_TABLE . "
         WHERE email IS NOT NULL AND TRIM(email) <> ''
         GROUP BY LOWER(TRIM(email))
         ORDER BY email");
    $emails = [];
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $emails[] = trim($row['email']);
        }
    }
    return $emails;
}

function build_items_html($items) {
    if (empty($items)) return '';
    $html = '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
    foreach ($items as $item) {
        $img_url = $item['poster_thumb']
            ? CLOUD_POSTER_THUMB_BUY_GALLERY . htmlspecialchars($item['poster_thumb'])
            : '';
        $img_tag = $img_url
            ? '<img src="' . $img_url . '" width="120" height="120" alt="" style="display:block;object-fit:cover;border-radius:6px;border:1px solid #dbd9da;">'
            : '<div style="width:120px;height:120px;background:#f5f5f5;border-radius:6px;border:1px solid #dbd9da;"></div>';

        $item_url = posterUrl($item['auction_id'], $item['poster_title']);
        $bidLabel = $item['max_bid_amount'] > 0 ? 'Current Bid' : 'Starting Bid';

        $html .= '
        <tr>
          <td style="padding:0 0 16px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #dbd9da;border-radius:6px;">
              <tr>
                <td width="130" style="padding:12px;vertical-align:top;">' . $img_tag . '</td>
                <td style="padding:12px 12px 12px 0;vertical-align:top;">
                  <div style="font-size:14px;font-weight:bold;color:#333333;margin-bottom:6px;">' . htmlspecialchars($item['poster_title']) . '</div>
                  <div style="font-size:13px;color:#666666;margin-bottom:10px;">' . $bidLabel . ': <strong style="color:#c0392b;">$' . number_format((float)$item['max_bid_amount'], 2) . '</strong></div>
                  <a href="' . $item_url . '" style="display:inline-block;background:#c0392b;color:#ffffff;text-decoration:none;padding:8px 18px;border-radius:4px;font-size:12px;font-weight:bold;">Bid Now &rarr;</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>';
    }
    $html .= '</table>';
    return $html;
}

function build_email_html($endingText, $introHtml, $itemsHtml, $ctaLabel, $weekLink) {
    // Generic salutation — this template is copied out and sent manually
    // (e.g. via BCC or an ESP campaign tool), not personalized per recipient.
    $textContent = 'Dear Collector,<br /><br />';

    if ($endingText !== '') {
        $textContent .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 16px;">
            <tr><td align="center" style="background:#c0392b;color:#ffffff;font-weight:bold;font-size:14px;padding:10px 14px;border-radius:4px;">'
                . htmlspecialchars($endingText) . '</td></tr>
        </table>';
    }

    $textContent .= '<div style="font-size:14px;color:#333333;line-height:1.6;margin-bottom:18px;">' . $introHtml . '</div>';

    if ($itemsHtml !== '') {
        $textContent .= '<div style="font-size:13px;font-weight:bold;color:#333333;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Popular Items Right Now</div>';
        $textContent .= $itemsHtml;
    }

    $textContent .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:10px;">
        <tr><td align="center">
            <a href="' . $weekLink . '" style="display:inline-block;background:#0f3460;color:#ffffff;text-decoration:none;padding:12px 30px;border-radius:4px;font-size:14px;font-weight:bold;">' . htmlspecialchars($ctaLabel) . '</a>
        </td></tr>
    </table>';

    $textContent .= "<p style='margin:24px 0 0 0; color:#333333;'>Warm regards,<br /><strong>" . ADMIN_NAME . "</strong><br /><a href='mailto:" . ADMIN_EMAIL_ADDRESS . "' style='color:#c0392b;'>" . ADMIN_EMAIL_ADDRESS . "</a></p>";

    return MAIL_BODY_TOP . $textContent . MAIL_BODY_BOTTOM;
}

// ─── page ─────────────────────────────────────────────────────────────────────

function show_preview() {
    require_once INCLUDE_PATH . 'lib/adminCommon.php';

    $itemCount = (int)($_REQUEST['item_count'] ?? 6);
    if ($itemCount < 1 || $itemCount > 12) $itemCount = 6;

    $week  = get_active_week();
    $items = get_popular_items($itemCount);
    $emails = get_all_unique_recipient_emails();

    $defaultEnding = '';
    if ($week && !empty($week['auction_week_end_date'])) {
        $defaultEnding = 'Auction ending this ' . date('l, F jS', strtotime($week['auction_week_end_date'])) . '!';
    }
    $defaultSubject  = 'Don\'t Miss Out — Kaijulink Auction Ending Soon!';
    $defaultIntro    = "Our current auction is heating up and closing soon. Take one more look before it's gone — rare original posters and kaiju memorabilia are waiting for their next home.";
    $defaultCtaLabel = 'See All Live Auction Items';

    $subject   = trim($_REQUEST['email_subject'] ?? $defaultSubject);
    $endingTxt = $_REQUEST['ending_text']  ?? $defaultEnding;
    $intro     = trim($_REQUEST['email_intro']   ?? $defaultIntro);
    $ctaLabel  = trim($_REQUEST['cta_label']     ?? $defaultCtaLabel);
    if ($subject === '') $subject = $defaultSubject;
    if ($intro === '')   $intro   = $defaultIntro;
    if ($ctaLabel === '') $ctaLabel = $defaultCtaLabel;

    $itemsHtml = build_items_html($items);
    $introHtml = nl2br(htmlspecialchars($intro));
    $weekLink  = 'https://' . HOST_NAME . '/buy?list=weekly';
    $renderedHtml = build_email_html($endingTxt, $introHtml, $itemsHtml, $ctaLabel, $weekLink);

    $smarty->assign('week', $week);
    $smarty->assign('items', $items);
    $smarty->assign('item_count', $itemCount);
    $smarty->assign('recipient_emails', $emails);
    $smarty->assign('total_recipients', count($emails));
    $smarty->assign('email_subject', $subject);
    $smarty->assign('ending_text', $endingTxt);
    $smarty->assign('email_intro', $intro);
    $smarty->assign('cta_label', $ctaLabel);
    $smarty->assign('rendered_html', $renderedHtml);
    $smarty->display('admin_auction_newsletter.tpl');
}

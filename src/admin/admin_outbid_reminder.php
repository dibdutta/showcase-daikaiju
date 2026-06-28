<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define("PAGE_HEADER_TEXT", "Outbid Reminder Email");

ob_start();

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';

if ($mode == 'send') {
    send_reminders();
} elseif ($mode == 'preview' && !empty($_REQUEST['week_id'])) {
    show_preview();
} else {
    show_form();
}

// ─── helpers ──────────────────────────────────────────────────────────────────

function get_live_weeks() {
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT aw.auction_week_id, aw.auction_week_start_date, aw.auction_week_end_date,
                COUNT(DISTINCT a.auction_id) AS item_count
         FROM tbl_auction_week aw
         INNER JOIN tbl_auction_live a ON a.fk_auction_week_id = aw.auction_week_id
         WHERE a.auction_is_sold = '0' AND a.auction_is_approved = '1'
         GROUP BY aw.auction_week_id
         ORDER BY aw.auction_week_start_date DESC");
    $rows = [];
    while ($r = mysqli_fetch_assoc($rs)) {
        $rows[] = $r;
    }
    return $rows;
}

function get_losing_bidders($week_id) {
    $week_id = (int)$week_id;
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT
            u.user_id, u.email, u.firstname, u.lastname,
            a.auction_id,
            pl.poster_title,
            pil.poster_image,
            a.max_bid_amount  AS current_highest_bid,
            a.auction_actual_end_datetime,
            MAX(b.bid_amount) AS user_highest_bid
         FROM tbl_bid b
         INNER JOIN tbl_auction_live a  ON b.bid_fk_auction_id = a.auction_id
         INNER JOIN user_table u        ON b.bid_fk_user_id    = u.user_id
         INNER JOIN tbl_poster_live pl  ON a.fk_poster_id      = pl.poster_id
         LEFT  JOIN tbl_poster_images_live pil
                ON pl.poster_id = pil.fk_poster_id AND pil.is_default = '1'
         WHERE a.fk_auction_week_id = $week_id
           AND a.auction_is_sold    = '0'
           AND a.auction_is_approved = '1'
           AND a.highest_user       != b.bid_fk_user_id
         GROUP BY u.user_id, a.auction_id
         ORDER BY u.user_id, a.auction_id");

    // Group by user
    $users = [];
    while ($row = mysqli_fetch_assoc($rs)) {
        $uid = $row['user_id'];
        if (!isset($users[$uid])) {
            $users[$uid] = [
                'user_id'   => $uid,
                'email'     => $row['email'],
                'firstname' => $row['firstname'],
                'lastname'  => $row['lastname'],
                'items'     => [],
            ];
        }
        $users[$uid]['items'][] = [
            'auction_id'            => $row['auction_id'],
            'poster_title'          => $row['poster_title'],
            'poster_image'          => $row['poster_image'],
            'current_highest_bid'   => $row['current_highest_bid'],
            'user_highest_bid'      => $row['user_highest_bid'],
            'auction_actual_end_datetime' => $row['auction_actual_end_datetime'],
        ];
    }
    return array_values($users);
}

function get_week_info($week_id) {
    $week_id = (int)$week_id;
    $rs = mysqli_query($GLOBALS['db_connect'],
        "SELECT * FROM tbl_auction_week WHERE auction_week_id = $week_id LIMIT 1");
    return mysqli_fetch_assoc($rs);
}

function build_email_html($user, $week_info, $subject_intro, $week_link) {
    $name  = htmlspecialchars($user['firstname']);
    $items = $user['items'];
    $end_date_label = date('D, M j \a\t g:i A', strtotime($week_info['auction_week_end_date'])) . ' EDT';

    $items_html = '';
    foreach ($items as $item) {
        $img_url  = $item['poster_image']
            ? CLOUD_POSTER_THUMB_BUY . htmlspecialchars($item['poster_image'])
            : '';
        $img_tag  = $img_url
            ? '<img src="' . $img_url . '" width="130" height="130" alt="" style="display:block;object-fit:cover;border-radius:6px;">'
            : '<div style="width:130px;height:130px;background:#0f3460;border-radius:6px;"></div>';

        $item_url  = 'https://' . HOST_NAME . '/buy.php?mode=poster_details&auction_id=' . (int)$item['auction_id'] . '&live=1';
        $end_fmt   = date('D, M j \a\t g:i A', strtotime($item['auction_actual_end_datetime'])) . ' EDT';

        // Time-left string (computed at send time — emails can't run JS)
        $secs_left = strtotime($item['auction_actual_end_datetime']) - time();
        if ($secs_left > 0) {
            $hours = floor($secs_left / 3600);
            $mins  = floor(($secs_left % 3600) / 60);
            if ($hours >= 24) {
                $days = floor($hours / 24);
                $time_left = $days . ' day' . ($days != 1 ? 's' : '') . ' ' . ($hours % 24) . 'h left';
            } elseif ($hours > 0) {
                $time_left = $hours . 'h ' . $mins . 'm left';
            } else {
                $time_left = $mins . ' min' . ($mins != 1 ? 's' : '') . ' left';
            }
        } else {
            $time_left = 'Ending soon';
        }

        $bid_gap = number_format($item['current_highest_bid'] - $item['user_highest_bid'], 2);

        $items_html .= '
        <div style="margin:0 20px 20px;border:1px solid #e94560;border-radius:10px;overflow:hidden;background:#1a1a2e;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td width="150" style="padding:15px;vertical-align:top;">' . $img_tag . '</td>
              <td style="padding:15px;vertical-align:top;">
                <h3 style="color:#e94560;margin:0 0 10px;font-size:15px;line-height:1.3;">' . htmlspecialchars($item['poster_title']) . '</h3>
                <table cellpadding="3" cellspacing="0" border="0" style="font-size:13px;">
                  <tr>
                    <td style="color:#a8dadc;">Current top bid:</td>
                    <td style="color:#fff;font-weight:bold;padding-left:8px;">$' . number_format($item['current_highest_bid'], 2) . '</td>
                  </tr>
                  <tr>
                    <td style="color:#a8dadc;">Your highest bid:</td>
                    <td style="color:#ffd166;padding-left:8px;">$' . number_format($item['user_highest_bid'], 2) . '</td>
                  </tr>
                  <tr>
                    <td style="color:#a8dadc;">Increase by:</td>
                    <td style="color:#06d6a0;padding-left:8px;">just $' . $bid_gap . ' more</td>
                  </tr>
                </table>
                <p style="margin:10px 0 4px;color:#ff6b6b;font-size:13px;">
                  ⏰ <strong>' . $time_left . '</strong> &nbsp;·&nbsp; Ends ' . $end_fmt . '
                </p>
                <a href="' . $item_url . '"
                   style="display:inline-block;margin-top:10px;background:#e94560;color:#fff;
                          text-decoration:none;padding:9px 20px;border-radius:5px;font-size:13px;
                          font-weight:bold;letter-spacing:.5px;">
                  Bid Now →
                </a>
              </td>
            </tr>
          </table>
        </div>';
    }

    $intro_html = nl2br(htmlspecialchars($subject_intro));

    return '<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#0d0d1a;font-family:Arial,sans-serif;">
<div style="max-width:620px;margin:0 auto;background:#16213e;">

  <!-- header -->
  <div style="background:linear-gradient(135deg,#0f3460,#1a1a4e);padding:30px 20px;text-align:center;">
    <div style="font-size:28px;font-weight:900;color:#e94560;letter-spacing:2px;">KAIJULINK</div>
    <div style="font-size:13px;color:#a8dadc;margin-top:4px;letter-spacing:1px;">MOVIE POSTER AUCTIONS</div>
  </div>

  <!-- urgency banner -->
  <div style="background:#e94560;padding:10px 20px;text-align:center;">
    <span style="color:#fff;font-weight:bold;font-size:14px;">
      ⚡ Don\'t let your favourite posters slip away — auction week closes ' . $end_date_label . '
    </span>
  </div>

  <!-- greeting -->
  <div style="padding:25px 20px 10px;">
    <p style="color:#eee;font-size:15px;margin:0 0 10px;">Hi <strong>' . $name . '</strong>,</p>
    <p style="color:#c8c8d8;font-size:14px;line-height:1.6;margin:0 0 5px;">' . $intro_html . '</p>
    <p style="color:#c8c8d8;font-size:14px;line-height:1.6;margin:0;">
      Here\'s a look at the item' . (count($items) > 1 ? 's' : '') . ' you\'re currently being outbid on:
    </p>
  </div>

  <!-- items -->
  <div style="padding:15px 0;">' . $items_html . '</div>

  <!-- cta -->
  <div style="padding:10px 20px 25px;text-align:center;">
    <a href="' . $week_link . '"
       style="display:inline-block;background:#0f3460;color:#a8dadc;border:1px solid #a8dadc;
              text-decoration:none;padding:10px 28px;border-radius:5px;font-size:13px;">
      Browse All Auction Items
    </a>
  </div>

  <!-- footer -->
  <div style="background:#0a0a1a;padding:20px;text-align:center;border-top:1px solid #1a3a5c;">
    <p style="color:#666;font-size:11px;margin:0;">
      You\'re receiving this because you placed a bid in this auction week.<br>
      &copy; ' . date('Y') . ' Kaijulink &mdash; Movie Poster Auctions
    </p>
  </div>

</div>
</body>
</html>';
}

// ─── pages ────────────────────────────────────────────────────────────────────

function show_form() {
    global $smarty;
    $weeks = get_live_weeks();
    $smarty->assign('weeks', $weeks);
    $smarty->assign('mode', 'form');
    $smarty->display('admin_outbid_reminder.tpl');
}

function show_preview() {
    global $smarty;
    $week_id   = (int)$_REQUEST['week_id'];
    $week_info = get_week_info($week_id);
    if (!$week_info) {
        show_form();
        return;
    }
    $users     = get_losing_bidders($week_id);
    $weeks     = get_live_weeks();

    $default_subject = 'You\'ve been outbid on items you love — act before the auction ends!';
    $default_intro   = "The clock is ticking on this week's Kaijulink auction and you're currently being outbid on items you've already shown interest in. A small increase in your bid could make all the difference — don't let someone else take home your favourite piece of cinema history.";

    $smarty->assign('mode',            'preview');
    $smarty->assign('week_id',         $week_id);
    $smarty->assign('week_info',       $week_info);
    $smarty->assign('weeks',           $weeks);
    $smarty->assign('users',           $users);
    $smarty->assign('default_subject', $default_subject);
    $smarty->assign('default_intro',   $default_intro);
    $smarty->assign('total_recipients', count($users));
    $smarty->assign('total_items',      array_sum(array_map(fn($u) => count($u['items']), $users)));
    $smarty->display('admin_outbid_reminder.tpl');
}

function send_reminders() {
    global $smarty;
    $week_id  = (int)$_POST['week_id'];
    $subject  = trim($_POST['email_subject'] ?? '');
    $intro    = trim($_POST['email_intro']   ?? '');

    if (!$week_id || !$subject || !$intro) {
        $smarty->assign('error', 'Missing required fields.');
        show_form();
        return;
    }

    $week_info = get_week_info($week_id);
    $users     = get_losing_bidders($week_id);

    $week_link = 'https://' . HOST_NAME . '/buy?list=weekly&auction_week_id=' . $week_id;

    $sent = 0;
    $failed = 0;
    $log = [];

    foreach ($users as $user) {
        $html = build_email_html($user, $week_info, $intro, $week_link);
        $ok   = sendMail($user['email'], $user['firstname'] . ' ' . $user['lastname'], $subject, $html);
        if ($ok) {
            $sent++;
            $log[] = ['status' => 'sent',   'name' => $user['firstname'] . ' ' . $user['lastname'], 'email' => $user['email'], 'items' => count($user['items'])];
        } else {
            $failed++;
            $log[] = ['status' => 'failed', 'name' => $user['firstname'] . ' ' . $user['lastname'], 'email' => $user['email'], 'items' => count($user['items'])];
        }
    }

    $weeks = get_live_weeks();
    $smarty->assign('mode',    'result');
    $smarty->assign('sent',    $sent);
    $smarty->assign('failed',  $failed);
    $smarty->assign('log',     $log);
    $smarty->assign('weeks',   $weeks);
    $smarty->display('admin_outbid_reminder.tpl');
}

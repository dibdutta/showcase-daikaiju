{include file="admin_header.tpl"}

<style>
.reminder-card { background:#fff; border:1px solid #ddd; border-radius:8px; margin-bottom:16px; overflow:hidden; }
.reminder-card-header { background:#0f3460; color:#fff; padding:10px 15px; font-weight:bold; font-size:13px; }
.reminder-card-body { display:flex; gap:12px; padding:12px 15px; align-items:flex-start; }
.reminder-card-img img { width:80px; height:80px; object-fit:cover; border-radius:4px; display:block; }
.reminder-card-img .no-img { width:80px; height:80px; background:#eee; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:11px; }
.reminder-card-meta { flex:1; }
.reminder-card-meta h4 { margin:0 0 6px; font-size:13px; color:#333; }
.reminder-card-meta table td { font-size:12px; padding:1px 4px; }
.badge-losing { background:#e94560; color:#fff; font-size:10px; padding:2px 7px; border-radius:10px; vertical-align:middle; }
.badge-sent { background:#28a745; color:#fff; font-size:11px; padding:2px 8px; border-radius:10px; }
.badge-failed { background:#dc3545; color:#fff; font-size:11px; padding:2px 8px; border-radius:10px; }
.preview-email { border:2px dashed #0f3460; border-radius:8px; padding:15px; background:#f8f9fa; margin-bottom:20px; }
.user-accordion { border:1px solid #ccc; border-radius:6px; margin-bottom:10px; }
.user-accordion-header { background:#f0f4f8; padding:10px 15px; cursor:pointer; display:flex; justify-content:space-between; align-items:center; border-radius:6px; }
.user-accordion-header:hover { background:#e0e8f0; }
.user-accordion-body { padding:0 12px 12px; display:none; }
.user-accordion-body.open { display:block; }
.user-accordion.recipient-excluded { opacity:.5; }
.recipient-checkbox { margin-right:10px; vertical-align:middle; }
</style>
<script>
function updateRecipientCount(){
  var checked = document.querySelectorAll('.recipient-checkbox:checked').length;
  var sendBtn = document.getElementById('sendBtn');
  if (sendBtn) {
    sendBtn.value = 'Send Reminders to ' + checked + ' Recipient' + (checked != 1 ? 's' : '');
    sendBtn.disabled = (checked === 0);
  }
  var countLabel = document.getElementById('selectedRecipientCount');
  if (countLabel) { countLabel.textContent = checked; }
}
function toggleAllRecipients(checked){
  var boxes = document.querySelectorAll('.recipient-checkbox');
  for (var i = 0; i < boxes.length; i++) {
    boxes[i].checked = checked;
    boxes[i].closest('.user-accordion').classList.toggle('recipient-excluded', !checked);
  }
  updateRecipientCount();
}
function onRecipientCheckboxChange(cb){
  cb.closest('.user-accordion').classList.toggle('recipient-excluded', !cb.checked);
  updateRecipientCount();
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="100%" align="center">
            <a href="#" onclick="history.back(); return false;" class="action_link"><strong>&lt;&lt; Back</strong></a>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="{$adminActualPath}/admin_manage_auction_week.php?mode=show_all_auction_week" class="action_link">Manage Auction Weeks</a>
          </td>
        </tr>
        <tr>
          <td align="center" class="bold_text" style="padding:8px 0 4px;">Outbid Reminder Email</td>
        </tr>
      </table>

      {* ── Week Selector (always visible) ── *}
      <table width="90%" align="center" border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" style="margin-bottom:14px;">
        <tr class="header_bgcolor" height="28">
          <td colspan="2" class="headertext">&nbsp;Select Live Auction Week</td>
        </tr>
        <tr class="tr_bgcolor">
          <td width="30%" class="bold_text">Live Auction Weeks:</td>
          <td>
            {if $weeks}
            <form method="get" action="{$adminActualPath}/admin_outbid_reminder.php" style="display:inline-flex;gap:8px;align-items:center;flex-wrap:wrap;">
              <input type="hidden" name="mode" value="preview">
              <select name="week_id" style="padding:4px 8px;min-width:320px;">
                {section name=c loop=$weeks}
                  <option value="{$weeks[c].auction_week_id}"
                    {if $week_id == $weeks[c].auction_week_id}selected{/if}>
                    Week #{$weeks[c].auction_week_id}
                    &mdash; {$weeks[c].auction_week_start_date|date_format:"%b %d"} to {$weeks[c].auction_week_end_date|date_format:"%b %d, %Y"}
                    ({$weeks[c].item_count} active items)
                  </option>
                {/section}
              </select>
              <input type="submit" value="Load Preview" class="addbutton">
            </form>
            {else}
              <span style="color:#c00;">No live auction weeks with active items found.</span>
            {/if}
          </td>
        </tr>
      </table>

      {* ── PREVIEW MODE ── *}
      {if $mode == 'preview'}

        <table width="90%" align="center" border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" style="margin-bottom:14px;">
          <tr class="header_bgcolor" height="28">
            <td colspan="2" class="headertext">&nbsp;Email Content &amp; Preview</td>
          </tr>
          <tr class="tr_bgcolor">
            <td colspan="2" style="padding:8px 12px;">
              <span class="bold_text">Week #{$week_id}</span>
              &nbsp;&mdash;&nbsp;
              {$week_info.auction_week_start_date|date_format:"%b %d, %Y"} &rarr; {$week_info.auction_week_end_date|date_format:"%b %d, %Y"}
              &nbsp;&nbsp;
              <span style="background:#0f3460;color:#fff;padding:2px 10px;border-radius:10px;font-size:11px;">
                {$total_recipients} recipient{if $total_recipients != 1}s{/if}
                &nbsp;·&nbsp;
                {$total_items} item{if $total_items != 1}s{/if}
              </span>
            </td>
          </tr>
        </table>

        {if $users}
        <form method="post" action="{$adminActualPath}/admin_outbid_reminder.php" id="reminderForm">
          <input type="hidden" name="mode" value="send">
          <input type="hidden" name="week_id" value="{$week_id}">

          <table width="90%" align="center" border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" style="margin-bottom:16px;">
            <tr class="header_bgcolor" height="28">
              <td colspan="2" class="headertext">&nbsp;Customise Email &mdash; changes apply to every outgoing email</td>
            </tr>
            <tr class="tr_bgcolor">
              <td width="18%" class="bold_text" valign="top" style="padding-top:10px;">Subject Line:</td>
              <td style="padding:6px;">
                <input type="text" name="email_subject" value="{$default_subject}" style="width:96%;padding:6px 8px;font-size:13px;" maxlength="200">
              </td>
            </tr>
            <tr class="tr_bgcolor">
              <td class="bold_text" valign="top" style="padding-top:10px;">Intro Paragraph:</td>
              <td style="padding:6px;">
                <textarea name="email_intro" rows="4" style="width:96%;padding:6px 8px;font-size:13px;">{$default_intro}</textarea>
                <div style="font-size:11px;color:#777;margin-top:3px;">This text appears above the item list in every email. Item-specific details (photo, bids, countdown) are generated automatically per recipient.</div>
              </td>
            </tr>
          </table>

          {* Per-recipient preview *}
          <table width="90%" align="center" border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" style="margin-bottom:16px;">
            <tr class="header_bgcolor" height="28">
              <td class="headertext">
                &nbsp;Recipients Preview — click a row to expand items
                &nbsp;&nbsp;
                <a href="#" onclick="toggleAllRecipients(true); return false;" style="color:#fff;text-decoration:underline;font-weight:normal;">Select All</a>
                &nbsp;|&nbsp;
                <a href="#" onclick="toggleAllRecipients(false); return false;" style="color:#fff;text-decoration:underline;font-weight:normal;">Select None</a>
              </td>
            </tr>
            <tr class="tr_bgcolor">
              <td style="padding:10px 12px;">
                {section name=u loop=$users}
                  {assign var="user" value=$users[u]}
                  <div class="user-accordion">
                    <div class="user-accordion-header">
                      <span>
                        <input type="checkbox" class="recipient-checkbox" name="recipient_ids[]" value="{$user.user_id}" checked
                               onclick="event.stopPropagation(); onRecipientCheckboxChange(this);">
                        <strong>{$user.firstname} {$user.lastname}</strong>
                        &nbsp;&lt;{$user.email}&gt;
                        &nbsp;&nbsp;
                        <span class="badge-losing">{$user.items|@count} item{if $user.items|@count != 1}s{/if}</span>
                      </span>
                      <span style="color:#0f3460;font-size:12px;cursor:pointer;" onclick="this.parentElement.nextElementSibling.classList.toggle('open')">▼ expand</span>
                    </div>
                    <div class="user-accordion-body">
                      {section name=i loop=$user.items}
                        {assign var="item" value=$user.items[i]}
                        <div class="reminder-card" style="margin-top:10px;">
                          <div class="reminder-card-header">
                            Lot #{$item.auction_id} — {$item.poster_title}
                          </div>
                          <div class="reminder-card-body">
                            <div class="reminder-card-img">
                              {if $item.poster_image}
                                <img src="{$smarty.const.CLOUD_POSTER_THUMB_BUY}{$item.poster_image}" alt="">
                              {else}
                                <div class="no-img">No Image</div>
                              {/if}
                            </div>
                            <div class="reminder-card-meta">
                              <h4>{$item.poster_title}</h4>
                              <table border="0" cellpadding="2">
                                <tr>
                                  <td style="color:#555;">Current top bid:</td>
                                  <td><strong style="color:#e94560;">${$item.current_highest_bid|string_format:"%.2f"}</strong></td>
                                </tr>
                                <tr>
                                  <td style="color:#555;">User's highest bid:</td>
                                  <td style="color:#856404;">${$item.user_highest_bid|string_format:"%.2f"}</td>
                                </tr>
                                <tr>
                                  <td style="color:#555;">Auction ends:</td>
                                  <td style="color:#c00;">{$item.auction_actual_end_datetime}</td>
                                </tr>
                              </table>
                            </div>
                          </div>
                        </div>
                      {/section}
                    </div>
                  </div>
                {/section}
              </td>
            </tr>
          </table>

          <table width="90%" align="center" border="0" cellpadding="8" cellspacing="0" style="margin-bottom:30px;">
            <tr>
              <td align="center">
                <input type="button" value="← Change Week" onclick="history.back()" class="cancelbutton">
                &nbsp;&nbsp;
                <input type="submit" id="sendBtn"
                       value="Send Reminders to {$total_recipients} Recipient{if $total_recipients != 1}s{/if}"
                       class="addbutton"
                       onclick="var n = document.querySelectorAll('.recipient-checkbox:checked').length; if(n===0){ alert('Please select at least one recipient.'); return false; } return confirm('Send outbid reminder emails to ' + n + ' recipient(s)?\n\nThis cannot be undone.');">
              </td>
            </tr>
          </table>
        </form>
        <script>updateRecipientCount();</script>

        {else}
          <table width="90%" align="center" border="0" cellpadding="8" cellspacing="1">
            <tr>
              <td align="center" style="padding:30px;color:#555;">
                <strong>No losing bidders found for this auction week.</strong><br>
                Either all bidders are currently winning their items, or no bids have been placed yet.
              </td>
            </tr>
          </table>
        {/if}

      {/if}{* end preview *}

      {* ── RESULT MODE ── *}
      {if $mode == 'result'}
        <table width="90%" align="center" border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" style="margin-bottom:16px;">
          <tr class="header_bgcolor" height="28">
            <td class="headertext">&nbsp;Send Results</td>
          </tr>
          <tr class="tr_bgcolor">
            <td style="padding:12px;">
              <div style="font-size:14px;margin-bottom:10px;">
                <span class="badge-sent">&#10003; {$sent} sent</span>
                &nbsp;
                {if $failed > 0}<span class="badge-failed">&#10007; {$failed} failed</span>{/if}
              </div>
              <table width="100%" border="1" cellpadding="5" cellspacing="0" style="font-size:12px;border-color:#ddd;">
                <tr style="background:#f5f5f5;">
                  <th align="left">Recipient</th>
                  <th align="left">Email</th>
                  <th align="center">Items</th>
                  <th align="center">Status</th>
                </tr>
                {section name=l loop=$log}
                  <tr>
                    <td>{$log[l].name}</td>
                    <td>{$log[l].email}</td>
                    <td align="center">{$log[l].items}</td>
                    <td align="center">
                      {if $log[l].status == 'sent'}
                        <span class="badge-sent">Sent</span>
                      {else}
                        <span class="badge-failed">Failed</span>
                      {/if}
                    </td>
                  </tr>
                {/section}
              </table>
            </td>
          </tr>
        </table>
      {/if}

    </td>
  </tr>
</table>

<script>
// Keep accordion open on the one the user clicked
document.querySelectorAll('.user-accordion-header').forEach(function(h) {
    h.addEventListener('click', function() {
        var arrow = this.querySelector('span:last-child');
        arrow.textContent = this.nextElementSibling.classList.contains('open') ? '▼ expand' : '▲ collapse';
    });
});
</script>

{include file="admin_footer.tpl"}

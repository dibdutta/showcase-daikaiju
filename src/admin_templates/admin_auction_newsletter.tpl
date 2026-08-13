{include file="admin_header.tpl"}

<style>
.nl-section { background:#fff; border:1px solid #ddd; border-radius:5px; padding:18px 20px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.nl-section h3 { font-size:13px; font-weight:700; color:#0f3460; margin:0 0 12px; border-bottom:1px solid #eee; padding-bottom:8px; text-transform:uppercase; letter-spacing:.5px; }
.nl-box-ok  { background:#d4edda; border:1px solid #28a745; color:#155724; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.nl-box-warn{ background:#fff3cd; border:1px solid #ffc107; color:#664d03; border-radius:4px; padding:10px 14px; font-size:13px; margin-bottom:14px; }
.nl-item-grid { display:grid; grid-template-columns:repeat(3, 1fr); gap:12px; }
.nl-item-card { border:1px solid #ddd; border-radius:6px; padding:10px; text-align:center; }
.nl-item-card img { width:100%; max-width:130px; height:130px; object-fit:cover; border-radius:4px; margin:0 auto 8px; display:block; }
.nl-item-card .noimg { width:100%; max-width:130px; height:130px; background:#f0f0f0; border-radius:4px; margin:0 auto 8px; }
.nl-item-title { font-size:12px; font-weight:700; color:#333; margin-bottom:4px; line-height:1.3; }
.nl-item-bid { font-size:11px; color:#c0392b; font-weight:700; }
@media (max-width:600px) { .nl-item-grid { grid-template-columns:repeat(2, 1fr); } }
.nl-copy-btn { background:#0f3460; color:#fff; border:none; padding:7px 16px; font-size:12px; font-weight:700; border-radius:3px; cursor:pointer; }
.nl-copy-btn:hover { background:#1a3a6e; }
.nl-copy-btn.copied { background:#28a745; }
.nl-textarea { width:100%; box-sizing:border-box; font-family:monospace; font-size:11px; padding:10px; border:1px solid #ccc; border-radius:4px; margin-bottom:8px; }
</style>

<script>
function copyFromTextarea(id, btn){
    var el = document.getElementById(id);
    el.select();
    el.setSelectionRange(0, 999999);
    var restore = function(){
        var old = btn.getAttribute('data-label');
        btn.textContent = 'Copied!';
        btn.classList.add('copied');
        setTimeout(function(){ btn.textContent = old; btn.classList.remove('copied'); }, 1500);
    };
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(el.value).then(restore, function(){ document.execCommand('copy'); restore(); });
    } else {
        document.execCommand('copy');
        restore();
    }
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="100%" align="center">
            <a href="#" onclick="history.back(); return false;" class="action_link"><strong>&lt;&lt; Back</strong></a>
          </td>
        </tr>
        <tr>
          <td align="center" class="bold_text" style="padding:8px 0 4px;">Auction Newsletter Template</td>
        </tr>
      </table>

      <div style="max-width:760px;margin:16px auto;">

        <div class="nl-section">
          <h3>How this works</h3>
          <p style="font-size:12px;color:#555;margin:0;">
            This page does not send anything. Edit the content below, copy the generated HTML, and paste it
            into whatever tool you use to send the actual campaign. Copy the recipient list separately —
            it's every unique registered user email address (deduplicated), since newsletter opt-in is now
            covered by Terms &amp; Conditions acceptance at registration rather than a separate checkbox.
          </p>
        </div>

        <form method="get" action="{$adminActualPath}/admin_auction_newsletter.php" id="templateForm">
          <div class="nl-section">
            <h3>Editable Email Content</h3>

            <label style="font-size:11px;font-weight:600;color:#666;display:block;margin-bottom:4px;">Subject Line</label>
            <input type="text" name="email_subject" value="{$email_subject}" style="width:100%;padding:7px 10px;font-size:13px;box-sizing:border-box;margin-bottom:12px;" maxlength="200">

            <label style="font-size:11px;font-weight:600;color:#666;display:block;margin-bottom:4px;">"Ending Soon" Banner Text</label>
            <input type="text" name="ending_text" value="{$ending_text}" style="width:100%;padding:7px 10px;font-size:13px;box-sizing:border-box;margin-bottom:4px;" maxlength="200">
            <div style="font-size:11px;color:#999;margin-bottom:12px;">Leave blank to hide the red banner entirely.</div>

            <label style="font-size:11px;font-weight:600;color:#666;display:block;margin-bottom:4px;">Intro Text (1-2 lines)</label>
            <textarea name="email_intro" rows="3" style="width:100%;padding:7px 10px;font-size:13px;box-sizing:border-box;margin-bottom:12px;">{$email_intro}</textarea>

            <label style="font-size:11px;font-weight:600;color:#666;display:block;margin-bottom:4px;">"See All Items" Button Label</label>
            <input type="text" name="cta_label" value="{$cta_label}" style="width:100%;padding:7px 10px;font-size:13px;box-sizing:border-box;margin-bottom:12px;" maxlength="80">

            <label style="font-size:11px;font-weight:600;color:#666;">Total number of items to feature:</label>
            <select name="item_count" style="padding:4px 8px;margin-left:6px;">
              {section name=n loop=20}
                {assign var="n" value=$smarty.section.n.index+1}
                <option value="{$n}" {if $n == $item_count}selected{/if}>{$n}</option>
              {/section}
            </select>
            <div style="font-size:11px;color:#999;margin-top:4px;">Rendered as a 3-per-row grid (e.g. 15 = 5 full rows, 20 = 7 rows).</div>

            <label style="font-size:11px;font-weight:600;color:#666;display:block;margin-top:14px;margin-bottom:4px;">Always Include These Item IDs</label>
            <input type="text" name="manual_ids" value="{$manual_ids}" style="width:100%;padding:7px 10px;font-size:13px;box-sizing:border-box;" placeholder="e.g. 4821, 4903, 5017">
            <div style="font-size:11px;color:#999;margin-top:4px;">
              Comma or space separated auction IDs. Useful for spotlighting items with no bids yet — these
              are always shown first, and count toward the total above (the rest is filled with popular items).
            </div>
            {if $pinned_count > 0}
              <div class="nl-box-ok" style="margin-top:10px;">{$pinned_count} manually-pinned item{if $pinned_count != 1}s{/if} included.</div>
            {/if}
            {if $invalid_manual_ids}
              <div class="nl-box-warn" style="margin-top:10px;">
                Could not find a live auction for ID{if $invalid_manual_ids|@count != 1}s{/if}:
                {foreach from=$invalid_manual_ids item=iid name=badid}{$iid}{if !$smarty.foreach.badid.last}, {/if}{/foreach}
                — it may be sold, ended, or mistyped.
              </div>
            {/if}

            <div style="margin-top:14px;">
              <input type="submit" value="Refresh Preview" class="addbutton">
            </div>
          </div>
        </form>

        <div class="nl-section">
          <h3>Popular Items Being Featured</h3>
          {if $items}
            <div class="nl-item-grid">
              {foreach from=$items item=it}
              <div class="nl-item-card">
                {if $it.poster_thumb}
                  <img src="{$smarty.const.CLOUD_POSTER_THUMB_BUY_GALLERY}{$it.poster_thumb}" alt="">
                {else}
                  <div class="noimg"></div>
                {/if}
                <div class="nl-item-title">{$it.poster_title}</div>
                <div class="nl-item-bid">${$it.max_bid_amount|string_format:"%.2f"}</div>
              </div>
              {/foreach}
            </div>
          {else}
            <p style="font-size:12px;color:#999;">No currently live auction items found to feature.</p>
          {/if}
        </div>

        <div class="nl-section">
          <h3>Rendered Preview</h3>
          <iframe srcdoc="{$rendered_html|escape:'html'}" style="width:100%;height:600px;border:1px solid #ddd;border-radius:4px;"></iframe>
        </div>

        <div class="nl-section">
          <h3>Email HTML Source (copy into your send tool)</h3>
          <textarea id="htmlSource" class="nl-textarea" rows="10" readonly onclick="this.select();">{$rendered_html}</textarea>
          <button type="button" class="nl-copy-btn" data-label="Copy HTML" onclick="copyFromTextarea('htmlSource', this)">Copy HTML</button>
        </div>

        <div class="nl-section">
          <h3>Recipients</h3>
          <div class="nl-box-ok">{$total_recipients} unique email address{if $total_recipients != 1}es{/if} found across all registered users.</div>
          <textarea id="emailList" class="nl-textarea" rows="8" readonly onclick="this.select();">{foreach from=$recipient_emails item=em name=el}{$em}{if !$smarty.foreach.el.last}, {/if}{/foreach}</textarea>
          <button type="button" class="nl-copy-btn" data-label="Copy All Emails" onclick="copyFromTextarea('emailList', this)">Copy All Emails</button>
          <div style="font-size:11px;color:#999;margin-top:8px;">Comma-separated — ready to paste into a BCC field or your ESP's recipient import.</div>
        </div>

      </div>

    </td>
  </tr>
</table>
{include file="admin_footer.tpl"}

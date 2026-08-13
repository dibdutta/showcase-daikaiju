{include file="admin_header.tpl"}

<style>
.ns-section { background:#fff; border:1px solid #ddd; border-radius:5px; padding:18px 20px; margin-bottom:18px; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.ns-section h3 { font-size:13px; font-weight:700; color:#0f3460; margin:0 0 12px; border-bottom:1px solid #eee; padding-bottom:8px; text-transform:uppercase; letter-spacing:.5px; }
.ns-kpi-row { display:flex; gap:14px; flex-wrap:wrap; }
.ns-kpi { flex:1; min-width:140px; border:1px solid #eee; border-radius:6px; padding:14px; text-align:center; }
.ns-kpi .num { font-size:22px; font-weight:700; color:#0f3460; }
.ns-kpi .label { font-size:11px; color:#777; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }
.ns-table { width:100%; border-collapse:collapse; font-size:12px; }
.ns-table th { background:#f5f5f5; text-align:left; padding:6px 8px; border-bottom:2px solid #ddd; }
.ns-table td { padding:6px 8px; border-bottom:1px solid #eee; }
.ns-box-info { background:#e7f1ff; border:1px solid #b6d4fe; color:#084298; border-radius:4px; padding:10px 14px; font-size:12px; margin-bottom:14px; }
</style>

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
          <td align="center" class="bold_text" style="padding:8px 0 4px;">Newsletter Click Stats</td>
        </tr>
      </table>

      <div style="max-width:820px;margin:16px auto;">

        <div class="ns-box-info">
          Emails only appear here when the clicker happened to already be logged into the site at the moment
          they clicked — the newsletter is sent as one identical email, so anonymous clicks (not logged in)
          are counted but can't be attributed to a specific address.
        </div>

        {if $campaigns}
        <div class="ns-section">
          <h3>Campaign</h3>
          <form method="get" action="{$adminActualPath}/admin_newsletter_stats.php">
            <select name="campaign" onchange="this.form.submit();" style="padding:5px 8px;">
              {foreach from=$campaigns item=c}
                <option value="{$c.campaign}" {if $c.campaign == $selected_campaign}selected{/if}>{$c.campaign} ({$c.clicks} clicks, last {$c.last_click})</option>
              {/foreach}
            </select>
          </form>
        </div>
        {/if}

        <div class="ns-section">
          <h3>Summary{if $selected_campaign} &mdash; {$selected_campaign}{/if}</h3>
          <div class="ns-kpi-row">
            <div class="ns-kpi"><div class="num">{$total_clicks}</div><div class="label">Total Clicks</div></div>
            <div class="ns-kpi"><div class="num">{$identified_clicks}</div><div class="label">Identified Clicks</div></div>
            <div class="ns-kpi"><div class="num">{$anonymous_clicks}</div><div class="label">Anonymous Clicks</div></div>
            <div class="ns-kpi"><div class="num">{$unique_emails}</div><div class="label">Unique Emails Seen</div></div>
          </div>
        </div>

        <div class="ns-section">
          <h3>Clicks by Item / Button</h3>
          {if $item_stats}
            <table class="ns-table">
              <tr><th>Item</th><th>Total Clicks</th><th>Unique Emails</th></tr>
              {foreach from=$item_stats item=row}
                <tr>
                  <td>{$row.label}</td>
                  <td>{$row.clicks}</td>
                  <td>{$row.unique_emails}</td>
                </tr>
              {/foreach}
            </table>
          {else}
            <p style="font-size:12px;color:#999;">No clicks recorded yet{if $selected_campaign} for this campaign{/if}.</p>
          {/if}
        </div>

        <div class="ns-section">
          <h3>Identified Clicks (logged-in visitors, most recent 300)</h3>
          {if $identified_log}
            <table class="ns-table">
              <tr><th>Email</th><th>Item</th><th>Clicked At</th></tr>
              {foreach from=$identified_log item=row}
                <tr>
                  <td>{$row.email}</td>
                  <td>{$row.label}</td>
                  <td>{$row.clicked_at}</td>
                </tr>
              {/foreach}
            </table>
          {else}
            <p style="font-size:12px;color:#999;">No identified clicks yet.</p>
          {/if}
        </div>

      </div>

    </td>
  </tr>
</table>
{include file="admin_footer.tpl"}

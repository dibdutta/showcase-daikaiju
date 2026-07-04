{include file="header.tpl"}

<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{$actualPathJSCSS}css/jquery.fancybox.css?v=2.1.5" media="screen" />
<style>
.fancybox-overlay { z-index: 200000 !important; }
.fancybox-wrap    { z-index: 200001 !important; }

.inv-page { padding: 20px 0 40px; }

/* ── Tab nav ────────────────────────────────────────── */
.inv-tabs { display: flex; gap: 0; border-bottom: 2px solid #e0e0e0; margin-bottom: 20px; flex-wrap: wrap; }
.inv-tabs a {
    display: inline-block; padding: 9px 18px; font-size: 12px; font-weight: 600;
    color: #666; text-decoration: none; border-bottom: 2px solid transparent;
    margin-bottom: -2px; transition: color .15s, border-color .15s; white-space: nowrap;
}
.inv-tabs a:hover { color: #bd1a21; }
.inv-tabs a.active { color: #bd1a21; border-bottom-color: #bd1a21; }

/* ── Card ───────────────────────────────────────────── */
.inv-card { background: #fff; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; }
.inv-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1px solid #f0f0f0; flex-wrap: wrap; gap: 10px;
}
.inv-card-head h2 {
    font-size: 13px; font-weight: 700; color: #1a1a1a; margin: 0;
    border: none; padding: 0; text-transform: uppercase; letter-spacing: .5px;
}
.inv-card-head-note { font-size: 11px; color: #999; }

/* ── Info banner ────────────────────────────────────── */
.inv-info-banner {
    display: flex; align-items: flex-start; gap: 10px;
    background: #f0f6ff; border-bottom: 1px solid #d0e4ff;
    padding: 11px 18px; font-size: 11px; color: #1a3a6e; line-height: 1.55;
}
.inv-info-banner svg { fill: #1a3a6e; width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }

/* ── Table ──────────────────────────────────────────── */
.inv-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.inv-table thead tr { background: #f8f8f8; border-bottom: 2px solid #e8e8e8; }
.inv-table th {
    padding: 10px 12px; text-align: left; font-size: 11px; font-weight: 700;
    color: #777; text-transform: uppercase; letter-spacing: .5px; white-space: nowrap;
}
.inv-table th.tac { text-align: center; }
.inv-table th.tar { text-align: right; }
.inv-table tbody tr { border-bottom: 1px solid #f2f2f2; transition: background .12s; }
.inv-table tbody tr:last-child { border-bottom: none; }
.inv-table tbody tr:hover { background: #fafafa; }
.inv-table td { padding: 12px 12px; vertical-align: middle; color: #333; }
.inv-table td.tac { text-align: center; }
.inv-table td.tar { text-align: right; }

.inv-num { font-size: 11px; color: #aaa; font-weight: 600; text-align: center; }
.inv-title { font-size: 12px; color: #222; font-weight: 600; line-height: 1.5; }
.inv-title-sku { font-size: 10px; color: #aaa; font-weight: 400; margin-left: 4px; }
.inv-title-sub { display: block; font-size: 11px; color: #999; font-weight: 400; margin-top: 1px; }
.inv-date { font-size: 11px; color: #888; white-space: nowrap; text-align: center; }
.inv-date-label { display: block; font-size: 10px; color: #bbb; margin-top: 1px; }
.inv-amount { font-size: 13px; font-weight: 700; color: #1a1a1a; text-align: right; white-space: nowrap; }

/* ── Badges ─────────────────────────────────────────── */
.inv-badge {
    display: inline-block; padding: 3px 9px; border-radius: 20px;
    font-size: 10px; font-weight: 700; letter-spacing: .4px;
    text-transform: uppercase; white-space: nowrap;
}
.inv-badge-paid     { background: #d4edda; color: #155724; }
.inv-badge-approved { background: #fff3cd; color: #856404; }

/* ── Row actions ────────────────────────────────────── */
.inv-row-actions { display: flex; align-items: center; justify-content: center; gap: 6px; }
.inv-print-btn {
    display: inline-flex; align-items: center; gap: 4px; padding: 5px 11px;
    border: 1px solid #ddd; color: #555; font-size: 11px; font-weight: 600;
    text-decoration: none; border-radius: 3px; background: #fff;
    white-space: nowrap; transition: background .15s, color .15s;
}
.inv-print-btn:hover { background: #f5f5f5; color: #333; }
.inv-print-btn svg { fill: currentColor; width: 12px; height: 12px; flex-shrink: 0; }

/* ── Empty state ────────────────────────────────────── */
.inv-empty { text-align: center; padding: 50px 20px; }
.inv-empty svg { fill: #ddd; width: 48px; height: 48px; margin: 0 auto 14px; display: block; }
.inv-empty p { font-size: 13px; color: #aaa; margin: 0; }

/* ── Alert ──────────────────────────────────────────── */
.inv-alert {
    margin: 0 18px 14px; padding: 10px 14px; border-radius: 4px;
    font-size: 12px; border: 1px solid #f5c6cb; background: #f8d7da; color: #721c24;
}
</style>

{literal}
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '.inv-print-btn', function (e) {
        e.preventDefault();
        $.fancybox.open({
            href        : this.href,
            type        : 'iframe',
            width       : 900,
            height      : 600,
            autoScale   : true,
            transitionIn : 'none',
            transitionOut: 'none',
            closeBtn    : true
        });
    });
});
</script>
{/literal}

<div id="forinnerpage-container">
    <div id="wrapper">
        <div id="headerthemepanel"></div>
        <div id="inner-container2">
        <div id="center"><div id="squeeze"><div class="right-corner">
        <div id="inner-left-container">

            <div class="innerpage-container-main inv-page">

                {* ── Tab navigation ───────────────────────── *}
                <div class="inv-tabs">
                    <a href="{$actualPath}/my_invoice">My Invoices</a>
                    <a href="{$actualPath}/my_invoice?mode=archive_invoice">Archived Invoices</a>
                    <a href="{$actualPath}/my_invoice?mode=buyer" class="active">Seller Reconciliation</a>
                </div>

                {* ── Main card ────────────────────────────── *}
                <div class="inv-card">

                    <div class="inv-card-head">
                        <h2>Seller Reconciliation</h2>
                        <span class="inv-card-head-note">Items you have sold and their payment status</span>
                    </div>

                    <div class="inv-info-banner">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        <span>This view shows invoices for items you listed as a seller. <strong>Approved</strong> means the buyer's invoice is confirmed but payment is pending. <strong>Paid</strong> means the buyer has completed payment and KaijuLink will process your payout minus commission.</span>
                    </div>

                    {if $errorMessage != ""}
                        <div class="inv-alert">{$errorMessage}</div>
                    {/if}

                    {if $total > 0}
                    <form name="listFrom" id="listForm" action="" method="post">
                        <input type="hidden" name="encoded_string" value="{$encoded_string}">
                        <table class="inv-table">
                            <thead>
                                <tr>
                                    <th class="tac" style="width:40px;">#</th>
                                    <th>Item(s)</th>
                                    <th class="tac" style="width:110px;">Date</th>
                                    <th class="tar" style="width:90px;">Amount</th>
                                    <th class="tac" style="width:90px;">Status</th>
                                    <th class="tac" style="width:80px;">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                            {section name=counter loop=$invoiceData}
                            <tr>
                                {* Row number *}
                                <td class="inv-num">{$smarty.section.counter.index+1}</td>

                                {* Item titles + SKUs *}
                                <td>
                                    <div class="inv-title">
                                    {section name=adCounter loop=$invoiceData[counter].auction_details}
                                        {$invoiceData[counter].auction_details[adCounter].poster_title|stripslashes}
                                        {if $invoiceData[counter].auction_details[adCounter].poster_sku != ''}
                                            <span class="inv-title-sku">#{$invoiceData[counter].auction_details[adCounter].poster_sku}</span>
                                        {/if}
                                        {if $invoiceData[counter].auction_details|@count > 1}<br>{/if}
                                    {/section}
                                    <span class="inv-title-sub">Invoice #{$invoiceData[counter].invoice_id}</span>
                                    </div>
                                </td>

                                {* Date — paid_on if paid, approved_on if awaiting *}
                                <td class="inv-date">
                                    {if $invoiceData[counter].is_paid == '1'}
                                        {$invoiceData[counter].paid_on|date_format:"%b %d, %Y"}
                                        <span class="inv-date-label">Paid on</span>
                                    {else}
                                        {$invoiceData[counter].approved_on|date_format:"%b %d, %Y"}
                                        <span class="inv-date-label">Approved on</span>
                                    {/if}
                                </td>

                                {* Amount *}
                                <td class="inv-amount">${$invoiceData[counter].total_amount}</td>

                                {* Status badge *}
                                <td class="tac">
                                    {if $invoiceData[counter].is_paid == '1'}
                                        <span class="inv-badge inv-badge-paid">Paid</span>
                                    {else}
                                        <span class="inv-badge inv-badge-approved">Approved</span>
                                    {/if}
                                </td>

                                {* View invoice *}
                                <td>
                                    <div class="inv-row-actions">
                                        <a href="{$actualPath}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"
                                           class="inv-print-btn">
                                            <svg viewBox="0 0 24 24"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            {/section}
                            </tbody>
                        </table>
                    </form>

                    {else}
                    <div class="inv-empty">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                        <p>No seller invoices to display. Items you sell will appear here once invoiced.</p>
                    </div>
                    {/if}

                </div>{* .inv-card *}

            </div>
        </div>
        </div></div></div>
        </div>
    </div>
</div>
{include file="foot.tpl"}

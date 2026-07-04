{include file="header.tpl"}

<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="{$actualPathJSCSS}js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{$actualPathJSCSS}css/jquery.fancybox.css?v=2.1.5" media="screen" />
<style>
.fancybox-overlay { z-index: 200000 !important; }
.fancybox-wrap    { z-index: 200001 !important; }

/* ── Page shell ─────────────────────────────────────── */
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
.inv-card-head-note {
    font-size: 11px; color: #999;
}

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
.inv-title span { display: block; font-size: 11px; color: #999; font-weight: 400; }
.inv-date { font-size: 11px; color: #888; white-space: nowrap; text-align: center; }
.inv-amount { font-size: 13px; font-weight: 700; color: #1a1a1a; text-align: right; white-space: nowrap; }

/* ── Badges ─────────────────────────────────────────── */
.inv-badge {
    display: inline-block; padding: 3px 9px; border-radius: 20px;
    font-size: 10px; font-weight: 700; letter-spacing: .4px;
    text-transform: uppercase; white-space: nowrap;
}
.inv-badge-paid      { background: #d4edda; color: #155724; }
.inv-badge-unpaid    { background: #fff3cd; color: #856404; }
.inv-badge-cancelled { background: #f8d7da; color: #721c24; }
.inv-badge-ordered   { background: #d1ecf1; color: #0c5460; }
.inv-badge-archived  { background: #e9e9e9; color: #555; }

/* ── Row actions ────────────────────────────────────── */
.inv-row-actions { display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap; }
.inv-pay-btn {
    display: inline-block; padding: 5px 13px; background: #bd1a21; color: #fff;
    font-size: 11px; font-weight: 700; text-decoration: none; border-radius: 3px;
    text-transform: uppercase; letter-spacing: .3px; white-space: nowrap; transition: background .15s;
}
.inv-pay-btn:hover { background: #9e1519; color: #fff; }
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
.inv-empty p { font-size: 13px; color: #aaa; margin: 0 0 16px; }
.inv-empty a {
    display: inline-block; padding: 8px 20px; background: #bd1a21; color: #fff;
    font-size: 12px; font-weight: 700; text-decoration: none; border-radius: 3px;
    text-transform: uppercase; letter-spacing: .4px;
}
.inv-empty a:hover { background: #9e1519; }

/* ── Alert ──────────────────────────────────────────── */
.inv-alert {
    margin: 0 18px 14px; padding: 10px 14px; border-radius: 4px;
    font-size: 12px; border: 1px solid #f5c6cb; background: #f8d7da; color: #721c24;
}
</style>

{literal}
<script type="text/javascript">
function fancy_images(i) {
    $.fancybox.open({
        'href'         : $("#various_" + i).attr('href'),
        'type'         : 'iframe',
        'width'        : 900,
        'height'       : 600,
        'autoScale'    : true,
        'transitionIn' : 'none',
        'transitionOut': 'none',
        'closeBtn'     : true
    });
    return false;
}
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
                    <a href="{$actualPath}/my_invoice?mode=archive_invoice" class="active">Archived Invoices</a>
                    <a href="{$actualPath}/my_invoice?mode=buyer">Seller Reconciliation</a>
                </div>

                {* ── Main card ────────────────────────────── *}
                <div class="inv-card">

                    <div class="inv-card-head">
                        <h2>Archived Invoices</h2>
                        <span class="inv-card-head-note">Paid invoices you have moved to the archive</span>
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
                                    <th class="tac" style="width:100px;">Date</th>
                                    <th class="tar" style="width:90px;">Amount</th>
                                    <th class="tac" style="width:90px;">Status</th>
                                    <th class="tac" style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            {section name=counter loop=$invoiceData}
                            <tr>
                                {* Row number *}
                                <td class="inv-num">{$smarty.section.counter.index+1}</td>

                                {* Item titles *}
                                <td>
                                    <div class="inv-title">
                                    {section name=adCounter loop=$invoiceData[counter].auction_details}
                                        {$invoiceData[counter].auction_details[adCounter].poster_title|stripslashes}
                                        {if $invoiceData[counter].auction_details|@count > 1}<br>{/if}
                                    {/section}
                                    <span>Invoice #{$invoiceData[counter].invoice_id}</span>
                                    </div>
                                </td>

                                {* Date *}
                                <td class="inv-date">{$invoiceData[counter].invoice_generated_on|date_format:"%b %d, %Y"}</td>

                                {* Amount *}
                                <td class="inv-amount">${$invoiceData[counter].total_amount}</td>

                                {* Status badge *}
                                <td class="tac">
                                    {if $invoiceData[counter].is_cancelled == '1'}
                                        <span class="inv-badge inv-badge-cancelled">Cancelled</span>
                                    {elseif $invoiceData[counter].is_paid == '1'}
                                        <span class="inv-badge inv-badge-paid">Paid</span>
                                    {elseif $invoiceData[counter].is_ordered == '1'}
                                        <span class="inv-badge inv-badge-ordered">Phone Order</span>
                                    {else}
                                        <span class="inv-badge inv-badge-archived">Archived</span>
                                    {/if}
                                </td>

                                {* Action *}
                                <td>
                                    <div class="inv-row-actions">
                                    {if $invoiceData[counter].is_paid == '0' && $invoiceData[counter].is_cancelled == '0' && $invoiceData[counter].is_ordered == '0'}
                                        <a href="{$actualPath}/my_invoice?mode=order&invoice_id={$invoiceData[counter].invoice_id}" class="inv-pay-btn">Pay Now</a>
                                    {/if}
                                    <a id="various_{$smarty.section.counter.index}"
                                       href="{$actualPath}/my_invoice?mode=print&invoice_id={$invoiceData[counter].invoice_id}"
                                       onclick="return fancy_images({$smarty.section.counter.index})"
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
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.54 5.23l-1.39-1.68C18.88 3.21 18.47 3 18 3H6c-.47 0-.88.21-1.16.55L3.46 5.23C3.17 5.57 3 6.02 3 6.5V19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6.5c0-.48-.17-.93-.46-1.27zM12 17.5L6.5 12H10v-2h4v2h3.5L12 17.5zM5.12 5l.81-1h12l .94 1H5.12z"/></svg>
                        <p>No archived invoices yet. Paid invoices can be moved here from your main invoice list.</p>
                        <a href="{$actualPath}/my_invoice">View Active Invoices</a>
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

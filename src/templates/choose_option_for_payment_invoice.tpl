{include file="header.tpl"}
<div id="forinnerpage-container">
  <div id="wrapper">
    <div id="headerthemepanel">
      {include file="search-login.tpl"}
    </div>

    <div id="inner-container">
      {include file="right-panel.tpl"}
      <div id="center"><div id="squeeze"><div class="right-corner">
        <div id="inner-left-container">
          <div class="innerpage-container-main">
            <div class="innerpage-container-main">

              <div class="dashboard-main">
                <h1>Choose Payment Method</h1>
              </div>

              <div class="left-midbg">
              <div class="right-midbg">
              <div class="mid-rept-bg">
                <div class="inner-area-general" style="max-width:560px; padding:24px; font-family:Arial,sans-serif;">

                  <!-- PayPal Expanded Checkout (REST v2 — recommended) -->
                  <div style="border:2px solid #0070ba; border-radius:6px; padding:20px 22px; margin-bottom:18px; background:#f8fbff;">
                    <div style="font-size:14px; font-weight:700; color:#003087; margin-bottom:6px;">
                      Pay with PayPal
                    </div>
                    <div style="font-size:12px; color:#555; margin-bottom:16px;">
                      Pay securely using your PayPal account, Venmo, Pay Later, or a debit/credit card — all on one checkout page.
                    </div>
                    <a href="{$actualPath}/my_invoice?mode=do_paypal_v2&invoice_id={$smarty.request.invoice_id}"
                       style="display:inline-block; background:#0070ba; color:#fff; text-decoration:none; padding:10px 28px; border-radius:4px; font-size:13px; font-weight:700; letter-spacing:.4px;">
                      Proceed to PayPal Checkout &rarr;
                    </a>
                  </div>

                  <!-- Legacy Express Checkout (fallback) -->
                  <div style="border:1px solid #ddd; border-radius:6px; padding:16px 22px; background:#fafafa;">
                    <div style="font-size:12px; font-weight:600; color:#666; margin-bottom:8px;">
                      Classic PayPal Express (legacy)
                    </div>
                    <a href="{$actualPath}/my_invoice?mode=do_express_checkout&invoice_id={$smarty.request.invoice_id}"
                       style="display:inline-block; font-size:12px; color:#0070ba; text-decoration:underline;">
                      Use legacy PayPal Express Checkout
                    </a>
                  </div>

                </div>
              </div>
              </div>
              </div>

            </div>
          </div>
        </div>
      </div></div></div>
    </div>
    {include file="gavelsnipe.tpl"}
  </div>
  <div class="clear"></div>
</div>
{include file="foot.tpl"}

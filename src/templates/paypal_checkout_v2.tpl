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
                <h1>Complete Your Payment</h1>
              </div>

              {if $errorMessage != ""}
              <div class="messageBox">{$errorMessage}</div>
              {/if}

              <div class="left-midbg">
              <div class="right-midbg">
              <div class="mid-rept-bg" style="display:flex; justify-content:center; width:100%;">
                <div class="inner-area-general" style="max-width:580px; padding:20px; width:100%;">

                  <!-- Order summary -->
                  <div style="background:#f9f9f9; border:1px solid #ddd; border-radius:4px; padding:14px 18px; margin-bottom:22px; font-family:Arial,sans-serif; font-size:13px;">
                    <div style="font-weight:700; font-size:14px; margin-bottom:8px; color:#222;">Order Summary — Invoice #{$invoice_id}</div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                      <span>Items Total</span><span>${$base_amount|string_format:"%.2f"}</span>
                    </div>
                    {if $shipping_charge > 0}
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                      <span>Shipping</span><span>${$shipping_charge|string_format:"%.2f"}</span>
                    </div>
                    {/if}
                    {if $sale_tax > 0}
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                      <span>Tax</span><span>${$sale_tax|string_format:"%.2f"}</span>
                    </div>
                    {/if}
                    <div style="display:flex; justify-content:space-between; font-weight:700; font-size:15px; border-top:1px solid #ddd; padding-top:8px; margin-top:6px; color:#bd1a21;">
                      <span>Total</span><span>${$total_amount|string_format:"%.2f"}</span>
                    </div>
                  </div>

                  <!-- PayPal smart buttons (PayPal / Venmo / Pay Later auto-shown by eligibility) -->
                  <div id="paypal-button-container" style="margin-bottom:18px;"></div>

                  <!-- Divider shown only when hosted fields are available -->
                  <div id="card-divider" style="display:none; text-align:center; margin:18px 0; font-family:Arial,sans-serif; font-size:12px; color:#888;">
                    <span style="background:#fff; padding:0 12px; position:relative; z-index:1;">— OR PAY WITH CARD —</span>
                    <hr style="border:none; border-top:1px solid #ddd; margin-top:-8px;">
                  </div>

                  <!-- Hosted card fields (only rendered when PayPal Advanced Payments is enabled) -->
                  <div id="card-form" style="display:none; font-family:Arial,sans-serif;">
                    <div style="margin-bottom:12px;">
                      <label style="display:block; font-size:12px; color:#555; margin-bottom:4px; font-weight:600;">Card Number</label>
                      <div id="card-number-field-container" class="pp-hosted-field" style="height:55px; border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;"></div>
                    </div>
                    <div style="display:flex; gap:12px; margin-bottom:12px;">
                      <div style="flex:1;">
                        <label style="display:block; font-size:12px; color:#555; margin-bottom:4px; font-weight:600;">Expiry Date</label>
                        <div id="expiry-field-container" class="pp-hosted-field" style="height:55px; border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;"></div>
                      </div>
                      <div style="flex:1;">
                        <label style="display:block; font-size:12px; color:#555; margin-bottom:4px; font-weight:600;">CVV</label>
                        <div id="cvv-field-container" class="pp-hosted-field" style="height:55px; border:1px solid #ccc; border-radius:4px; overflow:hidden; background:#fff;"></div>
                      </div>
                    </div>
                    <button id="card-submit-btn" type="button" style="width:100%; background:#0070ba; color:#fff; border:none; border-radius:4px; padding:12px; font-size:14px; font-weight:700; cursor:pointer; letter-spacing:.5px;">
                      Pay ${$total_amount|string_format:"%.2f"} with Card
                    </button>
                    <div id="card-error" style="display:none; color:#bd1a21; font-size:12px; margin-top:8px; text-align:center;"></div>
                  </div>

                  <!-- Fastlane placeholder (requires PayPal partnership enrollment) -->
                  <div id="fastlane-container" style="display:none;"></div>

                  <!-- Cancel link -->
                  <div style="text-align:center; margin-top:22px;">
                    <a href="{$actualPath}/my_invoice?mode=order&invoice_id={$invoice_id}" style="font-size:12px; color:#888;">Cancel and return to invoice</a>
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

<!-- PayPal JS SDK v6: card-fields replaces deprecated hosted-fields -->
<script src="https://www.paypal.com/sdk/js?client-id={$paypal_client_id}&currency=USD&components=buttons,card-fields&intent=capture"></script>

<!-- Expose Smarty-rendered values as plain JS vars before the literal block -->
<script>
var _pp = {
  invoiceId:  {$invoice_id},
  endpoint:   '{$actualPath}/paypal_orders.php',
  returnUrl:  '{$actualPath}/my_invoice',
  totalLabel: 'Pay ${$total_amount|string_format:"%.2f"} with Card'
};
</script>

{literal}
<script>
(function (pp) {
  function apiCall(params) {
    return fetch(pp.endpoint, {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams(params).toString()
    }).then(function (r) { return r.json(); });
  }

  function showCardError(msg) {
    var el = document.getElementById('card-error');
    el.textContent = msg;
    el.style.display = 'block';
  }

  // ── Smart Buttons (PayPal / Venmo / Pay Later shown by SDK based on eligibility) ─
  paypal.Buttons({
    style: {layout: 'vertical', color: 'gold', shape: 'rect', label: 'paypal'},

    createOrder: function () {
      return apiCall({action: 'create_order', invoice_id: pp.invoiceId})
        .then(function (data) {
          if (data.error) { alert('Error: ' + data.error); throw new Error(data.error); }
          return data.id;
        });
    },

    onApprove: function (data) {
      return apiCall({action: 'capture_order', order_id: data.orderID, invoice_id: pp.invoiceId})
        .then(function (result) {
          if (result.success) {
            window.location.href = pp.returnUrl;
          } else {
            alert('Payment failed: ' + (result.error || 'Unknown error'));
          }
        });
    },

    onError: function (err) {
      console.error('PayPal Buttons error', err);
      alert('A payment error occurred. Please try again or contact support.');
    }
  }).render('#paypal-button-container');

  // ── Card Fields (PayPal JS SDK v6 — replaces deprecated HostedFields) ─
  if (paypal.CardFields) {
    var cardField = paypal.CardFields({
      createOrder: function () {
        return apiCall({action: 'create_order', invoice_id: pp.invoiceId})
          .then(function (data) {
            if (!data.id) { throw new Error(data.error || 'Order creation failed'); }
            return data.id;
          });
      },
      onApprove: function (data) {
        return apiCall({action: 'capture_order', order_id: data.orderID, invoice_id: pp.invoiceId})
          .then(function (result) {
            if (result.success) {
              window.location.href = pp.returnUrl;
            } else {
              showCardError(result.error || 'Payment failed. Please try again.');
            }
          });
      },
      onError: function (err) {
        console.error('CardFields error', err);
        showCardError('Card payment failed. Please check your details and try again.');
        var btn = document.getElementById('card-submit-btn');
        btn.disabled    = false;
        btn.textContent = pp.totalLabel;
      }
    });

    if (cardField.isEligible()) {
      document.getElementById('card-divider').style.display = 'block';
      document.getElementById('card-form').style.display    = 'block';

      cardField.NumberField({placeholder: '•••• •••• •••• ••••'}).render('#card-number-field-container');
      cardField.ExpiryField({placeholder: 'MM / YY'}).render('#expiry-field-container');
      cardField.CVVField({placeholder: 'CVV'}).render('#cvv-field-container');

      document.getElementById('card-submit-btn').addEventListener('click', function () {
        document.getElementById('card-error').style.display = 'none';
        var btn = this;
        btn.disabled    = true;
        btn.textContent = 'Processing…';

        cardField.submit().catch(function (err) {
          console.error('Card submit error', err);
          showCardError('Card payment failed. Please check your details and try again.');
          btn.disabled    = false;
          btn.textContent = pp.totalLabel;
        });
      });
    }
  }
}(_pp));
</script>
{/literal}

{include file="foot.tpl"}

{include file="header.tpl"}

<style>
/* ── Page shell ─────────────────────────────────────────── */
.reg-page { padding: 24px 0 48px; }

/* ── Hero ───────────────────────────────────────────────── */
.reg-hero {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    border-radius: 6px 6px 0 0;
    padding: 22px 28px 18px;
    display: flex; align-items: center; gap: 14px;
}
.reg-hero svg { fill: rgba(255,255,255,0.85); width: 26px; height: 26px; flex-shrink: 0; }
.reg-hero-text h1 { margin: 0; font-size: 17px; font-weight: 700; color: #fff; }
.reg-hero-text p  { margin: 3px 0 0; font-size: 11px; color: rgba(255,255,255,0.75); }

/* ── Card ───────────────────────────────────────────────── */
.reg-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 20px;
}

/* ── Section header ─────────────────────────────────────── */
.reg-section-head {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 24px; background: #f8f8f8;
    border-bottom: 1px solid #ebebeb;
    border-top: 1px solid #ebebeb;
}
.reg-section-head:first-of-type { border-top: none; }
.reg-section-head svg { fill: #bd1a21; width: 15px; height: 15px; flex-shrink: 0; }
.reg-section-head span { font-size: 11px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: .5px; }

/* ── Form body ──────────────────────────────────────────── */
.reg-body { padding: 20px 24px 24px; }

/* ── Grid ───────────────────────────────────────────────── */
.reg-grid   { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px 20px; }
.reg-grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px 20px; }
.reg-span2  { grid-column: span 2; }
.reg-span3  { grid-column: span 3; }

/* ── Fields ─────────────────────────────────────────────── */
.reg-field { display: flex; flex-direction: column; }
.reg-field label {
    font-size: 11px; font-weight: 700; color: #555;
    margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;
}
.reg-field label .req { color: #bd1a21; margin-left: 2px; }
.reg-input, .reg-select {
    width: 100%; box-sizing: border-box;
    border: 1px solid #d0d0d0; border-radius: 4px;
    padding: 9px 12px; font-size: 12px; color: #333;
    font-family: inherit; background: #fff;
    transition: border-color .15s, box-shadow .15s; outline: none;
}
.reg-input:focus, .reg-select:focus {
    border-color: #bd1a21;
    box-shadow: 0 0 0 3px rgba(189,26,33,0.08);
}
.reg-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23999'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; }
.reg-hint { font-size: 10px; color: #999; margin-top: 3px; }
.reg-err  { font-size: 11px; color: #bd1a21; margin-top: 4px; }

/* ── Alert ──────────────────────────────────────────────── */
.reg-alert {
    margin: 0 24px 16px; padding: 10px 14px; border-radius: 4px;
    font-size: 12px; border: 1px solid #f5c6cb;
    background: #f8d7da; color: #721c24;
}

/* ── Same-as-billing ────────────────────────────────────── */
.reg-same-row {
    padding: 12px 24px; background: #fdf5f5;
    border-bottom: 1px solid #f0e0e0;
    display: flex; align-items: center; gap: 8px;
}
.reg-same-row label { font-size: 12px; color: #333; font-weight: 600; cursor: pointer; margin: 0; }
.reg-same-row input[type=checkbox] { accent-color: #bd1a21; width: 14px; height: 14px; cursor: pointer; }

/* ── CAPTCHA row ────────────────────────────────────────── */
.reg-captcha-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.reg-captcha-row img { border: 1px solid #ddd; border-radius: 3px; }
.reg-captcha-icons { display: flex; gap: 6px; align-items: center; }
.reg-captcha-icons a img { border: none; opacity: .6; }
.reg-captcha-icons a:hover img { opacity: 1; }

/* ── Terms ──────────────────────────────────────────────── */
.reg-terms-row {
    padding: 16px 24px; border-top: 1px solid #f0f0f0;
    background: #fafafa; display: flex; flex-direction: column; gap: 6px;
}
.reg-terms-check { display: flex; align-items: center; gap: 8px; }
.reg-terms-check input[type=checkbox] { accent-color: #bd1a21; width: 14px; height: 14px; cursor: pointer; flex-shrink: 0; }
.reg-terms-check label { font-size: 12px; color: #333; cursor: pointer; margin: 0; }
.reg-terms-check label a { color: #bd1a21; text-decoration: none; }
.reg-terms-check label a:hover { text-decoration: underline; }

/* ── Submit ─────────────────────────────────────────────── */
.reg-actions { padding: 18px 24px; display: flex; gap: 10px; border-top: 1px solid #f0f0f0; }
.reg-btn-submit {
    background: linear-gradient(135deg, #bd1a21, #8b0000);
    color: #fff; border: none; border-radius: 4px;
    padding: 11px 32px; font-size: 13px; font-weight: 700;
    cursor: pointer; letter-spacing: .3px; transition: opacity .15s;
}
.reg-btn-submit:hover { opacity: .88; }
.reg-btn-reset {
    background: #fff; color: #666; border: 1px solid #ccc;
    border-radius: 4px; padding: 11px 20px; font-size: 12px;
    font-weight: 600; cursor: pointer; transition: background .15s;
}
.reg-btn-reset:hover { background: #f5f5f5; }

/* ── Sign-in link ───────────────────────────────────────── */
.reg-signin { padding: 14px 24px 20px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #f0f0f0; }
.reg-signin a { color: #bd1a21; font-weight: 600; text-decoration: none; }
.reg-signin a:hover { text-decoration: underline; }

@media (max-width: 640px) {
    .reg-grid, .reg-grid-2 { grid-template-columns: 1fr; }
    .reg-span2, .reg-span3 { grid-column: span 1; }
}
</style>

{literal}
<script>
$(document).ready(function () {
    stateOptions($('#country_id').val(), 'state_textbox', 'state_select');
    stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});

function shipsame(form) {
    if (form.sameasbilling.checked) {
        form.shipping_firstname.value  = form.firstname.value;
        form.shipping_lastname.value   = form.lastname.value;
        form.shipping_address1.value   = form.address1.value;
        form.shipping_address2.value   = form.address2.value;
        form.shipping_city.value       = form.city.value;
        form.shipping_zipcode.value    = form.zipcode.value;
        if (form.country_id.type === "Select") {
            form.shipping_country_id.options[form.country_id.selectedIndex].selected = true;
        } else {
            form.shipping_country_id.value = form.country_id.value;
            if (form.country_id.value == 230) {
                form.shipping_state_select.value = form.state_select.value;
            } else {
                form.shipping_state_textbox.value = form.state_textbox.value;
            }
            stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
        }
    } else {
        form.shipping_firstname.value  = '';
        form.shipping_lastname.value   = '';
        form.shipping_address1.value   = '';
        form.shipping_address2.value   = '';
        form.shipping_city.value       = '';
        form.shipping_state_textbox.value = '';
        form.shipping_zipcode.value    = '';
        if (form.shipping_country_id.type === "Select") {
            form.shipping_country_id.options[0].selected = true;
        } else {
            form.shipping_country_id.value = '';
        }
        stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
    }
}
</script>
{/literal}

<div id="forinnerpage-container">
<div id="wrapper">
    <div id="headerthemepanel">
        {include file="search-login.tpl"}
    </div>
    <div id="inner-container">
    {include file="right-panel.tpl"}
    <div id="center"><div id="squeeze"><div class="right-corner">
    <div id="inner-left-container">

        <div class="innerpage-container-main reg-page">
        <div class="reg-card">

            {* ── Hero ─────────────────────────────────── *}
            <div class="reg-hero">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                <div class="reg-hero-text">
                    <h1>Create Your Account</h1>
                    <p>Fields marked <span style="color:#ffaaaa;">*</span> are required</p>
                </div>
            </div>

            {if $errorMessage != ''}
                <div class="reg-alert">{$errorMessage}</div>
            {/if}

            <form name="frmacc" action="" method="post" id="register">
            <input type="hidden" name="mode" value="register">
            <input type="hidden" name="ip" value="">

            {* ── Account details ───────────────────────── *}
            <div class="reg-section-head">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                <span>Account Details</span>
            </div>
            <div class="reg-body">
                <div class="reg-grid">
                    <div class="reg-field">
                        <label>First Name <span class="req">*</span></label>
                        <input type="text" name="firstname" value="{$firstname}" class="reg-input">
                        {if $firstname_err != ''}<div class="reg-err">{$firstname_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Last Name <span class="req">*</span></label>
                        <input type="text" name="lastname" value="{$lastname}" class="reg-input">
                        {if $lastname_err != ''}<div class="reg-err">{$lastname_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Email Address <span class="req">*</span></label>
                        <input type="email" name="email" value="{$email}" class="reg-input">
                        {if $email_err != ''}<div class="reg-err">{$email_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Username <span class="req">*</span></label>
                        <input type="text" name="username" value="{$username}" class="reg-input">
                        {if $username_err != ''}<div class="reg-err">{$username_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Password <span class="req">*</span></label>
                        <input type="password" name="password" id="password" value="{$password}" class="reg-input">
                        {if $password_err != ''}<div class="reg-err">{$password_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Confirm Password <span class="req">*</span></label>
                        <input type="password" name="cpassword" id="cpassword" value="{$cpassword}" class="reg-input">
                        {if $cpassword_err != ''}<div class="reg-err">{$cpassword_err}</div>{/if}
                    </div>
                </div>
            </div>

            {* ── Billing address ────────────────────────── *}
            <div class="reg-section-head">
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <span>Billing Address</span>
            </div>
            <div class="reg-body">
                <div class="reg-grid">
                    <div class="reg-field reg-span2">
                        <label>Address Line 1 <span class="req">*</span></label>
                        <input type="text" name="address1" value="{$address1}" class="reg-input">
                        {if $address1_err != ''}<div class="reg-err">{$address1_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Address Line 2</label>
                        <input type="text" name="address2" value="{$address2}" class="reg-input">
                    </div>
                    <div class="reg-field">
                        <label>Country <span class="req">*</span></label>
                        <select name="country_id" id="country_id" class="reg-select" onchange="stateOptions(this.value,'state_textbox','state_select');">
                            <option value="">Select Country</option>
                            {html_options values=$countryID output=$countryName selected=$country_id}
                        </select>
                        {if $country_id_err != ''}<div class="reg-err">{$country_id_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Province / State</label>
                        <input type="text" name="state_textbox" id="state_textbox" value="{$state_textbox}" class="reg-input">
                        <select name="state_select" id="state_select" class="reg-select" style="display:none;">
                            <option value="">Select State</option>
                            {section name=counter loop=$us_states}
                            <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $state_select}selected="selected"{/if}>{$us_states[counter].name}</option>
                            {/section}
                        </select>
                        {if $state_textbox_err != '' || $state_select_err != ''}<div class="reg-err">{$state_textbox_err}{$state_select_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>City <span class="req">*</span></label>
                        <input type="text" name="city" value="{$city}" class="reg-input">
                        {if $city_err != ''}<div class="reg-err">{$city_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Zipcode <span class="req">*</span></label>
                        <input type="text" name="zipcode" value="{$zipcode}" class="reg-input">
                        {if $zipcode_err != ''}<div class="reg-err">{$zipcode_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Day Phone <span class="req">*</span></label>
                        <input type="text" name="contact_no" value="{$contact_no}" maxlength="12" class="reg-input" placeholder="Numbers only">
                        <span class="reg-hint">Numbers only — no dashes or spaces</span>
                        {if $contact_no_err != ''}<div class="reg-err">{$contact_no_err}</div>{/if}
                    </div>
                </div>
            </div>

            {* ── Shipping address ───────────────────────── *}
            <div class="reg-section-head">
                <svg viewBox="0 0 24 24"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                <span>Shipping Address</span>
            </div>

            <div class="reg-same-row">
                <input type="checkbox" name="sameasbilling" id="sameasbilling" value="checkbox" onclick="shipsame(this.form);" {if $sameasbilling == 'checkbox'}checked="checked"{/if}>
                <label for="sameasbilling">Same as billing address</label>
            </div>

            <div class="reg-body">
                <div class="reg-grid">
                    <div class="reg-field">
                        <label>First Name <span class="req">*</span></label>
                        <input type="text" name="shipping_firstname" value="{$shipping_firstname}" class="reg-input">
                        {if $shipping_firstname_err != ''}<div class="reg-err">{$shipping_firstname_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Last Name <span class="req">*</span></label>
                        <input type="text" name="shipping_lastname" value="{$shipping_lastname}" class="reg-input">
                        {if $shipping_lastname_err != ''}<div class="reg-err">{$shipping_lastname_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Address Line 1 <span class="req">*</span></label>
                        <input type="text" name="shipping_address1" value="{$shipping_address1}" class="reg-input">
                        {if $shipping_address1_err != ''}<div class="reg-err">{$shipping_address1_err}</div>{/if}
                    </div>
                    <div class="reg-field reg-span2">
                        <label>Address Line 2</label>
                        <input type="text" name="shipping_address2" value="{$shipping_address2}" class="reg-input">
                    </div>
                    <div class="reg-field">
                        <label>Country <span class="req">*</span></label>
                        <select name="shipping_country_id" id="shipping_country_id" class="reg-select" onchange="stateOptions($('#shipping_country_id').val(),'shipping_state_textbox','shipping_state_select');">
                            <option value="">Select Country</option>
                            {html_options values=$countryID output=$countryName selected=$shipping_country_id}
                        </select>
                        {if $shipping_country_id_err != ''}<div class="reg-err">{$shipping_country_id_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Province / State</label>
                        <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" value="{$shipping_state_textbox}" class="reg-input">
                        <select name="shipping_state_select" id="shipping_state_select" class="reg-select" style="display:none;">
                            <option value="">Select State</option>
                            {section name=counter loop=$us_states}
                            <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $shipping_state_select}selected="selected"{/if}>{$us_states[counter].name}</option>
                            {/section}
                        </select>
                        {if $shipping_state_textbox_err != '' || $shipping_state_select_err != ''}<div class="reg-err">{$shipping_state_textbox_err}{$shipping_state_select_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>City <span class="req">*</span></label>
                        <input type="text" name="shipping_city" value="{$shipping_city}" class="reg-input">
                        {if $shipping_city_err != ''}<div class="reg-err">{$shipping_city_err}</div>{/if}
                    </div>
                    <div class="reg-field">
                        <label>Zipcode <span class="req">*</span></label>
                        <input type="text" name="shipping_zipcode" value="{$shipping_zipcode}" class="reg-input">
                        {if $shipping_zipcode_err != ''}<div class="reg-err">{$shipping_zipcode_err}</div>{/if}
                    </div>
                </div>
            </div>

            {* ── Security / CAPTCHA ─────────────────────── *}
            <div class="reg-section-head">
                <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93-2.67-1.14-5-4.43-5-7.93V7.18L12 5z"/></svg>
                <span>Security Verification</span>
            </div>
            <div class="reg-body">
                <div class="reg-grid-2">
                    <div class="reg-field">
                        <label>Security Image</label>
                        <div class="reg-captcha-row">
                            <img src="{$actualPath}/securimage/securimage_show.php?sid={$captchaSid}" alt="CAPTCHA" id="captcha-img">
                            <div class="reg-captcha-icons">
                                <a href="{$actualPath}/securimage/securimage_play.php" title="Listen"><img src="{$actualPath}/securimage/images/audio_icon.gif" alt="Audio" border="0"></a>
                                <a href="#" title="Refresh" onclick="document.getElementById('captcha-img').src='securimage/securimage_show.php?sid='+Math.random();return false;"><img src="{$actualPath}/securimage/images/refresh.gif" alt="Refresh" border="0"></a>
                            </div>
                        </div>
                    </div>
                    <div class="reg-field">
                        <label>Enter Code <span class="req">*</span></label>
                        <input type="text" name="code" value="" class="reg-input" placeholder="Type the code shown">
                        {if $code_err != ''}<div class="reg-err">{$code_err}</div>{/if}
                    </div>
                </div>
            </div>

            {* ── Terms & submit ─────────────────────────── *}
            <div class="reg-terms-row">
                <div class="reg-terms-check">
                    <input type="checkbox" name="agree" id="agree" value="1">
                    <label for="agree">I have read and agree to the <a href="{$actualPath}/user_agreement.php" target="_blank">Terms of Use</a></label>
                </div>
                {if $agree_err != ''}<div class="reg-err" style="padding-left:22px;">{$agree_err}</div>{/if}
            </div>

            <div class="reg-actions">
                <button type="submit" class="reg-btn-submit">Create Account</button>
                <button type="reset"  class="reg-btn-reset">Clear Form</button>
            </div>

            </form>

            <div class="reg-signin">
                Already have an account? <a href="{$actualPath}/login.php">Sign in here</a>
            </div>

        </div>{* .reg-card *}
        </div>{* .reg-page *}

    </div>
    </div></div></div>
    </div>
    {include file="gavelsnipe.tpl"}
</div>
</div>
<div class="clear"></div>

{include file="foot.tpl"}

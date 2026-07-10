{include file="header.tpl"}

<style>
/* ── Page shell ─────────────────────────────────────────── */
.prf-page { padding: 24px 0 48px; }

/* ── Hero ───────────────────────────────────────────────── */
.prf-hero {
    background: linear-gradient(135deg, #bd1a21 0%, #8b0000 100%);
    border-radius: 6px 6px 0 0;
    padding: 22px 28px 18px;
    display: flex; align-items: center; gap: 14px;
}
.prf-hero svg { fill: rgba(255,255,255,0.85); width: 26px; height: 26px; flex-shrink: 0; }
.prf-hero-text h1 { margin: 0; font-size: 17px; font-weight: 700; color: #fff; }
.prf-hero-text p  { margin: 3px 0 0; font-size: 11px; color: rgba(255,255,255,0.75); }

/* ── Card ───────────────────────────────────────────────── */
.prf-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
    margin-bottom: 20px;
}

/* ── Section header ─────────────────────────────────────── */
.prf-section-head {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 24px; background: #f8f8f8;
    border-bottom: 1px solid #ebebeb;
    border-top: 1px solid #ebebeb;
}
.prf-section-head:first-of-type { border-top: none; }
.prf-section-head svg { fill: #bd1a21; width: 15px; height: 15px; flex-shrink: 0; }
.prf-section-head span { font-size: 11px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: .5px; }

/* ── Form body ──────────────────────────────────────────── */
.prf-body { padding: 20px 24px 24px; }

/* ── Grid ───────────────────────────────────────────────── */
.prf-grid  { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px 20px; }
.prf-span2 { grid-column: span 2; }
.prf-span3 { grid-column: span 3; }

/* ── Fields ─────────────────────────────────────────────── */
.prf-field { display: flex; flex-direction: column; }
.prf-field label {
    font-size: 11px; font-weight: 700; color: #555;
    margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;
}
.prf-field label .req { color: #bd1a21; margin-left: 2px; }
.prf-input, .prf-select {
    width: 100%; box-sizing: border-box;
    border: 1px solid #d0d0d0; border-radius: 4px;
    padding: 9px 12px; font-size: 12px; color: #333;
    font-family: inherit; background: #fff;
    transition: border-color .15s, box-shadow .15s; outline: none;
}
.prf-input:focus, .prf-select:focus {
    border-color: #bd1a21;
    box-shadow: 0 0 0 3px rgba(189,26,33,0.08);
}
.prf-input[readonly] { background: #f5f5f5; color: #777; cursor: not-allowed; }
.prf-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23999'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 28px; }
.prf-hint { font-size: 10px; color: #999; margin-top: 3px; }
.prf-err  { font-size: 11px; color: #bd1a21; margin-top: 4px; }

/* ── Alert ──────────────────────────────────────────────── */
.prf-alert {
    margin: 0 24px 16px; padding: 10px 14px; border-radius: 4px;
    font-size: 12px; border: 1px solid #f5c6cb;
    background: #f8d7da; color: #721c24;
}

/* ── Same-as-billing / checkbox row ────────────────────── */
.prf-same-row {
    padding: 12px 24px; background: #fdf5f5;
    border-bottom: 1px solid #f0e0e0;
    display: flex; align-items: center; gap: 8px;
}
.prf-same-row label { font-size: 12px; color: #333; font-weight: 600; cursor: pointer; margin: 0; }
.prf-same-row input[type=checkbox] { accent-color: #bd1a21; width: 14px; height: 14px; cursor: pointer; }

.prf-check-field { display: flex; align-items: center; gap: 8px; }
.prf-check-field input[type=checkbox] { accent-color: #bd1a21; width: 14px; height: 14px; cursor: pointer; flex-shrink: 0; }
.prf-check-field label { font-size: 12px; color: #333; cursor: pointer; margin: 0; text-transform: none; font-weight: 500; }

/* ── Submit ─────────────────────────────────────────────── */
.prf-actions { padding: 18px 24px; display: flex; gap: 10px; border-top: 1px solid #f0f0f0; }
.prf-btn-submit {
    background: linear-gradient(135deg, #bd1a21, #8b0000);
    color: #fff; border: none; border-radius: 4px;
    padding: 11px 32px; font-size: 13px; font-weight: 700;
    cursor: pointer; letter-spacing: .3px; transition: opacity .15s;
}
.prf-btn-submit:hover { opacity: .88; }
.prf-btn-reset {
    background: #fff; color: #666; border: 1px solid #ccc;
    border-radius: 4px; padding: 11px 20px; font-size: 12px;
    font-weight: 600; cursor: pointer; transition: background .15s;
}
.prf-btn-reset:hover { background: #f5f5f5; }

@media (max-width: 640px) {
    .prf-grid { grid-template-columns: 1fr; }
    .prf-span2, .prf-span3 { grid-column: span 1; }
}
</style>

{literal}
<script language="javascript">
$(document).ready(function() {
	stateOptions($('#country_id').val(), 'state_textbox', 'state_select');
	stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});
function shipsame(form){

	if(form.sameasbilling.checked){

		form.shipping_firstname.value = form.firstname.value;
		form.shipping_lastname.value = form.lastname.value;
		form.shipping_address1.value = form.address1.value;
		form.shipping_address2.value = form.address2.value;
		form.shipping_city.value = form.city.value;
		form.shipping_zipcode.value = form.zipcode.value;

		if(form.country_id.type == "Select"){
			var bCountryIdx = form.country_id.selectedIndex;
			form.shipping_country_id.options[bCountryIdx].selected = true;
		}else{
			form.shipping_country_id.value = form.country_id.value;

			if(form.country_id.value == 230){
				form.shipping_state_select.value = form.state_select.value;
			}else{
				form.shipping_state_textbox.value = form.state_textbox.value;
			}

			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}

	}else{
		form.shipping_firstname.value = {/literal} "{$profile[0].shipping_firstname}" {literal};
		form.shipping_lastname.value = {/literal} "{$profile[0].shipping_lastname}" {literal};
		form.shipping_address1.value = {/literal} "{$profile[0].shipping_address1}" {literal};
		form.shipping_address2.value  = {/literal} "{$profile[0].shipping_address2}" {literal};
		form.shipping_city.value = {/literal} "{$profile[0].shipping_city}" {literal};
		form.shipping_zipcode.value = {/literal} "{$profile[0].shipping_zipcode}" {literal};
		if(form.shipping_country_id.type == "Select"){
			form.shipping_country_id.options[0].selected = true;
		}else{
			form.shipping_country_id.value = {/literal} "{$profile[0].shipping_country_id}" {literal};

			if(form.shipping_country_id.value == 230){
				form.shipping_state_select.value = {/literal} "{$profile[0].shipping_state}" {literal};
			}else{
				form.shipping_state_textbox.value = {/literal} "{$profile[0].shipping_state}" {literal};
			}

			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}
	}
}
</script>
{/literal}
<div id="forinnerpage-container">
    <div id="wrapper">
        <!--Header themepanel Starts-->
        <div id="headerthemepanel">
            <!--Header Theme Starts-->
          {include file="search-login.tpl"}
          <!--Header Theme Ends-->
        </div>
        <!--Header themepanel Ends-->

        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">

            <div id="inner-left-container">
                <div class="innerpage-container-main prf-page">
                <div class="prf-card">

                    {* ── Hero ─────────────────────────────────── *}
                    <div class="prf-hero">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        <div class="prf-hero-text">
                            <h1>My Profile</h1>
                            <p>Fields marked <span style="color:#ffaaaa;">*</span> are required</p>
                        </div>
                    </div>

                    {if $errorMessage != ''}
                        <div class="prf-alert">{$errorMessage}</div>
                    {/if}

                    <form name="frm_profile" action="" method="post" id="frm_profile">
                    <input type="hidden" name="mode" value="update_profile">

                    {* ── Account details ───────────────────────── *}
                    <div class="prf-section-head">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                        <span>Account Details</span>
                    </div>
                    <div class="prf-body">
                        <div class="prf-grid">
                            <div class="prf-field">
                                <label>Username</label>
                                <input type="text" value="{$profile[0].username}" readonly="readonly" class="prf-input">
                            </div>
                            <div class="prf-field">
                                <label>First Name <span class="req">*</span></label>
                                <input type="text" name="firstname" id="firstname" value="{$profile[0].firstname}" class="prf-input">
                                {if $firstname_err != ''}<div class="prf-err">{$firstname_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Last Name <span class="req">*</span></label>
                                <input type="text" name="lastname" value="{$profile[0].lastname}" class="prf-input">
                                {if $lastname_err != ''}<div class="prf-err">{$lastname_err}</div>{/if}
                            </div>
                            <div class="prf-field prf-span2">
                                <label>Email Address <span class="req">*</span></label>
                                <input type="email" name="email" value="{$profile[0].email}" class="prf-input">
                                {if $email_err != ''}<div class="prf-err">{$email_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Day Phone <span class="req">*</span></label>
                                <input type="text" name="contact_no" value="{$profile[0].contact_no}" maxlength="12" class="prf-input" placeholder="Numbers only">
                                {if $contact_no_err != ''}<div class="prf-err">{$contact_no_err}</div>{/if}
                            </div>
                        </div>
                    </div>

                    {* ── Billing address ────────────────────────── *}
                    <div class="prf-section-head">
                        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <span>Billing Address</span>
                    </div>
                    <div class="prf-body">
                        <div class="prf-grid">
                            <div class="prf-field prf-span2">
                                <label>Address Line 1 <span class="req">*</span></label>
                                <input type="text" name="address1" value="{$profile[0].address1}" class="prf-input">
                                {if $address1_err != ''}<div class="prf-err">{$address1_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Address Line 2</label>
                                <input type="text" name="address2" value="{$profile[0].address2}" class="prf-input">
                                {if $address2_err != ''}<div class="prf-err">{$address2_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Country <span class="req">*</span></label>
                                <select name="country_id" id="country_id" class="prf-select" onchange="stateOptions(this.value, 'state_textbox', 'state_select');">
                                    <option value="">Select Country</option>
                                    {html_options values=$countryID output=$countryName selected=$profile[0].country_id}
                                </select>
                                {if $country_id_err != ''}<div class="prf-err">{$country_id_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Province / State</label>
                                <input type="text" name="state_textbox" id="state_textbox" class="prf-input" {if $profile[0].country_id != 230} value="{$profile[0].state}" {else} style="display:none;" {/if}>
                                <select name="state_select" id="state_select" class="prf-select" {if $profile[0].country_id != 230} style="display:none;" {/if}>
                                    {section name=counter loop=$us_states}
                                    <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].name == $profile[0].state || $us_states[counter].abbreviation == $profile[0].state} selected="selected" {/if}>{$us_states[counter].name}</option>
                                    {/section}
                                </select>
                                {if $state_textbox_err != '' || $state_select_err != ''}<div class="prf-err">{$state_textbox_err}{$state_select_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>City <span class="req">*</span></label>
                                <input type="text" name="city" value="{$profile[0].city}" class="prf-input">
                                {if $city_err != ''}<div class="prf-err">{$city_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Zipcode <span class="req">*</span></label>
                                <input type="text" name="zipcode" value="{$profile[0].zipcode}" class="prf-input">
                                {if $zipcode_err != ''}<div class="prf-err">{$zipcode_err}</div>{/if}
                            </div>
                            <div class="prf-field prf-span2">
                                <div class="prf-check-field" style="margin-top:22px;">
                                    <input type="checkbox" name="nl_subscr" id="nl_subscr" value="1" {if $profile[0].newsletter_subscription == 1} checked="checked" {/if}>
                                    <label for="nl_subscr">Subscribe to newsletter</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {* ── Shipping address ───────────────────────── *}
                    <div class="prf-section-head">
                        <svg viewBox="0 0 24 24"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                        <span>Shipping Address</span>
                    </div>

                    <div class="prf-same-row">
                        <input type="checkbox" name="sameasbilling" id="sameasbilling" value="checkbox" onClick="shipsame(this.form);">
                        <label for="sameasbilling">Same as billing address</label>
                    </div>

                    <div class="prf-body">
                        <div class="prf-grid">
                            <div class="prf-field">
                                <label>First Name <span class="req">*</span></label>
                                <input type="text" name="shipping_firstname" value="{$profile[0].shipping_firstname}" class="prf-input">
                                {if $shipping_firstname_err != ''}<div class="prf-err">{$shipping_firstname_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Last Name <span class="req">*</span></label>
                                <input type="text" name="shipping_lastname" value="{$profile[0].shipping_lastname}" class="prf-input">
                                {if $shipping_lastname_err != ''}<div class="prf-err">{$shipping_lastname_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Address Line 1 <span class="req">*</span></label>
                                <input type="text" name="shipping_address1" value="{$profile[0].shipping_address1}" class="prf-input">
                                {if $shipping_address1_err != ''}<div class="prf-err">{$shipping_address1_err}</div>{/if}
                            </div>
                            <div class="prf-field prf-span2">
                                <label>Address Line 2</label>
                                <input type="text" name="shipping_address2" value="{$profile[0].shipping_address2}" class="prf-input">
                                {if $shipping_address2_err != ''}<div class="prf-err">{$shipping_address2_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Country <span class="req">*</span></label>
                                <select name="shipping_country_id" id="shipping_country_id" class="prf-select" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');">
                                    <option value="">Select Country</option>
                                    {html_options values=$countryID output=$countryName selected=$profile[0].shipping_country_id}
                                </select>
                                {if $shipping_country_id_err != ''}<div class="prf-err">{$shipping_country_id_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Province / State</label>
                                <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" class="prf-input" {if $profile[0].shipping_country_id != 230} value="{$profile[0].shipping_state}" {else} style="display:none;" {/if}>
                                <select name="shipping_state_select" id="shipping_state_select" class="prf-select" {if $profile[0].shipping_country_id != 230} style="display:none;" {/if}>
                                    {section name=counter loop=$us_states}
                                    <option value="{$us_states[counter].abbreviation}" {if $us_states[counter].abbreviation == $profile[0].shipping_state || $us_states[counter].name == $profile[0].shipping_state} selected="selected" {/if}>{$us_states[counter].name}</option>
                                    {/section}
                                </select>
                                {if $shipping_state_textbox_err != '' || $shipping_state_select_err != ''}<div class="prf-err">{$shipping_state_textbox_err}{$shipping_state_select_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>City <span class="req">*</span></label>
                                <input type="text" name="shipping_city" value="{$profile[0].shipping_city}" class="prf-input">
                                {if $shipping_city_err != ''}<div class="prf-err">{$shipping_city_err}</div>{/if}
                            </div>
                            <div class="prf-field">
                                <label>Zipcode <span class="req">*</span></label>
                                <input type="text" name="shipping_zipcode" value="{$profile[0].shipping_zipcode}" class="prf-input">
                                {if $shipping_zipcode_err != ''}<div class="prf-err">{$shipping_zipcode_err}</div>{/if}
                            </div>
                        </div>
                    </div>

                    <div class="prf-actions">
                        <button type="submit" class="prf-btn-submit">Save Profile</button>
                        <button type="reset" class="prf-btn-reset">Reset</button>
                    </div>

                    </form>

                </div>{* .prf-card *}
                </div>{* .prf-page *}
            </div>

            </div></div></div>

        </div>
		{include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

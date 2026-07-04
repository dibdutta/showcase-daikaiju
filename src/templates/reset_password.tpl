{include file="header.tpl"}

<style>
.rp-outer {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 16px 60px;
}
.rp-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.09);
    width: 100%;
    max-width: 420px;
    overflow: hidden;
}
.rp-box-head {
    background: linear-gradient(135deg, #bd1a21 0%, #8b1219 100%);
    padding: 28px 30px 22px;
    text-align: center;
}
.rp-box-head .rp-lock-icon {
    width: 40px;
    height: 40px;
    margin: 0 auto 10px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.rp-box-head .rp-lock-icon svg {
    fill: #fff;
    width: 20px;
    height: 20px;
}
.rp-box-head h1 {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 6px;
    letter-spacing: 0.3px;
    border: none;
    padding: 0;
}
.rp-box-head p {
    color: rgba(255,255,255,0.75);
    font-size: 12px;
    margin: 0;
    line-height: 1.5;
}
.rp-box-body {
    padding: 26px 30px 28px;
}
.rp-alert-ok {
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.rp-alert-err {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.rp-expired {
    text-align: center;
    padding: 10px 0 6px;
}
.rp-expired svg {
    fill: #ccc;
    width: 48px;
    height: 48px;
    margin: 0 auto 14px;
    display: block;
}
.rp-expired h3 {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    margin: 0 0 8px;
    border: none;
    padding: 0;
}
.rp-expired p {
    font-size: 12px;
    color: #888;
    margin: 0 0 18px;
    line-height: 1.6;
}
.rp-expired a {
    display: inline-block;
    background: #bd1a21;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    padding: 9px 22px;
    border-radius: 4px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.rp-expired a:hover { background: #9e1519; }
.rp-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
}
.rp-label span { color: #bd1a21; }
.rp-input-wrap {
    position: relative;
    margin-bottom: 4px;
}
.rp-input {
    width: 100%;
    padding: 9px 38px 9px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13px;
    font-family: inherit;
    background: #fafafa;
    box-sizing: border-box;
    transition: border-color .15s, background .15s;
}
.rp-input:focus {
    outline: none;
    border-color: #bd1a21;
    background: #fff;
}
.rp-eye {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #aaa;
    line-height: 1;
    font-size: 15px;
    user-select: none;
    background: none;
    border: none;
    padding: 0;
}
.rp-eye:hover { color: #666; }
.rp-field-err {
    font-size: 11px;
    color: #bd1a21;
    margin-top: 4px;
    margin-bottom: 12px;
}
.rp-field { margin-bottom: 16px; }
.rp-strength {
    margin-top: 6px;
    display: flex;
    gap: 4px;
    align-items: center;
}
.rp-strength-bar {
    flex: 1;
    height: 3px;
    border-radius: 2px;
    background: #e0e0e0;
    transition: background .2s;
}
.rp-strength-label {
    font-size: 10px;
    color: #aaa;
    width: 50px;
    text-align: right;
    flex-shrink: 0;
}
.rp-btn {
    display: block;
    width: 100%;
    margin-top: 22px;
    padding: 10px;
    background: #bd1a21;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    text-transform: uppercase;
    transition: background .15s;
}
.rp-btn:hover { background: #9e1519; }
.rp-footer-links {
    text-align: center;
    margin-top: 18px;
    font-size: 12px;
    color: #999;
}
.rp-footer-links a {
    color: #bd1a21;
    text-decoration: none;
    font-weight: 600;
}
.rp-footer-links a:hover { text-decoration: underline; }
.rp-divider { margin: 0 8px; color: #ddd; }
</style>

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

                    <div class="rp-outer">
                        <div class="rp-box">

                            <div class="rp-box-head">
                                <div class="rp-lock-icon">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                </div>
                                <h1>Set New Password</h1>
                                <p>Choose a strong password for your KaijuLink account.</p>
                            </div>

                            <div class="rp-box-body">

                                {if $show_ind > 0}

                                    {if $errorMessage != ""}
                                        <div class="rp-alert-err">{$errorMessage}</div>
                                    {/if}

                                    <form name="frm_forgetpass" id="frm_forgetpass" action="" method="post" novalidate>
                                        <input type="hidden" name="mode" value="reset_password">
                                        <input type="hidden" name="user_setpass_code" value="{$varify_id}">

                                        <div class="rp-field">
                                            <label class="rp-label" for="rp_password"><span>*</span> New Password</label>
                                            <div class="rp-input-wrap">
                                                <input type="password" id="rp_password" name="password" class="rp-input" placeholder="At least 5 characters" autocomplete="new-password">
                                                <button type="button" class="rp-eye" onclick="toggleVis('rp_password', this)" title="Show/hide password">&#128065;</button>
                                            </div>
                                            <div class="rp-strength" id="rp-strength-wrap" style="display:none;">
                                                <div class="rp-strength-bar" id="rp-bar1"></div>
                                                <div class="rp-strength-bar" id="rp-bar2"></div>
                                                <div class="rp-strength-bar" id="rp-bar3"></div>
                                                <div class="rp-strength-bar" id="rp-bar4"></div>
                                                <span class="rp-strength-label" id="rp-strength-label"></span>
                                            </div>
                                            <div class="rp-field-err" id="rp_password_err"></div>
                                        </div>

                                        <div class="rp-field">
                                            <label class="rp-label" for="rp_confirm"><span>*</span> Confirm Password</label>
                                            <div class="rp-input-wrap">
                                                <input type="password" id="rp_confirm" name="confirm_password" class="rp-input" placeholder="Repeat your password" autocomplete="new-password">
                                                <button type="button" class="rp-eye" onclick="toggleVis('rp_confirm', this)" title="Show/hide password">&#128065;</button>
                                            </div>
                                            <div class="rp-field-err" id="rp_confirm_err"></div>
                                        </div>

                                        <button type="submit" class="rp-btn">Set New Password</button>
                                    </form>

                                {else}

                                    <div class="rp-expired">
                                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                        <h3>Link Expired or Invalid</h3>
                                        <p>This password reset link has already been used or has expired. Request a new one and try again.</p>
                                        <a href="/forget_password">Request New Link</a>
                                    </div>

                                {/if}

                                <div class="rp-footer-links">
                                    <a href="javascript:void(0);" onclick="showLogIn();">Sign In</a>
                                    <span class="rp-divider">|</span>
                                    <a href="/register">Create Account</a>
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

{literal}
<script>
function toggleVis(fieldId, btn) {
    var f = document.getElementById(fieldId);
    if (f.type === 'password') {
        f.type = 'text';
        btn.style.opacity = '1';
    } else {
        f.type = 'password';
        btn.style.opacity = '0.5';
    }
}

(function() {
    var pw   = document.getElementById('rp_password');
    var conf = document.getElementById('rp_confirm');
    var form = document.getElementById('frm_forgetpass');
    if (!pw) return;

    var colors = ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71'];
    var labels = ['Weak', 'Fair', 'Good', 'Strong'];

    function scorePassword(val) {
        if (!val) return 0;
        var score = 0;
        if (val.length >= 5) score++;
        if (val.length >= 9) score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
        if (/\d/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;
        return Math.min(score, 4);
    }

    pw.addEventListener('input', function() {
        var wrap = document.getElementById('rp-strength-wrap');
        var score = scorePassword(this.value);
        wrap.style.display = this.value ? 'flex' : 'none';
        for (var i = 1; i <= 4; i++) {
            var bar = document.getElementById('rp-bar' + i);
            bar.style.background = i <= score ? colors[score - 1] : '#e0e0e0';
        }
        document.getElementById('rp-strength-label').textContent = this.value ? labels[score - 1] : '';
    });

    if (form) {
        form.addEventListener('submit', function(e) {
            var ok = true;
            var pwErr   = document.getElementById('rp_password_err');
            var confErr = document.getElementById('rp_confirm_err');
            pwErr.textContent = '';
            confErr.textContent = '';

            if (!pw.value || pw.value.length < 5) {
                pwErr.textContent = 'Password must be at least 5 characters.';
                ok = false;
            }
            if (conf.value !== pw.value) {
                confErr.textContent = 'Passwords do not match.';
                ok = false;
            }
            if (!ok) e.preventDefault();
        });
    }
})();
</script>
{/literal}

{include file="foot.tpl"}

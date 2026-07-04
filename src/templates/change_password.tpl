{include file="header.tpl"}

<style>
.cp-outer {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 36px 16px 60px;
}
.cp-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.09);
    width: 100%;
    max-width: 440px;
    overflow: hidden;
}
.cp-box-head {
    background: linear-gradient(135deg, #bd1a21 0%, #8b1219 100%);
    padding: 26px 30px 20px;
    text-align: center;
}
.cp-box-head .cp-icon {
    width: 42px;
    height: 42px;
    margin: 0 auto 10px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cp-box-head .cp-icon svg {
    fill: #fff;
    width: 20px;
    height: 20px;
}
.cp-box-head h1 {
    color: #fff;
    font-size: 19px;
    font-weight: 700;
    margin: 0 0 5px;
    letter-spacing: 0.3px;
    border: none;
    padding: 0;
}
.cp-box-head p {
    color: rgba(255,255,255,0.72);
    font-size: 12px;
    margin: 0;
    line-height: 1.5;
}
.cp-box-body {
    padding: 24px 30px 28px;
}
.cp-alert-ok {
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.cp-alert-err {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.cp-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 20px 0 18px;
}
.cp-divider-label {
    text-align: center;
    font-size: 10px;
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: -8px 0 18px;
    position: relative;
}
.cp-divider-label span {
    background: #fff;
    padding: 0 10px;
}
.cp-field {
    margin-bottom: 16px;
}
.cp-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
}
.cp-label span { color: #bd1a21; }
.cp-input-wrap {
    position: relative;
}
.cp-input {
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
.cp-input:focus {
    outline: none;
    border-color: #bd1a21;
    background: #fff;
}
.cp-input.cp-input-err { border-color: #dc3545; background: #fff8f8; }
.cp-eye {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #bbb;
    font-size: 15px;
    background: none;
    border: none;
    padding: 0;
    line-height: 1;
    user-select: none;
}
.cp-eye:hover { color: #666; }
.cp-field-err {
    font-size: 11px;
    color: #bd1a21;
    margin-top: 4px;
}
.cp-strength {
    display: flex;
    gap: 4px;
    align-items: center;
    margin-top: 6px;
}
.cp-strength-bar {
    flex: 1;
    height: 3px;
    border-radius: 2px;
    background: #e0e0e0;
    transition: background .2s;
}
.cp-strength-label {
    font-size: 10px;
    color: #aaa;
    width: 46px;
    text-align: right;
    flex-shrink: 0;
}
.cp-btn {
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
.cp-btn:hover { background: #9e1519; }
.cp-footer-links {
    text-align: center;
    margin-top: 16px;
    font-size: 12px;
    color: #999;
}
.cp-footer-links a {
    color: #bd1a21;
    text-decoration: none;
    font-weight: 600;
}
.cp-footer-links a:hover { text-decoration: underline; }
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

                    <div class="cp-outer">
                        <div class="cp-box">

                            <div class="cp-box-head">
                                <div class="cp-icon">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                </div>
                                <h1>Change Password</h1>
                                <p>Keep your account secure with a strong, unique password.</p>
                            </div>

                            <div class="cp-box-body">

                                {if $errorMessage != ""}
                                    {if $errorMessage == "Your password has been updated successfully."}
                                        <div class="cp-alert-ok">&#10003; {$errorMessage}</div>
                                    {else}
                                        <div class="cp-alert-err">{$errorMessage}</div>
                                    {/if}
                                {/if}

                                <form action="" method="post" name="changePassword" id="changePassword" novalidate>
                                    <input type="hidden" name="mode" value="save_password">

                                    {* Current password *}
                                    <div class="cp-field">
                                        <label class="cp-label" for="cp_old"><span>*</span> Current Password</label>
                                        <div class="cp-input-wrap">
                                            <input type="password" id="cp_old" name="oldpassword" class="cp-input{if $oldpassword_err != ''} cp-input-err{/if}" placeholder="Your current password" autocomplete="current-password">
                                            <button type="button" class="cp-eye" onclick="cpToggle('cp_old',this)" title="Show/hide">&#128065;</button>
                                        </div>
                                        {if $oldpassword_err != ""}<div class="cp-field-err">{$oldpassword_err}</div>{/if}
                                    </div>

                                    <hr class="cp-divider">
                                    <div class="cp-divider-label"><span>New Password</span></div>

                                    {* New password *}
                                    <div class="cp-field">
                                        <label class="cp-label" for="cp_new"><span>*</span> New Password</label>
                                        <div class="cp-input-wrap">
                                            <input type="password" id="cp_new" name="newpassword" class="cp-input{if $newpassword_err != ''} cp-input-err{/if}" placeholder="At least 5 characters" autocomplete="new-password">
                                            <button type="button" class="cp-eye" onclick="cpToggle('cp_new',this)" title="Show/hide">&#128065;</button>
                                        </div>
                                        <div class="cp-strength" id="cp-strength-wrap" style="display:none;">
                                            <div class="cp-strength-bar" id="cp-bar1"></div>
                                            <div class="cp-strength-bar" id="cp-bar2"></div>
                                            <div class="cp-strength-bar" id="cp-bar3"></div>
                                            <div class="cp-strength-bar" id="cp-bar4"></div>
                                            <span class="cp-strength-label" id="cp-strength-lbl"></span>
                                        </div>
                                        {if $newpassword_err != ""}<div class="cp-field-err">{$newpassword_err}</div>{/if}
                                    </div>

                                    {* Confirm new password *}
                                    <div class="cp-field">
                                        <label class="cp-label" for="cp_conf"><span>*</span> Confirm New Password</label>
                                        <div class="cp-input-wrap">
                                            <input type="password" id="cp_conf" name="cnewpassword" class="cp-input{if $cnewpassword_err != ''} cp-input-err{/if}" placeholder="Repeat your new password" autocomplete="new-password">
                                            <button type="button" class="cp-eye" onclick="cpToggle('cp_conf',this)" title="Show/hide">&#128065;</button>
                                        </div>
                                        {if $cnewpassword_err != ""}<div class="cp-field-err">{$cnewpassword_err}</div>{/if}
                                    </div>

                                    <button type="submit" class="cp-btn">Update Password</button>
                                </form>

                                <div class="cp-footer-links">
                                    <a href="/myaccount">&#8592; Back to My Account</a>
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
function cpToggle(id, btn) {
    var f = document.getElementById(id);
    f.type = (f.type === 'password') ? 'text' : 'password';
    btn.style.opacity = (f.type === 'text') ? '1' : '0.5';
}

(function () {
    var pw   = document.getElementById('cp_new');
    var conf = document.getElementById('cp_conf');
    var form = document.getElementById('changePassword');
    if (!pw) return;

    var colors = ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71'];
    var labels = ['Weak', 'Fair', 'Good', 'Strong'];

    function score(v) {
        if (!v) return 0;
        var s = 0;
        if (v.length >= 5) s++;
        if (v.length >= 9) s++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
        if (/\d/.test(v) && /[^A-Za-z0-9]/.test(v)) s++;
        return Math.min(s, 4);
    }

    pw.addEventListener('input', function () {
        var wrap = document.getElementById('cp-strength-wrap');
        var s = score(this.value);
        wrap.style.display = this.value ? 'flex' : 'none';
        for (var i = 1; i <= 4; i++) {
            document.getElementById('cp-bar' + i).style.background = i <= s ? colors[s - 1] : '#e0e0e0';
        }
        document.getElementById('cp-strength-lbl').textContent = this.value ? labels[s - 1] : '';
    });

    form.addEventListener('submit', function (e) {
        var ok = true;
        var oldEl  = document.getElementById('cp_old');
        var pwEl   = pw;
        var confEl = conf;

        [oldEl, pwEl, confEl].forEach(function(el) {
            el.classList.remove('cp-input-err');
            var errEl = el.parentElement.nextElementSibling;
            if (errEl && errEl.classList.contains('cp-field-err')) errEl.textContent = '';
        });

        if (!oldEl.value.trim()) {
            oldEl.classList.add('cp-input-err');
            showErr(oldEl, 'Please enter your current password.');
            ok = false;
        }
        if (!pwEl.value || pwEl.value.length < 5) {
            pwEl.classList.add('cp-input-err');
            showErr(pwEl, 'New password must be at least 5 characters.');
            ok = false;
        }
        if (confEl.value !== pwEl.value) {
            confEl.classList.add('cp-input-err');
            showErr(confEl, 'Passwords do not match.');
            ok = false;
        }
        if (!ok) e.preventDefault();
    });

    function showErr(inputEl, msg) {
        var wrap = inputEl.closest('.cp-field');
        var err = wrap.querySelector('.cp-field-err');
        if (!err) {
            err = document.createElement('div');
            err.className = 'cp-field-err';
            wrap.appendChild(err);
        }
        err.textContent = msg;
    }
})();
</script>
{/literal}

{include file="foot.tpl"}

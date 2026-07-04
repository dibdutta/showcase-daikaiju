{include file="header.tpl"}

<style>
.fp-outer {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 16px 60px;
}
.fp-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.09);
    width: 100%;
    max-width: 420px;
    overflow: hidden;
}
.fp-box-head {
    background: linear-gradient(135deg, #bd1a21 0%, #8b1219 100%);
    padding: 28px 30px 22px;
    text-align: center;
}
.fp-box-head h1 {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 6px;
    letter-spacing: 0.3px;
    border: none;
    padding: 0;
}
.fp-box-head p {
    color: rgba(255,255,255,0.75);
    font-size: 12px;
    margin: 0;
    line-height: 1.5;
}
.fp-box-body {
    padding: 26px 30px 28px;
}
.fp-alert-ok {
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.fp-alert-err {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    border-radius: 4px;
    padding: 10px 14px;
    font-size: 12px;
    margin-bottom: 18px;
    line-height: 1.5;
}
.fp-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
}
.fp-label span { color: #bd1a21; }
.fp-input {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13px;
    font-family: inherit;
    background: #fafafa;
    box-sizing: border-box;
    transition: border-color .15s, background .15s;
}
.fp-input:focus {
    outline: none;
    border-color: #bd1a21;
    background: #fff;
}
.fp-field-err {
    font-size: 11px;
    color: #bd1a21;
    margin-top: 4px;
}
.fp-btn {
    display: block;
    width: 100%;
    margin-top: 20px;
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
.fp-btn:hover { background: #9e1519; }
.fp-footer-links {
    text-align: center;
    margin-top: 18px;
    font-size: 12px;
    color: #999;
}
.fp-footer-links a {
    color: #bd1a21;
    text-decoration: none;
    font-weight: 600;
}
.fp-footer-links a:hover { text-decoration: underline; }
.fp-divider { margin: 0 8px; color: #ddd; }
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

                    <div class="fp-outer">
                        <div class="fp-box">

                            <div class="fp-box-head">
                                <h1>Forgot Password?</h1>
                                <p>Enter your username or email and we'll send you a reset link.</p>
                            </div>

                            <div class="fp-box-body">

                                {if $smarty.request.key == 1}
                                    <div class="fp-alert-ok">Your request has been submitted. Please check your email and follow the instructions.</div>
                                {elseif $smarty.request.key == 3}
                                    <div class="fp-alert-ok">&#10003; Your password has been updated successfully. You can now sign in with your new password.</div>
                                {elseif $smarty.request.key == 2}
                                    <div class="fp-alert-err">Failed to send email. Please try again.</div>
                                {elseif $errorMessage != ""}
                                    <div class="fp-alert-err">{$errorMessage}</div>
                                {/if}

                                <form name="frm_forgetpass" id="frm_forgetpass" action="" method="post">
                                    <input type="hidden" name="mode" value="send_password">

                                    <label class="fp-label" for="fp_username"><span>*</span> Username or Email Address</label>
                                    <input type="text" id="fp_username" name="username" class="fp-input" placeholder="Enter your username or email" autocomplete="email" required>
                                    {if $username_err != ""}
                                        <div class="fp-field-err">{$username_err}</div>
                                    {/if}

                                    <button type="submit" class="fp-btn">Send Reset Link</button>
                                </form>

                                <div class="fp-footer-links">
                                    <a href="javascript:void(0);" onclick="showLogIn();">Sign In</a>
                                    <span class="fp-divider">|</span>
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
{include file="foot.tpl"}

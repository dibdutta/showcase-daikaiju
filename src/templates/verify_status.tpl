{include file="header.tpl"}
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
                <!--Page Body Starts-->
                <div class="innerpage-container-main">
                    <div class="dashboard-main">
                        <h1>Account Verification</h1>
                    </div>
                    <div class="left-midbg">
                        <div class="right-midbg">
                            <div class="mid-rept-bg">

                                <div style="padding: 50px 20px; text-align: center;">

                                    {if $verify_status == "success"}

                                    <div style="display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background-color:#4CAF50; margin-bottom:24px;">
                                        <span style="font-size:40px; color:#ffffff; line-height:1;">&#10003;</span>
                                    </div>
                                    <h2 style="color:#222; font-size:22px; margin:0 0 12px 0;">Registration Successful!</h2>
                                    <p style="color:#666; font-size:15px; margin:0 0 28px 0; max-width:420px; display:inline-block; line-height:1.6;">
                                        Your account has been created successfully.<br />Please check your email to verify your account before logging in.
                                    </p>
                                    <br />
                                    <a href="javascript:void(0);" onclick="showLogIn();" style="display:inline-block; padding:11px 36px; background:#b30000; color:#ffffff; text-decoration:none; border-radius:4px; font-size:14px; font-weight:bold; letter-spacing:0.3px;">Go to Login</a>

                                    {else}

                                    <div style="display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background-color:#e53935; margin-bottom:24px;">
                                        <span style="font-size:40px; color:#ffffff; line-height:1;">&#10007;</span>
                                    </div>
                                    <h2 style="color:#222; font-size:22px; margin:0 0 12px 0;">Registration Failed</h2>
                                    <p style="color:#666; font-size:15px; margin:0 0 28px 0; max-width:420px; display:inline-block; line-height:1.6;">
                                        {if $errorMessage != ""}{$errorMessage}{else}Registration was not completed successfully. Please try again.{/if}
                                    </p>
                                    <br />
                                    <a href="register" style="display:inline-block; padding:11px 36px; background:#b30000; color:#ffffff; text-decoration:none; border-radius:4px; font-size:14px; font-weight:bold; letter-spacing:0.3px;">Try Again</a>

                                    {/if}

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--Page Body Ends-->
            </div>
        </div></div></div>

        </div>
		{include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}

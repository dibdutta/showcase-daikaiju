{include file="header.tpl"}
<div id="forinnerpage-container">
	<div id="wrapper">
    	 <!--Header themepanel Starts-->
        {include file="search-login.tpl"}
        <!--Header themepanel Ends-->
        <div id="inner-container">
        {include file="right-panel.tpl"}
        <div id="center"><div id="squeeze"><div class="right-corner">

            <div id="inner-left-container">
                <div class="innerpage-container-main">

<style>
.sm-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #3a0000 100%);
    padding: 36px 30px 32px;
    margin: 0 0 28px 0;
    border-radius: 5px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
}
.sm-hero h1 {
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 6px 0;
    letter-spacing: 0.5px;
    border: none;
    padding: 0;
}
.sm-hero p {
    color: #bbb;
    font-size: 13px;
    margin: 0;
}
.sm-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 18px;
    margin-bottom: 20px;
}
.sm-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.sm-card:hover {
    box-shadow: 0 6px 22px rgba(0,0,0,0.13);
    transform: translateY(-2px);
}
.sm-card-head {
    background: #CC0000;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    gap: 9px;
}
.sm-card-head .sm-icon {
    width: 22px;
    height: 22px;
    flex-shrink: 0;
    opacity: 0.9;
    fill: #fff;
}
.sm-card-head h2 {
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    margin: 0;
    letter-spacing: 1px;
    text-transform: uppercase;
    border: none;
    padding: 0;
}
.sm-card-body {
    padding: 10px 0;
}
.sm-card-body a {
    display: block;
    padding: 8px 16px;
    color: #333;
    text-decoration: none;
    font-size: 13px;
    border-left: 3px solid transparent;
    transition: background 0.15s, color 0.15s, border-color 0.15s, padding-left 0.15s;
    line-height: 1.3;
}
.sm-card-body a:hover {
    background: #fff8f8;
    color: #CC0000;
    border-left-color: #CC0000;
    padding-left: 20px;
    text-decoration: none;
}
.sm-card-body a span {
    display: block;
    font-size: 11px;
    color: #aaa;
    margin-top: 1px;
    font-weight: 400;
}
.sm-card-body a:hover span {
    color: #d97070;
}
.sm-sep {
    height: 1px;
    background: #f2f2f2;
    margin: 4px 16px;
}
</style>

<div class="sm-hero">
    <h1>Site Map</h1>
    <p>Everything on KaijuLink, at a glance.</p>
</div>

<div class="sm-grid">

    <!-- Browse & Buy -->
    <div class="sm-card">
        <div class="sm-card-head">
            <svg class="sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14.75l.03-.12.9-1.63H17c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0021.46 4H5.21L4.27 2H1v2h2l3.6 7.59L5.25 14c-.16.28-.25.61-.25.96C5 16.1 5.9 17 7 17h14v-2H7.42c-.13 0-.25-.11-.25-.25z"/></svg>
            <h2>Browse &amp; Buy</h2>
        </div>
        <div class="sm-card-body">
            <a href="{$actualPath}/index">Home<span>Back to our homepage</span></a>
            <div class="sm-sep"></div>
            <a href="{$actualPath}/buy?list=fixed">Browse Kaiju Memorabilia<span>Shop Godzilla, kaiju &amp; classic film collectibles</span></a>
            <a href="{$actualPath}/buy?list=weekly">Our Event Auctions<span>Current weekly &amp; extended bid auctions</span></a>
            <div class="sm-sep"></div>
            <a href="{$actualPath}/sold_item">Sold Items Archive<span>View previously sold collectibles</span></a>
            <a href="{$actualPath}/buy?mode=refinesrc">Advanced Search<span>Filter by genre, decade, condition &amp; more</span></a>
        </div>
    </div>

    <!-- Selling -->
    <div class="sm-card">
        <div class="sm-card-head">
            <svg class="sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41s-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg>
            <h2>Selling</h2>
        </div>
        <div class="sm-card-body">
            <a href="{$actualPath}/sell">Sell Your Posters<span>Learn how to consign with KaijuLink</span></a>
            {if $smarty.session.sessUserID != ''}
            <div class="sm-sep"></div>
            <a href="{$actualPath}/myselling?mode=fixed">Create a Listing<span>Upload a new fixed-price item</span></a>
            <a href="{$actualPath}/myselling?mode=selling">Auction Listings<span>Manage your live auction items</span></a>
            <a href="{$actualPath}/myselling?mode=fixed_selling">Fixed-Price Listings<span>Manage your shop items</span></a>
            <a href="{$actualPath}/myselling?mode=sold">Sold Items<span>Items awaiting payment &amp; shipment</span></a>
            <a href="{$actualPath}/myselling?mode=upcoming">Upcoming Lots<span>Approved &amp; scheduled for auction</span></a>
            <a href="{$actualPath}/myselling?mode=pending">Pending Approval<span>Items awaiting admin review</span></a>
            <a href="{$actualPath}/myselling?mode=unsold">Unsold / Closed<span>Items that did not sell</span></a>
            {/if}
        </div>
    </div>

    <!-- My Account -->
    <div class="sm-card">
        <div class="sm-card-head">
            <svg class="sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
            <h2>My Account</h2>
        </div>
        <div class="sm-card-body">
            {if $smarty.session.sessUserID != ''}
            <a href="{$actualPath}/myaccount">My Dashboard<span>Your account overview</span></a>
            <a href="{$actualPath}/myaccount?mode=profile">Edit Profile<span>Update your personal details</span></a>
            <div class="sm-sep"></div>
            <a href="{$actualPath}/my_bid">My Active Bids<span>Bids placed in live auctions</span></a>
            <a href="{$actualPath}/my_bid?mode=closed&type=winning">My Closed Items<span>Won &amp; lost auction history</span></a>
            <a href="{$actualPath}/user_watching">Watch List<span>Items you're keeping an eye on</span></a>
            <a href="{$actualPath}/offers">My Outgoing Offers<span>Offers on fixed-price items</span></a>
            <a href="{$actualPath}/offers?mode=incoming_counters">My Incoming Counters<span>Counter-offers from sellers</span></a>
            <a href="{$actualPath}/my_invoice">Invoices<span>Payment &amp; order history</span></a>
            <a href="{$actualPath}/my_want_list">Want List<span>Get notified when sought items are listed</span></a>
            {else}
            <a href="{$actualPath}/register">Create an Account<span>Register free — start bidding today</span></a>
            <div class="sm-sep"></div>
            <a href="{$actualPath}/forget_password">Forgot Password<span>Reset your login credentials</span></a>
            {/if}
        </div>
    </div>

    <!-- Help & Information -->
    <div class="sm-card">
        <div class="sm-card-head">
            <svg class="sm-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            <h2>Help &amp; Information</h2>
        </div>
        <div class="sm-card-body">
            <a href="{$actualPath}/faq">FAQ<span>Frequently asked questions</span></a>
            <a href="{$actualPath}/contactus">Contact Us<span>Get in touch with our team</span></a>
            <a href="{$actualPath}/blog">Blog &amp; Articles<span>News, guides &amp; collecting tips</span></a>
            <a href="{$actualPath}/aboutus">About Us<span>Our story &amp; mission</span></a>
            <div class="sm-sep"></div>
            <a href="{$actualPath}/user_agreement">User Agreement &amp; Policies<span>Terms, privacy &amp; buyer/seller rules</span></a>
            <a href="{$actualPath}/register">Register<span>Create your free KaijuLink account</span></a>
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

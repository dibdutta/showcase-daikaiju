<?php

session_start();
//session_register("adminErr");
//session_register("Err");

define('PHP_SELF', $_SERVER['PHP_SELF']); 


////////////////  Smarty Variables  ///////////////////////////////////

define ('COMPILE_CHECK', true);
define ('DEBUGGING', false);
define ("CACHING", false);
define ("MAX_UPLOAD_POSTER", 12);

//////////////// /////////////////////////////////////////////////////

////////////////  Database variables //////////////////////////////////

/*****************  Common Fields ****************/

define ("POST_DATE", "post_date");
define ("UPDATE_DATE", "up_date");
define ("STATUS", "status");
define ("ACTIVE", "active");
define ("POST_IP", "post_ip");

/***************************************************/

/***********  config Table **************************/

define ("CONFIG_TABLE", "config_table");
define ("CONFIG_ID", "config_id");
define ("CONFIG_ADMIN_NAME", "admin_name");
define ("CONFIG_ADMIN_EMAIL", "admin_email");
define ("CONFIG_ADMIN_PAGE_TITLE", "admin_page_title");
define ("CONFIG_ADMIN_PAGE_WELCOMETEXT", "admin_page_welcometext");
define ("CONFIG_ADMIN_INSTRUCTION", "admin_instruction");
define ("CONFIG_ADMIN_COPYRIGHT", "admin_copyright");
define ("CONFIG_AUCTION_START_HOUR", "auction_start_hour");
define ("CONFIG_AUCTION_START_MIN", "auction_start_min");
define ("CONFIG_AUCTION_START_AM_PM", "auction_start_am_pm");
define ("CONFIG_AUCTION_END_HOUR", "auction_end_hour");
define ("CONFIG_AUCTION_END_MIN", "auction_end_min");
define ("CONFIG_AUCTION_END_AM_PM", "auction_end_am_pm");
define ("CONFIG_AUCTION_INCR_MIN_SPAN", "auction_incr_min_span");
define ("CONFIG_AUCTION_INCR_SEC_SPAN", "auction_incr_sec_span");
define ("CONFIG_AUCTION_INCR_BY_MIN", "auction_incr_by_min");
define ("CONFIG_AUCTION_INCR_BY_SEC", "auction_incr_by_sec");

define ("CONFIG_START_HOUR", "auction_start_hour");
define ("CONFIG_START_MIN", "auction_start_min");
define ("CONFIG_START_AM_PM", "auction_start_am_pm");
define ("CONFIG_END_HOUR", "auction_end_hour");
define ("CONFIG_END_MIN", "auction_end_min");
define ("CONFIG_END_AM_PM", "auction_end_am_pm");
define ("CONFIG_INCR_MIN_SPAN", "auction_incr_min_span");
define ("CONFIG_INCR_SEC_SPAN", "auction_incr_sec_span");
define ("CONFIG_INCR_BY_MIN", "auction_incr_by_min");
define ("CONFIG_INCR_BY_SEC", "auction_incr_by_sec");

define ("CONFIG_PAYPAL_API_USERNAME", "paypal_api_username");
define ("CONFIG_PAYPAL_API_PASSWORD", "paypal_api_password");
define ("CONFIG_PAYPAL_API_SIGNATURE", "paypal_api_signature");
define ("CONFIG_PAYPAL_IS_TEST_MODE", "paypal_is_test_mode");

define ("CONFIG_SALE_TAX_GA", "sale_tax_ga");
define ("CONFIG_SALE_TAX_NC", "sale_tax_nc");
define ("MARCHANT_FEE", "marchant_fee");
define ("MPE_CHARGE", "mpe_charge");
define ("MPE_CHARGE_WEEKLY", "mpe_charge_weekly");
define ("SITE_GLOBAL_DESCRIPTION", "site_global_description");
define ("SITE_GLOBAL_KEYWORDS", "site_global_keywords");
define ("SITE_GLOBAL_METATAGS", "site_global_metatags");

define ("PETER_EMAIL", "peter_email_id");
define ("SEAN_EMAIL", "sean_email_id");
/***************************************************/


/***********  Admin Table **************************/

define ("ADMIN_TABLE", "admin_table");
define ("ADMIN_ID", "admin_id");
define ("ADMIN_LOGIN_NAME", "admin_login");
define ("ADMIN_SET_PASSWORD", "admin_set_password");
define ("ADMIN_PASSWORD", "admin_pwd");
define ("ADMIN_FIRST_NAME", "admin_first_name");
define ("ADMIN_MIDDLE_NAME", "admin_middle_name");
define ("ADMIN_LAST_NAME", "admin_last_name");
define ("ADMIN_EMAIL", "admin_email");
define ("ADMIN_SUPER_ADMIN", "super_admin");
define ("ADMIN_LOGIN_TRY", "login_try");
define ("ADMIN_LAST_LOGIN", "admin_last_login");
define ("ADMIN_RESET_PASSWORD", "reset_password");
define ("ADMIN_BLOCK_REASON", "block_reason");

/***************************************************/


/***********  Admin Access Table *********************/

define ("ADMIN_ACCESS_TABLE", "admin_access_table");

/***************************************************/


/***********  Admin Pages Table ********************/

define ("ADMIN_SECTION_TABLE", "admin_section_table");
define ("ADMIN_SECTION_ID", "admin_section_id");
define ("ADMIN_SECTION_NAME", "section_name");
define ("ADMIN_SECTION_DESCRIPTION", "section_description");

/***************************************************/


/*****************  Page content Table *************/

define ("PAGE_CONTENT_TABLE", "page_content_table");
define ("PAGE_CONTENT_ID", "page_content_id");
define ("PAGE_HEADER_NAME", "page_header_name");
define ("PAGE_TITLE", "page_title");
define ("PAGE_CONTENT", "page_content");
define ("META_KEYWORDS", "meta_keywords");
define ("META_DESCRIPTION", "meta_description");
define ("META_TAGS", "other_meta_tags");
define ("PAGE_CONTENT_PERMISSION", "permission");

/***************************************************/


/*****************  Page Table *************/

define ("PAGE_TABLE", "page_table");
define ("PAGE_ID", "page_id");
define ("PAGE_NAME", "page_name");
define ("CUSTOM_PAGE", "custom_page");
define ("PAGE_PERMISSION", "permission");
define ("PAGE_SSL_PERMISSION", "ssl_status");

/***************************************************/

/*****************  Country Table *************/

define ("COUNTRY_TABLE", "country_table");
define ("COUNTRY_ID", "country_id");
define ("COUNTRY_NAME", "country_name");
define ("FLAG", "flag");
define ("CURRENCY", "currency");
define ("CURRENCY_SIGN", "currency_sign");
define ("COUNTRY_CODE", "country_code");

/*****************  User Table *************/

define ("USER_TABLE", "user_table");
define ("USER_ID", "user_id");
define ("VERIFY_CODE", "verify_code");
define ("USER_SETPASS_CODE", "user_setpass_code");
define ("USERNAME", "username");
define ("PASSWORD", "password");
define ("FIRSTNAME", "firstname");
define ("LASTNAME", "lastname");
define ("SEX", "sex");
define ("EMAIL", "email");
define ("CONTACT_NO", "contact_no");
define ("MOBILE", "mobile");
define ("CITY", "city");
define ("STATE", "state");
define ("ADDRESS1", "address1");
define ("ADDRESS2", "address2");
define ("ZIPCODE", "zipcode");

define ("SHIPPING_FIRSTNAME", "shipping_firstname");
define ("SHIPPING_LASTNAME", "shipping_lastname");
define ("SHIPPING_COUNTRY_ID", "shipping_country_id");
define ("SHIPPING_CITY", "shipping_city");
define ("SHIPPING_STATE", "shipping_state");
define ("SHIPPING_ADDRESS1", "shipping_address1");
define ("SHIPPING_ADDRESS2", "shipping_address2");
define ("SHIPPING_ZIPCODE", "shipping_zipcode");

define ("NEWSLETTER_SUBSCRIPTION", "newsletter_subscription");
define ("USER_LOGIN", "user_login");

/*****************  Category Table *************/

define ("TBL_CATEGORY", "tbl_category");

/*****************  Category Type Table *************/

define ("TBL_CATEGORY_TYPE", "tbl_category_type");

/*****************  Message Table *************/

define ("TBL_MESSAGE", "tbl_messages");

/*****************  Poster & Auction Table *************/

define ("TBL_POSTER", "tbl_poster");
define ("TBL_POSTER_TO_CATEGORY", "tbl_poster_to_category");
define ("TBL_POSTER_IMAGES", "tbl_poster_images");

define ("TBL_AUCTION", "tbl_auction");
define ("TBL_AUCTION_TYPE", "tbl_auction_type");

define ("TBL_EVENT", "tbl_event");

define ("TBL_BID", "tbl_bid");
define ("TBL_OFFER", "tbl_offer");

/*****************  Card Details Table *************/
define ("CARD_DETAIL", "card_details");
define ("TBL_WATCHING", "tbl_watching");
define ("TBL_WANTLIST", "tbl_wantlist");
define ("TBL_INVOICE", "tbl_invoice");
define ("TBL_INVOICE_TO_AUCTION", "tbl_invoice_to_auction");
define ("TBL_CART_HISTORY", "tbl_cart_history");
define ("TBL_AUCTION_WEEK", "tbl_auction_week");
define ("TBL_US_STATES", "tbl_us_state");
define ("TBL_PACKAGE_DIMENTION", "tbl_package_dimention");
define ("TBL_MPE_ADMIN_PAYMENT_TO_SELLER", "tbl_mpe_admin_payment_to_seller");
define ("TBL_PROXY_BID", "tbl_proxy_bid");
define ("TBL_SIZE_WEIGHT_COST_MASTER", "tbl_size_weight_cost_master");
define ("tbl_pending_bulkuploads", "TBL_PENDING_BULKUPLOADS");
//////////////////////////////////////////////////////////////////////

?>
<?php
/****************************************************
constants.php

Fallback PayPal configuration. Primary values are loaded
from config_table via configures.php. These only apply
if configures.php has not already defined them.

Called by CallerService.php.
****************************************************/

ini_set("error_reporting", "E_ALL & ~E_NOTICE");

// PayPal API credentials — defined from DB in configures.php
// These fallbacks are only used if configures.php was not loaded
if (!defined('API_USERNAME'))  define('API_USERNAME', '');
if (!defined('API_PASSWORD'))  define('API_PASSWORD', '');
if (!defined('API_SIGNATURE')) define('API_SIGNATURE', '');
if (!defined('API_ENDPOINT'))  define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
if (!defined('PAYPAL_URL'))    define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');

/*
 # Third party Email address that you granted permission to make api call.
 */
if (!defined('SUBJECT')) define('SUBJECT','');

/**
USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
*/
if (!defined('USE_PROXY')) define('USE_PROXY', FALSE);
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');

/**
# Version: this is the API version in the request.
*/
if (!defined('VERSION')) define('VERSION', '65.1');

// Ack related constants
define('ACK_SUCCESS', 'SUCCESS');
define('ACK_SUCCESS_WITH_WARNING', 'SUCCESSWITHWARNING');
?>

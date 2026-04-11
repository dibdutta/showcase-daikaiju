<?php
/**
 * Site Identity Constants — single source of truth for domain/email.
 * Include this file in configures.php AND standalone cron scripts.
 */

if (!defined('SITE_DOMAIN')) {
    define("SITE_DOMAIN", getenv('SITE_DOMAIN') ?: "mygodzillashop.com");
    define("SITE_URL", "https://www." . SITE_DOMAIN);
    define("SITE_HOST", "www." . SITE_DOMAIN);
    define("SITE_EMAIL", "info@kaijulink.com");
    define("SITE_EMAIL_SENDER", "MyGodzillaShop <info@kaijulink.com>");
}

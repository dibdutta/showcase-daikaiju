<?php
// sitemap.php is only reached when sitemap.xml does not exist as a static file.
// The admin panel at /admin/admin_generate_sitemap.php writes the static sitemap.xml.
// Once that file exists, Apache serves it directly without hitting this script.
define("INCLUDE_PATH", "./");
require_once INCLUDE_PATH . "lib/configures.php";
require_once INCLUDE_PATH . "lib/generate_sitemap.php";

set_time_limit(120);
ob_clean();

$result = generate_sitemap_xml($GLOBALS['db_connect'], SITE_URL);

header('Content-Type: application/xml; charset=UTF-8');
echo $result['xml'];

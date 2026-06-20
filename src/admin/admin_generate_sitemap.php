<?php
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";
require_once INCLUDE_PATH . "lib/common.php";
require_once INCLUDE_PATH . "lib/generate_sitemap.php";

chkAdminLogin();

$message = '';
$count   = 0;

if (isset($_POST['generate'])) {
    set_time_limit(120);
    $result  = generate_sitemap_xml($GLOBALS['db_connect'], SITE_URL);
    $outFile = INCLUDE_PATH . 'sitemap.xml';
    if (file_put_contents($outFile, $result['xml']) !== false) {
        $count   = $result['count'];
        $message = "success";
    } else {
        $message = "error";
    }
}

$smarty->assign('message', $message);
$smarty->assign('count',   $count);
$smarty->display('admin_generate_sitemap.tpl');

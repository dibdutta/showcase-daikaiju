<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
define("PAGE_HEADER_TEXT", "Generate Sitemap");

ob_start();

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";
require_once INCLUDE_PATH . "lib/generate_sitemap.php";

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin("admin_login.php");
}

dispmiddle();

ob_end_flush();

function dispmiddle()
{
    require_once INCLUDE_PATH . "lib/adminCommon.php";

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
}

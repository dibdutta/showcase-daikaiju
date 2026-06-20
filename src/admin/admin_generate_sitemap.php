<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ob_start();

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";
require_once INCLUDE_PATH . "lib/generate_sitemap.php";

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin("admin_login.php");
}

if (isset($_POST['generate'])) {
    dispmiddle(true);
} else {
    dispmiddle(false);
}

ob_end_flush();

function dispmiddle($doGenerate)
{
    require_once INCLUDE_PATH . "lib/adminCommon.php";

    $message = '';
    $count   = 0;

    if ($doGenerate) {
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

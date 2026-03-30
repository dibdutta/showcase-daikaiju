<?php
define("INCLUDE_PATH", "../");
ob_start();
require_once INCLUDE_PATH."lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';
if ($mode == "add_subcategory") {
    add_subcategory();
} elseif ($mode == "save_subcategory") {
    $chk = checkSubcategory();
    if ($chk == true) {
        save_subcategory();
    } else {
        add_subcategory();
    }
} elseif ($mode == "edit_subcategory") {
    edit_subcategory();
} elseif ($mode == "update_subcategory") {
    $chk = checkUpdateSubcategory();
    if ($chk == true) {
        update_subcategory();
    } else {
        edit_subcategory();
    }
} elseif ($mode == "delete") {
    del_subcategory();
} else {
    dispmiddle();
}

ob_end_flush();

/****** HELPERS ******/

function getGenreCategories() {
    $obj = new Category();
    $sql = "SELECT cat_id, cat_value FROM tbl_category WHERE fk_cat_type_id = '2' AND is_stills = '0' ORDER BY LOWER(cat_value) ASC";
    $rows = [];
    if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/****** LIST ******/

function dispmiddle() {
    define("PAGE_HEADER_TEXT", "Admin Subcategory Manager");
    require_once INCLUDE_PATH."lib/adminCommon.php";

    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

    $filter_cat_id = $_REQUEST['filter_cat_id'] ?? '';
    $smarty->assign('filter_cat_id', $filter_cat_id);

    $parentCategories = getGenreCategories();
    $smarty->assign('parentCategories', $parentCategories);

    $obj = new Subcategory();
    $total = $obj->countSubcategories($filter_cat_id);
    if ($total > 0) {
        $subcatRows = $obj->fetchAllWithParent($filter_cat_id, true, true);
        $smarty->assign('subcatRows', $subcatRows);
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", "", 5, 100, 5, 1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", 10, 1, 'view_link', 'headertext'));
    }
    $smarty->assign('total', $total);
    $smarty->display('admin_subcategory_manager.tpl');
}

/****** ADD ******/

function add_subcategory() {
    define("PAGE_HEADER_TEXT", "Admin Subcategory Manager");
    require_once INCLUDE_PATH."lib/adminCommon.php";

    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

    $smarty->assign('parentCategories', getGenreCategories());

    foreach ($_REQUEST as $key => $value) {
        $smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
        $smarty->assign($key, $value);
    }

    $smarty->display('admin_add_subcategory_manager.tpl');
}

/****** SAVE ******/

function checkSubcategory() {
    $errCounter = 0;
    extract($_REQUEST);

    if (empty($fk_cat_id)) {
        $GLOBALS['fk_cat_id_err'] = "Please select a parent category.";
        $errCounter++;
    }
    if (empty($subcat_value)) {
        $GLOBALS['subcat_value_err'] = "Please enter a subcategory name.";
        $errCounter++;
    } else {
        $sql = "SELECT COUNT(*) as total FROM tbl_subcategory
                WHERE fk_cat_id = '" . (int)$fk_cat_id . "'
                AND subcat_value = '" . mysqli_real_escape_string($GLOBALS['db_connect'], $subcat_value) . "'";
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_assoc($rs);
        if ((int)$row['total'] > 0) {
            $GLOBALS['subcat_value_err'] = "This subcategory already exists under the selected category.";
            $errCounter++;
        }
    }
    return $errCounter == 0;
}

function save_subcategory() {
    extract($_REQUEST);
    $obj = new Subcategory();
    $chk = $obj->updateData(TBL_SUBCATEGORY, [
        'fk_cat_id'    => (int)$fk_cat_id,
        'subcat_value' => trim($subcat_value),
        'is_active'    => 1,
    ]);
    if ($chk) {
        $_SESSION['adminErr'] = "Subcategory created successfully.";
    } else {
        $_SESSION['adminErr'] = "Failed to create subcategory.";
    }
    header("location: " . PHP_SELF);
    exit;
}

/****** EDIT ******/

function edit_subcategory() {
    define("PAGE_HEADER_TEXT", "Admin Subcategory Manager");
    require_once INCLUDE_PATH."lib/adminCommon.php";

    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->assign("decoded_string", easy_decrypt($_REQUEST['encoded_string'] ?? ''));

    $subcat_id = (int)($_REQUEST['subcat_id'] ?? 0);
    $obj = new Subcategory();
    $row = $obj->selectData(TBL_SUBCATEGORY, ['*'], ['subcat_id' => $subcat_id]);
    $smarty->assign('subcat', $row[0] ?? []);
    $smarty->assign('subcat_id', $subcat_id);
    $smarty->assign('parentCategories', getGenreCategories());

    foreach ($_POST as $key => $value) {
        $smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
    }

    $smarty->display('admin_edit_subcategory_manager.tpl');
}

/****** UPDATE ******/

function checkUpdateSubcategory() {
    $errCounter = 0;
    extract($_REQUEST);

    if (empty($subcat_value)) {
        $GLOBALS['subcat_value_err'] = "Please enter a subcategory name.";
        $errCounter++;
    } else {
        $sql = "SELECT COUNT(*) as total FROM tbl_subcategory
                WHERE fk_cat_id = '" . (int)$fk_cat_id . "'
                AND subcat_value = '" . mysqli_real_escape_string($GLOBALS['db_connect'], $subcat_value) . "'
                AND subcat_id != '" . (int)$subcat_id . "'";
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_assoc($rs);
        if ((int)$row['total'] > 0) {
            $GLOBALS['subcat_value_err'] = "This subcategory already exists under the selected category.";
            $errCounter++;
        }
    }
    return $errCounter == 0;
}

function update_subcategory() {
    extract($_REQUEST);
    $obj = new Subcategory();
    $chk = $obj->updateData(TBL_SUBCATEGORY, [
        'fk_cat_id'    => (int)$fk_cat_id,
        'subcat_value' => trim($subcat_value),
    ], ['subcat_id' => (int)$subcat_id], true);
    if ($chk) {
        $_SESSION['adminErr'] = "Subcategory updated successfully.";
    } else {
        $_SESSION['adminErr'] = "Failed to update subcategory.";
    }
    header("location: " . PHP_SELF);
    exit;
}

/****** DELETE ******/

function del_subcategory() {
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $subcat_id = (int)($_REQUEST['subcat_id'] ?? 0);

    $obj = new Subcategory();
    if ($obj->isUsedByPoster($subcat_id)) {
        $_SESSION['adminErr'] = "Cannot delete: this subcategory is assigned to one or more posters.";
    } else {
        $obj->updateData(TBL_SUBCATEGORY, ['is_active' => 0], ['subcat_id' => $subcat_id], true);
        $_SESSION['adminErr'] = "Subcategory deleted successfully.";
    }
    header("location: " . PHP_SELF);
    exit;
}
?>

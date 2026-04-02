<?php
define("PAGE_HEADER_TEXT", "Shop Category Manager");
define("INCLUDE_PATH", "../");
ob_start();
require_once INCLUDE_PATH."lib/inc.php";

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin("admin_login.php");
}

$mode = $_REQUEST['mode'] ?? '';
if ($mode == "add_shop_category") {
    add_shop_category();
} elseif ($mode == "save_shop_category") {
    $chk = checkShopCategory();
    if ($chk) { save_shop_category(); } else { add_shop_category(); }
} elseif ($mode == "edit_shop_category") {
    edit_shop_category();
} elseif ($mode == "update_shop_category") {
    $chk = checkUpdateShopCategory();
    if ($chk) { update_shop_category(); } else { edit_shop_category(); }
} elseif ($mode == "delete") {
    del_shop_category();
} else {
    dispmiddle();
}

ob_end_flush();

function dispmiddle() {
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $obj = new ShopCategory();
    $total = $obj->countAll();
    if ($total > 0) {
        $rows = $obj->fetchAllForAdmin(true);
        $smarty->assign('shopCatRows', $rows);
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", "", 5, 100, 5, 1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", 10, 1, 'view_link', 'headertext'));
    }
    $smarty->assign('total', $total);
    $smarty->display('admin_shop_category_manager.tpl');
}

function add_shop_category() {
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    foreach ($_REQUEST as $key => $value) {
        $smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
        $smarty->assign($key, $value);
    }
    $smarty->display('admin_add_shop_category_manager.tpl');
}

function checkShopCategory() {
    $errCounter = 0;
    if (empty(trim($_REQUEST['shop_cat_name'] ?? ''))) {
        $GLOBALS['shop_cat_name_err'] = "Please enter a category name.";
        $errCounter++;
    } else {
        $sql = "SELECT COUNT(*) as total FROM tbl_shop_category WHERE shop_cat_name = '" .
               mysqli_real_escape_string($GLOBALS['db_connect'], trim($_REQUEST['shop_cat_name'])) . "'";
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_assoc($rs);
        if ((int)$row['total'] > 0) {
            $GLOBALS['shop_cat_name_err'] = "This category name already exists.";
            $errCounter++;
        }
    }
    return $errCounter == 0;
}

function save_shop_category() {
    $obj = new ShopCategory();
    $chk = $obj->updateData(TBL_SHOP_CATEGORY, [
        'shop_cat_name' => trim($_REQUEST['shop_cat_name']),
        'sort_order'    => (int)($_REQUEST['sort_order'] ?? 0),
        'is_active'     => 1,
    ]);
    $_SESSION['adminErr'] = $chk ? "Category created successfully." : "Failed to create category.";
    header("location: " . PHP_SELF);
    exit;
}

function edit_shop_category() {
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $smarty->assign("encoded_string", easy_crypt($_SERVER['REQUEST_URI']));
    $shop_cat_id = (int)($_REQUEST['shop_cat_id'] ?? 0);
    $obj = new ShopCategory();
    $row = $obj->selectData(TBL_SHOP_CATEGORY, ['*'], ['shop_cat_id' => $shop_cat_id]);
    $smarty->assign('shopCat', $row[0] ?? []);
    $smarty->assign('shop_cat_id', $shop_cat_id);
    foreach ($_POST as $key => $value) {
        $smarty->assign($key.'_err', $GLOBALS[$key.'_err'] ?? '');
    }
    $smarty->display('admin_edit_shop_category_manager.tpl');
}

function checkUpdateShopCategory() {
    $errCounter = 0;
    $shop_cat_id = (int)($_REQUEST['shop_cat_id'] ?? 0);
    if (empty(trim($_REQUEST['shop_cat_name'] ?? ''))) {
        $GLOBALS['shop_cat_name_err'] = "Please enter a category name.";
        $errCounter++;
    } else {
        $sql = "SELECT COUNT(*) as total FROM tbl_shop_category
                WHERE shop_cat_name = '" . mysqli_real_escape_string($GLOBALS['db_connect'], trim($_REQUEST['shop_cat_name'])) . "'
                AND shop_cat_id != '$shop_cat_id'";
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_assoc($rs);
        if ((int)$row['total'] > 0) {
            $GLOBALS['shop_cat_name_err'] = "This category name already exists.";
            $errCounter++;
        }
    }
    return $errCounter == 0;
}

function update_shop_category() {
    $shop_cat_id = (int)($_REQUEST['shop_cat_id'] ?? 0);
    $obj = new ShopCategory();
    $chk = $obj->updateData(TBL_SHOP_CATEGORY, [
        'shop_cat_name' => trim($_REQUEST['shop_cat_name']),
        'sort_order'    => (int)($_REQUEST['sort_order'] ?? 0),
        'is_active'     => (int)($_REQUEST['is_active'] ?? 1),
    ], ['shop_cat_id' => $shop_cat_id], true);
    $_SESSION['adminErr'] = $chk ? "Category updated successfully." : "Failed to update category.";
    header("location: " . PHP_SELF);
    exit;
}

function del_shop_category() {
    require_once INCLUDE_PATH."lib/adminCommon.php";
    $shop_cat_id = (int)($_REQUEST['shop_cat_id'] ?? 0);
    $obj = new ShopCategory();
    if ($obj->isUsedByPoster($shop_cat_id)) {
        $_SESSION['adminErr'] = "Cannot delete: this category is assigned to one or more posters.";
    } else {
        $sql = "SELECT COUNT(*) as total FROM tbl_subcategory WHERE fk_shop_cat_id = '$shop_cat_id' AND is_active = '1'";
        $rs = mysqli_query($GLOBALS['db_connect'], $sql);
        $row = mysqli_fetch_assoc($rs);
        if ((int)$row['total'] > 0) {
            $_SESSION['adminErr'] = "Cannot delete: this category has active subcategories. Remove them first.";
        } else {
            $obj->updateData(TBL_SHOP_CATEGORY, ['is_active' => 0], ['shop_cat_id' => $shop_cat_id], true);
            $_SESSION['adminErr'] = "Category deleted successfully.";
        }
    }
    header("location: " . PHP_SELF);
    exit;
}
?>

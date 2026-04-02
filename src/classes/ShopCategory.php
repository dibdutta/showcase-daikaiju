<?php
class ShopCategory extends DBCommon {

    public function __construct() {
        $this->primaryKey = 'shop_cat_id';
        $this->orderBy    = 'sort_order';
        parent::__construct();
    }

    function fetchAll() {
        $sql = "SELECT * FROM tbl_shop_category WHERE is_active = '1' ORDER BY sort_order ASC, LOWER(shop_cat_name) ASC";
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) { $dataArr[] = $row; }
        }
        return $dataArr;
    }

    function fetchAllForAdmin($isLimit = false) {
        $sql = "SELECT * FROM tbl_shop_category ORDER BY sort_order ASC, LOWER(shop_cat_name) ASC";
        if ($isLimit) {
            $sql .= " LIMIT " . $this->offset . "," . $this->toShow;
        }
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) { $dataArr[] = $row; }
        }
        return $dataArr;
    }

    function countAll() {
        $sql = "SELECT COUNT(*) as total FROM tbl_shop_category";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return (int)$row['total'];
        }
        return 0;
    }

    function isUsedByPoster($shop_cat_id) {
        $shop_cat_id = (int)$shop_cat_id;
        $sql = "SELECT COUNT(*) as total FROM tbl_poster_to_shop_category WHERE fk_shop_cat_id = '$shop_cat_id'";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            if ((int)$row['total'] > 0) return true;
        }
        $sql2 = "SELECT COUNT(*) as total FROM tbl_poster_to_shop_category_live WHERE fk_shop_cat_id = '$shop_cat_id'";
        if ($rs2 = mysqli_query($GLOBALS['db_connect'], $sql2)) {
            $row2 = mysqli_fetch_assoc($rs2);
            if ((int)$row2['total'] > 0) return true;
        }
        return false;
    }

    function getPosterShopCatId($poster_id, $live = false) {
        $poster_id = (int)$poster_id;
        $tbl = $live ? 'tbl_poster_to_shop_category_live' : 'tbl_poster_to_shop_category';
        $sql = "SELECT fk_shop_cat_id FROM $tbl WHERE fk_poster_id = '$poster_id' LIMIT 1";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return $row['fk_shop_cat_id'] ?? '';
        }
        return '';
    }

    function savePosterShopCat($poster_id, $shop_cat_id, $live = false) {
        $poster_id  = (int)$poster_id;
        $shop_cat_id = (int)$shop_cat_id;
        $tbl = $live ? 'tbl_poster_to_shop_category_live' : 'tbl_poster_to_shop_category';
        mysqli_query($GLOBALS['db_connect'], "DELETE FROM $tbl WHERE fk_poster_id = '$poster_id'");
        if ($shop_cat_id > 0) {
            mysqli_query($GLOBALS['db_connect'],
                "INSERT IGNORE INTO $tbl (fk_poster_id, fk_shop_cat_id) VALUES ('$poster_id', '$shop_cat_id')");
        }
    }

    function deletePosterShopCat($poster_id, $live = false) {
        $poster_id = (int)$poster_id;
        $tbl = $live ? 'tbl_poster_to_shop_category_live' : 'tbl_poster_to_shop_category';
        mysqli_query($GLOBALS['db_connect'], "DELETE FROM $tbl WHERE fk_poster_id = '$poster_id'");
    }
}
?>

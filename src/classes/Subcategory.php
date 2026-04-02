<?php
class Subcategory extends DBCommon {

    public function __construct() {
        $this->primaryKey = 'subcat_id';
        $this->orderBy    = 'LOWER(subcat_value)';
        parent::__construct();
    }

    function fetchByCategory($shop_cat_id) {
        $shop_cat_id = (int)$shop_cat_id;
        $sql = "SELECT * FROM tbl_subcategory
                WHERE fk_shop_cat_id = '$shop_cat_id' AND is_active = '1'
                ORDER BY LOWER(subcat_value) ASC";
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) { $dataArr[] = $row; }
        }
        return $dataArr;
    }

    function fetchAllGrouped() {
        $sql = "SELECT s.*, sc.shop_cat_name AS cat_name
                FROM tbl_subcategory s
                JOIN tbl_shop_category sc ON s.fk_shop_cat_id = sc.shop_cat_id
                WHERE s.is_active = '1'
                ORDER BY sc.shop_cat_name ASC, LOWER(s.subcat_value) ASC";
        $grouped = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $grouped[$row['fk_shop_cat_id']][] = [
                    'subcat_id'    => $row['subcat_id'],
                    'subcat_value' => $row['subcat_value'],
                ];
            }
        }
        return $grouped;
    }

    function fetchAllWithParent($filter_shop_cat_id = '', $isOrdered = false, $isLimit = false) {
        $where = "WHERE s.is_active = '1'";
        if ($filter_shop_cat_id != '') {
            $where .= " AND s.fk_shop_cat_id = '" . (int)$filter_shop_cat_id . "'";
        }
        $sql = "SELECT s.*, sc.shop_cat_name AS cat_name
                FROM tbl_subcategory s
                JOIN tbl_shop_category sc ON s.fk_shop_cat_id = sc.shop_cat_id
                $where
                ORDER BY sc.shop_cat_name ASC, LOWER(s.subcat_value) ASC";
        if ($isLimit) {
            $sql .= " LIMIT " . $this->offset . "," . $this->toShow;
        }
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) { $dataArr[] = $row; }
        }
        return $dataArr;
    }

    function countSubcategories($filter_shop_cat_id = '') {
        $where = "WHERE s.is_active = '1'";
        if ($filter_shop_cat_id != '') {
            $where .= " AND s.fk_shop_cat_id = '" . (int)$filter_shop_cat_id . "'";
        }
        $sql = "SELECT COUNT(*) as total FROM tbl_subcategory s $where";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return (int)$row['total'];
        }
        return 0;
    }

    function isUsedByPoster($subcat_id) {
        $subcat_id = (int)$subcat_id;
        $sql = "SELECT COUNT(*) as total FROM tbl_poster_to_subcategory WHERE fk_subcat_id = '$subcat_id'";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            if ((int)$row['total'] > 0) return true;
        }
        $sql2 = "SELECT COUNT(*) as total FROM tbl_poster_to_subcategory_live WHERE fk_subcat_id = '$subcat_id'";
        if ($rs2 = mysqli_query($GLOBALS['db_connect'], $sql2)) {
            $row2 = mysqli_fetch_assoc($rs2);
            if ((int)$row2['total'] > 0) return true;
        }
        return false;
    }

    function selectSubcategoryName($subcat_id) {
        $subcat_id = (int)$subcat_id;
        $sql = "SELECT subcat_value FROM tbl_subcategory WHERE subcat_id = '$subcat_id'";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return $row['subcat_value'] ?? '';
        }
        return '';
    }

    function getPosterSubcatId($poster_id, $live = false) {
        $poster_id = (int)$poster_id;
        $tbl = $live ? 'tbl_poster_to_subcategory_live' : 'tbl_poster_to_subcategory';
        $sql = "SELECT fk_subcat_id FROM $tbl WHERE fk_poster_id = '$poster_id' LIMIT 1";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return $row['fk_subcat_id'] ?? '';
        }
        return '';
    }

    function savePosterSubcat($poster_id, $subcat_id, $live = false) {
        $poster_id = (int)$poster_id;
        $subcat_id = (int)$subcat_id;
        $tbl = $live ? 'tbl_poster_to_subcategory_live' : 'tbl_poster_to_subcategory';
        mysqli_query($GLOBALS['db_connect'], "DELETE FROM $tbl WHERE fk_poster_id = '$poster_id'");
        if ($subcat_id > 0) {
            mysqli_query($GLOBALS['db_connect'],
                "INSERT IGNORE INTO $tbl (fk_poster_id, fk_subcat_id) VALUES ('$poster_id', '$subcat_id')");
        }
    }

    function deletePosterSubcat($poster_id, $live = false) {
        $poster_id = (int)$poster_id;
        $tbl = $live ? 'tbl_poster_to_subcategory_live' : 'tbl_poster_to_subcategory';
        mysqli_query($GLOBALS['db_connect'], "DELETE FROM $tbl WHERE fk_poster_id = '$poster_id'");
    }
}
?>

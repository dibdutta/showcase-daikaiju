<?php
/**
 * Handles all functions related to the Subcategory module.
 */
class Subcategory extends DBCommon {

    public function __construct() {
        $this->primaryKey = 'subcat_id';
        $this->orderBy    = 'LOWER(subcat_value)';
        parent::__construct();
    }

    /**
     * Fetch all active subcategories for a given parent category.
     */
    function fetchByCategory($cat_id) {
        $cat_id = (int)$cat_id;
        $sql = "SELECT * FROM tbl_subcategory
                WHERE fk_cat_id = '$cat_id' AND is_active = '1'
                ORDER BY LOWER(subcat_value) ASC";
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $dataArr[] = $row;
            }
        }
        return $dataArr;
    }

    /**
     * Fetch all active subcategories grouped by parent cat_id.
     * Returns associative array: [ cat_id => [ [subcat_id, subcat_value], ... ] ]
     */
    function fetchAllGrouped() {
        $sql = "SELECT s.*, c.cat_value AS cat_name
                FROM tbl_subcategory s
                JOIN tbl_category c ON s.fk_cat_id = c.cat_id
                WHERE s.is_active = '1'
                ORDER BY c.cat_value ASC, LOWER(s.subcat_value) ASC";
        $grouped = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $grouped[$row['fk_cat_id']][] = [
                    'subcat_id'    => $row['subcat_id'],
                    'subcat_value' => $row['subcat_value'],
                ];
            }
        }
        return $grouped;
    }

    /**
     * Fetch all subcategories (with parent name) for admin list view.
     */
    function fetchAllWithParent($filter_cat_id = '', $isOrdered = false, $isLimit = false) {
        $where = "WHERE s.is_active = '1'";
        if ($filter_cat_id != '') {
            $where .= " AND s.fk_cat_id = '" . (int)$filter_cat_id . "'";
        }
        $sql = "SELECT s.*, c.cat_value AS cat_name
                FROM tbl_subcategory s
                JOIN tbl_category c ON s.fk_cat_id = c.cat_id
                $where
                ORDER BY c.cat_value ASC, LOWER(s.subcat_value) ASC";
        if ($isLimit) {
            $sql .= " LIMIT " . $this->offset . "," . $this->toShow;
        }
        $dataArr = [];
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $dataArr[] = $row;
            }
        }
        return $dataArr;
    }

    /**
     * Count subcategories, optionally filtered by parent cat_id.
     */
    function countSubcategories($filter_cat_id = '') {
        $where = "WHERE s.is_active = '1'";
        if ($filter_cat_id != '') {
            $where .= " AND s.fk_cat_id = '" . (int)$filter_cat_id . "'";
        }
        $sql = "SELECT COUNT(*) as total FROM tbl_subcategory s $where";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return (int)$row['total'];
        }
        return 0;
    }

    /**
     * Check if a subcategory is used by any poster (live or archived).
     */
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

    /**
     * Get subcategory value string for a given subcat_id.
     */
    function selectSubcategoryName($subcat_id) {
        $subcat_id = (int)$subcat_id;
        $sql = "SELECT subcat_value FROM tbl_subcategory WHERE subcat_id = '$subcat_id'";
        if ($rs = mysqli_query($GLOBALS['db_connect'], $sql)) {
            $row = mysqli_fetch_assoc($rs);
            return $row['subcat_value'] ?? '';
        }
        return '';
    }

    /**
     * Get the poster's current subcategory id from mapping table.
     * $live = true for weekly auctions (live table), false for fixed/monthly.
     */
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

    /**
     * Save (replace) poster-to-subcategory mapping.
     */
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

    /**
     * Delete poster-to-subcategory mapping when poster is deleted.
     */
    function deletePosterSubcat($poster_id, $live = false) {
        $poster_id = (int)$poster_id;
        $tbl = $live ? 'tbl_poster_to_subcategory_live' : 'tbl_poster_to_subcategory';
        mysqli_query($GLOBALS['db_connect'], "DELETE FROM $tbl WHERE fk_poster_id = '$poster_id'");
    }
}
?>

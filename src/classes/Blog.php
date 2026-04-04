<?php

class Blog {

    var $blogID;
    var $title;
    var $slug;
    var $content;
    var $featuredImage;
    var $status;
    var $postIP;

    // comment fields
    var $commentID;
    var $commenterName;
    var $commenterEmail;
    var $commentText;

    var $offset;
    var $toShow;
    var $orderBy;
    var $orderType;

    function __construct() {
        $this->postIP    = $_SERVER['REMOTE_ADDR'];
        $this->status    = 1;
        $this->offset    = (isset($GLOBALS['offset']) && $GLOBALS['offset'] !== '') ? (int)$GLOBALS['offset'] : 0;
        $this->toShow    = (isset($GLOBALS['toshow']) && $GLOBALS['toshow'] !== '') ? (int)$GLOBALS['toshow'] : 20;
        $this->orderBy   = (isset($GLOBALS['order_by']) && $GLOBALS['order_by'] !== '') ? $GLOBALS['order_by'] : 'post_date';
        $this->orderType = (isset($GLOBALS['order_type']) && $GLOBALS['order_type'] !== '') ? $GLOBALS['order_type'] : 'DESC';
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    function db() {
        return $GLOBALS['db_connect'];
    }

    function makeSlug($title) {
        $slug  = strtolower(trim($title));
        $slug  = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug  = trim($slug, '-');
        $base  = $slug;
        $i     = 1;
        $check = $slug;
        while (true) {
            $sql = "SELECT COUNT(blog_id) AS cnt FROM tbl_blog WHERE slug = '" . mysqli_real_escape_string($this->db(), $check) . "'";
            if ($this->blogID) {
                $sql .= " AND blog_id != '" . (int)$this->blogID . "'";
            }
            $res = mysqli_query($this->db(), $sql);
            if (!$res) return $check;
            $row = mysqli_fetch_array($res);
            if ($row['cnt'] == 0) {
                return $check;
            }
            $check = $base . '-' . $i++;
        }
    }

    // ── Blog CRUD ─────────────────────────────────────────────────────────────

    function totalBlogs($status = null) {
        $sql = "SELECT COUNT(blog_id) AS cnt FROM tbl_blog WHERE 1";
        if ($status !== null) {
            $sql .= " AND status = " . (int)$status;
        }
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return 0;
        $row = mysqli_fetch_array($res);
        return (int)($row['cnt'] ?? 0);
    }

    function fetchBlogs($status = null) {
        $orderBy   = $this->orderBy   ?: 'post_date';
        $orderType = $this->orderType ?: 'DESC';
        $sql = "SELECT * FROM tbl_blog WHERE 1";
        if ($status !== null) {
            $sql .= " AND status = " . (int)$status;
        }
        $sql .= " ORDER BY {$orderBy} {$orderType} LIMIT {$this->offset}, {$this->toShow}";
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return [];
        $result = [];
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    function fetchBlogByID() {
        $sql = "SELECT * FROM tbl_blog WHERE blog_id = " . (int)$this->blogID;
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return [];
        return mysqli_fetch_array($res, MYSQLI_ASSOC) ?: [];
    }

    function fetchBlogBySlug($slug) {
        $slug = mysqli_real_escape_string($this->db(), $slug);
        $sql  = "SELECT * FROM tbl_blog WHERE slug = '{$slug}' AND status = 1";
        $res  = mysqli_query($this->db(), $sql);
        if (!$res) return [];
        return mysqli_fetch_array($res, MYSQLI_ASSOC) ?: [];
    }

    function createBlog() {
        $this->slug = $this->makeSlug($this->title);
        $sql = "INSERT INTO tbl_blog SET
                title          = '" . addslashes($this->title) . "',
                slug           = '" . mysqli_real_escape_string($this->db(), $this->slug) . "',
                content        = '" . addslashes($this->content) . "',
                featured_image = '" . mysqli_real_escape_string($this->db(), $this->featuredImage) . "',
                status         = " . (int)$this->status . ",
                post_date      = NOW(),
                update_date    = NOW(),
                post_ip        = '" . $this->postIP . "'";
        if (mysqli_query($this->db(), $sql)) {
            $this->blogID = mysqli_insert_id($this->db());
            return true;
        }
        return false;
    }

    function updateBlog() {
        $this->slug = $this->makeSlug($this->title);
        $sql = "UPDATE tbl_blog SET
                title          = '" . addslashes($this->title) . "',
                slug           = '" . mysqli_real_escape_string($this->db(), $this->slug) . "',
                content        = '" . addslashes($this->content) . "',
                featured_image = '" . mysqli_real_escape_string($this->db(), $this->featuredImage) . "',
                status         = " . (int)$this->status . ",
                update_date    = NOW(),
                post_ip        = '" . $this->postIP . "'
                WHERE blog_id  = " . (int)$this->blogID;
        return (bool)mysqli_query($this->db(), $sql);
    }

    function toggleStatus() {
        $sql = "SELECT status FROM tbl_blog WHERE blog_id = " . (int)$this->blogID;
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return 0;
        $row = mysqli_fetch_array($res);
        $new = ($row['status'] == 1) ? 0 : 1;
        mysqli_query($this->db(), "UPDATE tbl_blog SET status = {$new}, update_date = NOW() WHERE blog_id = " . (int)$this->blogID);
        return $new;
    }

    function deleteBlog() {
        mysqli_query($this->db(), "DELETE FROM tbl_blog_comments WHERE blog_id = " . (int)$this->blogID);
        return (bool)mysqli_query($this->db(), "DELETE FROM tbl_blog WHERE blog_id = " . (int)$this->blogID);
    }

    // ── Comments ──────────────────────────────────────────────────────────────

    function totalComments($blogID = null, $status = null) {
        $sql = "SELECT COUNT(comment_id) AS cnt FROM tbl_blog_comments WHERE 1";
        if ($blogID !== null) {
            $sql .= " AND blog_id = " . (int)$blogID;
        }
        if ($status !== null) {
            $sql .= " AND status = " . (int)$status;
        }
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return 0;
        $row = mysqli_fetch_array($res);
        return (int)($row['cnt'] ?? 0);
    }

    function fetchComments($blogID, $status = null) {
        $sql = "SELECT * FROM tbl_blog_comments WHERE blog_id = " . (int)$blogID;
        if ($status !== null) {
            $sql .= " AND status = " . (int)$status;
        }
        $sql .= " ORDER BY post_date ASC";
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return [];
        $result = [];
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    function fetchAllComments() {
        $orderType = $this->orderType ?: 'DESC';
        $sql = "SELECT c.*, b.title AS blog_title
                FROM tbl_blog_comments c
                LEFT JOIN tbl_blog b ON b.blog_id = c.blog_id
                ORDER BY c.post_date {$orderType}
                LIMIT {$this->offset}, {$this->toShow}";
        $res = mysqli_query($this->db(), $sql);
        if (!$res) return [];
        $result = [];
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }

    function addComment() {
        $sql = "INSERT INTO tbl_blog_comments SET
                blog_id         = " . (int)$this->blogID . ",
                commenter_name  = '" . addslashes($this->commenterName) . "',
                commenter_email = '" . addslashes($this->commenterEmail) . "',
                comment_text    = '" . addslashes($this->commentText) . "',
                status          = 0,
                post_date       = NOW(),
                post_ip         = '" . $this->postIP . "'";
        return (bool)mysqli_query($this->db(), $sql);
    }

    function approveComment() {
        $sql = "UPDATE tbl_blog_comments SET status = 1 WHERE comment_id = " . (int)$this->commentID;
        return (bool)mysqli_query($this->db(), $sql);
    }

    function deleteComment() {
        $sql = "DELETE FROM tbl_blog_comments WHERE comment_id = " . (int)$this->commentID;
        return (bool)mysqli_query($this->db(), $sql);
    }
}
?>

<?php
define('PAGE_HEADER_TEXT', 'Blog / Articles Manager');
ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';
require_once INCLUDE_PATH . 'FCKeditor/fckeditor.php';
require_once INCLUDE_PATH . 'classes/Blog.php';

if (!isset($_SESSION['adminLoginID'])) {
    redirect_admin('admin_login.php');
}

$mode = $_REQUEST['mode'] ?? '';

if ($mode === 'create') {
    show_form();
} elseif ($mode === 'save_create') {
    save_blog(false);
} elseif ($mode === 'edit') {
    show_form((int)$_REQUEST['blog_id']);
} elseif ($mode === 'save_edit') {
    save_blog(true);
} elseif ($mode === 'delete') {
    delete_blog();
} elseif ($mode === 'comments') {
    show_comments();
} elseif ($mode === 'approve_comment') {
    approve_comment();
} elseif ($mode === 'delete_comment') {
    delete_comment();
} else {
    list_blogs();
}

ob_end_flush();

// ── List ─────────────────────────────────────────────────────────────────────

function list_blogs() {
    require_once INCLUDE_PATH . 'lib/adminCommon.php';
    $blog  = new Blog();
    $total = $blog->totalBlogs();
    $rows  = $total > 0 ? $blog->fetchBlogs() : [];

    $pendingComments = $blog->totalComments(null, 0);

    $smarty->assign('blogs', $rows);
    $smarty->assign('total', $total);
    $smarty->assign('pendingComments', $pendingComments);
    $smarty->assign('encoded_string', easy_crypt($_SERVER['REQUEST_URI']));

    if ($total > 0) {
        $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], 'headertext', '', 5, 100, 5, 1));
        $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], 'headertext', 10, 1, 'view_link', 'headertext'));
    }

    $smarty->display('admin_blog_list.tpl');
}

// ── Create / Edit form ────────────────────────────────────────────────────────

function show_form($blogID = null) {
    require_once INCLUDE_PATH . 'lib/adminCommon.php';

    $data = [];
    if ($blogID) {
        $blog = new Blog();
        $blog->blogID = $blogID;
        $data = $blog->fetchBlogByID();
    }

    // Error repopulation
    foreach (['title', 'content', 'featured_image', 'status'] as $f) {
        if (!isset($data[$f])) {
            $data[$f] = $GLOBALS[$f . '_val'] ?? '';
        }
    }
    if (!isset($data['status'])) {
        $data['status'] = 1;
    }

    ob_start();
    $oFCK = new FCKeditor('content');
    $oFCK->BasePath = '../FCKeditor/';
    $oFCK->Value    = $data['content'] ?? '';
    $oFCK->Width    = '100%';
    $oFCK->Height   = '500';
    $oFCK->Create();
    $editorHTML = ob_get_clean();

    $smarty->assign('editor', $editorHTML);
    $smarty->assign('blog', $data);
    $smarty->assign('blog_id', $blogID);
    $smarty->assign('mode', $blogID ? 'save_edit' : 'save_create');
    $smarty->assign('encoded_string', easy_crypt($_SERVER['REQUEST_URI']));

    foreach (['title_err', 'content_err'] as $e) {
        $smarty->assign($e, $GLOBALS[$e] ?? '');
    }

    $smarty->display('admin_blog_edit.tpl');
}

// ── Save (create or edit) ─────────────────────────────────────────────────────

function save_blog($isEdit) {
    $title   = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $status  = (int)($_POST['status'] ?? 1);
    $blogID  = (int)($_POST['blog_id'] ?? 0);

    $errCount = 0;
    if ($title === '') {
        $GLOBALS['title_err'] = 'Please enter a title.';
        $errCount++;
    }
    if (strip_tags($content) === '') {
        $GLOBALS['content_err'] = 'Please enter content.';
        $errCount++;
    }

    if ($errCount > 0) {
        $GLOBALS['title_val']   = $title;
        $GLOBALS['content_val'] = $content;
        $GLOBALS['status_val']  = $status;
        show_form($isEdit ? $blogID : null);
        return;
    }

    // Handle featured image upload
    $featuredImage = '';
    if ($isEdit) {
        $blog = new Blog();
        $blog->blogID = $blogID;
        $existing = $blog->fetchBlogByID();
        $featuredImage = $existing['featured_image'] ?? '';
    }

    if (!empty($_FILES['featured_image']['tmp_name'])) {
        $ext     = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($ext, $allowed)) {
            $uploadDir = INCLUDE_PATH . 'blog_images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = 'blog_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadDir . $filename)) {
                $featuredImage = $filename;
            }
        }
    }

    $blog = new Blog();
    $blog->title         = $title;
    $blog->content       = $content;
    $blog->status        = $status;
    $blog->featuredImage = $featuredImage;

    if ($isEdit) {
        $blog->blogID = $blogID;
        $ok = $blog->updateBlog();
        $_SESSION['adminErr'] = $ok ? 'Blog post updated successfully.' : 'Failed to update blog post.';
    } else {
        $ok = $blog->createBlog();
        $_SESSION['adminErr'] = $ok ? 'Blog post created successfully.' : 'Failed to create blog post.';
    }

    redirect_admin('admin_blog_manager.php');
}

// ── Delete ────────────────────────────────────────────────────────────────────

function delete_blog() {
    $blog = new Blog();
    $blog->blogID = (int)($_REQUEST['blog_id'] ?? 0);
    $ok = $blog->deleteBlog();
    $_SESSION['adminErr'] = $ok ? 'Blog post deleted successfully.' : 'Failed to delete blog post.';
    redirect_admin('admin_blog_manager.php');
}

// ── Comments ──────────────────────────────────────────────────────────────────

function show_comments() {
    require_once INCLUDE_PATH . 'lib/adminCommon.php';
    $blog   = new Blog();
    $blogID = (int)($_REQUEST['blog_id'] ?? 0);

    if ($blogID) {
        $blog->blogID = $blogID;
        $post     = $blog->fetchBlogByID();
        $comments = $blog->fetchComments($blogID);
        $smarty->assign('post', $post);
    } else {
        // All comments across all posts
        $comments = $blog->fetchAllComments();
        $smarty->assign('post', null);
    }

    $smarty->assign('comments', $comments);
    $smarty->assign('blog_id', $blogID);
    $smarty->assign('encoded_string', easy_crypt($_SERVER['REQUEST_URI']));
    $smarty->display('admin_blog_comments.tpl');
}

function approve_comment() {
    $blog = new Blog();
    $blog->commentID = (int)($_REQUEST['comment_id'] ?? 0);
    $blogID          = (int)($_REQUEST['blog_id'] ?? 0);
    $ok = $blog->approveComment();
    $_SESSION['adminErr'] = $ok ? 'Comment approved.' : 'Failed to approve comment.';
    $qs = $blogID ? '?mode=comments&blog_id=' . $blogID : '?mode=comments';
    redirect_admin('admin_blog_manager.php' . $qs);
}

function delete_comment() {
    $blog = new Blog();
    $blog->commentID = (int)($_REQUEST['comment_id'] ?? 0);
    $blogID          = (int)($_REQUEST['blog_id'] ?? 0);
    $ok = $blog->deleteComment();
    $_SESSION['adminErr'] = $ok ? 'Comment deleted.' : 'Failed to delete comment.';
    $qs = $blogID ? '?mode=comments&blog_id=' . $blogID : '?mode=comments';
    redirect_admin('admin_blog_manager.php' . $qs);
}
?>

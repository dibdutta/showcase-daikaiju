<?php
define('PAGE_HEADER_TEXT', 'Blog / Articles Manager');
ob_start();

define('INCLUDE_PATH', '../');
require_once INCLUDE_PATH . 'lib/inc.php';
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
    $content = trim($_POST['content'] ?? '');
    $status  = (int)($_POST['status'] ?? 1);
    $blogID  = (int)($_POST['blog_id'] ?? 0);

    if ($title === '') {
        $_SESSION['adminErr'] = 'Please enter a title.';
        $qs = $isEdit ? '?mode=edit&blog_id=' . $blogID : '?mode=create';
        redirect_admin('admin_blog_manager.php' . $qs);
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
            $filename = 'blog_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
            $mimeMap  = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp'];
            $mimeType = $mimeMap[$ext] ?? 'image/jpeg';

            if (APP_ENV === 'production') {
                require_once INCLUDE_PATH . 'lib/AWS/aws-autoloader.php';
                $s3Bucket = getenv('S3_STATIC_BUCKET');
                if ($s3Bucket) {
                    try {
                        $s3 = new Aws\S3\S3Client(['version' => 'latest', 'region' => 'us-east-1']);
                        $s3->putObject([
                            'Bucket'       => $s3Bucket,
                            'Key'          => 'blog-images/' . $filename,
                            'SourceFile'   => $_FILES['featured_image']['tmp_name'],
                            'ContentType'  => $mimeType,
                            'CacheControl' => 'max-age=31536000',
                        ]);
                        $featuredImage = $filename;
                    } catch (Exception $e) {
                        // upload failed — keep existing image
                    }
                }
            } else {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/blog_images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadDir . $filename)) {
                    $featuredImage = $filename;
                }
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

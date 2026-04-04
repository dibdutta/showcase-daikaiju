<?php
ob_start();
define('INCLUDE_PATH', './');
require_once INCLUDE_PATH . 'lib/inc.php';
require_once INCLUDE_PATH . 'classes/Blog.php';

chkLoginNow();

$mode = $_REQUEST['mode'] ?? '';

if ($mode === 'post_comment') {
    post_comment();
} else {
    dispmiddle();
}

ob_end_flush();

function dispmiddle() {
    require_once INCLUDE_PATH . 'lib/common.php';

    $slug   = trim($_REQUEST['slug'] ?? '');
    $blog   = new Blog();

    if ($slug !== '') {
        // Single post view
        $post = $blog->fetchBlogBySlug($slug);
        if (!$post) {
            header('Location: ' . DOMAIN_PATH . 'blog.php');
            exit;
        }
        $comments = $blog->fetchComments($post['blog_id'], 1); // approved only

        $smarty->assign('post', $post);
        $smarty->assign('comments', $comments);
        $smarty->assign('comment_err',  $_SESSION['comment_err']  ?? '');
        $smarty->assign('comment_ok',   $_SESSION['comment_ok']   ?? '');
        unset($_SESSION['comment_err'], $_SESSION['comment_ok']);

        $smarty->display('blog_post.tpl');
    } else {
        // Listing view
        $total = $blog->totalBlogs(1);
        $posts = $total > 0 ? $blog->fetchBlogs(1) : [];

        $smarty->assign('posts', $posts);
        $smarty->assign('total', $total);

        if ($total > 0) {
            $smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], 'smalltext', '', 5, 50, 5, 1));
            $smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], 'smalltext', 10, 1, 'view_link', 'headertext'));
        }

        $smarty->display('blog_list.tpl');
    }
}

function post_comment() {
    require_once INCLUDE_PATH . 'classes/Blog.php';

    $slug  = trim($_POST['slug'] ?? '');
    $name  = trim($_POST['commenter_name'] ?? '');
    $email = trim($_POST['commenter_email'] ?? '');
    $text  = trim($_POST['comment_text'] ?? '');
    $blogID = (int)($_POST['blog_id'] ?? 0);

    $err = '';
    if ($name === '')  $err = 'Please enter your name.';
    elseif ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $err = 'Please enter a valid email address.';
    elseif ($text === '') $err = 'Please enter your comment.';

    if ($err) {
        $_SESSION['comment_err'] = $err;
    } else {
        $blog = new Blog();
        $blog->blogID         = $blogID;
        $blog->commenterName  = $name;
        $blog->commenterEmail = $email;
        $blog->commentText    = $text;
        $blog->addComment();
        $_SESSION['comment_ok'] = 'Thank you! Your comment has been submitted and is awaiting approval.';
    }

    header('Location: ' . DOMAIN_PATH . 'blog.php?slug=' . urlencode($slug));
    exit;
}
?>

<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect('comments_page.php');
}
$comment = Comment::get_by_id($_GET['id']);

if ($comment) {
    $comment->delete();
    $session->message("the comment with {$comment->id} has been deleted");
    redirect('comments_page.php');
    
} else {
    redirect('comments_page.php');
}

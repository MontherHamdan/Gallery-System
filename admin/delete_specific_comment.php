<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect("photos_page.php");
}
$comment = Comment::get_by_id($_GET['id']);

if ($comment) {
    $comment->delete();
    $session->message("the user {$user->username} has been deleted");
    redirect("comments_photo.php?id={$comment->photo_id}");
} else {
    redirect("photos_page.php");
}

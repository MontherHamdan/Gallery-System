<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect('users_page.php');
}
$user = User::get_by_id($_GET['id']);

if ($user) {
    $user->delete_user_and_photo();
    $session->message("the user {$user->username} has been deleted");
    redirect('users_page.php');
} else {
    redirect('users_page.php');
}

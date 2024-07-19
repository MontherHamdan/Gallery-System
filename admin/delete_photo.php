<?php
include("includes/init.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect("photos_page.php");
}

$photo = Photo::get_by_id($_GET['id']);

if ($photo) {
    $photo->delete_photo();
    $session->message("the photo {$photo->filename} has been deleted");

    redirect("photos_page.php");
} else {
    redirect("photos_page.php");
}

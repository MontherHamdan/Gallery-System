<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}
$photos = Photo::get_all();

//if you want to display the photos for current user 
// $photos = Photo::get_by_id($session->user_id);
// then create a function in photo class to return the photos by user_id

?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


    <!-- top nav bar -->
    <?php include("includes/top_nav.php")    ?>


    <!-- Sidebar Menu Items -->
    <?php include("includes/sidebar_nav.php") ?>
    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
    <!-- page content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Photos Page
                </h1>
                <p class="bg-success">
                    <?php echo $message; ?>
                </p>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>photo</th>
                                <th>id</th>
                                <th>file name</th>
                                <th>Tittle</th>
                                <th>size</th>
                                <th>comments</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($photos as $photo) : ?>
                                <tr>
                                    <td><img src="<?php echo $photo->picture_path(); ?>" alt="" class="admin-thumbnail-photo">
                                        <div class="pictures_link">
                                            <a class="delete_link" href="delete_photo.php?id=<?php echo $photo->id ?>">Delete</a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id ?>">Edit</a>
                                            <a href="../photo_comments_main.php?id=<?php echo $photo->id ?>">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->id ?></td>
                                    <td><?php echo $photo->filename ?></td>
                                    <td><?php echo $photo->title ?></td>
                                    <td><?php echo $photo->size ?></td>
                                    <td>
                                        <a href="comments_photo.php?id=<?php echo $photo->id; ?>">
                                            <?php
                                            $comment = Comment::find_comments($photo->id);
                                            echo count($comment);
                                            ?></a>


                                    </td>

                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
<?php include("includes/header.php");
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$session->is_signed_in()) {
    redirect("login.php");
}

$message = "";
if (isset($_FILES['file'])) {
    $photo = new Photo;
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['file']);

    if ($photo->save_file()) {
        $message = "photo uploaded successfully";
    } else {
        //join() is predefined function like imploade() get a string from the array and we can separator
        $message = join("<br>", $photo->custom_errors);
    }
}
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
                    Upload Page
                </h1>

                <div class="row">
                    <div class="col-md-6">
                        <?php
                        echo $message;
                        ?>

                        <form action="upload.php" enctype="multipart/form-data" method="post">

                            <div class="form-group">
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="file" name="file">
                            </div>

                            <input type="submit" name="submit">

                        </form>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">

                        <form action="upload" class="dropzone"></form>
                    </div>


                </div>


            </div>
        </div><!-- /.row -->


    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
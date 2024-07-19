<?php
include("includes/header.php");
include("includes/photo_modal.php");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect('users_page.php');
}

$user = User::get_by_id($_GET['id']);

$message = "";
if (isset($_POST['update'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];

        if (empty($_FILES['user_image'])) {
            $user->save();
            $session->message("the user has been updated");
            redirect("users_page.php");
        } else {
            $user->set_file($_FILES['user_image']);
            $user->upload_user_photo();
            $user->save();
            $session->message("the user has been updated");

            // redirect("edit_user_page.php?id={$user->id}");
            redirect("users_page.php");
        }
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
                    Edit User
                </h1>

                <div class="col-md-6 user_image_box">
                    <a href="#" data-toggle="modal" data-target="#photo-modal"><img class="img-responsive" src="<?php echo $user->image_path_and_placeholder(); ?>" alt=""></a>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                    <!-- form list -->
                    <div class="col-md-6 ">

                        <div class="form-group">
                            <label for="user_image">User Image</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                        </div>

                        <div class="form-group">
                            <a id="user-id" class="btn btn-danger" href="delete_users.php?id=<?php echo $user->id; ?>">Delete</a>

                            <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                        </div>

                </form>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
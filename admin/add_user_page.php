<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}


$user = new User;
$message = "";
if (isset($_POST['create'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];

        $user->set_file($_FILES['user_image']);
        $user->upload_user_photo();
        $session->message("the user {$user->username} has been added");
        $user->save();
        redirect("users_page.php");
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
                    Add User
                </h1>
                <?php
                echo $message;
                ?>
                <form action="" method="post" enctype="multipart/form-data">

                    <!-- form list -->
                    <div class="col-md-6 col-md-offset-3">

                        <div class="form-group">
                            <label for="user_image">User Image</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="create" class="btn btn-primary pull-right">
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
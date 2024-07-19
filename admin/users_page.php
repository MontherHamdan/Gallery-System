<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}

$user = User::get_all();

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
                    Users Page
                </h1>
                <p class="bg-success">
                    <?php echo $message; ?>
                </p>
                <a href="add_user_page.php" class="btn btn-primary">Add User</a>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>First name</th>
                                <th>Last name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user as $users) : ?>
                                <tr>
                                    <td><?php echo $users->id ?></td>
                                    <td><img src="<?php echo $users->image_path_and_placeholder(); ?>" alt="" class="admin-thumbnail-users user_image"> </td>
                                    <td><?php echo $users->username ?>
                                        <div class="actions_link">
                                            <a href="delete_users.php?id=<?php echo $users->id ?>">Delete</a>
                                            <a href="edit_user_page.php?id=<?php echo $users->id ?>">Edit</a>
                                        </div>
                                    </td>
                                    <td><?php echo $users->first_name ?></td>
                                    <td><?php echo $users->last_name ?></td>
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
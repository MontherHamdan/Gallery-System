<?php include("includes/header.php");
if (!$session->is_signed_in()) {
    redirect('login.php');
}

if (empty($_GET['id'])) {
    redirect("photos_page.php");
}

$comment = Comment::find_comments($_GET['id']);
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
                    specific photo comments
                </h1>
                <p class="bg-success">
                    <?php echo $message; ?>
                </p>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comment as $comments) : ?>
                                <tr>
                                    <td><?php echo $comments->id ?></td>
                                    <td><?php echo $comments->author ?>
                                        <div class="actions_link">
                                            <a href="delete_specific_comment.php?id=<?php echo $comments->id ?>">Delete</a>
                                        </div>
                                    </td>
                                    <td><?php echo $comments->body ?></td>
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
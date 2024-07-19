<?php include("includes/header.php");

//$session is object from Session class we already define object from the class in session.php file
// and we make it automatically come to all page using __construct method
if (!$session->is_signed_in()) {
    redirect('login.php');
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

    <?php include("includes/admin_content.php") ?>
</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php
//$session is object from Session class we already define object from the class in session.php file
// and we make it automatically come to all page using __construct method
if ($session->is_signed_in()) {
    redirect("index.php");
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //method from User class to verify if user in database or not
    $user_found = User::verify_user($username, $password);

    if ($user_found) {
        $session->login($user_found);
        redirect("index.php");
    } else {
        $the_message = "username or password is incorrect";
    }
} else {
    $the_message = "";
    $username = "";
    $password = "";
}

?>
<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger"><?php echo $the_message; ?></h4>

    <form id="login-id" action="" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <!-- htmlentities($username); عشان لما لما المستخدم يغلط بكلمة السر يخلي قيمة الاسم وكلمة السر بالحقول ويقدر يعدل عليهم هيك اسهل للمستخدم -->
            <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>">

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">

        </div>


    </form>


</div>
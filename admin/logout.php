<?php 
//logout 
require_once("includes/header.php");

$session->logout();
redirect("login.php");
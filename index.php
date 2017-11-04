<?php
session_start();
require 'dbconn.php';
//require 'alltables.php';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
// Login
if ($page == 'login' || $page == 'login.php') {
//    header('Location: http://www.projectmanagement.com/login.php');
    $page = 'login';

    require('header.php');
    require('content.php');
    require('footer.php');

    exit;
}
if ($page == 'signup' || $page == 'signup.php') {
//    header('Location: http://www.projectmanagement.com/login.php');
    $page = 'signup';
    require('header.php');
    require('content.php');
    require('footer.php');

    exit;
}
if (empty($_SESSION['email'])) {
    header('Location: http://www.projectmanagement.com/login.php');
} else {
    $email = $_SESSION['email'];
    $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
    $user = $result->fetch_assoc();
}


require('header.php');
require('content.php');
require('footer.php');
?>






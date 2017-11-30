<?php
session_start();
require 'dbconn.php';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
//$page = explode('/', $page);
//if (sizeof($page) > 1 and isset($page[1])) {
//    global $action;
//    $action = $page[1];
//    $page=$page[0];
//    }
//else{$page=$page[0];}
if (empty($_SESSION['email'])) {
    $page='login';
} else {
    $email = $_SESSION['email'];
    $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
    global $user;
    $user = $result->fetch_assoc();
}
require_once 'controllers/_controller.php';
require_once 'controllers/'.$page.'_controller.php';
require_once 'functions.php';
require_once 'permissions.php';


?>
<?php

//var_dump(777);
//die();
//session_start();
//require 'dbconn.php';
//$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
//var_dump($page);
//die();
////$page = explode('/', $page);
////if (sizeof($page) > 1 and isset($page[1])) {
////    global $action;
////    $action = $page[1];
////    $page=$page[0];
////    }
////else{$page=$page[0];}
//if (empty($_SESSION['email'])) {
//    $page='login';
//} else {
//    $email = $_SESSION['email'];
//    $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
//    global $user;
//    $user = $result->fetch_assoc();
//}
//require_once 'controllers/_controller.php';
//$file= 'controllers/'.$page.'_controller.php';
//if(file_exists($file)){
//    require_once 'controllers/'.$page.'_controller.php';
//}
//else{
//
//}
//require_once 'functions.php';
//require_once 'permissions.php';
session_start();
//use Doctrine\ORM\Tools\Setup;
//use Doctrine\ORM\EntityManager;
//use Doctrine\ORM\Mapping\Driver;
//include 'C:\wamp64\www\project-management\vaxo\Users.php';
$settings = include 'C:\wamp64\www\project-management\config\configs.php';
require 'C:\wamp64\www\project-management\vendor\autoload.php';
// create container and configure it
$container = new \Slim\Container($settings);


// create app instance
$app = new \Slim\App($container);
$app = new \Slim\App($settings);
include 'C:\wamp64\www\project-management\src\dependencies.php';
include 'C:\wamp64\www\project-management\src\Api\routes.php';
$app->run();
?>
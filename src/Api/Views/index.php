<?php
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
session_set_cookie_params(0);
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/vendor/autoload.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();
die();
require 'dbconn.php';
$time = $_SERVER['REQUEST_TIME'];


$timeout_duration = 30;


//require 'alltables.php';
$route = isset($_REQUEST['route']) ? $_REQUEST['route'] : '';
$routesArr = explode('/', $route);
global $page;
$page = $routesArr[0];
$action = isset($routesArr[1]) ? $routesArr[1] : null;

// Login
if ($page == 'login' || $page == 'login.php') {
    $page = 'login';
    include_once 'frontend/controllers/Controller.php';
    include_once 'frontend/controllers/' . ucfirst($page) . 'Controller.php';
    $className =  ucfirst($page) . 'Controller';
    $controller = new $className($action);


    exit;
}

if ($page == 'signup' || $page == 'signup.php') {
    $page = 'signup';
    include_once 'frontend/controllers/Controller.php';
    include_once 'frontend/controllers/' . ucfirst($page) . 'Controller.php';

}
if (empty($_SESSION['email'])) {
    if($page != 'signup'){
        $page='login';
    }

} else {
    if(!isset($page)){
        $page= 'login';
    }

    $email = $_SESSION['email'];
    $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
    global $user;
    $user = $result->fetch_assoc();


}
if(!isset($_REQUEST['route'])){
    require_once 'frontend/views/View.php';
    $view = new View();
    $view->header();
    $view->footer();
}


if (isset($_SESSION['LAST_ACTIVITY']) &&
    ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    $page= 'login';
}



$_SESSION['LAST_ACTIVITY'] = $time;

include_once 'frontend/controllers/Controller.php';
include_once 'frontend/controllers/' . ucfirst($page) . 'Controller.php';
$className =  ucfirst($page) . 'Controller';
$controller = new $className($action);





?>
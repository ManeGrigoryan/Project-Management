<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/12/2017
 * Time: 9:50 PM
 */

use App\Api\Controllers\TasksController;
use App\Api\Controllers\ProfileController;
use App\Api\Controllers\LoginController;
use App\Api\Controllers\LogoutController;
use App\Api\Controllers\ProjectsController;
use App\Api\Controllers\UsersController;
use App\Api\Controllers\SignupController;
use App\Api\Models\UsersModel;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->group('', function () use ($app) {
    $this->any('/', function (Request $request, Response $response) {
        return $this->view->render($response, 'index.twig');
    });
    $this->group('/profile', function () {
        $this->any('', ProfileController::class . ':profileInfo');
    });
    $this->group('/projects', function () {
        $this->get('', ProjectsController::class . ':list_');
        $this->post('', ProjectsController::class . ':save');
        $this->get('/add', ProjectsController::class . ':add');
//        $this->post('/add', ProjectsController::class . ':save');
    });
    $this->group('/tasks', function () {
        $this->get('', TasksController::class . ':list_');
        $this->get('/add', TasksController::class . ':add');
        $this->post('/add', TasksController::class . ':save');
    });
    $this->group('/users', function () {
        $this->get('', UsersController::class . ':list_');
        $this->get('/add', UsersController::class . ':add');
        $this->post('/add', UsersController::class . ':save');
    });
    $this->any('/logout', LogoutController::class. ':logout');
})->add(function (Request $request, Response $response, $next) {
    if (!isset($_SESSION['email'])){
        return $response->withRedirect('/login');
    } else {
        global $user;
        $usersModel = new UsersModel();
        $user = $usersModel->findBy(['email' => $_SESSION['email']]);
        return $next($request, $response);
    }
});
$app->get('/login',  LoginController::class . ':login');
$app->post('/login',  LoginController::class . ':doLogin');
$app->any('/signup', SignupController::class. ':signup');
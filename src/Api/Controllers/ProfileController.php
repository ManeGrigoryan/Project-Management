<?php


namespace App\Api\Controllers;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProfileController extends Controller
{
    public function profileInfo(Request $request, Response $response)
    {
        global $app;
        $view = $app->getContainer()->get('view');
        global $user;
        return $view->render($response, 'profile.twig', array(
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'position' => $user['position'],
            'email' => $user['email']
        ));
    }
}

///**
// * Created by PhpStorm.
// * User: Comp8
// * Date: 12/1/2017
// * Time: 8:14 PM
// */
//namespace App\Api\Controllers;
//
//use \Psr\Http\Message\RequestInterface;
//use \Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
//class ProfileController extends Controller
//{
//    public $position;
//
////    public function __construct()
////    {
////
////        include 'frontend/views/View.php';
////        include 'frontend/views/ProfileView.php';
////        include 'frontend/models/Model.php';
////        include 'frontend/models/ProfileModel.php';
////
////        $this->model = new ProfileModel();
////        $this->view = new ProfileView($this->model);
////
////        $this->view->header();
////        if (isset($_SESSION['email'])) {
////
////            $this->profileInfo();
////        } else {
////            $this->noInfo();
////        }
////        $this->view->footer();
////    }
//    public function profileInfo(){
//        var_dump(2);
////        $this->view->profileInfo();
//    }
//    public function noInfo(){
////        $this->view->noInfo();
//    }
//
//}
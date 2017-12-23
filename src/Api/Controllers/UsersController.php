<?php
///**
// * Created by PhpStorm.
// * User: Comp8
// * Date: 12/2/2017
// * Time: 4:00 PM
// */
namespace App\Api\Controllers;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
global $app;
class UsersController extends Controller
{
//    public $position;
//
////    public function __construct($action)
////    {
////        global $action;
////        include 'frontend/views/View.php';
////        include 'frontend/views/UsersView.php';
////        include 'frontend/models/Model.php';
////        include 'frontend/models/UsersModel.php';
////
////        $this->model = new UsersModel();
////        $this->view = new UsersView($this->model);
////
////        $this->view->header();
////        if ($action == '') {
////            $action = 'see_users_list';
////            $this->list_();
////
////        } elseif ($action == 'add') {
////            $action = 'add_new_user';
////            $this->add();
////            $this->save();
////
////        }
////        $this->view->footer();
////    }
//
    public function list_()
    {
var_dump(5);    }
//
//    public function add()
//    {
//        $this->view->add();
//    }
//
//    public function save()
//    {
//        global $mysqli;
//        global $adding_new_user;
//        if (!empty($_GET['firstname']) && !empty($_GET['lastname']) && !empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['position'])) {
//            $result = $mysqli->query("SELECT * FROM Users WHERE email = '" . $_GET['email'] . "'") or die();
//            if ($result->num_rows > 0) {
//                echo "User with email address " . $_GET['email'] . " already exists";
//            }
//            if (!mysqli_query($mysqli, $adding_new_user)) {
//                var_dump($adding_new_user);
//                echo "Could not add the user " . $_GET['email'];
//                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//            } else {
//                echo "NEW USER HAS BEEN INSERTED";
//                require_once ('frontend/controllers/UsersController.php');
//
//            }
//
//        }
//
//    }
//
//
}
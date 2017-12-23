<?php
/////**
//// * Created by PhpStorm.
//// * User: Comp8
//// * Date: 12/2/2017
//// * Time: 4:00 PM
//// */
//namespace App\Api\Controllers;
//use App\Api\Models\Model;
//use App\Api\Models\ProjectsModel;
//use \Psr\Http\Message\RequestInterface;
//use \Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
//class ProjectsController extends Controller{
//
//    public function  list_ (Request $request, Response $response)
//    {
//        $projectsModel= new ProjectsModel();
//
//
//    }
//    public function add(Request $request, Response $response)
//    {
////       $this->view->add();
//
//    }
//    public function save(Request $request, Response $response)
//    {
//        global $mysqli;
//
//    }
//
//}
////{
////    public $position;
////
////    public function __construct($action)
////    {
////        global $action;
////        include 'frontend/views/View.php';
////        include 'frontend/views/ProjectsView.php';
////        include 'frontend/models/Model.php';
////        include 'frontend/models/ProjectsModel.php';
////
////        $this->model = new ProjectsModel();
////        $this->view = new ProjectsView($this->model);
////
////        $this->view->header();
////        if ($action == '') {
////            $action = 'search_in_projects';
////            $this->list_();
////
////        } elseif ($action == 'add') {
////            $action = 'add_new_project';
////            $this->add();
////            $this->save();
////        }
////        $this->view->footer();
////    }
////
////    public function list_()
////    {
////        $this->view->list_();
////    }
////    public function add()
////    {
////        $this->view->add();
////    }
////    public function save()
////    {
////        global $mysqli;
////        global $adding_new_project;
////        if (!empty($_GET['project_manager']) && !empty($_GET['project_name']) && !empty($_GET['save_project']) && !empty($_GET['project_description']) &&  !empty($_GET['start_day']) && !empty($_GET['deadline'])) {
////            $result = $mysqli->query("SELECT * FROM projects WHERE proj_name = '".$_GET['project_name']."'");
////            if ($result->num_rows > 0) {
////                echo "Project with the name " . $_GET['project_name'] . " already exists";
////            } else {
////                $adding_new_project = mysqli_query($mysqli, $adding_new_project);
////                if (!$adding_new_project) {
////                    echo "Could not add the project " . $_GET['project_name'] ;
////                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
////                } else {
////                    echo "New Project Has Been Added To The Projects' List</br>";
////                }
////            }
////        }
////
////    }
////
////}
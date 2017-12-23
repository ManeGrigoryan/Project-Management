<?php

namespace App\Api\Controllers;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TasksController extends Controller
{
    public $position;

    public function list_(Request $request, Response $response)
    {
       echo 'halo';
}
    public function add(Request $request, Response $response)
    {
        return $response->getBody()->write('add');

    }
    public function save(Request $request, Response $response)
    {


    }

    

}

//    public function __construct($action)
//    {
//        global $action;
//        include 'frontend/views/View.php';
//        include 'frontend/views/TasksView.php';
//        include 'frontend/models/Model.php';
//        include 'frontend/models/TasksModel.php';
//
//        $this->model = new TasksModel();
//        $this->view = new TasksView($this->model);
//
//        $this->view->header();
//        if ($action == '') {
//            $action = 'search_in_tasks';
//            $this->list_();
//
//        } elseif ($action == 'add') {
//            $action = 'add_new_task';
//            $this->add();
//            $this->save();
//        }
//            $this->view->footer();
//    }
//
//

//
//    public function list_()
//    {
//        $this->view->list_();
//    }
//
//public function save(){
//    global $mysqli;
//    global $adding_new_task;
//    if (!empty($_GET['task_name']) && !empty($_GET['project_name']) && !empty($_GET['save_task']) && !empty($_GET['task_description']) && !empty($_GET['task_assignee']) && !empty($_GET['start_day']) && !empty($_GET['deadline'])) {
//        $result = $mysqli->query("SELECT * FROM tasks WHERE proj_name = '" . $_GET['project_name'] . "' AND task_name = '" . $_GET['task_name'] . "'");
//        if ($result->num_rows > 0) {
//            echo "Task with the name " . $_GET['task_name'] . " for the project " . $_GET['project_name'] . " already exists";
//        } else {
//            $adding_new_task = mysqli_query($mysqli, $adding_new_task);
//            if (!$adding_new_task) {
//                echo "Could not add the task " . $_GET['task_name'];
//                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//            } else {
//                echo "New Task Has Been Added To The Task List</br>";
//            }
//        }
//    }
//
//}

//
//
//
//}


?>
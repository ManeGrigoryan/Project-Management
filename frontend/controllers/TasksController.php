<?php
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/controllers/TasksController.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/functions.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/views/tasks_view.php');


class TasksController extends Controller
{
    public $position;

    public function __construct($action)
    {
        global $action;
        include 'frontend/views/View.php';
        include 'frontend/views/TasksView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/TasksModel.php';

        $this->model = new TasksModel();
        $this->view = new TasksView($this->model);

        $this->view->header();
        if ($action == '') {
            $action = 'search_in_tasks';
            $this->list_();

        } elseif ($action == 'add') {
            $action = 'add_new_task';
            $this->add();
            $this->save();
        }
            $this->view->footer();
    }


    public function add()
    {
        $this->view->add();
    }

    public function list_()
    {
        $this->view->list_();
    }

    public function save()
    {
        $this->view->save();
//        $this->list_();
    }
}


?>
<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/MVC/controllers/tasks_controller.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/MVC/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/MVC/views/tasks_view.php');


class tasks_controller extends _controller
{
    public $position;

    public function __construct()
    {
        if (isset($_SESSION['email'])) {
            global $user;
            $this->position = $user['email'];
            $instance= new TasksView;
            $instance->addNewTask();
            if (!isset($_POST['add_new_task'])) {
                $instance= new TasksView;
                $instance->tasksList();
            }

        }

    }


}

$instance = new tasks_controller;

?>
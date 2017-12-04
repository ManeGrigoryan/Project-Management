<?php
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/controllers/TasksController.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/functions.php');
//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/frontend/views/tasks_view.php');

class LoginController extends Controller
{

    public function __construct()
    {

        include 'frontend/views/View.php';
        include 'frontend/views/LoginView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/LoginModel.php';

        $this->model = new LoginModel();
        $this->view = new LoginView($this->model);

        $this->view->header();

        if (isset($_SESSION['email'])) {
            $this->alreadyLoggedIn();

        } else {
            $this->newLog();
        }
        $this->view->footer();
    }


    public function alreadyLoggedIn()
    {
        $this->view->alreadyLoggedIn();
    }

    public function newLog()
    {
        $this->view->newLog();
    }

}


?>

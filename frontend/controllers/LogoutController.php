<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 7:19 PM
 */

class LogoutController
{
    public function __construct()
    {
        include 'frontend/views/View.php';
        include 'frontend/views/LogoutView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/LogoutModel.php';

        $this->model = new LogoutModel;
        $this->view = new LogoutView($this->model);

        $this->view->header();
        if (isset($_SESSION['email'])) {
            $this->logout();

        } else  {

            $this->notLogged();
        }
        $this->view->footer();
    }
    public function logout(){
        $this->view->logout();
    }
    public function notLogged(){
        $this->view->notLogged();
    }

}
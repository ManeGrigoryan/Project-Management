<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:01 PM
 */

class SignupController extends Controller

{


    public function __construct()
    {

        include_once 'frontend/views/View.php';
        include_once  'frontend/views/SignupView.php';
        include_once  'frontend/models/Model.php';
        include_once  'frontend/models/SignupModel.php';

        $this->model = new SignupModel();
        $this->view = new SignupView($this->model);

        $this->view->header();
        if (isset($_SESSION['email'])) {
            $this->signedIn();
        } else {
            $this->signup();
        }
        $this->view->footer();
    }

    public function signedIn()
    {
        $this->view->signedIn();
    }

    public function signup()
    {
        $this->view->signup();
    }


}
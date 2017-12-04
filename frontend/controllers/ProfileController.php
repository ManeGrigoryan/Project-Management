<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 8:14 PM
 */

class ProfileController extends Controller
{
    public $position;

    public function __construct()
    {

        include 'frontend/views/View.php';
        include 'frontend/views/ProfileView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/ProfileModel.php';

        $this->model = new ProfileModel();
        $this->view = new ProfileView($this->model);

        $this->view->header();
        if (isset($_SESSION['email'])) {

            $this->profileInfo();
        } else {
            $this->noInfo();
        }
        $this->view->footer();
    }
    public function profileInfo(){
        $this->view->profileInfo();
    }
    public function noInfo(){
        $this->view->noInfo();
    }

}
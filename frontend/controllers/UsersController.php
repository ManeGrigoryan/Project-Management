<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */

class UsersController extends Controller
{
    public $position;

    public function __construct($action)
    {
        global $action;
        include 'frontend/views/View.php';
        include 'frontend/views/UsersView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/UsersModel.php';

        $this->model = new UsersModel();
        $this->view = new UsersView($this->model);

        $this->view->header();
        if ($action == '') {
            $action = 'see_users_list';
            $this->list_();

        } elseif ($action == 'add') {
            $action = 'add_new_user';
            $this->add();
            $this->save();
        }
        $this->view->footer();
    }
    public function list_()
    {
        $this->view->list_();
    }
    public function add()
    {
        $this->view->add();
    }
    public function save()
    {
        $this->view->save();
    }


}
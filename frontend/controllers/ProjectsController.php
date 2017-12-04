<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */

class ProjectsController extends Controller
{
    public $position;

    public function __construct($action)
    {
        global $action;
        include 'frontend/views/View.php';
        include 'frontend/views/ProjectsView.php';
        include 'frontend/models/Model.php';
        include 'frontend/models/ProjectsModel.php';

        $this->model = new ProjectsModel();
        $this->view = new ProjectsView($this->model);

        $this->view->header();
        if ($action == '') {
            $action = 'search_in_projects';
            $this->list_();

        } elseif ($action == 'add') {
            $action = 'add_new_project';
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
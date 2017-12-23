<?php

namespace App\Api\Controllers;
use App\Api\Models\Model;
use App\Api\Models\ProjectsModel;
use \Slim\Http\Response;
use \Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProjectsController extends Controller
{
    public function list_(Request $request, Response $response)
    {
       global $app;
       $view=$app->getContainer()->get('view');
       $models= new Model;
       $action='search_in_projects';
       $sort = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
       $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
       $pattern = isset($_GET['search'])? $_GET['search']:'';
       $project_manager=(isset($_GET['search_projectManager']) && $_GET['search_projectManager'] != '')? $_GET['search_projectManager']: '';
       $permission=$models->getPermission($action);
       $searchManager=$models->searchByManagers();
       var_dump($searchManager);
       if($permission==TRUE){
           $searchProjects=$models->searchByProjects();
       }
       $projectsModel= new ProjectsModel();
       $getProjectsTable=$projectsModel->getProjectsTable();
        return $view->render($response, 'projects.twig', array(
            'pattern'=>$pattern,
            'order'=>$order,
            'sort'=>$sort,
            'permission'=>$permission,
            'project_manager'=>$project_manager,
            'searchManager'=>$searchManager,
            'tableData'=>$getProjectsTable
        ));


    }

    public function add()
    {

    }

    public function save()
    {

    }

}

?>
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
        global $total_pages;

        $view = $app->getContainer()->get('view');
        $models = new Model;
        $action = 'search_in_projects';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
        $pattern = isset($_GET['search']) ? $_GET['search'] : '';
        $project_manager = (isset($_GET['search_projectManager']) && $_GET['search_projectManager'] != '') ? $_GET['search_projectManager'] : '';
        $project_name = (isset($_GET['search_projectName']) && $_GET['search_projectName'] != '') ? $_GET['search_projectName'] : '';
        $task_assignee = isset($_GET['search_taskAssignee']) && $_GET['search_taskAssignee'] != '' ? $_GET['search_taskAssignee'] : '';
        $permission = $models->getPermission($action);
        $searchManager = $models->getManagers();
        $searchProjects = $models->getProjects();
//       if($permission==TRUE){
//           $searchProjects=$models->searchByProjects();
//       }
        $projectsModel = new ProjectsModel();
        $getProjectsTable = $projectsModel->getProjectsTable();
        $location = $_SERVER['REQUEST_URI'];
        $urlArr = explode('?', $location);
        $queryParamsStr = isset($urlArr[1]) ? $urlArr[1] : '';
        parse_str($queryParamsStr, $queryParamsArr);
        for ($action = 1; $action <= $total_pages; $action++) {
            $newQueryParams = array_merge($queryParamsArr, ['action' => $action]);
            $newQueryParamStr = http_build_query($newQueryParams);
            $newUrl = implode('?', [$urlArr[0], $newQueryParamStr]);
            ?>
            <a href="<?php echo $newUrl; ?>"><?php echo $action ?></a>
            <?php
        }
        return $view->render($response, 'projects.twig', array(
            'pattern' => $pattern,
            'order' => $order,
            'sort' => $sort,
            'permission' => $permission,
            'project_manager' => $project_manager,
            'project_name' => $project_name,
            'searchManager' => $searchManager,
            'searchProject' => $searchProjects,
            'tableData' => $getProjectsTable
        ));


    }

    public function add(Request $request, Response $response)
    {
        global $app;
        $action = 'add_new_project';
        $view = $app->getContainer()->get('view');
        $models = new Model;
        $permission = $models->getPermission($action);
        $managers = $models->getManagers();
        return $view->render($response, 'projects.twig', array(
            'permission' => $permission,
            'managers' => $managers,
            'action' => $action
        ));

    }

    public function save(Request $request, Response $response)
    {
        global $app;
        $db = $app->getContainer()->get('mysql');
        $view=$app->getContainer()->get('view');
        if (isset($_POST['project_name'] , $_POST['description'] , $_POST['project_manager'] , $_POST['start_day'] , $_POST['deadline']) ) {
            $projectName=$_POST['project_name'];
            $description=$_POST['description'];
            $projectManager=$_POST['project_manager'];
            $startDay=$_POST['start_day'];
            $deadline=$_POST['deadline'];
            $addNewProject="INSERT INTO projects (`proj_name`, `description`, `proj_manager`, `start_day`, `deadline` ) VALUES (?,?, ?, ?, ? )";
            $prepare=$db->prepare($addNewProject);
            $prepare->bind_param("sssss", $projectName,$description,$projectManager,$startDay,$deadline);
            $insertion=$prepare->execute();
            if($insertion){
                echo "New Project Has Been Inserted";
                $this->list_($request, $response);
            }
            else{
                var_dump($prepare);
                echo $db->error;
            }
        }


    }

}

?>
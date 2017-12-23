<?php

namespace App\Api\Models;
global $app;
global $user;
$container = $app->getContainer();
$view = $container->get('view');
$mysqli = $container->get('mysql');
$permission = $container->get('permission');

class Model
{
    public function searchByProjects()
    {
        ?>
        <select name="search_projectName" size="1">
        <option value="">Select a Project</option>
        <?php
        global $app;
        global $user;
        $container = $app->getContainer();
        $mysqli = $container->get('mysql');
        $project_names = "SELECT DISTINCT proj_name FROM projects";
        $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager='" . $user['email'] . "'" : "";
        $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
        $project_names == ($user['position'] == 'developer') ? "SELECT  DISTINCT  proj_name FROM projects JOIN tasks ON task_assignee = '" . $user['email'] . "'" : $project_names;
        $project_names = mysqli_query($mysqli, $project_names);
        $project_name = (isset($_GET['search_projectName']) && $_GET['search_projectName'] != '') ? $_GET['search_projectName'] : '';
        while ($row = $project_names->fetch_assoc()) {
            echo '<option ' . (($project_name === $row['proj_name']) ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
        }
        echo '</select>';

    }

//    public function searchByManagers()
//    {
////
//
//<!--        </br></select><select name="search_projectManager" size="1">-->
//<!--        <option value="">Select a Manager</option>-->
//<!--        -->
//        global $app;
//        global $user;
//        $container = $app->getContainer();
//        $mysqli = $container->get('mysql');
//        $project_managers = "SELECT firstname, lastname, email FROM users WHERE position='manager'";
//        $project_managers .= ($user['position'] == 'manager') ? " WHERE proj_manager='" . $user['email'] . "'" : "";
//        $project_managers .= ($user['position'] == 'admin') ? " AND 1" : "";
//        $project_managers == ($user['position'] == 'developer') ? "SELECT DISTINCT firstname, lastname, email FROM users JOIN tasks JOIN projects
//                                                                    ON projects.proj_manager=users.email AND tasks.task_assignee = '" . $user['email'] . "'
//                                                                    AND tasks.proj_name=projects.proj_name" : $project_managers;
//
//        $project_managers = mysqli_query($mysqli, $project_managers);
//        $project_manager = (isset($_GET['search_projectManager']) && $_GET['search_projectManager'] != '') ? $_GET['search_projectManager'] : '';
//        while ($row = $project_managers->fetch_assoc()) {
//            echo '<option ' . (($project_manager === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
//        }
//        echo '</select>';
//    }

    public function searchByAssignees()
    {
        ?>
        <select name="search_taskAssignee" size="1">
            <option value="">Select an Assignee</option>
        <?php
        global $app;
        global $user;
        $mysqli = $app->getContainer()->get('mysql');
        $task_assignees = "SELECT DISTINCT firstname, lastname,email FROM users ";
        $task_assignees .= ($user['position'] == 'admin') ? "WHERE position = 'developer'" :
            " JOIN projects JOIN tasks ON projects.proj_manager='" . $user['email'] . "' AND users.position='developer' AND tasks.proj_name = projects.proj_name ";
        $task_assignees = mysqli_query($mysqli, $task_assignees);
        $task_assignee = isset($_GET['search_taskAssignee']) && $_GET['search_taskAssignee'] != '' ? $_GET['search_taskAssignee'] : '';
        while ($row = $task_assignees->fetch_assoc()) {
            $task_assignee_firstname = $row['firstname'];
            $task_assignee_lastname = $row['lastname'];
            $task_assignee_email = $row['email'];
            echo '<option ' . (($task_assignee === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
        }
        echo '</select></br>';
    }

    public function getProjects()
    {
        global $app;
        global $user;
        $container = $app->getContainer();
        $mysqli = $container->get('mysql');
        $project_names = "SELECT DISTINCT proj_name FROM projects";
        $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager='" . $user['email'] . "'" : "";
        $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
        $project_names == ($user['position'] == 'developer') ? $project_names="SELECT  DISTINCT  projects.proj_name FROM projects JOIN tasks ON task_assignee = '".$user['email']."' AND tasks.proj_name=projects.proj_name" : $project_names;
        $project_names = mysqli_query($mysqli, $project_names);
        $project_name = (isset($_GET['search_projectName']) && $_GET['search_projectName'] != '') ? $_GET['search_projectName'] : '';
        $data = array();
        while ($row = $project_names->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;

    }

    public function getAssignees()
    {
        global $app;
        global $user;
        $mysqli = $app->getContainer()->get('mysql');
        $task_assignees = "SELECT DISTINCT firstname, lastname,email FROM users ";
        $task_assignees .= ($user['position'] == 'admin') ? "WHERE position = 'developer'" :
            " JOIN projects JOIN tasks ON projects.proj_manager='" . $user['email'] . "' AND users.position='developer' AND tasks.proj_name = projects.proj_name ";
        $task_assignees = mysqli_query($mysqli, $task_assignees);
        $task_assignee = isset($_GET['search_taskAssignee']) && $_GET['search_taskAssignee'] != '' ? $_GET['search_taskAssignee'] : '';
        $data = array();
        while ($row = $task_assignees->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPermission($action)
    {
        global $app;
        global $user;
        $permission = $app->getContainer()->get('permission');
        if (isset($_SESSION['email'])) {
            if (in_array($action, $permission[$user['position']]) !== FALSE) {
                return true;
            } else {
                return false;
            }

        }
    }
    public function getManagers(){
        global $app;
        global $user;
        $container = $app->getContainer();
        $mysqli = $container->get('mysql');
        $project_managers = "SELECT DISTINCT  firstname, lastname, email FROM users JOIN projects ON position='manager'";
        $project_managers .= ($user['position'] == 'manager') ? " AND proj_manager='" . $user['email'] . "' AND users.email='".$user['email']."'" : "";
        $project_managers .= ($user['position'] == 'admin') ? " AND 1" : "";
        $project_managers == ($user['position'] == 'developer') ? $project_managers="SELECT DISTINCT firstname, lastname, email FROM users JOIN tasks JOIN projects
                                                                    ON projects.proj_manager=users.email AND tasks.task_assignee = '" . $user['email'] . "'
                                                                    AND tasks.proj_name=projects.proj_name" : $project_managers;

        $project_managers = mysqli_query($mysqli, $project_managers);
        $project_manager = (isset($_GET['search_projectManager']) && $_GET['search_projectManager'] != '') ? $_GET['search_projectManager'] : '';
        $data = array();
        while ($row = $project_managers->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}


?>
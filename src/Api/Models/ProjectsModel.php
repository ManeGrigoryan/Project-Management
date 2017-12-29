<?php

namespace App\Api\Models;
use App\vaxo;
class ProjectsModel extends Model
{
    public function getProjectsTable()
    {
        global $user;
        global $app;
        $mysqli=$app->getContainer()->get('mysql');
        global $query;
        global $total_pages;
        $query = "SELECT DISTINCT projects.proj_name, description, proj_manager, projects.start_day, projects.deadline FROM projects JOIN tasks On 1";
        $query .= (!empty($_GET['search'])) ? " AND projects.description LIKE '%" . $_GET['search'] . "%' " : "";
        $query .= (!empty($_GET['search_projectName'])) ? " AND projects.proj_name = '" . $_GET['search_projectName'] . "' " : "";
        $query .= (!empty($_GET['search_projectManager'])) ? " AND projects.proj_manager ='" . $_GET['search_projectManager'] . "' " : "";
        $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
        $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' AND projects.proj_name=tasks.proj_name " : "";
        $query .= ($user['position'] == 'admin') ? " " : "";
        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
        $query .= " ORDER BY $order $sort ";
        $result = mysqli_query($mysqli, $query);
        $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
        $perpage = 10;
        $start_number = (($action - 1) * $perpage);
        $total_elements = mysqli_num_rows($result);
        $total_pages = ceil($total_elements / $perpage);
        $query .= " LIMIT $start_number, $perpage";
        $query = mysqli_query($mysqli, $query);

        if (!$query) {
            var_dump($query);
            printf("Error: %s\n", mysqli_error($mysqli));
            exit();
        }
        $data = array();
        while ($row = mysqli_fetch_array($query)) {
            $data[] = $row;
        }
        return $data;
    }

}

?>
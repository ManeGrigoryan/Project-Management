<?php
///**
// * Created by PhpStorm.
// * User: Comp8
// * Date: 12/2/2017
// * Time: 4:00 PM
// */
//namespace App\Api\Models;
//
//class ProjectsModel extends Model
//{
//    public function getProjects()
//    {
//        global $user;
//        global $mysqli;
//        global $query;
//        global $total_pages;
//        $query = "SELECT DISTINCT projects.proj_name, description, proj_manager, projects.start_day, projects.deadline FROM projects JOIN tasks On 1";
//        $query .= (!empty($_GET['search'])) ? " AND projects.description LIKE '%" . $_GET['search'] . "%' " : "";
//        $query .= (!empty($_GET['project_name'])) ? " AND projects.proj_name = '" . $_GET['project_name'] . "' " : "";
//        $query .= (!empty($_GET['project_manager'])) ? " AND projects.proj_manager ='" . $_GET['project_manager'] . "' " : "";
//        $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
//        $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' " : "";
//        $query .= ($user['position'] == 'admin') ? " " : "";
//
//////        $order = isset($_GET['proj_name']) ? 'projects.proj_name' : '';
//////        $order = isset($_GET['proj_manager']) ? 'proj_manager' : $order;
//////        $order = isset($_GET['start_day']) ? 'projects.start_day' : $order;
//////        $order = isset($_GET['deadline']) ? 'projects.deadline' : $order;
//////        $order = ($order == '') ? 'projects.proj_name' : $order;
//////        $sort = 'ASC';
//        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
//        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
//        $query .= " ORDER BY $order $sort ";
//        $result = mysqli_query($mysqli, $query);
//        $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
//        $perpage = 10;
//        $start_number = (($action - 1) * $perpage);
//        $total_elements = mysqli_num_rows($result);
//        $total_pages = ceil($total_elements / $perpage);
//
//        $query .= " LIMIT $start_number, $perpage";
//        $query = mysqli_query($mysqli, $query);
//
//        if (!$query) {
//            var_dump($query);
//            printf("Error: %s\n", mysqli_error($mysqli));
//            exit();
//        }
//        $data = array();
//        while ($row = mysqli_fetch_array($query)) {
//            $data[] = $row;
//        }
//        return $data;
//    }
////
//
//    public function getAdds(){
//        if (isset($_GET['save_project'], $_GET['project_name'], $_GET['project_description'], $_GET['project_manager'], $_GET['start_day'], $_GET['deadline'])) {
//            global $adding_new_project;
//            $project_description = $_GET['project_description'];
//            $project_name = $_GET['project_name'];
//            $project_manager = $_GET['project_manager'];
//            $start_day = $_GET['start_day'];
//            $deadline = $_GET['deadline'];
//            $adding_new_project = "INSERT INTO projects(proj_name, description, proj_manager, start_day, deadline)
//                                      VALUES ('$project_name',  '$project_description', '$project_manager','$start_day', '$deadline')";
//        }
//    }
//
//}
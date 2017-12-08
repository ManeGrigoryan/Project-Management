<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 11/30/2017
 * Time: 11:07 PM
 */

class TasksModel extends Model
{
    public function getTasks()
    {
        global $user;
        global $mysqli;
        global $query;
        global $total_pages;


        $query = "SELECT DISTINCT tasks.proj_name, task_name, task_description, tasks.task_assignee, tasks.start_day, tasks.deadline 
                              FROM tasks JOIN projects ON tasks.proj_name=projects.proj_name";


        $query .= (!empty($_GET['search'])) ? " AND tasks.task_name LIKE '%" . $_GET['search'] . "%' " : "";
        $query .= (!empty($_GET['project_name'])) ? " AND tasks.proj_name = '" . $_GET['project_name'] . "' " : "";
        $query .= (!empty($_GET['task_assignee'])) ? " AND tasks.task_assignee='" . $_GET['task_assignee'] . "' " : "";
        $query .= (!empty($_GET['project_manager'])) ? " AND projects.proj_manager ='" . $_GET['project_manager'] . "' " : "";
        $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
        $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' " : "";
        $query .= ($user['position'] == 'admin') ? " " : "";

        // Ordering
        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
        $query .= " ORDER BY $order $sort ";
        // Pagination
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
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;

    }

    public function getAdds()
    {
        if (isset($_GET['save_task'], $_GET['task_name'], $_GET['task_description'], $_GET['project_name'], $_GET['task_assignee'], $_GET['start_day'], $_GET['deadline'])) {
            global $adding_new_task;
            $task_name = $_GET['task_name'];
            $task_description = $_GET['task_description'];
            $project_name = $_GET['project_name'];
            $task_assignee = $_GET['task_assignee'];
            $start_day = $_GET['start_day'];
            $deadline = $_GET['deadline'];
            $adding_new_task = "INSERT INTO tasks(proj_name, task_name, task_description, task_assignee, start_day, deadline)
                                      VALUES ('$project_name', '$task_name', '$task_description', '$task_assignee','$start_day', '$deadline')";
        }
    }

    public function save()
    {
        global $mysqli;
        global $adding_new_task;
        if (!empty($_GET['task_name']) && !empty($_GET['project_name']) && !empty($_GET['save_task']) && !empty($_GET['task_description']) && !empty($_GET['task_assignee']) && !empty($_GET['start_day']) && !empty($_GET['deadline'])) {
            $result = $mysqli->query("SELECT * FROM tasks WHERE proj_name = '" . $_GET['project_name'] . "' AND task_name = '" . $_GET['task_name'] . "'");
            if ($result->num_rows > 0) {
                echo "Task with the name " . $_GET['task_name'] . " for the project " . $_GET['project_name'] . " already exists";
            } else {
                $adding_new_task = mysqli_query($mysqli, $adding_new_task);
                if (!$adding_new_task) {
                    echo "Could not add the task " . $_GET['task_name'];
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                } else {
                    echo "New Task Has Been Added To The Task List</br>";
                }
            }
        }
    }


}
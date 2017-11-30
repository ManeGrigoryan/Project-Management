<?php
class tasks_model{
    public function __construct()
    {
        global $query;
        global $user;
        global $mysqli;
        global $project_managers;
        global $task_assignees;
        $query = "SELECT DISTINCT tasks.proj_name, task_name, task_description, tasks.task_assignee, tasks.start_day, tasks.deadline 
                              FROM tasks JOIN projects ON tasks.proj_name=projects.proj_name";

        $query .= (!empty($pattern)) ? " AND tasks.task_name LIKE '%" . $pattern . "%' " : "";
        $query .= (!empty($_POST['project_name'])) ? " AND tasks.proj_name = '" . $_POST['project_name'] . "' " : "";
        $query .= (!empty($_POST['task_assignee'])) ? " AND tasks.task_assignee='" . $_POST['task_assignee'] . "' " : "";
        $query .= (!empty($_POST['project_manager'])) ? " AND projects.proj_manager ='" . $_POST['project_manager'] . "' " : "";
        $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
        $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' " : "";
        $query .= ($user['position'] == 'admin') ? " " : "";
        global $project_names;
        $project_names = "SELECT proj_name FROM projects ";
        $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
        $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager = '" . $user['email'] . "'" : "";
        $project_names == ($user['position'] == 'developer') ? "SELECT  DISTINCT  proj_name FROM projects JOIN tasks ON task_assignee = '" . $user['email'] . "'" : $project_names;
        $project_names = mysqli_query($mysqli, $project_names);

        $project_managers = "SELECT firstname, lastname, email FROM users WHERE  position='manager'";


        $task_assignees = "SELECT DISTINCT firstname, lastname,email FROM users ";
        $task_assignees .= ($user['position'] == 'admin') ? "WHERE position = 'developer'" :
            " JOIN projects JOIN tasks ON projects.proj_manager='" . $user['email'] . "' AND users.position='developer' AND tasks.proj_name = projects.proj_name ";

    }
}
$instance = new tasks_model();
?>
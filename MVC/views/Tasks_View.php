<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MVC/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MVC/permissions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MVC/controllers/_controller.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MVC/controllers/tasks_controller.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/MVC/models/tasks_model.php');
global $action;

class TasksView
{
    public function addNewTask()
    {
        echo '  <form action="" method="post">
                <input type="submit" name="add_new_task" value="Add New Task"></br>';
        if (isset($_POST['add_new_task'])) {
            $action = 'add_new_task';
            permission($action);
            selectProjects();
            echo '</br><input type="text" name="task_name" placeholder="Task Name"></br>
                    <input type="text" name="task_description" placeholder="Task Description">';
            selectAssignees();
            echo '</select></br>
                        <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
                        <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
                        <input type="submit" name="save_task" value="Save Task">
                        </form>';
        } else {
            global $mysqli;
            if (isset($_POST['save_task'], $_POST['task_name'], $_POST['task_description'], $_POST['project_name'], $_POST['task_assignee'], $_POST['start_day'], $_POST['deadline'])) {
                $task_name = $_POST['task_name'];
                $task_description = $_POST['task_description'];
                $project_name = $_POST['project_name'];
                $task_assignee = $_POST['task_assignee'];
                $start_day = $_POST['start_day'];
                $deadline = $_POST['deadline'];
                $adding_new_task = "INSERT INTO tasks(proj_name, task_name, task_description, task_assignee, start_day, deadline)
                                      VALUES ('$project_name', '$task_name', '$task_description', '$task_assignee','$start_day', '$deadline')";
                if (!empty($task_name) && !empty($project_name) && !empty($task_description) && !empty($task_assignee) && !empty($start_day) && !empty($deadline)) {
                    $result = $mysqli->query("SELECT * FROM tasks WHERE proj_name = '$project_name' AND task_name = '$task_name'");
                    if ($result->num_rows > 0) {
                        echo "Task with the name " . $task_name . " for the project " . $project_name . " already exists";
                    } else {
                        $adding_new_task = mysqli_query($mysqli, $adding_new_task);
                        if (!$adding_new_task) {
                            echo "Could not add the task " . $task_name;
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                        } else {
                            echo "New Task Has Been Added To The Task List</br>";
                        }
                    }
                }
            }
        }


    }


    public function tasksList()
    {
        global $user;
        global $mysqli;
        $action = 'search_in_tasks';
        permission($action);
        echo '<form action="" method="post">
                <input type="text" name="search" placeholder="Search">';
        $pattern = isset($_POST['search']) && $_POST['search'] != '' ? $_POST['search'] : '';
        selectProjects();
        if ($user['position'] == 'manager' || $user['position'] == 'developer') {
            echo '';
        } elseif ($user['position'] == 'admin') {
            selectManagers();
        }
        if ($user['position'] != 'developer') {
            selectAssignees();
        }
        echo '<input type="submit" name="searchbutton" value="Search"></br>';
        global $query;
        echo '<table>
                        <tr><th><input type="submit" name="proj_name" value="Project Name"></th>
                        <th><input type="submit" name="task_name" value="Task Name"></th>
                        <th><input type="submit" name="task_description" value="Task Description" </th>
                        <th><input type="submit" name="assignee" value="Task Assignee Email"></th>
                        <th><input type="submit" name="start_day" value="Starting Date"></th>
                        <th><input type="submit" name="deadline" value="Deadline"></th>
                        </tr>';

        $order = isset($_POST['proj_name']) ? 'tasks.proj_name' : '';
        $order = isset($_POST['task_name']) ? 'task_name' : $order;
        $order = isset($_POST['assignee']) ? 'task_assignee' : $order;
        $order = isset($_POST['start_day']) ? 'tasks.start_day' : $order;
        $order = isset($_POST['deadline']) ? 'tasks.deadline' : $order;
        $order = ($order == '') ? 'tasks.proj_name' : $order;
        $sort = 'ASC';
        $query .= " ORDER BY $order $sort ";

//Pagination starts here
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
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr><td>" . $row['proj_name'] . "</td>
                              <td>" . $row['task_name'] . "</td>
                              <td>" . $row['task_description'] . "</td>
                              <td>" . $row['task_assignee'] . "</td>
                              <td>" . $row['start_day'] . "</td>
                              <td>" . $row['deadline'] . "</td>
                           </tr>";
        }
        echo '</table><br></form>';
        for ($action = 1; $action <= $total_pages; $action++) {
            echo '<a href="?action=' . $action . '">' . $action . '</a>';
        }

    }
}


?>
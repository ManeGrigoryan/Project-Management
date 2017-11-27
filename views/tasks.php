<?php
if (isset($_SESSION['email'])) {
    if (array_key_exists($user['position'], $permission)) {
        $action = 'add_new_task';
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            $project_name = $mysqli->query("SELECT proj_name FROM projects WHERE proj_manager='" . $user['email'] . "'");
            $developers = $mysqli->query("SELECT email,firstname,lastname FROM users WHERE position='developer'");
            echo '<form action="" method="post">
                    <input type="submit" name="add_new_task" value="Add New Task"></br>';
            if (isset($_POST['add_new_task'])) {
                echo '<input type="text" name="task_name" placeholder="Task Name"></br>
                        <input type="text" name="task_description" placeholder="Task Description"></br>
                        <select name="project_name" size="1">
                        <option value="">Select a Project</option>';
                while ($row = $project_name->fetch_assoc()) {
                    echo '<option value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . ' </option>';
                }
                echo '</select></br>
                        <select name="task_assignee" size="1">
                        <option value=""> Select Task Assignee</option>';
                while ($row = $developers->fetch_assoc()) {
                    $task_assignee_firstname = $row['firstname'];
                    $task_assignee_lastname = $row['lastname'];
                    $task_assignee_email = $row['email'];
                    echo "<option value='$task_assignee_email' > $task_assignee_firstname $task_assignee_lastname </option>";
                }
                echo '</select></br>
                        <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
                        <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
                        <input type="submit" name="save_task" value="Save Task">
                        </form>';


            } else {
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
        if (!isset($_POST['add_new_task'])) {
            if (in_array('search_in_tasks', $permission[$user['position']]) !== FALSE) {
                echo '<form action="tasks" method="post" id="taskform" name="taskform">
                        <input type="text" name="search" placeholder="Search"></br>
                        <select name="project_name" size="1">
                        <option value="">Select a Project </option>';

                $project_names = "SELECT proj_name FROM projects ";
                $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
                $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager = '" . $user['email'] . "'" : "";
                $project_names == ($user['position'] == 'developer') ? "SELECT  DISTINCT  proj_name FROM projects JOIN tasks ON task_assignee = '" . $user['email'] . "'" : $project_names;
                $project_names = mysqli_query($mysqli, $project_names);
                $pattern = isset($_POST['search']) && $_POST['search'] != '' ? $_POST['search'] : '';
                $project_name = isset($_POST['project_name']) && $_POST['project_name'] != '' ? $_POST['project_name'] : '';
                while ($row = $project_names->fetch_assoc()) {
                    echo '<option ' . ($project_name === $row['proj_name'] ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
                }
                echo '</select>';

                if ($user['position'] == 'manager' || $user['position'] == 'developer') {
                    echo '</br>';

                } elseif ($user['position'] == 'admin') {
                    $project_manager = isset($_POST['project_manager']) && $_POST['project_manager'] != '' ? $_POST['project_manager'] : '';
                    $project_managers = $mysqli->query("SELECT firstname, lastname, email FROM users WHERE  position='manager'");
                    echo '</br><select name="project_manager" size="1">
                            <option value="">Select a Manager</option>';
                    while ($row = $project_managers->fetch_assoc()) {
                        echo '<option ' . (($project_manager === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
                    }
                    echo '</select></br>';

                }


                if ($user['position'] != 'developer') {

                    $task_assignee = isset($_POST['task_assignee']) && $_POST['task_assignee'] != '' ? $_POST['task_assignee'] : '';
                    $task_assignees = "SELECT DISTINCT firstname, lastname,email FROM users ";
                    $task_assignees .= ($user['position'] == 'admin') ? "WHERE position = 'developer'" :
                        " JOIN projects JOIN tasks ON projects.proj_manager='" . $user['email'] . "' AND users.position='developer' AND tasks.proj_name = projects.proj_name ";


                    echo '<select name="task_assignee" size="1">
                            <option value="">Task Assignees</option>';
                    $task_assignees = mysqli_query($mysqli, $task_assignees);
                    while ($row = $task_assignees->fetch_assoc()) {
                        echo '<option ' . ($task_assignee === $row['email'] ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
                    }
                    echo '</select></br>';

                }


                echo '<input type="submit" name="searchbutton" value="Search"></br>';

                $query = "SELECT DISTINCT tasks.proj_name, task_name, task_description, tasks.task_assignee, tasks.start_day, tasks.deadline 
                              FROM tasks JOIN projects ON tasks.proj_name=projects.proj_name";

                $query .= (!empty($pattern)) ? " AND tasks.task_name LIKE '%" . $pattern . "%' " : "";
                $query .= (!empty($project_name)) ? " AND tasks.proj_name = '" . $project_name . "' " : "";
                $query .= (!empty($task_assignee)) ? " AND tasks.task_assignee='" . $task_assignee . "' " : "";
                $query .= (!empty($project_manager)) ? " AND projects.proj_manager ='" . $project_manager . "' " : "";
                $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
                $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' " : "";
                $query .= ($user['position'] == 'admin') ? " " : "";

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
                $result = mysqli_query($db, $query);
                $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
                $perpage = 10;
                $start_number = (($action - 1) * $perpage);
                $total_elements = mysqli_num_rows($result);
                $total_pages = ceil($total_elements / $perpage);

                $query .= " LIMIT $start_number, $perpage";
                $query = mysqli_query($db, $query);

                if (!$query) {
                    var_dump($query);
                    printf("Error: %s\n", mysqli_error($db));
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
                echo "<style>
                        table, th, td,tr { border: 1px solid black; }
                        </style></table><br></form>";

                for ($action = 0; $action < $total_pages; $action++) {
//                    echo '<a onclick="document.getElementById(\'page\').value='.$action.'" href="?action=' . $action . '">' . ($action + 1)  . '</a>';
                    echo '<button  onclick="document.getElementById(\'list_page\').value='.$action.'" document.getElementById(\'taskform\').submit()">' . ($action + 1)  . '</button>';
//                    echo '<script type="text/javascript">document.getElementById(\'taskform\').submit()</script>';

                }


                echo '<input id="list_page" value="" type="hidden">';

            }
        }
    }
}
?>
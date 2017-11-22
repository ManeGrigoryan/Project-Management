<?php
if (isset($_SESSION['email'])) {
    if (array_key_exists($user['position'], $permission)) {
        $action = 'add_new_task';
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            $proj_name = $mysqli->query("SELECT  `proj_name`  FROM `Projects` WHERE `proj_manager` = '" . $user['email'] . "'");
            $developers = $mysqli->query("SELECT  `email`  FROM `Users` WHERE `position` = 'developer'");
            echo "<form action='#' method = 'POST'>
		<input type = 'submit' value = 'Add New Task' name = 'newtask'><br>";


            if (isset($_POST['newtask'])) {
                echo "<input type='text' name='task_name' placeholder='Task Name' required><br>
		<input type='text' name='description' placeholder='Task Description' required><br>
        <label>
        <select name='proj_name' size = '1' required >
        <option  value = '' > Select Project </option>";


                while ($row = $proj_name->fetch_assoc()) {

                    $name = $row['proj_name'];

                    echo '<option value="' . $name . '"> ' . $name . '</option>';
                }
                echo "</select></br>";
                echo "</label>";


                echo '
        <label> 
        <select name="assignee" size="1" required>
        <option value="">Select Task Assignee</option>';

                while ($row = $developers->fetch_assoc()) {

                    $assignee = $row['email'];

                    echo '<option value="' . $assignee . '"> ' . $assignee . '</option>';

                }
                echo "</select></br>";
                echo "</label>";
                echo '<label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
        <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
        <input type="submit" name="save_task" value="Save Task">';

                echo "</form>";
            } else {
                if (isset($_POST['save_task'], $_POST['task_name'], $_POST['description'], $_POST['proj_name'], $_POST['assignee'], $_POST['start_day'], $_POST['deadline'])) {
                    $start_day = $_POST['start_day'];
                    $deadline = $_POST['deadline'];
                    $proj_name = $_POST['proj_name'];
                    $task_name = $_POST['task_name'];
                    $task_description = $_POST['description'];
                    $task_assignee = $_POST['assignee'];
                    $sql = "INSERT INTO tasks(`proj_name`, `task_name`, `task_description`, `task_assignee`, `start_day`, `deadline`) 
              VALUES ('$proj_name', '$task_name', '$task_description', '$task_assignee', '$start_day', '$deadline')";

                    if (!empty($task_assignee) && !empty($task_name) && !empty($task_description) && !empty($proj_name)) {
                        $result = $mysqli->query("SELECT * FROM tasks WHERE proj_name = '$proj_name' AND task_name = '$task_name'") or die();

                        if ($result->num_rows > 0) {
                            echo "Task with the name " . $task_name . " for project " . $proj_name . " already exists";


                        }
                        $sql = mysqli_query($mysqli, $sql);
                        if (!$sql) {
                            echo " Could not add the task";
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                            die();
                        } else {
                            echo "New Task has been inserted";
                            echo "</br>";

                        }


                    } else {
                        var_dump($proj_name);
                        var_dump($task_name);
                        var_dump($task_description);
                        var_dump($task_assignee);
                    }
                }

            }
        }
        if (isset($_POST['newtask'])) {
            die();
        } else {
        $action = 'search_in_tasks';
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            $pattern = isset($_POST['search']) && $_POST['search'] != '' ? $_POST['search'] : '';
            $project_name = isset($_POST['project_name']) && $_POST['project_name'] != '' ? $_POST['project_name'] : '';
            $task_assignee = isset($_POST['task_assignee']) && $_POST['task_assignee'] != '' ? $_POST['task_assignee'] : '';
            echo '<form action="" method="post">
              <input type="text" name="search" placeholder="Search" value="' . $pattern . '"></br>
              <select name="project_name" size="1">
              <option value=""> Select a Project</option> ';
            while ($row = $proj_name->fetch_assoc()) {
                echo '<option ' . ($project_name === $row['proj_name'] ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
            }
            echo '</select></br>
              <select name="task_assignee" size="1">
              <option value="">Select an Assignee</option> ';
            while ($row = $developers->fetch_assoc()) {
                echo '<option ' . ($task_assignee === $row['email'] ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['email'] . '</option>';
            }
            echo '</select></br>
              <input type="submit" name="searchbutton" value="Search">';
            global $query;
            $query = "SELECT tasks.proj_name, task_name, task_description, task_assignee, tasks.start_day, tasks.deadline
                 FROM Tasks JOIN Projects 
                 ON tasks.proj_name = projects.proj_name AND projects.proj_manager ='" . $user['email'] . "'";
            $query .= $pattern != '' ? "AND task_name LIKE '%" . $pattern . "%'" : "";
            $query .= $project_name != '' ? "AND tasks.proj_name= '" . $project_name . "'" : "";
            $query .= $task_assignee != '' ? "AND task_assignee = '" . $task_assignee . "'" : "";
        }

            echo "
<table>
    <tr>
    <th><input type='submit' name='proj_name' value='Project Name'></th>
    <th><input type='submit' name='task_name' value='Task Name'></th>
    <th>Task Description</th>
    <th><input type='submit' name='assignee' value='Task Assignee Email'></th>
    <th><input type='submit' name='start_day' value='Starting Date'></th>
    <th><input type='submit' name='deadline' value='Deadline'></th>
</tr><tr>";
            global $order;


            $order == (isset($_POST['proj_name']) && $order != '') ? $order = 'tasks.proj_name' : '';
            $order == (isset($_POST['task_name']) && $order != '') ? $order = 'task_name' : '';
            $order == (isset($_POST['assignee']) && $order != '') ? $order = 'task_assignee' : '';
            $order == (isset($_POST['start_day']) && $order != '') ? $order = 'tasks.start_day' : '';
            $order == (isset($_POST['deadline']) && $order != '') ? $order = 'tasks.deadline' : '';
            $order == ($order == '') ? $order = 'tasks.proj_name' : $order;
            $sort = 'ASC';
            $query .= " ORDER BY $order $sort ";


            $result = mysqli_query($db, $query);
            $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
            $perpage = 10;
            $start_number = (($action - 1) * $perpage);
            $total_elements = mysqli_num_rows($result);
            $total_pages = ceil($total_elements / $perpage);

            $query .= " LIMIT $start_number, $perpage";
            $query = mysqli_query($db, $query);
            if (!$query) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            }

            //Page Numbers' Links
            for ($action = 1; $action <= $total_pages; $action++) {
                echo '<a href="?action=' . $action . '">' . $action . '</a>';

            }


            while ($row = mysqli_fetch_array($query)) {


                echo "<td>" . $row['proj_name'] . "</td>
           <td>" . $row['task_name'] . "</td>
           <td>" . $row['task_description'] . "</td>
           <td>" . $row['task_assignee'] . "</td>
           <td>" . $row['start_day'] . "</td>
           <td>" . $row['deadline'] . "</td>
           </tr>";
            }

            echo "<style>
            table, th, td,tr {
            border: 1px solid black;
            }
          </style>";
            echo "</table><br></form>";

        }

    }


}

?>
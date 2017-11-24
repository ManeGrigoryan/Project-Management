<?php
if (isset($_SESSION['email'])) {
    if (array_key_exists($user['position'], $permission)) {
        $action = 'add_new_project';
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            $project_managers = $mysqli->query("SELECT firstname, lastname, email FROM users WHERE position='manager'");
            echo '<form action="" method="post">
                    <input type="submit" name="add_new_project" value="Add New Project"></br>';
            if (isset($_POST['add_new_project'])) {
                echo '<input type="text" name="project_name" placeholder="Project Name"></br>
                        <input type="text" name="project_description" placeholder="Project Description"></br>
                        <select name="project_manager" size="1">
                        <option value="">Select a Manager</option> ';
                while ($row = $project_managers->fetch_assoc()) {
                    $project_manager_email = $row['email'];
                    $project_manager_firstname = $row['firstname'];
                    $project_manager_lastname = $row['lastname'];
                    echo "<option value='$project_manager_email' > $project_manager_firstname $project_manager_lastname </option>";
                }
                echo '</select></br>
                        <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
                        <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
                        <input type="submit" name="save_project" value="Save Project">
                        </form>';
            } else {
                if (isset($_POST['save_project'], $_POST['project_name'], $_POST['project_description'], $_POST['project_manager'], $_POST['start_day'], $_POST['deadline'])) {
                    $project_name = $_POST['project_name'];
                    $project_description = $_POST['project_description'];
                    $project_manager = $_POST['project_manager'];
                    $start_day = $_POST['start_day'];
                    $deadline = $_POST['deadline'];
                    $adding_new_project = "INSERT INTO projects(proj_name, description, proj_manager, start_day, deadline)
                                        VALUES ('$project_name', '$project_description','$project_manager' , '$start_day', '$deadline')";
                    if (!empty($project_name) && !empty($project_description) && !empty($project_manager) && !empty($start_day) && !empty($deadline)) {
                        $result = $mysqli->query("SELECT * FROM projects WHERE proj_name='$project_name'");
                        if ($result->num_rows > 0) {
                            echo "Project with project name " . $project_name . " already exists</br>";
                        } else {
                            $adding_new_project = mysqli_query($mysqli, $adding_new_project);
                            if (!$adding_new_project) {
                                echo "Could Not Add The New Project " . $project_name. "</br>";
                                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                            } else {
                                echo "New Project " . $project_name . " Has Been Added To The Projects' List </br>";
                            }
                        }
                    }
                }
            }
        }
        if (!isset($_POST['add_new_project']) && empty($_POST['add_new_project'])) {
            $action = 'search_in_projects';
            if (in_array($action, $permission[$user['position']]) !== FALSE) {
                $project_names = $mysqli->query("SELECT proj_name FROM projects");
                $project_managers = $mysqli->query("SELECT firstname, lastname, email FROM users WHERE position='manager'");
                global $project_manager;
                global $project_name;
                $project_name = isset($_POST['project_name']) && $_POST['project_name'] != '' ? $_POST['project_name'] : '';
                $project_manager = isset($_POST['project_manager']) && $_POST['project_manager'] != '' ? $_POST['project_manager'] : '';
                echo '<form action="" method="post">
                        <select name="project_name" size="1">
                        <option value=""> Select a Project</option>';
                while ($row = $project_names->fetch_assoc()) {
                    echo '<option ' . ($project_name === $row['proj_name'] ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
                }
                echo '</select></br>
                        <select name="project_manager" size="1">
                        <option value="">Select a Manager</option>';
                while ($row = $project_managers->fetch_assoc()) {
                    echo '<option ' . (($project_manager === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
                }
                echo '</select></br>
                        <input type="submit" name="searchbutton" value="Search"></br>';

            }
            $query = "SELECT DISTINCT projects.proj_name, description, proj_manager, projects.start_day, projects.deadline FROM projects JOIN tasks On 1";
            $query .= (!empty($project_name)) ? " AND projects.proj_name = '" . $project_name . "' " : "";
            $query .= (!empty($project_manager)) ? " AND projects.proj_manager ='" . $project_manager . "' " : "";
            $query .= ($user['position'] == 'manager') ? " AND proj_manager = '" . $user['email'] . "' " : "";
            $query .= ($user['position'] == 'developer') ? " AND task_assignee = '" . $user['email'] . "' " : "";
            $query .= ($user['position'] == 'admin') ? " " : "";
            echo '<table>
                        <tr><th><input type="submit" name="proj_name" value="Project Name"></th>
                        <th><input type="submit" name="project_description" value="Project Description" </th>
                        <th><input type="submit" name="proj_manager" value="Project Manager Email"></th>
                        <th><input type="submit" name="start_day" value="Starting Date"></th>
                        <th><input type="submit" name="deadline" value="Deadline"></th>
                        </tr>';
            global $order;
            $order == (isset($_POST['proj_name']) && $order != '') ? $order = 'projects.proj_name' : '';
            $order == (isset($_POST['proj_manager']) && $order != '') ? $order = 'proj_manager' : '';
            $order == (isset($_POST['start_day']) && $order != '') ? $order = 'projects.start_day' : '';
            $order == (isset($_POST['deadline']) && $order != '') ? $order = 'projects.deadline' : '';
            $order == ($order == '') ? $order = 'projects.proj_name' : $order;
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
                      <td>" . $row['description'] . "</td>
                      <td>" . $row['proj_manager'] . "</td>
                      <td>" . $row['start_day'] . "</td>
                      <td>" . $row['deadline'] . "</td>
                      </tr>";
            }
            echo "<style>
                        table, th, td,tr { border: 1px solid black; }
                        </style></table><br></form>";

            for ($action = 1; $action <= $total_pages; $action++) {
                echo '<a href="?action=' . $action . '">' . $action . '</a>';
            }
        }
    }
}

?>
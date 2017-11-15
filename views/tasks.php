<?php
// Add filtering functionality by (task name, task assignee, project)

if (isset($_SESSION['email'])) {

    switch ($user['position']) {

        case 'admin':
            echo '<form action="" method="post">
            <input type="text" name="search" placeholder="Search"></br>
            <label>
            <select name="project_name" size="1">
            <option value="">Select a Project</option>';

            $proj_name = $mysqli->query("SELECT  `proj_name`  FROM `Projects` ");
            while ($row = $proj_name->fetch_assoc()) {

                $project_name = $row['proj_name'];

                echo '<option value="' . $project_name . '"> ' . $project_name . '</option>';
            }

            echo '</select> </br>
            </label>';

            echo '<label>
            <select name="project_manager" size="1">
            <option value="">Select Manager</option>';
            $managers = $mysqli->query("SELECT DISTINCT firstname, lastname, email 
                                                FROM users WHERE position='manager'");
            while ($row = $managers->fetch_assoc()) {

                $manager_email = $row['email'];
                $manager_firstname = $row['firstname'];
                $manager_lastname = $row['lastname'];

                echo "<option value='$manager_email' > $manager_firstname $manager_lastname </option>";

            }
            echo '</select></br>
            </label>';

            echo '<label>
            <select name="developer" size="1">
            <option value="">Select Developer</option>';
            $developers = $mysqli->query("SELECT DISTINCT firstname, lastname, email 
                                                FROM users WHERE position='developer'");
            while ($row = $developers->fetch_assoc()) {

                $assignee_email = $row['email'];
                $assignee_firstname = $row['firstname'];
                $assignee_lastname = $row['lastname'];

                echo "<option value='$assignee_email' > $assignee_firstname $assignee_lastname </option>";

            }
            echo '</select></br>
            </label>
            <input type="submit" name="searchbutton" value="Search">
            </form>';
            if (isset($_POST['searchbutton'])) {
                if (isset($_POST['searchbutton'], $_POST['search'], $_POST['project_name'], $_POST['developer'], $_POST['project_manager'])) {
                    global $query;
                    $pattern = $_POST['search'];
                    $project_name = $_POST['project_name'];
                    $project_manager = $_POST['project_manager'];
                    $task_assignee = $_POST['developer'];
                    $query = "SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` , tasks.start_day, tasks.deadline
                    FROM projects JOIN tasks ON projects.proj_name=tasks.proj_name ";
                    $query .= (!empty($pattern)) ? "AND tasks.task_name LIKE '%" . $pattern . "%'" : "";
                    $query .= (!empty($project_name)) ? "AND tasks.proj_name='" . $project_name . "' " : "";
                    $query .= (!empty($task_assignee)) ? "AND tasks.task_assignee='" . $task_assignee . "'" : "";
                    $query .= (!empty($project_managero)) ? "AND projects.proj_manager '" . $project_manager . "' " : "";
                }
                $query = mysqli_query($db, $query);
            } else {
                $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` , tasks.start_day, tasks.deadline
                    FROM projects JOIN tasks ON projects.proj_name=tasks.proj_name ");
            }

            break;


        case 'manager':

            // ADDING NEW PROJECT BY MANAGER
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
                            unset($_POST['newtask']);

                        }
                        if (!mysqli_query($mysqli, $sql)) {
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


                $query = $mysqli->query("SELECT tasks.proj_name, task_name, task_description, task_assignee, tasks.start_day, tasks.deadline
                      FROM Tasks JOIN Projects 
                      ON tasks.proj_name = projects.proj_name AND projects.proj_manager ='" . $user['email'] . "'
                      ORDER BY tasks.proj_name ASC");
                echo '<form action="" method="post">
            <input type="text" name="search" placeholder="Search"></br>
            <label>
            <select name="project_name" size="1">
            <option value="">Select a Project</option>';

                $proj_name = $mysqli->query("SELECT  `proj_name`  FROM `Projects` WHERE projects.proj_manager='" . $user['email'] . "'");
                while ($row = $proj_name->fetch_assoc()) {

                    $project_name = $row['proj_name'];

                    echo '<option value="' . $project_name . '"> ' . $project_name . '</option>';
                }

                echo '</select> </br>
            </label>';

                echo '<label>
            <select name="developer" size="1">
            <option value="">Select a Developer</option>';
                $developers = $mysqli->query("SELECT DISTINCT firstname, lastname, email 
                                                FROM users JOIN projects JOIN tasks
                                                ON projects.proj_manager='" . $user['email'] . "'
                                                AND tasks.task_assignee =users.email
                                                AND tasks.proj_name=projects.proj_name   ");
                while ($row = $developers->fetch_assoc()) {

                    $assignee_email = $row['email'];
                    $assignee_firstname = $row['firstname'];
                    $assignee_lastname = $row['lastname'];

                    echo "<option value='$assignee_email' > $assignee_firstname $assignee_lastname </option>";

                }
                echo '</select></br>
            </label>
            <input type="submit" name="searchbutton" value="Search">
            </form>';
                if (isset($_POST['searchbutton'], $_POST['search'], $_POST['project_name'], $_POST['developer'])) {
                    global $query;
                    $pattern = $_POST['search'];
                    $project_name = $_POST['project_name'];
                    $task_assignee = $_POST['developer'];
                    $query = "SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee, tasks.start_day, tasks.deadline
                    FROM projects JOIN tasks ON tasks.proj_name=projects.proj_name AND projects.proj_manager= '" . $user['email'] . "'";
                    $query .= (!empty($pattern)) ? "AND tasks.task_name LIKE '%" . $pattern . "%'" : "";
                    $query .= (!empty($project_name)) ? "AND tasks.proj_name='" . $project_name . "'" : "";
                    $query .= (!empty($task_assignee)) ? "AND tasks.task_assignee= '" . $task_assignee . "'" : "";
                    $query = mysqli_query($db, $query);
                } else {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` , tasks.start_day, tasks.deadline
                    FROM projects JOIN tasks ON tasks.proj_name=projects.proj_name AND projects.proj_manager= '" . $user['email'] . "'");
                }


            }

            break;


        case 'developer':

            echo '<form action="" method="post">
            <input type="text" name="search" placeholder="Search"></br>
            <label>
            <select name="project_name" size="1">
            <option value="">Select a Project</option>';

            $proj_name = $mysqli->query("SELECT DISTINCT proj_name FROM tasks WHERE tasks.task_assignee='" . $user['email'] . "' ");
            while ($row = $proj_name->fetch_assoc()) {

                $project_name = $row['proj_name'];

                echo '<option value="' . $project_name . '"> ' . $project_name . '</option>';
            }

            echo '</select> </br>
            </label>
            <input type="submit" name="searchbutton" value="Search">
            </form>';
            if (isset($_POST['searchbutton'])) {
                if (isset($_POST['searchbutton'], $_POST['search'], $_POST['project_name'])) {
                    global $query;
                    $pattern = $_POST['search'];
                    $project_name = $_POST['project_name'];

                        $query = "SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` ,tasks.start_day, tasks.deadline
                      FROM `tasks`
                     WHERE `task_assignee` = '" . $user['email'] . "' ";
                        $query .= (!empty($pattern)) ? "AND task_name LIKE '" . $pattern . "'" : "";
                        $query .= (!empty($project_name)) ? "AND tasks.proj_name= '" . $project_name . "'" : "";
                        $query = mysqli_query($db, $query);

                }
            }

                else {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` ,tasks.start_day, tasks.deadline
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "'");
                }


                break;


    }
                if (isset($_POST['newtask'])) {
                    die();
                } else {


                    echo "<table id = tasks> <caption>Tasks</caption>
    <tr>
    <th>Project Name</th>
    <th>Task Name</th>
    <th>Task Description</th>
    <th>Task Assignee Email</th>
    <th>Starting Date</th>
    <th>Deadline</th>
</tr><tr>";

                    if (!$query) {
//        var_dump($query);
//        var_dump($project_manager);
//        var_dump($pattern);
//        var_dump($project_name);
//        var_dump($task_assignee);
//        printf("Error: %s\n", mysqli_error($db));
                        exit();
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
                    echo "</table><br>";


                }
            }

            ?>
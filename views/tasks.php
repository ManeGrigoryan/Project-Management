<?php
// Add filtering functionality by (task name, task assignee, project)
// Add columns (create_date, update_date) to tasks and projects tables

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

          if(isset($_POST['searchbutton'], $_POST['search'], $_POST['project_name'],$_POST['developer'],$_POST['project_manager'])){
              global $query;
              $pattern=$_POST['search'];
              $project_name=$_POST['project_name'];
              $project_manager=$_POST['project_manager'];
              $task_assignee=$_POST['developer'];

              if(!empty($pattern) && !empty($project_name)&& !empty($project_manager)&& !empty($task_assignee)){
                $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."' AND projects.proj_manager='".$project_manager."' 
                       AND tasks.task_assignee='".$task_assignee."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&& !empty($project_name) && !empty(!$project_manager) && empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."' AND projects.proj_manager='".$project_manager."' 
                       AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&& !empty($project_name) && empty($project_manager) && !empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."'  
                       AND tasks.task_assignee='".$task_assignee."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&& !empty($project_name) &&empty($project_manager) && empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&& empty($project_name)&& !empty($project_manager)&& !empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON projects.proj_manager='".$project_manager."' 
                       AND tasks.task_assignee='".$task_assignee."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&&empty($project_name) && !empty($project_manager)&&empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON  projects.proj_manager='".$project_manager."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern)&& empty($project_name) && empty($project_manager) && !empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.task_assignee='".$task_assignee."' AND tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (!empty($pattern) && empty($project_name) && empty($project_manager) && empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.task_name LIKE '%".$pattern."%'");
              }
              elseif (empty($pattern) && !empty($project_name) && !empty($project_manager)&&!empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."' AND projects.proj_manager='".$project_manager."' 
                       AND tasks.task_assignee='".$task_assignee."'");
              }
              elseif (empty($pattern)&& !empty($project_name)&& !empty($project_manager && empty($task_assignee))){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."' AND projects.proj_manager='".$project_manager."' ");
              }
              elseif (empty($pattern)&& !empty($project_name)&& empty($project_manager)&& !empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."'  AND tasks.task_assignee='".$task_assignee."' ");
              }
              elseif (empty($pattern)&&!empty($project_name)&& empty($project_manager) && empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON tasks.proj_name='".$project_name."'");
              }
              elseif (empty($pattern)&&empty($project_name) &&!empty($project_manager)&&!empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON projects.proj_manager='".$project_manager."' AND tasks.task_assignee='".$task_assignee."' ");
              }
              elseif (empty($pattern)&&empty($project_name) &&!empty($project_manager)&&empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON  projects.proj_manager='".$project_manager."' AND tasks.proj_name=projects.proj_name");
              }
              elseif (empty($pattern)&&empty($project_name) && empty($project_manager) && !empty($task_assignee)){
                  $query=$mysqli->query("SELECT DISTINCT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` 
                       FROM projects JOIN tasks 
                       ON  tasks.task_assignee='".$task_assignee."'");
              }
              elseif (empty($pattern)&&empty($project_name)&&empty($project_manager)&&empty($task_assignee)){
                  $query=$mysqli->query("SELECT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` FROM tasks");
              }
          }
          else{
              $query=$mysqli->query("SELECT `tasks`.`proj_name`, `task_name`, `task_description`, `task_assignee` FROM tasks");
          }



            break;


        case 'manager':

            $query = $mysqli->query("SELECT tasks.proj_name, task_name, task_description, task_assignee
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
                if (!empty($pattern) && !empty($project_name) && !empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.proj_name ='" . $project_name . "' AND tasks.task_assignee='" . $task_assignee . "' 
                    AND tasks.task_name LIKE '%" . $pattern . "%' OR tasks.task_description LIKE  '%" . $pattern . "%' ");
                } elseif (!empty($pattern) && !empty($project_name) && empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.proj_name ='" . $project_name . "' 
                    AND tasks.task_name LIKE '%" . $pattern . "%' OR tasks.task_description LIKE  '%" . $pattern . "%' ");
                } elseif (!empty($pattern) && empty($project_name) && empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.task_name LIKE '%" . $pattern . "%' OR tasks.task_description LIKE  '%" . $pattern . "%' ");
                } elseif (!empty($pattern) && empty($project_name) && !empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.task_assignee='" . $task_assignee . "' 
                    AND tasks.task_name LIKE '%" . $pattern . "%' OR tasks.task_description LIKE  '%" . $pattern . "%' ");
                } elseif (empty($pattern) && !empty($project_name) && !empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.proj_name ='" . $project_name . "' AND tasks.task_assignee='" . $task_assignee . "' ");
                } elseif (empty($pattern) && !empty($project_name) && empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.proj_name ='" . $project_name . "' ");
                } elseif (empty($pattern) && empty($project_name) && !empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, tasks.task_name ,tasks.task_description, tasks.task_assignee
                    FROM projects JOIN tasks
                    ON projects.proj_manager='" . $user['email'] . "' AND projects.proj_name=tasks.proj_name
                    AND tasks.task_assignee='" . $task_assignee . "' ");
                } elseif (empty($pattern) && empty($project_name) && empty($task_assignee)) {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, task_name, task_description, task_assignee
                      FROM Tasks JOIN Projects 
                      ON tasks.proj_name = projects.proj_name AND projects.proj_manager ='" . $user['email'] . "'
                      ORDER BY tasks.proj_name ASC");

                } else {
                    $query = $mysqli->query("SELECT DISTINCT tasks.proj_name, task_name, task_description, task_assignee
                      FROM Tasks JOIN Projects 
                      ON tasks.proj_name = projects.proj_name AND projects.proj_manager ='" . $user['email'] . "'
                      ORDER BY tasks.proj_name ASC");
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

            if (isset($_POST['searchbutton'], $_POST['search'], $_POST['project_name'])) {
                global $query;
                $pattern = $_POST['search'];
                $project_name = $_POST['project_name'];
                if (!empty($project_name) && !empty($pattern)) {

                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "'
                      AND proj_name= '" . $project_name . "' AND task_name LIKE '%" . $pattern . "%' ");
                } elseif (!empty($project_name) && empty($pattern)) {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "'
                      AND proj_name= '" . $project_name . "' ");
                } elseif (empty($project_name) && !empty($pattern)) {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                        FROM `tasks` JOIN `users`
                        ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "'
                        AND task_name LIKE  '%" . $pattern . "%' ");
                } elseif (empty($project_name) && empty($pattern)) {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "' ");
                } else {
                    $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "' ");
                }

            } else {
                $query = $mysqli->query("SELECT DISTINCT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "' ");
            }


            break;

    }


    echo "<table id = tasks> <caption>Tasks</caption>
    <tr>
    <th>Project Name</th>
    <th>Task Name</th>
    <th>Task Description</th>
    <th>Task Assignee Email</th>
</tr><tr>";
    if (!$query) {
        var_dump($query);
        var_dump($project_manager);
        var_dump($pattern);
        var_dump($project_name);
        var_dump($task_assignee);
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    while ($row = mysqli_fetch_array($query)) {
        echo "<td>" . $row['proj_name'] . "</td>
           <td>" . $row['task_name'] . "</td>
           <td>" . $row['task_description'] . "</td>
           <td>" . $row['task_assignee'] . "</td>
           </tr>";
    }

    echo "<style>
            table, th, td,tr {
            border: 1px solid black;
            }
          </style>";
    echo "</table><br>";


    // ADDING NEW PROJECT BY MANAGER
    if ($user['position'] == 'manager') {
        $proj_name = $mysqli->query("SELECT  `proj_name`  FROM `Projects` WHERE `proj_manager` = '" . $user['email'] . "'");
        $developers = $mysqli->query("SELECT  `email`  FROM `Users` WHERE `position` = 'developer'");

        echo "<form action='#' method = 'POST'>
		<input type = 'submit' value = 'Add New Task' name = 'newtask'><br>
		<input type='text' name='task_name' placeholder='Task Name' required><br>
		<input type='text' name='description' placeholder='Task Description' required><br>
        <label> Project 
        <select name='proj_name' size = '1' required >
        <option  value = '' > --SELECT PROJECT-- </option>
        ";


        while ($row = $proj_name->fetch_assoc()) {

            $name = $row['proj_name'];

            echo '<option value="' . $name . '"> ' . $name . '</option>';
        }
        echo "</select>";
        echo "</label>";


        echo '
        <label> Task Assignee
        <select name="assignee" size="1" required>
        <option value="">--SELECT TASK ASSIGNEE--</option>';

        while ($row = $developers->fetch_assoc()) {

            $assignee = $row['email'];

            echo '<option value="' . $assignee . '"> ' . $assignee . '</option>';

        }
        echo "</select>";
        echo "</label>";
        echo "</form>";


        if (isset($_POST['task_name'], $_POST['description'], $_POST['proj_name'], $_POST['assignee'])) {
            $proj_name = $_POST['proj_name'];
            $task_name = $_POST['task_name'];
            $task_description = $_POST['description'];
            $task_assignee = $_POST['assignee'];
            $sql = "INSERT INTO tasks(`proj_name`, `task_name`, `task_description`, `task_assignee`) 
              VALUES ('$proj_name', '$task_name', '$task_description', '$task_assignee')";

            if (!empty($task_assignee) && !empty($task_name) && !empty($task_description) && !empty($proj_name)) {
                $result = $mysqli->query("SELECT * FROM tasks WHERE proj_name = '$proj_name' AND task_name = '$task_name'") or die();
                if ($result->num_rows > 0) {
                    echo "Task with the name " . $task_name . " for project " . $proj_name . " already exists";
                    header('refresh:2', 'Location: http://www.projectmanagement.com/tasks.php');
                    die();
                }
                if (!mysqli_query($mysqli, $sql)) {
                    echo "COULD NOT ADD THE TASK";
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                    die();
                } else {
                    echo "NEW TASK HAS BEEN INSERTED";
                    header('refresh:2', 'Location: http://www.projectmanagement.com/tasks.php');
                    die();
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
?>
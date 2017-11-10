<?php
// Add filtering functionality by (task name, task assignee, project)
// Add columns (create_date, update_date) to tasks and projects tables

if (isset($_SESSION['email'])) {
    switch ($user['position']) {

        case 'admin':
            $query = "SELECT proj_name, task_name, task_description, task_assignee 
                      FROM Tasks 
                      ORDER BY proj_name ASC";
            echo '<form action="" method="post">
            <input type="text" name="search" placeholder="Search"></br>
            <label>
            <select name="project_name" size="1">
            <option value="">Select a Project</option>';

            $proj_name = $mysqli->query("SELECT  `proj_name`  FROM `Projects`");
            while ($row = $proj_name->fetch_assoc()) {

                $project_name = $row['proj_name'];

                echo '<option value="' . $project_name . '"> ' . $project_name . '</option>';
            }

            echo '</select> </br>
            </label>';

            echo '<label>
            <select name="developer" size="1">
            <option value="">Select a Developer</option>';
            $developers = $mysqli->query("SELECT  `email`, `firstname`, `lastname` FROM `Users` WHERE `position` = 'developer'");
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
            break;


        case 'manager':
            $query = "SELECT tasks.proj_name, task_name, task_description, task_assignee
                      FROM Tasks JOIN Projects 
                      ON tasks.proj_name = projects.proj_name AND projects.proj_manager ='" . $user['email'] . "'
                      ORDER BY tasks.proj_name ASC";
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
            break;


        case 'developer':
            $query = "SELECT `tasks`.`proj_name`,`task_name`,`task_description`, `task_assignee` 
                      FROM `tasks` JOIN `users`
                      ON `task_assignee` = '" . $user['email'] . "' AND `email` = '" . $user['email'] . "' ";
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
            break;

    }
    $result = mysqli_query($db, $query);


    echo "<table id = tasks> <caption>Tasks</caption>
    <tr>
    <th>Project Name</th>
    <th>Task Name</th>
    <th>Task Description</th>
    <th>Task Assignee Email</th>
</tr><tr>";
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    while ($row = mysqli_fetch_array($result)) {
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
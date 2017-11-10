<?php
// Add filtering by

if (isset($_SESSION['email'])) {

    $query = "SElECT * FROM projects";
    switch ($user['position']) {
        case 'admin':
            $and = "";
            break;
        case 'manager':
            $and = " WHERE proj_manager = '" . $user['email'] . "'";
            break;
        case 'developer':
            $and = " JOIN tasks ON `projects`.`proj_name` = `tasks`.`proj_name` AND `task_assignee` ='" . $user['email'] . "'";
            break;
        default:
            break;

    }
    $query .= $and;

    $result = mysqli_query($db, $query);

    echo "<table id = projects> <caption>Projects</caption>
    <tr>
    <th>Project Name</th>
    <th>Project Description</th>
    <th>Project Manager</th>
</tr><tr>";
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    while ($row = mysqli_fetch_array($result)) {
        echo "<td>" . $row['proj_name'] . "</td>
           <td>" . $row['description'] . "</td>
           <td>" . $row['proj_manager'] . "</td>
           </tr>";
    }
    echo "<style>
            table, th, td,tr {
            border: 1px solid black;
            }
          </style>";
    echo "</table>";

    if ($user['position'] == 'admin') {
        ?>
        <form action='#' method='POST'>
            <input type='submit' value='Add New Project' name='newproject'><br>
            <input type='text' name='proj_name' placeholder='Project Name' required><br>
            <input type='text' name='description' placeholder='Project Description' required><br>
            <label for="manager"> Project Manager </label>
            <select id="manager" name="project_manager" size='1' required>
                <option value=""> SELECT PROJECT MANAGER</option>
                <?php
                $managers = $mysqli->query("SELECT  `email`, `firstname`, `lastname`  FROM `Users` WHERE `position`='manager' ");
                while ($row = $managers->fetch_assoc()) {

                    $project_manager_email = $row['email'];
                    $first_name = $row['firstname'];
                    $last_name = $row['lastname'];


                    echo "<option value='$project_manager_email' > $first_name $last_name </option>";

                }
                ?>
            </select>
        </form>

        <?php

        if (isset($_POST['proj_name'], $_POST['description'], $_POST['project_manager'], $_POST['newproject'])) {
            $project_manager = ($_POST['project_manager']);
            $proj_name = ($_POST['proj_name']);
            $description = ($_POST['description']);
            $sql = " INSERT INTO `Projects` (`proj_name`, `description`, `proj_manager`)
VALUES ('$proj_name', '$description', '$project_manager') ";

            if (!empty($proj_name) && !empty($description) && !empty($project_manager)) {
                $result = $mysqli->query("SELECT * FROM projects WHERE proj_name = '$proj_name'") or die();
                if ($result->num_rows > 0) {
                    echo "Project with the name " . $proj_name . " already exists";
                    header('refresh:1', 'Location: http://www.projectmanagement.com/projects.php');
                    die();
                }
                if (!mysqli_query($mysqli, $sql)) {
                    die();

                } else {
                    echo "NEW PROJECT HAS BEEN INSERTED";
                    header('refresh:0', 'Location: http://www.projectmanagement.com/projects.php');
                    die();


                }

            } else {
                var_dump($proj_name);
                var_dump($description);
                var_dump($project_manager);
                die();
            }
        }


    } else {
        die();
    }
} else {
    echo "You are not logged in, in order to see the info about projects";
}
?>
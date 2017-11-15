<?php
// Add filtering by

if (isset($_SESSION['email'])) {


    switch ($user['position']) {
        case 'admin':
            echo '<form action="" method="post">
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
                   </label>
                   <input type="submit" name="searchbutton" value="Search"></br>
                   </form>';

            if (isset($_POST['searchbutton'], $_POST['project_manager'], $_POST['project_name'])){
                $project_manager=$_POST['project_manager'];
                $project_name=$_POST['project_name'];
                global $query;
                $query="SELECT `proj_name`, `description`, `proj_manager` FROM projects WHERE proj_manager LIKE '%".$project_manager."%' 
                        AND proj_name LIKE '%".$project_name."%' "
                        ;
            }
            else {$query = "SElECT * FROM projects";}
            break;
        case 'manager':
            $query = " SElECT * FROM projects WHERE proj_manager = '" . $user['email'] . "'";
            break;
        case 'developer':
            $query = "SElECT * FROM projects  JOIN tasks ON `projects`.`proj_name` = `tasks`.`proj_name` AND `task_assignee` ='" . $user['email'] . "'";
            break;
        default:
            break;

    }


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
     echo '<form action="" method="POST">
            <input type="submit" value="Add New Project" name="newproject"><br>
            <input type="text" name="proj_name" placeholder="Project Name" required><br>
            <input type="text" name="description" placeholder="Project Description" required><br>
            <label for="manager"> Project Manager </label>
            <select id="manager" name="project_manager" size="1" required>
            <option value=""> Select Project Manager</option>';
     $managers = $mysqli->query("SELECT  `email`, `firstname`, `lastname`  FROM `Users` WHERE `position`='manager' ");
                while ($row = $managers->fetch_assoc()) {

                    $project_manager_email = $row['email'];
                    $first_name = $row['firstname'];
                    $last_name = $row['lastname'];


                    echo "<option value='$project_manager_email' > $first_name $last_name </option>";

                }

          echo ' </select>
            <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
            <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
        </form>' ;



        if (isset($_POST['proj_name'], $_POST['description'], $_POST['project_manager'], $_POST['newproject'], $_POST['start_day'], $_POST['deadline'])) {
            $project_manager = ($_POST['project_manager']);
            $proj_name = ($_POST['proj_name']);
            $description = ($_POST['description']);
            $start_day=$_POST['start_day'];
            $deadline=$_POST['deadline'];
            $sql = " INSERT INTO `Projects` (`proj_name`, `description`, `proj_manager`, `start_day`, `deadline`)
                    VALUES ('$proj_name', '$description', '$project_manager', '$start_day', '$deadline') ";

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
                    header('refresh:2', 'Location: http://www.projectmanagement.com/projects.php');
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
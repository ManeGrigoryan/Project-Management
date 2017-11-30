<?php
require_once 'permissions.php';

function selectProjects()
{
    global $user;
    global $mysqli;
    echo '</br><select name="project_name" size="1">
    <option value=""> Select a Project </option>';
    $project_names = "SELECT DISTINCT proj_name FROM projects";
    $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
    $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager = '" . $user['email'] . "'" : "";
    $project_names == ($user['position'] == 'developer') ? "SELECT  DISTINCT  proj_name FROM projects JOIN tasks ON task_assignee = '" . $user['email'] . "'" : $project_names;
    $project_names = mysqli_query($mysqli, $project_names);
    $project_name = isset($_POST['project_name']) && $_POST['project_name'] != '' ? $_POST['project_name'] : '';
    while ($row = $project_names->fetch_assoc()) {
        echo '<option ' . ($project_name === $row['proj_name'] ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
    }
    echo '</select>';
}


function selectManagers()
{
    global $user;
    global $mysqli;
    echo '</br><select name="project_manager" size="1">
            <option value="">Select a Manager</option>';
    $project_managers = "SELECT DISTINCT firstname, lastname, email FROM users JOIN projects ON users.position = 'manager'";
    $project_managers = mysqli_query($mysqli, $project_managers);
    $project_manager = isset($_POST['project_manager']) && $_POST['project_manager'] != '' ? $_POST['project_manager'] : '';
    while ($row = $project_managers->fetch_assoc()) {
        echo '<option ' . (($project_manager === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
    }
    echo '</select>';
}

function selectAssignees()
{
    global $mysqli;
    global $user;
    echo '</select></br>
          <select name="task_assignee" size="1">
          <option value=""> Select Task Assignee</option>';
    $task_assignees = "SELECT DISTINCT firstname, lastname,email FROM users ";
    $task_assignees .= ($user['position'] == 'admin') ? "WHERE position = 'developer'" :
        " JOIN projects JOIN tasks ON projects.proj_manager='" . $user['email'] . "' AND users.position='developer' AND tasks.proj_name = projects.proj_name ";
    $task_assignees = mysqli_query($mysqli, $task_assignees);
    $task_assignee = isset($_POST['task_assignee']) && $_POST['task_assignee'] != '' ? $_POST['task_assignee'] : '';
    while ($row = $task_assignees->fetch_assoc()) {
        $task_assignee_firstname = $row['firstname'];
        $task_assignee_lastname = $row['lastname'];
        $task_assignee_email = $row['email'];
        echo '<option ' . (($task_assignee === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
    }
    echo '</select></br>';
}


function permission($action)
{
    global $user;
    global $permission;
    if (isset($_SESSION['email'])) {
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            echo '</br>';
        } else {
            var_dump($user['position']);
            var_dump($permission);
            var_dump($action);
            echo 'You are not allowed to do this ' . $action . ' action';
            die();
        }

    }


}

?>
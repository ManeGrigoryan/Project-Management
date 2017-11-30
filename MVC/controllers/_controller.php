<?php
require_once 'header.php';
require_once 'footer.php';
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/MVC/permissions.php');

class _controller
{
//
//
//    public function selectProjects()
//    {
//        global $user;
//        global $mysqli;
//        echo '</br><select name="project_name" size="1">
//                <option value=""> Select a Project </option>';
//        $project_names = "SELECT DISTINCT proj_name FROM projects";
//        $project_names .= ($user['position'] == 'admin') ? " WHERE 1" : "";
//        $project_names .= ($user['position'] == 'manager') ? " WHERE proj_manager = '" . $user['email'] . "'" : "";
//        $project_names == ($user['position'] == 'developer') ? "SELECT  DISTINCT  proj_name FROM projects JOIN tasks ON task_assignee = '" . $user['email'] . "'" : $project_names;
//        $project_names = mysqli_query($mysqli, $project_names);
//        $project_name = isset($_POST['project_name']) && $_POST['project_name'] != '' ? $_POST['project_name'] : '';
//        while ($row = $project_names->fetch_assoc()) {
//            echo '<option ' . ($project_name === $row['proj_name'] ? ' selected ' : '') . ' value="' . $row['proj_name'] . '"> ' . $row['proj_name'] . '</option>';
//        }
//        echo '</select></br>';
//    }
//
//
//    public function selectManagers()
//    {
//        global $user;
//        global $mysqli;
//        echo '</br><select name="project_manager" size="1">
//            <option value="">Select a Manager</option>';
//        $project_managers = "SELECT DISTINCT firstname, lastname, email FROM users JOIN projects ON users.position = 'manager'";
//        $project_managers = mysqli_query($mysqli, $project_managers);
//        $project_manager = isset($_POST['project_manager']) && $_POST['project_manager'] != '' ? $_POST['project_manager'] : '';
//        while ($row = $project_managers->fetch_assoc()) {
//            echo '<option ' . (($project_manager === $row['email']) ? ' selected ' : '') . ' value="' . $row['email'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
//        }
//        echo '</select></br>';
//    }
//
//    public function selectAssignees()
//    {
//        global $user;
//        global $mysqli;
//        echo '</br><select name="task_assignees" size="1">
//            <option value="">Select an Assignee</option>';
//        $developers = "SELECT DISTINCT firstname,lastname,email FROM users JOIN tasks ON users.position = 'developer'";
//        $developers .= ($user['position'] == 'developer') ? " AND tasks.task_assignee= '" . $user['email'] . "'" : "";
//        $task_assignee = isset($_POST['task_assignee']) && $_POST['task_assignee'] != '' ? $_POST['task_assignee'] : '';
//        $developers = mysqli_query($mysqli, $developers);
//        while ($row = $developers->fetch_assoc()) {
//            echo '<option ' . ($task_assignee === $row['task_assignee'] ? ' selected ' : '') . ' value="' . $row['task_assignee'] . '"> ' . $row['firstname'] . $row['lastname'] . '</option>';
//        }
//        echo '</select></br>';
//    }
//
//    public function permission($action)
//    {
//        global $user;
//        global $permission;
//        if (isset($_SESSION['email'])) {
//
//            if (in_array($action, $permission[$user['position']]) !== FALSE) {
//                echo '<form action="" method="post" >';
//            }
//        }
//
//
//    }

}



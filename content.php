<?php

switch ($page) {
    case "signup":
        require('views/signup.php');
        break;
    case "login":
        require('views/login.php');
        break;
    case "logout":
        require('views/logout.php');
        break;
    case "projects":
        require('views/projects.php');
        break;
    case "users":
        require('views/users.php');
        break;
    case "tasks":
        require('views/tasks.php');
        break;
    case "profile":
    case "":
        require('views/profile.php');
        break;
    default:
        require('views/profile.php');
        break;

}
?>
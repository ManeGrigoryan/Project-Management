<?php

if (isset($_SESSION['email'])) {
    echo "You are now logged out " . $_SESSION['email'];

    session_destroy();
    header('refresh:1','Location: http://www.projectmanagement.com/login.php');
    exit();
} else {
    echo "No user is logged in in order to log out ";
}
?>
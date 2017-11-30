<?php
$user = "root";
$pass = "";
$db = "test_db";
$db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
global $mysqli;
$mysqli = mysqli_connect("localhost","root","","test_db");
?>
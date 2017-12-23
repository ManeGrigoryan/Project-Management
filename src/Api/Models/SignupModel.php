<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:01 PM
 */

class SignupModel extends Model
{
    public function signup()
    {
        $mysqli = mysqli_connect("localhost", "root", "", "test_db");
        if (isset($_POST['signup'])) {

            $_SESSION['firstname'] = $_POST['firstname'];
            $_SESSION['lastname'] = $_POST['lastname'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['position'] = $_POST['position'];

            $firstname = $mysqli->escape_string($_POST['firstname']);
            $lastname = $mysqli->escape_string($_POST['lastname']);
            $email = $mysqli->escape_string($_POST['email']);
            $password = $mysqli->escape_string($_POST['password']);
            $hash = md5($password);
            $position = $mysqli->escape_string($_POST['position']);
            $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'") or die();
            if ($result->num_rows > 0) {
                echo "User with email address " . $email . " already exists";
                header('refresh:2', 'Location: http://www.projectmanagement.com/signup.php');
                exit();
            } else {
                $sql = "INSERT INTO Users(firstname, lastname, password, email, position ) VALUES ('$firstname', '$lastname', '$hash', '$email',  '$position')";
                if ($mysqli->query($sql)) {
                    #$_SESSION['active'] = 0; //0 until user activates their account with verify.php
                    #$_SESSION['logged_in'] = true; // So we know the user has logged in

                    echo "Welcome to our team " . $firstname . " you are registered as a new member.";
                    header('refresh:2', 'Location: http://www.projectmanagement.com/profile.php');
                    exit();
                }

            }
        }

    }
}
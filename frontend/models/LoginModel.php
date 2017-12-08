<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 6:55 PM
 */

class LoginModel extends Model
{
    public function newLogCheck(){
        global $mysqli;
        $email = $mysqli->escape_string($_POST['email']);
        $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
        if ($result->num_rows == 0) {
            echo "Users with email address " . $email . " does not exist";

        } else {
            $user = $result->fetch_assoc();
            if (md5($_POST['password']) === $user['password']) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['firstname'];
                $_SESSION['last_name'] = $user['lastname'];

                session_write_close();
                header("Location: http://www.projectmanagement.com/profile");
                die();
            }
        }
    }

}
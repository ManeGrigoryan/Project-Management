<?php
require_once 'controllers/_controller.php';
require_once 'functions.php';
class login_controller extends _controller{
    public function __construct()
    {
        global $user;
        global $mysqli;
        if(isset($_SESSION['email'])){
            echo "You are already logged in as " . $_SESSION['email'] . " If it is not You then log out and then log in with your email address";
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['login'])) {
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
                } else {
                    echo "The password is wrong!";
                }
            }

            echo " <div class='login'>
    <div id='loggingin''>
        <h1>Welcome Back!</h1>
        <form action=''method='post' autocomplete='off'>
            <label>Email Address </label> <input type='email' required autocomplete='off'' name='email'/>
            <label>Password </label> <input type='password' required autocomplete='off'name='password'/>
          
            <button type='submit' class='formbutton' name='login'/>
            Log In</button>
        </form>
    </div>
</div> ";

        }

    }
    }
$instance = new login_controller;

?>
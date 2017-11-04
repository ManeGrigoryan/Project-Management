<?php

if (isset($_SESSION['email'])) {
    echo "You are now logged in as " .$_SESSION['email']. ". Please log out and then sign up as a new user.";
}
else{echo "
<div class='signup'>
    <div id='signingup'>


        <h1>Welcome To Our Team!</h1>
        <form action='' method=post autocomplete=off>
            <label>First Name</label> <input type='text' required autocomplete='off' name='firstname'/>
            <label>Last Name</label> <input type='text' required autocomplete='off' name='lastname'/>
            <label>Email Address</label> <input type='email' required autocomplete='off' name='email'/>
            <label>Password</label> <input type='password' required autocomplete='off' name='password'/>
            <div>
                <label>Position</label>
                <input type='radio' name='position' value='admin' required> Admin<br>
                <input type='radio' name='position' value='manager' required> Project Manager<br>
                <input type='radio' name='position' value='developer' required> Developer<br>
            </div>
            <button type='submit' class='formbutton' name='signup'/>
            Sign Up </button>

        </form>
";

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
            header('refresh:2','Location: http://www.projectmanagement.com/signup.php');
            exit();
        } else {
            $sql = "INSERT INTO Users(firstname, lastname, password, email, position ) VALUES ('$firstname', '$lastname', '$hash', '$email',  '$position')";
            if ($mysqli->query($sql)) {
                #$_SESSION['active'] = 0; //0 until user activates their account with verify.php
                #$_SESSION['logged_in'] = true; // So we know the user has logged in

                echo "Welcome to our team ".$firstname." you are registered as a new member.";
                header('refresh:2','Location: http://www.projectmanagement.com/profile.php');
                exit();
            }

        }
    }}

?>


<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:01 PM
 */

class SignupView extends View
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function signedIn()
    {
        echo "You are now logged in as " . $_SESSION['email'] . ". Please log out and then sign up as a new user.";
    }

    public function signup()
    {

        ?>
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
        <?php
        $this->model->signup();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 6:55 PM
 */

class LoginView extends View
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function alreadyLoggedIn()
    {


        ?>
        You are already logged in as  <?php echo $_SESSION['email'] ?> If it is not You then log out and then log in with your email address
        <?php
    }

    public function newLog(){
        ?>
        <div class='login'>
            <div id='loggingin'
            '>
            <h1>Welcome Back!</h1>
            <form action='' method='post' autocomplete='off'>
                <label>Email Address </label> <input type='email' required autocomplete='off' name='email'/>
                <label>Password </label> <input type='password' required autocomplete='off' name='password'/>
                <button type='submit' class='formbutton' name='login'/>
                Log In</button>
            </form>
        </div>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login'])){
                $this->model->newLogCheck();
            }else{
                ?>
                The password is wrong!
                <?php
            }
        }
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 7:29 PM
 */

class LogoutView extends View
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
    public function logout(){

        echo "You are now logged out " . $_SESSION['email'];
        session_destroy();
        header('refresh:1','Location: http://www.projectmanagement.com/login');
        exit();
    }
    public function notLogged(){
        ?>
        No user has been logged in, in order to log out from the system.
        <?php
    }
}
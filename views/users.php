<?php
class Users{
    public $position;
    public function __construct(){
        if(isset($_SESSION['email'])){
            global $user;
            $this->position= $user['position'];
            addNewUser();
            if(!isset($_POST['add_new_user'])){
                seeUsersList();
            }
        }

    }

}
$user= new Users();



?>
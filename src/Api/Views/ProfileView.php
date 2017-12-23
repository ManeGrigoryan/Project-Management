<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 8:14 PM
 */

class ProfileView extends View
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;

    }

    public function profileInfo()

    {
        global $user;
        ?>
        <table>
            <caption>Profile Info</caption>
            <tr>
                <th>First Name</th>
                <th>Lastname</th>
                <th>Position</th>
                <th>Email</th>
            </tr>
            <tr>
                <td> <?php echo $user['firstname']; ?> </td>
                <td> <?php echo $user['lastname']; ?></td>
                <td> <?php echo $user['position']; ?></td>
                <td> <?php echo $user['email']; ?></td>
            </tr>
        </table>
        <?php
    }

    public function noInfo()
    {
        ?> No user is logged in. In order to see Your profile info please go to the <a
            href="www.projectmanagement.com/login">login</a> page <?php

    }
}
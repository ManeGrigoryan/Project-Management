<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */

class UsersView extends View
{

    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function list_()
    {
        global $user;
        global $total_pages;
        global $action;

        $users = $this->model->getUsers();

        $this->model->getPermission($action);
        ?>
        <form action="" method="GET">
            <a href="users/add">Add</a>
            <table>
                <tr>
                    <th><input type="submit" name="firstname" value="First Name"></th>
                    <th><input type="submit" name="lastname" value="Last Name"></th>
                    <th><input type="submit" name="email" value="Email"</th>
                </tr>
                <?php
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td><?php echo $user['firstname']; ?>  </td>
                        <td><?php echo $user['lastname']; ?></td>
                        <td><?php echo $user['email']; ?></td>

                    </tr>
                <?php }
                ?>

            </table>
            <br>
        </form>
        <?php
        for ($action = 1; $action <= $total_pages; $action++) {
            echo '<a href="?action=' . $action . '">' . $action . '</a>';
        }
    }

    public function add()
    {
        global $action;
        $permission = $this->model->getPermission($action);


        ?>
        <form action="" method="GET">
            <input type="text" placeholder="Firstname" name="firstname"></br>
            <input type="text" placeholder="Lastname" name="lastname">
            <input type="email" placeholder="Email" name="email">
            <input type="password" placeholder="Password" name="password">
            <div>
                <label>Position</label></br>
                <input type="radio" name="position" value="admin" required> Admin<br>
                <input type="radio" name="position" value="manager" required> Project Manager<br>
                <input type="radio" name="position" value="developer" required> Developer<br>
            </div>
            <input type="submit" name="savenewuser" value="Save User">
        </form>
        <?php

        $adding = $this->model->getAdds();

    }

    public function save()
    {
        $this->model->save();
    }
}
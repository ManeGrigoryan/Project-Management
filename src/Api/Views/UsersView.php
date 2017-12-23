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
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
        $order = isset($_GET['order']) ? $_GET['order'] : 'firstname';
        ?>
        <form action="" method="GET" id="users_">
            <a href="users/add">Add</a>
            <input type="hidden" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'firstname' ?>"
                   id="order">
            <input type="hidden" name="sort" value="" id="sort">
            <table id="users_table">
                <thead>
                <tr>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'firstname') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('firstname', 'users_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">First
                            Name</a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'lastname') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('lastname', 'users_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Last
                            Name</a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'email') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('email', 'users_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Email
                    </th>
                </tr>
                </thead>
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
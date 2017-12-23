<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */
namespace App\Api\Models;

class UsersModel extends Model
{
    public function getUsers()
    {
        global $user;
        global $mysqli;
        $query = "SELECT DISTINCT firstname, lastname, email FROM users JOIN tasks JOIN projects";
        $query .= ($user['position'] == 'manager') ? " ON proj_manager = '" . $user['email'] . "' AND tasks.task_assignee = users.email " : "";
        $order = isset($_GET['order']) ? $_GET['order'] : 'firstname';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
        $query .= " ORDER BY $order $sort ";


//Pagination starts here
        $result = mysqli_query($mysqli, $query);
        $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
        $perpage = 10;
        $start_number = (($action - 1) * $perpage);
        $total_elements = mysqli_num_rows($result);
        $total_pages = ceil($total_elements / $perpage);

        $query .= " LIMIT $start_number, $perpage";
        $query = mysqli_query($mysqli, $query);

        if (!$query) {
            var_dump($query);
            printf("Error: %s\n", mysqli_error($mysqli));
            exit();
        }
        $data = array();
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getAdds()
    {   global $adding_new_user;
        if (isset($_GET['firstname'], $_GET['lastname'], $_GET['email'], $_GET['password'], $_GET['position'])) {
            global $adding_new_task;
            $firstname = $_GET['firstname'];
            $lastname = $_GET['lastname'];
            $password = md5($_GET['password']);
            $position = $_GET['position'];
            $email = $_GET['email'];
            $adding_new_user = "INSERT INTO users(firstname, lastname, email, password, position )
                                      VALUES ('$firstname', '$lastname', '$email', '$password','$position')";

        }
    }

    public function findBy($data = []) {
        global $app;
        $container = $app->getContainer();
        $mysqli = $container->get('mysql');
        $result=$mysqli->query("SELECT * FROM users WHERE email ='".$_SESSION['email']."'");
        $user = $result->fetch_assoc();
        return $user;
    }

}
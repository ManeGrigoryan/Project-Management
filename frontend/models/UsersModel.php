<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */

class UsersModel extends Model
{
    public function getUsers()
    {
        global $user;
        global $mysqli;
        $query = "SELECT DISTINCT firstname, lastname, email FROM users JOIN tasks JOIN projects";
        $query .= ($user['position'] == 'manager') ? " ON proj_manager = '" . $user['email'] . "' AND tasks.task_assignee = users.email " : "";
        $order = isset($_GET['firstname']) ? 'firstname' : '';
        $order = isset($_GET['lastname']) ? 'lastname' : $order;
        $order = isset($_GET['email']) ? 'email' : $order;
        $order = ($order == '') ? 'firstname' : $order;
        $sort = 'ASC';
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
            $adding_new_user = "INSERT INTO users(firstname, lastname, email, password, position, )
                                      VALUES ('$firstname', '$lastname', '$email', '$password','$position')";

        }
    }

    public function save()
    {
        global $mysqli;
        global $adding_new_user;
            if (!empty($_GET['firstname']) && !empty($_GET['lastname']) && !empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['position'])) {
                $result = $mysqli->query("SELECT * FROM Users WHERE email = '".$_GET['email']."'") or die();
                if ($result->num_rows > 0) {
                    echo "User with email address " . $_GET['email'] . " already exists";
                }
                if (!mysqli_query($mysqli, $adding_new_user)) {
                    var_dump($adding_new_user);
                    echo "Could not add the user " . $_GET['email'];
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                } else {
                    echo "NEW USER HAS BEEN INSERTED";
                }

            }
        }

}
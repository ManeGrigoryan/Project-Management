<?php
if (isset($_SESSION['email'])) {
    if (array_key_exists($user['position'], $permission)) {
        $action = 'add_new_user';
        if (in_array($action, $permission[$user['position']]) !== FALSE) {
            echo '<form action="" method="post">
                    <input type="submit" name="add_new_user" value="Add New User"></br>';
            if (isset($_POST['add_new_user'])) {
                echo '<input type="text" name="firstname" placeholder="First Name" required><br>
                        <input type="text" name="lastname" placeholder="Last Name" required><br>
                        <input type="email" name="email" placeholder="Email Address" required><br>
                        <input type="password" name="password" placeholder="Password" required><br>
                        <div>
                            <label>Position</label></br>
                            <input type="radio" name="position" value="admin" required> Admin<br>
                            <input type="radio" name="position" value="manager" required> Project Manager<br>
                            <input type="radio" name="position" value="developer" required> Developer<br>
                        </div>
                        <input type="submit" name="savenewuser" value="Save User">
                        </form>';
            } else {
                if (isset($_POST['savenewuser'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['position'])) {
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $password = md5($_POST['password']);
                    $position = $_POST['position'];
                    $adding_new_user = "INSERT INTO users(`firstname`, `lastname`, `email`, `password`, `position`) 
                                         VALUES ('$firstname', '$lastname', '$email','$password','$position' )";
                    if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($position)) {
                        $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'") or die();
                        if ($result->num_rows > 0) {
                            echo "User with email address " . $email . " already exists";
                        }
                        if (!mysqli_query($mysqli, $adding_new_user)) {
                            echo "Could not add the task " . $task_name;
                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                        } else {
                            echo "NEW USER HAS BEEN INSERTED";
                        }

                    }
                }
            }
        }
        if (!isset($_POST['add_new_user']) && empty($_POST['add_new_user'])) {
            $action = 'see_users_list';
            if (in_array($action, $permission[$user['position']]) !== FALSE) {
                $query = "SELECT DISTINCT firstname, lastname, email FROM users JOIN tasks JOIN projects";
                $query .= ($user['position'] == 'manager') ? " ON proj_manager = '" . $user['email'] . "' AND tasks.task_assignee = users.email " : "";

                echo '<table>
                        <tr><th><input type="submit" name="firstname" value="First Name"></th>
                        <th><input type="submit" name="lastname" value="Last Name"></th>
                        <th><input type="submit" name="email" value="Email" </th>
                        </tr>';

                $order = isset($_POST['firstname']) ? 'firstname' : '';
                $order = isset($_POST['lastname']) ? 'lastname' : $order;
                $order = isset($_POST['email']) ? 'email' : $order;
                $order = ($order == '') ? 'firstname' : $order;
                $sort = 'ASC';
                $query .= " ORDER BY $order $sort ";


//Pagination starts here
                $result = mysqli_query($db, $query);
                $action = (!isset($_GET['action'])) ? 1 : $_GET['action'];
                $perpage = 10;
                $start_number = (($action - 1) * $perpage);
                $total_elements = mysqli_num_rows($result);
                $total_pages = ceil($total_elements / $perpage);

                $query .= " LIMIT $start_number, $perpage";
                $query = mysqli_query($db, $query);

                if (!$query) {
                    var_dump($query);
                    printf("Error: %s\n", mysqli_error($db));
                    exit();
                }
                while ($row = mysqli_fetch_array($query)) {
                    echo "<tr><td>" . $row['firstname'] . "</td>
                              <td>" . $row['lastname'] . "</td>
                              <td>" . $row['email'] . "</td>
                           </tr>";
                }
                echo "<style>
                        table, th, td,tr { border: 1px solid black; }
                        </style></table><br></form>";

                for ($action = 1; $action <= $total_pages; $action++) {
                    echo '<a href="?action=' . $action . '">' . $action . '</a>';
                }
            } else {
                $action = ($user['position'] == 'developer') ? "You are not allowed to see the list of users" : "</br>";
                echo $action;

            }
        }

    }
}

?>
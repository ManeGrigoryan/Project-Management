<?php
if (isset($_SESSION['email'])) {


    switch ($user['position']) {
        case 'admin':
            $query = "SELECT * FROM Users";
            break;
        case 'manager':
            $query = "SELECT firstname, lastname, email, projects.proj_name, task_name 
                    FROM users JOIN tasks JOIN projects 
                    ON  projects.proj_manager = '" . $user['email'] . "' AND tasks.task_assignee = users.email AND
                    projects.proj_name = tasks.proj_name ";
            break;
        case 'developer':
            echo "You are not allowed to see the list of employees and their personal data";
            die();
            break;
    }
    $result = mysqli_query($db, $query);
    echo "<table id = users> <caption>Users' List</caption>
    <tr>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Email</th>
</tr><tr>";
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    while ($row = mysqli_fetch_array($result)) {
        echo "<td>" . $row['firstname'] . "</td>
           <td>" . $row['lastname'] . "</td>
           <td>" . $row['email'] . "</td>
           </tr>";
    }
    echo "<style>
            table, th, td,tr {
            border: 1px solid black;
            }
          </style>";
    echo "</table><br>";
    if ($user['position'] == 'admin') {
        echo "<form action='#' method='post' >
    <input type='text' name='firstname' placeholder='First Name' required><br>
    <input type='text' name='lastname' placeholder='Last Name' required><br>
    <input type='email' name='email' placeholder='Email Address' required><br>
    <input type='password' name='password' placeholder='Password' required><br>
    <div>
                <label>Position</label>
                <input type='radio' name='position' value='admin' required> Admin<br>
                <input type='radio' name='position' value='manager' required> Project Manager<br>
                <input type='radio' name='position' value='developer' required> Developer<br>
      </div>
    <input type = 'submit' value = 'Add New User' name = 'newuser'><br>
     
    </form>
    ";
        if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['position'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $position = $_POST['position'];

            $sql = "INSERT INTO users(`firstname`, `lastname`, `email`, `password`, `position`) 
              VALUES ('$firstname', '$lastname', '$email','$password','$position' )";

            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($position)) {
                $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'") or die();
                if ($result->num_rows > 0) {
                    echo "User with email address " . $email . " already exists";
                }
                if (!mysqli_query($mysqli, $sql)) {

                    die();

                } else {
                    echo "NEW USER HAS BEEN INSERTED";
                    header('refresh:0','Location: http://www.projectmanagement.com/users.php');
                    die();



                }

            } else {
                var_dump($firstname);
                var_dump($lastname);
                var_dump($email);
                var_dump($position);
                var_dump($password);
                die();
            }
        }


    }
}
?>
<?php

if(isset($_SESSION['email'])){
    echo "<table id='profile' <caption>Profile Info</caption>
           <tr>
           <th>First Name</th>
           <th>Lastname</th>
           <th>Position</th>
           </tr>
           <tr>
           <td>" .$user['firstname']. "</td>
           <td>" .$user['lastname']. "</td>
           <td>" .$user['position']. "</td>
           </tr>";
    echo "<style>
            table, th, td,tr {
            border: 1px solid black;
            }
          </style>";
    echo "</table>"; //Close the table in HTML
}
else {
    echo "No user is logged in. Please first log in, in order to see your profile info";
}

?>
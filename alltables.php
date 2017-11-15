<?php
$username= 'root';
$password = '';
$db = 'test_db';
$db = new mysqli('localhost', $username, $password, $db) or die("Connection Unavailable");
//$sql_users = "CREATE TABLE Users (
//		firstname VARCHAR(45) NOT NULL,
//		lastname VARCHAR(45) NOT NULL,
//		email VARCHAR(45) PRIMARY KEY,
//		password VARCHAR(100) NOT NULL,
//		active BOOL NOT NULL DEFAULT 0,
//		position VARCHAR(45) NOT NULL)";

//if ($db->query($sql_users) === TRUE) {
//		echo "Table Users created successfully";
//}
//else {
//		echo "Error creating table: " . $db->error;
//}

//$sql_projects = "CREATE TABLE Projects (
//        proj_name VARCHAR(45) PRIMARY KEY,
//		description VARCHAR(255) NOT NULL,
//		proj_manager VARCHAR(45) NOT NULL,
//		FOREIGN KEY (`proj_manager`)REFERENCES `Users`(`email`)
//			ON DELETE CASCADE
//			ON UPDATE CASCADE)";

//$projects_date= "ALTER TABLE `projects`
//                ADD COLUMN `start_day` DATE,
//                ADD COLUMN `deadline` DATE ";
//
//$task_dates= "ALTER TABLE `tasks`
//              ADD COLUMN `start_day` DATE,
//              ADD COLUMN  `deadline` DATE  ";
//
//if ($db->query($projects_date) === TRUE) {
//		echo "Table Projects altered successfully";
//}
//else {
//		echo "Error altering table: " . $db->error;
//}
//if ($db->query($task_dates) === TRUE) {
//    echo "Table Tasks altered successfully";
//}
//else {
//    echo "Error altering table: " . $db->error;
//}
//$sql_tasks = "CREATE TABLE Tasks (
//      proj_name VARCHAR(45) NOT NULL,
//      task_name VARCHAR(45) NOT NULL,
//      task_description VARCHAR(255) NOT NULL,
//      task_assignee VARCHAR(45) NOT NULL,
//      PRIMARY KEY(`proj_name`,`task_name`,`task_assignee`),
//      FOREIGN KEY (`proj_name`) REFERENCES `Projects`(`proj_name`)
//		  ON DELETE CASCADE
//          ON UPDATE CASCADE,
//      FOREIGN KEY (`task_assignee`) REFERENCES `Users`(`email`)
//		  ON DELETE CASCADE
//          ON UPDATE CASCADE)";

//if ($db->query($sql_tasks) === TRUE) {
//       echo "Table Tasks created successfully";
//}
//else {
//       echo "Error creating table: " . $db->error;
//}

//$sql_assignees = "CREATE TABLE Assignees(
//    user_email VARCHAR(45),
//    proj_name VARCHAR(45),
//    task_name VARCHAR (45),
//    PRIMARY KEY (`user_email`,`proj_name`,`task_name`),
//    FOREIGN KEY (`proj_name`) REFERENCES `Projects` (`proj_name`)
//		ON DELETE CASCADE
//        ON UPDATE CASCADE,
//    FOREIGN KEY (`task_name`) REFERENCES `Tasks` (`task_name`)
//		ON DELETE CASCADE
//        ON UPDATE CASCADE,
//    FOREIGN KEY (`user_email`) REFERENCES `Users` (`email`)
//		ON DELETE CASCADE
//        ON UPDATE CASCADE)";

// if ($db->query($sql_assignees) === TRUE) {
//		echo "Table Assignees created successfully";
//}
//else {
//		echo "Error creating table: " . $db->error;
//}
//
//

$db->close();
?>
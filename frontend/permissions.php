<?php
global $permission;
$permission=array(
'admin'=> array('add_new_project', 'add_new_user', 'search_in_tasks', 'search_in_projects', 'see_users_list', 'add_new_task'),
'manager'=>array('add_new_task', 'search_in_tasks', 'see_users_list'),
'developer'=>array('search_in_tasks'));

?>
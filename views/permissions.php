<?php
global $permission;
$permission=array(
'admin'=> array('add_new_project', 'add_new_user', 'search_in_tasks', 'search_in_projects'),
'manager'=>array('add_new_task', 'search_in_tasks'),
'developer'=>array('search_in_tasks'));

?>
























<?php

//$permission_by_roles = array('admin' => array("add_new_project", "add_new_user", "search_in_tasks", "search_in_projects"),
//    'developer' => array("add_new_task", "search_in_tasks"),
//    'manager' => array("search_in_tasks"));
//var_dump($permission_by_roles);
//
//
//if (isset($_SESSION['email'])) {
//    if (array_key_exists($user['position'], $permission_by_roles)) {
//        $action='add_new_project';
//        $position= array('admin', 'manager', 'developer');
//       for($i = 0; $i < count($position); $i++){
//           for ($j = 0; $j < count($permission_by_roles[i]); $j++){
//               if($permission_by_roles[i][j]=$action){
//                   print $permission_by_roles[$i][$j];
//                   print "<br/>";
//               }
//
//           }
//       }
//
//
//    }
//
//}
////
////
////foreach ($permission_by_roles as $position => $action) {
////    if (isset($position[$action]) && $position[$action] == 'add_new_project' && array_key_exists($position, $user)) {
////        var_dump($position);
////
////    }
////
////
////
////}
////        $add_new_project= "add_new_project";
////        foreach ($permission_by_roles as $key => $value)
////        {
////            $position = (array) $key;
////            var_dump($position);
////            if (in_array($add_new_project, $position)){
////                var_dump($position);
////            }
////        }
////

?>

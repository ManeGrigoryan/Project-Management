<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 11/30/2017
 * Time: 11:08 PM
 */

class TasksView extends View
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
        $tasks = $this->model->getTasks();
        $permission= $this->model->getPermission($action);
        ?>
        <form action="/tasks" method="GET">
            <a href="tasks/add">Add</a></br>
            <input type="text" name="search" placeholder="Search">
            <?php
            $projects = $this->model->getProjects();
            if ($user['position'] == 'manager' || $user['position'] == 'developer') {
                ?>

                <?php
            } elseif ($user['position'] == 'admin') {
                $managers = $this->model->getManagers();
            }
            if ($user['position'] != 'developer') {
                $assignees = $this->model->getAssignees();
            }


            ?>

            <input type="submit" name="searchbutton" value="Search">
            <table>
                <tr>
                    <th><input type="submit" name="proj_name" value="Project Name"></th>
                    <th><input type="submit" name="task_name" value="Task Name"></th>
                    <th><input type="submit" name="task_description" value="Task Description"</th>
                    <th><input type="submit" name="assignee" value="Task Assignee Email"></th>
                    <th><input type="submit" name="start_day" value="Starting Date"></th>
                    <th><input type="submit" name="deadline" value="Deadline"></th>
                </tr>
                <?php
                foreach ($tasks as $task) {
                    ?>
                    <tr>
                        <td><?php echo $task['proj_name']; ?>  </td>
                        <td><?php echo $task['task_name']; ?></td>
                        <td><?php echo $task['task_description']; ?></td>
                        <td><?php echo $task['task_assignee']; ?></td>
                        <td><?php echo $task['start_day']; ?></td>
                        <td><?php echo $task['deadline']; ?></td>
                    </tr>
                <?php }
                ?>

            </table>
            <br>
        </form>
        <?php
        for ($action = 1; $action <= $total_pages; $action++) {
            ?>
            <a href="?action=<?php echo $action ?>" onclick="changePage(<?php echo $action ?>)"><?php echo $action ?></a>
            <?php
        }
    }

    public function save()
    {
        $this->model->save();
    }

    public function add()
    {
        global $action;
        $permission= $this->model->getPermission($action);


        ?>
        <form action="" method="get">
            <input type="text" placeholder="Task Name" name="task_name"></br>
            <input type="text" placeholder="Task Description" name="task_description">
            <?php
            $projects = $this->model->getProjects();
            $assignees = $this->model->getAssignees();
            ?>
            <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
            <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
            <input type="submit" name="save_task" value="Save Task"></form>
        <?php
        $adding=$this->model->getAdds();

    }
}
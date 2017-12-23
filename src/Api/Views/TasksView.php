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
        $permission = $this->model->getPermission($action);
        $task_name = (isset($_GET['search']) && $_GET['search'] != '') ? $_GET['search'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
        ?>

        <form action="/tasks" method="GET" id="tasks_">
            <a href="tasks/add">Add</a></br>
            <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search'])? $_GET['search']:''; ?>">
            <input type="hidden" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'proj_name' ?>"
                   id="order">
            <input type="hidden" name="sort" value="" id="sort">
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
            <button onclick="searchFunction('tasks_table')">Search</button>
            <table id="tasks_table">
                <thead>
                <tr>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'proj_name') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('proj_name', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Project
                            Name</a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'task_name') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('task_name', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Task
                            Name</a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'description') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('description', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Task
                            Description</th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'task_assignee') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('task_assignee', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Task
                            Assignee Email</th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'start_day') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('start_day', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">
                            Starting Date</th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'deadline') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('deadline', 'tasks_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Deadline
                    </th>
                </tr>
                </thead>
                <?php
                foreach ($tasks

                as $task) {
                ?>
                <tbody>
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
                </tbody>
            </table>
            <br>
        </form>
        <?php
        $location = $_SERVER['REQUEST_URI'];
        $urlArr = explode('?', $location);
        $queryParamsStr = isset($urlArr[1]) ? $urlArr[1] : '';
        parse_str($queryParamsStr, $queryParamsArr);
        for ($action = 1; $action <= $total_pages; $action++) {
            $newQueryParams = array_merge($queryParamsArr, ['action' => $action]);
            $newQueryParamStr = http_build_query($newQueryParams);
            $newUrl = implode('?', [$urlArr[0], $newQueryParamStr]);
            ?>
            <a href="<?php echo $newUrl; ?>"><?php echo $action ?></a>
            <?php
        }
    }


    public function add()
    {
        global $action;
        $permission = $this->model->getPermission($action);
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
        $adding = $this->model->getAdds();

    }
}
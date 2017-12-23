<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/2/2017
 * Time: 4:00 PM
 */

class ProjectsView extends View
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
        $projects = $this->model->getProjects();
        $permission = $this->model->getPermission($action);
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'DESC';
        $order = isset($_GET['order']) ? $_GET['order'] : 'proj_name';
        ?>
        <form action="/projects" method="GET" id="projects_">
            <a href="projects/add">Add</a></br>
            <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search'])? $_GET['search']:''; ?>">
            <input type="hidden" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : 'proj_name' ?>"
                   id="order">
            <input type="hidden" name="sort" value="" id="sort">
            <?php
            if ($user['position'] == 'admin') {
                $managers = $this->model->getManagers();
            }

            ?>
            <button onclick="searchFunction('projects_table')">Search</button>
            <table id="projects_table">
                <thead>
                <tr>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'proj_name') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('proj_name', 'projects_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Project
                            Name</a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'description') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('description', 'projects_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Project
                            Description </a></th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'proj_manager') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('proj_manager', 'projects_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Task
                            Project Manager</th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'start_day') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('start_day', 'projects_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">
                            Starting Date</th>
                    <th><a data-sort-by="<?php echo $sort; ?>"
                           data-order-by="<?php echo ($order == 'deadline') ? 'yes' : 'no'; ?>" href=""
                           onclick="event.preventDefault();orderTable('deadline', 'projects_', this.getAttribute('data-order-by'), this.getAttribute('data-sort-by'));">Deadline
                    </th>
                </tr>
                </thead>
                    <?php
                    foreach ($projects as $project) {
                        ?>
                        <tr>
                            <td><?php echo $project['proj_name']; ?>  </td>
                            <td><?php echo $project['description']; ?></td>
                            <td><?php echo $project['proj_manager']; ?></td>
                            <td><?php echo $project['start_day']; ?></td>
                            <td><?php echo $project['deadline']; ?></td>
                        </tr>
                    <?php }
                    ?>

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
//        for ($action = 1; $action <= $total_pages; $action++) {
//            echo '<a href="?action=' . $action . '">' . $action . '</a>';
//        }
    }

    public function add()
    {
        global $action;
        $permission = $this->model->getPermission($action);


        ?>
        <form action="" method="get">
            <input type="text" placeholder="Project Name" name="project_name"></br>
            <input type="text" placeholder="Project Description" name="project_description">
            <?php
            $assignees = $this->model->getManagers();
            ?>
            <label> Start date:</label><input type="date" name="start_day" value="Start Day" required></br></label>
            <label> Deadline:</label><input type="date" name="deadline" value="Deadline" required></br></label>
            <input type="submit" name="save_project" value="Save Project"></form>
        <?php
        $adding = $this->model->getAdds();
    }


}
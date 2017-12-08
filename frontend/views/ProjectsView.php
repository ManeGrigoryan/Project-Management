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
        ?>
        <form action="/projects" method="GET">
            <a href="projects/add">Add</a></br>
            <input type="text" name="search" placeholder="Search">
            <?php
            if ($user['position'] == 'admin') {
                $managers = $this->model->getManagers();
            }

            ?>
            <input type="submit" name="searchbutton" value="Search">
            <table>
                <tr>
                    <th><input type="submit" name="proj_name" value="Project Name"></th>
                    <th><input type="submit" name="project_description" value="Description"></th>
                    <th><input type="submit" name="proj_manager" value="Project Manager"></th>
                    <th><input type="submit" name="start_day" value="Starting Date"></th>
                    <th><input type="submit" name="deadline" value="Deadline"></th>
                </tr>
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
        for ($action = 1; $action <= $total_pages; $action++) {
            echo '<a href="?action=' . $action . '">' . $action . '</a>';
        }
    }
    public function add(){
        global $action;
        $permission= $this->model->getPermission($action);


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
        $adding=$this->model->getAdds();
    }
    public function save()
    {
        $this->model->save();
    }
}
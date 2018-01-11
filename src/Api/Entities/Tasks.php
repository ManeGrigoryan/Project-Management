<?php

namespace App\Api\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @Table(name="tasks")
 */
class Tasks
{
    /**
     * @var string
     * @column(name = "proj_name")
     * @OneToMany(targetEntity="Projects", mappedBy="projName")
     * @ID
     */
    private $projName;

    /**
     * @column(name = "task_name")
     * @var string
     * @ID
     */
    private $taskName;

    /**
     * @var string
     * @column(name = "task_assignee")
     * @OneToMany(targetEntity="Users", mappedBy="email")
     * @ID
     */
    private $taskAssignee;

    /**
     * @var string
     * @column(name = "task_description")
     */
    private $taskDescription;

    /**
     * @var \DateTime
     * @column(name = "start_day")
     */
    private $startDay;

    /**
     * @var \DateTime
     * @column(name = "deadline")
     */
    private $deadline;


    /**
     * Set projName
     *
     * @param string $projName
     * @return Tasks
     */
    public function setProjName($projName)
    {
        $this->projName = $projName;

        return $this;
    }

    /**
     * Get projName
     *
     * @return string 
     */
    public function getProjName()
    {
        return $this->projName;
    }

    /**
     * Set taskName
     *
     * @param string $taskName
     * @return Tasks
     */
    public function setTaskName($taskName)
    {
        $this->taskName = $taskName;

        return $this;
    }

    /**
     * Get taskName
     *
     * @return string 
     */
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * Set taskAssignee
     *
     * @param string $taskAssignee
     * @return Tasks
     */
    public function setTaskAssignee($taskAssignee)
    {
        $this->taskAssignee = $taskAssignee;

        return $this;
    }

    /**
     * Get taskAssignee
     *
     * @return string 
     */
    public function getTaskAssignee()
    {
        return $this->taskAssignee;
    }

    /**
     * Set taskDescription
     *
     * @param string $taskDescription
     * @return Tasks
     */
    public function setTaskDescription($taskDescription)
    {
        $this->taskDescription = $taskDescription;

        return $this;
    }

    /**
     * Get taskDescription
     *
     * @return string 
     */
    public function getTaskDescription()
    {
        return $this->taskDescription;
    }

    /**
     * Set startDay
     *
     * @param \DateTime $startDay
     * @return Tasks
     */
    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;

        return $this;
    }

    /**
     * Get startDay
     *
     * @return \DateTime 
     */
    public function getStartDay()
    {
        return $this->startDay;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Tasks
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }
}

<?php

namespace App\Api\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @Entity
 * @Table(name="projects")
 */
class Projects
{
    /**
     * @var string
     * @column(name="proj_name")
     * @ID
     * @ManyToOne(targetEntity="Tasks", inversedBy="projName")

     */
    private $projName;

    /**
     * @column(name="description")
     * @var string
     */
    private $description;

    /**
     * @var string
     * @column(name="proj_manager")
     * @OneToMany(targetEntity="Users", mappedBy="email")
     */
    private $projManager;

    /**
     * @var \DateTime
     * @column(name="start_day")
     */
    private $startDay;

    /**
     * @var \DateTime
     */
    private $deadline;


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
     * Set description
     *
     * @param string $description
     * @return Projects
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set projManager
     *
     * @param string $projManager
     * @return Projects
     */
    public function setProjManager($projManager)
    {
        $this->projManager = $projManager;

        return $this;
    }

    /**
     * Get projManager
     *
     * @return string 
     */
    public function getProjManager()
    {
        return $this->projManager;
    }

    /**
     * Set startDay
     *
     * @param \DateTime $startDay
     * @return Projects
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
     * @return Projects
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

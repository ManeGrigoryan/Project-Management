<?php

namespace App\Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assignees
 */
class Assignees
{
    /**
     * @var string
     */
    private $userEmail;

    /**
     * @var string
     */
    private $projName;

    /**
     * @var string
     */
    private $taskName;


    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return Assignees
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string 
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set projName
     *
     * @param string $projName
     * @return Assignees
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
     * @return Assignees
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
}

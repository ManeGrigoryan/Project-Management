<?php
namespace App\Api\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @Table(name="users")
 **/
class Users
{

    /**
     * @Id
     * @Column(type="string")
     * @GeneratedValue(strategy="NONE")
     * @ManyToOne(targetEntity="Projects", inversedBy="projManager")
     * @ManyToOne(targetEntity="Tasks", inversedBy="task_assignee")
     */
    private $email;

    /**
     * @Column(type="string", name="firstname")
     */
    private $firstname;

    /**
     * @Column(type="string", name="lastname")
     */
    private $lastname;

    /**
     * @var string
     *
     * @Column(type="string", name="password")
     */
    private $password;

    /**
     * @var boolean
     * @column(name="active")
     */
    private $active;

    /**
     * @var string
     * @Column(type="string", name="position")
     */
    private $position;


    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Users
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Users
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

}

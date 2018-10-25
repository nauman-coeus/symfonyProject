<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table()
 */

class Designation extends Utility
{
    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="designation")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $employee;

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }
}
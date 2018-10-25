<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttendanceRepository")
 * @ORM\Table()
 */
class Attendance extends Utility
{
    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $timeIn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $timeOut;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="attendance")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $employee;

    /**
     * @return String
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param String $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return String
     */
    public function getTimeIn()
    {
        return $this->timeIn;
    }

    /**
     * @param String $timeIn
     */
    public function setTimeIn($timeIn)
    {
        $this->timeIn = $timeIn;
    }

    /**
     * @return String
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param String $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
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

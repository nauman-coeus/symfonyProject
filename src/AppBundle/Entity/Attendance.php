<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttendanceRepository")
 * @ORM\Table(name="attendance")
 */
class Attendance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Employees", inversedBy="attendance")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $employee;

    /**
     * @ORM\Column(type="string")
     */
    private $status;


    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $time_in;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $time_out;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTimeIn()
    {
        return $this->time_in;
    }

    /**
     * @param mixed $time_in
     */
    public function setTimeIn($time_in)
    {
        $this->time_in = $time_in;
    }

    /**
     * @return mixed
     */
    public function getTimeOut()
    {
        return $this->time_out;
    }

    /**
     * @param mixed $time_out
     */
    public function setTimeOut($time_out)
    {
        $this->time_out = $time_out;
    }

    public function __toString()
    {
        return $this->status;
    }

    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }
}
<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @ORM\Table()
 * @Vich\Uploadable
 */
class Employee extends Utility
{
    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;


    /**
     * @Vich\UploadableField(mapping="employees_img", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true}, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Range(min="0", minMessage="Can not be Negative")
     */
    private $salary;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="employee")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @ORM\JoinTable(name="emp_emp")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="Designation", inversedBy="employee")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $designation;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", inversedBy="empId")
     */
    private $bossId;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="bossId")
     */
    private $empId;

    /**
     * @ORM\OneToMany(targetEntity="Attendance", mappedBy="employee")
     */
    private $attendance;

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Employee constructor
     */
    public function __construct()
    {
        $this->bossId = new ArrayCollection();
        $this->empId = new ArrayCollection();
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return String
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param String $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return Integer
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param Integer $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
    }

    /**
     * @return Designation
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param Designation $designation
     */
    public function setDesignation(Designation $designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return Employee
     */
    public function getBossId()
    {
        return $this->bossId;
    }

    /**
     * @param Employee $bossId
     */
    public function setBossId($bossId)
    {
        $this->bossId = $bossId;
    }

    /**
     * @return Employee
     */
    public function getEmpId()
    {
        return $this->empId;
    }

    /**
     * @param Employee $empId
     */
    public function setEmpId($empId)
    {
        $this->empId = $empId;
    }

    /**
     * @return String
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * @param Attendance $attendance
     */
    public function setAttendance(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }
}

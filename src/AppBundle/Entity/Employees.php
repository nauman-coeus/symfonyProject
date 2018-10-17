<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeesRepository")
 * @ORM\Table(name="employees")
 * @Vich\Uploadable
 */
class Employees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

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
     * @ORM\Column(type="string", nullable=true)
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
     * @ORM\ManyToMany(targetEntity="Employees", inversedBy="emp_id")
     */
    private $boss_id;

    /**
     * @ORM\ManyToMany(targetEntity="Employees", mappedBy="boss_id")
     */
    private $emp_id;

    /**
     * @ORM\OneToMany(targetEntity="Attendance", mappedBy="employee")
     */
    private $attendance;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param mixed $designation
     */
    public function setDesignation(Designation $designation)
    {
        $this->designation = $designation;
    }

    /**
     * @return mixed
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * @param mixed $attendance
     */
    public function setAttendance(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * @return mixed
     */
    public function getBossId()
    {
        return $this->boss_id;
    }

    /**
     * @param mixed $boss_id
     */
    public function setBossId($boss_id)
    {
        $this->boss_id = $boss_id;
    }

    /**
     * @return mixed
     */
    public function getEmpId()
    {
        return $this->emp_id;
    }

    /**
     * @param mixed $emp_id
     */
    public function setEmpId($emp_id)
    {
        $this->emp_id = $emp_id;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->boss_id = new ArrayCollection();
        $this->emp_id = new ArrayCollection();
    }

}

<?php

namespace AppBundle\Service;

use AppBundle\Entity\Employee;
use Symfony\Bridge\Doctrine\RegistryInterface;

define('TIME_ZONE_PAKISTAN', 'Asia/Karachi');

class AttendanceService
{
    private $doctrine;

    /**
     * AttendanceService constructor.
     * @param RegistryInterface $doctrine
     */
    function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function getMonthlyAttendance()
    {
        for($i=1; $i<=12; $i++)
        {
            $date = '%-' . \DateTime::createFromFormat('m', $i)->format('m') . '-' . date('Y');
            $month = \DateTime::createFromFormat('m', $i)->format('M');

            $data[$month] = $this->doctrine->getEntityManager()->getRepository('AppBundle:Attendance')->getMonthlyAttendance($date);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getDailyAttendance()
    {
        $date = date('d-m-Y');
        return $this->doctrine->getEntityManager()->getRepository('AppBundle:Attendance')->getDailyAttendance($date);
    }

    /**
     * @param Employee $employee
     * @return array
     */
    public function getEmployeeAttendance(Employee $employee)
    {
        date_default_timezone_set(TIME_ZONE_PAKISTAN);
        $date = date('d-m-Y');
        $timeIn = null;
        $timeOut = null;

        $attendance = $this->doctrine->getEntityManager()->getRepository('AppBundle:Attendance')->findOneBy(['employee'=> $employee, 'date'=> $date]);

        if(!empty($attendance)) {
            $timeIn = $attendance->getTimeIn();
            $timeOut = $attendance->getTimeOut();
        }

        return ['timeIn'=> $timeIn, 'timeOut'=> $timeOut];
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function markTimeIn(Employee $employee)
    {
        date_default_timezone_set(TIME_ZONE_PAKISTAN);
        $date = date('d-m-Y');
        $timeIn = date('H:i');
        $status = ($timeIn <= '12:00') ? 'present' : 'late';

        $em = $this->doctrine->getEntityManager()->getRepository('AppBundle:Attendance');

        if(empty($em->findOneBy(['employee'=>$employee, 'date'=>$date]))) {
            $em->markTimeIn($employee, $date, $timeIn, $status);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function markTimeOut(Employee $employee)
    {
        date_default_timezone_set(TIME_ZONE_PAKISTAN);
        $timeOut = date('H:i');
        $date = date('d-m-Y');

        $em = $this->doctrine->getEntityManager()->getRepository('AppBundle:Attendance');

        if(!empty($em->findTimeOutMarked($employee, $date))) {
            $em->markTimeOut($employee, $date, $timeOut);
            return true;
        } else {
            return false;
        }
    }
}

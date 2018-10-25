<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 10/10/18
 * Time: 3:43 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Attendance;
use AppBundle\Entity\Employee;
use Doctrine\ORM\EntityRepository;

class AttendanceRepository extends EntityRepository
{
    public function findTimeOutMarked($employee, $date)
    {
        return $this->createQueryBuilder('attendance')
            ->andWhere('attendance.employee = :employee')
            ->andWhere('attendance.date = :date')
            ->andWhere('attendance.timeOut IS NULL')
            ->setParameter('employee', $employee)
            ->setParameter('date', $date)
            ->getQuery()->getOneOrNullResult();
    }

    public function getDailyAttendance($date)
    {
        return $this->createQueryBuilder('a')
            ->select('e.name AS empName', 'a.name AS status')
            ->innerJoin('a.employee', 'e')
            ->where('a.employee = e')
            ->andWhere('a.date = :date')
            ->setParameter('date', $date)
            ->getQuery()->execute();
    }

    public function getMonthlyAttendance($date)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name', 'COUNT(a.name) as att_count')
            ->where('a.date LIKE :date')
            ->groupBy('a.name')
            ->setParameter('date', $date)
            ->getQuery()->execute();
    }

    public function markTimeIn(Employee $employee, $date, $timeIn, $status)
    {
        $att = new Attendance();
        $att->setDate($date);
        $att->setEmployee($employee);
        $att->setTimeIn($timeIn);
        $att->setName($status);

        $this->getEntityManager()->persist($att);
        $this->getEntityManager()->flush();
    }

    public function markTimeOut(Employee $employee, $date, $timeOut)
    {
        $att = $this->getEntityManager()->getRepository('AppBundle:Attendance')
            ->findOneBy(['employee'=> $employee, 'date'=> $date, 'timeOut'=> null]);
        $att->setTimeOut($timeOut);
        $this->getEntityManager()->flush($att);
    }
}
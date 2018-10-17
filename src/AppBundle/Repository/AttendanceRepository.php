<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 10/10/18
 * Time: 3:43 PM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AttendanceRepository extends EntityRepository
{
    public function findTimeOutMarked($employee, $date)
    {
        return $this->createQueryBuilder('attendance')
            ->andWhere('attendance.employee = :employee')
            ->andWhere('attendance.date = :date')
            ->andWhere('attendance.time_out IS NULL')
            ->setParameter('employee', $employee)
            ->setParameter('date', $date)
            ->getQuery()->getOneOrNullResult();
    }

    public function getDailyAttendance($date)
    {
        return $this->createQueryBuilder('a')
            ->select('e.name', 'a.status')
            ->innerJoin('a.employee', 'e')
            ->where('a.employee = e')
            ->andWhere('a.date = :date')
            ->setParameter('date', $date)
            ->getQuery()->execute();

    }

    public function getMonthlyAttendance($date)
    {
        return $this->createQueryBuilder('a')
            ->select('a.status', 'COUNT(a.status) as att_count')
            ->where('a.date LIKE :date')
            ->groupBy('a.status')
            ->setParameter('date', $date)
            ->getQuery()->execute();
    }
}
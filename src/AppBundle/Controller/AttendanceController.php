<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AttendanceController extends Controller
{
    /**
     * @Route("/dailyattendance" , name="daily_attendance")
     */
    public function dailyAttendance()
    {
        $service = $this->get('app.attendance');
        return $this->render('Attendance/daily_attendance.html.twig', ['attendance'=> $service->getDailyAttendance()]);
    }

    /**
     * @Route("/monthlyattendance", name="monthly_attendance")
     */
    public function monthlyAttendance()
    {
        $service = $this->get('app.attendance');
        return $this->render('Attendance/monthly_attendance.html.twig', ['attendance'=> $service->getMonthlyAttendance()]);
    }

    /**
     * @Route("/markattendance/{id}", name="login_mark_attendance")
     */
    public function markAttendance(Employee $employee)
    {
        $serivce = $this->get('app.attendance');
        $data = $serivce->getEmployeeAttendance($employee);
        return $this->render('Attendance/mark_attendance.html.twig', ['id'=> $employee->getId(), 'timeIn'=> $data['timeIn'], 'timeOut'=>$data['timeOut'], 'user'=> $employee->getName()]);
    }

    /**
     * @Route("/marktimein/{id}", name="mark_time_in")
     */
    public function markTimeIn(Employee $employee)
    {
        $service = $this->get('app.attendance');
        if($service->markTimeIn($employee)) {
            $this->addFlash('success', 'Time In Marked Successfully');
        } else {
            $this->addFlash('error', 'Time In Marked Unsuccessful');
        }

        return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee->getId()]);
    }

    /**
     * @Route("/marktimeout/{id}", name="mark_time_out")
     */
    public function markTimeOut(Employee $employee)
    {
        $service = $this->get('app.attendance');

        if($service->markTimeOut($employee)) {
            $this->addFlash('success', 'Time Out Marked Successfully');
        } else {
            $this->addFlash('error', 'Time Out Marked Unsuccessful');
        }

        return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee->getId()]);
    }
}
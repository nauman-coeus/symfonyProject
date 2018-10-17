<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attendance;
use AppBundle\Entity\Employees;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class LoginController extends Controller
{

    /**
     * @Route("/login", name="login_page")
     */
    public function loginPage(Request $request)
    {

        $form = $this->createForm(LoginForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $employee = $em->getRepository('AppBundle:Employees')->findBy(['email' => $data['email'], 'password'=> $data['password']]);

            if($employee){
                return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee[0]->getId()]);
            } else {
                $this->addFlash('error', 'Wrong Email / Password');
            }
        }

        return $this->render('login/loginpage.html.twig', ['form'=> $form->createView()]);
    }

    /**
     * @Route("/markattendance/{id}", name="login_mark_attendance")
     */
    public function markAttendance(Employees $employee)
    {
        date_default_timezone_set("Asia/Karachi");
        $date = date('d-m-Y');
        $timeIn = null;
        $timeOut = null;

        $em = $this->getDoctrine()->getManager();
        $attendance = $em->getRepository('AppBundle:Attendance')->findOneBy(['employee'=> $employee, 'date'=> $date]);
        if(!empty($attendance)) {
            $timeIn = $attendance->getTimeIn();
            $timeOut = $attendance->getTimeOut();
        }
        return $this->render('login/markAttendance.html.twig', ['id'=> $employee->getId(), 'timeIn'=> $timeIn, 'timeOut'=>$timeOut, 'user'=> $employee->getName()]);
    }

    /**
     * @Route("/marktimein/{id}", name="mark_time_in")
     */
    public function markTimeIn(Employees $employee)
    {
        date_default_timezone_set("Asia/Karachi");
        $date = date('d-m-Y');
        $timeIn = date('H:i');
        $status = $timeIn <= '12:00' ? 'present' : 'late';

        $em = $this->getDoctrine()->getManager();

        if(empty($em->getRepository('AppBundle:Attendance')->findBy(['employee'=>$employee, 'date'=>$date]))) {
            $att = new Attendance();
            $att->setDate($date);
            $att->setEmployee($employee);
            $att->setTimeIn($timeIn);
            $att->setStatus($status);

            $em->persist($att);
            $em->flush();

            $this->addFlash('success', 'Time In Successful');
        } else {
            $this->addFlash('error', 'You have Already Marked your Time In');
        }

        return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee->getId()]);
    }

    /**
     * @Route("/marktimeout/{id}", name="mark_time_out")
     */
    public function markTimeOut(Employees $employee)
    {
        date_default_timezone_set("Asia/Karachi");
        $timeOut = date('H:i');
        $date = date('d-m-Y');

        $em = $this->getDoctrine()->getManager();
        if(!empty($em->getRepository('AppBundle:Attendance')->findTimeOutMarked($employee, $date))) {
            $attendance = $em->getRepository('AppBundle:Attendance')->findOneBy(['employee'=> $employee, 'date'=> $date, 'time_out'=> NULL]);
            $attendance->setTimeOut($timeOut);
            $em->flush();
            $this->addFlash('success', 'Time Out Successful');
        } else {
            $this->addFlash('error', 'Time Out Not Successful');
        }

        return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee->getId()]);
    }
}
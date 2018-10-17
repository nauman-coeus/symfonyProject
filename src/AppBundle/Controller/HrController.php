<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Employees;
use AppBundle\Form\AddEmployeeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HrController extends Controller
{
    /**
     * @Route("/hr/addemployee", name="hr_add_employee")
     */
    public function addEmployee(Request $request)
    {
        $form = $this->createForm(AddEmployeeForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                $data = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                $this->addFlash('success', "New Employee Added");
            } else {
                $this->addFlash('error', "Error Employee not Added");
            }
        }

        return $this->render('hr/addEmployee.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/hr/dailyattendance" , name="hr_daily_attendance")
     */
    public function dailyAttendance()
    {
        $date = date('d-m-Y');
        $em = $this->getDoctrine()->getManager();
        $attendance = $em->getRepository('AppBundle:Attendance')->getDailyAttendance($date);
        return $this->render('hr/dailyAttendance.html.twig', ['attendance'=> $attendance]);
    }

    /**
     * @Route("/hr/employeelist", name="hr_employee_list")
     */
    public function employeeList()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Employees')->findAll();

        return $this->render('hr/employeeList.html.twig', ['data'=> $data]);
    }

    /**
     * @Route("/hr/monthlyattendance", name="hr_monthly_attendance")
     */
    public function monthlyAttendance()
    {
        $em = $this->getDoctrine()->getManager();

        for($i=1; $i<=12; $i++)
        {
            $date = '%-' . \DateTime::createFromFormat('m', $i)->format('m') . '-' . date('Y');
            $month = \DateTime::createFromFormat('m', $i)->format('M');

            $data[$month] = $em->getRepository('AppBundle:Attendance')->getMonthlyAttendance($date);
        }

        return $this->render('hr/monthlyAttendance.html.twig', ['attendance'=> $data]);
    }

    /**
     * @Route("/hr/editemployee/{id}", name="hr_edit_employee")
     */
    public function editEmployee(Employees $employee = null, Request $request)
    {
        $form = $this->createForm(AddEmployeeForm::class,$employee);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->getRepository('AppBundle:Employees');
                $em->flush();

                $this->addFlash('success', 'Employee Updated Successfully');
                return $this->redirectToRoute('hr_employee_list');
            } else {
                $this->addFlash('error', 'Form Data is Invalid');
            }
        }

        return $this->render('hr/editEmployee.html.twig', ['form'=> $form->createView(), 'user'=> $employee]);
    }

    /**
     * @Route("/hr/deleteemployee/{id}", name="hr_delete_employee")
     */
    public function deleteEmployee(Employees $employee, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Employees')->find($employee);
        $em->remove($data);
        $em->flush();

        $this->addFlash('success', 'Employee Deleted Successfully');
        return $this->redirectToRoute('hr_employee_list');
    }
}
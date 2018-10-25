<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Form\AddEmployeeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class EmployeeController extends Controller
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
            $employee = $em->getRepository('AppBundle:Employee')->findBy(['email' => $data['email'], 'password'=> $data['password']]);

            if($employee){
                return $this->redirectToRoute('login_mark_attendance', ['id'=> $employee[0]->getId()]);
            } else {
                $this->addFlash('error', 'Wrong Email / Password');
            }
        }

        return $this->render('Employee/login_page.html.twig', ['form'=> $form->createView()]);
    }

    /**
     * @Route("/addemployee", name="add_employee")
     */
    public function addEmployee(Request $request)
    {
        $form = $this->createForm(AddEmployeeForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                $this->addFlash('success', "New Employee Added");
            } else {
                $this->addFlash('error', "Error Employee not Added");
            }
        }

        return $this->render('Employee/add_employee.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/employeelist", name="employee_list")
     */
    public function employeeList()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Employee')->findAll();

        return $this->render('Employee/employee_list.html.twig', ['data' => $data]);
    }

    /**
     * @Route("/editemployee/{id}", name="edit_employee")
     */
    public function editEmployee(Employee $employee = null, Request $request)
    {
        $form = $this->createForm(AddEmployeeForm::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->getRepository('Employee.php');
                $em->flush();

                $this->addFlash('success', 'Employee Updated Successfully');
                return $this->redirectToRoute('employee_list');
            } else {
                $this->addFlash('error', 'Form Data is Invalid');
            }
        }

        return $this->render('Employee/edit_employee.html.twig', ['form' => $form->createView(), 'user' => $employee]);
    }

    /**
     * @Route("/deleteemployee/{id}", name="delete_employee")
     */
    public function deleteEmployee(Employee $employee, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Employee')->find($employee);
        $em->remove($data);
        $em->flush();

        $this->addFlash('success', 'Employee Deleted Successfully');
        return $this->redirectToRoute('employee_list');

    }
}
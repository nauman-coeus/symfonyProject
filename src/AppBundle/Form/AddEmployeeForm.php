<?php
/**
 * Created by PhpStorm.
 * User: coeus
 * Date: 10/3/18
 * Time: 12:05 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEmployeeForm extends AbstractType
{
    public function  buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name', TextType::class, [
                'label'=> false,
            ])
            ->add('email', EmailType::class, [
                'label'=> false
            ])
            ->add('salary', IntegerType::class, [
                'label'=> false,
            ])
            ->add('password', PasswordType::class, [
                'label'=> false,
            ])
            ->add('department', null, [
                'label'=>  false,
                'placeholder'=> '-- Select Department --'
            ])
            ->add('imageFile', FileType::class, [
                'label'=> false,
                'required'=> false,
            ])
            ->add('boss_id', null, [
                'label'=> false,
            ])
            ->add('designation', null, [
                'label'=> false,
                'placeholder'=> '-- Select Designation --'
            ])
            ->add('submitBtn', SubmitType::class, [
                'label'=> 'Add Employee',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Employees'
        ]);
    }
}
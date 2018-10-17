<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, [
                'label' => false,
            ])
            ->add('password', PasswordType::class, [
                'label'=> false,
            ])
            ->add('submitBtn', SubmitType::class, [
                'attr' => ['class' => 'orangeBtn'],
                'label' => 'Login',
            ]);
    }
}
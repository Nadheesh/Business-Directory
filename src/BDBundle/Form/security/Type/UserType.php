<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/15/2016
 * Time: 8:33 AM
 */

namespace BDBundle\Form\security\Type;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class , array('label'=>'First Name'))
            ->add('lastName',TextType::class , array('label'=>'Last Name'))
            ->add('email', TextType::class , array('label'=>'Email'))
            ->add('dateOfBirth', BirthdayType::class , array('label'=>'Date Of Birth'))
            ->add('username', TextType::class , array('label'=>'Username'))
            ->add('plainPassword', RepeatedType::class, array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => PasswordType::class
        ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\security\RegisteredUser',
        ));
    }

    public function getName()
    {
        return 'registeredUser';
    }

}
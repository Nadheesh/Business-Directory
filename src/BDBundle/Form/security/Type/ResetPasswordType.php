<?php

namespace BDBundle\Form\security\Type;

use BDBundle\Form\security\Type\UserType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', UserType::class ,array('label'=>' '));
        $builder->add('oldpassword', PasswordType::class, array('label'=>'Current Password'));
        $builder->add('captcha', CaptchaType::class , array('keep_value'=>false , 'disabled' =>true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'reset_password_type';
    }
}

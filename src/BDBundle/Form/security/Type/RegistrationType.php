<?php

namespace BDBundle\Form\security\Type;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', UserType::class);
        $builder->add('captcha', CaptchaType::class , array('keep_value'=>false , 'disabled' =>true));
        $builder->add('termsAccepted', CheckboxType::class);
        $builder->add('submit', SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'registration';
    }


}

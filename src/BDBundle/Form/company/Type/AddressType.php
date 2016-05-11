<?php

namespace BDBundle\Form\company\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;


class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class, array(
        ));
        $builder->add('city', TextType::class, array(
        ));
        $builder->add('zipcode', TextType::class, array(
            'required' => false
        ));
        $builder->add('state', TextType::class, array(
            'required' => false
        ));
        $builder->add('country', CountryType::class, array(
        ));
        $builder->add('latitude', HiddenType::class, array(
        ));
        $builder->add('longitude', HiddenType::class, array(
        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\company\Address',
        ));
    }

    public function getName()
    {
        return 'address';
    }
}

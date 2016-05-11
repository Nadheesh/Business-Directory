<?php

namespace BDBundle\Form\companyPage;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SliderContainerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isEnabled',HiddenType::class )
                ->add('slide1' , SlideType::class ,array('label'=>' '))
                ->add('slide2' , SlideType::class)
                ->add('slide3' , SlideType::class)
                ->add('save',SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\companyPage\SliderContainer',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'slider';
    }
}

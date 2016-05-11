<?php

namespace BDBundle\Form\companyPage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class CompanyPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('website', HiddenType::class, array())
            ->add('visible_elements', HiddenType::class, array())
            ->add('template_name', HiddenType::class, array())
            ->add('images', HiddenType::class, array());
//        $builder->add('url', TextType::class , array('label'=>'Url'))
//                ->add('aboutContainer', AboutContainerType::class , array( 'label' => ' '))
//                ->add('sliderContainer', SliderContainerType::class , array( 'label' => ' '));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\company\CompanyPage',
//            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'company_page';
    }
}

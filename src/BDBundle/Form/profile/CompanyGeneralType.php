<?php

namespace BDBundle\Form\profile;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyGeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $productTypes = $options['productTypes'];

        $builder->add('companyName',TextType::class , array('label'=>'Company Name'))
            ->add('desc', TextareaType::class , array('label'=>'Description'))
            ->add('productTypes', ChoiceType::class,
                array(
                    'label'=>'Product Types',
                    'required'=>true,
                    'expanded' => false ,
                    'multiple'=>true ,
                    'empty_data'=>null,
                    'choice_label' => 'getProductType',
                    'choices' => $productTypes )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'bdbundle_company_general_type';
    }
}

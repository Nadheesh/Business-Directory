<?php

namespace BDBundle\Form\search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $productTypes = $options['productTypes'];

        $builder
            ->add('searchKey',TextType::class , array('label'=>'Search', 'required'=>false , 'empty_data'=>null))
            ->add('productTypes', ChoiceType::class,
                array(
                    'label'=>'Product Types',
                    'required'=>false,
                    'expanded' => false ,
                    'multiple'=>true ,
                    'empty_data'=>null,
                    'choice_label' => 'getProductType',
                    'choices' => $productTypes )
            )
            ->add('country', CountryType::class ,
                array(
                    'label'=>'Country' ,
                    'required'=>false,
                    'multiple'=>true ,
                    'empty_data'=>null
                ))

            ->add('startDate', BirthdayType::class , array('label'=>'Since'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\company\SearchTag',
            'productTypes' => null,
        ));
    }

    public function getName()
    {
        return 'search';
    }
}

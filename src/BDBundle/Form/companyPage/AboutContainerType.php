<?php

namespace BDBundle\Form\companyPage;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AboutContainerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('size',HiddenType::class )
                ->add('descriptionContainers',CollectionType::class,array(
                    'entry_type' => DescriptionContainerType::class,
                    'required'=>true,
                    'allow_add'  => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label'=>' ',
                ))->add('submit',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\companyPage\AboutContainer',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'about_container';
    }
}

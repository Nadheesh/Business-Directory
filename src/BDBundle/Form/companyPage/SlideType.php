<?php

namespace BDBundle\Form\companyPage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('image',FileType::class)
            ->add('header',HiddenType::class)
            ->add('text',HiddenType::class, array('error_bubbling'=>false))
            ->add('button_text',HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\companyPage\Slide',
            'error_mapping' => array(
                '.' => 'text',
            ),
        ));
    }

    public function getName()
    {
        return 'slide_type';
    }
}

<?php

namespace BDBundle\Form\profile;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', HiddenType::class, array('empty_data' => 0))
            ->add('review', TextareaType::class, array('required' => true, 'attr' => array('maxlength' => '250')))
            ->add('submit', SubmitType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'rating';
    }
}

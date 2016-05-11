<?php

namespace BDBundle\Form\company\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Gregwar\CaptchaBundle\Type\CaptchaType;


class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $productTypes = $options['productTypes'];

        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add('companyName',TextType::class , array('label'=>'Company'))
                    ->add('brandName',TextType::class , array('label'=>'Brand Name','required'=>false))
                    ->add('desc',HiddenType::class, array('required'=>false, 'empty_data'=>null ) );
                break;
            case 2:
                $builder
                    ->add('productTypes', ChoiceType::class,
                        array(
                            'label'=>'Product Types',
                            'required'=>true,
                            'expanded' => false ,
                            'multiple'=>true ,
                            'empty_data'=>null,
                            'choice_label' => 'getProductType',
                            'choice_value'=> 'getProductType',
                            'choices' => $productTypes )
                    );

                break;
            case 3:
                $builder
                    ->add('contactEmail', TextType::class , array('label'=>'Contact Email'))
                    ->add('contactNumbers', PhoneNumberType::class, array('widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE ))
                    ->add('url', UrlType::class, array('label'=>'Company Website', 'required' => false ));

                break;
            case 4:
                $builder
                    ->add('address', AddressType::class, array('label'=>' '));
                break;
            case 5:
                $builder
                    ->add('businessType', ChoiceType::class ,
                        array(
                            'label'=>'Business Type',
                            'required'=>true,
                            'choices'=>array(
                                'Unregistered' =>'Unregistered',
                                'Sole Proprietorship'=>'Sole Proprietorship' ,
                                'Partnership'=>'Partnership',
                                'PVT limited'=>'PVT limited',
                                'PLC limited' => 'PLC limited')
                        ))
//                    ->add('owners',CollectionType::class,array(
//                            'entry_type' => TextType::class,
//                            'required'=>true,
//                            'allow_add'  => true,
//                            'allow_delete' => true,
//                            'by_reference' => false,
//                            'label'=>' ',
//                        )
//                    )
                    ->add('startDate', BirthdayType::class , array('label'=>'Originated Date'))
                    ->add('registeredCountry',CountryType::class,array('label'=>'Registered Country'));
                break;
//            case 5:
//                $builder->add('branches',CollectionType::class,array(
//                'entry_type' => BranchType::class,
//                'required'=>true,
//                'allow_add'  => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'label'=>' ',
//                        )
//                );
//                break;
            case 6:
                $builder->add('captcha', CaptchaType::class , array('keep_value'=>false , 'disabled' =>true));
                $builder->add('termsAccepted', CheckboxType::class);
                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BDBundle\Document\company\Company',
            'cascade_validation' => true,
            'productTypes' => null,
            'flow_step' => 1,
        ));

    }

    public function getName()
    {
        return 'company';
    }

    public function getBlockPrefix() {
        return 'company';
    }
}

<?php

namespace BDBundle\Form\company\Type;


use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Misd\PhoneNumberBundle\Form\DataTransformer\PhoneNumberToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PhoneNumberType extends AbstractType
{
    const WIDGET_SINGLE_TEXT = 'single_text';
    const WIDGET_COUNTRY_CHOICE = 'country_choice';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (self::WIDGET_COUNTRY_CHOICE === $options['widget']) {//self::WIDGET_COUNTRY_CHOICE === $options['widget']

            $util = PhoneNumberUtil::getInstance();

            $countries = array();

            if (is_array($options['country_choices'])) {
                foreach ($options['country_choices'] as $country) {
                    $code = $util->getCountryCodeForRegion($country);
                    if ($code) {
                        $countries[$country] = $code;
                    }
                }
            }

            if (empty($countries)) {
                foreach ($util->getSupportedRegions() as $country) {
                    $countries[$country] = $util->getCountryCodeForRegion($country);
                }
            }

            $countryChoices = array();


            foreach (Intl::getRegionBundle()->getCountryNames() as $region => $name) {
                if (false === isset($countries[$region])) {
                    continue;
                }

                $countryChoices[sprintf('%s (+%s)', $name, $countries[$region])] = $countries[$region];

            }

//            $transformerChoices = array_values($countryChoices);

            $countryOptions = $numberOptions = array(
                'error_bubbling' => true,
                'required' => $options['required'],
                'disabled' => $options['disabled'],
                'translation_domain' => $options['translation_domain'],
            );



            $countryOptions['choice_translation_domain'] = false;
            $countryOptions['choices_as_values'] = true;
            $countryOptions['required'] = true;
            $countryOptions['choices'] = $countryChoices;
            $countryOptions['preferred_choices'] = $options['preferred_country_choices'];
            $countryOptions['label'] = 'Country code';
            $numberOptions['label'] = 'Local number';

            $builder
                ->add('country', ChoiceType::class, $countryOptions)
                ->add('number', TextType::class, $numberOptions);

        } else {
            $builder->addViewTransformer(
                new PhoneNumberToStringTransformer($options['default_region'], $options['format'])
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type'] = 'tel';
        $view->vars['widget'] = $options['widget'];
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BDBundle\Document\company\PhoneNumber',
                'widget' => self::WIDGET_COUNTRY_CHOICE,
                'compound' => function (Options $options) {
                    return PhoneNumberType::WIDGET_SINGLE_TEXT !== $options['widget'];
                },
                'default_region' => PhoneNumberUtil::UNKNOWN_REGION,
                'format' => PhoneNumberFormat::INTERNATIONAL,
                'invalid_message' => 'This value is not a valid phone number.',
                'by_reference' => false,
                'error_bubbling' => false,
                'country_choices' => array(),
                'preferred_country_choices' => array(),
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tel';
    }
}

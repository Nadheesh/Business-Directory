<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/18/2016
 * Time: 10:49 AM
 */

namespace BDBundle\Form\company\Flow;

use Craue\FormFlowBundle\Form\FormFlow;
//use Craue\FormFlowBundle\Form\FormFlowInterface;

class RegisterFlow extends FormFlow
{
//    protected $revalidatePreviousSteps = false;
    protected $allowDynamicStepNavigation = true;

    private $productTypes;

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'Who you are?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
            ),
            array(
                'label' => 'What do you do?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
                'form_options' => array(
                    'productTypes' => $this->productTypes,
                ),
            ),
            array(
                'label' => 'How can we contact you?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
//                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
//                    return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
            ),
            array(
                'label' => 'Where can we find you?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
//                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
//                    return $estimatedCurrentStepNumber > 1 && !$flow->getFormData()->canHaveEngine();
            ),
            array(
                'label' => 'Are you a registered company?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
            ),
            array(
                'label' => 'Do you agree with our terms?',
                'form_type' => 'BDBundle\Form\company\Type\CompanyType',
            ),
            array(
                'label' => 'Are these information correct?',
            ),
        );
    }

    public function setProducts(array $products){
        $this->productTypes = $products;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/3/2016
 * Time: 1:04 AM
 */

namespace Tests\AppBundle\Form;

use BDBundle\Form\company\Type\CompanyType;
use BDBundle\Document\company\Company;
use BDBundle\Document\company\Address;
use BDBundle\Document\company\Branch;
use libphonenumber\PhoneNumber;
use BDBundle\Document\company\ProductType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\ConstraintViolationList;


class CompanyTypeTest extends TypeTestCase
{

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data)
    {

        $form = $this->factory->create(CompanyType::class);

        $object = new Company;
        $object->fromArray($data);

        // submit the data to the form directly
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }


    public function getValidTestData()
    {

        $product1 = new ProductType();
        $product2 = new ProductType();

        $address1 = new Address();
        $address2 = new Address();




        $branch1 = new Branch();
        $branch2 = new Branch();



        //all data is tested with each form type test case
        //this is a unit test case. The intent is to test CompanyType
        //Therefore the BranchType and AddressType should be assumed as working correctly
        $address1->fromArray(array(
            'country' => 'SL',
            'street' => '20/A, Agraplace',
            'city' => 'Avissawella',
            'zipcode' => '123M',

        ));

        $address2->fromArray(array(
            'country' => 'US',
            'street' => '20/A, Agraplace',
            'city' => 'Avissawella',
            'zipcode' => '10700',
            'state' => 'Colombo',
        ));

        $branch1->fromArray(
            array(
                'branchName' => 'MSI distributor branch',
                'email' => 'msids@gmail.com',
                'contactNumbers' => new PhoneNumber(),
                'address' => $address1
            )
        );

        $branch2->fromArray(
            array(
                'branchName' => 'Google SL',
                'email' => 'google@gmail.lk',
                'contactNumbers' => new PhoneNumber(),
                'address' => $address2
            )
        );


        return array(
            array(//terms are accepted
                'data' => array(
                    'contactEmail' => 'jnj@gmail.com',
                    'companyName' =>'MSI',
                    'desc'=>'Gaming',
                    'businessType'=>'Sole Ownership',
                    'productTypes' =>array( 0 => $product1, 1 =>$product2),
                    'address' => $address1,
                    'startDate' => new \DateTime() ,
                    'owners' =>array(0 =>'JNJ'),
                    'registeredCountry' =>'UK',
                    'url' =>'https://www.google.lk/',
                    'contactNumbers' =>new PhoneNumber(),
                    'branches'=> array( 0 => $branch1, 1 => $branch2),
                    'termsAccepted'=>1
                )
            ),
            array( //terms are not accepted
                'data' => array(
                    'contactEmail' => 'jnj@gmail.com',
                    'companyName' =>'MSI',
                    'desc'=>'Gaming',
                    'businessType'=>'Sole Ownership',
                    'productTypes' =>array( 0 => $product1, 1 =>$product2),
                    'address' => $address1,
                    'startDate' => new \DateTime() ,
                    'owners' =>array(0 =>'JNJ'),
                    'registeredCountry' =>'UK',
                    'url' =>'https://www.google.lk/',
                    'contactNumbers' =>new PhoneNumber(),
                    'branches'=> array( 0 => $branch1, 1 => $branch2),
                    'termsAccepted'=>0
                )
            ),
            array( //no branches
                'data' => array(
                    'contactEmail' => 'jnj@gmail.com',
                    'companyName' =>'MSI',
                    'desc'=>'Gaming',
                    'businessType'=>'Sole Ownership',
                    'productTypes' =>array( 0 => $product1, 1 =>$product2),
                    'address' => $address1,
                    'startDate' => new \DateTime() ,
                    'owners' =>array(0 =>'JNJ'),
                    'registeredCountry' =>'UK',
                    'url' =>'https://www.google.lk/',
                    'contactNumbers' =>new PhoneNumber(),
                    'termsAccepted'=>1
                )
            ),
        );
    }
}
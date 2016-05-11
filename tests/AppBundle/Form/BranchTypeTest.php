<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/3/2016
 * Time: 1:04 AM
 */

namespace Tests\AppBundle\Form;

use BDBundle\Form\company\Type\BranchType;
use BDBundle\Document\company\Branch;
use BDBundle\Document\company\Address;
use BDBundle\Document\company\PhoneNumber;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;



class BranchTypeTest extends TypeTestCase
{
    private $documentManager;

    protected function setUp()
    {
        // mock any depend$encies
        $this->documentManager = $this->getMockbuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();


        parent::setUp();
    }


    protected function getExtensions()
    {
        // create a type instance with the mocked dependencies
        $type = new BranchType($this->documentManager);

        return array(
            // register the type instances with the PreloadedExtension
            new PreloadedExtension(array($type), array()),
        );
    }


    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data,$obj)
    {

        $form = $this->factory->create(BranchType::class);

        $object = new Branch();
        $object->fromArray($data);

        // submit the data to the form directly
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());

        $data = $form->getData();


        $expected = new Branch();
        $expected->fromArray($obj);

        $this->assertEquals($expected, $form->getData());

        $view = $form->createView();
        $children = $view->children;

    }


    public function getValidTestData()
    {

        $address1 = new Address();
        $address2 = new Address();



        //all internal types are tested with each form type test case
        //this is a unit test case. The intent is to test BranchType
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


        $phoneNo = new PhoneNumber();

        $phoneNo->setNumber(123123);
        $phoneNo->setCountry(27);


        return array(
            array(
                'data' =>
                    array(
                    'branchName' => 'MSI distributor branch',
                    'email' => 'msids@gmail.com',
                    'contactNumbers' => array(
                        'country' => '1',
                        'number' => 123123
                    ),
                    'address' => array(
                        'country' => 'US',
                        'street' => '20/A, Agraplace',
                        'city' => 'Avissawella',
                        'zipcode' => '10700',
                        'state' => 'Colombo',
                    )
                ),
                'obj' => array(
                    'branchName' => 'MSI distributor branch',
                    'email' => 'msids@gmail.com',
                    'contactNumbers' => $phoneNo,
                    'address' => $address2
                )
            ),
            array(
                'data' =>
                    array(
                    'branchName' => 'Google SL',
                    'email' => 'google@gmail.lk',
                        'contactNumbers' => array(
                            'country' => '1',
                            'number' => 123123
                        ),
                    'address' => array(
                        'country' => 'SL',
                        'street' => '20/A, Agraplace',
                        'city' => 'Avissawella',
                        'zipcode' => '123M',

                    )
                ),
                'obj' =>
                    array(
                    'branchName' => 'Google SL',
                    'email' => 'google@gmail.lk',
                    'contactNumbers' => $phoneNo,
                    'address' => $address1

                    )
            ),

            array(
                'data' =>
                    array(
                    'branchName' => 'Google SL',
                    'email' => 'google@gmail.lk',
                    'contactNumbers' => 'new tel no',
                    'address' => 'new address'
                ),

                'obj' =>
                    array(
                        'branchName' => 'Google SL',
                        'email' => 'google@gmail.lk',
                        'contactNumbers' => 'new tel no',
                        'address' => 'new address'
                    )
            ),
            array(
                'data' =>
                    array(
                        'branchName' => 'Shehan Stores',
                        'email' => 'shehan@gmail.lk',
                        'address' => 'new address'
                    ),

                'obj' =>
                    array(
                        'branchName' => 'Google SL',
                        'email' => 'google@gmail.lk',
                        'address' => 'new address'
                    )
            ),

        );
    }
}
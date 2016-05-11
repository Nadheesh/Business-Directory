<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/3/2016
 * Time: 1:04 AM
 */

namespace Tests\AppBundle\Form;

use BDBundle\Form\company\Type\AddressType;
use BDBundle\Document\company\Address;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\ConstraintViolationList;


class AddressTypeTest extends TypeTestCase
{

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData($data)
    {

        $form = $this->factory->create(AddressType::class);

        $object = new Address();
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
        return array(
            array(
                'data' => array(
                    'country' => 'Sri Lanka',
                    'street' => '20/A, Agraplace',
                    'city' => 'Avissawella',
                    )
            ),
            array(
                'data' => array(
                    'country' => 'test',
                    'zipcode' => 'test2',
                ),
            ),
            array(
                'data' => array(
                    'country' => 'US',
                    'street' => '20/A, Agraplace',
                    'city' => 'Avissawella',
                    'zipcode' => '10700',
                    'state' => 'Colombo',

                )
            ),



            array(
                'data' => array(
                    'country' => 'SL',
                    'street' => '20/A, Agraplace',
                    'city' => 'Avissawella',
                    'zipcode' => '123M',

                )
            ),
        );
    }
}
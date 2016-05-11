<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/15/2016
 * Time: 10:59 AM
 */

namespace BDBundle\Form\security\Model;


use Symfony\Component\Validator\Constraints as Assert;
use BDBundle\Document\security\RegisteredUser;

class Registration
{

    /**
     * @Assert\Type(type="BDBundle\Document\security\RegisteredUser")
     * @Assert\Valid
     */
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\IsTrue(message = "Must Accept the terms")
     */
    protected $termsAccepted;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    /**
     * @param mixed $termsAccepted
     */
    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = $termsAccepted;
    }


}
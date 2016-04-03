<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 6/15/2016
 * Time: 4:07 AM
 */

namespace BDBundle\Form\security\Model;


use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ResetPassword
{

    /**
     * @SecurityAssert\Type(type="BDBundle\Document\security\User")
     * @SecurityAssert\Valid
     */
    protected $user;


    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    protected $oldpassword;

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
    public function getOldpassword()
    {
        return $this->oldpassword;
    }

    /**
     * @param mixed $oldpassword
     */
    public function setOldpassword($oldpassword)
    {
        $this->oldpassword = $oldpassword;
    }




}
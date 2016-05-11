<?php

namespace BDBundle\Document\company;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @MongoDB\EmbeddedDocument
 */
class PhoneNumber
{

    /**
     * @MongoDB\Id
     */
    private $phoneNumberId;


    /**
     * @MongoDB\Integer
     * @Assert\NotBlank(groups={"flow_register_step3"})
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid Country Code.",
     *     groups={"flow_register_step3","modify_branch"}
     * )
     */
    private $country = null;

    /**
     * @MongoDB\Integer
     * @Assert\NotBlank(groups={"flow_register_step3"})
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     htmlPattern = "^[0-9]+$",
     *     message="The value {{ value }} is not a valid tel-number.",
     *     groups={"flow_register_step3","modify_branch"}
     * )
     */
    private $number = null;

    /**
     * @return mixed
     */
    public function getPhoneNumberId()
    {
        return $this->phoneNumberId;
    }

    /**
     * @param mixed $phoneNumberId
     */
    public function setPhoneNumberId($phoneNumberId)
    {
        $this->phoneNumberId = $phoneNumberId;
    }

    /**
     * @return int|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param int|null $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return null|string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param null|string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/15/2016
 * Time: 10:51 PM
 */

namespace BDBundle\Document\company;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\EmbeddedDocument
 */
class Branch
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank(groups={"modify_branch"})
     */
    protected $branchName;

    /**
     * @MongoDB\String
     * @Assert\NotBlank(groups={"flow_register_step4"})
     * @Assert\Email(checkMX = false , groups={"modify_branch"})
     */
    protected $email;

    /**
     * @MongoDB\EmbedOne(targetDocument="PhoneNumber")
     * @Assert\NotBlank(groups={"modify_branch"})
     * @Assert\Valid
     */
    protected $contactNumbers;


    /**
     * @MongoDB\EmbedOne(targetDocument="Address")
     * @Assert\NotBlank(groups={"modify_branch"})
     * @Assert\Valid
     */
    protected $address;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBranchName()
    {
        return $this->branchName;
    }

    /**
     * @param mixed $branchName
     */
    public function setBranchName($branchName)
    {
        $this->branchName = $branchName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getContactNumbers()
    {
        return $this->contactNumbers;
    }

    /**
     * @param mixed $contactNumbers
     */
    public function setContactNumbers($contactNumbers)
    {
        $this->contactNumbers = $contactNumbers;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


    public function fromArray($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

}
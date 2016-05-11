<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/14/2016
 * Time: 11:30 AM
 */

namespace BDBundle\Document\security;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document
 */
class RegisteredUser extends User
{
    /**
     * @MongoDB\Date
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    Protected $dateOfBirth ;


    /**
     * @var
     * @MongoDB\Collection
     */
    protected $companies ;

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param mixed $companies
     */
    public function setCompanies($companies)
    {
        $this->companies = $companies;
    }



}
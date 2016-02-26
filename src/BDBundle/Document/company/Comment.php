<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 6/13/2016
 * Time: 3:46 PM
 */

namespace BDBundle\Document\company;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\EmbeddedDocument
 */
class Comment
{


    /**
     * @MongoDB\Float
     */
    protected $rate;


    /**
     * @MongoDB\String
     * @Assert\NotBlank
     * @Assert\Length(max="250")
     */
    protected $review;


    /**
     * @MongoDB\Date
     */
    protected $timestamp;


    /**
     * @MongoDB\Id(strategy="NONE")
     * @var string
     * @Assert\NotBlank()
     */
    protected $username ;



    //initiations
    public function setCreated(){
        $this->timestamp = (new \DateTime());

    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }





    /**
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param mixed $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * @return mixed
     */
    public function getRegTime()
    {
        return $this->regTime;
    }

    /**
     * @param mixed $regTime
     */
    public function setRegTime($regTime)
    {
        $this->regTime = $regTime;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


}
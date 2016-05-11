<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/11/2016
 * Time: 1:06 PM
 */

namespace BDBundle\Document\companyPage;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\EmbeddedDocument
 */
class SliderContainer
{

    /**
     * @MongoDB\Id
     */
    protected $id;


    /**
     * @MongoDB\Boolean

     * @Assert\NotBlank
     */
    protected $isEnabled ;

    /**
     * @MongoDB\EmbedOne(targetDocument="Slide")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    protected $slide1;

    /**
     * @MongoDB\EmbedOne(targetDocument="Slide")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    protected $slide2;

    /**
     * @MongoDB\EmbedOne(targetDocument="Slide")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    protected $slide3;

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
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param mixed $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return mixed
     */
    public function getSlide1()
    {
        return $this->slide1;
    }

    /**
     * @param mixed $slide1
     */
    public function setSlide1($slide1)
    {
        $this->slide1 = $slide1;
    }

    /**
     * @return mixed
     */
    public function getSlide2()
    {
        return $this->slide2;
    }

    /**
     * @param mixed $slide2
     */
    public function setSlide2($slide2)
    {
        $this->slide2 = $slide2;
    }

    /**
     * @return mixed
     */
    public function getSlide3()
    {
        return $this->slide3;
    }

    /**
     * @param mixed $slide3
     */
    public function setSlide3($slide3)
    {
        $this->slide3 = $slide3;
    }




}
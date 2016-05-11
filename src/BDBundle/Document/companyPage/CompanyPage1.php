<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/11/2016
 * Time: 1:03 PM
 */

namespace BDBundle\Document\companyPage;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;


/**
 * @MongoDB\Document(collection="CompanyPage")
 * @MongoDBUnique(fields="url")
 * @MongoDB\Index(keys={"url"="text"})
 */
class CompanyPage1
{

    /**
     * @MongoDB\Id(strategy="NONE")
     * @var string
     * @Assert\NotBlank
     * @Assert\Url
     */
    protected $url;


    /**
     * @MongoDB\EmbedOne(targetDocument="AboutContainer")
     *
     */
    protected $aboutContainer;

    /**
     * @MongoDB\EmbedOne(targetDocument="SliderContainer")
     * @Assert\NotBlank
     * @Assert\Valid
     */
    protected $sliderContainer;


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return mixed
     */
    public function getAboutContainer()
    {
        return $this->aboutContainer;
    }

    /**
     * @param mixed $aboutContainer
     */
    public function setAboutContainer($aboutContainer)
    {
        $this->aboutContainer = $aboutContainer;
    }

    /**
     * @return mixed
     */
    public function getSliderContainer()
    {
        return $this->sliderContainer;
    }

    /**
     * @param mixed $sliderContainer
     */
    public function setSliderContainer($sliderContainer)
    {
        $this->sliderContainer = $sliderContainer;
    }




}
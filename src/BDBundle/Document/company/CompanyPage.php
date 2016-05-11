<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 6/1/2016
 * Time: 9:10 AM
 */

namespace BDBundle\Document\company;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\EmbeddedDocument
 */
class CompanyPage
{

    /**
     * @MongoDB\Hash
     */
    protected $website;

    /**
     * @MongoDB\Hash
     */
    protected $visibleElements;



    /**
     * @MongoDB\String
     */
    protected  $templateName;


    protected  $images;



//    /**
//     * @var boolean
//     * @MongoDB\Boolean
//     *
//     */
//    protected $isWebPageEnabled;
//
//
//    /**
//     * @var string
//     * @MongoDB\String
//     */
//    protected $pageUrl;
//
//    public function setCreated()
//    {
//        $this->isWebPageEnabled = false;
//    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }
//
//    /**
//     * @return boolean
//     */
//    public function isIsWebPageEnabled()
//    {
//        return $this->isWebPageEnabled;
//    }
//
//    /**
//     * @param boolean $isWebPageEnabled
//     */
//    public function setIsWebPageEnabled($isWebPageEnabled)
//    {
//        $this->isWebPageEnabled = $isWebPageEnabled;
//    }
//
//    /**
//     * @return string
//     */
//    public function getPageUrl()
//    {
//        return $this->pageUrl;
//    }
//
//    /**
//     * @param string $pageUrl
//     */
//    public function setPageUrl($pageUrl)
//    {
//        $this->pageUrl = $pageUrl;
//    }

    /**
     * @return string
     */
    public function getVisibleElements()
    {
        return $this->visibleElements;
    }

    /**
     * @param string $visibleElements
     */
    public function setVisibleElements($visibleElements)
    {
        $this->visibleElements = $visibleElements;
    }

    /**
     * @return mixed
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param mixed $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }


}
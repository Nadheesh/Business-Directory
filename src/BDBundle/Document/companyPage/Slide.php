<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/13/2016
 * Time: 10:47 AM
 */

namespace BDBundle\Document\companyPage;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class Slide
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $imageUrl;

    /**
     * @Assert\Image
     */
    protected $image;

    /**
     * @MongoDB\String
     * @Assert\Type(type="string")
     */
    protected $header;

    /**
     * @MongoDB\String
     * @Assert\Email
     */
    protected $text;

    /**
     * @MongoDB\String
     * @Assert\Type(type="string")
     */
    protected $buttonText;

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
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getButtonText()
    {
        return $this->buttonText;
    }

    /**
     * @param mixed $buttonText
     */
    public function setButtonText($buttonText)
    {
        $this->buttonText = $buttonText;
    }


}
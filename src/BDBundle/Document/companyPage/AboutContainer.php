<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/11/2016
 * Time: 1:08 PM
 */

namespace BDBundle\Document\companyPage;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\EmbeddedDocument
 */
class AboutContainer
{

    /**
     * @MongoDB\Id
     */
    protected $id;


    /**
     * @MongoDB\Integer
     * @Assert\Type(type="integer")
     */
    protected $size;

    /**
     * @MongoDB\EmbedMany(targetDocument="DescriptionContainer")
     *
     */
    protected $descriptionContainers;

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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getDescriptionContainers()
    {
        return $this->descriptionContainers;
    }

    /**
     * @param mixed $descriptionContainers
     */
    public function setDescriptionContainers($descriptionContainers)
    {
        $this->descriptionContainers = $descriptionContainers;
    }


}
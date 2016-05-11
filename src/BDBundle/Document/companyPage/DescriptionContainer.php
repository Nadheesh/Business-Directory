<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/11/2016
 * Time: 1:47 PM
 */

namespace BDBundle\Document\companyPage;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\EmbeddedDocument
 */
class DescriptionContainer
{


    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\Type(type = "string")
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @MongoDB\String
     * @Assert\Type(type = "string")
     * @Assert\NotBlank
     */
    protected $description;

    /**
     * @MongoDB\Integer
     * @Assert\Type(type="integer")
     */
    protected $position;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }


}
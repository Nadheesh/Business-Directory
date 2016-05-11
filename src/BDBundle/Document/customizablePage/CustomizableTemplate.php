<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/28/2016
 * Time: 1:08 PM
 */

namespace BDBundle\Document\customizablePage;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class CustomizableTemplate
{

    /**
     * @var string
     * @MongoDB\Id(strategy="NONE")
     * @var string
     * @Assert\NotBlank
     */
    protected $templateName;


    /**
     * @MongoDB\Hash
     */
    protected $templateData;

    /**
     * @MongoDB\Hash
     */
    protected $visibility;

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param string $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }



    /**
     * @return string
     */
    public function getTemplateData()
    {
        return $this->templateData;
    }

    /**
     * @param string $templateData
     */
    public function setTemplateData($templateData)
    {
        $this->templateData = $templateData;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }


}
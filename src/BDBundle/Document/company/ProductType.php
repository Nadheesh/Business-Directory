<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/16/2016
 * Time: 12:10 AM
 */

namespace BDBundle\Document\company;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\EmbeddedDocument
 */
class ProductType
{

    /**
     * @MongoDB\Id
     */
    private $productTypeId;


    /**
     * @MongoDB\String
     */
    private $productType;

    /**
     * @return mixed
     */
    public function getProductTypeId()
    {
        return $this->productTypeId;
    }

    /**
     * @param mixed $productTypeId
     */
    public function setProductTypeId($productTypeId)
    {
        $this->productTypeId = $productTypeId;
    }

    /**
     * @return mixed
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param mixed $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }




}
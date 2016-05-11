<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/2/2016
 * Time: 10:48 AM
 */

namespace BDBundle\Document\company;

use Symfony\Component\Validator\Constraints as Assert;


class SearchTag
{

    /**
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    protected $searchKey;

    /**
     * @Assert\Collection
     */
    protected $productTypes;

    /**
     * @Assert\Date()
     */
    protected $startDate;

    /**
     * @Assert\Collection
     */
    protected $country;

    /**
     * @Assert\Type(
     *     type="float"
     * )
     */
    protected $score;


    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    /**
     * @return mixed
     */
    public function getSearchKey()
    {
        return $this->searchKey;
    }

    /**
     * @param mixed $searchKey
     */
    public function setSearchKey($searchKey)
    {
        $this->searchKey = $searchKey;
    }

    /**
     * @return mixed
     */
    public function getProductTypes()
    {
        return $this->productTypes;
    }

    /**
     * @param mixed $productTypes
     */
    public function setProductTypes($productTypes)
    {
        $this->productTypes = $productTypes;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }




}
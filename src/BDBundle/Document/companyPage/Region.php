<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/28/2016
 * Time: 1:08 PM
 */

namespace BDBundle\Document\companyPage;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


class Region
{

   protected $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }



}
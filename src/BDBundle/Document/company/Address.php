<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/2/2016
 * Time: 2:53 PM
 */

namespace BDBundle\Document\company;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Intl\Intl;


/**
 * @MongoDB\EmbeddedDocument
 */
class Address
{
    /**
     * @MongoDB\Id
     */
    protected $id;


    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\Country(groups={"modify_branch","flow_register_step4"})
     * @Assert\NotBlank(groups={"modify_branch","flow_register_step4"})
     * @Assert\Length(min="2", max="255",groups={"modify_branch","flow_register_step4"})
     */
    protected $country;


    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\Length(max="100",groups={"modify_branch","flow_register_step4"})
     */
    protected $state;



    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\Length(max="20",groups={"modify_branch","flow_register_step4"})
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\NotBlank(groups={"modify_branch","flow_register_step4"})
     * @Assert\Length(max="100",groups={"modify_branch","flow_register_step4"})
     */
    protected $city;

    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\Length(max="100",groups={"modify_branch","flow_register_step4"})
     */
    protected $district;


    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\NotBlank(groups={"modify_branch","flow_register_step4"})
     * @Assert\Length(max="255",groups={"modify_branch","flow_register_step4"})
     */
    protected $street;

    /**
     * @MongoDB\Float
     */
    protected $longitude;


    /**
     * @MongoDB\Float
     */
    protected $latitude;


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
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }


    public function getStrCountry(){

        $countries = Intl::getRegionBundle()->getCountryName($this->country);

        return $countries;
    }


    public static function getCountryName($code){

        $country = Intl::getRegionBundle()->getCountryName($code);

        return $country;
    }



    public function getStrAddress($withZipCode = false){

        $str_address= $this->street.','.$this->city;

        if($this->state!=null){
            $str_address.=','.$this->state;
        }

        if($withZipCode && $this->zipCode!=null){
            $str_address.=','.$this->zipCode;
        }

        $str_address.=','.$this->getStrCountry($this->country);

        return $str_address;
    }



    public function fromArray($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

    public  function toArray() {

        $addressArr = array();
        $addressArr['longitude'] = $this->longitude;
        $addressArr['latitude'] = $this->latitude;
        $addressArr['state'] = $this->state;
        $addressArr['street'] = $this->street;
        $addressArr['city'] = $this->city;
        $addressArr['country'] =$this->country;
        $addressArr['zipcode'] = $this->zipCode;
        return $addressArr;

    }


}
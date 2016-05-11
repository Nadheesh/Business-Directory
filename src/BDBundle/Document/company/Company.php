<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/14/2016
 * Time: 11:34 AM
 */

namespace BDBundle\Document\company;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @MongoDB\Document(collection="Company")
 * @MongoDBUnique(fields="contactEmail")
 * @MongoDBUnique(fields="pageUrl")
 * @MongoDB\Index(keys={"companyName" = "text"})
 * @MongoDB\Index(keys={"desc" = "text"})
 */
class Company
{

    /**
     * @MongoDB\ID
     */
    protected $id;

    /**
     * @MongoDB\String
     * @var string
     * @Assert\NotBlank(groups={"flow_register_step3"})
     * @Assert\Email(checkMX = false , groups={"flow_register_step3"})
     * @Assert\Length(max="100",groups={"flow_register_step3"})
     */
    protected $contactEmail;

    /**
     * @MongoDB\String
     * @Assert\NotBlank(groups={"flow_register_step1","general_type_form"})
     * @Assert\Length(max="50",groups={"general_type_form","flow_register_step1"})
     */
    protected $companyName;

    /**
     * @MongoDB\String
     * @Assert\NotBlank(groups={"general_type_form"})
     * @Assert\Length(max="50",groups={"general_type_form","flow_register_step1"})
     */
    protected $brandName;


    /**
     * @MongoDB\String
     */
    protected $profileUrl;

    /**
     * @MongoDB\String
     * @Assert\Length(max="2500",groups={"general_type_form"})
     */
    protected $desc;

    /**
     * @MongoDB\String
     * @Assert\NotBlank(groups={"flow_register_step5"})
     */
    protected $businessType;

    /**
     * @MongoDB\EmbedMany(targetDocument="ProductType")
     * @Assert\NotBlank(groups={"flow_register_step2","flow_register_step2"})
     *
     */
    protected $productTypes;

    /**
     * @MongoDB\EmbedOne(targetDocument="Address")
     * @Assert\NotBlank(groups={"flow_register_step4"})
     *
     */
    protected $address;

    /**
     * @MongoDB\Date
     * @Assert\Date(groups={"flow_register_step5"})
     */
    protected $startDate;

    /**
     * @MongoDB\Collection
     * @Assert\NotBlank(groups={""})
     */
    protected $owners;

    /**
     * @MongoDB\String
     * @Assert\Country(groups={"flow_register_step5"})
     */
    protected $registeredCountry;

    /**
     * @MongoDB\String
     * @Assert\Length(max="100",groups={"flow_register_step3"})
     * @Assert\Url(
     *     checkDNS = true,
     *     message = "The url '{{ value }}' is not a valid url",
     *     dnsMessage = "The host '{{ value }}' could not be resolved.",
     *     protocols = {"http", "https", "ftp"},
     *     groups={"flow_register_step3"}),
     */
    protected $url;

    /**
     * @MongoDB\EmbedOne(targetDocument="PhoneNumber")
     * @Assert\Valid()
     */
    protected $contactNumbers;

    /**
     * @MongoDB\Boolean
     */
    protected  $isActive ;

    /**
     * @MongoDB\Boolean
     */
    protected  $isVerified ;

    /**
     * @MongoDB\TimeStamp
     */
    protected $regTime;

    /**
     * @MongoDB\EmbedMany(targetDocument="Branch")
     */
    protected $branches;


    /**
     * @var string
     * @MongoDB\EmbedOne(targetDocument="CompanyPage")
     */
    protected $companyPage;



    //variable used for registration
    /**
     * @Assert\NotBlank(groups={"flow_register_step6"})
     * @Assert\IsTrue(message = "Must Accept the terms" , groups={"flow_register_step6"})
     */
    protected $termsAccepted;

    /**
     * @MongoDB\Float
     * @MongoDB\NotSaved
     */
    protected $score;

    /**
     * @MongoDB\Float
     */
    protected $ratingScore;


    /**
     * @MongoDB\Integer
     */
    protected $commentCount;

    /**
     * @MongoDB\EmbedMany(targetDocument="Comment")
     */
    protected $comments;



    public function __construct()
    {
        $this->owners = [];
    }


    //initiations
    public function setCreated(){
        $this->regTime = (new \DateTime())->getTimestamp();
        $this->isActive = true ;
        $this->isVerified = false;
        $this->branches = array();
    }

    /**
     * @return mixed
     */
    public function getRatingScore()
    {
        return $this->ratingScore;
    }

    /**
     * @param mixed $ratingScore
     */
    public function setRatingScore($ratingScore)
    {
        $this->ratingScore = $ratingScore;
    }

    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * @param mixed $commentCount
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }



    //getters and setters


    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }


    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getBusinessType()
    {
        return $this->businessType;
    }

    /**
     * @param mixed $businessType
     */
    public function setBusinessType($businessType)
    {
        $this->businessType = $businessType;
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

    /**
     * @return mixed
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * @param mixed $owners
     */
    public function setOwners($owners)
    {
        $this->owners = $owners;
    }

    /**
     * @return mixed
     */
    public function getRegisteredCountry()
    {
        return $this->registeredCountry;
    }

    /**
     * @param mixed $registeredCountry
     */
    public function setRegisteredCountry($registeredCountry)
    {
        $this->registeredCountry = $registeredCountry;
    }

    /**
     * @return mixed
     */
    public function getContactNumbers()
    {
        return $this->contactNumbers;
    }

    /**
     * @param mixed $contactNumbers
     */
    public function setContactNumbers($contactNumbers)
    {
        $this->contactNumbers = $contactNumbers;
    }

    /**
     * @return string
     */
    public function getCompanyPage()
    {
        return $this->companyPage;
    }

    /**
     * @param string $companyPage
     */
    public function setCompanyPage($companyPage)
    {
        $this->companyPage = $companyPage;
    }



    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getIsVerified()
    {
        return $this->isVerified;
    }

    /**
     * @param mixed $isVerified
     */
    public function setIsVerified($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    /**
     * @return mixed
     */
    public function getRegTime()
    {
        return $this->regTime;
    }

    /**
     * @param mixed $regTime
     */
    public function setRegTime($regTime)
    {
        $this->regTime = $regTime;
    }

    /**
     * @return mixed
     */
    public function getBranches()
    {
        return $this->branches;
    }

    /**
     * @param mixed $branches
     */
    public function setBranches($branches)
    {
        $this->branches = $branches;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * @param mixed $brandName
     */
    public function setBrandName($brandName)
    {
        $this->brandName = $brandName;
    }

    /**
     * @return mixed
     */
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

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
     * @param mixed $termsAccepted
     */
    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = $termsAccepted;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getProfileUrl()
    {
        return $this->profileUrl;
    }

    /**
     * @param mixed $profileUrl
     */
    public function setProfileUrl($profileUrl)
    {
        $this->profileUrl = $profileUrl;
    }

    public function addOwner($owner){
        $this->owners[]=$owner;
    }

    public function removeOwner($owner){

        if(($key = array_search($owner, $this->owners)) !== false) {
            unset($this->owners[$key]);
        }

    }

    public function fromArray($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

}
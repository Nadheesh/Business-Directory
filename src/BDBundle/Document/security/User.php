<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/14/2016
 * Time: 10:54 AM
 */

namespace BDBundle\Document\security;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(collection="User")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField("type")
 * @MongoDB\DiscriminatorMap({"registeredUser"="RegisteredUser", "admin"="Admin" , "businessUser"="BusinessUser"})
 * @MongoDBUnique(fields="email")
 * @MongoDBUnique(fields="username")
 */
class User implements UserInterface, \Serializable
{

    /**
     * @MongoDB\Id(strategy="NONE")
     * @var string
     * @Assert\NotBlank()
     */
    protected $username ;

    /**
     * @MongoDB\String
     */
    protected $password ;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     */
    protected $firstName ;


    /**
     * @MongoDB\String
     */
    protected $lastName ;

    /**
     * @MongoDB\String
     */
    protected $imgUrl ;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = false
     * )
     */
    protected $email ;

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


    public function setCreated(){
        $this->regTime = (new \DateTime())->getTimestamp();
        $this->isActive = true ;
        $this->isVerified = false;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setId($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param mixed $imgUrl
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->username,
            $this->password,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->username,
            $this->username,
            $this->password,

            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
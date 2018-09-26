<?php

namespace AppBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="mobile_number", type="string", length=32)
     *
     * @Assert\NotBlank(message="mobile number can not be blank")
     */
    protected $mobileNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_country", type="string", length=4)
     *
     * @Assert\NotBlank(message="mobile country can not be blank")
     */
    protected $mobileCountry;


    /**
     * Set mobileNumber
     *
     * @param string $mobileNumber
     *
     * @return User
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * Set mobileCountry
     *
     * @param string $mobileCountry
     *
     * @return User
     */
    public function setMobileCountry($mobileCountry)
    {
        $this->mobileCountry = $mobileCountry;

        return $this;
    }

    /**
     * Get mobileCountry
     *
     * @return string
     */
    public function getMobileCountry()
    {
        return $this->mobileCountry;
    }

}


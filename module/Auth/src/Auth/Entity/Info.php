<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

namespace Auth\Entity;

use Core\Entity\AbstractEntity;
use Core\Entity\EntityInterface;
use Core\Entity\FileInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * personal information of a user.
 * 
 * @ODM\EmbeddedDocument
 */
class Info extends AbstractEntity implements InfoInterface
{   
	
	/** @var string 
	 * @ODM\String */
	protected $birthDay;
	
	/** @var string 
	 * @ODM\String */
	protected $birthMonth;

	/** @var string 
	 * @ODM\String */
	protected $birthYear;
	
    /** @var string 
     * @ODM\String */
    protected $email;

    /**
     * @var boolean
     * @ODM\Boolean
     */
    protected $emailVerified;
    
    /** @var string 
     * @ODM\String */ 
    protected $firstName;
    
    /** @var string 
     * @ODM\String */
    protected $gender;
    
    /** @var string 
     * @ODM\String */
    protected $houseNumber;
    
    /** @var string
     * @ODM\String */
    protected $lastName;
    
    /** @var string 
     * @ODM\String */
    protected $phone;
    
    /** @var string 
     * @ODM\String */
    protected $postalCode;

    /** @var string 
     * @ODM\String */
    protected $city;
    
    /**
     * the photo of an users profile
     *
     * @var FileInterface
     * @ODM\ReferenceOne(targetDocument="UserImage", simple=true, nullable=true, cascade={"all"})
     */
    protected $image;
    
    /** @var string 
     * @ODM\String */
    protected $street;    
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setBirthDay($birthDay)
    {
    	$this->birthDay=$birthDay;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getBirthDay()
    {
    	return $this->street;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setBirthMonth($birthMonth)
    {
    	$this->birthDay=$birthMonth;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getBirthMonth()
    {
    	return $this->birthMonth;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setBirthYear($birthYear)
    {
    	$this->birthYear=$birthYear;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getBirthYear()
    {
    	return $this->birthYear;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\Info
     */
    public function setEmail($email)
    {
    	$this->email = trim((String)$email);
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getEmail()
    {
    	return $this->email;
    }

    /** {@inheritdoc} */
    public function isEmailVerified()
    {
        return $this->emailVerified;
    }

    /** {@inheritdoc} */
    public function setEmailVerified($emailVerified)
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setFirstName($firstName)
    {
    	$this->firstName = trim((String)$firstName);
    	return $this;
    }
    
    
    /** {@inheritdoc} */
    public function getGender()
    {
    	return $this->gender;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setGender($gender)
    {
    	$this->gender = trim((String)$gender);
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getFirstName()
    {
    	return $this->firstName;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setHouseNumber($houseNumber)
    {
    	$this->houseNumber=$houseNumber;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getHouseNumber()
    {
    	return $this->houseNumber;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setLastName($name)
    {
        $this->lastName = trim((String) $name);
        return $this;
    }
    
    /** {@inheritdoc} */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function getDisplayName()
    {
        if (!$this->lastName) {
            return $this->email;
        }
        return ($this->firstName ? $this->firstName . ' ' : '') . $this->lastName;
    }
    
    public function getAddress($extended = false)
    {
        $address = array();
        if ($this->lastName) {
            $address[] = ("male" == $this->gender ? 'Herr' : 'Frau') . ' '
                      . ($this->firstName ? $this->firstName . ' ' : '') 
                      . $this->lastName;
        }
        if ($this->street) {
            $address[] = $this->street . ($this->houseNumber ? ' ' . $this->houseNumber : '');
        }
        if ($this->city) {
            $address[] = ($this->postalCode ? $this->postalCode . ' ' : '') . $this->city;
        }
        
        if ($extended) {
            $address[] = ''; // empty line
        
            if ($this->phone) {
                $address[] = $this->phone;
            }
            if ($this->email) {
                $address[] = $this->email;
            }
        }    
        
        return implode(PHP_EOL, $address);
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setPhone($phone) {
    	$this->phone = (String) $phone;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getPhone() {
    	return $this->phone;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setPostalCode($postalCode) {
    	$this->postalCode = (String) $postalCode;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getPostalCode() {
    	return $this->postalCode;
    }
    
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setCity($city) {
    	$this->city = (String) $city;
    	return $this;
    }
    
    /** {@inheritdoc} */
    public function getCity() {
    	return $this->city;
    }
    
    public function setImage(EntityInterface $image = null)
    {
        $this->image = $image;
        return $this;
    }
    
    public function getImage()
    {
        return $this->image;
    }
    /**
     * {@inheritdoc}
     * @return \Auth\Entity\User
     */
    public function setStreet($street)
    {
    	$this->street=$street;
    	return $this;
    }

    /** {@inheritdoc} */
    public function getStreet() 
    {
    	return $this->street;
    }
    
    /**
     * convert an array into an Info Object
     * @param Array $array
     * @return \Auth\Entity\Info
     */
    public function fromArray($array) 
    {
        $this->birthDay=$array['birthDay'];
        $this->birthMonth=$array['birthMonth'];
        $this->birthYear=$array['birthYear'];
        $this->firstName=$array['firstName'];
        $this->lastName=$array['lastName'];
        $this->email=$array['email'];
        $this->emailVerified = isset($array['emailVerified']) ? $array['emailVerified'] : null;
        $this->gender=$array['gender']; 
        $this->street=$array['street'];
        $this->houseNumber=$array['houseNumber'];
        $this->phone=$array['phone'];
        $this->postalCode=$array['postalcode'];
        $this->city=$array['city'];        
        return($this);   
    }
    
    /**
     * convert an Info object into an Array
     * @param Info $info
     * @return Array
     */
    static function toArray(Info $info) 
    {
        $array['birthDay']=$info->birthDay;
        $array['birthMonth']=$info->birthMonth;
        $array['birthYear']=$info->birthYear;
        $array['firstName']=$info->firstName;
        $array['lastName']=$info->lastName;
        $array['email']=$info->email;
        $array['emailVerified'] = $info->emailVerified;
        $array['gender']=$info->gender;
        $array['street']=$info->street;
        $array['houseNumber']=$info->houseNumber;
        $array['phone']=$info->phone;
        $array['postalcode']=$info->postalCode;
        $array['city']=$info->city;
        return $array;
    }
    
}
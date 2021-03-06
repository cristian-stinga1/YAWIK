<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** Auth model */
namespace Auth\Entity;

use Core\Entity\EntityInterface;

/**
 * Defines an users Info model interface. The Info model holds contact
 * data. 
 */
interface InfoInterface extends EntityInterface
{
    
	/**
	 * Sets the Day of the date of birth.
	 *
	 * @param string $birthDay
	 */
	public function setBirthDay($birthDay);
	
	/**
	 * Gets the Day of the date of birth
	 *
	 * @return string
	*/
	public function getBirthDay();
	
	/**
	 * Sets the month of the date of birth.
	 *
	 * @param string $birthMonth
	 */
	public function setBirthMonth($birthMonth);
	
	/**
	 * Gets the month of the date of birth
	 *
	 * @return string
	*/
	public function getBirthMonth();

	/**
	 * Sets the year of the date of birth.
	 *
	 * @param string $email
	 */
	public function setBirthYear($email);
	
	/**
	 * Gets the Year of the date of birth.
	 *
	 * @return string
	*/
	public function getBirthYear();
	
    /**
     * Sets the email.
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Gets the email
     * 
     * @return string
     */
    public function getEmail();

    /**
     * @return boolean
     */
    public function isEmailVerified();

    /**
     * @param bool $emailVerified
     * @return self
     */
    public function setEmailVerified($emailVerified);
    
    /**
     * Sets the first name
     * 
     * @param string $name
     */
    public function setFirstName($name);
    
    /**
     * Gets the first name
     *
     * @return string
     */
    public function getFirstName();
    
    /**
     * Sets the gender
     *
     * @param string $gender
     */
    public function setGender($gender);
    
    /**
     * Gets the gender
     *
     * @return string
    */
    public function getGender();
    
    
    /**
     * Sets the last name
     *
     * @param string $name
     */
    public function setLastName($name);
    
    /**
     * Gets the last name
     *
     * @return string
     */
    public function getLastName();
    
    /**
     * Sets the profile Image of an user
     * 
     * @param EntityInterface $image
     */
    public function setImage(EntityInterface $image=null);
    
    /**
     * Gets the profile Image of an user
     */
    public function getImage();
    
    /**
     * Sets the users street
     *
     * @param string $name
     */
    public function setStreet($name);
    
    /**
     * Gets the users street
     *
     * @return string
    */
    public function getStreet();
    
    /**
     * Sets the users house number
     *
     * @param string $houseNumber
     */
    public function setHouseNumber($houseNumber);
    
    /**
     * Gets the users house number
     *
     * @@return string
     */
    public function getHouseNumber();

    /**
     * Gets the user display name
     *
     * @return string
     */
    public function getDisplayName();
}  
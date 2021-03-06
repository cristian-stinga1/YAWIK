<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright 2013-2014 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Core\Form;

/**
 * Allows implementing classes to disable itself and its elements.
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de> 
 */
interface DisableElementsCapableInterface extends DisableCapableInterface
{

    /**
     * Sets if this element is capable of disabling its children.
     *
     * @param boolean $flag
     *
     * @return self
     */
    public function setIsDisableElementsCapable($flag);

    /**
     * Gets if this element is capable of disabling its children.
     *
     * @return boolean
     */
    public function isDisableElementsCapable();

    /**
     * Disables elements.
     *
     * To disable elements pass the element names as array entries.
     * To disable elements inside a fieldset/form, pass the fieldset/form name as key and the
     * element names in an array.
     * This can be done recursively.
     *
     * @example
     *      <code>
     *          $map = array(
     *              'element', 'element2',
     *              'fieldset' => array('element'),
     *              'form' => array('fieldset' => array('element'),
     *          );
     *      </code>
     *
     * @param array $map
     *
     * @return self
     */
    public function disableElements(array $map);
}
<?php

namespace Jobs\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the job opening search formular fields
 *
 * @package Jobs\Form
 */
class ListFilterFieldsetExtendedFactory implements FactoryInterface
{
    
    /* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
    */
    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new ListFilterFieldset(true);
        return $fieldset;
    }

}
<?php

namespace Cv\Entity;

use Core\Entity\AbstractEntity;

class Employment extends AbstractEntity
{
    protected $startDate;
    protected $endDate;
    protected $currentIndicator;
    protected $description;
    
    public function setStartDate($startDate)
    {
        $this->startDate = (string) $startDate;
        return $this;
    }
    
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }
    
    public function getCurrentIndicator()
    {
    	return $this->currentIndicator;
    }
    
    public function setCurrentIndicator($currentIndicator)
    {
    	$this->currentIndicator = $currentIndicator;
    	return $this;
    }
     
    
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    public function setDescription($value)
    {
    	$this->description = $value;
    	return $this;
    }
    
    public function getDescription()
    {
    	return $this->description;
    }
}
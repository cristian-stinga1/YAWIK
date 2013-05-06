<?php

namespace Applications\Model;

use Core\Model\AbstractModel;

class Education extends AbstractModel
{
    protected $startDate;
    protected $endDate;
    protected $competencyName;
    protected $description;
    protected $nationalClassification;
    
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
    
    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setCompetencyName($competencyName)
    {
    	$this->competencyName = $competencyName;
    	return $this;
    }
    
    public function getCompetencyName()
    {
    	return $this->competencyName;
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
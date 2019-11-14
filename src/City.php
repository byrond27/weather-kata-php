<?php

namespace Codium\CleanCode;

class City {
  
    private $name;
    private $id;
    private $predictions;

    function __construct($name,$colaborador){
        $this->setName($name);
        $this->setId($colaborador->getWoeid($name));
        $this->setPredictions($colaborador->getPrediction($this->getId()));
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setPredictions($predictions){
        $this->predictions = $predictions;
    }

    public function getName(){
        return $this->name;
    }

    public function getId(){
        return $this->id;
    }

    public function getPredictions(){
        return $this->predictions;
    }

}
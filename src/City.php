<?php

namespace Codium\CleanCode;

class City {
  
    public $name;
    public $id;
    public $prediction;

    function __construct($name,$colaborador){
        $this->name = $name;   
        $this->id = $colaborador->getWoeid($name);
        $this->prediction = $colaborador->getPrediction($this->id);
    }

}
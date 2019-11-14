<?php
namespace Codium\CleanCode;

interface WeatherInterface {
    public function getWoeid($city);
    public function getPrediction($woeid);
}